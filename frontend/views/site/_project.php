<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\ActivityOfyearDetail;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityOfyearDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-ofyear-detail-search">
	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

	<div class="container-fluid">
		<div class="row" style="border:2px solid green;border-radius: 5px">	
			<div class="col-md-1" ></div>
			<div class="col-md-4">

				<?= $form->field($model, 'ac_id')->widget(kartik\select2\Select2::classname(),[
						
						'data' => ArrayHelper::map(backend\models\Activity::find()->all(),'ac_id',function($model){return $model->ac_name;},'cate.cate_name'),
						'options' => [
							'placeholder' => 'เลือกกิจกรรม',						
						],
						'pluginOptions' => [
							'allowClear' => true								
						],
					])->label('กิจกรรม') ?>

			</div>
			<div class="col-md-4">	
				<?php
				echo $form->field($model, 'year')->dropDownList(
					ArrayHelper::map(Yii::$app->db->createCommand('SELECT DISTINCT SUBSTRING(ac_startdate, 1, 4) AS year FROM `activity_ofyear_detail` ORDER BY `year` DESC')->queryAll(),'year','year'
				)
					,
					['prompt'=>'กรุณาเลือกปี']
				)->label('ปี') ?>

			</div>	
			<div class="col-md-3">
				<div class="form-group">
					<?= Html::submitButton('ค้นหา', ['class' => 'btn btn-success']) ?>
					<?= Html::resetButton('รีเซ็ต', ['class' => 'btn btn-default']) ?>
				</div>
			</div>
		</div>
	</div>











	<?php // echo $form->field($model, 'detail') ?>



	<?php ActiveForm::end(); ?>

</div>
