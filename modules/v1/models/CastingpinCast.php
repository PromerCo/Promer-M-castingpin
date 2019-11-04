<?php
namespace mcastingpin\modules\v1\models;

use Yii;

/**
 * This is the model class for table "castingpin_cast".
 *
 * @property integer $id
 * @property string $open_id
 * @property integer $arranger_id
 * @property string $script
 * @property integer $type
 * @property integer $theme
 * @property integer $city
 * @property string $team
 * @property string $profile
 * @property integer $delete_status
 * @property string $create_time
 * @property string $update_time
 */
class CastingpinCast extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'castingpin_cast';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['arranger_id','script','team','profile'], 'required'],
            [['arranger_id', 'type', 'theme'], 'integer'],
            [['team', 'profile'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['open_id'], 'string', 'max' => 32],
            [['script'], 'string', 'max' => 30],
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
            'open_id' => '微信OId',
            'arranger_id' => '统筹ID',
            'script' => '剧名',
            'type' => '剧型',
            'cover_img'=>'封面照',
            'theme' => '题材',
            'city' => '城市',
            'team' => '执行团队',
            'profile' => '简介',
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
		'open_id' => array(
                        'name' => 'open_id',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '微信OId',
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
                        'label'=>$this->getAttributeLabel('open_id'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'arranger_id' => array(
                        'name' => 'arranger_id',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '统筹ID',
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
                        'label'=>$this->getAttributeLabel('arranger_id'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'script' => array(
                        'name' => 'script',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '剧名',
//                         'dbType' => "char(30)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '30',
                        'scale' => '',
                        'size' => '30',
                        'type' => 'char',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('script'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'type' => array(
                        'name' => 'type',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '剧型',
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
                        'label'=>$this->getAttributeLabel('type'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
        'cover_img' => array(
                'name' => 'cover_img',
                'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '封面照',
//                         'dbType' => "char(30)",
                'defaultValue' => '',
                'enumValues' => null,
                'isPrimaryKey' => false,
                'phpType' => 'string',
                'precision' => '500',
                'scale' => '',
                'size' => '500',
                'type' => 'char',
                'unsigned' => false,
                'label'=>$this->getAttributeLabel('cover_img'),
                'inputType' => 'text',
                'isEdit' => true,
                'isSearch' => false,
                'isDisplay' => true,
                'isSort' => true,
//                         'udc'=>'',
        ),
		'theme' => array(
                        'name' => 'theme',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '题材',
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
                        'label'=>$this->getAttributeLabel('theme'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'city' => array(
                        'name' => 'city',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '城市',
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
                        'label'=>$this->getAttributeLabel('city'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'team' => array(
                        'name' => 'team',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '执行团队',
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
                        'label'=>$this->getAttributeLabel('team'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'profile' => array(
                        'name' => 'profile',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '简介',
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
                        'label'=>$this->getAttributeLabel('profile'),
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
