<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "activity_cate".
 *
 * @property string $cate_id รหัสประเภทกิจกรรม
 * @property string $cate_name ชื่อประเภทกิจกรรม
 *
 * @property Activity[] $activities
 */
class ActivityCate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_cate';
    }

    /**
     * {@inheritdoc}
     */
    // public function rules()
    // {
    //     return [
    //         [['cate_id'], 'required'],
    //         [['cate_id'], 'string', 'max' => 4],
    //         [['cate_name'], 'string', 'max' => 255],
    //         [['cate_id'], 'unique'],
    //         [['cate_name'], 'unique'],
    //     ];
    // }
    public function rules()
    {
        return [
            [['cate_id'], 'required','message'=>'กรุณากรอกรหัสประเภทกิจกรรม'],
            [['cate_name'], 'required','message'=>'กรุณากรอกชื่อประเภทกิจกรรม'],
            [['cate_id'], 'string', 'max' => 4],
            [['cate_name'], 'string', 'max' => 255],
            [['cate_id'],'unique','message'=>'รหัสประเภทกิจกรรมซ้ำ'],
            [['cate_name'],'unique','message'=>'ชื่อประเภทกิจกรรมซ้ำ']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cate_id' => 'รหัสประเภทกิจกรรม',
            'cate_name' => 'ชื่อประเภทกิจกรรม',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['cate_id' => 'cate_id']);
    }
}
