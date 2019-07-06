<?php
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'PCRU - Activity';
/*$this->params['breadcrumbs'][] = 'หน้าหลัก';*/
use backend\models\ActivityEnterDetail;
use backend\models\ActivityEnter;
$this->title = 'หน้าหลัก';
$this->params['breadcrumbs'][] = '';
?>


<div class="site-index">

	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<a href="<?= Url::to(['/activity/']); ?>">
				<div class="card card-stats">
					<div class="card-header" data-background-color="blue">
						<i class="material-icons">list</i>
					</div>
					<div class="card-content">
						<p class="category">&nbsp;</p>
						<h4 class="title">ข้อมูลชื่อกิจกรรม</h4>
					</div>               
				</div>
			</a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<a href="<?= Url::to(['/activity/']); ?>">
				<div class="card card-stats">
					<div class="card-header" data-background-color="orange">
						<i class="material-icons">directions_run</i>
					</div>
					<div class="card-content">
						<p class="category">&nbsp;</p>
						<h4 class="title">ข้อมูลกิจกรรม</h4>
					</div>               
				</div>
			</a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<a href="<?= Url::to(['/activity-ofyear-detail/']); ?>">
				<div class="card card-stats">
					<div class="card-header" data-background-color="green">
						<i class="material-icons">date_range</i>
					</div>
					<div class="card-content">
						<p class="category">&nbsp;</p>
						<h4 class="title">จัดการวันที่ดำเดินกิจกรรม</h4>
					</div>               
				</div>
			</a>
		</div>

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<a href="<?= Url::to(['/activity-ofyear-detail/pre-qrcode']); ?>" target='_blank'>
				<div class="card card-stats">
					<div class="card-header" data-background-color="blue">                      
						<i class="fa fa-qrcode"  ></i>
					</div>
					<div class="card-content">
						<p class="category">&nbsp;</p>
						<h4 class="title">รายงานคิวอาร์โค้ดกิจกรรม</h4>
					</div>

				</div>
			</a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<a href="<?= Url::to(['/activity-enter/']); ?>">
				<div class="card card-stats">
					<div class="card-header" data-background-color="red">
						<i class="material-icons">touch_app</i>
					</div>
					<div class="card-content">
						<p class="category">&nbsp;</p>
						<h5 class="title">การเข้าร่วมกิจกรรมของนักศึกษา</h5>
					</div>
				</div>
			</a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<a href="<?= Url::to(['/site/project?year='.(date('Y')+543)]); ?>" target='_blank'>
				<div class="card card-stats">
					<div class="card-header" data-background-color="purple">
						<i class="fa fa-th-list" aria-hidden="true"></i>
					</div>
					<div class="card-content">
						<p class="category">&nbsp;</p>
						<h5 class="title">รายงานการเข้าร่วมกิจกรรม</h5>
					</div>
				</div>
			</a>
		</div>
       <!--   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <a href="<?= Url::to(['/activity-enter/report-one']); ?>">
                <div class="card card-stats">
                    <div class="card-header" data-background-color="orange">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <div class="card-content">
                        <p class="category">&nbsp;</p>
                        <h5 class="title">รายงานการเข้าร่วมกิจกรรมรายบุคคล</h5>
                    </div>
                </div>
            </a>
        </div> -->
    </div>

</div>
