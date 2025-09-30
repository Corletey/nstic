<?php
///Get project Owner
$wmOwner="select * from ".$prefix."submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
$grantID=$_GET['grantID'];
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];


?>

<?php 
if($_POST['doSubmitAssigntoReviewers']){
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

$proposalTittle=$mysqli->real_escape_string($_POST['proposalTittle']);
$owner_id=$mysqli->real_escape_string($_POST['owner_id']);
$conceptm_id=$mysqli->real_escape_string($_POST['conceptm_id']);
$currentReviewer=$mysqli->real_escape_string($_POST['currentReviewer']);

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

$sqlMember="SELECT * FROM ".$prefix."musers  where usrm_id='$owner_id'";
$QueryMember=$mysqli->query($sqlMember);
$sqMember = $QueryMember->fetch_array();
$nameofpi=$sqMember['usrm_sname'];
$conceptm_email=$sqMember['usrm_email'];

$queryConceptLogs="select * from ".$prefix."conceptsasslogs_new where conceptm_id='$conceptm_id' and conceptm_assignedto='$cfnreviewer' and categorym='proposals'";
$rsConceptLogs=$mysqli->query($queryConceptLogs);
$rTotalConceptLogs=$rsConceptLogs->num_rows;
if(!$rTotalConceptLogs){
//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`) 
values('$session_fullname has assigned $nameofpi proposal titled $proposalTittle to $assignedtoName','$nameofpi','$email','$user_ip',now())";
$mysqli->query($queryLog) or print(mysql_error());		
	
//,conceptm_assignedto='$reviewer'
$queryC="update ".$prefix."submissions_proposals  set projectStatus='Scheduled for Review' where projectID='$conceptm_id'";
$mysqli->query($queryC);

$queryCd="update ".$prefix."review_proposals  set status='completed' where projectID='$conceptm_id' and reviewer_id='$currentReviewer'";
$mysqli->query($queryCd);
///////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
$queryLog2="insert into ".$prefix."conceptsasslogs_new (`conceptm_id`,`conceptm_assignedto`,`conceptm_by`,`assignm_date`,`logm_status`,`categorym`,`conceptm_assignedby`,`conflictofInterest`,`availableReview`,`availableReviewComment`,`reviewStatus`,`grantID`) 
values('$conceptm_id','$cfnreviewer','$owner_id',now(),'new','proposals','$usrm_id','none','no','','dynamic','$grantID')";
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

$mail->addBcc("$emailBcc",'$sitename');//
//$mail->addCc('$emailUsername','');//

$mail->FromName = "$sitename"; //From Name -- CHANGE --
$mail->AddAddress($usrm_email, $assignedtoName); //To Address -- CHANGE -- 
$mail->AddReplyTo("$emailUsername", "$sitename"); //Reply-To Address -- CHANGE --

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$sitename - $lang_ProposalHasbeenScheduledforReview";
$body="
<p>$lang_dear $assignedtoName,<br>
$lang_aProposal, <b>$proposalTittle</b> $lang_proposal_for_review</p>

<p>$fulladdress</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;}

}//end Totals
}////end foreach


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

$mail->FromName = "$sitename"; //From Name -- CHANGE --
$mail->AddAddress($conceptm_email, $nameofpi); //To Address -- CHANGE --$conceptm_email
$mail->AddReplyTo("$emailUsername", "$sitename"); //Reply-To Address -- CHANGE --

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$sitename - $lang_ProposalHasbeenScheduledforReview";
$body="Dear $nameofpi,<br><br>
$lang_referenceMessage
$name_granting_council $lang_referenceMessageX <b>$proposalTittle</b>
$lang_referenceMessageM

</p>

<p>$fulladdress</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;}

$message="A proposal, <b>$proposalTittle</b> has been assigned for review.";

echo '<img src="./img/loading_wait.gif">';
echo '<div class="spacer"></div>';
//sleep for 3 seconds
sleep(5);

//echo '<meta http-equiv="refresh" content="5; url='.$base_url.'main.php?option=dashboard/" />';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=NewProposals'>";
}///end Post


$sqlUsers4="SELECT * FROM ".$prefix."submissions_proposals where projectID='$id' order by projectID desc limit 0,1";
$QueryUsers4 = $mysqli->query($sqlUsers4);
$rUserInv4=$QueryUsers4->fetch_array();
?>



