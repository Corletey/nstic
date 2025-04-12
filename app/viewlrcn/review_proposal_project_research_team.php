<?php
$grantID=$_GET['grantID'];
$wmOwner="select * from ".$prefix."submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];
$usrm_idowner=$rowner['owner_id'];

$wm="select * from ".$prefix."review_proposals where  owner_id='$owner_id' and status='new' and reviewer_id='$usrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_proposals  set `PrincipalInvestigator`='1' where `owner_id`='$usrm_idowner' and status='new' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}
}

$sessionusrm_id=$_SESSION['usrm_id'];
$usrm_idowner=$rowner['owner_id'];
$wProjectStages="select * from ".$prefix."review_proposals where reviewer_id='$sessionusrm_id' and owner_id='$usrm_idowner'  and projectID='$id'";
$cmProjectStages = $mysqli->query($wProjectStages);
$rProjectStages=$cmProjectStages->fetch_array();
?><div class="tab">
  
 <button  <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewPrososal&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectInformation;?></button>
 
  <button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'reviewProjectTeam')" id="defaultOpen"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBackground&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalMethodology&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    
    <button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button>

  <button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
</div>


<div id="reviewProjectTeam" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>    
  <h3>Project Team</h3>

  <?php
  
$usrm_id=$rowner['owner_id'];
$sqlUsers2="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();
$conceptIDm=$rUserInv2['conceptID'];
$projectID=$rUserInv2['projectID'];

$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$usrm_id' and `conceptm_id`='$conceptIDm' order by piID desc limit 0,10";
$QueryUsers4 = $mysqli->query($sqlUsers4);
if($QueryUsers4->num_rows){

?>
<div style="overflow-x:auto;">
  <table width="100%" border="0" id="customers">
  <tr>
    <th>Name</th>
    <th>Gender</th>
    <th><?php echo $lang_AgeRange;?></th>
    <th><?php echo $lang_Contacts;?></th>
    <th><?php echo $lang_Expertise;?></th>
    <th>&nbsp;</th>
    <!--    <th><?php echo $lang_ResearchExperience;?></th>
    <th><?php echo $$lang_RoleofTeamMember;?></th>
    <th><?php echo $lang_institution_of_affiliation;?></th>-->
  </tr>
  
  <?php 

while($rUserInv2=$QueryUsers4->fetch_array()){
?>
  <tr>
    <td><?php echo $rUserInv2['Surname'];?> <?php echo $rUserInv2['Othername'];?></td>
    <td><?php echo $rUserInv2['Gender'];?></td>
    <td><?php echo $rUserInv2['AgeRange'];?></td>
    <td><?php echo $rUserInv2['<?php echo $lang_Contacts;?>'];?></td>
    <td><?php echo $rUserInv2['<?php echo $lang_Expertise;?>'];?></td>
    <td><?php //echo $rUserInv2['EducationalBackground'];?>
      
   <a href="./main.php?option=newreviewProposalEducationBackground&id=<?php echo $id;?>&bkey=<?php echo $rUserInv2['piID'];?>&bt=<?php echo $rUserInv2['owner_id'];?>" style="background-color: #4CAF50; color:#fff;padding:5px;">View Details </a>
      
      
      
    </td>
    <?php /*?>    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td><?php echo $rUserInv2['InstitutionofAffiliation'];?></td><?php */?>
  </tr>
  <?php }?>
</table>
</div>

<p>&nbsp;</p><?php }?>












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