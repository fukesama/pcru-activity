<?php 

use yii\web\Controller;
use frontend\models\Faculty;
use frontend\models\EduBackground;
use frontend\models\Branch;
use frontend\models\Prefix;

use backend\models\User;
use frontend\models\UserCollegian;


/**
 * @param $branch สาขาวิชา
 * @param $edu_level ระดับการศึกษา
 * @param $year จำนวนปีที่ศึกษา
 * @param $ver รุ่น
 * @param $group ห้อง
 * @param $StudyGroup หมู่เรียน
 * @param $number เลขที่;
 * @param $pre_id รหัสคำนำหน้า;
 * @param $pre_name ชื่อคำนำหน้า;
 * @param $uc_fname ชื่อ;
 * @param $uc_lname นามสกุล;
 */
function trimS($text){
	return trim($text,' ');
}
function loop(Array $arr){
	$result;

	foreach ($arr as $key=>$value) {
		$result[$key]=trimS($value);
	}	
	return $result;
}
$name;$br='';$update=0;$create=0;$total=0;
$password=Yii::$app->security->generatePasswordHash('12345678');
$auth_key=Yii::$app->security->generateRandomString();

foreach ($arr as $key1=>$value1) {   	
	foreach ($value1 as $key2=>$value2) { 
		if($value2[0]==''){
			continue;
		}

		$arr=explode(' ',$value1[$key2][0]);		
		if(trimS($arr[0])=='สาขาวิชา'){
			$arr2=explode('-',$arr[1]);	
			$arr3;
			foreach ($arr2 as $key=>$value) {
				$arr3[$key]=$value;				
			}	
			$branch_name=$arr3[0];
			$edub_code=$arr3[1];	
			continue;
		}
		if(trimS($value2[0])=='เพชรบูรณ์'){
			$faculty_name=$value2[4];			
			continue;
		}		
		if(trimS($value2[0])=='ระดับการศึกษา'){
			$arr=explode(' ',$value2[1]);			
			$edu_level=trimS($arr[0]);			
			$year=$arr[1];
			array_pop($arr);			
			$ver=trimS($value2[3]);			
			$StudyGroup=trimS($value2[8]);
			$group=trimS($StudyGroup[9]);				
			$branch_id=trimS($StudyGroup[6].$StudyGroup[7].$StudyGroup[8]);
			continue;
		}
		if($value2[0]=='อาจารย์ที่ปรึกษาหมู่เรียน'){
			$br='no space';
			$fModel=Faculty::find()->where(['faculty_name'=>$faculty_name]);
			if($fModel->count()==0){
				$fModel=new Faculty();
				$fModel->faculty_name=$faculty_name;
				$fModel->save();
			}
			else{
				$fModel=$fModel->one();					
			}
			$edModel=EduBackground::find()->where(['edub_code'=>$edub_code]);
			if($edModel->count()==0){
				$edModel=new EduBackground();				
				$edModel->edub_name='';	
				$edModel->edub_code=$edub_code;
				$edModel->save();								
			}
			else{
				$edModel=$edModel->one();
			}

			$bModel=Branch::find()->where(['branch_name'=>$branch_name]);
			if($bModel->count()==0){
				$bModel=new Branch();
				$bModel->branch_id=$branch_id;
				$bModel->branch_name=$branch_name;
				$bModel->edub_id=$edModel->edub_id;
				$bModel->faculty_id=$fModel->faculty_id;
				$bModel->save();
			}
			else{
				$bModel=$bModel->one();

			}	
		}
		$br='no space';	
		if($br==''){
			break;
		}		
		$name=explode(' ',$value2[2]);
		$name=loop($name);		

		if($name[0]!=''&&$name[0]!='ชื่อ-สกุล'){
			$name=explode(' ',$value2[2]);
			$pre_name=$name[0];
			$uc_fname=$name[1];
			$uc_lname=$name[3];
			$pModel=Prefix::find()->where(['pre_name'=>$pre_name]);

			if($pModel->count()==0){
				$pModel=new Prefix;
				$pModel->pre_name=$pre_name;
				$pModel->save();
			}
			else{
				$pModel=$pModel->one();					
			}				
			$number=$value2[1][10].$value2[1][11];	
			$uModel=User::find()->where(['username'=>$value2[1]]);			
			if($uModel->count()==0){
				$uModel=new User;
				$uModel->username=$value2[1];
				$uModel->password_hash=$password;
				$uModel->auth_key=$auth_key;
				$uModel->level_user='2';
				$uModel->save();
			}
			else{
				$uModel=User::find()->where(['username'=>$value2[1]])->one();			
			} 
			$ucModel=UserCollegian::find()->where(['user_id'=>$uModel->id]);


			if($ucModel->count()==0){
				$ucModel=new UserCollegian;
				$ucModel->user_id=$uModel->id;
				$ucModel->address='';
				$ucModel->post_num='';
				$ucModel->email='';
				$ucModel->tel='';	
				$ucModel->pre_id=$pModel->pre_id;			
				$ucModel->uc_fname=$uc_fname;			
				$ucModel->uc_lname=$uc_lname;	
				$ucModel->faculty_id=$fModel->faculty_id;
				$ucModel->branch_id=$bModel->branch_id;			
				$ucModel->group=$group;
				$count=strlen($value2[1]);
				$ucModel->number=$value2[1][$count-3].$value2[1][$count-2];
				$ucModel->save();
				$create++;			
			}		
			else{
				$ucModel=$ucModel->one();
				$ucModel->pre_id=$pModel->pre_id;			
				$ucModel->uc_fname=$uc_fname;			
				$ucModel->uc_lname=$uc_lname;	
				$ucModel->faculty_id=$fModel->faculty_id;
				$ucModel->branch_id=$bModel->branch_id;			
				$ucModel->group=$group;
				$count=strlen($value2[1]);
				$ucModel->number=$value2[1][$count-3].$value2[1][$count-2];
				$ucModel->save();
				$update++;	
			}	
			$total++;		
		}
	}
}

?>