<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Json;

use \yii\web\Request;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;


function mapdata($data,$id,$name,$no){
    return Yii::$app->Func->MapDataDropDown($data,$id,$name,$no);
}

/* @var $this yii\web\View */
/* @var $model backend\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>
<style media="screen">
    .nowarp{
        display: block;float: left;width: 14px;
        text-align: right;
        border:1px solid #D7D7D7;
    }
    .nowarp:first-child{
        display: block;float: left;width: 16px;
        text-align: right;
        border:1px solid #D7D7D7;
    }
    div label.control-label{
        font-size: 14px;float: left;
    }
</style>
<div class="activity-form">

    <div class="container-fluid">
        <?php $form = ActiveForm::begin(); ?>
        <?php
        if(isset($model->ac_id)){

        }
        ?>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2"></div>
            <div class="col-lg-2 col-md-2 col-sm-2">
                <label class="control-label" for="activity-cate_id" style="fontfont-size: 16px">รหัสกิจกรรม</label>
                <br><br>
                <div class="nowarp"><input type="text" name="dp[1]" class="form-control"  readonly></div>
                <div class="nowarp"><input type="text" name="dp[2]" class="form-control"  readonly></div>
                <div class="nowarp"><input type="text" name="dp[3]" class="form-control"  readonly></div>
                <div class="nowarp" style="width: 20px">
                    <input type="text" name="dp[4]" class="form-control"  readonly >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= $form->field($model, 'cate_id')->dropDownList(MapData(\backend\models\ActivityCate::find()->all(), 'cate_id', 'cate_name','cate_id'),['prompt'=>'กรุณาเลือกประเภทของกิจกรรม']) ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= $form->field($model, 'type_id')->dropDownList(MapData(\backend\models\ActivityType::find()->all(), 'type_id', 'type_name','type_id'),['prompt'=>'กรุณาเลือกชนิดของกิจกรรม']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">

                <?= $form->field($model, 'side_id')->dropDownList(mapdata(\backend\models\ActivitySide::find()->all(), 'side_id', 'side_name','side_id'),['prompt'=>'กรุณาเลือกด้านของกิจกรรม']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= $form->field($model, 'ac_id')->hiddenInput([])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= $form->field($model, 'ac_num')->textInput(['placeholder'=>'กรุณากรอกลำดับกิจกรรม',])->label('ลำดับกิจกรรม'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= $form->field($model, 'ac_level')->dropDownList([1=>'ชั้นปีที่ 1',2=>'ชั้นปีที่ 2',3=>'ชั้นปีที่ 3',4=>'ชั้นปีที่ 4',5=>'ชั้นปีที่ 5'],['prompt'=>'กรุณาเลือกชั้นปี'])->label('ชั้นปี') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= $form->field($model, 'ac_name')->textInput(['placeholder'=>'กรุณากรอกชื่อกิจกรรม/โครงการ','maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?php 
                $model->ac_time=1;
                ?>
                <?= $form->field($model, 'ac_time')->textInput(['placeholder'=>'กรุณากรอกชั่วโมงกิจกรรม','type'=>'number']) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$js=<<<JS
function addNum(val){
    if(val.length==1){
        val='0'.concat(val);
    }
    return val;
}
function sumCode(){
    var code=$("[name='dp[1]']").val()+$("[name='dp[2]']").val()+$("[name='dp[3]']").val()+$("[name='dp[4]']").val();
    $('#activity-ac_id').val(code);
}

JS;
$this->registerJs($js,View::POS_HEAD);
$js=<<<JS


$("[name^='Activity']").change(function(){
    _1st();
}
);
$("[name='Activity[ac_num]']").keyup(function(){
    _2nd($(this).val());
}
);

JS;
$this->registerJs($js,View::POS_READY);
$js=<<<JS
function _1st(){
    $("[name='dp[1]']").val($("[name*='Activity[cate_id]']").val());
    $("[name='dp[2]']").val($("[name*='Activity[type_id]']").val());
    $("[name='dp[3]']").val($("[name*='Activity[side_id]']").val());
    sumCode();
}
function _2nd(val){
    $("[name='dp[4]']").val(addNum(val));
    sumCode();
}
_1st();
_2nd($("[name*='Activity[ac_num]']").val());
JS;
$this->registerJs($js,View::POS_END);
?>
