<?php
///Below, Enter member details from synch doSaveEnterTeamMemberData
if($_POST['doSaveEnterTeamMemberData'] and $_POST['EnterTeamMemberSelected'] and $_POST['asrmApplctID'] and $id and $_POST['EnterTeamMember']){
$EnterTeamMemberSelected=$mysqli->real_escape_string($_POST['EnterTeamMemberSelected']);//EMail Address selected
$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);	

//Fecth information
$sqlUsersTeam="SELECT * FROM ".$prefix."principal_investigators where `piID`='$EnterTeamMemberSelected' order by piID desc limit 0,1";
$QueryUsersTeam = $mysqli->query($sqlUsersTeam);
$totalUsersTeam = $QueryUsersTeam->num_rows;
$rUserInvTeam=$QueryUsersTeam->fetch_array();
		
$Surname=$mysqli->real_escape_string($rUserInvTeam['Surname']);
	$Othername=$mysqli->real_escape_string($rUserInvTeam['Othername']);
	$Gender=$mysqli->real_escape_string($rUserInvTeam['Gender']);
	$AgeRange=$mysqli->real_escape_string($rUserInvTeam['AgeRange']);
	$Contacts=$mysqli->real_escape_string($rUserInvTeam['Contacts']);
	$emailaddress=$mysqli->real_escape_string($rUserInvTeam['emailaddress']);
	$Expertise=$mysqli->real_escape_string($rUserInvTeam['Expertise']);
	$EducationalBackground=$mysqli->real_escape_string($rUserInvTeam['EducationalBackground']);
	$Qualifications=$mysqli->real_escape_string($rUserInvTeam['Qualifications']);
	$ResearchExperience=$mysqli->real_escape_string($rUserInvTeam['ResearchExperience']);
	$RoleofTeamMember=$mysqli->real_escape_string($rUserInvTeam['RoleofTeamMember']);
	$InstitutionofAffiliation=$mysqli->real_escape_string($rUserInvTeam['InstitutionofAffiliation']);

	$ResearchExperienceDetails=$mysqli->real_escape_string($rUserInvTeam['ResearchExperienceDetails']);
	
	$sqlUsers="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$asrmApplctID' and `Surname`='$Surname' and grantcallID='$id' order by piID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."principal_investigators (`conceptm_id`,`owner_id`,`Surname`,`Othername`,`Gender`,`AgeRange`,`Contacts`,`Expertise`,`EducationalBackground`,`Qualifications`,`ResearchExperience`,`ResearchExperienceDetails`,`RoleofTeamMember`,`InstitutionofAffiliation`,`updatedon`,`is_sent`,`catNormal`,`grantcallID`,`emailaddress`) 

values('$conceptm_id','$asrmApplctID','$Surname','$Othername','$Gender','$AgeRange','$Contacts','$Expertise','$EducationalBackground','$Qualifications','$ResearchExperience','$ResearchExperienceDetails','$RoleofTeamMember','$InstitutionofAffiliation',now(),'0','dynamic','$id','$emailaddress')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){//
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new Project Team");

///Add education Details
//Fecth information
$sqlUsersEduc="SELECT * FROM ".$prefix."education_history where `piID`='$EnterTeamMemberSelected' order by piID desc limit 0,1";
$QueryUsersEduc = $mysqli->query($sqlUsersEduc);
while($rUserInvEduc=$QueryUsersEduc->fetch_array()){

$educn_university=$rUserInvEduc['rstug_educn_university'];
$educn_qualification=$rUserInvEduc['rstug_educn_qualification'];
$educn_year=$rUserInvEduc['rstug_educn_year'];
$educn_specialisation=$rUserInvEduc['rstug_educn_specialisation'];
$completionyear=$rUserInvEduc['completionyear'];
$workExperience=$rUserInvEduc['workExperience'];

$Insert_QR2="insert into ".$prefix."education_history (`rstug_user_id`,`rstug_educn_university`,`rstug_educn_qualification`,`rstug_educn_class`,`rstug_educn_year`,`rstug_educn_specialisation`,`rstug_educn_process_status`,`conceptID`,`is_sent`,`piID`,`completionyear`,`workExperience`,`catNormal`,`grantcallID`) values ('$asrmApplctID','$educn_university','$educn_qualification','$educn_class','$educn_year','$educn_specialisation','Completed','$conceptm_id','0','$record_id','$completionyear','$workExperience','dynamic','$id')";
$mysqli->query($Insert_QR2);

}
///end add education details

///Add education Details
$sqlUsersExpe="SELECT * FROM ".$prefix."work_experience where `piID`='$EnterTeamMemberSelected' order by piID desc limit 0,1";
$QueryUsersExpe = $mysqli->query($sqlUsersExpe);
while($rUserInvExperience=$QueryUsersExpe->fetch_array()){
$Institution=$rUserInvExperience['Institution'];
$PositionHeld=$rUserInvExperience['PositionHeld'];
$YearofRecruitment=$rUserInvExperience['YearofRecruitment'];
$YearofDeparture=$rUserInvExperience['YearofDeparture'];


$Insert_QR2="insert into ".$prefix."work_experience (`rstug_user_id`,`conceptID`,`Institution`,`PositionHeld`,`YearofRecruitment`,`YearofDeparture`,`dateAdded`,`is_sent`,`piID`,`grantcallID`) values ('$asrmApplctID','$conceptm_id','$Institution','$PositionHeld','$YearofRecruitment','$YearofDeparture',now(),'0','$conceptm_id','$id')";
$mysqli->query($Insert_QR2);

}
///end add education details



}
if($record_id<=0){
$message='<p class="error2">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `PrincipalInvestigator`='1' where `owner_id`='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}
	
	
}


