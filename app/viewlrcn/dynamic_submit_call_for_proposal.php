<?php
$admin_id=$_SESSION['usrm_id'];
$sessionusrm_id=$_SESSION['usrm_id'];
if($_POST['doSaveData'] and $id){
$publish=$mysqli->real_escape_string($_POST['publish']);
	$conceptID=$mysqli->real_escape_string($_POST['conceptID']);
	$includeconcept=$mysqli->real_escape_string($_POST['includeconcept']);
	$calltittle=$mysqli->real_escape_string($_POST['calltittle']);
	$summary=nl2br($mysqli->real_escape_string($_POST['summary']));
	$details=nl2br($mysqli->real_escape_string($_POST['details']));
	$startDate=$mysqli->real_escape_string($_POST['startDate']);
    $EndDate=$mysqli->real_escape_string($_POST['EndDate']);
	$gnt_hour=$mysqli->real_escape_string($_POST['gnt_hh'].'-'.$_POST['gnt_mm'].'-'.$_POST['gnt_ss']);
	$gnt_hour_end=$mysqli->real_escape_string($_POST['gnt_hh2'].'-'.$_POST['gnt_mm2'].'-'.$_POST['gnt_ss2']);
	
	$requirefullproposal=$mysqli->real_escape_string($_POST['requirefullproposal']);
	$shortacronym = strtoupper(str_replace(' ', '', $_POST['shortacronym']));

if($_FILES['attachmentFile']['name']){
$attachmentFile = preg_replace('/\s+/', '_', $_FILES['attachmentFile']['name']);
$attachmentFile2 = $asrmApplctID.date("ymdh").$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachmentFile']['name']));
$targetw1 = "./files/". basename($asrmApplctID.date("ymdh").preg_replace('/\s+/', '_', $_FILES['attachmentFile']['name']));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachmentFile']['tmp_name']), $targetw1);

}
	


///////////////////////////Update Call
if($id){///Means we are updating this call not adding new one



	if($includeconcept=="Yes"){
$sqltitle="SELECT * FROM ".$prefix."grantcalls where `grantID`='$conceptID' order by grantID desc limit 0,1";
$Querytitle = $mysqli->query($sqltitle);
$rowtitle=$Querytitle->fetch_array();
$totalUsers = $Querytitle->num_rows;
$title=$rowtitle['title'];	
	}

if($includeconcept=="No"){
$title=$calltittle;	
	}
	///update
if($_FILES['attachmentFile']['name']){
$sqlA2="update ".$prefix."grantcalls set  `attachment`='$attachmentFile2'  where `grantID`='$id'";
$mysqli->query($sqlA2);
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=CallProposals&id=$id'>";

}

		//////////////Update Now grantID
$sqlAUpdate="update ".$prefix."concept_dynamic_stages set `status`='old',`call_up`='1' where `grantcallID`='$id' and categorym='proposal'";
$mysqli->query($sqlAUpdate);
////Grants Table

$sqlAUpdate2="update ".$prefix."grantcall_categories set `status`='old' where `grantID`='$id' and categorym='proposal'";
//$mysqli->query($sqlAUpdate2);
/////Update sections
$sqlAUpdate22="update ".$prefix."concept_dynamic_questions_all_a set `is_sent`='1' where `grantID`='$id'";
$mysqli->query($sqlAUpdate22);

$sqlAUpdate23="update ".$prefix."concept_dynamic_questions_all_d set `is_sent`='1' where `grantID`='$id'";
$mysqli->query($sqlAUpdate23);

$sqlAUpdate24="update ".$prefix."concept_dynamic_questions_all_e set `is_sent`='1' where `grantID`='$id'";
$mysqli->query($sqlAUpdate24);

$sqlAUpdate25="update ".$prefix."concept_dynamic_questions_all_g set `is_sent`='1' where `grantID`='$id'";
$mysqli->query($sqlAUpdate25);	

$sqlAUpdate26="update ".$prefix."concept_dynamic_questions_all_h set `is_sent`='1' where `grantID`='$id'";
$mysqli->query($sqlAUpdate26);

$sqlAUpdate2y="update ".$prefix."concept_dynamic_questions_all_i set `is_sent`='1' where `grantID`='$id'";
$mysqli->query($sqlAUpdate2y);

$sqlAUpdate27y="update ".$prefix."concept_dynamic_questions_all_j set `is_sent`='1' where `grantID`='$id'";
$mysqli->query($sqlAUpdate27y);

$sqlAUpdate28y="update ".$prefix."concept_dynamic_questions_all_k set `is_sent`='1' where `grantID`='$id'";
$mysqli->query($sqlAUpdate28y);

$sqlAUpdate24cf="update ".$prefix."concept_dynamic_questions_all_f set `is_sent`='1' where `grantID`='$id'";
$mysqli->query($sqlAUpdate24cf);

$sqlA_update="update ".$prefix."grantcalls set proposal_submitted='Yes' where `grantID`='$id'";
$mysqli->query($sqlA_update);

$sqlA2="update ".$prefix."grantcalls set  `title`='$title',`summary`='$summary',`shortacronym`='$shortacronym',`conceptID`='$conceptID',`details`='$details',`startDate`='$startDate',`EndDate`='$EndDate',`category`='proposals',gnt_hour='$gnt_hour',gnt_hour_end='$gnt_hour_end',`publish`='$publish',`includeconcept`='$includeconcept',`dynamic`='Yes',`proposal_submitted`='Yes' where `grantID`='$id'";
$mysqli->query($sqlA2);



logaction("$session_fullname Submitted Call for Concept");
//Send email to Grants Amdin, creator
$sqlCreator="SELECT * FROM ".$prefix."musers where `usrm_id`='$admin_id' order by usrm_id desc limit 0,1";
$QueryCreator = $mysqli->query($sqlCreator);
$rUserCreator=$QueryCreator->fetch_array();
$adminemail=$rUserCreator['usrm_fname'].' '.$rUserCreator['usrm_sname'];
$adminusrm_email=$rUserCreator['usrm_email'];


require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");
require("viewlrcn/mail_template_submit_call_proposal.php");
///Now send Email


// PHPMailer settings
$mail = new PHPMailer(true); // important
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Port = $usmtpportNo; // SMTP Port
$mail->CharSet = "utf-8";
$mail->Host = $usmtpHost; // specify SMTP server
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = $emailSSL;
$mail->Username = "$emailUsername";
// SMTP password (your Office 365 email password)
$mail->Password = "$emailPassword";
$mail->SMTPDebug = 0;



$mail->Username = "$emailUsername"; // SMTP username -- CHANGE --
$mail->Password = "$emailPassword"; // SMTP password -- CHANGE --
$mail->setFrom("$emailUsername", "$fromName");
$mail->FromName = "$fromName"; // From Name -- CHANGE --

$mail->addBcc("$emailBcc", "Grant Management Team");

$mail->AddAddress("$emailBcc", "Grant Management Team"); // To Address -- CHANGE --
$mail->AddReplyTo("$emailBcc", $lang_grants_management_system . "-" . $lang_UserRegistration); // Reply-To Address -- CHANGE --

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$lang_grants_management_system - $lang_UserRegistration";
$body="$allSentMessage";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

echo "<meta http-equiv='REFRESH' content='5;url=$base_url/main.php?option=CallProposals&id=$id'>";
$message='<p class="success">Dear '.$session_fullname.', details have been submitted.</p>';
	
}//end


	


}//end post
$sqlUsers2="SELECT * FROM ".$prefix."grantcalls where `grantID`='$id' order by grantID desc";

$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$shcategoryID12=$rUserInv2['gnt_hour'];
$categoryChunksss = explode("-", $shcategoryID12);

$chops1="$categoryChunksss[0]";
$chops2="$categoryChunksss[1]";
$chops3="$categoryChunksss[2]";

