<?php
//doSaveFive

$sessionusrm_id=$_SESSION['usrm_id'];

if($_POST['doFilesUpload'] and $_FILES['attachethicalapproval']['name'] and $_POST['asrmApplctID'] and $id){
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 } 
 $asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$attachmentCategory=$mysqli->real_escape_string($_POST['attachmentCategory']);


$extensionw = getExtension(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));

if($extensionw=='pdf'){
	
if($_FILES['attachethicalapproval']['name']){
$attachethicalapproval = preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']);
$attachethicalapproval2 = $asrmApplctID.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));
$targetw1 = "files/uploads/". basename($asrmApplctID.preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['tmp_name']), $targetw1);

}

$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and `is_sent`='0' and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];

$sqlstudy="SELECT * FROM ".$prefix."concept_attachments where `owner_id`='$asrmApplctID' and conceptID='$conceptm_id' and filename='$attachethicalapproval2' and grantcallID='$id' order by id desc";// and filename='$attachethicalapproval2'
$Querystudy = $mysqli->query($sqlstudy);
$totalstudy = $Querystudy->num_rows;
if(!$totalstudy){
$sqlA2="insert into ".$prefix."concept_attachments (`conceptID`,`owner_id`,`filename`,`updated`,`attachmentCategory`,`is_sent`,`catNormal`,`grantcallID`) 

values('$conceptm_id','$asrmApplctID','$attachethicalapproval2',now(),'$attachmentCategory','0','dynamic','$id')";
$mysqli->query($sqlA2);

$message='<div class="success">Dear '.$session_fullname.', details have been submitted, click save to continue</div>';
//logaction("$session_fullname updated protocol, Bibliography Information");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=conceptAttachments&id=$id'>";
}
if($totalstudy){
$message='<div class="error2">Dear '.$session_fullname.', looks like duplicate file attached</div>';	
}
}else{$message="<span class=error2>Please upload PDF file (s) only. Your File was not uploaded</span>";}


}//end post




 $sqlAttachment_concept = "select * FROM ".$prefix."concept_attachments where attachmentCategory='concept' and owner_id='$sessionusrm_id' and is_sent='0' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_concept = $mysqli->query($sqlAttachment_concept);
$totalAttachment_concept = $resultAttachment_concept->num_rows;
$rUConceptconcept=$resultAttachment_concept->fetch_array();


 $sqlAttachment_cv = "select * FROM ".$prefix."concept_attachments where attachmentCategory='cv' and owner_id='$sessionusrm_id' and is_sent='0' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_cv = $mysqli->query($sqlAttachment_cv);
$totalAttachment_cv = $resultAttachment_cv->num_rows;
$rUConceptcv=$resultAttachment_cv->fetch_array();

 $sqlAttachment_workplan = "select * FROM ".$prefix."concept_attachments where attachmentCategory='workplan' and owner_id='$sessionusrm_id' and is_sent='0' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_workplan = $mysqli->query($sqlAttachment_workplan);
$totalAttachment_workplan = $resultAttachment_workplan->num_rows;
$rUConceptworkplan=$resultAttachment_workplan->fetch_array();

 $sqlAttachment_budget = "select * FROM ".$prefix."concept_attachments where attachmentCategory='budget' and owner_id='$sessionusrm_id' and is_sent='0' and grantcallID='$id' order by id desc";//informed concent
$resultAttachment_budget = $mysqli->query($sqlAttachment_budget);
$totalAttachment_budget = $resultAttachment_budget->num_rows;
$rUConceptbudget=$resultAttachment_budget->fetch_array();

//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where owner_id='$sessionusrm_id' and status='new' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $totalAttachment_concept>=1 and $totalAttachment_cv>=1 and $totalAttachment_workplan>=1 and $totalAttachment_budget>=1){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `conceptAttachments`='1' where `owner_id`='$sessionusrm_id' and status='new' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}


