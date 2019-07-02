<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "prefix".
 *
 * @property int $pre_id รหัสคำนำหน้า
 * @property string $pre_name ชื่อคำนำหน้า
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
            [['pre_name'], 'string', 'max' => 255],
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
}
