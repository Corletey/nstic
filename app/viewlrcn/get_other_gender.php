<?php
require_once('../configlrcn/db_mconfig.php');
$country=$_GET['country'];
if($country=='OtherGender'){
?>
<input type="text" class="form-control <?php echo $required;?>" name="OthersGender[]" value=""  style="width:110px;" placeholder="specify">

<?php }

?>

