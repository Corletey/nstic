<?php if($_SESSION['usrm_usrtype']=='reviewer'){
	//////get all//////////////////////////
$queryContributionLogs="select * from ".$prefix."conceptsasslogs where conceptm_id='$id' and conceptm_assignedto='$usrm_id'";
$rs_ContributionLogs=$mysqli->query($queryContributionLogs);
$rsContributionLogs=$rs_ContributionLogs->fetch_array();
$conceptm_assignedto=$rsContributionLogs['conceptm_assignedto'];
///////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."concepts where conceptm_id='$id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();
$ms_NameOfPI=$rsContribution['ms_NameOfPI'];
$conceptm_NameofInstitution=$rsContribution['conceptm_NameofInstitution'];
$proposalmTittle=$rsContribution['proposalmTittle'];
$conceptm_email=$rsContribution['conceptm_email'];
$conceptm_phone=$rsContribution['conceptm_phone'];



/////////////////////Get Reviewer Details
$queryReviwer="select * from ".$prefix."musers where usrm_id='$conceptm_assignedto'";
$rs_Reviwer=$mysqli->query($queryReviwer);
$rsReviwer=$rs_Reviwer->fetch_array();
$usrm_fname=$rsReviwer['usrm_fname'];
$usrm_email=$rsReviwer['usrm_email'];
$usrm_phone=$rsReviwer['usrm_phone'];
//////////////////////////////////////////////////////////////////////////////
$sqlScoresMain = "SELECT * FROM ".$prefix."mscores where conceptm_id='$id' and EvaluatedBy='$conceptm_assignedto'";
$queryScoresMain = $mysqli->query($sqlScoresMain);
$totalScoresMain = $queryScoresMain->num_rows;

?>
<?php

if($_POST['doEvaluate']=='Submit')
{
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

$QnewMethods=$_POST['QnewMethods'];	
if($QnewMethods>=21){
$errmsg="Error!! <b>S&T Quality</b>: Question (a) has exceeded 20%";
}
////////////////////////////////////////////////////////////////////////
$QhighQuality=$_POST['QhighQuality'];
if($QhighQuality>=21){
$errmsg="Error!! <b>S&T Quality</b>: Question (b) has exceeded 20%";	
}
////////////////////////////////////////////////////////////////////////
$SatisfactoryPartnership=$_POST['SatisfactoryPartnership'];
if($SatisfactoryPartnership>=11){
$errmsg="Error!! <b>S&T Quality</b>: Question (c) has exceeded 10%";	
}
///////////////////////////////////////////////////////////////////////////
/*$PrototypeClearly=$_POST['PrototypeClearly'];
if($PrototypeClearly>=26){
$errmsg="Error!! <b>Applicability</b>: Question (a) has exceeded 25%";	
}*/

////////////////////////////////////////////////////////////////
$AddressIssues=$_POST['AddressIssues'];
if($AddressIssues>=16){
$errmsg="Error!! <b>Applicability</b>: Question (b) has exceeded 15%";	
}

/////////////////////////////////////////////////
$ClearlyConvincingly=$_POST['ClearlyConvincingly'];
if($ClearlyConvincingly>=8){
$errmsg="Error!! <b>Impact</b>: Question (a) has exceeded 7%";		
}

////////////////////////////////////////////////////////////////////////////////
$GenderIssues=$_POST['GenderIssues'];
if($GenderIssues>=4){
$errmsg="Error!! <b>Impact</b>: Question (b) has exceeded 3%";	
}

/////////////////////////////////////
$EvTotalScore=($QnewMethods+$QhighQuality+$SatisfactoryPartnership+$AddressIssues+$ClearlyConvincingly+$GenderIssues);
//////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////
$conceptm_id=$_POST['conceptm_id'];

		$sqlScores = "SELECT * FROM ".$prefix."mscores where conceptm_id='$conceptm_id' and EvaluatedBy='$conceptm_assignedto'";
		$queryScores = $mysqli->query($sqlScores);
        $totalScores = $queryScores->num_rows;
        $rScores = $queryScores->fetch_array();
		

if($totalScores || $errmsg){
$message="<p>Error!! Already Evaluated. Thank You</p>";	
}
if(!$totalScores and !$errmsg){
$queryScores="insert into ".$prefix."mscores (`conceptm_id`,`STQnewMethods`,`STQhighQuality`,`STQSatisfactoryPartnership`,`AppPrototypeClearly`,`AppAddressIssues`,`ImpactClearlyConvincingly`,`ImpactGenderIssues`,`EvTotalScore`,`EvaluatedBy`,`DateEvaluated`) 
values('$conceptm_id','$QnewMethods','$QhighQuality','$SatisfactoryPartnership','','$AddressIssues','$ClearlyConvincingly','$GenderIssues','$EvTotalScore','$usrm_id','$dateSubmitted')";
$mysqli->query($queryScores);
//////////////////////////////////////////////////////////////////////////////////////////////
$noReviewed=($rsContribution['conceptm_Reviewers']+1);

/*if($noReviewed==5){
$queryScores2="update ".$prefix."concepts  set `conceptm_status`='evaluated',`conceptm_Reviewers`='$noReviewed' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2);
}*/
//if($noReviewed!=5){//5 evauaters have not finished
$queryScores2="update ".$prefix."concepts  set `conceptm_status`='completed',`conceptm_Reviewers`='$noReviewed' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2);
//}

////////////////////update score logs///////////////////////////////////
$queryScores2d="update ".$prefix."conceptsasslogs  set `logm_status`='completed' where `conceptm_id`='$conceptm_id' and conceptm_assignedto='$conceptm_assignedto'";
$mysqli->query($queryScores2d);
////scored

	///send email notification to admin
	
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
$mail->addBcc("$emailBcc",'UNCST - $sitename Proposal Evaluated');//
$mail->addCc('nstip-admin@uncst.go.ug','UNCST - $sitename Proposal Evaluated');//

$mail->FromName = "$sitename"; //From Name -- CHANGE --
$mail->AddAddress("nstip-admin@uncst.go.ug", $ms_NameOfPI); //To Address -- CHANGE --
$mail->AddReplyTo($usrm_email, "UNCST - $sitename Proposal Evaluated"); //Reply-To Address -- CHANGE --$usrm_email

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$sitename - Proposal Evaluated ";
$body="
<p>Dear NSTIP Team,<br>
This is to inform you that $ms_NameOfPI's Proposal was Evaluated by $usrm_fname, find below the full details:</p>
<p>
<b>Reviewer Details</b><br>
Name: $usrm_fname<br>
Email: $usrm_email<br>
Phone: $usrm_phone
</p>

<p>
<b>PI Deatails</b><br>

Name of PI: $ms_NameOfPI<br>
Name of Institution: $conceptm_NameofInstitution<br>
Proposal: $proposalmTittle<br>
Email: $conceptm_email<br>
Phone: $conceptm_phone
</p>

<p><b>Scores</b><br>

<p><b>S&T Quality (Scientific and/or Technological Excellence): 50 Percent Score</b></p>
<p>a) Does the research involve the development of new methods, the integration of existing methods into new tools, or the application of existing methods in a novel way that improves and extends their utility? (20%). <b>$QnewMethods</b></p>

<p>b) Is the proposed research potentially of very high quality in relation to the highest international standards of scientific excellence in all of the sectors and disciplines that it includes? (20%) . <b>$QhighQuality</b></p>

<p>c) Are there satisfactory partnership mechanisms to support inter-sectoral or interdisciplinary understanding and collaboration? (10%). <b>$SatisfactoryPartnership</b></p>


