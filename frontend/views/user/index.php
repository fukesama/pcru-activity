<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use yii\web\View;
use yii\helpers\Json;


/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ผู้ใช้');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
.form-group,.btn-group {
    padding-bottom: none;
    margin: 0 0 0 0;
}
.btm{
    margin:0px;
}
.btn.btn-xs{
    padding: 4px 6px
}


</style>

<div class="user-index">


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <div class="row">
        <div class="col-lg-12">
            <div class="card card-stats">

                <div class="card-header" data-background-color="purple">
                    <i class="material-icons"  style="display:block;float:left;">list</i>
                    <h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
                        <?= Html::encode($this->title) ?>
                    </h4>
                </div>
                <div class="card-content">
                    <h4 class="title" style="font-weight:bold;display:inline-block;float:left;text-align:left;width: 200px;">
                    </h4>

                    <?php $add='เพิ่ม'.Html::encode($this->title) ?>
                    <a href="<?=Url::to(['create'])?>" id="add" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style="">
                        <div class="btn btn-primary" style="">
                            <i class="material-icons">add_box</i><?=$add?>
                        </div>
                    </a>
                </div>
                <div class="container-fluid">
                    <div class="table-responsive" style='margin-bottom:10px'>
                        <?=
                        GridView::widget(
                            [
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
                                'class'=>'table ',
                                'columns' =>
                                [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    'username',
                                    [
                                        'attribute'=>'level_user',
                                        'label'=>'สถานะผู้ใช้',
                                        'value'=>function($model){
                                            return $model->level_user!==''||$model->level_user==null?Yii::$app->Func->Level($model->level_user):'';
                                        },
                                        'filter'=>Html::activeDropDownList($searchModel, 'level_user',
                                        Yii::$app->Func->ArrayLevel()
                                        ,['prompt' => 'เลือก','class'=>'form-control','style'=>['text-indent: calc(50% - 1em);']]),
                                        'options'=>['width'=>'100px'],
                                        'contentOptions'=>['align'=>'center']
                                    ],
                                     Yii::$app->Func->AcColumn('user')
                                ],
                            ]
                        ); ?>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js=<<<JS

JS;
$this->registerJs($js,View::POS_READY);
?>
