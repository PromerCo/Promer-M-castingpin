<?php
namespace mcastingpin\modules\v1\models;

use Yii;

/**
 * This is the model class for table "castingpin_casting".
 *
 * @property integer $id
 * @property integer $actor_id
 * @property integer $speciality
 * @property string $audio
 * @property string $video
 * @property array $portrait
 * @property array $still
 * @property string $casting
 * @property string $opus
 * @property integer $delete_status
 * @property string $create_time
 * @property string $update_time
 */
class CastingpinCasting extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'castingpin_casting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['actor_id'], 'required'],
            [['actor_id', 'speciality'], 'integer'],
            [['portrait', 'still', 'casting', 'opus'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['audio', 'video'], 'string', 'max' => 100],
            [['delete_status'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'actor_id' => '艺人ID',
            'speciality' => '特长',
            'audio' => '音频',
            'video' => '视频',
            'portrait' => '写真',
            'still' => '剧照',
            'casting' => '魔卡',
            'opus' => '作品',
            'delete_status' => '删除状态',
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
		'actor_id' => array(
                        'name' => 'actor_id',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '艺人ID',
//                         'dbType' => "int(11) unsigned",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '11',
                        'scale' => '',
                        'size' => '11',
                        'type' => 'integer',
                        'unsigned' => true,
                        'label'=>$this->getAttributeLabel('actor_id'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'speciality' => array(
                        'name' => 'speciality',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '特长',
//                         'dbType' => "int(6)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '6',
                        'scale' => '',
                        'size' => '6',
                        'type' => 'integer',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('speciality'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'audio' => array(
                        'name' => 'audio',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '音频',
//                         'dbType' => "varchar(100)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '100',
                        'scale' => '',
                        'size' => '100',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('audio'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'video' => array(
                        'name' => 'video',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '视频',
//                         'dbType' => "varchar(100)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '100',
                        'scale' => '',
                        'size' => '100',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('video'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'portrait' => array(
                        'name' => 'portrait',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '写真',
//                         'dbType' => "json",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'array',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'json',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('portrait'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'still' => array(
                        'name' => 'still',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '剧照',
//                         'dbType' => "json",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'array',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'json',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('still'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'casting' => array(
                        'name' => 'casting',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '魔卡',
//                         'dbType' => "text",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'text',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('casting'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'opus' => array(
                        'name' => 'opus',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '作品',
//                         'dbType' => "text",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'text',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('opus'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'delete_status' => array(
                        'name' => 'delete_status',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '删除状态',
//                         'dbType' => "tinyint(1)",
                        'defaultValue' => '0',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '1',
                        'scale' => '',
                        'size' => '1',
                        'type' => 'tinyint',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('delete_status'),
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
