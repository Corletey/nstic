<?php
$grantID=$_GET['grantID'];

if(!$_GET['grantID']){
echo '<meta http-equiv="refresh" content="0; url='.$base_url.'main.php?option=dashboard&id="'.$grantID.'"" />';	
}

$wmOwner="select * from ".$prefix."submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_proposals where  owner_id='$owner_id' and status='new' and reviewer_id='$usrm_id' and projectID='$id' and grantID='$grantID'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_proposals  set `Background`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$usrm_id' and projectID='$id' and grantID='$grantID'";
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

<?php
require("dynamic_categories_review.php");
?>
<div class="tab">

<?php if($total_Information){?><button <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewPrososal&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
  
<?php if($total_Team){?><button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewProjectTeam&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button><?php }?> 
  
<?php if($total_Background){?><button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newreviewproposalBackground')" id="defaultOpen"><?php echo $lang_new_Background;?> </button><?php }?>
  
  
<?php if($total_Methodology){?><button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalMethodology&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button><?php }?>
    
    
<?php if($total_Budget){?><button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
    
<?php if($total_Results){?><button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button><?php }?>
  
  <?php if($total_Management){?><button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button><?php }?>
  
<?php if($total_Followup){?><button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button><?php }?>
  
 <?php if($total_Citations){?> <button <?php if($rProjectStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalReferences&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
  <?php if($total_Attachments){?><button <?php if($rProjectStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalAttachments&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>
 
  
   
  
</div>

<div id="newreviewproposalBackground" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>    
    
  <h3><?php echo $lang_new_Background;?> </h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>

 <?php
$sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_g where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
?> 

<?php if($rowsSubmitted_c['SummaryAudience_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['SummaryAudience'];?><span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['SummaryAudience'];?></strong>
    </div>
  </div><?php }?>


<?php if($rowsSubmitted_c['explanationObjectives_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['explanationObjectives'];?><span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['explanationObjectives'];?></strong>
    </div>
  </div><?php }?>

<?php if($rowsSubmitted_c['researchInnovationIssues_status']){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['researchInnovationIssues'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['researchInnovationIssues'];?></strong>
    </div>
  </div><?php }?>
  
<?php if($rowsSubmitted_c['NovelCharacterScientificResearch_status']){?>
 <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['NovelCharacterScientificResearch'];?><span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['NovelCharacterScientificResearch'];?></strong>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['ClearJustificationDemonstration_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ClearJustificationDemonstration'];?> <span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['ClearJustificationDemonstration'];?></strong>
    </div><?php }?>
  </div>
  
  
  <?php if($rowsSubmitted_c['interdisciplinaryTransdisciplinary_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['interdisciplinaryTransdisciplinary'];?> <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['interdisciplinaryTransdisciplinary'];?></strong>
    </div>
  </div><?php }?>
  
 
 <?php if($rowsSubmitted_c['addedValue_status']){?> 
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['addedValue'];?> <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['addedValue'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['ImportanceResearchInnovation_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ImportanceResearchInnovation'];?> <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['ImportanceResearchInnovation'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['PartofInternationalProject_status']){?>
  <div class="row success">

    <div class="col-100">
     <label for="lname"><?php echo $rowsSubmitted_c['PartofInternationalProject'];?> <span class="error">*</span><br />
  
      <input name="PartofInternationalProject" type="radio" value="No"  onChange="getProjectSpecificActivities(this.value)" <?php if($rUserInv2['PartofInternationalProject']=='No'){?>checked="checked"<?php }?>/> <?php echo $lang_No;?><br />
     <input name="PartofInternationalProject" type="radio" value="Yes"  onChange="getProjectSpecificActivities(this.value)" <?php if($rUserInv2['PartofInternationalProject']=='Yes'){?>checked="checked"<?php }?>/> <?php echo $lang_Yes;?>
     </label>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['projectSpecificActivities_status']){?>
  
   <div class="row success">

    <div class="col-100">
    
    <div id="projectSpecificActivities">
<?php if($rUserInv2['projectSpecificActivities']){?>
<label for="fname"><?php echo $rowsSubmitted_c['projectSpecificActivities'];?> <span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['projectSpecificActivities'];?></strong><?php }?>
    </div>
    

    </div>
  </div><?php }?>

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