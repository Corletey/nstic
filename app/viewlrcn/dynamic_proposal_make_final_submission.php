<div id="conceptReferencess" class="tabcontents">
<h3> Make final submission</h3>

<?php 
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$_GET['categoryID'];
$wmConfirm="select * from ".$prefix."dynamic_proposal_stages where  owner_id='$sessionusrm_id' and status='new' and grantID='$id'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();


////Now, get all categories---grantcall_categories
$wmConfirm2="select * from ".$prefix."grantcall_categories where  grantID='$id'";
$cmdwbConfirm2 = $mysqli->query($wmConfirm2);
$totalStagesConfirm2 = $cmdwbConfirm2->num_rows;///Overall Total categories
//Now Generate steps depending on number of categories, if they are 5 cats, generate on 5 steps
/*$countNumMoze=1;
while($rUTotalStages=$cmdwbConfirm2->fetch_array()){
	echo $countNumMoze++.'<br>';
	if($countNumMoze=='1'){$stepsDone='20';}
}*/


if($totalStagesConfirm>=$totalStagesConfirm2){


$sqldynamicAnswers="SELECT * FROM ".$prefix."dynamic_concept_titles where owner_id='$sessionusrm_id' and is_sent='0' order by  	dconceptID desc limit 0,1";
$QuerydynamicAnswers = $mysqli->query($sqldynamicAnswers);
$rdynamicAnswers=$QuerydynamicAnswers->fetch_array();

$rstug_rsch_project_title=$rdynamicAnswers['project_title'];
$referenceNo=$rdynamicAnswers['referenceNo'];

//////////////get user details//////////////////////////////
$wmuser="select * from ".$prefix."musers where  usrm_id='$sessionusrm_id'";
$cmdwbser = $mysqli->query($wmuser);
$rcmdwbser= $cmdwbser->fetch_array();
$dbfirstname=$rcmdwbser['usrm_fname'];
$dbsurname=$rcmdwbser['usrm_sname'];
$email=$rcmdwbser['usrm_email'];


$Insert_QR2m="UPDATE ".$prefix."dynamic_concept_titles SET `projectStatus`='Pending Review',`finalSubmission`='Made Final Submission',`is_sent`='1' where owner_id='$sessionusrm_id' and is_sent='0'";
$mysqli->query($Insert_QR2m);

$Insert_QR2m="UPDATE ".$prefix."grantcall_qn_answers_proposal SET `is_sent`='1' where usrm_id='$sessionusrm_id' and is_sent='0'";
$mysqli->query($Insert_QR2m);
////////////////////////////////////////////////////////
$Insert_QR2m1="UPDATE ".$prefix."dynamic_proposal_stages SET `status`='completed',`is_sent`='1' where owner_id='$sessionusrm_id' and is_sent='0'";
$mysqli->query($Insert_QR2m1);



if($rproject['updated']!='yes'){
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 
require("mail_template_send_proposal_dynamic.php"); 
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
$mail->addCc("$emailBcc",'Dynamic Grants Proposal Final Submission');
$mail->addBcc('mwesigwa.collins@gmail.com','Dynamic Grants Proposal Final Submission');

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

}//end $mail1


?>
<div class="success"><?php echo $lang_congrations_you_have_completed;?>

</div>


<?php
echo '<img src="./img/loading_wait.gif">';
echo '<div class="spacer"></div>';
//sleep for 3 seconds
sleep(5);

//echo '<meta http-equiv="refresh" content="5; url='.$base_url.'main.php?option=dashboard/" />';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=dashboard'>";
 
}///end all
else{
	

?>
<div class="buttonsholder1">
<p><span style="color:#F00; font-weight:bold; font-size:16px;"><?php echo $lang_FinalCheckandSubmission;?></span>

</div>
<?php }?>
</div>