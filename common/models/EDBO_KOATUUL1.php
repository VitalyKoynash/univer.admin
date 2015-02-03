<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%KOATUUL1}}".
 *
 * @property integer $id
 * @property integer $Id_KOATUU
 * @property string $KOATUUCode
 * @property string $Type
 * @property integer $Id_KOATUUName
 * @property string $KOATUUName
 * @property string $KOATUUFullName
 * @property string $KOATUUDateBegin
 * @property string $KOATUUDateEnd
 * @property integer $Id_Language
 * @property string $KOATUUCodeL1
 * @property string $KOATUUCodeL2
 * @property string $KOATUUCodeL3
 * @property integer $created_at
 * @property integer $updated_at
 */
class EDBO_KOATUUL1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%KOATUUL1}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_edbo');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Id_KOATUU', 'Id_KOATUUName', 'Id_Language', 'created_at', 'updated_at'], 'integer'],
            [['KOATUUDateBegin', 'KOATUUDateEnd'], 'safe'],
            [['created_at', 'updated_at'], 'required'],
            [['KOATUUCode', 'Type', 'KOATUUName', 'KOATUUFullName', 'KOATUUCodeL1', 'KOATUUCodeL2', 'KOATUUCodeL3'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'Id_KOATUU' => Yii::t('app', 'Id  Koatuu'),
            'KOATUUCode' => Yii::t('app', 'Koatuucode'),
            'Type' => Yii::t('app', 'Type'),
            'Id_KOATUUName' => Yii::t('app', 'Id  Koatuuname'),
            'KOATUUName' => Yii::t('app', 'Koatuuname'),
            'KOATUUFullName' => Yii::t('app', 'Koatuufull Name'),
            'KOATUUDateBegin' => Yii::t('app', 'Koatuudate Begin'),
            'KOATUUDateEnd' => Yii::t('app', 'Koatuudate End'),
            'Id_Language' => Yii::t('app', 'Id  Language'),
            'KOATUUCodeL1' => Yii::t('app', 'Koatuucode L1'),
            'KOATUUCodeL2' => Yii::t('app', 'Koatuucode L2'),
            'KOATUUCodeL3' => Yii::t('app', 'Koatuucode L3'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
