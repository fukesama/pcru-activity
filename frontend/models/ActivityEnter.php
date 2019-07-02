<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "activity_enter".
 *
 * @property int $acen_id รหัสการเข้าร่วมกิจกรรม
 * @property string $acoy_id
 * @property int $co_id รหัสผู้ใช้ ระดับ นักศึกษา
 * @property string $enter_status 1-ยังไม่ได้เข้าร่วม 2-เข้าร่วมแล้ว
 * @property string $results
 * @property string $acen_startdate
 * @property string $acen_enddate
 * @property string $acen_starttime
 * @property string $acen_endtime
 *
 * @property ActivityOfyear $acoy
 * @property UserCollegian $co
 * @property ActivityEnterDetail[] $activityEnterDetails
 */
class ActivityEnter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_enter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['co_id'], 'integer'],
            [['co_id'], 'required','message'=>'กรุณาเลือกนักศึกษา'],
            [['acoy_id'], 'required','message'=>'กรุณาเลือกกิจกรรม'],
            [['enter_status'], 'string'],

            [['acoy_id'], 'string', 'max' => 8],
            [['acoy_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityOfyear::className(), 'targetAttribute' => ['acoy_id' => 'acoy_id']],
            [['co_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCollegian::className(), 'targetAttribute' => ['co_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'acen_id' => 'รหัสการเข้าร่วมกิจกรรม',
            'acoy_id' => 'รหัสกิจกรรมตามปีการศึกษา',
            'co_id' => 'รหัสผู้ใช้ ระดับ นักศึกษา',
            'enter_status' => '1-ยังไม่ได้เข้าร่วม 2-เข้าร่วมแล้ว',


        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcoy()
    {
        return $this->hasOne(ActivityOfyear::className(), ['acoy_id' => 'acoy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCo()
    {
        return $this->hasOne(UserCollegian::className(), ['user_id' => 'co_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityEnterDetails()
    {
        return $this->hasMany(ActivityEnterDetail::className(), ['acen_id' => 'acen_id']);
    }
}
