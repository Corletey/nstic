<?php
require_once('../configlrcn/db_mconfig.php');
$country=$_GET['country'];
if($country=='no'){
?>
<textarea name="reason" id="MyTextBox333" cols="" rows="5" class="form-control required" style="width:400px; border:1px solid #000; margin-top:20px;"><?php echo $rstudy['reason'];?></textarea>
<?php }
if($country=='yes'){}

?>

