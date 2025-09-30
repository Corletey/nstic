<?php
if($_POST['doSaveData']=='Save and Next' and $_POST['Personnel'] and $_POST['PersonnelTotal'] and $_POST['asrmApplctID']){

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
	$project_detail_id=$mysqli->real_escape_string($_POST['project_detail_id']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and `is_sent`='0' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
	$sqlUsers="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$asrmApplctID' and `is_sent`='1' order by id desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();
///Check total submitted budget
$totalsubmittedbyUser=($Personnel+$ResearchCosts+$Equipment+$kickoff+$Travel+$KnowledgeSharing);
	
if($totalUsers and $_POST['asrmApplctID'] and $TotalSubmitted>=$totalsubmittedbyUser and $ResearchCosts>=$ResearchCostsTotal){

$sqlA2="update ".$prefix."concept_budget set  `Personnel`='$Personnel',`PersonnelTotal`='$PersonnelTotal',`ResearchCosts`='$ResearchCosts',`ResearchCostsTotal`='$ResearchCostsTotal',`Equipment`='$Equipment',`EquipmentTotal`='$EquipmentTotal',`kickoff`='$kickoff',`kickoffTotal`='$kickoffTotal',`KnowledgeSharing`='$KnowledgeSharing',`KnowledgeSharingTotal`='$KnowledgeSharingTotal',`OverheadCosts`='$OverheadCosts',`OverheadCostsTotal`='$OverheadCostsTotal',`OtherGoods`='$OtherGoods',`OtherGoodsTotal`='$OtherGoodsTotal',`TotalBudget`='$TotalBudget',`TotalSubmitted`='$TotalSubmitted' where owner_id='$asrmApplctID' and id='$project_detail_id'";// and is_sent='1'
$mysqli->query($sqlA2);

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
/*echo("<script>location.href = '".$base_url."'main.php?option=proposalResults/';</script>");*/
}

if($totalsubmittedbyUser>$TotalSubmitted){
$message='<p class="error2">Dear '.$session_fullname.', the total of your budget entries exceeds the total budget you provided under project details. You may edit the total budget cost under project details or the entries in this table.</p>';
$highlightfield='true';	
}
if($ResearchCosts<$ResearchCostsTotal){
$message='<p class="error2">Dear '.$session_fullname.', Research Costs should NOT be lessthan 60% of MAX. ALLOWABLE AMOUNT.</p>';
$highlightfield='true';	
}
		//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `Budget`='1' where `owner_id`='$asrmApplctID' and status='new'";
$mysqli->query($sqlASubmissionStages);
}
	


}//end post
$sessionusrm_id=$_SESSION['usrm_id'];
$sqlUsers2="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$sessionusrm_id' and `is_sent`='1' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$conceptID=$rUserInv2['conceptID'];

$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<div class="tab">

 <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitProposal&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>

<button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalResearchTeam&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>

  <button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBackground&id=<?php echo $id;?>'"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalMethodology&id=<?php echo $id;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'proposalBudget')" id="defaultOpen"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalResults&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectResults;?></button>
  
  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalManagement&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalFollowup&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
</div>
 <?php
$sqlUsersBudget="SELECT * FROM ".$prefix."project_details_concept where `owner_id`='$usrm_id' order by id desc limit 0,1";//and `is_sent`='1' 
$QueryUsersBudget = $mysqli->query($sqlUsersBudget);
$rUserInvBudget=$QueryUsersBudget->fetch_array();
$TotalBudget=$rUserInvBudget['TotalBudget'];
$project_detail_id=$rUserInvBudget['id'];
?>

<script language="JAVASCRIPT">

  <!--

 /* function addTWD() {
//document.regForm.PersonnelTotal.value = (parseInt(document.regForm.Personnel.value)*8/100); document.regForm.PersonnelTotal.value = 8/100*(parseInt(document.regForm.Personnel.value));
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

  }*/
 
  </script>	


<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<div id="proposalBudget" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <?php include("proposal_submit_now_final_button.php");?>
  <h3>Budget</h3>
<?php if($message){echo $message;}?>
<div class="success">

<form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 
 <div class="row" style="margin-bottom:15px;">

    <div class="col-100">
     <label for="lname"><strong>Total Budget</strong> <span class="error">*</span></label>
      <input type="text" id="TotalBudget" name="TotalBudget" placeholder=".." class="requiredm number"  value="<?php echo numberformat($TotalBudget);?> <?php echo $rUserInvBudget['currencyPrimaryFunder'];?>" required readonly="readonly">
    </div>
  </div>
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">
 <?php
 $mmPersonnelTotal=($TotalBudget*0.08);
$mmResearchCosts=($TotalBudget*0.6);
$mmEquipmentTotal=($TotalBudget*0.15);
$mmTravel=($TotalBudget*0.02);
$mmkickoff=($TotalBudget*0.02);
$mmKnowledgeSharing=($TotalBudget*0.05);
$mmOverheadCostsTotal=($TotalBudget*0.05);
$mmOtherGoods=($TotalBudget*0.02);
$mmMatchingSupport=($TotalBudget*0.01);

