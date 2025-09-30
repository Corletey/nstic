<div id="conceptReferencess" class="tabcontents">
<h3> <?php echo $lang_MakeFinalSubmission;?></h3>

<?php 
$wmConfirm="select * from ".$prefix."concept_stages where  owner_id='$usrm_id' and grantcallID='$id'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();


//grantcallID
$sqlDynamic="SELECT * FROM ".$prefix."grantcalls where grantID='$id' order by grantID asc";
	$QueryDynamic = $mysqli->query($sqlDynamic);
	$rowsDynamic=$QueryDynamic->fetch_array();
	$grant_adminID=$rowsDynamic['grant_adminID'];

if($totalStagesConfirm and $rConfirm['ProjectInformation']>=1 and $rConfirm['PrincipalInvestigator']>=1 ){
$conceptID=$rConfirm['conceptID'];

$wmproject="select * from ".$prefix."submissions_concepts where  owner_id='$usrm_id' and grantcallID='$id'";
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
//send Notification to Admin
$wmadmin="select * from ".$prefix."musers where  usrm_id='$grant_adminID'";
$cmdwadmin = $mysqli->query($wmadmin);
$rcmdwbadmin= $cmdwadmin->fetch_array();

$admin_dbsurname=$rcmdwbadmin['usrm_fname'].' '.$rcmdwbadmin['usrm_sname'];
$admin_email=$rcmdwbadmin['usrm_email'];

$Insert_QR2m="UPDATE ".$prefix."submissions_concepts SET `projectStatus`='Pending Review',`finalSubmission`='Made Final Submission',`is_sent`='1' where owner_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m);
////////////////////////////////////////////////////////
$Insert_QR2m1="UPDATE ".$prefix."concept_stages SET `status`='completed' where owner_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m1);

$Insert_QR2m2="UPDATE ".$prefix."principal_investigators SET `is_sent`='1' where owner_id='$usrm_id' and  	grantcallID='$id'";
$mysqli->query($Insert_QR2m2);

/////////////////////////////////////////////////////////////////////////////
$Insert_QR2m3="UPDATE ".$prefix."introduction_concept SET `is_sent`='1' where owner_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m3);

//////////////////////////////////////////////////////////////////
$Insert_QR2m4="UPDATE ".$prefix."concept_budget SET `is_sent`='1' where owner_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m4);

$Insert_QR2m5="UPDATE ".$prefix."project_details_concept SET `is_sent`='1' where owner_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m5);

$Insert_QR2m6="UPDATE ".$prefix."concept_references SET `is_sent`='1' where owner_id='$usrm_id' and grantID='$id'";
//$mysqli->query($Insert_QR2m6);

$Insert_QR2m7="UPDATE ".$prefix."project_primary_beneficiaries SET `is_sent`='1' where owner_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m7);


$Insert_QR2m8="UPDATE ".$prefix."education_history SET `is_sent`='1' where rstug_user_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m8);

$Insert_QR2m9="UPDATE ".$prefix."research_experience SET `is_sent`='1' where owner_id='$usrm_id' and grantcallID='$id'";
$mysqli->query($Insert_QR2m9);


require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 
require("mail_template_send_concept.php"); 
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
$mail->AddAddress($email, $dbfirstname);
/////////////////////////////Begin Mail Body
//$mail->addCc('$emailUsername','Activation Link from UNCST');//
$mail->addBcc("$emailBcc",'$lang_MakeFinalSubmission');//
//$mail->addBcc('i.makhuwa@uncst.go.ug','Final Submission');//
if($admin_email){$mail->addCc($admin_email,$admin_dbsurname);}
//$mail->addBcc('sgcigrants.uncst.go.ug','$sitename');

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
}///end 
//////////////////////////////End Mail Body

?>
<div class="success"><?php echo $lang_congrations_you_have_completed;?>
</div>


<?php
echo '<img src="./img/loading_wait.gif">';
echo '<div class="spacer"></div>';
//sleep for 3 seconds
sleep(5);

//echo '<meta http-equiv="refresh" content="5; url='.$base_url.'main.php?option=dashboard/" />';
echo "<meta http-equiv='REFRESH' content='2;url=$base_url/main.php?option=dashboard'>";	
 
}///end all
else{
	

?>
<div class="buttonsholder1">
<p><span style="color:#F00; font-weight:bold; font-size:16px;"><?php echo $lang_FinalCheckandSubmission;?></span>

</div>
<?php }?>
</div>