<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;

use yii\web\View;
use yii\helpers\Json;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use backend\models\ActivityCate;
use backend\models\ActivityType;
use backend\models\ActivitySide;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ชื่อกิจกรรม';
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.form-group {
		padding-bottom: none;
		margin: 0 0 0 0;
	}
	.btn-group, .btn-group-vertical{
		margin:0px 0px;
	}
	.btm{
		margin:0px;
	}
	.btn.btn-xs{
		padding: 4px 6px
	}
	th:last-child{

	}

</style>
<div class="activity-index">
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
					<h4 class="title" style="font-weight:bold;display:inline-block;float:left;text-align:left;width: 200px;">

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
								[
									'class' => 'yii\grid\SerialColumn',
									'header'=> 'ลำดับ'
								],

								[

									'options'=>['width'=>'100px']
									,'attribute'=>'ac_id',
								],

								[
									'label'=>'หน่วยงานรับผิดชอบ',
									'options'=>['width'=>'40px']
									,'attribute'=>'cate.cate_name',
									'filter'=>Select2::widget([ 								

										'model' => $searchModel,
										'attribute' => 'cate_id',
										'data'=> ArrayHelper::map(
											backend\models\ActivityCate::find()->all(),'cate_id','cate_name'
										),															
										'pluginOptions'=>[										
											'placeholder'=>'โปรดเลือกหน่วยงาน',			
											'allowClear' => true						
										]
									]),                                 
								],
								[
									'label'=>'ชนิดกิจกรรม',
									'options'=>['width'=>'40px']
									,'attribute'=>'type.type_name',
									'filter'=>Select2::widget([ 								

										'model' => $searchModel,
										'attribute' => 'type_id',
										'data'=> ArrayHelper::map(
											backend\models\ActivityType::find()->all(),'type_id','type_name'
										),															
										'pluginOptions'=>[										
											'placeholder'=>'โปรดเลือกชนิดกิจกรรม',			
											'allowClear' => true						
										]
									]),   
								],
								[
									'label'=>'ด้านกิจกรรม',
									'options'=>['width'=>'40px']
									,'attribute'=>'side.side_name',
									'filter'=>Select2::widget([ 								

										'model' => $searchModel,
										'attribute' => 'side_id',
										'data'=> ArrayHelper::map(
											backend\models\ActivitySide::find()->all(),'side_id','side_name'
										),															
										'pluginOptions'=>[										
											'placeholder'=>'โปรดเลือกด้านกิจกรรม',			
											'allowClear' => true						
										]
									]),   
								],

                                //'ac_num',
                                [
									'label'=>'ชื่อกิจกรรม',
									'options'=>['width'=>'40px']
									,'attribute'=>'ac_name',
									'filter'=>Select2::widget([ 								

										'model' => $searchModel,
										'attribute' => 'ac_name',
										'data'=> ArrayHelper::map(
											backend\models\Activity::find()->all(),'ac_name','ac_name'
										),															
										'pluginOptions'=>[										
											'placeholder'=>'โปรดเลือกชื่อกิจกรรม',			
											'allowClear' => true						
										]
									]),   
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
