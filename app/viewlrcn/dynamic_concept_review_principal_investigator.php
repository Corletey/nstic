<?php
///Get project Owner
$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$conceptID'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_concents where  owner_id='$owner_id' and reviewer_id='$usrm_id' and conceptID='$conceptID'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_concents  set `PrincipalInvestigator`='1' where `owner_id`='$owner_id'  and conceptID='$conceptID' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}


$sessionusrm_id=$_SESSION['usrm_id'];
$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."review_concents where reviewer_id='$sessionusrm_id' and reviewer_id='$usrm_id'  and conceptID='$conceptID'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();

?><div class="tab">

<?php require_once("dynamic_categories.php");?>
  
  <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewProjectInformation&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
  
  
  
<?php if($total_Team){?><button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newReviewconceptPrincipalInvestigator')" id="defaultOpen"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptIntroduction&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button><?php }?>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptProjectDetails&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newReviewconceptBudget/<?php echo $id;?>/'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptReferences&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
<?php if($total_Attachments){?> <button <?php if($rUConceptStages['Attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptAttachments&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_ViewAttachment;?> </button><?php }?>
</div>
<?php

if($cmdOwner->num_rows and $id){


?>


<div id="newReviewconceptPrincipalInvestigator" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?>    
  <h3>Project Team</h3>
  
  <?php
  $asrmApplctID2=$usrm_id;
$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$owner_id' and `conceptm_id`='$conceptID' order by piID desc limit 0,10";
$QueryUsers4 = $mysqli->query($sqlUsers4);
if($QueryUsers4->num_rows){

?>
<div style="overflow-x:auto;">
<div style="overflow-x:auto;">
  <table width="100%" border="0" id="customers">
  <tr>
    <th><?php echo $lang_new_Name;?></th>
    <th><?php echo $lang_Gender;?></th>
    <th><?php echo $lang_AgeRange;?></th>
    <th><?php echo $lang_Contacts;?></th>
    <th><?php echo $lang_Expertise;?></th>
    <th>&nbsp;</th>
   
  </tr>
  
  <?php 

while($rUserInv2=$QueryUsers4->fetch_array()){
?>
  <tr>
    <td><?php echo $rUserInv2['Surname'];?> <?php echo $rUserInv2['Othername'];?></td>
    <td><?php echo $rUserInv2['Gender'];?></td>
    <td><?php echo $rUserInv2['AgeRange'];?></td>
    <td><?php echo $rUserInv2['Contacts'];?></td>
    <td><?php echo $rUserInv2['Expertise'];?></td>
    <td><?php //echo $rUserInv2['EducationalBackground'];?>
      
   <a href="./main.php?option=newconceptEducationBackground&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>&bkey=<?php echo $rUserInv2['piID'];?>" style="background-color: #4CAF50; color:#fff;padding:5px;"><?php echo $lang_ClicktoViewDetails;?> </a>
      
      
      
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
<?php }?>

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