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
	$TotalBudget=$mysqli->real_escape_string($_POST['TotalBudget']);
	$TotalSubmitted=$mysqli->real_escape_string($_POST['TotalSubmitted']);
	
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and `is_sent`='0' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
	$sqlUsers="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$asrmApplctID' and `is_sent`='0' order by id desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."concept_budget (`Personnel`,`PersonnelTotal`,`ResearchCosts`,`ResearchCostsTotal`,`Equipment`,`EquipmentTotal`,`kickoff`,`kickoffTotal`,`Travel`,`TravelTotal`,`KnowledgeSharing`,`KnowledgeSharingTotal`,`OverheadCosts`,`OverheadCostsTotal`,`OtherGoods`,`OtherGoodsTotal`,`MatchingSupport`,`MatchingSupportTotal`,`TotalBudget`,`TotalSubmitted`,`owner_id`,`projectCategory`,`is_sent`,`conceptID`) 

values('$Personnel','$PersonnelTotal','$ResearchCosts','$ResearchCostsTotal','$Equipment','$EquipmentTotal','$kickoff','$kickoffTotal','$Travel','$TravelTotal','$KnowledgeSharing','$KnowledgeSharingTotal','$OverheadCosts','$OverheadCostsTotal','$OtherGoods','$OtherGoodsTotal','$MatchingSupport','$MatchingSupportTotal','$TotalBudget','$TotalSubmitted','$asrmApplctID','Project','0','$conceptm_id')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created Budget");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=conceptReferences'>";

}


if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals


if($totalUsers){
	///update TotalBudget

$sqlA2="update ".$prefix."concept_budget set  `Personnel`='$Personnel',`PersonnelTotal`='$PersonnelTotal',`ResearchCosts`='$ResearchCosts',`ResearchCostsTotal`='$ResearchCostsTotal',`Equipment`='$Equipment',`EquipmentTotal`='$EquipmentTotal',`kickoff`='$kickoff',`kickoffTotal`='$kickoffTotal',`KnowledgeSharing`='$KnowledgeSharing',`KnowledgeSharingTotal`='$KnowledgeSharingTotal',`OverheadCosts`='$OverheadCosts',`OverheadCostsTotal`='$OverheadCostsTotal',`OtherGoods`='$OtherGoods',`OtherGoodsTotal`='$OtherGoodsTotal',`TotalBudget`='$TotalBudget',`TotalSubmitted`='$TotalSubmitted',`conceptID`='$conceptm_id' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';

echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=conceptReferences'>";
	
}//end



		//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and conceptID='$conceptm_id' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `Budget`='1' where `owner_id`='$asrmApplctID' and `conceptID`='$conceptm_id' and status='new'";
