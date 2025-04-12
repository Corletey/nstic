<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?><div class="tab">
  
 <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitProposal&id=<?php echo $id;?>"><?php echo $lang_new_ProjectInformation;?></button>
 
  <button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'proposalResearchTeam')" id="defaultOpen"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBackground&id=<?php echo $id;?>'"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalMethodology&id=<?php echo $id;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalResults&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectResults;?></button>

  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalManagement&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalFollowup&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
</div>
<?php
if($_POST['doSaveData']=='Save' and $_POST['Surname'] and $_POST['asrmApplctID']){

	
	$Surname=$mysqli->real_escape_string($_POST['Surname']);
	$Othername=$mysqli->real_escape_string($_POST['Othername']);
	$Gender=$mysqli->real_escape_string($_POST['Gender']);
	$AgeRange=$mysqli->real_escape_string($_POST['AgeRange']);
	$<?php echo $lang_Contacts;?>=$mysqli->real_escape_string($_POST['<?php echo $lang_Contacts;?>']);
	$<?php echo $lang_Expertise;?>=$mysqli->real_escape_string($_POST['<?php echo $lang_Expertise;?>']);
	$EducationalBackground=$mysqli->real_escape_string($_POST['EducationalBackground']);
	$Qualifications=$mysqli->real_escape_string($_POST['Qualifications']);
	$ResearchExperience=$mysqli->real_escape_string($_POST['ResearchExperience']);
	$RoleofTeamMember=$mysqli->real_escape_string($_POST['RoleofTeamMember']);
	$InstitutionofAffiliation=$mysqli->real_escape_string($_POST['InstitutionofAffiliation']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$sqlUsers="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$asrmApplctID' and `Surname`='$Surname' and `is_sent`='0' order by piID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and `is_sent`='0' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."principal_investigators (`conceptm_id`,`owner_id`,`Surname`,`Othername`,`Gender`,`AgeRange`,`<?php echo $lang_Contacts;?>`,`<?php echo $lang_Expertise;?>`,`EducationalBackground`,`Qualifications`,`ResearchExperience`,`RoleofTeamMember`,`InstitutionofAffiliation`,`updatedon`,`is_sent`) 

values('$conceptm_id','$asrmApplctID','$Surname','$Othername','$Gender','$AgeRange','$<?php echo $lang_Contacts;?>','$<?php echo $lang_Expertise;?>','$EducationalBackground','$Qualifications','$ResearchExperience','$RoleofTeamMember','$InstitutionofAffiliation',now(),'0')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new Project Team");


}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and conceptID='$conceptm_id' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `PrincipalInvestigator`='1' where `owner_id`='$asrmApplctID' and `conceptID`='$conceptm_id' and status='new'";
$mysqli->query($sqlASubmissionStages);
}

}

/////////////////Begin Education Details
if($_POST['doSaveDetails']=='Save Details')
{
$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);


$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and `is_sent`='0' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	$conceptm_id=$rUserInvrr['conceptID'];
	
for ($i=0; $i < count($_POST['educn_university']); $i++) {
$educn_university=$_POST['educn_university'][$i];
$educn_qualification=$_POST['educn_qualification'][$i];
$educn_year=$_POST['educn_year'][$i];
$educn_specialisation=$_POST['educn_specialisation'][$i];


///////////////////////////////////////////////////////////////////
$QRR1="select * from ".$prefix."education_history where `rstug_educn_university`='$educn_university' and `rstug_educn_year`='$educn_year' and rstug_user_id='$asrmApplctID' and conceptID='$conceptm_id' and is_sent='0'";
$mmR1=$mysqli->query($QRR1);
$TotalsR1=$mmR1->num_rows;


if($TotalsR1){
$message='<strong style="color:red; font-size:16px;">Dear, this looks to be a duplicate entry</strong>';	
}


if(!$TotalsR1 and $conceptm_id){
$Insert_QR2="insert into ".$prefix."education_history (`rstug_user_id`,`rstug_educn_university`,`rstug_educn_qualification`,`rstug_educn_class`,`rstug_educn_year`,`rstug_educn_specialisation`,`rstug_educn_process_status`,`conceptID`,`is_sent`) values ('$asrmApplctID','$educn_university','$educn_qualification','$educn_class','$educn_year','$educn_specialisation','Completed','$conceptm_id','0')";
$mysqli->query($Insert_QR2);
$record_id = $mysqli->insert_id;


//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and conceptID='$conceptm_id' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $record_id){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `PrincipalInvestigatorEducation`='1' where `owner_id`='$asrmApplctID' and `conceptID`='$conceptm_id' and status='new'";
$mysqli->query($sqlASubmissionStages);
}


if($record_id){
$message='<strong style="color:blue; font-size:16px;">Information has been successfully updated, please complete all the other pending requirements</strong>';
}
if(!$record_id){
$message='<strong style="color:red; font-size:16px;">Information was not saved</strong>';}
}
}//end foreach





}



