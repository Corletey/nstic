<?php
$conceptID=$_GET['conceptID'];
if($_POST['doSaveData'] and $_POST['projectID'] and $_POST['asrmApplctID'] and $id){

	function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
 $attachment = $session_user_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['AttachLetterofSupport']['name']));
$target = './files/'. basename($session_user_id.preg_replace('/\s+/', '_', $_FILES['AttachLetterofSupport']['name']));
$research_attachment = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['AttachLetterofSupport']['tmp_name']), $target);
$extension = getExtension($attachment);
$extension = strtolower($extension);

	$resultExploitationPlan=$mysqli->real_escape_string($_POST['resultExploitationPlan']);
	$resultInnovativeResults=$mysqli->real_escape_string($_POST['resultInnovativeResults']);
	$resultIntellectualProperty=$mysqli->real_escape_string($_POST['resultIntellectualProperty']);
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$relevantKeywords=$mysqli->real_escape_string($_POST['relevantKeywords']);
	$ethicalConsiderations=$mysqli->real_escape_string($_POST['ethicalConsiderations']);
	$DealwithEthicalIssues=$mysqli->real_escape_string($_POST['DealwithEthicalIssues']);
	$NeedEthicalClearance=$mysqli->real_escape_string($_POST['NeedEthicalClearance']);
	$NeedEthicalClearanceWhy=$mysqli->real_escape_string($_POST['NeedEthicalClearanceWhy']);
	$GenderYouth=$mysqli->real_escape_string($_POST['GenderYouth']);
	$StateNatureofSupport=$mysqli->real_escape_string($_POST['StateNatureofSupport']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$YouthTakenccount=$mysqli->real_escape_string($_POST['YouthTakenccount']);
	$YoungResearchers=$mysqli->real_escape_string($_POST['YoungResearchers']);
	$InterestGroups=$mysqli->real_escape_string($_POST['InterestGroups']);
	
	
	$sqlUsers="SELECT * FROM ".$prefix."project_follow_up where `owner_id`='$asrmApplctID' and `grantID`='$id' order by projectID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."project_follow_up (`projectID`,`owner_id`,`resultExploitationPlan`,`resultInnovativeResults`,`resultIntellectualProperty`,`ethicalConsiderations`,`DealwithEthicalIssues`,`NeedEthicalClearance`,`NeedEthicalClearanceWhy`,`GenderYouth`,`YouthTakenccount`,`YoungResearchers`,`InterestGroups`,`StateNatureofSupport`,`AttachLetterofSupport`,`is_sent`,`grantID`) 

values('$projectID','$asrmApplctID','$resultExploitationPlan','$resultInnovativeResults','$resultIntellectualProperty','$ethicalConsiderations','$DealwithEthicalIssues','$NeedEthicalClearance','$NeedEthicalClearanceWhy','$GenderYouth','$YouthTakenccount','$YoungResearchers','$InterestGroups','$StateNatureofSupport','$attachment','0','$id')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new protocol");

/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newProposalAttachments&id=$id&categoryID=$categoryID&conceptID=$conceptID;</script>");*/

}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update
if($_FILES['AttachLetterofSupport']['name']){
$sqlA2="update ".$prefix."project_follow_up set  `resultExploitationPlan`='$resultExploitationPlan',`resultInnovativeResults`='$resultInnovativeResults',`resultIntellectualProperty`='$resultIntellectualProperty',`ethicalConsiderations`='$ethicalConsiderations',`DealwithEthicalIssues`='$DealwithEthicalIssues',`NeedEthicalClearance`='$NeedEthicalClearance',`NeedEthicalClearanceWhy`='$NeedEthicalClearanceWhy',`GenderYouth`='$GenderYouth',`YouthTakenccount`='$YouthTakenccount',`YoungResearchers`='$YoungResearchers',`InterestGroups`='$InterestGroups',`StateNatureofSupport`='$StateNatureofSupport',`AttachLetterofSupport`='$attachment' where owner_id='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlA2);
}

