<?php

namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\components\Redis;
use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinConfig;
use mcastingpin\modules\v1\models\CastingpinVersion;
use yii\web\Controller;

/**
 * CastingpinConfigController implements the CRUD actions for CastingpinConfig model.
 */
class CastingpinconfigController extends Controller
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
 * 检验当前版本号
 */
    public function actionVersion()
    {
        if ((\Yii::$app->request->isPost)) {
            $version =  \Yii::$app->request->post('version');
            $valid = CastingpinVersion::find()->select(['version'])->asArray()->one();
            if ($version != $valid['version']){
                return  HttpCode::jsonObj(1,'ok',200);  //更新
            }else{
                return  HttpCode::jsonObj(0,'ok',200); //未更新
            }
        }else{
            return  HttpCode::jsonObj([],'请求方式出错','418');
        }
    }
    /*
     * 获取Redis 缓存
   */

    public function  actionMessage(){
        if ((\Yii::$app->request->isPost)) {
            $data = [];
            $valid = CastingpinVersion::find()->select(['version','status'])->asArray()->one();
            $cache_msg =  CastingpinConfig::find()->select(['code','name','sort','type','title'])->orderBy('code asc')->asArray()->all();
            $data['valid'] = $valid;
            $data['cache_msg'] = $cache_msg;
//            $list =  Redis::get('casting_list');
//            if (!$list){
//                $list = $data;
//                Redis::set('casting_list',$list);
//            }
            return  HttpCode::renderJSON($data,'ok',200);
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }



}
