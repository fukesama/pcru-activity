<?php
namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\Json;
use PhpOffice\PHPExcel;
use PhpOffice\PHPExcel_IOFactory;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use kartik\depdrop\Depdrop;
use yii\widgets\MaskedInput;
use kartik\widgets\FileInput;
use kartik\widgets\DatePicker;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use kartik\daterange\DateRangePicker;
use yii\filters\AccessControl;
use common\commands\AccessRule;
use yii\web\Controller;
use yii\filters\VerbFilter;

use common\components\Func as F;





class AcColumn extends Component {
	public function AcColumn($site=null){
		if($site==='user'){
			$button=$this->UserButton();
		}
		else{
			$button=$this->DefaultButton();
		}
		return[
			'class' => 'yii\grid\ActionColumn',
			'header'=>'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
			'contentOptions'=>['width'=>'110px'],
			'options'=>['width'=>'110px'],
			'template'=>'<div class="btn-group btn-group-xs text-center" role="group" >{view}{update}{delete}</div>',
			'buttons'=>$button,
		];
	}
	protected function UserButton(){
		$GLOBALS['level_user']=Yii::$app->User->identity->level_user;
		return[
			'view'=>function($url,$model,$key){
				return
				Html::a('
				<span class="material-icons">visibility</span>
				',$url,
				[
					'class'=>'btn btn-xs btn-success',
					"style" => "cursor: pointer;",
					"title" => "ดู"
				]
				) ;
			},


			'update'=>function($url,$model,$key){
				return$GLOBALS['level_user']==='0'?
				Html::a('
				<span class="material-icons">create</span>
				',$url,
				[
					'class'=>'btn btn-xs btn-warning',
					"style" => "cursor: pointer;",
					"title" => "แก้ไข"
				]
				):null;
			},
			'delete'=>function($url,$model,$key){
				return$GLOBALS['level_user']==='0'?
				Html::a('
				<span class="material-icons">delete</span>
				',$url,
				[
					'class'=>'btn btn-xs btn-danger',
					"style" => "cursor: pointer;",
					"title" => "ลบ",
					'data' => [
						'confirm' => Yii::t('app', 'คุณต้องการที่จะลบรายการนี้ใช่หรือไม่?'),
						'method' => 'post',
					],
				]
				):null;
			},


		];
	}
	protected function DefaultButton(){
		return[
			'view'=>function($url,$model,$key){
				return
				Html::a('
				<span class="material-icons">visibility</span>
				',$url,
				[
					'class'=>'btn btn-xs btn-success',
					"style" => "cursor: pointer;",
					"title" => "ดู"
				]
				) ;
			},

			'update'=>function($url,$model,$key){
				return
				Html::a('
				<span class="material-icons">create</span>
				',$url,
				[
					'class'=>'btn btn-xs btn-warning',
					"style" => "cursor: pointer;",
					"title" => "แก้ไข"
				]
				) ;
			},
			'delete'=>function($url,$model,$key){

				return Html::a('<i class="material-icons" st>delete</i>', $url, [
					'class'=>'btn btn-xs btn-danger',
					"style" => "cursor: pointer;",
					"title" => "ลบ",
					'data' => [
						'confirm' => Yii::t('app', 'คุณต้องการที่จะลบรายการนี้ใช่หรือไม่?'),
						'method' => 'post',
					],
				]
			);
			},


		];
	}

}
?>
