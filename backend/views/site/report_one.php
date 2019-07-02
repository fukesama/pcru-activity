<?php
use yii\helpers\Url;
use frontend\models\User;
use backend\models\ActivityEnter;
use backend\models\ActivityEnterDetail;
use backend\models\ActivityOfyearDetail;
use backend\models\Viewreportproject2;
use backend\models\Faculty;
use backend\models\Branch;
use backend\models\Prefix;
ini_set('max_execution_time', 99999);
?>
<div  style="font-size:15px">
	<?php 
	$acenArr=Viewreportproject2::find()->where(['acoyd_id'=> $model->acoyd_id,'co_id'=>Yii::$app->user->identity->id])->orderBy(['acend_date'=>SORT_ASC])->asArray()->all();
	$facArr=Faculty::find()->all();
	$arr=[];
	foreach ($facArr as $key=> $value) {
		$arr[$value->faculty_id]=$value->faculty_name;
	}
	$facArr=$arr;
	$braArr=Branch::find()->all();
	$arr=[];
	foreach ($braArr as $key=> $value) {
		$arr[$value->branch_id]=$value->branch_name;
	}
	$braArr=$arr;
	$preArr=Prefix::find()->all();
	$arr=[];
	foreach ($preArr as $key=> $value) {
		$arr[$value->pre_id]=$value->pre_name;
	}
	$preArr=$arr;
	$enterArr=[0=>'ไม่เข้าร่วม',1=>'เข้าร่วม'];	
		
		?>

		<div class="a4">
			<div class="text-center" style="font-size:17px"><b>ตารางบันทึกการเข้าร่วมโครงการ/กิจกรรม</b></div>
			<div class="text-center" style="font-size:17px"><b>ชื่อ <?= Yii::$app->user->co->pre->pre_name?></b></div>
			<div class="text-center">
				<b>จัดวันที่</b> <?=  Yii::$app->Func->DateThaiFull($acenArr[0]['acend_date'])?> <b>สถานที่จัด</b> <?= $model->address_detail ?>
			</div>
			<div class="text-center">
				<b>คณะ</b>&nbsp;<?= $facArr[$acenArr[0]['faculty_id']] ?> <b>สาขา</b>&nbsp;<?=$braArr[$acenArr[0]['branch_id']] ?>
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

					if($i%42==0||($c!=0&&$acenArr[$c-1]['branch_id']!=$acenArr[$c]['branch_id'])):
						if(($c!=0&&$acenArr[$c-1]['branch_id']!=$acenArr[$c]['branch_id'])){
							$i=1;
						}
						?>
					</table>	
				</div>
				<div class="a4">
					<div class="text-center" style="font-size:17px"><b>โครงการ<?= $model->acoy->ac->ac_name;?></b></div>
					<div class="text-center">
						<b>จัดวันที่</b> <?= Yii::$app->Func->DateThaiFull($acenArr[$c]['acend_date']) ?> <b>สถานที่จัด</b> <?= $model->address_detail ?>
					</div>
					<div class="text-center">
						<b>คณะ</b>&nbsp;<?= $facArr[$acenArr[$c]['faculty_id']] ?> <b>สาขา</b>&nbsp;<?= $braArr[$acenArr[$c]['branch_id']] ?>
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
		// $now++;
	// endwhile; ?>

</div>