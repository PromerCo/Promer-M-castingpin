<?php
namespace mcastingpin\common\components;

use Faker\Provider\Uuid;
use OSS\Core\OssException;
use OSS\OssClient;
use Yii;

class AliOss
{
    public static $oss;
    public static $bucket;

    public function __construct()
    {
        $accessKeyId        = Yii::$app->params['oss']['accessKeyId'];
        $accessKeySecret    = Yii::$app->params['oss']['accessKeySecret'];
        $endpoint           = Yii::$app->params['oss']['endPoint'];
        self::$bucket       = Yii::$app->params['oss']['bucket'];
        self::$oss = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
    }

    public function uploadImage($file)
    {
        $fileType = Yii::$app->params['oss']['fileType']['image'];
        $fielName = Uuid::uuid();
        $object = $fileType .'/'.$fielName;

        try {
            $req = self::$oss->multiuploadFile(self::$bucket, $object, $file);
            return $this->resp($req);
        } catch (OssException $e) {
//            printf(__FUNCTION__ . ": FAILED\n");
//            printf($e->getMessage() . "\n");Y
            return $e->getMessage();
        }
    }

    public function uploadVideo($file)
    {
        $fileType = Yii::$app->params['oss']['fileType']['video'];
        $fielName = Uuid::uuid();
        $object = $fileType .'/'.$fielName;
        try {
            $req = self::$oss->multiuploadFile(self::$bucket, $object, $file);
            return $this->resp($req);
        } catch (OssException $e) {
//            printf(__FUNCTION__ . ": FAILED\n");
//            printf($e->getMessage() . "\n");Y
            return;
        }
    }

    public function uploadAudio($file)
    {
        $fileType = Yii::$app->params['oss']['fileType']['audio'];
        $fielName = Uuid::uuid();
        $object = $fileType .'/'.$fielName;
        try {
            $req = self::$oss->multiuploadFile(self::$bucket, $object, $file);
            return $this->resp($req);
        } catch (OssException $e) {
//            printf(__FUNCTION__ . ": FAILED\n");
//            printf($e->getMessage() . "\n");Y
            return;
        }
    }


    /**
     * 删除指定文件
     * @param $object 被删除的文件名
     * @return bool   删除是否成功
     */

    /**
     * @param $object
     * @return bool
     */
    public function delete($object)
    {
        $res = false;
        $bucket = Yii::$app->params['oss']['bucket'];    //获取阿里云oss的bucket
        if (self::$oss->deleteObject($bucket, $object)){ //调用deleteObject方法把服务器文件上传到阿里云oss
            $res = true;
        }

        return $res;
    }



    public function resp($req)
    {
        return $req['oss-request-url'];
    }

}
