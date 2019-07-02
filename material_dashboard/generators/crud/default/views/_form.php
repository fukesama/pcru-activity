<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

    <div class="container-fluid">
        <?= "<?php " ?>$form = ActiveForm::begin(); ?>

        <?php foreach ($generator->getColumnNames() as $attribute) {
            if (in_array($attribute, $safeAttributes)) {
                echo'<div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                    ';
                echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n";
                echo '</div>
                </div>
                ';
            }
        } ?>
        <div class="form-group">
            <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save') ?>, ['class' => 'btn btn-success']) ?>

        </div>

        <?= "<?php " ?>ActiveForm::end(); ?>
    </div>
</div>
