<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_collegian".
 *
 * @property int $user_id
 * @property int $pre_id คำนำหน้า
 * @property string $uc_fname ชื่อ
 * @property string $uc_lname นามสกุล
 * @property int $faculty_id คณะ
 * @property string $branch_id สาขา
 * @property string $group หมู่เรียน
 * @property string $number เลขที่
 * @property string $address ที่อยู่
 * @property string $post_num หมายเลขไปรษณีย์
 * @property string $email อีเมล
 * @property string $tel หมายเลขโทรศัพท์
 *
 * @property ActivityEnter[] $activityEnters
 * @property User $user
 * @property Prefix $pre
 * @property Faculty $faculty
 * @property Branch $branch
 */
class UserCollegian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_collegian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'pre_id', 'faculty_id'], 'integer'],
            [['uc_fname', 'uc_lname', 'address', 'email'], 'string', 'max' => 255],
            [['branch_id'], 'string', 'max' => 4],
            [['group', 'tel'], 'string', 'max' => 10],
            [['number'], 'string', 'max' => 2],
            [['post_num'], 'string', 'max' => 5],
            [['uc_fname', 'uc_lname'], 'unique', 'targetAttribute' => ['uc_fname', 'uc_lname']],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['pre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prefix::className(), 'targetAttribute' => ['pre_id' => 'pre_id']],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::className(), 'targetAttribute' => ['faculty_id' => 'faculty_id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'pre_id' => 'คำนำหน้า',
            'uc_fname' => 'ชื่อ',
            'uc_lname' => 'นามสกุล',
            'faculty_id' => 'คณะ',
            'branch_id' => 'สาขา',
            'group' => 'หมู่เรียน',
            'number' => 'เลขที่',
            'address' => 'ที่อยู่',
            'post_num' => 'หมายเลขไปรษณีย์',
            'email' => 'อีเมล',
            'tel' => 'หมายเลขโทรศัพท์',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcen()
    {
        return $this->hasMany(ActivityEnter::className(), ['co_id' => 'user_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFac()
    {
        return $this->hasOne(Faculty::className(), ['faculty_id' => 'faculty_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBra()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch_id']);
    }
}
