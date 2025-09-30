<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$_GET['categoryID'];
$ownerm_id=$_GET['ownerm_id'];
$dproposalID=$_GET['dproposalID'];

$wGrantCategories1="select * from ".$prefix."grantcall_categories where  grantID='$id' and categorym='proposal' and categoryID='$maincategoryID' order by categoryID asc";
$cmGrantCategories1 = $mysqli->query($wGrantCategories1);
$rUGrantCategories1=$cmGrantCategories1->fetch_array();

if(isset($message)){echo $message;}

//Insert into Submission Stages
$wm="select * from ".$prefix."review_dynamic_proposals where  categoryID='$maincategoryID' and owner_id='$ownerm_id' and status='new' and grantID='$id' and reviewer_id='$sessionusrm_id' order by id desc";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;

if(!$totalStages and $id and $maincategoryID){
$sqlASubmissionStages="insert into ".$prefix."review_dynamic_proposals (`categoryID`,`owner_id`,`status`,`grantID`,`is_sent`,`dproposalID`,`reviewer_id`)  values('$maincategoryID','$ownerm_id','new','$id','0','$dproposalID','$sessionusrm_id')";
$mysqli->query($sqlASubmissionStages);
}

$sqlTitles3="SELECT * FROM ".$prefix."dynamic_proposal_titles where  `owner_id`='$ownerm_id' and `is_sent`='1' order by dproposalID desc";
$QueryTitles3 = $mysqli->query($sqlTitles3);
$rUserInv3=$QueryTitles3->fetch_array();
?>
<div class="tab">

<?php
require_once("dynamic_proposal_categories_review.php");?> 

</div>

<div id="SubmitConceptDynamic" class="tabcontentss">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
 <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("dynamic_proposal_assign_button_admin.php"); include("dynamic_proposal_assign_button_admin2.php");
 }?>
 <?php if($session_usertype=='reviewer'){include("dynamic_proposal_score_reviewer.php");
 }?>  
   
  
   
  <h3><b><?php echo $rUGrantCategories1['categoryName'];?></b></h3>
 
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="usrm_id" value="<?php echo $_SESSION['usrm_id'];?>" >

 <div class="container"><!--begin-->
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>



<?php if($rUserInv3['categoryID']==$maincategoryID || !$QueryTitles3->num_rows){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Project Title <span class="error">*</span></label><br />
       
 <?php echo $rUserInv3['project_title'];?>
      
    </div>
  </div><?php }?>







<?php
$sqldynamicQns="SELECT * FROM ".$prefix."grantcall_questions where `categoryID`='$categoryID' order by questionID asc limit 0,100";
$QuerydynamicQns = $mysqli->query($sqldynamicQns);
while($rdynamicQns=$QuerydynamicQns->fetch_array()){
	$questionID=$rdynamicQns['questionID'];
	
$sqldynamicAnswers="SELECT * FROM ".$prefix."grantcall_qn_answers_proposal where `questionID`='$questionID' and usrm_id='$ownerm_id' and is_sent='1' order by answerID asc";
$QuerydynamicAnswers = $mysqli->query($sqldynamicAnswers);
$rdynamicAnswers=$QuerydynamicAnswers->fetch_array();	
	
?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rdynamicQns['questionName'];?> <span class="error">*</span></label>
    

 <br /><?php echo $rdynamicAnswers['answer'];?>
      
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