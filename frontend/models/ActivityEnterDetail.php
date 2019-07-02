<?php

namespace frontend\models;

use Yii;

/**
* This is the model class for table "activity_enter_detail".
*
* @property int $acend_id
* @property int $acen_id
* @property int $co_id
* @property string $qrcode
* @property string $acend_date
* @property string $acend_starttime
* @property string $acend_endtime
*
* @property ActivityEnter $acen
* @property UserCollegian $co
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
            [['acend_id', 'acen_id'], 'integer'],
            [['acend_date'], 'safe'],
            [['qrcode'], 'string', 'max' => 20],
            [['acend_id'], 'unique'],
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
            'acen_id' => 'Acen ID',
            'co_id' => 'Co ID',
            'qrcode' => 'Qrcode',
            'acend_date' => 'Acend Date',

        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAcen()
    {
        return $this->hasOne(ActivityEnter::className(), ['acen_id' => 'acen_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCo()
    {
        return $this->hasOne(UserCollegian::className(), ['user_id' => 'co_id']);
    }
}
