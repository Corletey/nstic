<?php
///Get project Owner
$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$conceptID'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
$grantID=$rowner['grantcallID'];
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_concents where  owner_id='$owner_id' and conceptID='$conceptID' and reviewer_id='$usrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_concents  set `Budget`='1' where `owner_id`='$owner_id' and conceptID='$conceptID' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}
$sqlUsers2="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$owner_id' and `conceptID`='$conceptID' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."review_concents where reviewer_id='$sessionusrm_id' and reviewer_id='$usrm_id'  and conceptID='$conceptID'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();

$sqlUsersBudget="SELECT * FROM ".$prefix."project_details_concept where `owner_id`='$owner_id' and conceptID='$conceptID' order by id desc limit 0,1";
$QueryUsersBudget = $mysqli->query($sqlUsersBudget);
$rUserInvBudget=$QueryUsersBudget->fetch_array();
$TotalBudget=$rowner['TotalBudget'];
?>
<div class="tab">

<?php require_once("dynamic_categories.php");?>

 <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewProjectInformation&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
 
<?php if($total_Team){?> <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptPrincipalInvestigator&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptIntroduction&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button><?php }?>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptProjectDetails&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newReviewconceptBudget')" id="defaultOpen"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptReferences&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
<?php if($total_Attachments){?><button <?php if($rUConceptStages['Attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptAttachments&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_ViewAttachment;?> </button><?php }?>
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
<div id="newReviewconceptBudget" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?> 
 <div style="clear:both"></div>
 <div class="success">
  <h3><?php echo $lang_Budget;?></h3>
  <?php 
  $sqlDynamic="SELECT * FROM ".$prefix."concept_dynamic_questions_all_e where grantID='$grantID' order by id asc";
	$QueryDynamic = $mysqli->query($sqlDynamic);
	$rowsDynamic=$QueryDynamic->fetch_array();
	
	if($rowsDynamic['qn_PersonnelPercentage_Ceiling']){$qn_PersonnelPercentage_Ceiling=($rowsDynamic['qn_PersonnelPercentage_Ceiling']/100);}
	if($rowsDynamic['qn_ResearchCosts_Ceiling']){$qn_ResearchCosts_Ceiling=($rowsDynamic['qn_ResearchCosts_Ceiling']/100);}
	if($rowsDynamic['qn_Equipment_Ceiling']){$qn_Equipment_Ceiling=($rowsDynamic['qn_Equipment_Ceiling']/100);}
	if($rowsDynamic['qn_Travel_Ceiling']){$qn_Travel_Ceiling=($rowsDynamic['qn_Travel_Ceiling']/100);}
	if($rowsDynamic['qn_kickoff_Ceiling']){$qn_kickoff_Ceiling=($rowsDynamic['qn_kickoff_Ceiling']/100);}
	if($rowsDynamic['qn_KnowledgeSharing_Ceiling']){$qn_KnowledgeSharing_Ceiling=($rowsDynamic['qn_KnowledgeSharing_Ceiling']/100);}
	if($rowsDynamic['qn_OverheadCosts_Ceiling']){$qn_OverheadCosts_Ceiling=($rowsDynamic['qn_OverheadCosts_Ceiling']/100);}
	if($rowsDynamic['qn_OtherGoods_Ceiling']){$qn_OtherGoods_Ceiling=($rowsDynamic['qn_OtherGoods_Ceiling']/100);}
	if($rowsDynamic['qn_MatchingSupport_Ceiling']){$qn_MatchingSupport_Ceiling=($rowsDynamic['qn_MatchingSupport_Ceiling']/100);}
	
	$mmPersonnelTotal=($TotalBudget*$qn_PersonnelPercentage_Ceiling);
$mmResearchCosts=($TotalBudget*$qn_ResearchCosts_Ceiling);
$mmEquipmentTotal=($TotalBudget*$qn_Equipment_Ceiling);
$mmTravel=($TotalBudget*$qn_Travel_Ceiling);
$mmkickoff=($TotalBudget*$qn_kickoff_Ceiling);
$mmKnowledgeSharing=($TotalBudget*$qn_KnowledgeSharing_Ceiling);
$mmOverheadCostsTotal=($TotalBudget*$qn_OverheadCosts_Ceiling);
$mmOtherGoods=($TotalBudget*$qn_OtherGoods_Ceiling);
$mmMatchingSupport=($TotalBudget*$qn_MatchingSupport_Ceiling);

$SumTotal=($mmPersonnelTotal+$mmResearchCosts+$mmEquipmentTotal+$mmTravel+$mmkickoff+$mmKnowledgeSharing+$mmOverheadCostsTotal+$mmOtherGoods+$mmMatchingSupport);
	?>

 <div class="row" style="margin-bottom:15px;">

    <div class="col-100">
     <label for="lname"><strong><?php echo $lang_new_TotalBudgetCost;?></strong> <span class="error">*</span></label>
      <?php echo numberformat($TotalBudget);?> <?php echo $rUserInvBudget['currencyPrimaryFunder'];?>
    </div>
  </div>
<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
   <tr>
    <td width="37" valign="top"><p align="center"><strong>&nbsp;</strong></td>
    <td width="256" valign="top"><p align="center"><strong><?php echo $lang_new_Item;?></strong></td>
    <td width="530" valign="top"><p align="center"><strong><?php echo $lang_new_Amount;?> (<?php echo $rUserInvBudget['currencyPrimaryFunder'];?>)</strong></td>
    <td valign="top"><p align="center"><strong><?php echo $lang_new_PercentageCeiling;?></strong></td>
    <td valign="top"><p align="center"><strong><?php echo $lang_new_MaAllowableAmount;?></strong></td>
    </tr>
    
   <?php if($rowsDynamic['qn_Personnel_status']=='Enable'){?> 
  <tr>
    <td width="35" valign="top">1. &nbsp;</td>
    <td width="241" valign="top"><?php echo $rowsDynamic['qn_Personnel'];?></td>
    <td width="561" valign="top">
      <script type="text/javascript">
function fnc(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) > <?php echo $mmPersonnelTotal;?>) 
        return "Personnel costs should not exceed 8% of the total budget which is <?php echo numberformat($mmPersonnelTotal);?>"; 
    else return value;
}
</script>
    
  <?php echo numberformat($rUserInv2['Personnel']);?>
    
    
  

    
    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_PersonnelPercentage_Ceiling'];?></td>
    <td width="144" valign="top">
   <?php echo numberformat($mmPersonnelTotal);?></td>
  </tr><?php }?>
  
  
  <?php if($rowsDynamic['qn_ResearchCosts_status']=='Enable'){?>
  <tr>
    <td width="35" valign="top">2. &nbsp;</td>
    <td width="241" valign="top"><?php echo $rowsDynamic['qn_ResearchCosts'];?></td>
    <td width="561" valign="top">
   
 <script type="text/javascript">
function fnc2(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) < <?php echo $mmResearchCosts;?>) 
       return value;  
    else return value;
}
</script>
<?php if($highlightfield=='true'){$mm='border:solid 2px #F30;';}?>
 <?php echo numberformat($rUserInv2['ResearchCosts']);?>
