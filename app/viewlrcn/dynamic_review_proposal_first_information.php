<?php
$grantID=$_GET['grantID'];
$wmOwner="select * from ".$prefix."submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_proposals where  owner_id='$owner_id' and reviewer_id='$usrm_id' and projectID='$id' and grantID='$grantID' order by id desc limit 0,1";//and status='new' 
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_proposals  set `ProjectInformation`='1' where `owner_id`='$owner_id' and reviewer_id='$usrm_id' and  projectID='$id' and grantID='$grantID'";
$mysqli->query($sqlASubmissionStages);
}
if(!$totalStages and $session_usertype!='user'){
$sqlASubmissionStages="insert into ".$prefix."review_proposals (`owner_id`,`projectID`,`ProjectInformation`,`PrincipalInvestigator`,`Background`,`Methodology`,`ProjectResults`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`,`reviewer_id`,`grantID`)  values('$owner_id','$id','1','0','0','0','0','0','0','0',now(),'new','$usrm_id','$grantID')";
$mysqli->query($sqlASubmissionStages);
}

}

$usrm_id=$rowner['owner_id'];
$sqlUsers2="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();

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

<?php if($total_Information){?><button <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newreviewPrososal')" id="defaultOpen"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
  
<?php if($total_Team){?><button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewProjectTeam&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button><?php }?> 
  
<?php if($total_Background){?><button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalBackground&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Background;?> </button><?php }?>
  
  
<?php if($total_Methodology){?><button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalMethodology&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button><?php }?>
    
    
<?php if($total_Budget){?><button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
    
<?php if($total_Results){?><button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button><?php }?>
  
<?php if($total_Management){?><button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button><?php }?>
  
  
<?php if($total_Followup){?> <button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button><?php }?>
  
  
 <?php if($total_Citations){?> <button <?php if($rProjectStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalReferences&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
  <?php if($total_Attachments){?><button <?php if($rProjectStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalAttachments&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>
  
</div>

<div id="newreviewPrososal" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>  
   
    
  <h3><?php echo $lang_new_ProjectInformation;?></h3>
  
   <?php
$sqlQnsubmitted="SELECT * FROM ".$prefix."concept_dynamic_questions_all_a where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted = $mysqli->query($sqlQnsubmitted);
$rowsSubmitted=$Querysubmitted->fetch_array();
?>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserInv2['projectID'];?>" >
  <input type="hidden" name="conceptID" value="<?php echo $conceptID;?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<?php if($rowsSubmitted['qn_title_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted['qn_title'];?> <span class="error">*</span></label>
      <br /><strong><?php echo $rUserInv2['projectTitle'];?></strong>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted['qn_acronym_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsSubmitted['qn_acronym'];?> <span class="error">*</span></label><br />
     <strong><?php echo $rUserInv2['titleAcronym'];?></strong>
    </div>
  </div><?php }?>

  <?php if($rowsSubmitted['qn_relevantKeywords_status']){?>
    <div class="row success">

    <div class="col-100">
     <label for="lname"><?php echo $rowsSubmitted['qn_relevantKeywords'];?> <span class="error">*</span></label><br />
     <strong><?php echo $rUserInv2['relevantKeywords'];?></strong>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted['qn_researchTypeID_status']){?>
    <div class="row success">

    <div class="col-100">
     <label for="country"><?php echo $lang_new_researchTypeID;?> <span class="error">*</span></label><br />
       <?php
$researchTypeID=$rUserInv2['researchTypeID'];
$sqlCat = "SELECT * FROM ".$prefix."categories where rstug_categoryID='$researchTypeID' order by rstug_categoryName asc";
$queryCat = $mysqli->query($sqlCat);
$rCat = $queryCat->fetch_array();
?>
<strong><?php echo $rCat['rstug_categoryName'];?></strong>
    </div>
  </div><?php }?>
  
 <?php if($rowsSubmitted['qn_HostInstitution_status']=='Enable'){?>
 <div class="row success">

    <div class="col-100">
     <label for="lname">Host Institution  <span class="error">*</span></label><br />
      <?php echo $rUserInv2['HostInstitution'];?>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted['qn_OrchidID_status']=='Enable'){?>
    <div class="row success">

    <div class="col-100">
     <label for="lname"><?php echo $rowsSubmitted['qn_OrchidID'];?></label><br />
     <?php echo $rUserInv2['qn_OrchidID'];?>
    </div>
  </div><?php }?>

  <?php if($rowsSubmitted['qn_projectDurationID_status']){?>
     <div class="row success">

    <div class="col-100">
    <label for="country"><?php echo $lang_new_titleDurationtheproject;?> <span class="error">*</span></label><br />

       <?php
	   $projectDurationID=$rUserInv2['projectDurationID'];
$sqlFeaturedCall = "SELECT * FROM ".$prefix."duration where durationID='$projectDurationID' order by durationID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
$rFeaturedCall = $queryFeaturedCall->fetch_array();
?>
<strong><?php echo $rFeaturedCall['durationID'];?> <?php echo $rFeaturedCall['durationdesc'];?></strong>


    </div>
  </div><?php }?>
  
  
<?php /*?>  <?php if($rowsSubmitted['']){?>
 <div class="row success">

    <div class="col-100">
     <label for="lname">Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal  <span class="error">*</span></label><br />
      <strong><?php echo $rUserInv2['PrincipalInvestigator'];?></strong>
    </div>
  </div><?php }?><?php */?>
  
  <?php if($rowsSubmitted['qn_fundingappliedfor_status']){?>
  <div class="row success">

    <div class="col-100">
     <label for="lname"><?php echo $rowsSubmitted['qn_fundingappliedfor'];?> <span class="error">*</span></label><br />
 <strong><?php echo numberformat($rUserInv2['Totalfunding']);?></strong>
    </div>
  </div>
  <?php }?>

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