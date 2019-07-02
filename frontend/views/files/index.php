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
use frontend\models\Branch;
use frontend\models\UserCollegian;

use yii\widgets\ActiveForm;
use frontend\models\Files;




/* @var $this yii\web\View */
/* @var $searchModel frontend\models\FilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files';
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
<div class="files-index">
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
					<div style="background-color: white;color: black;border: 2px solid #4CAF50;width: 500px;display:inline-block;float:left;border-radius: 5px;">
						<?php $model = new Files(); ?>
						<?php $form = ActiveForm::begin(['action'=>['add'],'options'=>['target'=>'_blank']]); ?>

						<div class="row" style="width: 250px;display:block;float:left;">								
							<div class="col-lg-12 col-md-12 col-sm-12">
								<?= $form->field($model, 'file')->fileInput(['class'=>'','id'=>'fileToUpload','accept'=>'.xls,.xlsx'])->label('') ?>
							</div>
						</div>		
						<div style="width: 250px;display:block;float:right;margin:0;">					
							<?= Html::submitButton('เพิ่มนักศึกษาโดยใช้ไฟล์ EXCEL', ['class' => 'btn btn-success','style'=>'margin:0;','id'=>'recExcel']) ?>
						</div>
						<?php ActiveForm::end(); ?>
					</div>
					<?php $add='เพิ่ม'.Html::encode($this->title) ?>
					<a href="<?=Url::to(['create'])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style="">
						<div class="btn btn-primary" style="">
							<i class="material-icons">add_box</i><?=$add?>
						</div>
					</a>
				</div>
				<br>
				<?php echo Yii::getVersion(); ?>
				<div class="container-fluid">
					<div class="table-responsive" style='margin-bottom:10px'>
						<?= GridView::widget([
							'dataProvider' => $dataProvider,
							'filterModel' => $searchModel,
							'columns' => [
								['class' => 'yii\grid\SerialColumn'],

								'id',
								'file',

								Yii::$app->Func->AcColumn(),

							],
						]); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
