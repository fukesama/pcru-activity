<?php
use yii\helpers\Url;


$this->title = 'QR CODE';
?>

<?php
$i=1;
$print=true;
$b='';
$p=1;
$pbackdoor=$p;
// foreach ($model as $key1 => $value1):
    foreach($model as $key2 => $value2):
        if($print==true||$b!==$key1){
            $b=$key1;
            echo '<div style="text-align:center;font-size:16px;margin-bottom:0px;margin-right: 0;margin-left: 0;margin-top:0;">'.$ac_name.' '.$key1;
            if($pbackdoor!=$p||$p=1){
                $pbackdoor=$p;
                echo ' หน้าที่ '.$p;
            }
            echo '</div>';
        }
        if($print==true){
            // echo '<br>';
            $print=false;
        }
        
        $i++;
        if($i>70){$i=1;$p++;$print=true;}
        ?>
        <img src="<?= Url::base().'/activity-of-year/'.$value2.'.png'; ?>" style="padding:5px;border: 1px solid black;margin-bottom:5px;margin-right: 0;margin-left: 0;"/>
        <?php
    endforeach;
// endforeach;
?>
