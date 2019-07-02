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
	$acenArr=Viewreportproject2::find()->where(['acoyd_id'=> $model->acoyd_id])->orderBy(['acend_date'=>SORT_ASC,'branch_id'=>SORT_ASC,'username'=>SORT_ASC])->asArray()->all();
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

	$dateArr=Viewreportproject2::find()->select('acend_date')->where(['acoyd_id'=> $model->acoyd_id])->orderBy(['acend_date'=>SORT_ASC,'branch_id'=>SORT_ASC,'username'=>SORT_ASC])->asArray()->all();
	$arr=[];
	foreach ($dateArr as $key=>$value) {
		$arr[$value['acend_date']]=$value['acend_date'];
	}
	$dateArr=$arr;
	unset($arr);
	
	
	foreach($dateArr as $key => $value):
		
		$acenArr2=Viewreportproject2::find()->where(['acoyd_id'=> $model->acoyd_id,'acend_date'=>date('Y-m-d',strtotime($value))])->orderBy(['acend_date'=>SORT_ASC,'branch_id'=>SORT_ASC,'username'=>SORT_ASC])->asArray()->all();
		 $date=Yii::$app->Func->DateThaiFull($value);
		?>

		<div class="a4">
			<div class="text-center" style="font-size:16px"><b><?= $model->acoy->ac->ac_name;?></b></div>
			<div class="text-center">
				<b>จัดวันที่</b> <?=  $date?> <b>สถานที่จัด</b> <?= $model->address_detail ?>
			</div>
			<div class="text-center">
				<?php 
				
				?>
				<b>คณะ</b>&nbsp;<?php 				
				echo $facArr[$acenArr2[0]['faculty_id']];
				?> 
				<b>สาขา</b>&nbsp;<?php 				
				echo $braArr[$acenArr2[0]['branch_id']] ;
				?>
			</div>
			<br>		
			<?php $count=count($acenArr2);?>
			<table class='border'>
				<tr>
					<th class="text-center" width="80px">ลำดับ</th><th class="text-center" width="120px">รหัสนักศึกษา</th><th class="text-center">ชื่อ - นามสกุล</th>
				</tr>
				<?php 
				//ได้ไม่เกิน 42 แถว

				$bra='';
				$i=1;
				for ($c=0;$c<$count;$c++):

					if($i%42==0||($c!=0&&$acenArr2[$c-1]['branch_id']!=$acenArr2[$c]['branch_id'])):
						if(($c!=0&&$acenArr2[$c-1]['branch_id']!=$acenArr2[$c]['branch_id'])){
							$i=1;
						}
						?>
					</table>	
				</div>
				<div class="a4">
					<div class="text-center" style="font-size:17px"><b>โครงการ<?= $model->acoy->ac->ac_name;?></b></div>
					<div class="text-center">
						<b>จัดวันที่</b> <?= $date ?> <b>สถานที่จัด</b> <?= $model->address_detail ?>
					</div>
					<div class="text-center">
						<b>คณะ</b>&nbsp;<?= $facArr[$acenArr2[$c]['faculty_id']] ?> <b>สาขา</b>&nbsp;<?= $braArr[$acenArr2[$c]['branch_id']] ?>
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
						<td><?= $acenArr2[$c]['username'] ?></td>
						<td align="left" >&nbsp; <?= $preArr[$acenArr2[$c]['pre_id']].' '.$acenArr2[$c]['uc_fname'].' '.$acenArr2[$c]['uc_lname'] ?></td>

					</tr>
					<?php			
					$i++;
				endfor; ?>
			</table>
		</div>
		<?php 
		
	endforeach; ?>

</div>