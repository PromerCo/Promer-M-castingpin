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
    imagefill($img,0,0,$color);
    ImagePng($img,'https://ss2.baidu.com/-vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=0c78105b888ba61ec0eece2f713597cc/0e2442a7d933c8956c0e8eeadb1373f08202002a.jpg');
     ImageDestroy($img);
    $path_1 =  'https://ss2.baidu.com/-vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=0c78105b888ba61ec0eece2f713597cc/0e2442a7d933c8956c0e8eeadb1373f08202002a.jpg';//  生成的透明图片url
    $path_2 = $this->actionImageResize(file_get_contents($img_1), $defaut_w, $new_card);
    $image_1 = imagecreatefrompng($path_1);
    $image_2 = imagecreatefrompng($path_2);
    imagecopymerge($image_1, $image_2, 0, 0, 0, 0, imagesx($image_2), imagesy($image_2), 100);

    print_r($image_1);
    die;




    }

    /*
 * 生成缩略图
 * $image 图片url
 * $width 缩放宽度
 * $height 缩放高度
 * $num    缩放比例，为0不缩放，不为0忽略参数2、3的宽高
 */
    function actionImageResize($imagedata,$width,$height,$num=0){

        // 获取图像信息
        list($bigWidth, $bigHight, $bigType) = getimagesizefromstring($imagedata);

        // 缩放比例
        if ($num > 0) {
            $width  = $bigWidth * $num;
            $height = $bigHight * $num;
        }

        // 创建缩略图画板
        $block = imagecreatetruecolor($width, $height);

        // 启用混色模式
        imagealphablending($block, false);

        // 保存PNG alpha通道信息
        imagesavealpha($block, true);

        // 创建原图画板
        $bigImg = imagecreatefromstring($imagedata);

        // 缩放
        imagecopyresampled($block, $bigImg, 0, 0, 0, 0, $width, $height, $bigWidth, $bigHight);

        // 生成临时文件名
        $tmpFilename = tempnam(sys_get_temp_dir(), 'image_');

        // 保存
        switch ($bigType) {
            case 1: imagegif($block, $tmpFilename);
                break;

            case 2: imagejpeg($block, $tmpFilename);
                break;

            case 3: imagepng($block, $tmpFilename);
                break;
        }

        // 销毁
        imagedestroy($block);

        $image = $tmpFilename;

        return $image;
    }



}
