<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;
use yii\helpers\ArrayHelper;
use backend\models\ActivityEnterDetail;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityEnter */
$this->title = $model->acoyd->acoy->ac->ac_name;
$this->params['breadcrumbs'][] = ['label' => 'การเข้าร่วมกิจกรรม', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	th{
		vertical-align: top;
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
					<h4 class="title" style="font-weight:bold;display:inline-block;float:left;text-align:left;width: 200px;">
					</h4>
					<br><br>

					<?= DetailView::widget([
						'model' => $model,
						'attributes' => 
						[
							'acoyd.acoy.acoy_id:text:รหัสกิจกรรม',
							'acoyd.acoy.ac.ac_name',
							'acoyd.acoy.ac.cate.cate_name:text:ผู้รับผิดชอบ',
							'acoyd.acoy.edu_level',
							'acoyd.acoy.ac.type.type_name',							
							'acoyd.acoy.ac.side.side_name',
							'acoyd.acoy.ac.ac_num:text:ลำดับกิจกรรม',
							'acoyd.address_detail',
							'acoyd.acoy.point',					
						// 'enter_status',
						// 'result',
							[	
								'attribute'=>'acend.acend_date',
								'labelOptions' => [
									'style' => 'display: none;',
								],
								'label'=>'วันที่เข้าร่วมกิจกรรม',							
								'format'=>'raw',
								'value'=>function($model){
									$acend=ActivityEnterDetail::find()->where(['acen_id'=>$model->acen_id])->asArray()->all();
									$text='';
									foreach ($acend as $key => $value) {
										if($key!=0){
											$text.=',<br>';
										}
										$text.=Yii::$app->Func->DateThai($value['acend_date']);
										
									}
									return $text;

								}


							],
						],
					]) ?>
				</div>
			</div>
		</div>
	</div>
</div>
