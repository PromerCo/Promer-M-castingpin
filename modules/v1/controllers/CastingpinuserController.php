<?php
namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinCarefor;
use mcastingpin\modules\v1\models\CastingpinEnshrine;
use mcastingpin\modules\v1\models\CastingpinUser;
use mcastingpin\modules\v1\services\CastingpinUserService;
use mcastingpin\modules\v1\services\ParamsValidateService;
use mcastingpin\modules\v1\services\UserTokenService;
use wxphone\WXBizDataCrypt;
use yii\web\RangeNotSatisfiableHttpException;

/**
 * CastingpinUserController implements the CRUD actions for CastingpinUser model.
 */
class CastingpinuserController extends BaseController
{

    public  $enableCsrfValidation=false;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }



    /*
     * 微信授权：将用户基本信息存档
     */
    public function actionAuthorize(){

        if ((\Yii::$app->request->isPost)) {
            $data  = \Yii::$app->request->post();
            $openId = $this->openId;
            $pvs = new ParamsValidateService();
            $valid = $pvs->validate($data, [
                [['nick_name', 'avatar_url'], 'required']
            ]);
            if (!$valid) {
                return  HttpCode::renderJSON([],$pvs->getErrorSummary(true),'416');
            }
            $wechat_user = new CastingpinUser();
            try {
                $transaction = \Yii::$app->db->beginTransaction();
                $wechat_user->updateAll($data,['open_id'=>$openId]);
                if (!$wechat_user){
                    return  HttpCode::renderJSON([],'update failed','412');
                }else{
                    $transaction->commit();
                    return  HttpCode::renderJSON([],'ok','201');
                }
            }catch (\Exception $e) {
                return  HttpCode::renderJSON([],$e->getMessage(),'412');
            }
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }

    /*
     * 获取我的页面数据
    */
    public function actionMiexhibit(){
        $openId =  $this->openId; //获取用户ID
        $types =  CastingpinUser::find()->where(['open_id'=>$openId])->select('capacity')->asArray()->one(); //查询类型(状态)
        if (!$types['capacity']){
            return   HttpCode::renderJSON([],'ok','204');
        }else{
            return   HttpCode::renderJSON(CastingpinUserService::Blocked($types['capacity'],$openId),'ok','201'); //返回对应角色数据
        }

    }
    /*
     * 获取用户-手机号
     */
    public function actionPhone(){
        if ((\Yii::$app->request->isPost)) {
            $iv =    \Yii::$app->request->post('iv');
            $encryptedData = urldecode(\Yii::$app->request->post('encryptedData'));
            $code =  \Yii::$app->request->post('code');
            $app_id = \Yii::$app->params['app_id'];
            if (empty($iv) || empty($encryptedData) || empty($code) || empty($app_id) ){
                throw new RangeNotSatisfiableHttpException('缺少参数');
            }
            $wx = new UserTokenService($code);

            $session_key = $wx->getSessionKey();
            $pc =  new WXBizDataCrypt($app_id,$session_key);
            $errCode = $pc->decryptData($encryptedData,
                $iv, $data );
            if ($errCode == 0){
                return  HttpCode::renderJSON([],$data,'201');
            }
            return  HttpCode::renderJSON([],$errCode,'418');

        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }
    /*
     * 切换角色
     */
    public function actionCutrole(){
        if ((\Yii::$app->request->isPost)) {

            $type = \Yii::$app->request->post('type');
            if (empty($type)){
                return  HttpCode::renderJSON([],'参数不存在','412');
            }
            try {
            $transaction = \Yii::$app->db->beginTransaction(); //开启事务
            $is_success =  CastingpinUser::updateAll(['capacity'=>$type,'update_time'=>date('Y-m-d H:i:s',time())],['open_id'=>$this->openId]);
                if ($is_success){
                    $transaction->commit();
                    return   HttpCode::renderJSON(CastingpinUserService::Blocked($type,$this->openId),'ok','201') ; //返回对应角色数据
                }else{
                    return  HttpCode::renderJSON([],'更新失败','416');
                }
            }catch (\Exception $e) {
                return  HttpCode::renderJSON([],$e->getMessage(),'412');
            }
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }

    /*
     * 切换身份（更新）
    */
    public function actionIdentity(){
        if ((\Yii::$app->request->isPost)) {
            $type = \Yii::$app->request->post('type');
            if (empty($type)){
                return  HttpCode::renderJSON([],'参数不存在','412');
            }
            try {
                $transaction = \Yii::$app->db->beginTransaction(); //开启事务
                $is_success =  CastingpinUser::updateAll(['capacity'=>$type,'update_time'=>date('Y-m-d H:i:s',time())],['open_id'=>$this->openId]);
                if ($is_success){
                    $transaction->commit();
                    return   HttpCode::renderJSON([],'ok','201') ; //返回对应角色数据
                }else{
                    return  HttpCode::renderJSON([],'更新失败','416');
                }
            }catch (\Exception $e) {
                return  HttpCode::renderJSON([],$e->getMessage(),'412');
            }
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }

    /*
     * 收藏列表
     */
    public function actionEnshrine(){
        if ((\Yii::$app->request->isPost)) {
            //获取角色状态
            $uid = $this->uid;
            $capacity = CastingpinUser::find()->where(['open_id' => $this->openId])->select(['capacity'])->one();
            if ($capacity['capacity'] == 1){
            //我收藏的艺人
            $data = CastingpinEnshrine::findBySql("SELECT id,sex,wechat,phone,occupation,invite,university,stage_name,city,cover_img FROM castingpin_actor WHERE
            open_id IN(SELECT castingpin_user.open_id FROM castingpin_enshrine LEFT JOIN castingpin_user ON castingpin_enshrine.away_id = castingpin_user.id
            WHERE castingpin_enshrine.collect_id = $uid AND castingpin_enshrine.status = 1 and castingpin_user.id <> $uid
            )")->asArray()->all();
            $data['capacity'] = 1;
            return  HttpCode::renderJSON($data,'ok','201');
            }elseif ($capacity['capacity'] == 2){
            //我关注的统筹
            $data = CastingpinArranger::findBySql("
			SELECT  castingpin_arranger.wechat,castingpin_arranger.phone,castingpin_arranger.id,
			castingpin_arranger.corporation,castingpin_arranger.city,castingpin_arranger.industry,
			castingpin_user.avatar_url,castingpin_carefor.create_date 
			FROM  castingpin_carefor  
			LEFT JOIN  castingpin_user  ON  castingpin_user.id = castingpin_carefor.arranger_id
			LEFT JOIN  castingpin_arranger on castingpin_arranger.open_id = castingpin_user.open_id
			WHERE   castingpin_carefor.actor_id = $uid  AND  castingpin_carefor. `status` = 1 
			AND   castingpin_user.id <> $uid
             ")->asArray()->all();
                $data['capacity'] = 2;
            return  HttpCode::renderJSON($data,'ok','201');
            }else{
                return  HttpCode::renderJSON([],'ok','204');
            }

        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }





}
