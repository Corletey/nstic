<?php
$grantID=$_GET['grantID'];
$wmOwner="select * from ".$prefix."submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];
$usrm_idowner=$rowner['owner_id'];

$wm="select * from ".$prefix."review_proposals where  owner_id='$usrm_idowner' and status='new' and reviewer_id='$usrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_proposals  set `Methodology`='1' where `owner_id`='$usrm_idowner' and status='new' and reviewer_id='$usrm_id'";
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
<div class="tab">

  <button  <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewPrososal&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  
  <button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewProjectTeam&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBackground&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewproposalMethodology')" id="defaultOpen"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    
    <button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button>
  
  <button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
  
</div>

<div id="reviewproposalMethodology" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>    
    
  <h3>Project Approach/Methodology (max. 1500 words) </h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Explain the general approach and methodology chosen to achieve the project objectives. Highlight the particular advantages of the methodology chosen.  <span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['generalApproach'];?></strong>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="fname">Relationship to ongoing Research/Projects (Name of study and reference) -(max 5100 words)<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['RelationshipOngoingResearch'];?></strong>
    </div>
  </div>


    <div class="row success">

    <div class="col-100">
    <label for="fname">Are there other Donors funding this Project? Yes/No <span class="error">*</span>
   <br /><strong><?php echo $rUserInv2['otherDonorsFunding'];?></strong>
    </label>

    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <div id="projectOtherDonorsFunding">
    
<?php if($rUserInv2['otherDonorsFunding']=='Yes'){?>
<label for="fname">State the Donors and components they are funding – State Amount<span class="error">*</span><br /></label>

<table width="50%" border="0" id="customers2">
        <tr>
            <th style=" display:none;">&nbsp;</th>
            <th><strong>Donor</strong>
            </th>
            <th><strong>Amount</strong>
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
            <td><?php echo $rUserProjectID['StateAmount'];?>
            </td>
       
        </tr>
        <?php }?>
    </table>
<?php }?>
    
    
    
    
    </div>
    </div>
    </div>
    
    
 <div class="row success">

    <div class="col-100">
    <label for="fname">Is this project furthering work in an existing Project?(Y/N), if Yes(indicate how)<br /><strong><?php echo $rUserInv2['furtheringWork'];?></strong>
   <div id="projectfurtheringWork">
   
   <?php 
if($rUserInv2['furtheringWork']=='Yes'){?><br />
<strong><?php echo $rUserInv2['furtheringWorkHow'];?></strong><?php }?>
   
   </div> 

    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Is this project likely to draw synergies with other ongoing projects? Yes/No <span class="error">*</span><br />
   <strong><?php echo $rUserInv2['furtheringWork'];?></strong><span class="error">*</span></label>
   
   
   <div id="projectdrawSynergies">
   
   <?php
if($rUserInv2['furtheringWork']=='Yes'){?>
<label for="fname">Name the Projects and the objectives. (Max 3 Projects) <span class="error">*</span><br /></label>
<table id="customers2" border="0">
        <tr>
            <th>Project Name</th>
            <th>Objectives</th>
        </tr>
        <?php 
$sqlProjectID2="SELECT * FROM ".$prefix."projects_objectives where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID2 = $mysqli->query($sqlProjectID2);
while($rUserProjectID2=$QueryProjectID2->fetch_array()){
?>
        <tr>
              <td>
              <label><?php echo $rUserProjectID2['projectName'];?></label>
            </td>
            <td>
              <label><?php echo $rUserProjectID2['projectObjectives'];?></label>
            </td>
     
        </tr>
        <?php }?>
    </table><?php }?>
   
   </div> 

    
    
    </label>

    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Explain where a potential for synergy may exist between different tasks of the project and how this is going to be exploited.<span class="error">*</span></label>
<table width="100%" border="0" id="customers2">
        <tr>
            <th><strong>Project</strong></th>
            <th><strong>Task</strong></th>
            <th> <strong>Descrption</strong></th>
     
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