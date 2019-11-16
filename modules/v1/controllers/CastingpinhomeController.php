<?php
namespace mcastingpin\modules\v1\controllers;
use Codeception\Module\Yii1;
use mcastingpin\common\helps\Common;
use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinActor;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinCarefor;
use mcastingpin\modules\v1\models\CastingpinCast;
use mcastingpin\modules\v1\models\CastingpinNotice;
use mcastingpin\modules\v1\models\CastingpinPull;
use mcastingpin\modules\v1\models\CastingpinUser;
use yii\web\Controller;

/**
 * CastingpinUserController implements the CRUD actions for CastingpinUser model.
 */
class CastingpinhomeController extends Controller
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
        $type =  \Yii::$app->request->post('type')??100600;  //剧组ID
        $start_page = \Yii::$app->request->post('start_page')??0; //页数
        $data = CastingpinCast::findBySql("SELECT id,script,type,cover_img,city,theme,browse,arranger_id,debut_time,create_time FROM  castingpin_cast where type = $type order by debut_time desc limit $start_page,8")->asArray()->all();
        if ($data){
            foreach ($data as $key=>$value){
                $data[$key]['create_time'] = Common::time_tranx($value['create_time'],1);
                $data[$key]['debut_time'] =   date('Y-m-d',strtotime($data[$key]['debut_time']));
            }
        }else{
            $data = [];
        }

          return  HttpCode::renderJSON($data,'ok','201');

    }


}