<?php
$grantID=$_GET['grantID']; 
$wmOwner="select * from ".$prefix."submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
$sessionusrm_id=$_SESSION['usrm_id'];
$usrm_idowner=$rowner['owner_id'];
$wProjectStages="select * from ".$prefix."review_proposals where reviewer_id='$sessionusrm_id' and owner_id='$usrm_idowner'  and projectID='$id'";
$cmProjectStages = $mysqli->query($wProjectStages);
$rProjectStages=$cmProjectStages->fetch_array();
?><div class="tab">
  
<button  <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewPrososal&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  
 
  
     <button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewProjectTeam')" id="defaultOpen"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  
  
  <button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBackground&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalMethodology&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>

   <button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button>
   
   <button  <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button>  
  
  <button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
  

</div>


<div id="newreviewProjectTeam" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
  <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?> 
   
  <h3>Research Team - Details</h3>
  
  <?php
  $asrmApplctID2=$bt;
$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where piID='$bkey' order by piID desc limit 0,10";
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
    <th><?php echo $lang_Updatedon;?></th>
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

<div style="clear:both; height:10px;"></div>
<a href="./main.php?option=reviewProjectTeam&id=<?php echo $id;?>" style="background-color:#06F; color:#fff;padding:5px;"><?php echo $lang_BacktoList;?> </a>



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