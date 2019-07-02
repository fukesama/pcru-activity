<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;

use yii\web\View;
use yii\helpers\Json;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use backend\models\Activity;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivityOfyearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'วันที่ดำเนินกิจกรรม';
$this->params['breadcrumbs'][] = $this->title;

$GLOBALS['num']=0;
?>
<style>
	.form-group,.btn-group {
		padding-bottom: none;
		margin: 0 0 0 0;
	}
	.btm{
		margin:0px;
	}
	.btn.btn-xs{
		padding: 4px 6px
	}


</style>
<div class="activity-ofyear-index">
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-stats">
				<div class="card-header" data-background-color="purple">
					<i class="material-icons"  style="display:block;float:left;">list</i>
					<h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
						<?= Html::encode($this->title) ?>
					</h4>
				</div>
				<div class="card-content">
					<?php  //print_r(Yii::$app->Func->dateRange('2019-04-01','2019-04-15')) ?>
					<?php $add='Generate QR Code' ?>

					<?php echo  Html::a('<div class="btn btn-default">
						<i class="fa fa-qrcode"></i>'.$add.'
						</div>',['pre-qrcode'],
						[
							'target'=>'_blank'
						]        
					); ?>

					<?php $add='เพิ่ม'.Html::encode($this->title) ?>
					<a href="<?=Url::to(['create'])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style="">
						<div class="btn btn-primary" style="">
							<i class="material-icons">add_box</i><?=$add?>
						</div>
					</a>

				</div>
				<br>
				<div class="container-fluid">

					<div class="table-responsive" style='margin-bottom:10px'>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'filterModel' => $searchModel,
							'columns' => [




								[
									'header'=>'ลำดับ',

									'class' => 'yii\grid\SerialColumn',
									'contentOptions'=>[
										'class'=>'text-center',
										'style' => 'width:50px;'
									],
									'headerOptions'=>['class'=>'text-center']
								],
								[
									'attribute' => 'acoy_id',
									'filterInputOptions' => [
										'class' => 'form-control',
										'placeholder' => 'รหัสดำเนินกิจกรรม'
									],
									'contentOptions'=>['class'=>'text-center'],
									'headerOptions'=>['class'=>'text-center']
								],
								/*   'acoy_id',*/
								[
									'attribute' => 'year',
									'filterInputOptions' => [
										'class'=> 'form-control text-center',
										'placeholder' => 'ปีกิจกรรม'
									],
									'contentOptions'=>['class'=>'text-center'],
									'headerOptions'=>['class'=>'text-center']
								],
								/*    'year',*/
								/*'ac.ac_name',*/
								[
									'attribute' => 'ac_id',
									'width' => '',
									'value' => function ($model, $key, $index, $widget) {
										return $model->ac->ac_name;
									},
									'filterType' => GridView::FILTER_SELECT2,
									'filter' => ArrayHelper::map(Activity::find()->orderBy('ac_name')->asArray()->all(), 'ac_id', 'ac_name'),
									'filterWidgetOptions' =>
									[
										'pluginOptions' => ['allowClear' => true],
									],
									'filterInputOptions' => ['placeholder' => 'กิจกรรม'],

									'headerOptions'=>['class'=>'text-center'],
									'contentOptions'=>['style'=>'vertical-align: middle']
								],
								/*'ac_startdate',*/
								[
									'attribute' => 'ac_startdate',
									'value' => 'ac_startdate',
									'content' => function ($model, $key, $index, $column) {
										return Yii::$app->Func->dateThai2($model->ac_startdate);
									},
									'filterType'=> \kartik\grid\GridView::FILTER_DATE,
									'filterWidgetOptions' => [
										'removeButton'=>false,
										'options' => [
											'placeholder' => 'เลือกวันที่',

										],
										'pluginOptions' => [
											'format' => 'yyyy-mm-dd',
											'todayHighlight' => true,
											'autoClose'=>true,
											'autoComplete'=>false
										]
									],
									'format' => 'html',
									'contentOptions'=>['class'=>'text-center'],
									'headerOptions'=>['class'=>'text-center']
								],
								[
									'attribute' => 'ac_enddate',
									'value' => 'ac_enddate',
									'content' => function ($model, $key, $index, $column) {
										return Yii::$app->Func->dateThai2($model->ac_startdate);
									},

									'filterType'=> \kartik\grid\GridView::FILTER_DATE,
									'filterWidgetOptions' => [
										'removeButton'=>false,
										'options' => [
											'placeholder' => 'เลือกวันที่',

										],
										'pluginOptions' => [
											'format' => 'yyyy-mm-dd',
											'todayHighlight' => true,
											'autoClose'=>true,
											'autoComplete'=>false
										]
									],
									'format' => 'html',
									'contentOptions'=>['class'=>'text-center'],
									'headerOptions'=>['class'=>'text-center']
								],


								Yii::$app->Func->AcColumn(),

							],
						]); ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
    //หาหน้าเว็ปปัจจุบัน