$mysqli->query($sqlASubmissionStages);
}	
	


}//end post
$sqlUsers2="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$usrm_id' and `is_sent`='0' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."concept_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<div class="tab">

 <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitConcept/<?php echo $id;?>/'"><?php echo $lang_new_ProjectInformation;?></button>
 
  <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptPrincipalInvestigator/<?php echo $id;?>/'"><?php echo $lang_new_ProjectTeam;?></button>
  
    <button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=conceptIntroduction/<?php echo $id;?>/'"><?php echo $lang_new_Introduction;?></button>
    
   <button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptProjectDetails/<?php echo $id;?>/'"><?php echo $lang_new_ProjectDetails;?></button>
   
  <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'conceptBudget')" id="defaultOpen"><?php echo $lang_new_Budget;?></button>
  
  <button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptReferences/<?php echo $id;?>/'"><?php echo $lang_new_Citations;?></button>
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
<div id="conceptBudget" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <?php include("concept_submit_now_final_button.php");?>
  <h3>Budget</h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 
 <div class="row" style="margin-bottom:15px;">

    <div class="col-100">
     <label for="lname"><strong>Total Budget</strong> <span class="error">*</span></label>
      <input type="text" id="TotalBudget" name="TotalBudget" placeholder=".." class="required number"  value="<?php echo $rUserInv2['TotalBudget'];?>">
    </div>
  </div>
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
   <tr>
    <td width="37" valign="top"><p align="center"><strong>&nbsp;</strong></td>
    <td width="256" valign="top"><p align="center"><strong><?php echo $lang_new_Item;?></strong></td>
    <td width="530" valign="top"><p align="center"><strong>AMOUNT (UGX)</strong></td>
    <td valign="top"><p align="center"><strong>PERCENTAGE CEILING</strong></td>
    <td valign="top"><p align="center"><strong>MAX. ALLOWABLE AMOUNT</strong></td>
    </tr>
  <tr>
    <td width="35" valign="top">1. &nbsp;</td>
    <td width="241" valign="top">Personnel</td>
    <td width="561" valign="top"><input type="text" id="Personnel" name="Personnel" placeholder="The personnel costs (salary top ups) should not be detailed by person but by position" class="required number" onkeyup="addTWD();" value="<?php echo $rUserInv2['Personnel'];?>" ></td>
    <td width="86" valign="top" class="txtalign" align="center">8</td>
    <td width="144" valign="top"><input type="text" id="PersonnelTotal" name="PersonnelTotal" placeholder=".." class="required number" value="<?php echo $rUserInv2['PersonnelTotal'];?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">2. &nbsp;</td>
    <td width="241" valign="top">Research Costs</td>
    <td width="561" valign="top">
   
    <textarea name="ResearchCosts" cols="" rows="" id="ResearchCosts" placeholder="Including travel in the field and costs of accommodation, consumables, research assistance, and other costs" class="required number" onkeyup="addTWD();"><?php echo $rUserInv2['ResearchCosts'];?></textarea> 
</td>
    <td width="86" valign="top" class="txtalign" align="center">60</td>
    <td width="144" valign="top"><input type="text" id="ResearchCostsTotal" name="ResearchCostsTotal" placeholder=".." class="required number" value="<?php echo $rUserInv2['ResearchCostsTotal'];?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">3. &nbsp;</td>
    <td width="241" valign="top">Equipment</td>
    <td width="561" valign="top">
    <input type="text" id="Equipment" name="Equipment" placeholder="A max of 15% budget may be allowed for small equipment" class="required number" onkeyup="addTWD();" value="<?php echo $rUserInv2['Equipment'];?>">
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center">15</td>
    <td width="144" valign="top"><input type="text" id="EquipmentTotal" name="EquipmentTotal" placeholder=".." class="required number" value="<?php echo $rUserInv2['EquipmentTotal'];?>" readonly="readonly"></td>
  </tr>
