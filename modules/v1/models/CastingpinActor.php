<?php
namespace mcastingpin\modules\v1\models;

use Yii;

/**
 * This is the model class for table "castingpin_actor".
 *
 * @property integer $id
 * @property string $open_id
 * @property string $wechat
 * @property string $phone
 * @property string $email
 * @property integer $occupation
 * @property string $university
 * @property string $stage_name
 * @property integer $gender
 * @property integer $birthday
 * @property integer $height
 * @property integer $weight
 * @property integer $bust
 * @property integer $waist
 * @property integer $hip
 * @property integer $style
 * @property integer $speciality
 * @property string $profile
 * @property integer $delete_status
 * @property string $create_time
 * @property string $update_time
 */
class CastingpinActor extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'castingpin_actor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {


        return [
            [['occupation', 'style', 'speciality'], 'integer'],
            [['profile'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['open_id'], 'string', 'max' => 32],
            [['wechat', 'email', 'stage_name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 11],
            [['university'], 'string', 'max' => 60],
            [['gender', 'delete_status'], 'string', 'max' => 1],
            [[ 'height', 'weight', 'bust', 'waist', 'hip'], 'string', 'max' => 3]
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
            'wechat' => '微信',
            'phone' => '手机',
            'email' => '邮箱',
            'occupation' => '职业',
            'university' => '毕业院校',
            'stage_name' => '艺名',
            'gender' => '性别',
            'birthday' => '生日',
            'height' => '身高',
            'weight' => '体重',
            'bust' => '胸围',
            'waist' => '腰围',
            'hip' => '臀围',
            'style' => '风格',
            'speciality' => '特长',
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
		'wechat' => array(
                        'name' => 'wechat',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '微信',
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
                        'label'=>$this->getAttributeLabel('wechat'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'phone' => array(
                        'name' => 'phone',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '手机',
//                         'dbType' => "char(11)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '11',
                        'scale' => '',
                        'size' => '11',
                        'type' => 'char',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('phone'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'email' => array(
                        'name' => 'email',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '邮箱',
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
                        'label'=>$this->getAttributeLabel('email'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'occupation' => array(
                        'name' => 'occupation',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '职业',
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
                        'label'=>$this->getAttributeLabel('occupation'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'university' => array(
                        'name' => 'university',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '毕业院校',
//                         'dbType' => "varchar(60)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '60',
                        'scale' => '',
                        'size' => '60',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('university'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'stage_name' => array(
                        'name' => 'stage_name',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '艺名',
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
                        'label'=>$this->getAttributeLabel('stage_name'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'gender' => array(
                        'name' => 'gender',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '性别',
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
                        'label'=>$this->getAttributeLabel('gender'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'birthday' => array(
                        'name' => 'birthday',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '生日',
//                         'dbType' => "tinyint(3)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '3',
                        'scale' => '',
                        'size' => '3',
                        'type' => 'tinyint',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('birthday'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'height' => array(
                        'name' => 'height',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '身高',
//                         'dbType' => "tinyint(3) unsigned",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '3',
                        'scale' => '',
                        'size' => '3',
                        'type' => 'tinyint',
                        'unsigned' => true,
                        'label'=>$this->getAttributeLabel('height'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'weight' => array(
                        'name' => 'weight',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '体重',
//                         'dbType' => "tinyint(3) unsigned",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '3',
                        'scale' => '',
                        'size' => '3',
                        'type' => 'tinyint',
                        'unsigned' => true,
                        'label'=>$this->getAttributeLabel('weight'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'bust' => array(
                        'name' => 'bust',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '胸围',
//                         'dbType' => "tinyint(3) unsigned",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '3',
                        'scale' => '',
                        'size' => '3',
                        'type' => 'tinyint',
                        'unsigned' => true,
                        'label'=>$this->getAttributeLabel('bust'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'waist' => array(
                        'name' => 'waist',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '腰围',
//                         'dbType' => "tinyint(3) unsigned",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '3',
                        'scale' => '',
                        'size' => '3',
                        'type' => 'tinyint',
                        'unsigned' => true,
                        'label'=>$this->getAttributeLabel('waist'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'hip' => array(
                        'name' => 'hip',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '臀围',
//                         'dbType' => "tinyint(3) unsigned",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '3',
                        'scale' => '',
                        'size' => '3',
                        'type' => 'tinyint',
                        'unsigned' => true,
                        'label'=>$this->getAttributeLabel('hip'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'style' => array(
                        'name' => 'style',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '风格',
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
                        'label'=>$this->getAttributeLabel('style'),
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
