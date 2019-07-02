<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;

use frontend\models\ContactForm;
use common\models\User as User2;
use common\commands\AccessRule;

use frontend\models\UserOfficer ;
use frontend\models\UserCollegian ;
use frontend\models\Branch;
use yii\helpers\Json;
use common\models\User as UserC;



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


    /**
    * Lists all User models.
    * @return mixed
    */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
            $model->username = $_POST['User']['username'];
            $password = isset($_POST['User']['password_hash'])?$_POST['User']['password_hash']:'12345678';
            $model->password=$password;
            $model->level_user=$_POST['User']['level_user'];
            $model->setPassword($password);
            $model->generateAuthKey();
            $model->save();

            if($_POST['User']['level_user']==='1'){

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
                $modeluc=new UserCollegian;
                $modeluc->user_id=$model->id;
                $modeluc->pre_id=$_POST['UserCollegian']['pre_id'];
                $modeluc->uc_fname=$_POST['UserCollegian']['uc_fname'];
                $modeluc->uc_lname=$_POST['UserCollegian']['uc_lname'];
                $modeluc->faculty_id=$_POST['UserCollegian']['faculty_id'];
                $modeluc->branch_id=$_POST['UserCollegian']['branch_id'];
                $modeluc->address=$_POST['UserCollegian']['address'];
                $modeluc->save();
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
            $model->username = $_POST['User']['username'];
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
            UserCollegian::findOne($model->id)->delete();
            $model->level_user=$_POST['User']['level_user'];
            isset($_POST['User']['password'])?$model->setPassword($_POST['User']['password']):null;
            $model->save();
            //UserCollegian::findOne($model->id)->one()->delete();

            if($_POST['User']['level_user']==='1'){
                if(isset($_POST['UserCollegian'])){
                    $_POST=array_pop($_POST['UserCollegian']);
                }
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
                $modeluc=new UserCollegian;
                $modeluc->user_id=$model->id;
                $modeluc->pre_id=$_POST['UserCollegian']['pre_id'];
                $modeluc->uc_fname=$_POST['UserCollegian']['uc_fname'];
                $modeluc->uc_lname=$_POST['UserCollegian']['uc_lname'];
                $modeluc->faculty_id=$_POST['UserCollegian']['faculty_id'];
                $modeluc->branch_id=$_POST['UserCollegian']['branch_id'];
                $modeluc->address=$_POST['UserCollegian']['address'];
                $modeluc->save();
            }
            if($_POST['User']['level_user']==='0'||($_POST['User']['level_user']==='1'&&$modeluo->save())||($modeluc->save()&&$_POST['User']['level_user']==='2')){
                Yii::$app->session->setFlash('success','แก้ไขข้อมูลชื่อผู้ใช้ '.$_POST['User']['username'].' เรียบร้อยแล้ว');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        else{
            return $this->render('update', [
                'model' => $model,'modeluo'=>$modeluo,'modeluc'=>$modeluc
            ]);
        }
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
            $mo=UserOfficer::findOne($model->id)->delete();

        }
        else if($model->level_user==='2'){
            $mo=UserCollegian::findOne($model->id)->delete();
        }

        $model->id!==$$model->delete();
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
