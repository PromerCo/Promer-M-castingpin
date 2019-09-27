<?php
namespace mcastingpin\modules\v1\services;


use mcastingpin\common\components\UtilService;
use mcastingpin\modules\v1\models\CastingpinLog;

use Yii;

class CastingpinLogService {
    public static function addErrorLog($appname,$content){
        $error = Yii::$app->errorHandler->exception;
        $model_app_logs = new CastingpinLog();
        $model_app_logs->app_name = $appname;
        $model_app_logs->content = $content;
        $model_app_logs->ip = UtilService::getIP();
        if( !empty($_SERVER['HTTP_USER_AGENT']) ) {
            $model_app_logs ->ua = "[UA:{$_SERVER['HTTP_USER_AGENT']}]";
        }
        if ($error) {
            if(method_exists($error,'getName' )) {
                $model_app_logs->err_name = $error->getName();
            }
            if (isset($error->statusCode)) {
                $model_app_logs->http_code = $error->statusCode;
            }
            $model_app_logs->err_code = $error->getCode();
        }
        $model_app_logs->save(0);
    }

}
