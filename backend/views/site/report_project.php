<?php
use yii\helpers\Url;
use frontend\models\User;
use backend\models\ActivityEnter;
use backend\models\ActivityEnterDetail;
use backend\models\ActivityOfyearDetail;
use backend\models\Viewreportproject;
use backend\models\Faculty;
use backend\models\Branch;
use backend\models\Prefix;
ini_set('max_execution_time', 99999);
?>
<div  style="font-size:15px">
	<?php 
	$acenArr=Viewreportproject::find()->where(['acoyd_id'=> $model->acoyd_id])->asArray()->all();
	// $facArr=Faculty::find()->all();
	// $arr=[];
	// foreach ($facArr as $key=> $value) {
	// 	$arr[$value->faculty_name]=$value->faculty_name;
	// }
	// $facArr=$arr;
	// $braArr=Branch::find()->all();
	// $arr=[];
	// foreach ($braArr as $key=> $value) {
	// 	$arr[$value->branch_name]=$value->branch_name;
	// }
	// $braArr=$arr;
	$preArr=Prefix::find()->all();
	$arr=[];
	foreach ($preArr as $key=> $value) {
		$arr[$value->pre_id]=$value->pre_name;
	}
	$preArr=$arr;
	$start =strtotime($model->ac_startdate);
	$end =strtotime($model->ac_enddate);
	$range=Yii::$app->Func->compareDate($model->ac_startdate,$model->ac_enddate);
	$now=0;
	
	$enterArr=[0=>'ไม่เข้าร่วม',1=>'เข้าร่วม'];
	$date=Yii::$app->Func->DateThaiFull($model->ac_startdate);
	while($now<=$range):
		if($now!=0){
			$date=Yii::$app->Func->DateThaiFull(date('Y-m-d',strtotime('+'.$now.' days',$start)));
		}		
		?>
		<div class="a4">
			<div class="text-center" style="font-size:15px"><b>รายฃื่อผู้มีสิทธิ์เข้าร่วม<br>โครงการ<?= $model->acoy->ac->ac_name;?></b></div>
			<div class="text-center">
				<b>จัดวันที่</b> <?=  $date?> <b>สถานที่จัด</b> <?= $model->address_detail ?>
			</div>
			<div class="text-center">
				<b>คณะ</b>&nbsp;<?= $acenArr[0]['faculty_name']?> <b>สาขา</b>&nbsp;<?=$acenArr[0]['branch_name'] ?>
			</div>
			<br>		
			<?php $count=count($acenArr);?>
			<table class='border'>
				<tr>
					<th class="text-center" width="80px">ลำดับ</th><th class="text-center" width="120px">รหัสนักศึกษา</th><th class="text-center">ชื่อ - นามสกุล</th>
				</tr>
				<?php 
				//ได้ไม่เกิน 42 แถว

				$bra='';
				$i=1;
				for ($c=0;$c<$count;$c++):

					if($i%42==0||($c!=0&&$acenArr[$c-1]['branch_name']!=$acenArr[$c]['branch_name'])):
						if(($c!=0&&$acenArr[$c-1]['branch_name']!=$acenArr[$c]['branch_name'])){
							$i=1;
						}
						?>
					</table>	
				</div>
				<div class="a4">
					<div class="text-center" style="font-size:15px"><b>รายฃื่อผู้มีสิทธิ์เข้าร่วม<br>โครงการ<?= $model->acoy->ac->ac_name;?></b></div>
					<div class="text-center">
						<b>จัดวันที่</b> <?= $date ?> <b>สถานที่จัด</b> <?= $model->address_detail ?>
					</div>
					<div class="text-center">
						<b>คณะ</b>&nbsp;<?= $acenArr[$c]['faculty_name'] ?> <b>สาขา</b>&nbsp;<?= $acenArr[$c]['branch_name'] ?>
					</div>
					<br>	
					<table class='border'>
						<tr>
							<th class="text-center" width="80px">ลำดับ</th><th class="text-center" width="120px">รหัสนักศึกษา</th><th class="text-center">ชื่อ - นามสกุล</th>
						</tr>
						<?php								
					endif;
					?>				
					<tr>
						<td><?= $i ?></td>
						<td><?= $acenArr[$c]['username'] ?></td>
						<td align="left" >&nbsp; <?= $preArr[$acenArr[$c]['pre_id']].' '.$acenArr[$c]['uc_fname'].' '.$acenArr[$c]['uc_lname'] ?></td>
						
					</tr>
					<?php			
					$i++;
				endfor; ?>
			</table>
		</div>
		<?php 
		$now++;
	endwhile; ?>

</div>