$pageURLNow = (string)$_SERVER["REQUEST_URI"];
$pageURLNow = explode("/",$pageURLNow);
$k = count($pageURLNow);
$pageURLNow = $pageURLNow[$k-1];
    ///ตัวแปรรับค่าหน้าที่ต้องการไปแสดง/////
$pageGo="complete";
    ///ตัวแปรรับค่าหน้าที่ต้องการไปแสดง/////
$r="";

$js=<<<JS
$(function(){
        // changed id to class
	$('#modalButton').click(function (){
		$.get($(this).attr('href'), function(data) {
			$('#modal').modal('show').find('.createModal').html(data)
			});
			return false;
			});
			});
			Array.prototype.remove = function() {
				var what, a = arguments, L = a.length, ax;
				while (L && this.length) {
					what = a[--L];
					while ((ax = this.indexOf(what)) !== -1) {
						this.splice(ax, 1);
					}
				}
				return this;
			};

			var count=[],text=0;
			$('#checkall').on('click',function(){
				var array='$GLOBALS[num]'.split(',');
				var n=array.length-1;
				if(this.checked==true){
					count=[];
					text=0;
					while(n>=0){
						$('#check'+array[n]).prop('checked',true);
						count.push($('#check'+array[n]).val());
						text+=1;
						n--;
						$('#num').html(text);
					}
				}
				else{
					count=[];
					text=0;
					while(n>=0){
						$('#check'+array[n]).removeAttr('checked');
						$('#check'+array[n]).removeProp('checked');
						n--;
						$('#num').html(text);
					}
				}

			}
			);
			$('#sendid').click(function(){
				if(count!=''){
					var text = "asset-check?data="+count;
        //alert(text);
					window.location=text;
				}
			}
			);
			$('input[name*=check]').click(function(){})
			$('input[name*=check]').change(
			function(){
				if(this.checked==true){
					count.push(this.value);
					n=count.length-1;
					text+=1;
					$('#num').html(text);
				}
				else{
					text-=1;
					count.remove(this.value);
					$('#num').html(text);
				}

			}
			);

			JS;
			$this->registerJS($js,yii\web\View::POS_READY);
			?>


			<?php
			$qr= Url::to(['pre-qrcode']);
			$create= Url::to(['create']);
			$update=Url::to(['update']);
			$view=Url::to(['view']);
			$js=<<<JS

			function init_click_handlers(){
				$("#qr").click(function(e) {

					$.get(
					"$qr",
					function (data)
					{
						$("#activity-modal").find(".modal-body").html(data);
						$(".modal-body").html(data);
						$(".modal-title").html("");
						$("#activity-modal").modal("show");
					}
					);
					});

				}
				init_click_handlers(); //first run
				$("#customer_pjax_id").on("pjax:success", function() {
					init_click_handlers(); //reactivate links in grid after pjax update
					});
					JS;
					$this->registerJs($js);
					?>

					<?php
					$url=Url::to(['ac']);

					$js=<<<JS


					JS;
					$this->registerJs($js,View::POS_HEAD);
					?>