<p> <b>Applicability (Efficiency of Implementation/Management): 40 Percent Score</b></p>

<p>Does the proposed research address issues that present significant challenges to the specified S&T field? (15%) <b>$AddressIssues</b></p>

<b>Impact (Development, Dissemination and Use of Project Results): 10 Percent Score</b></p>
<p>Are the anticipated development outcomes and possible pathways to impact clearly and convincingly argued? (7%).<b>$ClearlyConvincingly</b></p>
<p>Have gender issues been mainstreamed in project design and objectives? (3%).<b>$GenderIssues</b></p>
<p>
Date Evaluated: $dateSubmitted<br>
Total Score: <b>$EvTotalScore%<br>
Thank You</p>

<p>$sitename Management Team<br>
$fulladdress
https://localhost/scripts/grants/<br>
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

$message="<p class='success'><p>Successfully Evaluated. Total Score: <b>".$EvTotalScore."</b> Thank You</p>";
}


}//end checking permissions

?>
 
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

<form action="./main.php?option=score&id=<?php echo $id;?>" method="post" name="regForm" id="regForm"  enctype="multipart/form-data">

<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td>



<div class="box box-danger">
                                <div class="box-header">
                                  &nbsp;
                                </div><!-- /.box-header -->
                                <div class="box-body">
                           
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-check"></i>
                                       <b>S&T Quality (Scientific and/or Technological Excellence): 50 Percent Score</b>
                                       <p>a) Does the research involve the development of new methods, the integration of existing methods into new tools, or the application of existing methods in a novel way that improves and extends their utility? (20%). <br />
