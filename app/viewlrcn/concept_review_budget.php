<?php
///Get project Owner
$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_concents where  owner_id='$owner_id' and conceptID='$id' and reviewer_id='$usrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_concents  set `Budget`='1' where `owner_id`='$owner_id' and conceptID='$id' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}
$sqlUsers2="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$owner_id' and `conceptID`='$id' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."review_concents where reviewer_id='$sessionusrm_id' and reviewer_id='$usrm_id'  and conceptID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();

$sqlUsersBudget="SELECT * FROM ".$prefix."project_details_concept where `owner_id`='$owner_id' and conceptID='$id' order by id desc limit 0,1";
$QueryUsersBudget = $mysqli->query($sqlUsersBudget);
$rUserInvBudget=$QueryUsersBudget->fetch_array();
$TotalBudget=$rUserInvBudget['TotalBudget'];
?>
<div class="tab">

 <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewProjectInformation&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
 
  <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button>
  
    <button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button>
    
   <button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button>
   
  <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'ReviewconceptBudget')" id="defaultOpen"><?php echo $lang_new_Budget;?></button>
  
  <button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button>
  
    <button <?php if($rUConceptStages['Attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptAttachments&id=<?php echo $id;?>'">Attachments </button>
</div>
<script language="JAVASCRIPT">

  <!--

  function addTWD() {

document.regForm.PersonnelTotal.value = (parseInt(document.regForm.Personnel.value)*8/100);
document.regForm.ResearchCostsTotal.value = (parseInt(document.regForm.ResearchCosts.value)*60/100);
document.regForm.EquipmentTotal.value = (parseInt(document.regForm.Equipment.value)*15/100);
document.regForm.kickoffTotal.value = (parseInt(document.regForm.kickoff.value)*2/100);
document.regForm.KnowledgeSharingTotal.value = (parseInt(document.regForm.KnowledgeSharing.value)*5/100);
document.regForm.OverheadCostsTotal.value = (parseInt(document.regForm.OverheadCosts.value)*5/100);
document.regForm.OtherGoodsTotal.value = (parseInt(document.regForm.OtherGoods.value)*5/100);
/*  
$new_width = ($percentage / 100) * $totalWidth;
 , , , , , , , , , , , */
  }
  //-->

  </script>	


<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<div id="ReviewconceptBudget" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?> 
 <div class="success">
  <h3>Budget</h3>

 <div class="row" style="margin-bottom:15px;">

    <div class="col-100">
     <label for="lname"><strong>Total Budget</strong> <span class="error">*</span></label>
      <input type="text" id="TotalBudget" name="TotalBudget" placeholder=".." class="requiredm number"  value="<?php echo numberformat($TotalBudget);?> <?php echo $rUserInvBudget['currencyPrimaryFunder'];?>" required readonly="readonly">
    </div>
  </div>
<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
  <tr>
    <td width="33" valign="top"><p align="center"><strong>&nbsp;</strong></td>
    <td width="581" valign="top"><p align="center"><strong>ITEM</strong></td>
    <td width="174" valign="top"><p align="center"><strong>AMOUNT (<?php echo $rUserInvBudget['currencyPrimaryFunder'];?>)</strong></td>
    <td valign="top"><p align="center"><strong>BUDGET CEILING</strong></td>
    <td valign="top"><p align="center"><strong>ACTUAL BUDGET</strong></td>
    </tr>
  <tr>
    <td width="33" valign="top">1. &nbsp;</td>
    <td width="581" valign="top">Personnel</td>
    <td width="174" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['Personnel']);?></strong></td>
    <td width="144" valign="top" class="txtalign" align="center">8</td>
    <td width="128" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['PersonnelTotal']);?></strong></td>
  </tr>
  <tr>
    <td width="33" valign="top">2. &nbsp;</td>
    <td width="581" valign="top">Research Costs</td>
    <td width="174" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['ResearchCosts']);?></strong>
