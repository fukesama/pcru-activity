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
use backend\models\Faculty;
use backend\models\EduBackground;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrachSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สาขา';
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
<div class="branch-index">
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
                                 [
                                    'header'=>'ลำดับ',

                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions'=>[
                                        'class'=>'text-center',
                                        'style' => 'width:50px;'
                                    ],
                                    'headerOptions'=>['class'=>'text-center']
                                ],

                                // [
                                //     'attribute' => 'branch_id',
                                //     'width'=>'150px',
                                //     'filterInputOptions' => [
                                //         'class'       => 'form-control',
                                //         'placeholder' => 'รหัสสาขา'
                                //     ],
                                //     'contentOptions'=>['class'=>'text-center'],
                                //     'headerOptions'=>['class'=>'text-center']
                                // ],
                                [
                                    'attribute' => 'branch_name',
                                    'width'=>'150px',
                                    'filterInputOptions' => [
                                        'class'       => 'form-control',
                                        'placeholder' => 'ชื่อสาขา'
                                    ],
                                    'contentOptions'=>['class'=>'text-left'],
                                    'headerOptions'=>['class'=>'text-center']
                                ],
                             /*   'branch_name',*/
                                [
                                    'attribute' => 'faculty_id', 
                                    'width' => '',
                                    'value' => function ($model, $key, $index, $widget) { 
                                        return $model->fac->faculty_name;
                                    },
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filter' => ArrayHelper::map(Faculty::find()->orderBy('faculty_name')->asArray()->all(), 'faculty_id', 'faculty_name'), 
                                    'filterWidgetOptions' => 
                                    [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'คณะ'],
                                    
                                    'headerOptions'=>['class'=>'text-center'],
                                    'contentOptions'=>['style'=>'vertical-align: middle']
                                ],
                               /* [
                                    'attribute'=>'faculty_id',
                                    'value'=>'faculty.faculty_name'
                                ],*/
                                [
                                    'attribute' => 'edub_id', 
                                    'width' => '',
                                    'value' => function ($model, $key, $index, $widget) { 
                                        return $model->edub->edub_name;
                                    },
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filter' => ArrayHelper::map(EduBackground::find()->orderBy('edub_name')->asArray()->all(), 'edub_id', 'edub_name'), 
                                    'filterWidgetOptions' => 
                                    [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'หลักสูตรการศึกษา'],
                                    
                                    'headerOptions'=>['class'=>'text-center'],
                                    'contentOptions'=>['style'=>'vertical-align: middle']
                                ],
                                /*[
                                    'attribute'=>'edub_id',
                                    'value'=>'edub.edub_name'
                                ],*/


                                Yii::$app->Func->AcColumn(),
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
