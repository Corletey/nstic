<?php
 if($_POST['doSaveData'] and $_POST['Methodology'] and $_POST['asrmApplctID'] and $id){
$Methodology=$mysqli->real_escape_string($_POST['Methodology']);
	$solution=$mysqli->real_escape_string($_POST['ScientificSolution']);
	$SpecialInterestGroup=$mysqli->real_escape_string($_POST['SpecialInterestGroup']);
	$PartnershipsCollaborations=$mysqli->real_escape_string($_POST['PartnershipsCollaborations']);
	$PrimaryFunderName=$mysqli->real_escape_string($_POST['PrimaryFunderName']);
	$PrimaryFunderAmount=$mysqli->real_escape_string($_POST['PrimaryFunderAmount']);
	$SecondaryFunderName=$mysqli->real_escape_string($_POST['SecondaryFunderName']);
	$SecondaryFunderAmount=$mysqli->real_escape_string($_POST['SecondaryFunderAmount']);
	$CounterpartFundingName=$mysqli->real_escape_string($_POST['CounterpartFundingName']);
	$CounterpartFundingAmount=$mysqli->real_escape_string($_POST['CounterpartFundingAmount']);
	$currencyPrimaryFunder=$mysqli->real_escape_string($_POST['currencyPrimaryFunder']);
	$currencySecondaryFunder=$mysqli->real_escape_string($_POST['currencySecondaryFunder']);
	$currencyCounterpartFunding=$mysqli->real_escape_string($_POST['currencyCounterpartFunding']);
	
	$PrimaryFunderDuration=$mysqli->real_escape_string($_POST['PrimaryFunderDuration']);
	$SecondaryFunderDuration=$mysqli->real_escape_string($_POST['SecondaryFunderDuration']);
	$CounterpartFundingDuration=$mysqli->real_escape_string($_POST['CounterpartFundingDuration']);
	
	$periodPrimaryFunder=$mysqli->real_escape_string($_POST['periodPrimaryFunder']);
	$periodSecondaryFunder=$mysqli->real_escape_string($_POST['periodSecondaryFunder']);
	$periodCounterpart=$mysqli->real_escape_string($_POST['periodCounterpart']);
	
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$TotalBudget=$mysqli->real_escape_string($_POST['TotalBudget']);
	
for ($i=0; $i < count($_POST['ExpectedIntellectualProperty']); $i++) {
$ExpectedIntellectualProperty.=$_POST['ExpectedIntellectualProperty'][$i].'-';
}
	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
	$sqlUsers="SELECT * FROM ".$prefix."project_details_concept where `owner_id`='$asrmApplctID' and grantcallID='$id' order by id desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();
		
		
		
		
		
		
		
		
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."project_details_concept (`Methodology`,`solution`,`SpecialInterestGroup`,`PartnershipsCollaborations`,`ExpectedIntellectualProperty`,`PrimaryFunderName`,`PrimaryFunderAmount`,`SecondaryFunderName`,`SecondaryFunderAmount`,`CounterpartFundingName`,`CounterpartFundingAmount`,`currencyPrimaryFunder`,`currencySecondaryFunder`,`currencyCounterpartFunding`,`owner_id`,`projectCategory`,`is_sent`,`conceptID`,`TotalBudget`,`PrimaryFunderDuration`,`SecondaryFunderDuration`,`CounterpartFundingDuration`,`periodPrimaryFunder`,`periodSecondaryFunder`,`periodCounterpart`,`catNormal`,`grantcallID`) 

values('$Methodology','$solution','$SpecialInterestGroup','$PartnershipsCollaborations','$ExpectedIntellectualProperty','$PrimaryFunderName','$PrimaryFunderAmount','$SecondaryFunderName','$SecondaryFunderAmount','$CounterpartFundingName','$CounterpartFundingAmount','$currencyPrimaryFunder','$currencySecondaryFunder','$currencyCounterpartFunding','$asrmApplctID','Concept','0','$conceptm_id','$TotalBudget','$PrimaryFunderDuration','$SecondaryFunderDuration','$CounterpartFundingDuration','$periodPrimaryFunder','$periodSecondaryFunder','$periodCounterpart','dynamic','$id')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added project details");
/*
echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newconceptBudget/$id';</script>");*/

}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}





