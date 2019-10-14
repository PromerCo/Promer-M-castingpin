<?php
namespace mcastingpin\modules\v1\controllers;
use mcastingpin\modules\v1\models\CastingpinUser;
use mcastingpin\modules\v1\services\ParamsValidateService;
use mcastingpin\common\helps\HttpCode;
use yii\web\Controller;

/**
 * Site controller
 */
class UserController extends Controller
{
    public $modelClass = 'mcastingpin\models\CastingpinUser';
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

    /*
     * 微信授权：将用户基本信息存档
     */
    public function actionAuthorize(){


        if ((\Yii::$app->request->isPost)) {
            $data  = \Yii::$app->request->post();
            $user_id = $this->uid;
            $pvs = new ParamsValidateService();
            $valid = $pvs->validate($data, [
                [['nick_name', 'avatar_url'], 'required']
            ]);
            if (!$valid) {
                return  HttpCode::renderJSON([],$pvs->getErrorSummary(true),'416');
            }
            $wechat_user = new CastingpinUser();
            try {
                $transaction = \Yii::$app->db->beginTransaction();
                $wechat_user->updateAll($data,['id'=>$user_id]);
                if (!$wechat_user){
                    return  HttpCode::renderJSON([],'update failed','412');
                }else{
                    $transaction->commit();
                    return  HttpCode::renderJSON([],'ok','201');
                }
            }catch (\Exception $e) {
                return  HttpCode::renderJSON([],$e->getMessage(),'412');
            }
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }
}
