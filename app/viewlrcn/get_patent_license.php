<?php
require_once('../configlrcn/db_mconfig.php');
require_once('../contrlrcn/language.php');
$country=$_GET['country'];
if($country=='Yes'){
?>
<p><?php echo $lang_Providealistofallpatents;?> <em  style="color:#F00;"><?php echo $lang_confidentialinformation;?></em>.</p>
<textarea name="listofallpatents" id="MyTextBox14" cols="" rows="5" class="form-control required" style="width:100%; border:1px solid #000; margin-top:20px;"></textarea><br />



<p><?php echo $lang_Indicatethenameofthepatent;?></p>
<textarea name="nameofthepatent" id="MyTextBox12" cols="" rows="5" class="form-control required" style="width:100%; border:1px solid #000; margin-top:20px;"></textarea><br />


<p><?php echo $lang_Describeinvention;?></p>
<textarea name="potentialimportance" id="MyTextBox13" cols="" rows="5" class="form-control required" style="width:100%; border:1px solid #000; margin-top:20px;"></textarea>

<?php }
if($country=='No'){}

?>

