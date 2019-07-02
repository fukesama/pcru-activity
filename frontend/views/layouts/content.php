<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

use yii\web\View;
use yii\helpers\Json;

?>



<?= $content; ?>

<?php
$JS=<<<JS

JS;
$this->registerJs($JS,View::POS_READY)
?>
