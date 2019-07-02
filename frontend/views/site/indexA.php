<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\helpers\Html as Html2;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;
use yii\web\View;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model backend\models\Branch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branch-form">

    <div class="container-fluid">
        <?php $form = ActiveForm::begin(['method' => 'post','action'=>Url::to(['service/qrcode'])]); ?>
       
            

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= Html::textInput('qrcode', 'A62111 1 2019-06-13', ['class' => 'form-control']) ?>

            </div>
        </div>
          <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-2">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= Html::textInput('id', '63', ['class' => 'form-control']) ?>

            </div>
        </div>




        <div class="form-group">
            <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
