<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityOfyearSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-ofyear-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'acoy_id') ?>

    <?= $form->field($model, 'ac_id') ?>

    <?= $form->field($model, 'edu_level') ?>

    <?= $form->field($model, 'point') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
