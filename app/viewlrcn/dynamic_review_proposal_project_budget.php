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

$wm="select * from ".$prefix."review_proposals where  owner_id='$owner_id' and status='new' and reviewer_id='$usrm_id' and projectID='$id' and projectID='$id' and grantID='$grantID'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_proposals  set `Budget`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$usrm_id' and projectID='$id' and grantID='$grantID'";
$mysqli->query($sqlASubmissionStages);
}
}

$usrm_id=$rowner['owner_id'];
$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();
$conceptID=$rUserProjectID['conceptID'];


$sqlUsers2="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$usrm_id' and grantcallID='$grantID' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();
$projectID=$rUserProjectID['projectID'];

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
    
    
<?php if($total_Budget){?><button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newreviewproposalBudget')" id="defaultOpen"><?php echo $lang_new_Budget;?></button><?php }?>
    
<?php if($total_Results){?><button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button><?php }?>
  
  <?php if($total_Management){?><button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button><?php }?>
  
<?php if($total_Followup){?><button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button><?php }?>
  
 <?php if($total_Citations){?> <button <?php if($rProjectStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalReferences&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
  <?php if($total_Attachments){?><button <?php if($rProjectStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalAttachments&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>
    

</div>
<script language="JAVASCRIPT">

  <!--

  function addTWD() {
//document.regForm.PersonnelTotal.value = (parseInt(document.regForm.Personnel.value)*8/100);
document.regForm.PersonnelTotal.value = 8/100*(parseInt(document.regForm.Personnel.value));
document.regForm.ResearchCostsTotal.value = 60/100*(parseInt(document.regForm.ResearchCosts.value));
document.regForm.EquipmentTotal.value = 15/100*(parseInt(document.regForm.Equipment.value));
document.regForm.kickoffTotal.value = 2/100*(parseInt(document.regForm.kickoff.value));
document.regForm.TravelTotal.value = 2/100*(parseInt(document.regForm.Travel.value));
document.regForm.KnowledgeSharingTotal.value = 5/100*(parseInt(document.regForm.KnowledgeSharing.value));
document.regForm.OverheadCostsTotal.value = 5/100*(parseInt(document.regForm.OverheadCosts.value));
document.regForm.OtherGoodsTotal.value = 5/100*(parseInt(document.regForm.OtherGoods.value));
document.regForm.MatchingSupportTotal.value = 2/100*(parseInt(document.regForm.MatchingSupport.value));

$total1 = document.regForm.PersonnelTotal.value = 8/100*(parseInt(document.regForm.Personnel.value));
$total2 = document.regForm.ResearchCostsTotal.value = 60/100*(parseInt(document.regForm.ResearchCosts.value));
$total3 = document.regForm.EquipmentTotal.value = 15/100*(parseInt(document.regForm.Equipment.value));
$total4 = document.regForm.kickoffTotal.value = 2/100*(parseInt(document.regForm.kickoff.value));
$total5 = document.regForm.TravelTotal.value = 2/100*(parseInt(document.regForm.Travel.value));
$total6 = document.regForm.KnowledgeSharingTotal.value = 5/100*(parseInt(document.regForm.KnowledgeSharing.value));
$total7 = document.regForm.OverheadCostsTotal.value = 5/100*(parseInt(document.regForm.OverheadCosts.value));
$total8 = document.regForm.OtherGoodsTotal.value = 5/100*(parseInt(document.regForm.OtherGoods.value));
$total9 = document.regForm.MatchingSupportTotal.value = 2/100*(parseInt(document.regForm.MatchingSupport.value));

document.regForm.TotalSubmitted.value = ($total1+$total2+$total3+$total4+$total5+$total6+$total7+$total8+$total9);
/*  
$new_width = ($percentage / 100) * $totalWidth;
 , , , , , , , , , , , */
  }
  //-->

  </script>	


<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<div id="newreviewproposalBudget" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?> 
 
   <h3><?php echo $lang_Budget;?></h3>
   
   <div class="success">

 <?php
$sqlQnsubmitted_d="SELECT * FROM ".$prefix."concept_dynamic_questions_all_e where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted_d = $mysqli->query($sqlQnsubmitted_d);
$rowsSubmitted_d=$Querysubmitted_d->fetch_array();
$totalStages_d = $Querysubmitted_d->num_rows;
?>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 
  <div class="row" style="margin-bottom:15px;">

    <div class="col-100">
     <label for="lname"><strong><?php echo $lang_new_TotalBudgetCost;?></strong> <span class="error">*</span></label>
 <strong> <?php echo numberformat($rUserInv2['TotalSubmitted']);?></strong>
    </div>
  </div>
  
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >

<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
  <tr>
    <td width="30" valign="top"><p align="center"><strong>&nbsp;</strong></td>
    <td width="203" valign="top"><p align="center"><strong><?php echo $lang_new_Item;?></strong></td>
    <td width="328" valign="top"><p align="center"><strong><?php echo $lang_new_Amount;?></strong></td>
     <td valign="top"><p align="center"><strong><?php echo $lang_new_PercentageCeiling;?></strong></td>
    <td valign="top"><p align="center"><strong><?php echo $lang_new_MaAllowableAmount;?></strong></td>
    </tr>
    <?php if($rowsSubmitted_d['qn_Personnel_status']){?>
  <tr>
    <td width="30" valign="top">1. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_Personnel'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv2['Personnel'];?></td>
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_PersonnelPercentage_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv2['PersonnelTotal'];?></td>
  </tr>
  <?php }?>
   <?php if($rowsSubmitted_d['qn_ResearchCosts_status']){?>
  <tr>
    <td width="30" valign="top">2. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_ResearchCosts'];?></td>
    <td width="328" valign="top">
   
    <?php echo $rUserInv2['ResearchCosts'];?>
</td>
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_ResearchCosts_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv2['ResearchCostsTotal'];?></td>
  </tr><?php }?>
  
  
   <?php if($rowsSubmitted_d['qn_Equipment_Ceiling_status']){?>
  <tr>
    <td width="30" valign="top">3. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_Equipment'];?></td>
    <td width="328" valign="top">
   <?php echo $rUserInv2['Equipment'];?>
    
    </td>
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_Equipment_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv2['EquipmentTotal'];?></td>
  </tr>
  <?php }?>
  
   <?php if($rowsSubmitted_d['qn_Travel_status']){?>
<tr>
    <td width="30" valign="top">4. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_Travel'];?></td>
    <td width="328" valign="top">
  <?php echo $rUserInv2['Travel'];?>
    </td>
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_Travel_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv2['TravelTotal'];?></td>
  </tr><?php }?>
  
  
   <?php if($rowsSubmitted_d['qn_kickoff_status']){?>
  <tr>
    <td width="30" valign="top">5. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_kickoff'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv2['kickoff'];?></td>
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_kickoff_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv2['kickoffTotal'];?></td>
  </tr>
  <?php }?>
  
   <?php if($rowsSubmitted_d['qn_KnowledgeSharing_status']){?>
  <tr>
    <td width="30" valign="top">6. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_KnowledgeSharing'];?></td>
    <td width="328" valign="top">
<?php echo $rUserInv2['KnowledgeSharing'];?>
    
    </td>
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_KnowledgeSharing_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv2['KnowledgeSharingTotal'];?></td>
  </tr><?php }?>
  
   <?php if($rowsSubmitted_d['qn_OverheadCosts_status']){?>
  <tr>
    <td width="30" valign="top">7. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_OverheadCosts'];?></td>
    <td width="328" valign="top">

    <?php echo $rUserInv2['OverheadCosts'];?>
    
    </td>
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_OverheadCosts_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv2['OverheadCostsTotal'];?></td>
  </tr><?php }?>
  
  
   <?php if($rowsSubmitted_d['qn_OtherGoods_status']){?>
  <tr>
    <td width="30" valign="top">8. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_OtherGoods'];?></td>
    <td width="328" valign="top">
<?php echo $rUserInv2['OtherGoods'];?>
    
    </td>
    
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_OtherGoods_Ceiling'];?></td>
    <td width="275" valign="top">    
   <?php echo $rUserInv2['OtherGoodsTotal'];?>
    
    
    </td>
  </tr><?php }?>
  
   <?php if($rowsSubmitted_d['qn_MatchingSupport_status']){?>
  <tr>
    <td width="30" valign="top">9. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_MatchingSupport'];?></td>
    <td width="328" valign="top">
<?php echo $rUserInv2['MatchingSupport'];?>
    
    </td>
    
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_MatchingSupport_Ceiling'];?></td>
    <td width="275" valign="top">    
    <?php echo $rUserInv2['MatchingSupportTotal'];?>
    
    
    </td>
  </tr><?php }?>
  
  <tr>
    <td width="30" valign="top">&nbsp;</td>
    <td width="203" valign="top"><p align="center"><strong><?php echo $lang_new_TotalBudgetCost;?></strong></td>
    <td width="328" valign="top">&nbsp;</td>
    <td width="209" align="center" valign="top"><strong>100</strong></td>
    <td width="275" valign="top"><?php echo numberformat($rUserInv2['TotalSubmitted']);?></td>
  </tr>
</table>

<div style="clear:both;"></div>


</form>


<div style="clear:both"></div>
</div>



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