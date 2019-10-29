<?php

namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\components\AliOss;
use mcastingpin\common\helps\HttpCode;
use OSS\OssClient;
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

       $img_list = \Yii::$app->request->post('image');

       $pic_list = explode(",", $img_list);

       // header("Content-type:image/jpg");
//        $pic_list       = array(
//        'https://ss1.baidu.com/-4o3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=a9e671b9a551f3dedcb2bf64a4eff0ec/4610b912c8fcc3cef70d70409845d688d53f20f7.jpg',
//         'https://ss1.baidu.com/9vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=05b297ad39fa828bce239be3cd1e41cd/0eb30f2442a7d9337119f7dba74bd11372f001e0.jpg',
//         'https://ss3.baidu.com/9fo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=0cc74ef9a3773912db268361c8188675/9922720e0cf3d7ca810f3732f81fbe096a63a9fd.jpg',
//         'http://c.hiphotos.baidu.com/image/h%3D300/sign=ebc877f839d3d539de3d09c30a87e927/ae51f3deb48f8c54b6cc922935292df5e0fe7f9c.jpg',
//        'https://ss2.baidu.com/-vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=d985fb87d81b0ef473e89e5eedc551a1/b151f8198618367aa7f3cc7424738bd4b31ce525.jpg',
//        );

        $pic_list = array_slice($pic_list, 0, 5); // 只操作前9个图片
        $bg_w = 410; // 背景图片宽度
        $bg_h = 204; // 背景图片高度
        $background = imagecreatetruecolor($bg_w,$bg_h); // 背景图片
        $color = imagecolorallocate($background, 255, 255, 255); // 为真彩色画布创建白色背景，再设置为透明
        imagefill($background, 0, 0, $color);
        imageColorTransparent($background, $color);
        $pic_count = count($pic_list);
        $lineArr = array(); // 需要换行的位置
        $space_x = 3;
        $space_y = 3;
        $line_x = 0;
        foreach( $pic_list as $k=>$pic_path ) {
            $kk = $k + 1;
            switch($kk) {
                case 1: // 正中间
                    $start_x = 2; // 开始位置X
                    $start_y = 2; // 开始位置Y
                    $pic_w = 200; // 宽度
                    $pic_h = 200; // 高度
                    break;
                case 2: // 中间位置并排
                    $start_x = 204;
                    $start_y = 2;
                    $pic_w   = 100;
                    $pic_h   = 100;
                    break;
                case 3:
                    $start_x = 204;
                    $start_y = 104;
                    $pic_w = 100;
                    $pic_h = 100;
                    break;
                case 4:
                    $start_x = 306;
                    $start_y = 2;
                    $pic_w = 100;
                    $pic_h = 100;
                    break;
                case 5:
                    $start_x = 308;
                    $start_y = 104;
                    $pic_w = 100;
                    $pic_h = 100;
                    break;
            }
            if ( in_array($kk, $lineArr) ) {
                $start_x = $line_x;
                $start_y = $start_y + $pic_h + $space_y;
            }
            $pathInfo = pathinfo($pic_path);
            switch( strtolower($pathInfo['extension']) ) {
                case 'jpg':
                case 'jpeg':
                    $imagecreatefromjpeg = 'imagecreatefromjpeg';
                    break;
                case 'png':
                    $imagecreatefromjpeg = 'imagecreatefrompng';
                    break;
                case 'gif':
                default:
                    $imagecreatefromjpeg = 'imagecreatefromstring';
                    $pic_path = file_get_contents($pic_path);
                    break;
            }
            $resource = $imagecreatefromjpeg($pic_path);
            imagecopyresized($background,$resource,$start_x,$start_y,0,0,$pic_w,$pic_h,imagesx($resource),imagesy($resource)); // 最后两个参数为原始图片宽度和高度，倒数两个参数为copy时的图片宽度和高度
            $start_x = $start_x + $pic_w + $space_x;
        }

       $server_nmae =  $_SERVER['SERVER_NAME'];
       $file_name = './image/'.uniqid().time().'.jpg';
       $img =  imagejpeg($background,$file_name);
       if ($img){
           $image_url = $server_nmae.''.$file_name;
           return  HttpCode::renderJSON($image_url,'ok','201');
       }






}


    /*
       *  合成图片
      */
    public function actionImage($files = [], $xNum = 1, $yNum = 3, $xDistance = 2, $yDistance = 2){
        $pic_list  = array(
           'src'=> 'https://ss1.baidu.com/-4o3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=a9e671b9a551f3dedcb2bf64a4eff0ec/4610b912c8fcc3cef70d70409845d688d53f20f7.jpg',
           'src'=>'https://ss1.baidu.com/9vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=05b297ad39fa828bce239be3cd1e41cd/0eb30f2442a7d9337119f7dba74bd11372f001e0.jpg',
           'src'=>'https://ss1.baidu.com/9vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=ad628627aacc7cd9e52d32d909032104/32fa828ba61ea8d3fcd2e9ce9e0a304e241f5803.jpg'
        );
        $bg_w = 400; // 背景图片宽度
        $bg_h = 400; // 背景图片高度
        $background = imagecreatetruecolor($bg_w,$bg_h); // 背景图片
        $color = imagecolorallocate($background, 255, 255, 255); // 为真彩色画布创建白色背景，再设置为透明
        imagefill($background, 0, 0, $color);
        imageColorTransparent($background, $color);




    }




}