$shcategoryIDmm=$rUserInv2['gnt_hour_end'];
$categoryChunkmm = explode("-", $shcategoryIDmm);

$chops11="$categoryChunkmm[0]";
$chops12="$categoryChunkmm[1]";
$chops13="$categoryChunkmm[2]";

//check any category
$sqlCatGrantCategoryUp="SELECT * FROM ".$prefix."concept_dynamic_stages where `grantcallID`='$id'  and categorym='proposal' and questions_up=1 order by id desc";
$AnyCategorySavedUP = $mysqli->query($sqlCatGrantCategoryUp);
$AnyCategoryRows=$AnyCategorySavedUP->fetch_array();
$AnyCategorySavedG=$AnyCategorySavedUP->num_rows;


?><div class="tab">

<?php
if($AnyCategorySavedG){?>
<button <?php if($AnyCategoryRows['categories_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=DynamicCallProposals&id=<?php echo $id;?>'"><?php echo $lang_new_SubmitProposalCategories;?> </button>
<button <?php if($AnyCategoryRows['catordering_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=DynamicCallProposalsUpdate&id=<?php echo $id;?>'"><?php echo $lang_new_UpdateOrdering;?> </button>

<button <?php if($AnyCategoryRows['questions_up']=='1'){?>class="tablinks"<?php }?> class="tablinks" onClick="window.location.href='./main.php?option=DynamicCallProposalQns&id=<?php echo $id;?>'"><?php echo $lang_new_AddQuestionsCategories;?> </button>
<button <?php if($AnyCategoryRows['call_up']=='1'){?>class="tablinks"<?php }?> onclick="openCity(event, 'SubmitCallforProposalNew')" id="defaultOpen"><?php echo $lang_new_FinishSubmkitConcept;?></button>
<?php }?>

</div>

<div id="SubmitCallforProposalNew" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>

   
  <h3><!--Submit Call for CallProposals--></h3>
<?php if($message){?><div style="color:#F00; font-size:18px;"><?php echo $message;?></div><?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">

 
 <div class="container"><!--begin-->
 
 <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
 
  <div class="row success">
  <?php echo $lang_callMain;?>

    <div class="col-100">
     <label for="fname"><input name="includeconcept" type="radio" value="No" class="required"  onChange="getIncludeProposalTitle(this.value)" <?php if($rUserInv2['includeconcept']=='No'){?>checked="checked"<?php }?>/><strong> <?php echo $lang_Yes;?></strong> <span class="error">*</span></label><br />
     <label for="fname"><input name="includeconcept" type="radio" value="Yes" class="required" onChange="getIncludeProposalTitle(this.value)" <?php if($rUserInv2['includeconcept']=='Yes'){?>checked="checked"<?php }?>/><strong> <?php echo $lang_No;?></strong> <span class="error">*</span></label>
     
     
     
     
     
    </div>
  </div>
  
  <div class="row success">
<div id="includeconceptdiv">


<?php 
if($rUserInv2['includeconcept']=='Yes'){
?><div class="col-100">
    <label for="fname"><?php echo $lang_new_CallTitle;?> </label>
<select name="conceptID" id="MyTextBox3">
<option value=""><?php echo $lang_please_select;?></option>
<?php
  ///Check for Project Title and Budget
    //check for project Title
$sqlProjectID2r_title="SELECT * FROM ".$prefix."grantcalls where `requirefullproposal`='Yes' and category='concepts' order by grantID desc limit 0,10";
$QueryProjectID2r_title = $mysqli->query($sqlProjectID2r_title);
while($rowsSubmitted_c=$QueryProjectID2r_title->fetch_array()){
?>
<option value="<?php echo $rowsSubmitted_c['grantID'];?>" <?php if($rowsSubmitted_c['grantID']==$rUserInv2['conceptID']){?>selected="selected"<?php }?>><?php echo $rowsSubmitted_c['title'];?></option>
<?php }?>
</select>
   
    </div>
    <?php }
	if($rUserInv2['includeconcept']=='No'){?>
	<div class="col-100">
    <label for="fname"><?php echo $lang_new_CallTitle;?> </label>
 <input type="text" id="calltittle" name="calltittle" placeholder="Enter call title.." value="<?php echo $rUserInv2['title'];?>">
   
    </div>
    
    <?php }?>





</div>

    
  </div>
  

  
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $lang_new_ShortAcronym;?> <span class="error">*</span></label>
      <input type="text" id="shortacronym" name="shortacronym" placeholder="Short Name.." value="<?php echo $rUserInv2['shortacronym'];?>" required maxlength="15">
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_new_Summary;?> <span class="error">*</span></label>
      <textarea id="MyTextBox4" name="summary" placeholder="summary.." style="height:150px" required><?php echo $rUserInv2['summary'];?></textarea>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_new_ProvideDetails;?> <span class="error">*</span></label>
      <textarea id="MyTextBox7" name="details" placeholder="Provide Details(s).." style="height:180px" required><?php echo $rUserInv2['details'];?></textarea>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_new_Attachment;?> <span class="error">*</span></label>
     <?php if($rUserInv2['attachment']){?><input name="attachmentFile" type="file"/><br /><?php }?>
      <?php if(!$rUserInv2['attachment']){?><input name="attachmentFile" type="file" required/><br /><?php }?>
     
     <a href="<?php echo $base_url;?>files/<?php echo $rUserInv2['attachment'];?>" target="_blank"> <?php echo $rUserInv2['attachment'];?></a>
    </div>
  </div>
  
   
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $lang_new_StartDate;?> <span class="error">*</span></label>
    
    <table width="50%" border="0">
  <tr>
    <td style="width:150px;"><input type="date" id="start" name="startDate" placeholder="Start Date.." class="form-control required" value="<?php echo $rUserInv2['startDate'];?>" style="width:150px;float:left; padding:7px;" required></td>
    <td style="width:60px;"> <select name="gnt_hh" id="dmonth" class="form-control" tabindex="6" style=" width:60px; float:left;">
    <option value="">HH</option>
    <option value="01" <?php if($chops1=='01' || $chops1=='01' || $chops1=='01'){?>selected="selected"<?php }?>>&nbsp;01</option>
   <option value="02" <?php if($chops1=='02' || $chops1=='02' || $chops1=='02'){?>selected="selected"<?php }?>>&nbsp;02</option>
   <option value="03" <?php if($chops1=='03' || $chops1=='03' || $chops1=='03'){?>selected="selected"<?php }?>>&nbsp;03</option>
   <option value="04" <?php if($chops1=='04' || $chops1=='04' || $chops1=='04'){?>selected="selected"<?php }?>>&nbsp;04</option>
   <option value="05" <?php if($chops1=='05' || $chops1=='05' || $chops1=='05'){?>selected="selected"<?php }?>>&nbsp;05</option>
   <option value="06" <?php if($chops1=='06' || $chops1=='06' || $chops1=='06'){?>selected="selected"<?php }?>>&nbsp;06</option>
   <option value="07" <?php if($chops1=='07' || $chops1=='07' || $chops1=='07'){?>selected="selected"<?php }?>>&nbsp;07</option>
   <option value="08" <?php if($chops1=='08' || $chops1=='08' || $chops1=='08'){?>selected="selected"<?php }?>>&nbsp;08</option>
   <option value="09" <?php if($chops1=='09' || $chops1=='09' || $chops1=='09'){?>selected="selected"<?php }?>>&nbsp;09</option>
   <option value="10" <?php if($chops1=='10' || $chops1=='10' || $chops1=='10'){?>selected="selected"<?php }?>>&nbsp;10</option>
   <option value="11"  <?php if($chops1=='11' || $chops1=='11' || $chops1=='11'){?>selected="selected"<?php }?>>&nbsp;11</option>
   <option value="12"  <?php if($chops1=='12' || $chops1=='12' || $chops1=='12'){?>selected="selected"<?php }?>>&nbsp;12</option>
   <option value="13"  <?php if($chops1=='13' || $chops1=='13' || $chops1=='13'){?>selected="selected"<?php }?>>&nbsp;13</option>
   <option value="14"  <?php if($chops1=='14' || $chops1=='14' || $chops1=='14'){?>selected="selected"<?php }?>>&nbsp;14</option>
   <option value="15"  <?php if($chops1=='15' || $chops1=='15' || $chops1=='15'){?>selected="selected"<?php }?>>&nbsp;15</option>
   <option value="16"  <?php if($chops1=='16' || $chops1=='16' || $chops1=='16'){?>selected="selected"<?php }?>>&nbsp;16</option>
   <option value="17"  <?php if($chops1=='17' || $chops1=='17' || $chops1=='17'){?>selected="selected"<?php }?>>&nbsp;17</option>
   <option value="18"  <?php if($chops1=='18' || $chops1=='18' || $chops1=='18'){?>selected="selected"<?php }?>>&nbsp;18</option>
   <option value="19"  <?php if($chops1=='19' || $chops1=='19' || $chops1=='19'){?>selected="selected"<?php }?>>&nbsp;19</option>
   <option value="20"  <?php if($chops1=='20' || $chops1=='20' || $chops1=='20'){?>selected="selected"<?php }?>>&nbsp;20</option>
   <option value="21"  <?php if($chops1=='21' || $chops1=='21' || $chops1=='21'){?>selected="selected"<?php }?>>&nbsp;21</option>
   <option value="22"  <?php if($chops1=='22' || $chops1=='22' || $chops1=='22'){?>selected="selected"<?php }?>>&nbsp;22</option>
   <option value="23"  <?php if($chops1=='23' || $chops1=='23' || $chops1=='23'){?>selected="selected"<?php }?>>&nbsp;23</option>
   <option value="24"  <?php if($chops1=='24' || $chops1=='24' || $chops1=='24'){?>selected="selected"<?php }?>>&nbsp;24</option>
   
  </select></td>
    <td style="width:60px;">
    <?php echo $chops;?>
    <select name="gnt_mm" id="dmonth" class="form-control" tabindex="6" style=" width:65px; float:left;">
    <option value="">MM</option>
  <option value="00" <?php if($chops2=='00' || $chops2=='00' || $chops2=='00'){?>selected="selected"<?php }?>>&nbsp;00</option>
 <option value="01" <?php if($chops2=='01' || $chops2=='01' || $chops2=='01'){?>selected="selected"<?php }?>>&nbsp;01</option>
   <option value="02" <?php if($chops2=='02' || $chops2=='02' || $chops2=='02'){?>selected="selected"<?php }?>>&nbsp;02</option>
   <option value="03" <?php if($chops2=='03' || $chops2=='03' || $chops2=='03'){?>selected="selected"<?php }?>>&nbsp;03</option>
   <option value="04" <?php if($chops2=='04' || $chops2=='04' || $chops2=='04'){?>selected="selected"<?php }?>>&nbsp;04</option>
   <option value="05" <?php if($chops2=='05' || $chops2=='05' || $chops2=='05'){?>selected="selected"<?php }?>>&nbsp;05</option>
   <option value="06" <?php if($chops2=='06' || $chops2=='06' || $chops2=='06'){?>selected="selected"<?php }?>>&nbsp;06</option>
   <option value="07" <?php if($chops2=='07' || $chops2=='07' || $chops2=='07'){?>selected="selected"<?php }?>>&nbsp;07</option>
   <option value="08" <?php if($chops2=='08' || $chops2=='08' || $chops2=='08'){?>selected="selected"<?php }?>>&nbsp;08</option>
   <option value="09" <?php if($chops2=='09' || $chops2=='09' || $chops2=='09'){?>selected="selected"<?php }?>>&nbsp;09</option>
   <option value="10" <?php if($chops2=='10' || $chops2=='10' || $chops2=='10'){?>selected="selected"<?php }?>>&nbsp;10</option>
   <option value="11"  <?php if($chops2=='11' || $chops2=='11' || $chops2=='11'){?>selected="selected"<?php }?>>&nbsp;11</option>
   <option value="12"  <?php if($chops2=='12' || $chops2=='12' || $chops2=='12'){?>selected="selected"<?php }?>>&nbsp;12</option>
   <option value="13"  <?php if($chops2=='13' || $chops2=='13' || $chops2=='13'){?>selected="selected"<?php }?>>&nbsp;13</option>
   <option value="14"  <?php if($chops2=='14' || $chops2=='14' || $chops2=='14'){?>selected="selected"<?php }?>>&nbsp;14</option>
   <option value="15"  <?php if($chops2=='15' || $chops2=='15' || $chops2=='15'){?>selected="selected"<?php }?>>&nbsp;15</option>
   <option value="16"  <?php if($chops2=='16' || $chops2=='16' || $chops2=='16'){?>selected="selected"<?php }?>>&nbsp;16</option>
   <option value="17"  <?php if($chops2=='17' || $chops2=='17' || $chops2=='17'){?>selected="selected"<?php }?>>&nbsp;17</option>
   <option value="18"  <?php if($chops2=='18' || $chops2=='18' || $chops2=='18'){?>selected="selected"<?php }?>>&nbsp;18</option>
   <option value="19"  <?php if($chops2=='19' || $chops2=='19' || $chops2=='19'){?>selected="selected"<?php }?>>&nbsp;19</option>
   <option value="20"  <?php if($chops2=='20' || $chops2=='20' || $chops2=='20'){?>selected="selected"<?php }?>>&nbsp;20</option>
   <option value="21"  <?php if($chops2=='21' || $chops2=='21' || $chops2=='21'){?>selected="selected"<?php }?>>&nbsp;21</option>
   <option value="22"  <?php if($chops2=='22' || $chops2=='22' || $chops2=='22'){?>selected="selected"<?php }?>>&nbsp;22</option>
   <option value="23"  <?php if($chops2=='23' || $chops2=='23' || $chops2=='23'){?>selected="selected"<?php }?>>&nbsp;23</option>
   <option value="24"  <?php if($chops2=='24' || $chops2=='24' || $chops2=='24'){?>selected="selected"<?php }?>>&nbsp;24</option>
   
   <option value="25" <?php if($chops2=='25' || $chops2=='25' || $chops2=='25'){?>selected="selected"<?php }?>>&nbsp;25</option>
   <option value="26" <?php if($chops2=='26' || $chops2=='26' || $chops2=='26'){?>selected="selected"<?php }?>>&nbsp;26</option>
   <option value="27" <?php if($chops2=='27' || $chops2=='27' || $chops2=='27'){?>selected="selected"<?php }?>>&nbsp;27</option>
   <option value="28" <?php if($chops2=='28' || $chops2=='28' || $chops2=='28'){?>selected="selected"<?php }?>>&nbsp;28</option>
   <option value="29" <?php if($chops2=='29' || $chops2=='29' || $chops2=='29'){?>selected="selected"<?php }?>>&nbsp;29</option>
   <option value="30" <?php if($chops2=='30' || $chops2=='30' || $chops2=='30'){?>selected="selected"<?php }?>>&nbsp;30</option>
   <option value="31" <?php if($chops2=='31' || $chops2=='31' || $chops2=='31'){?>selected="selected"<?php }?>>&nbsp;31</option>
   <option value="32" <?php if($chops2=='32' || $chops2=='32' || $chops2=='32'){?>selected="selected"<?php }?>>&nbsp;32</option>
   <option value="33" <?php if($chops2=='33' || $chops2=='33' || $chops2=='33'){?>selected="selected"<?php }?>>&nbsp;33</option>
   <option value="34" <?php if($chops2=='34' || $chops2=='34' || $chops2=='34'){?>selected="selected"<?php }?>>&nbsp;34</option>
   <option value="35" <?php if($chops2=='35' || $chops2=='35' || $chops2=='35'){?>selected="selected"<?php }?>>&nbsp;35</option>
   <option value="36" <?php if($chops2=='36' || $chops2=='36' || $chops2=='36'){?>selected="selected"<?php }?>>&nbsp;36</option>
   <option value="37" <?php if($chops2=='37' || $chops2=='37' || $chops2=='37'){?>selected="selected"<?php }?>>&nbsp;37</option>
   <option value="38" <?php if($chops2=='38' || $chops2=='38' || $chops2=='38'){?>selected="selected"<?php }?>>&nbsp;38</option>
   <option value="39" <?php if($chops2=='39' || $chops2=='39' || $chops2=='39'){?>selected="selected"<?php }?>>&nbsp;39</option>
   <option value="40" <?php if($chops2=='40' || $chops2=='40' || $chops2=='40'){?>selected="selected"<?php }?>>&nbsp;40</option>
   <option value="41" <?php if($chops2=='41' || $chops2=='41' || $chops2=='41'){?>selected="selected"<?php }?>>&nbsp;41</option>
   <option value="42" <?php if($chops2=='42' || $chops2=='42' || $chops2=='42'){?>selected="selected"<?php }?>>&nbsp;42</option>
   <option value="43" <?php if($chops2=='43' || $chops2=='43' || $chops2=='43'){?>selected="selected"<?php }?>>&nbsp;43</option>
   <option value="44" <?php if($chops2=='44' || $chops2=='44' || $chops2=='44'){?>selected="selected"<?php }?>>&nbsp;44</option>
   <option value="45" <?php if($chops2=='45' || $chops2=='45' || $chops2=='45'){?>selected="selected"<?php }?>>&nbsp;45</option>
   <option value="46" <?php if($chops2=='46' || $chops2=='46' || $chops2=='46'){?>selected="selected"<?php }?>>&nbsp;46</option>
   <option value="47" <?php if($chops2=='47' || $chops2=='47' || $chops2=='47'){?>selected="selected"<?php }?>>&nbsp;47</option>
   <option value="48" <?php if($chops2=='48' || $chops2=='48' || $chops2=='48'){?>selected="selected"<?php }?>>&nbsp;48</option>
   <option value="49" <?php if($chops2=='49' || $chops2=='49' || $chops2=='49'){?>selected="selected"<?php }?>>&nbsp;49</option>
   <option value="50" <?php if($chops2=='50' || $chops2=='50' || $chops2=='50'){?>selected="selected"<?php }?>>&nbsp;50</option>
   
   <option value="51" <?php if($chops2=='51' || $chops2=='51' || $chops2=='51'){?>selected="selected"<?php }?>>&nbsp;51</option>
   <option value="52" <?php if($chops2=='52' || $chops2=='52' || $chops2=='52'){?>selected="selected"<?php }?>>&nbsp;52</option>
   <option value="53" <?php if($chops2=='53' || $chops2=='53' || $chops2=='53'){?>selected="selected"<?php }?>>&nbsp;53</option>
   <option value="54" <?php if($chops2=='54' || $chops2=='54' || $chops2=='54'){?>selected="selected"<?php }?>>&nbsp;54</option>
   <option value="55" <?php if($chops2=='55' || $chops2=='55' || $chops2=='55'){?>selected="selected"<?php }?>>&nbsp;55</option>
   <option value="56" <?php if($chops2=='56' || $chops2=='56' || $chops2=='56'){?>selected="selected"<?php }?>>&nbsp;56</option>
   <option value="57" <?php if($chops2=='57' || $chops2=='57' || $chops2=='57'){?>selected="selected"<?php }?>>&nbsp;57</option>
   <option value="58" <?php if($chops2=='58' || $chops2=='58' || $chops2=='58'){?>selected="selected"<?php }?>>&nbsp;58</option>
   <option value="59" <?php if($chops2=='59' || $chops2=='59' || $chops2=='59'){?>selected="selected"<?php }?>>&nbsp;59</option>
   
   
  </select></td>
   <td style="width:60px;"><select name="gnt_ss" id="dmonth" class="form-control" tabindex="6" style=" width:65px; float:left;">
    <option value="">SS</option>
  <option value="00" <?php if($chops3=='00' || $chops3=='00' || $chops3=='00'){?>selected="selected"<?php }?>>&nbsp;00</option>
 <option value="01" <?php if($chops3=='01' || $chops3=='01' || $chops3=='01'){?>selected="selected"<?php }?>>&nbsp;01</option>
   <option value="02" <?php if($chops3=='02' || $chops3=='02' || $chops3=='02'){?>selected="selected"<?php }?>>&nbsp;02</option>
   <option value="03" <?php if($chops3=='03' || $chops3=='03' || $chops3=='03'){?>selected="selected"<?php }?>>&nbsp;03</option>
   <option value="04" <?php if($chops3=='04' || $chops3=='04' || $chops3=='04'){?>selected="selected"<?php }?>>&nbsp;04</option>
   <option value="05" <?php if($chops3=='05' || $chops3=='05' || $chops3=='05'){?>selected="selected"<?php }?>>&nbsp;05</option>
   <option value="06" <?php if($chops3=='06' || $chops3=='06' || $chops3=='06'){?>selected="selected"<?php }?>>&nbsp;06</option>
   <option value="07" <?php if($chops3=='07' || $chops3=='07' || $chops3=='07'){?>selected="selected"<?php }?>>&nbsp;07</option>
   <option value="08" <?php if($chops3=='08' || $chops3=='08' || $chops3=='08'){?>selected="selected"<?php }?>>&nbsp;08</option>
   <option value="09" <?php if($chops3=='09' || $chops3=='09' || $chops3=='09'){?>selected="selected"<?php }?>>&nbsp;09</option>
   <option value="10" <?php if($chops3=='10' || $chops3=='10' || $chops3=='10'){?>selected="selected"<?php }?>>&nbsp;10</option>
   <option value="11"  <?php if($chops3=='11' || $chops3=='11' || $chops3=='11'){?>selected="selected"<?php }?>>&nbsp;11</option>
   <option value="12"  <?php if($chops3=='12' || $chops3=='12' || $chops3=='12'){?>selected="selected"<?php }?>>&nbsp;12</option>
   <option value="13"  <?php if($chops3=='13' || $chops3=='13' || $chops3=='13'){?>selected="selected"<?php }?>>&nbsp;13</option>
   <option value="14"  <?php if($chops3=='14' || $chops3=='14' || $chops3=='14'){?>selected="selected"<?php }?>>&nbsp;14</option>
   <option value="15"  <?php if($chops3=='15' || $chops3=='15' || $chops3=='15'){?>selected="selected"<?php }?>>&nbsp;15</option>
   <option value="16"  <?php if($chops3=='16' || $chops3=='16' || $chops3=='16'){?>selected="selected"<?php }?>>&nbsp;16</option>
   <option value="17"  <?php if($chops3=='17' || $chops3=='17' || $chops3=='17'){?>selected="selected"<?php }?>>&nbsp;17</option>
   <option value="18"  <?php if($chops3=='18' || $chops3=='18' || $chops3=='18'){?>selected="selected"<?php }?>>&nbsp;18</option>
   <option value="19"  <?php if($chops3=='19' || $chops3=='19' || $chops3=='19'){?>selected="selected"<?php }?>>&nbsp;19</option>
   <option value="20"  <?php if($chops3=='20' || $chops3=='20' || $chops3=='20'){?>selected="selected"<?php }?>>&nbsp;20</option>
   <option value="21"  <?php if($chops3=='21' || $chops3=='21' || $chops3=='21'){?>selected="selected"<?php }?>>&nbsp;21</option>
   <option value="22"  <?php if($chops3=='22' || $chops3=='22' || $chops3=='22'){?>selected="selected"<?php }?>>&nbsp;22</option>
   <option value="23"  <?php if($chops3=='23' || $chops3=='23' || $chops3=='23'){?>selected="selected"<?php }?>>&nbsp;23</option>
   <option value="24"  <?php if($chops3=='24' || $chops3=='24' || $chops3=='24'){?>selected="selected"<?php }?>>&nbsp;24</option>
   
   <option value="25" <?php if($chops3=='25' || $chops3=='25' || $chops3=='25'){?>selected="selected"<?php }?>>&nbsp;25</option>
   <option value="26" <?php if($chops3=='26' || $chops3=='26' || $chops3=='26'){?>selected="selected"<?php }?>>&nbsp;26</option>
   <option value="27" <?php if($chops3=='27' || $chops3=='27' || $chops3=='27'){?>selected="selected"<?php }?>>&nbsp;27</option>
   <option value="28" <?php if($chops3=='28' || $chops3=='28' || $chops3=='28'){?>selected="selected"<?php }?>>&nbsp;28</option>
   <option value="29" <?php if($chops3=='29' || $chops3=='29' || $chops3=='29'){?>selected="selected"<?php }?>>&nbsp;29</option>
   <option value="30" <?php if($chops3=='30' || $chops3=='30' || $chops3=='30'){?>selected="selected"<?php }?>>&nbsp;30</option>
   <option value="31" <?php if($chops3=='31' || $chops3=='31' || $chops3=='31'){?>selected="selected"<?php }?>>&nbsp;31</option>
   <option value="32" <?php if($chops3=='32' || $chops3=='32' || $chops3=='32'){?>selected="selected"<?php }?>>&nbsp;32</option>
   <option value="33" <?php if($chops3=='33' || $chops3=='33' || $chops3=='33'){?>selected="selected"<?php }?>>&nbsp;33</option>
   <option value="34" <?php if($chops3=='34' || $chops3=='34' || $chops3=='34'){?>selected="selected"<?php }?>>&nbsp;34</option>
   <option value="35" <?php if($chops3=='35' || $chops3=='35' || $chops3=='35'){?>selected="selected"<?php }?>>&nbsp;35</option>
   <option value="36" <?php if($chops3=='36' || $chops3=='36' || $chops3=='36'){?>selected="selected"<?php }?>>&nbsp;36</option>
   <option value="37" <?php if($chops3=='37' || $chops3=='37' || $chops3=='37'){?>selected="selected"<?php }?>>&nbsp;37</option>
   <option value="38" <?php if($chops3=='38' || $chops3=='38' || $chops3=='38'){?>selected="selected"<?php }?>>&nbsp;38</option>
   <option value="39" <?php if($chops3=='39' || $chops3=='39' || $chops3=='39'){?>selected="selected"<?php }?>>&nbsp;39</option>
   <option value="40" <?php if($chops3=='40' || $chops3=='40' || $chops3=='40'){?>selected="selected"<?php }?>>&nbsp;40</option>
   <option value="41" <?php if($chops3=='41' || $chops3=='41' || $chops3=='41'){?>selected="selected"<?php }?>>&nbsp;41</option>
   <option value="42" <?php if($chops3=='42' || $chops3=='42' || $chops3=='42'){?>selected="selected"<?php }?>>&nbsp;42</option>
   <option value="43" <?php if($chops3=='43' || $chops3=='43' || $chops3=='43'){?>selected="selected"<?php }?>>&nbsp;43</option>
   <option value="44" <?php if($chops3=='44' || $chops3=='44' || $chops3=='44'){?>selected="selected"<?php }?>>&nbsp;44</option>
   <option value="45" <?php if($chops3=='45' || $chops3=='45' || $chops3=='45'){?>selected="selected"<?php }?>>&nbsp;45</option>
   <option value="46" <?php if($chops3=='46' || $chops3=='46' || $chops3=='46'){?>selected="selected"<?php }?>>&nbsp;46</option>
   <option value="47" <?php if($chops3=='47' || $chops3=='47' || $chops3=='47'){?>selected="selected"<?php }?>>&nbsp;47</option>
   <option value="48" <?php if($chops3=='48' || $chops3=='48' || $chops3=='48'){?>selected="selected"<?php }?>>&nbsp;48</option>
   <option value="49" <?php if($chops3=='49' || $chops3=='49' || $chops3=='49'){?>selected="selected"<?php }?>>&nbsp;49</option>
   <option value="50" <?php if($chops3=='50' || $chops3=='50' || $chops3=='50'){?>selected="selected"<?php }?>>&nbsp;50</option>
   
   <option value="51" <?php if($chops3=='51' || $chops3=='51' || $chops3=='51'){?>selected="selected"<?php }?>>&nbsp;51</option>
   <option value="52" <?php if($chops3=='52' || $chops3=='52' || $chops3=='52'){?>selected="selected"<?php }?>>&nbsp;52</option>
   <option value="53" <?php if($chops3=='53' || $chops3=='53' || $chops3=='53'){?>selected="selected"<?php }?>>&nbsp;53</option>
   <option value="54" <?php if($chops3=='54' || $chops3=='54' || $chops3=='54'){?>selected="selected"<?php }?>>&nbsp;54</option>
   <option value="55" <?php if($chops3=='55' || $chops3=='55' || $chops3=='55'){?>selected="selected"<?php }?>>&nbsp;55</option>
   <option value="56" <?php if($chops3=='56' || $chops3=='56' || $chops3=='56'){?>selected="selected"<?php }?>>&nbsp;56</option>
   <option value="57" <?php if($chops3=='57' || $chops3=='57' || $chops3=='57'){?>selected="selected"<?php }?>>&nbsp;57</option>
   <option value="58" <?php if($chops3=='58' || $chops3=='58' || $chops3=='58'){?>selected="selected"<?php }?>>&nbsp;58</option>
   <option value="59" <?php if($chops3=='59' || $chops3=='59' || $chops3=='59'){?>selected="selected"<?php }?>>&nbsp;59</option>
  </select></td>
  </tr>
</table>

    
      
      
     
      
    

   
    </div>
  </div>
  
  
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $lang_new_EndDate;?>  <span class="error">*</span></label>
        <table width="50%" border="0">
  <tr>
    <td style="width:150px;"><input type="date" id="start" name="EndDate" placeholder="End Date.." class="form-control required" value="<?php echo $rUserInv2['EndDate'];?>" style="width:150px;float:left; padding:7px;" required></td>
    <td style="width:60px;"> <select name="gnt_hh2" id="dmonth" class="form-control" tabindex="6" style=" width:60px; float:left;" required>
    <option value="">HH</option>
    <option value="01" <?php if($chops11=='01' || $chops11=='01' || $chops11=='01'){?>selected="selected"<?php }?>>&nbsp;01</option>
   <option value="02" <?php if($chops11=='02' || $chops11=='02' || $chops11=='02'){?>selected="selected"<?php }?>>&nbsp;02</option>
   <option value="03" <?php if($chops11=='03' || $chops11=='03' || $chops11=='03'){?>selected="selected"<?php }?>>&nbsp;03</option>
   <option value="04" <?php if($chops11=='04' || $chops11=='04' || $chops11=='04'){?>selected="selected"<?php }?>>&nbsp;04</option>
   <option value="05" <?php if($chops11=='05' || $chops11=='05' || $chops11=='05'){?>selected="selected"<?php }?>>&nbsp;05</option>
   <option value="06" <?php if($chops11=='06' || $chops11=='06' || $chops11=='06'){?>selected="selected"<?php }?>>&nbsp;06</option>
   <option value="07" <?php if($chops11=='07' || $chops11=='07' || $chops11=='07'){?>selected="selected"<?php }?>>&nbsp;07</option>
   <option value="08" <?php if($chops11=='08' || $chops11=='08' || $chops11=='08'){?>selected="selected"<?php }?>>&nbsp;08</option>
   <option value="09" <?php if($chops11=='09' || $chops11=='09' || $chops11=='09'){?>selected="selected"<?php }?>>&nbsp;09</option>
   <option value="10" <?php if($chops11=='10' || $chops11=='10' || $chops11=='10'){?>selected="selected"<?php }?>>&nbsp;10</option>
   <option value="11"  <?php if($chops11=='11' || $chops11=='11' || $chops11=='11'){?>selected="selected"<?php }?>>&nbsp;11</option>
   <option value="12"  <?php if($chops11=='12' || $chops11=='12' || $chops11=='12'){?>selected="selected"<?php }?>>&nbsp;12</option>
   <option value="13"  <?php if($chops11=='13' || $chops11=='13' || $chops11=='13'){?>selected="selected"<?php }?>>&nbsp;13</option>
   <option value="14"  <?php if($chops11=='14' || $chops11=='14' || $chops11=='14'){?>selected="selected"<?php }?>>&nbsp;14</option>
   <option value="15"  <?php if($chops11=='15' || $chops11=='15' || $chops11=='15'){?>selected="selected"<?php }?>>&nbsp;15</option>
   <option value="16"  <?php if($chops11=='16' || $chops11=='16' || $chops11=='16'){?>selected="selected"<?php }?>>&nbsp;16</option>
   <option value="17"  <?php if($chops11=='17' || $chops11=='17' || $chops11=='17'){?>selected="selected"<?php }?>>&nbsp;17</option>
   <option value="18"  <?php if($chops11=='18' || $chops11=='18' || $chops11=='18'){?>selected="selected"<?php }?>>&nbsp;18</option>
   <option value="19"  <?php if($chops11=='19' || $chops11=='19' || $chops11=='19'){?>selected="selected"<?php }?>>&nbsp;19</option>
   <option value="20"  <?php if($chops11=='20' || $chops11=='20' || $chops11=='20'){?>selected="selected"<?php }?>>&nbsp;20</option>
   <option value="21"  <?php if($chops11=='21' || $chops11=='21' || $chops11=='21'){?>selected="selected"<?php }?>>&nbsp;21</option>
   <option value="22"  <?php if($chops11=='22' || $chops11=='22' || $chops11=='22'){?>selected="selected"<?php }?>>&nbsp;22</option>
   <option value="23"  <?php if($chops11=='23' || $chops11=='23' || $chops11=='23'){?>selected="selected"<?php }?>>&nbsp;23</option>
   <option value="24"  <?php if($chops11=='24' || $chops11=='24' || $chops11=='24'){?>selected="selected"<?php }?>>&nbsp;24</option>
   
  </select></td>
    <td style="width:60px;"><select name="gnt_mm2" id="dmonth" class="form-control" tabindex="6" style=" width:65px; float:left;" required>
    <option value="">MM</option>
   <option value="00" <?php if($chops12=='00' || $chops12=='00' || $chops12=='00'){?>selected="selected"<?php }?>>&nbsp;00</option>
 <option value="01" <?php if($chops12=='01' || $chops12=='01' || $chops12=='01'){?>selected="selected"<?php }?>>&nbsp;01</option>
   <option value="02" <?php if($chops12=='02' || $chops12=='02' || $chops12=='02'){?>selected="selected"<?php }?>>&nbsp;02</option>
   <option value="03" <?php if($chops12=='03' || $chops12=='03' || $chops12=='03'){?>selected="selected"<?php }?>>&nbsp;03</option>
   <option value="04" <?php if($chops12=='04' || $chops12=='04' || $chops12=='04'){?>selected="selected"<?php }?>>&nbsp;04</option>
   <option value="05" <?php if($chops12=='05' || $chops12=='05' || $chops12=='05'){?>selected="selected"<?php }?>>&nbsp;05</option>
   <option value="06" <?php if($chops12=='06' || $chops12=='06' || $chops12=='06'){?>selected="selected"<?php }?>>&nbsp;06</option>
   <option value="07" <?php if($chops12=='07' || $chops12=='07' || $chops12=='07'){?>selected="selected"<?php }?>>&nbsp;07</option>
   <option value="08" <?php if($chops12=='08' || $chops12=='08' || $chops12=='08'){?>selected="selected"<?php }?>>&nbsp;08</option>
   <option value="09" <?php if($chops12=='09' || $chops12=='09' || $chops12=='09'){?>selected="selected"<?php }?>>&nbsp;09</option>
   <option value="10" <?php if($chops12=='10' || $chops12=='10' || $chops12=='10'){?>selected="selected"<?php }?>>&nbsp;10</option>
   <option value="11"  <?php if($chops12=='11' || $chops12=='11' || $chops12=='11'){?>selected="selected"<?php }?>>&nbsp;11</option>
   <option value="12"  <?php if($chops12=='12' || $chops12=='12' || $chops12=='12'){?>selected="selected"<?php }?>>&nbsp;12</option>
   <option value="13"  <?php if($chops12=='13' || $chops12=='13' || $chops12=='13'){?>selected="selected"<?php }?>>&nbsp;13</option>
   <option value="14"  <?php if($chops12=='14' || $chops12=='14' || $chops12=='14'){?>selected="selected"<?php }?>>&nbsp;14</option>
   <option value="15"  <?php if($chops12=='15' || $chops12=='15' || $chops12=='15'){?>selected="selected"<?php }?>>&nbsp;15</option>
   <option value="16"  <?php if($chops12=='16' || $chops12=='16' || $chops12=='16'){?>selected="selected"<?php }?>>&nbsp;16</option>
   <option value="17"  <?php if($chops12=='17' || $chops12=='17' || $chops12=='17'){?>selected="selected"<?php }?>>&nbsp;17</option>
   <option value="18"  <?php if($chops12=='18' || $chops12=='18' || $chops12=='18'){?>selected="selected"<?php }?>>&nbsp;18</option>
   <option value="19"  <?php if($chops12=='19' || $chops12=='19' || $chops12=='19'){?>selected="selected"<?php }?>>&nbsp;19</option>
   <option value="20"  <?php if($chops12=='20' || $chops12=='20' || $chops12=='20'){?>selected="selected"<?php }?>>&nbsp;20</option>
   <option value="21"  <?php if($chops12=='21' || $chops12=='21' || $chops12=='21'){?>selected="selected"<?php }?>>&nbsp;21</option>
   <option value="22"  <?php if($chops12=='22' || $chops12=='22' || $chops12=='22'){?>selected="selected"<?php }?>>&nbsp;22</option>
   <option value="23"  <?php if($chops12=='23' || $chops12=='23' || $chops12=='23'){?>selected="selected"<?php }?>>&nbsp;23</option>
   <option value="24"  <?php if($chops12=='24' || $chops12=='24' || $chops12=='24'){?>selected="selected"<?php }?>>&nbsp;24</option>
   
   <option value="25" <?php if($chops12=='25' || $chops12=='25' || $chops12=='25'){?>selected="selected"<?php }?>>&nbsp;25</option>
   <option value="26" <?php if($chops12=='26' || $chops12=='26' || $chops12=='26'){?>selected="selected"<?php }?>>&nbsp;26</option>
   <option value="27" <?php if($chops12=='27' || $chops12=='27' || $chops12=='27'){?>selected="selected"<?php }?>>&nbsp;27</option>
   <option value="28" <?php if($chops12=='28' || $chops12=='28' || $chops12=='28'){?>selected="selected"<?php }?>>&nbsp;28</option>
   <option value="29" <?php if($chops12=='29' || $chops12=='29' || $chops12=='29'){?>selected="selected"<?php }?>>&nbsp;29</option>
   <option value="30" <?php if($chops12=='30' || $chops12=='30' || $chops12=='30'){?>selected="selected"<?php }?>>&nbsp;30</option>
   <option value="31" <?php if($chops12=='31' || $chops12=='31' || $chops12=='31'){?>selected="selected"<?php }?>>&nbsp;31</option>
   <option value="32" <?php if($chops12=='32' || $chops12=='32' || $chops12=='32'){?>selected="selected"<?php }?>>&nbsp;32</option>
   <option value="33" <?php if($chops12=='33' || $chops12=='33' || $chops12=='33'){?>selected="selected"<?php }?>>&nbsp;33</option>
   <option value="34" <?php if($chops12=='34' || $chops12=='34' || $chops12=='34'){?>selected="selected"<?php }?>>&nbsp;34</option>
   <option value="35" <?php if($chops12=='35' || $chops12=='35' || $chops12=='35'){?>selected="selected"<?php }?>>&nbsp;35</option>
   <option value="36" <?php if($chops12=='36' || $chops12=='36' || $chops12=='36'){?>selected="selected"<?php }?>>&nbsp;36</option>
   <option value="37" <?php if($chops12=='37' || $chops12=='37' || $chops12=='37'){?>selected="selected"<?php }?>>&nbsp;37</option>
   <option value="38" <?php if($chops12=='38' || $chops12=='38' || $chops12=='38'){?>selected="selected"<?php }?>>&nbsp;38</option>
   <option value="39" <?php if($chops12=='39' || $chops12=='39' || $chops12=='39'){?>selected="selected"<?php }?>>&nbsp;39</option>
   <option value="40" <?php if($chops12=='40' || $chops12=='40' || $chops12=='40'){?>selected="selected"<?php }?>>&nbsp;40</option>
   <option value="41" <?php if($chops12=='41' || $chops12=='41' || $chops12=='41'){?>selected="selected"<?php }?>>&nbsp;41</option>
   <option value="42" <?php if($chops12=='42' || $chops12=='42' || $chops12=='42'){?>selected="selected"<?php }?>>&nbsp;42</option>
   <option value="43" <?php if($chops12=='43' || $chops12=='43' || $chops12=='43'){?>selected="selected"<?php }?>>&nbsp;43</option>
   <option value="44" <?php if($chops12=='44' || $chops12=='44' || $chops12=='44'){?>selected="selected"<?php }?>>&nbsp;44</option>
   <option value="45" <?php if($chops12=='45' || $chops12=='45' || $chops12=='45'){?>selected="selected"<?php }?>>&nbsp;45</option>
   <option value="46" <?php if($chops12=='46' || $chops12=='46' || $chops12=='46'){?>selected="selected"<?php }?>>&nbsp;46</option>
   <option value="47" <?php if($chops12=='47' || $chops12=='47' || $chops12=='47'){?>selected="selected"<?php }?>>&nbsp;47</option>
   <option value="48" <?php if($chops12=='48' || $chops12=='48' || $chops12=='48'){?>selected="selected"<?php }?>>&nbsp;48</option>
   <option value="49" <?php if($chops12=='49' || $chops12=='49' || $chops12=='49'){?>selected="selected"<?php }?>>&nbsp;49</option>
   <option value="50" <?php if($chops12=='50' || $chops12=='50' || $chops12=='50'){?>selected="selected"<?php }?>>&nbsp;50</option>
   
   <option value="51" <?php if($chops12=='51' || $chops12=='51' || $chops12=='51'){?>selected="selected"<?php }?>>&nbsp;51</option>
   <option value="52" <?php if($chops12=='52' || $chops12=='52' || $chops12=='52'){?>selected="selected"<?php }?>>&nbsp;52</option>
   <option value="53" <?php if($chops12=='53' || $chops12=='53' || $chops12=='53'){?>selected="selected"<?php }?>>&nbsp;53</option>
   <option value="54" <?php if($chops12=='54' || $chops12=='54' || $chops12=='54'){?>selected="selected"<?php }?>>&nbsp;54</option>
   <option value="55" <?php if($chops12=='55' || $chops12=='55' || $chops12=='55'){?>selected="selected"<?php }?>>&nbsp;55</option>
   <option value="56" <?php if($chops12=='56' || $chops12=='56' || $chops12=='56'){?>selected="selected"<?php }?>>&nbsp;56</option>
   <option value="57" <?php if($chops12=='57' || $chops12=='57' || $chops12=='57'){?>selected="selected"<?php }?>>&nbsp;57</option>
   <option value="58" <?php if($chops12=='58' || $chops12=='58' || $chops12=='58'){?>selected="selected"<?php }?>>&nbsp;58</option>
   <option value="59" <?php if($chops12=='59' || $chops12=='59' || $chops12=='59'){?>selected="selected"<?php }?>>&nbsp;59</option>
   
   
  </select></td>
   <td style="width:60px;"><select name="gnt_ss2" id="dmonth" class="form-control" tabindex="6" style=" width:65px; float:left;" required>
    <option value="">SS</option>
 <option value="00" <?php if($chops13=='00' || $chops13=='00' || $chops13=='00'){?>selected="selected"<?php }?>>&nbsp;00</option>
 <option value="01" <?php if($chops13=='01' || $chops13=='01' || $chops13=='01'){?>selected="selected"<?php }?>>&nbsp;01</option>
   <option value="02" <?php if($chops13=='02' || $chops13=='02' || $chops13=='02'){?>selected="selected"<?php }?>>&nbsp;02</option>
   <option value="03" <?php if($chops13=='03' || $chops13=='03' || $chops13=='03'){?>selected="selected"<?php }?>>&nbsp;03</option>
   <option value="04" <?php if($chops13=='04' || $chops13=='04' || $chops13=='04'){?>selected="selected"<?php }?>>&nbsp;04</option>
   <option value="05" <?php if($chops13=='05' || $chops13=='05' || $chops13=='05'){?>selected="selected"<?php }?>>&nbsp;05</option>
   <option value="06" <?php if($chops13=='06' || $chops13=='06' || $chops13=='06'){?>selected="selected"<?php }?>>&nbsp;06</option>
   <option value="07" <?php if($chops13=='07' || $chops13=='07' || $chops13=='07'){?>selected="selected"<?php }?>>&nbsp;07</option>
   <option value="08" <?php if($chops13=='08' || $chops13=='08' || $chops13=='08'){?>selected="selected"<?php }?>>&nbsp;08</option>
   <option value="09" <?php if($chops13=='09' || $chops13=='09' || $chops13=='09'){?>selected="selected"<?php }?>>&nbsp;09</option>
   <option value="10" <?php if($chops13=='10' || $chops13=='10' || $chops13=='10'){?>selected="selected"<?php }?>>&nbsp;10</option>
   <option value="11"  <?php if($chops13=='11' || $chops13=='11' || $chops13=='11'){?>selected="selected"<?php }?>>&nbsp;11</option>
   <option value="12"  <?php if($chops13=='12' || $chops13=='12' || $chops13=='12'){?>selected="selected"<?php }?>>&nbsp;12</option>
   <option value="13"  <?php if($chops13=='13' || $chops13=='13' || $chops13=='13'){?>selected="selected"<?php }?>>&nbsp;13</option>
   <option value="14"  <?php if($chops13=='14' || $chops13=='14' || $chops13=='14'){?>selected="selected"<?php }?>>&nbsp;14</option>
   <option value="15"  <?php if($chops13=='15' || $chops13=='15' || $chops13=='15'){?>selected="selected"<?php }?>>&nbsp;15</option>
   <option value="16"  <?php if($chops13=='16' || $chops13=='16' || $chops13=='16'){?>selected="selected"<?php }?>>&nbsp;16</option>
   <option value="17"  <?php if($chops13=='17' || $chops13=='17' || $chops13=='17'){?>selected="selected"<?php }?>>&nbsp;17</option>
   <option value="18"  <?php if($chops13=='18' || $chops13=='18' || $chops13=='18'){?>selected="selected"<?php }?>>&nbsp;18</option>
   <option value="19"  <?php if($chops13=='19' || $chops13=='19' || $chops13=='19'){?>selected="selected"<?php }?>>&nbsp;19</option>
   <option value="20"  <?php if($chops13=='20' || $chops13=='20' || $chops13=='20'){?>selected="selected"<?php }?>>&nbsp;20</option>
   <option value="21"  <?php if($chops13=='21' || $chops13=='21' || $chops13=='21'){?>selected="selected"<?php }?>>&nbsp;21</option>
   <option value="22"  <?php if($chops13=='22' || $chops13=='22' || $chops13=='22'){?>selected="selected"<?php }?>>&nbsp;22</option>
   <option value="23"  <?php if($chops13=='23' || $chops13=='23' || $chops13=='23'){?>selected="selected"<?php }?>>&nbsp;23</option>
   <option value="24"  <?php if($chops13=='24' || $chops13=='24' || $chops13=='24'){?>selected="selected"<?php }?>>&nbsp;24</option>
   
   <option value="25" <?php if($chops13=='25' || $chops13=='25' || $chops13=='25'){?>selected="selected"<?php }?>>&nbsp;25</option>
   <option value="26" <?php if($chops13=='26' || $chops13=='26' || $chops13=='26'){?>selected="selected"<?php }?>>&nbsp;26</option>
   <option value="27" <?php if($chops13=='27' || $chops13=='27' || $chops13=='27'){?>selected="selected"<?php }?>>&nbsp;27</option>
   <option value="28" <?php if($chops13=='28' || $chops13=='28' || $chops13=='28'){?>selected="selected"<?php }?>>&nbsp;28</option>
   <option value="29" <?php if($chops13=='29' || $chops13=='29' || $chops13=='29'){?>selected="selected"<?php }?>>&nbsp;29</option>
   <option value="30" <?php if($chops13=='30' || $chops13=='30' || $chops13=='30'){?>selected="selected"<?php }?>>&nbsp;30</option>
   <option value="31" <?php if($chops13=='31' || $chops13=='31' || $chops13=='31'){?>selected="selected"<?php }?>>&nbsp;31</option>
   <option value="32" <?php if($chops13=='32' || $chops13=='32' || $chops13=='32'){?>selected="selected"<?php }?>>&nbsp;32</option>
   <option value="33" <?php if($chops13=='33' || $chops13=='33' || $chops13=='33'){?>selected="selected"<?php }?>>&nbsp;33</option>
   <option value="34" <?php if($chops13=='34' || $chops13=='34' || $chops13=='34'){?>selected="selected"<?php }?>>&nbsp;34</option>
   <option value="35" <?php if($chops13=='35' || $chops13=='35' || $chops13=='35'){?>selected="selected"<?php }?>>&nbsp;35</option>
   <option value="36" <?php if($chops13=='36' || $chops13=='36' || $chops13=='36'){?>selected="selected"<?php }?>>&nbsp;36</option>
   <option value="37" <?php if($chops13=='37' || $chops13=='37' || $chops13=='37'){?>selected="selected"<?php }?>>&nbsp;37</option>
   <option value="38" <?php if($chops13=='38' || $chops13=='38' || $chops13=='38'){?>selected="selected"<?php }?>>&nbsp;38</option>
   <option value="39" <?php if($chops13=='39' || $chops13=='39' || $chops13=='39'){?>selected="selected"<?php }?>>&nbsp;39</option>
   <option value="40" <?php if($chops13=='40' || $chops13=='40' || $chops13=='40'){?>selected="selected"<?php }?>>&nbsp;40</option>
   <option value="41" <?php if($chops13=='41' || $chops13=='41' || $chops13=='41'){?>selected="selected"<?php }?>>&nbsp;41</option>
   <option value="42" <?php if($chops13=='42' || $chops13=='42' || $chops13=='42'){?>selected="selected"<?php }?>>&nbsp;42</option>
   <option value="43" <?php if($chops13=='43' || $chops13=='43' || $chops13=='43'){?>selected="selected"<?php }?>>&nbsp;43</option>
   <option value="44" <?php if($chops13=='44' || $chops13=='44' || $chops13=='44'){?>selected="selected"<?php }?>>&nbsp;44</option>
   <option value="45" <?php if($chops13=='45' || $chops13=='45' || $chops13=='45'){?>selected="selected"<?php }?>>&nbsp;45</option>
   <option value="46" <?php if($chops13=='46' || $chops13=='46' || $chops13=='46'){?>selected="selected"<?php }?>>&nbsp;46</option>
   <option value="47" <?php if($chops13=='47' || $chops13=='47' || $chops13=='47'){?>selected="selected"<?php }?>>&nbsp;47</option>
   <option value="48" <?php if($chops13=='48' || $chops13=='48' || $chops13=='48'){?>selected="selected"<?php }?>>&nbsp;48</option>
   <option value="49" <?php if($chops13=='49' || $chops13=='49' || $chops13=='49'){?>selected="selected"<?php }?>>&nbsp;49</option>
   <option value="50" <?php if($chops13=='50' || $chops13=='50' || $chops13=='50'){?>selected="selected"<?php }?>>&nbsp;50</option>
   
   <option value="51" <?php if($chops13=='51' || $chops13=='51' || $chops13=='51'){?>selected="selected"<?php }?>>&nbsp;51</option>
   <option value="52" <?php if($chops13=='52' || $chops13=='52' || $chops13=='52'){?>selected="selected"<?php }?>>&nbsp;52</option>
   <option value="53" <?php if($chops13=='53' || $chops13=='53' || $chops13=='53'){?>selected="selected"<?php }?>>&nbsp;53</option>
   <option value="54" <?php if($chops13=='54' || $chops13=='54' || $chops13=='54'){?>selected="selected"<?php }?>>&nbsp;54</option>
   <option value="55" <?php if($chops13=='55' || $chops13=='55' || $chops13=='55'){?>selected="selected"<?php }?>>&nbsp;55</option>
   <option value="56" <?php if($chops13=='56' || $chops13=='56' || $chops13=='56'){?>selected="selected"<?php }?>>&nbsp;56</option>
   <option value="57" <?php if($chops13=='57' || $chops13=='57' || $chops13=='57'){?>selected="selected"<?php }?>>&nbsp;57</option>
   <option value="58" <?php if($chops13=='58' || $chops13=='58' || $chops13=='58'){?>selected="selected"<?php }?>>&nbsp;58</option>
   <option value="59" <?php if($chops13=='59' || $chops13=='59' || $chops13=='59'){?>selected="selected"<?php }?>>&nbsp;59</option>
   
  </select></td>
  </tr>
</table>
    </div>
  </div>
  <div class="row success">

    <div class="col-100" style="font-size:18px; font-weight:bold;">
    <label for="fname"><?php echo $lang_publish;?>  <span class="error">*</span></label>
     <input name="publish" type="radio" value="Yes" class="" required <?php if($rUserInv2['publish']=='Yes'){?>checked="checked"<?php }?>/> <?php echo $lang_Yes;?>
     <input name="publish" type="radio" value="No" class="" required <?php if($rUserInv2['publish']=='No'){?>checked="checked"<?php }?>/> <?php echo $lang_No;?>
    </div>
  </div>

    <input type="submit" name="doSaveData" style="margin-left:20px; background:#F93;" value="<?php echo $lang_new_FinishSubmit;?>">
    <input type="submit" name="doSaveData" value="<?php echo $lang_new_Save;?>">
  </div>
  
</div><!--End-->


</form>

<?php //}?>





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
</script>