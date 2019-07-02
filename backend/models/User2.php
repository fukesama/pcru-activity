<?php

namespace backend\models;

use Yii;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\models\User;
use yii\db\Expression;
use common\models\ThaiDate;
/**
* This is the model class for table "user".
* @property UserCollegian $userCollegian
* @property UserOfficer $userOfficer
*/
class User extends ThaiDate implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const ADMIN = '0';
    const OFFICER = '1';
    const COLLEGIAN = '2';


    /**
    * {@inheritdoc}
    */
    public static function tableName()
    {
        return 'user';
    }

    /**
    * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'datetime'],
            [['level_user'], 'string'],
            [['username',  'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],

            [['password_reset_token'], 'unique'],
        ];
    }
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสผู็ใช้'),
            'username' => Yii::t('app', 'ชื่อผู้ใช้'),
            'auth_key' => Yii::t('app', 'Auth Key'),

            'password_hash' => Yii::t('app', 'รหัสผ่าน'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'level_user' => Yii::t('app', 'สถานะผู้ใช้'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'updated_at' => Yii::t('app', 'แก้ไข้เมื่อ'),
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUserCollegian()
    {
        return $this->hasOne(UserCollegian::className(), ['user_id' => 'id']);
    }
    public function getCollegian()
    {
        return $this->hasOne(UserCollegian::className(), ['user_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUserOfficer()
    {
        return $this->hasOne(UserOfficer::className(), ['user_id' => 'id']);
    }
    /**
    * {@inheritdoc}
    */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    /**
    * {@inheritdoc}
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
    * @return bool
    */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
    * {@inheritdoc}
    */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
    * {@inheritdoc}
    */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
    * {@inheritdoc}
    */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
    * Validates password
    *
    * @param string $password password to validate
    * @return bool if password provided is valid for current user
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
    public function signup($username,$password='12345678')
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $username;
        //$user->email = $this->email;
        $user->setPassword($password);
        $user->generateAuthKey();

        return $user->save() ? $user : null;
    }
}
