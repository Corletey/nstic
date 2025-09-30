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
$sqlASubmissionStages="update ".$prefix."review_proposals  set `ProjectResults`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$usrm_id' and projectID='$id' and grantID='$grantID'";
$mysqli->query($sqlASubmissionStages);
}
}

$usrm_id=$rowner['owner_id'];
$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();

$sqlUsers2="SELECT * FROM ".$prefix."project_results where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$usrm_idowner=$rowner['owner_id'];
$wProjectStages="select * from ".$prefix."review_proposals where reviewer_id='$sessionusrm_id' and owner_id='$usrm_idowner'  and projectID='$id'  order by id desc limit 0,1";
$cmProjectStages = $mysqli->query($wProjectStages);
$rProjectStages=$cmProjectStages->fetch_array();
?>

<?php
require("dynamic_categories_review.php");
?>
<div class="tab">

<?php if($total_Information){?><button <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewPrososal&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
  
<?php if($total_Team){?><button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewProjectTeam&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button><?php }?> 
  
<?php if($total_Background){?><button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalBackground&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Background;?> </button><?php }?>
  
  
<?php if($total_Methodology){?><button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalMethodology&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button><?php }?>
    
    
<?php if($total_Budget){?><button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
    
<?php if($total_Results){?><button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newreviewproposalResults')" id="defaultOpen"><?php echo $lang_new_ProjectResults;?></button><?php }?>
  
  <?php if($total_Management){?><button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button><?php }?>
  
<?php if($total_Followup){?><button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button><?php }?>
  
<?php if($total_Citations){?>  <button <?php if($rProjectStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalReferences&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
  <?php if($total_Attachments){?><button <?php if($rProjectStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalAttachments&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>
   

</div>

<div id="newreviewproposalResults" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>    
    
  <h3><?php echo $lang_new_ProjectResults;?></h3>
  
   <?php
$sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_j where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
?> 

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->
<label for="fname"><strong><?php echo $lang_TheoryofChange;?></strong></label><br />
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>


<?php if($rowsSubmitted_c['logicalflow_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><strong><?php echo $rowsSubmitted_c['logicalflow'];?><span class="error">*</span></strong></label>

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="customers">
        <tr>
        
      
           <th width="20%"><strong><em><?php echo $lang_Researchoutputs;?></em></strong></th>
    <th width="17%"><strong><em><?php echo $lang_Indicators;?></em></strong></th>
    <th width="6%">&nbsp;</th>
    <th width="20%"><strong><em><?php echo $lang_Researchoutcomes;?></em></strong></th>
    <th width="16%"><strong><em><?php echo $lang_Indicators;?></em></strong></th>
    <th width="7%">&nbsp;</th>
    <th width="14%"><strong><em><?php echo $lang_Impact;?></em></strong></th>
     
        </tr>
      
        
        <?php 
$sqlProjectID="SELECT * FROM ".$prefix."research_impact_pathway where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
     
           <td width="20%"><?php echo $rUserProjectID['ResearchOutputs1'];?></td>
    <td width="17%"><?php echo $rUserProjectID['ResearchOutputsIndicators1'];?></td>
    <td width="6%">&nbsp;</td>
    <td width="20%"><?php echo $rUserProjectID['ResearchOutcomes1'];?></td>
    <td width="16%"><?php echo $rUserProjectID['ResearchOutcomesIndicators1'];?></td>
    <td width="7%">&nbsp;</td>
    <td width="14%"><?php echo $rUserProjectID['Impact1'];?></td>
      
        </tr>
        <?php }?>
        </table>
    </div>
  </div><?php }?>

<?php if($rowsSubmitted_c['ResearchObjective_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ResearchObjective'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['ResearchObjective'];?></strong>
    </div>
  </div><?php }?>


<?php if($rowsSubmitted_c['Outputs_status']){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['Outputs'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['Outputs'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['Outcomes_status']){?>
 <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['Outcomes'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['Outcomes'];?></strong>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['ImpactCapacityDevelopment_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ImpactCapacityDevelopment'];?><br /><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['ImpactCapacityDevelopment'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['ImpactPathwayDiagram_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ImpactPathwayDiagram'];?> <span class="error">(<?php echo $lang_FilePDF;?>)</span><span class="error">*</span></label>

<?php if($rUserInv2['ImpactPathwayDiagram']){?>

<br /><a href="./files/<?php echo $rUserInv2['ImpactPathwayDiagram'];?>" target="_blank"><?php echo $lang_ClicktoViewDetails;?></a><?php }?>

    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['StakeholderEngagement_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['StakeholderEngagement'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['StakeholderEngagement'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['CommunicationWithStakeholders_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['CommunicationWithStakeholders'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['CommunicationWithStakeholders'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['ScientificOutput_status']){?>
     <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ScientificOutput'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['ScientificOutput'];?></strong>
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