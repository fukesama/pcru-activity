<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\models\User;

use yii\web\View;
use yii\helpers\Json;
use frontend\models\Viewreportone;

?>
<?php

$url1=Url::to(['frontend/web/img/sidebar-1.jpg']);
$url2=Url::to(['frontend/web/img/pcrulogo.png']);
?>
<?php echo Yii::$app->Func->activelink('site/') ?>
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

	<div class="sidebar-wrapper">
		<?php 
		$items=[
			[
				'url' => ['site/index'],
				'icon' => 'home',
				'label' => 'หน้าหลัก',

			],
			   // [
                    //     'url' => ['site/t-activity'],
                    //     'icon' => 'print',
                    //     'label' => 'ทรานสคริปกิจกรรม',
                    // ], 
		];
		
		// $items[]=[
		// 	'url' => ['site/report-one'],
		// 	'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
		// 	'label' => 'รายงานการเข้าร่วมกิจกรรม',

		// ];

		$items[]=[
			
			'icon' => '<i class="fa fa-book" aria-hidden="true"></i>',
			'label' => 'รายงานการเข้าร่วมกิจกรรม',
			'items'=>[
				
			]

		];
		$items[1]['items'][]=[
			'url' => ['site/report-one'],
			'label' => 'ทุกชั้นปี',
		];

		$acenArr=Viewreportone::find()->select('year')
		->where(['co_id'=>Yii::$app->user->identity->id])->orderBy(['acend_date'=>SORT_ASC])
		->asArray()->all();
		$year='';		
		$i=1;
		foreach ($acenArr as $key =>$value):
			if($year!==$acenArr[$key]['year']){	
				$year=$acenArr[$key]['year'];				
				$items[1]['items'][]=[
					'url' => ['site/report-one?edu_level='.$i],
					'label' => 'ชั้นปีที่ '.$i,
				];
				$i++;
			}
			
		endforeach;

		?>
		<?=
		ramosisw\CImaterial\widgets\Menu::widget(
			[
				'items' => $items
				,'options'=>['class'=>'nav tree']
			])
			?>

		</div>
	</div>
