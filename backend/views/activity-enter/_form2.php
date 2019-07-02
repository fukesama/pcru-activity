<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityEnter */
/* @var $form yii\widgets\ActiveForm */

function mapdata($data,$id,$name,$no){

    return Yii::$app->Func->MapDataDropDown($data,$id,$name,$no);
}
?>

<div class="activity-enter-form">

    <div class="container-fluid">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= $form->field($model, 'acoy_id')
                ->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\backend\models\ActivityOfyearDetail::find()
                    ->innerJoinWith('ac')->all(), 'acoyd_id', 'acoy.ac.ac_name'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'กรุณาเลือกกิจกรรม'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])
                ->label('กิจกรรม') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= $form->field($model, 'co_id')
                ->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\backend\models\User::find()->where(['level_user'=>'2'])->all(), 'id', 'username'),
                    'language' => 'th',
                    'options' => ['placeholder' => 'กรุณาเลือกกิจกรรม'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])
                ->label('รหัสนักศึกษา') ?>
            </div>
        </div>
        <?php
        if(isset($model->enter_status)&&!empty($model->enter_status)):?>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?=$form->field($model, 'enter_status')->dropDownList([ 2 => 'เข้าร่วมแล้ว', 1 => 'ยังไม่ได้เข้าร่วม', ], ['prompt' => 'เลือกสถานะการเข้าร่วม']);?>

            </div>
        </div>
        <?php
        endif ?>
        <?php
        if(isset($model->results)&&$model->results!==null):?>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= $form->field($model, 'results')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <?php
        endif ?>

        <div class="form-group">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
