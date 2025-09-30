<?php

if($_POST['doSaveData'] and $_POST['projectTitle'] and $_POST['asrmApplctID'] and $_POST['asrmApplctID'] and $id){

	
	$projectTitle=$mysqli->real_escape_string($_POST['projectTitle']);
	$titleAcronym=$mysqli->real_escape_string($_POST['titleAcronym']);
	$relevantKeywords=$mysqli->real_escape_string($_POST['relevantKeywords']);
	$researchTypeID=$mysqli->real_escape_string($_POST['researchTypeID']);
	$projectDurationID=$mysqli->real_escape_string($_POST['projectDurationID']);
	$HostInstitution=$mysqli->real_escape_string($_POST['HostInstitution']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$qn_OrchidID=$mysqli->real_escape_string($_POST['qn_OrchidID']);
	$TotalBudget=$mysqli->real_escape_string($_POST['TotalBudget']);
	
	////////////////////Get Category
	$sqlCategory="SELECT * FROM ".$prefix."categories where rstug_categoryID='$researchTypeID' order by rstug_categoryName asc";
	$QueryCategory = $mysqli->query($sqlCategory);
	$rUserCategory=$QueryCategory->fetch_array();
	
	///grant_adminID
	$sqlUsersCallAdm="SELECT * FROM ".$prefix."grantcalls where grantID='$id' order by grantID desc limit 0,1";
		$QueryUsersCallAdm = $mysqli->query($sqlUsersCallAdm);
		$rUserInvCallAdm=$QueryUsersCallAdm->fetch_array();
		$grant_adminID=$rUserInvCallAdm['grant_adminID'];
		
	//Get call ID referenceNo
	$sqlUsersCall="SELECT * FROM ".$prefix."grantcalls where category='concepts' order by grantID desc limit 0,1";
		$QueryUsersCall = $mysqli->query($sqlUsersCall);
		$rUserInvCall=$QueryUsersCall->fetch_array();
		$shortacronym=$rUserInvCall['shortacronym'];
		if(!$id){$grantcallID=$rUserInvCall['grantID'];
		
		
		}
		if($id){$grantcallID=$id;
		}
		
	$sqlUsers3="SELECT * FROM ".$prefix."submissions_concepts order by conceptID desc limit 0,1";
		$QueryUsers3 = $mysqli->query($sqlUsers3);
		$totalUsers3 = $QueryUsers3->num_rows;
		$rUserInv3=$QueryUsers3->fetch_array();
		
if(!$totalUsers3){$serialBegin='0001';}
if($totalUsers3){
$NewserialBegin=$rUserInv3['conceptID']+1;


if($NewserialBegin>=0 and $NewserialBegin<=9)
{$serialBegin='000'.$NewserialBegin;}

if($NewserialBegin>=10 and $NewserialBegin<=99)
{$serialBegin='00'.$NewserialBegin;}

if($NewserialBegin>=100 and $NewserialBegin<=199)
{$serialBegin='0'.$NewserialBegin;}

if($NewserialBegin>=200 and $NewserialBegin<=9000000000)
{$serialBegin=$NewserialBegin;}

}
		//Assign Reference number
$mmCOnecpt=$rUserInv3['conceptID']+1;
$referenceNo="$shortacronym"."-".$grantcallID."-".date("Y")."-"."$serialBegin";
//$referenceNo="$shortacronym".date("Y").$rUserCategory['rstugshort1']."0".$mmCOnecpt;

$sqlUsers="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID'  and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();
			
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."submissions_concepts (`projectTitle`,`titleAcronym`,`relevantKeywords`,`researchTypeID`,`projectDurationID`,`updatedon`,`owner_id`,`projectCategory`,`projectStatus`,`is_sent`,`HostInstitution`,`rejectComents`,`finalSubmission`,`grantcallID`,`referenceNo`,`conceptm_Times`,`conceptm_Reviewers`,`category`,`invited_for_proposal`,`projectYears`,`creferences`,`updated`,`grant_adminID`,`dynamic`,`qn_OrchidID`,`gm`,`grantcallIDMain`,`TotalBudget`) 

values('$projectTitle','$titleAcronym','$relevantKeywords','$researchTypeID','$projectDurationID',now(),'$asrmApplctID','Concept','Pending Final Submission','0','$HostInstitution','','Pending Final Submission','$grantcallID','$referenceNo','0','0','concepts','notinvited',NULL,NULL,'no','$grant_adminID','Yes','$qn_OrchidID',NULL,NULL,'$TotalBudget')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new protocol");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=newconceptPrincipalInvestigator&id=$id'>";

}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update
	
$sqlA2="update ".$prefix."submissions_concepts set  `projectTitle`='$projectTitle',`titleAcronym`='$titleAcronym',`relevantKeywords`='$relevantKeywords',`researchTypeID`='$researchTypeID',`projectDurationID`='$projectDurationID',`HostInstitution`='$HostInstitution',`finalSubmission`='Pending Final Submission',`referenceNo`='$referenceNo',`qn_OrchidID`='$qn_OrchidID',`TotalBudget`='$TotalBudget' where owner_id='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlA2);

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=newconceptPrincipalInvestigator&id=$id'>";
	
}//end


if(!$record_id){$record_idm=$_POST['conceptID'];}
if($record_id){$record_idm=$record_id;}		
//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."concept_stages (`owner_id`,`conceptID`,`ProjectInformation`,`PrincipalInvestigator`,`Introduction`,`ProjectDetails`,`Budget`,`cReferences`,`dateCreated`,`status`,`grantcallID`,`dynamic`)  values('$asrmApplctID','$record_idm','1','0','0','0','0','0',now(),'new','$id','Yes')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `ProjectInformation`='1' where `owner_id`='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}

}//end post



