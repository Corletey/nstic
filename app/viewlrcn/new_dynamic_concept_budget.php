<?php
if($_POST['doSaveData'] and $_POST['Personnel'] and $_POST['PersonnelTotal'] and $_POST['asrmApplctID'] and $id){

	
$Personnel=$mysqli->real_escape_string($_POST['Personnel']);
	$PersonnelTotal=$mysqli->real_escape_string($_POST['PersonnelTotal']);
	$ResearchCosts=$mysqli->real_escape_string($_POST['ResearchCosts']);
	$ResearchCostsTotal=$mysqli->real_escape_string($_POST['ResearchCostsTotal']);
	$Equipment=$mysqli->real_escape_string($_POST['Equipment']);
	$EquipmentTotal=$mysqli->real_escape_string($_POST['EquipmentTotal']);
	$kickoff=$mysqli->real_escape_string($_POST['kickoff']);
	$kickoffTotal=$mysqli->real_escape_string($_POST['kickoffTotal']);
	$Travel=$mysqli->real_escape_string($_POST['Travel']);
	$TravelTotal=$mysqli->real_escape_string($_POST['TravelTotal']);
	$KnowledgeSharing=$mysqli->real_escape_string($_POST['KnowledgeSharing']);
	$KnowledgeSharingTotal=$mysqli->real_escape_string($_POST['KnowledgeSharingTotal']);
	
	$OverheadCosts=$mysqli->real_escape_string($_POST['OverheadCosts']);
	$OverheadCostsTotal=$mysqli->real_escape_string($_POST['OverheadCostsTotal']);
	$OtherGoods=$mysqli->real_escape_string($_POST['OtherGoods']);
	$OtherGoodsTotal=$mysqli->real_escape_string($_POST['OtherGoodsTotal']);
	$MatchingSupport=$mysqli->real_escape_string($_POST['MatchingSupport']);
	$MatchingSupportTotal=$mysqli->real_escape_string($_POST['MatchingSupportTotal']);
	
	$TotalSubmitted=$mysqli->real_escape_string($_POST['TotalSubmitted']);
	
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
	$sqlUsers="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$asrmApplctID' and grantcallID='$id' order by id desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();
///Check total submitted budget
$totalsubmittedbyUser=($Personnel+$ResearchCosts+$Equipment+$kickoff+$Travel+$KnowledgeSharing);
	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."concept_budget (`Personnel`,`PersonnelTotal`,`ResearchCosts`,`ResearchCostsTotal`,`Equipment`,`EquipmentTotal`,`kickoff`,`kickoffTotal`,`Travel`,`TravelTotal`,`KnowledgeSharing`,`KnowledgeSharingTotal`,`OverheadCosts`,`OverheadCostsTotal`,`OtherGoods`,`OtherGoodsTotal`,`MatchingSupport`,`MatchingSupportTotal`,`TotalBudget`,`TotalSubmitted`,`owner_id`,`projectCategory`,`is_sent`,`conceptID`,`grantcallID`) 

values('$Personnel','$PersonnelTotal','$ResearchCosts','$ResearchCostsTotal','$Equipment','$EquipmentTotal','$kickoff','$kickoffTotal','$Travel','$TravelTotal','$KnowledgeSharing','$KnowledgeSharingTotal','$OverheadCosts','$OverheadCostsTotal','$OtherGoods','$OtherGoodsTotal','$MatchingSupport','$MatchingSupportTotal','$TotalBudget','$TotalSubmitted','$asrmApplctID','Project','0','$conceptm_id','$id')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

		//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and conceptID='$conceptm_id' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `Budget`='1' where `owner_id`='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created Budget");

/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newconceptReferences/$id';</script>");*/

}

if($totalsubmittedbyUser>$TotalSubmitted){
	$message='<p class="error2">Dear '.$session_fullname.', the total of your budget entries exceeds the total budget you provided under project details. You may edit the total budget cost under project details or the entries in this table.</p>';
	$highlightfield='true';	
}


}	/////end totals

/*if($record_id<=0){
$message='<p class="error2">Details have not been saved. Re-enter and submit again.</p>';	
}*/

