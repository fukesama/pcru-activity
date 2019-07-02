<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\EduBackground */

$this->title = "รายละเอียดหลักสูตร";
$this->params['breadcrumbs'][] = ['label' => 'หลักสูตร', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="edu-background-view">
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
                    <a href="<?=Url::to(['update', 'id' => $model->edub_id])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style=""><i class="material-icons" style="font-size: 30px">create</i><?=$add?></a>
                </div>
                <div class="btn btnhover btn-danger" style="">
                    <?php $add='ลบ ( '.$this->title.' )' ?>
                    <?= Html::a(Yii::t('app', '<i class="material-icons" style="font-size: 30px">delete</i>'.$add.'</a>'), ['delete', 'id' => $model->edub_id], [
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
                        // 'edub_id',
                        'edub_name',
                        'edub_code',

                    ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
