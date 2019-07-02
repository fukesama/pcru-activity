<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_officer".
 *
 * @property int $user_id รหัสผู้ใช้
 * @property int $pre_id รหัสคำนำหน้า
 * @property string $uo_fname ชื่อ
 * @property string $uo_lname นามสกุล
 *
 * @property User $user
 */
class UserOfficer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_officer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'uo_fname', 'uo_lname'], 'required'],
            [['user_id', 'pre_id'], 'integer'],
            [['uo_fname', 'uo_lname'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'pre_id' => 'Pre ID',
            'uo_fname' => 'Uo Fname',
            'uo_lname' => 'Uo Lname',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