//insert into education
for ($i=0; $i < count($_POST['Categoryofbeneficiary']); $i++) {
$Categoryofbeneficiary=$_POST['Categoryofbeneficiary'][$i];
$Gender=$_POST['Gender'][$i];
$OthersGender=$_POST['OthersGender'][$i];
$Quantities=$_POST['Quantities'][$i];
$Locationofbeneficiaries=$_POST['Locationofbeneficiaries'][$i];
$OthersCategory=$_POST['OthersCategory'][$i];

$sqlUsers2="SELECT * FROM ".$prefix."project_primary_beneficiaries where `Categoryofbeneficiary`='$Categoryofbeneficiary' and `Gender`='$Gender'  and Locationofbeneficiaries='$Locationofbeneficiaries' and`owner_id`='$asrmApplctID' and grantcallID='$id' order by id desc";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers2 = $QueryUsers2->num_rows;
		
if(strlen($_POST['Categoryofbeneficiary'][$i])>=3 and !$totalUsers2){
$Insert_QR2="insert into ".$prefix."project_primary_beneficiaries (`Categoryofbeneficiary`,`Gender`,`Quantities`,`Locationofbeneficiaries`,`owner_id`,`projectCategory`,`is_sent`,`conceptID`,`OthersCategory`,`OthersGender`,`catNormal`,`grantcallID`) values ('$Categoryofbeneficiary','$Gender','$Quantities','$Locationofbeneficiaries','$asrmApplctID','Concept','0','$conceptm_id','$OthersCategory','$OthersGender','dynamic','$id')";
$mysqli->query($Insert_QR2);
}
}///////////


}	/////end totals


if($totalUsers){
	
	
	//insert into education
for ($i=0; $i < count($_POST['Categoryofbeneficiary']); $i++) {
$Categoryofbeneficiary=$_POST['Categoryofbeneficiary'][$i];
$Gender=$_POST['Gender'][$i];
$OthersGender=$_POST['OthersGender'][$i];
$Quantities=$_POST['Quantities'][$i];
$Locationofbeneficiaries=$_POST['Locationofbeneficiaries'][$i];
$OthersCategory=$_POST['OthersCategory'][$i];

$sqlUsers2="SELECT * FROM ".$prefix."project_primary_beneficiaries where `Categoryofbeneficiary`='$Categoryofbeneficiary' and `Gender`='$Gender' and Locationofbeneficiaries='$Locationofbeneficiaries' and`owner_id`='$asrmApplctID' and grantcallID='$id' order by id desc";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers2 = $QueryUsers2->num_rows;

if(strlen($_POST['Categoryofbeneficiary'][$i])>=3 and !$totalUsers2){
$Insert_QR2="insert into ".$prefix."project_primary_beneficiaries (`Categoryofbeneficiary`,`Gender`,`Quantities`,`Locationofbeneficiaries`,`owner_id`,`projectCategory`,`is_sent`,`conceptID`,`OthersCategory`,`OthersGender`,`catNormal`,`grantcallID`) values ('$Categoryofbeneficiary','$Gender','$Quantities','$Locationofbeneficiaries','$asrmApplctID','Concept','0','$conceptm_id','$OthersCategory','$OthersGender','dynamic','$id')";
$mysqli->query($Insert_QR2);
}
}
	///update

$sqlA2="update ".$prefix."project_details_concept set  `Methodology`='$Methodology',`solution`='$solution',`SpecialInterestGroup`='$SpecialInterestGroup',`PartnershipsCollaborations`='$PartnershipsCollaborations',`ExpectedIntellectualProperty`='$ExpectedIntellectualProperty',`PrimaryFunderName`='$PrimaryFunderName',`PrimaryFunderAmount`='$PrimaryFunderAmount',`SecondaryFunderName`='$SecondaryFunderName',`SecondaryFunderAmount`='$SecondaryFunderAmount',`CounterpartFundingName`='$CounterpartFundingName',`CounterpartFundingAmount`='$CounterpartFundingAmount',`TotalBudget`='$TotalBudget',`PrimaryFunderDuration`='$PrimaryFunderDuration',`SecondaryFunderDuration`='$SecondaryFunderDuration',`CounterpartFundingDuration`='$CounterpartFundingDuration',`periodPrimaryFunder`='$periodPrimaryFunder',`periodSecondaryFunder`='$periodSecondaryFunder',`periodCounterpart`='$periodCounterpart',`currencyPrimaryFunder`='$currencyPrimaryFunder' where owner_id='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlA2);

/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newconceptBudget/$id';</script>");*/
	
}//end

			//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and conceptID='$conceptm_id' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `ProjectDetails`='1' where `owner_id`='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}	


 }////End Post
 
 

