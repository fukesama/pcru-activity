<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "activity_enter_detail".
 *
 * @property int $acend_id
 * @property int $acen_id ชื่อกิจกรรม
 * @property string $qrcode รหัส Qrcode ที่ถูก Generate ออกไป
 * @property string $acend_date วันที่ทำกิจกรรม
 *
 * @property ActivityEnter $acen
 */
class ActivityEnterDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity_enter_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acen_id','qr_num'], 'integer'],
            [['qrcode', 'acend_date'], 'required'],
            [['acend_date'], 'safe'],
            [['qrcode'], 'string', 'max' => 20],
            [['acen_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityEnter::className(), 'targetAttribute' => ['acen_id' => 'acen_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'acend_id' => 'Acend ID',
            'acen_id' => 'ชื่อกิจกรรม',
            'qrcode' => 'รหัส Qrcode ที่ถูก Generate ออกไป',
            'acend_date' => 'วันที่ทำกิจกรรม',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcen()
    {
        return $this->hasOne(ActivityEnter::className(), ['acen_id' => 'acen_id']);
    }
}
