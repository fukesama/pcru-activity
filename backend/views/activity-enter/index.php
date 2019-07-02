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
	.grid-view th {
		white-space: nowrap;
	}
	.td:nth-child(1) {
		max-width: 100px;
		overflow: auto; /* optional */
		word-wrap: break-word;
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
					<?php $add='เพิ่ม'.Html::encode($this->title) ?>
					<a href="<?=Url::to(['multi-create'])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style="">
						<div class="btn btn-primary" style="">
							<i class="material-icons">add_box</i><?=$add?>
						</div>
					</a>
				</div>
				<?php 
				$param=Yii::$app->request->queryParams ;	
				// print_r($param);	

				if(isset($param['ActivityEnterReportSearch'])){
					$faculty_id=$param['ActivityEnterReportSearch']['faculty_id'];
					$branch_id=$param['ActivityEnterReportSearch']['branch_id'];
				}
				

				isset($faculty_id)&&$faculty_id!==''?$facData=backend\models\Branch::find()->where(['faculty_id'=>$faculty_id])->all()
				:$facData=backend\models\Branch::find()->all();


				
				$groupData=backend\models\UserCollegian::find()
				->orderBy(['faculty_id'=>SORT_ASC,'branch_id'=>SORT_ASC,'group'=>SORT_ASC]);

				if(isset($faculty_id)&&$faculty_id!==''){
					$groupData->where(['faculty_id'=>$faculty_id]);
				}
				if(isset($branch_id)&&$branch_id!==''){
					$groupData->where(['branch_id'=>$branch_id]);
				}		

				$groupData=ArrayHelper::map($groupData->all()
					,'group','group',
					function($model){
						return $model->fac->faculty_name.
						'('.$model->bra->branch_name.')';
					}
				);

				?>


				<div class="container-fluid">
					<div class="table table-responsive" style='margin-bottom:10px;overflow-x: hidden;'>
						<?php 
						$columns=[
							[
								'class' => 'yii\grid\SerialColumn',
								'contentOptions'=>['width'=>'20px']
							],						
							[
								'attribute'=>'acoyd_id',
								'contentOptions'=>['width'=>'200px'],
								'label'=>'ชื่อกิจกรรม',
								'value'=>function($model){									
									return$model->acoy_id.' - '.$model->ac_name;
								},
								'filter'=>Select2::widget([ 								
									
									'model' => $searchModel,
									'attribute' => 'acoyd_id',
									'data'=> ArrayHelper::map(
										backend\models\ActivityOfyearDetail::find()->all(),'acoyd_id',
										function($model){return$model->acoy_id.' - '.$model->acoy->ac->ac_name.'('.(explode('-',$model->ac_startdate)[0]+543).')';},function($model){
											return explode('-',$model->ac_startdate)[0]+543;
										}
									),															
									'pluginOptions'=>[										
										'placeholder'=>'โปรดเลือกกิจกรรม',			
										'allowClear' => true						
									]
								]),

							],		
							[
								'attribute'=>'ver',
								'label'=>'รุ่น',	
								'value'=>'ver',	
								'contentOptions'=>['width'=>'100px']  					
							],		
							[
								'attribute'=>'faculty_name',

								'label'=>'คณะ',
								'filter'=>Select2::widget([
									'model' => $searchModel,
									'attribute' => 'faculty_id',
									'data' => ArrayHelper::map(backend\models\Faculty::find()->all()
										,'faculty_id','faculty_name'),
									'options' => ['placeholder' => 'เลือกคณะ',],
									'pluginOptions' => [
										'allowClear' => true
									],
								])
							]
							,
							[
								'attribute'=>'branch_name',
								'label'=>'สาขา',
								'filter'=>Select2::widget([             
									// 'options'=>['id'=>'ddl-branch'],
									'model' => $searchModel,
									'attribute' => 'branch_id',
									'name' => 'branch_id',
									'data'=> ArrayHelper::map(
										$facData,'branch_id','branch_name','fac.faculty_name'),
										// 'type'=>DepDrop::TYPE_SELECT2,
									'pluginOptions'=>[
										'initialize' => false,
										'allowClear' => true,
										// 'depends'=>['ddl-faculty'],
										'placeholder'=>'โปรดเลือกสาขา',
										// 'url'=>Url::to(['/user/get-branch'])
									]
								])
							],
							[
								 'attribute'=>'group',
								'label'=>'หมู่เรียน',
								'filter'=>Select2::widget([ 
									'name' => 'group',
									'model' => $searchModel,									
									'attribute' => 'group',
									'data'=>$groupData,								
									'pluginOptions'=>[
										'initialize' => false,
										'placeholder'=>'โปรดเลือกหมู่เรียน',
										'allowClear' => true,										
									]
								])
							],							
							[
								'attribute'=>'number',
								'value'=>'number',
								'label'=>'เลขที่',		
								'contentOptions'=>['width'=>'100px']  					
							],
							[
								'attribute'=>'co_id',								
								'label'=>'ชื่อ-นามสกุล นักศึกษา',
								'filterType' => GridView::FILTER_SELECT2,
								'filterWidgetOptions' => 
								[
									'pluginOptions' => ['allowClear' => true,'placeholder'=>'โปรดเลือกนักศึกษา'],
								],								
								'filter'=>ArrayHelper::map(backend\models\UserCollegian::find()->all(),'user_id',
									function($model){
										return $model->pre->pre_name.' '.$model->uc_fname.' '.$model->uc_lname;
									},function($model){
										return $model->bra->branch_name.'('.$model->fac->faculty_name.')';
									}
								),
								'value'=>function($model){
									return $model->pre_name.' '.$model->uc_fname.' '.$model->uc_lname;
								}

							],
							[
								'attribute'=>'enter_status',
								'format'=>'raw',
								'headerOptions'=>['class'=>'text-center'],
								'filterType'=>GridView::FILTER_SELECT2,	
								'contentOptions'=>['width'=>'100px','class'=>'text-center'],
								'value'=>function($model){
									return $model->enter_status=='1'?'ยังไม่ได้เข้าร่วม':'เข้าร่วม';
								},
								'filter'=>['1'=>'ยังไม่ได้เข้าร่วม','2'=>'เข้าร่วมแล้ว']
							],
							[
								'attribute'=>'result',
								'format'=>'raw',
								'filterType'=>GridView::FILTER_SELECT2,								
								'contentOptions'=>['width'=>'100px','class'=>'text-center'],	
								'value'=>function($model){
									return $model->result==''?'-':$model->result;
								},
								'filter'=>[''=>'-','ผ.'=>'ผ.','ม.ผ.'=>'ม.ผ.']
							],	

							Yii::$app->Func->AcColumn(),

						]
						?>
						<?= GridView::widget(
							[
								'dataProvider' => $dataProvider,
								'filterModel' => $searchModel,							
								'panel'=>[
									'before'=>' '
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
								'columns' => $columns
							]
						); ?>

						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
