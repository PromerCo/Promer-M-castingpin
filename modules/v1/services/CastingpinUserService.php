<?php
namespace mcastingpin\modules\v1\services;

use mcastingpin\modules\v1\models\CastingpinActor;
use mcastingpin\modules\v1\models\CastingpinArranger;
use mhubkol\common\helps\HttpCode;
use mhubkol\modules\v1\models\HubkolHub;
use mhubkol\modules\v1\models\HubkolKol;
use mhubkol\modules\v1\models\HubkolTags;


class CastingpinUserService {

    public static function Blocked($type,$openId){
        switch ($type){
            case 1:
               //stage_name 职业
               //university 毕业院校
               //stage_name 艺名
               //style 风格
               //speciality特长
               $data =   CastingpinActor::find()->select(['stage_name','university','stage_name','style','speciality'])->asArray()->one();
               return $data;
            break;
            case 2:
                //industry 行业
                //company 公司
                //position 职位
                //city 城市
               $data = CastingpinArranger::find()->select(['industry,company,position,city'])->asArray()->one();
               return $data;


            break;
        }
    }

}
