<?php
namespace mcastingpin\modules\v1\services;

use mcastingpin\modules\v1\models\CastingpinActor;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mcastingpin\modules\v1\models\CastingpinUser;


class CastingpinUserService {

    public static function Blocked($type,$openId){
        switch ($type){
            case 1:
                //industry 行业
                //company 公司
                //position 职位
                //city 城市
                $data = CastingpinArranger::find()->where(['open_id'=>$openId])->select(['industry','corporation','position','city'])->asArray()->one();


                if (empty($data)){
                    $data['material'] = 0;
                    $data['type'] = $type;
                }else{
                    $data['cover_img'] = CastingpinUser::find()->where(['open_id'=>$openId])->select(['avatar_url'])->asArray()->one()[0];
                    $data['material'] = 1;
                    $data['type'] = $type;
                }
                return $data;

            break;
            case 2:
                //occupation 职业
                //university 毕业院校
                //stage_name 艺名
                //style 风格
                //speciality特长
                //sex  性别
                 $data =   CastingpinActor::find()->where(['open_id'=>$openId])->select(['stage_name','university','occupation','style','speciality','sex','birthday','weight','height','phone','cover_img'])->asArray()->one();
                 if (empty($data)){
                     $data['material'] = 0;
                     $data['type'] = $type;
                 }else{
                     $data['material'] = 1;
                     $data['type'] = $type;
                 }
                return  $data;
            break;
        }
    }

}
