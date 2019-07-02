<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'ลงชื่อเข้าใช้';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">  
        <div class="col-lg-3"></div>      
        <div class="col-lg-6" style="margin-left: auto;margin-right: auto;display: block;">

            <!-- <div class="card"  style="
            background-image: url(<?= Url::to(['backend/web/img/sidebar-1.jpg'])?>);  
            background-repeat: no-repeat, repeat;
            background-position: center;
            background-size: cover;"> -->
            <div class="card">
            <div class="card-header" data-background-color="purple">
                <h4 class="title"><?= Html::encode($this->title) ?></h4>                   
            </div>
            <div class="card-content table-responsive">
               <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

               <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Username หรือ Email') ?>

               <?= $form->field($model, 'password')->passwordInput() ?>

               <?= $form->field($model, 'rememberMe')->checkbox()->label('จำฉันไว้'); ?>

               <!--   <div style="color:#999;margin:1em 0">
                    ถ้าคุณลืมรหัสผ่าน <?= Html::a('รีเซ็ตรหัสผ่าน', ['site/request-password-reset']) ?>.
                </div> -->

                <div class="form-group">
                    <?= Html::submitButton('ลงชื่อเข้าใช้', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>

