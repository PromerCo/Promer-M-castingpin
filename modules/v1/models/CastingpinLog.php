<?php
namespace mcastingpin\modules\v1\models;

use Yii;

/**
 * This is the model class for table "hubkol_log".
 *
 * @property integer $id
 * @property string $app_name
 * @property string $err_name
 * @property string $http_code
 * @property string $err_code
 * @property string $ip
 * @property string $ua
 * @property string $content
 * @property string $create_time
 * @property string $update_time
 */
class CastingpinLog extends \backend\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hubkol_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['app_name', 'err_name', 'http_code', 'err_code'], 'string', 'max' => 64],
            [['ip'], 'string', 'max' => 15],
            [['ua'], 'string', 'max' => 32],
            [['content'], 'string', 'max' => 255]
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '日志表',
            'app_name' => 'App Name',
            'err_name' => 'ERR Name',
            'http_code' => 'ERR Name',
            'err_code' => 'ERR Name',
            'ip' => 'ERR Name',
            'ua' => 'Ua',
            'content' => 'Content',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

  /**
     * 返回数据库字段信息，仅在生成CRUD时使用，如不需要生成CRUD，请注释或删除该getTableColumnInfo()代码
     * COLUMN_COMMENT可用key如下:
     * label - 显示的label
     * inputType 控件类型, 暂时只支持text,hidden  // select,checkbox,radio,file,password,
     * isEdit   是否允许编辑，如果允许编辑将在添加和修改时输入
     * isSearch 是否允许搜索
     * isDisplay 是否在列表中显示
     * isOrder 是否排序
     * udc - udc code，inputtype为select,checkbox,radio三个值时用到。
     * 特别字段：
     * id：主键。必须含有主键，统一都是id
     * create_date: 创建时间。生成的代码自动赋值
     * update_date: 修改时间。生成的代码自动赋值
     */
    public function getTableColumnInfo(){
        return array(
        'id' => array(
                        'name' => 'id',
                        'allowNull' => false,
//                         'autoIncrement' => true,
//                         'comment' => '日志表',
//                         'dbType' => "int(11) unsigned",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => true,
                        'phpType' => 'integer',
                        'precision' => '11',
                        'scale' => '',
                        'size' => '11',
                        'type' => 'integer',
                        'unsigned' => true,
                        'label'=>$this->getAttributeLabel('id'),
                        'inputType' => 'hidden',
                        'isEdit' => true,
                        'isSearch' => true,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'app_name' => array(
                        'name' => 'app_name',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => 'App Name',
//                         'dbType' => "varchar(64)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '64',
                        'scale' => '',
                        'size' => '64',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('app_name'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'err_name' => array(
                        'name' => 'err_name',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => 'ERR Name',
//                         'dbType' => "varchar(64)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '64',
                        'scale' => '',
                        'size' => '64',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('err_name'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'http_code' => array(
                        'name' => 'http_code',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => 'ERR Name',
//                         'dbType' => "varchar(64)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '64',
                        'scale' => '',
                        'size' => '64',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('http_code'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'err_code' => array(
                        'name' => 'err_code',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => 'ERR Name',
//                         'dbType' => "varchar(64)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '64',
                        'scale' => '',
                        'size' => '64',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('err_code'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'ip' => array(
                        'name' => 'ip',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => 'ERR Name',
//                         'dbType' => "varchar(15)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '15',
                        'scale' => '',
                        'size' => '15',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('ip'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'ua' => array(
                        'name' => 'ua',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => 'Ua',
//                         'dbType' => "varchar(32)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '32',
                        'scale' => '',
                        'size' => '32',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('ua'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'content' => array(
                        'name' => 'content',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => 'Content',
//                         'dbType' => "varchar(255)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '255',
                        'scale' => '',
                        'size' => '255',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('content'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'create_time' => array(
                        'name' => 'create_time',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '创建时间',
//                         'dbType' => "timestamp",
                        'defaultValue' => 'CURRENT_TIMESTAMP',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'timestamp',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('create_time'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'update_time' => array(
                        'name' => 'update_time',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '更新时间',
//                         'dbType' => "timestamp",
                        'defaultValue' => 'CURRENT_TIMESTAMP',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'timestamp',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('update_time'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		        );
        
    }
 
}
