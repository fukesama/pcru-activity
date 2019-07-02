<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password
 * @property string $password_hash
 * @property string $password_reset_token
 * @property int $status
 * @property string $level_user สถานะผู้ใช้0-ADMIN 1-EMPLOYEE 2-STUDENT
 * @property int $created_at
 * @property int $updated_at
 * @property string $email
 *
 * @property UserCollegian $userCollegian
 * @property UserOfficer $userOfficer
 */
class UserC extends \yii\db\ActiveRecord
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
            [['id'],'integer'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['level_user'], 'string'],
            [['username', 'password', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password' => 'Password',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'level_user' => 'สถานะผู้ใช้0-ADMIN 1-EMPLOYEE 2-STUDENT',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegian()
    {
        return $this->hasOne(UserCollegian::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOfficer()
    {
        return $this->hasOne(UserOfficer::className(), ['user_id' => 'id']);
    }
     public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
}
