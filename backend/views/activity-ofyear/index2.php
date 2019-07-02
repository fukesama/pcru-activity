<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;

use yii\web\View;
use yii\helpers\Json;

use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ActivityOfyearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'วันที่ดำเนินกิจกรรม';
$this->params['breadcrumbs'][] = $this->title;

$GLOBALS['num']=0;
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
<div class="activity-ofyear-index">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-stats">
                <div class="card-header" data-background-color="purple">
                    <i class="material-icons"  style="display:block;float:left;">list</i>
                    <h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
                        <?= Html::encode($this->title) ?>                    </h4>
                    </div>
                    <div class="card-content">

                        <?php $add='Generate QR Code' ?>

                        <a href="<?=Url::to(['pre-qrcode'])?>" class="modalButton"  title="<?=$add?>" style="pointer-events: none;">
                            <div class="btn btn-default" style="">
                                <i class="fa fa-qrcode"></i>    <?=$add?>
                            </div>
                        </a>
                        <?php
                        Modal::begin([
                            'id' => 'modal',
                            'size' => 'modal-lg',

                        ]);
                        echo "<div class='modalContent'></div>";
                        Modal::end();
                        ?>

                        <?php $add='เพิ่ม'.Html::encode($this->title) ?>

                        <?php echo  Html::a('<div class="btn btn-primary">
                        <i class="material-icons">add_box</i>'.$add.'
                        </div>',['activity-of-year/create'], [
                            'id' => 'activity-create-link',
                            'data-toggle' => 'modal',
                            'data-target' => '#activity-modal',

                        ]); ?>
                        <a href="<?=Url::to(['create'])?>" id="activity-create-link" data-toggle="tooltip" data-placement="top" title="<?=$add?>" style="">

                        </a>

                        <?php Modal::begin([
                            'id' => 'activity-modal',
                            'size'=>'modal-lg',
                        ]);
                        Modal::end();
                        ?>
                    </div>
                    <br>
                    <div class="container-fluid">
                        <div class="table-responsive" style='margin-bottom:10px'>
                            <?php Pjax::begin(['id'=>'customer_pjax_id']); ?>
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,

                                'responsive' => true,
                                'hover' => true,

                                'pjax'=>true,
                                'pjaxSettings'=>[
                                    'neverTimeout'=>true,
                                    'enablePushState' => false,
                                    'options' => ['id' => 'CustomerGrid'],
                                ],

                                'columns' => [

                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' =>"<input type='checkbox' id='checkall'> All",
                                        'options' => ['width' => '15px'],

                                        'contentOptions'=>['width' => '15px','noWrap' => true],
                                        'buttonOptions'=>['class'=>'btn btn-default'],
                                        'template'=>'<center width="100%" style="">{print}</center>',
                                        'buttons'=>[

                                            'print'=>function($url,$model,$key){
                                                $GLOBALS['num']!=''?$GLOBALS['num'].=','.$model->acoy_id:$GLOBALS['num'].=$model->acoy_id;
                                                return "<input type='checkbox' name='check' id='check$model->acoy_id' value='$model->acoy_id'>";
                                            }
                                        ],
                                        'visible' => true

                                    ],
                                    ['class' => 'yii\grid\SerialColumn'],
                                    'acoy_id',
                                    'year',
                                    'ac.ac_name',
                                    'ac_startdate',
                                    'ac_enddate',
                                    //'ac_starttime',
                                    //'ac_endtime',
                                    //'address_detail',
                                    [
                                        'format'=>'raw',
                                        'label'=>'Qr Code',
                                        'value'=>function($model){
                                            $text=Yii::$app->Func->encode($model->acoy_id.' 51');
                                            return Html::a('<i class="fa fa-qrcode" aria-hidden="true"></i>', ['qrcode','id'=>$text], ['target' => '_blank','class' => 'btn btn-xs btn-primary'])
                                            .Html::a('<i class="fa fa-print" aria-hidden="true"></i>',
                                            ['print','id'=>$text], ['target' => '_blank','class' => 'btn btn-xs btn-success']);
                                        }
                                    ],

                                    // Yii::$app->Func->AcColumn(),
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'buttons' => [
                                            'view' => function ($url, $model, $key) {
                                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>','#', [
                                                    'class' => 'activity-view-link',

                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#activity-modal',
                                                    'data-id' => $key,
                                                    'data-pjax' => '0',

                                                ]);
                                            },
                                            'update' => function ($url, $model, $key) {
                                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>','#', [
                                                    'class' => 'activity-update-link',

                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#activity-modal',
                                                    'data-id' => $key,
                                                    'data-pjax' => '0',

                                                ]
                                            );
                                        },

                                    ]
                                ],

                            ],
                        ]); ?>
                        <?php Pjax::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
