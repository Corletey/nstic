<?php
$grantID=$_GET['grantID'];
$wmOwner="select * from ".$prefix."submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_proposals where  owner_id='$owner_id' and status='new' and reviewer_id='$usrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_proposals  set `ProjectManagement`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}
}
$usrm_id=$rowner['owner_id'];
$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();

$sqlUsers2="SELECT * FROM ".$prefix."project_management where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
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
  
    <button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalMethodology&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewproposalResults&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectResults;?></button>
  
  <button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewproposalManagement')" id="defaultOpen"><?php echo $lang_new_ProjectManagement;?></button>
  
   <button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
   
</div>

<div id="reviewproposalManagement" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>    
    
  <h3>Project management (max. 400 words)</h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Describe how the overall coordination and monitoring management of the project will be implemented. Provide if possible a project organisational chart. Indicate the decision-making bodies and processes foreseen as part of the project execution (decision boards, coordination meetings). <span class="error">(pdf only)</span> <span class="error">*</span></label><br />


<?php if($rUserInv2['overallCoordination']){?>
<br /><a href="./files/<?php echo $rUserInv2['overallCoordination'];?>" target="_blank"><strong>Attachment</strong></a><?php }?>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="fname">If appropriate, set up a Gantt chart or detailed diagram giving the time schedule of the tasks and mark their interrelations; add milestones where important goals will be reached and/or decisions on further approach will have to be made; indicate a critical path marking those events which directly influence the overall time schedule in case of delays. Please make assumptions underlying the critical path and the Grant chart. (4 Assumptions) <span class="error">(pdf only)</span><span class="error">*</span></label><br />


<?php if($rUserInv2['GantChart']){?>
<br /><a href="./files/<?php echo $rUserInv2['GantChart'];?>" target="_blank"><strong>Gant Chart</strong></a><?php }?>

    </div>
  </div>


    <div class="row success">

    <div class="col-100">
    <label for="fname">Explain how information flow and communication will be enhanced within the project. Provide details of specific planned meetings and exchanges, and highlight factors likely to provide additional value to these communication processes., <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['informationFlow'];?></strong>
    </div>
  </div>
  
 <div class="row success">

    <div class="col-100">
    <label for="fname">Risk management: Indicate where there are risks of not achieving the objectives and fall-back positions, if applicable. <span class="error">*</span></label>

<table width="50%" border="0" id="customers">
        <tr>
         
            <th>Possible Risk
            </th>
            <th>Mitigation Measure
            </th>
      
        </tr>
          
        <?php 
$sqlProjectID="SELECT * FROM ".$prefix."possible_risk where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
         
            <td>
              <label><?php echo $rUserProjectID['PossibleRisk'];?></label>
            </td>
            <td>
              <label><?php echo $rUserProjectID['MitigationMeasure'];?></label>
            </td>
     
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