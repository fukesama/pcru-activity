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
/* @var $model backend\models\ActivityOfyear */
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
			<div class="col-lg-8 col-md-8 col-sm-8">
				<?= $form->field($model, 'acoy_id')->textInput(['maxlength' => true,'readonly'=>true])->label('รหัสกิจกรรมตามปีที่ดำเนินการ') ?>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">


				<?php echo $form->field($model, 'ac_id')->widget(Select2::classname(), [
					'data' => mapdata(\backend\models\Activity::find()->all(), 'ac_id', 'ac_name','ac_id'),
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
		<div class="col-lg-8 col-md-8 col-sm-8">
			<?php
			$year=isset($model->year)?$model->year:date('Y')+543;
			?>
			<?=  $form->field($model, 'year')->dropDownList(GenYear(),['prompt'=>'กรุณาเลือกปีการศึกษา'])->label('ปีการศึกษา');
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4">
			<?php 
			isset($model->ac_startdate)?
			$model->ac_startdate=Yii::$app->Func->dateThai2($model->ac_startdate):(date('Y')+543).date('-m-d');
			?>
			<?= $form->field($model, 'ac_startdate')->textInput()->widget(DatePicker::classname(),[
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
			$model->ac_startdate=Yii::$app->Func->dateThai2($model->ac_enddate):(date('Y')+543).date('-m-d');
			?>
		<?= $form->field($model, 'ac_enddate')->textInput()->widget(DatePicker::classname(),[
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
	<div class="col-lg-2 col-md-2 col-sm-2">
	</div>

</div>

<div class="row">
	<div class="col-lg-2 col-md-2 col-sm-2">
	</div>	
	<div class="col-lg-4 col-md-4 col-sm-4"><br>
		<?=  $form->field($model, 'address_detail')->dropDownList(ArrayHelper::map(\backend\models\ActivityOfyear::find()->all(), 'address_detail', 'address_detail'),['prompt'=>'กรุณาเลือกสถานที่ทำกิจกรรม'])->label('');
		?>
		
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4">
		<?= $form->field($model, 'address_detail')->textArea(['maxlength' => true])->label('สถานที่ทำกิจกรรม') ?>

	</div>
</div>

<div class="row">
	<div class="col-lg-2 col-md-2 col-sm-2"></div>
	<div class="col-lg-8 col-md-8 col-sm-8">
		<?php
		$model->point_per_day=1;
		echo $form->field($model, 'point_per_day')->textInput(['type'=>'number','min'=>1]);
				// echo $form->field($model, 'point_per_day')->widget(kartik\number\NumberControl::classname(), [
				//     'maskedInputOptions' => [
				//
				//         'suffix' => ' หน่วย',
				//         'allowMinus' => false
				//     ],
				//     'options' => $บันทึกOptions,
				//     'displayOptions' => $dispOptions,
				//     'บันทึกInputContainer' => $บันทึกCont
				// ]);
		?>

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
$js=<<<JS


JS;
$this->registerJs($js,View::POS_HEAD);
$js=<<<JS
$("[name='ActivityOfyear[ac_id]'],[name='ActivityOfyear[year]").change(function(){
	var year=$("[name='ActivityOfyear[year]'").val(),ac_id=$("[name='ActivityOfyear[ac_id]']").val(),val;
	val=ac_id!==''&&year!==''?ac_id[0]+year[2]+year[3]+ac_id[1]+ac_id[2]+ac_id[3]+ac_id[4]:'';

	$("[name='ActivityOfyear[acoy_id]']").val(val);
}
);
$('select[name="ActivityOfyear[address_detail]"]').change(
function(){
	
	if($(this).val()==''){
		$('textarea[name="ActivityOfyear[address_detail]"]').val('');
		$('textarea[name="ActivityOfyear[address_detail]"]').removeAttr('disabled');
		console.log('none disabled');
	}
	else{
		$('textarea[name="ActivityOfyear[address_detail]"]').val('');
		$('textarea[name="ActivityOfyear[address_detail]"]').attr('disabled','disabled');
		console.log('disabled');
	}
}
)
$('textarea[name="ActivityOfyear[address_detail]"]').change(
function(){
	
	if($(this).val()==''){
		$('select[name="ActivityOfyear[address_detail]"]').val('');
		$('select[name="ActivityOfyear[address_detail]"]').removeAttr('disabled');
	}
	else{
		$('select[name="ActivityOfyear[address_detail]"]').attr('disabled','disabled');
	}
}
)

JS;
$this->registerJs($js,View::POS_READY);
$js=<<<JS
$("[name='ActivityOfyear[year]']").val("$year");
$('[name~="acoy_id"]').css('pointer-events','none');
JS;
$this->registerJs($js,View::POS_END);

?>
