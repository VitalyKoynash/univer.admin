<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "{{%edbouser_user}}".
 *
 * @property integer $id
 * @property string $id_edbouser
 * @property integer $id_user
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Edbouser $idEdbouser
 * @property User $idUser
 */
class EdbouserUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%edbouser_user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id_edbouser'], 'string'],
            //[['id_user', 'created_at', 'updated_at'], 'integer'],
            //[['created_at', 'updated_at'], 'required'],
            //[['id_edbouser'], 'unique'],
            //[['id_user'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_edbouser' => Yii::t('app', 'Id Edbouser'),
            'id_user' => Yii::t('app', 'Id User'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEdbouser()
    {
        return $this->hasOne(Edbouser::className(), ['id' => 'id_edbouser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

}
