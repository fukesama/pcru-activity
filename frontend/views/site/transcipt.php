<?php
use yii\helpers\Url;
use frontend\models\User;
use backend\models\ActivityEnter;
use backend\models\ActivityEnterDetail;

// $model=User::findOne(Yii::$app->user->identity->id);
$this->title = 'ทรานสคริป';

$GLOBAL['id']=$model->id;
function headTable():void{
	echo '<tr><td>รหัส<br>กิจกรรม</td><td>โครงการ/กิจกรรม</td><td>หน่วย<br>กิจกรรม</td><td>ผล<br>ประเมิน</td></tr>';
}

function rowhead($text):void{
	echo '<tr><td colspan="4" style="text-align:left;">'.$text.'</td></tr>';
}
function looptable($model):void{
	headTable();
	if($model!=[]):
		foreach ($model as $key =>$value) :		
			echo '<tr><td>'.$value[$key]['acoy_id'].'</td><td>'.$value[$key]['ac_name'].'</td><td>'.$value[$key]['point'].'</td><td>'.$value[$key]['result'].'</td></tr>';
		endforeach;
	else :
		echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
	endif;
}
function countPoint($arr){
	$sum=0;
	foreach ($arr as $key =>$value) {		
		$sum+=$arr[$key]['acoyd']['acoy']['point'];
	}
	return $sum;
}

function countPointRecursive($arr,$text=0){	
	$count=count($arr);
	if($count>0){
		$text+=$arr[$count-1]['acoyd']['acoy']['point'];
		unset($arr[$count-1]['acoyd']['acoy']['point']);
		countPointRecursive($arr,$text);
	}
	else{
		return $text;
	}	
}



function baseSql($id){
	return $sql=backend\models\ActivityEnter::find()
	->joinWith('acoyd')
	->joinWith('acoyd.acoy')
	->joinWith('acoyd.acoy.ac')
	->where(['co_id'=>$id]);
}
function baseSql2($id){
	return $sql=backend\models\ActivityEnterDetail::find()
	->joinWith('acen')
	->joinWith('acen.acoyd')
	->joinWith('acen.acoyd.acoy')
	->joinWith('acen.acoyd.acoy.ac')
	->where(['co_id'=>$id]);
}

function table($year=1,$sql){
	$sql2=$sql;
	// $sql2=$sql2->count();
	// $arr=Yii::$app->db->createCommand($sql2)->queryAll();
	$count=$sql2->count();
	?>		

	<table class="border">
		<colgroup>
			<col>
			<col>
			<col>
			<col>
		</colgroup>
		<tr>
			<td colspan="4" style="text-align:left;">กิจกรรมส่วนกลาง : 
				<?=$name='ชั้นปีที่ '.$year.' จำนวน '.$count.' ชั่วโมงกิจกรรม';?>

			</td>
		</tr>
		<?php 
		$arr=$sql2->andWhere(['cate_id'=>'A','edu_level'=>$year])->asArray()->all();
			//กิจกรรมส่วนกลาง
		print_r($arr);
		// looptable($arr);

		// $sql2=$sql.' and ac_level ="'.$year.'"';
		// $arr=Yii::$app->db->createCommand($sql2)->queryAll();
		// $count=countPoint($arr);
		// rowhead('กิจกรรมคณะ : 0 ชั่วโมงกิจกรรม');				
		// looptable($arr=[]);		

		// $sql2=$sql.' and ac_level ="'.$year.'"';
		// $arr=Yii::$app->db->createCommand($sql2)->queryAll();
		// $count=countPoint($arr);
		// rowhead('กิจกรรมสาขาวิชา : 0 ชั่วโมงกิจกรรม');
		// looptable($arr=[])
		?>
	</table>
	<?php			
}
?>

<div class="row">
	<div class="split2" style="width: 15%">
		<img src="<?= Url::to(['frontend/web/img/qrcode.png']);?>">
	</div>
	<div class="split2" style="width: 69.1%;text-align: center;font-size: 16px;font-weight: bold;">
		ใบรายงานเข้าร่วมกิจกรรมนักศึกษา ภาคปกติ<br>
		ทรานสคิปกิจกรรม (Activity Transcipt) <br>
		มหาวิทยาลัยราชภัฎเพชรบูรณ์
	</div>
	<div class="split2" style="width: 15%">
		<div style="width:94.488189px;height: 132.283465px;border:1px solid black;margin-top:0;margin-right:15px;float:right;text-align:center">
			<br><br>
			ติดรูปถ่าย<br>
			1.5 นิ้ว
		</div>
	</div>
</div>


