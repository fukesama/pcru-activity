<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "faculty".
 *
 * @property int $faculty_id
 * @property string $faculty_name
 *
 * @property Branch[] $branches
 * @property UserCollegian[] $userCollegians
 */
class Faculty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faculty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['faculty_name'], 'required'],
            [['faculty_name'], 'string', 'max' => 255],
            [['faculty_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
       return [
			'faculty_id' => 'รหัสคณะ',
			'faculty_name' => 'ชื่อคณะ',
		];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['faculty_id' => 'faculty_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCollegians()
    {
        return $this->hasMany(UserCollegian::className(), ['faculty_id' => 'faculty_id']);
    }
}
