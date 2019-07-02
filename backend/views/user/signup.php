<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Json;

use \yii\web\Request;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use backend\models\User;
use backend\models\UserOfficer;
use backend\models\UserCollegian;
use backend\models\Branch;



?>
<div class="container-fluid" >

	<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
	<?php
	if(isset($model->id)) {


		if($model->level_user=='1'){
			$muo=UserOfficer::find()->where(['user_id'=>$model->id])->one();
			$modeluo->pre_id=$muo->pre_id;
			$modeluo->uo_fname=$muo->uo_fname;
			$modeluo->uo_lname=$muo->uo_lname;

			$modeluc->pre_id=$muo->pre_id;
			$modeluc->uc_fname=$muo->uo_fname;
			$modeluc->uc_lname=$muo->uo_lname;
		}
		else if($model->level_user=='2'){
			$muc=UserCollegian::find()->where(['user_id'=>$model->id])->one();

			$modeluc->pre_id=$muc->pre_id;
			$modeluc->uc_fname=$muc->uc_fname;
			$modeluc->uc_lname=$muc->uc_lname;
			$modeluc->faculty_id=$muc->faculty_id;
			$modeluc->branch_id=$muc->branch_id;
			$modeluc->address=$muc->address;

			$modeluo->pre_id=$muc->pre_id;
			$modeluo->uo_fname=$muc->uc_fname;
			$modeluo->uo_lname=$muc->uc_lname;
		}
		$model->password_hash='';
	}
	?>
	<?php 
	// $model->username='581102064117';
	// $model->password_hash='3154';
	// $model->level_user='2';
	// $modeluc->pre_id='1';
	// $modeluc->uc_fname='dfgsdfg';
	// $modeluc->uc_lname='zvzxcv';
	// $modeluc->faculty_id=2;
	// $modeluc->branch_id=169;
	// $modeluc->address='sdf';
	?>
	<div class="row">
		<div class="row" name='' <?= $model->isNewRecord?'':'style="display:none"' ?>>
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">

				<?= $form->field($model, 'level_user')
				->dropdownList(Yii::$app->Func->ArrayLevel(),['prompt'=>'เลือก','id'=>'level_user'])->label('ระดับผู้ใช้') ?>
			</div>
		</div>

	</div>
	<div class="row" name='officerRow' style="display:none">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 ">
			<?php $data=ArrayHelper::map(\backend\models\Prefix::find()->orderBy(['pre_id'=>SORT_ASC])->all(), 'pre_id', 'pre_name'); ?>
			<?= $form->field($modeluo, 'pre_id')->dropDownList($data,[ 'disabled' => 'disabled','prompt'=>'โปรดเลือกคำนำหน้า'])->label('คำนำหน้า');?>
		</div>
	</div>

	<div class="row" name='officerRow' style="display:none">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 ">

			<?= $form->field($modeluo, 'uo_fname')->textInput([ 'disabled' => 'disabled','placeholder'=>'โปรดกรอกชื่อ'])->label('ชื่อ')?>

		</div>


	</div>
	<div class="row" name='officerRow' style="display:none">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8">
			<?= $form->field($modeluo, 'uo_lname')->textInput([ 'disabled' => 'disabled','placeholder'=>'โปรดกรอกสกุล'])->label('สกุล')?>
		</div>
	</div>
	<div class="row" name='collegianRow' style="display:none">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8 ">

			<?= $form->field($modeluc, 'pre_id')->dropDownList($data,[ 'disabled' => 'disabled','prompt'=>'โปรดเลือกคำนำหน้า'])->label('คำนำหน้า')?>

		</div>


	</div>
	<div class="row" name='collegianRow' style="display:none">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8">
			<?= $form->field($modeluc, 'uc_fname')->textInput([ 'disabled' => 'disabled','placeholder'=>'โปรดกรอกชื่อ'])->label('ชื่อ')?>
		</div>
	</div>
	<div class="row" name='collegianRow' style="display:none">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8">
			<?= $form->field($modeluc, 'uc_lname')->textInput([ 'disabled' => 'disabled','placeholder'=>'โปรดกรอกสกุล'])->label('สกุล')?>
		</div>

	</div>

	<div class="row" name='collegianRow' style="display:none">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8">
			
			<?= $form->field($modeluc, 'faculty_id')->textInput(['maxlength' => true])
			->widget(kartik\select2\Select2::className(),
				[
					'data'=>ArrayHelper::map(backend\models\Faculty::find()
						->all(),'faculty_id','faculty_name'),
					'options'=>[
						'placeholder'=>'โปรดเลือกคณะ','required'=>'true',
						'id'=>'ddl-faculty',
					],

					'pluginOptions'=>['allowClear'=>true]
				]
			)->label('คณะ')  ?>
		</div>
	</div>
	<div class="row" name='collegianRow' style="display:none">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-8 col-md-8 col-sm-8">
			<?php $uc=ArrayHelper::map(backend\models\Branch::find()->where(['faculty_id'=>$modeluc->faculty_id])
			->all(),'branch_id','branch_name') ?>
			<?= $form->field($modeluc, 'branch_id')->widget(DepDrop::classname(), [
				'options'=>['id'=>'ddl-branch'],
				'data'=> $modeluc->faculty_id!==null?$uc:[],
				'type'=>DepDrop::TYPE_SELECT2,
				'pluginOptions'=>[
					'initialize' => false,
					'depends'=>['ddl-faculty'],
					'placeholder'=>'โปรดเลือกสาขา',
					'url'=>Url::to(['/user/get-branch'])
				]
			]
		)->label('สาขา'); ?>
	</div>

