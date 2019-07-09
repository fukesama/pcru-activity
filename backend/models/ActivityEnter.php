<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "activity_enter".
 *
 * @property int $acen_id รหัสการเข้าร่วมกิจกรรม
 * @property int $acoyd_id รหัสกิจกรรมประจำปิการศึกษา
 * @property int $co_id รหัสนักศึกษา
 * @property string $enter_status สถานะการเข้าร่วม 1-ยังไม่ได้เข้าร่วม 2-เข้าร่วมแล้ว
 * @property string $result ผลประเมิน
 *
 * @property UserCollegian $co
 * @property ActivityOfyearDetail $acoyd
 * @property ActivityEnterDetail[] $activityEnterDetails
 */
class ActivityEnter extends \yii\db\ActiveRecord
{
	public $ac_id;
	public $year;
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
            [['acoyd_id', 'co_id'], 'integer'],
            [['enter_status', 'result'], 'string'],
            [['acoyd_id', 'co_id'], 'unique', 'targetAttribute' => ['acoyd_id', 'co_id']],
            [['co_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCollegian::className(), 'targetAttribute' => ['co_id' => 'user_id']],
            [['acoyd_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityOfyearDetail::className(), 'targetAttribute' => ['acoyd_id' => 'acoyd_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'acen_id' => 'รหัสการเข้าร่วมกิจกรรม',
            'acoyd_id' => 'รหัสกิจกรรมประจำปิการศึกษา',
            'co_id' => 'รหัสนักศึกษา',
            'enter_status' => 'สถานะการเข้าร่วม',
            'result' => 'ผลประเมิน',
        ];
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
    public function getAcoyd()
    {
        return $this->hasOne(ActivityOfyearDetail::className(), ['acoyd_id' => 'acoyd_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcend()
    {
        return $this->hasMany(ActivityEnterDetail::className(), ['acen_id' => 'acen_id']);
    }
}
