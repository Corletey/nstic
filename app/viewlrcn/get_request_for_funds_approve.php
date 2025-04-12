<?php
require_once('../configlrcn/db_mconfig.php');
$country=$_GET['country'];

if($country=='Rejected'){
?>
<p>Provide comment why you are rejecting this request.</p>
<textarea name="reason" id="MyTextBox333" cols="" rows="5" class="form-control required" style="width:100%; border:1px solid #000; margin-top:20px;"><?php echo $rstudy['reason'];?></textarea>
<?php }
if($country=='Approved'){}

?>

