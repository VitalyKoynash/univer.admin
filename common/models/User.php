<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Edbouser;
use common\models\EdbouserUser;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 1;
    const STATUS_BANNED = 2;
    const STATUS_ACTIVE = 10;

    public $edbouser = '';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'required'],
            ['edbouser', 'default', 'value' => NULL],
            //[['username, password_hash, password_reset_token, email'], 'length', 'max'=>128],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            //['id, username, email, role', 'safe', 'on'=>'search'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth_key'),
            'password_hash' => Yii::t('app', 'Password'),
            'password_reset_token' => Yii::t('app', 'Password_reset_token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
           
        ];
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
            }

            

            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes) 
    {

        parent::afterSave($insert, $changedAttributes); // Вызываем родительскую функцию afterSave()

        $this->LinkUserToEDBOAccount ();
    }

    /*
    после сохранения данных пользователя устанавливаем связь пользователя с пользователем ЕДБО.
    Выполняем это после сохранения, так как при создании  пользователя еще нет id
    */
    private function LinkUserToEDBOAccount ()
    {
        \Yii::trace("связь пользователя с аккаунтом ЕДБО установливается - id_edbouser = " . $this->edbouser);
        $edbouseruser = Edbouseruser::findOne(['id_user' => $this->id]);
        
        if ($this->edbouser < 1 && $edbouseruser) { 
        /* связь с аккаунтом едбо не установлена при сохранении, поэтому удаляем запись
        соответствия аккаунтов
        */
            
            $edbouseruser->delete();
            \Yii::trace("связь пользователя с аккаунтом ЕДБО разорвана");

        } else {
            if (!$edbouseruser)
                $edbouseruser = new Edbouseruser ();
                
            $edbouseruser->id_user = $this->id;
            $edbouseruser->id_edbouser = $this->edbouser;
            $edbouseruser->save();
            \Yii::trace("связь пользователя с аккаунтом ЕДБО установлена");
        }            

    }

    /* $edbouser - не представлена в таблице БД, поэтому после успешного поиска
    * заполнем эту переменную вручную
    */
    public function afterFind() 
    {
        \Yii::trace(__METHOD__ . ' id_user = '.$this->id);
        $edbouseruser = Edbouseruser::findOne(['id_user' => $this->id]);
        if ($edbouseruser)
        {
            $this->edbouser = $edbouseruser->id_edbouser;
        
            \Yii::trace(__METHOD__ . ' $this->edbouser = '. $edbouseruser->id_edbouser);
        } else {
            \Yii::trace(__METHOD__ . ' not found');
        }
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    /**
    * @return array Массив доступных данных статуса пользователя
    */
    public static function getStatusArray($id = null)
    {
        $statuses = [
            self::STATUS_INACTIVE   => [
                'label' => Yii::t('app', 'Неактивный'),
                'color' => '',
                'icon'  => '',
                'id' => self::STATUS_INACTIVE,
            ],
            self::STATUS_ACTIVE   => [
                'label' => Yii::t('app', 'Активный'),
                'color' => 'green',
                'icon'  => '',
                'id' => self::STATUS_ACTIVE,
            ],
            self::STATUS_BANNED   => [
                'label' => Yii::t('app', 'Заблокирован'),
                'color' => 'silver',
                'icon'  => '',
                'id' => self::STATUS_BANNED,
            ],
            self::STATUS_DELETED   => [
                'label' => Yii::t('app', 'Удален'),
                'color' => 'gold',
                'icon'  => '',
                'id' => self::STATUS_DELETED,
            ],
        ];
        
        /*
        if (Yii::$app->getUser()->checkAccess('editUser')) {
            $statuses[self::STATUS_DELETED] = Yii::t('app', 'Deleted');
        }*/

        if ($id == 'dropDownList') {
            return yii\helpers\ArrayHelper::map($statuses, 'id', 'label');
        }
        
        if ($id !== null) {
            return yii\helpers\ArrayHelper::getValue($statuses, 'label', null);
        }
        
        return $statuses;
    } 

/*
    public function EDBOLogin() {
        Yii::$app->edbo->EDBOGuides->Login($model->password_hash, NULL, false);
        return true;
    }
*/

    /*возвращает объект аккаунта ЕДБО или его параметр, заданный в аргументе $param
    */
    public function getEdbouser($param = NULL)
    {
        $edbouseruser = EdbouserUser::findOne(['id_user' =>$this->id]);
        
        if (!$edbouseruser)  return NULL;
        
        $edbouser =  Edbouser::findOne(['id' =>$edbouseruser->id_edbouser]);
        
        if (!$edbouser) return NULL;

        if (is_null($param))
            return $edbouser;
        else
            return $edbouser->{$param};
    } 

    /*проверка -закепления какого-либо ЕДБО аккаунта за пользователем
    */
    public function hasEdboAccount()
    {
        return is_null($this->getEdbouser());
    }

    /*установка ИД сессии
    */
    public function setGUIDSession($GUIDSession)
    {

        $edbouser = $this->getEdbouser();
        if (!$edbouser)  return;

        $edbouser->sessionguid = $GUIDSession;
        $edbouser->touch('sessionguid_updated_at'); //устанавливаем дату обновления
        $edbouser->save();
    } 


    public function getGUIDSession()
    {
        return $this->getEdbouser('sessionguid');
    } 

    public function getEDBOUserId()
    {
        $edbouserUser = EdbouserUser::findOne(['id_user' =>$this->id]);

        if (!$edbouserUser)
            return NULL;

        return $edbouserUser->id_edbouser;
    } 

    public function getEDBOUsersArray()
    {
        $edbousers = Edbouser::find()->asArray()->all();

        if (!$edbousers)
            return NULL;

        return yii\helpers\ArrayHelper::map($edbousers, 'id', 'email');

    } 

}