/////////////////////////////////End 

if($_POST['doSaveData'] and $_POST['Surname'] and $_POST['asrmApplctID'] and $id and $_POST['emailaddress']){

	
	$Surname=$mysqli->real_escape_string($_POST['Surname']);
	$Othername=$mysqli->real_escape_string($_POST['Othername']);
	$Gender=$mysqli->real_escape_string($_POST['Gender']);
	$AgeRange=$mysqli->real_escape_string($_POST['AgeRange']);
	$Contacts=$mysqli->real_escape_string($_POST['Contacts']);
	$emailaddress=$mysqli->real_escape_string($_POST['emailaddress']);
	$Expertise=$mysqli->real_escape_string($_POST['Expertise']);
	$EducationalBackground=$mysqli->real_escape_string($_POST['EducationalBackground']);
	$Qualifications=$mysqli->real_escape_string($_POST['Qualifications']);
	$ResearchExperience=$mysqli->real_escape_string($_POST['ResearchExperience']);
	$RoleofTeamMember=$mysqli->real_escape_string($_POST['RoleofTeamMember']);
	$InstitutionofAffiliation=$mysqli->real_escape_string($_POST['InstitutionofAffiliation']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);

	$ResearchExperienceDetails=$mysqli->real_escape_string($_POST['ResearchExperienceDetails']);
	
	$sqlUsers="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$asrmApplctID' and `Surname`='$Surname' and grantcallID='$id' order by piID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."principal_investigators (`conceptm_id`,`owner_id`,`Surname`,`Othername`,`Gender`,`AgeRange`,`Contacts`,`Expertise`,`EducationalBackground`,`Qualifications`,`ResearchExperience`,`ResearchExperienceDetails`,`RoleofTeamMember`,`InstitutionofAffiliation`,`updatedon`,`is_sent`,`catNormal`,`grantcallID`,`emailaddress`) 

values('$conceptm_id','$asrmApplctID','$Surname','$Othername','$Gender','$AgeRange','$Contacts','$Expertise','$EducationalBackground','$Qualifications','$ResearchExperience','$ResearchExperienceDetails','$RoleofTeamMember','$InstitutionofAffiliation',now(),'0','dynamic','$id','$emailaddress')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new Project Team");

///Add education Details
for ($i=0; $i < count($_POST['educn_university']); $i++) {
$educn_university=$_POST['educn_university'][$i];
$educn_qualification=$_POST['educn_qualification'][$i];
$educn_year=$_POST['educn_year'][$i];
$educn_specialisation=$_POST['educn_specialisation'][$i];
$completionyear=$_POST['completionyear'][$i];
$workExperience=$_POST['workExperience'][$i];

$Insert_QR2="insert into ".$prefix."education_history (`rstug_user_id`,`rstug_educn_university`,`rstug_educn_qualification`,`rstug_educn_class`,`rstug_educn_year`,`rstug_educn_specialisation`,`rstug_educn_process_status`,`conceptID`,`is_sent`,`piID`,`completionyear`,`workExperience`,`catNormal`,`grantcallID`) values ('$asrmApplctID','$educn_university','$educn_qualification','$educn_class','$educn_year','$educn_specialisation','Completed','$conceptm_id','0','$record_id','$completionyear','$workExperience','dynamic','$id')";
$mysqli->query($Insert_QR2);

}
///end add education details

///Add education Details
for ($i=0; $i < count($_POST['Institution']); $i++) {
$Institution=$_POST['Institution'][$i];
$PositionHeld=$_POST['PositionHeld'][$i];
$YearofRecruitment=$_POST['YearofRecruitment'][$i];
$YearofDeparture=$_POST['YearofDeparture'][$i];


$Insert_QR2="insert into ".$prefix."work_experience (`rstug_user_id`,`conceptID`,`Institution`,`PositionHeld`,`YearofRecruitment`,`YearofDeparture`,`dateAdded`,`is_sent`,`piID`,`grantcallID`) values ('$asrmApplctID','$conceptm_id','$Institution','$PositionHeld','$YearofRecruitment','$YearofDeparture',now(),'0','$conceptm_id','$id')";
$mysqli->query($Insert_QR2);

}
///end add education details



}
if($record_id<=0){
$message='<p class="error2">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and conceptID='$conceptm_id' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `PrincipalInvestigator`='1' where `owner_id`='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}

}?>

