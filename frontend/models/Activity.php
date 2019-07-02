<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "activity".
 *
 * @property string $ac_id รหัสกิจกรรม
 * @property string $cate_id รหัสประเภทกิจกรรม
 * @property string $type_id รหัสชนิดกิจกรรม
 * @property string $side_id รหัสด้านกิจกรรม
 * @property int $ac_num ชั่วโมงกิจกรรม
 * @property string $ac_name ชื่อกิจกรรม
 * @property int $ac_time ชั่วโมงกิจกรรม
 *
 * @property ActivityCate $cate
 * @property ActivityType $type
 * @property ActivitySide $side
 * @property ActivityOfyear[] $activityOfyears
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
    // public function rules()
    // {
    //     return [
    //         [['ac_id'], 'required'],
    //         [['ac_num', 'ac_time'], 'integer'],
    //         [['ac_id'], 'string', 'max' => 6],
    //         [['cate_id'], 'string', 'max' => 4],
    //         [['type_id', 'side_id'], 'string', 'max' => 1],
    //         [['ac_name'], 'string', 'max' => 255],
    //         [['ac_id'], 'unique'],
    //         [['type_id', 'side_id', 'ac_num','cate_id'], 'unique', 'targetAttribute' => ['type_id', 'side_id', 'ac_num']],
    //         [['ac_name'], 'unique'],
    //         [['cate_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityCate::className(), 'targetAttribute' => ['cate_id' => 'cate_id']],
    //         [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityType::className(), 'targetAttribute' => ['type_id' => 'type_id']],
    //         [['side_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivitySide::className(), 'targetAttribute' => ['side_id' => 'side_id']],
    //     ];
    // }
    public function rules()
    {
        return [
            [['ac_id'], 'required','message'=>'กรุณาเลือกรหัสกิจกรรม'],
            [['ac_num'], 'required','message'=>'กรุณากรอกชั่วโมงกิจกรรม'],
            [['cate_id'], 'required','message'=>'กรุณาเลือกรหัสประเภทกิจกรรม'],
            [['type_id'], 'required','message'=>'กรุณาเลือกรหัสชนิดกิจกรรม'],
            [['side_id'], 'required','message'=>'กรุณาเลือกรหัสด้านกิจกรรม'],
            [['ac_name'], 'required','message'=>'กรุณากรอกชื่อกิจกรรม'],
            [['ac_time'], 'required','message'=>'กรุณากรอกชั่วโมงกิจกรรม(หน่วย)'],
            [['ac_num', 'ac_time'], 'integer'],
            [['ac_id'], 'string', 'max' => 6],
            [['cate_id'], 'string', 'max' => 4],
            [['type_id', 'side_id'], 'string', 'max' => 1],
            [['ac_name'], 'string', 'max' => 255],
            [['ac_id'], 'unique','message'=>'รหัสกิจกรรมซ้ำ'],
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
            'ac_name' => 'ชื่อกิจกรรม',
            'ac_time' => 'ชั่วโมงกิจกรรม',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityOfyears()
    {
        return $this->hasMany(ActivityOfyear::className(), ['ac_id' => 'ac_id']);
    }
}
