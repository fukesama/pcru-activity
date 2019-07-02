<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-stats">
                <div class="card-header" data-background-color="orange">
                    <i class="material-icons"  style="display:block;float:left;">list</i>
                    <h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
                        <?='<'?>?= Html::encode($this->title); ?>
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
                    <?='<'?>?php $add='แก้ไข ( '.$this->title.' )' ?>
                    <a href="<?='<'?>?=Url::to(['update', <?= $urlParams ?>])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?='<'?>?=$add?>" style=""><i class="material-icons" style="font-size: 30px">create</i><?='<'?>?=$add?></a>
                </div>
                <div class="btn btnhover btn-danger" style="">
                    <?='<'?>?php $add='ลบ ( '.$this->title.' )' ?>
                    <?='<'?>?= Html::a(Yii::t('app', '<i class="material-icons" style="font-size: 30px">delete</i>'.$add.'</a>'), ['delete', <?= $urlParams ?>], [
                    'data' => [
                    'confirm' => Yii::t('app', 'คุณต้องการที่จะลบรายการนี้ใช่หรือไม่?'),
                    'method' => 'post',
                    ],
                    ]
                    ) ?>
                </div>

                <?= "<?= " ?>DetailView::widget([
                'model' => $model,
                'attributes' => [
                <?php
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                        echo "            '" . $name . "',\n";
                    }
                } else {
                    foreach ($generator->getTableSchema()->columns as $column) {
                        $format = $generator->generateColumnFormat($column);
                        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                }
                ?>
                ],
                ]) ?>
            </div>
        </div>
    </div>
</div>
</div>