<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."concept_stages where  owner_id='$sessionusrm_id' and grantcallID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();

?>


<div class="tab">
  <?php require_once("dynamic_categories.php");?>
  
   <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newSubmitConcept&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
  
<?php if($total_Team){?><button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newconceptPrincipalInvestigator')" id="defaultOpen"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick<?php }?>="window.location.href='./main.php?option=newconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>

<?php if($total_Attachments){?> <button <?php if($rUConceptStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptAttachments&id=<?php echo $id;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>
  
  <?php require_once("dynamic_categories.php");?>
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
    var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = '';
	var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = '';
	
    x.appendChild( new_row );
}

function deleteRow2(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable2').deleteRow(-1);
	//document.getElementById("myTable").deleteRow(0);
}


function insRow2()
{
    console.log( 'hi');
    var x=document.getElementById('POITable2');
    var new_row = x.rows[1].cloneNode(true);
    var len = x.rows.length;
    new_row.cells[0].innerHTML = len;
    
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.value = '';
    var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = '';
    x.appendChild( new_row );
}
</script>






<div id="newconceptPrincipalInvestigator" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("concept_submit_now_final_button.php");
    $asrmApplctID2=$usrm_id;
 
   if($category=='newconceptPrincipalInvestigatorDelete' and $id and $bkey){
    $piID=$_GET['piID'];
	$sqlA2Protocol2="delete from ".$prefix."principal_investigators where owner_id='$asrmApplctID2' and piID='$bkey'";
	$mysqli->query($sqlA2Protocol2);
	
$wm="select * from ".$prefix."principal_investigators where  owner_id='$asrmApplctID2' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;

if(!$totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `PrincipalInvestigator`='0' where `owner_id`='$asrmApplctID2' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}
	
	
	echo $message='<p class="error2">Dear '.$session_fullname.', Team Member has been successfully removed.</p>';
	}
   
   ?>
   
  <h3><?php echo $lang_new_ProjectTeam;?></h3>
<label for="lname"><?php echo $lang_new_ProjectTeam;?> <span class="error">*</span></label>
  <?php
 
$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$asrmApplctID2' and grantcallID='$id' order by piID desc limit 0,10";
$QueryUsers4 = $mysqli->query($sqlUsers4);
if($QueryUsers4->num_rows){

?>
<div style="overflow-x:auto;">
  <table width="100%" border="0" id="customers">
  <tr>
    <th><?php echo $lang_new_Name;?></th>
    <th><?php echo $lang_Gender;?></th>
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
    <td><?php echo $rUserInv2['Contacts'];?></td>
    <td><?php echo $rUserInv2['Expertise'];?></td>
    <td><?php //echo $rUserInv2['EducationalBackground'];?>
      
   <a href="./main.php?option=newconceptAddEducationBackground&id=<?php echo $id;?>&piID=<?php echo $rUserInv2['piID'];?>" style="background-color: #4CAF50; color:#fff;padding:5px;"><?php echo $lang_ClicktoViewDetails;?> </a>
      

<a href="./main.php?option=newconceptPrincipalInvestigatorDelete&id=<?php echo $id;?>&bkey=<?php echo $rUserInv2['piID'];?>" style="background-color:#F00; color:#fff;padding:5px;" onclick="return confirm('<?php echo $lang_AreyousureDelete;?>');"><?php echo $lang_Remove;?> </a>
      
    </td>
    <?php /*?>    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td><?php echo $rUserInv2['InstitutionofAffiliation'];?></td><?php */?>
  </tr>
  <?php }?>
</table>
</div>

<p>&nbsp;</p><?php }?>

<button id="myBtn"><?php echo $lang_add_team_member;?> </button>



<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>

    </div>
    <div class="modal-body" style="height:450px; overflow:scroll;">
    <!--<h4>Name Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal</h4>-->
     <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    
  
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

<div class="row success">

    <div class="leftmmm">
     <label for="lname"><?php echo $lang_EnterTeam;?> </label>
      <input type="text" id="EnterTeamMember" name="EnterTeamMember" class="requiredV" value="" onKeyUp="showTeam(this.value)">
      
      <div id="txtHintTeam"></div>
    </div>
    
    <div class="rightm">
    <input type="submit" name="doSaveEnterTeamMemberData" value="<?php echo $lang_new_Save;?>">
    </div>
    
    </div>
    </form>
    
      <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
     <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

 <div class="row success">

    <div class="leftm">
     <label for="lname"><?php echo $lang_Surname;?> <span class="error">*</span></label>
      <input type="text" id="Surname" name="Surname" class="requiredV" value="" required>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_Othername;?> <span class="error">*</span></label>
      <input type="text" id="Othername" name="Othername" class="requiredS" value="" required>
    </div>
    
    
  </div>

<div style="clear:both;"></div>
 <div class="row success">

    <div class="leftm">
     <label for="lname"><?php echo $lang_Gender;?> <span class="error">*</span></label>
       <select id="Gender" name="Gender" class="requireDd" required>
<option value="Male"> <?php echo $lang_new_Male;?></option>
<option value="Female"> <?php echo $lang_new_Female;?></option>
      </select>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_AgeRange;?> <span class="error">*</span></label>

<select id="AgeRange" name="AgeRange" class="requiredS" required>
       <option value=""> <?php echo $lang_please_select;?></option>
<option value="10-20"> 10-20</option>
<option value="21-30"> 21-30</option>
<option value="31-40"> 31-40</option>
<option value="41-50"> 41-50</option>
<option value="51-60"> 51-60</option>
<option value="61-70"> 61-70</option>
<option value="71-80"> 71-80</option>
<option value="81-90"> 81-90</option>
<option value="91-100"> 91-100</option>
      </select>
    </div>
    
    
  </div>
                 
<div style="clear:both;"></div>
 <div class="row success">

    <div class="leftm">
     <label for="lname"><?php echo $lang_TelephoneContact;?> <span class="error">*</span></label>
    <input type="text" id="<?php echo $lang_Contacts;?>" name="<?php echo $lang_Contacts;?>"  class="requireds" required placeholder="input your phone number">
      </select>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_email;?> <span class="error">*</span></label>
    <input type="text" id="emailaddress" name="emailaddress"  class="requireds" required placeholder="input your email address">
      </select>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_Expertise;?> <span class="error">*</span></label>
      <input type="text" id="<?php echo $lang_Expertise;?>" name="<?php echo $lang_Expertise;?>" placeholder=".." class="requireds" required>
    </div>
    
    
  </div>
  
  
  
  <div style="clear:both;"></div>

 <div class="row success">

    <div class="leftm">
    <!-- <label for="lname"><?php echo $lang_ResearchExperience;?> (References in Publication) <span class="error">*</span></label>
    <input type="text" id="ResearchExperience" name="ResearchExperience" placeholder=".." class="required">
      </select>!-->
      
         <label for="lname"><?php echo $lang_RoleofTeamMemberonProject;?> <span class="error">*</span></label>
    
       <select id="RoleofTeamMember" name="RoleofTeamMember" class="requireds" required>
       <option value=""> <?php echo $lang_please_select;?></option>
<option value="Principal Investigator"> <?php echo $lang_PrincipalInvestigator;?></option>
<option value="Co-Investigator"> <?php echo $lang_CoInvestigator;?></option>
<option value="Team Member"> <?php echo $lang_TeamMember;?></option>

      </select>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_institution_of_affiliation;?> <span class="error">*</span></label>
      <input type="text" id="InstitutionofAffiliation" name="InstitutionofAffiliation" placeholder=".." class="requireds" required>
    </div>
    
    
  </div>
  <div style="clear:both;"></div>
  <hr />
  <label for="lname"><strong><?php echo $lang_EducationalBackground;?> </strong><span class="error">*</span></label>
  
  
  <div class="row success">


<table width="100%" border="0" id="POITable" class="customers3">
        <tr>
            <th style=" display:none;">&nbsp;</th>
            <th><?php echo $lang_University;?></th>
            <th><?php echo $lang_Qualifications;?></th>
            <th><?php echo $lang_YearofEnrolment;?></th>
            <th><?php echo $lang_YearofCompletion;?></th>
            <th><?php echo $lang_FieldofSpecialization;?></th>

            <th>&nbsp; </th>
             <th>&nbsp; </th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<input type="text" name="educn_university[]" id="vvv" tabindex="4" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;" required title="Minimum Length 8 characters" placeholder="Minimum Length 8 characters"/>
            </td>
            <td><input type="text" name="educn_qualification[]" id="customss2" tabindex="5" class="requireds" pattern=".{8,}" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;" required title="Minimum Length 8 characters" placeholder="Minimum Length 8 characters" /></td>
  
          
  
  
            <td><select name="educn_year[]" id="ssss" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:100px;" required  onChange="getNextYear(this.value)">
<option value=""><?php echo $lang_Year;?></option>
<?php
define('DOB_YEAR_START', 1950);

$current_year = date('Y')+0;

for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
    <option value="<?php echo $count;?>"><?php echo $count;?></option>
<?php }?>

  </select></td>
  
  
   <td>
   <div id="nextyeardiv"></div>
