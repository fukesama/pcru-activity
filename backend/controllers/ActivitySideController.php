<?php

namespace backend\controllers;

use Yii;
use backend\models\ActivitySide;
use backend\models\ActivitySideSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\User;
use common\commands\AccessRule;
use yii\filters\AccessControl;

use yii\data\ActiveDataProvider;

use kartik\grid\GridView;
use \yii\web\Request;
use yii\web\View;
use yii\helpers\Json;
use backend\models\Activity;

/**
 * ActivitySideController implements the CRUD actions for ActivitySide model.
 */
class ActivitySideController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
    	return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'ruleConfig' => [
            //         'class' => AccessRule::className(), // เรียกใช้งาน accessRule (component) ที่เราสร้างขึ้นใหม่
            //     ],
            //     'rules' => [
            //         [
            //             'actions' => ['index','view','create','update','delete'],
            //             'allow' => true,
            //             'roles' => [User::ADMIN],
            //         ],

            //     ],
            // ],
    		'verbs' => [
    			'class' => VerbFilter::className(),
    			'actions' => [
    				'logout' => ['post'],
    			],
    		],
    	];
    }

    /**
     * Lists all ActivitySide models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$searchModel = new ActivitySideSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    	return $this->render('index', [
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }
    /**
     * [beforeAction description]
     * @param  [type] $action [description]
     * @return [type]         [description]
     */
    public function beforeAction($action){
    	if (!Yii::$app->user->isGuest) {
    		if (Yii::$app->User->identity->level_user == '2') {
    			return $this->redirect(['../pcru-activity/site']);
    		}
    		elseif(Yii::$app->User->identity->level_user == '1'){
    			return $this->redirect(['/site']);
    		}
    	}
    	else{
    		return $this->redirect(['../site']);
    	}
    	return parent::beforeAction($action);
    }
    /**
     * [actionSideList description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function actionSideList($id)
    {

    	$query=Activity::find()->where(['side_id'=>$id]);
    	$dataProvider = new ActiveDataProvider([
    		'query' => $query,
    		'pagination' => false
    	]);
    	return $this->render('sidelist', [
    		'dataProvider' => $dataProvider ,
    		'id'=>$id
    	]);
    }    





    /**
     * Displays a single ActivitySide model.
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
     * Creates a new ActivitySide model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new ActivitySide();

    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['view', 'id' => $model->side_id]);
    	}

    	return $this->render('create', [
    		'model' => $model,
    	]);
    }

    /**
     * Updates an existing ActivitySide model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);

    	if ($model->load(Yii::$app->request->post()) && $model->save()) {
    		return $this->redirect(['view', 'id' => $model->side_id]);
    	}

    	return $this->render('update', [
    		'model' => $model,
    	]);
    }

    /**
     * Deletes an existing ActivitySide model.
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
     * Finds the ActivitySide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ActivitySide the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	if (($model = ActivitySide::findOne($id)) !== null) {
    		return $model;
    	}

    	throw new NotFoundHttpException('The requested page does not exist.');
    }
}
