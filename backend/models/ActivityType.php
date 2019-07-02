<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "activity_type".
 *
 * @property string $type_id
 * @property string $type_name
 *
 * @property Activity[] $activities
 */
class ActivityType extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'activity_type';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['type_id'], 'required'],
			[['type_id'], 'string', 'max' => 3],
			[['type_name'], 'string', 'max' => 255],
			[['type_id'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'type_id' => 'รหัสสาขา',
			'type_name' => 'ชื่อสาขา',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getActivities()
	{
		return $this->hasMany(Activity::className(), ['type_id' => 'type_id']);
	}
}
