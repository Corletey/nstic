<?php
if($_POST['doSaveReferences']=='Save' and $_POST['References'] and $_POST['asrmApplctID'] and $id){

	
	$References=$mysqli->real_escape_string(htmlentities($_POST['References']));
    $asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
$sqlA2="update ".$prefix."submissions_concepts set  `creferences`='$References' where owner_id='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlA2);

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created Budget");




				//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `cReferences`='1' where `owner_id`='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}	

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
/*echo("<script>location.href = '".$base_url."'main.php?option=newconceptAttachments/$id';</script>");*/

}//end post
$sqlUsers2="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$usrm_id' and grantcallID='$id' order by conceptID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."concept_stages where  owner_id='$sessionusrm_id' and grantcallID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?><div class="tab">

<?php require_once("dynamic_categories.php");?>

    <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newSubmitConcept&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
   
   
<?php if($total_Team){?><button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button><?php }?>
  
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newconceptReferences')" id="defaultOpen"><?php echo $lang_new_Citations;?></button><?php }?>
  
<?php if($total_Attachments){?><button <?php if($rUConceptStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptAttachments&id=<?php echo $id;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>

  
</div>


<div id="newconceptReferences" class="tabcontent">



  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
 <?php include("concept_submit_now_final_button.php");?>
  <?php 
  $sqlDynamic="SELECT * FROM ".$prefix."concept_dynamic_questions_all_f where grantID='$id' order by id asc";
	$QueryDynamic = $mysqli->query($sqlDynamic);
	$rowsDynamic=$QueryDynamic->fetch_array();
	?>
  <h3>Citations</h3>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">
<div class="container"><!--begin-->

  
  <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  
  <?php if($rowsDynamic['qn_References_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsDynamic['qn_References'];?></label>
<textarea id="subject" name="References" placeholder="References List (Max 150 words).." style="height:200px" class="required"><?php echo $rUserInv2['creferences'];?></textarea>
    </div>
  </div><?php }?>
  


 

  <div class="row success">
    <input type="submit" name="doSaveReferences" value="Save">

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