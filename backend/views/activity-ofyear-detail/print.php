<?php
use yii\helpers\Url;
use backend\models\ActivityOfyearDetail;

$this->title = 'QR CODE';
?>

<?php
$i=1;
$print=true;
$b='';
$p=1;
$pbackdoor=$p;
foreach ($model as $key1 => $value1):
	foreach($value1 as $key2 => $value2):
		if($print==true||$b!==$key1){
			$b=$key1;
			echo '<div style="text-align:center;font-size:16px;margin-bottom:0px;margin-right: 0;margin-left: 0;margin-top:0;">'.$ac_name.' '.$key1;      
			echo '</div>';
		}
		if($print==true){
			$print=false;
		}
		$i++;
		if($i>20){$i=1;$p++;$print=true;}
		?>
		<div style="float:left;display:block;border:1px solid black;width: 170px;">
			<img src="<?php echo Url::base().'/activity-of-year/'.$value2.'.png'; ?>" style="padding:5px;border: 1px solid black;margin-bottom:7px;margin-right: 0;margin-left: 0;display: block;"/>
			<br>
			<div style="font-size: 15px;display: block;">
				<?php echo$value2 ?>
			</div>
		</div>
		<?php
	endforeach;
endforeach;
?>
