<?php
if($_POST['doSaveData']=='Save' and $_POST['title']){

	$admin_id=$_SESSION['usrm_id'];
	$title=$mysqli->real_escape_string($_POST['title']);
	$summary=nl2br($mysqli->real_escape_string($_POST['summary']));
	$details=nl2br($mysqli->real_escape_string($_POST['details']));
	$startDate=$mysqli->real_escape_string($_POST['startDate']);
    $EndDate=$mysqli->real_escape_string($_POST['EndDate']);
	$conceptID=$mysqli->real_escape_string($_POST['conceptID']);
	$shortacronym = strtoupper(str_replace(' ', '', $_POST['shortacronym']));

if($_FILES['attachmentFile']['name']){
$attachmentFile = preg_replace('/\s+/', '_', $_FILES['attachmentFile']['name']);
$attachmentFile2 = $asrmApplctID.date("ymdh").$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachmentFile']['name']));
$targetw1 = "files/". basename($asrmApplctID.date("ymdh").preg_replace('/\s+/', '_', $_FILES['attachmentFile']['name']));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachmentFile']['tmp_name']), $targetw1);

}
	
	
	$sqlUsers="SELECT * FROM ".$prefix."grantcalls where `title`='$title' and `startDate`='$startDate' and `EndDate`='$EndDate' and category='proposals' order by grantID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers){
$sqlA2="insert into ".$prefix."grantcalls (`title`,`summary`,`details`,`attachment`,`startDate`,`EndDate`,`category`,`conceptID`,`shortacronym`,`dynamic`,`grant_adminID`) 

values('$title','$summary','$details','$attachmentFile2','$startDate','$EndDate','proposals','$conceptID','$shortacronym','No','$admin_id')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted.</p>';
echo '<meta http-equiv="Refresh" content="2; url='.$base_url.'main.php?option=CallProposals" />';
logaction("$session_fullname Submitted Call for Proposals");


require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");
require("mail_template_submit_call_proposal.php");
///Now send Email
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
$mail->FromName = "Grants Management - UNCST"; //From Name -- CHANGE --
$mail->AddReplyTo("uncstuganda@gmail.com", "Call for Proposal"); //To Address -- CHANGE --
/////////////////////////////Begin Mail Body
$mail->AddAddress("uncstuganda@gmail.com", "Call for Proposal");
//$mail->addCc('$emailUsername','Activation Link from UNCST');//
$mail->addCc('mawandammoses@gmail.com','Call for Proposal');//


$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Management - Call for Proposal";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}




}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update
if($id and $_FILES['attachmentFile']['name']){
$sqlA2="update ".$prefix."grantcalls set  `attachment`='$attachmentFile2'  where `grantID`='$id'";
$mysqli->query($sqlA2);
echo '<meta http-equiv="Refresh" content="2; url='.$base_url.'main.php?option=CallProposals" />';
}

if($id){
$sqlA2="update ".$prefix."grantcalls set  `summary`='$summary',`details`='$details',`startDate`='$startDate',`EndDate`='$EndDate',`category`='grants',`conceptID`='$conceptID' where `grantID`='$id'";
$mysqli->query($sqlA2);
echo '<meta http-equiv="Refresh" content="2; url='.$base_url.'main.php?option=CallProposals" />';
}
$message='<p class="success">Dear '.$session_fullname.', details have been submitted.</p>';
	
}//end


	


}//end post
$sqlUsers2="SELECT * FROM ".$prefix."grantcalls where `grantID`='$id' order by grantID desc";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();
?><div class="tab">

    <button class="tablinks"  onclick="openCity(event, 'conceptIntroduction')" id="defaultOpen">Submit Call for Proposals </button>

</div>

<div id="conceptIntroduction" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>

   
  <h3>Submit Call for Proposals</h3>
<?php if($message){?><div style="color:#F00; font-size:18px;"><?php echo $message;?></div><?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">

 
 <div class="container"><!--begin-->
 
 <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">Please select concept</label>
    
     <select name="conceptID" id="conceptID" required>
    <option value="">---------------------</option>

<?php
$sqlUsers24="SELECT * FROM ".$prefix."grantcalls where `category`='concepts' order by grantID desc";
$QueryUsers24 = $mysqli->query($sqlUsers24);
while($rUserInv24=$QueryUsers24->fetch_array()){?>
<option value="<?php echo $rUserInv24['grantID'];?>"><?php echo $rUserInv24['title'];?></option>
<?php }?>

</select>
    </div>
  </div>
  
  
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">1. Call Title</label>
      <input type="text" id="MyTextBox3" name="title" placeholder="Call Title.." value="<?php echo $rUserInv2['title'];?>" required>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">Short Acronym</label>
      <input type="text" id="shortacronym" name="shortacronym" placeholder="Short Name.." value="<?php echo $rUserInv2['shortacronym'];?>" required maxlength="10">
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="lname">2. Summary</label>
      <textarea id="MyTextBox4" name="summary" placeholder="summary.." style="height:150px" required><?php echo $rUserInv2['summary'];?></textarea>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="lname">3. Provide Details, (Max 250 words)</label>
      <textarea id="MyTextBox7" name="details" placeholder="Provide Details(s).." style="height:180px" required><?php echo $rUserInv2['details'];?></textarea>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">Attachment</label>
     <input name="attachmentFile" type="file" required/>
     <a href="<?php echo $base_url;?>files/<?php echo $rUserInv2['attachment'];?>" target="_blank"> <?php echo $rUserInv2['attachment'];?></a>
    </div>
  </div>
  
   
   <div class="row success">

    <div class="col-100">
    <label for="fname">Start Date</label>
      <input type="date" id="start" name="startDate" placeholder="Start Date.." class="required" value="<?php echo $rUserInv2['startDate'];?>" style="width:50%;">
    </div>
  </div>
  
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">End Date</label>
      <input type="date" id="end" name="EndDate" placeholder="End Date.." class="required" value="<?php echo $rUserInv2['EndDate'];?>" style="width:50%;">
    </div>
  </div>

  <div class="row success">
    <input type="submit" name="doSaveData" value="Save">
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
</script>