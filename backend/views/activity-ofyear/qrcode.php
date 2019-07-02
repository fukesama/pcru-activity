<?php

use yii\helpers\Html;
use kartik\helpers\Html as Html2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;
use yii\web\View;
use yii\helpers\Json;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use yii\bootstrap4\Modal;
use frontend\models\ActivityOfyear;
use frontend\models\Activity;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ActivityOfyearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'รายงานคิวอาร์โค้ด';

?>
<div class="activity-ofyear-qrcode">
	<?php $form = ActiveForm::begin(); ?>

	<div class="container-fluid ">
		<div class="card card-stats">
			<div class="card-header" data-background-color="gray">

				<i class="fa fa-qrcode"  style="display:block;float:left;"></i>
				<h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
					<?= Html::encode($this->title) ?>
				</h4>
			</div>
			<br><br>
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">

					<?php
				
					$data=ArrayHelper::map(ActivityOfyearDetail::find()->all(),'acoyd_id',function($model){return $model->acoyd_id.' - '.$model->acoy->ac->ac_name;});
					echo Select2::widget([
						'name' => 'acoyd_id',
						'data' => $data,
						'id'=>'ac_of_year',
						'size' => Select2::MEDIUM,
						'pluginOptions' => [
							'allowClear' => true,  'initialize' => true,
						],
						'options' => [
							'placeholder' => 'เลือกกิจกรรม',  'initialize' => true,
						],

						'addon' => [
							'prepend' => [
								'content' => 'รหัสกิจกรรม'
							],

						]
					]
				);


				?>



			</div>

		</div><br>
		<style type="text/css">
		#num span,#num div {
			font-weight: bold;
			float: left;
			display: inline-block;
			margin-left: 2px;
			margin-right:2px;
		}
		#num span{
			margin-top: 8px
		}
		</style>
		<div class="row">
			<div class="col-lg-4 col-lg-offset-2">
				<span>วันที่เริ่มกิจกรรม : </span>
				<span id='ac_startdate'></span>
			</div>
			<div class="col-lg-4 ">
				<span>วันทีสิ้นสุดกิจกรรม : </span>
				<span id='ac_enddate'></span>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<span>จำนวนที่มี  </span>
				<?= Html::textInput('qr_now', 0, ['class' => 'form-control','id'=>'qr_now','style'=>'text-align: right;font-weight:bold','readonly'=>true]) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<span>เพิ่ม </span>
				<div id="text2" >
					<?= Html::textInput('qr_num_plus', 0, ['class' => 'form-control numOnly','id'=>'qr','style'=>'text-align: right;background-color:#ffc7c7;font-weight:bold']) ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<span>รวมเป็น</span>
				<div id='text3'>
					<?= Html::textInput('total', 0, ['class' => 'form-control','id'=>'total','style'=>'text-align: right;font-weight:bold','readonly'=>true]) ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<center>

					<?= Html::submitButton('Generate', ['class' => 'btn btn-success','disabled'=>true]) ?>
				</center>
			</div>
		</div>

	</div>
</div></div>
<?php ActiveForm::end(); ?>
<?php
$url=Url::to(["ac"]);;
$csrf=Yii::$app->request->getCsrfToken();
$js=
<<<JS

function sum(){
	var num1=Number($('#qr_now').val());
	var num2=Number($('#qr').val());
	var sum=num1+num2;
	$('#total').val(sum);
}
function enabledAc(){
	var val=$('button[type="submit"]');
	if(!$('#ac_of_year').val()=='' && ($('#qr').val()!==''||$('#qr').val()!==0)){
		val.removeAttr('disabled');
		console.log('ac_of_year : ',$('#ac_of_year').val());
		console.log('qr : ',$('#qr').val());
	}
	else{
		val.attr('disabled',true);
		$('#qr_now').val(0);
		$('#ac_startdate').text('');
		$('#ac_enddate').text('');
	}
	qr($('#qr'));
}
function qr(val){
	if(val.val()==0||val.val()==''){
		val.val('');
	}
	sum();
}



$('#qr').on('click keyup',function(){
	qr($(this));
	enabledAc();
}
);
$('#text1').change(function(){
	sum();
}
);
$('#ac_of_year').change(function(c){
	var data={
		acoy_id: $(this).val()
	};
	console.log(data);
	enabledAc();
	$.ajax({
		url: '$url',
		type: 'post',
		data: data,
		success: function (data) {
			var val=data.data;
			console.log(val);
			$('#qr_now').val(data.data.qr_num);
			$('#ac_startdate').text(data.data.ac_startdate);
			$('#ac_enddate').text(data.data.ac_enddate);
		}
	});
}
);


JS;
$this->registerJs($js,View::POS_READY)
?>
