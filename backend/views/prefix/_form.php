<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Prefix */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prefix-form">

	<div class="container-fluid">
		<?php $form = ActiveForm::begin(); ?>

		<div class="row" style="display: <?= $model->isNewRecord?'none':'block' ?>">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'pre_id')->textInput(['maxlength' => true,'disabled'=> $model->isNewRecord?true:false]) ?>

		</div>
	</div><div class="row">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'pre_name')->textInput(['maxlength' => true]) ?>

	</div>
</div>        <div class="form-group">
	<?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>

</div>

<?php ActiveForm::end(); ?>
</div>
</div>
