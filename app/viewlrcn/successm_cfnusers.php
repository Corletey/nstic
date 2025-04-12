	<?php
if($_POST['doRegister']=='Add User'){
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
define ("MAX_SIZE","400");
 $errors=0;

$image =$_FILES["profilepic"]["name"];
 $uploadedfile = $_FILES['profilepic']['tmp_name'];

  if ($image) 
  {
  $filename = stripslashes($_FILES['profilepic']['name']);
  $extension = getExtension($filename);
  $extension = strtolower($extension);
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
  {
echo ' Unknown Image extension ';
$errors=1;
  }
 else
{
   $size=filesize($_FILES['profilepic']['tmp_name']);
 
if ($size > MAX_SIZE*6024)
{
 echo "You have exceeded the size limit";
 $errors=1;
}
 
if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['profilepic']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
$uploadedfile = $_FILES['profilepic']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}
 
list($width,$height)=getimagesize($uploadedfile);
//image
$newwidth=160;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);

//thumbnail
$newwidth1=80;
$newheight1=($height/$width)*$newwidth1;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,

 $width,$height);

imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1, 

$width,$height);

//$no=rand(1000,0000);
$hp="nstip_";
$newname=$hp.$image;

$filename = "files/photos/". $newname;
$filename1 = "files/photos/thumb_". $newname;

imagejpeg($tmp,$filename,100);
imagejpeg($tmp1,$filename1,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);


}
}
	$username=$mysqli->real_escape_string($_POST['username']);
	$usrm_username=$mysqli->real_escape_string($_POST['usrm_username']);
	$fname=$mysqli->real_escape_string($_POST['fname']);
	$sname=$mysqli->real_escape_string($_POST['sname']);
	$Nationality=$mysqli->real_escape_string($_POST['Nationality']);
	$phone=$mysqli->real_escape_string($_POST['phone']);
	$email=$mysqli->real_escape_string($_POST['email']);
	$Gender=$mysqli->real_escape_string($_POST['Gender']);
	$Qualifications=$mysqli->real_escape_string($_POST['Qualifications']);
	$master2=md5($_POST['email']);///md5 email
	$Institution=$mysqli->real_escape_string($_POST['Institution']);
	$usrm_usrtype=$mysqli->real_escape_string($_POST['usrm_usrtype']);
	
	$date=$mysqli->real_escape_string($_POST['date']);
	$month=$mysqli->real_escape_string($_POST['month']);
	$yearm=$mysqli->real_escape_string($_POST['yearm']);
	$dob=($yearm.'-'.$month.'-'.$date);
	
	$ipaddress=$_SERVER['REMOTE_ADDR'];
	$md5pass=md5($mysqli->real_escape_string($_POST['pwd']));
	$NotPassword=$mysqli->real_escape_string($_POST['pwd']);
	
	$hostmain  = $_SERVER['HTTP_HOST'];
    $host_upper = strtoupper($host);
    $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	

	$length=25;
    $refNo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	
	$sqlUsers="SELECT * FROM ".$prefix."musers where `usrm_email`='$email' and `usrm_username`='$usrm_username'";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		
		if($totalUsers){
		
			echo $message='<p class="error">Username <b>'.$usrm_username.'</b> already exists';


		}
		
		
		if(!$totalUsers){
$sqlA2="insert into ".$prefix."musers (`usrm_username`,`usrm_NameofInstitution`,`usrm_fname`,`usrm_sname`,`usrm_Nationality`,`usrm_password`,`usrm_phone`,`usrm_email`,`usrm_updated`,`usrm_approved`,`usrm_usrtype`,`usrm_profilepic`,`usrm_no`,`usrm_gender`,`usrm_Qualification`,`usrm_dob`) values('$usrm_username','$Institution','$fname','$sname','$Nationality','$md5pass','$phone','$email',now(),'1','$usrm_usrtype','$newname','$master2','$Gender','$Qualifications','$dob')";
$mysqli->query($sqlA2);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

$mail->AddAddress($email, $fname); //To Address -- CHANGE --
$mail->AddReplyTo("$emailUsername", "$sitename-User Registration"); //Reply-To Address -- CHANGE --

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$sitename - User Registration";
$body="Hello $fname,<br>
An account has been created for you on $sitename. Please click the link below to login or copy and paste link in your browser.</p>
After Registration Confirmation, you can proceed to login<br><br>

Username: $usrm_username<br>
Password: $NotPassword<br><br>
<p><u>$sitename</u><br>
$fulladdress
$base_url
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$sqlA = "INSERT INTO ".$prefix."mlogs (log_details, logname, logemail,logip,logdate) VALUES('A new user called $fname has been added by $session_fullname', '".$_SESSION['mmfullname']."', '$email','',now())";
//$mysqli->query($sqlA);	

$message='<p class="success">Dear, this account has been successfully created, you can check your email for details. Thank you';

		}



}//end post



?>
 <!-- Main content -->
 
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6sss">
                            <!-- general form elements -->  
                            <div class="box box-primaryss">
                                <div class="box-header">
                                    <h3 class="box-title">&nbsp;&nbsp;Login Details</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                              
                                    <div class="box-body">
<?php echo $message;?><br /><br />

<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=Users'"/>
</div>
</div>
</div>
</div>


