<?php

$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$mysqli->real_escape_string($_GET['categoryID']);
$projectID=$mysqli->real_escape_string($_GET['id']);
$grantID=$mysqli->real_escape_string($_GET['grantID']);

if($_POST['doSaveData']=='Submit' and $_POST['actionConcept'] and $_POST['owner_id']){

	
	$actionConcept=$mysqli->real_escape_string($_POST['actionConcept']);
	$rejectcomments=$mysqli->real_escape_string($_POST['rejectcomments']);
	
	$owner_id=$mysqli->real_escape_string($_POST['owner_id']);
	
$wmproject="select * from ".$prefix."submissions_proposals where  projectID='$projectID' and  grantcallID='$grantID'";
$cmdwbproject = $mysqli->query($wmproject);
$SubmittedProject=$cmdwbproject->num_rows;
$rproject= $cmdwbproject->fetch_array();
$rstug_rsch_project_title=$rproject['projectTitle'];

//////////////get user details//////////////////////////////
$wmuser="select * from ".$prefix."musers where  usrm_id='$owner_id'";
$cmdwbser = $mysqli->query($wmuser);
$rcmdwbser= $cmdwbser->fetch_array();
$dbfirstname=$rcmdwbser['usrm_fname'];
$dbsurname=$rcmdwbser['usrm_sname'];
$email=$rcmdwbser['usrm_email'];	
	
	
if($actionConcept=='ApproveConcept'){$projectStatus='Approved';}
if($actionConcept=='AcceptWithComments'){$projectStatus='AcceptWithComments';}
if($actionConcept=='TotalReject'){$projectStatus='TotalReject';}
//'Pending Final Submission','Pending Review','',''
$sqlA2="update ".$prefix."submissions_proposals set `projectStatus`='Completeness Check-Approved',`rejectComents`='$rejectcomments' where projectID='$projectID'  and  grantcallID='$grantID'";
$mysqli->query($sqlA2);

$message='<p class="success">Dear '.$session_fullname.', proposal has been '.$projectStatus.'.</p>';
//logaction("$session_fullname $projectStatus proposal id:$projectID");

if($projectStatus=='Approved'){
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 
require("mail_template_approve_proposal.php"); 
///Now send Email


$mail = new PHPMailer(true); // important
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Port = $usmtpportNo; // SMTP Port
$mail->CharSet = "utf-8";
$mail->Host = $usmtpHost; // specify SMTP server
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = $emailSSL;
$mail->Username = "$emailUsername";
// SMTP password (your Office 365 email password)
$mail->Password = "$emailPassword";
$mail->SMTPDebug = 0;



$mail->Username = "$emailUsername"; // SMTP username -- CHANGE --
$mail->Password = "$emailPassword"; // SMTP password -- CHANGE --
$mail->setFrom("$emailUsername", "Grants Management");

$mail->AddReplyTo($email, $dbfirstname); //To Address -- CHANGE --
$mail->AddAddress($email, $dbfirstname);


$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Management - Administrative Review";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
echo '<img src="./img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='1;url=$base_url/main.php?option=dashboard'>";	
	
}



if($projectStatus=='AcceptWithComments'){//Accept with comments. This should allow user to re-submit
$sqlA2="update ".$prefix."submissions_proposals set `projectStatus`='Completeness Check-Rejected',`rejectComents`='$rejectcomments' where projectID='$projectID'  and  grantcallID='$grantID'";
$mysqli->query($sqlA2);

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 
require("mail_template_reject1_proposal.php"); 
///Now send Email
$mail1="$emailUsername";
$mail2=$email;//sender, original creator

$mail = new PHPMailer(true); // important
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Port = $usmtpportNo; // SMTP Port
$mail->CharSet = "utf-8";
$mail->Host = $usmtpHost; // specify SMTP server
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = $emailSSL;
$mail->Username = "$emailUsername";
// SMTP password (your Office 365 email password)
$mail->Password = "$emailPassword";
$mail->SMTPDebug = 0;



$mail->Username = "$emailUsername"; // SMTP username -- CHANGE --
$mail->Password = "$emailPassword"; // SMTP password -- CHANGE --
$mail->setFrom("$emailUsername", "Grants Management");
$mail->AddReplyTo("$email", $dbfirstname); //To Address -- CHANGE --
$mail->AddAddress("$email", $dbfirstname);//$email

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Management - Administrative Review";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
echo '<img src="./img/loading_wait.gif">';
echo '<div class="spacer"></div>';
	
echo "<meta http-equiv='REFRESH' content='3;url=$base_url/main.php?option=dashboard'>";
	
}
if($projectStatus=='TotalReject'){
  $sqlA22="update ".$prefix."submissions_proposals set `projectStatus`='Rejected',`rejectComents`='$rejectcomments' where projectID='$projectID'  and  grantcallID='$grantID'";
  $mysqli->query($sqlA22);

  
  require("viewlrcn/class.phpmailer.php");
  require("viewlrcn/class.smtp.php"); 
  require("mail_template_reject_proposal.php"); 
  ///Now send Email
  $mail1="$emailUsername";
  $mail2=$email;//sender, original creator
  
  $mail = new PHPMailer(true); // important
  $mail->IsSMTP(); // set mailer to use SMTP
  $mail->Port = $usmtpportNo; // SMTP Port
  $mail->CharSet = "utf-8";
  $mail->Host = $usmtpHost; // specify SMTP server
  $mail->SMTPAuth = true; // turn on SMTP authentication
  $mail->SMTPSecure = $emailSSL;
  $mail->Username = "$emailUsername";
  // SMTP password (your Office 365 email password)
  $mail->Password = "$emailPassword";
  $mail->SMTPDebug = 0;
  
  
  
  $mail->Username = "$emailUsername"; // SMTP username -- CHANGE --
  $mail->Password = "$emailPassword"; // SMTP password -- CHANGE --
  $mail->setFrom("$emailUsername", "Grants Management");
  $mail->AddReplyTo($email, $dbfirstname); //To Address -- CHANGE --
  $mail->AddAddress("$emailBcc", $dbfirstname);

  
  //$mail->addBcc('rmgtonline@uncst.go.ug','Research Team');
  //rsch_project_REC
  
  $mail->WordWrap = 50; // set word wrap to 50 characters
  $mail->IsHTML(false); // set email format to HTML
  $mail->Subject = "Grants Management - Administrative Review";
  $body="$allSentMessage
  ";
  $mail->MsgHTML($body);
  
  if(!$mail->Send()){
    echo "Mailer Error: " . $mail->ErrorInfo;
  }
    
  echo '<img src="./img/loading_wait.gif">';
echo '<div class="spacer"></div>';

echo "<meta http-equiv='REFRESH' content='3;url=$base_url/main.php?option=dashboard'>";  
    
  }




}//end post




