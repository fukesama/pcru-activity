<?php

namespace backend\models;

use Yii;
use yii\web\IdentityInterface;
use \yii\db\ActiveRecord;
use yii\base\Model;
/**
 * This is the model class for table "activity_enter".
 *
 * @property int $acen_id รหัสการเข้าร่วมกิจกรรม
 * @property int $acoyd_id รหัสกิจกรรมประจำปิการศึกษา
 * @property int $co_id รหัสนักศึกษา
 * @property string $enter_status สถานะการเข้าร่วม 1-ยังไม่ได้เข้าร่วม 2-เข้าร่วมแล้ว
 * @property string $result ผลประเมิน
 *
 * @property UserCollegian $co
 * @property ActivityOfyearDetail $acoyd
 * @property ActivityEnterDetail[] $activityEnterDetails
 */
class ActivityEnterReport extends Model
{
	

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
    	return 'activity_enter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
    	return [
    		[['acoyd_id', 'co_id'], 'required'],
    		[['acoyd_id', 'co_id','branch_id','faculty_id'], 'integer'],
    		[['acoyd_id', 'co_id'], 'unique'],
    		[['enter_status', 'result','ver','pre_name','uc_fname','uc_lname','number','group'], 'string'],
    		[['co_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCollegian::className(), 'targetAttribute' => ['co_id' => 'user_id']],
    		[['acoyd_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActivityOfyearDetail::className(), 'targetAttribute' => ['acoyd_id' => 'acoyd_id']],
    		[['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
    		[['faculty_id'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::className(), 'targetAttribute' => ['faculty_id' => 'faculty_id']],
    		[['group'], 'exist', 'skipOnError' => true, 'targetClass' => UserCollegian::className(), 'targetAttribute' => ['co_id' => 'user_id']],
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
    		'enter_status' => 'สถานะการเข้าร่วม',
    		'result' => 'ผลประเมิน',
    	];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCo()
    {
    	return $this->hasOne(UserCollegian::className(), ['user_id' => 'co_id']);
    }
    public function getVer()
    {
    	return $this->hasOne(UserCollegian::className(), ['ver' => 'ver']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcoyd()
    {
    	return $this->hasOne(ActivityOfyearDetail::className(), ['acoyd_id' => 'acoyd_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcen()
    {
    	return $this->hasMany(ActivityEnterDetail::className(), ['acen_id' => 'acen_id']);
    }
}
