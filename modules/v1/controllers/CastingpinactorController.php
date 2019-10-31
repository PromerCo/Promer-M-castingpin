<?php

namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\components\RedisLock;
use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinActor;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinCarefor;
use mcastingpin\modules\v1\models\CastingpinCast;
use mcastingpin\modules\v1\models\CastingpinPull;
use mcastingpin\modules\v1\models\CastingpinUser;

/**
 * CastingpinActorController implements the CRUD actions for CastingpinActor model.
 */
class CastingpinactorController extends BaseController
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
     * 保存信息
     */
    public function actionSavedata(){
        if ((\Yii::$app->request->isPost)) {
            $data  =    \Yii::$app->request->post('data');
            $openid =   $this->openId;
            $capacity = CastingpinUser::find()->where(['open_id' => $openid])->select(['capacity'])->one();
            if (empty($capacity['capacity'])) {
                return  HttpCode::jsonObj([],'请先授权','416');
            } else {
            $transaction = \Yii::$app->db->beginTransaction();
            $type = $capacity['capacity'];
            switch ($type) {
                    //艺人
                    case 2:
                        $Actor = new CastingpinActor();
                        $id    = CastingpinActor::find()->where(['open_id' => $openid])->select(['id'])->one(); //基本资料
                        if (!$id) {
                            $data['open_id'] = $this->openId;
                            $Actor->setAttributes($data, false);
                            if (!$Actor->save() ) {
                                return  HttpCode::renderJSON([],$Actor->errors,'412');
                            }else{
                                $transaction->commit();
                                return  HttpCode::renderJSON([],'ok','200');
                            }
                    } else {
                            $is_update = CastingpinActor::updateAll($data, ['open_id' => $openid]);
                            if ($is_update) {
                                $transaction->commit();
                                return HttpCode::renderJSON([], 'ok', '200');
                            } else {
                                return HttpCode::renderJSON([], 'update failed', '412');
                            }
                        }
                        break;
                    case 1:
                        //统筹
                        $Arranger = new CastingpinArranger();
                        $id    = CastingpinArranger::find()->where(['open_id' => $openid])->select(['id'])->one();
                        if (!$id) {
                            $data['open_id'] = $this->openId;
                            $Arranger->setAttributes($data, false);
                            if (!$Arranger->save() ) {
                                return  HttpCode::renderJSON([],$Arranger->errors,'412');
                            }else{
                                $transaction->commit();
                                return  HttpCode::renderJSON([],'ok','200');
                            }
                        }else{
                            $is_update = CastingpinArranger::updateAll($data, ['open_id' => $openid]);
                            if ($is_update) {
                                $transaction->commit();
                                return HttpCode::renderJSON([], 'ok', '200');
                            } else {
                                return HttpCode::renderJSON([], 'update failed', '412');
                            }
                        }
                        break;
                }
            }
                //1 统筹  2.艺人
                //分别插入数据（更新数据）
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }

    /*
     * list
    */
    public function actionSmeans(){
        if ((\Yii::$app->request->isPost)) {
            $openid =   $this->openId;
            $capacity = CastingpinUser::find()->where(['open_id' => $openid])->select(['capacity'])->one();
            if (empty($capacity['capacity'])) {
                return  HttpCode::jsonObj([],'请先授权','416');
            } else {
                $type = $capacity['capacity'];
                switch ($type) {
                    //统筹
                    case 1:
                    $actor = CastingpinArranger::find()->where(['open_id'=>$this->openId])->select(['wechat','phone', 'email',
                        'industry','corporation','position','city','profile'])->asArray()->one();
                    return HttpCode::renderJSON($actor, 'ok', '200');
                    break;
                    //艺人
                    case 2:
                    $actor = CastingpinActor::find()->where(['open_id'=>$this->openId])->select(['wechat','phone','corporation',
                    'cover_video','occupation','woman','university','stage_name','city','birthday','height','weight','speciality','profile','cover_img'])->asArray()->one();
                    //地址


                    return HttpCode::renderJSON($actor, 'ok', '200');
                    break;
                }
            }
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }
    /*
     * 艺人列表
     */
    public function actionList(){
        if ((\Yii::$app->request->isPost)) {
            $occupation= \Yii::$app->request->post('style')??100200;

            $openid =   $this->openId;
            $capacity = CastingpinUser::find()->where(['open_id' => $openid])->select(['capacity'])->one();
            if (empty($capacity['capacity'])) {
                return  HttpCode::jsonObj([],'请先授权','419');
            } else {
            if ($occupation == 100200){
                    $actor = CastingpinActor::find()->select(['id','cover_img','cover_video','open_id'])->asArray()->all();
             }else{
                    $actor = CastingpinActor::find()->where(['occupation'=>$occupation])->select(['id','cover_img','cover_video','open_id'])->asArray()->all();
             }
             foreach ($actor as $key=>$value){
                    if (empty($value['cover_img'])){
                           unset($actor[$key]);
                    }
                }
                $actor =    array_values($actor);
            }
            return HttpCode::renderJSON($actor, 'ok', '200');
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }
    /*
     * 艺人详情
    */
    public function actionDetails(){

        if ((\Yii::$app->request->isPost)) {
        $cast_id = \Yii::$app->request->post('cast_id');
        $data =  CastingpinActor::find()->where(['open_id'=>$cast_id])->select(['height','stage_name','phone','cover_video','cover_img','profile'
        ,'speciality','occupation','woman','id','open_id','invite','invite_number','follow_number','weight','style'])->asArray()->one();

        //查看是否被关注
        $is_follow =   CastingpinCarefor::find()->where(['actor_id'=>$this->uid,'arranger_id'=>$data['id']])->select('status')->one();
        //关注我的人（粉丝）

        if (empty($is_follow)){
        $data['status']  = 0;
         }else{
         $data['status']  = $is_follow['status'];
         }

            return HttpCode::renderJSON($data, 'ok', '200');
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }

    }

    /*
      *  用户关注
    */
    public function actionFollow(){
        if ((\Yii::$app->request->isPost)) {

            $yir_id = \Yii::$app->request->post('arranger_id');//被关注人ID（艺人）

            $status = \Yii::$app->request->post('status')??1;  //0未关注  1已关注
            if (empty($yir_id)){
                return  HttpCode::renderJSON([],'参数不能为空','406');
            }
            $open_id =  CastingpinActor::find()->where(['id'=>$yir_id])->select(['open_id'])->asArray()->one()['open_id'];  // 艺人OpenId
            $arranger_id =   CastingpinUser::find()->where(['open_id'=>$open_id])->select(['id'])->asArray()->one()['id'];  //艺人ID

            $transaction = \Yii::$app->db->beginTransaction();
            //查看是否关注过
            $follow_status =   CastingpinCarefor::find()->where(['actor_id'=>$this->uid,'arranger_id'=>$arranger_id])->select(['status'])->asArray()->one();
            //查看网红关注总人数
            $follow_number = CastingpinActor::find()->where(['id'=>$yir_id])->select(['follow_number'])->asArray()->one()['follow_number'];
            if (!$follow_status){
                //没有关注过(插入)
                $is_success  =   \Yii::$app->db->createCommand()->insert('castingpin_carefor', [
                    'status' => $status,
                    'arranger_id' => $arranger_id,
                    'actor_id'=>$this->uid
                ])->execute();
                if ($is_success){
                    CastingpinActor::updateAll(['follow_number'=>$follow_number+1,'update_time'=>date('Y-m-d H:i:s',time())],['id'=>$yir_id]);
                    $transaction->commit();
                    return  HttpCode::renderJSON($status,'create is success','201');
                }else{
                    return  HttpCode::renderJSON([],'error','412');
                }
            }else{
                $cancel_follow =    CastingpinCarefor::updateAll(['status'=>$status,'update_time'=>date('Y-m-d H:i:s',time())],['actor_id'=>$this->uid,'arranger_id'=>$arranger_id]);
                if ($cancel_follow){

                    if ($status == 1){
                         CastingpinActor::updateAll(['follow_number'=>intval($follow_number)+1,'update_time'=>date('Y-m-d H:i:s',time())],['id'=>$yir_id]);
                    }else{
                        CastingpinActor::updateAll(['follow_number'=>intval($follow_number)-1,'update_time'=>date('Y-m-d H:i:s',time())],['id'=>$yir_id]);
                    }
                    $transaction->commit();
                    return  HttpCode::renderJSON($status,'ok','201');
                }else{
                    return  HttpCode::renderJSON(['关注失败'],'error','412');
                }
            }
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }

    /*
    * 邀请艺人
    */
    public function actionInvite(){
        if ((\Yii::$app->request->isPost)) {
            $arranger_id  = \Yii::$app->request->post('arranger_id'); //艺人ID
            $transaction = \Yii::$app->db->beginTransaction();
            if (empty($arranger_id)){
                return  HttpCode::renderJSON([],'参数不能为空','406');
            }
            $key = 'mylock';//加锁
            $is_lock = RedisLock::lock($key);
            if ($is_lock){
                try{
                    //获取用户身份 及其头像
                    $userinfo =   CastingpinUser::find()->where(['open_id'=>$this->openId])->select(['capacity','avatar_url'])->asArray()->one();

                    if ($userinfo['capacity'] == 1){
                        //统筹是否填写资料
                        $arranger = CastingpinArranger::find()->where(['open_id'=>$this->openId])->select(['id'])->asArray()->one();
                        //已经填写资料
                        if (!empty($arranger['id'])) {
                            //查看（艺人）受邀人数
                            $invites = CastingpinActor::find()->where(['id' => $arranger_id])->select(['invite', 'invite_number'])->asArray()->one();

                            if (!empty($invites['invite'])) {
                                $invite = $invites['invite'];
                                $invite_data = json_decode(json_decode($invite, true), true);
                                foreach ($invite_data as $key => $value) {
                                    if ($value['arranger_id'] == $arranger['id']) {
                                        return HttpCode::renderJSON([], '您已经邀请过了', '200');
                                    }
                                }
                                $invite_json = json_decode($invite, true);
                                $bm = str_replace(array('[', ']'), array('', ''), $invite_json);
                            } else {
                                $invites['invite_number'] = 0;
                                $bm = null;
                            }
                        //没有邀请 -》 获取HUB 头像和ID
                        $user_kol['avatar_url']  = $userinfo['avatar_url'];
                        $user_kol['arranger_id']  = $arranger['id'];  //统筹
                        $add_kol = json_encode($user_kol);
                        if (!$bm){
                            $json_msg   = '['.$bm.$add_kol.']';
                        }else{
                            $json_msg   = '['.$add_kol.']';
                        }

                        //更新网红信息
                        $is_update =   CastingpinActor::updateAll(['invite'=>$json_msg,'invite_number'=>$invites['invite_number']+1,'update_time'=>date('Y-m-d H:i:s',time())],['id'=>$arranger_id]);

                        //邀请人数
                        if ($is_update){
                            RedisLock::unlock($key);  //清空KEY
                            $transaction->commit();  //提交事务
                            return  HttpCode::renderJSON($userinfo['avatar_url'],'邀请成功','201');
                        }else{
                            return  HttpCode::renderJSON([],'邀请失败','418');
                        }
                        }else{
                            return  HttpCode::renderJSON([],'请先填写资料','412');
                        }
                    }else{
                        return  HttpCode::renderJSON([],'您不是统筹身份','412');
                    }
                }catch (\ErrorException $e){
                    $transaction->rollBack();
                    throw $e;
                }

            } else{
                return  HttpCode::renderJSON([],'请稍后再试','418');
            }
        }else{
            return  HttpCode::jsonObj([],'请求方式出错','418');
        }

    }

    /*
       * 我关注（粉丝）
       */
    public function actionFoluser(){
        $type = \Yii::$app->request->post('type')??0;
        $status = \Yii::$app->request->post('status')??0;
        if ($status == 0){
         //我的收藏

               CastingpinPull::find()->where()->select([''])->one();



        }else{
            if ($type == 0){
                //关注
                $data =   CastingpinUser::findBySql("SELECT open_id,avatar_url,nick_name,IF(capacity = 1,'统筹','艺人') as capacity,id FROM  castingpin_user WHERE  id  in(SELECT arranger_id FROM castingpin_carefor WHERE actor_id = $this->uid and  status = 1)")->asArray()->all();
                if (!empty($data)){
                    foreach ($data as $key => $value){
                        $data[$key]['pro_id'] = CastingpinActor::find()->where(['open_id'=>$value['open_id']])->select(['id'])->one()['id'];
                        $data[$key]['stage_name'] = CastingpinActor::find()->where(['open_id'=>$value['open_id']])->select(['stage_name'])->one()['stage_name'];
                        $data[$key]['occupation'] = CastingpinActor::find()->where(['open_id'=>$value['open_id']])->select(['occupation'])->one()['occupation'];
                    }
                }else{
                    $data = [];
                }
            }else{
                //粉丝
                $data =   CastingpinUser::findBySql("SELECT open_id,avatar_url,nick_name,IF(capacity = 1,'统筹','艺人') as capacity,id FROM  castingpin_user WHERE  id in(SELECT actor_id FROM castingpin_carefor WHERE arranger_id = $this->uid  and status = 1)")->asArray()->all();
                foreach ($data as $key => $value){
                    $data[$key]['position'] = CastingpinArranger::find()->where(['open_id'=>$value['open_id']])->select(['position'])->one()['position'];

                }
            }
        }

        return  HttpCode::jsonObj($data,'ok','201');
    }







}
