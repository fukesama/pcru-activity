<?php
use yii\helpers\Url;
use frontend\models\User;
use backend\models\ActivityEnter;
use backend\models\ActivityEnterDetail;
use backend\models\ActivityOfyearDetail;
use backend\models\ViewAcen;

ini_set('max_execution_time', 99999);
?>
<div  style="font-size:15px">
	<?php 
	

	$dateArr=ActivityOfyearDetail::find()->select('ac_startdate,ac_enddate')->where(['acoyd_id'=> $model->acoyd_id])->one();
	
	$dateArr=Yii::$app->Func->dateRange($dateArr->ac_startdate,$dateArr->ac_enddate,'+ 1 days','Y-m-d');
	
	$branch='';
	$now='';
	$page=1;
	?>
	<?php 
	$table=0;
	foreach($dateArr as $key => $dateRaw):
		$date=Yii::$app->Func->DateThaiFull($dateRaw);			
		$acenArr=ViewAcen::find()->where(['acoyd_id'=> $model->acoyd_id])->all();
		$all=ViewAcen::find()->where(['acoyd_id'=> $model->acoyd_id])->count();
		$i=1;
		
		foreach ($acenArr as $key=>$value) :
			$foot=0; 


			if($branch!==$value->branch_name||$i%42==0||$now!=$date):
				
				if(($branch!==''&&$branch!==$value->branch_name)||$i%42==0){
					$i=1;
					$foot=1;
					// echo 'endtable<br>';
					echo '</table></div>';
				}
				$now=$date;
				// echo 'a4<br>';
				echo '<div class="a4">';
				?>
				
				<div class="text-center" style="font-size:16px">
					<b>
						รายฃื่อผู้ที่ไม่เข้าร่วมโครงการ<br><?= $model->acoy->ac->ac_name;?>
					</b>
				</div>
				<div class="text-center">
					<b>จัดวันที่</b> <?=  $date?> <b>สถานที่จัด</b> <?= $model->address_detail!=''?$model->address_detail:'-' ?>
				</div>
				<div class="text-center">
					<?php 

					?>
					<b>คณะ</b>&nbsp;
					<?php 				
					echo $value->faculty_name;
					?> 
					<b>สาขา</b>&nbsp;
					<?php 				
					echo $value->branch_name;
					?>
				</div>
				<br>
				<?php 
				// echo 'start table<br>';
				echo '<table class="border">';
				echo'
				
				<tr>
				<th class="text-center" width="80px">ลำดับ</th><th class="text-center" width="120px">รหัสนักศึกษา</th><th class="text-center">ชื่อ - นามสกุล</th>
				</tr>
				';
			endif;
			$count=ActivityEnterDetail::find()->where(['acen_id'=>$value->acen_id,'acend_date'=>$dateRaw])->count() ;
			// echo $value->acen_id.' '.$count.'<br>';
			if($count==0):
				echo '
				<tr>
				<td>'.$i.'</td>
				<td>'.$value->username.'</td>
				<td align="left" >&nbsp;'.$value->pre_name.' '.$value->uc_fname.' '.$value->uc_lname.'</td>
				</tr>
				';
				echo $value->pre_name.' '.$value->uc_fname.' '.$value->uc_lname.' '.$value->branch_name.'<br>';
				$i++;
			endif;

			// if($i!=1&&$i%41==0||($branch!=''&&$branch!=$value->branch_name)):
			// 	$foot==1;
				// echo'</table></div>';
			?>	

			<?php
			// endif; 	
			if($branch!=$value->branch_name){			
				$branch=$value->branch_name;
			}	
		endforeach;
	endforeach; 
	if($foot==0){
		$foot=1;
		  echo'</table></div>';
	}?>

	<!-- </table></div> -->
</div>