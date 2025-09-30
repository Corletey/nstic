 <!-- Content Header (Page header) -->
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
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

///////////////////////////////////////////////////////////////
$conceptm_id=$_POST['conceptm_id'];
$user_ip = $_SERVER['REMOTE_ADDR'];
///////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."concepts where conceptm_id='$conceptm_id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();

$conceptm_id=$rsContribution['conceptm_id'];
//////////////////////////////////////////////////////////////////////////////////////
$queryContribution2="select * from ".$prefix."concepts where conceptm_id='$conceptm_id'";
$rs_Contribution2=$mysqli->query($queryContribution2);
$rsContribution2=$rs_Contribution2->fetch_array();


$nameofpi=$rsContribution2['ms_NameOfPI'];
$conceptm_email=$rsContribution['conceptm_email'];
$NameofInstitution=$rsContribution2['conceptm_NameofInstitution'];
$proposalTittle=$rsContribution['proposalmTittle'];
$conceptm_cmtapprove=$rsContribution['proptm_cmtapprove'];
?>
<div class="box box-danger">
                                <div class="box-header">
                                    <i class="fa fa-warning"></i>
                                    <h3 class="box-title"><?php echo $rsContribution2['ms_NameOfPI'];?>'s <?php echo $lang_ReviewSubmission;?></h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                     
                                
<?php if($_POST['doSubmit']=='Assign to Reviewers'){
//$reviewer=$mysqli->real_escape_string($_POST['reviewer']);

foreach($_POST['reviewer'] as $cfn_reviewer) {
$cfnreviewer= $cfn_reviewer;
/////////////////////////////////////////////////////////////////////////////
$hostmain  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');


$sqlReviewer="SELECT * FROM ".$prefix."musers  where usrm_id='$cfnreviewer'";
$QueryReviewer=$mysqli->query($sqlReviewer);
$sqReviewer = $QueryReviewer->fetch_array();
$assignedtoName=$sqReviewer['usrm_fname'];
$usrm_email=$sqReviewer['usrm_email'];

///send email

$queryConceptLogs="select * from ".$prefix."conceptsasslogs where conceptm_id='$conceptm_id' and conceptm_assignedto='$cfnreviewer'";
$rsConceptLogs=$mysqli->query($queryConceptLogs);
$rTotalConceptLogs=$rsConceptLogs->num_rows;
if(!$rTotalConceptLogs){
//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`) 
values('$session_fullname has assigned $nameofpi proposal titled $proposalTittle to $assignedtoName','$nameofpi','$email','$user_ip',now())";
$mysqli->query($queryLog) or print(mysql_error());		
	
//,conceptm_assignedto='$reviewer'
$queryC="update ".$prefix."concepts  set conceptm_status='forwaded',conceptm_assignedby='$usrm_id' where conceptm_id='$conceptm_id'";
$mysqli->query($queryC);
///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
$queryLog2="insert into ".$prefix."conceptsasslogs (`conceptm_id`,`conceptm_assignedto`,`conceptm_by`,`assignm_date`,`logm_status`) 
values('$conceptm_id','$cfnreviewer','$usrm_id',now(),'new')";
$mysqli->query($queryLog2) or print(mysql_error());	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
$mail->addBcc("$emailBcc",'$sitename Proposals');//
$mail->addCc('nstip-admin@uncst.go.ug','$sitename Proposals');//

$mail->FromName = "$sitename"; //From Name -- CHANGE --
$mail->AddAddress($usrm_email, $assignedtoName); //To Address -- CHANGE --
$mail->AddReplyTo("nstip-admin@uncst.go.ug", "$sitename"); //Reply-To Address -- CHANGE --

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$sitename - Proposal for Review";
$body="
<p>Dear $assignedtoName,<br>
A proposal, '$proposalTittle' has been assigned to you for review. Please <a href='http://$hostmain$path/'>Click here</a>  to access the proposal.</p>

<p>Do not hesitate to contact us on the adress below incase of any difficulties accessing the system.<br>

Thank you,</p>

<p><u>$sitename Management Team</u><br>
$fulladdress
https://sgcigrants.uncst.go.ug/
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

}////end foreach
}//////

//////////////////////////////////////////////////////////////////////////////////////
$queryContribution2="select * from ".$prefix."concepts where conceptm_id='$conceptm_id'";
$rs_Contribution2=$mysqli->query($queryContribution2);
$rsContribution2=$rs_Contribution2->fetch_array();
?>
                               
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                       <b style="font-size:18px;"><?php echo $rsContribution2['ms_NameOfPI'];?>'s Proposal, "<?php echo $rsContribution['proposalmTittle'];?>" has been assigned to <?php echo $assignedtoName;?>. A Mail Notification has been duly sent.</b>
                                       
                                    </div>
                           <input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=proposals'"/>
                            <?php }?>

                               
                        
                                </div><!-- /.box-body -->
                            </div>
                     
                            </section>