<?php

namespace mcastingpin\modules\v1\controllers;

use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinCast;
use mcastingpin\modules\v1\models\CastingpinNotice;
use mcastingpin\modules\v1\models\CastingpinUser;
use mcastingpin\modules\v1\validate\RegexValidator;
use mhubkol\modules\v1\services\ParamsValidateService;

/**
 * CastingpinNoticeController implements the CRUD actions for CastingpinNotice model.
 */
class CastingpinnoticeController extends BaseController
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
    * 发布活动(广告组 HUB) - 发布活动  -可能存在问题- 重复点击 插入两条一样活动活动
   */
    public function actionPush(){
        if ((\Yii::$app->request->isPost)) {
            $data  = \Yii::$app->request->post('data');
            $transaction = \Yii::$app->db->beginTransaction();

            $notice = new CastingpinNotice();


//            $valid = new RegexValidator([
//                    'method' => ['zh', 'negative'],
//                    'message' => ['必须为中文', '必须为负数']
//            ]);
//            $valid->validate($data, $error);
//            if($error){
//                return  HttpCode::renderJSON($error,'请求方式出错','418');
//
//            }

            $arranger_id =  CastingpinArranger::find()->where(['open_id'=>$this->openId])->select('id')->asArray()->one();  //外加一个状态 标识切换账号
            if (empty($arranger_id) || !$arranger_id){
                return  HttpCode::renderJSON([],'请先完善统筹资料','415');
            }else{
            $cast =     CastingpinCast::find()->where(['arranger_id'=>$arranger_id['id'],'open_id'=>$this->openId])->select('id')->asArray()->one();
            if (empty($cast) || !$cast){
                return  HttpCode::renderJSON([],'请先完善剧组资料','415');
            }
            $data['arranger_id'] = $arranger_id['id'];

            $data['cast_id'] = $cast['id'];
            }
            $notice->setAttributes($data,false);
            if (!$notice->save()){

                 $err_msg = [];
                  foreach ($notice->errors as $key =>$val){
                      array_push($err_msg,$val);
                  }
                return  HttpCode::renderJSON([],$err_msg,'412');
            }else{
                $transaction->commit();

                $info['cast_id']   = $notice->id;
                return  HttpCode::renderJSON($info,'ok','201');
            }
        }else{
            return  HttpCode::renderJSON([],'请求方式出错','418');
        }
    }

    /*
     *  发布的通告
    */
    /*
  * 我报名(发布)的栏目
  */
    public function actionLame(){
        $open_id =   $this->openId;   //获取用户ID
        //查看用户角色
        $capacity =   CastingpinUser::find()->where(['open_id'=>$open_id])->select(['capacity'])->asArray()->one();
        switch ($capacity['capacity']){
            case 1:
                $arranger_id =  CastingpinArranger::find()->where(['open_id'=>$this->openId])->select('id')->asArray()->one();  //外加一个状态 标识切换账号
                if (empty($arranger_id) || !$arranger_id){
                    return  HttpCode::renderJSON([],'请先完善统筹资料','415');
                }
                $data =  CastingpinNotice::find()->where(['arranger_id'=>$arranger_id])->orderBy('create_time desc')->asArray()->all();
                return  HttpCode::renderJSON($data,'ok','201');
                break;
            case 2:
                $data = [];
                return  HttpCode::renderJSON($data,'ok','201');
                break;
        }
    }



}
