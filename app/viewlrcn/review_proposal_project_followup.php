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
$sqlASubmissionStages="update ".$prefix."review_proposals  set `Followup`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}
}
$usrm_id=$rowner['owner_id'];

$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();

$sqlUsers2="SELECT * FROM ".$prefix."project_follow_up where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$usrm_idowner=$rowner['owner_id'];
$wProjectStages="select * from ".$prefix."review_proposals where reviewer_id='$sessionusrm_id' and owner_id='$usrm_idowner'  and projectID='$id'";
$cmProjectStages = $mysqli->query($wProjectStages);
$rProjectStages=$cmProjectStages->fetch_array();
?>
<div class="tab">

  <button  <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewPrososal&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  
  <button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewProjectTeam&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBackground&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalMethodology&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    
    <button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button>
  
  <button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewproposalFollowup')" id="defaultOpen"><?php echo $lang_new_ProjectFollowup;?></button>
  
</div>

<div id="reviewproposalFollowup" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>    
    
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
<br /><strong><?php echo $rUserInv2['resultExploitationPlan'];?></strong>
    </div>
  </div>

  <div class="row success">

    <div class="col-100">
    <label for="fname">b) If relevant: how innovative results will be further exploited through an implementation plan for the project results/innovations;
 <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['resultInnovativeResults'];?></strong>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="fname">c) How intellectual property, including foreground knowledge, patents, copyrights, license agreements and any other arrangements will be managed.
 <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['resultIntellectualProperty'];?></strong>
    </div>
  </div>

  <div class="row success">

    <div class="col-100">
    <label for="fname">What ethical considerations are foreseen in the project?<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['ethicalConsiderations'];?></strong>
    </div>
  </div>


    <div class="row success">

    <div class="col-100">
    <label for="fname">Clearly explain the way(s) in which the project intends to deal with ethical issues that may be associatedidentified above <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['DealwithEthicalIssues'];?></strong>
    </div>
  </div>
  
 <div class="row success">

    <div class="col-100">
    <label for="fname">Does the project intend to obtain ethical clearance from the sectoral research regulators and the UNCST? Yes/No If no, Why?<span class="error">*</span> <br /><strong><?php echo $rUserInv2['PartofInternationalProject'];?></label> 
    
    
<div id="projectwhyNoNeedEthicalCliarence"><?php if($rUserInv2['NeedEthicalClearance']=='No'){?>   
<br /><strong><?php echo $rUserInv2['NeedEthicalClearanceWhy'];?></strong><?php }?></div>

    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Gender and the inclusion of youth, young researchers and other special interest groups. (max. 500 words)<br />
a) Explain how gender and other special interest group  considerations are taken into account in the project and provide a gender  approach.
<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['GenderYouth'];?></strong>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">b) Explain how youth is taken into account in the  project.
<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['YouthTakenccount'];?></strong>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">c) Explain how young researchers and their capacity  development are supported through the project activities.
<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['YoungResearchers'];?></strong>
    </div>
  </div>
  
     <div class="row success">

    <div class="col-100">
    <label for="fname">d) Explain how other interest groups are taken into  account in the project.
<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['InterestGroups'];?></strong>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">State Nature of support provided by the host institution. 
<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['StateNatureofSupport'];?></strong>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Attach a letter of support from the host institution <span class="error">(pdf only)</span>
<span class="error">*</span></label>
<?php if($rUserInv2['AttachLetterofSupport']){?>
<br /><a href="./files/<?php echo $rUserInv2['AttachLetterofSupport'];?>" target="_blank"><strong>Attach a letter of support</strong></a><?php }?>

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