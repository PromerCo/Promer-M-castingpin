<?php
namespace mcastingpin\modules\v1\models;

use Yii;

/**
 * This is the model class for table "hubkol_version".
 *
 * @property integer $id
 * @property string $sion
 * @property string $version
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class CastingpinVersion extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'castingpin_version';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['sion'], 'string', 'max' => 32],
            [['version'], 'string', 'max' => 30],
            [['status'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sion' => '加密铭文',
            'version' => '版本号',
            'status' => '状态',
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
//                         'comment' => 'ID',
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
		'sion' => array(
                        'name' => 'sion',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '加密铭文',
//                         'dbType' => "char(32)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '32',
                        'scale' => '',
                        'size' => '32',
                        'type' => 'char',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('sion'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'version' => array(
                        'name' => 'version',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '版本号',
//                         'dbType' => "varchar(30)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '30',
                        'scale' => '',
                        'size' => '30',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('version'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'status' => array(
                        'name' => 'status',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '状态',
//                         'dbType' => "tinyint(1)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '1',
                        'scale' => '',
                        'size' => '1',
                        'type' => 'tinyint',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('status'),
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
