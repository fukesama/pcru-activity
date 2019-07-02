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
use yii2fullcalendar\yii2fullcalendar;

use backend\models\ActivityEnter;
use yii2fullcalendar\models\Event;
use backend\models\ActivityOfyearDetail;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivityEnterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ปฏิทินการเข้าร่วมกิจกรรม';
if($id==''){
	$this->title.='รวม';
}
else{
	$this->title.='ของฉัน';
}
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
				<br>
				<div class="container-fluid" style="max-width: 500px;">
					<?php 
				// print_r($events);

					echo yii2fullcalendar::widget([
						'options' => [
							'lang' => 'th',    
						],
						'events' => $events
					]) 
					?>
				</div>
				
			</div>
		</div>
	</div>
</div>


