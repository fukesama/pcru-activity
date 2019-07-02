<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "viewreportproject2".
 *
 * @property int $acend_id
 * @property int $acen_id ชื่อกิจกรรม
 * @property string $acend_date วันที่ทำกิจกรรม
 * @property int $acoyd_id รหัสกิจกรรมประจำปิการศึกษา
 * @property int $co_id รหัสนักศึกษา
 * @property int $pre_id คำนำหน้า
 * @property string $uc_fname ชื่อ
 * @property string $uc_lname นามสกุล
 * @property int $faculty_id คณะ
 * @property string $branch_id สาขา
 * @property string $username
 */
class Viewreportproject2 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'viewreportproject2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acend_id', 'acen_id', 'acoyd_id', 'co_id', 'pre_id', 'faculty_id'], 'integer'],
            [['acend_date', 'username'], 'required'],
            [['acend_date'], 'safe'],
            [['uc_fname', 'uc_lname', 'username'], 'string', 'max' => 255],
            [['branch_id'], 'string', 'max' => 4],
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
            'acend_date' => 'วันที่ทำกิจกรรม',
            'acoyd_id' => 'รหัสกิจกรรมประจำปิการศึกษา',
            'co_id' => 'รหัสนักศึกษา',
            'pre_id' => 'คำนำหน้า',
            'uc_fname' => 'ชื่อ',
            'uc_lname' => 'นามสกุล',
            'faculty_id' => 'คณะ',
            'branch_id' => 'สาขา',
            'username' => 'Username',
        ];
    }
}
