<?php
namespace mcastingpin\modules\v1\controllers;


use mcastingpin\common\services\ApplogService;

use Yii;
use yii\log\FileTarget;
use yii\web\Controller;
class ErrorController extends Controller {

	public function actionError(){

		$error = Yii::$app->errorHandler->exception;

		$err_msg = "";
		if ($error) {
			$code = $error->getCode();
			$msg = $error->getMessage();
			$file = $error->getFile();
			$line = $error->getLine();
			$time = microtime(true);
			$log = new FileTarget();
			$log->logFile = Yii::$app->getRuntimePath() . '/logs/err.log';
			$err_msg = $msg . " [file: {$file}][line: {$line}][err code:$code.]".
				"[url:{$_SERVER['REQUEST_URI']}][post:".http_build_query($_POST)."]";
			$log->messages[] = [
				$err_msg,
				1,
				'application',
				$time
			];
			$log->export();


			ApplogService::addErrorLog(Yii::$app->id,$err_msg);
		}
        $data = [
            'code' => $code,
            'msg' => $msg,
            'data' => [
                'file' => $file,
                'line' => $line
            ]
        ];
        echo json_encode($data);
        die;
    }
}