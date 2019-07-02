<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserCollegian */

$this->title = Yii::t('app', 'Update User Collegian: ' . $model->student_id, [
    'nameAttribute' => '' . $model->student_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Collegians'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->student_id, 'url' => ['view', 'id' => $model->student_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-collegian-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