$SumTotal=($mmPersonnelTotal+$mmResearchCosts+$mmEquipmentTotal+$mmTravel+$mmkickoff+$mmKnowledgeSharing+$mmOverheadCostsTotal+$mmOtherGoods+$mmMatchingSupport);
?>

<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
   <tr>
    <td width="37" valign="top"><p align="center"><strong>&nbsp;</strong></td>
    <td width="256" valign="top"><p align="center"><strong><?php echo $lang_new_Item;?></strong></td>
    <td width="530" valign="top"><p align="center"><strong><?php echo $lang_new_Amount;?> (<?php echo $rUserInvBudget['currencyPrimaryFunder'];?>)</strong></td>
    <td valign="top"><p align="center"><strong><?php echo $lang_new_PercentageCeiling;?></strong></td>
    <td valign="top"><p align="center"><strong><?php echo $lang_new_MaAllowableAmount;?></strong></td>
    </tr>
  <tr>
    <td width="35" valign="top">1. &nbsp;</td>
    <td width="241" valign="top">Personnel</td>
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
    
    
    <input type="text" id="Personnel" name="Personnel" placeholder="The personnel costs (salary top ups) should not be detailed by person but by position" class="requiredm number" value="<?php if($rUserInv2['Personnel']){echo $rUserInv2['Personnel'];}else{ echo $_POST['Personnel'];}?>" maxlength="<?php echo $mmPersonnelTotal;?>" required onkeyup="this.value = fnc(this.value, 0, <?php echo $mmPersonnelTotal;?>)">
    
    <input name="project_detail_id" type="hidden" value="<?php echo $project_detail_id;?>"/>
  

    
    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center">8</td>
    <td width="144" valign="top">
    <input type="text" id="PersonnelTotal" name="PersonnelTotal" placeholder=".." class="requiredm number" value="<?php echo ($TotalBudget*0.08);?>" required  readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">2. &nbsp;</td>
    <td width="241" valign="top">Research Costs</td>
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
    <textarea name="ResearchCosts" cols="" rows="" id="ResearchCosts" placeholder="Including travel in the field and costs of accommodation, consumables, research assistance, and other costs" class="requiredm number" onkeyup="this.value = fnc2(this.value, 0, <?php echo $mmResearchCosts;?>)" style="<?php echo $mm;?>"><?php if($rUserInv2['ResearchCosts']){echo $rUserInv2['ResearchCosts'];}else{ echo $_POST['ResearchCosts'];}?></textarea> 
</td>
    <td width="86" valign="top" class="txtalign" align="center">60</td>
    <td width="144" valign="top"><input type="text" id="ResearchCostsTotal" name="ResearchCostsTotal" placeholder=".." class="requiredm number" value="<?php echo ($TotalBudget*0.6);?>" required  readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">3. &nbsp;</td>
    <td width="241" valign="top">Equipment</td>
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

    <input type="text" id="Equipment" name="Equipment" placeholder="A max of 15% budget may be allowed for small equipment" class="requiredm number" required onkeyup="this.value = fnc3(this.value, 0, <?php echo $mmEquipmentTotal;?>)" value="<?php if($rUserInv2['Equipment']){echo $rUserInv2['Equipment'];}else{ echo $_POST['Equipment'];}?>">
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center">15</td>
    <td width="144" valign="top"><input type="text" id="EquipmentTotal" name="EquipmentTotal" placeholder=".." class="requiredm number" value="<?php echo ($TotalBudget*0.15);?>" required  readonly="readonly"></td>
  </tr>
