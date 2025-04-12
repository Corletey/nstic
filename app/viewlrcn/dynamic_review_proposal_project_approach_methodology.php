<?php
$grantID=$_GET['grantID'];

if(!$_GET['grantID']){
echo '<meta http-equiv="refresh" content="0; url='.$base_url.'main.php?option=dashboard&id="'.$grantID.'"" />';	
}
$wmOwner="select * from ".$prefix."submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];
$usrm_idowner=$rowner['owner_id'];

$wm="select * from ".$prefix."review_proposals where  owner_id='$usrm_idowner' and status='new' and reviewer_id='$usrm_id' and projectID='$id' and grantID='$grantID'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_proposals  set `Methodology`='1' where `owner_id`='$usrm_idowner' and status='new' and reviewer_id='$usrm_id' and projectID='$id' and grantID='$grantID'";
$mysqli->query($sqlASubmissionStages);
}
}
$usrm_id=$rowner['owner_id'];

$sqlUsers2="SELECT * FROM ".$prefix."project_methodology where `owner_id`='$usrm_idowner' and `projectID`='$id' order by methodologyID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$usrm_idowner=$rowner['owner_id'];
$wProjectStages="select * from ".$prefix."review_proposals where reviewer_id='$sessionusrm_id' and owner_id='$usrm_idowner'  and projectID='$id'";
$cmProjectStages = $mysqli->query($wProjectStages);
$rProjectStages=$cmProjectStages->fetch_array();
?>

<?php
require("dynamic_categories_review.php");
?>
<div class="tab">

<?php if($total_Information){?><button <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewPrososal&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
  
<?php if($total_Team){?><button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewProjectTeam&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button><?php }?> 
  
<?php if($total_Background){?><button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalBackground&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Background;?> </button><?php }?>
  
  
<?php if($total_Methodology){?><button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newreviewproposalMethodology')" id="defaultOpen"><?php echo $lang_new_ApproachMethodology;?> </button><?php }?>
    
    
<?php if($total_Budget){?><button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
    
<?php if($total_Results){?> <button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button><?php }?>
  
  <?php if($total_Management){?><button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button><?php }?>
  
  <?php if($total_Followup){?><button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button><?php }?>
  
 <?php if($total_Citations){?> <button <?php if($rProjectStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalReferences&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
  <?php if($total_Attachments){?><button <?php if($rProjectStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewproposalAttachments&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>

  
</div>

<div id="newreviewproposalMethodology" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>    
    
  <h3><?php echo $lang_new_ApproachMethodology;?> </h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>

 <?php
$sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_h where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
?>

<?php if($rowsSubmitted_c['generalApproach_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['generalApproach'];?>  <span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['generalApproach'];?></strong>
    </div>
  </div>
   <?php }?>

<?php if($rowsSubmitted_c['RelationshipOngoingResearch_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['RelationshipOngoingResearch'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['RelationshipOngoingResearch'];?></strong>
    </div>
  </div>
   <?php }?>

<?php if($rowsSubmitted_c['otherDonorsFunding_status']){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['otherDonorsFunding'];?><span class="error">*</span>
   <br /><strong><?php echo $rUserInv2['otherDonorsFunding'];?></strong>
    </label>

    </div>
  </div>
   <?php }?>
  
  <?php if($rowsSubmitted_c['otherDonorsFunding_status']){?>
  <div class="row success">

    <div class="col-100">
    <div id="projectOtherDonorsFunding">
    
<?php if($rUserInv2['otherDonorsFunding']=='Yes'){?>
<label for="fname"><?php echo $rowsSubmitted_c['drawSynergiesOngoingProjects'];?><!--State the Donors and components they are funding – State Amount--><span class="error">*</span><br /></label>

<table width="50%" border="0" id="customers2">
        <tr>
            <th style=" display:none;">&nbsp;</th>
            <th><strong><?php echo $lang_Donor;?></strong>
            </th>
            <th><strong><?php echo $lang_new_Amount;?></strong>
            </th>
  
        </tr>
    
        
        <?php 
$projectID=$rUserProjectID['projectID'];
$sqlProjectID="SELECT * FROM ".$prefix."project_methodology_donors where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td><?php echo $rUserProjectID['StateDonors'];?>
            </td>
            <td><?php echo number_format($rUserProjectID['StateAmount']);?>
            </td>
       
        </tr>
        <?php }?>
    </table>
<?php }?>
    
    
    
    
    </div>
    </div>
    </div>
     <?php }?>
     
     
    
    <?php if($rowsSubmitted_c['furtheringwork_status']){?>
 <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['furtheringwork'];?><br /><strong><?php echo $rUserInv2['furtheringWork'];?></strong>
   <div id="projectfurtheringWork">
   
   <?php 
if($rUserInv2['furtheringWork']=='Yes'){?><br />
<strong><?php echo $rUserInv2['furtheringWorkHow'];?></strong><?php }?>
   
   </div> 

    </div>
  </div>
   <?php }?>
  
   <div class="row success">

    <div class="col-100">
   
   
   <div id="projectdrawSynergies">
   
   <?php 
if($rowsSubmitted_c['synergymayexistbetween_status']){?>
<label for="fname"><?php echo $rowsSubmitted_c['synergymayexistbetween'];?><!--Name the Projects and the objectives. (Max 3 Projects)--> <span class="error">*</span><br /></label>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="POITable3">
<tr>
            <td style=" display:none;">&nbsp;</td>
       <th>
              <?php echo $lang_Project;?></th>
            <th><?php echo $lang_Task;?></th>
            <th> <?php echo $lang_Descrption;?></th>

     
        </tr>
        <?php 
$sqlProjectID3="SELECT * FROM ".$prefix."potential_for_synergy where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID3 = $mysqli->query($sqlProjectID3);
while($rUserProjectID3=$QueryProjectID3->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td>
              <label><?php echo $rUserProjectID3['SynergyProject'];?></label></td>
            <td><label><?php echo $rUserProjectID3['SynergyTask'];?></label></td>
            <td><label><?php echo $rUserProjectID3['SynergyDescrption'];?></label></td>
            
    
   
        </tr>
        <?php }?>
    </table>
    
    <?php }?>
   
   </div> 

    
    
    </label>

    </div>
  </div> 
  
  
  
  <?php if($rowsSubmitted_c['']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['synergymayexistbetween'];?><!--Explain where a potential for synergy may exist between different tasks of the project and how this is going to be exploited.--><span class="error">*</span></label>
<table width="100%" border="0" id="customers2">
        <tr>
            <th><strong><?php echo $lang_Project;?></strong></th>
            <th><strong><?php echo $lang_Task;?></strong></th>
            <th> <strong><?php echo $lang_Descrption;?></strong></th>
     
        </tr>
       <?php 
$sqlProjectID3="SELECT * FROM ".$prefix."potential_for_synergy where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID3 = $mysqli->query($sqlProjectID3);
while($rUserProjectID3=$QueryProjectID3->fetch_array()){
?>
        <tr>
   
            <td>
              <label><?php echo $rUserProjectID3['SynergyProject'];?></label></td>
            <td><label><?php echo $rUserProjectID3['SynergyTask'];?></label></td>
            <td><label><?php echo $rUserProjectID3['SynergyDescrption'];?></label></td>
         
        </tr>
        <?php }?>
    </table>

    </div>
  </div>
   <?php }?>
  


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