<?php
namespace mcastingpin\modules\v1\controllers;
use mcastingpin\common\services\TokenService;
use yii\redis\Connection;
use yii\rest\Controller;

class BaseController extends Controller
{
    public $uid;
   public function init()
   {

       $this->uid =TokenService::getCurrentTokenVar('uid');
       print_r($this->uid);
       die;
//       if ($this->modules === null) {
//           throw new InvalidCallException('The "modelClass" property must be set.');
//       }
//       if (in_array(\Yii::$app->requestedRoute, [
//           'v1/means/miexhibit'
//       ])) {
//
//        self::controllerLimit([
//               [
//                   'funciton' => 'v1/means/miexhibit',
//                   'time_limit' => 60,
//                   'try_times' => 10,
//               ],
//           ], \Yii::$app->requestedRoute);
//
//       }

   }
       /** 尝试次数限制
        * @param $key
        * @param $prefix //前缀，用于跟key组合存redis
        * @param $timeLimit //限制的时间
        * @param $tryTimes //限制的次数
        */
       public static function tryLimit()
   {
       $redis = new Connection();
       $ip = self::get_client_ip(true);
       $len = intval($redis->llen($ip));

       if ($len === 0){
           $redis->lpush($ip,time());
           echo "访问1次<br>";
           $redis->expire($ip,60);
       }else{
           $max_time = $redis->lrange($ip,0,0);
           if((time()- $max_time[0]) < 60){
               if($len> 10){
                   echo '访问超过了限制';
               }else{
                   $redis->lpush($ip,time());
                   echo "访问{$len}次<br>";
               }
           }
       }
   }
    /** 尝试次数限制
     * 通过ip进行限制
     */
    public static function controllerLimit($params, $funcName)
    {

        foreach ($params as $v) {
            if ($v['funciton'] == $funcName) {

                self::tryLimit();
            }
        }
    }


    public static function get_client_ip($type = 0)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL) return $ip[$type];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) unset($arr[$pos]);
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = ip2long($ip);
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }




}
