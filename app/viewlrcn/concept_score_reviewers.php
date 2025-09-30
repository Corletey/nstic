<?php
///Get project Owner
$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];


?>

<?php if($_SESSION['usrm_usrtype']=='reviewer'){
	
$queryLoggedr="select * from ".$prefix."musers where usrm_username='$usrm_username'";
$rs_Logged=$mysqli->query($queryLoggedr);
$rsLogged=$rs_Logged->fetch_array();
$usrrsLoggedId=$rsLogged['usrm_id'];

	//////get all//////////////////////////
$queryContributionLogs="select * from ".$prefix."conceptsasslogs_new where conceptm_id='$id' and conceptm_assignedto='$usrrsLoggedId'";
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
$queryContribution="select * from ".$prefix."submissions_concepts where conceptID='$id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();
$conceptm_id=$rsContribution['conceptm_id'];
$conceptm_Times=$rsContribution['conceptm_Times'];
$conceptm_Times2=$rsContribution['conceptm_Times']+1;
//////////////////////////////////////////////////////////////////////////////////////
$queryContribution2="select * from ".$prefix."submissions_concepts where conceptID='$conceptm_id'";
$rs_Contribution2=$mysqli->query($queryContribution2);
$rsContribution2=$rs_Contribution2->fetch_array();

$ms_NameOfPI=$rsContribution2['ms_NameOfPI'];
$conceptm_NameofInstitution=$rsContribution2['HostInstitution'];
$proposalmTittle=$rsContribution['projectTitle'];





/////////////////////Get Reviewer Details
$queryReviwer="select * from ".$prefix."musers where usrm_id='$conceptm_assignedto'";
$rs_Reviwer=$mysqli->query($queryReviwer);
$rsReviwer=$rs_Reviwer->fetch_array();
$usrm_fname=$rsReviwer['usrm_fname'];
$usrm_email=$rsReviwer['usrm_email'];
$usrm_phone=$rsReviwer['usrm_phone'];
///Get owner details
$conceptm_email=$rsReviwer['usrm_email'];
$conceptm_phone=$rsReviwer['usrm_phone'];

//////////////////////////////////////////////////////////////////////////////
$sqlScoresMain = "SELECT * FROM ".$prefix."mscores_new where conceptm_id='$id' and EvaluatedBy='$conceptm_assignedto'";
$queryScoresMain = $mysqli->query($sqlScoresMain);
$totalScoresMain = $queryScoresMain->num_rows;

?>
<?php
if($_POST['doSubmit'] and $totalConceptLogs)
{
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

$QnewMethods=$_POST['QnewMethods'];	
if($QnewMethods>=31){
$errmsg="<div class='error2'>Error!! <b>Scientific quality and innovation of the joint research proposal</b>: Question has exceeded 30%</div>";
}
////////////////////////////////////////////////////////////////////////
$QhighQuality=$_POST['QhighQuality'];
if($QhighQuality>=16){
$errmsg="<div class='error2'>Error!! <b>Feasibility  of the joint  research  proposal (Practicality,   feasibility   and   consistency   of   proposed   activities   with   the objectives  of the call,  and feasibility  of the  methodology  provided)</b>: 15%</div>";	
}
////////////////////////////////////////////////////////////////////////
$SatisfactoryPartnership=$_POST['SatisfactoryPartnership'];
if($SatisfactoryPartnership>=16){
$errmsg="<div class='error2'>Error!! <b>3. Added value  to expect  from  collaboration Technological  capacity  building</b> 15%</div>";	
}
///////////////////////////////////////////////////////////////////////////
//$PrototypeClearly=$_POST['PrototypeClearly'];
//if($PrototypeClearly>=26){
//$errmsg="Error!! <b>Applicability</b>: Question (a) has exceeded 25";	
//}

////////////////////////////////////////////////////////////////
$AddressIssues=$_POST['AddressIssues'];
if($AddressIssues>=6){
$errmsg="<div class='error2'>Error!! <b>4. Competence, <?php echo $lang_Expertise;?> and experience of principal investigators and relevant  scientists  / research  teams</b>: Question exceeded 5%</div>";	
}

/////////////////////////////////////////////////
$ClearlyConvincingly=$_POST['ClearlyConvincingly'];
if($ClearlyConvincingly>=16){
$errmsg="<div class='error2'>Error!! <b>5. Clarity of expected results</b>: Question (a) has exceeded 15%</div>";		
}

////////////////////////////////////////////////////////////////////////////////
$GenderIssues=$_POST['GenderIssues'];
if($GenderIssues>=11){
$errmsg="<div class='error2'>Error!! Question 6 has exceeded 10%</div>";	
}

$Potential=$_POST['Potential'];
if($Potential>=10){
$errmsg="<div class='error2'>Error!! Question Potential to promote equity and ethics of the joint project (5%)</div>";	
}

$Budget=$_POST['Budget'];
if($Budget>=6){
$errmsg="<div class='error2'>Error!! Budget has exceeded 5%</div>";	
}


/////////////////////////////////////
$EvTotalScore=($QnewMethods+$QhighQuality+$SatisfactoryPartnership+$AddressIssues+$ClearlyConvincingly+$GenderIssues+$Potential+$Budget);
//////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////
$conceptm_id=$mysqli->real_escape_string($_POST['conceptm_id']);
$ownermID=$mysqli->real_escape_string($_POST['owner_id']);
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

		$sqlScores = "SELECT * FROM ".$prefix."mscores_new where conceptm_id='$conceptm_id' and EvaluatedBy='$conceptm_assignedto'";
		$queryScores = $mysqli->query($sqlScores);
       $totalScores = $queryScores->num_rows;
        $rScores = $queryScores->fetch_array(); 
		

if($totalScores){// || $errmsg
$message="<div class='error2'>Error!! Already Evaluated. Thank You</div>";	
}
if($totalScores and !$errmsg){
$queryScores="update ".$prefix."mscores_new set `STQnewMethods`='$QnewMethods',`STQhighQuality`='$QhighQuality',`STQSatisfactoryPartnership`='$SatisfactoryPartnership',`AppPrototypeClearly`='$AddressIssues',`AppAddressIssues`='$AddressIssues',`Potential`='$Potential',`ImpactClearlyConvincingly`='$ClearlyConvincingly',`ImpactGenderIssues`='$GenderIssues',`EvTotalScore`='$EvTotalScore',`EvoverallComment`='$overallcomment',`EvComment1`='$comment1',`EvComment2`='$comment2',`EvComment3`='$comment3',`EvComment4`='$comment4',`EvComment5`='$comment5',`EvComment6`='$comment6',`Everdict`='$Verdict',`Budget`='$Budget',`EvCommentnon`='$commentnon',`EvComment7`='$comment7' `openstatus`='closed' where conceptm_id='$conceptm_id' and EvaluatedBy='$conceptm_assignedto'";
$mysqli->query($queryScores);
	
	

//////////////////////////////////////////////////////////////////////////////////////////////
$noReviewed=($rsContribution['conceptm_Reviewers']+1);

//if($noReviewed==5){
//$queryScores2="update ".$prefix."concepts  set `conceptm_status`='evaluated',`conceptm_Reviewers`='$noReviewed' where `conceptm_id`='$conceptm_id'";
//$mysqli->query($queryScores2);
//}
//if($noReviewed!=5){//5 evauaters have not finished
$queryScores2="update ".$prefix."submissions_concepts  set `projectStatus`='Reviewed',`conceptm_Reviewers`='$noReviewed' where `conceptID`='$conceptm_id'";
$mysqli->query($queryScores2);
//}
if($conceptm_Times==0){
$queryScores2Times="update ".$prefix."submissions_concepts  set `conceptm_Times`='1' where `conceptID`='$conceptm_id'";
$mysqli->query($queryScores2Times);
////My Scores
$sqlScoresCons = "update ".$prefix."mscores_new set `EvSame`='1' where conceptm_id='$conceptm_id' and EvaluatedBy='$conceptm_assignedto'";
$mysqli->query($sqlScoresCons);
}
if($conceptm_Times>=1){
$queryScores2Timesw="update ".$prefix."submissions_concepts  set `conceptm_Times`='$conceptm_Times2' where `conceptID`='$conceptm_id'";
$mysqli->query($queryScores2Timesw);
$sqlScoresConsd = "update ".$prefix."mscores_new set `EvSame`='2' where conceptm_id='$conceptm_id' and EvaluatedBy='$conceptm_assignedto'";
$mysqli->query($sqlScoresConsd);
}
////////////////////update score logs///////////////////////////////////
$queryScores2d="update ".$prefix."conceptsasslogs_new  set `logm_status`='completed' where `conceptm_id`='$conceptm_id' and conceptm_assignedto='$conceptm_assignedto'";
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

<p>$fulladdress
https://.uncst.go.ug/grants<br>
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

$message="<p class='success'><p>Successfully Evaluated. Total Score: <b>".$EvTotalScore."</b> Thank You</p>";
sleep(6);
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=CompleteConceptsReviewer'>";

//if($record_id){}
}


}//end checking permissions

}


