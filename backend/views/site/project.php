<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;

use yii\web\View;
use yii\helpers\Json;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivityOfyearDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายงานโครงการตามวันที่ดำเนินการ';
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
				<div class="container-fluid">
					<div class="table-responsive" style='margin-bottom:10px'>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							// 'filterModel' => $searchModel,
							'columns' => [
								['class' => 'yii\grid\SerialColumn'],								
								
								[
									'attribute'=>'acoy.ac.ac_name',
									'label'=>'ชื่อกิจกรรม',
									'format'=>'raw',
									'value'=>function($model){										
										return  Html::a($model->acoy->ac->ac_name,
											Url::to(['site/report-project?acoyd_id='.$model->acoyd_id]),
											['target'=>'_blank']);
									}
								],
								
								[
									'attribute'=>'ac_startdate',
									'format'=>'raw',
									'value'=>function($model){

										return Yii::$app->Func->DateThai($model->ac_startdate);
									}
								],
								[
									'attribute'=>'ac_enddate',
									'format'=>'raw',
									'value'=>function($model){
										return Yii::$app->Func->DateThai($model->ac_enddate);
									}
								],		
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
