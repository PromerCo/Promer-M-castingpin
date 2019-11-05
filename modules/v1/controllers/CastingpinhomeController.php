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
                 $data = CastingpinNotice::findBySql("SELECT id,script,type,cover_img,city,theme,browse,arranger_id,debut_time FROM  castingpin_cast  order by debut_time desc limit $start_page,8")->asArray()->all();
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
                 $data[$key]['debut_time'] = Common::time_tranx($value['debut_time'],1);
             }
          return  HttpCode::renderJSON($data,'ok','201');

    }

    /*
     * 详情
    */
    public function actionDetails(){
         //剧组ID
         $cast_id    = \Yii::$app->request->post('cast_id');
         //剧组列表
         $cast_list = CastingpinCast::find()->where(['id'=>$cast_id])->select(['script','city','profile','cover_img','team','debut_time','id','browse'])->asArray()->one();//
         //通告列表
         $cast_list['notice'] = CastingpinNotice::find()->where(['cast_id'=>$cast_list['id']])->select(['title','id','cast_id','occupation','age','convene','bystander_number','shoot_time'])->asArray()->all();
         //浏览量
         $transaction = \Yii::$app->db->beginTransaction();
         //查看当前剧组浏览量
         $follow_number = $cast_list['browse']; //浏览量
         CastingpinCast::updateAll(['browse'=>$follow_number+1,'update_time'=>date('Y-m-d H:i:s',time())],['id'=>$cast_id]);
         $transaction->commit();
         $cast_list['browse'] = $cast_list['browse']+1;
         return  HttpCode::renderJSON($cast_list,'ok','201');
    }
}