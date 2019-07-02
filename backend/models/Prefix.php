<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "prefix".
 *
 * @property string $pre_id รหัสคำนำหน้า
 * @property string $pre_name ชื่อคำนำหน้า
 *
 * @property UserCollegian[] $userCollegians
 * @property UserOfficer[] $userOfficers
 */
class Prefix extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prefix';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pre_name'], 'required'],
            [['pre_name'], 'string', 'max' => 255],           
            [['pre_id'], 'unique'],
            [['pre_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pre_id' => 'รหัสคำนำหน้า',
            'pre_name' => 'ชื่อคำนำหน้า',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCollegians()
    {
        return $this->hasMany(UserCollegian::className(), ['pre_id' => 'pre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOfficers()
    {
        return $this->hasMany(UserOfficer::className(), ['pre_id' => 'pre_id']);
    }
}
