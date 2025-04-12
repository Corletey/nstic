<?php
///Get project Owner
$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$conceptID'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();

$grantID=$rowner['grantcallID'];
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_concents where  owner_id='$owner_id'  and conceptID='$conceptID' and reviewer_id='$usrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_concents  set `Introduction`='1' where `owner_id`='$owner_id'  and conceptID='$conceptID' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}

$sqlUsers2="SELECT * FROM ".$prefix."introduction_concept where `owner_id`='$owner_id' and `grantcallID`='$grantID' order by id desc limit 0,1";//`conceptID`='$id'
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."review_concents where reviewer_id='$sessionusrm_id' and reviewer_id='$usrm_id'  and conceptID='$conceptID'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?><div class="tab">

<?php require_once("dynamic_categories.php");?>

 <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewProjectInformation&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
 
<?php if($total_Team){?><button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptPrincipalInvestigator&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newReviewconceptIntroduction')" id="defaultOpen"><?php echo $lang_new_Introduction;?></button><?php }?>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptProjectDetails&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newReviewconceptBudget&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptReferences&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
<?php if($total_Attachments){?><button <?php if($rUConceptStages['Attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptAttachments&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_ViewAttachment;?> </button><?php }?>
</div>

<div id="newReviewconceptIntroduction" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?> 
 
 <?php 
  $sqlDynamic="SELECT * FROM ".$prefix."concept_dynamic_questions_all_b where grantID='$grantID' order by id asc";
	$QueryDynamic = $mysqli->query($sqlDynamic);
	$rowsDynamic=$QueryDynamic->fetch_array();
	?>
   
  <h3><?php echo $lang_new_Introduction;?></h3>

 
 <div class="container"><!--begin-->
 
 <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  
  <?php if($rowsDynamic['qn_introduction_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname">8. <?php echo $rowsDynamic['qn_introduction'];?></label><br />
  <strong> <?php echo nl2br($rUserInv2['Introduction']);?></strong>
    </div>
  </div>
  <?php }?>
  
  
  <?php if($rowsDynamic['qn_objectives_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="lname">9. <?php echo $rowsDynamic['qn_objectives'];?></label><br />
<strong><?php echo nl2br($rUserInv2['Objectives']);?></strong>
    </div>
  </div><?php }?>


 <?php if($rowsDynamic['qn_expectedoutput_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="lname">10. <?php echo $rowsDynamic['qn_expectedoutput'];?></label><br />
 <strong><?php echo nl2br($rUserInv2['Expectedoutput']);?></strong>
    </div>
  </div><?php }?>
  
  <?php if($rowsDynamic['qn_expectedoutcome_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="lname">11. <?php echo $rowsDynamic['qn_expectedoutcome'];?></label><br />
 <strong><?php echo nl2br($rUserInv2['Expectedoutcome']);?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsDynamic['qn_scientific_impact_status']=='Enable'){?>
    <div class="row success">

    <div class="col-100">
    <label for="lname">12. <?php echo $rowsDynamic['qn_scientific_impact'];?> <br />

</label><br />
    <strong><?php echo nl2br($rUserInv2['Impact']);?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsDynamic['qn_Economicimpact_status']=='Enable'){?>
     <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_Economicimpact'];?>
</label><br />
    <strong><?php echo nl2br($rUserInv2['Economicimpact']);?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsDynamic['qn_environmental_impact_status']=='Enable'){?>
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_environmental_impact'];?>
</label><br />
    <strong><?php echo nl2br($rUserInv2['EnvironmentalImpact']);?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsDynamic['qn_societal_impact_status']=='Enable'){?>
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_societal_impact'];?></label><br />
    <strong><?php echo nl2br($rUserInv2['SocietalImpact']);?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsDynamic['qn_describe_project_alignment_status']=='Enable'){?>
      <div class="row success">

    <div class="col-100">
    <label for="lname">13. <?php echo $rowsDynamic['qn_describe_project_alignment'];?>
</label><br />
 <strong><?php echo nl2br($rUserInv2['DescribeProjectAlignment']);?></strong>
    </div>
  </div><?php }?>
  
  


  
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