</td>

              <td>
            <input type="text" name="educn_specialisation[]" id="ddd" tabindex="5" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px;" required/>
            </td>
           
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>
    </table>
    
    
  </div>
  
  
  <div style="clear:both;"></div>
  <hr />
  <label for="lname"><strong><?php echo $lang_WorkExperience;?> </strong><span class="error">*</span></label>
  
  
  <div class="row success">


<table width="100%" border="0" id="POITable2" class="customers3">
        <tr>
            <th style=" display:none;">&nbsp;</th>
            <th><?php echo $lang_Institution;?></th>
            <th><?php echo $lang_PositionHeld;?></th>
            <th><?php echo $lang_new_StartDate;?></th>
            <th><?php echo $lang_new_EndDate;?></th>


            <th>&nbsp; </th>
             <th>&nbsp; </th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<input type="text" name="Institution[]" id="Institution" tabindex="4" class="requireds" minlength="5" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;" required title="Minimum Length 5 characters" placeholder="Minimum Length 5 characters"/>
            </td>
            <td><input type="text" name="PositionHeld[]" id="customss2" tabindex="5" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;" required title="Minimum Length 8 characters" placeholder="Minimum Length 8 characters"/></td>
  
          
  
  
            <td><select name="YearofRecruitment[]" id="YearofRecruitment" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:100px;" required onChange="getNextYearM(this.value)">>
