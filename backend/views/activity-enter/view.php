<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityEnter */

$this->title = $model->acen_id;
$this->params['breadcrumbs'][] = ['label' => 'การเข้าร่วมกิจกรรม', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	th{
		width:100px;
	}
</style>
<div class="activity-enter-view">
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-stats">
				<div class="card-header" data-background-color="orange">
					<i class="material-icons"  style="display:block;float:left;">list</i>
					<h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
						<?= Html::encode($this->title); ?>
					</h4>
				</div>
				<div class="card-content">
					<h4 class="title" style="font-weight:bold;display:inline-block;float:left;text-align:left;width: 200px;
					">
				</h4>
				<div class="btn btnhover btn-warning" style="">
					<?php $add='แก้ไข ( '.$this->title.' )' ?>
					<a href="<?=Url::to(['update', 'id' => $model->acen_id])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style=""><i class="material-icons" style="font-size: 30px">create</i><?=$add?></a>
				</div>
				<div class="btn btnhover btn-danger" style="">
					<?php $add='ลบ ( '.$this->title.' )' ?>
					<?= Html::a(Yii::t('app', '<i class="material-icons" style="font-size: 30px">delete</i>'.$add.'</a>'), ['delete', 'id' => $model->acen_id], 
						[
							'data' =>
							[
								'confirm' => Yii::t('app', 'คุณต้องการที่จะลบรายการนี้ใช่หรือไม่?'),
								'method' => 'post',
							],
						]
					) ?>
				</div>

				<?= DetailView::widget([
					'model' => $model,
					'attributes' => [
						'acen_id',
						[
							'attribute'=>'acoyd.acoy.ac.ac_name',
							'value'=>function($model){
								return $model->acoyd->acoy->ac->ac_name;
							}
							


						],
						[
							'attribute'=>'co_id',
							'label'=>'รหัสนักศึกษา',
							'value'=>function($model){
								return $model->co->user->username;
							}

						],						
						[
							'attribute'=>'co_id',
							'label'=>'ชื่อ - นามสกุล นักศึกษา',
							'value'=>function($model){
								return $model->co->pre->pre_name.' '.$model->co->uc_fname.' '.$model->co->uc_lname;
							}

						],
						[
							'attribute'=>'enter_status',
							'format'=>'raw',
							'headerOptions'=>['class'=>'text-center'],
							'contentOptions'=>['width'=>'100px','class'=>'text-center'],
							'value'=>function($model){
								return $model->enter_status=='1'?'ยังไม่ได้เข้าร่วม':'เข้าร่วม';
							}
						],
						[
							'label'=>"จำนวนวันขั้นต่ำที่ต้องเข้าร่วมกิจกรรม",
							'format'=>'raw',
							'value'=>function($model){
								$day=0;
								return $model->acoyd->day.' วัน';
							}
						],
						
						[
							'label'=>"วันที่เข้าร่วมกิจกรรม",
							'format'=>'raw',
							'value'=>function($model){
								$text='';
								$arr=backend\models\ActivityEnterDetail::find()->where(['acen_id'=>$model->acen_id])->asArray()->all();

								foreach ($arr as $key=> $value) {
									if($key==0){
										$text.=$value;
										continue;
									}	
									$text.=','.$value;
								}
								return $text;
							}
						],
						[
							'label'=>"รวมจำนวนวันที่เข้าร่วมกิจกรรม",
							'format'=>'raw',
							'value'=>function($model){
								$text='';
								$arr=backend\models\ActivityEnterDetail::find()->where(['acen_id'=>$model->acen_id])->asArray()->count();
								
								return $arr.' วัน';
							}
						],
						
						[
							'attribute'=>'result',
							'format'=>'raw',
							'contentOptions'=>['width'=>'100px','class'=>'text-center'],	
							'value'=>function($model){
								return $model->result==''?'-':$model->result;
							}
						],
					],
				]) ?>
			</div>
		</div>
	</div>
</div>
</div>