if(!$_FILES['AttachLetterofSupport']['name']){
$sqlA2="update ".$prefix."project_follow_up set  `resultExploitationPlan`='$resultExploitationPlan',`resultInnovativeResults`='$resultInnovativeResults',`resultIntellectualProperty`='$resultIntellectualProperty',`ethicalConsiderations`='$ethicalConsiderations',`DealwithEthicalIssues`='$DealwithEthicalIssues',`NeedEthicalClearance`='$NeedEthicalClearance',`NeedEthicalClearanceWhy`='$NeedEthicalClearanceWhy',`GenderYouth`='$GenderYouth',`YouthTakenccount`='$YouthTakenccount',`YoungResearchers`='$YoungResearchers',`InterestGroups`='$InterestGroups',`StateNatureofSupport`='$StateNatureofSupport' where owner_id='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlA2);
}

/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newProposalAttachments&id=$id&categoryID=$categoryID&conceptID=$conceptID';</script>");*/
	
}//end


if(!$record_id){$record_idm=$_POST['projectID'];}
if($record_id){$record_idm=$record_id;}		
//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and grantID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."project_stages (`owner_id`,`projectID`,`ProjectInformation`,`Background`,`Methodology`,`ProjectResults`,`ResearchTeam`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`,`grantID`)  values('$asrmApplctID','$record_idm','1','0','0','0','0','0','1','0',now(),'new','$id')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `Followup`='1' where `owner_id`='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlASubmissionStages);
}

}//end post



if(isset($message)){echo $message;}
$asrmApplctID2=$usrm_id;

$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `grantcallID`='$id' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();
$sqlUsers2="SELECT * FROM ".$prefix."project_follow_up where `owner_id`='$usrm_id' and `grantID`='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<?php
require("dynamic_categories.php");

?>
<div class="tab">

 
<?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newSubmitProposal&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectInformation;?> </button><?php }?>

<?php if($total_Team){?><button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newproposalResearchTeam&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button><?php }?>
  
<?php if($total_Background){?><button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalBackground&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Background;?> </button><?php }?>
  
<?php if($total_Methodology){?><button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalMethodology&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button><?php }?>
    
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalBudget&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
    
    
    
<?php if($total_Results){?><button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalResults&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectResults;?></button><?php }?>
     
<?php if($total_Management){?><button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalManagement&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectManagement;?></button><?php }?>
    
