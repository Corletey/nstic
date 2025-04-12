<?php
///Get project Owner
$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];
?>
<?php
if($_POST['doSaveData']=='Submit' and $_POST['actionConcept'] and $_POST['owner_id']){

	
	$actionConcept=$mysqli->real_escape_string($_POST['actionConcept']);
	$rejectcomments=$mysqli->real_escape_string($_POST['rejectcomments']);
	
	$owner_id=$mysqli->real_escape_string($_POST['owner_id']);
	
	$wmproject="select * from ".$prefix."submissions_concepts where  owner_id='$owner_id' and conceptID='$id'";
$cmdwbproject = $mysqli->query($wmproject);
$SubmittedProject=$cmdwbproject->num_rows;
$rproject= $cmdwbproject->fetch_array();
$rstug_rsch_project_title=$rproject['projectTitle'];
$grant_adminID=$rproject['grant_adminID'];
//////////////get user details//////////////////////////////
$wmuser="select * from ".$prefix."musers where  usrm_id='$owner_id'";
$cmdwbser = $mysqli->query($wmuser);
$rcmdwbser= $cmdwbser->fetch_array();
$dbfirstname=$rcmdwbser['usrm_fname'];
$dbsurname=$rcmdwbser['usrm_sname'];
$email=$rcmdwbser['usrm_email'];

//send Notification to Admin
$wmadmin="select * from ".$prefix."musers where  usrm_id='$grant_adminID'";
$cmdwadmin = $mysqli->query($wmadmin);
$rcmdwbadmin= $cmdwadmin->fetch_array();

$admin_dbsurname=$rcmdwbadmin['usrm_fname'].' '.$rcmdwbadmin['usrm_sname'];
$admin_email=$rcmdwbadmin['usrm_email'];	
	
	
if($actionConcept=='ApproveConcept'){$projectStatus='Completeness Check-Approved';}
if($actionConcept=='RejectConcept'){$projectStatus='Completeness Check-Rejected';}
//'Pending Final Submission','Pending Review','',''
$sqlA2="update ".$prefix."submissions_concepts set `projectStatus`='$projectStatus',`rejectComents`='$rejectcomments' where owner_id='$owner_id' and conceptID='$id'";
$mysqli->query($sqlA2);

$message='<p class="success">Dear '.$session_fullname.', concept has been '.$projectStatus.'.</p>';
logaction("$session_fullname $projectStatus Concept id:$id");

if($projectStatus=='Approved'){
	
	require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 
require("mail_template_approve_concept.php"); 
///Now send Email
$mail1="$emailUsername";
$mail2=$email;//sender, original creator

$mail = new PHPMailer(true); //important
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Port = $usmtpportNo; // SMTP Port
$mail->CharSet =  "utf-8";
$mail->Host = $usmtpHost; // specify SMTP server//nemesis.eahd.or.ug mailhost02.cfi.co.ug
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = $emailSSL;
$mail->SMTPDebug = 0;


$mail->Username = "$emailUsername"; // SMTP username -- CHANGE --
$mail->Password = "$emailPassword"; // SMTP password -- CHANGE --
$mail->setFrom("$emailUsername", "Admin");
$mail->FromName = "Grants Management - UNCST"; //From Name -- CHANGE --
$mail->AddReplyTo($email, $dbfirstname); //To Address -- CHANGE --
$mail->AddAddress($email, $dbfirstname);
/////////////////////////////Begin Mail Body
//$mail->addCc('$emailUsername','Activation Link from UNCST');//
$mail->addBcc("$emailBcc",'Grants Management');//
//$mail->addBcc('i.makhuwa@uncst.go.ug','Final Submission');//
$mail->addCc($admin_email,$admin_dbsurname);
//$mail->addBcc('sgcigrants.uncst.go.ug','$sitename');

//$mail->addBcc('rmgtonline@uncst.go.ug','Research Team');
//rsch_project_REC

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Management - Completeness Check (Approved)";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
	
	
	
}



if($projectStatus=='Rejected'){


require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 
require("mail_template_reject_concept.php"); 
///Now send Email
$mail1="$emailUsername";
$mail2=$email;//sender, original creator

$mail = new PHPMailer(true); //important
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Port = $usmtpportNo; // SMTP Port
$mail->CharSet =  "utf-8";
$mail->Host = $usmtpHost; // specify SMTP server//nemesis.eahd.or.ug mailhost02.cfi.co.ug
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = $emailSSL;
$mail->SMTPDebug = 0;


$mail->Username = "$emailUsername"; // SMTP username -- CHANGE --
$mail->Password = "$emailPassword"; // SMTP password -- CHANGE --
$mail->setFrom("$emailUsername", "Admin");
$mail->FromName = "Grants Management - UNCST"; //From Name -- CHANGE --
$mail->AddReplyTo($email, $dbfirstname); //To Address -- CHANGE --
$mail->AddAddress($email, $dbfirstname);
/////////////////////////////Begin Mail Body
//$mail->addCc('$emailUsername','Activation Link from UNCST');//
$mail->addBcc("$emailBcc",'Grants Management');//
//$mail->addBcc('i.makhuwa@uncst.go.ug','Final Submission');//
$mail->addCc($admin_email,$admin_dbsurname);
//$mail->addBcc('sgcigrants.uncst.go.ug','$sitename');

//$mail->addBcc('rmgtonline@uncst.go.ug','Research Team');
//rsch_project_REC

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Management - $lang_CompletenessCheck (Rejected)";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
	
	
	
}


echo '<img src="./img/loading_wait.gif">';
echo '<div class="spacer"></div>';
//sleep for 3 seconds
sleep(5);

//echo '<meta http-equiv="refresh" content="5; url='.$base_url.'main.php?option=dashboard/" />';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=AdminNewConcepts&id=$id'>";

}//end post




