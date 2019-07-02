<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\User;

use yii\web\View;
use yii\helpers\Json;

?>
<?php
$url1=Url::to(['../frontend/web/img/sidebar-1.jpg']);
$url2=Url::to(['../frontend/web/img/pcrulogo.png']);
?>
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

		<?=
		ramosisw\CImaterial\widgets\Menu::widget(
			[
				'items' => [
					[
						'url'=>['site/index'],
						'icon' => 'home',
						'label' => 'หน้าหลัก',						
						

					],
					[
						// 'url'=>['user/index'],
						'icon' => '<i class="fa fa-th-list" aria-hidden="true"></i>',
						'label' => 'ผู้ใช้พื้นฐาน',						
						'items' =>[
							[
								'url'=>['prefix/index'],
								'icon'=>'list',
								'label'=>'คำนำหน้า',
							],
							
							[
								'url'=>['edu-background/index'],
								'icon'=>'school',
								'label'=>'จัดการหลักสูตร',
							],
							[
								'url'=>['faculty/index'],
								'icon'=>'bookmarks',
								'label'=>'จัดการคณะ',
							],
							[
								'url'=>['branch/index'],
								'icon'=>'bookmarks',
								'label'=>'จัดการสาขา',
							],
						]

					],	
					
					[
						 // 'url'=>['site/index'],
						'icon' => '<i class="fa fa-calendar" aria-hidden="true"></i>',
						'label' => 'กิจกรรมพื้นฐาน',						
						'items' =>[
							[
								'url'=>['activity-cate/index'],
								'icon'=>'grain',
								'label'=>'จัดการผู้รับผิดชอบกิจกรรม',
							],
							[
								'url'=>['activity-type/index'],
								'icon'=>'grain',
								'label'=>'จัดการชนิดของกิจกรรม',
							],
							[
								'url'=>['activity-side/index'],
								'icon'=>'grain',
								'label'=>'จัดการด้านของกิจกรรม',
							],
							[
								'url'=>['activity/index'],
								'icon'=>'list',
								'label'=>'จัดการชื่อกิจกรรม',
							],

						],						
					],	
					[
						'url'=>['user/index'],
						'icon'=>'people',
						'label'=>'จัดการผู้ใช้',
					],	


					[
						'url'=>['activity-ofyear/index'],
						'icon'=>'directions_run',
						'label'=>'จัดการกิจกรรม',
					],
					[
						'url'=>['activity-ofyear-detail/index'],
						'icon'=>'date_range',
						'label'=>'จัดการวันที่ดำเดินกิจกรรม',
					],
					[
						'url'=>['activity-enter/index'],
						'icon'=>'touch_app',
						'label'=>'จัดการการเข้าร่วมกิจกรรม',
					],
				]
				,'options'=>['class'=>'nav tree']
			])
			?>
			<?php
			// ramosisw\CImaterial\widgets\Menu::widget(
			// 	[
			// 		'items' => [
			// 			[
			// 				'url'=>['site/index'],
			// 				'icon' => 'home',
			// 				'label' => 'หน้าหลัก',						


			// 			],

			// 			[
			// 				'url'=>['prefix/index'],
			// 				'icon'=>'list',
			// 				'label'=>'คำนำหน้า',
			// 			],
			// 			[
			// 				'url'=>['user/index'],
			// 				'icon'=>'people',
			// 				'label'=>'จัดการผู้ใช้',
			// 			],
			// 			[
			// 				'url'=>['edu-background/index'],
			// 				'icon'=>'school',
			// 				'label'=>'จัดการหลักสูตร',
			// 			],
			// 			[
			// 				'url'=>['faculty/index'],
			// 				'icon'=>'bookmarks',
			// 				'label'=>'จัดการคณะ',
			// 			],
			// 			[
			// 				'url'=>['branch/index'],
			// 				'icon'=>'bookmarks',
			// 				'label'=>'จัดการสาขา',
			// 			],

			// 			[
			// 				'url'=>['activity-cate/index'],
			// 				'icon'=>'grain',
			// 				'label'=>'จัดการผู้รับผิดชอบกิจกรรม',
			// 			],
			// 			[
			// 				'url'=>['activity-type/index'],
			// 				'icon'=>'grain',
			// 				'label'=>'จัดการชนิดของกิจกรรม',
			// 			],
			// 			[
			// 				'url'=>['activity-side/index'],
			// 				'icon'=>'grain',
			// 				'label'=>'จัดการด้านของกิจกรรม',
			// 			],
			// 			[
			// 				'url'=>['activity/index'],
			// 				'icon'=>'list',
			// 				'label'=>'จัดการชื่อกิจกรรม',
			// 			],
			// 			[
			// 				'url'=>['activity-ofyear/index'],
			// 				'icon'=>'directions_run',
			// 				'label'=>'จัดการกิจกรรม',
			// 			],
			// 			[
			// 				'url'=>['activity-ofyear-detail/index'],
			// 				'icon'=>'date_range',
			// 				'label'=>'จัดการวันที่ดำเดินกิจกรรม',
			// 			],
			// 			[
			// 				'url'=>['activity-enter/index'],
			// 				'icon'=>'touch_app',
			// 				'label'=>'จัดการการเข้าร่วมกิจกรรม',
			// 			],
			// 		]
			// 		,'options'=>['class'=>'nav tree']
			// 	])
			?>
		</div>
	</div>
