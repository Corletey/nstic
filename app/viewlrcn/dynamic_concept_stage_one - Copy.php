<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$_GET['categoryID'];

if($_POST['doSaveData']=='Save and Next'){

$owner_id=$mysqli->real_escape_string($_POST['usrm_id']);
$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$grantID=$mysqli->real_escape_string($_POST['grantID']);
$project_title=$mysqli->real_escape_string($_POST['projecttitle']);


$sqlUsersCall="SELECT * FROM ".$prefix."grantcalls where category='concepts' order by grantID desc limit 0,1";
		$QueryUsersCall = $mysqli->query($sqlUsersCall);
		$rUserInvCall=$QueryUsersCall->fetch_array();
		$shortacronym=$rUserInvCall['shortacronym'];
		if(!$id){$grantcallID=$rUserInvCall['grantID'];
		
		
		}
		if($id){$grantcallID=$id;
		}
		
//What is the project title
$sqlTitles4="SELECT * FROM ".$prefix."dynamic_concept_titles where `project_title`='$project_title' and `owner_id`='$owner_id' order by dconceptID desc";
$QueryTitles4 = $mysqli->query($sqlTitles4);
$rUserInv4=$QueryTitles4->fetch_array();

$mmCOnecpt=$rUserInv4['dconceptID']+1;
$referenceNo="$shortacronym".date("Y").$rUserCategory['rstugshort1']."0".$mmCOnecpt;


$sqlTitles="SELECT * FROM ".$prefix."dynamic_concept_titles where  `owner_id`='$owner_id' and `is_sent`='0' order by dconceptID desc";
$QueryTitles = $mysqli->query($sqlTitles);
$rUserInv=$QueryTitles->fetch_array();

if(!$QueryTitles->num_rows){
$sqlA2="insert into ".$prefix."dynamic_concept_titles (`owner_id`,`grantID`,`project_title`,`referenceNo`,`projectStatus`,`finalSubmission`,`dateUpdated`,`is_sent`,`categoryID`) 

values('$owner_id','$grantID','$project_title','$referenceNo','Pending Final Submission','Pending Final Submission',now(),'0','$categoryID')";
$mysqli->query($sqlA2);	

}
///Update project title
if($QueryTitles->num_rows){
$sqlAmm="update ".$prefix."dynamic_concept_titles  set `project_title`='$project_title' where `owner_id`='$owner_id' and `is_sent`='0'";
$mysqli->query($sqlAmm);	

}

$sqlTitles2="SELECT * FROM ".$prefix."dynamic_concept_titles where `owner_id`='$owner_id' and `is_sent`='0' order by dconceptID desc";
$QueryTitles2 = $mysqli->query($sqlTitles2);
sleep(1);
$rUserInv22=$QueryTitles2->fetch_array();
$mdconceptID=$rUserInv22['dconceptID'];

for ($i=0; $i < count($_POST['home']); $i++) {
$question_no=$_POST['home'][$i];
 /////////////////////////insert all details////////////

$updateanswerID=$_POST['answerID'.$question_no];
 
 if($_POST['Answer'.$question_no]){
$winningAnswer=$_POST['Answer'.$question_no]; 
 }
 if($_POST['Answer1'.$question_no]){
$winningAnswer=$_POST['Answer1'.$question_no]; 
 }
 if($_POST['Answer2'.$question_no]){
$winningAnswer=$_POST['Answer2'.$question_no]; 
 }
 if($_POST['Answer3'.$question_no]){
$winningAnswer=$_POST['Answer3'.$question_no]; 
 }
 
$sqlUsers="SELECT * FROM ".$prefix."grantcall_qn_answers_concept where `questionID`='$question_no' and `usrm_id`='$owner_id' and `is_sent`='0' and answer='$winningAnswer' order by answerID desc";
$QueryUsers = $mysqli->query($sqlUsers);

if(!$QueryUsers->num_rows and $QueryTitles2->num_rows){
	
$sqlA2="insert into ".$prefix."grantcall_qn_answers_concept (`questionID`,`categoryID`,`answer`,`usrm_id`,`status`,`categorym`,`grantID`,`dateupdated`,`is_sent`,`dconceptID`) 

values('$question_no','$categoryID','$winningAnswer','$owner_id','new','concept','$grantID',now(),'0','$mdconceptID')";
$mysqli->query($sqlA2);	
$record_id = $mysqli->insert_id;
$record_id2.=$mysqli->insert_id;
}//end submit

if($QueryUsers->num_rows and $updateanswerID and $QueryTitles2->num_rows and $owner_id){
$sqlAUpdate="update ".$prefix."grantcall_qn_answers_concept set `answer`='$winningAnswer' where `grantID`='$grantID' and answerID='$updateanswerID' and usrm_id='$owner_id'";
$mysqli->query($sqlAUpdate);	


////////////////////Now UPDATE




}//end submit
}///end loop



 ////////////////Check if any record was added

//Insert into Submission Stages
$wm="select * from ".$prefix."dynamic_concept_stages where  categoryID='$maincategoryID' and owner_id='$owner_id' and status='new' and grantID='$grantID' order by id desc";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$record_id2;
if(!$totalStages and $record_id2){
$sqlASubmissionStages="insert into ".$prefix."dynamic_concept_stages (`categoryID`,`owner_id`,`status`,`grantID`,`is_sent`,`dconceptID`)  values('$maincategoryID','$owner_id','new','$grantID','0','$mdconceptID')";
$mysqli->query($sqlASubmissionStages);
}

 
 


}//end post