<div class="row" style="padding-top:10px">
	<div class='split2'>
		ชื่อ - นามสกุล :&nbsp;&nbsp;&nbsp;&nbsp;
		<?php

		//print_r($model);
		echo $model->userCollegian->uc_fname.' '.$model->userCollegian->uc_lname?><br>
		รหัสนักศึกษา :&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $model->username ?><br>
		คณะ :&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $model->collegian->fac->faculty_name ?>
		<br>
		รหัสไปรษณีย์ :&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $model->collegian->post_num ?><br> 
		โทรศัพท์ :&nbsp;&nbsp;&nbsp;&nbsp;
		<?php
		$num=strlen($model->collegian->tel);
		$text=$model->collegian->tel;
		$text=isset($text)&&$text!=''?$text[0].$text[1].$text[2].'-'.$text[3].$text[4].$text[5].$text[6].$text[7].$text[8].$text[9]:'';
		$text=$num=='10'?$text:'';
		echo $text;
		?>
		<br>
	</div>
	<div class='split2'>
		หลักสูตร :&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $model->collegian->bra->edub->edub_name ?><br>
		สาขาวิชา :&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $model->collegian->bra->branch_name ?>
		<br>
		ที่อยู่ :&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $model->collegian->address ?><br>
		<br>
		อีเมล์ :&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $model->collegian->email ?><br>
	</div>
</div>
<HR style="border:3px solid black;margin-left:5px;margin-right:5px;"/>
<?php 
// $data=Yii::$app->db->createCommand('SELECT * FROM activity_enter as acen
// 	INNER JOIN activity_ofyear as acoy ON acen.acoy_id=acoy.acoy_id 
// 	INNER JOIN activity as ac ON acoy.ac_id=ac.ac_id
// 	WHERE acen.co_id='.$model->id)
// ->queryAll();

$sql=baseSql($model->id)->andWhere(['enter_status'=>'2'])->asArray()->all();
$count=0;
// print_r($sql);
// foreach ($sql as $key => $value) {
// 	$count+=$sql[$key]['acoyd']['acoy']['point'];
// }

// $count=$count->count();
?>


<div class="dif1 disBor mg-l">
	<b>
		ประวัติการเข้าร่วมกิจกรรม
	</b>
	<?php 
	echo countPoint($sql);
	echo countPointRecursive($sql)
	?>
</div>
<div class="dif2 disBor mg-r t-r">
	ชั่วโมงกิจกรรมร่วมสะสม&nbsp;&nbsp;<?php //(.....)&nbsp;&nbsp;=&nbsp;&nbsp;?>
	<?php //echo $pointAll=$count ?>&nbsp;&nbsp;หน่วย
</div>
<div class="row">
	&nbsp;
</div>
<?php 
// $sql='SELECT * FROM activity_enter as acen
// INNER JOIN activity_ofyear_detail as acoyd ON acen.acoyd_id=acoyd.acoyd_id 
// INNER JOIN activity_ofyear as acoy ON acoyd.acoy_id=acoy.acoy_id 
// INNER JOIN activity as ac ON acoy.ac_id=ac.ac_id
// WHERE acen.co_id='.$model->id;
$sql=baseSql($model->id);
?>
<div class="a4">
	<div class="dif1">
		<?php 
		//ชั้นปีที่ 1 จำนวน 31 ชั่วโมงกิจกรรม	
		table($year=1,$sql);
		?>
	</div>
	<div class="dif2">
		<?php 
		//ชั้นปีที่ 2 จำนวน 28 ชั่วโมงกิจกรรม	
		// table($year=2,$sql);
		?>			
	</div>
</div>

<br>
<br>
<br>
<br>
<div class="a42" style="height:18.7cm">
	<div class="dif1">
		<?php 
		//ชั้นปีที่ 3 จำนวน 25 ชั่วโมงกิจกรรม	
		// table($year=3,$sql);
		?>
		<br>
		<?php 
		//ชั้นปีที่ 4 จำนวน 16 ชั่วโมงกิจกรรม	
		// table($year=4,$sql);
		?>			
	</div>

	<?php
	if($model->collegian->bra->edub->edub_name=='ครุศาสตร์บัณฑิต'):
		?>
		<div class="dif2">
			<?php 
			//ชั้นปีที่ 5 จำนวน 16 ชั่วโมงกิจกรรม	
			// table($year=5,$sql);
			?>				
		</div>
		<?php
	endif;
	?>
</div>
<HR style="border:2px solid black;margin-left:5px;margin-right:5px;margin-top:5px;margin-top:5px"/>

