<?php
$grantID=$_GET['grantID'];
$wmOwner="select * from ".$prefix."submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_proposals where  owner_id='$owner_id' and status='new' and reviewer_id='$usrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_proposals  set `Background`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}
}


$usrm_id=$rowner['owner_id'];

$sqlUsers2="SELECT * FROM ".$prefix."project_background where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$wm33="select * from ".$prefix."review_proposals where  owner_id='$owner_id' and status='new' and reviewer_id='$usrm_id'";
$cmdwb33 = $mysqli->query($wm33);
$r33= $cmdwb33->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$usrm_idowner=$rowner['owner_id'];
$wProjectStages="select * from ".$prefix."review_proposals where reviewer_id='$sessionusrm_id' and owner_id='$usrm_idowner'  and projectID='$id'";
$cmProjectStages = $mysqli->query($wProjectStages);
$rProjectStages=$cmProjectStages->fetch_array();
?>
<div class="tab">

  <button  <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewPrososal&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  
  <button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewProjectTeam&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewproposalBackground')" id="defaultOpen"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalMethodology&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button>

  <button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
  
</div>

<div id="reviewproposalBackground" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>    
    
  <h3>Background, Questions and Objectives </h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Summary for a broader audience (max. 350 words)-Summarize the main questions and/or approach and objectives; give a short description of the activities and expected results of the project.  <span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['SummaryAudience'];?></strong>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="fname">Background, Questions and Objectives (max. 2500 words) <br />
Provide a detailed explanation of the objectives of the project within the context of the state-of-the art of the scientific area related to the project:<span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['explanationObjectives'];?></strong>
    </div>
  </div>


    <div class="row success">

    <div class="col-100">
    <label for="fname">Present the research and/or innovation issues the project intends to address within the framework of the relevant thematic scope.<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['researchInnovationIssues'];?></strong>
    </div>
  </div>
  
 <div class="row success">

    <div class="col-100">
    <label for="fname">Explain the novel character of the scientific research proposed (statement of originality) and describe the present state-of-the-art concerning the specific topics of the project. Show how the project aims at significant advances in the state-of-the-art through extending the current knowledge and/or filling the gaps identified.<span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['NovelCharacterScientificResearch'];?></strong>
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Clear justification demonstration/illustration of the projects' research and development (R&D) that has gone beyond proof of concept with a working prototype. <span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['ClearJustificationDemonstration'];?></strong>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Highlight the interdisciplinary and transdisciplinary character of the project and explain how its added value is to be exploited and is best suited to address the challenges identified in the call for proposals. <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['interdisciplinaryTransdisciplinary'];?></strong>
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">State and Explain the added value and effect of existing collaborative approaches and partnerships on the challenges identified in the project. <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['addedValue'];?></strong>
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Explain the relevance and importance of the research and innovation proposed, in terms of applications/use (new products, services, processes, social innovations) and/or in terms of economic and societal impact.. <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['ImportanceResearchInnovation'];?></strong>
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
<label for="fname">Explain the project specific activities and how it context addresses the interests of this call. <span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['projectSpecificActivities'];?></strong><?php }?>
    </div>
    

    </div>
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