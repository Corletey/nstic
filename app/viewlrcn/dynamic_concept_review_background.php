<?php
$sqlUsers2="SELECT * FROM ".$prefix."introduction_concept where `owner_id`='$owner_id' and `conceptID`='$conceptID' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."review_concents where reviewer_id='$sessionusrm_id' and reviewer_id='$usrm_id'  and conceptID='$conceptID'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?><div class="tab">
<?php require_once("dynamic_categories.php");?>
  
  <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewProjectInformation&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
  
  <?php if($total_Team){?><button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'ReviewconceptPrincipalInvestigator')" id="defaultOpen"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptIntroduction&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button><?php }?>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptProjectDetails&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>

<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newReviewconceptBudget&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptReferences&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>

<?php if($total_Attachments){?><button <?php if($rUConceptStages['Attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptAttachments&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_ViewAttachment;?> </button><?php }?>
</div>



<div id="ReviewconceptPrincipalInvestigator" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?>  
   
  <h3>Project Team - Details</h3>
  
  <?php
  $asrmApplctID2=$usrm_id;
$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where piID='$bkey' order by piID desc limit 0,10";
$QueryUsers4 = $mysqli->query($sqlUsers4);
if($QueryUsers4->num_rows){
	$rUserInv2=$QueryUsers4->fetch_array();

$owner_id=$rUserInv2['owner_id'];
$conceptm_id=$rUserInv2['conceptm_id'];
?>
<div style="overflow-x:auto;">
  <table width="100%" border="0" id="customers">
  <tr>
    <th><?php echo $lang_new_Name;?></th>
    <th><?php echo $lang_Gender;?></th>
    <th><?php echo $lang_AgeRange;?></th>
    <th><?php echo $lang_Contacts;?></th>
    <th><?php echo $lang_Expertise;?></th>
  
  </tr>
  

  <tr>
    <td><?php echo $rUserInv2['Surname'];?> <?php echo $rUserInv2['Othername'];?></td>
    <td><?php echo $rUserInv2['Gender'];?></td>
    <td><?php echo $rUserInv2['AgeRange'];?></td>
    <td><?php echo $rUserInv2['Contacts'];?></td>
    <td><?php echo $rUserInv2['Expertise'];?></td>
    <?php /*?>    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td><?php echo $rUserInv2['InstitutionofAffiliation'];?></td><?php */?>
  </tr>
  <tr>
    <th><?php echo $lang_ResearchExperience;?></th>
    <th><?php echo $lang_ResearchExperience;?></th>
    <th><?php echo $lang_RoleofTeamMember;?></th>
    <th><?php echo $lang_institution_of_affiliation;?></th>
    <th><?php echo $lang_Updatedon;?></th>

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
$QRp6="select * from ".$prefix."education_history where rstug_user_id='$owner_id' and piID='$bkey'";
$QRDp6=$mysqli->query($QRp6);
if($TotalsEduc=$QRDp6->num_rows){
?>
<div style="overflow-x:auto;">
<table width="100%" id="rounded-corner" summary="2007 Major IT Companies' Profit">
    <thead>
    	<tr>
        	<th scope="col" class="rounded"><?php echo $lang_University;?></th>
        	<th scope="col" class="rounded"><?php echo $lang_Qualifications;?></th>
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
       	  <td><?php echo $QR_Totalp6['rstug_educn_university'];?></td>
        	<td><?php echo $QR_Totalp6['rstug_educn_qualification'];?> </td>
        	<td><?php echo $QR_Totalp6['rstug_educn_year'];?> </td>
            <td><?php echo $QR_Totalp6['rstug_educn_specialisation'];?> </td>
       	</tr>
        <?php }?>
    </tbody>
</table></div><?php }?>

<?php
$QRp6="select * from ".$prefix."work_experience where rstug_user_id='$owner_id' and piID='$bkey'";
$QRDp6=$mysqli->query($QRp6);
if($TotalsEduc=$QRDp6->num_rows){
?>
<div style="overflow-x:auto;">
<table width="100%" border="0" id="customers">
    <thead>
    	<tr>
        	<th scope="col" class="rounded"><?php echo $lang_Institution;?></th>
        	<th scope="col" class="rounded"><?php echo $lang_PositionHeld;?></th>
            <th scope="col" class="rounded"><?php echo $lang_new_StartDate;?></th>
            <th scope="col" class="rounded"><?php echo $lang_new_EndDate;?></th>
   
        </tr>
    </thead>

    <tbody>
    <?php
while($QR_Totalp6=$QRDp6->fetch_array())
{
	
	?>
    	<tr>
       	  <td><?php echo $QR_Totalp6['Institution'];?></td>
        	<td><?php echo $QR_Totalp6['PositionHeld'];?> </td>
        	<td><?php echo $QR_Totalp6['YearofRecruitment'];?> </td>
        	<td><?php echo $QR_Totalp6['YearofDeparture'];?></td>
 
       	</tr>
        <?php }?>
    </tbody>
</table></div><?php }?>
<div style="clear:both; padding-bottom:10px;"></div>
<a href="./main.php?option=newReviewconceptPrincipalInvestigator&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>" style="background-color:#06F; color:#fff;padding:5px;"><?php echo $lang_BacktoList;?> </a>


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