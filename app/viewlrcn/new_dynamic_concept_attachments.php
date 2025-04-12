<?php
//doSaveFive

$sessionusrm_id=$_SESSION['usrm_id'];
$fid=$mysqli->real_escape_string($_GET['fid']);	
	$command=$mysqli->real_escape_string($_GET['command']);

if($_POST['doFilesUpdateFile'] and $_FILES['attachethicalapproval']['name'] and $id and $command=='update'){
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
$targetw1 = "./files/". basename($asrmApplctID.preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['tmp_name']), $targetw1);

}

$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];

$sqlstudy="SELECT * FROM ".$prefix."concept_attachments where `owner_id`='$asrmApplctID' and filename='$attachethicalapproval2' and grantcallID='$id' order by id desc";// and filename='$attachethicalapproval2'
$Querystudy = $mysqli->query($sqlstudy);
$totalstudy = $Querystudy->num_rows;
if(!$totalstudy){
$sqlA2="insert into ".$prefix."concept_attachments (`conceptID`,`owner_id`,`filename`,`updated`,`attachmentCategory`,`is_sent`,`catNormal`,`grantcallID`,`categorym`) 

values('$conceptm_id','$asrmApplctID','$attachethicalapproval2',now(),'$attachmentCategory','0','dynamic','$id','concepts')";
$mysqli->query($sqlA2);

$message='<div class="success">Dear '.$session_fullname.', details have been submitted, click save to continue</div>';
//logaction("$session_fullname updated protocol, Bibliography Information");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=newconceptAttachments&id=$id'>";
}
if($totalstudy){
$message='<div class="error2">Dear '.$session_fullname.', looks like duplicate file attached</div>';	
}
}else{$message="<span class=error2>Please upload PDF file (s) only. Your File was not uploaded</span>";}


}//end update file



 $sqlAttachment_concept = "select * FROM ".$prefix."concept_attachments where attachmentCategory='concept' and owner_id='$sessionusrm_id' and grantcallID='$id' order by id desc";//informed concent
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

//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where owner_id='$sessionusrm_id' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $totalAttachment_concept>=1 and $totalAttachment_cv>=1 and $totalAttachment_workplan>=1 and $totalAttachment_budget>=1){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `conceptAttachments`='1' where `owner_id`='$sessionusrm_id' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}


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
  
 <?php /*?> <button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newconceptReferences')" id="defaultOpen"><?php echo $lang_new_Citations;?></button><?php */?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?> </button><?php }?>
  
  
<?php if($total_Attachments){?><button <?php if($rUConceptStages['conceptAttachments']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newconceptAttachments')" id="defaultOpen"><?php echo $lang_new_Attachments;?></button><?php }?>
  
  
  
</div>


<div id="newconceptAttachments" class="tabcontent">



  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
 <?php include("concept_submit_now_final_button.php"); echo $message;?><br /><br />
  <h3>Click Button below to add Attachments; The following are required;</h3>
 <?php

?>
<p>1. <?php echo $lang_Concepts;?> <?php if(!$totalAttachment_concept){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_concept){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />

2. <?php echo $lang_CVSofTeamMembers;?> <?php if(!$totalAttachment_cv){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_cv){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />

3. <?php echo $lang_WorkPlan;?> <?php if(!$totalAttachment_workplan){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_workplan){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />

4. <?php echo $lang_Budget;?> <?php if(!$totalAttachment_budget){?><span style="color:#F00; font-weight:bold;"><?php echo $lang_new_NOTUploaded;?></span><?php }?>
<?php if($totalAttachment_budget){?><span style="color:#06F; font-weight:bold;"><?php echo $lang_new_Uploaded;?></span><?php }?><br />



</p>


<h3><?php echo $lang_new_Attachments;?>:</h3>


 <table class="table table-striped table-sm" id="customers">
                  <thead>
                          <tr>
                            <th><?php echo $lang_Attachment;?></th>
                            <th><?php echo $lang_Category;?></th>
                            <th><?php echo $lang_Updatedon;?></th>
                         <th>&nbsp;</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
		
	if($category=='newconceptAttachments' and $fid and $command=="delete"){

	$sqlA2Protocol2="delete from ".$prefix."concept_attachments where owner_id='$sessionusrm_id' and id='$fid'";
	$mysqli->query($sqlA2Protocol2);
	}
						
						
//if no page var is given, set start to 0
$sql = "select * FROM ".$prefix."concept_attachments where owner_id='$sessionusrm_id' and grantcallID='$id' order by id desc";//informed concent
$result = $mysqli->query($sql);
while($rInvestigator=$result->fetch_array()){
	?>
                          <tr>
                            <td><a href="<?php echo $base_url;?>files/<?php echo $rInvestigator['filename'];?>" target="_blank">View File</a><br />
<?php if($fid and $command=="update"){?>
<form action="" method="post" name="regForm" id="regForm" autocomplete="off"  enctype="multipart/form-data">                         
Attach file<br />
<input name="attachethicalapproval" type="file" id="attachethicalapproval" class="required" required/><br />
<input type="submit" name="doFilesUpdateFile" value="Update File" style="float:left;">
</form>
<?php }?>

                            </td>
                            <td>
							<?php if($rInvestigator['attachmentCategory']=='concept'){ echo $lang_Concepts;}?>
                            <?php if($rInvestigator['attachmentCategory']=='cv'){ echo $lang_CVSofTeamMembers;}?>
                            <?php if($rInvestigator['attachmentCategory']=='workplan'){ echo $lang_WorkPlan;}?>
                            <?php if($rInvestigator['attachmentCategory']=='budget'){ echo $lang_Budget;}?>                            
                            
                            
                            
                            </td>
                            <td><?php echo $rInvestigator['updated'];?></td>
<td><a href="./main.php?option=newconceptAttachments&fid=<?php echo $rInvestigator['id'];?>&command=delete&id=<?php echo $id;?>" style="color:#F00; font-weight:bold;" onclick="return confirm('<?php echo $lang_AreyousureDelete;?>');"><?php echo $lang_Delete;?></a>
<div style="clear:both; height:3px;"></div>

<a href="./main.php?option=newconceptAttachments&fid=<?php echo $rInvestigator['id'];?>&command=update&id=<?php echo $id;?>" style="color:#06F; font-weight:bold;" ><?php echo $lang_Update;?></a>


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
     <form action="./main.php?option=newconceptAttachments&id=<?php echo $id;?>" method="post" name="regForm" id="regForm" autocomplete="off"  enctype="multipart/form-data">
    
    <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

 <div class="row success">
 <label class="col-sm-3 form-control-label">Document Type <span class="error">*</span>:</label>

<select id="attachmentCategory" name="attachmentCategory" class="requireDd" required>
<option value="concept"> <?php echo $lang_Concepts;?></option>
<option value="cv"> <?php echo $lang_CVSofTeamMembers;?></option>
<option value="workplan"> <?php echo $lang_WorkPlan;?></option>
<option value="budget"> <?php echo $lang_Budget;?></option>
      </select>    
    
  </div>



 <div class="row success">
 <label class="col-sm-3 form-control-label"><?php echo $lang_FilePDF;?> <span class="error">*</span>:</label>
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