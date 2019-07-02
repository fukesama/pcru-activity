<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserCollegian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-collegian-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'prefix')->textInput() ?>

    <?= $form->field($model, 'branch_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'faculty_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'education_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'บันทึก'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
