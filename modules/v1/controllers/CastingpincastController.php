<?php

namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinCast;

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
            $data        = \Yii::$app->request->post('data');
            $transaction = \Yii::$app->db->beginTransaction();
            $notice      = new CastingpinCast();
            $arranger_id = CastingpinArranger::find()->where(['open_id'=>$this->openId])->select('id')->asArray()->one();  //外加一个状态 标识切换账号
            if (empty($arranger_id) || !$arranger_id){
                return  HttpCode::renderJSON([],'请先完善统筹资料','415');
            }else{
                $data['arranger_id'] = $arranger_id['id'];
            }
            $notice->setAttributes($data,false);
            if (!$notice->save()){
                return  HttpCode::renderJSON([],$notice->errors,'412');
            }else{
                $transaction->commit();
                $info['arranger_id']   = $notice->id;
                return  HttpCode::renderJSON($info,'ok','201');
            }
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }
}
