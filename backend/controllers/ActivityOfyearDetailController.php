<?php

namespace backend\controllers;

use Yii;
use backend\models\ActivityOfyearDetail;
use backend\models\ActivityOfyearDetailSearch;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
 * ActivityOfyearDetailController implements the CRUD actions for ActivityOfyearDetail model.
 */
class ActivityOfyearDetailController extends Controller
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
     * Lists all ActivityOfyearDetail models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$searchModel = new ActivityOfyearDetailSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    	return $this->render('index', [
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }

    /**
     * Displays a single ActivityOfyearDetail model.
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
     * Creates a new ActivityOfyearDetail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$model = new ActivityOfyearDetail();

    	if ($model->load(Yii::$app->request->post())) {    		
    		if($model->save()){
    			return $this->redirect(['view', 'id' => $model->acoyd_id]);
    		}
    		
    	}

    	return $this->render('create', [
    		'model' => $model,
    	]);
    }

    /**
     * Updates an existing ActivityOfyearDetail model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
    	$model = $this->findModel($id);

    	if ($model->load(Yii::$app->request->post())) {
    		if($model->save()){
    			return $this->redirect(['view', 'id' => $model->acoyd_id]);
    		}

    	}

    	return $this->render('update', [
    		'model' => $model,
    	]);
    }

    /**
     * Deletes an existing ActivityOfyearDetail model.
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

    public function actionPreQrcode()
    {

    	$model = new ActivityOfyearDetail();

    	if (Yii::$app->request->post()) {
    		$post=Yii::$app->request->post();
    		// print_r($post);
    		if($post['acoyd_id']!==null||$post['qr_num_plus]']==0){
                //เปิดการเชื่อมต่อนานขึ้นหรือน้อยลง
    			ini_set('max_execution_time', 9999);
    			$model=$this->findModel($post['acoyd_id']);    			
    			$val=ActivityOfyearDetail::find()->where(['acoyd_id'=>$post['acoyd_id']])->one();
    			
    			$start=$post['qr_now']+1;
    			$end=$post['total'];
    			$text=$val->acoyd_id;
    			$date1=$model->ac_startdate;
    			$date2=$model->ac_enddate;
    			$arr=[];
    			$str= Url::to(['/web/activity-of-year/']);
    			$files =  glob('../activity-of-year/');
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
    	

    	$model2=(ActivityOfyearDetail::find()->where(['acoyd_id'=>$ac_name])->one());
    	$ac_name=$model2->acoy_id;
    	// print_r($ac_name);
    	// 		return ;

        // $qrCode=$this->Qrcode($id,$size,$logosize,$font)['data'];

    	$this->label=$model2->acoy->ac->ac_name;
    	$name=$this->label.'.pdf';
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
    			'SetFooter'=>['{PAGENO}'],
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
    		$str=$text.' '.$start.' '.strtotime($date);
    		// $filename=$date.' '.$start;
    		$filename=$str;
    		$arr[]=$filename;
    		// $str=Yii::$app->Func->encode($str);
    		$this->qrCodeGen($str,$filename);
    		$start++;
    	}
    	return $arr;
    }
   


    /**
    * [qrCodeGen description]
    * @param [type] $text [description]
    * @param [type] $file [description]
    */
    public function qrCodeGen($text,$filename):void{
    	$qrCode=$this->renderQrcode($text,180);
    	$qrCode->writeFile($this->dir().$filename.'.png');
    	$qrCode->writeString();
    }

    // public function actionQrcode($id,$size=300,$logosize=50,$font=16){

    // 	$qrCode=$this->Qrcode($id,$size,$logosize,$font)['data'];
    // 	echo $qrCode->writeString();
    // 	echo (new QrCodeResponse($qrCode));
    // 	$this->deleteQr($id);

    // }
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


    /**
     * Finds the ActivityOfyearDetail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActivityOfyearDetail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	if (($model = ActivityOfyearDetail::findOne($id)) !== null) {
    		return $model;
    	}

    	throw new NotFoundHttpException('The requested page does not exist.');
    }
}