if($totalUsers){
	///update TotalBudget
if($TotalSubmitted>=$totalsubmittedbyUser and $ResearchCosts<=$ResearchCostsTotal){
$sqlA2="update ".$prefix."concept_budget set  `Personnel`='$Personnel',`PersonnelTotal`='$PersonnelTotal',`ResearchCosts`='$ResearchCosts',`ResearchCostsTotal`='$ResearchCostsTotal',`Equipment`='$Equipment',`EquipmentTotal`='$EquipmentTotal',`kickoff`='$kickoff',`kickoffTotal`='$kickoffTotal',`KnowledgeSharing`='$KnowledgeSharing',`KnowledgeSharingTotal`='$KnowledgeSharingTotal',`OverheadCosts`='$OverheadCosts',`OverheadCostsTotal`='$OverheadCostsTotal',`OtherGoods`='$OtherGoods',`OtherGoodsTotal`='$OtherGoodsTotal',`TotalBudget`='$TotalBudget',`TotalSubmitted`='$TotalSubmitted',`Travel`='$Travel',`MatchingSupport`='$MatchingSupport' where owner_id='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlA2);

/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newconceptReferences/$id';</script>");*/
}
if($totalsubmittedbyUser>$TotalSubmitted){
$message='<p class="error2">Dear '.$session_fullname.', the total of your budget entries exceeds the total budget you provided under project details. You may edit the total budget cost under project details or the entries in this table.</p>';
$highlightfield='true';	
}




		//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `Budget`='1' where `owner_id`='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}	
	
}//end



	


}//end post
$sqlUsers2="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$usrm_id' and grantcallID='$id' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."concept_stages where  owner_id='$sessionusrm_id' and grantcallID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<div class="tab">
<?php require_once("dynamic_categories.php");?>

  <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newSubmitConcept&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
 
