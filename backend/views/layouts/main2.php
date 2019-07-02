<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use backend\assets\AppAsset;
//use yii2mod\alert\Alert;
//use common\widgets\Alert;
use yii\helpers\Url;
use common\components\Mobiledetect as MD;
use yii\web\View;
use yii\helpers\Json;
use bluezed\scrollTop;
use yii\bootstrap\Modal;

//use aryelds\sweetalert\SweetAlert;


AppAsset::register($this);

if (class_exists('ramosisw\CImaterial\web\MaterialAsset23')) {
	ramosisw\CImaterial\web\MaterialAsset23::register($this);
	yii\materialicons\AssetBundle::register($this);
	rmrevin\yii\fontawesome\AssetBundle::register($this);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>

	<meta charset="<?= Yii::$app->charset; ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags(); ?>
	<title><?= Html::encode($this->title); ?></title>
	<?php $this->head(); ?>
</head>

<?php $colorbtnhover='#9931B0' ?>


<style type="text/css">
	.form-group input[type=file] {
		opacity: 100;

	}
	.form-group .help-block{
		display:block;
	}
	.btnhover{
		background-color: <?=$colorbtnhover?>;
		border: none;
		color: white;
		padding: 5px 6px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		color:#000;
		border-radius: 3px;
	}
	.btnhover:hover{
		background-color: <?=Yii::$app->Func->colorCon($colorbtnhover,-20)?>
	}
	.btnhover a{
		color:white;
	}
	.sidebar .sidebar-wrapper{
		height: calc(100vh - 140px);
	}
	.breadcrumb {
		display: inline-block;
		position: relative;
		width: 100%;
		margin-bottom: 25px;
		box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.14);
		border-radius: 3px;
		color: rgba(0,0,0, 0.87);
		background: #fff;
	}
	ul.nav.tree  li a table{
		border-collapse: collapse;
	}
	ul.nav.tree  li a table tr td{
		vertical-align: text-top;
		padding: 0px;
	}
	.btn-group{
		margin:0px;
	}
	.breadcrumb{
		background-color: #FFFFFF;
	}
	.detail-view tbody tr td{
		text-align: left;
	}

	html, body {
		height: 100%;
		margin: 0;
	}

	.form-group label.control-label{
		font-size: 14px;
	}
	.control-label{
		font-size: 14px;
	}
	.form-group {
		padding-bottom: 0px;
		margin: 0px 0 0 0;
	}



	.modalContent{
		text-align: left;
	}


	.modal-content{
		border: 1px  solid black;

		box-shadow: none;
		text-align:left;

	}

	.modal-body {

		position: relative;
		padding: 15px;
		overflow-y: auto;
	}

	#footer {
		height: 60px;
		margin-top: -50px;
	}
	.cd-top.cd-top--show {

		visibility: visible;
		opacity: 1;
	}

	.cd-top.cd-top--fade-out {

		opacity: .5;
	}
	.form-group.has-success label.control-label,.form-group label.control-label{
		font-size: 16px;
	}

</style>

<body style="height: 100%;margin: 0;">

	<?php $this->beginBody() ?>

	<div class="warpper">
		<?= \bluezed\scrollTop\ScrollTop::widget() ?>
		<?= $this->render('left.php');?>
		<?php Modal::begin([
			'id' => 'activity-modal',
			'size'=>'modal-lg',
			'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
		]);
		Modal::end();
		?>
		<div class="main-panel">


			<?=	$this->render('header.php') ?>


			<?php $this->render('//layouts/alert') ?>
			<div class="content" style="display: block;">

				<div class="container-fluid" style="margin-top:-25px">
					<?=Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ;?>
					<?=$this->render('content.php',['content'=>$content]) ?>
				</div>
			</div>

			<div class="footer" id="footer" style="display: block;">
				&nbsp; &copy; Dev by Chinnawat Kaewyom
			</div>

		</div>




	</div>
	<?php $this->endBody(); ?>
</body>
</html>
<?php
$url=Url::to(['index']);
$DM=new MD;
if($DM->isMobile()){
	$text=$DM->isAndroidOS()?'android':'window';
	$DM->isiOS()?$text='ios':null;
}
elseif($DM->isTablet()){
	// Any tablet device.
}
else{
	$text='COM';
}
$delete=Url::to(['delete']);
$script=<<<JS

/**
* Override the default yii confirm dialog. This function is
* called by yii when a confirmation is requested.
*
* @param message the message to display
* @param okCallback triggered when confirmation is true
* @param cancelCallback callback triggered when cancelled
*/

function alert2(message, title, buttonText) {

	buttonText = (buttonText == undefined) ? 'ใช่' : buttonText;
	title = (title == undefined) ? "The page says:" : title;

	var div = $('<div>');
	div.html(message);
	div.attr('title', title);
	div.dialog(
	{
		autoOpen: true,
		modal: true,
		draggable: false,
		resizable: false,
		buttons: [
		{
			text: buttonText,
			click: 
			function () {
				$(this).dialog("close");
				div.remove();
			}
		}
		]
	}
	);
}



JS;
$this->registerJs($script,View::POS_READY)
?>
<?php
$script=<<<JS

JS;
$this->registerJs($script,View::POS_END);
?>
<?php

$script=<<<JS

$(window).bind("load", function() {

	var footerHeight = 0,
	footerTop = 0,
	footer = $("#footer");

	positionFooter();

	function positionFooter() {

		footerHeight = footer.height();
		footerTop = ($(window).scrollTop()+$(window).height()-footerHeight)+"px";

		if ( ($(document.body).height()+footerHeight) < $(window).height()) {
			footer.css(
			{
				position: "absolute"
			}
			).animate(
			{
				top: footerTop
			}
			)
		} 
		else {
			footer.css(
			{
				position: "static"
			}
			)
		}

	}

	$(window)
	.scroll(positionFooter)
	.resize(positionFooter)

}
);


JS;
$this->registerJs($script,View::POS_END);
?>
<?php
$csrf=Yii::$app->request->getCsrfToken();
$js=<<<JS
function numOnly(){
	$(".numOnly").keypress(function(e){
		var keyCode = e.which;
		/*
		8 - (backspace)
		32 - (space)
		48-57 - (0-9)Numbers
		*/

		if (keyCode < 48 || keyCode > 57) {
			return false;
		}
	}
	);
}
function getData(data,url,type='post')
{


	var data2={
		_csrf:'$csrf'
	};

	var res=jQuery.extend(data,data2);

	$.ajax({
		url: '$url',
		type: type,
		data: res,
		success: function (data) {
			console.log(data.data);
		}
	}
	);
}

JS;
$this->registerJs($js,View::POS_HEAD);
?>
<?php
$this->registerCssFile('http://'.$_SERVER['SERVER_NAME']."/pcru-activity/backend/web/css/css.css") ?>
<?php $this->endPage() ?>
