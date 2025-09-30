<?php
//doSaveFive

$sessionusrm_id=$_SESSION['usrm_id'];
$fid=$mysqli->real_escape_string($_GET['fid']);	
	$command=$mysqli->real_escape_string($_GET['command']);
	$conceptID=$_GET['conceptID'];

if($_POST['doFilesUpdateFile'] and $_FILES['attachethicalapproval']['name'] and $id and $command=='update' and $id){
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 } 
 $asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$attachmentCategory=$mysqli->real_escape_string($_POST['attachmentCategory']);

  if ($attachmentCategory === 'other') {
    $attachmentCategory = $mysqli->real_escape_string($_POST['otherCategory']);
  }


$extensionw = getExtension(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));

if($extensionw=='pdf'){
	
if($_FILES['attachethicalapproval']['name']){
$attachethicalapproval = preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']);
$attachethicalapproval2 = $asrmApplctID.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));
$targetw1 = "./files/". basename($asrmApplctID.preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['tmp_name']), $targetw1);



$sqlA2="update ".$prefix."concept_attachments set `filename`='$attachethicalapproval2' where id='$fid'";
$mysqli->query($sqlA2);

$message='<div class="success">Dear '.$session_fullname.', details have been submitted</div>';
logaction("$session_fullname updated attachethicalapproval2");
}
}

}//end post

///////////Re-update File
if($_POST['doFilesUpload'] and $_FILES['attachethicalapproval']['name'] and $_POST['asrmApplctID'] and $id and $_POST['attachmentCategory']){
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 } 
 $asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
$attachmentCategory=$mysqli->real_escape_string($_POST['attachmentCategory']);

if ($attachmentCategory === 'other') {
    $attachmentCategory = $mysqli->real_escape_string($_POST['otherCategory']);
  }



$extensionw = getExtension(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));

if($extensionw=='pdf'){
	
if($_FILES['attachethicalapproval']['name']){
$attachethicalapproval = preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']);
$attachethicalapproval2 = $asrmApplctID.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));
$targetw1 = "./files/". basename($asrmApplctID.preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['tmp_name']), $targetw1);

}

$sqlUsersrr="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];

$sqlstudy="SELECT * FROM ".$prefix."concept_attachments where `owner_id`='$asrmApplctID' and conceptID='$conceptm_id' and filename='$attachethicalapproval2' and grantcallID='$id' order by id desc";// and filename='$attachethicalapproval2'
$Querystudy = $mysqli->query($sqlstudy);
$totalstudy = $Querystudy->num_rows;

if(!$totalstudy and $attachmentCategory){
$sqlA2="insert into ".$prefix."concept_attachments (`conceptID`,`owner_id`,`filename`,`updated`,`attachmentCategory`,`is_sent`,`catNormal`,`grantcallID`,`categorym`) 

values('$conceptm_id','$asrmApplctID','$attachethicalapproval2',now(),'$attachmentCategory','0','dynamic','$id','proposals')";
$mysqli->query($sqlA2);

$message='<div class="success">Dear '.$session_fullname.', details have been submitted, click save to continue</div>';
//logaction("$session_fullname updated protocol, Bibliography Information");
/*
echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newProposalAttachments&id=$id&categoryID=$categoryID&conceptID=$conceptID';</script>");
*/
} 
if($totalstudy){
$message='<div class="error2">Dear '.$session_fullname.', looks like duplicate file attached</div>';	
}
}else{$message="<span class=error2>Please upload PDF file (s) only. Your File was not uploaded</span>";}


}//end update file



$sqlAttachment_concept = "select * FROM ".$prefix."concept_attachments where attachmentCategory='proposal' and owner_id='$sessionusrm_id' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_concept = $mysqli->query($sqlAttachment_concept);
$totalAttachment_concept = $resultAttachment_concept->num_rows;
$rUConceptconcept=$resultAttachment_concept->fetch_array();


 $sqlAttachment_cv = "select * FROM ".$prefix."concept_attachments where attachmentCategory='cv' and owner_id='$sessionusrm_id' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_cv = $mysqli->query($sqlAttachment_cv);
$totalAttachment_cv = $resultAttachment_cv->num_rows;
$rUConceptcv=$resultAttachment_cv->fetch_array();

 $sqlAttachment_workplan = "select * FROM ".$prefix."concept_attachments where attachmentCategory='workplan' and owner_id='$sessionusrm_id' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_workplan = $mysqli->query($sqlAttachment_workplan);
