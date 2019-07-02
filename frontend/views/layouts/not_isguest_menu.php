<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\models\User;
use yii\widgets\Pjax;
use \yii\web\Request;
use yii\web\View;
use yii\helpers\Json;
$level_user=Yii::$app->User->identity->level_user;
if($level_user=='0'){
    echo $this->render('admin_menu.php');
}
else if($level_user=='1'){
    echo $this->render('officer_menu.php');
}
else if($level_user=='2'){
    echo $this->render('collegian_menu.php');
}
?>