<?php if($total_Team){?><button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
<?php if($total_Introduction){?> <button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button><?php }?>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?> <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newconceptBudget')" id="defaultOpen"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
<?php if($total_Attachments){?><button <?php if($rUConceptStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptAttachments&id=<?php echo $id;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>
   
   
</div>
 <?php
$sqlUsersBudget="SELECT * FROM ".$prefix."project_details_concept where `owner_id`='$usrm_id' and grantcallID='$id' order by id desc limit 0,1";
$QueryUsersBudget = $mysqli->query($sqlUsersBudget);
$rUserInvBudget=$QueryUsersBudget->fetch_array();
$TotalBudget=$rUserInvBudget['TotalBudget'];


$sqlUsers4="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$usrm_id' and grantcallID='$id' order by conceptID desc limit 0,1";
$QueryUsers4 = $mysqli->query($sqlUsers4);
$rUserInv4=$QueryUsers4->fetch_array();
$TotalBudget=$rUserInv4['TotalBudget'];
?>
<script type="text/javascript">
function imposeMinMax(el){
  if(el.value != ""){
    if(parseInt(el.value) < parseInt(el.min)){
      el.value = el.min;
    }
    if(parseInt(el.value) > parseInt(el.max)){
      el.value = el.max;
    }
  }
}</script>
<script language="JAVASCRIPT">

  <!--

 function addTWD() {

/*document.regForm.PersonnelTotal.value = 8/100*(parseInt(document.regForm.Personnel.value));
document.regForm.ResearchCostsTotal.value = 60/100*(parseInt(document.regForm.ResearchCosts.value));
document.regForm.EquipmentTotal.value = 15/100*(parseInt(document.regForm.Equipment.value));
document.regForm.kickoffTotal.value = 2/100*(parseInt(document.regForm.kickoff.value));
document.regForm.TravelTotal.value = 2/100*(parseInt(document.regForm.Travel.value));
document.regForm.KnowledgeSharingTotal.value = 5/100*(parseInt(document.regForm.KnowledgeSharing.value));
document.regForm.OverheadCostsTotal.value = 5/100*(parseInt(document.regForm.OverheadCosts.value));
document.regForm.OtherGoodsTotal.value = 5/100*(parseInt(document.regForm.OtherGoods.value));
document.regForm.MatchingSupportTotal.value = 2/100*(parseInt(document.regForm.MatchingSupport.value));
*/

  }
 
  </script>	


<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<div id="newconceptBudget" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <?php include("concept_submit_now_final_button.php");?>
 <h3><?php echo $lang_Budget;?></h3>
<?php if($message){echo $message;}?>
<div class="success">
<?php
$sqlDynamic="SELECT * FROM ".$prefix."concept_dynamic_questions_all_e where categorym='concept' and grantID='$id' order by id asc";
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
$SumTotal=($mmPersonnelTotal+$mmResearchCosts+$mmEquipmentTotal+$mmTravel+$mmkickoff+$mmKnowledgeSharing+$mmOverheadCostsTotal+$mmOtherGoods+$mmMatchingSupport);/**/
	?>

<form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 
 <div class="row" style="margin-bottom:15px;">

    <div class="col-100">
     <label for="lname"><strong><?php echo $lang_new_TotalBudgetCost;?></strong> <span class="error">*</span></label>
      <input type="text" id="TotalBudget" name="TotalBudget" placeholder=".." class="requiredm number"  value="<?php echo numberformat($TotalBudget);?> <?php echo $rUserInvBudget['currencyPrimaryFunder'];?>" required readonly="readonly">
    </div>
  </div>
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">


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
    
    
    <input type="text" id="Personnel" name="Personnel" placeholder="The personnel costs (salary top ups) should not be detailed by person but by position" class="requiredm number" value="<?php if($rUserInv2['Personnel']){echo $rUserInv2['Personnel'];}else{ echo $_POST['Personnel'];}?>" min="1" max="<?php echo $mmPersonnelTotal;?>" onkeyup="imposeMinMax(this)">
    
    <input name="project_detail_id" type="hidden" value="<?php echo $project_detail_id;?>"/>
  

    
    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_PersonnelPercentage_Ceiling'];?></td>
    <td width="144" valign="top">
    <input type="text" id="PersonnelTotal" name="PersonnelTotal" placeholder=".." class="requiredm number" value="<?php echo ($mmPersonnelTotal);?>" required  readonly="readonly"></td>
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
    
 <input type="text" id="ResearchCosts" name="ResearchCosts" placeholder="Including travel in the field and costs of accommodation, consumables, research assistance, and other costs" class="requiredm number"  value="<?php if($rUserInv2['OverheadCosts']){echo $rUserInv2['ResearchCosts'];}else{ echo $_POST['ResearchCosts'];}?>" required  min="1" max="<?php echo $mmResearchCosts;?>" onkeyup="imposeMinMax(this)">
</td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_ResearchCosts_Ceiling'];?></td>
    <td width="144" valign="top"><input type="text" id="ResearchCostsTotal" name="ResearchCostsTotal" placeholder=".." class="requiredm number" value="<?php echo ($mmResearchCosts);?>" required  readonly="readonly"></td>
  </tr><?php }?>
  
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
        return "Equipment costs should not exceed 15% of the total budget which is <?php echo numberformat($mmEquipmentTotal);?>"; 
    else return value;
}
</script>

    <input type="text" id="Equipment" name="Equipment" placeholder="A max of 15% budget may be allowed for small equipment" class="requiredm number" required min="1" max="<?php echo $mmEquipmentTotal;?>" onkeyup="imposeMinMax(this)" value="<?php if($rUserInv2['Equipment']){echo $rUserInv2['Equipment'];}else{ echo $_POST['Equipment'];}?>">
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_Equipment_Ceiling'];?></td>
    <td width="144" valign="top"><input type="text" id="EquipmentTotal" name="EquipmentTotal" placeholder=".." class="requiredm number" value="<?php echo ($mmEquipmentTotal);?>" required  readonly="readonly"></td>
  </tr><?php }?>
  
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
        return "Travel and Subsistence costs should not exceed 2% of the total budget which is <?php echo numberformat($mmTravel);?>"; 
    else return value;
}
</script>

    <input type="text" id="Travel" name="Travel" placeholder="" class="requiredm number" required min="1" max="<?php echo $mmTravel;?>" onkeyup="imposeMinMax(this)"value="<?php if($rUserInv2['Travel']){echo $rUserInv2['Travel'];}else{ echo $_POST['Travel'];}?>">
    </td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_Travel_Ceiling'];?></td>
    <td width="144" valign="top"><input type="text" id="TravelTotal" name="TravelTotal" placeholder=".." class="requiredm number" value="<?php echo ($mmTravel);?>" required readonly="readonly"></td>
  </tr><?php }?>
  
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

    <input type="text" id="kickoff" name="kickoff" placeholder="A minimum of 2 participants per project are expected to attend each workshop" class="requiredm number" required min="1" max="<?php echo $mmkickoff;?>" onkeyup="imposeMinMax(this)" value="<?php if($rUserInv2['kickoff']){echo $rUserInv2['kickoff'];}else{ echo $_POST['kickoff'];}?>" >
    </td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_kickoff_Ceiling'];?></td>
    <td width="144" valign="top"><input type="text" id="kickoffTotal" name="kickoffTotal" placeholder=".." class="requiredm number" value="<?php echo ($mmkickoff);?>" required readonly="readonly"></td>
  </tr><?php }?>
  
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
    
    <input type="text" id="KnowledgeSharing" name="KnowledgeSharing" placeholder="May include both costs for scientific publications    (e.g. open Access publication) and other dissemination materials (e.g.    reports, leaflets, websites etc.), workshops and training of stakeholder    engagement, capacity building and communication targeting end user and public." class="requiredm number"  value="<?php if($rUserInv2['KnowledgeSharing']){echo $rUserInv2['KnowledgeSharing'];}else{ echo $_POST['KnowledgeSharing'];}?>" required  min="1" max="<?php echo $mmKnowledgeSharing;?>" onkeyup="imposeMinMax(this)">
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_KnowledgeSharing_Ceiling'];?></td>
    <td width="144" valign="top"><input type="text" id="KnowledgeSharingTotal" name="KnowledgeSharingTotal" placeholder=".." class="requiredm number" value="<?php echo ($mmKnowledgeSharing);?>" required readonly="readonly"></td>
  </tr><?php }?>
  
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

    
    <input type="text" id="OverheadCosts" name="OverheadCosts" placeholder="All eligible costs which can not be identified as being directly allocated to the project but which can be justified by the accounting system of the beneficiary organization." class="requiredm number"  value="<?php if($rUserInv2['OverheadCosts']){echo $rUserInv2['OverheadCosts'];}else{ echo $_POST['OverheadCosts'];}?>" required  min="1" max="<?php echo $mmOverheadCostsTotal;?>" onkeyup="imposeMinMax(this)">
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_OverheadCosts_Ceiling'];?></td>
    <td width="144" valign="top"><input type="text" id="OverheadCostsTotal" name="OverheadCostsTotal" placeholder=".." class="requiredm number" value="<?php echo ($mmOverheadCostsTotal);?>" required readonly="readonly"></td>
  </tr><?php }?>
  
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


