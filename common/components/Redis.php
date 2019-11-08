<?php
namespace mcastingpin\common\components;
use yii\web\Controller;

class Redis extends Controller
{

    public static function set($key,$value,$expire=0){
        if(is_object($value)||is_array($value)){
            $value = serialize($value);
        }
        if ($expire == 0){
            return   \Yii::$app->redis->set($key,$value);
        }else{
            return   \Yii::$app->redis->set($key,$value,$expire);
        }
    }
    public static function get($key){
        $value =\Yii::$app->redis->get($key);
        $value_serl = @unserialize($value);
        if(is_object($value_serl)||is_array($value_serl)){
            return $value_serl;
        }
        return $value;
    }


    public static function del($key){
     return \Yii::$app->redis->del($key);
    }

}
