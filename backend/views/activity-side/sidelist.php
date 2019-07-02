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


use yii\data\ActiveDataProvider; 	
use yii\db\Query ;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivitySideSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$query=backend\models\ActivitySide::find()->where(['side_id'=>$id])->one();
$this->title = 'กิจกรรม'.$query->side_name;
$this->params['breadcrumbs'][] = ['label' => 'ด้านของกิจกรรม', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


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
<div class="activity-side-index">
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
				<div class="container-fluid">
					<div class="table-responsive" style='margin-bottom:10px'>
						<?php 
						$columns=[
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
								'attribute' => 'side.side_name',                                  
								'filterInputOptions' => [
									'class'       => 'form-control',
									'placeholder' => 'ชื่อด้าน'
								],
								'contentOptions'=>['class'=>'text-left'],
								'headerOptions'=>['class'=>'text-center']
							],
							'ac_id',
							[
								'attribute'=>'ac_name',
								'label'=>'ชื่อกิจกรรม',
								// 'value'=>function($model){
								// 	$arr=backend\models\Activity::find()->where(['side_id'=>$model->side_id])->one();
								// 	return $model->ac_name;
								// }
							],
						];
						
						echo GridView::widget(
							[
								'dataProvider' => $dataProvider,

								'panel'=>[
									'before'=>' '
								],
								'toggleDataOptions'=>[ 
									'all' => [
										'icon' => 'resize-full',
										'label' => '<i class="fa fa-expand"></i> ทั้งหมด',
										'class' => 'btn btn-warning',						
									],
									'page' => [
										'icon' => 'resize-small',
										'label' => '<i class="fa fa-compress"></i> ย่อ',
										'class' => 'btn btn-warning',						
									],
								],
								'exportConfig'=>[
									GridView::EXCEL=>false,
									GridView::CSV=>false,
									GridView::PDF=>false,
								],
								'toolbar' => [
									'{toggleData}{export}'
								],						
								'panelTemplate'=>'						
								{panelHeading}
								{panelBefore}
								<hr style="margin:0">						
								{items}
								{panelAfter}
								{panelFooter}				
								<div class="clearfix"></div>
								',
								'columns' => $columns
							]
						);


						
						?>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
