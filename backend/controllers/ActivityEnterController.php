<?php

namespace backend\controllers;

use Yii;
use backend\models\ActivityEnter;
use backend\models\ActivityEnterSearch;
use backend\models\ActivityEnterReport;
use backend\models\ActivityEnterReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\UserCollegian;
use backend\models\UserCollegianSearch;
use  yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use backend\models\Branch;

use \yii\web\Request;
use yii\web\View;
use yii\helpers\Json;


/**
 * ActivityEnterController implements the CRUD actions for ActivityEnter model.
 */
class ActivityEnterController extends Controller
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

    /**
     * Lists all ActivityEnter models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$searchModel = new ActivityEnterReportSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    	return $this->render('index', [
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }
    public function beforeAction($action){
    	if (!Yii::$app->user->isGuest) {
    		if (Yii::$app->User->identity->level_user == '2') {
    			return $this->redirect(['/site']);
    		}

    	}
    	else{
    		return $this->redirect(['../site']);
    	}
    	return parent::beforeAction($action);
    }

    /**
     * Displays a single ActivityEnter model.
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
     * Creates a new ActivityEnter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new ActivityEnter();

    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['view', 'id' => $model->acen_id]);
    	}

    	return $this->render('create', [
    		'model' => $model,
    	]);
    }
    public function actionMultiCreate()
    {
    	$model = new ActivityEnter();  
    	if ($post=Yii::$app->request->post()) {
    		$data=$post;
    		$q= (new UserCollegian())->find();
    		$selection=isset($post['selection'])?$post['selection']:null;
    		if(count($selection)>0){
    			foreach ($selection as $key=> $value) {
    				$model = new ActivityEnter();
    				$model->acoyd_id=$post['ActivityEnter']['acoyd_id'];
    				$model->co_id=$value;
    				$model->enter_status='1';
    				$model->save();
    			}    			
    			return $this->redirect(['index']);
    		}    		
    	}  

    	return $this->render('multicreate', [
    		'model' => $model,
    		// 'searchModel' => $searchModel,
    		// 'dataProvider' => $dataProvider,
    		// 'post'=>$data
    	]);
    }
    public function actionCheck()
    {
    	$model = new ActivityEnter();  
    	if ($post=Yii::$app->request->post()) {
    		$data=$post;
    		$q= (new UserCollegian())->find();
    		$selection=isset($post['selection'])?$post['selection']:null;
    		if(count($selection)>0){
    			foreach ($selection as $key=> $value) {
    				$model = new ActivityEnter();
    				$model->acoyd_id=$post['ActivityEnter']['acoyd_id'];
    				$model->co_id=$value;
    				$model->enter_status='1';
    				$model->save();
    			}    			
    			return $this->redirect(['index']);
    		}    		
    	}  

    	return $this->render('check', [
    		'model' => $model,
    		// 'searchModel' => $searchModel,
    		// 'dataProvider' => $dataProvider,
    		// 'post'=>$data
    	]);
    }

    /**
     * Updates an existing ActivityEnter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);

    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['view', 'id' => $model->acen_id]);
    	}

    	return $this->render('update', [
    		'model' => $model,
    	]);
    }
    public function actionGetBranch(){
    	// Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	$out = [];
    	if (isset($_POST['depdrop_parents'])) {
    		$ids = $_POST['depdrop_parents'];
    		$faculty_id = empty($ids[0]) ? null : $ids[0];    		
    		if ($faculty_id!= null) {
    			$model=Branch::find()->orderBy(['faculty_id'=>SORT_ASC,'branch_id'=>SORT_ASC])
    			->where(['faculty_id'=>$faculty_id])->all();
    			$model=$this->MapData($model,'branch_id','branch_name'); 
    			return Json::encode(['output'=>$model, 'selected'=>'']);
    		}
    		$model=Branch::find()->orderBy(['faculty_id'=>SORT_ASC,'branch_id'=>SORT_ASC])->all();
    		$model=$this->MapData($model,'branch_id','branch_name'); 
    		return Json::encode(['output'=>$model, 'selected'=>'']);
    		
    	}  
    	
    	return Json::encode(['output'=>'', 'selected'=>'']);
    }
    public function actionGetGroup(){
    	// Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	$out = [];
    	if (isset($_POST['depdrop_parents'])) {
    		$ids = $_POST['depdrop_parents'];
    		$faculty_id = empty($ids[0]) ? null : $ids[0];
    		$branch_id = empty($ids[1]) ? null : $ids[1];    	
    		if ($branch_id !=null&&$faculty_id ==null) {
    			$model=UserCollegian::find()->select('group')->orderBy(['faculty_id'=>SORT_ASC,'branch_id'=>SORT_ASC])->distinct()->where(['branch_id'=>$branch_id])->all();
    			$model=$this->MapData($model,'group','group');
    			return Json::encode(['output'=>$model, 'selected'=>'']);  
    		}
    		elseif ($faculty_id !=null&&$branch_id ==null) {
    			$model=UserCollegian::find()->select('group')->orderBy(['faculty_id'=>SORT_ASC,'branch_id'=>SORT_ASC])->distinct()->where(['faculty_id'=>$faculty_id])->all();
    			$model=$this->MapData($model,'group','group');
    			return Json::encode(['output'=>$model, 'selected'=>'']);  
    		}
    		elseif ($branch_id !=null&&$faculty_id!=null) {
    			$model=UserCollegian::find()->select('group')->orderBy(['faculty_id'=>SORT_ASC,'branch_id'=>SORT_ASC])->distinct()->where(['branch_id'=>$branch_id,'faculty_id'=>$faculty_id])->all();
    			$model=$this->MapData($model,'group','group');
    			return Json::encode(['output'=>$model, 'selected'=>'']);  
    		}
    		$model=UserCollegian::find()->select('group')->orderBy(['faculty_id'=>SORT_ASC,'branch_id'=>SORT_ASC])->distinct()->all();
    		$model=$this->MapData($model,'group','group');
    		return Json::encode(['output'=>$model, 'selected'=>'']);    

    	}

    	return Json::encode(['output'=>'', 'selected'=>'']);
    }
    protected function MapData($list,$fieldId,$fieldName){
    	$out=[];
    	foreach ($list as $i => $value) {
    		$out[] = ['id'=>$value->{$fieldId},'name'=>$value->{$fieldName}];    		
    	}
    	return $out;

    }
    protected function MapData2($datas,$fieldId,$fieldName){
    	$obj = [];
    	
    	foreach ($datas as $key => $value) {
    		$obj[$value->{$fieldId}]=['id'=>$value->{$fieldId},'name'=>$value->{$no}.' - '.$value->{$fieldName}];
    	}

    	if($obj!=[]){
    		return $obj;
    	}
    	else{
    		return null;
    	}

    }

    public function actionAjax(){
    	if (Yii::$app->request->isAjax) {
    		$data = Yii::$app->request->post();
    		$q= UserCollegian::find();

    		$ver= $data['ver'];  
    		$fac= $data['fac'];  
    		$bra= $data['bra']; 
    		$group= $data['group']; 

    		if(isset($ver)&&$ver==''&&isset($fac)&&$fac==''&&isset($bra)&&$bra==''&&isset($group)&&$group==''){
    			$q->andWhere(['ver'=>'000']);   
    		}
    		else{
    			if(isset($ver)&&$ver!==''){
    				$q->andWhere(['ver'=>$ver]);    			
    			}
    			if(isset($fac)&&$fac!==''){
    				$q->andWhere(['faculty_id'=>$fac]);
    			}
    			if(isset($bra)&&$bra!==''){
    				$q->andWhere(['branch_id'=>$bra]);
    			}
    			if(isset($group)&&$group!==''){
    				$q->andWhere(['group'=>$group]);
    			}
    		}


    		$q->all();
    		$columns=[
    			['class' => 'yii\grid\SerialColumn'],
    			[
    				'class' => 'yii\grid\CheckboxColumn',
    				'options'=>['name'=>'user_id'],
    				'contentOptions'=>['width'=>'20px']     
    			],
    			[
    				'attribute'=>'ver',
    				'label'=>'รุ่น',		
    				'contentOptions'=>['width'=>'100px']  					
    			]
    			,
    			[
    				'attribute'=>'ver',
    				'label'=>'เลขที่',		
    				'contentOptions'=>['width'=>'100px']  					
    			]
    			,
    			[
    				'attribute'=>'fac.faculty_name',
    				'label'=>'คณะ',	
    				'contentOptions'=>['width'=>'100px']  						
    			]
    			,
    			[
    				'attribute'=>'bra.branch_name',
    				'label'=>'สาขา',	
    				'contentOptions'=>['width'=>'100px']  						
    			],
    			'group',
    			[
    				'attribute'=>'user_id as id',
    				'label'=>'ชื่อ - นามสกุล',							
    				'value'=>function($model){
    					return $model->pre->pre_name.' '.$model->uc_fname.' '.$model->uc_lname;
    				},
    			],
    		];
    		$search=$this->grid($q,$columns,false);

    		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    		return [
    			'search' =>  $search,
    			'code' => 100,
    		];   		
    	}  		

    }

    public function actionAjax2(){
    	if (Yii::$app->request->isAjax) {
    		$data = Yii::$app->request->post();
    		$q= UserCollegian::find();

    		$ver= $data['ver'];  
    		$fac= $data['fac'];  
    		$bra= $data['bra']; 
    		$group= $data['group']; 

    		if(isset($ver)&&$ver==''&&isset($fac)&&$fac==''&&isset($bra)&&$bra==''&&isset($group)&&$group==''){
    			$q->andWhere(['ver'=>'000']);   
    		}
    		else{
    			if(isset($ver)&&$ver!==''){
    				$q->andWhere(['ver'=>$ver]);    			
    			}
    			if(isset($fac)&&$fac!==''){
    				$q->andWhere(['faculty_id'=>$fac]);
    			}
    			if(isset($bra)&&$bra!==''){
    				$q->andWhere(['branch_id'=>$bra]);
    			}
    			if(isset($group)&&$group!==''){
    				$q->andWhere(['group'=>$group]);
    			}
    		}


    		$q->all();
    		
    		$search=$this->grid($q,$this->actionArrayColumn(),false);

    		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    		return [
    			'search' =>  $search,
    			'code' => 100,
    		];   		
    	}  		

    }
    public function grid($query,$columns,$pagination=10)
    {
    	$dataProvider = new ActiveDataProvider([
    		'query' => $query,
    		'pagination' => $pagination
    	]);

    	return $this->renderGrid($columns,$dataProvider);
    }


    public function renderGrid($columns,$dataProvider,$searchModel=null){
    	// return $dataProvider;
    	
    	if($searchModel!==null){
    		$arr['searchModel']=$searchModel;
    	}
    	return GridView::widget($this->actionArrayGrid($columns,$dataProvider));
    }
    public function actionArrayColumn(){
    	return $columns=[
    		['class' => 'yii\grid\SerialColumn'],
    		[
    			'class' => 'yii\grid\CheckboxColumn',
    			'options'=>['name'=>'user_id'],
    			'contentOptions'=>['width'=>'20px']     
    		],
    		[
    			'attribute'=>'ver',
    			'label'=>'รุ่น',		
    			'contentOptions'=>['width'=>'100px']  					
    		]
    		,
    		[
    			'attribute'=>'ver',
    			'label'=>'เลขที่',		
    			'contentOptions'=>['width'=>'100px']  					
    		]
    		,
    		[
    			'attribute'=>'fac.faculty_name',
    			'label'=>'คณะ',	
    			'contentOptions'=>['width'=>'100px']  						
    		]
    		,
    		[
    			'attribute'=>'bra.branch_name',
    			'label'=>'สาขา',	
    			'contentOptions'=>['width'=>'100px']  						
    		],
    		'group',
    		[
    			'attribute'=>'user_id as id',
    			'label'=>'ชื่อ - นามสกุล',							
    			'value'=>function($model){
    				return $model->pre->pre_name.' '.$model->uc_fname.' '.$model->uc_lname;
    			},
    		],
    	];
    }
    public function actionArrayGrid($columns,$dataProvider){
    	return $arr=[
    		'dataProvider' => $dataProvider,

    		'panel'=>[
    			'before'=>' '
    		],
    		'toggleDataOptions'=>[ 
    			'all' => [
    				'icon' => 'resize-full',
    				'label' => '<i class="fa fa-expand"></i> ทั้งหมด',
    				'class' => 'btn btn-warning',						
    			],
    			'page' => [
    				'icon' => 'resize-small',
    				'label' => '<i class="fa fa-compress"></i> ย่อ',
    				'class' => 'btn btn-warning',						
    			],
    		],
    		'toolbar' => [
    			// '{toggleData}'
    		],						
    		'panelTemplate'=>'						
    		{panelHeading}
    		{panelBefore}
    		<hr style="margin:0">						
    		{items}
    		{panelAfter}
    		{panelFooter}				
    		<div class="clearfix"></div>
    		',
    		'columns' => $columns
    	];
    }

    /**
     * Deletes an existing ActivityEnter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
    	$this->findModel($id)->delete();

    	return $this->redirect(['index']);
    }

    /**
     * Finds the ActivityEnter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActivityEnter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	if (($model = ActivityEnter::findOne($id)) !== null) {
    		return $model;
    	}

    	throw new NotFoundHttpException('The requested page does not exist.');
    }
}
