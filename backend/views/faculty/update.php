<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Faculty */

$this->title = 'แก้ไขข้อมูลคณะ: ' . $model->faculty_id;
    $this->params['breadcrumbs'][] = ['label' => 'จัดการข้อมูลคณะ', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->faculty_id, 'url' => ['view', 'id' => $model->faculty_id]];
    $this->params['breadcrumbs'][] = 'Update';
    ?>
    <div class="faculty-update">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="orange">
                        <i class="glyphicon glyphicon-pencil"  style="display:block;float:left;"></i>
                        <h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
                            <?= Html::encode($this->title) ?>
                        </h4>
                    </div>
                    <div class="card-content">
                        <h4 class="title" style="font-weight:bold;display:inline-block;float:left;text-align:left;width: 200px;">
                        </h4>


                    </div>
                    <br><br>

                    <?= $this->render('_form', [
                    'model' => $model,
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
