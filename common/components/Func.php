<?php
namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Json;
use PhpOffice\PHPExcel;
use PhpOffice\PHPExcel_IOFactory;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use frontend\models\User;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\depdrop\Depdrop;
use yii\widgets\MaskedInput;
use kartik\widgets\FileInput;
use kartik\widgets\DatePicker;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use kartik\daterange\DateRangePicker;
use yii\filters\AccessControl;
use common\commands\AccessRule;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\User as User2;
use backend\models\LoginForm;
use common\components\AcColumn as AC;


header("content-type:text/javascript;charset=utf-8");



class Func extends Component {
	public function get_host() {
		if ($host = $_SERVER['HTTP_X_FORWARDED_HOST'])
		{
			$elements = explode(',', $host);

			$host = trim(end($elements));
		}
		else
		{
			if (!$host = $_SERVER['HTTP_HOST'])
			{
				if (!$host = $_SERVER['SERVER_NAME'])
				{
					$host = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
				}
			}
		}

    // Remove port number from host
		$host = preg_replace('/:\d+$/', '', $host);

		return trim($host);
	}
	
	public function accesbackend(){
		return [
			'access' => [
				'class' => AccessControl::className(),

				'ruleConfig' => [
					'class' => AccessRule::className()
				],
				'denyCallback' => function ($rule, $action) {
					throw new \Exception('คุณไม่ได้รับอนุญาติให้ใช้งานในหน้านี้');
				},

				'rules' => [

					[
						'actions'=>['login','error','exception'],
						'allow' => true,
						'roles' => [
							'?'
						]
					],
					[
						'actions'=>['error','index','exception'],
						'allow' => true,
						'roles' => [
							'@'
						]
					],
					[
						'allow' => true,
						'roles' => [
							User2::ADMIN
						]
					],
				],
			],
		];
	}
	public function addDayswithdate($date,$days){
		$date = strtotime("+".$days." days", strtotime($date));
		return  date("Y-m-d", $date);
	}
	public function  compareDate($date1,$date2){
		$date1 = strtotime($date1);
		$date2 = strtotime($date2);
		return round(abs($date2 - $date1) / (60*60*24),0);
	}
	public function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d' ) {
		$dates = array();
		$current = strtotime($first);
		$last = strtotime($last);

