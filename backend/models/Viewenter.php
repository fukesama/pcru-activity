<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "viewenter".
 *
 * @property int $acen_id รหัสการเข้าร่วมกิจกรรม
 * @property int $acoyd_id รหัสกิจกรรมประจำปิการศึกษา
 * @property int $co_id รหัสนักศึกษา
 * @property string $enter_status สถานะการเข้าร่วม 1-ยังไม่ได้เข้าร่วม 2-เข้าร่วมแล้ว
 * @property string $result ผลประเมิน
 * @property string $acoy_id
 * @property string $ac_startdate วันที่เริ่มกิจกรรม
 * @property string $ac_enddate วันที่สินสุดกิจกรรม
 * @property string $address_detail สถานที่ทำกิจกรรม
 * @property string $ac_id รหัสกิจกรรม
 * @property string $ac_name ชื่อกิจกรรม
 * @property int $pre_id คำนำหน้า
 * @property string $uc_fname ชื่อ
 * @property string $uc_lname นามสกุล
 * @property int $faculty_id คณะ
 * @property string $branch_id สาขา
 * @property string $group หมู่เรียน
 * @property string $ver
 * @property string $number เลขที่
 * @property string $pre_name ชื่อคำนำหน้า
 * @property string $faculty_name
 * @property string $branch_name ชื่อสาขา
 */
class Viewenter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'viewenter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acen_id', 'acoyd_id', 'co_id', 'pre_id', 'faculty_id'], 'integer'],
            [['enter_status', 'result'], 'string'],
            [['ac_startdate', 'ac_enddate', 'ac_id', 'ac_name', 'ver', 'faculty_name', 'branch_name'], 'required'],
            [['ac_startdate', 'ac_enddate'], 'safe'],
            [['acoy_id'], 'string', 'max' => 8],
            [['address_detail', 'ac_name', 'uc_fname', 'uc_lname', 'pre_name', 'faculty_name', 'branch_name'], 'string', 'max' => 255],
            [['ac_id'], 'string', 'max' => 7],
            [['branch_id'], 'string', 'max' => 4],
            [['group'], 'string', 'max' => 10],
            [['ver', 'number'], 'string', 'max' => 2],
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
            'enter_status' => 'สถานะการเข้าร่วม 1-ยังไม่ได้เข้าร่วม 2-เข้าร่วมแล้ว',
            'result' => 'ผลประเมิน',
            'acoy_id' => 'Acoy ID',
            'ac_startdate' => 'วันที่เริ่มกิจกรรม',
            'ac_enddate' => 'วันที่สินสุดกิจกรรม',
            'address_detail' => 'สถานที่ทำกิจกรรม',
            'ac_id' => 'รหัสกิจกรรม',
            'ac_name' => 'ชื่อกิจกรรม',
            'pre_id' => 'คำนำหน้า',
            'uc_fname' => 'ชื่อ',
            'uc_lname' => 'นามสกุล',
            'faculty_id' => 'คณะ',
            'branch_id' => 'สาขา',
            'group' => 'หมู่เรียน',
            'ver' => 'Ver',
            'number' => 'เลขที่',
            'pre_name' => 'ชื่อคำนำหน้า',
            'faculty_name' => 'Faculty Name',
            'branch_name' => 'ชื่อสาขา',
        ];
    }
}
