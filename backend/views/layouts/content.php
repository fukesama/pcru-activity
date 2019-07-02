<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

use yii\web\View;
use yii\helpers\Json;

?>


<?=Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ;?>
<?= $content; ?>

<?php
$JS=<<<JS

JS;
$this->registerJs($JS,View::POS_READY)
?>