		while( $current <= $last ) {
			$dates[] = date($format, $current);
			$current = strtotime($step, $current);
		}
		return $dates;
	}
	public function QrColumn($text){
		return Html::a('<i class="fa fa-qrcode" aria-hidden="true"></i>', ['qrcode','id'=>$text], ['target' => '_blank','class' => 'btn btn-xs btn-primary'])
		.Html::a('<i class="fa fa-print" aria-hidden="true"></i>',
			['print','id'=>$text], ['target' => '_blank','class' => 'btn btn-xs btn-success']);

	}

	public function mapArray($array){
		foreach ($array as $key=> $value) {
			$text["$key"]=$value;
		}
		return $text;
	}
	// function encode($str){

	// 	for($i=0; $i<5;$i++)
	// 	{
	//
	// 		$str=strrev(base64_encode($str));
	// 	}
	// 	return $str;
	// }


	// function decode($str){
	// 	for($i=0; $i<5;$i++)
	// 	{
	// 		$str=base64_decode(strrev($str));
	// 	}

	// 	return $str;
	// }
	protected function mycrypt( $string, $action = 'e' ) {

		// you may change these values to your own

		$secret_key = '@PCRUAc_key1';

		$secret_iv = '@PCRUAc_iv1';

		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash('sha256',$secret_key);
		$iv = substr(hash('sha256',$secret_iv),0,16);

		if( $action == 'e' ) {

			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );

		}

		else if( $action == 'd' ){

			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );

		}

		return $output;

	}

	public function encode($string){

		$salting = substr(md5(microtime()),-1) . $string;

		return $this->mycrypt( $salting,'e');

	}

	public function decode($string){

		$encode = $this->mycrypt( $string, 'd' );

		return substr($encode, 1);

	}	
	protected function ForEn($data){
		$count=strlen($data);
		
		$text='';	
		for($i=0;$i<$count;$i++){
			switch ($data[$i]) {
				case '0':$text.='A';break;
				case '1':$text.='F';break;
				case '2':$text.='K';break;
				case '3':$text.='O';break;
				case '4':$text.='S';break;
				case '5':$text.='W';break;
				case '6':$text.='B';break;
				case '7':$text.='G';break;
				case '8':$text.='L';break;
				case '9':$text.='P';break;		
			}		
			// $text.=$data[$i];	
			
		}
		return $text;
		

	}
	protected function ForDe($data){
		$count=strlen($data);
		
		$text='';	
		for($i=0;$i<$count;$i++){
			switch ($data[$i]) {
				case 'A':$text.='0';break;
				case 'F':$text.='1';break;
				case 'K':$text.='2';break;
				case 'O':$text.='3';break;
				case 'S':$text.='4';break;
				case 'W':$text.='5';break;
				case 'B':$text.='6';break;
				case 'G':$text.='7';break;
				case 'L':$text.='8';break;
				case 'P':$text.='9';break;		
			}		
			// $text.=$data[$i];	
			
		}
		return $text;
		

	}
	public function QREncode($data) { 
		$data=explode(' ',$data);
		$data[0]=dechex($data[0]);
		$data[1]=$this->ForEn($data[1]);
		
		// $data[1]=dechex($data[1]);
		$data[2]=strtotime($data[2]);
		$data=$data[0].' '.$data[1].' '.$data[2];
		return $data; 
	} 

	public function QRDecode($data) {
		$data=explode(' ',$data);
		$data[0]=hexdec($data[0]);
		$data[1]=$this->ForDe($data[1]);
		// $data[1]=hexdec($data[1]);
		$data[2]=date('Y-m-d',$data[2]);
		$data=$data[0].' '.$data[1].' '.$data[2]; 
		return $data; 
	}
	public function EnterStatus($data){
		$array=[
			'1'=>'ยังไม่ได้เข้าร่วม',
			'2'=>'เข้าร่วมแล้ว'
		];
		return $data;

	}
	public function SetTime($time){
		$time=explode(':',$time);
		return $time[0].':'.$time[1];
	}

	protected function level_user(){
		return Yii::$app->User->identity->level_user;
	}

	public function AcColumn($site=null){
		return (new AC)->AcColumn($site);
	}
	//แสดงระดับของผู้ใช้
	public function Level($level){

		return $this->ArrayLevel()[$level];
	}
	public function Input($type='text'){
		if($type==='text'){
			return '
			<div class="form-group bmd-form-group">
			<label class="bmd-label-floating">{label}</label>
			<span class="required">*</span>
			{input}
			</div>
			';


		}
	}
	//Array ระดับของผู้ใช้
	public function ArrayLevel($choice=null){
		$array=[
			'0'=>'ผู้ดูแลระบบ',
			'1'=>'เจ้าหน้าที่',
			'2'=>'นักศึกษา'
		];
		if(isset($choice)){
			unset($array[$choice]);

		}
		return $array;

	}
	//เปลี่ยนสี โดยใส่ โค้ดสี #xxx หรือ #xxxxxx แล้วใส่ให้สีเข้มหรือจางลงด้วยตัวเลข
	public function colorCon($hex, $steps) {
		$steps = max(-255, min(255, $steps));
		$hex = str_replace('#', '', $hex);
		if (strlen($hex) == 3) {
			$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
		}
		$color_parts = str_split($hex, 2);
		$return = '#';
		foreach ($color_parts as $color) {
			$color   = hexdec($color);
			$color   = max(0,min(255,$color + $steps));
			$return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT);
		}
		return $return;
	}
	/**
	Mapdata(Arrayข้อมูล,ชื่อฟิลล์ที่เป็น ID,ชื่อฟิลล์ที่แสดงออกมา,ชื่อฟิลล์ที่เป็นรหัส,มีเลือกทั้งหมดหรือธรรมดา(ใช้สำหรับDepdrop))
	*/
	public function MapDataDropDown($datas,$fieldId,$fieldName,$no,$type=null){
		$obj = [];
		if($type=='ALL'){
			$obj[]=['id'=>'ALL','name'=>'ทั้งหมด'];
		}
		foreach ($datas as $key => $value)
		{
			$obj[$value->{$fieldId}]=$value->{$no}.' - '.$value->{$fieldName};
		}
		if($obj!=[]){
			return $obj;
		}
		else{
			return null;
		}
	}
	public function GenYear(){

		$array=[];
		$year=date('Y')+543+1;
		$n=$year-2557+1;
		while($n!==0){
			$array["{$year}"]="{$year}";
			$year--;
			$n--;
		}
		return $array;
	}
	//วันเดือนปีไทย
	public function DateThaiFull($date)
	{
		list($year,$month,$day) = explode('-',$date);
		if($day <10){
			$day = substr($day,1,1);
		}

		$thMonth = array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน",     
			"กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		if($month<10){
			$month = substr($month,1,1);
		}

		// $year +=543;

		return $day." ".$thMonth[$month-1]." พ.ศ.".$year;  
	}
	public function DateThai($date)
	{
		list($year,$month,$day) = explode('-',$date);
		if($day <10){
			$day = substr($day,1,1);
		}

		$thMonth = Array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค","พ.ย.","ธ.ค.");
		if($month<10){
			$month = substr($month,1,1);
		}

		// $year +=543;

		return $day." ".$thMonth[$month-1]." ".$year;  
		
	}
	public function DateThaiSlash($date)
	{
		list($year,$month,$day) = explode('-',$date);
		if($day <10){
			$day = substr($day,1,1);
		}

		$thMonth = Array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค","พ.ย.","ธ.ค.");
		if($month<10){
			$month = substr($month,1,1);
		}

		// $year +=543;

		return $day."/".$thMonth[$month-1]."/".$year[2].$year[3];  
		
	}
	public function Datetothai($date)
	{
		list($year,$month,$day) = split('-',$date);
		if($day <10){
			$day = substr($day,1,1);
		}		
		if($month<10){
			$month = substr($month,1,1);
		}

		$year +=543;

		return $day."&nbsp;".$month."&nbsp;".$year;  
	}
	public function DateTimeThai()
	{
		$strYear = date("Y");
		$strMonth= date("n");
		$strDay= date("j");

		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}
	//function ที่ทำให้ตัวเลขใส่ comma(,)
	public function number_format($number,$decimal = '.')
	{
		$text='';
		$broken_number = explode($decimal,$number);
		return number_format($broken_number[0]).$decimal.substr($broken_number[1],0,2);
	}
	//function ที่ทำให้ลิงค์เมนูของ matterial dashboard มัน active ตามลิงค์
	public function activelink($url,$type=null){
		$url=Url::to($url);
		$host=$_SERVER['REQUEST_URI'];
		if($host[strlen($host)-1]=='/')$host.='index';
		$host=explode('/',$host);
		$array=explode('/',$url);
		$count=count($host)-1;
		$count2=count($array)-1;


		$text='';
		$text2='';
		$i=1;
		if($count>=$count2){
			$ab=$count;
		}
		else if($count<$count2){
			$ab=$count2-1;
		}
		else {
			$ab=null;
		}
		while($i<=$ab)
		{
			isset($host[$i])?$text.="/$host[$i]":null;
			isset($array[$i])?$text2.="/".$array[$i]:null;
			$i++;
		}
		if($url!=Yii::getAlias('@web')){
			//return $text.'<br>'.$text2;

			if($text==$text2)
			{
				return 'class="active"';
			}
			else{
				if($count<=$count2){
					if($host[2]==$array[2]&&$host[2]!='backend')
					{
						if($host[3]==$array[3]){
							return 'class="active"';
						}
					}
					else if(isset($host[3])&&$host[3]==$array[3]&&$host[2]=='backend')
					{
						if($host[4]==$array[4]){
							return 'class="active"';
						}
					}
					else{
						return null;
					}
				}
				else{
					return null;
				}
			}

		}
		if(Yii::getAlias('@web').'/'==$_SERVER['REQUEST_URI'])
		{
			return 'class="active"';
		}
	}
	public function sidebar($data){
		echo '<div class="sidebar-wrapper">
		<ul class="nav">';


		foreach ($data['column'] as $key => $value) {
			$active=$this->activelink($value['url'],isset($value['type'])&&$value['type']!=null?$value['type']:null);
			echo
			"
			<li $active>
			<a href=\"$value[url]\">
			<i class=\"material-icons\">$value[icon]</i>
			<p>$value[label]</p>
			</a>
			</li>"
			;

		}
		echo '</ul>
		</div>';
	}
}

?>
