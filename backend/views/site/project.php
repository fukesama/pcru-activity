<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;

use yii\web\View;
use yii\helpers\Json;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use backend\models\ActivityOfyearDetailSearch;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivityOfyearDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายงานการเข้าร่วมกิจกรรม';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.form-group {
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
<div class="activity-ofyear-detail-index">
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-stats">
				<div class="card-header" data-background-color="purple">
					<i class="material-icons"  style="display:block;float:left;">list</i>
					<h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
						<?= Html::encode($this->title) ?>                    </h4>
					</div>
					<div class="card-content">
						<h4 class="title" style="font-weight:bold;
						display:inline-block;
						float:left;
						text-align:left;
						width: 200px;
						">

					</h4>

				</div>
				<br>
				<br>	
	<br>
				<?= $this->render('_project',['model'=>$searchModel,'params'=>Yii::$app->request->queryParams]) ?>
				<div class="container-fluid">
					<div class="table-responsive" style='margin-bottom:10px'>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							// 'filterModel' => $searchModel,
							'columns' => [
								['class' => 'yii\grid\SerialColumn'],	
								[
									'attribute'=>'acoy.acoy_id',
									'label'=>'รหัสกิจกรรม',
									
								],							
								
								[
									'attribute'=>'acoy.ac.ac_name',
									'label'=>'ชื่อกิจกรรม',									
								],
								[
									'attribute'=>'acoy.edu_level',
									'label'=>'ชั้นปี',
									'format'=>'raw',									
								],	
								
								[
									'attribute'=>'year',
									'label'=>'ปี',
									'format'=>'raw',
									'value'=>function($model){
										$d=$model->ac_startdate;
										return $d[0].$d[1].$d[2].$d[3];
									}
								],								
								[
									'class' => 'yii\grid\ActionColumn',
									'header'=>'รายงานรายชื่อนักศึกษา',
									'headerOptions'=>['class'=>'text-center'],
									'contentOptions'=>['width'=>'200px'],
									'options'=>['width'=>'110px'],
									'template'=>'{have}{enter}{unenter}',
									'buttons'=>[
										'have'=>function($url,$model,$key){
											$url=Url::to(['site/report-project','acoyd_id'=>$model->acoyd_id]);
											return
											Html::a('
												ผู้มีสิทธิ์
												',$url,
												[
													'class'=>'btn btn-sm btn-primary',
													"style" => "cursor: pointer;",
													"title" => "ผู้มีสิทธิ์",
													'target'=> '_blank'
												]
											);
										},
										'enter'=>function($url,$model,$key){
											$url=Url::to(['site/report-project2','acoyd_id'=>$model->acoyd_id]);
											return
											Html::a('
												เข้าร่วม
												',$url,
												[
													'class'=>'btn btn-sm btn-success',
													"style" => "cursor: pointer;",
													"title" => "เข้าร่วม",
													'target'=> '_blank'
												]
											);
										},
										'unenter'=>function($url,$model,$key){
											$url=Url::to(['site/report-project3','acoyd_id'=>$model->acoyd_id]);
											return
											Html::a('
												ไม่เข้าร่วม
												',$url,
												[
													'class'=>'btn btn-sm btn-warning',
													"style" => "cursor: pointer;",
													"title" => "ไม่เข้าร่วม",
													'target'=> '_blank'
												]
											);
										},
									],
								]		
								// 'address_detail',
								// 'detail:ntext',

								// Yii::$app->Func->AcColumn(),

							],
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
