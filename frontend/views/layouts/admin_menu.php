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
$url2=Url::to(['frontend/web/img/pcrulogo.png']);
?>
<div class="sidebar" data-color="purple" data-image="<?=$url1?>" style="position: fixed;">

    <div class="logo">
        <img src="<?=$url2?>"
        style="max-height: 75px;
        display: block;
        margin-left: auto;
        margin-right: auto;
        ">
    </div>

    <div class="sidebar-wrapper">

        <?=
        ramosisw\CImaterial\widgets\Menu::widget(
            [
                'items' => [
                    [
                        'url' => ['site/'],
                        'icon' => 'home',
                        'label' => 'หน้าหลัก'
                       
                    ],
                    [
                        'url'=>['prefix/'],
                        'icon'=>'list',
                        'label'=>'คำนำหน้า',
                    ],
                    [
                        'url'=>['user/'],
                        'icon'=>'people',
                        'label'=>'จัดการผู้ใช้',
                    ],
                    [
                        'url'=>['faculty/'],
                        'icon'=>'bookmarks',
                        'label'=>'จัดการคณะ',
                    ],
                    [
                        'url'=>['branch/'],
                        'icon'=>'bookmarks',
                        'label'=>'จัดการสาขา',
                    ],
                    [
                        'url'=>['edu-background/'],
                        'icon'=>'school',
                        'label'=>'จัดการหลักสูตร',
                    ],
                    [
                        'url'=>['activity-cate/'],
                        'icon'=>'grain',
                        'label'=>'จัดการประเภทของกิจกรรม',
                    ],
                    [
                        'url'=>['activity-type/'],
                        'icon'=>'grain',
                        'label'=>'จัดการชนิดของกิจกรรม',
                    ],
                    [
                        'url'=>['activity-side/'],
                        'icon'=>'grain',
                        'label'=>'จัดการด้านของกิจกรรม',
                    ],
                    [
                        'url'=>['activity/'],
                        'icon'=>'directions_run',
                        'label'=>'จัดการกิจกรรม',
                    ],
                    [
                        'url'=>['activity-ofyear/'],
                        'icon'=>'date_range',
                        'label'=>'จัดการวันที่ดำเดินกิจกรรม',
                    ],
                    [
                        'url'=>['activity-enter/'],
                        'icon'=>'touch_app',
                        'label'=>'จัดการการเข้าร่วมกิจกรรม',
                    ],
                ]
                ,'options'=>['class'=>'nav tree']
            ])
            ?>

        </div>
    </div>