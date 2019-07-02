<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ac_id') ?>

    <?= $form->field($model, 'cate_id') ?>

    <?= $form->field($model, 'type_id') ?>

    <?= $form->field($model, 'side_id') ?>
    <?= $form->field($model, 'ac_year') ?>
    <?= $form->field($model, 'ac_num') ?>

    <?php // echo $form->field($model, 'ac_name') ?>

    <?php // echo $form->field($model, 'ac_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