<div class="tab">

 <button class="tablinks" onClick="window.location.href='./main.php?option=reviewPrososal&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  <button class="tablinks"  onClick="window.location.href='./main.php?option=reviewproposalResearchTeam&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=reviewproposalBackground&id=<?php echo $id;?>'"><?php echo $lang_new_Background;?> </button>
    <button class="tablinks" onClick="window.location.href='./main.php?option=reviewproposalMethodology&id=<?php echo $id;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    <button class="tablinks" onClick="window.location.href='./main.php?option=reviewproposalBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
   <button class="tablinks"  onClick="window.location.href='./main.php?option=reviewproposalResults&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectResults;?></button>
  
  <button class="tablinks"  onClick="window.location.href='./main.php?option=reviewproposalManagement&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=newreviewproposalReferences&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectFollowup;?></button>

  <button <?php if($rProjectStages['conceptAttachments']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'ReviewproposalAssign')" id="defaultOpen"><?php echo $lang_new_Citations;?> </button>
  
</div>


<div id="ReviewproposalAssign" class="tabcontent">



  <h3><?php echo $lang_AssignProposal;?></h3><?php if($message){?><span style="color:#03F; font-size:18px;"><?php  echo $message;?></span> <?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $id;?>">
  <input type="hidden" name="proposalTittle" value="<?php echo $rUserInv4['projectTitle'];?>">
  <input type="hidden" name="owner_id" value="<?php echo $rUserInv4['owner_id'];?>">
  <input type="hidden" name="conceptm_id" value="<?php echo $id;?>">
 <input type="hidden" name="currentReviewer" value="<?php echo $usrm_id;?>">
 
<div class="container"><!--begin-->

  
  <label for="fname"><strong><?php echo $lang_TickcheckboxandAssignReviewer;?></strong> (<span class="error">*</span>)</label>
  <div class="row">

    <div class="col-100ss">
    <table width="100%" border="0" id="customers">
  <tr>
    <th></th>
    <th><?php echo $lang_phone_Name;?></th>
    <th><?php echo $lang_email;?></th>
    <th><?php echo $lang_phone_number;?></th>
    <th><?php echo $lang_Category;?></th>
  </tr>



    <?php
$researchTypeID=$rUserInv4['researchTypeID'];
$sqlUsers2="SELECT * FROM ".$prefix."musers where usrm_usrtype='reviewer' and categoryID like '%$researchTypeID%' order by usrm_fname asc limit 0,30";
$QueryUsers2 = $mysqli->query($sqlUsers2);
while($rUserInv2=$QueryUsers2->fetch_array()){
	
$cfnreviewer=$rUserInv2['usrm_id'];
$cfnreviewer2=$rUserInv2['categoryID'];

$queryConceptLogs1="select * from ".$prefix."conceptsasslogs_new where conceptm_assignedto='$cfnreviewer' and conceptm_id='$id' and categorym='proposals'";
$rsConceptLogs1=$mysqli->query($queryConceptLogs1);
$rUserConceptLogs1=$rsConceptLogs1->fetch_array();
	
	?>
  <?php if($rUserInv2['usrm_id']==$rUserConceptLogs1['conceptm_assignedto']){?><tr>
    <td style="background:#ddd;"><input name="reviewer[]" type="checkbox" value="<?php echo $rUserInv2['usrm_id'];?>" class="required" <?php if($rUserInv2['usrm_id']==$rUserConceptLogs1['conceptm_assignedto']){?>checked="checked"<?php }?> disabled /></td>
    <td style="background:#ddd;"><?php echo $rUserInv2['usrm_fname'];?> <?php echo $rUserInv2['usrm_sname'];?></td>
    <td style="background:#ddd;"><?php echo $rUserInv2['usrm_email'];?></td>
    <td style="background:#ddd;"><?php echo $rUserInv2['usrm_phone'];?></td>
    <td style="background:#ddd;"><?php echo $rUserInv2['usrm_usrtype'];?></td>
  </tr><?php }?>
  
   <?php if($rUserInv2['usrm_id']!=$rUserConceptLogs1['conceptm_assignedto']){?>
   <tr>
    <td><input name="reviewer[]" type="checkbox" value="<?php echo $rUserInv2['usrm_id'];?>" class="required"/></td>
    <td><?php echo $rUserInv2['usrm_fname'];?> <?php echo $rUserInv2['usrm_sname'];?></td>
    <td><?php echo $rUserInv2['usrm_email'];?></td>
    <td><?php echo $rUserInv2['usrm_phone'];?></td>
    <td><?php echo $rUserInv2['usrm_usrtype'];?></td>
  </tr><?php }?>
  
  
    <?php }?>

</table>
    </div>
  </div>
  
 <div class="row">
    <input type="submit" name="doSubmitAssigntoReviewers" value="<?php echo $lang_AssigntoReviewers;?>">
  </div>
 
</div><!--End-->


 </form>


</div>
<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script><?php }?>