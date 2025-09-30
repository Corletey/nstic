<?php
require_once('../configlrcn/db_mconfig.php');
require_once('../contrlrcn/language.php');
$country=$_GET['country'];


//extra number from string
$int_var = preg_replace('/[^0-9]/', '', $country);   
$projectID=$int_var;
$extractedValue=substr($country,0,3);

if($extractedValue=='yes'){
///Get Totalfunding from applicant submission
$sqlAmount = "select * from ".$prefix."submissions_proposals where projectID='$projectID'";
$resAmount = $mysqli->query($sqlAmount);
$sqAmount = $resAmount->fetch_array();
$currency=$sqAmount['currency'];
//Get currency ID
?>

<div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $lang_AmountofGrantawarded;?></label>
      <input type="number" id="MyTextBox3" name="AmountofGrantawarded" placeholder="<?php echo $lang_AmountofGrantawarded;?>..." value="<?php echo $sqAmount['Totalfunding'];?>" required>
      
      <select name="currency" id="currency" style="float:right; width:30%;">
   <option value="" selected="selected"><?php echo $lang_please_select;?></option>     
 <?php
$sqlUser = "SELECT * FROM ".$prefix."currency order by currency asc";
$queryUser = $mysqli->query($sqlUser);
while($r = $queryUser->fetch_array()){?>
    <option value="<?php echo $r['currency'];?>" <?php if($r['currency']==$sqAmount['currency']){?>selected="selected"<?php }?>>&nbsp;<?php echo $r['currency'];?></option>
    <?php }?>
       </select> 
       
    </div>
  </div>
  
  
     <div class="row success">

    <div class="col-100">
    <label for="country"><?php echo $lang_DurationofGrant;?> <span class="error">*</span></label>
      <select id="country" name="projectDurationID" class="requiredm" required>
       <?php
$sqlFeaturedCall = "SELECT * FROM ".$prefix."duration order by durationID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
while($rFeaturedCall = $queryFeaturedCall->fetch_array()){
?>
<option value="<?php echo $rFeaturedCall['durationID'];?>" <?php if($rFeaturedCall['durationID']==$projectDurationID){?>selected="selected"<?php }?>><?php echo $rFeaturedCall['duration'];?> <?php echo $rFeaturedCall['durationdesc'];?></option>
<?php }?>
      </select>
    </div>
  </div>
  
  <div class="row success">

<div class="col-100">
<label for="fname">Date of Award <span class="error">*</span></label>

<input type="date" id="MyTextBox3" name="awardDate" placeholder="" required>



</div>
</div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $lang_GrantAgreement;?> <span class="error">*</span></label>
   <input name="awardagreement" type="file" id="awardagreement" class="required" required/>
    </div>
  </div>
  
<?php }
if($country=='no'){?>





<?php
}
?>

