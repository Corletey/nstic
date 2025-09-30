<?php
if($_POST['doSaveData']=='Save' and $_POST['Surname'] and $_POST['asrmApplctID']){

	
	$Surname=$mysqli->real_escape_string($_POST['Surname']);
	$Othername=$mysqli->real_escape_string($_POST['Othername']);
	$Gender=$mysqli->real_escape_string($_POST['Gender']);
	$AgeRange=$mysqli->real_escape_string($_POST['AgeRange']);
	$<?php echo $lang_Contacts;?>=$mysqli->real_escape_string($_POST['<?php echo $lang_Contacts;?>']);
	$<?php echo $lang_Expertise;?>=$mysqli->real_escape_string($_POST['<?php echo $lang_Expertise;?>']);
	$EducationalBackground=$mysqli->real_escape_string($_POST['EducationalBackground']);
	$Qualifications=$mysqli->real_escape_string($_POST['Qualifications']);
	$ResearchExperience=$mysqli->real_escape_string($_POST['ResearchExperience']);
	$RoleofTeamMember=$mysqli->real_escape_string($_POST['RoleofTeamMember']);
	$InstitutionofAffiliation=$mysqli->real_escape_string($_POST['InstitutionofAffiliation']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$sqlUsers="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$asrmApplctID' and `Surname`='$Surname' and `is_sent`='0' order by piID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and `is_sent`='0' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."principal_investigators (`conceptm_id`,`owner_id`,`Surname`,`Othername`,`Gender`,`AgeRange`,`<?php echo $lang_Contacts;?>`,`<?php echo $lang_Expertise;?>`,`EducationalBackground`,`Qualifications`,`ResearchExperience`,`RoleofTeamMember`,`InstitutionofAffiliation`,`updatedon`,`is_sent`) 

values('$conceptm_id','$asrmApplctID','$Surname','$Othername','$Gender','$AgeRange','$<?php echo $lang_Contacts;?>','$<?php echo $lang_Expertise;?>','$EducationalBackground','$Qualifications','$ResearchExperience','$RoleofTeamMember','$InstitutionofAffiliation',now(),'0')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;
}
}//end post
?>

<?php
if($_POST['doSaveData']=='Save and Next' and $_POST['projectID'] and $_POST['asrmApplctID']){

	
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$SummaryAudience=$mysqli->real_escape_string($_POST['SummaryAudience']);
	$explanationObjectives=$mysqli->real_escape_string($_POST['explanationObjectives']);
	$researchInnovationIssues=$mysqli->real_escape_string($_POST['researchInnovationIssues']);
	$NovelCharacterScientificResearch=$mysqli->real_escape_string($_POST['NovelCharacterScientificResearch']);
	$ClearJustificationDemonstration=$mysqli->real_escape_string($_POST['ClearJustificationDemonstration']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$interdisciplinaryTransdisciplinary=$mysqli->real_escape_string($_POST['interdisciplinaryTransdisciplinary']);
	$addedValue=$mysqli->real_escape_string($_POST['addedValue']);
	$ImportanceResearchInnovation=$mysqli->real_escape_string($_POST['ImportanceResearchInnovation']);
	$PartofInternationalProject=$mysqli->real_escape_string($_POST['PartofInternationalProject']);
	$projectSpecificActivities =$mysqli->real_escape_string($_POST['projectSpecificActivities']);
	
	$sqlUsers="SELECT * FROM ".$prefix."project_background where `owner_id`='$asrmApplctID' and `is_sent`='0' order by projectID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."project_background (`projectID`,`owner_id`,`SummaryAudience`,`explanationObjectives`,`researchInnovationIssues`,`NovelCharacterScientificResearch`,`ClearJustificationDemonstration`,`interdisciplinaryTransdisciplinary`,`addedValue`,`ImportanceResearchInnovation`,`PartofInternationalProject`,`projectSpecificActivities`,`is_sent`) 

values('$projectID','$asrmApplctID','$SummaryAudience','$explanationObjectives','$researchInnovationIssues','$NovelCharacterScientificResearch','$ClearJustificationDemonstration','$interdisciplinaryTransdisciplinary','$addedValue','$ImportanceResearchInnovation','$PartofInternationalProject','$projectSpecificActivities','0')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new protocol");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalMethodology'>";

}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update
	
$sqlA2="update ".$prefix."project_background set  `SummaryAudience`='$SummaryAudience',`explanationObjectives`='$explanationObjectives',`researchInnovationIssues`='$researchInnovationIssues',`NovelCharacterScientificResearch`='$NovelCharacterScientificResearch',`ClearJustificationDemonstration`='$ClearJustificationDemonstration',`interdisciplinaryTransdisciplinary`='$interdisciplinaryTransdisciplinary',`addedValue`='$addedValue',`ImportanceResearchInnovation`='$ImportanceResearchInnovation',`PartofInternationalProject`='$PartofInternationalProject',`projectSpecificActivities`='$projectSpecificActivities' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalMethodology'>";
	
}//end


if(!$record_id){$record_idm=$_POST['projectID'];}
if($record_id){$record_idm=$record_id;}		
//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."project_stages (`owner_id`,`projectID`,`ProjectInformation`,`Background`,`Methodology`,`ProjectResults`,`ResearchTeam`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`)  values('$asrmApplctID','$record_idm','1','1','0','0','0','0','0','0',now(),'new')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `Background`='1' where `owner_id`='$asrmApplctID' and status='new'";
$mysqli->query($sqlASubmissionStages);
}

}//end post



