<?php

namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\components\RedisLock;
use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinActor;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinCast;
use mcastingpin\modules\v1\models\CastingpinNotice;
use mcastingpin\modules\v1\models\CastingpinPull;
use mcastingpin\modules\v1\models\CastingpinUser;

/**
 * CastingpinNoticeController implements the CRUD actions for CastingpinNotice model.
 */
class CastingpinnoticeController extends BaseController
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
            $data  = \Yii::$app->request->post('data');
            $transaction = \Yii::$app->db->beginTransaction();
            $notice =   new CastingpinNotice();
            $arranger_id =  CastingpinArranger::find()->where(['open_id'=>$this->openId])->select('id')->asArray()->one();  //外加一个状态 标识切换账号
            if (empty($arranger_id) || !$arranger_id){
                return  HttpCode::renderJSON([],'请先完善统筹资料','415');
            }else{
            $cast =     CastingpinCast::find()->where(['arranger_id'=>$arranger_id['id'],'open_id'=>$this->openId])->select('id')->asArray()->one();
            if (empty($cast) || !$cast){
                return  HttpCode::renderJSON([],'请先完善剧组资料','415');
            }
            $data['arranger_id'] = $arranger_id['id'];
            $data['cast_id'] = $cast['id'];
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
                $info['cast_id']   = $notice->id;
                return  HttpCode::renderJSON($info,'ok','201');
            }
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }


    /*
  * 我报名(发布)的栏目
  */
    public function actionLame(){
        $open_id =   $this->openId;   //获取用户ID
        //查看用户角色
        $capacity =   CastingpinUser::find()->where(['open_id'=>$open_id])->select(['capacity'])->asArray()->one();
        switch ($capacity['capacity']){
            case 1:
                $arranger_id =  CastingpinArranger::find()->where(['open_id'=>$this->openId])->select('id')->asArray()->one();  //外加一个状态 标识切换账号
                if (empty($arranger_id) || !$arranger_id){
                    return  HttpCode::renderJSON([],'请先完善统筹资料','415');
                }
                $data =  CastingpinNotice::find()->where(['arranger_id'=>$arranger_id])->orderBy('create_time desc')->asArray()->all();
                return  HttpCode::renderJSON($data,'ok','201');
                break;
            case 2:
                $data = [];
                return  HttpCode::renderJSON($data,'ok','201');
                break;
        }
    }

    /*
     * 参与报名
    */
    public function actionEnroll(){
        if ((\Yii::$app->request->isPost)) {
            $notice_id  = \Yii::$app->request->post('notice_id');

            $transaction = \Yii::$app->db->beginTransaction();
            if (empty($notice_id)){
                return  HttpCode::renderJSON([],'参数不能为空','406');
            }
            $key = 'mylock';//加锁
            $is_lock = RedisLock::lock($key);
            if ($is_lock){
                try {
                    // 入伍人数  入伍人  召集人数
                    $data = CastingpinNotice::find()->where(['id'=>$notice_id])->select(['enroll','convene','enroll_number'])->asArray()->one();
                    $enroll =$data['enroll']; //入伍人
                    $enroll_number =$data['enroll_number']; //入伍人数
                    $convene =$data['convene']; //召集人数
                    //查看用户是否填写资料
                    $means =    CastingpinActor::find()->where(['open_id'=>$this->openId])->select(['id','wechat'])->asArray()->one();

                    if (!$means){
                        return  HttpCode::renderJSON([],'请先填写资料','417');
                    }

                    //假如用户填写资料
                    $is_pull =   CastingpinPull::find()->where(['notice_id'=>$notice_id,'actor_id'=>$means['id']])->asArray()->count(); //接单

                    $material =  CastingpinUser::find()->where(['open_id'=>$this->openId])->select(['capacity'])->asArray()->one();  //身份标识（0 未填写资料 1 HUB 2KOL
                    if ($material['capacity'] != 2){
                        return  HttpCode::renderJSON([],'您不是KOL身份','417');
                    }

                    if (!$is_pull){
                        \Yii::$app->db->createCommand()->insert('castingpin_pull', [
                        'bystander_frequency' => '1',
                        'actor_id' => $means['id'], 'notice_id'=>$notice_id
                        ])->execute();
                    }
                    //报名人数是否达到
                    if ($enroll_number > $convene ){
                        RedisLock::unlock($key);  //清空KEY
                        return  HttpCode::renderJSON([],'报名人数已达到','200');
                    }
                    //用户是否报名
                    $enrolls =     CastingpinPull::findBySql("SELECT castingpin_pull.is_enroll,castingpin_pull.id as pull_id FROM castingpin_notice
LEFT JOIN castingpin_pull ON castingpin_notice.id = castingpin_pull.notice_id
LEFT JOIN castingpin_actor ON   castingpin_actor.id = castingpin_pull.actor_id
WHERE  castingpin_pull.id = $notice_id AND   castingpin_actor.open_id=$this->openId")->asArray()->one();

                    if ($enrolls['is_enroll']){
                        RedisLock::unlock($key);  //清空KEY
                        return  HttpCode::renderJSON([],'您已经报名','200');
                    }else{
                        $user_info = CastingpinUser::find()->where(['open_id'=>$this->openId])->select(['avatar_url','nick_name','gender'])->asArray()->one();
                        //微信号
                        $enroll_add['avatar_url'] =  $user_info['avatar_url'];
                        $enroll_add['nick_name'] =  $user_info['nick_name'];
                        $enroll_add['gender'] =    $user_info['gender'];
                        $enroll_add['wechat'] =   $means['wechat'];
                        $enroll_add['kol_id'] =  CastingpinNotice::find()->where(['open_id'=>$this->openId])->select(['id'])->asArray()->one()['id']; //网红ID

                        $enroll_add = json_encode($enroll_add);
                        $bm         = json_decode($enroll,true);
                        $bm = str_replace(array('[',']'), array('', ''), $bm);
                        if (!$bm){
                            $json_msg   = '['.$bm.$enroll_add.']';
                        }else{
                            $json_msg   = '['.$bm.','.$enroll_add.']';
                        }
                        //更新报名信息 (后期替换关联更新)
                        $push_update =    CastingpinNotice::updateAll(['enroll_number'=>$enroll_number+1,'enroll'=>$json_msg,'update_time'=>date('Y-m-d H:i:s',time())],['id'=>$notice_id]);
                        $pull_update =    CastingpinPull::updateAll(['is_enroll'=>'1','is_success'=>'1','update_time'=>date('Y-m-d H:i:s',time())],['id'=>$enrolls['pull_id']]);
                        if ($push_update && $pull_update){
                            RedisLock::unlock($key);  //清空KEY
                            $transaction->commit();  //提交事务
                            return  HttpCode::renderJSON($user_info['avatar_url'],'报名成功','201');

                        }else{
                            RedisLock::unlock($key);  //清空KEY
                            return  HttpCode::renderJSON([],'报名失败','416');
                        }
                    }
                }catch (\ErrorException $e){
                    $transaction->rollBack();
                    throw $e;
                }
            }else{
                echo '请稍后再试';
            }
        }else{
            return  HttpCode::jsonObj([],'请求方式出错','418');
        }
    }




}
