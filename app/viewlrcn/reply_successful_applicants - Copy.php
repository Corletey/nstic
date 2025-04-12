 <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard/"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Assign Submission</li>
                    </ol>
                </section>

<section class="content">
<?php


if($_POST['doSendNotification']=='Send Notification' and $_POST['message']){
	
	$hostmain  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

	$conceptm_idmm=$_POST['conceptm_id'];
$proposalmTittle=$_POST['proposalTittle'];
$ms_NameOfPI=$_POST['ms_NameOfPI'];
$conceptm_email=$_POST['conceptm_email'];
$piusrm_id=$_POST['piusrm_id'];
$message=$_POST['message'];
	
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");	
	
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

$mail->addBcc("$emailBcc",'UNCST - $sitename');//
$mail->addCc('g.sempiri@uncst.go.ug','UNCST - $sitename');//
$mail->addCc('r.jaggwe@uncst.go.ug','UNCST - $sitename');//

$mail->FromName = "$sitename"; //From Name -- CHANGE --
$mail->AddAddress($conceptm_email, $ms_NameOfPI); //To Address -- CHANGE --
$mail->AddReplyTo("nstip-admin@uncst.go.ug", "UNCST - $sitename"); //Reply-To Address -- CHANGE --
/////
$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$sitename - Submission of Full Proposals";
$body="$message";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;}
//sentNotify
//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`) 
values('$session_fullname has sent notification to $ms_NameOfPI','$ms_NameOfPI','$email','$user_ip',now())";
$mysqli->query($queryLog) or print(mysql_error());		
	
//,conceptm_assignedto='$reviewer'
$queryC="update ".$prefix."concepts  set sentNotify='Yes',mailtext='$message' where conceptm_id='$conceptm_idmm'";
$mysqli->query($queryC);
////
$queryCss="update ".$prefix."musers  set sentNotify='Yes' where usrm_id='$piusrm_id'";
$mysqli->query($queryCss);
$message="Notification has been sent to $ms_NameOfPI";
/*echo("<script>location.href = './main.php?option=completeval/';</script>");
echo '<meta http-equiv="refresh" content="5; url=http://localhost/scripts/submissions/nstipgrants/main.php?option=completeval/" />';
*/
echo '<meta http-equiv="refresh" content="2; url=https://nstip.uncst.go.ug/main.php?option=completeval/" />';
}
/*Dear $ms_NameOfPI, <br /> <br />
Reference is made to your application to the NSTIP Call for R&D Proposal for FY 2017/18 titled <b>$proposalmTittle</b>.<br /><br />

$name_granting_council thanks you for responding to the 2017/18 call for research proposals. Your concept proposal was evaluated by an independent technical committee. You are hereby requested to submit a full proposal to UNCST at <b>http://www.uncst.go.ug/nstip</b> by <b>Friday 18th August 2017</b> for further consideration. <br /><br />

Sincerely,<br />
$sitename Management Team<br />
$fulladdress
*////////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."concepts where conceptm_id='$id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();
if($rsContribution['categorym']=="concepts"){
$categorym="concepts";
}
if($rsContribution['categorym']=="proposals"){
$categorym="proposals";
}
?>
<form action="" method="post" name="regForm" id="regForm"  enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td>


<div class="box box-danger">
                                <div class="box-header">
                                    <i class="fa fa-warning"></i>
                                    <h3 class="box-title"><?php echo $rsContribution['ms_NameOfPI'];?>'s Submission</h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                               
                                    <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                       <b style="font-size:18px;"><?php echo $rsContribution['proposalmTittle'];?></b>
                                       
                                    </div>
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                        Name: <?php echo $rsContribution['ms_NameOfPI'];?> <br />
                                        Email: <?php echo $rsContribution['conceptm_email'];?> <br />
                                        Phone: <?php echo $rsContribution['conceptm_phone'];?>
                                        
                                    </div>
                                    <div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-warning"></i>
           <?php if($rsContribution['cpt_sector']){?>Sector: <?php echo $rsContribution['cpt_sector'];?><br /><?php }?>
           <?php if($rsContribution['cpt_othersector']){?>Other Sector: <?php echo $rsContribution['cpt_othersector'];?><br /><?php }?>
                                      RefNo: <?php echo $rsContribution['referenceno'];?> 
                                    </div>
                                    
                                  
                                    
                                </div><!-- /.box-body -->
          </div>
                            <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/> 
                            <input name="categorym" type="hidden"  value="<?php echo $categorym;?>"/> 
                            
     

</td>
<td style="padding-right:20px;">&nbsp;</td>
<td style="padding-top:30px;" valign="top">
                       <table width="100%">
                               <tr>
    <td align="left" valign="top">
    
    <p style="font-size:18px; color:#09F; padding-bottom:15px;"><?php echo $message;?></p>
    
<textarea name="message" style="width:600px; height:350px;" id="commentoverall">

Dear <?php echo $rsContribution['ms_NameOfPI'];?>, <br /> <br />
Reference is made to your application to the NSTIP Call for R&D Proposal for FY 2017/18 titled <b><?php echo $rsContribution['proposalmTittle'];?></b> .<br /><br />

<?php echo $name_granting_council;?> thanks you for responding to the 2017/18 call for research proposals. Your concept proposal was evaluated by an independent technical committee. You are hereby requested to submit a full proposal to UNCST at <b>http://www.uncst.go.ug/nstip</b> by <b>Friday 18th August 2017</b> for further consideration. <br /><br />
For submission guidelines, follow the link <b>https://nstip.uncst.go.ug/Detailed_Call_for_NSTIP_R&D_Proposals_FY_2017-18_july.pdf</b><br /><br />
Sincerely,<br />
<?php echo $sitename;?> Management Team<br />
<?php echo $fulladdress;?>
</textarea>

  <br />
<input name="piusrm_id" type="hidden" value="<?php echo $rsContribution['usrm_id'];?>"/>
<input name="proposalTittle" type="hidden" value="<?php echo $rsContribution['proposalmTittle'];?>"/>
<input name="ms_NameOfPI" type="hidden" value="<?php echo $rsContribution['ms_NameOfPI'];?>"/>
<input name="conceptm_email" type="hidden" value="<?php echo $rsContribution['conceptm_email'];?>"/>

  
</td>
  </tr>
  
                         <tr>
                                 <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         <tr>
 <td align="left" valign="top"><?php if($rsContribution['sentNotify']=="Yes"){}else{?>
<input name="doSendNotification" type="submit" class="btn btn-info btn-flat" value="Send Notification"/><?php }?> <input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=completeval/'"/>
</td>
  </tr>
</table>
</td>
</tr>
</table>

 </form>                           
                            </section>