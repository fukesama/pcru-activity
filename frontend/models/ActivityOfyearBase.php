<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "activity_ofyear".
 *
 * @property string $acoy_id
 * @property string $year
 * @property string $ac_id
 * @property string $ac_startdate
 * @property string $ac_enddate
 * @property string $ac_starttime
 * @property string $ac_endtime
 * @property string $address_detail
 */
class ActivityOfyearBase extends \yii\db\ActiveRecord
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
            [['acoy_id'], 'required'],
            [['ac_startdate', 'ac_enddate', 'ac_starttime', 'ac_endtime'], 'safe'],
            [['acoy_id'], 'string', 'max' => 8],
            [['year'], 'string', 'max' => 4],
            [['ac_id'], 'string', 'max' => 5],
            [['address_detail'], 'string', 'max' => 255],
            [['acoy_id'], 'unique'],
            [['address'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'acoy_id' => Yii::t('app', 'รหัสกิจกรรมตามปีที่ดำเนินการ'),
            'year' => Yii::t('app', 'ปีการศึกษา'),
            'ac_id' => Yii::t('app', 'กิจกรรม'),
            'ac_startdate' => Yii::t('app', 'วันที่เริ่มกิจกรรม'),
            'ac_enddate' => Yii::t('app', 'วันที่สิ้นสุดกิจกรรม'),
            'ac_starttime' => Yii::t('app', 'เวลาที่เริ่มกิจกรรม'),
            'ac_endtime' => Yii::t('app', 'เวลาที่สิ้นสุดกิจกรรม'),
            'address_detail' => Yii::t('app', 'สถานที่ทำกิจกรรม'),
        ];
    }
}