<tr>
    <td width="35" valign="top">4. &nbsp;</td>
    <td width="241" valign="top">Travel and Subsistence</td>
    <td width="561" valign="top">
    <input type="text" id="Travel" name="Travel" placeholder="" class="required number" onkeyup="addTWD();" value="<?php echo $rUserInv2['Travel'];?>">
    </td>
    <td width="86" valign="top" class="txtalign" align="center">2</td>
    <td width="144" valign="top"><input type="text" id="TravelTotal" name="TravelTotal" placeholder=".." class="required number" value="<?php echo $rUserInv2['TravelTotal'];?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">5. &nbsp;</td>
    <td width="241" valign="top">Grant kick-off, mid-term and final workshops</td>
    <td width="561" valign="top">
    <input type="text" id="kickoff" name="kickoff" placeholder="A minimum of 2 participants per project are expected to attend each workshop" class="required number" onkeyup="addTWD();" value="<?php echo $rUserInv2['kickoff'];?>">
    </td>
    <td width="86" valign="top" class="txtalign" align="center">2</td>
    <td width="144" valign="top"><input type="text" id="kickoffTotal" name="kickoffTotal" placeholder=".." class="required number" value="<?php echo $rUserInv2['kickoffTotal'];?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">6. &nbsp;</td>
    <td width="241" valign="top">Knowledge Sharing and Research Uptake</td>
    <td width="561" valign="top">

    
    <textarea name="KnowledgeSharing" id="KnowledgeSharing" cols="" rows="" placeholder="May include both costs for scientific publications    (e.g. open Access publication) and other dissemination materials (e.g.    reports, leaflets, websites etc.), workshops and training of stakeholder    engagement, capacity building and communication targeting end user and public." class="required number" onkeyup="addTWD();"><?php echo $rUserInv2['KnowledgeSharing'];?></textarea>
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center">5</td>
    <td width="144" valign="top"><input type="text" id="KnowledgeSharingTotal" name="KnowledgeSharingTotal" placeholder=".." class="required number" value="<?php echo $rUserInv2['KnowledgeSharingTotal'];?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">7. &nbsp;</td>
    <td width="241" valign="top">Overhead costs</td>
    <td width="561" valign="top">

    <textarea name="OverheadCosts" id="OverheadCosts" cols="" rows="" placeholder="All eligible costs which can not be identified as being directly allocated to the project but which can be justified by the accounting system of the beneficiary organization." class="required number" onkeyup="addTWD();"><?php echo $rUserInv2['OverheadCosts'];?></textarea>
    
    </td>
    <td width="86" valign="top" class="txtalign" align="center">5</td>
    <td width="144" valign="top"><input type="text" id="OverheadCostsTotal" name="OverheadCostsTotal" placeholder=".." class="required number" value="<?php echo $rUserInv2['OverheadCostsTotal'];?>" readonly="readonly"></td>
  </tr>
  <tr>
    <td width="35" valign="top">8. &nbsp;</td>
    <td width="241" valign="top">Other goods and services<br>
      Others (Specify)</td>
    <td width="561" valign="top">
<input type="text" id="OtherGoods" name="OtherGoods" placeholder="Should list any other cost that can not be categorized in the above section." class="required number" onkeyup="addTWD();" value="<?php echo $rUserInv2['OtherGoods'];?>">
    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center">5</td>
    <td width="144" valign="top">    
    <input type="text" id="OtherGoodsTotal" name="OtherGoodsTotal" placeholder=".." class="required number" value="<?php echo $rUserInv2['OtherGoodsTotal'];?>" readonly="readonly">
    
    
    </td>
  </tr>
  
  
  <tr>
    <td width="35" valign="top">9. &nbsp;</td>
    <td width="241" valign="top">Matching Support if any</td>
    <td width="561" valign="top">
<input type="text" id="MatchingSupport" name="MatchingSupport" placeholder="Give a detailed breakdown of another source of funding and the contribution of the host institution to the project. The contribution of the host institution may be in cash or kind." class="required number" onkeyup="addTWD();" value="<?php echo $rUserInv2['MatchingSupport'];?>">
    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center">1</td>
    <td width="144" valign="top">    
    <input type="text" id="MatchingSupportTotal" name="MatchingSupportTotal" placeholder=".." class="required number" value="<?php echo $rUserInv2['MatchingSupportTotal'];?>" readonly="readonly">
    
    
    </td>
  </tr>
  
  <tr>
    <td width="35" valign="top">&nbsp;</td>
    <td width="241" valign="top"><p align="center"><strong>TOTAL</strong></td>
    <td width="561" valign="top">&nbsp;</td>
    <td width="86" align="center" valign="top"><strong>100</strong></td>
    <td width="144" valign="top"><input type="text" id="TotalSubmitted" name="TotalSubmitted" placeholder=".." class="required number" value="<?php echo $rUserInv2['TotalSubmitted'];?>" readonly="readonly"></td>
  </tr>
</table>

<div style="clear:both;"></div>

  <div class="row success">
    <input type="submit" name="doSaveData" value="Save and Next">
  </div>


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