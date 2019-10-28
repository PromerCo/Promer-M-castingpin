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

        $pic_list       = array(
        'https://ss1.baidu.com/-4o3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=a9e671b9a551f3dedcb2bf64a4eff0ec/4610b912c8fcc3cef70d70409845d688d53f20f7.jpg',
        'https://ss1.baidu.com/9vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=05b297ad39fa828bce239be3cd1e41cd/0eb30f2442a7d9337119f7dba74bd11372f001e0.jpg',
        'https://ss0.baidu.com/7Po3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=0d33eab267224f4a4899751339f69044/b3b7d0a20cf431ad7427dfad4136acaf2fdd98a9.jpg',
        'https://ss3.baidu.com/9fo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=0cc74ef9a3773912db268361c8188675/9922720e0cf3d7ca810f3732f81fbe096a63a9fd.jpg',
        'https://ss1.baidu.com/9vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=ad628627aacc7cd9e52d32d909032104/32fa828ba61ea8d3fcd2e9ce9e0a304e241f5803.jpg',
        'https://ss2.baidu.com/-vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=d985fb87d81b0ef473e89e5eedc551a1/b151f8198618367aa7f3cc7424738bd4b31ce525.jpg',
            'https://ss0.baidu.com/7Po3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=0d33eab267224f4a4899751339f69044/b3b7d0a20cf431ad7427dfad4136acaf2fdd98a9.jpg',
            'https://ss3.baidu.com/9fo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=0cc74ef9a3773912db268361c8188675/9922720e0cf3d7ca810f3732f81fbe096a63a9fd.jpg',
            'https://ss1.baidu.com/9vo3dSag_xI4khGko9WTAnF6hhy/image/h%3D300/sign=ad628627aacc7cd9e52d32d909032104/32fa828ba61ea8d3fcd2e9ce9e0a304e241f5803.jpg'
        );

    $pic_list    = array_slice($pic_list, 0, 9); // 只操作前6个图片

     $img = @imagecreatetruecolor(100,100);    //创建真彩图像资源
        print_r($img);
        exit;
     $color = imagecolorAllocate($img,200,200,200);   //分配一个灰色
       imagefill($img,0,0,$color);                 // 从左上角开始填充灰色
        header('content-type:image/jpeg');   //jpg格式
        imagejpeg($img);



//    imagefill($background, 0, 0, $color);
//    imageColorTransparent($background, $color);
//    $pic_count  = count($pic_list);
//    $lineArr    = array();  // 需要换行的位置
//    $space_x    = 3;
//    $space_y    = 3;
//    $line_x    = 0;
//
//
//        switch($pic_count) {
//            case 1: // 正中间
//                $start_x    = intval($bg_w/4);  // 开始位置X
//                $start_y    = intval($bg_h/4);  // 开始位置Y
//                $pic_w   = intval($bg_w/2); // 宽度
//                $pic_h   = intval($bg_h/2); // 高度
//                break;
//            case 2: // 中间位置并排
//                $start_x    = 2;
//                $start_y    = intval($bg_h/4) + 3;
//                $pic_w   = intval($bg_w/2) - 5;
//                $pic_h   = intval($bg_h/2) - 5;
//                $space_x    = 5;
//                break;
//            case 3:
//                $start_x    = 40;   // 开始位置X
//                $start_y    = 5;    // 开始位置Y
//                $pic_w   = intval($bg_w/2) - 5; // 宽度
//                $pic_h   = intval($bg_h/2) - 5; // 高度
//                $lineArr    = array(2);
//                $line_x  = 4;
//                break;
//            case 4:
//                $start_x    = 4;    // 开始位置X
//                $start_y    = 5;    // 开始位置Y
//                $pic_w   = intval($bg_w/2) - 5; // 宽度
//                $pic_h   = intval($bg_h/2) - 5; // 高度
//                $lineArr    = array(3);
//                $line_x  = 4;
//                break;
//            case 5:
//                $start_x    = 30;   // 开始位置X
//                $start_y    = 30;   // 开始位置Y
//                $pic_w   = intval($bg_w/3) - 5; // 宽度
//                $pic_h   = intval($bg_h/3) - 5; // 高度
//                $lineArr    = array(3);
//                $line_x  = 5;
//                break;
//            case 6:
//                $start_x    = 5;    // 开始位置X
//                $start_y    = 30;   // 开始位置Y
//                $pic_w   = intval($bg_w/3) - 5; // 宽度
//                $pic_h   = intval($bg_h/3) - 5; // 高度
//                $lineArr    = array(4);
//                $line_x  = 5;
//                break;
//            case 7:
//                $start_x    = 53;   // 开始位置X
//                $start_y    = 5;    // 开始位置Y
//                $pic_w   = intval($bg_w/3) - 5; // 宽度
//                $pic_h   = intval($bg_h/3) - 5; // 高度
//                $lineArr    = array(2,5);
//                $line_x  = 5;
//                break;
//            case 8:
//                $start_x    = 30;   // 开始位置X
//                $start_y    = 5;    // 开始位置Y
//                $pic_w   = intval($bg_w/3) - 5; // 宽度
//                $pic_h   = intval($bg_h/3) - 5; // 高度
//                $lineArr    = array(3,6);
//                $line_x  = 5;
//                break;
//            case 9:
//                $start_x    = 5;    // 开始位置X
//                $start_y    = 5;    // 开始位置Y
//                $pic_w   = intval($bg_w/3) - 5; // 宽度
//                $pic_h   = intval($bg_h/3) - 5; // 高度
//                $lineArr    = array(4,7);
//                $line_x  = 5;
//                break;
//        }
//
//
//        foreach( $pic_list as $k=>$pic_path ) {
//            $kk = $k + 1;
//            if (in_array($kk, $lineArr)) {
//                $start_x = $line_x;
//                $start_y = $start_y + $pic_h + $space_y;
//            }
//            $pathInfo = pathinfo($pic_path);
//
//            switch (strtolower($pathInfo['extension'])) {
//                case 'jpg':
//                case 'jpeg':
//                    $imagecreatefromjpeg = 'imagecreatefromjpeg';
//                    break;
//                case 'png':
//                    $imagecreatefromjpeg = 'imagecreatefrompng';
//                    break;
//                case 'gif':
//                default:
//                    $imagecreatefromjpeg = 'imagecreatefromstring';
//                    $pic_path = file_get_contents($pic_path);
//                    break;
//            }
//        }
//        $resource   = $imagecreatefromjpeg($pic_path);
//        imagecopyresized($background,$resource,$start_x,$start_y,0,0,$pic_w,$pic_h,imagesx($resource),imagesy($resource));
//        $start_x    = $start_x + $pic_w + $space_x;
//        imagejpeg($background);


}





}
