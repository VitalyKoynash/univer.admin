<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\EdbouserUser;
/**
 * This is the model class for table "{{%edbouser}}".
 *
 * @property integer $id
 * @property string $email
 * @property string $sessionguid
 * @property integer $sessionguid_updated_at
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property EdbouserUser[] $edbouserUsers
 */
class Edbouser extends ActiveRecord
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
        return '{{%edbouser}}';
    }
//yii\base\Security
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'], //'sessionguid_updated_at', 'created_at', 'updated_at
            [['sessionguid_updated_at', 'status', 'created_at', 'updated_at'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['sessionguid'], 'string', 'max' => 36]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'sessionguid' => Yii::t('app', 'Sessionguid'),
            'sessionguid_updated_at' => Yii::t('app', 'Sessionguid Updated At'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEDBOUserUsers()
    {
        return $this->hasMany(EdbouserUser::className(), ['id_edbouser' => 'id']);
    }

    
    public function getEDBOUsers($id_edbouser = NULL)
    {
        if (is_null($id_edbouser))
            $id_edbouser = $this->id;

        $edbouseruser = EdbouserUser::find()
                            ->where(array('id_edbouser' =>2))
                            ->all();
        
        return $edbouseruser;
        

    }

    public function getEDBOPassword (/*$password*/)
    {
        return Yii::$app->getSecurity()->decryptByPassword($this->password, $this->email);
        
    }
    public function encryptEDBOPassword (/*$password*/)
    {
        $this->password = Yii::$app->getSecurity()->encryptByPassword($this->password, $this->email);
        return true;
    }

    public function decryptEDBOPassword (/*$password*/)
    {
        $this->password = Yii::$app->getSecurity()->decryptByPassword($this->password , $this->email);
        return $this->password;
    }


}