$totalAttachment_workplan = $resultAttachment_workplan->num_rows;
$rUConceptworkplan=$resultAttachment_workplan->fetch_array();

 $sqlAttachment_budget = "select * FROM ".$prefix."concept_attachments where attachmentCategory='budget' and owner_id='$sessionusrm_id' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_budget = $mysqli->query($sqlAttachment_budget);
$totalAttachment_budget = $resultAttachment_budget->num_rows;
$rUConceptbudget=$resultAttachment_budget->fetch_array();

$sqlAttachment_identification = "select * FROM ".$prefix."concept_attachments where attachmentCategory='Identification' and owner_id='$sessionusrm_id' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_identification = $mysqli->query($sqlAttachment_identification);
$totalAttachment_identification = $resultAttachment_identification->num_rows;
$rUConceptIdentification=$resultAttachment_identification->fetch_array();

$sqlAttachment_permit = "select * FROM ".$prefix."concept_attachments where attachmentCategory='permit' and owner_id='$sessionusrm_id' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_permit = $mysqli->query($sqlAttachment_permit);
$totalAttachment_permit = $resultAttachment_permit->num_rows;
$rUConceptPermit=$resultAttachment_permit->fetch_array();

$sqlAttachment_support_letter = "select * FROM ".$prefix."concept_attachments where attachmentCategory='letter' and owner_id='$sessionusrm_id' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_support_letter = $mysqli->query($sqlAttachment_support_letter);
$totalAttachment_support_letter= $resultAttachment_support_letter->num_rows;
$rUConceptSupportLetter=$resultAttachment_support_letter->fetch_array();

//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where owner_id='$sessionusrm_id' and grantID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $totalAttachment_concept>=1 and $totalAttachment_cv>=1 and $totalAttachment_workplan>=1 and $totalAttachment_budget>=1 and $totalAttachment_identification>=1  ){
$sqlASubmissionStages="update ".$prefix."project_stages  set `attachments`='1' where `owner_id`='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlASubmissionStages);
}


$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();/**/
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
   