</td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_ResearchCosts_Ceiling'];?></td>
    <td width="144" valign="top"><?php echo numberformat($mmResearchCosts);?></td>
  </tr>
  <?php }?>
  
  
  <?php if($rowsDynamic['qn_Equipment_Ceiling_status']=='Enable'){?>
  <tr>
    <td width="35" valign="top">3. &nbsp;</td>
    <td width="241" valign="top"><?php echo $rowsDynamic['qn_Equipment'];?></td>
    <td width="561" valign="top">
       <script type="text/javascript">
function fnc3(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) > <?php echo $mmEquipmentTotal;?>) 
        return "Equipment costs should not exceed <?php echo $rowsDynamic['qn_Equipment_Ceiling'];?>% of the total budget which is <?php echo numberformat($mmEquipmentTotal);?>"; 
    else return value;
}
</script>

 <?php echo numberformat($rUserInv2['Equipment']);?>
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_Equipment_Ceiling'];?></td>
    <td width="144" valign="top"><?php echo numberformat($mmEquipmentTotal);?></td>
  </tr>
  <?php }?>
  
  <?php if($rowsDynamic['qn_Travel_status']=='Enable'){?>
<tr>
    <td width="35" valign="top">4. &nbsp;</td>
    <td width="241" valign="top"><?php echo $rowsDynamic['qn_Travel'];?></td>
    <td width="561" valign="top">
    
    <script type="text/javascript">
function fnc4(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) > <?php echo $mmTravel;?>) 
        return "Travel and Subsistence costs should not exceed <?php echo $rowsDynamic['qn_Travel_Ceiling'];?>% of the total budget which is <?php echo numberformat($mmTravel);?>"; 
    else return value;
}
</script>

