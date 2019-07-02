<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "edu_background".
 *
 * @property string $edub_id รหัสหลักสูตร
 * @property string $edub_name
 * @property string $edub_code
 *
 * @property Branch[] $branches
 */
class EduBackground extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_background';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edub_id'], 'required'],
            [['edub_id'], 'string', 'max' => 3],
            [['edub_name'], 'string', 'max' => 255],
            [['edub_code'], 'string', 'max' => 5],
            [['edub_id'], 'unique'],
            [['edub_name'], 'unique'],
            [['edub_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'edub_id' => 'รหัสหลักสูตร',
            'edub_name' => 'ชื่อหลักสูตร',
            'edub_code' => 'ชื่อย่อ',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['edub_id' => 'edub_id']);
    }
}