<?php if($total_Attachments){?><button <?php if($rUConceptStages['attachments']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newProposalAttachments')" id="defaultOpen"><?php echo $lang_new_ResearchAttachments;?></button><?php }?>

   
<?php if($total_Citations){?> <button <?php if($rUConceptStages['citations']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newProposalReferences&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Citations;?></button><?php }?>

</div>


<div id="newProposalAttachments" class="tabcontent">



  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
 <?php include("proposal_submit_now_final_button.php"); echo $message;?><br /><br />
  <h3><?php echo $lang_ClickButtonAttachments;?></h3>
 <?php

?>
<p>1. <?php echo $lang_Proposals;?> <?php if(!$totalAttachment_concept){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_concept){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />

2. <?php echo $lang_CVSofTeamMembers;?> <?php if(!$totalAttachment_cv){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_cv){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />

3. <?php echo $lang_WorkPlan;?> <?php if(!$totalAttachment_workplan){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_workplan){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />

4. <?php echo $lang_Budget;?> <?php if(!$totalAttachment_budget){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_budget){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />

5. <?php echo $lang_Identification;?> <?php if(!$totalAttachment_identification){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_identification){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />


6. <?php echo $lang_Permit;?> <?php if(!$totalAttachment_permit){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_permit){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />

7. <?php echo $lang_SupportLetter;?> <?php if(!$totalAttachment_support_letter){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_support_letter){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />


</p>


<h3><?php echo $lang_new_Attachments;?>:</h3>


 <table class="table table-striped table-sm" id="customers">
                  <thead>
                          <tr>
                            <th><?php echo $lang_new_Attachments;?></th>
                            <th><?php echo $lang_Category;?></th>
                            <th><?php echo $lang_Updatedon;?></th>
                         <th>&nbsp;</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
		
	if($category=='newProposalAttachments' and $fid and $_GET['command']=="delete"){

	$sqlA2Protocol2="delete from ".$prefix."concept_attachments where owner_id='$sessionusrm_id' and id='$fid'";
	$mysqli->query($sqlA2Protocol2);
	}
						
						
//if no page var is given, set start to 0
$sql = "select * FROM ".$prefix."concept_attachments where owner_id='$sessionusrm_id' and grantcallID='$id' order by id desc";//informed concent
$result = $mysqli->query($sql);
while($rInvestigator=$result->fetch_array()){
	?>
                          <tr>
                            <td><a href="<?php echo $base_url;?>files/<?php echo $rInvestigator['filename'];?>" target="_blank"><?php echo $lang_ViewAttachment;?></a><br />
<?php if($fid and $command=="update"){?>
<form action="" method="post" name="regForm" id="regForm" autocomplete="off"  enctype="multipart/form-data">                         
<?php echo $lang_Attachments;?><br />
<input name="attachethicalapproval" type="file" id="attachethicalapproval" class="required" required/><br />
<input type="submit" name="doFilesUpdateFile" value="<?php echo $lang_UpdateFile;?>" style="float:left;">
</form>
<?php }?>

                            </td>
                            <td>
                            <?php //if($rInvestigator['attachmentCategory']=='proposal'){ echo "$lang_Proposals";}?>
                            <?php //if($rInvestigator['attachmentCategory']=='concept'){ echo "$lang_Concepts";}
							
							echo $rInvestigator['attachmentCategory'];?>
                            
                            </td>
                            <td><?php echo $rInvestigator['updated'];?></td>
<td><a href="./main.php?option=newProposalAttachments&fid=<?php echo $rInvestigator['id'];?>&command=delete&id=<?php echo $id;?>" style="color:#F00; font-weight:bold;" onclick="return confirm('Are you sure you want to delete this item?');"><?php echo $lang_Delete;?></a>
<div style="clear:both; height:3px;"></div>

<a href="./main.php?option=newProposalAttachments&fid=<?php echo $rInvestigator['id'];?>&command=update&id=<?php echo $id;?>" style="color:#06F; font-weight:bold;" ><?php echo $lang_UpdateFile;?></a>


</td>
                          </tr>
   <?php }///////////end function ?>                 
                        </tbody>
                      </table>

</div>



<button id="myBtn"><?php echo $lang_Attachments;?></button>



<!-- The Modal -->
<div id="myModal" class="modal" style="width:700px;">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
    </div>
    <div class="modal-body" style="height:450px; overflow:scroll;">
    <!--<h4>Name Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal</h4>-->
     <form action="<?php echo $base_url;?>main.php?option=newProposalAttachments&id=<?php echo $id;?>&categoryID=<?php echo $categoryID?>&conceptID=<?php echo $conceptID;?>" method="post" name="regForm" id="regForm" autocomplete="off"  enctype="multipart/form-data">
    
    <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

 <div class="row success">
 <label class="col-sm-3 form-control-label"><?php echo $lang_DocumentType;?> <span class="error">*</span>:</label>

<select id="attachmentCategory" name="attachmentCategory" class="requireDd" required>
<option value="proposal"> <?php echo $lang_Proposals;?></option>
<option value="cv"> <?php echo $lang_CVSofTeamMembers;?></option>
<option value="workplan"> <?php echo $lang_WorkPlan;?></option>
<option value="budget"> <?php echo $lang_Budget;?></option>
<option value="identification"> <?php echo $lang_Identification;?></option>
<option value="permit"> <?php echo $lang_Permit;?></option>
<option value="letter"> <?php echo $lang_SupportLetter;?></option>
<option value="other">Others (specify)</option>
      </select>    
  </div>

 <div class="row success" id="otherCategoryDiv" style="display:none;">
    <label class="col-sm-3 form-control-label">Specify Category:</label>
    <input type="text" id="otherCategory" name="otherCategory" class="form-control">
  </div>

 <div class="row success">
 <label class="col-sm-3 form-control-label"><?php echo $lang_FilePDF;?><span class="error">*</span>:</label>
<input name="attachethicalapproval" type="file" id="attachethicalapproval" class="required" required/>
    
    
  </div>


   
 <div class="row success">
    <div class="rightm">
    <input type="submit" name="doFilesUpload" value="<?php echo $lang_new_Save;?>">
    </div>
    
    
  </div>
  
  
   </form>
   
</div>
                                     
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

function toggleOtherCategory() {
  var category = document.getElementById("attachmentCategory");
  var otherDiv = document.getElementById("otherCategoryDiv");
  if (category.value === "other") {
    otherDiv.style.display = "block";
  } else {
    otherDiv.style.display = "none";
  }
}

// Add this line to call toggleOtherCategory when the page loads
document.addEventListener('DOMContentLoaded', toggleOtherCategory);

// Add this line to call toggleOtherCategory when the select value changes
document.getElementById("attachmentCategory").addEventListener('change', toggleOtherCategory);


// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>