$asrmApplctID2=$usrm_id;
$sqlUsers2="SELECT * FROM ".$prefix."submissions_concepts where `conceptID`='$id'";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

?>




<div class="tab">

   <button class="tablinks"onClick="window.location.href='./main.php?option=reviewProjectInformation&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button>
   <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button>
  <button class="tablinks"  onClick="window.location.href='./main.php?option=ReviewconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
  <button class="tablinks"  onClick="window.location.href='./main.php?option=ReviewconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button>
  <button class="tablinks"  onclick="openCity(event, 'ReviewconceptAction')" id="defaultOpen">Approve/Reject </button>
  
</div>


<div id="ReviewconceptAction" class="tabcontent">
<?php include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");?>


  <h3><?php echo $lang_AcceptRejectConcept;?></h3>
  <?php if(isset($message)){?><p><strong style="color:#06F!important; font-size:16px;"><?php echo $message;?></strong></p><?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="owner_id" value="<?php echo $rUserInv2['owner_id'];?>">

<?php if($rUserInv2['projectStatus']=='Pending Review' || $rUserInv2['projectStatus']=='Scheduled for Review' || $rUserInv2['projectStatus']=='Completeness Check-Approved'){?>
<div class="container"><!--begin-->

  <div class="row success">

    <div class="col-100">
     <label for="fname"><input name="actionConcept" type="radio" value="ApproveConcept" class="required"  onChange="getApproveReject(this.value)"/><strong> <?php echo $lang_AcceptConcept;?></strong> <span class="error">*</span></label><br />
     <label for="fname"><input name="actionConcept" type="radio" value="RejectConcept" class="required" onChange="getApproveReject(this.value)"/><strong> <?php echo $lang_RejectConceptwithcomments;?></strong> <span class="error">*</span></label>
    </div>
  </div><?php }?>
  
<div class="row success">

    <div class="col-100">
    
 <div id="approverejectdiv"></div>
 
    </div>
  </div>
  
 <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="Submit">
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
</script><?php }?>