<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserCollegianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'User Collegians');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.form-group {
    padding-bottom: none;
    margin: 0 0 0 0;
}
</style>
<div class="user-collegian-index">


    <a name="run" value='go'/>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-stats">
                <div class="card-header" data-background-color="purple">
                    <i class="material-icons"  style="display:block;float:left;">list</i>
                    <h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
                        <?= Html::encode($this->title) ?>                    </h4>
                </div>
                <div class="card-content">
                    <h4 class="title" style="font-weight:bold;
                    display:inline-block;
                    float:left;
                    text-align:left;
                    width: 200px;
                    ">

                </h4>

                <div class="btnhover" style="">
                    <?php $add='เพิ่ม'.Html::encode($this->title) ?>
                    <a href="<?=Url::to(['create'])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style=""><i class="material-icons" style="font-size: 30px">add_box</i><?=$add?></a>
                </div>
            </div>
            <br>
            <div class="container-fluid">
                <div class="table-responsive" style='margin-bottom:10px'>
                                            <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
        'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                                    'student_id',
            'prefix',
            'branch_id',
            'faculty_id',
            'education_id',
            //'address',

                        ['class' => 'yii\grid\ActionColumn'],
                        ],
                        ]); ?>
                                                        </div>
            </div>
        </div>
    </div>
</div>
</div>
