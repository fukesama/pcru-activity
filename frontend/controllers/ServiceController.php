<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use common\commands\AccessRule;

use frontend\models\User as User2;
use frontend\models\UserC ;
use backend\models\UserCollegian ;
use backend\models\ActivityEnterDetail;
use backend\models\ActivityEnter;
header("Access-Control-Allow-Origin:*");
header("content-type:text/javascript;charset=utf-8");
header("content-type:applicaton/json;charset=utf-8");
/**
* Site controller.
*/
class ServiceController extends Controller
{
	/**
	* {@inheritdoc}
	*/
	private $data=[];
	private $model;
	private $secretKey='PCRUAc';

	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout', 'signup'],
				'ruleConfig' => [
					'class' => AccessRule::className(), // เรียกใช้งาน accessRule (component) ที่เราสร้างขึ้นใหม่
				],
				'rules' => [
					[
						'actions' => ['login'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'actions' => ['logout','qrcode'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors' => [
					// restrict access to
					// ยอมให้เข้าใช้เฉพาะ
					// 'Origin' => ['*'],
					// Allow only POST and PUT methods
					'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
					// Allow only headers 'X-Wsse',
					'Access-Control-Request-Headers' => ['*'],
					// Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
					'Access-Control-Allow-Credentials' => true,
					// Allow OPTIONS caching
					'Access-Control-Max-Age' => 3600,
					// Allow the X-Pagination-Current-Page header to be exposed to the browser.
					'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
				],
			],
		];
	}
	public function init()
	{
		$this->layout = false;
	}
	/**
	* {@inheritdoc}
	*/
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}
	public function actionQrcode2(){
		$var['text']='สแกนไม่สำเร็จ';
		if(Yii::$app->request->post()){
			$qrcode=$_POST['qrcode'];
		
			$qrcode=Yii::$app->Func->QRDecode($qrcode);
			// $var['text']=$qrcode;
			// return json_encode($var);
			$arr=explode(" ",$qrcode);	
		
			$AcEn=Yii::$app->db->createCommand("SELECT COUNT(*)as count FROM Activity_Enter where acoyd_id='".$arr[0]."' and co_id='".$_POST['id']."'");
			
			$countAcEn=$AcEn->queryAll();
			$countAcEn=$countAcEn[0]['count'];
			
			if($countAcEn==0){
				
				$var['text']='คุณไม่มีสิทธิทำกิจกรรมนี้';
				return json_encode($var);
			}
			elseif($countAcEn>0){
					//ตรวจสอบว่ารหัสคิวอาร์โค้ดได้ถูกใช้ไปแล้ว
				$AcEnDe=Yii::$app->db->createCommand("SELECT COUNT(*)as count FROM Activity_Enter_Detail where qrcode='".$arr[0].' '.$arr[1]."' and acend_date='".$arr[2]."'");
				$countAcEnDe=$AcEnDe->queryAll();
				$countAcEnDe=$countAcEnDe[0]['count'];
				if($countAcEnDe>0){
					$var['text']='คิวอาร์โค้ดนี้ถูกใช้ไปแล้ว ';
					return json_encode($var);
				}



				$AcEn=Yii::$app->db->createCommand("SELECT acen_id FROM Activity_Enter where acoyd_id='".$arr[0]."' and co_id='".$_POST['id']."'");

				$AcEnModel=$AcEn->queryAll();
				$AcEnModel=$AcEnModel[0]['acen_id'];
				

				$AcEnDe=Yii::$app->db->createCommand("SELECT COUNT(*)as count FROM Activity_Enter_Detail where acen_id='".$AcEnModel."' and acend_date='".$arr[2]."'");

				$countAcEnDe=$AcEnDe->queryAll();
				$countAcEnDe=$countAcEnDe[0]['count'];


				//ตรวจสอบว่าน.ศ.ได้สแกน QR Code ไปแล้ว
				if($countAcEnDe>0){					
					$var['text']='คุณแสกนคิวอาร์โค้ดกิจกรรมนี้ของวันนี้ไปแล้ว';
					return json_encode($var) ;
				}
				elseif($countAcEnDe==0){
					if($arr[2]==(date('Y')+543).date('-m-d')){
						// $AcEnDe=Yii::$app->db->createCommand("SELECT COUNT(*)as count FROM Activity_Enter_Detail where acend_id='".$arr[0]."' and acend_date='".$arr[2]."'");

						// $countAcEnDe=$AcEnDe->queryAll();
						// $countAcEnDe=$countAcEnDe[0]['count'];
						// $var['text']=$arr[0].' '.$arr[2];

						// return json_encode($var);

						$model=Yii::$app->db->createCommand("UPDATE Activity_Enter SET `enter_status`='2'   WHERE `acoyd_id`='".$arr[0]."' AND `co_id`='".$_POST['id']."'")->query();
						$AcEn=Yii::$app->db->createCommand("SELECT * FROM Activity_Enter where acoyd_id='".$arr[0]."' and co_id='".$_POST['id']."'")->queryAll();
						$model=Yii::$app->db->createCommand("INSERT INTO activity_enter_detail (acen_id,qrcode,acend_date) VALUES('".$AcEn[0]['acen_id']."','".$arr[0].' '.$arr[1]."','".$arr[2]."')");
						if($model->query()){
							$var['text']='คุณสแกนคิวอาร์โค้ดกิจกรรมของวันที่ '.$arr[2].' สำเร็จ ';
							return json_encode($var);
						}
						else{
							$var['text']='เกิดข้อผิดพลาด!!! คุณอาจสแกนคิวอาร์โค้ดกิจกรรมของวันที่ '.$arr[2].' ไปแล้ว';
							return json_encode($var);
						}	
					}
					else{
						$var['text']='คุณสแกนคิวอาร์โค้ดกิจกรรมของวันที่ '.$arr[2].' ซึ่งไม่ตรงกับวันที่กิจกรรมวันนี้วันที่ '.Yii::$app->Func->DateThai((date('Y')+543).date('-m-d'));
						return json_encode($var);
					}
				}
			}	
		}
	}

	public function actionQrcode(){
		$var['text']='สแกนไม่สำเร็จ';
		if(Yii::$app->request->post()){
			$qrcode=$_POST['qrcode'];
			$qrcode=Yii::$app->Func->decode($_POST['qrcode']);

			$arr=explode(" ",$qrcode);	

			$AcEn=ActivityEnter::find()->where("acoyd_id='".$arr[0]."' and co_id='".$_POST['id']."'");
			

			$countAcEn=$AcEn->count();
			
			if($countAcEn==0){
				
				$var['text']='คุณไม่มีสิทธิทำกิจกรรมนี้';
				return json_encode($var);
			}
			elseif($countAcEn>0){
					//ตรวจสอบว่ารหัสคิวอาร์โค้ดได้ถูกใช้ไปแล้ว
				$AcEnDe=ActivityEnterDetail::find()->where("qrcode='".$arr[0].' '.$arr[1]."' and acend_date='".$arr[2]."'");
				$countAcEnDe=$AcEnDe->count();

				if($countAcEnDe>0){
					$var['text']='คิวอาร์โค้ดนี้ถูกใช้ไปแล้ว ';
					return json_encode($var);
				}

				$AcEn=ActivityEnterDetail::find()->where("acend_id='".$arr[0]."' and acend_date='".$arr[2]."'");
				$countAcEnDe=$AcEnDe->count();

				//ตรวจสอบว่าน.ศ.ได้สแกน QR Code ไปแล้ว
				if($countAcEnDe>0){					
					$var['text']='คุณแสกนคิวอาร์โค้ดกิจกรรมนี้ของวันที่ '.$arr[2].' ไปแล้ว';
					return json_encode($var) ;
				}
				elseif($countAcEnDe==0){
					// $AcEn=ActivityEnter::find()->where("acend_id='".$arr[0]."'")->one();
					// $AcEnDe=ActivityEnterDetail::find()->where("acen_id='".$AcEn->acen_id."'");
					// $countAcEnDe=$AcEnDe->count();

					// $day=$AcEn->acoyd->day;
					$AcEn=Yii::$app->db->createCommand("SELECT * FROM Activity_Enter where acoyd_id='".$arr[0]."' and co_id='".$_POST['id']."'")->queryAll();

					$AcEnDe=Yii::$app->db->createCommand("SELECT COUNT(*)as count FROM Activity_Enter_Detail where acend_id='".$arr[0]."'");
					$countAcEnDe=$AcEnDe->queryAll();
					$countAcEnDe=$countAcEnDe[0]['count'];

					$AcEn=Yii::$app->db->createCommand("SELECT * FROM activity_ofyear_detail where acoyd_id='".$arr[0])->queryAll();					
					$day=$AcEn[0]['day'];

					$sql="UPDATE Activity_Enter SET `enter_status`='2'";
					if($countAcEnDe>$day||$countAcEnDe==$day){
						$sql.=",`result`='ผ'";
					}					
					$sql.=" WHERE `acoyd_id`='".$arr[0]."' AND `co_id`='".$_POST['id']."'";
					$model=Yii::$app->db->createCommand($sql)->query();
					$AcEn=Yii::$app->db->createCommand("SELECT * FROM Activity_Enter where acoyd_id='".$arr[0]."' and co_id='".$_POST['id']."'")->queryAll();
					$model=Yii::$app->db->createCommand("INSERT INTO activity_enter_detail (acen_id,qrcode,acend_date) VALUES('".$AcEn[0]['acen_id']."','".$arr[0].' '.$arr[1]."','".$arr[2]."')");
					if($model->query()){
						$var['text']='คุณสแกนคิวอาร์โค้ดกิจกรรมของวันที่ '.$arr[2].' สำเร็จ ';
						return json_encode($var);
					}		
				}
			}	
		}		
	}

	private function encode($data){
		return Yii::$app->getSecurity()->encryptByPassword($data, $this->secretKey);
	}
	private function decode($data){
		return Yii::$app->getSecurity()->decryptByPassword($data, $this->secretKey);
	}

	public function actionLogin()
	{
		$model = new LoginForm();
		$var=$_POST;
		$model->username=$var['user'];
		$model->password=$var['pass'];

		// $model->username='581102064117';
		// $model->password='chinnawat1';

		$user = User2::find()->where(['username'=>$model->username])->one();
		if (Yii::$app->getSecurity()->validatePassword($model->password, $user->password_hash)) {

			Yii::$app->user->login($user);

			$this->pushT('loginStatus',false,true);
			$user = User2::find()->where(['username'=>$model->username])->one();

			// $this->pushT('uc_fname',$user->collegian->uc_fname);
			// $this->pushT('uc_lname',$user->collegian->uc_lname);
			// $this->pushT('branch_name',$user->userCollegian->branch->branch_name);

			$this->mapLogin($user->username);
			$array=Yii::$app->Func->mapArray($user->userCollegian);


		}
		else{
			$this->pushT('loginStatus',false,true);
		}

		return $this->value();
	}

	public function actionLogin2()
	{

		$this->logout();


		$contentdata=file_get_contents("php://input");
		$contentdata=[
			'user'=>'581102064117',
			'pass'=>'chinnawat1'
		];
		$contentdata=json_encode($contentdata);

		$getdata=json_decode($contentdata);


		$getsearch=$getdata->user;
		$pass=$getdata->pass;

		$model = new LoginForm();

		$model->username=$getsearch;
		$model->password=$pass;

		$user=User::findByUsername($model->username);
		if (Yii::$app->getSecurity()->validatePassword($model->password, $user->password_hash)) {
			Yii::$app->user->login($user);

			$this->pushT('loginStatus',true,true);
			$user = User2::findByUsername($model->username);
			$this->mapLogin($user->username);
			$array=Yii::$app->Func->mapArray($user->userCollegian);


		}
		else{
			$this->pushT('loginStatus',false,true);
		}

		return $this->value();

	}
	public function mapLogin($getsearch){
		$user = User2::findByUsername($getsearch);
		$this->model=$user;
		$this->pushT('loginStatus',true);
		$this->pushT('id',$user->id);
		$this->pushT('level',Yii::$app->Func->level($user->level_user));
		if($user->level_user=='0') {
			echo 0;
		}
		else if($user->level_user=='1') {
			echo 1;
		}
		else if($user->level_user=='2') {

			// $this->data['uc_fname']=$user->userCollegian->uc_fname;
			// $this->data['uc_lname']=$user->userCollegian->uc_lname;
			// $this->data['branch_name']=$user->userCollegian->branch->branch_name;
			$this->pushT('userCollegian->pre->pre_name');
			$this->pushT('userCollegian->uc_fname');
			$this->pushT('userCollegian->uc_lname');
			$this->pushT('userCollegian->fac->faculty_name');
			$this->pushT('userCollegian->bra->branch_name');
			$this->pushT('userCollegian->address');
		}
		else{
			$this->pushT('loginStatus',false,true);
		}


	}

	private function mapdata($model=null){
		if($model==null){
			$model=$this->model;
		}
		yii\helpers\ArrayHelper::mapdata();
		return $data;
	}
	private function pushT($keyData,$dataPush=null,$reset=false){
		$type=gettype($dataPush);

		if($type=='boolean'){
			$reset=true;
		}
		if($reset===true){
			$this->data=[];
		}
		if($dataPush!==null){
			$this->data["$keyData"]=$dataPush;
		}
		else if(strpos($keyData, '->') !== false){
			$model=$this->model;
			$key=explode('->',$keyData);
			$count=count($key)-1;

			for ($i=0;true;) {
				$text=''.$key[$i];
				$model=$model->$text;
				if($key[$i]==$key[$count]){
					break;
				}
				$i++;
			}

			$this->data[$key[$count]]=$model;
		}
	}
	private function pushA($data,$reset=false){
		if($reset===true){
			$this->data=[];
		}
		foreach ($data as $key => $value) {
			$this->pushT("$key",$value);
		}

	}
	public function actionLogout()
	{
		return $this->logout();
	}
	public function logout()
	{
		Yii::$app->user->logout();
		Yii::$app->getSession()->destroy();
		return json_encode('Logout Success');
	}
	private function value(){
		// return json_encode(['loginStatus'=>true]);
		return json_encode($this->data);
	}


}
