<?php
namespace mcastingpin\common\components;
use yii\web\Controller;
header('content-type:text/html; charset=utf-8');
ini_set('display_errors', true);

class GdImg extends Controller{
    private $handle;                //原图的句柄
    private $type;                  //文件类型
    private $src_width;             //原图的宽
    private $src_height;            //原图的高
    private $limitType = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];
    private $imageCreate = ['imagecreatefrompng', 'imagecreatefromjpeg', 'imagecreatefromjpeg', 'imagecreatefromgif'];
    private $imageOutPut = ['imagepng', 'imagejpeg', 'imagejpeg', 'imagegif'];
    private $config = [
        'width' => 50,
        'height' => 50,
        'text' => '',
        'fontSize' => 20,
        'font' => './resource/STHUPO.TTF',
        'targetFile' => 'd:/uploadFile/thumbImg'
    ];

    public function __construct($conf) {
        $this->config = array_replace($this->config, $conf);
        if(file_exists($this->config['filename']) && in_array($this->type = mime_content_type($this->config['filename']), $this->limitType)) {
            $this->handle = array_combine($this->limitType, $this->imageCreate)[$this->type]($this->config['filename']);
        }
    }

    /**计算缩放比率
     * @return float|int
     */
    private function getScaleBite() {
        $scale = 1;
        $this->src_width = imagesx($this->handle);
        $this->src_height = imagesy($this->handle);
        switch(true) {
            case $this->src_width >= $this->src_height: $scale = $this->src_width / $this->config['width']; break;
            case $this->src_width < $this->src_height: $scale = $this->src_height / $this->config['hegiht']; break;
        }
        return $scale;
    }

    /**创建新图片的幕布
     * @return false|resource
     */
    private function createScreen() {
        $screen = imagecreatetruecolor($this->config['width'], $this->config['height']);
        $color = imagecolorallocate($screen, 255, 255, 255);
        $color = imagecolortransparent($screen, $color);
        imagefill($screen, 0, 0, $color);
        return $screen;
    }

    /**创建图片新名字，生成新地址
     * @return string
     */
    private function createFilePath(){
        $name = sprintf('thumb_%s', basename($this->config['filename']));
        if(!file_exists($this->config['targetFile'])) {
            mkdir($this->config['targetFile'], 0777, true);
        }
        return sprintf('%s/%s', $this->config['targetFile'], $name);
    }

    /**打印水印
     * @param $screen
     */
    private function printLogo($screen) {
        if(!$this->config['text']) {
            return;
        }
        $fontColor = imagecolorallocate($screen, 0, 0, 0);
        imagettftext($screen, $this->config['fontSize'], 0, 20, 20, $fontColor, $this->config['font'], $this->config['text']);
    }

    /**压缩图片
     * @return string
     */
    private function imageThumb(){
        $screen = $this->createScreen();
        $scale = $this->getScaleBite();
        $newFileName = $this->createFilePath();
        $targetWidth = $this->src_width / $scale;
        $targetHeight = $this->src_height / $scale;
        imagecopyresampled($screen, $this->handle,0,0,0,0, $targetWidth, $targetHeight, $this->src_width, $this->src_height);
        $this->printLogo($screen);
        array_combine($this->limitType, $this->imageOutPut)[$this->type]($screen, $newFileName); //输出图片
        return $newFileName;            //返回新图片的名字
    }

    /**
     * 裁剪图片
     * @param string $img_file 图片位置
     * @param int $cut_w 裁剪后的宽
     * @param int $cut_h 裁剪后的高
     * @param int $cut_x $cut_y 裁剪的起点坐标
     * @return string 保存后图片路径
     */
    public function cutImg ($img_file ,$cut_w ,$cut_h ,$cut_x=0 ,$cut_y=0) {
        if (!file_exists($img_file)) {
            exit('裁剪图片不存在！');
        }
        $info = getimagesize($img_file);
        list($src_w ,$src_h) = $info;

        $src_fnc = str_replace('/', 'createfrom', $info['mime']);
        $src_img = $src_fnc($img_file);
        $dst_img = imagecreatetruecolor($cut_w, $cut_h);
        $color = imagecolorallocatealpha($dst_img, 255, 255, 255 ,127);

        $dst_x = 0;
        $dst_y = 0;
        if( $cut_w > $src_w || $cut_h > $src_h ) {//缩放图片
            imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $cut_x, $cut_y, $cut_w, $cut_h, $src_w, $src_h);
        } else {//裁剪
            imagecopy($dst_img, $src_img, $dst_x, $dst_y, $cut_x, $cut_y, $cut_w, $cut_h);
        }

        $this->checkPath();
        $filename = self::SAVE_PATH .'/' .md5(microtime()).'.png';
        imagepng($dst_img ,ROOT.$filename);
        imagedestroy($dst_img);
        imagedestroy($src_img);
        return $filename;
    }


    public function init() {
        if(!$this->handle) {
            return false;
        }
        return $this->imageThumb();
    }
}

?>