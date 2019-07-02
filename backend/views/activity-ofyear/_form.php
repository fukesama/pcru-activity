<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityOfyear */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-ofyear-form">

	<div class="container-fluid">
		<?php $form = ActiveForm::begin(); ?>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">

				<?php
				if($model->isNewRecord){
					echo '<div class="form-group"><label class="control-label" for="activityofyear-ac_id">กิจกรรม</label>';
					echo kartik\select2\Select2::widget([
						'name' => 'ac_id',
						'data' => ArrayHelper::map(backend\models\Activity::find()->all(),'ac_id',function($model){return $model->ac_id.' - '.$model->ac_name;},'cate.cate_name'),
						'options' => [
							'placeholder' => 'เลือกกิจกรรม',						
						],
						'pluginOptions' => [
							'allowClear' => true,
							'multiple' => true
						],
					]);
					echo '</div>';
				} 
				else{
					echo $form->field($model, 'ac_id')->widget(kartik\select2\Select2::classname(),[
						
						'data' => ArrayHelper::map(backend\models\Activity::find()->all(),'ac_id',function($model){return $model->ac_id.' - '.$model->ac_name;},'cate.cate_name'),
						'options' => [
							'placeholder' => 'เลือกกิจกรรม',						
						],
						'pluginOptions' => [
							'allowClear' => true								
						],
					]);
				}

				?>					
			</div>
		</div>

		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">
				<?= $form->field($model, 'edu_level')->dropDownList(
					[
						'1'=>'ชั้นปีที่ 1',
						'2'=>'ชั้นปีที่ 2',
						'3'=>'ชั้นปีที่ 3',
						'4'=>'ชั้นปีที่ 4',
						'5'=>'ชั้นปีที่ 5',
					]) ?>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-2 col-md-2 col-sm-2">
				</div>
				<div class="col-lg-8 col-md-8 col-sm-8">
					<?php $model->point=$model->isNewRecord?1:$model->point ?>
					<?= $form->field($model, 'point')->textInput(['maxlength' => true,'type'=>'number']) ?>
				</div>
			</div>
			
			<div class="form-group">
				<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

			</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