<input type="text" id="OtherGoods" name="OtherGoods" placeholder="Should list any other cost that can not be categorized in the above section." class="requiredm number"  value="<?php if($rUserInv2['OtherGoods']){echo $rUserInv2['OtherGoods'];}else{ echo $_POST['OtherGoods'];}?>" required  min="1" max="<?php echo $mmOtherGoods;?>" onkeyup="imposeMinMax(this)">
    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_OverheadCosts_Ceiling'];?></td>
    <td width="144" valign="top">    
    <input type="text" id="OtherGoodsTotal" name="OtherGoodsTotal" placeholder=".." class="requiredm number" value="<?php echo ($mmOtherGoods);?>" required readonly="readonly">
    
    
    </td>
  </tr><?php }?>
  
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

<input type="text" id="MatchingSupport" name="MatchingSupport" placeholder="Give a detailed breakdown of another source of funding and the contribution of the host institution to the project. The contribution of the host institution may be in cash or kind." class="requiredm number"  value="<?php if($rUserInv2['MatchingSupport']){echo $rUserInv2['MatchingSupport'];}else{ echo $_POST['MatchingSupport'];}?>" required  min="1" max="<?php echo $mmMatchingSupport;?>" onkeyup="imposeMinMax(this)">
    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rowsDynamic['qn_MatchingSupport_Ceiling'];?></td>
    <td width="144" valign="top">    
    <input type="text" id="MatchingSupportTotal" name="MatchingSupportTotal" placeholder=".." class="requiredm number" value="<?php echo ($mmMatchingSupport);?>" required readonly="readonly">
    
    
    </td>
  </tr><?php }?>
  
  <tr>
    <td width="35" valign="top">&nbsp;</td>
    <td width="241" valign="top"><p align="center"><strong><?php echo $lang_new_TotalBudgetCost;?></strong></td>
    <td width="561" valign="top"><strong><?php /*if($_POST['Personnel']){
echo numberformat(($_POST['Personnel']+$_POST['ResearchCosts']+$_POST['Equipment']+$_POST['Travel']+$_POST['kickoff']+$_POST['KnowledgeSharing']+$_POST['OverheadCosts']+$_POST['OtherGoods']+$_POST['MatchingSupportTotal']));
}else{
echo numberformat(($rUserInv2['Personnel']+$rUserInv2['ResearchCosts']+$rUserInv2['Equipment']+$rUserInv2['Travel']+$rUserInv2['kickoff']+$rUserInv2['KnowledgeSharing']+$rUserInv2['OverheadCosts']+$rUserInv2['OtherGoods']+$rUserInv2['MatchingSupportTotal']));
}*/?></strong></td>
    <td width="86" align="center" valign="top"><strong>100</strong></td>
    <td width="144" valign="top"><input type="text" id="TotalSubmitted" name="TotalSubmitted" placeholder=".." class="required number" value="<?php echo $SumTotal;?>" ></td>
  </tr>
</table>

<div style="clear:both;"></div>

  <div class="row success">
    <input type="submit" name="doSaveData" value="<?php echo $lang_new_Save;?>">
  </div>


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