<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityOfyearDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-ofyear-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'acoyd_id') ?>

    <?= $form->field($model, 'acoy_id') ?>

    <?= $form->field($model, 'ac_startdate') ?>

    <?= $form->field($model, 'ac_enddate') ?>

    <?= $form->field($model, 'address_detail') ?>

    <?php // echo $form->field($model, 'detail') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
