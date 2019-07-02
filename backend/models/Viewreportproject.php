<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "viewreportproject".
 *
 * @property int $acen_id รหัสการเข้าร่วมกิจกรรม
 * @property int $co_id รหัสนักศึกษา
 * @property string $username
 * @property string $enter_status สถานะการเข้าร่วม 1-ยังไม่ได้เข้าร่วม 2-เข้าร่วมแล้ว
 * @property int $pre_id คำนำหน้า
 * @property string $uc_fname ชื่อ
 * @property string $uc_lname นามสกุล
 * @property int $faculty_id คณะ
 * @property string $branch_id สาขา
 * @property int $acoyd_id รหัสกิจกรรมประจำปิการศึกษา
 * @property string $result ผลประเมิน
 */
class Viewreportproject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'viewreportproject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acen_id', 'co_id', 'pre_id', 'faculty_id', 'acoyd_id'], 'integer'],
            [['username'], 'required'],
            [['enter_status', 'result'], 'string'],
            [['username', 'uc_fname', 'uc_lname'], 'string', 'max' => 255],
            [['branch_id'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'acen_id' => 'รหัสการเข้าร่วมกิจกรรม',
            'co_id' => 'รหัสนักศึกษา',
            'username' => 'Username',
            'enter_status' => 'สถานะการเข้าร่วม 1-ยังไม่ได้เข้าร่วม 2-เข้าร่วมแล้ว',
            'pre_id' => 'คำนำหน้า',
            'uc_fname' => 'ชื่อ',
            'uc_lname' => 'นามสกุล',
            'faculty_id' => 'คณะ',
            'branch_id' => 'สาขา',
            'acoyd_id' => 'รหัสกิจกรรมประจำปิการศึกษา',
            'result' => 'ผลประเมิน',
        ];
    }
}
