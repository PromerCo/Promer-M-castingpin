<?php

namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\helps\HttpCode;
use mcastingpin\common\services\TokenService;
use mcastingpin\modules\v1\services\UserTokenService;
use yii\web\Controller;
/**
 * Site controller
 */
class TokenController extends Controller
{

    public  $enableCsrfValidation=false;

    /**
     * @inheritdoc
     */
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
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionToken()
    {
        $code = \Yii::$app->request->post('code');
        if (empty($code)){
            return  HttpCode::renderJSON([],'code不能为空','412');
        }
        $wx = new UserTokenService($code);
        $token = $wx->get();
        return  HttpCode::renderJSON(['token'=>$token],'ok');
    }

    public function actionVerify()
    {

        if ((\Yii::$app->request->isPost)) {
             $token = \Yii::$app->request->post('token');
        if(!$token){
                return  HttpCode::renderJSON([],'Token不存在','412');
        }
        $valid = TokenService::verifyToken($token);
        return  HttpCode::renderJSON(['valid'=>$valid],'ok',200);
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }



}
