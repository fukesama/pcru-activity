<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityEnter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-enter-form">

    <div class="container-fluid">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <?= $form->field($model, 'acoy_id')->textInput(['maxlength' => true]) ?>
</div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <?= $form->field($model, 'co_id')->textInput() ?>
</div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <?= $form->field($model, 'enter_status')->dropDownList([ 2 => '2', 1 => '1', ], ['prompt' => '']) ?>
</div>
                </div>
                        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