if(isset($message)){echo $message;}
$asrmApplctID2=$usrm_id;
$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();

$sqlUsers2="SELECT * FROM ".$prefix."project_background where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<div class="tab">

  <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitProposal/<?php echo $id;?>/'"><?php echo $lang_new_ProjectInformation;?></button>
  
  <button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalResearchTeam/<?php echo $id;?>/'"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'proposalBackground')" id="defaultOpen"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalMethodology/<?php echo $id;?>/'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBudget/<?php echo $id;?>/'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalResults/<?php echo $id;?>/'"><?php echo $lang_new_ProjectResults;?></button>

  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalManagement/<?php echo $id;?>/'"><?php echo $lang_new_ProjectManagement;?></button>
  
  
  <button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalFollowup/<?php echo $id;?>/'"><?php echo $lang_new_ProjectFollowup;?></button>
  
</div>

<div id="proposalBackground" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("proposal_submit_now_final_button.php");?>
   
    
  <h3>Background, Questions and Objectives </h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Summary for a broader audience (max. 350 words)-Summarize the main questions and/or approach and objectives; give a short description of the activities and expected results of the project.  <span class="error">*</span></label>
<textarea id="MyTextBox11" name="SummaryAudience" placeholder="Summary for a broader audience.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['SummaryAudience'];?></textarea>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="fname">Background, Questions and Objectives (max. 2500 words) <br />
Provide a detailed explanation of the objectives of the project within the context of the state-of-the art of the scientific area related to the project:<span class="error">*</span></label>
<textarea id="MyTextBox2500" name="explanationObjectives" placeholder="" style="height:150px" class="requiredm" required><?php echo $rUserInv2['explanationObjectives'];?></textarea>
    </div>
  </div>


    <div class="row success">

    <div class="col-100">
    <label for="fname">Present the research and/or innovation issues the project intends to address within the framework of the relevant thematic scope.<span class="error">*</span></label>
<textarea id="MyTextBox14" name="researchInnovationIssues" placeholder="" style="height:150px" class="requiredm" required><?php echo $rUserInv2['researchInnovationIssues'];?></textarea>
    </div>
  </div>
  
 <div class="row success">

    <div class="col-100">
    <label for="fname">Explain the novel character of the scientific research proposed (statement of originality) and describe the present state-of-the-art concerning the specific topics of the project. Show how the project aims at significant advances in the state-of-the-art through extending the current knowledge and/or filling the gaps identified.<span class="error">*</span></label>
<textarea id="MyTextBoxmm3001" name="NovelCharacterScientificResearch" placeholder="" style="height:150px" class="requiredm" required><?php echo $rUserInv2['NovelCharacterScientificResearch'];?></textarea>
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Clear justification demonstration/illustration of the projects' research and development (R&D) that has gone beyond proof of concept with a working prototype. <span class="error">*</span></label>
<textarea id="MyTextBox13" name="ClearJustificationDemonstration" placeholder="" style="height:150px" class="requiredm" required><?php echo $rUserInv2['ClearJustificationDemonstration'];?></textarea>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Highlight the interdisciplinary and transdisciplinary character of the project and explain how its added value is to be exploited and is best suited to address the challenges identified in the call for proposals. <span class="error">*</span></label>
<textarea id="MyTextBox3" name="interdisciplinaryTransdisciplinary" placeholder="" style="height:150px" class="requiredm" required><?php echo $rUserInv2['interdisciplinaryTransdisciplinary'];?></textarea>
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">State and Explain the added value and effect of existing collaborative approaches and partnerships on the challenges identified in the project. <span class="error">*</span></label>
<textarea id="MyTextBox7" name="addedValue" placeholder="" style="height:150px" class="requiredm" required><?php echo $rUserInv2['addedValue'];?></textarea>
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Explain the relevance and importance of the research and innovation proposed, in terms of applications/use (new products, services, processes, social innovations) and/or in terms of economic and societal impact.. <span class="error">*</span></label>
<textarea id="MyTextBox10" name="ImportanceResearchInnovation" placeholder="" style="height:150px" class="requiredm" required><?php echo $rUserInv2['ImportanceResearchInnovation'];?></textarea>
    </div>
  </div>
  
  
  
  <div class="row success">

    <div class="col-100">
     <label for="lname">Is the proposal part of a larger national or international project? Yes/No? <span class="error">*</span><br />
  
      <input name="PartofInternationalProject" type="radio" value="No"  onChange="getProjectSpecificActivities(this.value)" <?php if($rUserInv2['PartofInternationalProject']=='No'){?>checked="checked"<?php }?>/> No<br />
     <input name="PartofInternationalProject" type="radio" value="Yes"  onChange="getProjectSpecificActivities(this.value)" <?php if($rUserInv2['PartofInternationalProject']=='Yes'){?>checked="checked"<?php }?>/> Yes
     </label>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    
    <div id="projectSpecificActivities">
<?php if($rUserInv2['projectSpecificActivities']){?>
<label for="fname">Explain the project specific activities and how it context addresses the interests of this call. <span class="error">*</span></label>
<textarea id="MyTextBox11" name="projectSpecificActivities" placeholder="" style="height:150px" class="requiredm" required><?php echo $rUserInv2['projectSpecificActivities'];?></textarea><?php }?>
    </div>
    

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