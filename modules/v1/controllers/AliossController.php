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

<<<<<<< HEAD
//      $filepath_vend_banner = "E:/Hub/Preomer/Pro/Promer-X/mcastingpin/modules/v1/web/images/upload/image-xinggan-91b2d170414acee47526bbda4f36d885c3d8fac0b037dfdd64ad62ae1f136751.jpg";

	$filepath_vend_banner =  '/data/www/Promer-X/mcastingpin/web/wx0a704dacdf2e7b2e.o6zAJs_3JXJGeT2tlfWN_UeMcIBA.5cdgPfMrPm0Sd001c433e30fd369ea10163bdf808936.jpg';
=======
    public function actionTest()
    {
        $imgs_banner = trim($_FILES['file']['name']);
        $oss = new AliOss();
        $req = $oss->uploadImage($imgs_banner);
>>>>>>> 7aaefdf1b7eef44e55f70e88ac8c8cc8ca3a5707


        echo '<pre>';var_dump($req);

    }

}
