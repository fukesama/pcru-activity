<?php
use yii\helpers\Url;
use frontend\models\User;
use frontend\models\Viewreportone;

use backend\models\ActivityEnter;
use backend\models\ActivityEnterDetail;
use backend\models\ActivityOfyearDetail;
use backend\models\Faculty;
use backend\models\Branch;
use backend\models\Prefix;
use backend\models\UserCollegian;
ini_set('max_execution_time', 99999);
?>
<div  style="font-size:15px">
	<?php

	$user=Yii::$app->user->identity->username;
	$acenArr=Viewreportone::find()
	->where(['co_id'=>Yii::$app->user->identity->id])->orderBy(['acend_date'=>SORT_ASC])
	->asArray()->all();
	if($edu_level!==''){
		$acenArr=Viewreportone::find()
		->where(['co_id'=>Yii::$app->user->identity->id])->andWhere(['year'=>(string)((int)('25'.$user[0].$user[1])+$edu_level-1)])->orderBy(['acend_date'=>SORT_ASC])->asArray()->all();
	}		
	$acenArr;
	$facArr=Faculty::find()->all();
	$co=UserCollegian::findOne(Yii::$app->user->identity->id);
	$year=$acenArr[0]['year'];

	// $define_edu_level=$year-$acenArr[0]['year']+1;

	
	?>

	<div class="a4">
		<div class="text-center" style="font-size:17px"><b>ตารางบันทึกการเข้าร่วมโครงการ/กิจกรรม ชั้นปีที่ <?= $edu_level==''?$year-$acenArr[0]['year']+1:$edu_level ?></b></div>
		<div class="text-center" style="font-size:15px">
			<b>ชื่อ</b> <?=$co->pre->pre_name.' '.$co->uc_fname?> <b>สกุล</b> <?=' '.$co->uc_lname?>
		</div>

		<div class="text-center">
			<b>คณะ</b>&nbsp;<?= $co->fac->faculty_name ?> <b>สาขา</b>&nbsp;<?=$co->bra->branch_name ?>
		</div>
		<br>		

		<?php 

		$count=count($acenArr);
		?>
		<table class='border'>
			<tr>
				<th class="text-center" width="80px">ลำดับ</th><th class="text-center">โครงการ/กิจกรรม</th><th class="text-center" width="90px">ว/ด/ป</th><th class='text-center' width="70px">จำนวนชั่วโมง</th>
			</tr>
			<?php 
				//ได้ไม่เกิน 42 แถว

			$bra='';
			$i=1;
			for ($c=0;$c<$count;$c++):

				if($i%42==0||$year!=$acenArr[$c]['year']):
					$year=$acenArr[$c]['year']					
					?>
				</table>	
			</div>
			<div class="a4">
				<div class="text-center" style="font-size:17px"><b>ตารางบันทึกการเข้าร่วมโครงการ/กิจกรรม ชั้นปีที่ <?= $edu_level==''?$year-$acenArr[0]['year']+1:$edu_level ?></b></div>
				<div class="text-center" style="font-size:15px">
					<b>ชื่อ</b> <?=$co->pre->pre_name.' '.$co->uc_fname?> <b>สกุล</b> <?=' '.$co->uc_lname?>
				</div>				
				<div class="text-center">
					<b>คณะ</b>&nbsp;<?= $co->fac->faculty_name ?> <b>สาขา</b>&nbsp;<?=$co->bra->branch_name ?>
				</div>
				<br>		
				<table class='border'>
					<tr>
						<th class="text-center" width="80px">ลำดับ</th><th class="text-center">โครงการ/กิจกรรม</th><th class="text-center" width="90px">ว/ด/ป</th><th class='text-center' width="70px">จำนวนชั่วโมง</th>
					</tr>
					<?php								
				endif;
				?>				
				<tr>
					<td><?= $i ?></td>
					<td><?= $acenArr[$c]['ac_name'] ?></td>
					<td><?= Yii::$app->Func->DateThaiSlash($acenArr[$c]['acend_date']) ?></td>
					<td><?= $acenArr[$c]['point'] ?></td>
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