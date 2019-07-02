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
				 // 'only' => ['logout', 'signup'],
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
						// 'actions' => ['test','logout','qrcode'],
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
// 	public function beforeAction($action)
// {

//     \Yii::$app->response->format = Response::FORMAT_JSON;
//     return parent::beforeAction($action);
// }
	public function actionQrcode(){

		return json_encode() ;

	}
	public function actionTest(){
		$val1=Yii::$app->Func->encode('A05454 54');
		$val2=Yii::$app->Func->encode('A05454 55');
		$val3=Yii::$app->Func->encode('A05454 56');
		echo $val1;
		echo '<br>'.$val2;
		echo '<br>'.$val3;
		echo '<br>'.Yii::$app->Func->decode($val1);
		echo '<br>'.Yii::$app->Func->decode($val2);
		echo '<br>'.Yii::$app->Func->decode($val3);
	}
	// private function encode($data){
	// 	return Yii::$app->getSecurity()->encryptByPassword($data, $this->secretKey);
	// }
	// private function decode($data){
	// 	return Yii::$app->getSecurity()->decryptByPassword($data, $this->secretKey);
	// }

	public function actionLogin()
	{
		$model = new LoginForm();

		 $var=$_POST;
		 	print_r($_POST);
		 // $model->username=$var['user'];
		 // $model->password=$var['pass'];

		 $model->username='581102064117';
		 $model->password='chinnawat1';

		$user=User::findByUsername($model->username);
		if (
			Yii::$app->getSecurity()->validatePassword(
				$model->password, 
				$user->password_hash
			)
		) {
			Yii::$app->user->login($user);

		$this->pushT('loginStatus',true,true);
		$user = User2::findByUsername($model->username);
		$this->mapLogin($user->username);
			// $array=Yii::$app->Func->mapArray($user->collegian);


	}
	else{
		$this->pushT('loginStatus',false,true);
	}
		// return json_encode($_POST);
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

		$this->pushT('loginStatus',false,true);
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
	$user = User2::find()->where(['username'=>$getsearch])->one();
	// print_r($user);
		// $this->model=$user;
		// $this->pushT('loginStatus',true);
		// // $this->pushT('level',Yii::$app->Func->level($user->level_user));
		// if($user->level_user=='0') {
		// 	echo 0;
		// }
		// else if($user->level_user=='1') {
		// 	echo 1;
		// }
		// else if($user->level_user=='2') {

		// 	$this->data['uc_fname']=$this->model->userCollegian->uc_fname;
		// 	$this->data['uc_lname']=$this->model->userCollegian->uc_lname;

		// 	$this->data['branch_name']=$this->model->userCollegian->branch->branch_name;

		// 	// $this->pushT('collegian->uc_fname');
		// 	// $this->pushT('collegian->uc_lname');
		// 	// $this->pushT('collegian->faculty->faculty_name');
		// 	// $this->pushT('collegian->branch->branch_name');
		// 	// $this->pushT('collegian->address');
		// }
		// else{
		// 	$this->pushT('loginStatus',false,true);
		// }


}

private function mapdata($model=null){
	if($model==null){$model=$this->model;}
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
	return json_encode($this->data);
}


}
