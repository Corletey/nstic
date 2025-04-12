<div class="tab">
  
  <button class="tablinks"onClick="window.location.href='./main.php?option=reviewProjectInformation&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  <button class="tablinks" onclick="openCity(event, 'ReviewconceptPrincipalInvestigator')" id="defaultOpen"><?php echo $lang_new_ProjectTeam;?></button>
    <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button>
   <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button>
  <button class="tablinks"  onClick="window.location.href='./main.php?option=ReviewconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button>
</div>



<div id="ReviewconceptPrincipalInvestigator" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?>  
   
  <h3>Project Team - Details</h3>
  
  <?php
  $asrmApplctID2=$usrm_id;
$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where piID='$id' order by piID desc limit 0,10";
$QueryUsers4 = $mysqli->query($sqlUsers4);
if($QueryUsers4->num_rows){
	$rUserInv2=$QueryUsers4->fetch_array();

$owner_id=$rUserInv2['owner_id'];
$conceptm_id=$rUserInv2['conceptm_id'];
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
$QRp6="select * from ".$prefix."education_history where rstug_user_id='$owner_id' and piID='$id'";
$QRDp6=$mysqli->query($QRp6);
if($TotalsEduc=$QRDp6->num_rows){
?>
<div style="overflow-x:auto;">
<table width="100%" id="rounded-corner" summary="2007 Major IT Companies' Profit">
    <thead>
    	<tr>
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
       	  <td><?php echo $QR_Totalp6['rstug_educn_university'];?></td>
        	<td><?php echo $QR_Totalp6['rstug_educn_qualification'];?> </td>
        	<td><?php echo $QR_Totalp6['rstug_educn_year'];?> </td>
            <td><?php echo $QR_Totalp6['rstug_educn_specialisation'];?> </td>
       	</tr>
        <?php }?>
    </tbody>
</table></div><?php }?>

<?php
$QRp6="select * from ".$prefix."work_experience where rstug_user_id='$owner_id' and piID='$id'";
$QRDp6=$mysqli->query($QRp6);
if($TotalsEduc=$QRDp6->num_rows){
?>
<div style="overflow-x:auto;">
<table width="100%" border="0" id="customers">
    <thead>
    	<tr>
        	<th scope="col" class="rounded">Institution</th>
        	<th scope="col" class="rounded">Position Held</th>
            <th scope="col" class="rounded">Start <?php echo $lang_Year;?></th>
            <th scope="col" class="rounded">End <?php echo $lang_Year;?></th>
   
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
<a href="./main.php?option=ReviewconceptPrincipalInvestigator&id=<?php echo $conceptm_id;?>" style="background-color:#06F; color:#fff;padding:5px;">Back to Project Teams </a>


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