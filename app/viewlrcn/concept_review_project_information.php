<?php

///Get project Owner
$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_concents where  owner_id='$owner_id' and status='new' and reviewer_id='$usrm_id' and conceptID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages and $session_usertype!='user'){
$sqlASubmissionStages="insert into ".$prefix."review_concents (`owner_id`,`conceptID`,`ProjectInformation`,`PrincipalInvestigator`,`Introduction`,`ProjectDetails`,`Budget`,`cReferences`,`dateCreated`,`status`,`reviewer_id`,`Attachments`)  values('$owner_id','$id','1','0','0','0','0','0',now(),'new','$usrm_id','0')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_concents  set `ProjectInformation`='1' where `owner_id`='$owner_id' and reviewer_id='$usrm_id' and  conceptID='$id'";
$mysqli->query($sqlASubmissionStages);
}


$asrmApplctID2=$usrm_id;
$sqlUsers2="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$owner_id' and `conceptID`='$id'";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();


$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."review_concents where reviewer_id='$sessionusrm_id'  and reviewer_id='$usrm_id' and conceptID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<div class="tab">

  <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'FirstInformation')" id="defaultOpen"><?php echo $lang_new_ProjectInformation;?></button>
  
  <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button>
  
    <button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button>
    
   <button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button>
   
  <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=ReviewconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
  
  <button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button>
  
  <button <?php if($rUConceptStages['Attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=ReviewconceptAttachments&id=<?php echo $id;?>'">Attachments </button>
  
</div>

<div id="FirstInformation" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?>  
  <h3><?php echo $lang_new_ProjectInformation;?></h3>
 

 <div class="container"><!--begin-->

  <div class="row success">

    <div class="col-100">
    <label for="fname">Title (max 35 words) - Give the title of your project <span class="error">*</span></label><br />
 <strong><?php echo $rUserInv2['projectTitle'];?></strong>
    </div>
  </div>
  <div class="row success">

    <div class="col-100">
    <label for="lname">Short Title or Acronym (10 characters) <span class="error">*</span></label><br />
   <strong><?php echo $rUserInv2['titleAcronym'];?></strong>
    </div>
  </div>

  
    <div class="row success">

    <div class="col-100">
     <label for="lname">Identify the 5 most relevant keywords that represent the scientific basis of your project (max 5 words) <span class="error">*</span></label><br />
     <strong><?php echo $rUserInv2['relevantKeywords'];?></strong>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
     <label for="country"><?php echo $lang_new_researchTypeID;?> <span class="error">*</span></label><br />
     

       <?php
$sqlCat = "SELECT * FROM ".$prefix."categories order by rstug_categoryName asc";
$queryCat = $mysqli->query($sqlCat);
$rCat = $queryCat->fetch_array();
?>
<strong><?php echo $rCat['rstug_categoryName'];?></strong>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
     <label for="lname">Host Institution  <span class="error">*</span></label><br />
   <strong><?php echo $rUserInv2['HostInstitution'];?></strong>
    </div>
  </div>

  
     <div class="row success">

    <div class="col-100">
    <label for="country">Duration of the project- indicate the duration of the project in months <span class="error">*</span></label><br />

       <?php

$sqlFeaturedCall = "SELECT * FROM ".$prefix."duration order by durationID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
$rFeaturedCall = $queryFeaturedCall->fetch_array();
?>
<strong><?php echo $projectDurationID=$rUserInv2['projectDurationID'].' '.$rFeaturedCall['durationdesc'];?></strong>


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
</script>
<?php }?>