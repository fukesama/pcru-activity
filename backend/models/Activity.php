<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property string $ac_id รหัสกิจกรรม
 * @property string $cate_id รหัสประเภทกิจกรรม
 * @property string $type_id รหัสชนิดกิจกรรม
 * @property string $side_id รหัสด้านกิจกรรม
 * @property int $ac_num ชั่วโมงกิจกรรม
 * @property string $ac_level ระดับการศึกษา
 * @property string $ac_name ชื่อกิจกรรม
 *
 * @property ActivityCate $cate
 * @property ActivityType $type
 * @property ActivitySide $side
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ac_id','cate_id', 'side_id', 'ac_num', 'ac_name'], 'required'],
            [['ac_num'], 'integer'],
            [['ac_id'], 'string', 'max' => 7],
            [['cate_id'], 'string', 'max' => 4],
            [['type_id', 'side_id'], 'string', 'max' => 1],          
            [['ac_name'], 'string', 'max' => 255],
            [['ac_id'], 'unique'],
            [['ac_name'], 'unique'],
            [['type_id', 'side_id', 'ac_num', 'cate_id'], 'unique', 'targetAttribute' => ['type_id', 'side_id', 'ac_num', 'cate_id']],
            [['cate_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityCate::className(), 'targetAttribute' => ['cate_id' => 'cate_id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityType::className(), 'targetAttribute' => ['type_id' => 'type_id']],
            [['side_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivitySide::className(), 'targetAttribute' => ['side_id' => 'side_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ac_id' => 'รหัสกิจกรรม',
            'cate_id' => 'รหัสประเภทกิจกรรม',
            'type_id' => 'รหัสชนิดกิจกรรม',
            'side_id' => 'รหัสด้านกิจกรรม',
            'ac_num' => 'ชั่วโมงกิจกรรม',
            'ac_level' => 'ระดับการศึกษา',
            'ac_name' => 'ชื่อกิจกรรม',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCate()
    {
        return $this->hasOne(ActivityCate::className(), ['cate_id' => 'cate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(ActivityType::className(), ['type_id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSide()
    {
        return $this->hasOne(ActivitySide::className(), ['side_id' => 'side_id']);
    }
}
