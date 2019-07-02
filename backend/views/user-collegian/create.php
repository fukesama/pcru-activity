<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\UserCollegian */

$this->title = Yii::t('app', 'Create User Collegian');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Collegians'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-collegian-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
