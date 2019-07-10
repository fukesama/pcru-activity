<?php

namespace backend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\SignupForm;
use backend\models\ContactForm;
use common\models\User;
use backend\models\User1;
use common\commands\AccessRule;
use backend\models\ActivityEnter;
use backend\models\ActivityEnterReportSearch;
use yii\data\ActiveDataProvider;
use kartik\mpdf\Pdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use backend\models\ActivityOfyearDetail;
use backend\models\ActivityOfyearDetailSearch;
use backend\models\ActivityEnterDetail;


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
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['logout'],
				'ruleConfig' => [
					'class' => AccessRule::className(), // เรียกใช้งาน accessRule (component) ที่เราสร้างขึ้นใหม่
				],
				'rules' => [
					// [                       
					//     'allow' => true,
					//     'roles' => [User::ADMIN,User::OFFICER],
					// ],
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],

		];
	}
	public function beforeAction($action){
		if (!Yii::$app->user->isGuest) {
			if (Yii::$app->User->identity->level_user == '2') {
				return $this->redirect(['../pcru-activity/site']);
			}
		}else{
			return $this->redirect(['../site']);
		}
		return parent::beforeAction($action);
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


	/**
	 * Displays homepage.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			if (Yii::$app->User->identity->level_user == '0' || Yii::$app->User->identity->level_user == '1') {
				return $this->redirect(['/site']);
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

		return $this->redirect(['../site']);
	}
	public function actionChangepassword(){
		$model = User1::findOne(Yii::$app->user->identity->id);
		if ($model->load(Yii::$app->request->post())) 
		{
			$model->password_hash = Yii::$app->security->generatePasswordHash($_POST['User1']['password_hash']);
			$model->auth_key = Yii::$app->security->generateRandomString();

			if($model->save())
			{
				// Yii::$app->session->setFlash('success','เปลี่ยนรหัสผ่านเรียบร้อย');
				echo "<script>
				Swal.fire(
				'Password changed',
				'เปลี่ยนรหัสผ่านเรียบร้อย',
				'success'
				)				
				window.history.go(-2)
				</script>";
				// return $this->redirect(['/site/index']);
			}
		}
		return $this->render('change_password',['model'=>$model]);
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

	/**
	 * Displays about page.
	 *
	 * @return mixed
	 */
	public function actionAbout()
	{
		return $this->render('about');
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
	public function actionReportOne($co_id)
	{
		if(Yii::$app->user->identity->level_user=='2'){
			$id=Yii::$app->user->identity->id;
		}elseif($id==''){
			return $this->goBack();
		}


		
		$model=User2::findOne($id);

		$content = $this->renderPartial('transcipt',['model'=>$model]);
		$pdf=$this->pdf($content);
		return $pdf->render();
	}
	public function actionProject()
	{
		$model=ActivityOfyearDetail::find()->orderBy(['ac_startdate'=>SORT_DESC]);
		$params=Yii::$app->request->queryParams;
		if(!isset($params['ActivityOfyearDetailSearch']['year'])){
			$params['ActivityOfyearDetailSearch']['year']=date('Y')+543;
			$model->where(['like','ac_startdate',$params['ActivityOfyearDetailSearch']['year']]);
		}
		$searchModel = new ActivityOfyearDetailSearch();
		$dataProvider = $searchModel->search($params,$model);

		return $this->render('project', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
	
	public function actionReportProject($acoyd_id)
	{
		$count=ActivityEnter::find()->where(['acoyd_id'=>$acoyd_id])->count();
		if($count==0){
			Yii::$app->session->setFlash('warning','ไม่มีข้อมูล');
			return $this->redirect(['project']);
		}

		// $count=0;
		// foreach ($acen as $value) {
		// 	$count+=ActivityEnterDetail::find()->where(['acen_id'=>$value->acen_id])->count();
		// 	if($count>0){
		// 		break;
		// 	}
		// }

		// if($acoyd_id==''||$acoyd_id==null||!isset($acoyd_id)||$count==0){
		// 	Yii::$app->session->setFlash('warning','ไม่มีข้อมูล');
		// 	return $this->redirect(['project']);
		// }
		$model=ActivityOfyearDetail::find()->where(['acoyd_id'=>$acoyd_id])->one();	
		ini_set("pcre.backtrack_limit", "50000000");

		$content = $this->renderPartial('report_project',['model'=>$model,'acoyd_id'=>$acoyd_id]);
		$pdf=$this->pdf($content);
		return $pdf->render();
	}
	public function actionReportProject2($acoyd_id)
	{
		$acen=ActivityEnter::find()->where(['acoyd_id'=>$acoyd_id])->all();
		$count=0;
		foreach ($acen as $value) {
			$count+=ActivityEnterDetail::find()->where(['acen_id'=>$value->acen_id])->count();
			if($count>0){
				break;
			}
		}

		if($acoyd_id==''||$acoyd_id==null||!isset($acoyd_id)||$count==0){
			Yii::$app->session->setFlash('warning','ไม่มีข้อมูล');
			return $this->redirect(['project']);
		}
		$model=ActivityOfyearDetail::find()->where(['acoyd_id'=>$acoyd_id])->one();	
		
		ini_set("pcre.backtrack_limit", "50000000");
		$content = $this->renderPartial('report_project2',['model'=>$model]);
		$pdf=$this->pdf($content);
		return $pdf->render();
	}
	public function actionReportProject3($acoyd_id)
	{
		// $acen=ActivityEnter::find()->where(['acoyd_id'=>$acoyd_id])->all();
		// $count=0;
		// foreach ($acen as $value) {
		// 	$count+=ActivityEnterDetail::find()->where(['acen_id'=>$value->acen_id])->count();
		// 	if($count>0){
		// 		break;
		// 	}
		// }

		// if($acoyd_id==''||$acoyd_id==null||!isset($acoyd_id)||$count==0){
		// 	Yii::$app->session->setFlash('warning','ไม่มีข้อมูล');
		// 	return $this->goBack();
		// }
		$model=ActivityOfyearDetail::find()->where(['acoyd_id'=>$acoyd_id])->one();	
		
		ini_set("pcre.backtrack_limit", "50000000");
		// return $this->render('report_project3',['model'=>$model]);
		// return $this->renderPartial('report_project3',['model'=>$model]);
		$content = $this->renderPartial('report_project3',['model'=>$model]);
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
}
