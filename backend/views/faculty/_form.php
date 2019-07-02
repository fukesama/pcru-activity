<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Faculty */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faculty-form">

	<div class="container-fluid">
		<?php $form = ActiveForm::begin(); ?>

		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">
				<?= $form->field($model, 'faculty_name')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>