$sqlUsers2="SELECT * FROM ".$prefix."project_details_concept where `owner_id`='$usrm_id' and grantcallID='$id' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."concept_stages where  owner_id='$sessionusrm_id' and grantcallID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?><div class="tab">
<?php require_once("dynamic_categories.php");?>

  <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newSubmitConcept&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
 
<?php if($total_Team){?><button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button><?php }?>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newconceptProjectDetails')" id="defaultOpen"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
<?php if($total_Attachments){?><button <?php if($rUConceptStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptAttachments&id=<?php echo $id;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>
  
  
</div>



<script>
function deleteRow(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable').deleteRow(-1);
	//document.getElementById("myTable").deleteRow(0);
}


function insRow()
{
    console.log( 'hi');
    var x=document.getElementById('POITable');
    var new_row = x.rows[1].cloneNode(true);
    var len = x.rows.length;
    new_row.cells[0].innerHTML = len;
    
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.value = '';
	
    /**/var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = '';
	
var inp3 = new_row.cells[3].getElementsByTagName('input')[0];
    inp3.id += len;
    inp3.value = '';
	
	var inp4 = new_row.cells[4].getElementsByTagName('input')[0];
    inp4.id += len;
    inp4.value = '';
	
	new_row.cells[5].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
}
</script>



<div id="newconceptProjectDetails" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <?php include("concept_submit_now_final_button.php");?>
   
  <h3>Project Details</h3>


 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">

 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">
 
 <div class="container"><!--begin-->
 <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>

  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $lang_new_Projectprimarybeneficiaries;?></label>

      
      
      
      <div style="overflow-x:auto;">

<?php
$sqlUsers3="SELECT * FROM ".$prefix."project_primary_beneficiaries where `owner_id`='$usrm_id' and grantcallID='$id' order by id desc limit 0,40";
$QueryUsers3 = $mysqli->query($sqlUsers3);
$totalUsers3 = $QueryUsers3->num_rows;

//if(!$totalUsers3){$required='required';}
//if($totalUsers3){$required='';}
?>
 <?php
$sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_c where grantID='$id' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
?>
<table id="POITable" border="0">
        <tr>
            <th class="whitebg">&nbsp;No&nbsp;</th>
            <th><?php echo $lang_new_Categoryofbeneficiary;?></th>
            <th><?php echo $lang_Gender;?></th>
            <th><?php echo $lang_new_Quantities;?></th>
            <th><?php echo $lang_new_Locationofbeneficiaries;?></th>
       
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td class="whitebg" style="padding-left:5px;">1</td>
            <td style=" padding-top:15px;">
<div class="form-group form-group-default <?php echo $required;?>">
  <input type="hidden" class="form-control" name="Categoryofbeneficiarymm[]">  
                     
<select id="Categoryofbeneficiary" name="Categoryofbeneficiary[]" class="form-control <?php echo $required;?>" style="width:110px;" onChange="getOtherCategory(this.value)">
<option value=""><?php echo $lang_please_select;?></option> 
<option value="Youth"> <?php echo $lang_Youth;?></option>
<option value="Children"> <?php echo $lang_Children;?></option>
<option value="Women"> <?php echo $lang_female;?></option>
<option value="Men"> <?php echo $lang_male;?></option>
<option value="Elderly"> <?php echo $lang_Elderly;?></option>
<option value="All"> <?php echo $lang_All;?></option>
<option value="Special Interest Groups"> <?php echo $lang_SpecialInterestGroups;?></option>
<option value="Others"> <?php echo $lang_Other;?></option>
      </select>
      
      <div id="getothercategorydiv">  </div>
     
      
  </div>
            </td>
       
              <td style=" padding-top:15px;"><div class="form-group form-group-default <?php echo $required;?>">
                
                <input type="hidden" class="form-control" name="Gendermm[]">
                
<select id="Gender" name="Gender[]" class="form-control <?php echo $required;?>" style="width:110px;"  onChange="getOtherGender(this.value)">>
<option value=""><?php echo $lang_please_select;?></option>
<option value="All"> <?php echo $lang_All;?></option> 
<option value="Male"> <?php echo $lang_male;?></option>
<option value="Female"> <?php echo $lang_female;?></option>
<option value="OtherGender"> <?php echo $lang_Other;?></option>


      </select>
       <div id="getothergenderdiv">  </div>         
                
              </div></td>
              <td style=" padding-top:15px;"><div class="form-group form-group-default <?php echo $required;?>">
    
    <input type="text" class="form-control <?php echo $required;?>" name="Quantities[]" value=""  style="width:110px;"  placeholder="input number only">
  </div></td>
              
            <td style=" padding-top:15px;">
              <div class="form-group form-group-default">
                
                <input type="text" class="form-control <?php echo $required;?>" name="Locationofbeneficiaries[]" onkeyup="addTWD();" style="width:200px;">
              </div></td>
              
        
  
            <td><input type="button" id="delPOIbutton" value="<?php echo $lang_Delete;?>" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="<?php echo $lang_Rows;?>" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>

    </table>

<?php if($totalUsers3 = $QueryUsers3->num_rows){
	$count=0;?>
  <table id="customers" border="0">
        <tr>
            <th class="whitebg">&nbsp;No&nbsp;</th>
                  
            <th><?php echo $lang_new_Categoryofbeneficiary;?></th>
            <th><?php echo $lang_new_Gender;?></th>
            <th><?php echo $lang_new_Quantities;?></th>
            <th><?php echo $lang_new_Locationofbeneficiaries;?></th>
       
       
            <th>&nbsp;</th>
            </tr>      
<?php
if($category=='newconceptProjectDetailsDel' and $bkey and $id){
$mid=$mysqli->real_escape_string($_GET['id']);
$qRDel2="delete from ".$prefix."project_primary_beneficiaries where owner_id='$usrm_id' and id='$bkey'";
$mysqli->query($qRDel2);
}
 
while($rUserInv3=$QueryUsers3->fetch_array()){$count++;?>
<tr>
<td class="whitebg" style="padding-left:5px;"><?php echo $count;?></td>
<td><?php echo $rUserInv3['Categoryofbeneficiary'];?> <?php if($rUserInv3['OthersCategory']){ echo "<br>".$rUserInv3['OthersCategory'];}?></td>
<td><?php echo $rUserInv3['Gender'];?> <?php if($rUserInv3['OthersGender']){ echo "<br>".$rUserInv3['OthersGender'];}?></td>
<td><?php echo $rUserInv3['Quantities'];?></td>
<td><?php echo $rUserInv3['Locationofbeneficiaries'];?></td>
<td><a href="./main.php?option=newconceptProjectDetailsDel&id=<?php echo $id;?>&bkey=<?php echo $rUserInv3['id'];?>" style="color:#F00; font-weight:bold;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>
</tr>
<?php }?></table><?php }//end totals?>


</div>
      
      
      
    </div>
  </div>
  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsSubmitted_c['qn_methodology'];?></label>
      <textarea id="MyTextBox10" name="Methodology" placeholder="Methodology (300 words).." class="required" style="height:150px"><?php echo $rUserInv2['Methodology'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">300 words</span></p>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsSubmitted_c['qn_scientificsolution'];?> </label>
      <textarea id="MyTextBox11" name="ScientificSolution" placeholder="Scientific/technological solution provided.." class="required" style="height:150px"><?php echo $rUserInv2['solution'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">350 words</span></p>
    </div>
  </div>
  
  
  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsSubmitted_c['qn_specialinterestgroup'];?> </label>
      <textarea id="MyTextBox12" name="SpecialInterestGroup" placeholder="Gender and Special Interest group considerations.." class="required" style="height:150px"><?php echo $rUserInv2['SpecialInterestGroup'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">150 words</span></p>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsSubmitted_c['qn_PartnershipsCollaborations'];?>
</label>
      <textarea id="MyTextBox13" name="PartnershipsCollaborations" placeholder="Partnerships, Collaborations and Linkages.." class="required" style="height:150px"><?php echo $rUserInv2['PartnershipsCollaborations'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">300 words</span></p>
    </div>
  </div>
  
      <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_new_ExpectedIntellectualProperty;?>
</label><br />
<?php
$shcategoryID4=$rUserInv2['ExpectedIntellectualProperty'];
$categoryChunks = explode("-", $shcategoryID4);
$chop1="$categoryChunks[0]";
$chop2="$categoryChunks[1]";
$chop3="$categoryChunks[2]";
$chop4="$categoryChunks[3]";
$chop5="$categoryChunks[4]";
$chop6="$categoryChunks[5]";
?>

<input name="ExpectedIntellectualProperty[]" type="checkbox" value="Copy Rights"  <?php if($chop1=='Copy Rights' || $chop2=='Copy Rights' || $chop3=='Copy Rights' || $chop4=='Copy Rights' || $chop5=='Copy Rights' || $chop6=='Copy Rights'){?>checked="checked"<?php }?>/> <?php echo $lang_new_CopyRights;?><br />

<input name="ExpectedIntellectualProperty[]" type="checkbox" value="Industrial designs"  <?php if($chop1=='Industrial designs' || $chop2=='Industrial designs' || $chop3=='Industrial designs' || $chop4=='Industrial designs' || $chop5=='Industrial designs' || $chop6=='Industrial designs'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Industrialdesigns;?><br />

<input name="ExpectedIntellectualProperty[]" type="checkbox" value="Utility Models"  <?php if($chop1=='Utility Models' || $chop2=='Utility Models' || $chop3=='Utility Models' || $chop4=='Utility Models' || $chop5=='Utility Models' || $chop6=='Utility Models'){?>checked="checked"<?php }?>/> <?php echo $lang_new_UtilityModels;?><br />

<input name="ExpectedIntellectualProperty[]" type="checkbox" value="Trade Marks"  <?php if($chop1=='Trade Marks' || $chop2=='Trade Marks' || $chop3=='Trade Marks' || $chop4=='Trade Marks' || $chop5=='Trade Marks' || $chop6=='Trade Marks'){?>checked="checked"<?php }?>/> <?php echo $lang_new_TradeMarks;?><br />

<input name="ExpectedIntellectualProperty[]" type="checkbox" value="Trade Secrets" <?php if($chop1=='Trade Secrets' || $chop2=='Trade Secrets' || $chop3=='Trade Secrets' || $chop4=='Trade Secrets' || $chop5=='Trade Secrets' || $chop6=='Trade Secrets'){?>checked="checked"<?php }?>/> <?php echo $lang_new_TradeSecrets;?><br />

<input name="ExpectedIntellectualProperty[]" type="checkbox" value="Patent" <?php if($chop1=='Patent' || $chop2=='Patent' || $chop3=='Patent' || $chop4=='Patent' || $chop5=='Patent' || $chop6=='Patent'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Patent;?><br />


<input name="ExpectedIntellectualProperty[]" type="checkbox" value="None" <?php if($chop1=='None' || $chop2=='None' || $chop3=='None' || $chop4=='None' || $chop5=='None' || $chop6=='None'){?>checked="checked"<?php }?>/> <?php echo $lang_new_None;?>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="lname"><strong><?php echo $rowsSubmitted_c['qn_TotalBudget'];?></strong> </label><br />
    <input type="text" id="TotalBudget" name="TotalBudget" class="requiredm number"  value="<?php echo $rUserInv2['TotalBudget'];?>" required placeholder="input Total Budget Cost" style="float:left; width:60%;">

    
    </div>
    </div>
    
    <div class="row success">

    <div class="col-100">
    
   <label for="lname"><strong><?php echo $lang_new_Currency;?></strong> </label><br />     
    
    <select name="currencyPrimaryFunder" id="currencyPrimaryFunder" style="width:60%;">
   <option value="" selected="selected"><?php echo $lang_please_select;?></option>     
 <?php
$sqlUser = "SELECT * FROM ".$prefix."currency order by currency asc";
$queryUser = $mysqli->query($sqlUser);
while($r = $queryUser->fetch_array()){?>
    <option value="<?php echo $r['currency'];?>" <?php if($r['currency']==$rUserInv2['currencyPrimaryFunder']){?>selected="selected"<?php }?>>&nbsp;<?php echo $r['currency'];?></option>
    <?php }?>
       </select>  
    
    </div>
    </div>
    
    
    
       <div class="row success">

    <div class="col-100">
    <label for="lname"><strong><?php echo $lang_FundingSource;?></strong> </label>
    <br />
<label for="lname">a) <?php echo $lang_PrimaryFunder;?> <span class="error">*</span></label>
 <div style="overflow-x:auto;">

<table id="customers2" border="0">
        <tr>
            <th><?php echo $lang_new_Name;?></th>
            <th><?php echo $lang_new_Amount;?></th>
            <th><?php echo $lang_new_DurationofFunding;?></th>
            <th><?php echo $lang_new_Period;?></th>
            </tr>
        <tr>
            <td><input type="text" class="form-control required" name="PrimaryFunderName" id="PrimaryFunderName" value="<?php echo $rUserInv2['PrimaryFunderName'];?>"></td>
       
              <td> <input type="text" class="form-control required" name="PrimaryFunderAmount" id="PrimaryFunderAmount" value="<?php echo $rUserInv2['PrimaryFunderAmount'];?>">
           </td>
              <td><input type="text" class="form-control required" name="PrimaryFunderDuration" id="PrimaryFunderDuration" value="<?php echo $rUserInv2['PrimaryFunderDuration'];?>" /></td>
              <td>
              
               <select name="periodPrimaryFunder" id="periodPrimaryFunder">
   <option value="">&nbsp;Please Select</option>
    <option value="Months" <?php if($rUserInv2['periodPrimaryFunder']=='Months'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Month;?></option>
    
    <option value="Years" <?php if($rUserInv2['periodPrimaryFunder']=='Years'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Year;?></option>

       </select>  
              
              </td>
              
              
            </tr>
    </table>
</div>

<label for="lname">b) <?php echo $lang_new_SecondaryFunder;?></label>

 <div style="overflow-x:auto;">

<table id="customers2" border="0">
        <tr>
            <th><?php echo $lang_new_Name;?></th>
            <th><?php echo $lang_new_Amount;?></th>
            <th><?php echo $lang_new_DurationofFunding;?></th>
            <th><?php echo $lang_new_Period;?></th>
            </tr>
        <tr>
            <td><input type="text" class="form-control" name="SecondaryFunderName" id="SecondaryFunderName" value="<?php echo $rUserInv2['SecondaryFunderName'];?>"></td>
       
              <td> <input type="text" class="form-control" name="SecondaryFunderAmount" id="SecondaryFunderAmount" value="<?php echo $rUserInv2['SecondaryFunderAmount'];?>">
           </td>
              <td><input type="text" class="form-control required" name="SecondaryFunderDuration" id="SecondaryFunderDuration" value="<?php echo $rUserInv2['SecondaryFunderDuration'];?>" /></td>
              <td><select name="periodSecondaryFunder" id="periodSecondary">
   <option value="">&nbsp;<?php echo $lang_please_select;?></option>
    <option value="Months" <?php if($rUserInv2['periodSecondaryFunder']=='Months'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Month;?></option>
    
    <option value="Years" <?php if($rUserInv2['periodSecondaryFunder']=='Years'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Year;?></option>

       </select> </td>
           </tr>
    </table>
</div>




<label for="lname">b) <?php echo $lang_new_CounterpartFunding;?></label>
 <div style="overflow-x:auto;">

<table id="customers2" border="0">
        <tr>
            <th><?php echo $lang_new_Name;?></th>
            <th><?php echo $lang_new_Amount;?></th>
            <th><?php echo $lang_new_DurationofFunding;?></th>
            <th><?php echo $lang_new_Period;?></th>
            </tr>
        <tr>
            <td><input type="text" class="form-control" name="CounterpartFundingName" id="CounterpartFundingName" value="<?php echo $rUserInv2['CounterpartFundingName'];?>"></td>
       
              <td> <input type="text" class="form-control" name="CounterpartFundingAmount" id="CounterpartFundingAmount" value="<?php echo $rUserInv2['CounterpartFundingAmount'];?>">
           </td>
              <td><input type="text" class="form-control required" name="CounterpartFundingDuration" id="CounterpartFundingDuration" value="<?php echo $rUserInv2['CounterpartFundingDuration'];?>" /></td>
              <td><select name="periodCounterpart" id="periodCounterpart">
   <option value="">&nbsp;<?php echo $lang_new_please_select;?></option>
    <option value="Months" <?php if($rUserInv2['periodCounterpart']=='Months'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Month;?></option>
    
    <option value="Years" <?php if($rUserInv2['periodCounterpart']=='Years'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Year;?></option>

       </select></td>
            </tr>
    </table>
</div>


    </div>
  </div>

 

  <div class="row success">
    <input type="submit" name="doSaveData" value="<?php echo $lang_SaveandNext;?>">
  </div>
  
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