$sqlUsers4="SELECT * FROM ".$prefix."submissions_concepts where conceptID='$id' order by conceptID desc limit 0,1";
$QueryUsers4 = $mysqli->query($sqlUsers4);
$rUserInv4=$QueryUsers4->fetch_array();

//////////////////////////Score
$sessionusrm_id=$_SESSION['usrm_id'];
$sqlUsersScore="SELECT * FROM ".$prefix."mscores_new where conceptm_id='$id' and EvaluatedBy='$sessionusrm_id' order by scoredmID desc limit 0,1";
$QueryScore = $mysqli->query($sqlUsersScore);
$rsScore=$QueryScore->fetch_array();
?>



<div class="tab">

   <button class="tablinks"onClick="window.location.href='./main.php?option=reviewProjectInformation&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptPrincipalInvestigator&id=<?php echo $id;?>'">Principal Investigator</button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button>
   <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button>
  <button class="tablinks"  onClick="window.location.href='./main.php?option=ReviewconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
  <button class="tablinks"  onClick="window.location.href='./main.php?option=ReviewconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button>
  <button class="tablinks"  onclick="openCity(event, 'conceptScoreReviewers')" id="defaultOpen">Score Sheet </button>
  
</div>


<div id="conceptScoreReviewers" class="tabcontent">



  <h3><?php echo $lang_GiveScoretoConcept;?></h3><?php if($message){?><?php  echo $message;?><?php }?>
  <?php if($errmsg){?><?php  echo $errmsg;?><?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $id;?>">
  <input type="hidden" name="proposalTittle" value="<?php echo $rUserInv4['projectTitle'];?>">
  <input type="hidden" name="owner_id" value="<?php echo $rUserInv4['owner_id'];?>">
  <input type="hidden" name="conceptm_id" value="<?php echo $id;?>">
 
 
<div class="container"><!--begin-->


  <div class="row success">

    <div class="col-100">
  
  
                                       
<table width="100%" border="0" id="customers">
  <tr>
    <th width="35%"><strong><?php echo $lang_Score;?></strong></th>
    <th width="49%"><strong><?php echo $lang_ProvideComments;?></strong></th>
  </tr>
  <tr><td colspan="2"><strong>1. Scientific quality and innovation of the joint research proposal (30%)</strong></td></tr>
  <tr>
    <td valign="top"><input name="QnewMethods" type="text" class="required number" maxlength="2" id="QnewMethods" autocomplete="off" value="<?php if($rsScore['STQnewMethods']){echo $rsScore['STQnewMethods'];}else{ echo $_POST['QnewMethods'];}?>"/> </td>
    <td valign="top"><textarea name="comment1" cols="40" rows="" id="comment1"><?php if($rsScore['EvComment1']){echo $rsScore['EvComment1'];}else{ echo $_POST['comment1'];}?></textarea> </td>
  </tr>
  
   <tr><td colspan="2"><strong>2. Feasibility  of the joint research proposal (Practicality, feasibility and consistency of proposed activities with the objectives  of the call, and feasibility of the methodology provided) (15%) </strong></td></tr>

<tr>
    <td valign="top"><input name="QhighQuality" type="text" class="required number" maxlength="2" id="QhighQuality" autocomplete="off" value="<?php if($rsScore['STQhighQuality']){echo $rsScore['STQhighQuality'];}else{ echo $_POST['QhighQuality'];}?>"/> </td>
    <td valign="top"><textarea name="comment2" cols="40" rows="" id="comment2"><?php if($rsScore['EvComment2']){echo $rsScore['EvComment2'];}else{ echo $_POST['comment2'];}?></textarea> </td>
  </tr>
  
 <tr><td colspan="2"><strong>3. Added value  to expect  from  collaboration Technological  capacity  building (15%)</strong></td></tr>
  
    <tr>
    <td valign="top"><input name="SatisfactoryPartnership" type="text" class="required number" maxlength="2" id="SatisfactoryPartnership" autocomplete="off" value="<?php if($rsScore['STQSatisfactoryPartnership']){echo $rsScore['STQSatisfactoryPartnership'];}else{ echo $_POST['SatisfactoryPartnership'];}?>"/> </td>
    <td valign="top"><textarea name="comment3" cols="40" rows="" id="comment3"><?php if($rsScore['EvComment3']){echo $rsScore['EvComment3'];}else{ echo $_POST['comment3'];}?></textarea> </td>
  </tr>
  
   
  
  
  <tr><td colspan="2"><strong>4. Competence, <?php echo $lang_Expertise;?> and experience of principal investigators and relevant  scientists  / research  teams (5%)</strong></td></tr>
  
  
   <tr>
    <td valign="top"><input name="AddressIssues" type="text" class="required number" maxlength="2" id="AddressIssues" autocomplete="off" value="<?php if($rsScore['AppAddressIssues']){echo $rsScore['AppAddressIssues'];}else{ echo $_POST['AppAddressIssues'];}?>"/> </td>
    <td valign="top"><textarea name="comment4" cols="40" rows="" id="comment4"><?php if($rsScore['EvComment4']){echo $rsScore['EvComment4'];}else{ echo $_POST['comment4'];}?></textarea> </td>
  </tr>
  
  
  <tr><td colspan="2"><strong>5. Clarity of expected results (15%)</strong></td></tr>
   <tr>
    <td valign="top"><input name="ClearlyConvincingly" type="text" class="required number" maxlength="2" id="ClearlyConvincingly" autocomplete="off" value="<?php if($rsScore['ImpactClearlyConvincingly']){echo $rsScore['ImpactClearlyConvincingly'];}else{ echo $_POST['ClearlyConvincingly'];}?>"/> </td>
    <td valign="top"><textarea name="comment5" cols="40" rows="" id="comment5"><?php if($rsScore['EvComment5']){echo $rsScore['EvComment5'];}else{ echo $_POST['comment5'];}?></textarea> </td>
  </tr>
  
  <tr><td colspan="2"><strong>6. Relevance and impact of  research (Industrial Development, Technological Capacity Building, Marketing of Research Results, Agricultural Production,   Improved Health Outcomes, Economic  Growth  Improved  Livelihoods) (10%)</strong></td></tr>
  
   <tr>
    <td valign="top"><input name="GenderIssues" type="text" class="required number" maxlength="2" id="GenderIssues" autocomplete="off" value="<?php if($rsScore['ImpactGenderIssues']){echo $rsScore['ImpactGenderIssues'];}else{ echo $_POST['GenderIssues'];}?>"/></td>
    <td valign="top"><textarea name="comment6" cols="40" rows="" id="comment6"><?php if($rsScore['EvComment6']){echo $rsScore['EvComment6'];}else{ echo $_POST['comment6'];}?></textarea> </td>
  </tr>
  
  
   <tr>
     <td colspan="2"><strong>Potential to promote equity and ethics (5%)</strong></td></tr>
   
    <tr>
    <td valign="top"><input name="Potential" type="text" class="required number" maxlength="2" id="Potential" autocomplete="off" value="<?php if($rsScore['Potential']){echo $rsScore['Potential'];}else{ echo $_POST['Potential'];}?>"/></td>
    <td valign="top"><textarea name="commentnon" cols="40" rows="" id="commentnon"><?php if($rsScore['EvCommentnon']){echo $rsScore['EvCommentnon'];}else{ echo $_POST['commentnon'];}?></textarea> </td>
  </tr>
   
   <tr><td colspan="2"><strong>7. Budget (Consistency  with  the  budget  ratio  or  percentage  provided  by  the  appeal guide, Basis of  estimates - How  well the  proposed  expenses  reflect the actual  cost of the  proposed action?) (5%)</strong></td></tr>
   
     <tr>
    <td valign="top"><input name="Budget" type="text" class="required number" maxlength="2" id="Budget" autocomplete="off" value="<?php if($rsScore['Budget']){echo $rsScore['Budget'];}else{ echo $_POST['Budget'];}?>"/></td>
    <td valign="top"><textarea name="comment7" cols="40" rows="" id="comment7"><?php if($rsScore['EvComment7']){echo $rsScore['EvComment7'];}else{ echo $_POST['comment7'];}?></textarea> </td>
  </tr>
   <tr><td colspan="2"><p><strong><?php echo $lang_OverallComment;?></strong></p>
<textarea name="overallcomment" cols="40" rows="" id="commentoverall"><?php echo $rsScore['EvoverallComment'];?></textarea>
 <div class="clear"></div>
<p><strong><?php echo $lang_Verdict;?></strong></p>
<input name="Verdict" type="radio" value="Recommended for Consideration" class="required" <?php if($rsScore['Everdict']=='Recommended for Consideration'){?>checked="checked"<?php }?>/>&nbsp;&nbsp;<?php echo $lang_RecommendedforConsideration;?><br />

<input name="Verdict" type="radio" value="Not Recommended for Consideration" class="required" <?php if($rsScore['Everdict']=='Not Recommended for Consideration'){?>checked="checked"<?php }?>/>&nbsp;&nbsp;<?php echo $lang_NotRecommendedforConsideration;?>

</td></tr>
  
</table>



  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
    </div>
  </div>
  
 <div class="row success">
    <input type="submit" name="doSubmit" value="<?php echo $lang_submit_now;?>" onclick="return confirm('Are you sure you want to submit? Click OK to continue or CANCEL to save, edit and submit later.');">
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