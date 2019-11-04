<?php
namespace mcastingpin\modules\v1\controllers;
use Codeception\Module\Yii1;
use mcastingpin\common\helps\Common;
use mcastingpin\common\helps\HttpCode;
use mcastingpin\modules\v1\models\CastingpinActor;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinCast;
use mcastingpin\modules\v1\models\CastingpinNotice;
use mcastingpin\modules\v1\models\CastingpinPull;
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

             if($type == 100600 ){
                 $data = CastingpinNotice::findBySql("SELECT id,script,type,cover_img,city,theme,browse,debut_time FROM  castingpin_cast  order by debut_time desc limit $start_page,8")->asArray()->all();
             }else{
                 $arranger_id =    CastingpinCast::find()->where(['type'=>$type])->select(['id'])->asArray()->all(); //剧组ID
                 if ($arranger_id){
                     $first_names = array_column($arranger_id, 'id');
                     $cast_id = implode(",", $first_names);

                     $data = CastingpinNotice::findBySql("SELECT castingpin_user.avatar_url,castingpin_notice.arranger_id,castingpin_notice.id,castingpin_notice.cast_id,castingpin_notice.title,
castingpin_notice.occupation,castingpin_notice.age,castingpin_notice.speciality,castingpin_notice.convene,castingpin_notice.create_time
FROM castingpin_notice 
LEFT JOIN castingpin_arranger ON castingpin_notice.arranger_id = castingpin_arranger.id
LEFT JOIN castingpin_user  ON castingpin_user.open_id = castingpin_arranger.open_id where castingpin_notice.cast_id in ($cast_id) order by castingpin_notice.create_time desc limit $start_page,8")->asArray()->all();
                 }else{
                     $data = [];
                 }
             }

             foreach ($data as $key=>$value){
                 $data[$key]['create_time'] = Common::time_tranx($value['create_time'],1);
             }
          return  HttpCode::renderJSON($data,'ok','201');

    }

    /*
     * 详情
    */
    public function actionDetails(){
        $notice_id = \Yii::$app->request->post('notice_id'); //通告ID

        $arranger_id = \Yii::$app->request->post('arranger_id'); //统筹ID

        $data = CastingpinNotice::findBySql("SELECT  castingpin_pull.is_enroll,castingpin_pull.is_collect,castingpin_user.avatar_url,castingpin_user.nick_name,castingpin_arranger.position,castingpin_notice.arranger_id,castingpin_notice.id,castingpin_notice.cast_id,castingpin_notice.title,
castingpin_notice.occupation,castingpin_notice.age,castingpin_notice.speciality,castingpin_notice.convene,
castingpin_notice.profile,castingpin_notice.enroll,castingpin_notice.enroll_number,castingpin_notice.bystander_number,
castingpin_notice.create_time,castingpin_notice.cast_id,castingpin_cast.script,castingpin_cast.city
FROM castingpin_notice 
LEFT JOIN castingpin_arranger ON castingpin_notice.arranger_id = castingpin_arranger.id
LEFT JOIN castingpin_user  ON castingpin_user.open_id = castingpin_arranger.open_id
LEFT JOIN castingpin_pull  ON castingpin_pull.notice_id = castingpin_notice.id
LEFT JOIN castingpin_cast  ON castingpin_cast.id = castingpin_notice.cast_id
where  castingpin_notice.id = $notice_id  AND  castingpin_notice.arranger_id=$arranger_id")->asArray()->one();

        $data['create_time'] = Common::time_tranx($data['create_time'],1);
        return  HttpCode::renderJSON($data,'ok','201');
    }






}