</td>
    <td width="144" valign="top" class="txtalign" align="center">60</td>
    <td width="128" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['ResearchCostsTotal']);?></strong></td>
  </tr>
  <tr>
    <td width="33" valign="top">3. &nbsp;</td>
    <td width="581" valign="top">Equipment</td>
    <td width="174" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['Equipment']);?></strong>
    
    </td>
    <td width="144" valign="top" class="txtalign" align="center">15</td>
    <td width="128" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['EquipmentTotal']);?></strong></td>
  </tr>
  <tr>
    <td width="33" valign="top">4. &nbsp;</td>
    <td width="581" valign="top">Travel and Subsistence</td>
    <td width="174" valign="top" align="right">
    <strong><?php echo numberformat($rUserInv2['Travel']);?></strong>
    </td>
    <td width="144" valign="top" class="txtalign" align="center">2</td>
    <td width="128" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['kickoffTotal']);?></strong></td>
  </tr>
  <tr>
    <td width="33" valign="top">5. &nbsp;</td>
    <td width="581" valign="top">Grant kick-off, mid-term and final workshops</td>
    <td width="174" valign="top" align="right">
    <strong><?php echo numberformat($rUserInv2['kickoff']);?></strong>
    </td>
    <td width="144" valign="top" class="txtalign" align="center">2</td>
    <td width="128" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['kickoffTotal']);?></strong></td>
  </tr>
  
  <tr>
    <td width="33" valign="top">6. &nbsp;</td>
    <td width="581" valign="top">Knowledge Sharing and Research Uptake</td>
    <td width="174" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['KnowledgeSharing']);?></strong>
    
    </td>
    <td width="144" valign="top" class="txtalign" align="center">5</td>
    <td width="128" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['KnowledgeSharingTotal']);?></strong></td>
  </tr>
  <tr>
    <td width="33" valign="top">7. &nbsp;</td>
    <td width="581" valign="top">Overhead costs</td>
    <td width="174" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['OverheadCosts']);?></strong>
    
    </td>
    <td width="144" valign="top" class="txtalign" align="center">5</td>
    <td width="128" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['OverheadCostsTotal']);?></strong></td>
  </tr>
  <tr>
    <td width="33" valign="top">8. &nbsp;</td>
    <td width="581" valign="top">Other goods and services<br>
      Others (Specify)</td>
    <td width="174" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['OtherGoods']);?></strong>
    
    </td>
    
    <td width="144" valign="top" class="txtalign" align="center">5</td>
    <td width="128" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['OtherGoodsTotal']);?></strong>
    
    
    </td>
  </tr>
  
   <tr>
    <td width="33" valign="top">9. &nbsp;</td>
    <td width="581" valign="top">Matching Support if any</td>
    <td width="174" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['MatchingSupport']);?></strong>
    
    </td>
    
    <td width="144" valign="top" class="txtalign" align="center">5</td>
    <td width="128" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['MatchingSupportTotal']);?></strong>
    
    
    </td>
  </tr>
  <tr>
    <td width="33" valign="top">&nbsp;</td>
    <td width="581" valign="top"><p align="center"><strong>TOTAL</strong></td>
    <td width="174" valign="top" align="right"><strong><?php echo numberformat(($rUserInv2['Personnel']+$rUserInv2['ResearchCosts']+$rUserInv2['Equipment']+$rUserInv2['kickoff']+$rUserInv2['Travel']+$rUserInv2['KnowledgeSharing']+$rUserInv2['OverheadCosts']+$rUserInv2['OtherGoods']+$rUserInv2['MatchingSupport']));
	?></strong></td>
    <td width="144" align="center" valign="top"><strong>100</strong></td>
    <td width="128" valign="top" align="right"><strong><?php echo numberformat($rUserInv2['TotalSubmitted']);?></strong></td>
  </tr>
</table>

<div style="clear:both;"></div>

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
</script><?php }?>