<?php echo numberformat($rUserInv2['Travel']);?>
    </td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_Travel_Ceiling'];?></td>
    <td width="144" valign="top"><?php echo numberformat($mmTravel);?></td>
  </tr>
  <?php }?>
  
  <?php if($rowsDynamic['qn_kickoff_status']=='Enable'){?>
  <tr>
    <td width="35" valign="top">5. &nbsp;</td>
    <td width="241" valign="top"><?php echo $rowsDynamic['qn_kickoff'];?></td>
    <td width="561" valign="top">
    
    <script type="text/javascript">
function fnc5(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) > <?php echo $mmkickoff;?>) 
        return "Grant kick-off costs should not exceed 2% of the total budget which is <?php echo numberformat($mmkickoff);?>"; 
    else return value;
}
</script>

<?php echo numberformat($rUserInv2['kickoff']);?>
    </td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_kickoff_Ceiling'];?></td>
    <td width="144" valign="top"><?php echo numberformat($mmkickoff);?></td>
  </tr>
  <?php }?>
  
  <?php if($rowsDynamic['qn_KnowledgeSharing_status']=='Enable'){?>
  <tr>
    <td width="35" valign="top">6. &nbsp;</td>
    <td width="241" valign="top"><?php echo $rowsDynamic['qn_KnowledgeSharing'];?></td>
    <td width="561" valign="top">

    <script type="text/javascript">
function fnc6(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) > <?php echo $mmKnowledgeSharing;?>) 
        return "Knowledge Sharing and Research Uptake costs should not exceed 5% of the total budget which is <?php echo numberformat($mmKnowledgeSharing);?>"; 
    else return value;
}
</script>

<?php echo numberformat($rUserInv2['KnowledgeSharing']);?>
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_KnowledgeSharing_Ceiling'];?></td>
    <td width="144" valign="top"><?php echo numberformat($mmKnowledgeSharing);?></td>
  </tr>
  <?php }?>
  
  <?php if($rowsDynamic['qn_OverheadCosts_status']=='Enable'){?>
  <tr>
    <td width="35" valign="top">7. &nbsp;</td>
    <td width="241" valign="top"><?php echo $rowsDynamic['qn_OverheadCosts'];?></td>
    <td width="561" valign="top">

 <script type="text/javascript">
function fnc7(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) > <?php echo $mmOverheadCostsTotal;?>) 
        return "Overhead costs should not exceed 5% of the total budget which is <?php echo numberformat($mmOverheadCostsTotal);?>"; 
    else return value;
}
</script> 

<?php echo numberformat($rUserInv2['OverheadCosts']);?>
    </td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_OverheadCosts_Ceiling'];?></td>
    <td width="144" valign="top"><?php echo numberformat($mmOverheadCostsTotal);?></td>
  </tr>
  
  <?php }?>
  
  <?php if($rowsDynamic['qn_OtherGoods_status']=='Enable'){?>
  <tr>
    <td width="35" valign="top">8. &nbsp;</td>
    <td width="241" valign="top"><?php echo $rowsDynamic['qn_OtherGoods'];?></td>
    <td width="561" valign="top">
    
     <script type="text/javascript">
function fnc8(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) > <?php echo $mmOtherGoods;?>) 
        return "Other goods costs should not exceed 2% of the total budget which is <?php echo numberformat($mmOtherGoods);?>"; 
    else return value;
}
</script>
<?php echo $rUserInv2['OtherGoods'];?>
    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_OtherGoods_Ceiling'];?></td>
    <td width="144" valign="top">    
    <?php echo numberformat($mmOtherGoods);?>
    
    
    </td>
  </tr>
  <?php }?>
  
  <?php if($rowsDynamic['qn_MatchingSupport_status']=='Enable'){?>
  <tr>
    <td width="35" valign="top">9. &nbsp;</td>
    <td width="241" valign="top"><?php echo $rowsDynamic['qn_MatchingSupport'];?></td>
    <td width="561" valign="top">
    
    <script type="text/javascript">
function fnc9(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value) > <?php echo $mmMatchingSupport;?>) 
        return "Matching Support costs should not exceed 1% of the total budget which is <?php echo numberformat($mmMatchingSupport);?>"; 
    else return value;
}
</script>

<?php echo numberformat($rUserInv2['MatchingSupport']);?>
    
    </td>
   
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_MatchingSupport_Ceiling'];?></td>
    <td width="144" valign="top">    
   <?php echo numberformat(($mmMatchingSupport));?>
    
    
    </td>
  </tr>
  <?php }?>
  
  <tr>
    <td width="35" valign="top">&nbsp;</td>
    <td width="241" valign="top"><p align="center"><strong>TOTAL</strong></td>
    <td width="561" valign="top"><strong></strong></td>
    <td width="86" align="center" valign="top"><strong>100</strong></td>
    <td width="144" valign="top"><?php echo numberformat($SumTotal);?></td>
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