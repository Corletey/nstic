 <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
         
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?php echo $lang_ReviewSubmission;?></li>
                    </ol>
                </section>

<section class="content">
<?php
///////////////////////////////////////////////////////////////
$conceptm_id=$_POST['conceptm_id'];
$user_ip = $_SERVER['REMOTE_ADDR'];
///////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."concepts where conceptm_id='$conceptm_id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();
$nameofpi=$rsContribution['ms_NameOfPI'];
$conceptm_email=$rsContribution['conceptm_email'];
$NameofInstitution=$rsContribution['conceptm_NameofInstitution'];
$proposalTittle=$rsContribution['proposalmTittle'];
?>
<div class="box box-danger">
                                <div class="box-header">
                                    <i class="fa fa-warning"></i>
                                    <h3 class="box-title"><?php echo $rsContribution['ms_NameOfPI'];?>'s <?php echo $lang_ReviewSubmission;?></h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
<?php if($_POST['Submit']=='Approve Submission'){
	
$query="update ".$prefix."concepts  set conceptm_status='approved'";
$mysqli->query($query);
//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`) 
values('$session_fullname has approved $nameofpi proposal titled $proposalTittle.','$nameofpi','$email','$user_ip',now())";
$mysqli->query($queryLog) or print(mysql_error());	
///send email




$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Host = "nemesis.eahd.or.ug"; // specify SMTP server
$mail->SMTPAuth = true; // turn on SMTP authentication

$mail->Username = "ugtldreg"; // SMTP username -- CHANGE --
$mail->Password = "OYZZpsgJXzl"; // SMTP password -- CHANGE --
$mail->From = "info@cbr.ug"; //From Address -- CHANGE --
$mail->FromName = "LSLAP"; //From Name -- CHANGE --
$mail->AddAddress($conceptm_email, $nameofpi); //To Address -- CHANGE --
$mail->AddReplyTo($conceptm_email, "Large Scale land Acquisition Project"); //Reply-To Address -- CHANGE --

$mail->Port = "465"; // SMTP Port
$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Large Scale land Acquisition Project";
$body="<p>Hello $nameofpi!<br>
Your Proposal <u>$proposalTittle</u> has been Approved.<br>
Thank you,
</p>
<p><u><?php echo $sitename;?> Management Team</u><br>
$fulladdress
https://sgcigrants.uncst.go.ug/
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
//echo "Message has been sent";
	}









$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// Additional headers
$headers .= "From: UNCST- $sitename<nstip-admin@uncst.go.ug>" . "\r\n";
$headers .= "Reply-To: $email";
$headers .= 'Cc: mmawanda@i3c.co.ug' . "\r\n";
$headers .= 'Cc: mmawanda@i3c.co.ug' . "\r\n";
$headers .= 'Bcc: mmawanda@i3c.co.ug' . "\r\n";
'X-Mailer: PHP/' . phpversion();
//nstip-admin@uncst.go.ug
$to=$conceptm_email;
$subject="UNCST- $sitename";
$mmessage = 
"<p>Hello $nameofpi!<br>
Your Proposal <u>$proposalTittle</u> has been Approved.<br>
Thank you,
</p>
<p><u>$sitename Management Team</u><br>
$fulladdress
https://sgcigrants.uncst.go.ug/
</p>
";

@mail($to, $subject, $mmessage, $headers);
?>
                               
                                    <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                       <b style="font-size:18px;"><?php echo $rsContribution['ms_NameOfPI'];?>'s Proposal <?php echo $rsContribution['proposalmTittle'];?> has been Approved</b>
                                       
                                    </div>
                           
                            <?php }?>
                            
<?php if($_POST['doSubmit']=='Reject Submission'){
										  
$query="update ".$prefix."concepts  set conceptm_status='rejected'";
$mysqli->query($query);
//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`) 
values('$session_fullname has approved $nameofpi proposal titled $proposalTittle.','$nameofpi','$email','$user_ip',now())";
$mysqli->query($queryLog) or print(mysql_error());	
///send email
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// Additional headers
$headers .= "From: UNCST- $sitename<nstip-admin@uncst.go.ug>" . "\r\n";
$headers .= "Reply-To: $email";
$headers .= 'Cc: mmawanda@i3c.co.ug' . "\r\n";
$headers .= 'Cc:mmawanda@i3c.co.ug' . "\r\n";
$headers .= 'Bcc: mmawanda@i3c.co.ug' . "\r\n";
'X-Mailer: PHP/' . phpversion();
//nstip-admin@uncst.go.ug
$to=$conceptm_email;
$subject="UNCST- $sitename";
$mmessage = 
"<p>Hello $nameofpi!<br>
Your Proposal <u>$proposalTittle</u> has been Rejected.<br>
Thank you,
</p>
<p><u>$sitename Management Team</u><br>
$fulladdress
https://sgcigrants.uncst.go.ug/
</p>
";

@mail($to, $subject, $mmessage, $headers);
?>
                               
                           
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                       <b style="font-size:18px;"><?php echo $rsContribution['ms_NameOfPI'];?>'s Proposal <?php echo $rsContribution['proposalmTittle'];?> has been Rejected</b>
                                        
                                    </div>
                            <?php }?>   
                                </div><!-- /.box-body -->
                            </div>
                     
                            </section>