//หาหน้าเว็ปปัจจุบัน
$pageURLNow = (string)$_SERVER["REQUEST_URI"];
$pageURLNow = explode("/",$pageURLNow);
$k = count($pageURLNow);
$pageURLNow = $pageURLNow[$k-1];
///ตัวแปรรับค่าหน้าที่ต้องการไปแสดง/////
$pageGo="complete";
///ตัวแปรรับค่าหน้าที่ต้องการไปแสดง/////
$r="";

$js=<<<JS
$(function(){
    // changed id to class
    $('.modalButton').click(function (){
        $.get($(this).attr('href'), function(data) {
            $('#modal').modal('show').find('.modalContent').html(data)
        });
        return false;
    });
});
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

var count=[],text=0;
$('#checkall').on('click',function(){
    var array='$GLOBALS[num]'.split(',');
    var n=array.length-1;
    if(this.checked==true){
        count=[];
        text=0;
        while(n>=0){
            $('#check'+array[n]).prop('checked',true);
            count.push($('#check'+array[n]).val());
            text+=1;
            n--;
            $('#num').html(text);
        }
    }
    else{
        count=[];
        text=0;
        while(n>=0){
            $('#check'+array[n]).removeAttr('checked');
            $('#check'+array[n]).removeProp('checked');
            n--;
            $('#num').html(text);
        }
    }

}
);
$('#sendid').click(function(){
    if(count!=''){
        var text = "asset-check?data="+count;
        //alert(text);
        window.location=text;
    }
}
);
$('input[name*=check]').click(function(){})
$('input[name*=check]').change(
    function(){
        if(this.checked==true){
            count.push(this.value);
            n=count.length-1;
            text+=1;
            $('#num').html(text);
        }
        else{
            text-=1;
            count.remove(this.value);
            $('#num').html(text);
        }

    }
);

JS;
$this->registerJS($js,yii\web\View::POS_READY);
?>
<?php
$js=<<<JS
$('.modalButton').removeAttr( 'style' );
JS;
$this->registerJS($js,View::POS_END);
?>

<?php
$js=<<<JS

function init_click_handlers(){
    $("#activity-create-link").click(function(e) {

        $.get(
            "create",
            function (data)
            {
                $("#activity-modal").find(".modal-body").html(data);
                $(".modal-body").html(data);
                $(".modal-title").html("เพิ่มข้อมูลสมาชิก");
                $("#activity-modal").modal("show");
            }
        );
    });
    $(".activity-view-link").click(function(e) {
        var fID = $(this).closest("tr").data("key");
        $.get(
            "view",
            {
                id: fID
            },
            function (data)
            {
                $("#activity-modal").find(".modal-body").html(data);
                $(".modal-body").html(data);
                $(".modal-title").html("เปิดดูข้อมูลสมาชิก");
                $("#activity-modal").modal("show");
            }
        );
    });
    $(".activity-update-link").click(function(e) {
        var fID = $(this).closest("tr").data("key");
        $.get(
            "update",
            {
                id: fID
            },
            function (data)
            {
                $("#activity-modal").find(".modal-body").html(data);
                $(".modal-body").html(data);
                $(".modal-title").html("แก้ไขข้อมูลสมาชิก");
                $("#activity-modal").modal("show");
            }
        );
    });

}
init_click_handlers(); //first run
$("#customer_pjax_id").on("pjax:success", function() {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
$this->registerJs($js);
?>
