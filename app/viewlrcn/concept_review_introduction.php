<?php
///Get project Owner
$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_concents where  owner_id='$owner_id'  and conceptID='$id' and reviewer_id='$usrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_concents  set `Introduction`='1' where `owner_id`='$owner_id'  and conceptID='$id' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}

$sqlUsers2="SELECT * FROM ".$prefix."introduction_concept where `owner_id`='$owner_id' and `conceptID`='$id' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."review_concents where reviewer_id='$sessionusrm_id' and reviewer_id='$usrm_id'  and conceptID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?><div class="tab">

 <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewProjectInformation/<?php echo $id;?>/'"><?php echo $lang_new_ProjectInformation;?></button>
 
  <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button>
  
    <button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'ReviewconceptIntroduction')" id="defaultOpen"><?php echo $lang_new_Introduction;?></button>
    
   <button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button>
   
  <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=ReviewconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
  
  <button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button>
  
  <button <?php if($rUConceptStages['Attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptAttachments&id=<?php echo $id;?>'">Attachments </button>
</div>

<div id="ReviewconceptIntroduction" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?> 
   
  <h3><?php echo $lang_new_Introduction;?></h3>

 
 <div class="container"><!--begin-->
 
 <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">8. Introduction (Max 250 words)</label><br />
  <strong> <?php echo nl2br($rUserInv2['Introduction']);?></strong>
    </div>
  </div>
  <div class="row success">

    <div class="col-100">
    <label for="lname">9. Objectives (Max 100 words)- Explain the aims and objectives of the proposed research within the context of the state-of –the art of the scientific area related to the project.</label><br />
<strong><?php echo nl2br($rUserInv2['Objectives']);?></strong>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="lname">10. Expected output(s), (Max 100 words)</label><br />
 <strong><?php echo nl2br($rUserInv2['Expectedoutput']);?></strong>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="lname">11.	Expected outcome(s), (Max 100 words)</label><br />
 <strong><?php echo nl2br($rUserInv2['Expectedoutcome']);?></strong>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">12. Impact (250 Words) <br />
(a) Scientific Impact 
</label><br />
    <strong><?php echo nl2br($rUserInv2['Impact']);?></strong>
    </div>
  </div>
  
     <div class="row success">

    <div class="col-100">
    <label for="lname">(b) Economic impact 
</label><br />
    <strong><?php echo nl2br($rUserInv2['Economicimpact']);?></strong>
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">(c) Environmental Impact
</label><br />
    <strong><?php echo nl2br($rUserInv2['EnvironmentalImpact']);?></strong>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">(d) Societal impact</label><br />
    <strong><?php echo nl2br($rUserInv2['SocietalImpact']);?></strong>
    </div>
  </div>
  
      <div class="row success">

    <div class="col-100">
    <label for="lname">13. Describe the project alignment of this project to the National Vision/Development Plan (Max 100 words) (s) 
</label><br />
 <strong><?php echo nl2br($rUserInv2['DescribeProjectAlignment']);?></strong>
    </div>
  </div>
  
  


  
</div><!--End-->







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
</script><?php }?>