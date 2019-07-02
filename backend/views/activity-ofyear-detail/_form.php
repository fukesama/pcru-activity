<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

// use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Json;

use \yii\web\Request;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use kartik\widgets\TimePicker;

use yii\bootstrap4\Modal;

use kartik\number\NumberControl;
use karatae99\datepicker\DatePicker;

use yii\jui\AutoComplete;
use yii\web\JsExpression;
$dispOptions = ['class' => 'form-control kv-monospace'];

$บันทึกOptions = [
	'type' => 'text',
	'label'=>'<label>บันทึกd Value: </label>',
	'class' => 'kv-บันทึกd',
	'readonly' => true,
	'tabindex' => 1000
];

$บันทึกCont = ['class' => 'kv-บันทึกd-cont'];

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityOfyearDetail */
/* @var $form yii\widgets\ActiveForm */
function mapdata($data,$id,$name,$no){
	return Yii::$app->Func->MapDataDropDown($data,$id,$name,$no);
}
function GenYear(){
	return Yii::$app->Func->GenYear();
}
?>

<div class="activity-ofyear-form">

	<div class="container-fluid">
		<?php $form = ActiveForm::begin(); ?>

		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>			
		</div>

		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">


				<?php echo $form->field($model, 'acoy_id')->widget(Select2::classname(), [
					'data' => ArrayHelper::map(\backend\models\ActivityOfyear::find()->all(), 'acoy_id', function($model){return $model->acoy_id.' - '.$model->ac->ac_name;},'ac.cate.cate_name'),
					'options' => ['placeholder' => 'กรุณาเลือกกิจกรรม'],
					'pluginOptions' => [
						'allowClear' => true
					],
				]
			)->label('กิจกรรม'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4">
			<?php 
		
			isset($model->ac_startdate)?
			$model->ac_startdate=$model->ac_startdate:$model->ac_startdate=(date('Y')+543).date('-m-d');
			?>
			<?= $form->field($model, 'ac_startdate')->widget(DatePicker::classname(),[
				'language' =>'TH',
				'id'=>'ac_startdate',
				'name' => 'ac_startdate',
				'attribute' => 'ac_startdate',				
				
				'template' => '{addon}{input}',
				'language' => 'th', 
				'clientOptions' => [
					'autoclose' => true,
					'format' => 'yyyy-mm-dd'
				]
			]
		) ?>
	</div>

	<div class="col-lg-4 col-md-4 col-sm-4">
		<?php 		
		isset($model->ac_enddate)?
		$model->ac_enddate=$model->ac_enddate:$model->ac_enddate=(date('Y')+543).date('-m-d');
		?>
		<?= $form->field($model, 'ac_enddate')->widget(DatePicker::classname(),[
			'id'=>'ac_enddate',
			'name' => 'ac_enddate',
			'attribute' => 'ac_enddate',
			'template' => '{addon}{input}',
			'language' => 'th', 
			'clientOptions' => [
				'autoclose' => true,
				'format' => 'yyyy-mm-dd'
			]


		]
	) ?>
</div>

</div>

<div class="row">
	<div class="col-lg-2 col-md-2 col-sm-2"></div>
	<div class="col-lg-8 col-md-8 col-sm-8">

		<?php $model->isNewRecord?$model->day=1:null ?>
		<?= $form->field($model, 'day')->textInput(['maxlength' => true,'min'=>1,'max'=>2]) ?>
	</div>
</div>

<div class="row">
	<div class="col-lg-2 col-md-2 col-sm-2">
	</div>	
	<div class="col-lg-4 col-md-4 col-sm-4">
		<div class="form-group">
			<label class="control-label" for="activityofyeardetail-address_detail">สถานที่ทำกิจกรรม</label>
		</div>
		<?=  $form->field($model, 'address_detail')->dropDownList(ArrayHelper::map(\backend\models\ActivityOfyearDetail::find()->all(), 'address_detail', 'address_detail'),['prompt'=>'กรุณาเลือกสถานที่ทำกิจกรรม'])->label('');
		?>
		
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4"><br>
		<?= $form->field($model, 'address_detail')->textArea(['maxlength' => true])->label('') ?>

	</div>
</div>

<div class="row">
	<div class="col-lg-2 col-md-2 col-sm-2"></div>
	<div class="col-lg-8 col-md-8 col-sm-8">


		<?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>
	</div>
</div>
<div class="form-group">
	<?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']
) ?>

