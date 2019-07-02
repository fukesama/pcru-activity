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

use backend\models\Activity;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivityOfyearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'กิจกรรม';
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
<div class="activity-ofyear-index">
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
				</div>
				<br>
				<div class="container-fluid">
					<div class="table-responsive" style='margin-bottom:10px'>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'filterModel' => $searchModel,
							'columns' => [
								['class' => 'yii\grid\SerialColumn'],

								'acoy_id',
								[
									'attribute'=>'ac_id',
									'label'=>'กิจกรรม',
									'value'=>'ac.ac_name',
									// 'filterType' => GridView::FILTER_SELECT2,	
									'contentOptions'=>['width'=>'500px'],								
									'filter' => Select2::widget([

										'model' => $searchModel,
										'attribute' => 'ac_id',
										'data' => ArrayHelper::map(Activity::find()->joinWith('cate')->orderBy('ac_name')->all(), 'ac_id', function($model){return  $model->ac_id.' - '.$model->ac_name;},'cate.cate_name'
									),
										'options' => ['placeholder' => 'เลือกกิจกรรม'],
										'pluginOptions' => [
											'allowClear' => true
										],
									]),
								],
								'edu_level',
								'point',

								Yii::$app->Func->AcColumn(),
								
							],
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