<input name="QnewMethods" type="text" class="required number" maxlength="2" id="QnewMethods" autocomplete="off"/>                                      
                                       
                                       </p>
                                       
                                       
                                       <p>b) Is the proposed research potentially of very high quality in relation to the highest international standards of scientific excellence in all of the sectors and disciplines that it includes? (20%) .<br />
<input name="QhighQuality" type="text" class="required number" maxlength="2" id="QhighQuality" autocomplete="off"/></p>
                                       
                                       <p>c) Are there satisfactory partnership mechanisms to support inter-sectoral or interdisciplinary understanding and collaboration? (10%).<br />
 <input name="SatisfactoryPartnership" type="text" class="required number" maxlength="2" id="SatisfactoryPartnership" autocomplete="off"/></p> 
                                        
                                    </div>
                                    <div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
           <b>Applicability (Efficiency of Implementation/Management): 40 Percent Score</b>
    <?php /*?>       <p>a) Is the research team able to present and demonstrate the research prototype clearly? (25%). <br />
<input name="PrototypeClearly" type="text" class="required number" maxlength="2" id="PrototypeClearly" autocomplete="off"/>
</p><?php */?>
<p>Does the proposed research address issues that present significant challenges to the specified S&T field? (15%). <br />
<input name="AddressIssues" type="text" class="required number" maxlength="2" id="AddressIssues" autocomplete="off"/>
</p>
           
           
           
                                    </div>
                                    
                                    
                                    <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
<b>Impact (Development, Dissemination and Use of Project Results): 10 Percent Score</b>
<p>a) Are the anticipated development outcomes and possible pathways to impact clearly and convincingly argued? (7%). <br />
<input name="ClearlyConvincingly" type="text" class="required number" maxlength="2" id="ClearlyConvincingly" autocomplete="off"/>
</p>
            <p>b) Have gender issues been mainstreamed in project design and objectives? (3%). <br />
<input name="GenderIssues" type="text" class="required number" maxlength="2" id="GenderIssues" autocomplete="off"/>
</p>
                                    </div>
                                    
                                    
                                </div><!-- /.box-body -->
                         
                            <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/> 


                     <table>
                               <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
<?php 
//check success messge
//if($_POST['doEvaluate']=='Submit' and $errmsg){?><input name="doEvaluate" type="submit" class="btn btn-info btn-flat" value="Submit"/><?php //}?>&nbsp;
<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=dashboard'"/></td>
  </tr>
</table>



                           
                           
         
</td>
<td style="padding-right:20px;">&nbsp;</td>
<td style="padding-top:30px;" valign="top">
<?php if($message){?><div class="alert alert-warning alert-dismissable"><?php echo $message;?></div><?php }?>

<?php /*?><?php if($errmessage){?><div class="alert alert-warning alert-dismissable"><?php echo $errmessage;?></div><?php }?><?php */?>

<?php if($errmsg){?><div class="alert alert-warning alert-dismissable">
<p><b>Please correct errors below</b>:</p>
<span style="color:#F00;"><?php echo $errmsg;?></span></div><?php }?>

 <b style="font-size:18px;"><?php echo $rsContribution['proposalmTittle'];?></b>
<?php
//Begin Browser Support
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('/MSIE/i', $user_agent)) {
//////////////////////////////////////
//if (preg_match('/MSIE/i', $user_agent)) { $browser = "Internet Explorer";}
//elseif (preg_match('/Firefox/i', $user_agent)){$browser = "Mozilla Firefox";}
//elseif (preg_match('/Chrome/i', $user_agent)){$browser = "Google Chrome";}
//elseif (preg_match('/Safari/i', $user_agent)){$browser = "Safari";}
//elseif (preg_match('/Opera/i', $user_agent)){$browser = "Opera";}
?>
<?php }else{?>

  <?php if($rsContribution['proposalm_uploadReup']){?>
  
  <iframe src="https://docs.google.com/viewerng/viewer?url=https://sgcigrants.uncst.go.ug/files/<?php echo $rsContribution['proposalm_uploadReup'];?>&hl=bn&embedded=true" style="width:500px; height:800px;"></iframe>
  
  <?php }?>

<?php 
}//end browser support
?>
</td>
</tr>
</table>

 </form>                           
 </section><?php }else{?><p style="color:#900;">Error!! You are not allowed to access this page</p><?php }?>