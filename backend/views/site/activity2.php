<?php

use yii\helpers\Html;

use yii\helpers\Url;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\grid\GridView;

use yii\widgets\ActiveForm;
use frontend\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use backend\models\Assetcate;
use backend\models\Assetsubcate;
use backend\models\Asset;
use frontend\models\Repiar;
use kartik\depdrop\Depdrop;

use yii\widgets\MaskedInput;
use kartik\widgets\FileInput;
use yii\web\View;
use yii\helpers\Json;
use kartik\widgets\DatePicker;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use kartik\daterange\DateRangePicker;
use backend\models\ActivityOfyear;




/* @var $this yii\web\View */
/* @var $searchModel app\models\CarerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title='รายงานกิจกรรม';
//$this->params['breadcrumbs'][] = $this->title;

//echo Yii::$app->until->FiscalStart().'<br/>'.Yii::$app->until->FiscalEnd();
Modal::begin(['id'=>'modal','header'=>'<h4 class"text-center"> หัวหน้าหรือผู้จัดการอนุมัติเอกสาร</h4>','size'=>'modal-lg']);
echo '<div id="modalContent"></div>';
Modal::end();


?>
<style type="text/css">
    #excel{
        border-color:#008D4C;
        transition: 0.8s;
        color:#008D4C;
    }
    #excel:hover{
        background-color:#008D4C;
        color:#fff; 
    }
</style>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','enableAjaxValidation'=>false,]]); ?>
<?php //echo $data ?>
<div class="container-fluid">
    <div class="card">
        <div class='row'>
          <div class="col-md-3">

            <br>

            <?php 
            $model=(new ActivityOfyear);
            $data=ArrayHelper::map($model->find()->all(),'acoy_id','ac.ac_name','year');
            ;
            echo Select2::widget([
                'model' => $model,
                'id'=>'acoy_id',
                'attribute' => 'acoy_id',
                'data' => $data,
                'options' => ['placeholder' => 'เลือกกิจกรรม'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>


        </div>           

        <div class="col-md-3">
            <br>    
            <?php 
            use backend\models\Faculty;
            $model=(new Faculty);
            $data=ArrayHelper::map($model->find()->all(),'faculty_id','faculty_name');

            echo Select2::widget([
                'model' => $model,
                'id'=>'faculty_id',
                'attribute' => 'faculty_id',
                'data' => $data,
                'options' => ['placeholder' => 'เลือกคณะ'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div class="col-md-3">
            <br>
            <?php 
            use backend\models\Branch;
            $model=(new Branch);
            $data=ArrayHelper::map($model->find()->all(),'branch_id','branch_name');
            ;
            echo Select2::widget([
                'model' => $model,
                'id'=>'branch_id',
                'attribute' => 'branch_id',
                'data' => $data,
                'options' => ['placeholder' => 'เลือกสาขา'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <div  class="col-md-2 col-lg-2 col-xs-2">

            <?= Html::submitButton('<i class="fa fa-search" aria-hidden="true"></i>&nbsp; ค้นหา', ['class' => 'btn btn-success btn-block','id'=>'btn']) ?>


            <?php ActiveForm::end(); ?>&nbsp;
            <?php // Html::a('<i class="fa fa-file-excel-o"></i> &nbsp;EXCEL', ['excel','model'=>$textquery], ['class' => 'btn','id'=>'excel','style'=>'display:block;font-weight:bold;float:left;margin-left:5px;']) ?>
        </div>


    </div>
</div>

<div >
    <div class="table-responsive" style='margin-bottom:10px'>

        <?php 

        $layout ='
        <div class="pull-right">
        {summary}
        </div>
        {custom}
        <div class="clearfix"></div>
        {items}
        {pager}';



        echo GridView::widget([
            'dataProvider'=> $dataProvider,
            'filterModel' => $searchModel,
            'class'=>'card',
            'columns' => [
             ['class' => 'yii\grid\SerialColumn'],

             [
                'attribute'=>'acoy_id',
                'header'=>'รหัสกิจกรรม',
                'filter'=>'',
                'headerOptions'=>[
                    'width'=>'150px'
                ]
            ],
            [
                'attribute'=>'acoy.ac.ac_level',
                'header'=>'ชั้นปีที่',
                'headerOptions'=>[
                    'width'=>'60px'
                ]
            ],
            [
                'attribute' => 'acoy_id',
                'width' => '',
                'header'=>'รหัสกิจกรรมตามปีการศึกษา'    ,
                'value' => function ($model, $key, $index, $widget) {
                    return $model->acoy->ac->ac_name;
                },
                
                'filter'=>Select2::widget([         
                    'model' => $searchModel,
                    'attribute' => 'acoy_id',
                    'data' => ArrayHelper::map(backend\models\ActivityOfyear::find()
                        ->joinWith('ac as ac')->all()
                        ,'acoy_id','ac.ac_name','year')
                    ,
                    'options' => ['placeholder' => 'เลือกกิจกรรม']
                ]),
                'filterWidgetOptions' =>
                [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'กิจกรรม'],

                'headerOptions'=>['class'=>'text-center'],
                'contentOptions'=>['style'=>'vertical-align: middle']
            ],
            [
                'attribute'=>'co.pre.pre_name',
                'label'=>'คำนำหน้า'


            ],
            [
                'attribute'=>'co.uc_fname',
                'label'=>'ชื่อ'
            ],
            [
                'attribute'=>'co.uc_lname',
                'label'=>'นามสกุล'
            ],
            [
                'attribute'=>'co.fac.faculty_name',
                'label'=>'คณะ'
            ]
            ,
            [
                'attribute'=>'co.fac.faculty_name',
                'label'=>'สาขา'
            ]

        ],
        'options' =>['class' => 'table table-striped table-bordered text-nowrap'],
        'layout' => $layout,
        'panel'=>['before'=>' ' ],  
        'replaceTags' => [
            '{custom}' => function($widget) {

                if ($widget->panel === false) {
                    return '';
                } else {
                    return '';
                }
            }
        ],

    ]); 
    ?>
</div>
</div>
</div>
<?php 
$js=<<<JS
// $('#activityofyear-acoy_id,#faculty_id,#branch_id').change(function(){
//     if($('#activityofyear-acoy_id').val()!=''&& $('#faculty-faculty_id').val()!=''&&$('#branch-branch_id').val()!='')
//     {
//         $('#btn').removeAttr('disabled');
//     }
//     else{
//         $('#btn').attr('disabled',true);
//    }
//    console.log($('#activityofyear-acoy_id').val()!=''&& $('#faculty-faculty_id').val()!=''&&$('#branch-branch_id').val()!='')
// }
// )
JS;
$this->registerJs($js,View::POS_READY);
?>

