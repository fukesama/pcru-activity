<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserCollegianSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-collegian-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'student_id') ?>

    <?= $form->field($model, 'prefix') ?>

    <?= $form->field($model, 'branch_id') ?>

    <?= $form->field($model, 'faculty_id') ?>

    <?= $form->field($model, 'education_id') ?>

    <?php // echo $form->field($model, 'address') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
