<?php

namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinCarefor;
use mcastingpin\modules\v1\models\CastingpinCast;
use mcastingpin\modules\v1\models\CastingpinNotice;
use mcastingpin\modules\v1\models\CastingpinUser;

/**
 * CastingpinCastController implements the CRUD actions for CastingpinCast model.
 */
class CastingpincastController extends BaseController
{
    public  $enableCsrfValidation=false;
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
    * 发布活动(广告组 HUB) - 发布活动  -可能存在问题- 重复点击 插入两条一样活动活动
    */
    public function actionPush(){
        if ((\Yii::$app->request->isPost)) {
            $open_id = $this->openId;
            $data        = \Yii::$app->request->post('data');
            $transaction = \Yii::$app->db->beginTransaction();
            $notice      = new CastingpinCast();
            $arranger_id = CastingpinArranger::find()->where(['open_id'=>$this->openId])->select('id')->asArray()->one();  //外加一个状态 标识切换账号
            if (empty($arranger_id) || !$arranger_id){
                return  HttpCode::renderJSON([],'请先完善统筹资料','415');
            }else{
                $data['arranger_id'] = $arranger_id['id'];
                $data['open_id'] =     $open_id;
            }
            $notice->setAttributes($data,false);
            if (!$notice->save()){
                $err_msg = [];
                foreach ($notice->errors as $key =>$val){
                    array_push($err_msg,$val);
                }
                return  HttpCode::renderJSON([],$err_msg,'412');
            }else{
                $transaction->commit();
                $info['arranger_id']   = $notice->id;
                return  HttpCode::renderJSON($info,'ok','201');
            }
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }
  /*
   * 剧组列表
   */
    public function actionCast(){
        if ((\Yii::$app->request->isPost)) {
            $cast_list = CastingpinCast::findBySql('select castingpin_cast.id,castingpin_cast.script,castingpin_cast.type,castingpin_cast.theme,castingpin_cast.city,castingpin_user.avatar_url from castingpin_cast LEFT JOIN castingpin_user ON castingpin_cast.open_id = castingpin_user.
open_id  where castingpin_user.open_id = "'.$this->openId.'" ')->asArray()->all();
            return  HttpCode::renderJSON($cast_list,'ok','201');
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }

    /*
     *  通告列表(剧组对应通告)
     */
    public function actionAnnounce(){
        if ((\Yii::$app->request->isPost)) {
            $cast_id = \Yii::$app->request->post('cast_id');
            $cast_list = CastingpinNotice::find()->where(['cast_id'=>$cast_id])->select(['title','style','speciality','id'])->asArray()->all();
            return  HttpCode::renderJSON($cast_list,'ok','201');
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }

    /*
     * 查看是否填写剧组资料
     */
    public function actionCastms(){
        if ((\Yii::$app->request->isPost)) {
            $open_id = $this->openId;
            $data =  CastingpinCast::find()->where(['open_id'=>$open_id])->select(['script','id'])->asArray()->all();
            if ($data){
                return  HttpCode::renderJSON($data,'ok','201');
            }else{
                return  HttpCode::renderJSON([],'ok','204');
            }

        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }

    }

    /*
    * 详情
   */
    public function actionDetails(){
        //剧组ID
        $cast_id    = \Yii::$app->request->post('cast_id');
        //统筹ID
        $arranger_id = \Yii::$app->request->post('arranger_id');
        if (empty($arranger_id) || empty($cast_id)){
            return  HttpCode::renderJSON([],'参数不能为空','419');
        }
        //剧组列表
        $cast_list = CastingpinCast::find()->where(['id'=>$cast_id])->select(['script','city','profile','cover_img','team','debut_time','id','browse','arranger_id'])->asArray()->one();//
        //通告列表
        $cast_list['notice'] = CastingpinNotice::find()->where(['cast_id'=>$cast_list['id']])->select(['title','id','cast_id','occupation','age','convene','bystander_number','shoot_time'])->asArray()->all();
        //浏览量
       foreach ($cast_list['notice'] as $key => $value){
           $cast_list['notice'][$key]['shoot_time'] =  date("Y/m/d",strtotime($value['shoot_time']));
       }
       //其它组讯
        $cast_list['cast_list'] = CastingpinCast::findBySql("SELECT cover_img,script FROM castingpin_cast WHERE arranger_id = $arranger_id AND  id != $cast_id")->asArray()->all();
        $transaction = \Yii::$app->db->beginTransaction();
        // 1.我是否关注过   2. 关注他的总人数
        $uid = $this->uid;
        $user_ids =  CastingpinUser::findBySql("SELECT castingpin_user.id FROM castingpin_user
LEFT JOIN castingpin_arranger ON  castingpin_arranger.open_id = castingpin_user.open_id
WHERE castingpin_arranger.id = $arranger_id")->asArray()->one();
        //查看是否关注
        $cast_list['follow_status'] =  CastingpinCarefor::find()->where(['actor_id'=>$uid,'arranger_id'=>$user_ids['id'],'status'=>'1'])->count();
        $cast_list['follow_counts'] =  CastingpinCarefor::find()->where(['arranger_id'=>$user_ids['id'],'status'=>'1'])->count();
        //查看当前剧组浏览量
        $follow_number = $cast_list['browse']; //浏览量
        CastingpinCast::updateAll(['browse'=>$follow_number+1,'update_time'=>date('Y-m-d H:i:s',time())],['id'=>$cast_id]);
        $transaction->commit();
        $cast_list['browse'] = $cast_list['browse']+1;
        return  HttpCode::renderJSON($cast_list,'ok','201');
    }
    /*
    * 详情
   */
    public function actionFollow(){
        if ((\Yii::$app->request->isPost)) {
            $arranger_id    = \Yii::$app->request->post('arranger_id');
            $follow_status  =\Yii::$app->request->post('follow_status');
            $uid = $this->uid;
            if (empty($arranger_id) || empty($follow_status)){
                return  HttpCode::renderJSON([],'参数不能为空','419');
            }
            $user_ids =  CastingpinUser::findBySql("SELECT castingpin_user.id FROM castingpin_user
LEFT JOIN castingpin_arranger ON  castingpin_arranger.open_id = castingpin_user.open_id
WHERE castingpin_arranger.id = $arranger_id")->asArray()->one();
            //1.查看用户是否关注过
           $is_follow =   CastingpinCarefor::find()->where(['actor_id'=>$uid,'arranger_id'=>$user_ids['id']])->count();
            $transaction = \Yii::$app->db->beginTransaction();
           if (!$is_follow){
               $is_creat =   \Yii::$app->db->createCommand()->insert('castingpin_carefor', [
                   'status' => $follow_status,
                   'arranger_id' => $user_ids['id'],
                   'actor_id'=>$this->uid
               ])->execute();
               if (!$is_creat){
                   return  HttpCode::renderJSON([],'关注失败','416');
               }
           }else{
              $is_success =  CastingpinCarefor::updateAll([
                   'status'=>$follow_status,'update_time'=>date('Y-m-d H:i:s',time())
               ],['arranger_id'=>$user_ids['id'],'actor_id'=>$this->uid]);
               $transaction->commit();
               if (!$is_success){
                   return  HttpCode::renderJSON($follow_status,'关注失败','416');
               }
               return  HttpCode::renderJSON($follow_status,'ok','201');
           }



        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }

    }



}
