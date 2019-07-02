<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use yii\web\View;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use frontend\models\Files;
use backend\models\UserCollegian;
use backend\models\User;

use backend\models\Faculty;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ผู้ใช้');
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

<div class="user-index">


	<?php Pjax::begin(); ?>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>


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
						&nbsp;
					</h4>
					<div style="display: inline-block;width:627px">
						<?php $model = new Files(); ?>
						
						
						<div style="background-color: white;color: black;border: 2px solid #4CAF50;width: 500px;display:inline-block;float:left;border-radius: 5px;">
							<?php $model = new Files(); ?>
							<?php $form = ActiveForm::begin(['action'=>['user/add']]); ?>

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
						<a href="<?=Url::to(['create'])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style="display:inline-block;float:left;border:2px solid #9C27B0;border-radius: 5px;margin-left: 2px;">
							<div class="btn btn-primary" style="margin:0;">
								<i class="material-icons">add_box</i><?=$add?>
							</div>
						</a>
					</div>
					
					
				</div>
				<div class="container-fluid">
					<div class="table-responsive" style='margin-bottom:10px'>
						<?=
						GridView::widget(
							[
								'dataProvider' => $dataProvider,
								'filterModel' => $searchModel,
								'class'=>'table ',
								'columns' =>
								[
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
										'attribute' => 'username',
										
										'filterInputOptions' => [
											'class'       => 'form-control',
											'placeholder' => 'ชื่อผู้ใช้'
										],
										
										'headerOptions'=>['class'=>'text-center']
									],
									[
										'attribute'=>'level_user',
										'label'=>'สถานะผู้ใช้',
										'value'=>function($model){
											return Yii::$app->Func->Level($model->level_user);
										},
										'filter'=>Html::activeDropDownList($searchModel, 'level_user',
											Yii::$app->Func->ArrayLevel()
											,['prompt' => 'เลือก','class'=>'form-control','style'=>['text-indent: calc(50% - 1em);']]),
										'options'=>['width'=>'100px'],
										'contentOptions'=>['align'=>'center','width'=>'100px'],
										'headerOptions'=>['width'=>'100px']
									],
									Yii::$app->Func->AcColumn('user')
								],
							]
						); ?>
						<?php Pjax::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$js=<<<JS
// $('#fileToUpload').change(
// function(){
// 	if($(this).val()!==''){
// 		$('#recExcel').removeAttr('disabled');
// 	}
// 	else{
// 		$('#recExcel').attr('disabled','disabled');
// 	}

// }
// )
JS;
$this->registerJs($js,View::POS_READY);
?>
