<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Activity;
/* @var $this yii\web\View */
/* @var $model frontend\models\Files */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="files-form">

	<div class="container-fluid">
		<?php $form = ActiveForm::begin(); ?>

		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">
				<?= $form->field($model, 'file')->fileInput(['class'=>''])->label('') ?>
			</div>
		</div>
		<div class="form-group">
			<?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>

		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>
<?php 

 ?>
