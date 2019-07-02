<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\SignupForm */
use kartik\widgets\DatePicker;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\web\View;
use yii\helpers\Json;

use \yii\web\Request;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;

$this->title = 'เพิ่มผู้ใช้งาน';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-stats">
            <div class="card-header" data-background-color="green">
                <i class="material-icons"  style="display:block;float:left;">add_box</i>
                <h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
                    <?= Html::encode($this->title) ?>
                </h4>
            </div>
            <div class="card-content">
                <h4 class="title" style="font-weight:bold;display:inline-block;float:left;text-align:left;width: 200px;">
                </h4>
            </div>
            <br><br>
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <?= $form->field($model2, 'level_user')
                        ->dropdownList(Yii::$app->Func->ArrayLevel(),['prompt'=>'เลือก','id'=>'level_user'])->label('ระดับผู้ใช้') ?>
                    </div>
                </div>
                <div class="row" name='officerRow' style="display:none">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 ">
                        <?php $data=ArrayHelper::map(\backend\models\Prefix::find()->all(), 'pre_id', 'pre_name'); ?>
                        <?= $form->field($modeluo, 'pre_id')->dropDownList($data,[ 'disabled' => 'disabled','prompt'=>'โปรดเลือกคำนำหน้า','name'=>'userofficer'])->label('คำนำหน้า');?>

                    </div>


                </div>

                <div class="row" name='officerRow' style="display:none">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 ">

                        <?= $form->field($modeluo, 'uo_fname')->textInput([ 'disabled' => 'disabled','placeholder'=>'โปรดกรอกชื่อ','name'=>'userofficer'])->label('ชื่อ')?>

                    </div>


                </div>
                <div class="row" name='officerRow' style="display:none">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <?= $form->field($modeluo, 'uo_lname')->textInput([ 'disabled' => 'disabled','placeholder'=>'โปรดกรอกสกุล','name'=>'userofficer'])->label('สกุล')?>
                    </div>
                </div>
                <div class="row" name='collegianRow' style="display:none">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 ">

                        <?= $form->field($modeluc, 'pre_id')->dropDownList($data,[ 'disabled' => 'disabled','prompt'=>'โปรดเลือกคำนำหน้า','name'=>'usercollegian'])->label('คำนำหน้า')?>

                    </div>


                </div>
                <div class="row" name='collegianRow' style="display:none">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <?= $form->field($modeluc, 'uc_fname')->textInput([ 'disabled' => 'disabled','placeholder'=>'โปรดกรอกชื่อ','name'=>'usercollegian'])->label('ชื่อ')?>
                    </div>
                </div>
                <div class="row" name='collegianRow' style="display:none">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <?= $form->field($modeluc, 'uc_lname')->textInput([ 'disabled' => 'disabled','placeholder'=>'โปรดกรอกสกุล','name'=>'usercollegian'])->label('สกุล')?>
                    </div>

                </div>

                <div class="row" name='collegianRow' style="display:none">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">

                        <?= $form->field($modeluc, 'faculty_id')->textInput(['maxlength' => true])
                        ->widget(kartik\select2\Select2::className(),
                        [
                            'data'=>ArrayHelper::map(backend\models\Faculty::find()
                            ->all(),'faculty_id','faculty_name'),
                            'options'=>[
                                'placeholder'=>'โปรดเลือกคณะ','required'=>'true',
                                'id'=>'ddl-faculty',
                            ],

                            'pluginOptions'=>['allowClear'=>true]
                        ]
                        )->label('คณะ')  ?>
                    </div>
                </div>
                <div class="row" name='collegianRow' style="display:none">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">

                        <?= $form->field($modeluc, 'branch_id')->widget(DepDrop::classname(), [
                            'options'=>['id'=>'ddl-branch'],
                            'data'=> [],
                            'type'=>DepDrop::TYPE_SELECT2,
                            'pluginOptions'=>[
                                'initialize' => false,
                                'depends'=>['ddl-faculty'],
                                'placeholder'=>'โปรดเลือกสาขา',
                                'url'=>Url::to(['/user/get-branch'])
                            ]
                        ]); ?>
                    </div>

                </div>
                <div class="row" name='collegianRow' style="display:none">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <?= $form->field($modeluc, 'address')->textarea([ 'disabled' => 'disabled','name'=>'usercollegian','rows' => '6','style' => 'resize:none'])->label('ที่อยู่')?>
                    </div>

                </div>
                <div class="row" name='user' style="display:none">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8"><?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'โปรดกรอกชื่อผู้ใช้']) ?>
                    </div>
                </div>
                <div class="row" name='user' style="display:none">
                    <div class="col-lg-1 col-md-1 col-sm-1">
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1" align='right'>
                        <div class='form-group'>
                            <label class='control-label'>กำหนด</label>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="cPass">
                                    <span class="checkbox-material" name="cPass">
                                        <!-- <span class="check"></span> -->
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <?php
                        echo $form->field($model, 'password')->passwordInput(['disabled'=>'disabled','placeholder'=>'โปรดกรอกรหัสผ่าน Default:12345678']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?= Html::submitButton('เพิ่ม', ['class' => 'btn btn-success from-control', 'name' => 'signup-button']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
</div>
<?php
$js=<<<JS
function isUndefined(x) {
    var d;
    return x === d;
}
function eUser(val){
    if(val==='1'){
        $("div[name='officerRow']").show();
        $("div[name='collegianRow']").hide();
        $("input[name='userofficer'],select[name='userofficer']").removeAttr('disabled');
        $("input[name='usercollegian']").attr('disabled','disabled');
    }
    else if(val==='2'){
        $("div[name='collegianRow']").show();
        $("div[name='officerRow']").hide();
        $("input[name='usercollegian'],textarea[name='usercollegian'],select[name='usercollegian']").removeAttr('disabled');
        $("input[name='userofficer'],select[name='userofficer']").attr('disabled','disabled');
    }
    else {
        $("div[name='officerRow'],div[name='collegianRow']").hide();
        $("input[name='userofficer'],input[name='usercollegian'],textarea[name='usercollegian'],select[name='userofficer'],select[name='usercollegian']").attr('disabled','disabled');
    }
    if(jQuery.inArray(val,['0','1','2'])!==-1) {
        $("div[name='user']").show();
    }
    else{
        $("div[name='user']").hide();
        $('#signupform-password').removeAttr('disabled');
    }
}

JS;
$this->registerJs($js,View::POS_BEGIN);
$js=<<<JS
$('#level_user').on('change',function(){eUser($(this).val())});
$('[name="cPass"]').on('click',function(){
    if(this.checked) {
        //Do stuff
        $('#signupform-password').removeAttr('disabled');
    }
    else{
        $('#signupform-password').attr('disabled','disabled');
    }
})
JS;
$this->registerJs($js,View::POS_READY);
$js=<<<JS
eUser($('#level_user').val());
$('#signupform-password').attr('disabled','disabled');
JS;
$this->registerJs($js,View::POS_END);
?>
