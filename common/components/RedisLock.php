<?php
/**
 *  Redis锁操作类
 *  Date:   2016-06-30
 *  Author: fdipzone
 *  Ver:    1.0
 *
 *  Func:
 *  public  lock    获取锁
 *  public  unlock  释放锁
 *  private connect 连接
 */
namespace mcastingpin\common\components;
use yii\web\Controller;
class RedisLock extends Controller {


    /**
     * 获取锁
     * @param  String  $key    锁标识
     * @param  Int     $expire 锁过期时间
     * @return Boolean
     */
    public static function lock($key, $expire=3){

        $is_lock = \Yii::$app->redis->setnx($key, time()+$expire);
        // 不能获取锁
        if(!$is_lock){
            // 判断锁是否过期
            $lock_time = \Yii::$app->redis->get($key);
            // 锁已过期，删除锁，重新获取
            if(time()>$lock_time){
                self::unlock($key);
                $is_lock = \Yii::$app->redis->setnx($key, time()+$expire);
            }
        }
        return $is_lock? true : false;
    }

    /**
     * 释放锁
     * @param  String  $key 锁标识
     * @return Boolean
     */
    public static function unlock($key){
        return \Yii::$app->redis->del($key);
    }


} //

?>
