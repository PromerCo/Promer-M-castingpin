<?php

namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinActor;
use mcastingpin\modules\v1\models\CastingpinArranger;
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
                        $id    = CastingpinActor::find()->where(['open_id' => $openid])->select(['id'])->one();
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
                    'email','occupation','woman','university','stage_name','city','birthday','height','weight','speciality','profile','cover_img'])->asArray()->one();
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
            $openid =   $this->openId;
            $capacity = CastingpinUser::find()->where(['open_id' => $openid])->select(['capacity'])->one();
            if (empty($capacity['capacity'])) {
                return  HttpCode::jsonObj([],'请先授权','419');
            } else {
                $actor = CastingpinActor::find()->select(['id','cover_img','cover_video'])->asArray()->all();
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
            $data =  CastingpinActor::find()->where(['id'=>$cast_id])->select(['height','stage_name','phone','cover_video','cover_img','profile'
                ,'speciality','occupation'])->asArray()->one();
            return HttpCode::renderJSON($data, 'ok', '200');
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }


    }





}
