<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\SignupForm;
use backend\models\ContactForm;
use common\models\User;
use yii\helpers\Url;

$this->title = $name;
?>
<style media="screen">

</style>
<div class="site-error">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-stats">
                <div class="card-header" data-background-color="red">
                    <i class="material-icons"  style="display:block;float:left;">error</i>
                    <h4 style="display:block;float:left;padding-top:4px;font-weight:bold;">
                        <?= Html::encode($this->title) ?>
                    </h4>
                </div>
                <div class="card-content">
                    <h4 class="title" style="font-weight:bold;display:inline-block;float:left;text-align:left;width: 200px;">

                    </h4>

                </div>

                <br><br>
                <div class="container-fluid" style="text-align: left">
                    <div class="row hidden-lg">
                        <div class="col-xs-12">
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1 col-md-2 col-sm-2 col-xs-4">

                            <img src="<?php echo Url::to(['backend/web/img/noti.png']) ?>" width="100%" height="auto"/>

                        </div>
                        <div class="col-lg-11 col-md-10 col-sm-10 col-xs-8">

                            <div class="alert alert-danger">
                                <?= nl2br(Html::encode($message)) ?>
                            </div>



                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <p>
                                <?php  echo nl2br(Html::encode($message)) ?> กรุณาติดต่อผู้ดูแลระบบ
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
