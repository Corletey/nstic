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
	

    
	new_row.cells[6].getElementsByTagName('input')[0].removeAttribute('style');
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
	

    
	new_row.cells[5].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
}
</script>
<?php
///Below, Enter member details from synch doSaveEnterTeamMemberData
$conceptm_id=$_GET['conceptID'];
$conceptID=$_GET['conceptID'];

  
$sqlProposals="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryProposals = $mysqli->query($sqlProposals);
$totalProposals = $QueryProposals->num_rows;
$rUserInvProposal=$QueryProposals->fetch_array();
$conceptIDm=$rUserInvProposal['conceptID'];
//$conceptm_id=$rUserInvProposal['conceptID'];

if($_POST['doSaveData'] and $_POST['Surname'] and $_POST['asrmApplctID']){

	
	$Surname=$mysqli->real_escape_string($_POST['Surname']);
	$Othername=$mysqli->real_escape_string($_POST['Othername']);
	$Gender=$mysqli->real_escape_string($_POST['Gender']);
	$AgeRange=$mysqli->real_escape_string($_POST['AgeRange']);
	$Contacts=$mysqli->real_escape_string($_POST['Contacts']);
	$Expertise=$mysqli->real_escape_string($_POST['Expertise']);
	$EducationalBackground=$mysqli->real_escape_string($_POST['EducationalBackground']);
	$Qualifications=$mysqli->real_escape_string($_POST['Qualifications']);
	$ResearchExperience=$mysqli->real_escape_string($_POST['ResearchExperience']);
	$RoleofTeamMember=$mysqli->real_escape_string($_POST['RoleofTeamMember']);
	$InstitutionofAffiliation=$mysqli->real_escape_string($_POST['InstitutionofAffiliation']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$emailaddress=$mysqli->real_escape_string($_POST['emailaddress']);

	$ResearchExperienceDetails=$mysqli->real_escape_string($_POST['ResearchExperienceDetails']);
	
	$sqlUsers="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$asrmApplctID' and `Surname`='$Surname' and `conceptm_id`='$conceptm_id' and grantcallID='$id' order by piID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and `is_sent`='0' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	 

if($_POST['asrmApplctID']){
$sqlA2="update ".$prefix."principal_investigators set `Surname`='$Surname',`Othername`='$Othername',`Gender`='$Gender',`AgeRange`='$AgeRange',`Contacts`='$Contacts',`Expertise`='$Expertise',`EducationalBackground`='$EducationalBackground',`Qualifications`='$Qualifications',`ResearchExperience`='$ResearchExperience',`ResearchExperienceDetails`='$ResearchExperienceDetails',`RoleofTeamMember`='$RoleofTeamMember',`InstitutionofAffiliation`='$InstitutionofAffiliation',`emailaddress`='$emailaddress' where piID='$bkey'";
$mysqli->query($sqlA2);



///Add education Details



for ($i=0; $i < count($_POST['educn_university']); $i++) {
if(! empty($_POST['educn_university'][$i])){	
	
$educn_university=$_POST['educn_university'][$i];
$educn_qualification=$_POST['educn_qualification'][$i];
$educn_year=$_POST['educn_year'][$i];
$educn_specialisation=$_POST['educn_specialisation'][$i];
$completionyear=$_POST['completionyear'][$i];
$workExperience=$_POST['workExperience'][$i];

$sqlUsersr="SELECT * FROM ".$prefix."education_history where `rstug_user_id`='$asrmApplctID' and `piID`='$bkey' and `rstug_educn_university`='$educn_university' order by rstug_educn_id desc limit 0,1";
$QueryUsersr = $mysqli->query($sqlUsersr);
$totalUsersr = $QueryUsersr->num_rows;
if(!$totalUsersr){
$Insert_QR2="insert into ".$prefix."education_history (`rstug_user_id`,`rstug_educn_university`,`rstug_educn_qualification`,`rstug_educn_class`,`rstug_educn_year`,`rstug_educn_specialisation`,`rstug_educn_process_status`,`conceptID`,`is_sent`,`piID`,`completionyear`,`workExperience`,`catNormal`,`grantcallID`) values ('$asrmApplctID','$educn_university','$educn_qualification','$educn_class','$educn_year','$educn_specialisation','Completed','$conceptm_id','0','$bkey','$completionyear','$workExperience','dynamic','$id')";
$mysqli->query($Insert_QR2);
}

}
}
///end add education details

///Add education Details

for ($i=0; $i < count($_POST['Institution']); $i++) {
	
if(! empty($_POST['Institution'][$i])){	
$Institution=$_POST['Institution'][$i];
$PositionHeld=$_POST['PositionHeld'][$i];
$YearofRecruitment=$_POST['YearofRecruitment'][$i];
$YearofDeparture=$_POST['YearofDeparture'][$i];

$sqlUserst="SELECT * FROM ".$prefix."work_experience where `rstug_user_id`='$asrmApplctID' and `piID`='$bkey' and `Institution`='$Institution' order by id desc limit 0,1";
$QueryUserst = $mysqli->query($sqlUserst);
$totalUserst = $QueryUserst->num_rows;
if(!$totalUserst){		
$Insert_QR2="insert into ".$prefix."work_experience (`rstug_user_id`,`conceptID`,`Institution`,`PositionHeld`,`YearofRecruitment`,`YearofDeparture`,`dateAdded`,`is_sent`,`piID`,`catNormal`,`grantcallID`) values ('$asrmApplctID','$conceptm_id','$Institution','$PositionHeld','$YearofRecruitment','$YearofDeparture',now(),'0','$bkey','dynamic','$id')";
$mysqli->query($Insert_QR2);
}

}
}
///end add education details
///end add education details


}

////////////////////End Loop
}

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and status='new' and conceptID='$conceptID' order by id desc limit 0,1";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<?php
require("dynamic_categories.php");

?>
<div class="tab">

<?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newSubmitProposal&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectInformation;?> </button><?php }?>
  
  <?php if($total_Team){?><button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalResearchTeam&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectTeam;?> </button><?php }?>
  