</div>

<?php ActiveForm::end(); ?>
</div>
</div>
<?php
$year=date('Y')+543;
$js=<<<JS


JS;
$this->registerJs($js,View::POS_HEAD);
$js=<<<JS
$("[name='ActivityOfyearDetail[ac_id]'],[name='ActivityOfyearDetail[year]").change(function(){
	var year=$("[name='ActivityOfyearDetail[year]'").val(),ac_id=$("[name='ActivityOfyearDetail[ac_id]']").val(),val;
	val=ac_id!==''&&year!==''?ac_id[0]+year[2]+year[3]+ac_id[1]+ac_id[2]+ac_id[3]+ac_id[4]:'';

	$("[name='ActivityOfyearDetail[acoyd_id]']").val(val);
}
);
$('select[name="ActivityOfyearDetail[address_detail]"]').change(
function(){
	
	if($(this).val()==''){
		$('textarea[name="ActivityOfyearDetail[address_detail]"]').val('');
		$('textarea[name="ActivityOfyearDetail[address_detail]"]').removeAttr('disabled');
		console.log('none disabled');
	}
	else{
		$('textarea[name="ActivityOfyearDetail[address_detail]"]').val('');
		$('textarea[name="ActivityOfyearDetail[address_detail]"]').attr('disabled','disabled');
		console.log('disabled');
	}
}
)
$('textarea[name="ActivityOfyearDetail[address_detail]"]').change(
function(){
	
	if($(this).val()==''){
		$('select[name="ActivityOfyearDetail[address_detail]"]').val('');
		$('select[name="ActivityOfyearDetail[address_detail]"]').removeAttr('disabled');
	}
	else{
		$('select[name="ActivityOfyearDetail[address_detail]"]').attr('disabled','disabled');
	}
}
)
$('[name$="date]"]').change(
function(){
	// alert('day'+(range));

	var now = new Date();
	if((now < new Date(sdate)) || (now < new Date(edate))){
		alert('คุณเลือกวันที่ผ่านมาแล้ว');		
		return false;
	}
	if($year!=($(this).val().split('-'))[0]){
		alert('วันที่ที่ท่านเลือกไม่เป็นปีปัจจุบัน');
		return false;
	}
	var sdate=$('[name="ActivityOfyearDetail[ac_startdate]"]').val();
	var edate=$('[name="ActivityOfyearDetail[ac_enddate]"]').val();
	if(new Date(sdate) > new Date(edate)){
		alert('วันที่เริ่มต้นต้องน้อยกว่าวันที่สิ้นสุด');
		console.log(sdate);
		return false;
	}
	if(sdate!=''&& edate!=''){
		var sdate=new Date(sdate);
		var edate=new Date(edate);
		var range=new Date(edate-sdate)/ (1000 * 60 * 60 * 24);
		$('#activityofyeardetail-day').val(range+1);


	}
	
}
);
$('#activityofyeardetail-day').change(
function(){
	var sdate=new Date(sdate);
	var edate=new Date(edate);
	var range=new Date(edate-sdate)/ (1000 * 60 * 60 * 24);
	if($(this).val()>(range+1)){
		alert('คุณกรอกวันที่มากกว่าวันที่สามารถกรอกได้');
	}
	else if($(this).val()<(range+1)){
		alert('คุณกรอกวันที่น้อยกว่าวันที่สามารถกรอกได้');
	}
}
);

JS;
$this->registerJs($js,View::POS_READY);
$js=<<<JS
$('[name~="acoyd_id"]').css('pointer-events','none');
JS;
$this->registerJs($js,View::POS_END);

?>
