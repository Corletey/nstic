<div id="conceptReferencess" class="tabcontents">
<h3> <?php echo $lang_MakeFinalSubmission;?></h3>

<?php $wmConfirm="select * from ".$prefix."project_stages where  owner_id='$usrm_id' and status='new'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();
//if($totalStagesConfirm and $rConfirm['ProjectInformation']>=1 and $rConfirm['Background']>=1 and $rConfirm['Methodology']>=1 and $rConfirm['ProjectResults']>=1 and $rConfirm['ResearchTeam']>=1 and $rConfirm['ProjectManagement']>=1 and $rConfirm['Followup']>=1 and $rConfirm['Budget']>=1 and $rConfirm['attachments']>=1 and $rConfirm['citations']>=1){
$projectID=$rConfirm['projectID'];

$wmproject="select * from ".$prefix."submissions_proposals where  owner_id='$usrm_id' and grantcallID='$id' order by projectID desc";
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

$Insert_QR2m="UPDATE ".$prefix."submissions_proposals SET `projectStatus`='Pending Review',`finalSubmission`='Made Final Submission',`is_sent`='1' where owner_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m);
////////////////////////////////////////////////////////
$Insert_QR2m1="UPDATE ".$prefix."project_stages SET `status`='completed' where owner_id='$usrm_id' and grantID='$id'";
$mysqli->query($Insert_QR2m1);
$Insert_QR2m2="UPDATE ".$prefix."proposal_research_team SET `is_sent`='1' where owner_id='$usrm_id' and grantID='$id'";
//$mysqli->query($Insert_QR2m2);
$Insert_QR2m2ee="UPDATE ".$prefix."proposal_research_team_ext SET `is_sent`='1' where owner_id='$usrm_id' and grantID='$id'";
//$mysqli->query($Insert_QR2m2ee); echo "Passed";
/////////////////////////////////////////////////////////////////////////////
$Insert_QR2m3="UPDATE ".$prefix."project_background SET `is_sent`='1' where owner_id='$usrm_id' and grantID='$id'";
$mysqli->query($Insert_QR2m3);

//////////////////////////////////////////////////////////////////
$Insert_QR2m4="UPDATE ".$prefix."project_budget SET `is_sent`='1' where owner_id='$usrm_id' and grantID='$id'";
//$mysqli->query($Insert_QR2m4);

$Insert_QR2m5="UPDATE ".$prefix."project_details_concept SET `is_sent`='1' where owner_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m5);

$Insert_QR2m6="UPDATE ".$prefix."project_follow_up SET `is_sent`='1' where owner_id='$usrm_id' and grantID='$id'";
$mysqli->query($Insert_QR2m6);

$Insert_QR2m7="UPDATE ".$prefix."project_management SET `is_sent`='1' where owner_id='$usrm_id' and grantID='$id'";
$mysqli->query($Insert_QR2m7);


$Insert_QR2m8="UPDATE ".$prefix."project_methodology SET `is_sent`='1' where owner_id='$usrm_id' and grantID='$id'";
$mysqli->query($Insert_QR2m8);

$Insert_QR2m9="UPDATE ".$prefix."project_primary_beneficiaries SET `is_sent`='1' where owner_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m9);

$Insert_QR2m10="UPDATE ".$prefix."project_results SET `is_sent`='1' where owner_id='$usrm_id' and grantID='$id'";
$mysqli->query($Insert_QR2m10);

$Insert_QR2m11="UPDATE ".$prefix."concept_attachments SET `is_sent`='1' where owner_id='$usrm_id' and  	grantcallID='$id'";
$mysqli->query($Insert_QR2m11);


require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");
require("mail_template_send_proposal.php");
///Now send Email
$mail1="$emailUsername";
$mail2=$email;//sender, original creator

///////////Send Email now//////////////////////////////
if($mail1=="$emailUsername"){
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
/////////////////////////////Begin Mail Body
$mail->AddAddress($email, $dbfirstname);

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



echo "<meta http-equiv='REFRESH' content='20;url=$base_url/main.php?option=dashboard'>";
//}///end all
//else{
	

?>
<p><span style="color:#F00; font-weight:bold; font-size:16px;"><?php echo $lang_FinalCheckandSubmission;?></span></p>
<?php //}?>
</div>