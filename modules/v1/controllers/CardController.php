<?php

namespace mcastingpin\modules\v1\controllers;

use yii\web\Controller;

/**
 * Site controller
 */
class CardController extends  Controller
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
     *  合成图片
    */
    public function actionCompose(){
    $img_1 = 'https://ss1.baidu.com/-4o3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=a9e671b9a551f3dedcb2bf64a4eff0ec/4610b912c8fcc3cef70d70409845d688d53f20f7.jpg';
    $img_2 = 'https://ss1.baidu.com/9vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=05b297ad39fa828bce239be3cd1e41cd/0eb30f2442a7d9337119f7dba74bd11372f001e0.jpg';
    $defaut_w = 320;//  宽
    $defaut_h = 240;//  宽
    $image_data_1 = getimagesize($img_1);//  图片1属性
    $image_data_2 = getimagesize($img_2);//  图片2属性
    $new_card = $image_data_1[1]*$defaut_w/$image_data_1[0];//  指定生成的图片1高
    $qrcode_height = $image_data_2[1]*$defaut_w/$image_data_2[0];
    $new_qrcode = $image_data_2[1]*$defaut_h/$image_data_2[0];//  指定生成的图片2高
    $defaut_poster = $new_card+$qrcode_height;//  整体高度
    $img = imagecreatetruecolor($defaut_w,$defaut_poster);
    $color = imagecolorallocate($img,255, 255, 255);//  白色
    print_r($color);





    }



}
