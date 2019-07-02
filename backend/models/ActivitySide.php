<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "activity_side".
 *
 * @property string $side_id
 * @property string $side_name
 *
 * @property Activity[] $activities
 */
class ActivitySide extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'activity_side';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['side_id'], 'required'],
			[['side_id'], 'string', 'max' => 3],
			[['side_name'], 'string', 'max' => 255],
			[['side_id'], 'unique'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'side_id' => 'รหัสด้านกิจกรรม',
			'side_name' => 'ชื่อด้านกิจกรรม',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getActivities()
	{
		return $this->hasMany(Activity::className(), ['side_id' => 'side_id']);
	}
}
