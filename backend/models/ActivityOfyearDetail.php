<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "activity_ofyear_detail".
 *
 * @property int $acoyd_id
 * @property string $acoy_id
 * @property string $ac_startdate วันที่เริ่มกิจกรรม
 * @property string $ac_enddate วันที่สินสุดกิจกรรม
 * @property string $address_detail สถานที่ทำกิจกรรม
 * @property string $detail รายละเอียด
 * @property int $qr_num
 * @property int $day วันขั้นต่ำที่ต้องเข้าร่วมกิจกรรม
 *
 * @property ActivityEnter[] $activityEnters
 * @property ActivityOfyear $acoy
 */
class ActivityOfyearDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_ofyear_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ac_startdate', 'ac_enddate','day','acoy_id'], 'required'],
            [['ac_startdate', 'ac_enddate'], 'safe'],
            [['detail'], 'string'],
            [['qr_num', 'day'], 'integer'],
            [['acoy_id'], 'string', 'max' => 8],
            [['address_detail'], 'string', 'max' => 255],
            [['acoy_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityOfyear::className(), 'targetAttribute' => ['acoy_id' => 'acoy_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'acoyd_id' => 'Acoyd ID',
            'acoy_id' => 'Acoy ID',
            'ac_startdate' => 'วันที่เริ่มกิจกรรม',
            'ac_enddate' => 'วันที่สินสุดกิจกรรม',
            'address_detail' => 'สถานที่ทำกิจกรรม',
            'detail' => 'รายละเอียด',
            'qr_num' => 'Qr Num',
            'day' => 'วันขั้นต่ำที่ต้องเข้าร่วมกิจกรรม',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcen()
    {
        return $this->hasMany(ActivityEnter::className(), ['acoyd_id' => 'acoyd_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcoy()
    {
        return $this->hasOne(ActivityOfyear::className(), ['acoy_id' => 'acoy_id']);
    }
}
