<?php
if($_POST['doSaveData']=='Save and Next' and $_POST['projectID'] and $_POST['asrmApplctID']){

	function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
 $attachment = $session_user_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['AttachLetterofSupport']['name']));
$target = 'files/'. basename($session_user_id.preg_replace('/\s+/', '_', $_FILES['AttachLetterofSupport']['name']));
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
	
	
	$sqlUsers="SELECT * FROM ".$prefix."project_follow_up where `owner_id`='$asrmApplctID' and `is_sent`='0' order by projectID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."project_follow_up (`projectID`,`owner_id`,`resultExploitationPlan`,`resultInnovativeResults`,`resultIntellectualProperty`,`ethicalConsiderations`,`DealwithEthicalIssues`,`NeedEthicalClearance`,`NeedEthicalClearanceWhy`,`GenderYouth`,`YouthTakenccount`,`YoungResearchers`,`InterestGroups`,`StateNatureofSupport`,`AttachLetterofSupport`,`is_sent`) 

values('$projectID','$asrmApplctID','$resultExploitationPlan','$resultInnovativeResults','$resultIntellectualProperty','$ethicalConsiderations','$DealwithEthicalIssues','$NeedEthicalClearance','$NeedEthicalClearanceWhy','$GenderYouth','$YouthTakenccount','$YoungResearchers','$InterestGroups','$StateNatureofSupport','$attachment','0')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new protocol");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalFollowup'>";

}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update
if($_FILES['AttachLetterofSupport']['name']){
$sqlA2="update ".$prefix."project_follow_up set  `resultExploitationPlan`='$resultExploitationPlan',`resultInnovativeResults`='$resultInnovativeResults',`resultIntellectualProperty`='$resultIntellectualProperty',`ethicalConsiderations`='$ethicalConsiderations',`DealwithEthicalIssues`='$DealwithEthicalIssues',`NeedEthicalClearance`='$NeedEthicalClearance',`NeedEthicalClearanceWhy`='$NeedEthicalClearanceWhy',`GenderYouth`='$GenderYouth',`YouthTakenccount`='$YouthTakenccount',`YoungResearchers`='$YoungResearchers',`InterestGroups`='$InterestGroups',`StateNatureofSupport`='$StateNatureofSupport',`AttachLetterofSupport`='$attachment' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);
}

if(!$_FILES['AttachLetterofSupport']['name']){
$sqlA2="update ".$prefix."project_follow_up set  `resultExploitationPlan`='$resultExploitationPlan',`resultInnovativeResults`='$resultInnovativeResults',`resultIntellectualProperty`='$resultIntellectualProperty',`ethicalConsiderations`='$ethicalConsiderations',`DealwithEthicalIssues`='$DealwithEthicalIssues',`NeedEthicalClearance`='$NeedEthicalClearance',`NeedEthicalClearanceWhy`='$NeedEthicalClearanceWhy',`GenderYouth`='$GenderYouth',`YouthTakenccount`='$YouthTakenccount',`YoungResearchers`='$YoungResearchers',`InterestGroups`='$InterestGroups',`StateNatureofSupport`='$StateNatureofSupport' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);
}

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalFollowup'>";
	
}//end


if(!$record_id){$record_idm=$_POST['projectID'];}
if($record_id){$record_idm=$record_id;}		
//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."project_stages (`owner_id`,`projectID`,`ProjectInformation`,`Background`,`Methodology`,`ProjectResults`,`ResearchTeam`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`)  values('$asrmApplctID','$record_idm','1','0','0','0','0','0','1','0',now(),'new')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `Followup`='1' where `owner_id`='$asrmApplctID' and status='new'";
$mysqli->query($sqlASubmissionStages);
}

}//end post



if(isset($message)){echo $message;}
$asrmApplctID2=$usrm_id;

$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();
$sqlUsers2="SELECT * FROM ".$prefix."project_follow_up where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<div class="tab">

  <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitProposal&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  
  <button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalResearchTeam&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBackground&id=<?php echo $id;?>'"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalMethodology&id=<?php echo $id;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalResults&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectResults;?></button>
  
  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalManagement&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'proposalFollowup')" id="defaultOpen"><?php echo $lang_new_ProjectFollowup;?></button>
  
</div>

<div id="proposalFollowup" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("proposal_submit_now_final_button.php");?>
   
    
  <h3>Follow-up on project results (max. 500 words):</h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Sketch out a result exploitation plan in line with the Research Impact Pathway which explains:<br />
