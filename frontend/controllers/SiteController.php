<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\User;
use common\commands\AccessRule;
use frontend\models\ActivityEnterSearch;
use frontend\models\User as User2;
use kartik\mpdf\Pdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

use backend\models\ActivityEnter;
use yii2fullcalendar\yii2fullcalendar;

// use frontend\models\ActivityEnter;
use yii2fullcalendar\models\Event;
use backend\models\ActivityOfyearDetail;
use backend\models\ActivityOfyearDetailSearch;
// use \yii2fullcalendar\models\Event;

/**
* Site controller.
*/
class SiteController extends Controller
{
	/**
	* {@inheritdoc}
	*/
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout','index'],
				'ruleConfig' => [
					'class' => AccessRule::className(), // เรียกใช้งาน accessRule (component) ที่เราสร้างขึ้นใหม่
				],
				'rules' => [
					[         
						'actions' =>['index'],               
						'allow' => true,
						'roles' => [User::COLLEGIAN],
					],
					[
						'actions' =>['logout'],
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
		];
	}

	/**
	* {@inheritdoc}
	*/
	public function beforeAction($action){
		if (!Yii::$app->user->isGuest) {
			if (Yii::$app->User->identity->level_user == '0'||Yii::$app->User->identity->level_user == '1') {
				return $this->redirect(['backend/site']);
			}
		}

		return parent::beforeAction($action);
	}
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
	public function actionCalender($id=''){	
		$events=$this->dataCalender($id);
		return $this->render('calender',['id'=>$id,'events'=>$events]);
	}
	
	protected function dataCalender($id){
		if($id!=''){
			$model = ActivityEnter::find()->where(['co_id'=>$id])->all();
			$events = array();
			foreach ($model AS $time){

				$Event = new Event();
				$Event->id = $time->acoyd_id;
				$Event->title = $time->acoyd->acoy->acoy_id.' - '.$time->acoyd->acoy->ac->ac_name;
				$start=strtotime($time->acoyd->ac_startdate);
				$end=strtotime($time->acoyd->ac_enddate);
					// $Event->allDay=true;
				
				$Event->url=Url::to(['','id'=>$Event->id]);
				$Event->start = (date('Y',$start)-543).date('-m-d',$start);
				$Event->end = (date('Y',$end)-543).date('-m-d',$end);
				$events[] = $Event;
			}

			return $events;
		}		

		$model = ActivityOfyearDetail::find()->all();
		$events = array();
		foreach ($model AS $time){

			$Event = new Event();
			$Event->id = $time->acoyd_id;
			$Event->title = $time->acoyd_id.' - '.$time->acoy->ac->ac_name;
			$start=strtotime($time->ac_startdate);
			$end=strtotime($time->ac_enddate);
			$Event->start = (date('Y',$start)-543).date('-m-d',$start);
			$Event->end = (date('Y',$end)-543).date('-m-d',$end);
			$events[] = $Event;
		}
		
		return $events;
	}

	/**
	* Displays homepage.
	*
	* @return mixed
	*/

	public function actionIndex()
	{
		if (!Yii::$app->user->isGuest) {
			if (Yii::$app->User->identity->level_user == '0'||Yii::$app->User->identity->level_user == '1') {
				return $this->redirect(['backend/site']);
			}
		}
		else{
			return $this->redirect(['login']);
		}
		$query=ActivityEnter::find()
		->innerJoinWith('acoyd as acoyd')
		->innerJoinWith('acoyd.acoy as acoy')
		->innerJoinWith('acoyd.acoy.ac as ac')
		->where(['co_id'=>Yii::$app->User->identity->id]);
		$searchModel = new ActivityEnterSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$query);

