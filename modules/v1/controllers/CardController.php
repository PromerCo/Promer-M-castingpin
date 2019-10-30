<?php

namespace mcastingpin\modules\v1\controllers;

use abei2017\mini\core\AccessToken;
use mcastingpin\common\components\AliOss;
use mcastingpin\common\components\HttpClient;
use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\services\UserTokenService;
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
//
//      $img_list = \Yii::$app->request->post('image');
//      $pic_list = explode(",", $img_list);
     $type =  \Yii::$app->request->get('type')??0;
//    header("Content-type:image/jpg");
    $pic_list  = array(
        'http://sbs-cp.oss-cn-beijing.aliyuncs.com/image/3791133a-4bd9-3ca1-bbe8-0dfd120cc1e7',
        'http://sas-cp.oss-cn-beijing.aliyuncs.com/image/66790fa4-b330-37b5-8c12-6075e296a251',
        'http://sas-cp.oss-cn-beijing.aliyuncs.com/image/5c681fd4-d54b-3d67-a564-f5f8d69b5f1b',
        'http://sas-cp.oss-cn-beijing.aliyuncs.com/image/6f329565-4cb7-3947-bf28-12770ec84e69',
        'http://sbs-cp.oss-cn-beijing.aliyuncs.com/image/3791133a-4bd9-3ca1-bbe8-0dfd120cc1e7',
        'http://sbs-cp.oss-cn-beijing.aliyuncs.com/image/3791133a-4bd9-3ca1-bbe8-0dfd120cc1e7',
        );
        if ($type == 0){
            $pic_list[0] =$pic_list[0].'?x-oss-process=image/resize,h_296/quality,q_80';   //第一张图片宽度396 高198
            $pic_list[1] =$pic_list[1].'?x-oss-process=image/resize,h_296/quality,q_80/crop,h_396,w_296,g_center';   //第一张图片宽度396 高198
            $pic_list[2] =$pic_list[2].'?x-oss-process=image/resize,h_296/quality,q_80/crop,h_396,w_296,g_center';   //第一张图片宽度396 高198
            $pic_list[3] =$pic_list[3].'?x-oss-process=image/resize,h_296/quality,q_80/crop,h_396,w_296,g_center';   //第一张图片宽度396 高198
            $pic_list = array_slice($pic_list, 0, 4); // 只操作前4个图片
            $bg_w = 800; // 背景图片宽度
            $bg_h = 600; // 背景图片高度
            //第一个图片
            $arr['start_x_one'] =  2;
            $arr['start_y_one'] =  2;
            $arr['pic_w_one']   =  396;
            $arr['pic_h_one']   =  296;
            //第二个图片
            $arr['start_x_tow'] =  400;
            $arr['start_y_tow'] =  2;
            $arr['pic_w_tow']   =  396;
            $arr['pic_h_tow']   =  296;
            //第三个图片
            $arr['start_x_three'] =  2;
            $arr['start_y_three'] =  300;
            $arr['pic_w_three']   =  396;
            $arr['pic_h_three']   =  296;
            //第四张图片
            $arr['start_x_fore'] =  400;
            $arr['start_y_fore'] =  300;
            $arr['pic_w_fore']   =  396;
            $arr['pic_h_fore']   =  296;
            //第五张图片
            $arr['start_x_five'] =  608;
            $arr['start_y_five'] =  104;
            $arr['pic_w_five']   =  296;
            $arr['pic_h_five']   =  150;
            //第六张图片
            $arr['start_x_sixth'] =  2;
            $arr['start_y_sixth'] =  300;
            $arr['pic_w_sixth']   =  396;
            $arr['pic_h_sixth']   =  296;

        }elseif ($type == 1){

            $pic_list = array_slice($pic_list, 0, 4); // 只操作前4个图片

            $pic_list[0] =$pic_list[0].'?x-oss-process=image/resize,h_298/quality,q_80';   //第一张图片宽度396 高198
            $pic_list[1] =$pic_list[1].'?x-oss-process=image/resize,h_298/quality,q_80/crop,h_298,w_198,g_center';   //第一张图片宽度396 高198
            $pic_list[2] =$pic_list[2].'?x-oss-process=image/resize,h_298/quality,q_80/crop,h_298,w_198,g_center';   //第一张图片宽度396 高198
            $pic_list[3] =$pic_list[3].'?x-oss-process=image/resize,h_298/quality,q_80/crop,h_298,w_396,g_center';   //第一张图片宽度396 高198
            $bg_w = 400; // 背景图片宽度
            $bg_h = 900; // 背景图片高度
            //第一个图片
            $arr['start_x_one'] =  2;
            $arr['start_y_one'] =  2;
            $arr['pic_w_one'] =  396;
            $arr['pic_h_one'] =  298;
            //第二个图片
            $arr['start_x_tow'] =  2;
            $arr['start_y_tow'] =  302;
            $arr['pic_w_tow'] =  198;
            $arr['pic_h_tow'] =  296;
            //第三个图片
            $arr['start_x_three'] =  202;
            $arr['start_y_three'] =  302;
            $arr['pic_w_three'] =  196;
            $arr['pic_h_three'] =  296;
            //第四个图片
            $arr['start_x_fore'] =  2;
            $arr['start_y_fore'] =  600;
            $arr['pic_w_fore']   =  396;
            $arr['pic_h_fore']   =  298;
        }
        $background = imagecreatetruecolor($bg_w,$bg_h); // 背景图片
        $color = imagecolorallocate($background, 255, 255, 255); // 为真彩色画布创建白色背景，再设置为透明
        imagefill($background, 0, 0, $color);
        imageColorTransparent($background, $color);

        $lineArr = array(); // 需要换行的位置
        $space_x = 3;
        $space_y = 3;
        $line_x = 0;

        foreach( $pic_list as $k=>$pic_path ) {
            $kk = $k + 1;
            switch($kk) {
                case 1: // 正中间
                    $start_x  = $arr['start_x_one']; // 开始位置X
                    $start_y  = $arr['start_y_one']; // 开始位置Y
                    $pic_w    = $arr['pic_w_one']; // 宽度
                    $pic_h    = $arr['pic_h_one']; // 高度
                    break;
                case 2: // 中间位置并排
                    $start_x = $arr['start_x_tow'];
                    $start_y = $arr['start_y_tow'];
                    $pic_w   = $arr['pic_w_tow'];
                    $pic_h   = $arr['pic_h_tow'];
                    break;
                case 3:
                    $start_x = $arr['start_x_three'];
                    $start_y = $arr['start_y_three'];
                    $pic_w   = $arr['pic_w_three'];
                    $pic_h   = $arr['pic_h_three'];
                    break;
                case 4:
                    $start_x = $arr['start_x_fore'];
                    $start_y = $arr['start_y_fore'];
                    $pic_w   = $arr['pic_w_fore'];
                    $pic_h   = $arr['pic_h_fore'];
                    break;
                case 5:
                    $start_x = $arr['start_x_five'];
                    $start_y = $arr['start_y_five'];
                    $pic_w   = $arr['pic_w_five'];
                    $pic_h   = $arr['pic_h_five'];
                    break;
                case 6:
                    $start_x = $arr['start_x_sixth'];
                    $start_y = $arr['start_y_sixth'];
                    $pic_w   = $arr['pic_w_sixth'];
                    $pic_h   = $arr['pic_h_sixth'];
                    break;
            }
            if ( in_array($kk, $lineArr) ) {
                $start_x = $line_x;
                $start_y = $start_y + $pic_h + $space_y;
            }

            $imagecreatefromjpeg = 'imagecreatefromjpeg';
            $resource = $imagecreatefromjpeg($pic_path);
            imagecopyresized($background,$resource,$start_x,$start_y,0,0,$pic_w,$pic_h,imagesx($resource),imagesy($resource)); // 最后两个参数为原始图片宽度和高度，倒数两个参数为copy时的图片宽度和高度
            $start_x = $start_x + $pic_w + $space_x;
        }


       $oss = new AliOss();
       $server_nmae =  $_SERVER['DOCUMENT_ROOT'];
       $file_name = './image/'.uniqid().time().'.jpg';
       $img =  imagejpeg($background,$file_name);
       if ($img){
           $image_url = $server_nmae.''.$file_name;
           $req = $oss->uploadImage($image_url);
           if ($req){
                   unlink($image_url);
                   return  HttpCode::renderJSON($req,'ok','201');
           }

       }

}


    /*
       *  小程序图片高清化。
      */
    public function actionDefinition(){

         $wx = new UserTokenService();
         $access_token = $wx->getAccessToken();
         $img_url = 'https://castingpin.pudata.cn/image/5db8fbd2237051572404178.jpg';

         $url = "https://api.weixin.qq.com/cv/img/aicrop?img_url=$img_url&access_token=$access_token";

         $result  =  HttpClient::post($url,[]);

         print_r($result);

    }




}
