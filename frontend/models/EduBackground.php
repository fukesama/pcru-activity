<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "edu_background".
 *
 * @property int $edub_id รหัสหลักสูตร
 * @property string $edub_name
 * @property string $edub_code
 *
 * @property Branch[] $branches
 * @property BranchCopy[] $branchCopies
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
            [['edub_name'], 'string', 'max' => 255],
            [['edub_code'], 'string', 'max' => 5],
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
            'edub_name' => 'Edub Name',
            'edub_code' => 'Edub Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branch::className(), ['edub_id' => 'edub_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranchCopies()
    {
        return $this->hasMany(BranchCopy::className(), ['edub_id' => 'edub_id']);
    }
}
