<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Json;
use \yii\web\Request;
use backend\models\User;
?>
<div class="container-fluid" >
	<div class="row">
		<div class="card col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
			<?php $form = ActiveForm::begin([
				'id' => 'form-signup', 
				'options' => 
				[
					'class' => 'm-t',
					'style'=>'margin-top: 20px; margin-left:20px; margin-right: 20px;',
					'enctype'=>'multipart/form-data'
				]
			]); ?>

			<?= $form->field($model, 'username')->passwordInput(['required'=>'','type'=>'text','oninvalid'=>'this.setCustomValidity("กรุณากรอกรหัสผ่าน")','oninput'=>'this.setCustomValidity("")','readonly'=>true]) ?>

			<?= $form->field($model, 'password_hash')->passwordInput(['value'=>'','required'=>'','oninvalid'=>'this.setCustomValidity("กรุณากรอกรหัสผ่าน")','oninput'=>'this.setCustomValidity("")']) ?>


			<div class="form-group text-left">
				<?= Html::submitButton('<i class="fa fa-check"></i> บันทึกรหัสผ่าน', ['class' => 'btn btn-success', 'name' => 'signup']) ?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>

