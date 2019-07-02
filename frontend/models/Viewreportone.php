<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "viewreportone".
 *
 * @property int $acend_id
 * @property int $acen_id ชื่อกิจกรรม
 * @property string $year
 * @property string $acend_date วันที่ทำกิจกรรม
 * @property int $acoyd_id รหัสกิจกรรมประจำปิการศึกษา
 * @property int $co_id รหัสนักศึกษา
 * @property string $acoy_id
 * @property string $ac_id รหัสกิจกรรม
 * @property string $edu_level ชั้นปี
 * @property int $point หน่วยกิจกรรมต่อวัน
 * @property string $ac_name ชื่อกิจกรรม
 */
class Viewreportone extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'viewreportone';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acend_id', 'acen_id', 'acoyd_id', 'co_id', 'point'], 'integer'],
            [['acend_date', 'ac_id', 'edu_level', 'point', 'ac_name'], 'required'],
            [['acend_date'], 'safe'],
            [['year'], 'string', 'max' => 4],
            [['acoy_id'], 'string', 'max' => 8],
            [['ac_id'], 'string', 'max' => 7],
            [['edu_level'], 'string', 'max' => 1],
            [['ac_name'], 'string', 'max' => 255],
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
            'year' => 'Year',
            'acend_date' => 'วันที่ทำกิจกรรม',
            'acoyd_id' => 'รหัสกิจกรรมประจำปิการศึกษา',
            'co_id' => 'รหัสนักศึกษา',
            'acoy_id' => 'Acoy ID',
            'ac_id' => 'รหัสกิจกรรม',
            'edu_level' => 'ชั้นปี',
            'point' => 'หน่วยกิจกรรมต่อวัน',
            'ac_name' => 'ชื่อกิจกรรม',
        ];
    }
}