if(isset($message)){echo $message;}
$asrmApplctID2=$usrm_id;
$sqlUsers2="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$usrm_id' and grantcallID='$id' order by conceptID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."concept_stages where  owner_id='$sessionusrm_id' and grantcallID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<div class="tab">
<?php require_once("dynamic_categories.php");?>

 <?php if($total_Information){?> <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newFirstInformation')" id="defaultOpen"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
  
 <?php if($total_Team){?> <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  

<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button><?php }?>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
<?php if($total_Attachments){?><button <?php if($rUConceptStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptAttachments&id=<?php echo $id;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>
  
  
  
</div>

<div id="newFirstInformation" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("concept_submit_now_final_button.php");?>
   
  <?php 
  $sqlDynamic="SELECT * FROM ".$prefix."concept_dynamic_questions_all_a where grantID='$id' and categorym='concept' order by id asc";
	$QueryDynamic = $mysqli->query($sqlDynamic);
	$rowsDynamic=$QueryDynamic->fetch_array();
	?>
   
  <h3><?php echo $lang_new_ProjectInformation;?></h3>
 
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="conceptID" value="<?php echo $rUserInv2['conceptID'];?>" >
 <div class="container"><!--begin-->
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>

<?php if($rowsDynamic['qn_title_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsDynamic['qn_title'];?> <span class="error">*</span></label>
      <input type="text" id="MyTextBox" name="projectTitle" placeholder="Give the title of your project.." class="requiredm" value="<?php echo $rUserInv2['projectTitle'];?>" required>
    </div>
  </div>
  <?php }?>
  
  
  <?php if($rowsDynamic['qn_acronym_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_acronym'];?> <span class="error">*</span></label>
      <input type="text" id="lname" name="titleAcronym" placeholder="Short Title or Acronym.." class="requiredm" maxlength="10"  value="<?php echo $rUserInv2['titleAcronym'];?>" required>
    </div>
  </div>
<?php }?>
  
  <?php if($rowsDynamic['qn_relevantKeywords_status']=='Enable'){?>
    <div class="row success">

    <div class="col-100">
     <label for="lname"><?php echo $rowsDynamic['qn_relevantKeywords'];?> <span class="error">*</span></label>
      <input type="text" id="MyTextBox2" name="relevantKeywords" placeholder=".." class="requiredm"  value="<?php echo $rUserInv2['relevantKeywords'];?>" required>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsDynamic['qn_researchTypeID_status']=='Enable'){?>
    <div class="row success">

    <div class="col-100">
     <label for="country"><?php echo $lang_new_researchTypeID;?><span class="error">*</span></label>
     
    <select id="country" name="researchTypeID" class="requiredm" required>
    <option value=""><?php echo $lang_please_select;?></option>
       <?php
$sqlCat = "SELECT * FROM ".$prefix."categories order by rstug_categoryName asc";
$queryCat = $mysqli->query($sqlCat);
while($rCat = $queryCat->fetch_array()){
?>
<option value="<?php echo $rCat['rstug_categoryID'];?>" <?php if($rCat['rstug_categoryID']==$rUserInv2['researchTypeID']){?>selected="selected"<?php }?>><?php echo $rCat['rstug_categoryName'];?></option>
<?php }?>
</select>
    </div>
  </div><?php }?>

  
  
  
  <?php if($rowsDynamic['qn_HostInstitution_status']=='Enable'){?>
   <div class="row success">

    <div class="col-100">
     <label for="lname"><?php echo $rowsDynamic['qn_HostInstitution'];?>   <span class="error">*</span></label>
      <input type="text" id="HostInstitution" name="HostInstitution" placeholder=".." class="requiredm"  value="<?php echo $rUserInv2['HostInstitution'];?>" required>
    </div>
  </div><?php }?>
  
  <?php if($rowsDynamic['qn_OrchidID_status']=='Enable'){?>
    <div class="row success">

    <div class="col-100">
     <label for="lname"><?php echo $rowsDynamic['qn_OrchidID'];?></label>
      <input type="text" id="MyTextBoxmmOCIDIDw" name="qn_OrchidID" placeholder=".." class="requiredm"  value="<?php echo $rUserInv2['qn_OrchidID'];?>" min="16" maxlength="16">
    </div>
  </div><?php }?>

  
  <?php if($rowsDynamic['qn_projectDurationID_status']=='Enable'){?>
     <div class="row success">

    <div class="col-100">
    <label for="country"><?php echo $lang_new_titleDurationtheproject;?> <span class="error">*</span></label>
      <select id="country" name="projectDurationID" class="requiredm" required>
       <?php
$sqlFeaturedCall = "SELECT * FROM ".$prefix."duration order by durationID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
while($rFeaturedCall = $queryFeaturedCall->fetch_array()){
?>
<option value="<?php echo $rFeaturedCall['durationID'];?>" <?php if($rFeaturedCall['durationID']==$rUserInv2['projectDurationID']){?>selected="selected"<?php }?>><?php echo $rFeaturedCall['duration'];?> <?php echo $rFeaturedCall['durationdesc'];?></option>
<?php }?>
      </select>
    </div>
  </div><?php }?>
  
  <div class="row success">

    <div class="col-100">
    <label for="lname"><strong><?php echo $lang_new_TotalBudgetCost;?></strong> </label><br />
    <input type="text" id="TotalBudget" name="TotalBudget" class="requiredm number"  value="<?php echo $rUserInv2['TotalBudget'];?>" required placeholder="input Total Budget Cost">
    </div>
    </div>
  

  <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="<?php echo $lang_SaveandNext;?>">
  </div>

</div><!--End-->
 
 
   </form>
 
 
 
</div>









<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>