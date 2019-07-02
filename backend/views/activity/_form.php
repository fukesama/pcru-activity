<?php

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


function mapdata($data,$id,$name,$no){
	return Yii::$app->Func->MapDataDropDown($data,$id,$name,$no);
}

/* @var $this yii\web\View */
/* @var $model backend\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>
<style media="screen">
	.nowarp{
		display: block;float: left;width: 30px;
		text-align: right;
		border:1px solid #D7D7D7;
	}

	div label.control-label{
		font-size: 14px;float: left;
	}
</style>
<div class="activity-form">

	<div class="container-fluid">
		<?php $form = ActiveForm::begin(); ?>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-push-0"></div>

			<div class="col-lg-3 col-md-3 col-sm-6">
				<label class="control-label" for="activity-cate_id" style="font-size: 16px">รหัสกิจกรรม</label>
				<br><br>
				<div class="nowarp"><input type="text" name="dp[1]" class="form-control"  readonly></div>
				<div class="nowarp"><input type="text" name="dp[2]" class="form-control"  readonly ></div>
				<div class="nowarp"><input type="text" name="dp[3]" class="form-control"  readonly></div>

				<div class="nowarp" >
					<input type="text" name="dp[4]" class="form-control"  readonly >
				</div>
			</div>

		</div>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">
				<?php echo $form->field($model, 'ac_name')->textInput(['placeholder'=>'กรุณากรอกชื่อกิจกรรม/โครงการ','maxlength' => true]) ?>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">
				<label class="control-label" for="activity-cate_id">ผู้รับผิดชอบกิจกรรม</label><br><br>
				<div>
					<?php echo $form->field($model, 'cate_id')->widget(Select2::classname(), [
						'data' => ArrayHelper::map(\backend\models\ActivityCate::find()->all(), 'cate_id', 
							function($model){
								return $model->cate_id.' - '.$model->cate_name;
							}
						)

						,'options' => ['placeholder' => 'กรุณาเลือกผู้รับผิดชอบกิจกรรม'],
						'pluginOptions' => [
							'allowClear' => true
						],
					])->label(false);
					?>
				</div>
			</div>
		</div>
		

		
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">
				<?php echo $form->field($model, 'type_id')->dropDownList(MapData(\backend\models\ActivityType::find()->all(), 'type_id', 'type_name','type_id'),['prompt'=>'กรุณาเลือกชนิดของกิจกรรม']) ?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">
				<?php echo $form->field($model, 'side_id')->dropDownList(MapData(\backend\models\ActivitySide::find()->all(), 'side_id', 'side_name','side_id'),['prompt'=>'กรุณาเลือกด้านของกิจกรรม']) ?>
			</div>
		</div>


		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">
				<?php echo $form->field($model, 'ac_id')->textInput([])->label(false) ?>
			</div>
		</div>
		

		
		<div class="row">
			<div class="col-lg-2 col-md-2 col-sm-2">
			</div>
			<div class="col-lg-8 col-md-8 col-sm-8">			
				<?php 
				$ac_num=$model->ac_num;
				echo $form->field($model, 'ac_num')->dropDownList([],['prompt'=>'กรุณากรอกลำดับกิจกรรม'])->label('ลำดับกิจกรรม'); ?>
			</div>
		</div>
		
	</div>

	<div class="form-group">
		<?php echo Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>
	
</div>
<?php
$url=Url::to('number');
$Csrf=Yii::$app->request->getCsrfToken();
$js=<<<JS
function addNum(val){
	if(val.length==1){
		val='0'.concat(val);
	}
	return val;
}
function sumCode(){
	var code=$("[name='dp[1]']").val()+$("[name='dp[2]']").val()+$("[name='dp[3]']").val()+$("[name='dp[4]']").val();
	$('#activity-ac_id').val(code);
}
function _1st(){
	$("[name='dp[1]']").val($("[name*='Activity[cate_id]']").val());
	$("[name='dp[2]']").val($("[name*='Activity[type_id]']").val());
	$("[name='dp[3]']").val($("[name*='Activity[side_id]']").val());
	$("[name='dp[4]']").val($("[name*='Activity[ac_num]']").val());
	sumCode();
}
function _2nd(val){
	$("[name='dp[4]']").val(addNum(val));
	sumCode();
}
function getData(){

	
	var cate_id=$("[name*='Activity[cate_id]']").val();
	var type_id=$("[name*='Activity[type_id]']").val();
	var side_id=$("[name*='Activity[side_id]']").val();
	var ac_name=$("[name*='Activity[ac_name]']").val();
	$.ajax(
	{
		url: '$url',
		type: 'post',
		data: {
			cate_id:cate_id , 
			type_id:type_id , 
			side_id:side_id , 
			ac_name:ac_name , 
			_csrf : '$Csrf'
		}
		,
		success: function (data) {
			

			var result='<option value="">กรุณากรอกลำดับกิจกรรม</option>';
			var keys = Object.keys(data.res);
			keys.forEach(function(key){
				var res= data.res[key];
				result+='<option value="'+key+'" ';
				if('$ac_num'==key){
					result+='selected';
				}
				result+=' >'+res+'</option>';
			}
			);
			$('#activity-ac_num').html(result);
		}
	}
	);

}


JS;
$this->registerJs($js,View::POS_HEAD);

$js=<<<JS

_1st();
_2nd($("[name*='Activity[ac_num]']").val());
$("[name='edu_level']").change(function(){
	_1st();
}
);

$("[name^='Activity']").change(function(){
	_1st();
}
);
$("#activity-cate_id, #activity-type_id, #activity-side_id, #activity-ac_name").change(
function(){
	_1st();
	var cate_id=$("[name*='Activity[cate_id]']").val();
	var type_id=$("[name*='Activity[type_id]']").val();
	var side_id=$("[name*='Activity[side_id]']").val();
	var ac_name=$("[name*='Activity[ac_name]']").val();
	if(cate_id!=''&&type_id!=''&&side_id!=''&&ac_name!=''){		
		getData();
	}
	else{
		$('#activity-ac_num').html('<option value="">กรุณากรอกลำดับกิจกรรม</option>');
	}
}
)
$("[name='Activity[ac_num]']").change(function(){
	_2nd($(this).val());
	console.log($(this).val());
}
);




JS;
$this->registerJs($js,View::POS_READY);
$js=<<<JS
$("[name='dp[4]']").val($("[name*='Activity[ac_num]']").val());
console.log($("[name*='Activity[ac_num]']").val());
getData();
JS;
$this->registerJs($js,View::POS_END);

?>