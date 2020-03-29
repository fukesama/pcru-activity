<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use frontend\models\User;

use yii\web\View;
use yii\helpers\Json;

if (!Yii::$app->user->isGuest) :
	echo $this->render('not_isguest_menu.php') ;

else:
	if(Yii::$app->user->isGuest)
	echo $this->render('isguest_menu.php') ;
	?>

	<?php
endif;
?>
