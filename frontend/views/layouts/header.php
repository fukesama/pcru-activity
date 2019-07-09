<?php
use yii\helpers\Html;

use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\select2\Select2;
use kartik\depdrop\Depdrop;

use common\models\User2 as User;
use yii\widgets\MaskedInput;

use kartik\widgets\FileInput;

use yii\web\View;
use yii\helpers\Json;
use yii\widgets\Breadcrumbs;


use yii\bootstrap\Modal;
use kartik\widgets\DatePicker;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use frontend\models\User as u;
/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php
$menuItems = [
	['label' => 'Home', 'url' => ['/site/index']],
	['label' => 'About', 'url' => ['/site/about']],
	['label' => 'Contact', 'url' => ['/site/contact']],
];
if (Yii::$app->user->isGuest) {
	$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
	$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
	$menuItems[] = '<li>'
	. Html::beginForm(['/site/logout'], 'post')
	. Html::submitButton(
		'Logout (' . Yii::$app->user->identity->username . ')',
		['class' => 'btn btn-link logout']
	)
	. Html::endForm()
	. '</li>';
}


?>
<style>
	.btn .link:hover{
		background-color: rgba(154, 154, 154, 1)
	}
</style>
<header class="main-header" >
	<nav class="navbar navbar-transparent navbar-absolute">
		<div class="container-fluid">
			<div class="navbar-header" >
				<button type="button" class="navbar-toggle" data-toggle="collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=Yii::getAlias('@web') ?>" style="">

					<span style="font-weight: bold;display: block;">PCRU - Activity</span>
				</a>
			</div>
			<div class="collapse navbar-collapse">

				<ul class="nav navbar-nav navbar-right">
					<?php
					if (Yii::$app->user->isGuest) :

						$Login=Url::to(['/site/login']);
						?>


						<li>
							<a href="<?=$Login?>"  style="font-weight: bold;">

								<p class='hidden-lg hidden-md'>
									<i class="material-icons" style="display: block;">person</i>Login
								</p>
								<p class='hidden-xs hidden-sm' style="float: left;">
									<i class="material-icons" style="display: block;float: left;">person</i>Login
								</p>
							</a>
						</li>
						<?php
						$menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
						$menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
					else :


						?>


						<li>
							<a href="#" style="font-weight: bold;" onclick="postLogout()">

								<p class='hidden-lg hidden-md'>
									<?php $u=u::findone(Yii::$app->user->identity->id);
									$text='';
									if($u->level_user='3'){
										$text= ' '.$u->co->pre->pre_name.' '.$u->co->uc_fname.' '.$u->co->uc_lname;
									}	

									?>
									<i class="material-icons">person</i> Logout 
									(
									<?php echo Yii::$app->user->identity->username.$text;?>
									)
								</p>
								<p class='hidden-xs hidden-sm' style="float: left;">
									<i class="material-icons" style="display: block;float: left;">
										person
									</i>
									Logout (<?=Yii::$app->user->identity->username.$text;?>)
								</p>
							</a>


						</li>

					</ul>
				<?php endif;?>

			</div>
		</div>
	</nav>


</header>

<?php
$logout=Url::to(['/site/logout']);
$script=<<<Javascripte
function postLogout() {
	$.post('$logout', {}, function(resp) {
			//Do something with the AJAX response
	}
	);
}
Javascripte;
$this->registerJs($script,View::POS_HEAD)
?>
