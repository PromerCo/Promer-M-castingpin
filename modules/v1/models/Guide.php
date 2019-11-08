<?php
namespace mcastingpin\modules\v1\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%guide}}".
 *
 * @property integer $id
 * @property string $imgurl
 * @property integer $status
 * @property integer $flag
 */

class Guide extends ActiveRecord implements IdentityInterface
{

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            'access_token' => $token
        ]);
    }
    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function tableName()
    {
        return '{{%guide}}';
    }

    public function rules()
    {
        return [
            [
                [
                    'imgurl',
                    'status',
                    'flag'
                ],
                'required'
            ],
            [
                [
                    'status',
                    'flag'
                ],
                'integer'
            ],
            [
                [
                    'imgurl'
                ],
                'string',
                'max' => 255
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'imgurl' => Yii::t('app', 'imgurl'),
            'status' => Yii::t('app', 'status'),
            'flag' => Yii::t('app', 'flag')
        ];
    }
}
