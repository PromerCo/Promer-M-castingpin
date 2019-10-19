<?php
namespace mcastingpin\modules\v1\controllers;
use mcastingpin\common\helps\Common;
use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinActor;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinNotice;
use mcastingpin\modules\v1\models\CastingpinPull;

/**
 * CastingpinUserController implements the CRUD actions for CastingpinUser model.
 */
class CastingpinhomeController extends BaseController
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
     * 首页列表
     */
    public function actionHome(){
         $open_id  =  $this->openId;
         $arranger =  CastingpinArranger::find()->where(['open_id'=>$open_id])->select(['id'])->asArray()->one();
         if (empty($arranger['id'])){
             return  HttpCode::renderJSON([],'参数不能为空','416');
         }else{
          $data = CastingpinNotice::findBySql("SELECT castingpin_user.avatar_url,castingpin_notice.arranger_id,castingpin_notice.id,castingpin_notice.cast_id,castingpin_notice.title,
castingpin_notice.occupation,castingpin_notice.age,castingpin_notice.speciality,castingpin_notice.convene,castingpin_notice.create_time
FROM castingpin_notice 
LEFT JOIN castingpin_arranger ON castingpin_notice.arranger_id = castingpin_arranger.id
LEFT JOIN castingpin_user  ON castingpin_user.open_id = castingpin_arranger.open_id")->asArray()->all();
             foreach ($data as $key=>$value){
                 $data[$key]['create_time'] = Common::time_tranx($value['create_time'],1);
             }
          return  HttpCode::renderJSON($data,'ok','201');
         }
    }

    /*
     * 详情
    */
    public function actionDetails(){
        $notice_id = \Yii::$app->request->post('notice_id');
        $data = CastingpinNotice::findBySql("SELECT  castingpin_pull.is_enroll,castingpin_pull.is_collect,castingpin_user.avatar_url,castingpin_user.nick_name,castingpin_arranger.position,castingpin_notice.arranger_id,castingpin_notice.id,castingpin_notice.cast_id,castingpin_notice.title,
castingpin_notice.occupation,castingpin_notice.age,castingpin_notice.speciality,castingpin_notice.convene,castingpin_notice.profile,castingpin_notice.enroll,castingpin_notice.enroll_number,castingpin_notice.bystander_number,castingpin_notice.create_time
FROM castingpin_notice 
LEFT JOIN castingpin_arranger ON castingpin_notice.arranger_id = castingpin_arranger.id
LEFT JOIN castingpin_user  ON castingpin_user.open_id = castingpin_arranger.open_id
LEFT JOIN castingpin_pull  ON castingpin_pull.notice_id = castingpin_notice.id
where  castingpin_notice.id = $notice_id")->asArray()->one();
        $data['create_time'] = Common::time_tranx($data['create_time'],1);
        return  HttpCode::renderJSON($data,'ok','201');
    }
    /*
     * 收藏
     */
    public function actionCollect(){
        if ((\Yii::$app->request->isPost)) {
            $open_id = $this->openId;
            $collect = \Yii::$app->request->post('collect');
            $notice_id = \Yii::$app->request->post('notice_id');
            $actor_id = CastingpinActor::find()->where(['open_id' => $open_id])->select(['id'])->asArray()->one();
            if (empty($actor_id['id'])) {
                return HttpCode::jsonObj([], '资料不全', '416');
            }
            $transaction = \Yii::$app->db->beginTransaction();
            /*
             * 更新收藏
             */
            $is_update = CastingpinPull::updateAll(['is_collect' => $collect, 'update_time' => date('Y-m-d H:i:s', time())], [
                'actor_id' => $notice_id,
                'notice_id'=>$actor_id['id']
            ]);
            if ($is_update){
                $transaction->commit();
                return  HttpCode::jsonObj($collect,'OK','201');
            }else{
                return  HttpCode::jsonObj([],'error','416');
            }
        }else{
            return  HttpCode::jsonObj([],'请求方式出错','418');
        }
    }





}
