 <?php

 ///////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."concepts where conceptm_id='$id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();
$musrm_id=$rsContribution['usrm_id'];

///owner name
$queryContribution2="select * from ".$prefix."musers where usrm_id='$musrm_id'";
$rs_Contribution2=$mysqli->query($queryContribution2);
$rsContribution2=$rs_Contribution2->fetch_array();
$email=$rsContribution2['usrm_email'];
?><!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
               
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?php echo $lang_ReviewSubmission;?></li>
                    </ol>
                </section>

<section class="content">
<?php

$status=$_POST['status'];
 $path = $_FILES['attachment']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
$nameofpi=$rsContribution['ms_NameOfPI'];
$proposalTittle=$rsContribution['proposalmTittle'];
$proposalm_upload=$mysqli->real_escape_string($rsContribution['proposalm_upload']);

if($_POST['doSubmit'] and $status=='Approve for Review')
{
 require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");


$query="update ".$prefix."concepts set `conceptm_status`='approved',`conceptm_cmtreject`='',`proposalm_uploadReup`='$proposalm_upload' where conceptm_id='$id'";
$mysqli->query($query);
//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`) 
values('$session_fullname has submit Re-Uploaded Submission titled $proposalTittle with name $document.','$nameofpi','$email','$user_ip',now())";
$mysqli->query($queryLog) or print(mysql_error());	
///send email
$message="<p class='success'><p>Submission attached for review successfully</p>";

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
$mail->FromName = "$sitename Proposal"; //From Name -- CHANGE --

$mail->addBcc("$emailBcc",'$sitename Proposal');
$mail->AddAddress($email, $nameofpi); //To Address -- CHANGE --
$mail->AddReplyTo("$emailUsername", "$sitename Proposal"); //Reply-To Address -- CHANGE --

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$sitename Proposal Fowarded";
$body="
<p>Dear $nameofpi,<br>
A proposal, <strong>'$proposalTittle'</strong> has been fowarded for review.</p>
Thank you,

<p><u>$sitename Team</u><br>
$fulladdress
https://sgcigrants.uncst.go.ug/
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}



?>
                               
                                    <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <?php if($message){?>
                                        <b style="font-size:18px;"><?php echo $message;?></b><br /><br />
                                        <input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=pdashboard'"/>
                                        <?php }?>
                                        <?php if($errormessage){?>
                                        <b style="font-size:18px; color:#F00;"><?php echo $errormessage;?></b><br /><br />
                                        <input name="button" type="button" class="btn btn-info btn-flat" value="Click to Go Back" onClick="window.location.href='./main.php?option=review&id=<?php echo $id;?>'"/>
                                        <?php }?>
                                       
                                    </div>
                           
       
                            
<?php 
}//end checking permissions
//////rejected///////////////////////////////////////////////////////////////////
if($_POST['doSubmit'] and $status=='Reject Submission'){
$cmtcomments = nl2br(preg_replace('/<br \/>/iU', '', $_POST['cmtcomments']));
	
	
									  
$query="update ".$prefix."concepts  set conceptm_status='rejected',`conceptm_cmtapprove`='',`conceptm_cmtreject`='$cmtcomments' where conceptm_id='$id'";
$mysqli->query($query);
//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`,`conceptm_cmtapprove`,`conceptm_cmtreject`) 
values('$session_fullname has approved $nameofpi proposal titled $proposalTittle.','$nameofpi','$email','$user_ip',now(),'','$cmtcomments')";
$mysqli->query($queryLog);	
///send email

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
$mail->FromName = "$sitename Proposal Rejected"; //From Name -- CHANGE --

$mail->addBcc("$emailBcc",'$sitename Proposal Rejected');
$mail->AddAddress($email, $nameofpi); //To Address -- CHANGE --
$mail->AddReplyTo("$emailUsername", "$sitename Proposal Rejected"); //Reply-To Address -- CHANGE --


$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Re: $proposalTittle";
$body="
Dear $nameofpi,<br>
We refer to your application to the above-mentioned program.<br><br>

$name_granting_council thanks you for responding to the 2017/18 call for research proposals. Your research proposal was evaluated by an independent technical committee and found to be plausible. However, due to the stiff competition your concept proposal was not selected for development into a full proposal. Below are the comments;<br><br>
$cmtcomments<br><br>
Sincerely,<br><br>

<p>$sitename Management Team<br>
$fulladdress
https://sgcigrants.uncst.go.ug/
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
                               
                           
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                       <b style="font-size:18px;"><?php echo $rsContribution['ms_NameOfPI'];?>'s Proposal <?php echo $rsContribution['proposalmTittle'];?> has been Rejected.</b>
                                        
                                    </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=pdashboard'"/>
                            <?php }?>   
                                </div><!-- /.box-body -->
                            </div>
                     
                            </section>