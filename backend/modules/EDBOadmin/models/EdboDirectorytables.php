<?php

namespace app\modules\EDBOadmin\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use \yii\db\ActiveRecord;

use common\models\EDBOKOATUUL1;
/**
 * This is the model class for table "{{%edbo_directorytables}}".
 *
 * @property integer $id
 * @property string $name_directory
 * @property integer $created_at
 * @property integer $updated_at
 */
class EdboDirectorytables extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    
    public function behaviors()
    {
        return [
            [
            'class' => TimestampBehavior::className(),
            'attributes' => [
            ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],//,'sessionguid_updated_at'
            ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at' ], //'sessionguid_updated_at'
            ]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%edbo_directorytables}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_directory'], 'required'], //, 'created_at', 'updated_at'
            //[['created_at', 'updated_at'], 'integer'],
            [['name_directory', 'description', 'function'], 'string'] //, 'max' => 255
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name_directory' => Yii::t('app', 'Name Directory'),
            'description' => Yii::t('app', 'Description'),
            'function' => Yii::t('app', 'Function'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function findModelTable($id)
    {
        if (($model = EDBOKOATUUL1::findOne($id)) !== null) {
            return $model;
        } else {
            return NULL;
        }
    }


}
