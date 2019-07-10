<?php

namespace backend\controllers;

use Yii;
use backend\models\Activity;
use backend\models\ActivitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\User;
use yii\filters\AccessControl;
use common\commands\AccessRule;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
    	return [
    		// 'access' => [
    		// 	'class' => AccessControl::className(),
    		// 	'ruleConfig' => [
      //               'class' => AccessRule::className(), // เรียกใช้งาน accessRule (component) ที่เราสร้างขึ้นใหม่
      //           ],
      //           'rules' => [
      //           	[
      //           		'actions' => ['index','view','create','update','delete','number'],
      //           		'allow' => true,
      //           		'roles' => [User::ADMIN,User::OFFICER],
      //           	],

      //           ],
      //       ],
    		'verbs' => [
    			'class' => VerbFilter::className(),
    			'actions' => [
    				'logout' => ['post'],
    			],
    		],
    	];
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
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$searchModel = new ActivitySearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    	return $this->render('index', [
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }

    /**
     * Displays a single Activity model.
     * @param string $id
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
     * Creates a new Activity model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new Activity();

    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['view', 'id' => $model->ac_id]);
    	}

    	return $this->render('create', [
    		'model' => $model,
    	]);
    }

    /**
     * Updates an existing Activity model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);

    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['view', 'id' => $model->ac_id]);
    	}

    	return $this->render('update', [
    		'model' => $model,
    	]);
    }
    public function actionNumber(){
    	if(Yii::$app->request->isAjax){
    		$data = Yii::$app->request->post();
    		$cate_id= explode(":", $data['cate_id'])[0];
    		$type_id= explode(":", $data['type_id'])[0];
    		$side_id= explode(":", $data['side_id'])[0];
    		$ac_name= explode(":", $data['ac_name'])[0];

    		$model=Activity::find()->select(['ac_num'])->where(
    			[
    				'cate_id'=>$cate_id,
    				'type_id'=>$type_id,
    				'ac_name'=>$side_id
    			]
    		)->asArray()->all();
    		$arr;
    		for($i=1;$i<=100;$i+=1) {    			
    			if(in_array($i, $model)){
    				continue;
    			}
    			$arr[$i]=$i;

    		}

    		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    		return [
    			'res' => $arr,
    			'code' => 100,
    		];
    	}
    }

    /**
     * Deletes an existing Activity model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
    	$this->findModel($id)->delete();

    	return $this->redirect(['index']);
    }

    /**
     * Finds the Activity model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Activity the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	if (($model = Activity::findOne($id)) !== null) {
    		return $model;
    	}

    	throw new NotFoundHttpException('The requested page does not exist.');
    }
}
