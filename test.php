<?php
require("configlrcn/db_mconfig.php");
require("pages/class.phpmailer.php");
require("pages/class.smtp.php");
date_default_timezone_set('Africa/Kampala');
$todaymm=date("D M Y H:M:i");
///////////Send Email now//////////////////////////////$mail = new PHPMailer();
$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Port = $usmtpportNo; // SMTP Port
$mail->Host = $usmtpHost; // specify SMTP server//nemesis.eahd.or.ug mailhost02.cfi.co.ug
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = 'ssl';
$mail->SMTPDebug = 2;


$mail->Username = "$emailUsername"; // SMTP username -- CHANGE --
$mail->Password = "$emailPassword"; // SMTP password -- CHANGE --
$mail->setFrom("$emailUsername", "Admin");
//$mail->From = "grants@uncst.go.ug"; //From Address -- CHANGE -

$mail->FromName = "Research Management - UNCST"; //From Name -- CHANGE --
$mail->AddReplyTo("$emailUsername", $fname); //Reply-To Address -- CHANGE --$usrm_email
$mail->AddAddress("mwesigwa.collins@gmail.com", "Research Team"); //To Address -- CHANGE --$emailUsername ,uncstuganda@gmail.com,mwesigwa.collins@gmail.com
//$mail->addCc('mwesigwa.collins@gmail.com','Research Team');
$mail->addCc("mawandammoses@gmail.com",'Research Team');
//$mail->addBcc("$emailBcc",'Research Team');
//$mail->addCc("namikkaruth@gmail.com",'Research Team');
//$mail->addCc("luwedderhona@gmail.com",'Research Team');


$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Research UNCST";
$body="<br><br>
TESING $todaymm<br>Dear Admin,<br>
Sending from new SMTP. This is a test email from Research. Configured SMTPS<br>
<strong>Do not reply this message.</strong>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
echo $body;
?>

