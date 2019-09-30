<?php

namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\components\AliOss;
use yii\web\Controller;


/**
 * Site controller
 */
class AliossController extends  Controller
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

        $tmp_name = $_FILES['file']['tmp_name'];

        $oss = new AliOss();
        $req = $oss->uploadImage($tmp_name);

        return $req;
    }

    public function actionTest()
    {
        $imgs_banner = trim($_FILES['file']['name']);
        $oss = new AliOss();
        $req = $oss->uploadImage($imgs_banner);


        echo '<pre>';var_dump($req);

    }

}
