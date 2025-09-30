<?php
session_start();
//require_once('contrlrcn/c_mlsrcontrol.php'); 
?>
<?php
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTPserver01.i3c.co.ug

$mail->Host = "mailer.gov.bf"; // specify SMTP server//nemesis.eahd.or.ug mailhost02.cfi.co.ug
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = "tls";
$mail->SMTPDebug = 1;
$mail->Username = "herve.pale@fonrid.bf"; // SMTP username -- CHANGE --
$mail->Password = "B@rga1n01"; // SMTP password -- CHANGE --
$mail->setFrom("herve.pale@fonrid.bf", "Grants Management");
$mail->FromName = "BUKINAFASO-Grants"; //From Name -- CHANGE --


$mail->AddAddress("emmanuelkamanda1255@gmail.com", "Mwesigwa Collins"); //To Address -- CHANGE --
$mail->AddReplyTo("herve.pale@fonrid.bf", "MOSTI-GHANA"); //Reply-To Address -- CHANGE --
$mail->addBcc("herve.pale@fonrid.bf",'MOSTI-GHANA');//
$mail->addBcc('mawandammoses@gmail.com','Moses Mawanda');

$mail->Port = "465"; // SMTP Port
$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "NSTIP Grants - Password";
echo $body="
<b>SMTP TEST</b><br>
Host: $usmtpHost<br>
Username: $emailUsername<br>
Password: $emailPassword<br>
BCC: $emailBcc

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
//echo "Message has been sent";


?>