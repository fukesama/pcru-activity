<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;
use yii\helpers\ArrayHelper;
use backend\models\ActivityEnter;
use backend\models\ActivityEnterDetail;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityEnter */

$this->title = $model->acoy->ac->ac_name;
$this->params['breadcrumbs'][] = ['label' => 'การเข้ากิจกรรม', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
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
					<h4 class="title" style="font-weight:bold;
					display:inline-block;
					float:left;
					text-align:left;
					width: 200px;
					">
				</h4>
				<?= DetailView::widget([
					'model' => $model,
					'attributes' => [
						[
							'attribute'=>'acoy.ac.ac_name',
							'label'=>'ชื่อกิจกรรม'
						],

						[
							'attribute'=>'result',
							'label'=>'ผลประเมิน',
							'value'=>function($model){
								$arr=[
									''=>'',
									'ผ'=>'ผ่าน',
									'ม.ผ.'=>'ไม่ผ่าน'
								];
								return $arr[$model->result];
							}
						],
						[
							'attribute'=>'acen_id',
							'label'=>'วันที่ทำกิจกรรม',
							'value'=>function($model){
								$data=ActivityEnterDetail::find($model->acen_id)->asArray()->all();
								$text;
								foreach ($data as $key=> $value) {
									if($key==0){
										$text=Yii::$app->Func->dateThai2($value['acend_date']);
										continue;
									}
									$text.='<br>'.Yii::$app->Func->dateThai2($value['acend_date']);	
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
