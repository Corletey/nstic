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
$sqlASubmissionStages="update ".$prefix."review_proposals  set `ProjectResults`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}
}

$usrm_id=$rowner['owner_id'];
$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();

$sqlUsers2="SELECT * FROM ".$prefix."project_results where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
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
  
  <button  <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewProjectTeam&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rProjectStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBackground&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rProjectStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalMethodology&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>

   <button <?php if($rProjectStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalBudget&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_Budget;?></button>
   
   <button <?php if($rProjectStages['ProjectResults']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewproposalResults')" id="defaultOpen"><?php echo $lang_new_ProjectResults;?></button>
   
  
  <button <?php if($rProjectStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalManagement&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rProjectStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewproposalFollowup&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
  
</div>

<div id="reviewproposalResults" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?>    
    
  <h3>Project Results (max. 1000 words)</h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->
<label for="fname"><strong>Theory of Change</strong></label><br />
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><strong>Please describe in narrative the relationship, logical flow and/or causalities between planned activities, expected results (output), desired changes (outcome) and main objective (contribution to impact). A context analysis that includes the assumptions underlying the Research Impact Pathway should be part of the Theory of Change.</strong><br />
    Research Impact Pathway  <span class="error">*</span></label>

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="customers">
        <tr>
        
      
           <th width="20%"><strong><em>Research outputs</em></strong></th>
    <th width="17%"><strong><em>Indicators</em></strong></th>
    <th width="6%">&nbsp;</th>
    <th width="20%"><strong><em>Research outcomes</em></strong></th>
    <th width="16%"><strong><em>Indicators</em></strong></th>
    <th width="7%">&nbsp;</th>
    <th width="14%"><strong><em>Impact</em></strong></th>
     
        </tr>
      
        
        <?php 
$sqlProjectID="SELECT * FROM ".$prefix."research_impact_pathway where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
     
           <td width="20%"><?php echo $rUserProjectID['ResearchOutputs1'];?></td>
    <td width="17%"><?php echo $rUserProjectID['ResearchOutputsIndicators1'];?></td>
    <td width="6%">&nbsp;</td>
    <td width="20%"><?php echo $rUserProjectID['ResearchOutcomes1'];?></td>
    <td width="16%"><?php echo $rUserProjectID['ResearchOutcomesIndicators1'];?></td>
    <td width="7%">&nbsp;</td>
    <td width="14%"><?php echo $rUserProjectID['Impact1'];?></td>
      
        </tr>
        <?php }?>
        </table>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="fname">a) Research objective: the main objective of the research project, in relation to the objectives of the call;<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['ResearchObjective'];?></strong>
    </div>
  </div>


    <div class="row success">

    <div class="col-100">
    <label for="fname">b) Outputs: the most immediate results of the research project. Research outcomes relate to the uptake of these outputs by external stakeholders and the effects thereof;<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['Outputs'];?></strong>
    </div>
  </div>
  
 <div class="row success">

    <div class="col-100">
    <label for="fname">c) Outcomes: The external use, adoption or influence of a project's outputs by next and final users that results in adopter-level changes needed to achieve the intended impact. Indicate the (economic, social, environmental) changes that are expected at the level of the adopters;<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['Outcomes'];?></strong>
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Impact: changes in Scientific, economic, environmental and social conditions that the project is working toward. <br />
  a) Capacity development: Describe the activities incorporated in the project with the purpose of capacity development.<br /><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['ImpactCapacityDevelopment'];?></strong>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">b) Impact pathway diagram with indicators at output and outcome level <span class="error">(pdf only)</span><span class="error">*</span></label>

<?php if($rUserInv2['ImpactPathwayDiagram']){?>

<br /><a href="./files/<?php echo $rUserInv2['ImpactPathwayDiagram'];?>" target="_blank">Impact pathway diagram</a><?php }?>

    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Knowledge sharing and research uptake (Max 250 words)<br />
  Stakeholder engagement: Include an initial mapping of relevant stakeholders and their roles and contributions in the project at all stages.<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['StakeholderEngagement'];?></strong>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Communication with stakeholders (including communication strategies, methods and technologies): Describe the proposed activities and their timeline. Include in this section a description of the planned communication activities, specifying target groups, specific objectives, communication issues and products as well as means of communication.<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['CommunicationWithStakeholders'];?></strong>
    </div>
  </div>
  
     <div class="row success">

    <div class="col-100">
    <label for="fname">Scientific output.<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv2['ScientificOutput'];?></strong>
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