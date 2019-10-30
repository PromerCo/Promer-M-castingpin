<?php
namespace mcastingpin\modules\v1\services;

use mcastingpin\common\components\HttpClient;
use mcastingpin\common\helps\HttpCode;
use mcastingpin\common\helps\ScopeEnum;
use mcastingpin\common\services\TokenService;
use mcastingpin\modules\v1\models\CastingpinUser;
use yii\web\BadRequestHttpException;

class UserTokenService extends TokenService {
    protected $code;
    protected $wxLoginUrl;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $access_token_url;
    function __construct($code='')
    {
        $this->code = $code;
        $this->wxAppID =  \Yii::$app->params['app_id'];
        $this->wxAppSecret = \Yii::$app->params['app_secret'];
        $this->wxLoginUrl = sprintf(
            \Yii::$app->params['login_url'], $this->wxAppID, $this->wxAppSecret, $this->code);

        $this->access_token_url = sprintf(
            \Yii::$app->params['access_token_url'], $this->wxAppID, $this->wxAppSecret);
    }
    public function get()
    {
      $result  =  HttpClient::get($this->wxLoginUrl);

      $wxResult = json_decode($result, true);// openid  session_key

      if (empty($wxResult)) {
          return HttpCode::renderJSON('','获取session_key及openID时异常，微信内部错误','416');
       }
      else {
       $loginFail = array_key_exists('errcode', $wxResult);

       if ($loginFail) {
             return HttpCode::renderJSON('',$wxResult['errmsg'],$wxResult['errcode']);
        }
            else {

                 return $this->grantToken($wxResult);
            }
        }
    }
    private function grantToken($wxResult)
    {
        // 此处生成令牌使用的是YII自带的令牌
        // 如果想要更加安全可以考虑自己生成更复杂的令牌
        // 比如使用JWT并加入盐，如果不加入盐有一定的几率伪造令牌
        $openid = $wxResult['openid'];   //openid 和session_key
        $user =   CastingpinUser::findOne(['open_id'=>$openid]);

        if (!$user)
            // 借助微信的openid作为用户标识
            // 但在系统中的相关查询还是使用自己的uid
        {

            $wechat_user = new CastingpinUser();
            $wechat_user->open_id = $openid;
            $wechat_user->save();
            $uid =  $wechat_user->id;
        }
        else {
            $uid = $user->id;
        }

        $cachedValue = $this->prepareCachedValue($wxResult, $uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }

    private function prepareCachedValue($wxResult, $uid)
    {
        $cachedValue = $wxResult;  //openid  sessionj
        $cachedValue['uid'] = $uid;  //用户ID
        $cachedValue['scope'] = ScopeEnum::User; //权限  用户  管理员
        return $cachedValue;
    }

    private function saveToCache($wxResult)
    {
        $key = $this->generateToken();
        $value = json_encode($wxResult);  //转 数组
        $expire_in = \Yii::$app->params['token_expire_in'];  //过期时间  7200
        $result =  \Yii::$app->cache->set($key,$value,$expire_in);  //设置 过期时间 缓存
        if (!$result){
            //抛出异常   缓存失败
            throw new  BadRequestHttpException('重新获取缓存');
        }
        return $key;
    }

    /*
     * 获取session_key
     */
    public function getSessionKey(){
        $result  =  HttpClient::get( $this->wxLoginUrl);
        // 注意json_decode的第一个参数true
        // 这将使字符串被转化为数组而非对象
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            // 为什么以empty判断是否错误，这是根据微信返回
            // 规则摸索出来的
            // 这种情况通常是由于传入不合法的code
            throw new  BadRequestHttpException('获取session_key及openID时异常，微信内部错误');
        }
        else {
            return $wxResult['session_key'];
        }
    }
    /*
     * 获取access_token
     */
    public function getAccessToken(){
        $result  =  HttpClient::get($this->access_token_url);
        // 注意json_decode的第一个参数true
        // 这将使字符串被转化为数组而非对象
        $wxResult = json_decode($result, true);

        if (empty($wxResult)) {
            // 为什么以empty判断是否错误，这是根据微信返回
            // 规则摸索出来的
            // 这种情况通常是由于传入不合法的code
            throw new  BadRequestHttpException('获取session_key及openID时异常，微信内部错误');
        }
        else {
            return $wxResult['access_token'];
        }
    }


}