$wGrantCategories1="select * from ".$prefix."grantcall_categories where  grantID='$id' and categorym='concept' and categoryID='$maincategoryID' order by categoryID asc";
$cmGrantCategories1 = $mysqli->query($wGrantCategories1);
$rUGrantCategories1=$cmGrantCategories1->fetch_array();

if(isset($message)){echo $message;}

$sqlTitles3="SELECT * FROM ".$prefix."dynamic_concept_titles where  `owner_id`='$sessionusrm_id' and `is_sent`='0' order by dconceptID desc";
$QueryTitles3 = $mysqli->query($sqlTitles3);
$rUserInv3=$QueryTitles3->fetch_array();
?>
<div class="tab">

<?php
require_once("dynamic_categories.php");?> 

</div>

<div id="SubmitConceptDynamic" class="tabcontentss">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("dynamic_concept_submit_now_final_button.php");?>
   
  
   
  <h3><b><?php echo $rUGrantCategories1['categoryName'];?></b></h3>
 
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="usrm_id" value="<?php echo $_SESSION['usrm_id'];?>" >

 <div class="container"><!--begin-->
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>



<?php /*?><?php if($rUserInv3['categoryID']==$maincategoryID || !$QueryTitles3->num_rows){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Project Title <span class="error">*</span></label>
       
      <input name="projecttitle" type="text" value="<?php echo $rUserInv3['project_title'];?>" required/>
      
      
    </div>
  </div><?php }?>
<?php */?>







  <div class="row success">

    <div class="col-100">
    
    
    <?php
