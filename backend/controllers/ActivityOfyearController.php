<?php

namespace backend\controllers;

use Yii;
//Model
use backend\models\ActivityOfyear;
use backend\models\ActivityOfyearSearch;
use backend\models\Activity;

//ส่วนเสริม
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
//ส่วน function ทั่วไป
use common\components\Func;

//ส่วนของ QeCode
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;
//ส่วน pdf
use kartik\mpdf\Pdf;




/**
* ActivityOfyearController implements the CRUD actions for ActivityOfyear model.
*/
class data{
	public $data;
}
class ActivityOfyearController extends Controller
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
    * Displays a single ActivityOfyear model.
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
    * Creates a new ActivityOfyear model.
    * If creation is successful, the browser will be redirected to the 'view' page.
    * @return mixed
    */
    public function actionFuke(){
    	return $this->render('fuke');
    }
    public function actionCreate()
    {
    	$model = new ActivityOfyear();
    	
    	if ($model->load(Yii::$app->request->post())) {
    		$post=Yii::$app->request->post();
    		$acoy=$post['ActivityOfyear'];
    		$success=0;
    		$failed=0;
    		$added=0;
    		foreach ($post['ac_id'] as $key=> $value) {
    			$arr=Activity::find()->where(['ac_id'=>$post['ac_id'][$key]])->asArray()->one();
    			$count=ActivityOfyear::find()->where(['acoy_id'=>$arr['cate_id'].$acoy['edu_level'].$arr['type_id'].$arr['side_id'].$arr['ac_num']])->count();

    			if($count==0){
    				$modelSub = new ActivityOfyear();
    				
    				$num=[1,2,3,4,5,6,7,8,9];
    				if(in_array($arr['ac_num'],$num)){
    					$arr['ac_num']='0'.$arr['ac_num'];
    				}
    				$modelSub->acoy_id=$arr['cate_id'].$acoy['edu_level'].$arr['type_id'].$arr['side_id'].$arr['ac_num'];
    				$modelSub->ac_id=$value;  
    				$modelSub->edu_level=$acoy['edu_level']; 
    				$modelSub->point=$acoy['point'];  
    				if($modelSub->save()){
    					$success++;
    				}
    				else{
    					$failed++;
    				}
    			}
    			else{
    				$added++;
    			}
    		}
    		Yii::$app->session->setFlash('warnning','เพิ่มกิจกรรมสำเร็จ '.$success.' รายการ มีข้อมูลแล้ว '.$added.' รายการ เกิดข้อผิดพลาด '.$failed);
    		return $this->redirect(['index']);
    		
    	}
    	else{
    		return $this->render('create', [
    			'model' => $model,
    		]);
    	}


    }



    /**
    * Updates an existing ActivityOfyear model.
    * If update is successful, the browser will be redirected to the 'view' page.
    * @param string $id
    * @return mixed
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionUpdate($id)
    {
    	$model = ActivityOfyear::findOne($id);

    	if ($model->load(Yii::$app->request->post())) {
    		$post=Yii::$app->request->post();
    		$acoy=$post['ActivityOfyear'];
    		$success=0;
    		$failed=0;    		
    		foreach ($post['ac_id'] as $key=> $value) {
    			$arr=Activity::find()->where(['ac_id'=>$post['ac_id'][$key]])->asArray()->one();
    			$count=ActivityOfyear::find()->where(['acoy_id'=>$arr['cate_id'].$acoy['edu_level'].$arr['type_id'].$arr['side_id'].$arr['ac_num']]);

    			$num=[1,2,3,4,5,6,7,8,9];
    			if(in_array($arr['ac_num'],$num)){
    				$arr['ac_num']='0'.$arr['ac_num'];
    			}
    			$modelSub->acoy_id=$arr['cate_id'].$acoy['edu_level'].$arr['type_id'].$arr['side_id'].$arr['ac_num'];
    			$modelSub->ac_id=$value;  
    			$modelSub->edu_level=$acoy['edu_level']; 
    			$modelSub->point=$acoy['point'];  
    			if($modelSub->save()){
    				$success++;
    			}
    			else{
    				$failed++;
    			}

    			
    		}
    		Yii::$app->session->setFlash('warnning','แก้ไขกิจกรรมสำเร็จ '.$success.' รายการ เกิดข้อผิดพลาด '.$failed);
    		return $this->redirect(['index']);
    		
    	}
    	else{
    		return $this->render('update', [
    			'model' => $model,
    		]);
    	}

    }

    /**
    * Deletes an existing ActivityOfyear model.
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
    * Finds the ActivityOfyear model based on its primary key value.
    * If the model is not found, a 404 HTTP exception will be thrown.
    * @param string $id
    * @return ActivityOfyear the loaded model
    * @throws NotFoundHttpException if the model cannot be found
    */
    public function actionAc()
    {
    	if (Yii::$app->request->isAjax) {
    		$data = Yii::$app->request->post();
    		$res=0;
    		if($data['acoy_id']!==''&&$data['acoy_id']!==null){
    			$res= explode(":", $data['acoy_id']);
    			$res=ActivityOfyearDetail::find()->select('qr_num,ac_startdate,ac_enddate')->where(['acoyd_id'=>$res])->one();
    		}


    		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    		return [
    			'data' => $res,
    		];
    	}
    }

    /**
    * Lists all ActivityOfyear models.
    * @return mixed
    */
    public function actionIndex()
    {
    	$query=ActivityOfYear::find()->orderBy(['acoy_id'=>SORT_DESC]);
    	$searchModel = new ActivityOfyearSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$query);

    	return $this->render('index', 
    		[
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    		]
    	);
    }
    public function actionPreQrcode()
    {

    	$model = new ActivityOfyear();

    	if (Yii::$app->request->post()) {
    		$post=Yii::$app->request->post();
    		if($post['acoy_id']!==null||$post['qr_num_plus]']==0){
                //เปิดการเชื่อมต่อนานขึ้นหรือน้อยลง
    			ini_set('max_execution_time', 9999);
    			$model=$this->findModel($post['acoy_id']);

    			$start=$post['qr_now']+1;
    			$end=$post['total'];
    			$text=$post['acoy_id'];
    			$date1=$model->ac_startdate;
    			$date2=$model->ac_enddate;
    			$arr=[];
    			$str= Url::to(['/web/activity-of-year/']);
    			$files =  glob('../activity-of-year/');

                // echo $dir =Yii::getAlias('@web').'/activity-of-year/';
                   // $this->deleteAll($dir);
    			while(true){
    				if(strtotime($date1)>strtotime($date2)){
    					break;
    				}
    				$arr["$date1"]=$this->HaveDate($start,$end,$text,$date1);
    				$date1= date('Y-m-d',strtotime($date1.'+ 1 days'));
    			};
    			if($model->save()){
    				$model->qr_num=$post['total'];
    				$model->save();                   
    			}

    			return $this->print($arr,$start,$end,$text,$date1,$date2);
    		}
    		else{
    			return $this->redirect(['index']);
    		}
    	}
    	else{
    		return $this->render('qrcode', [
    			'model' => $model,
    		]);
    	}
    }

    

    protected function deleteAll($str) {
    //It it's a file.
    	if (is_file($str)) {
        //Attempt to delete it.
    		return unlink($str);
    	}
    //If it's a directory.
    	elseif (is_dir($str)) {
        //Get a list of the files in this directory.
    		$scan = glob($str.'activity-of-year/{,.}*', GLOB_BRACE);
        //Loop through the list of files.
    		foreach($scan as $index=>$path) {
            //Call our recursive function.
    			$this->deleteAll($path);
    		}
        //Remove the directory itself.
            // return @rmdir($str);
    	}


    }
    public function print($model,$start,$end,$ac_name,$date1,$date2){
        //$this->Qrcode($id);
    	$this->label='Qr Code กิจกรรม';

        // $qrCode=$this->Qrcode($id,$size,$logosize,$font)['data'];


    	$name='QrCode กิจกรรม.pdf';
        //$this->title=$name;
    	$content = $this->renderPartial('print',['model'=>$model,'ac_name'=>$ac_name]);



    	$pdf = new Pdf([
    		'mode' => Pdf::MODE_UTF8,
    		'format' => Pdf::FORMAT_A4,
    		'orientation' => Pdf::ORIENT_PORTRAIT,
    		'destination' => Pdf::DEST_BROWSER,
    		'filename' => $name,
    		'marginLeft' => 10,
    		'marginRight' => 10,
    		'marginTop' => 10,
    		'marginBottom' => 10,
    		'content' => $content,

    		'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
    		'cssInline' => '
    		.divtable{
    			border-collapse:collapse;
    			table-layout:fixed;
    			overflow:wrap;
    			width:100%;
    		}
    		.divtable tr th,.divtable tr td{
    			vertical-align:top;
    		}
    		body {
    			font-size:18px
    		}

    		p {
    			margin-bottom: 3px;
    		}
    		.head {
    			width: 275px;
    			float: left;
    			margin-bottom: 1px;
    		}
    		.head-right {
    			width: 220px;
    			float: left;
    		}

    		.container{
    			position:relative;
    		}
    		div .h1{
    			position:absolute;left:0;top:0;
    		}
    		div .h2{
    			position:absolute;left:auto;right:auto;top:0;
    		}
    		.dottedunderline{
    			text-decoration:underline dotted black
    		}
            #repair_user{
    		float: right;
    		width: 250px;
    		clear: left;        }
    		td.small {line-height: 90%}
    		table.big {
    			line-height: 140%;
    		}
    		.line{
    			border-bottom:#333 1.9px dotted
    		}
    		.table {
    			border: 1px solid #000;
    			border-collapse: collapse;
    			font-size:16px;
    		}
    		.clear{clear:both; line-height:0; height:0; font-size: 1px}
    		.box-1{width:250px;  float:left}
    		.box-2{width:250px;   float:right;}
    		.block{width: 245px; margin: 5px; float: left; height:100px;}',
    		'options' => ['title' => $name],
    		'methods' => [
                //'SetHeader'=>['Krajee Report Header'],
                //'SetFooter'=>['{PAGENO}'],
    		]
    	]);
    	$pdf=$pdf->render();


    	return $pdf;

    }
    /**
    * [actionQrFromArray description]
    * @return [type] [description]
    */

    protected function HaveDate(Int $start,Int $end,String $text, String $date):Array{
    	$arr=[];
    	while ($start<=$end) {
    		$str='';
    		$str=$text.' '.$start.' '.$date;
    		$filename=$date.' '.$start;
    		$arr[]=$filename;
    		$str=Yii::$app->Func->encode($str);
    		$this->qrCodeGen($str,$filename);
    		$start++;
    	}
    	return $arr;
    }
    protected function unlinkQr(Int $start,Int $end,String $text, String $date):void{
    	while ($start<=$end) {
    		$str='';
    		$str=$text.' '.$start.' '.$date;
            // echo"Deleted $str <br />";
    		$this->deleteQr($date.' '.$start);
    		$start++;
    	}
    }


    /**
    * [qrCodeGen description]
    * @param [type] $text [description]
    * @param [type] $file [description]
    */
    public function qrCodeGen($text,$filename):void{
    	$qrCode=$this->renderQrcode($text,80);
    	$qrCode->writeFile($this->dir().$filename.'.png');
    	$qrCode->writeString();
    }
    /**
    * [actionQrcode description]
    * @param  [type]  $id       [description]
    * @param  integer $size     [description]
    * @param  integer $logosize [description]
    * @param  integer $font     [description]
    * @return [type]            [description]
    */
    public function actionQrcode($id,$size=300,$logosize=50,$font=16){

    	$qrCode=$this->Qrcode($id,$size,$logosize,$font)['data'];
    	echo $qrCode->writeString();
    	echo (new QrCodeResponse($qrCode));
    	$this->deleteQr($id);

    }
    public function qrcode($id,$size=300,$logosize=50,$font=16){

        // $qrCode=$this->renderQrcode($id,$size,$logosize,$font)['data'];

    	$qrCode=$this->renderQrcode($id,$size,$logosize,$font);
    	$qrCode->writeFile($this->dir().$id.'.png');
    	echo $qrCode->writeString();
    	echo (new QrCodeResponse($qrCode));
        // $this->deleteQr($id);


    }
    protected $label='';
    protected function dir(){
    	return dirname(__DIR__).'/web/activity-of-year/';
    }
    protected function deleteQr($id){
    	unlink($this->dir().$id.'.png');
    }
    protected function renderQrcode($id,$size=100,$logosize=15,$font=10){

    	$qrCode = new QrCode($id);
    	$qrCode->setSize($size);

        // Set advanced options
    	$qrCode->setWriterByName('png');
        //$qrCode->setWriterByName('png');
    	$qrCode->setMargin(2);
    	$qrCode->setEncoding('UTF-8');
    	$qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH));
    	$qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
    	$qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
    	if($this->label!==''){
    		$id=Yii::$app->Func->decode($id);
    		$id=explode(' ',$id)[0];
    		$qrCode->setLabel($id, $font);
    	}
        //$qrCode->setLogoPath(dirname(__DIR__).'/web/img/qrcode.png');
        // $qrCode->setLogoWidth($logosize);

    	$qrCode->setValidateResult(false);

        // Directly output the QR code
    	header('Content-Type: '.$qrCode->getContentType());



        // Save it to a file
        // $qrCode->writeFile($this->dir().$id.'.png');
        // Create a response object

    	return $qrCode;
    }


    protected function findModel($id)
    {
    	if (($model = ActivityOfyear::findOne($id)) !== null) {
    		return $model;
    	}

    	throw new NotFoundHttpException('The requested page does not exist.');
    }
}
