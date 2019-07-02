<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use \yii\web\Request;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'ผู้ใช้', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-view">
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
                    <a href="<?=Url::to(['update', 'id' => $model->id])?>" id="add"  title="<?=$add?>" style="">
                        <i class="material-icons" style="font-size: 30px">create</i>
                        <?=$add?>
                </a>
                </div>
                <div class="btn btnhover btn-danger" style="">
                    <?php $add='ลบ ( '.$this->title.' )' ?>
                    <?= Html::a(Yii::t('app', '<i class="material-icons" style="font-size: 30px">delete</i>'.$add.'</a>'), ['delete', 'id' => $model->id], [
                        'data' => [
                            'confirm' => Yii::t('app', 'คุณต้องการที่จะลบรายการนี้ใช่หรือไม่?'),
                            'method' => 'post',
                        ],
                    ]
                ) ?>
            </div>
            <?php 
            $array=[
                'model' => $model,
                'attributes' => [
                    // [
                    //     'attribute'=>'id',
                    //     'label'=>'รหัสผู้ใช้'
                    // ],
                    'username',
                    [
                        'attribute'=>'level_user',
                        'value'=>function($model){
                            return Yii::$app->Func->Level($model->level_user);
                        }
                    ],

                ]
            ];
            if($model->level_user==='1'){
                array_push(
                    $array['attributes'],
                    [
                      'label'=>'ชื่อ',
                      'value'=>function($model)
                      {
                        return $model->userOfficer->pre->pre_name.' '.$model->userOfficer->uo_fname.' '.$model->userOfficer->uo_lname;
                    }   
                ]
            );
            }
            else if($model->level_user==='2'){
                array_push(
                    $array['attributes'],
                    [
                       'label'=>'ชื่อ',
                       'value'=>function($model)
                       {
                        return $model->userCollegian->pre->pre_name.' '.$model->userCollegian->uc_fname.' '.$model->userCollegian->uc_lname;
                    }   
                ]
                ,                  
                [
                    'attribute'=>'userCollegian.fac.faculty_name',
                    'label'=>'คณะ'
                ],
                [
                    'attribute'=> 'userCollegian.bra.branch_name'
                    ,
                    'label'=>'สาขา'
                ]

            );
            }
                // array_push(
                //     $array['attributes'],
                //     'created_at:dateTime',
                //      'updated_at:dateTime'
                  

                // );

                //print_r($array)
            ?>
            <?php echo DetailView::widget($array) ?>
        </div>
    </div>
</div>
</div>
</div>
