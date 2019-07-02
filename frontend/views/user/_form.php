<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <div class="container-fluid">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>                
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'status')->textInput() ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'level_user')->dropDownList([ 2 => '2', 1 => '1', 0 => '0', ], ['prompt' => '']) ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'created_at')->textInput() ?>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">    <?= $form->field($model, 'updated_at')->textInput() ?>

            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