$wConceptStages="select * from ".$prefix."concept_stages where  owner_id='$sessionusrm_id' and status='new' and grantcallID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?><div class="tab">

   <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitConcept&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
   
   
  <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button>
  
  <button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button>
  
   <button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button>
   
  <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=conceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
  
  <button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'conceptReferences')" id="defaultOpen"><?php echo $lang_new_Citations;?></button>
  
  <button <?php if($rUConceptStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptAttachments&id=<?php echo $id;?>'">Attachments </button>
  
</div>


<div id="conceptReferences" class="tabcontent">



  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
 <?php include("concept_submit_now_final_button.php");?><br /><br />
  <h3>Click Button below to add Attachments; The following are required;</h3>
 <?php

?>
<p>1. Concept <?php if(!$totalAttachment_concept){?><span style="color:#F00; font-weight:bold;">NOT Uploaded</span><?php }?>
<?php if($totalAttachment_concept){?><span style="color:#06F; font-weight:bold;">Uploaded</span><?php }?><br />

2. CV's of Team Members <?php if(!$totalAttachment_cv){?><span style="color:#F00; font-weight:bold;">NOT Uploaded</span><?php }?>
<?php if($totalAttachment_cv){?><span style="color:#06F; font-weight:bold;">Uploaded</span><?php }?><br />

3. Work-Plan <?php if(!$totalAttachment_workplan){?><span style="color:#F00; font-weight:bold;">NOT Uploaded</span><?php }?>
<?php if($totalAttachment_workplan){?><span style="color:#06F; font-weight:bold;">Uploaded</span><?php }?><br />

4. Budget <?php if(!$totalAttachment_budget){?><span style="color:#F00; font-weight:bold;">NOT Uploaded</span><?php }?>
<?php if($totalAttachment_budget){?><span style="color:#06F; font-weight:bold;">Uploaded</span><?php }?><br />



</p>


<h3>Attachments:</h3>


 <table class="table table-striped table-sm" id="customers">
                  <thead>
                          <tr>
                            <th>Attachment</th>
                            <th>Category</th>
                            <th><?php echo $lang_Updatedon;?></th>
                         <th>&nbsp;</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
	$fid=$mysqli->real_escape_string($_GET['fid']);	
	$command=$mysqli->real_escape_string($_GET['command']);	
	if($category=='conceptAttachments' and $fid and $command=="delete"){

	$sqlA2Protocol2="delete from ".$prefix."concept_attachments where owner_id='$sessionusrm_id' and is_sent='0' and id='$fid'";
	$mysqli->query($sqlA2Protocol2);
	}
						
						
//if no page var is given, set start to 0
$sql = "select * FROM ".$prefix."concept_attachments where owner_id='$sessionusrm_id' and is_sent='0' and grantcallID='$id' order by id desc";//informed concent
$result = $mysqli->query($sql);
while($rInvestigator=$result->fetch_array()){
	?>
                          <tr>
                            <td><a href="<?php echo $base_url;?>files/uploads/<?php echo $rInvestigator['filename'];?>" target="_blank">View File</a></td>
                            <td><?php echo $rInvestigator['attachmentCategory'];?></td>
                            <td><?php echo $rInvestigator['updated'];?></td>
<td><a href="./main.php?option=conceptAttachments&fid=<?php echo $rInvestigator['id'];?>&command=delete&id=<?php echo $id;?>" style="color:#F00; font-weight:bold;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>
                          </tr>
   <?php }///////////end function ?>                 
                        </tbody>
                      </table>

</div>



<button id="myBtn">Add Attachments</button>



<!-- The Modal -->
<div id="myModal" class="modal" style="width:700px;">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h3><strong>Add New Attachment</strong></h3>
    </div>
    <div class="modal-body" style="height:450px; overflow:scroll;">
    <!--<h4>Name Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal</h4>-->
     <form action="./main.php?option=conceptAttachments&id=<?php echo $id;?>" method="post" name="regForm" id="regForm" autocomplete="off"  enctype="multipart/form-data">
    
    <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

 <div class="row success">
 <label class="col-sm-3 form-control-label">Document Type <span class="error">*</span>:</label>

<select id="attachmentCategory" name="attachmentCategory" class="requireDd" required>
<option value="concept"> Concept</option>
<option value="cv"> CV</option>
<option value="workplan"> Workplan</option>
<option value="budget"> Budget</option>
      </select>    
    
  </div>



 <div class="row success">
 <label class="col-sm-3 form-control-label">File  (PDF) <span class="error">*</span>:</label>
<input name="attachethicalapproval" type="file" id="attachethicalapproval" class="required" required/>
    
    
  </div>

   
 <div class="row success">
    <div class="rightm">
    <input type="submit" name="doFilesUpload" value="Save">
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

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>