<option value=""><?php echo $lang_Year;?></option>
<?php
define('DOB_YEAR_START', 1950);

$current_year = date('Y')+0;

for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
    <option value="<?php echo $count;?>"><?php echo $count;?></option>
<?php }?>

  </select></td>
  
  
   <td><div id="nextyearmmdiv"></div>
   </td>


           
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow2(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow2()" style="font-size:12px;"/></td>
        </tr>
    </table>
    
    
  </div>
  
  
  
  
     <div style="clear:both;"></div>
     
   <label for="lname"><strong><?php echo $lang_ResearchExperience;?> </strong><span class="error">*</span></label>
  
  
  <div class="row success">
  
     <label for="lname"><?php echo $lang_Yes;?>/<?php echo $lang_No;?><span class="error">*</span></label>
    <input name="ResearchExperience" type="radio" value="No" onChange="getResearchExperiece(this.value)"/> <?php echo $lang_No;?> &nbsp;<input name="ResearchExperience" type="radio" value="Yes" onChange="getResearchExperiece(this.value)"/> <?php echo $lang_Yes;?>
    
   <!--Begin researchExperiencediv--> <div id="researchExperiencediv"></div><!--end researchExperiencediv-->

     </div>  
     
     <div style="clear:both;"></div> 
   
 <div class="row success">


    
    <div class="rightm">
    <input type="submit" name="doSaveData" value="<?php echo $lang_new_Save;?>">
    </div>
    
    
  </div>
  
  
   </form>
   
</div></div>
                                     
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