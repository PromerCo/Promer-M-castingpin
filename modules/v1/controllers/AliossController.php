<?php
namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\components\Aliyunoss;
use yii\web\Controller;
/**
 * Site controller
 */
class AliossController extends Controller
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

           $al = new Aliyunoss();
        $al->test();
    }


}
