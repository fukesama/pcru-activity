<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;

use backend\models\ContactForm;
use common\models\User as User2;
use common\commands\AccessRule;

use backend\models\UserOfficer ;
use backend\models\UserCollegian ;
use backend\models\Branch;
use yii\helpers\Json;
use common\models\User as UserC;
use backend\models\User1;
use yii\helpers\Url;
use backend\models\Files;

use backend\models\Prefix;
use yii\data\ArrayDataProvider;

use frontend\models\Faculty;
use frontend\models\EduBackground;


/**
* UserController implements the CRUD actions for User model.
*/
class UserController extends Controller
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
    			'ruleConfig' => [
                    'class' => AccessRule::className() // เรียกใช้งาน accessRule (component) ที่เราสร้างขึ้นใหม่
                ],

                'rules' => [
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
    public function beforeAction($action){
    	if (!Yii::$app->user->isGuest) {
    		if (Yii::$app->User->identity->level_user == '2' ||Yii::$app->User->identity->level_user == '1') {
    			return $this->redirect(['../site']);
    		}
    	}
    	return parent::beforeAction($action);
    }
    public function getExcel($id){
    	$model = Files::findOne($id);
    	try{
    		$file = $model->dirFile().'/'.$model->file;
    		$inputFile = \PHPExcel_IOFactory::identify($file);
    		$objReader = \PHPExcel_IOFactory::createReader($inputFile);
    		$objPHPExcel = $objReader->load($file);
    	}catch (Exception $e){
    		Yii::$app->session->addFlash('error', 'เกิดข้อผิดพลาด'. $e->getMessage());
    	}

    	$sheet = $objPHPExcel->getSheet(0);
    	$highestRow = $sheet->getHighestRow();
    	$highestColumn = $sheet->getHighestColumn();

    	$objWorksheet = $objPHPExcel->getActiveSheet();

    	foreach($objWorksheet->getRowIterator() as $rowIndex => $row){
    		$arr[] = $objWorksheet->rangeToArray('A'.$rowIndex.':'.$highestColumn.$rowIndex);
    	}
    	return $arr;
    }
    public function getExcelData($id)
    {    	
    	
    	$arr=$this->getExcel($id);  
    	ini_set('max_execution_time', 9999);    	



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
    	$password=Yii::$app->security->generatePasswordHash('1234');
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
    				// array_pop($arr);		
    				$ver=$value2[4];

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
    				
    				$uModel=User::find()->where(['username'=>$value2[1]]);			
    				if($uModel->count()==0){
    					// $password=Yii::$app->security->generatePasswordHash('12345678');
    					// $auth_key=Yii::$app->security->generateRandomString();
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

    				$number=$uModel->username;    			
    				$number=$number[10].$number[11];
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
    					$ucModel->group=$StudyGroup;
    					$ucModel->ver=$ver;    					
    					$ucModel->number=$number;
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
    					$ucModel->group=$StudyGroup;
    					$ucModel->ver=$ver;    					
    					$ucModel->number=$number;
    					$ucModel->save();
    					$update++;	
    				}	
    				$total++;		
    			}
    		}
    	}
    	return $total;    	
    }	



    /**
    * Lists all User models.
    * @return mixed
    */

    public function actionIndex()
    {
    	
    	// $model = new Files();
    	// if($model->load(Yii::$app->request->post())){
    	// 	$model->file = $model->uploadFile($model, 'file'); 
    	// 	$model->save();
    	// 	if($model->save()){
    	// 		$transaction = Yii::$app->db->beginTransaction();
    	// 		try {
    	// 			$text=$this->getExcelData($model->id);
    	// 			$transaction->commit();   
    	// 			Yii::$app->session->setFlash('warning', $text);
    	// 		}
    	// 		catch (Exception $e){
    	// 			$transaction->rollBack();    	
    	// 			Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');	
    	// 		}    			
    	// 	}
    	// }
    	$searchModel = new UserSearch();

    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    	return $this->render('index', [
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }
    public function actionAdd()
    {
    	$model = new Files();

    	if ($model->load(Yii::$app->request->post())) {

    		$model->file = $model->uploadFile($model, 'file');   
    		$model->save();    		
    		if($text=$this->getExcelData($model->id)){    			
    			Yii::$app->session->setFlash('success', 'ระบบดำเนินการนำเข้าข้อมูลนักศึกษาทั้งหมด '.$text.' คน กรุณาตรวจสอบข้อมูลอีกครั้ง');
    		}
    		else{
    			Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');
    		}
    		return $this->redirect(['user/']);

    	} 
    }


    /**
    * Displays a single User model.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionView($id)
    {
    	return $this->render('view', [
    		'model' => $this->findModel($id),
    	]);
    }

    /**
    * Creates a new User model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionCreate()
    {


    	$model=new User;
    	$modeluo=new UserOfficer;
    	$modeluc=new UserCollegian;
    	if ($model->load(Yii::$app->request->post())) {

    		$userSearch = User::find()->where(['username'=>$_POST['User']['username']])->count();
    		if($userSearch>0){
    			Yii::$app->session->setFlash('error','ชื่อผู้ใช้ซ้ำ');
    			return $this->render('create', [
    				'model' => $model,'modeluo'=>$modeluo,'modeluc'=>$modeluc
    			]);
    		}
    		$model->username = $_POST['User']['username'];

    		$password = isset($_POST['User']['password_hash'])&&$_POST['User']['password_hash']!==''?$_POST['User']['password_hash']:'12345678';

    		$model->password_hash=Yii::$app->security->generatePasswordHash($password);
    		$model->auth_key=Yii::$app->security->generateRandomString();

    		$model->level_user=$_POST['User']['level_user'];

    		if($_POST['User']['level_user']==='1'){
    			$model->save();
    			$modeluo=new UserOfficer;
    			$modeluo->user_id=$model->id;
    			$modeluo->pre_id=$_POST['UserOfficer']['pre_id'];
    			$modeluo->uo_fname=$_POST['UserOfficer']['uo_fname'];
    			$modeluo->uo_lname=$_POST['UserOfficer']['uo_lname'];
    			$modeluo->save();
    		}
    		else if($_POST['User']['level_user']==='2'){
    			if(isset($_POST['UserOfficer'])){
    				$_POST=array_pop($_POST['UserOfficer']);
    			}
    			if(strlen($model->username)>12||strlen($model->username)<12){
    				Yii::$app->session->setFlash('error','กรุณาป้อน Username 12 หลัก');
    				return $this->render('create', [
    					'model' => $model,'modeluo'=>$modeluo,'modeluc'=>$modeluc
    				]); 
    			}
    			$model->save();
    			$modeluc=new UserCollegian;
    			$modeluc->user_id=$model->id;
    			$modeluc->pre_id=$_POST['UserCollegian']['pre_id'];
    			$modeluc->uc_fname=$_POST['UserCollegian']['uc_fname'];
    			$modeluc->uc_lname=$_POST['UserCollegian']['uc_lname'];
    			$modeluc->faculty_id=$_POST['UserCollegian']['faculty_id'];
    			$modeluc->branch_id=$_POST['UserCollegian']['branch_id'];
    			$group='';
    			$number='';  
    			$username=$model->username;
    			
    			for ($key=0;$key<12;$key++) {
    				if($key<10){
    					$group.=$username["$key"];
    					continue;
    				}
    				$number.=$username["$key"];
    				if(!isset($username["$key"])){
    					break;
    				}
    			}    			
    			$modeluc->group=$group;
    			$modeluc->number=$number;
    			$modeluc->address=$_POST['UserCollegian']['address'];
    			$modeluc->save();
    		}
    		else{
    			$model->save();
    		}

    		Yii::$app->session->setFlash('success','สร้างข้อมูลผู้ชื่อใช้ '.$_POST['User']['username'].' เรียบร้อยแล้ว');
    		return $this->redirect(['view', 'id' => $model->id]);


    	}
    	else{
    		return $this->render('create', [
    			'model' => $model,'modeluo'=>$modeluo,'modeluc'=>$modeluc
    		]);
    	}


    }

    /**
    * Updates an existing User model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);
    	$modeluo=new UserOfficer;
    	$modeluc=new UserCollegian;
    	if($model->level_user==='0'){
    		$modeluo=new UserOfficer;
    		$modeluc=new UserCollegian;
    	}
    	else if($model->level_user==='1'){
    		$modeluo=UserOfficer::findOne($model->id);
    		$modeluc=new UserCollegian;
    	}
    	elseif($model->level_user==='2'){
    		$modeluo=new UserOfficer;
    		$modeluc=UserCollegian::findOne($model->id);
    	}



    	if ($model->load(Yii::$app->request->post())) {

    		$model->level_user=$_POST['User']['level_user'];  
    		if($model->level_user!==$_POST['User']['level_user']){
    			if($_POST['User']['level_user']==='0'){
    				UserOfficer::findOne($model->id)->delete();
    				UserCollegian::findOne($model->id)->delete();
    			}
    			else if($_POST['User']['level_user']==='1'){
    				UserCollegian::findOne($model->id)->delete();
    			}
    			else if($_POST['User']['level_user']==='2'){
    				UserOfficer::findOne($model->id)->delete();
    			}

    		}
    		/*UserCollegian::findOne($model->id)->delete();*/
    		$model->level_user=$_POST['User']['level_user'];

    		$model->level_user=$_POST['User']['level_user'];
    		if(isset($_POST['User']['password_hash'])&&$_POST['User']['password_hash']!==''){
    			$password = $_POST['User']['password_hash'];
    			$model->setPassword($password);
    			$model->generateAuthKey();
    		}

    		
            //UserCollegian::findOne($model->id)->one()->delete();

    		if($_POST['User']['level_user']==='1'){
    			$model->save();
    			if(isset($_POST['UserCollegian'])){
    				$_POST=array_pop($_POST['UserCollegian']);
    			}             
    			$modeluo=UserOfficer::find()->where(['user_id'=>$model->id])->one();                 
    			$modeluo->pre_id=$_POST['UserOfficer']['pre_id'];
    			$modeluo->uo_fname=$_POST['UserOfficer']['uo_fname'];
    			$modeluo->uo_lname=$_POST['UserOfficer']['uo_lname'];
    			$modeluo->save();
    		}
    		else if($_POST['User']['level_user']==='2'){
    			$model->save();
    			if(isset($_POST['UserOfficer'])){
    				$_POST=array_pop($_POST['UserOfficer']);
    			}
    			$modeluc=UserCollegian::find()->where(['user_id'=>$model->id])->one();                 

    			$modeluc->pre_id=$_POST['UserCollegian']['pre_id'];
    			if($modeluc->uc_fname!==$_POST['UserCollegian']['uc_fname']){
    				$modeluc->uc_fname=$_POST['UserCollegian']['uc_fname'];
    			}
    			if( $modeluc->uc_lname!==$_POST['UserCollegian']['uc_lname']){
    				$modeluc->uc_lname=$_POST['UserCollegian']['uc_lname'];
    			}               

    			$modeluc->faculty_id=$_POST['UserCollegian']['faculty_id'];
    			$modeluc->branch_id=$_POST['UserCollegian']['branch_id'];
    			$group='';
    			$number='';
    			$username=$model->username;
    			for ($key=0;$key<=12;$key++) {
    				if($key<10){
    					$group.=$username[$key];
    					continue;
    				}
    				$number.=$username[$key];
    				if(!isset($username[$key])){
    					break;
    				}
    			}    					
    			$modeluc->group=$group;
    			$modeluc->number=$number;
    			$modeluc->address=$_POST['UserCollegian']['address'];
    			$modeluc->save();
    		}
    		else{
    			$model->save();
    		}
    		if($_POST['User']['level_user']==='0'||($_POST['User']['level_user']==='1'&&$modeluo->save())||($modeluc->save()&&$_POST['User']['level_user']==='2')){
    			Yii::$app->session->setFlash('success','แก้ไขข้อมูลชื่อผู้ใช้ '.$_POST['User']['username'].' เรียบร้อยแล้ว');
    			return $this->redirect(['view', 'id' => $model->id]);
    		}
    	}

    	return $this->render('update', [
    		'model' => $model,
    		'modeluo'=>$modeluo,
    		'modeluc'=>$modeluc
    	]);

    }

    /**
    * Deletes an existing User model.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @param integer $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionDelete($id)
    {
        //echo($id);
        //echo Yii::$app->getRequest()->getMethod();
    	$model=$this->findModel($id);
    	if($model->level_user==='1'){
    		if($mo=UserOfficer::findOne($model->id))$mo->delete();

    	}
    	else if($model->level_user==='2'){
    		if($mo=UserCollegian::findOne($model->id))$mo->delete();

    	}

    	if($model->delete());
    	return $this->redirect(['index']);
    }
    public function actionGetBranch() {
    	$out = [];
    	if (isset($_POST['depdrop_parents'])) {
    		$parents = $_POST['depdrop_parents'];
    		if ($parents != null) {
    			$id = $parents[0];
    			$out = $this->getBranch($id);
    			echo Json::encode(['output'=>$out, 'selected'=>'']);
    			return;
    		}
    	}
    	echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    protected function getBranch($id){
    	$datas = Branch::find()->where(['faculty_id'=>$id])->all();
    	return $this->MapData($datas,'branch_id','branch_name');
    }
    protected function MapData($datas,$fieldId,$fieldName){
    	$obj = [];
    	foreach ($datas as $key => $value) {
    		array_push($obj, ['id'=>$value->{$fieldId},'name'=>$value->{$fieldName}]);
    	}
    	return $obj;
    }



    /**
    * Finds the User model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param integer $id
    * @return User the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    protected function findModel($id)
    {
    	if (($model = User::findOne($id)) !== null) {
    		return $model;
    	}

    	throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
