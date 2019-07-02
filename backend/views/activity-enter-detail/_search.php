<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityEnterDetailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-enter-detail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'acend_id') ?>

    <?= $form->field($model, 'acen_id') ?>

    <?= $form->field($model, 'qrcode') ?>

    <?= $form->field($model, 'acend_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
