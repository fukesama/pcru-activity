<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user_officer".
 *
 * @property int $user_id รหัสผู้ใช้
 * @property string $pre_id รหัสคำนำหน้า
 * @property string $uo_fname ชื่อ
 * @property string $uo_lname นามสกุล
 *
 * @property User $user
 * @property Prefix $pre
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
            [['user_id'], 'integer'],
            [['pre_id'], 'string', 'max' => 2],
            [['uo_fname', 'uo_lname'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['pre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prefix::className(), 'targetAttribute' => ['pre_id' => 'pre_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'รหัสผู้ใช้',
            'pre_id' => 'รหัสคำนำหน้า',
            'uo_fname' => 'ชื่อ',
            'uo_lname' => 'นามสกุล',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPre()
    {
        return $this->hasOne(Prefix::className(), ['pre_id' => 'pre_id']);
    }
}
