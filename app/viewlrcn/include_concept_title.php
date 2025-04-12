<?php
require_once('../configlrcn/db_mconfig.php');
require_once('../contrlrcn/language.php');
$country=$_GET['country'];
if($country=='Yes'){
?><div class="col-100">
    <label for="fname"><?php echo $lang_new_CallTitle;?> </label>
<select name="conceptID" id="MyTextBox3">
<option value=""><?php echo $lang_please_select;?></option>
<?php
  ///Check for Project Title and Budget
    //check for project Title
$sqlProjectID2r_title="SELECT * FROM ".$prefix."grantcalls where `requirefullproposal`='Yes' and category='concepts' order by grantID desc limit 0,10";
$QueryProjectID2r_title = $mysqli->query($sqlProjectID2r_title);
while($rowsSubmitted_c=$QueryProjectID2r_title->fetch_array()){
?>
<option value="<?php echo $rowsSubmitted_c['grantID'];?>" <?php if($rowsSubmitted_c['grantID']==$rUserInv2['conceptID']){?>selected="selected"<?php }?>><?php echo $rowsSubmitted_c['title'];?></option>
<?php }?>
</select>
   
    </div>
    <?php }
	if($country=='No'){?>
	<div class="col-100">
    <label for="fname"><?php echo $lang_new_CallTitle;?> </label>
 <input type="text" id="calltittle" name="calltittle" placeholder="Enter call title.." value="<?php echo $rUserInv2['title'];?>">
   
    </div>
    
    <?php }?>