<?php if($total_Team){?><button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newproposalResearchTeamUpdate')" id="defaultOpen"><?php echo $lang_new_ProjectTeam;?> Update  </button><?php }?>



  
<?php if($total_Background){?><button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalBackground&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Background;?> </button><?php }?>
  
<?php if($total_Methodology){?><button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalMethodology&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button><?php }?>
    
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalBudget&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
    
    
    
<?php if($total_Results){?><button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalResults&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectResults;?></button><?php }?>
     
<?php if($total_Management){?><button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalManagement&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectManagement;?></button><?php }?>
    
<?php if($total_Followup){?><button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalFollowup&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectFollowup;?></button><?php }?>
   
<?php if($total_Attachments){?><button <?php if($rUConceptStages['attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newProposalAttachments&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ResearchAttachments;?></button><?php }?>

   
<?php if($total_Citations){?> <button <?php if($rUConceptStages['citations']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newProposalReferences&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Citations;?></button><?php }?>

</div>






<div id="newproposalResearchTeamUpdate" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("proposal_submit_now_final_button.php");?>
   
  <h3><?php echo $lang_new_ProjectTeam;?></h3>


<div style="overflow-x:auto;">
<?php
$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$usrm_id' and  grantcallID='$id' and piID='$bkey'";
$QueryUsers4 = $mysqli->query($sqlUsers4);
$rUserProjectID2=$QueryUsers4->fetch_array();
?>

     <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
       <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
    
    <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

 <div class="row success">

    <div class="leftm">
     <label for="lname"><?php echo $lang_first_name;?> <span class="error">*</span></label>
      <input type="text" id="Surname" name="Surname" class="requiredV" value="<?php echo $rUserProjectID2['Surname'];?>" required>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_last_name;?> <span class="error">*</span></label>
      <input type="text" id="Othername" name="Othername" class="requiredS" value="<?php echo $rUserProjectID2['Othername'];?>" required>
    </div>
    
    
  </div>

<div style="clear:both;"></div>
 <div class="row success">

    <div class="leftm">
     <label for="lname"><?php echo $lang_Gender;?>) <span class="error">*</span></label>
       <select id="Gender" name="Gender" class="requireDd" required>
<option value="Male" <?php if($rUserProjectID2['Gender']=='Male'){?>selected="selected"<?php }?>> <?php echo $lang_male;?></option>
<option value="Female" <?php if($rUserProjectID2['Gender']=='Female'){?>selected="selected"<?php }?>> <?php echo $lang_female;?></option>
      </select>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_AgeRange;?> <span class="error">*</span></label>

<select id="AgeRange" name="AgeRange" class="requiredS" required>
       <option value=""> <?php echo $lang_please_select;?></option>
<option value="10-20"  <?php if($rUserProjectID2['AgeRange']=='10-20'){?>selected="selected"<?php }?>> 10-20</option>
<option value="21-30"  <?php if($rUserProjectID2['AgeRange']=='21-30'){?>selected="selected"<?php }?>> 21-30</option>
<option value="31-40"  <?php if($rUserProjectID2['AgeRange']=='31-40'){?>selected="selected"<?php }?>> 31-40</option>
<option value="41-50"  <?php if($rUserProjectID2['AgeRange']=='41-50'){?>selected="selected"<?php }?>> 41-50</option>
<option value="51-60"  <?php if($rUserProjectID2['AgeRange']=='51-60'){?>selected="selected"<?php }?>> 51-60</option>
<option value="61-70"  <?php if($rUserProjectID2['AgeRange']=='61-70'){?>selected="selected"<?php }?>> 61-70</option>
<option value="71-80"  <?php if($rUserProjectID2['AgeRange']=='71-80'){?>selected="selected"<?php }?>> 71-80</option>
<option value="81-90"  <?php if($rUserProjectID2['AgeRange']=='81-90'){?>selected="selected"<?php }?>> 81-90</option>
<option value="91-100"  <?php if($rUserProjectID2['AgeRange']=='91-100'){?>selected="selected"<?php }?>> 91-100</option>
      </select>
    </div>
    
    
  </div>
                 
<div style="clear:both;"></div>
 <div class="row success">

    <div class="leftm">
     <label for="lname"><?php echo $lang_TelephoneContact;?> <span class="error">*</span></label>
    <input type="text" id="Contacts" name="Contacts" placeholder=".." class="requireds" required value="<?php echo $rUserProjectID2['Contacts'];?>">
      </select>
    </div>
 
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_Expertise;?> <span class="error">*</span></label>
      <input type="text" id="<?php echo $lang_Expertise;?>" name="<?php echo $lang_Expertise;?>" placeholder=".." class="requireds" required value="<?php echo $rUserProjectID2['Expertise'];?>">
    </div>
    
    
  </div>
  <div style="clear:both;"></div>
 <div class="row success">

    
      <div class="leftm">
     <label for="lname"><?php echo $lang_email;?> <span class="error">*</span></label>
    <input type="text" id="Contacts" name="emailaddress" placeholder=".." class="requireds" required value="<?php echo $rUserProjectID2['emailaddress'];?>">
      </select>
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
<option value="Principal Investigator"   <?php if($rUserProjectID2['RoleofTeamMember']=='Principal Investigator'){?>selected="selected"<?php }?>> <?php echo $lang_PrincipalInvestigator;?></option>
<option value="Co-Investigator" <?php if($rUserProjectID2['RoleofTeamMember']=='Co-Investigator'){?>selected="selected"<?php }?>> <?php echo $lang_CoInvestigator;?></option>
<option value="Team Member" <?php if($rUserProjectID2['RoleofTeamMember']=='Team Member'){?>selected="selected"<?php }?>> <?php echo $lang_TeamMember;?></option>

      </select>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_institution_of_affiliation;?> <span class="error">*</span></label>
      <input type="text" id="InstitutionofAffiliation" name="InstitutionofAffiliation" placeholder=".." class="requireds" required value="<?php echo $rUserProjectID2['InstitutionofAffiliation'];?>">
    </div>
    
    
  </div>
  <div style="clear:both;"></div>
 <hr />
  <label for="lname"><strong><?php echo $lang_EducationalBackground;?> </strong><span class="error">*</span></label>
  
  
  <div class="row success">
<?php
if($category=='newproposalResearchTeamUpdate' and $id and $_GET['rv'] and $_GET['action']=='delete'){
$rv=$_GET['rv'];
	$sqlA2Protocol2="delete from ".$prefix."education_history where `rstug_user_id`='$usrm_id' and piID='$bkey' and rstug_educn_id='$rv'";
	$mysqli->query($sqlA2Protocol2);
	}
	?>

<table width="100%" border="0" id="POITable" class="customers3">
        <tr>
            <th style=" display:none;">&nbsp;</th>
            <th><?php echo $lang_University;?></th>
            <th><?php echo $lang_EducationalBackground;?></th>
            <th><?php echo $lang_YearofEnrolment;?></th>
            <th><?php echo $lang_YearofCompletion;?>  </th>
            <th><?php echo $lang_FieldofSpecialization;?></th>

            <th>&nbsp; </th>
             <th>&nbsp; </th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<input type="text" name="educn_university[]" id="vvv" tabindex="4" class="requireds" minlength="5" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;"/>
            </td>
            <td><input type="text" name="educn_qualification[]" id="customss2" tabindex="5" class="requireds" minlength="8" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;"/></td>
  
          
  
  
            <td><select name="educn_year[]" id="ssss" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:100px;">
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
  
  
   <td><select name="completionyear[]" id="ssss" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:100px;">
<option value=""><?php echo $lang_Year;?></option>
<?php
define('DOB_YEAR_START', 1950);

$current_year = date('Y')+5;

for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
    <option value="<?php echo $count;?>"><?php echo $count;?></option>
<?php }?>

  </select></td>

              <td>
            <input type="text" name="educn_specialisation[]" id="ddd" tabindex="5" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px;"/>
            </td>
           
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>
        
 <?php
$sqlUsers5="SELECT * FROM ".$prefix."education_history where `rstug_user_id`='$usrm_id' and piID='$bkey'";
$QueryUsers5 = $mysqli->query($sqlUsers5);
while($rUserProjectID5=$QueryUsers5->fetch_array()){
?>       
      <tr>
 <td style=" display:none;">1</td>
<td><?php echo $rUserProjectID5['rstug_educn_university'];?></td>
<td><?php echo $rUserProjectID5['rstug_educn_qualification'];?></td>
<td><?php echo $rUserProjectID5['rstug_educn_year'];?></td>
<td><?php echo $rUserProjectID5['completionyear'];?></td>
<td><?php echo $rUserProjectID5['rstug_educn_specialisation'];?></td>
           
<td> <a href="./main.php?option=newproposalResearchTeamUpdate&id=<?php echo $id;?>&categoryID=&conceptID=&bkey=<?php echo $bkey;?>&rv=<?php echo $rUserProjectID5['rstug_educn_id'];?>&action=delete" style="background-color:#dc3545; color:#fff;padding:5px;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>
<td></td>
</tr>   
 <?php }?>       
        
        
    </table>
    
    
  </div>
  
  
  <div style="clear:both;"></div>
  <hr />
  <label for="lname"><strong><?php echo $lang_WorkExperience;?> </strong><span class="error">*</span></label>
  
  
  <div class="row success">
<?php
if($category=='newproposalResearchTeamUpdate' and $id and $_GET['rv'] and $_GET['action']=='delete'){
$rv=$_GET['rv'];
	$sqlA2Protocol2="delete from ".$prefix."work_experience where `rstug_user_id`='$usrm_id' and  grantcallID='$id' and piID='$bkey' and id='$rv'";
	$mysqli->query($sqlA2Protocol2);
	}
	?>

<table width="100%" border="0" id="POITable2" class="customers3">
        <tr>
            <th style=" display:none;">&nbsp;</th>
            <th><?php echo $lang_Institution;?></th>
            <th><?php echo $lang_PositionHeld;?></th>
            <th><?php echo $lang_YearofRecruitment;?></th>
            <th><?php echo $lang_YearofDeparture;?>  </th>


            <th>&nbsp; </th>
             <th>&nbsp; </th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<input type="text" name="Institution[]" id="Institution" tabindex="4" class="requireds" minlength="5" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;"/>
            </td>
            <td><input type="text" name="PositionHeld[]" id="customss2" tabindex="5" class="requireds" minlength="8" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;"/></td>
  
          
  
  
            <td><select name="YearofRecruitment[]" id="YearofRecruitment" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:100px;">
<option value=""><?php echo $lang_Year;?></option>
<?php
define('DOB_YEAR_START', 1950);

$current_year = date('Y')+0;
?>

<?php 
for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
    <option value="<?php echo $count;?>"><?php echo $count;?></option>
<?php }?>

  </select></td>
  
  
   <td><select name="YearofDeparture[]" id="ssss" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:100px;">
<option value=""><?php echo $lang_Year;?></option>
<option value="To date"><?php echo $lang_Todate;?></option>
<?php
define('DOB_YEAR_START', 1950);

$current_year = date('Y')+5;

for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
    <option value="<?php echo $count;?>"><?php echo $count;?></option>
<?php }?>

  </select></td>


           
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow2(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow2()" style="font-size:12px;"/></td>
        </tr>
        
         <?php
$sqlUsers6="SELECT * FROM ".$prefix."work_experience where `rstug_user_id`='$usrm_id' and piID='$bkey'";
$QueryUsers6 = $mysqli->query($sqlUsers6);
while($rUserProjectID6=$QueryUsers6->fetch_array()){
?>       
      <tr>
 <td style=" display:none;">1</td>
<td><?php echo $rUserProjectID6['Institution'];?></td>
<td><?php echo $rUserProjectID6['PositionHeld'];?></td>
<td><?php echo $rUserProjectID6['YearofRecruitment'];?></td>
<td><?php echo $rUserProjectID6['YearofDeparture'];?></td>
           
<td><a href="./main.php?option=newproposalResearchTeamUpdate&id=<?php echo $id;?>&categoryID=&conceptID=&bkey=<?php echo $bkey;?>&rv=<?php echo $rUserProjectID6['id'];?>&action=delete" style="background-color:#dc3545; color:#fff;padding:5px;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>
<td></td>
</tr>   
 <?php }?> 
    </table>
    
    
  </div>
  
  
  
     <div style="clear:both;"></div>
     
   <label for="lname"><strong><?php echo $lang_ResearchExperience;?> </strong><span class="error">*</span></label>
  
  
  <div class="row success">
  
     <label for="lname"><?php echo $lang_Yes;?>/<?php echo $lang_No;?><span class="error">*</span></label>
    <input name="ResearchExperience" type="radio" value="No" onChange="getResearchExperiece(this.value)" <?php if($rUserProjectID2['ResearchExperience']=='No'){?>checked="checked"<?php }?>/> <?php echo $lang_No;?> &nbsp;<input name="ResearchExperience" type="radio" value="Yes" onChange="getResearchExperiece(this.value)" <?php if($rUserProjectID2['ResearchExperience']=='Yes'){?>checked="checked"<?php }?>/> <?php echo $lang_Yes;?>
    
   <!--Begin researchExperiencediv--> <div id="researchExperiencediv">
   
   
   <textarea id="ResearchExperienceDetails" name="ResearchExperienceDetails" placeholder="" style="height:150px" class="required"><?php echo $rUserProjectID2['ResearchExperienceDetails'];?></textarea>
   </div><!--end researchExperiencediv-->

     </div>  
     
     <div style="clear:both;"></div> 
   
 <div class="row success">


    
    <div class="rightm">
    <input type="submit" name="doSaveData" value="<?php echo $lang_new_Save;?>">
    </div>
    
    
  </div>
  
  
   </form>



</div>

<p>&nbsp;</p>














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