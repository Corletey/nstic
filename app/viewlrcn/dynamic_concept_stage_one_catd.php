<?php
//doSaveFive

$sessionusrm_id=$_SESSION['usrm_id'];

if($_POST['doFilesUpload'] and $_FILES['attachethicalapproval']['name'] and $sessionusrm_id and $_POST['attachmentCategoryID']){
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 $asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$attachmentCategoryID=$mysqli->real_escape_string($_POST['attachmentCategoryID']);


$extensionw = getExtension(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));

if($extensionw=='pdf'){
	
if($_FILES['attachethicalapproval']['name']){
$attachethicalapproval = preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']);
$attachethicalapproval2 = $sessionusrm_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));
$targetw1 = "./files/uploads/". basename($sessionusrm_id.preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name']));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['tmp_name']), $targetw1);

}

$sqlstudy1="SELECT * FROM ".$prefix."concept_attachments where `owner_id`='$sessionusrm_id' and conceptID='$id' and filename='$attachethicalapproval2' and is_sent='0' order by id desc";// and filename='$attachethicalapproval2'
$Querystudy1 = $mysqli->query($sqlstudy1);
$totalstudy1 = $Querystudy1->num_rows;


$sqlstudy="SELECT * FROM ".$prefix."concept_attachments where `owner_id`='$sessionusrm_id' and conceptID='$id' and attachmentCategory='$attachmentCategoryID'  and is_sent='0' order by id desc";// and filename='$attachethicalapproval2'
$Querystudy = $mysqli->query($sqlstudy);
$totalstudy = $Querystudy->num_rows;
if(!$totalstudy and !$totalstudy1){
$sqlA2="insert into ".$prefix."concept_attachments (`conceptID`,`owner_id`,`filename`,`updated`,`attachmentCategory`,`is_sent`,`catNormal`) 

values('$id','$sessionusrm_id','$attachethicalapproval2',now(),'$attachmentCategoryID','0','dynamic')";
$mysqli->query($sqlA2);

$wm="select * from ".$prefix."dynamic_concept_stages where  categoryID='$maincategoryID' and owner_id='$owner_id' and status='new' and grantID='$id' order by id desc";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$record_id2;
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."dynamic_concept_stages (`categoryID`,`owner_id`,`status`,`grantID`,`is_sent`,`dconceptID`)  values('$maincategoryID','$sessionusrm_id','new','$id','0','$mdconceptID')";
$mysqli->query($sqlASubmissionStages);
//Reload After saving
//Reload After saving
echo '<meta http-equiv="REFRESH" content="0;url='.$base_url.'main.php?option=SubmitConceptDynamic&id='.$id.'&categoryID='.$maincategoryID.'">';
}

$message='<div class="success">Dear '.$session_fullname.', details have been submitted, click save to continue</div>';
//logaction("$session_fullname updated protocol, Bibliography Information");
}
if($totalstudy || $totalstudy1){
echo $message='<div class="error2">Dear '.$session_fullname.', looks like duplicate file attached</div>';	
}
}else{$message="<span class=error2>Please upload PDF file (s) only. Your File was not uploaded</span>";}


}//end post

?>

<h3>Project Attachments</h3>

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
	if($category=='SubmitConceptDynamic' and $fid and $command=="delete"){

	$sqlA2Protocol2="delete from ".$prefix."concept_attachments where owner_id='$sessionusrm_id' and is_sent='0' and id='$fid'";
	$mysqli->query($sqlA2Protocol2);
	}
						
						
//if no page var is given, set start to 0
$sql = "select * FROM ".$prefix."concept_attachments where owner_id='$sessionusrm_id' and is_sent='0' and catNormal='dynamic' and conceptID='$id' order by id desc";//informed concent
$result = $mysqli->query($sql);
while($rInvestigator=$result->fetch_array()){
	$attachmentCategory=$rInvestigator['attachmentCategory'];
	
	
$sql4 = "select * FROM ".$prefix."grantcall_questions_attachments where `id`='$attachmentCategory' order by id desc";//informed concent
$result4 = $mysqli->query($sql4);
$rInvestigator4=$result4->fetch_array();
	?>
                          <tr>
                            <td><a href="./files/uploads/<?php echo $rInvestigator['filename'];?>" target="_blank">View File</a></td>
                            <td><?php echo $rInvestigator4['dynamicaddattachments'];?></td>
                            <td><?php echo $rInvestigator['updated'];?></td>
<td><a href="./main.php?option=SubmitConceptDynamic&id=<?php echo $id;?>&categoryID=<?php echo $maincategoryID;?>&fid=<?php echo $rInvestigator['id'];?>&command=delete" style="color:#F00; font-weight:bold;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></td>


                          </tr>
   <?php }///////////end function ?>                 
                        </tbody>
                      </table>

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
     <form action="" method="post" name="regForm" id="regForm" autocomplete="off"  enctype="multipart/form-data">
    
    <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

 <div class="row success">
 <label class="col-sm-3 form-control-label">Document Type <span class="error">*</span>:</label>

<select id="attachmentCategorym" name="attachmentCategoryID" class="requireDd" required>
 <?php
$sql = "select * FROM ".$prefix."grantcall_questions_attachments where `categoryID`='$categoryID' and `grantID`='$id' order by id desc";//informed concent
$result = $mysqli->query($sql);
while($rInvestigator=$result->fetch_array()){
	?>
<option value="<?php echo $rInvestigator['id'];?>"> <?php echo $rInvestigator['dynamicaddattachments'];?></option>
<?php }?>
      </select>    
    
  </div>



 <div class="row success">
 <label class="col-sm-3 form-control-label">File  (PDF) <span class="error">*</span>:</label>
<input name="attachethicalapproval" type="file" id="attachethicalapproval" class="required" required/>
    
    
  </div>

    
   <div>
    <input type="submit" name="doFilesUpload" value="Save">
    </div>
    
    
    </form>
    </div>
    </div>
    </div>
    