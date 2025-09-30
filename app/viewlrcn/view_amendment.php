<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];


$actionConcept=$mysqli->real_escape_string($_POST['actionConcept']);
if($_POST['doSaveData'] and $actionConcept=='RejectConcept' and $id and $sessionusrm_id){
$comments=$mysqli->real_escape_string($_POST['comments']);
$projectIDm=$mysqli->real_escape_string($_POST['projectIDm']);
$owner_idm=$mysqli->real_escape_string($_POST['owner_idm']);
$rejectcomments=$mysqli->real_escape_string($_POST['rejectcomments']);

$wmproject="select * from ".$prefix."submissions_proposals where  projectID='$projectIDm' order by projectID desc";
$cmdwbproject = $mysqli->query($wmproject);
$SubmittedProject=$cmdwbproject->num_rows;
$rproject= $cmdwbproject->fetch_array();
$rstug_rsch_project_title=$rproject['projectTitle'];
$referenceNo=$rproject['referenceNo'];


$wmuser="select * from ".$prefix."musers where  usrm_id='$owner_idm'";
$cmdwbser = $mysqli->query($wmuser);
$rcmdwbser= $cmdwbser->fetch_array();
$dbfirstname=$rcmdwbser['usrm_fname'];
$dbsurname=$rcmdwbser['usrm_sname'];
$email=$rcmdwbser['usrm_email'];

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");
require("viewlrcn/mail_template_reject_amendment.php"); 

///Now send Email
$mail1="$emailUsername";
$mail2=$email;//sender, original creator

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
$mail->AddReplyTo($email, $dbfirstname); //To Address -- CHANGE --
$mail->AddAddress($email, $dbfirstname);
/////////////////////////////Begin Mail Body
//$mail->addCc('$emailUsername','Activation Link from UNCST');//
$mail->addBcc("$emailBcc",'Grants Management');//
//$mail->addBcc('i.makhuwa@uncst.go.ug','Final Submission');//
$mail->addCc("mawandammoses@gmail.com",$admin_dbsurname);
//$mail->addBcc('sgcigrants.uncst.go.ug','$sitename');

//$mail->addBcc('rmgtonline@uncst.go.ug','Research Team');
//rsch_project_REC

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Management - $lang_Rejected";
echo $body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}


$sqlAmendmentupdate="update ".$prefix."amendments set projectStatus='Rejected',comments='$rejectcomments' where `projectID`='$id'";
$mysqli->query($sqlAmendmentupdate);


logaction("$session_fullname Rejected Amendment");		


}//end post

if($_POST['doSaveData'] and $actionConcept=='ApproveConcept' and $id and $sessionusrm_id){
$comments=$mysqli->real_escape_string($_POST['comments']);
$projectIDm=$mysqli->real_escape_string($_POST['projectIDm']);
$owner_idm=$mysqli->real_escape_string($_POST['owner_idm']);
$rejectcomments=$mysqli->real_escape_string($_POST['rejectcomments']);

$wmproject="select * from ".$prefix."submissions_proposals where  projectID='$projectIDm' order by projectID desc";
$cmdwbproject = $mysqli->query($wmproject);
$SubmittedProject=$cmdwbproject->num_rows;
$rproject= $cmdwbproject->fetch_array();
$rstug_rsch_project_title=$rproject['projectTitle'];
$referenceNo=$rproject['referenceNo'];


$wmuser="select * from ".$prefix."musers where  usrm_id='$owner_idm'";
$cmdwbser = $mysqli->query($wmuser);
$rcmdwbser= $cmdwbser->fetch_array();
$dbfirstname=$rcmdwbser['usrm_fname'];
$dbsurname=$rcmdwbser['usrm_sname'];
$email=$rcmdwbser['usrm_email'];

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");
require("viewlrcn/mail_template_approve_amendment.php"); 

///Now send Email
$mail1="$emailUsername";
$mail2=$email;//sender, original creator

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
$mail->AddReplyTo($email, $dbfirstname); //To Address -- CHANGE --
$mail->AddAddress($email, $dbfirstname);
/////////////////////////////Begin Mail Body
//$mail->addCc('$emailUsername','Activation Link from UNCST');//
$mail->addBcc("$emailBcc",'Grants Management');//
//$mail->addBcc('i.makhuwa@uncst.go.ug','Final Submission');//
$mail->addCc("mawandammoses@gmail.com",$admin_dbsurname);
//$mail->addBcc('sgcigrants.uncst.go.ug','$sitename');

//$mail->addBcc('rmgtonline@uncst.go.ug','Research Team');
//rsch_project_REC

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Management - $lang_Approved";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}


$sqlAmendmentupdate="update ".$prefix."amendments set projectStatus='Approved' where `projectID`='$id'";
$mysqli->query($sqlAmendmentupdate);


logaction("$session_fullname Rejected Amendment");		


}//end post

