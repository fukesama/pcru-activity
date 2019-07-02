<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Branch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="branch-form">

	<div class="container-fluid">
		<?php $form = ActiveForm::begin(); ?>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">
			- 	<?php 
				if(!isset($model->branch_id)){
					$model->branch_id=backend\models\Branch::find()->count()+1;
				}

				?>
				<?= $form->field($model, 'branch_id')->textInput(['maxlength' => true,'placeholder'=>'โปรดกรอกรหัสสาขา' 
					,'min'=>3,'max'=>3
					// 'readonly'=> $model->isNewRecord?false:true
			]) ?> 

			</div>
		</div> 
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true,'placeholder'=>'โปรดกรอกชื่อสาขา']) ?>

		</div>
	</div>
	<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8">



			<?= $form->field($model, 'faculty_id')->textInput(['maxlength' => true])
			->widget(kartik\select2\Select2::className(),
				[
					'data'=>ArrayHelper::map(backend\models\Faculty::find()
						->all(),'faculty_id','faculty_name'),
					'options'=>[
						'placeholder'=>'โปรดเลือกคณะ','required'=>'true',
					],
					'pluginOptions'=>['allowClear'=>true]
				]
			)->label('คณะ')  ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8">

			<?= $form->field($model, 'edub_id')->textInput(['maxlength' => true])
			->widget(kartik\select2\Select2::className(),
				[
					'data'=>ArrayHelper::map(backend\models\EduBackground::find()
						->all(),'edub_id','edub_name'),

					'options'=>[
						'placeholder'=>'โปรดเลือกหลักสูตร','required'=>'true',

					],
					'pluginOptions'=>['allowClear'=>true,'value'=>$model->edub_id,]
				]
			)->label('ชื่อหลักสูตร')  ;?>
		</div>
	</div>




	<div class="form-group">
		<?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>

	</div>

	<?php ActiveForm::end(); ?>
</div>
</div>
