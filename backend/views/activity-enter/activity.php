<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;

use yii\web\View;
use yii\helpers\Json;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

// use yii\grid\GridView;

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivityEnterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'การเข้าร่วมกิจกรรมของนักศึกษา';
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
					<?php $add='เพิ่ม'.Html::encode($this->title) ?>
					<a href="<?=Url::to(['create'])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style="">
						<div class="btn btn-primary" style="">
							<i class="material-icons">add_box</i><?=$add?>
						</div>
					</a>

					<br>

					<div class="container-fluid">
						<div class="table-responsive" style='margin-bottom:10px'>
							<?php 


							isset($faculty_id)&&$faculty_id!==''?$facData=backend\models\Branch::find()->where(['faculty_id'=>$faculty_id])->all()
							:$facData=backend\models\Branch::find()->all();

							?>


							<?php
							$layout ='
							<div class="pull-right">
							{summary} 
							</div>
							{custom}
							<div class="clearfix"></div>
							{items}
							{pager}';							
							echo GridView::widget([
								'dataProvider' => $dataProvider,
								'filterModel' => $searchModel,

								'options' =>['class' => 'table table-striped table-bordered text-nowrap skip-export-json skip-export-html skip-export-txt'],
							// 'panelTemplate' => $layout,
								'panel'=>['before'=>' ' ], 

								'replaceTags' => [
									'{custom}' => function($widget) {

										if ($widget->panel === false) {
											return '';
										} else {
											return '';
										}
									}
								],
								'columns' => [
									['class' => 'yii\grid\SerialColumn','header'=>'ลำดับ'],
									[
										'attribute'=>'acoy_id',
										''=>'',

										'filter' => 
										ArrayHelper::map(backend\models\ActivityEnter::find()->all(), 'acoy_id', 'acoy_id'),
										'filterOptions'=>[
											'placeholder' => 'เลือกปีการศึกษา'

										]

									],
									[
										'attribute'=>'acoy.year',
										'value'=>function($model){
											return $model->acoy->year;
										},
										'header'=>'ปีการศึกษา&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
										'filter'=>Select2::widget([
											'model' => $searchModel,
											'attribute' => 'year',
											'data' => ArrayHelper::map(backend\models\ActivityOfyear::find()->all()
												,'year','year'),
											'options' => ['placeholder' => 'เลือกปีการศึกษา',
											'value'=>isset($data['year'])?$data['year']:null,],
											'pluginOptions' => [
												'allowClear' => true
											],
										])

									],
									[
										'attribute' => 'acoy.ac.ac_name',
										'width' => '',
										'value' => function ($model, $key, $index, $widget) {
											return $model->acoy->ac->ac_name;
										},

										'filter'=>Select2::widget([

											'model' => $searchModel,
											'attribute' => 'acoy_id',
											'data' => ArrayHelper::map(Yii::$app->db->createCommand("
												SELECT DISTINCT ac.ac_name as ac_name,
												acen.acoy_id as acoy_id,acoy.year as year
												FROM activity_enter as acen
												INNER JOIN activity_ofyear as acoy ON acen.acoy_id=acoy.acoy_id
												INNER JOIN activity as ac ON acoy.ac_id=ac.ac_id
												")->queryAll(),'acoy_id','ac_name','year'),
											'options' => ['placeholder' => 'เลือกกิจกรรม',]
										]),
										'filterWidgetOptions' =>
										[
											'pluginOptions' => ['allowClear' => true],
										],
										'filterInputOptions' => ['placeholder' => 'กิจกรรม'],

										'headerOptions'=>['class'=>'text-center'],
										'contentOptions'=>['style'=>'vertical-align: middle']
									],




									[
										'attribute'=>'co.fac.faculty_name',

										'label'=>'คณะ',
										'filter'=>Select2::widget([
											'model' => $searchModel,
											'attribute' => 'faculty_id',
											'name' => 'faculty_id',
											'data' => ArrayHelper::map(backend\models\Faculty::find()->all()
												,'faculty_id','faculty_name'),
											'options' => ['placeholder' => 'เลือกคณะ'],
											'pluginOptions' => [
												'allowClear' => true
											],
										]),									
									]
									,
									[
										'attribute'=>'co.bra.branch_name',
										'label'=>'สาขา',
										'filter'=>Select2::widget([             
											'options'=>['id'=>'ddl-branch'],
											'attribute' => 'branch_id',
											'name' => 'branch_id',
											'data'=> ArrayHelper::map(
												$facData,'branch_id',function($model){
													return $model->branch_id.' - '.$model->branch_name;
												}),
										// 'type'=>DepDrop::TYPE_SELECT2,
											'pluginOptions'=>[	
												'allowClear' => true,										
												'placeholder'=>'เลือกสาขา',

											]
										])
									],
									[
										'attribute'=>'co.group',
										'label'=>'หมูเรียน',
										'filter'=>Select2::widget([
											'name' => 'group',
											'data'=> ArrayHelper::map(
												backend\models\ActivityEnter::find()->joinWith('co'),'co.group','group'),
										// 'type'=>DepDrop::TYPE_SELECT2,
											'pluginOptions'=>[	
												'allowClear' => true,										
												'placeholder'=>'เลือกหมู่เรียน',

											]
										])
									],
									[
										'attribute'=>'co_id',
										'label'=>'ชื่อ - นามสกุล',
										'filter'=>Select2::widget([
											'model' => $searchModel,
											'attribute' => 'co_id',
											'data' => ArrayHelper::map(backend\models\UserCollegian::find()->all()
												,'user_id',function($model){
													return $model->pre->pre_name.' '.$model->uc_fname.' '.$model->uc_lname;
												}

											),
											'options' => ['placeholder' => 'เลือก ชื่อ - สกุล'],
											'pluginOptions' => [
												'allowClear' => true
											],
										]),
										'value'=>function($model){
											return $model->co->pre->pre_name.' '.$model->co->uc_fname.' '.$model->co->uc_lname;
										}

									],
								],
							]); 
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