?>






<div id="proposalResearchTeam" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("proposal_submit_now_final_button.php");?>
   
  <h3>Research Team - Details</h3>
  
  <?php
  $asrmApplctID2=$usrm_id;
$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$asrmApplctID2' and piID='$id' order by piID desc limit 0,10";
$QueryUsers4 = $mysqli->query($sqlUsers4);
if($QueryUsers4->num_rows){
	$rUserInv2=$QueryUsers4->fetch_array();

?>
<div style="overflow-x:auto;">
  <table width="100%" border="0" id="customers">
  <tr>
    <th>Name</th>
    <th>Gender</th>
    <th><?php echo $lang_AgeRange;?></th>
    <th><?php echo $lang_Contacts;?></th>
    <th><?php echo $lang_Expertise;?></th>
    <!--    <th><?php echo $lang_ResearchExperience;?></th>
    <th><?php echo $$lang_RoleofTeamMember;?></th>
    <th><?php echo $lang_institution_of_affiliation;?></th>-->
  </tr>
  

  <tr>
    <td><?php echo $rUserInv2['Surname'];?> <?php echo $rUserInv2['Othername'];?></td>
    <td><?php echo $rUserInv2['Gender'];?></td>
    <td><?php echo $rUserInv2['AgeRange'];?></td>
    <td><?php echo $rUserInv2['<?php echo $lang_Contacts;?>'];?></td>
    <td><?php echo $rUserInv2['<?php echo $lang_Expertise;?>'];?></td>
    <?php /*?>    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td><?php echo $rUserInv2['InstitutionofAffiliation'];?></td><?php */?>
  </tr>
  <tr>
    <th><?php echo $lang_ResearchExperience;?></th>
    <th><?php echo $lang_ResearchExperience;?> Details</th>
    <th><?php echo $$lang_RoleofTeamMember;?></th>
    <th><?php echo $lang_institution_of_affiliation;?></th>
    <th><?php echo $lang_Updatedon;?</th>
    <!--    <th><?php echo $lang_ResearchExperience;?></th>
    <th><?php echo $$lang_RoleofTeamMember;?></th>
    <th><?php echo $lang_institution_of_affiliation;?></th>-->
  </tr>
  

  <tr>
    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['ResearchExperienceDetails'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td><?php echo $rUserInv2['InstitutionofAffiliation'];?></td>
    <td><?php echo $rUserInv2['updatedon'];?></td>
    <?php /*?>    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td><?php echo $rUserInv2['InstitutionofAffiliation'];?></td><?php */?>
  </tr>
  


  
  
</table>
</div>

<?php }?>



<?php if($message){echo $message;}?>

<?php
$QRp6="select * from ".$prefix."education_history where rstug_user_id='$asrmApplctID2' and is_sent='0' and piID='$id'";
$QRDp6=$mysqli->query($QRp6);
if($TotalsEduc=$QRDp6->num_rows){
?>
<div style="overflow-x:auto;">
<table width="100%" id="rounded-corner" summary="2007 Major IT Companies' Profit">
    <thead>
    	<tr>
        	<th scope="col" class="rounded-company"></th>
        
        	<th scope="col" class="rounded"><?php echo $lang_University;?></th>
        	<th scope="col" class="rounded"><?php echo $lang_Qualification;?></th>
            <th scope="col" class="rounded"><?php echo $lang_Year;?></th>
            <th scope="col" class="rounded"><?php echo $lang_Specialisation;?></th>
        </tr>
    </thead>

    <tbody>
    <?php
while($QR_Totalp6=$QRDp6->fetch_array())
{
	
	?>
    	<tr>
        	<td><input type="checkbox" name="" /></td>

       	  <td><?php echo $QR_Totalp6['rstug_educn_university'];?></td>
        	<td><?php echo $QR_Totalp6['rstug_educn_qualification'];?> </td>
        	<td><?php echo $QR_Totalp6['rstug_educn_year'];?> </td>
            <td><?php echo $QR_Totalp6['rstug_educn_specialisation'];?> </td>
       	</tr>
        <?php }?>
    </tbody>
</table></div><?php }?>

<div style="clear:both; margin-top:10px;"></div>
<a href="./main.php?option=proposalResearchTeam" style="background-color:#06F; color:#fff;padding:5px;"><?php echo $lang_BacktoList;?> </a>


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h3><strong>Add a Team Member</strong></h3>
    </div>
    <div class="modal-body">
    <!--<h4>Name Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal</h4>-->
     <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    
    <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

 <div class="row success">

    <div class="leftm">
     <label for="lname">Surname <span class="error">*</span></label>
      <input type="text" id="Surname" name="Surname" placeholder=".." class="required">
    </div>
    
    <div class="rightm">
     <label for="lname">Othername <span class="error">*</span></label>
      <input type="text" id="Othername" name="Othername" placeholder="Othername" class="required">
    </div>
    
    
  </div>

<div style="clear:both;"></div>
 <div class="row success">

    <div class="leftm">
     <label for="lname">Gender (M/F) <span class="error">*</span></label>
       <select id="Gender" name="Gender" class="required">
<option value="Male"> Male</option>
<option value="Female"> Female</option>
      </select>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_AgeRange;?> <span class="error">*</span></label>
      <input type="text" id="AgeRange" name="AgeRange" placeholder=".." class="required">
    </div>
    
    
  </div>
                 
<div style="clear:both;"></div>
 <div class="row success">

    <div class="leftm">
     <label for="lname">Telephone Contact <span class="error">*</span></label>
    <input type="text" id="<?php echo $lang_Contacts;?>" name="<?php echo $lang_Contacts;?>" placeholder=".." class="required">
      </select>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_Expertise;?>/Speciality <span class="error">*</span></label>
      <input type="text" id="<?php echo $lang_Expertise;?>" name="<?php echo $lang_Expertise;?>" placeholder=".." class="required">
    </div>
    
    
  </div>
  
  
  
  <div style="clear:both;"></div>
 <!--<div class="row success">

    <div class="leftm">
     <label for="lname">Educational Background <span class="error">*</span></label>
    <input type="text" id="EducationalBackground" name="EducationalBackground" placeholder=".." class="required">
      </select>
    </div>
    
    <div class="rightm">
     <label for="lname">Qualifications <span class="error">*</span></label>
      <input type="text" id="Qualifications" name="Qualifications" placeholder=".." class="required">
    </div>
    
    
  </div>!-->
  
  
     <div style="clear:both;"></div>
 <div class="row success">

    <div class="leftm">
    <!-- <label for="lname"><?php echo $lang_ResearchExperience;?> (References in Publication) <span class="error">*</span></label>
    <input type="text" id="ResearchExperience" name="ResearchExperience" placeholder=".." class="required">
      </select>!-->
      
         <label for="lname"><?php echo $lang_RoleofTeamMemberonProject;?> <span class="error">*</span></label>
    
       <select id="RoleofTeamMember" name="RoleofTeamMember" class="required">
       <option value=""> Please Select</option>
<option value="Principal Investigator"> Principal Investigator</option>
<option value="Co-Investigator"> Co-Investigator</option>
<option value="Team Member"> Team Member</option>

      </select>
    </div>
    
    <div class="rightm">
     <label for="lname"><?php echo $lang_institution_of_affiliation;?> <span class="error">*</span></label>
      <input type="text" id="InstitutionofAffiliation" name="InstitutionofAffiliation" placeholder=".." class="required">
    </div>
    
    
  </div>
  <div style="clear:both;"></div>
 <div class="row success">


    
    <div class="rightm">
    <input type="submit" name="doSaveData" value="Save">
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