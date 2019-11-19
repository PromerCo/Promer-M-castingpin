<?php
namespace mcastingpin\modules\v1\models;

use Yii;

/**
 * This is the model class for table "castingpin_carefor".
 *
 * @property integer $id
 * @property integer $actor_id
 * @property integer $arranger_id
 * @property integer $status
 * @property string $create_date
 * @property string $update_time
 */
class CastingpinEnshrine extends \backend\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'castingpin_enshrine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collect_id', 'collect_id'], 'required'],
            [['collect_id', 'collect_id'], 'integer'],
            [['create_date', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'collect_id' => 'CollectId ID',
            'arranger_id' => 'ArrangerId ID',
            'create_date' => 'Create Date',
            'update_time' => 'Update Time',
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
            'collect_id' => array(
                'name' => 'collect_id',
                'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '关注者',
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
            'collect_id' => array(
                'name' => 'collect_id',
                'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '被关注者',
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

            'create_date' => array(
                'name' => 'create_date',
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
                'label'=>$this->getAttributeLabel('create_date'),
                'inputType' => 'text',
                'isEdit' => true,
                'isSearch' => false,
                'isDisplay' => true,
                'isSort' => true,
//                         'udc'=>'',
            ),
            'update_time' => array(
                'name' => 'update_time',
                'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '更新时间',
//                         'dbType' => "timestamp",
                'defaultValue' => '',
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
