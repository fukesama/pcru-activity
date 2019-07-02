<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property string $branch_id รหัสสาขา
 * @property string $branch_name ชื่อสาขา
 * @property int $faculty_id รหัสคณะ
 * @property int $edub_id
 *
 * @property EduBackground $edub
 * @property Faculty $faculty
 * @property UserCollegian[] $userCollegians
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'branch_name', 'faculty_id', 'edub_id'], 'required'],
            [['faculty_id', 'edub_id'], 'integer'],
            [['branch_id'], 'string', 'max' => 3,'min'=>3],
            [['branch_name'], 'string', 'max' => 255],
            [['branch_id'], 'unique'],
            [['branch_name', 'faculty_id'], 'unique', 'targetAttribute' => ['branch_name', 'faculty_id']],
            [['edub_id'], 'exist', 'skipOnError' => true, 'targetClass' => EduBackground::className(), 'targetAttribute' => ['edub_id' => 'edub_id']],
            [['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::className(), 'targetAttribute' => ['faculty_id' => 'faculty_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'branch_id' => 'รหัสสาขา',
            'branch_name' => 'ชื่อสาขา',
            'faculty_id' => 'รหัสคณะ',
            'edub_id' => 'Edub ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdub()
    {
        return $this->hasOne(EduBackground::className(), ['edub_id' => 'edub_id']);
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
    public function getCo()
    {
        return $this->hasMany(UserCollegian::className(), ['branch_id' => 'branch_id']);
    }
}