$sqlTitles3="SELECT * FROM ".$prefix."submissions_proposals where `projectID`='$id' and grantcallID='$grantID' order by projectID desc";
$QueryTitles3 = $mysqli->query($sqlTitles3);
$rUserInv3=$QueryTitles3->fetch_array();
$ownerm_id=$rUserInv3['owner_id'];

$wGrantCategories="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categorym='proposal' order by categoryID asc";
$cmGrantCategories = $mysqli->query($wGrantCategories);
$rUGrantCategories1=$cmGrantCategories->fetch_array();
?>
<div class="tab">

<?php
//require_once("dynamic_proposal_categories_review.php");?> 

</div>

<div id="SubmitConceptDynamic" class="tabcontentss">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
 <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("proposal_assign_button_admin.php"); include("proposal_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("proposal_score_reviewer.php");}?> 
   
  
  <h3><?php echo $lang_approve_reject;?></h3>
  <?php if(isset($message)){?><p><strong style="color:#06F!important; font-size:16px;"><?php echo $message;?></strong></p><?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="owner_id" value="<?php echo $ownerm_id;?>">


<div class="container"><!--begin-->

  <div class="row success">

    <div class="col-100">
     <label for="fname"><input name="actionConcept" type="radio" value="ApproveConcept" class="required"  onChange="getApproveReject(this.value)"/><strong> Accept</strong> <span class="error">*</span></label><br />
     <label for="fname"><input name="actionConcept" type="radio" value="AcceptWithComments" class="required" onChange="getApproveReject(this.value)"/><strong> Accept with Conditions (User must re-submit)</strong> <span class="error">*</span></label><br>
     <label for="fname"><input name="actionConcept" type="radio" value="TotalReject" class="required" onChange="getApproveReject(this.value)"/><strong> Reject</strong> <span class="error">*</span></label>
    
    
    </div>
  </div>
  
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
</script>