<?php

namespace mcastingpin\modules\v1\controllers;
use Faker\Provider\Uuid;
use mcastingpin\modules\v1\services\AliossService;
use yii\web\UploadedFile;
use mcastingpin\common\components\Aliyunoss;


/**
 * Site controller
 */
class AliossController extends AliossService
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


        $imgs_banner = trim($_FILES['file']['name']);

        $img_banner = Uuid::uuid();
        //文件重命名
        $vend_banners = "./images/upload/".$img_banner.'.'.$imgs_banner;
        $vend_banner = $img_banner.'.'.$imgs_banner;

        $uploadPath = dirname(dirname(__FILE__)).'/web/images/upload/';  // 取得临时文件路径
        if (!file_exists($uploadPath)) {
            @mkdir($uploadPath, 0777, true);
        }
        $file_Path_vend_banner = $uploadPath.$vend_banner;
        $filepath_vend_banner=str_replace("\\", "/",$file_Path_vend_banner);//绝对路径，上传第二个参数
        $object_vend_banner="image/".$vend_banner;


        $filepath_vend_banner = "E:/Hub/Preomer/Pro/Promer-X/mcastingpin/modules/v1/web/images/upload/image-xinggan-91b2d170414acee47526bbda4f36d885c3d8fac0b037dfdd64ad62ae1f136751.jpg";

        $vend_banner_url = new Aliyunoss();
        $vend_banner_url->upload($object_vend_banner,$filepath_vend_banner);
    }

    public function actionText(){

    }


}