<?php if($total_Followup){?><button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newproposalFollowup')" id="defaultOpen"><?php echo $lang_new_ProjectFollowup;?></button><?php }?>
   
<?php if($total_Attachments){?><button <?php if($rUConceptStages['attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newProposalAttachments&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ResearchAttachments;?></button><?php }?>

   
<?php if($total_Citations){?> <button <?php if($rUConceptStages['citations']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newProposalReferences&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
</div>

<div id="newproposalFollowup" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("proposal_submit_now_final_button.php");?>
   
    
  <h3><?php echo $lang_new_ProjectFollowup;?></h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

 <?php
$sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_i where grantID='$id' and categorym='proposal' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
?> 
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  
  <?php if($rowsSubmitted_c['resultExploitationPlan_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['resultExploitationPlan'];?>
 <span class="error">*</span></label>
<textarea id="MyTextBox10" name="resultExploitationPlan" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['resultExploitationPlan'];?></textarea>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['resultExploitationPlan_status']){?>

  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['resultInnovativeResults'];?>
 <span class="error">*</span></label>
<textarea id="MyTextBox11" name="resultInnovativeResults" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['resultInnovativeResults'];?></textarea>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['resultIntellectualProperty_status']){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['resultIntellectualProperty'];?>
 <span class="error">*</span></label>
<textarea id="MyTextBox14" name="resultIntellectualProperty" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['resultIntellectualProperty'];?></textarea>
    </div>
  </div><?php }?>

<?php if($rowsSubmitted_c['ethicalConsiderations_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ethicalConsiderations'];?><span class="error">*</span></label>
<textarea id="MyTextBox13" name="ethicalConsiderations" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['ethicalConsiderations'];?></textarea>
    </div>
  </div><?php }?>

<?php if($rowsSubmitted_c['DealwithEthicalIssues_status']){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['DealwithEthicalIssues'];?><span class="error">*</span></label>
<textarea id="MyTextBoxmm300" name="DealwithEthicalIssues" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['DealwithEthicalIssues'];?></textarea>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['DealwithEthicalIssues_status']){?>
<div class="row success">
  <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['NeedEthicalClearance'];?><span class="error">*</span>
      <input name="NeedEthicalClearance" type="radio" value="No" onChange="getWhyNoEthicalClearence(this.value)" <?php if($rUserInv2['NeedEthicalClearance']=='No'){?>checked="checked"<?php }?>/> <?php echo $lang_No;?>
      <input name="NeedEthicalClearance" type="radio" value="Yes" onChange="getWhyNoEthicalClearence(this.value)" <?php if($rUserInv2['NeedEthicalClearance']=='Yes'){?>checked="checked"<?php }?>/> <?php echo $lang_Yes;?>
    </label> 
    
    <div id="projectwhyNoNeedEthicalCliarence" <?php if($rUserInv2['NeedEthicalClearance']!='No'){?>style="display:none;"<?php }?>>   
      <textarea id="NeedEthicalClearanceWhy" name="NeedEthicalClearanceWhy" placeholder="" style="height:150px" class="required" <?php if($rUserInv2['NeedEthicalClearance']=='No'){?>required<?php }?>><?php echo $rUserInv2['NeedEthicalClearanceWhy'];?></textarea>
    </div>
  </div>
</div>
<?php }?>
  
  <?php if($rowsSubmitted_c['GenderYouth_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['GenderYouth'];?>
<span class="error">*</span></label>
<textarea id="MyTextBoxmm3001" name="GenderYouth" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['GenderYouth'];?></textarea>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['YoungResearchers_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['YoungResearchers'];?>
<span class="error">*</span></label>
<textarea id="MyTextBoxmm3002" name="YouthTakenccount" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['YouthTakenccount'];?></textarea>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['InterestGroups_status']){?>
     <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['InterestGroups'];?>
<span class="error">*</span></label>
<textarea id="MyTextBox7" name="InterestGroups" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['InterestGroups'];?></textarea>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['StateNatureofSupport_status']){?>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['StateNatureofSupport'];?>
<span class="error">*</span></label>
<textarea id="MyTextBox6" name="StateNatureofSupport" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['StateNatureofSupport'];?></textarea>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['AttachLetterofSupport_status']){?>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['AttachLetterofSupport'];?> <span class="error">(<?php echo $lang_FilePDF;?>)</span>
<span class="error">*</span></label>
<?php if($rUserInv2['AttachLetterofSupport']){?>
<input name="AttachLetterofSupport" type="file" id="AttachLetterofSupport"/>

<br /><a href="./files/<?php echo $rUserInv2['AttachLetterofSupport'];?>" target="_blank"><strong><?php echo $lang_ViewAttachment;?></strong></a><?php }?>

<?php if(!$rUserInv2['AttachLetterofSupport']){?>
<input name="AttachLetterofSupport" type="file" class="required" id="AttachLetterofSupport" required/>
<?php }?>
    </div>
  </div><?php }?>
  

  
  <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="<?php echo $lang_new_Save;?>">
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

function getWhyNoEthicalClearence(val) {
  if(val=='No') {
    document.getElementById('projectwhyNoNeedEthicalCliarence').style.display='block';
    document.getElementById('NeedEthicalClearanceWhy').required = true;
  } else {
    document.getElementById('projectwhyNoNeedEthicalCliarence').style.display='none';
    document.getElementById('NeedEthicalClearanceWhy').required = false;
  }
}
</script>