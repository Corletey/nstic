<?php
require_once('../configlrcn/db_mconfig.php');
$country=$_GET['country'];
$sqlLastQn="SELECT * FROM ".$prefix."grantcall_questions where `status`='new' order by questionID desc limit 0,1";
$QueryLastQn = $mysqli->query($sqlLastQn);
$rUserLastQn=$QueryLastQn->fetch_array();
$qn_number=($rUserLastQn['qn_number']+1);
//Project Information
if($country==1){
	echo "Project Information";?>
    <hr />
    <table width="100%" border="0">
  <tr>
    <td width="72%"><strong>Question</strong></td>
    <td width="14%"><strong>Qn Number</strong></td>
    <td width="14%"><strong><?php echo $lang_Status;?></strong></td>
  </tr>
  <tr>
    <td>  <div class="row success">

    <div class="col-100">
      <input type="text" id="MyTextBox" name="qn_title" placeholder="Give the title of your project.." class="requiredm" value="Title (max 35 words) - Give the title of your project" required>
    </div>
  </div></td>
    <td>  <div class="row success">

    <div class="col-100">
      <input type="text" id="MyTextBox" name="qn_title_number" class="requiredm" value="Qn Number" required>
    </div>
  </div></td>
    <td><input name="qn_title_status" type="radio" value="Enable" /> Enable<br />
    <input name="qn_title_status" type="radio" value="Disable" /> Disable
    </td>
  </tr>
  
  
  
   <tr>
    <td>  <div class="row success">

    <div class="col-100">
      <input type="text" id="MyTextBox" name="qn_acronym" placeholder="Short Title or Acronym (10 characters)" class="requiredm" value="Short Title or Acronym (10 characters)" required>
    </div>
  </div></td>
    <td>  <div class="row success">

    <div class="col-100">
      <input type="text" id="MyTextBox" name="qn_acronym_number" class="requiredm" value="Qn Number" required>
    </div>
  </div></td>
    <td><input name="qn_acronym_status" type="radio" value="Enable" /> Enable<br />
    <input name="qn_acronym_status" type="radio" value="Disable" /> Disable
    </td>
  </tr>
  
  <tr>
    <td>  <div class="row success">

    <div class="col-100">
      <input type="text" id="MyTextBox2" name="qn_relevantKeywords" placeholder="Identify the 5 most relevant keywords that represent the scientific basis of your project (max 5 words)" class="requiredm" value="Identify the 5 most relevant keywords that represent the scientific basis of your project (max 5 words)" required>
    </div>
  </div></td>
    <td>  <div class="row success">

    <div class="col-100">
      <input type="text" id="MyTextBox" name="qn_relevantKeywords_number" class="requiredm" value="Qn Number" required>
    </div>
  </div></td>
    <td><input name="qn_relevantKeywords_status" type="radio" value="Enable" /> Enable<br />
    <input name="qn_relevantKeywords_status" type="radio" value="Disable" /> Disable
    </td>
  </tr>
  
  
   <tr>
    <td>  <div class="row success">

    <div class="col-100">
     <label for="country">Research and Development foci selection- select the appropriate research, development and innovation focus/foci for your concept <span class="error">*</span></label>
     
    <select id="country" name="qn_researchTypeID" class="requiredm" required>
    <option value="">Please select from list</option>
       <?php
$sqlCat = "SELECT * FROM ".$prefix."categories order by rstug_categoryName asc";
$queryCat = $mysqli->query($sqlCat);
while($rCat = $queryCat->fetch_array()){
?>
<option value="<?php echo $rCat['rstug_categoryID'];?>" <?php if($rCat['rstug_categoryID']==$rUserInv2['researchTypeID']){?>selected="selected"<?php }?>><?php echo $rCat['rstug_categoryName'];?></option>
<?php }?>
</select>
    </div>
  </div></td>
    <td>  <div class="row success">

    <div class="col-100">
      <input type="text" id="MyTextBox" name="qn_researchTypeID_number" class="requiredm" value="Qn Number" required>
    </div>
  </div></td>
    <td><br /><input name="qn_researchTypeID_status" type="radio" value="Enable" /> Enable<br />
    <input name="qn_researchTypeID_status" type="radio" value="Disable" /> Disable
    </td>
  </tr>
  
   <tr>
    <td>  <div class="row success">

    <div class="col-100">
     <label for="country">Host Institution <span class="error">*</span></label>
   <input type="text" id="qn_HostInstitution" name="qn_HostInstitution" placeholder=".." class="requiredm"  value="Host Institution" required>
    </div>
  </div></td>
    <td>  <div class="row success">

    <div class="col-100">
      <input type="text" id="MyTextBox" name="qn_HostInstitution_number" class="requiredm" value="Qn Number" required>
    </div>
  </div></td>
    <td><br /><input name="qn_HostInstitution_status" type="radio" value="Enable" /> Enable<br />
    <input name="qn_HostInstitution_status" type="radio" value="Disable" /> Disable
    </td>
  </tr>
  
  <tr>
    <td>  <div class="row success">

    <div class="col-100">
     <label for="country">Duration of the project- indicate the duration of the project in months <span class="error">*</span></label>
  <select id="country" name="qn_projectDurationID" class="requiredm" required>
       <?php
$sqlFeaturedCall = "SELECT * FROM ".$prefix."duration order by durationID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
while($rFeaturedCall = $queryFeaturedCall->fetch_array()){
?>
<option value="<?php echo $rFeaturedCall['durationID'];?>" <?php if($rFeaturedCall['durationID']==$rUserInv2['projectDurationID']){?>selected="selected"<?php }?>><?php echo $rFeaturedCall['duration'];?> <?php echo $rFeaturedCall['durationdesc'];?></option>
<?php }?>
      </select>
    </div>
  </div></td>
    <td>  <div class="row success">

    <div class="col-100">
      <input type="text" id="MyTextBox" name="qn_projectDurationID_number" class="requiredm" value="Qn Number" required>
    </div>
  </div></td>
    <td><br /><input name="qn_projectDurationID_status" type="radio" value="Enable" /> Enable<br />
    <input name="qn_projectDurationID_status" type="radio" value="Disable" /> Disable
    </td>
  </tr>
  
  
  
  
  
</table>

    
  



<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
<?php }
//Introduction
if($country==5){
	echo "Introduction";?>



<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
<?php }

//Project Details
if($country==6){
	echo "Project Details";?>



<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
<?php }
//Project Team
if($country==7){
	echo "Project Team";?>



<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
<?php }

//Budget
if($country==8){
	echo "Budget";?>



<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
<?php }
//Attachments
if($country==9){
	echo "Attachments";?>



<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
<?php }
///Citations
if($country==10){
	echo "Citations";?>



<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
<?php }

?>