$sqldynamicQns="SELECT * FROM ".$prefix."grantcall_questions where `categoryID`='$categoryID' order by questionID asc limit 0,100";
$QuerydynamicQns = $mysqli->query($sqldynamicQns);
while($rdynamicQns=$QuerydynamicQns->fetch_array()){
	$questionID=$rdynamicQns['questionID'];
	$questionIDm=$rdynamicQns['questionID'];
	$categoryIDm=$rdynamicQns['categoryID'];
	
$sqldynamicAnswers="SELECT * FROM ".$prefix."grantcall_qn_answers_concept where `questionID`='$questionID' and usrm_id='$sessionusrm_id' and is_sent='0' order by answerID asc";
$QuerydynamicAnswers = $mysqli->query($sqldynamicAnswers);
$rdynamicAnswers=$QuerydynamicAnswers->fetch_array();

/////If dropdwons///////////////////////////////////////////////////////////////////
$sqlcheckbox="SELECT * FROM ".$prefix."grantcall_questions_checkboxes where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Querycheckbox = $mysqli->query($sqlcheckbox);
$totalscheckbox=$Querycheckbox->num_rows;

$sqlradiobutton="SELECT * FROM ".$prefix."grantcall_questions_radiobutton where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Queryradiobutton = $mysqli->query($sqlradiobutton);
$totalsRadioButton=$Queryradiobutton->num_rows;

$sqldropdown="SELECT * FROM ".$prefix."grantcall_questions_dropdown where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Querydropdown = $mysqli->query($sqldropdown);
$totalsDropdown=$Querydropdown->num_rows;

$sqlbudget="SELECT * FROM ".$prefix."grantcall_questions_budget where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Querybudget = $mysqli->query($sqlbudget);
$totalsbudget=$Querybudget->num_rows;

$sqlattahment="SELECT * FROM ".$prefix."grantcall_questions_attachments where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Queryattahment = $mysqli->query($sqlattahment);
$totalsattahment=$Queryattahment->num_rows;
$totalsattahment2.=$Queryattahment->num_rows;
///////////////////////////////////////////////////////////////////////////////////////////	
	
?>
    <label for="fname"><?php echo $rdynamicQns['questionName'];?> <span class="error">*</span></label><br />
    
    
     <input type="hidden" name="categoryID" value="<?php echo $rdynamicQns['categoryID'];?>" >
    <input name="grantID" type="hidden" value="<?php echo $rdynamicQns['grantID'];?>"/>    
     <input name="home[]" type="hidden" value="<?php echo $rdynamicQns['questionID'];?>" checked="checked"/>
     <input name="answerID<?php echo $rdynamicQns['questionID'];?>" type="hidden" value="<?php echo $rdynamicAnswers['answerID'];?>"/>
     
     
     
<?php if(!$totalscheckbox and !$totalsRadioButton and !$totalsDropdown and !$totalsbudget and !$totalsattahment){?>  

<textarea name="Answer<?php echo $rdynamicQns['questionID'];?>" placeholder="<?php echo $rdynamicQns['questionName'];?>.." cols="" rows="" required id="MyTextBoxMMMM"><?php echo $rdynamicAnswers['answer'];?></textarea>
<?php }?>

      
      
      
      
	
            <?php
while($rcheckbox=$Querycheckbox->fetch_array()){?>
  <input name="Answer1<?php echo $rcheckbox['questionID'];?>" type="checkbox" value="<?php echo $rdynamicAnswers['answer'];?>" /> <?php echo $rcheckbox['dynamiccheckboxes'];?> <br />         
            
 <?php }?> 

 
 
 
 
 
   <?php
while($rradiobutton=$Queryradiobutton->fetch_array()){?>
 <input name="Answer2<?php echo $rradiobutton['questionID'];?>" type="radio" value="<?php echo $rdynamicAnswers['answer'];?>" /> <?php echo $rradiobutton['dynamicradiobuttion'];?> <br />         
            
 <?php }?>  
 
 
  <?php
if($totalsDropdown){
?>
<select name="Answer3<?php echo $rdynamicQns['questionID'];?>" id="dynamic">
<?php 
while($rdropdown=$Querydropdown->fetch_array()){
//grantcall_questions_dropdown

	?>


<option value="<?php echo $rdropdown['id'];?>" <?php if($rdropdown['id']==$rdynamicAnswers['answer']){?>selected="selected"<?php }?>><?php echo $rdropdown['dropdown_option'];?></option>
 <?php }?>
 </select>
  <?php }//end totals?>
  
  
  
  
  
  
  
  <?php
while($resultsBudget=$Querybudget->fetch_array()){
//grantcall_questions_dropdown

	?>
<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
   <tr>
    <td width="37" valign="top"><p align="center"><strong>&nbsp;</strong></td>
    <td width="256" valign="top"><p align="center"><strong>ITEM</strong></td>
    <td width="530" valign="top"><p align="center"><strong>AMOUNT (<?php echo $rUserInvBudget['currencyPrimaryFunder'];?>)</strong></td>
    <td valign="top"><p align="center"><strong>PERCENTAGE CEILING</strong></td>
    <td valign="top"><p align="center"><strong>MAX. ALLOWABLE AMOUNT</strong></td>
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
    <td width="561" valign="top"><strong><?php /*if($_POST['Personnel']){
echo numberformat(($_POST['Personnel']+$_POST['ResearchCosts']+$_POST['Equipment']+$_POST['Travel']+$_POST['kickoff']+$_POST['KnowledgeSharing']+$_POST['OverheadCosts']+$_POST['OtherGoods']+$_POST['MatchingSupportTotal']));
}else{
echo numberformat(($rUserInv2['Personnel']+$rUserInv2['ResearchCosts']+$rUserInv2['Equipment']+$rUserInv2['Travel']+$rUserInv2['kickoff']+$rUserInv2['KnowledgeSharing']+$rUserInv2['OverheadCosts']+$rUserInv2['OtherGoods']+$rUserInv2['MatchingSupportTotal']));
}*/?></strong></td>
    <td width="86" align="center" valign="top"><strong>100</strong></td>
    <td width="144" valign="top"><input type="text" id="TotalSubmitted" name="TotalSubmitted" placeholder=".." class="required number" value="<?php echo $SumTotal;?>" ></td>
  </tr>
</table>

 <?php }
?>
  
  
   <?php
while($resultsAttachment=$Queryattahment->fetch_array()){
//grantcall_questions_dropdown

	?>



     <?php } //end Attachment
	?>
  
  
  
  
  
  
  <?php }?>
      
    </div>
  </div>
  
  

  
 
  

  <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="Save and Next">
  </div>

</div><!--End-->
 
 
   </form>
 
 
 
</div>



<?php 
if($totalsattahment2>=1){?>

 <button id="myBtn">Add Attachments</button>  
   
   <!-- The Modal -->
<div id="myModal" class="modal" style="width:700px;">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h3><strong>Add New Attachment</strong></h3>
    </div>
    <div class="modal-body" style="height:450px; overflow:scroll;">
    <!--<h4>Name Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal</h4>-->
     <form action="./main.php?option=conceptAttachments" method="post" name="regForm" id="regForm" autocomplete="off"  enctype="multipart/form-data">
    
    <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

 <div class="row success">
 <label class="col-sm-3 form-control-label">Document Type <span class="error">*</span>:</label>

<select id="attachmentCategory" name="attachmentCategory" class="requireDd" required>
<option value="concept"> Concept</option>
<option value="cv"> CV</option>
<option value="workplan"> Workplan</option>
<option value="budget"> Budget</option>
      </select>    
    
  </div>



 <div class="row success">
 <label class="col-sm-3 form-control-label">File  (PDF) <span class="error">*</span>:</label>
<input name="attachethicalapproval" type="file" id="attachethicalapproval" class="required" required/>
    
    
  </div>

   
 <div class="row success">
    <div class="rightm">
    <input type="submit" name="doFilesUpload" value="Save">
    </div>
    
    
  </div>
  
  
   </form>
   
</div>
</div>
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