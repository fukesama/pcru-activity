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

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivityEnterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'การเข้าร่วมกิจกรรม';
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
<div class="activity-enter-index">
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
				<br><br>
				<?php 				
				?>
				<div class="container-fluid">
					<?= $this->render('_project',['model'=>$searchModel]) ?>
					<div class="table-responsive" style='margin-bottom:10px'>
						<?php $model=backend\models\ActivityEnter::find()->where(['co_id'=>Yii::$app->user->id])->all() ?>
						<?php 
						// foreach ($model as $key=>$value): 
						// 	print_r($value->acoyd->acoy->acoy_id);
						// endforeach ?>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							// 'filterModel' => $searchModel,
							'panel'=>[
								// 'before'=>' '
							],
							'export'=>[

							],
							'exportConfig'=>[
								GridView::EXCEL=>false,
								GridView::CSV=>false,
								GridView::PDF=>false,
							],
							'toggleDataOptions'=>[ 
								'all' => [
									'icon' => 'resize-full',
									'label' => '<i class="fa fa-expand"></i> ทั้งหมด',
									'class' => 'btn btn-secondary',

								],
								'page' => [
									'icon' => 'resize-small',
									'label' => '<i class="fa fa-compress"></i> ย่อ',
									'class' => 'btn btn-secondary',

								],
							],
							'toolbar' => [
								'{toggleData}{export}'
							],
						// 'panelBeforeTemplate'=>'{summary}{toolbar}
						// ',
						// 'panelHeadingTemplate'=>'
						// ',
							'panelTemplate'=>'						
							{panelHeading}
							{panelBefore}						
							{items}
							{panelAfter}
							{panelFooter}				
							<div class="clearfix"></div>
							',
							'columns' => [
								['class' => 'yii\grid\SerialColumn'],								
								[	
									'attribute'=>'acoyd.acoy_id',
									'header'=>'รหัสกิจกรรม',
									'options'=>['class'=>'text-center'],
									'contentOptions'=>['width'=>'100px','class'=>'text-center'],
								],
								[
									'attribute'=>'acoyd.acoy.ac.ac_name',
									'format'=>'raw',
									'value'=>function($model){
										return  Html::a($model->acoyd->acoy->ac->ac_name,
											Url::to(['site/view?acen_id='.$model->acen_id]),
											['target'=>'_blank']);

									},
									'header'=>'ชื่อกิจกรรม',
									

									// 'filter'=>Select2::widget([ 								

									// 	'model' => $searchModel,
									// 	'attribute' => 'acoyd_id',
									// 	'data'=> function($model) use ($year){
									// 		ArrayHelper::map(
									// 		backend\models\ActivityEnter::find()->where(['co_id'=>Yii::$app->user->id])->all(),'acoyd_id','acoyd.acoy.ac.ac_name'
									// 	);
									// 	},															
									// 	'pluginOptions'=>[										
									// 		'placeholder'=>'โปรดเลือกกิจกรรม',			
									// 		'allowClear' => true						
									// 	]
									// ]),
								],	
								[
									'attribute'=>'acoyd.ac_startdate',
									'header'=>'วันที่เริ่มกิจกรรม',
									'format'=>'raw',
									'value'=>function($model){
										return Yii::$app->Func->DateThai($model->acoyd->ac_startdate);
									}
								],
								[
									'attribute'=>'acoyd.ac_enddate',
									'header'=>'วันที่สิ้นสุดกิจกรรม',
									'format'=>'raw',
									'value'=>function($model){
										return Yii::$app->Func->DateThai($model->acoyd->ac_enddate);
									}
								],
								// [
								// 	'attribute'=>'enter_status',
								// 	'format'=>'raw',
								// 	'header'=>'สถานะการเข้าร่วม',
								// 	'headerOptions'=>['class'=>'text-center'],
								// 	'filterType'=>GridView::FILTER_SELECT2,	
								// 	'contentOptions'=>['width'=>'150px','class'=>'text-center'],
								// 	'value'=>function($model){
								// 		return $model->enter_status=='1'?'ยังไม่ได้เข้าร่วม':'เข้าร่วม';
								// 	},
								// 	'filter'=>['1'=>'ยังไม่ได้เข้าร่วม','2'=>'เข้าร่วมแล้ว']
								// ],
								// [
								// 	'attribute'=>'result',	
								// 	'header'=>'ผลประเมิน'								
								// ]

							],
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
