<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">

        <div class="card ">
            <div class="card-body ">

                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <div class="container-fluid" >
                    <div class="row">
                        <div class="col-lg-12" style="text-align:center">
                            <h1><?= Html::encode($this->title) ?></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12"><?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <?= $form->field($model, 'email') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <?= $form->field($model, 'password')->passwordInput() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
