<?php
$conceptID=$_GET['conceptID'];

if($_POST['doSaveReferences'] and $id){

	
	$References=$mysqli->real_escape_string(htmlentities($_POST['References']));
    $asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and `grantcallID`='$id' and grantcallID='$id' order by projectID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
$sqlA2="update ".$prefix."submissions_proposals set  `creferences`='$References' where owner_id='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlA2);

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added References");




				//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and grantID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `citations`='1' where `owner_id`='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlASubmissionStages);
}	

/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newProposalReferences/$id';</script>");*/

}//end post

$sqlUsers2="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and grantcallID='$id' order by conceptID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<?php
require("dynamic_categories.php");

?>
<div class="tab">

<?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newSubmitProposal&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectInformation;?> </button><?php }?>
  

<?php if($total_Team){?><button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newproposalResearchTeam&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button><?php }?>
  
<?php if($total_Background){?><button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalBackground&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Background;?> </button><?php }?>
  
<?php if($total_Methodology){?><button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalMethodology&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button><?php }?>
    
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalBudget&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
    
    
    
<?php if($total_Results){?><button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalResults&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectResults;?></button><?php }?>
     
<?php if($total_Management){?><button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalManagement&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectManagement;?></button><?php }?>
    
<?php if($total_Followup){?><button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalFollowup&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectFollowup;?></button><?php }?>
   
<?php if($total_Attachments){?><button <?php if($rUConceptStages['attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newProposalAttachments&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ResearchAttachments;?></button><?php }?>

   
<?php if($total_Citations){?> <button <?php if($rUConceptStages['citations']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newProposalReferences')" id="defaultOpen"><?php echo $lang_new_Citations;?></button><?php }?>



  
</div>


<div id="newProposalReferences" class="tabcontent">



  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
 <?php include("proposal_submit_now_final_button.php");?>
  <?php 
  $sqlDynamic="SELECT * FROM ".$prefix."concept_dynamic_questions_all_f where categorym='proposal' and grantID='$id' order by id asc";
	$QueryDynamic = $mysqli->query($sqlDynamic);
	$rowsDynamic=$QueryDynamic->fetch_array();
	?>
  <h3><?php echo $lang_new_Citations;?></h3>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">
<div class="container"><!--begin-->

  
  <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  
 <?php if($rowsDynamic['qn_References_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsDynamic['qn_References'];?></label>
<textarea id="subject" name="References" placeholder="References List (Max 150 words).." style="height:200px" class="required"><?php echo $rUserInv2['creferences'];?></textarea>
    </div>
  </div>
  <?php }?>


 

  <div class="row success">
    <input type="submit" name="doSaveReferences" value="<?php echo $lang_new_Save;?>">

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