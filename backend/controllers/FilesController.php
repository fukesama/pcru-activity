<?php

namespace backend\controllers;

use Yii;
use backend\models\Files;
use backend\models\FilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use frontend\models\Faculty;
use frontend\models\EduBackground;
use frontend\models\Branch;
use backend\models\User;
use backend\models\UserCollegian;
use backend\models\Prefix;
use yii\data\ArrayDataProvider;

/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller
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
    	];
    }
    public function beforeAction($action){
    	if (!Yii::$app->user->isGuest) {
    		if (Yii::$app->User->identity->level_user == '1') {
    			return $this->redirect(['backend/site']);
    		}
    		else if (Yii::$app->User->identity->level_user == '2') {
    			return $this->redirect(['/site']);
    		}
    	}
    	else{
    		return $this->redirect(['../site']);
    	}
    	return parent::beforeAction($action);
    }

    /**
     * Lists all Files models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$model = new Files();
    	if($model->load(Yii::$app->request->post())){
    		$model->file = $model->uploadFile($model, 'file'); 
    		$model->save();
    		if($model->save()){
    			$transaction = Yii::$app->db->beginTransaction();
    			try {
    				$text=$this->getExcelData($model->id);
    				$transaction->commit();   
    				Yii::$app->session->setFlash('success', 'ดำเนินการนำเข้าข้อมูลนักศึกษาเรียบร้อยแล้ว กรุณาตรวจสอบความถูกต้องอีกครั้ง');
    			}
    			catch (Exception $e){
    				$transaction->rollBack();    	
    				Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด');	
    			}    			
    		}
    	}
    	$searchModel = new FilesSearch();

    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    	return $this->render('index', [
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }
    public function getExcel($id){
    	$model = $this->findModel($id);
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
    public function actionView($id)
    {
    	$model = $this->findModel($id); 
    	$dataProvider = new ArrayDataProvider([
    		'allModels' => $model,
    		'pagination' => false,
    	]);    	
    	return $this->render('view', [
    		'model' => $model,
    		'dataProvider' => $dataProvider,
    	]); 	    	
    	
    	
    	

    }
    public function getExcelData($id)
    {    	
    	$transaction = Yii::$app->db->beginTransaction();
    	try {
    		$arr=$this->getExcel($id);  
    		ini_set('max_execution_time', 9999);    	
    		$text= $this->render('importExcel',['arr'=>$arr]);
    		$transaction->commit();    		
    		return 'ดำเนินการนำเข้าข้อมูลนักศึกษาเรียบร้อยแล้ว กรุณาตรวจสอบความถูกต้องอีกครั้ง';
    	}
    	catch (Exception $e){
    		$transaction->rollBack();   
    		return 'เกิดข้อผิดพลาด'; 		
    	}
    }	
    /**
     * [actionCreate description]
     * @return [type] [description]
     */
    public function actionCreate()
    {
    	$model = new Files();

    	if ($model->load(Yii::$app->request->post())) {

    		$model->file = $model->uploadFile($model, 'file');
    		$model->save();

    		Yii::$app->session->setFlash('success', 'เพิ่มข้อมูลเรียบร้อยแล้ว');
    		return $this->redirect(['view', 'id' => $model->id]);

    	} else {
    		return $this->render('create', [
    			'model' => $model,
    		]);
    	}
    }
    public function actionAdd()
    {
    	$model = new Files();

    	if ($model->load(Yii::$app->request->post())) {

    		$model->file = $model->uploadFile($model, 'file');   
    		$model->save();
    		$text=$this->getExcelData($model->id);  	 		
    		$text!==''||$text!=null?$text:'';
    		return $this->redirect(['user/']);

    	} 
    }

	/**
	 * [actionUpdate description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post())) {

			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}
    /**
     * [actionDelete description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionDelete($id)
    {
    	$model = $this->findModel($id);
    	@unlink($model->dirFile().'/'.$model->file);
    	$model->delete();

    	Yii::$app->session->setFlash('success', 'ลบข้อมูลเรียบร้อยแล้ว');
    	return $this->redirect(['index']);
    }



    /**
     * Finds the Files model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Files the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	if (($model = Files::findOne($id)) !== null) {
    		return $model;
    	}

    	throw new NotFoundHttpException('The requested page does not exist.');
    }
}