if(isset($message)){echo $message;}
$wmConfirm2="select * from ".$prefix."amendments where  id='$id' order by id desc";
$cmdwbConfirm2 = $mysqli->query($wmConfirm2);
$rConfirm2= $cmdwbConfirm2->fetch_array();
$projectID=$rConfirm2['projectID'];
$owner_id=$rConfirm2['owner_id'];
?>
<div class="tab">

  <button onclick="openCity(event, 'submitProgressReport')" id="defaultOpen"><?php echo $lang_SubmitAmendments;?></button>

 
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
   
   new_row.cells[8].getElementsByTagName('input')[0].removeAttribute('style');
	

	
    x.appendChild( new_row );
}

function deleteRow(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable').deleteRow(-1);
	//document.getElementById("myTable").deleteRow(0);
}


function insRow2()
{
    console.log( 'hi');
    var x=document.getElementById('POITable2');
    var new_row = x.rows[1].cloneNode(true);
    var len = x.rows.length;
    new_row.cells[0].innerHTML = len;
    
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.value = '';
   
   new_row.cells[3].getElementsByTagName('input')[0].removeAttribute('style');
	

	
    x.appendChild( new_row );
}

function deleteRow2(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable2').deleteRow(-1);
	//document.getElementById("myTable").deleteRow(0);
}
</script>
 
  
 
  
</div>

<div id="submitProgressReport" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   
  <h3><?php echo $lang_new_ProjectInformation;?></h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="asrmApplctID" value="<?php echo $sessionusrm_id;?>" >

 <div class="container"><!--begin-->
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>

  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $lang_ProjectTitle;?> <span class="error">*</span></label><br />

       <?php
$sqlFeaturedCall = "SELECT * FROM ".$prefix."submissions_proposals where projectID='$projectID' order by projectID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
$rFeaturedCall = $queryFeaturedCall->fetch_array();
?>
<?php echo $rFeaturedCall['projectTitle'];?>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $lang_Details;?> <span class="error">*</span></label><br />
<?php echo $rConfirm2['Details'];?>
    </div>
  </div>

  <div class="row success">
    <p><?php echo $one_Attachment_perRow;?></p>

<table width="100%" border="0" id="POITable2" class="customers3">
        <tr>
            <th style="">&nbsp;</th>
            <th><?php echo $lang_nameof_attachment;?></th>
       <th><?php echo $lang_Attachments;?></th>
          </tr>
         
        
                <?php
$count=0;
$sqlUsers24="SELECT * FROM ".$prefix."amendments_attachments where `projectID`='$projectID' order by id desc limit 0,40";//conceptID='$conceptID'
$QueryUsers24 = $mysqli->query($sqlUsers24);
while($rUserInv24=$QueryUsers24->fetch_array()){
	$count++;
?>
 <tr>
            <td><?php echo $count;?></td>
<td><?php echo $rUserInv24['AttachmentName'];?></td>

<td><a href="./files/<?php echo $rUserInv24['Attachment'];?>" target="_blank"><?php echo $rUserInv24['Attachment'];?></a></td>
          </tr>   <?php }?>  
    </table>
    
  </div>
  
    <div class="row success">

    <div class="col-100">
     <label for="fname"><input name="actionConcept" type="radio" value="ApproveConcept" class="required"  onChange="getApproveReject(this.value)"/><strong> <?php echo $lang_AcceptConcept;?></strong> <span class="error">*</span></label><br />
     <label for="fname"><input name="actionConcept" type="radio" value="RejectConcept" class="required" onChange="getApproveReject(this.value)"/><strong> <?php echo $lang_RejectConceptwithcomments;?></strong> <span class="error">*</span></label>
    </div>
  </div>
  

    <div class="row success">
    <input name="owner_idm" type="hidden" value="<?php echo $owner_id;?>"/>
    <input name="projectIDm" type="hidden" value="<?php echo $projectID;?>"/>

    <div class="col-100">
<div id="approverejectdiv"></div>
    </div>
  </div>
  
   <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="<?php echo $lang_new_Save;?>">
  </div>
 
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