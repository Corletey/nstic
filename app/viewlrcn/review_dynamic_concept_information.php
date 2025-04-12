<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$_GET['categoryID'];
$ownerm_id=$_GET['ownerm_id'];
$dconceptID=$_GET['dconceptID'];

$wGrantCategories1="select * from ".$prefix."grantcall_categories where  grantID='$id' and categorym='concept' and categoryID='$maincategoryID' order by categoryID asc";
$cmGrantCategories1 = $mysqli->query($wGrantCategories1);
$rUGrantCategories1=$cmGrantCategories1->fetch_array();

if(isset($message)){echo $message;}

//Insert into Submission Stages
$wm="select * from ".$prefix."review_dynamic_concepts where  categoryID='$maincategoryID' and owner_id='$ownerm_id' and status='new' and grantID='$id' and reviewer_id='$sessionusrm_id' order by id desc";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;

if(!$totalStages and $id and $maincategoryID){
$sqlASubmissionStages="insert into ".$prefix."review_dynamic_concepts (`categoryID`,`owner_id`,`status`,`grantID`,`is_sent`,`dconceptID`,`reviewer_id`)  values('$maincategoryID','$ownerm_id','new','$id','0','$dconceptID','$sessionusrm_id')";
$mysqli->query($sqlASubmissionStages);
}
/*
$sqlTitles3="SELECT * FROM ".$prefix."dynamic_concept_titles where  `owner_id`='$ownerm_id' and `is_sent`='1' order by dconceptID desc";
$QueryTitles3 = $mysqli->query($sqlTitles3);
$rUserInv3=$QueryTitles3->fetch_array();*/
?>
<div class="tab">

<?php
require_once("dynamic_concept_categories_review.php");?> 

</div>

<div id="SubmitConceptDynamic" class="tabcontentss">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
 <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("dynamic_concept_assign_button_admin.php"); include("dynamic_concept_assign_button_admin2.php");
 }?>
 <?php if($session_usertype=='reviewer'){include("dynamic_concept_score_reviewers.php");
 }?>  
   
  
  <div class="success" style="margin-top:40px;"> 
   <?php
  //Load Category 1!$categoryID || 
  if(!$id || !$dconceptID || !$ownerm_id){
	
	  echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=dashboard'>";
  }
  

   if($categoryID==7){//Project Team
  require_once("review_dynamic_concept_project_team.php");
  }
  

  if($categoryID==8){//Budget
  require_once("review_dynamic_concept_project_budget.php");
  }
  if($categoryID==9){///Attachments
  require_once("review_dynamic_concept_project_attachments.php");
  }else if($categoryID!=7 and $categoryID!=8 and $categoryID!=9){
	  require_once("review_dynamic_concept_project_intro.php");
  }
  ?>
  <div style="clear:both;"></div>
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