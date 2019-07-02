<?php 
use backend\models\Branch;
use backend\models\Faculty;
use backend\models\User;
use backend\models\UserCollegian;

/**
 * @param $branch สาขาวิชา
 * @param $edu_level ระดับการศึกษา
 * @param $year จำนวนปีที่ศึกษา
 * @param $ver รุ่น
 * @param $room ห้อง
 * @param $StudyGroup หมู่เรียน
 */
$branch_id;
$branch_name;
$faculty_id;
$faculty_name;
$edu_level;
$year;
$ver;
$room;
$StudyGroup;
$br='';
$numOfStudent=0;

foreach ($arr as $key1=>$value1) {   	
	foreach ($value1 as $key2=>$value2) { 
		if($value2[0]==''){
			continue;
		}
		else if($value2[0]=='อาจารย์ที่ปรึกษาหมู่เรียน'||$value2[0]=='ลำดับ')
		{		
			$br='no space';	
			break;
		}
		// echo $value1[$key2][0];
		$branch_name=explode(' ',$value1[$key2][0]);		
		if($branch_name[0]=='สาขาวิชา'){
			$branch_name=explode('-',$branch_name[1]);
			$branch_name=$branch_name[0];				
			// echo $branch_name['branch_id'];

			continue;
		}
		if($value2[0]=='เพชรบูรณ์'){
			$faculty_name=$value2[4];
			// echo $faculty_name;
			continue;
		}
		elseif($value2[0]=='ระดับการศึกษา'){
			$arr=explode(' ',$value2[1]);			
			$edu_level=$arr[0];			
			$year=$arr[1];
			array_pop($arr);			
			$ver=$value2[3];

			$StudyGroup=$value2[8];	
			$room=$StudyGroup[9];
			$faculty_id=$StudyGroup[2];
			$branch_id=$StudyGroup[6].$StudyGroup[7].$StudyGroup[8];
			continue;
		}
		elseif($value2[0]=='อาจารย์ที่ปรึกษาหมู่เรียน'){
			$bmodel=Faculty::find()->where(['faculty_name'=>$faculty_name]);
			if($bmodel->count()==0){
				$bmodel=(new Faculty);
				$bmodel->faculty_id=$faculty_id;
				$bmodel->faculty_name=$faculty_name;
				$bmodel->save();
			}
			else{
				$bmodel=$bmodel->asArray()->one();
			}
			$fmodel=Branch::find()->where(['branch_name'=>$branch_name]);
			if($fmodel->count()==0){
				$fmodel=(new Branch);
				$fmodel->branch_id=$branch_id;
				$fmodel->branch_name=$branch_name;
				$fmodel->save();
			}
			else{
				$fmodel=$fmodel->asArray()->one();
			}
			$umodel=User::find()->where(['username'=>$branch_name]);
			
			if($fmodel->count()==0){
				$ucmodel=UserCollegian::find()->select('branch_id')->where(['branch_name'=>$branch_name]);
				$fmodel=(new UserCollegian);
				$fmodel->branch_id=$branch_id;
				$fmodel->branch_name=$branch_name;
				$fmodel->save();
			}
			else{

				$fmodel=$fmodel->asArray()->one();
			}
			$numOfStudent++;
		}

		$space='';
		if($br==''){
			echo '<br>';
		}		
		foreach ($value2 as $key3=>$value3) {			
			if(($value3==''&&$key3=='0')||$value3==' '){
				break;
			}			
			if(isset($value1[$key2-1][$key3])&&$value1[$key2-1][$key3]=='ระดับการศึกษา'){
				break;
			}			
			if($key3=='0'){
				continue;
			}
			$br='';
			echo $value3;
			$space=$key3;	

		}

	}
}

?>