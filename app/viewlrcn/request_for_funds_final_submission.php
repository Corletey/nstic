
<div class="tab">

  <button class="tablinks" onclick="openCity(event, 'requestFunds')" id="defaultOpen">Request for Funds</button>

  
</div>

<script>
function deleteRow(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable').deleteRow(-1);
	//document.getElementById("myTable").deleteRow(0);
}


function insRow()
{
    console.log( 'hi');
    var x=document.getElementById('POITable');
    var new_row = x.rows[1].cloneNode(true);
    var len = x.rows.length;
    new_row.cells[0].innerHTML = len;
    
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.value = '';
	/**/var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = '';
    
	var inp3 = new_row.cells[3].getElementsByTagName('input')[0];
    inp3.id += len;
    inp3.value = '';
	
	new_row.cells[4].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
}
</script>




<div id="requestFundsss" class="tabcontentss">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  

    
  <h3>Request for Funds </h3>

 <?php
$sessionusrm_id=$_SESSION['usrm_id'];
$grantID=$mysqli->real_escape_string($_GET['grantID']);
if($category=='RequestforFundsFinal' and $id and $sessionusrm_id and $grantID){

$wProposal="select * from ".$prefix."submissions_proposals where projectID='$id'";
$cmProposal = $mysqli->query($wProposal);
$rUProposal=$cmProposal->fetch_array();
$rconceptID=$rUProposal['conceptID'];

$rowner_id=$rUProposal['owner_id'];
$wpi="select * from ".$prefix."musers where usrm_id='$sessionusrm_id'";
$cmpi = $mysqli->query($wpi);
$rpi=$cmpi->fetch_array();

$public_title=$rUProposal['projectTitle'];
$dbfirstname=$rpi['usrm_fname'];
$dbsurname=$rpi['usrm_sname'];
$email=$rpi['usrm_email'];

$sqlUsers="SELECT * FROM ".$prefix."request_for_funds_main where `projectID`='$id' and owner_id='$sessionusrm_id' and grantID='$grantID' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
$TotalFunds=$QueryUsers->num_rows;
$rpData=$QueryUsers->fetch_array();
$TotalBudget=numberformat($rpData['BudgetItem']);
$currency=$rpData['currency'];

if($TotalBudget>1){
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 
require("mail_template_send_budget.php"); 
///Now send Email
$mail1="$emailUsername";
$mail2=$email;//sender, original creator

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
  $mail->setFrom("$emailUsername", "Grants Management");
$mail->AddReplyTo($email, $dbfirstname); //To Address -- CHANGE --
$mail->AddAddress($email, $dbfirstname);
/////////////////////////////Begin Mail Body
//$mail->addCc('$emailUsername','Activation Link from UNCST');//
//$mail->addBcc('i.makhuwa@uncst.go.ug','Final Submission');//
$mail->addCc("$emailBcc",'Request for Funds');
//$mail->addBcc('sgcigrants.uncst.go.ug','$sitename');

//$mail->addBcc('rmgtonline@uncst.go.ug','Research Team');
//rsch_project_REC

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Management - $public_title";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

$sqlA2="update ".$prefix."request_for_funds set  `actionStatus`='Submitted',`is_sent`='1' where owner_id='$sessionusrm_id' and `projectID`='$id' and grantID='$grantID'";
$mysqli->query($sqlA2);

$sqlA22="update ".$prefix."request_for_funds_main set  `actionOnRequest`='Submitted',`is_sent`='1' where owner_id='$sessionusrm_id' and `projectID`='$id' and grantID='$grantID'";
$mysqli->query($sqlA22);

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=dashboard'>";

}//end Total Budget Great
}//end post
?>
 
 
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