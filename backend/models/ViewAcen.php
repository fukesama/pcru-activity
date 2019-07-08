<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "view_acen".
 *
 * @property int $acen_id รหัสการเข้าร่วมกิจกรรม
 * @property int $acoyd_id รหัสกิจกรรมประจำปิการศึกษา
 * @property string $username
 * @property string $pre_name ชื่อคำนำหน้า
 * @property string $uc_fname ชื่อ
 * @property string $uc_lname นามสกุล
 * @property string $faculty_name
 * @property string $branch_name ชื่อสาขา
 * @property int $co_id รหัสนักศึกษา
 */
class ViewAcen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'view_acen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acen_id', 'acoyd_id', 'co_id'], 'integer'],
            [['username', 'faculty_name', 'branch_name'], 'required'],
            [['username', 'pre_name', 'uc_fname', 'uc_lname', 'faculty_name', 'branch_name'], 'string', 'max' => 255],
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
            'username' => 'Username',
            'pre_name' => 'ชื่อคำนำหน้า',
            'uc_fname' => 'ชื่อ',
            'uc_lname' => 'นามสกุล',
            'faculty_name' => 'Faculty Name',
            'branch_name' => 'ชื่อสาขา',
            'co_id' => 'รหัสนักศึกษา',
        ];
    }
}
