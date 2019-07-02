<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Faculty */

$this->title = $model->faculty_id;
$this->params['breadcrumbs'][] = ['label' => 'Faculties', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faculty-view">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-stats">
                <div class="card-header" data-background-color="orange">
                    <i class="material-icons"  style="display:block;float:left;">list</i>
                    <h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
                        <?= Html::encode($this->title); ?>
                    </h4>
                </div>
                <div class="card-content">
                    <h4 class="title" style="font-weight:bold;
                    display:inline-block;
                    float:left;
                    text-align:left;
                    width: 200px;
                    ">
                </h4>
                <div class="btn btnhover btn-warning" style="">
                    <?php $add='แก้ไข ( '.$this->title.' )' ?>
                    <a href="<?=Url::to(['update', 'id' => $model->faculty_id])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style=""><i class="material-icons" style="font-size: 30px">create</i><?=$add?></a>
                </div>
                <div class="btn btnhover btn-danger" style="">
                    <?php $add='ลบ ( '.$this->title.' )' ?>
                    <?= Html::a(Yii::t('app', '<i class="material-icons" style="font-size: 30px">delete</i>'.$add.'</a>'), ['delete', 'id' => $model->faculty_id], [
                    'data' => [
                    'confirm' => Yii::t('app', 'คุณต้องการที่จะลบรายการนี้ใช่หรือไม่?'),
                    'method' => 'post',
                    ],
                    ]
                    ) ?>
                </div>

                <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                            'faculty_id',
            'faculty_name',
                ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
</div>