		return $this->render('index', [
			 'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);


	}
	public function actionView($acen_id)
	{
		$model=ActivityEnter::find()->where(['acen_id'=>$acen_id,'co_id'=>Yii::$app->User->identity->id]);
		if($model->count()<=0){
			return $this->redirect(['site/index']);
		}
		else{
			return $this->render('view', [
				'model' => $model->one(),'acen_id'=>$acen_id
			]);
		}

	}

	/**
	* Logs in a user.
	*
	* @return mixed
	*/
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->redirect(['/site']);
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			if (Yii::$app->User->identity->level_user == '0' ||Yii::$app->User->identity->level_user == '1') {
				return $this->redirect(['backend/site']);
			} else {
				return $this->goBack();
			}
		} else {
			$model->password = '';

			return $this->render('login', [
				'model' => $model,
			]);
		}
	}

	/**
	* Logs out the current user.
	*
	* @return mixed
	*/
	public function actionLogout()
	{
		Yii::$app->user->logout();
		Yii::$app->getSession()->destroy();

		return $this->goHome();
	}

	/**
	* Displays contact page.
	*
	* @return mixed
	*/
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
				Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
			} else {
				Yii::$app->session->setFlash('error', 'There was an error sending your message.');
			}

			return $this->refresh();
		} else {
			return $this->render('contact', [
				'model' => $model,
			]);
		}
	}

	public function actionOne()
	{
		$model=ActivityOfyearDetail::find()->orderBy(['ac_startdate'=>SORT_DESC]);
		
		$searchModel = new ActivityOfyearDetailSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$model);

		return $this->render('one', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	public function actionReportOne($edu_level='')
	{
		$content = $this->renderPartial('report_one',['edu_level'=>$edu_level]);
		$pdf=$this->pdf($content);
		return $pdf->render();
	}
	public function pdf($content){
		$pdf = new Pdf([
			'mode' => Pdf::MODE_UTF8,
			'format' => Pdf::FORMAT_A4,
			'orientation' => Pdf::ORIENT_PORTRAIT,
			'destination' => Pdf::DEST_BROWSER,
			'marginLeft' => 10,
			'marginRight' => 10,
			'marginTop' => 10,
			'marginBottom' => 10,
			'content' => $content,

			'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
			'cssInline' =>'

			.logo{
				height:132.283465px;width:auto;
			}
			.fl{
				display:block;
				float:left;

			}
			.container {
				width: 100%;
				padding-right: 15px;
				padding-left: 15px;
				margin-right: auto;
				margin-left: auto
			}
			.col {
				-ms-flex-preferred-size: 0;
				flex-basis: 0;
				-ms-flex-positive: 1;
				flex-grow: 1;
				max-width: 100%;

			}
			.container > .col-1,.col-2,.col-3,.col-4,.col-5,.col-6,.col-7,.col-8,.col-9,.col-10,.col-11,.col-12 {

				padding: 20px 0;
				float:left;
			}
			.col-auto {
				-ms-flex: 0 0 auto;
				flex: 0 0 auto;
				width: auto;
				max-width: 100%
			}
			.row {
				display: -ms-flexbox;
				display: flex;
				-ms-flex-wrap: wrap;
				flex-wrap: wrap;
				margin-right: -15px;
				margin-left: -15px;
				width:100%;
			}
			.col-1{
				width:8.333333333%;
			}
			.col-2{
				width:16.66666667%;
			}
			.col-3{
				width:25%;
			}
			.col-4{
				width:33.33333333%;
			}
			.col-5{
				width:41.66666667%;
			}
			.col-6{
				width:50%;
			}
			.col-7{
				width:58.33333333%;
			}
			.col-8{
				width:66.66666667%;
			}
			.col-9{
				width:75%;
			}
			.col-10{
				width:83.33333333%;
			}
			.col-11{
				width:91.66666667%;
			}
			.col-12{
				width:100%;
			}
			.container-fluid div{
				border:1px solid black;
			}


			.split2{
				display: block;
				width: 50%;
				float:left;
				text-align: left;

			}

			.dif1,.dif2{
				display: block;
				width: 46%;
				text-align: left;
			}
			.dif1{
				float: left;
			}
			.dif2{
				float: right;
			}
			table.border, table.border th, table.border td {
				border: 1px solid black;
				border-collapse: collapse;

			}
			table.border{
				width:100%;
				font-size:15px;

			}
			table.border tr td
			body{
				font-size:16px;
				font-family:thsaraban;
				filter: grayscale(100%);
			}
			.disBor{
				border:none;
			}
			.mg-c{
				margin-left: auto;
				margin-right: auto
			}
			.mg-l{
				margin-left: 5px
			}
			.mg-r{
				margin-right: 20px
			}
			.t-l{
				text-align: left;
			}
			.t-r{
				text-align: right;
			}
			.t-c{
				text-align: center;
			}
			table tr td{
				text-align:center;
			}
			.f10{
				font-size:10px
			}
			.dif1 div div.dif1,.dif2 div div.dif1,.dif1 div div.dif2,.dif2 div div.dif2{
				display:block;
				float:left;


			}

			.dif1 div div.dif1,.dif2 div div.dif1{
				width:40px;
			}
			.dif1 div,.dif2 div{
				width:calc(100%-25px);
			}
			.dif1 div div.dif2 div,.dif2 div div.dif2 div{
				display:block;
				float:left;
				width:190px;
			}
			.a4{
				height:29.7cm;
				max-height:29.7cm;
			}
			.a42{
				max-height:25cm;
			}
			.dot{
				border-bottom: 1px #222 dotted;
			}
			'
			,
			'options' => ['title' => 'ทรานสคิปกิจกรรม'],
			'methods' => [ 

			]
		]);
		// Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
		$headers = Yii::$app->response->headers;
		$headers->add('Content-Type', 'application/pdf; charset=utf-8');

		$defaultConfig = (new ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];

		$pdf->options['fontDir'] = array_merge($fontDirs, [
			Yii::getAlias('@webroot').'/fonts'
		]);



		$pdf->options['fontdata'] = $fontData + [
			"THSarabun" => [
				'R' => 'THSarabun.ttf',
				'B' => 'THSarabun Bold.ttf',
			]
		];
		return $pdf;
	}

	public function actionTActivity($id='')
	{
		if(Yii::$app->user->identity->level_user=='2'){
			$id=Yii::$app->user->identity->id;
		}elseif($id==''){
			return $this->goBack();
		}


		
		$model=User2::findOne($id);

		$content = $this->renderPartial('transcipt',['model'=>$model]);




		$pdf = new Pdf([
			'mode' => Pdf::MODE_UTF8,
			'format' => Pdf::FORMAT_A4,
			'orientation' => Pdf::ORIENT_PORTRAIT,
			'destination' => Pdf::DEST_BROWSER,
			'marginLeft' => 10,
			'marginRight' => 10,
			'marginTop' => 10,
			'marginBottom' => 10,
			'content' => $content,

			'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
			'cssInline' =>'

			.logo{
				height:132.283465px;width:auto;
			}
			.fl{
				display:block;
				float:left;

			}
			.container {
				width: 100%;
				padding-right: 15px;
				padding-left: 15px;
				margin-right: auto;
				margin-left: auto
			}
			.col {
				-ms-flex-preferred-size: 0;
				flex-basis: 0;
				-ms-flex-positive: 1;
				flex-grow: 1;
				max-width: 100%;

			}
			.container > .col-1,.col-2,.col-3,.col-4,.col-5,.col-6,.col-7,.col-8,.col-9,.col-10,.col-11,.col-12 {

				padding: 20px 0;
				float:left;
			}
			.col-auto {
				-ms-flex: 0 0 auto;
				flex: 0 0 auto;
				width: auto;
				max-width: 100%
			}
			.row {
				display: -ms-flexbox;
				display: flex;
				-ms-flex-wrap: wrap;
				flex-wrap: wrap;
				margin-right: -15px;
				margin-left: -15px;
				width:100%;
			}
			.col-1{
				width:8.333333333%;
			}
			.col-2{
				width:16.66666667%;
			}
			.col-3{
				width:25%;
			}
			.col-4{
				width:33.33333333%;
			}
			.col-5{
				width:41.66666667%;
			}
			.col-6{
				width:50%;
			}
			.col-7{
				width:58.33333333%;
			}
			.col-8{
				width:66.66666667%;
			}
			.col-9{
				width:75%;
			}
			.col-10{
				width:83.33333333%;
			}
			.col-11{
				width:91.66666667%;
			}
			.col-12{
				width:100%;
			}
			.container-fluid div{
				border:1px solid black;
			}


			.split2{
				display: block;
				width: 50%;
				float:left;
				text-align: left;

			}

			.dif1,.dif2{
				display: block;
				width: 46%;
				text-align: left;
			}
			.dif1{
				float: left;
			}
			.dif2{
				float: right;
			}
			table.border, table.border th, table.border td {
				border: 1px solid black;
				border-collapse: collapse;

			}
			table.border{
				width:100%;
				font-size:12px;

			}
			table.border tr td
			body{
				font-size:16px;
				font-family:thsaraban;
				filter: grayscale(100%);
			}
			.disBor{
				border:none;
			}
			.mg-c{
				margin-left: auto;
				margin-right: auto
			}
			.mg-l{
				margin-left: 5px
			}
			.mg-r{
				margin-right: 20px
			}
			.t-l{
				text-align: left;
			}
			.t-r{
				text-align: right;
			}
			.t-c{
				text-align: center;
			}
			table tr td{
				text-align:center;
			}
			.f10{
				font-size:10px
			}
			.dif1 div div.dif1,.dif2 div div.dif1,.dif1 div div.dif2,.dif2 div div.dif2{
				display:block;
				float:left;


			}

			.dif1 div div.dif1,.dif2 div div.dif1{
				width:40px;
			}
			.dif1 div,.dif2 div{
				width:calc(100%-25px);
			}
			.dif1 div div.dif2 div,.dif2 div div.dif2 div{
				display:block;
				float:left;
				width:190px;
			}
			.a4{
				height:29.7cm;
				max-height:29.7cm;
			}
			.a42{
				max-height:18cm;
			}
			.dot{
				border-bottom: 1px #222 dotted;
			}
			'
			,
			'options' => ['title' => 'ทรานสคิปกิจกรรม'],
			'methods' => [
				// 'SetFooter' => ['PAGENO']
			]
		]);
		// Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
		$headers = Yii::$app->response->headers;
		$headers->add('Content-Type', 'application/pdf; charset=utf-8');

		$defaultConfig = (new ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];

		$pdf->options['fontDir'] = array_merge($fontDirs, [
			Yii::getAlias('@webroot').'/fonts'
		]);



		$pdf->options['fontdata'] = $fontData + [
			"THSarabun" => [
				'R' => 'THSarabun.ttf',
				'B' => 'THSarabun Bold.ttf',
			]
		];


		return $pdf->render();
	}


	/**
	* Signs user up.
	*
	* @return mixed
	*/
	public function actionSignup()
	{
		$model = new SignupForm();
		if ($model->load(Yii::$app->request->post())) {
			if ($user = $model->signup()) {
				if (Yii::$app->getUser()->login($user)) {
					return $this->goHome();
				}
			}
		}

		return $this->render('signup', [
			'model' => $model,
		]);
	}



	/**
	* Requests password reset.
	*
	* @return mixed
	*/
	public function actionRequestPasswordReset()
	{
		$model = new PasswordResetRequestForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
				return $this->goHome();
			} else {
				Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
			}
		}

		return $this->render('requestPasswordResetToken', [
			'model' => $model,
		]);
	}

	/**
	* Resets password.
	*
	* @param string $token
	*
	* @return mixed
	*
	* @throws BadRequestHttpException
	*/
	public function actionResetPassword($token)
	{
		try {
			$model = new ResetPasswordForm($token);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Yii::$app->session->setFlash('success', 'New password saved.');

			return $this->goHome();
		}

		return $this->render('resetPassword', [
			'model' => $model,
		]);
	}

}