<div class="f10" style="font-size:10px;text-align:center">
	<b>
		ผลการเข้าร่วมกิจกรรมของนักศึกษา ภาคปกติ ตลอดหลักสูตรการศึกษา จำนวน 
		<span class="dot">
			<?php //echo$pointAll ?>
		</span> ชั่วโมงกิจกรรม<br>

		<img src="<?= Url::to(['frontend/web/img/unTick.png']);?>" width='10px' height='10px'> &nbsp;เข้าร่วมกิจกรรมไม่น้อยกว่า 55 ชั่วโมงกิจกรรม ถือว่าผ่านการเข้าร่วมกิจกรรม<br>
	</b>

</div>

<br>
<div class="t-c f10" style="bottom-margin:10px;display:block;font-weight: bold; ">
	เกณฑ์มาตรฐานการเข้าร่วมกิจกรรมนักศึกษาภาคปกติระหว่างเรียน ที่ได้รับ Activity Transcript
</div>
<!-- <table class='f10' style="bottom-margin:10px;display:block;width:300px;margin-left:auto;margin-right:auto;">
	<tr>
		<td>จำนวนชั่วโมงกิจกรรม</td>
		<td>ความหมายการประเมินผล</td>
	</tr>
	<tr>
		<td>95-100</td>
		<td>ผ่านดีเยี่ยม</td>
	</tr>
	<tr>
		<td>86-94</td>
		<td>ผ่านดีมาก</td>
	</tr>
	<tr>
		<td>75-85</td>
		<td>ผ่านดี</td>
	</tr>
</table> -->
<!-- <br> -->
<div class="t-c f10" style="font-weight: bold;">
	เกณฑ์มาตรฐานการเข้าร่วมกิจกรรมนักศึกษาภาคปกติระหว่างเรียน<br>
	<table class="mg-c f10" bordercolor="" style="width:8cm;border: 1px solid #fff;font-weight: bold;">
		<tr>
			<td style="width:4cm;text-align: left;">
				<img src="<?= Url::to(['frontend/web/img/unTick.png']);?>" width='10px' height='10px'> เข้าร่วมไม่น้อยกว่า 95-100
			</td>
			<td style="width:4.8cm;text-align: left;">
				ชั่วโมงกิจกรรม การประเมิน ผ่านดีเยี่ยม
			</td>
		</tr>
		<tr>
			<td style="width:4cm;text-align: left;">
				<img src="<?= Url::to(['frontend/web/img/unTick.png']);?>" width='10px' height='10px'> เข้าร่วมไม่น้อยกว่า 86-94
			</td>
			<td style="width:4.8cm;text-align: left;">
				ชั่วโมงกิจกรรม การประเมิน ผ่านดีมาก
			</td>
		</tr>
		<tr>
			<td style="width:4cm;text-align: left;">
				<img src="<?= Url::to(['frontend/web/img/unTick.png']);?>" width='10px' height='10px'> เข้าร่วมไม่น้อยกว่า 75-85
			</td>
			<td style="width:4.8cm;text-align: left;">
				ชั่วโมงกิจกรรม การประเมิน ผ่านดี
			</td>
		</tr>
	</table>
</div>
<br>
<div class="dif1 f10">
	<div>
		<div class="dif1">
			<b>ลงชื่อ</b>
		</div>
		<div class="dif2 t-c">
			<div>
				<b>
					<br>
					(........................................................)
					<br>เจ้าหน้าที่กิจกรรมนักศึกษา
				</b>
			</div>
		</div>

	</div><br>
	<div>
		<div class="dif1">
			<b>ลงชื่อ</b>
		</div>
		<div class="dif2 t-c">
			<div>
				<b>
					<br>
					(........................................................)
					<br>รองอธิการบดีฝ่ายกิจการนักศึกษา
				</b><br>
				<br><br>ออกให้เมื่อวันที่
				<?php
				$year=date('Y')+543;
				echo date('d / m / ').$year;
				?>
			</div>
			<br>
		</div>
	</div>
</div>
<div class="dif2 f10">
	<div>
		<div class="dif1">
			<b>ลงชื่อ</b>
		</div>
		<div class="dif2 t-c">
			<div>
				<b>
					<br>
					(........................................................)
					<br>ผู้อำนวยการกองพัฒนานักศึกษา
				</b>
			</div>
		</div>
	</div><br>
	<div style="width: 100%">
		<div class="dif1">
			<b>ลงชื่อ</b>
		</div>
		<div class="dif2 t-c">
			<div>
				<b>
					<br>
					(........................................................)
					<br>
					&nbsp;&nbsp;&nbsp;อธิการบดีมหาวิทยาลัยราชภัฏเพชรบูรณ์
				</b>
				<br><br>
				<br>(เอกสารนี้ต้องประทับตราจึงจะสมบูรณ์)
			</div>
		</div>
	</div>
</div>