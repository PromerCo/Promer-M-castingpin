<?php
namespace mcastingpin\modules\v1\controllers;
use mcastingpin\modules\v1\models\CastinpinUser;
use mcastingpin\modules\v1\services\ParamsValidateService;
use mhubkol\common\helps\HttpCode;
use mhubkol\modules\v1\models\HubkolUser;

use mhubkol\modules\v1\services\UserTokenService;
use wxphone\WXBizDataCrypt;
use yii\web\RangeNotSatisfiableHttpException;

/**
 * Site controller
 */
class UserController extends BaseController
{
    public $modelClass = 'mcastingpin\models\CastingpinUser';
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
    public function actionIndex(){
        echo "用户的ID为：".$this->uid;
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
     * 微信授权：将用户基本信息存档
     */
    public function actionAuthorize(){
        if ((\Yii::$app->request->isPost)) {
            $data  = \Yii::$app->request->post();
            $user_id = $this->uid;
            $pvs = new ParamsValidateService();
            $valid = $pvs->validate($data, [
                [['nick_name', 'avatar_url'], 'required']
            ]);
            if (!$valid) {
                return  HttpCode::renderJSON([],$pvs->getErrorSummary(true),'416');
            }
            $wechat_user = new CastinpinUser();
            try {
                $transaction = \Yii::$app->db->beginTransaction();
                $wechat_user->updateAll($data,['id'=>$user_id]);
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

    public function actionRole(){
        $uid = $this->uid;
        $types =  HubkolUser::find()->where(['id'=>$uid])->select('capacity')->asArray()->one();


        return  HttpCode::renderJSON( $types['capacity'],'ok','201');
    }








}
