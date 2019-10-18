<?php
namespace mcastingpin\modules\v1\controllers;
use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinNotice;

/**
 * CastingpinUserController implements the CRUD actions for CastingpinUser model.
 */
class CastingpinhomeController extends BaseController
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

    /*
     * 首页列表
     */
    public function actionHome(){
         $open_id  =  $this->openId;
         $arranger =  CastingpinArranger::find()->where(['open_id'=>$open_id])->select(['id'])->asArray()->one();
         if (empty($arranger['id'])){
             return  HttpCode::renderJSON([],'参数不能为空','416');
         }else{
          $data    =  CastingpinNotice::find()->where(['arranger_id'=>$arranger['id']])->select(['arranger_id',
          'notice_id','title','occupation','age','speciality','convene'])->asArray()->all();
          return  HttpCode::renderJSON($data,'ok','201');

         }

    }





}