</div>

<div class="row" name='collegianRow' style="display:none">
	<div class="col-lg-2 col-md-2 col-sm-2">
	</div>
	<div class="col-lg-8 col-md-8 col-sm-8">
		<?= $form->field($modeluc, 'address')->textarea([ 'disabled' => 'disabled','rows' => '6','style' => 'resize:none'])->label('ที่อยู่')?>
	</div>

</div>
<div class="row" name='user' style="display:none">
	<div class="col-lg-2 col-md-2 col-sm-2">
	</div>
	<div class="col-lg-8 col-md-8 col-sm-8">
		<?= $form->field($model, 'username')->textInput(['placeholder'=>'โปรดกรอกชื่อผู้ใช้'])->label('ชื่อผู้ใช้') ?>
	</div>
</div>
<div class="row" name='user' style="display:none">
	<div class="col-lg-2 col-md-2 col-sm-2">
	</div>
	<div class="col-lg-8 col-md-8 col-sm-8">
		<div class="row">
			<div class="col-lg-1 col-md-1 col-sm-1" align='right'>
				<div class='form-group'>
					<label class='control-label'>กำหนด</label>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="cPass">
							<span class="checkbox-material" name="cPass">
								<!-- <span class="check"></span> -->
							</span>
						</label>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-9 col-sm-9">
				<?php
				$text='';
				if(!isset($model->id)){
					$text='โปรดกรอกรหัสผ่าน Default:12345678';
				}
				echo $form->field($model, 'password_hash')->passwordInput(['disabled'=>'true','placeholder'=>$text])->label('รหัสผ่าน') ?>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2">
				<br><br>
				<?= Html::checkbox('reveal-password', false, ['id' => 'reveal-password']) ?>
				<?= Html::label('แสดงรหัสผ่าน', 'reveal-password') ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
			<?= Html::submitButton('บันทึก', ['class' => 'btn btn-success', 'name' => 'signup-button']) ?>
		</div>
	</div>
</div>
<?php ActiveForm::end(); ?>
</div>


<?php
$this->registerJs("$('#reveal-password').change(function(){
	$('#user-password_hash').attr('type',this.checked?'text':'password');
}
)");
$js=<<<JS
function isUndefined(x) {
	var d;
	return x === d;
}
function eUser(val){
	if(val==='1'){
		$("div[name='officerRow']").show();
		$("div[name='collegianRow']").hide();
		$("input[name^='UserOfficer'],select[name^='UserOfficer']").removeAttr('disabled');
		$("input[name^='UserCollegian']").attr('disabled','disabled');
	}
	else if(val==='2'){
		$("div[name='collegianRow']").show();
		$("div[name='officerRow']").hide();
		$("input[name^='UserCollegian'],textarea[name^='UserCollegian'],select[name^='UserCollegian'],#ddl-branch").removeAttr('disabled');
		$("input[name^='UserOfficer'],select[name^='UserOfficer']").attr('disabled','disabled');
	}
	else {
		$("div[name='officerRow'],div[name='collegianRow']").hide();
		$("input[name^='UserOfficer'],input[name^='UserCollegian'],textarea[name^='UserCollegian'],select[name^='UserOfficer'],select[name^='UserCollegian'],#ddl-branch").attr('disabled','disabled');
	}
	if($.inArray(val,['0','1','2'])!==-1) {
		$("div[name='user']").show();
		$('#user-password_hash').attr('disabled',true);
	}
	else{

		$("div[name='user']").hide();
		$('#user-password_hash').removeAttr('disabled');
	}
}
function changeBranch(val){
    // alert(val);
	if(val!==''||val!==undefined){
		$('#ddl-branch').removeAttr('disabled');
	}
	else{
		$('#ddl-branch').attr('disabled','disabled');
	}
}

JS;
$this->registerJs($js,View::POS_BEGIN);
$js=<<<JS

$('#level_user').on('change',function(){
	eUser($(this).val())
}
);
$('[name="cPass"]').on('click',function(){
	if(this.checked) {
        //Do stuff
		$("#user-password_hash").removeAttr('disabled');
		$("[name='User[password]']").removeAttr('disabled');
	}
	else{
		$("#user-password_hash").attr('disabled','disabled');
		$("[name='User[password]']").attr('disabled','disabled');
	}
}
);
$('#ddl-faculty').on('change',function(){
	changeBranch($(this).val());
}
);
JS;
$this->registerJs($js,View::POS_READY);
$fac=$modeluc->faculty_id!==null;
$js=<<<JS

$("#user-password_hash").attr('disabled','disabled');
$("[name='User[password]']").attr('disabled','disabled');
changeBranch($('#ddl-faculty').val());

$(window).on('load',function(){
	changeBranch(!'$fac'?'':true);
	eUser($('#level_user').val());
}
);
JS;
$this->registerJs($js,View::POS_END);
?>
