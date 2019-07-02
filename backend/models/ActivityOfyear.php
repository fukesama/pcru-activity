<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "activity_ofyear".
 *
 * @property string $acoy_id รหัสกิจกรรมประจำปี
 * @property string $ac_id รหัสกิจกรรม
 * @property string $edu_level ชั้นปี
 * @property int $point ชั่วโมงกิจกรรมต่อวัน
 *
 * @property Activity $ac
 * @property ActivityOfyearDetail[] $activityOfyearDetails
 * @property ActivityOfyearDetail[] $activityOfyearDetails0
 */
class ActivityOfyear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
    	return 'activity_ofyear';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
    	return [
    		[[ 'edu_level', 'point'], 'required'],
    		[['point'], 'integer'],
    		[['acoy_id'], 'string', 'max' => 8],
    		[['ac_id'], 'string', 'max' => 7],
    		[['edu_level'], 'string', 'max' => 1],
    		[['acoy_id'], 'unique'],
    		[['edu_level', 'ac_id'], 'unique', 'targetAttribute' => ['edu_level', 'ac_id']],
    		[['ac_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['ac_id' => 'ac_id']],
    	];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
    	return [
    		'acoy_id' => 'รหัสกิจกรรมประจำปี',
    		'ac_id' => 'รหัสกิจกรรม',
    		'edu_level' => 'ชั้นปี',
    		'point' => 'ชั่วโมงกิจกรรม',
    	];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAc()
    {
    	return $this->hasOne(Activity::className(), ['ac_id' => 'ac_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityOfyearDetails()
    {
    	return $this->hasMany(ActivityOfyearDetail::className(), ['acoy_id' => 'acoy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityOfyearDetails0()
    {
    	return $this->hasMany(ActivityOfyearDetail::className(), ['acoy_id' => 'acoy_id']);
    }
}
