<?php

namespace mcastingpin\modules\v1\controllers;

use Codeception\Module\Yii1;
use mcastingpin\common\components\AliOss;
use mcastingpin\modules\v1\models\CastingpinActor;
use yii\web\Controller;


/**
 * Site controller
 */
class AliossController extends  BaseController
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

    public function  actionIndex(){

        $type =\Yii::$app->request->post('type')??0; //0 图片  1 视频  2音频
        $oss = new AliOss();
        $tmp_name = $_FILES['file']['tmp_name'];
        if ($type == 0){
            $req = $oss->uploadImage($tmp_name);
        } elseif ($type == 1){
            $req = $oss->uploadVideo($tmp_name);
        }elseif ($type == 2){
            $req = $oss->uploadAudio($tmp_name);
        }


        return $req;
    }

}
