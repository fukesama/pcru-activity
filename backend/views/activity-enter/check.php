<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\select2\Select2;

use yii\helpers\Url;
use \yii\web\Request;
use yii\web\View;
use yii\helpers\Json;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityEnter */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'เช็คชื่อการเข้าร่วมกิจกรรม';
$this->params['breadcrumbs'][] = ['label' => 'การเข้าร่วมกิจกรรม', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
	.mg-top{
		margin-top:0;
		
	}
	.card img{
		width: 50px;height: auto;
		margin-right:auto;
		margin-left:auto;
	}
</style>
<div class="activity-enter-form">
	<form action="" method="post" accept-charset="utf-8">	
		<input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>">
		<div class="container ">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
					<div class="container card mg-top">
						<div class="row">
							<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
								<?php 
								echo Select2::widget([				
									'name' => 'ver',
									'id'=>'ver',
									'data' => ArrayHelper::map(backend\models\UserCollegian::find()->all(),'ver','ver'),
									'options' => ['placeholder' => 'เลือกรุ่น'],
									'pluginOptions' => [
										'allowClear' => true
									],
								]) ?>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<?php echo Select2::widget(
									[						
										'attribute' => 'faculty_id',
										'name' => 'faculty_id',
										'id'=>'fac',							
										'data' => ArrayHelper::map(backend\models\Faculty::find()->all(),'faculty_id','faculty_name'),
										'options' => ['placeholder' => 'เลือกคณะ'],
										'pluginOptions' => [

											'allowClear' => true,

										],
									]
								) ?>
							</div>			
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<?php  echo DepDrop::widget(
									[             
										'id'=>'bra',
										'name' => 'branch_id',		
							// 
										'data'=> ArrayHelper::map(backend\models\Branch::find()->orderBy(['faculty_id'=>SORT_ASC,'branch_id'=>SORT_ASC])->all(),'branch_id','branch_name'),
										'type' => DepDrop::TYPE_SELECT2,
										'select2Options' => [

											'pluginOptions' => [
												'allowClear' => true,	
												'placeholder'=>'โปรดเลือกสาขา', 
											]
										],
										'pluginOptions'=>[								
											'depends' => ['fac'],
											'placeholder'=>'โปรดเลือกสาขา', 
											'allowClear' => true,     
											'url' => Url::to(['get-branch']),                         
										]
									]
								) ?>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
								<div style="margin-top: 15px;">
									<?php  echo DepDrop::widget(
										[    
											'name' => 'group',								
											'data'=> ArrayHelper::map(backend\models\UserCollegian::find()->select('group')->orderBy(['faculty_id'=>SORT_ASC,'branch_id'=>SORT_ASC])->all()
												,'group','group'),

											'type' => DepDrop::TYPE_SELECT2,
											'id'=>'group',
											'select2Options' => [
												'value'=>'',
												'pluginOptions' => [
													'allowClear' => true,	   
													'placeholder'=>'โปรดเลือกหมู่เรียน',
												]
											],
											'pluginOptions'=>[
												'depends' => ['fac','bra'],
												'initialize' => false,  
												'allowClear' => true,                        
												'placeholder'=>'โปรดเลือกหมู่เรียน',
												'url' => Url::to(['get-group']),                          
											]
										]
									) ?>
								</div>

							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 card mg-top">

					<div class="row">

						<div class="col-lg-5 col-md-5 col-sm-6 col-xs-6">
							<div style="margin-top: 15px;">
								<?php  
								$data=backend\models\ActivityEnter::find()->joinWith('acoyd')->joinWith('acoyd.acoy as acoy')->joinWith('acoyd.acoy.ac as ac')->orderBy(['ac_startdate'=>SORT_DESC])->all();
								$data=backend\models\ActivityOfyearDetail::find()->joinWith('acoy as acoy')->joinWith('acoy.ac as ac')->where(['between','ac_startdate',(date('Y')+542).'-01-01',(date('Y')+544).'-01-01'])->all();

								echo DepDrop::widget(
									[    
										'name' => 'acoyd_id',								
										'data'=> ArrayHelper::map($data
											,'acoyd_id',function($model){
												return $model->acoy_id.' - '.$model->acoy->ac->ac_name.'('.$model->ac_startdate.' ถึง '.$model->ac_enddate.')';
											},function($model){
												return date('Y',strtotime($model->ac_startdate));
											}
										),

										'type' => DepDrop::TYPE_SELECT2,
										'id'=>'acoyd_id',
										'select2Options' => [
											'value'=>'',
											'pluginOptions' => [
												'allowClear' => true,									                       
												'placeholder'=>'โปรดเลือกกิจกรรม',
											]
										],
										'pluginOptions'=>[
											'depends' => ['fac','bra','group'],
											'initialize' => false,  
											'allowClear' => true,                        
											'placeholder'=>'โปรดเลือกกิจกรรม',
											'url' => Url::to(['get-activity']),                          
										]
									]
								) ?>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 ">
								<?php
					//  Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i> ค้นหา', 
					// 	[
					// 		'class' => 'btn btn-success','id'=>'search'
					// 	]
					// ) 
								?>
								<span class="btn btn-success" onclick='loadGrid()'><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</span>
							</div>	
						</div>
					</div>
				</div>
			</div>




			




			

		</div>
	</form>
	<?php $form = ActiveForm::begin(['options'=>['onsubmit'=>'beforeSubmit()']]); ?>
	<div class="container card mg-top">
		<div class="row">			
			<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
				<?= $form->field($model, 'acoyd_id')
				->widget(Select2::className(),
					[
						'data'=>ArrayHelper::map(backend\models\ActivityOfyearDetail::find()->all()
							,'acoyd_id',
							function($model){

								$start=$model->ac_startdate;
								$end=$model->ac_enddate;
								return $model->acoy->acoy_id.' - '.$model->acoy->ac->ac_name.' ('.$start.' ถึง '.$end.')';
							}
						)
						,'options' => ['placeholder' => 'เลือกกิจกรรม'],
						'pluginOptions' => [
							'allowClear' => true
						],
					]

				)->label('กิจกรรมตามวันที่ดำเนินการ') ?>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 25px;">				
				<?= Html::submitButton('บันทึก', ['class' => 'btn btn-success','id'=>'save']) ?>
			</div>
		</div>	
	</div>
	<div class="container-fluid card mg-top " id='congird'>
		<div id="spinner" style="display: none">
			<div class="row">
				<div class="col-lg-3 col-lg-offset-5 col-md-4 col-md-offset-5 col-sm-8 col-sm-offset-4  col-xs-10 col-xs-offset-3">
					กำลังโหลดข้อมูล<?=Html::img(Yii::getAlias('@web').'/spinner.gif')?>
				</div>
			</div>
		</div>
		<div id="gird" class="table-responsive" style="display: none">

		</div>


	</div>
	<?php ActiveForm::end(); ?>	
</div>


<?php


$error='<div class="row label-danger" style="color:white;font-size:20px;font-weight:bold;"><div class="col-lg-2 col-lg-offset-5 col-md-4 col-md-offset-5 col-sm-8 col-sm-offset-4  col-xs-10 col-xs-offset-3">เกิดข้อผิดพลาด</div></div>'; 
$url=Url::to(['ajax2']);
$csrf=Yii::$app->request->getCsrfToken();
$js=<<<js

function checkAll(){
	$('input[type="checkbox"]').prop("checked","1")
};
function loadGrid(){
	var ac=$('#acoyd_id');

	if(ac.val()!=''){
		var g=$('#gird'),spinner=$('#spinner');
		var ver=$('#ver').val(),fac=$('#fac').val(),bra=$('#bra').val(),group=$('#group').val();
		var data={
			ver:ver,
			fac:fac,
			bra:bra,
			group:group,		
			_csrf : '$csrf'
		};
		g.hide();
		spinner.show();
		$.ajax({
			url: '$url',
			type: 'post',		
			data: data
			,
			success: function (data) {
				spinner.hide();
				g.html(data.search);
				console.log(data.search)
				g.show();
				checkAll();
			}
			,
			error: function(data){
				g.html('$error');
			}
		}
		);
	}
	else{
		alert('กรุณาเลือกกิจกรรม');
		return false;
	}
	

}

js;
$this->registerJs($js,View::POS_HEAD);

?>
<?php 
$js=<<<js
$('#activityenter-acoyd_id').change(
function(){
	if($(this).val()!=''){

	}
}
);

window.onload = (event) => {
	checkAll();
};


js;
$this->registerJs($js,View::POS_READY);

?>
