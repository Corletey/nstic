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
$sqlASubmissionStages="update ".$prefix."review_proposals  set `ProjectInformation`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$usrm_id' and id='$id'";
$mysqli->query($sqlASubmissionStages);
}
if(!$totalStages and $session_usertype!='user'){
$sqlASubmissionStages="insert into ".$prefix."review_proposals (`owner_id`,`projectID`,`ProjectInformation`,`PrincipalInvestigator`,`Background`,`Methodology`,`ProjectResults`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`,`reviewer_id`)  values('$owner_id','$id','1','0','0','0','0','0','0','0',now(),'new','$usrm_id')";
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
<div class="tab">

  <button <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewPrososal')" id="defaultOpen"><?php echo $lang_new_ProjectInformation;?></button>
  
  <button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewProjectTeam&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBackground&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'">Background </button>
  
  
    <button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalMethodology&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    
    <button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button>
  
  <button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
   <button <?php if($rProjectStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalReferences&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Citations;?></button>
  
  <button <?php if($rProjectStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalAttachments&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Attachments;?> </button>
</div>

<div id="reviewPrososal" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>  
   
    
  <h3>Project Information</h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserInv2['projectID'];?>" >
  <input type="hidden" name="conceptID" value="<?php echo $conceptID;?>" >
 <div class="container"><!--begin-->
  <p><strong>Important:</strong> Note that the information requested is not the same as in the preliminary concept note proposal stage. You are required to take the feedback from your preliminary concept note proposal into consideration when developing the full proposal.</p>
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Title (max 50 words) - Give the title of your project <span class="error">*</span></label>
      <br /><strong><?php echo $rUserInv2['projectTitle'];?></strong>
    </div>
  </div>
  <div class="row success">

    <div class="col-100">
    <label for="lname">Short Title or Acronym (20 characters) <span class="error">*</span></label><br />
     <strong><?php echo $rUserInv2['titleAcronym'];?></strong>
    </div>
  </div>

  
    <div class="row success">

    <div class="col-100">
     <label for="lname">Identify the 5 most relevant keywords that represent the scientific basis of your project (max 5 words) <span class="error">*</span></label><br />
     <strong><?php echo $rUserInv2['relevantKeywords'];?></strong>
    </div>
  </div>
  
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
  </div>
  
<?php /*?>   <div class="row success">

    <div class="col-100">
     <label for="lname">Host Institution  <span class="error">*</span></label>
      <input type="text" id="HostInstitution" name="HostInstitution" placeholder=".." class="required"  value="<?php echo $rUserInv2['HostInstitution'];?>">
    </div>
  </div><?php */?>

  
     <div class="row success">

    <div class="col-100">
    <label for="country">Duration of the project- indicate the duration of the project in months <span class="error">*</span></label><br />

       <?php
	   $projectDurationID=$rUserInv2['projectDurationID'];
$sqlFeaturedCall = "SELECT * FROM ".$prefix."duration where durationID='$projectDurationID' order by durationID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
$rFeaturedCall = $queryFeaturedCall->fetch_array();
?>
<strong><?php echo $rFeaturedCall['durationID'];?> <?php echo $rFeaturedCall['durationdesc'];?></strong>


    </div>
  </div>
  
 <div class="row success">

    <div class="col-100">
     <label for="lname">Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal  <span class="error">*</span></label><br />
      <strong><?php echo $rUserInv2['PrincipalInvestigator'];?></strong>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
     <label for="lname">Total funding applied for  <span class="error">*</span></label><br />
 <strong><?php echo $rUserInv2['Totalfunding'];?></strong>
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