<tr>
    <td width="35" valign="top">4. &nbsp;</td>
    <td width="241" valign="top">Travel and Subsistence</td>
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

    <input type="text" id="Travel" name="Travel" placeholder="" class="requiredm number" required onkeyup="this.value = fnc4(this.value, 0, <?php echo $mmTravel;?>)" value="<?php if($rUserInv2['Travel']){echo $rUserInv2['Travel'];}else{ echo $_POST['Travel'];}?>">
    </td>
    <td width="86" valign="top" class="txtalign" align="center">2</td>
    <td width="144" valign="top"><input type="text" id="TravelTotal" name="TravelTotal" placeholder=".." class="requiredm number" value="<?php echo ($TotalBudget*0.02);?>" required readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">5. &nbsp;</td>
    <td width="241" valign="top">Grant kick-off, mid-term and final workshops</td>
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

    <input type="text" id="kickoff" name="kickoff" placeholder="A minimum of 2 participants per project are expected to attend each workshop" class="requiredm number" required onkeyup="this.value = fnc5(this.value, 0, <?php echo $mmkickoff;?>)" value="<?php if($rUserInv2['kickoff']){echo $rUserInv2['kickoff'];}else{ echo $_POST['kickoff'];}?>" >
    </td>
    <td width="86" valign="top" class="txtalign" align="center">2</td>
    <td width="144" valign="top"><input type="text" id="kickoffTotal" name="kickoffTotal" placeholder=".." class="requiredm number" value="<?php echo ($TotalBudget*0.02);?>" required readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">6. &nbsp;</td>
    <td width="241" valign="top">Knowledge Sharing and Research Uptake</td>
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

    <textarea name="KnowledgeSharing" id="KnowledgeSharing" cols="" rows="" placeholder="May include both costs for scientific publications    (e.g. open Access publication) and other dissemination materials (e.g.    reports, leaflets, websites etc.), workshops and training of stakeholder    engagement, capacity building and communication targeting end user and public." class="requiredm number" required onkeyup="this.value = fnc6(this.value, 0, <?php echo $mmKnowledgeSharing;?>)"><?php if($rUserInv2['KnowledgeSharing']){echo $rUserInv2['KnowledgeSharing'];}else{ echo $_POST['KnowledgeSharing'];}?></textarea>
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center">5</td>
    <td width="144" valign="top"><input type="text" id="KnowledgeSharingTotal" name="KnowledgeSharingTotal" placeholder=".." class="requiredm number" value="<?php echo ($TotalBudget*0.05);?>" required readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">7. &nbsp;</td>
    <td width="241" valign="top">Overhead costs</td>
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

    <textarea name="OverheadCosts" id="OverheadCosts" cols="" rows="" placeholder="All eligible costs which can not be identified as being directly allocated to the project but which can be justified by the accounting system of the beneficiary organization." class="requiredm number" required onkeyup="this.value = fnc7(this.value, 0, <?php echo $mmOverheadCostsTotal;?>)"><?php if($rUserInv2['OverheadCosts']){echo $rUserInv2['OverheadCosts'];}else{ echo $_POST['OverheadCosts'];}?></textarea>
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center">5</td>
    <td width="144" valign="top"><input type="text" id="OverheadCostsTotal" name="OverheadCostsTotal" placeholder=".." class="requiredm number" value="<?php echo ($TotalBudget*0.05);?>" required readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">8. &nbsp;</td>
    <td width="241" valign="top">Other goods and services<br>
      Others (Specify)</td>
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

<input type="text" id="OtherGoods" name="OtherGoods" placeholder="Should list any other cost that can not be categorized in the above section." class="requiredm number" required onkeyup="this.value = fnc8(this.value, 0, <?php echo $mmOtherGoods;?>)" value="<?php if($rUserInv2['OtherGoods']){echo $rUserInv2['OtherGoods'];}else{ echo $_POST['OtherGoods'];}?>">
    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center">2</td>
    <td width="144" valign="top">    
    <input type="text" id="OtherGoodsTotal" name="OtherGoodsTotal" placeholder=".." class="requiredm number" value="<?php echo ($TotalBudget*0.02);?>" required readonly="readonly">
    
    
    </td>
  </tr>
  
  
  <tr>
    <td width="35" valign="top">9. &nbsp;</td>
    <td width="241" valign="top">Matching Support if any</td>
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

<input type="text" id="MatchingSupport" name="MatchingSupport" placeholder="Give a detailed breakdown of another source of funding and the contribution of the host institution to the project. The contribution of the host institution may be in cash or kind." class="requiredm number"  value="<?php if($rUserInv2['MatchingSupport']){echo $rUserInv2['MatchingSupport'];}else{ echo $_POST['MatchingSupport'];}?>" required onkeyup="this.value = fnc9(this.value, 0, <?php echo $mmMatchingSupport;?>)">
    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center">1</td>
    <td width="144" valign="top">    
    <input type="text" id="MatchingSupportTotal" name="MatchingSupportTotal" placeholder=".." class="requiredm number" value="<?php echo ($TotalBudget*0.01);?>" required readonly="readonly">
    
    
    </td>
  </tr>
  
  <tr>
    <td width="35" valign="top">&nbsp;</td>
    <td width="241" valign="top"><p align="center"><strong>TOTAL</strong></td>
    <td width="561" valign="top"><strong><?php if($_POST['Personnel']){
echo numberformat(($_POST['Personnel']+$_POST['ResearchCosts']+$_POST['Equipment']+$_POST['Travel']+$_POST['kickoff']+$_POST['KnowledgeSharing']+$_POST['OverheadCosts']+$_POST['OtherGoods']+$_POST['MatchingSupportTotal']));
}else{
echo numberformat(($rUserInv2['Personnel']+$rUserInv2['ResearchCosts']+$rUserInv2['Equipment']+$rUserInv2['Travel']+$rUserInv2['kickoff']+$rUserInv2['KnowledgeSharing']+$rUserInv2['OverheadCosts']+$rUserInv2['OtherGoods']+$rUserInv2['MatchingSupportTotal']));
}?></strong></td>
    <td width="86" align="center" valign="top"><strong>100</strong></td>
    <td width="144" valign="top"><input type="text" id="TotalSubmitted" name="TotalSubmitted" placeholder=".." class="required number" value="<?php echo $SumTotal;?>" ></td>
  </tr>
</table>

<div style="clear:both;"></div>

  <div class="row success">
    <input type="submit" name="doSaveData" value="Save and Next">
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