a) How the new knowledge generated through the project and other deliverables of the project will be exploited after the project duration;
 <span class="error">*</span></label>
<textarea id="MyTextBox10" name="resultExploitationPlan" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['resultExploitationPlan'];?></textarea>
    </div>
  </div>

  <div class="row success">

    <div class="col-100">
    <label for="fname">b) If relevant: how innovative results will be further exploited through an implementation plan for the project results/innovations;
 <span class="error">*</span></label>
<textarea id="MyTextBox11" name="resultInnovativeResults" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['resultInnovativeResults'];?></textarea>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="fname">c) How intellectual property, including foreground knowledge, patents, copyrights, license agreements and any other arrangements will be managed.
 <span class="error">*</span></label>
<textarea id="MyTextBox14" name="resultIntellectualProperty" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['resultIntellectualProperty'];?></textarea>
    </div>
  </div>

  <div class="row success">

    <div class="col-100">
    <label for="fname">What ethical considerations are foreseen in the project?<span class="error">*</span></label>
<textarea id="MyTextBox13" name="ethicalConsiderations" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['ethicalConsiderations'];?></textarea>
    </div>
  </div>


    <div class="row success">

    <div class="col-100">
    <label for="fname">Clearly explain the way(s) in which the project intends to deal with ethical issues that may be associatedidentified above <span class="error">*</span></label>
<textarea id="MyTextBoxmm300" name="DealwithEthicalIssues" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['DealwithEthicalIssues'];?></textarea>
    </div>
  </div>
  
 <div class="row success">

    <div class="col-100">
    <label for="fname">Does the project intend to obtain ethical clearance from the sectoral research regulators and the UNCST? Yes/No If no, Why?<span class="error">*</span> <input name="NeedEthicalClearance" type="radio" value="No"  onChange="getWhyNoEthicalClearence(this.value)" <?php if($rUserInv2['PartofInternationalProject']=='No'){?>checked="checked"<?php }?>/> No <input name="NeedEthicalClearance" type="radio" value="Yes"  onChange="getWhyNoEthicalClearence(this.value)" <?php if($rUserInv2['PartofInternationalProject']=='Yes'){?>checked="checked"<?php }?>/> Yes</label> 
    
    
<div id="projectwhyNoNeedEthicalCliarence"><?php if($rUserInv2['NeedEthicalClearance']=='No'){?>   
<textarea id="NeedEthicalClearanceWhy" name="NeedEthicalClearanceWhy" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['NeedEthicalClearanceWhy'];?></textarea><?php }?></div>

    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Gender and the inclusion of youth, young researchers and other special interest groups. (max. 500 words)<br />
a) Explain how gender and other special interest group  considerations are taken into account in the project and provide a gender  approach.
<span class="error">*</span></label>
<textarea id="MyTextBoxmm3001" name="GenderYouth" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['GenderYouth'];?></textarea>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">b) Explain how youth is taken into account in the  project.
<span class="error">*</span></label>
<textarea id="MyTextBoxmm3002" name="GenderYouth" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['YouthTakenccount'];?></textarea>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">c) Explain how young researchers and their capacity  development are supported through the project activities.
<span class="error">*</span></label>
<textarea id="MyTextBox3" name="YoungResearchers" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['YoungResearchers'];?></textarea>
    </div>
  </div>
  
     <div class="row success">

    <div class="col-100">
    <label for="fname">d) Explain how other interest groups are taken into  account in the project.
<span class="error">*</span></label>
<textarea id="MyTextBox7" name="InterestGroups" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['InterestGroups'];?></textarea>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">State Nature of support provided by the host institution. 
<span class="error">*</span></label>
<textarea id="MyTextBox6" name="StateNatureofSupport" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['StateNatureofSupport'];?></textarea>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Attach a letter of support from the host institution <span class="error">(pdf only)</span>
<span class="error">*</span></label>
<?php if($rUserInv2['AttachLetterofSupport']){?>
<input name="AttachLetterofSupport" type="file" id="AttachLetterofSupport"/>

<br /><a href="./files/<?php echo $rUserInv2['AttachLetterofSupport'];?>" target="_blank"><strong>Attach a letter of support</strong></a><?php }?>

<?php if(!$rUserInv2['AttachLetterofSupport']){?>
<input name="AttachLetterofSupport" type="file" class="required" id="AttachLetterofSupport" required/>
<?php }?>
    </div>
  </div>
  

  
  <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="Save and Next">
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