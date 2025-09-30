<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."concept_stages where  owner_id='$sessionusrm_id' and status='new' and grantcallID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();

?>
<div class="tab">
  <?php require_once("dynamic_categories.php");?>
  
   <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newSubmitConcept&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
   
<?php if($total_Team){?><button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newconceptPrincipalInvestigator')" id="defaultOpen"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button><?php }?>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
   
<?php if($total_Attachments){?><button <?php if($rUConceptStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptAttachments&id=<?php echo $id;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>
</div>
<?php
/////////////////Begin Education Details
if($_POST['doSaveData']=='Save Details')
{
$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
$details=$mysqli->real_escape_string($_POST['details']);

$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and `is_sent`='0' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	$conceptm_id=$rUserInvrr['conceptID'];
	
///////////////////////////////////////////////////////////////////
$QRR1="select * from ".$prefix."research_experience where `details`='$details' and conceptID='$conceptm_id' and is_sent='0'";
$mmR1=$mysqli->query($QRR1);
$TotalsR1=$mmR1->num_rows;


if($TotalsR1){
$message='<strong style="color:red; font-size:16px;">Dear, this looks to be a duplicate entry</strong>';	
}


if(!$TotalsR1 and $conceptm_id){
$Insert_QR2="insert into ".$prefix."research_experience (`details`,`owner_id`,`conceptID`,`is_sent`) values ('$details','$asrmApplctID','$conceptm_id','0')";
$mysqli->query($Insert_QR2);
$record_id = $mysqli->insert_id;


//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and conceptID='$conceptm_id' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $record_id){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `PrincipalInvestigatorResearch`='1' where `owner_id`='$asrmApplctID' and `conceptID`='$conceptm_id' and status='new'";
$mysqli->query($sqlASubmissionStages);
}


if($record_id){
$message='<strong style="color:blue; font-size:16px;">Information has been successfully updated, please complete all the other pending requirements</strong>';
}
if(!$record_id){
$message='<strong style="color:red; font-size:16px;">Information was not saved</strong>';}
}


}



?>






<div id="newconceptPrincipalInvestigator" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("concept_submit_now_final_button.php");?>
   
  <h3>Project Team - <?php echo $lang_ResearchExperience;?></h3>
  
  <?php
  $asrmApplctID2=$usrm_id;
$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where `owner_id`='$asrmApplctID2' and `is_sent`='0' order by piID desc limit 0,10";
$QueryUsers4 = $mysqli->query($sqlUsers4);
if($QueryUsers4->num_rows){

?>
<div style="overflow-x:auto;">
  <table width="100%" border="0" id="customers">
  <tr>
    <th>Name</th>
    <th>Gender</th>
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
    <td><?php echo $rUserInv2['<?php echo $lang_Contacts;?>'];?></td>
    <td><?php echo $rUserInv2['<?php echo $lang_Expertise;?>'];?></td>
    <td><?php //echo $rUserInv2['EducationalBackground'];?>
      <a href="./main.php?option=newconceptAddEducationBackground&id=<?php echo $rUserInv2['piID'];?>" style="background-color: #4CAF50; color:#fff;padding:5px;">Add/View Education Background</a><br /><br />
      <a href="./main.php?option=newconceptAddResearchExperience&id=<?php echo $rUserInv2['piID'];?>" style="background-color: #4CAF50; color:#fff; padding:5px;">Add/View <?php echo $lang_ResearchExperience;?></a><br />
      
    </td>
    <?php /*?>    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td><?php echo $rUserInv2['InstitutionofAffiliation'];?></td><?php */?>
  </tr>
  <?php }?>
</table>
</div>

<?php }?>


<button id="myBtn">Add <?php echo $lang_ResearchExperience;?> </button><br /><br />
<?php if($message){echo $message;}?>

<?php
$QRp6="select * from ".$prefix."research_experience where owner_id='$asrmApplctID2' and is_sent='0'";
$QRDp6=$mysqli->query($QRp6);
if($TotalsEduc=$QRDp6->num_rows){
?>
<div style="overflow-x:auto;">
<table width="100%" id="rounded-corner" summary="2007 Major IT Companies' Profit">
    <thead>
    	<tr>
        	<th scope="col" class="rounded-company"></th>
        
        	<th scope="col" class="rounded"><?php echo $lang_ResearchExperience;?></th>

        </tr>
    </thead>

    <tbody>
    <?php
while($QR_Totalp6=$QRDp6->fetch_array())
{
	
	?>
    	<tr>
        	<td><input type="checkbox" name="" /></td>

       	  <td><?php echo $QR_Totalp6['details'];?></td>

       	</tr>
        <?php }?>
    </tbody>
</table></div><?php }?>







<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h3><strong>Add <?php echo $lang_ResearchExperience;?></strong></h3>
    </div>
    <div class="modal-body">
    <!--<h4>Name Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal</h4>-->
     <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    
    <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

 <div class="row success">

    <div class="left">
     <label for="lname">Details </label>
      <input type="text" id="Surname" name="details" placeholder=".." class="required">
    </div>
    

    
    
  </div>




  <div style="clear:both;"></div>
 <div class="row success">


    
    <div class="rightm">
    <input type="submit" name="doSaveData" value="Save Details">
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