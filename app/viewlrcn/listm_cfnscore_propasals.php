<?php if($_SESSION['usrm_usrtype']=='reviewer'){
	
$queryLoggedr="select * from ".$prefix."musers where usrm_username='$usrm_username'";
$rs_Logged=$mysqli->query($queryLoggedr);
$rsLogged=$rs_Logged->fetch_array();
$usrrsLoggedId=$rsLogged['usrm_id'];

	//////get all//////////////////////////
$queryContributionLogs="select * from ".$prefix."conceptsasslogs where conceptm_id='$id' and conceptm_assignedto='$usrrsLoggedId'";
$rs_ContributionLogs=$mysqli->query($queryContributionLogs);
$rsContributionLogs=$rs_ContributionLogs->fetch_array();
$totalConceptLogs = $rs_ContributionLogs->num_rows;
$conceptm_assignedto=$rsContributionLogs['conceptm_assignedto'];

if($rsContributionLogs['categorym']=="concepts"){
$categorym="concepts";
}
if($rsContributionLogs['categorym']=="proposals"){
$categorym="proposals";
}
///////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."concepts where conceptm_id='$id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();
$conceptm_id=$rsContribution['conceptm_id'];
$conceptm_Times=$rsContribution['conceptm_Times'];
$conceptm_Times2=$rsContribution['conceptm_Times']+1;
//////////////////////////////////////////////////////////////////////////////////////
$queryContribution2="select * from ".$prefix."concepts where conceptm_id='$conceptm_id'";
$rs_Contribution2=$mysqli->query($queryContribution2);
$rsContribution2=$rs_Contribution2->fetch_array();

$ms_NameOfPI=$rsContribution2['ms_NameOfPI'];
$conceptm_NameofInstitution=$rsContribution2['conceptm_NameofInstitution'];
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

if($_POST['doEvaluate']=='Submit' and $totalConceptLogs)
{
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

$QnewMethods=$_POST['QnewMethods'];	
if($QnewMethods>=31){
$errmsg="Error!! <b>Scientific quality and innovation of the joint research proposal</b>: Question has exceeded 30%";
}
////////////////////////////////////////////////////////////////////////
$QhighQuality=$_POST['QhighQuality'];
if($QhighQuality>=16){
$errmsg="Error!! <b>Feasibility  of the joint  research  proposal (Practicality,   feasibility   and   consistency   of   proposed   activities   with   the objectives  of the call,  and feasibility  of the  methodology  provided)</b>: 15%";	
}
////////////////////////////////////////////////////////////////////////
$SatisfactoryPartnership=$_POST['SatisfactoryPartnership'];
if($SatisfactoryPartnership>=16){
$errmsg="Error!! <b>3. Added value  to expect  from  collaboration Technological  capacity  building</b> 15%";	
}
///////////////////////////////////////////////////////////////////////////
//$PrototypeClearly=$_POST['PrototypeClearly'];
//if($PrototypeClearly>=26){
//$errmsg="Error!! <b>Applicability</b>: Question (a) has exceeded 25";	
//}

////////////////////////////////////////////////////////////////
$AddressIssues=$_POST['AddressIssues'];
if($AddressIssues>=6){
$errmsg="Error!! <b>4. Competence, <?php echo $lang_Expertise;?> and experience of principal investigators and relevant  scientists  / research  teams</b>: Question exceeded 5%";	
}

/////////////////////////////////////////////////
$ClearlyConvincingly=$_POST['ClearlyConvincingly'];
if($ClearlyConvincingly>=16){
$errmsg="Error!! <b>5. Clarity of expected results</b>: Question (a) has exceeded 15%";		
}

////////////////////////////////////////////////////////////////////////////////
$GenderIssues=$_POST['GenderIssues'];
if($GenderIssues>=11){
$errmsg="Error!! Question 6 has exceeded 10%";	
}

$Potential=$_POST['Potential'];
if($Potential>=6){
$errmsg="Error!! Question Potential to promote equity and ethics of the joint project (5%)";	
}

$Budget=$_POST['Budget'];
if($Budget>=6){
$errmsg="Error!! Budget has exceeded 5%";	
}


/////////////////////////////////////
$EvTotalScore=($QnewMethods+$QhighQuality+$SatisfactoryPartnership+$AddressIssues+$ClearlyConvincingly+$GenderIssues+$Potential+$Budget);
//////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////
$conceptm_id=$mysqli->real_escape_string($_POST['conceptm_id']);
$ownermID=$mysqli->real_escape_string($_POST['ownermID']);
$overallcomment=$mysqli->real_escape_string($_POST['overallcomment']);
$comment1=$mysqli->real_escape_string($_POST['comment1']);
$comment2=$mysqli->real_escape_string($_POST['comment2']);
$comment3=$mysqli->real_escape_string($_POST['comment3']);
$comment4=$mysqli->real_escape_string($_POST['comment4']);
$comment5=$mysqli->real_escape_string($_POST['comment5']);
$comment6=$mysqli->real_escape_string($_POST['comment6']);
$commentnon=$mysqli->real_escape_string($_POST['commentnon']);
$comment7=$mysqli->real_escape_string($_POST['comment7']);

$Verdict=$mysqli->real_escape_string($_POST['Verdict']);
$categorym=$mysqli->real_escape_string($_POST['categorym']);

		$sqlScores = "SELECT * FROM ".$prefix."mscores where conceptm_id='$conceptm_id' and EvaluatedBy='$conceptm_assignedto'";
		$queryScores = $mysqli->query($sqlScores);
        $totalScores = $queryScores->num_rows;
        $rScores = $queryScores->fetch_array(); 
		

if($totalScores){// || $errmsg
$message="<p>Error!! Already Evaluated. Thank You</p>";	
}
if(!$totalScores and !$errmsg){
$queryScores="insert into ".$prefix."mscores (`conceptm_id`,`STQnewMethods`,`STQhighQuality`,`STQSatisfactoryPartnership`,`AppPrototypeClearly`,`AppAddressIssues`,`ImpactClearlyConvincingly`,`ImpactGenderIssues`,`EvTotalScore`,`EvaluatedBy`,`DateEvaluated`,`usrm_id`,`EvoverallComment`,`EvComment1`,`EvComment2`,`EvComment3`,`EvComment4`,`EvComment5`,`EvComment6`,`Everdict`,`EVivaScore`,`EvVivaComments`,`vivconceptStatus`,`EvSame`,`categorym`,`EvgeneralTotal`,`openstatus`,`Potential`,`Budget`,`EvCommentnon`,`EvComment7`) 
values('$conceptm_id','$QnewMethods','$QhighQuality','$SatisfactoryPartnership','','$AddressIssues','$ClearlyConvincingly','$GenderIssues','$EvTotalScore','$conceptm_assignedto','$dateSubmitted','$ownermID','$overallcomment','$comment1','$comment2','$comment3','$comment4','$comment5','$comment6','$Verdict','','','','','$categorym','','open','$Potential','$Budget','$commentnon','$comment7')";
$mysqli->query($queryScores);
//////////////////////////////////////////////////////////////////////////////////////////////
$noReviewed=($rsContribution['conceptm_Reviewers']+1);

//if($noReviewed==5){
//$queryScores2="update ".$prefix."concepts  set `conceptm_status`='evaluated',`conceptm_Reviewers`='$noReviewed' where `conceptm_id`='$conceptm_id'";
//$mysqli->query($queryScores2);
//}
//if($noReviewed!=5){//5 evauaters have not finished
$queryScores2="update ".$prefix."concepts  set `conceptm_status`='completed',`conceptm_Reviewers`='$noReviewed' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2);
//}
if($conceptm_Times==0){
$queryScores2Times="update ".$prefix."concepts  set `conceptm_Times`='1' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2Times);
////My Scores
$sqlScoresCons = "update ".$prefix."mscores set `EvSame`='1' where conceptm_id='$conceptm_id' and EvaluatedBy='$conceptm_assignedto'";
$mysqli->query($sqlScoresCons);
}
if($conceptm_Times>=1){
$queryScores2Timesw="update ".$prefix."concepts  set `conceptm_Times`='$conceptm_Times2' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2Timesw);
$sqlScoresConsd = "update ".$prefix."mscores set `EvSame`='2' where conceptm_id='$conceptm_id' and EvaluatedBy='$conceptm_assignedto'";
$mysqli->query($sqlScoresConsd);
}
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
$mail->FromName = "$sitename"; //From Name -- CHANGE --
$mail->AddAddress("uncstuganda@gmail.com", $ms_NameOfPI); //To Address -- CHANGE --
$mail->addBcc("$emailBcc",'UNCST - $sitename');//
$mail->AddReplyTo($usrm_email, "$sitename Proposal Evaluated"); //Reply-To Address -- CHANGE --$usrm_email

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$sitename - Proposal Evaluated ";
$body="
<p>Dear $sitename Team,<br>
<p>
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

<p>1. Scientific quality and innovation of the joint research proposal (30%). <b>$QnewMethods</b></p>

<p>2. Feasibility  of the joint  research  proposal (Practicality,   feasibility   and   consistency   of   proposed   activities   with   the objectives  of the call,  and feasibility  of the  methodology  provided) (15%) . <b>$QhighQuality</b></p>

<p>3. Added value  to expect  from  collaboration Technological  capacity  building (15%). <b>$SatisfactoryPartnership</b></p>

<p>4. Competence, <?php echo $lang_Expertise;?> and experience of principal investigators and relevant  scientists  / research  teams (5%) <b>$AddressIssues</b></p>

<p>5. Clarity of expected results (15%).<b>$ClearlyConvincingly</b></p>


<p>6. Relevance and impact of  research (Industrial Development, Technological Capacity Building, Marketing of Research Results, Agricultural Production,   Improved Health Outcomes, Economic  Growth  Improved  Livelihoods) (10%).<b>$GenderIssues</b></p>


<p>Potential to promote equity and ethics of the joint project (5%).<b>$Potential</b></p>

<p>7. Budget (Consistency  with  the  budget  ratio  or  percentage  provided  by  the  appeal guide, Basis of  estimates - How  well the  proposed  expenses  reflect the actual  cost of the  proposed action?) (5%).<b>$Budget</b></p>




<p>
Date Evaluated: $dateSubmitted<br>
Total Score: <b>$EvTotalScore<br>
Thank You</p>

<p>$sitename Team<br>
$fulladdress
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

$message="<p class='success'><p>Successfully Evaluated. Total Score: <b>".$EvTotalScore."</b> Thank You</p>";


echo '<meta http-equiv="refresh" content="5; url=https://sgcigrants.uncst.go.ug/main.php?option=dashboard" />';
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

<form action="./main.php?option=pscore&id=<?php echo $id;?>" method="post" name="regForm" id="regForm"  enctype="multipart/form-data">

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


                                       <p>1. Scientific quality and innovation of the joint research proposal <strong>(30%)</strong>. <br />
                                       
<table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong><?php echo $lang_ProvideComments;?></strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="QnewMethods" type="text" class="required number" maxlength="2" id="QnewMethods" autocomplete="off"/>
    <input name="categorym" type="hidden" id="categorym" value="<?php echo $categorym;?>"/>
     </td>
    <td valign="top"><textarea name="comment1" cols="40" rows="" id="comment1"></textarea> </td>
  </tr>
</table>
 </p>
 <div class="clear"></div>
                                       
                                       
2. Feasibility  of the joint  research  proposal (Practicality,   feasibility   and   consistency   of   proposed   activities   with   the objectives  of the call,  and feasibility  of the  methodology  provided)<strong>(15%) </strong>.<br />


<table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong><?php echo $lang_ProvideComments;?></strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="QhighQuality" type="text" class="required number" maxlength="2" id="QhighQuality" autocomplete="off"/> </td>
    <td valign="top"><textarea name="comment2" cols="40" rows="" id="comment2"></textarea> </td>
  </tr>
</table>
</p>
 <div class="clear"></div>
                                       
3. Added value  to expect  from  collaboration Technological  capacity  building <strong>(15%)</strong>. 
 
 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="SatisfactoryPartnership" type="text" class="required number" maxlength="2" id="SatisfactoryPartnership" autocomplete="off"/> </td>
    <td valign="top"><textarea name="comment3" cols="40" rows="" id="comment3"></textarea> </td>
  </tr>
</table>
 
 
 </p>
  <div class="clear"></div> 
                                        
                                    </div>
                                    <div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
4. Competence, <?php echo $lang_Expertise;?> and experience of principal investigators and relevant  scientists  / research  teams <strong>(5%)</strong>.

 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong><?php echo $lang_ProvideComments;?></strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="AddressIssues" type="text" class="required number" maxlength="2" id="AddressIssues" autocomplete="off"/> </td>
    <td valign="top"><textarea name="comment4" cols="40" rows="" id="comment4"></textarea> </td>
  </tr>
</table>



</p>
  <div class="clear"></div>          
           
           
                                    </div>
                                    
                                    
                                    <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
5. Clarity of expected results <strong>(15%)</strong>.
 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="ClearlyConvincingly" type="text" class="required number" maxlength="2" id="ClearlyConvincingly" autocomplete="off"/> </td>
    <td valign="top"><textarea name="comment5" cols="40" rows="" id="comment5"></textarea> </td>
  </tr>
</table>


</p>
 <div class="clear"></div>
 </div>
 
 
 <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
6. Relevance and impact of  research (Industrial Development, Technological Capacity Building, Marketing of Research Results, Agricultural Production,   Improved Health Outcomes, Economic  Growth  Improved  Livelihoods) <strong>(10%)</strong>.
 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="GenderIssues" type="text" class="required number" maxlength="2" id="GenderIssues" autocomplete="off"/></td>
    <td valign="top"><textarea name="comment6" cols="40" rows="" id="comment6"></textarea> </td>
  </tr>
</table>

 <div class="clear"></div>
 </div>
 
 <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
Potential to promote equity and ethics of the joint project <strong>(5%)</strong>.
 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="Potential" type="text" class="required number" maxlength="2" id="Potential" autocomplete="off"/></td>
    <td valign="top"><textarea name="commentnon" cols="40" rows="" id="commentnon"></textarea> </td>
  </tr>
</table>
  <div class="clear"></div>
 
7. Budget (Consistency  with  the  budget  ratio  or  percentage  provided  by  the  appeal guide, Basis of  estimates - How  well the  proposed  expenses  reflect the actual  cost of the  proposed action?) <strong>(5%)</strong>.
 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="Budget" type="text" class="required number" maxlength="2" id="Budget" autocomplete="off"/></td>
    <td valign="top"><textarea name="comment7" cols="40" rows="" id="comment7"></textarea> </td>
  </tr>
</table>
 
  <div class="clear"></div>
                                    </div>
                                    
                                    
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                     <div class="alert alert-success alert-dismissable">
<i class="fa fa-check"></i>
<p><strong><?php echo $lang_OverallComment;?></strong></p>
<textarea name="overallcomment" cols="40" rows="" id="commentoverall"></textarea>
 <div class="clear"></div>
<p><strong><?php echo $lang_Verdict;?></strong></p>
<input name="Verdict" type="radio" value="Recommended for Consideration" class="required"/>&nbsp;&nbsp;<?php echo $lang_RecommendedforConsideration;?><br />

<input name="Verdict" type="radio" value="Not Recommended for Consideration" class="required"/>&nbsp;&nbsp;<?php echo $lang_NotRecommendedforConsideration;?>
 <div class="clear"></div>

 
                                    </div>
                                    
                                    <p>&nbsp;</p> 
                                </div><!-- /.box-body -->                        
                                
                                
                                
                                
                                
                                
                         
                            <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/> 
                             <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/>
                             <input name="ownermID" type="hidden"  value="<?php echo $rsContribution['usrm_id'];?>"/>

                     <table>
                               <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
<?php 
//check success messge
//if($_POST['doEvaluate']=='Submit' and $errmsg){?>
<input name="doEvaluate" type="submit" class="btn btn-info btn-flat" value="Submit"/><?php //}?>&nbsp;
<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=pproposals'"/></td>
  </tr>
</table>



                           
                           
         
</td>
<td style="padding-right:20px;">&nbsp;</td>
<td style="padding-top:30px;" valign="top">
<?php if($message){?><div class="alert alert-warning alert-dismissable" style="font-size:18px; font-weight:bold;"><?php echo $message;?></div><?php }?>

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


  <?php if($rsContribution['proposalm_uploadReup']){ //proposalm_uploadReup?>
  
<iframe src="https://docs.google.com/viewerng/viewer?url=https://sgcigrants.uncst.go.ug/files/<?php echo $rsContribution['proposalm_uploadReup'];?>&hl=bn&embedded=true" style="width:500px; height:800px;"></iframe>
  <?php }?>
  
   <?php if($rsContribution['proposalm_upload'] and !$rsContribution['proposalm_upload']){ //proposalm_uploadReup?>
 <iframe src="https://docs.google.com/viewerng/viewer?url=https://sgcigrants.uncst.go.ug/files/<?php echo $rsContribution['proposalm_upload'];?>&hl=bn&embedded=true" style="width:500px; height:800px;"></iframe>
 


  <?php }?>

<?php 
}//end browser support
?>
</td>
</tr>
</table>

 </form>                           
 </section><?php }else{?><p style="color:#900;">Error!! You are not allowed to access this page</p><?php }?>