<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "activity_ofyear".
 *
 * @property string $acoy_id
 * @property string $year
 * @property string $ac_id
 * @property int $qr_num จำนวน QrCode ที่ Generate ออกไป ณ ปัจจุบัน
 * @property string $ac_startdate
 * @property string $ac_enddate
 * @property string $ac_starttime
 * @property string $ac_endtime
 * @property string $address_detail
 *
 * @property Activity $ac
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
            [['acoy_id'], 'required'],
            [['qr_num'], 'integer'],
            [['ac_startdate', 'ac_enddate', 'ac_starttime', 'ac_endtime'], 'safe'],
            [['acoy_id'], 'string', 'max' => 8],
            [['year'], 'string', 'max' => 4],
            [['ac_id'], 'string', 'max' => 6],
            [['address_detail'], 'string', 'max' => 255],
            [['acoy_id'], 'unique'],
            [['ac_id'], 'exist', 'skipOnError' => true, 'targetClass' => Activity::className(), 'targetAttribute' => ['ac_id' => 'ac_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'acoy_id' => 'Acoy ID',
            'year' => 'Year',
            'ac_id' => 'Ac ID',
            'qr_num' => 'จำนวน QrCode ที่ Generate ออกไป ณ ปัจจุบัน',
            'ac_startdate' => 'Ac Startdate',
            'ac_enddate' => 'Ac Enddate',
            'ac_starttime' => 'Ac Starttime',
            'ac_endtime' => 'Ac Endtime',
            'address_detail' => 'Address Detail',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAc()
    {
        return $this->hasOne(Activity::className(), ['ac_id' => 'ac_id']);
    }
}
