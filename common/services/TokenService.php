<?php
namespace mcastingpin\common\services;

use Codeception\Exception\ParseException;
use mcastingpin\common\helps\Common;
use mcastingpin\common\helps\HttpCode;
use mcastingpin\common\helps\ScopeEnum;
use TheSeer\Tokenizer\TokenCollectionException;
use yii\db\Exception;
use yii\web\ForbiddenHttpException;

class TokenService
{
    // 生成令牌
    public static function generateToken()
    {
        $randChar =  Common::getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt =  \Yii::$app->params['token_salt']; //盐
        return md5($randChar . $timestamp . $tokenSalt);  //加密
    }
    //验证token是否合法或者是否过期
    //验证器验证只是token验证的一种方式
    //另外一种方式是使用行为拦截token，根本不让非法token
    //进入控制器
    public static function needPrimaryScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope) {
            if ($scope >= ScopeEnum::User) {
                return true;
            } else{
                 //抛出异常  权限不足
            }
        } else {
             //抛出异常
        }
    }

    // 用户专有权限
    public static function needExclusiveScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::User) {
                return true;
            } else {
               //抛出异常
            }
        } else {
           //token 不存在
        }
    }

    public static function needSuperScope()
    {
        $scope = self::getCurrentTokenVar('scope');
        if ($scope){
            if ($scope == ScopeEnum::Super) {
                return true;
            } else {
                throw new ForbiddenHttpException();
            }
        } else {
            throw new TokenCollectionException();
        }
    }

    public static function getCurrentTokenVar($key)
    {
        $token = \Yii::$app->request->headers['token'];
        $vars  = \Yii::$app->cache->get($token);  //

        if (!$vars)
        {
            //抛出异常
            return  HttpCode::jsonObj('','缓存失效或过期','419');
        }
        else {
            if(!is_array($vars))
            {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            } else{
              //抛出异常
                throw new Exception();
            }
        }
    }

    /**
     * 从缓存中获取当前用户指定身份标识
     * @param array $keys
     * @return array result
     * @throws \app\lib\exception\TokenException
     */
    public static function getCurrentIdentity($keys)
    {
        $token =\Yii::$app->request->headers->get('token');
        $identities = \Yii::$app->cache->get($token);
        if (!$identities)
        {
           //用户信息不存在  抛出异常
        }
        else
        {
            $identities = json_decode($identities, true);
            $result = [];
            foreach ($keys as $key)
            {
                if (array_key_exists($key, $identities))
                {
                    $result[$key] = $identities[$key];
                }
            }
            return $result;
        }
    }
    /**
     * 当需要获取全局UID时，应当调用此方法
     * 而不应当自己解析UID
     *
     */
    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        $scope = self::getCurrentTokenVar('scope');

        if ($scope == ScopeEnum::Super)
        {
            // 只有Super权限才可以自己传入uid
            // 且必须在get参数中，post不接受任何uid字段
            $userID =   \Yii::$app->request->get('uid');
            if (!$userID)
            {
                throw new ParseException(
                    [
                        'msg' => '没有指定需要操作的用户对象'
                    ]);

            }
            return $userID;
        }
        else
        {
            return $uid;
        }
    }

    /**
     * 检查操作UID是否合法
     * @param $checkedUID
     * @return bool
     * @throws Exception
     * @throws ParameterException
     */
    public static function isValidOperate($checkedUID)
    {
        if(!$checkedUID){
           //抛出异常   检查UID时必须传入一个被检查的UID
        }
        $currentOperateUID = self::getCurrentUid();
        if($currentOperateUID == $checkedUID){
            return true;
        }
        return false;
    }

    public static function verifyToken($token)
    {
        $exist =  \Yii::$app->cache->get($token);

        if($exist){
            return true;
        }
        else{
            return false;
        }
    }
}
