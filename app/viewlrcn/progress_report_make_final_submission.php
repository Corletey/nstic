<div id="conceptReferencess" class="tabcontents">
<h3> Make final submission</h3>

<?php $wmConfirm="select * from ".$prefix."progress_report_stages where  owner_id='$usrm_id' and status='new'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();
if($totalStagesConfirm and $rConfirm['SignaturePage']>=1 and $rConfirm['Abstract']>=1 and $rConfirm['SummaryofScientificProgress']>=1 and $rConfirm['KeyPersonnelEffort']>=1 and $rConfirm['Publications']>=1){
$projectID=$rConfirm['projectID'];

$wmproject="select * from ".$prefix."submissions_proposals where  owner_id='$usrm_id' and projectID='$projectID'";
$cmdwbproject = $mysqli->query($wmproject);
$SubmittedProject=$cmdwbproject->num_rows;
$rproject= $cmdwbproject->fetch_array();
$rstug_rsch_project_title=$rproject['projectTitle'];
$referenceNo=$rproject['referenceNo'];

//////////////get user details//////////////////////////////
$wmuser="select * from ".$prefix."musers where  usrm_id='$usrm_id'";
$cmdwbser = $mysqli->query($wmuser);
$rcmdwbser= $cmdwbser->fetch_array();
$dbfirstname=$rcmdwbser['usrm_fname'];
$dbsurname=$rcmdwbser['usrm_sname'];
$email=$rcmdwbser['usrm_email'];

$Insert_QR2m="UPDATE ".$prefix."progress_report_signature_page SET `is_sent`='1',`reportStatus`='Submitted' where owner_id='$usrm_id' and projectID='$projectID' and is_sent='0'";
$mysqli->query($Insert_QR2m);
////////////////////////////////////////////////////////
$Insert_QR2m1="UPDATE ".$prefix."progress_meeting_abstracts SET `is_sent`='1' where owner_id='$usrm_id' and projectID='$projectID' and is_sent='0'";
$mysqli->query($Insert_QR2m1);

$Insert_QR2m2="UPDATE ".$prefix."progress_report_keypersonnel_effort SET `is_sent`='1' where owner_id='$usrm_id' and projectID='$projectID' and is_sent='0'";
$mysqli->query($Insert_QR2m2);
$Insert_QR2m2ee="UPDATE ".$prefix."progress_report_otherpresentations SET `is_sent`='1' where owner_id='$usrm_id' and projectID='$projectID' and is_sent='0'";
$mysqli->query($Insert_QR2m2ee);
/////////////////////////////////////////////////////////////////////////////
$Insert_QR2m3="UPDATE ".$prefix."progress_report_summary_progress SET `is_sent`='1' where owner_id='$usrm_id' and projectID='$projectID' and is_sent='0'";
$mysqli->query($Insert_QR2m3);

$Insert_QR2m55="UPDATE ".$prefix."progress_report_stages SET `status`='old' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m55);

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");
require("mail_template_send_report.php");
///Now send Email
$mail1="$emailUsername";
$mail2=$email;//sender, original creator

///////////Send Email now//////////////////////////////
if($mail1=="$emailUsername"){
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
/////////////////////////////Begin Mail Body
$mail->AddAddress($email, $dbfirstname);
$mail->addCc('mawandammoses@gmail.com','Grants Report Final Submission');//
$mail->addBcc("$emailBcc",'Grants Report Final Submission');//
//$mail->addBcc('i.makhuwa@uncst.go.ug','Final Submission');//


//$mail->addBcc('rmgtonline@uncst.go.ug','Research Team');
//rsch_project_REC


$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Management - $rstug_rsch_project_title";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

//////////////////////////////End Mail Body

}//end $mail1


?>
<div class="success">
<?php echo $lang_congrations_you_have_completed;?>

</div>


<?php 
echo '<img src="./img/loading_wait.gif">';
echo '<div class="spacer"></div>';
//sleep for 3 seconds
sleep(1);

//echo '<meta http-equiv="refresh" content="5; url='.$base_url.'main.php?option=dashboard/" />';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=ProgressReports'>";
}///end all
else{
	

?>
<p><span style="color:#F00; font-weight:bold; font-size:16px;"><?php echo $lang_FinalCheckandSubmission;?></span></p>
<?php }?>
</div>