<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\models\User;

use yii\web\View;
use yii\helpers\Json;

?>
<?php
$url1=Url::to(['frontend/web/img/sidebar-1.jpg']);
$url2=Url::to(['frontend/web/img/pcrulogo.png']);?>

<div class="sidebar" data-color="purple" data-image="<?=$url1?>" style="position: fixed;">

    <div class="logo">
        <img src="<?=$url2?>"
        style="max-height: 75px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        ">
          <center><h5>ระบบกิจกรรมนักศึกษา</h5></center>
    </div>

    ?>
    <div class="sidebar-wrapper">

        <?=
        ramosisw\CImaterial\widgets\Menu::widget(
            [
                'items' => [
                    [
                        'label' => 'หน้าหลัก',
                        'icon' => 'home',
                        'url' => ['site/'],
                        'active'=>Yii::$app->Func->activelink(Url::to(['site/']))
                    ],
                
                ]
                ,'options'=>['class'=>'nav tree']
            ]
        );
        ?>

    </div>
</div>
