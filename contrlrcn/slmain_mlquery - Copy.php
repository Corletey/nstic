<?php
//$Auth = new Auth();
////////////////Begin Table Prefix////////////////////////////////////////////////

$photos_folder="images/photos/";
$requsitions_folder="../files/requsitions/";
////////////////End Table Prefix///////////////////////////////////////////////////

function numberformat($nvalue)
{   
	$returnno=number_format($nvalue,0);  
	return $returnno;
}
//////////////////////////////////////////////////////////////////////////////////////////
function EscapeString($evalue)
{
$returnES=mysql_real_escape_string($evalue);
return $returnES;	
}
///////////////////////date/////////////////
function dateformat($date,$format="")
{
	$default_format="l dS F, Y";
	$format=($format)?$format:$default_format;
	
$new_date=new DateTime($date);
$new_date=$new_date->format($format);

return $new_date;
	
}

function Error($errorvalue)
{
$returnerrorVal=print(mysql_error($errorvalue));
return $returnerrorVal;	
}

if ($_POST['doLogin'])
{//=="$lang_Signmein"

		$name = $mysqli->real_escape_string($_POST['name']);
		$md5pass = md5($mysqli->real_escape_string($_POST['pwd']));

		$sqlUser = "SELECT * FROM ".$prefix."musers where usrm_username='$name' and usrm_password='$md5pass'";
		$queryUser = $mysqli->query($sqlUser);
       $totalUser = $queryUser->num_rows;
        $r = $queryUser->fetch_array();
	
		$dbusrm_id=$r['usrm_id'];
		$dbprdffullname=$r['usrm_fname'];
		$dbusrm_email=$r['usrm_email'];
		$dbusrm_password=$r['usrm_password'];
		$dbusrm_username=$r['usrm_username'];
		$dbusrm_approved=$r['usrm_approved'];
		$dbusrm_usrtype=$r['usrm_usrtype'];
		$dbsentNotify=$r['sentNotify'];
//////////////////////////////////////////////////////////////////////////////////////////////////////////


		if($totalUser==1 && $dbusrm_approved=="1"){ 
		$_SESSION['usrm_username']=$dbusrm_username;
		$_SESSION['usrm_email']=$dbusrm_email;
		$_SESSION['usrm_id']=$dbusrm_id;
		$_SESSION['usrm_usrtype']=$dbusrm_usrtype;
		$_SESSION['mmfullname']=$dbprdffullname;	


//////////////////record action//////////////////////////////////////
$sqlA = "INSERT INTO ".$prefix."logs(lg_action, lg_user, lg_user_level,lg_time) VALUES('$dbusrm_username Logged in from $usersipaddress', '".$_SESSION['mmfullname']."', '".$_SESSION['usrm_usrtype']."','$dateSubmitted')";
$mysqli->query($sqlA);
echo("<script>location.href = './app/main.php?option=dashboard';</script>");
//header("location:./data/dashboard/");

		}
		
		if($totalUser==1 && $dbusrm_approved=="1" and $dbusrm_usrtype=='reviewer'){
			$err2='<span class="error"> </span>';
			}
		else {
$err2="$lang_wrong_username";
		
		
			}
					}//end if post
			

$category=$mysqli->real_escape_string($_GET['option']);
$pd=$mysqli->real_escape_string($_GET['mdc']);
$id=$mysqli->real_escape_string($_GET['id']);
$bt=$mysqli->real_escape_string($_GET['bt']);
$c=$mysqli->real_escape_string($_GET['c']);
$n=$mysqli->real_escape_string($_GET['n']);
$bkey=$mysqli->real_escape_string($_GET['bkey']);
$bmw=$mysqli->real_escape_string($_GET['bmw']);
$address=$_SERVER['REQUEST_URI'];

///////////////////Begin main link/////////////////
function main($MainLink)
{
	global $category; 
	echo $mlink="main.php?option=";
}
///////////////////End main link/////////////////

//////////////sessions//////////////////////////////////////////////////////////////////////////
		$usrm_username=$_SESSION['usrm_username'];
		$usrm_id=$_SESSION['usrm_id'];
		$session_usertype=$_SESSION['usrm_usrtype'];
		$session_fullname=$_SESSION['mmfullname'];
        $cfn_organisation=$_SESSION['cfn_organisation'];

///////////end sessions/////////////////////////////////////////////////////////////////////////

function authent($value)
{  global  $cac_role,$cm,$mdc;
	if($cac_role==$cm OR $cac_role==$mdc)
	{
	return($value);
	}
}

$queryMyLogged="select * from ".$prefix."musers where usrm_username='$usrm_username'";
$rs_MyLogged=$mysqli->query($queryMyLogged);
$rsLoggedMy=$rs_MyLogged->fetch_array();
$usrrsmyLoggedIdm=$rsLoggedMy['usrm_id'];

////////Begin time out////////////////////////////////////////////////////////////////////////////
function timeout($timeout)
				{
    global $usrm_username,$usrm_id,$session_usertype,$session_fullname,$ca_privillages;
		
			if(!$usrm_username and !$usrm_id and !$ca_privillages){
				
			header("Location: ./");
			//die("You are not authorized to see this page");
					}

			$timeout = 400; // Set timeout minutes
			$logout_redirect_url = "./"; // Set logout URL
				
			$timeout = $timeout * 60; // Converts minutes to seconds
			if (isset($_SESSION['start_time'])) {
			$elapsed_time = time() - $_SESSION['start_time'];
			if ($elapsed_time >= $timeout) {
			session_destroy();
			header("Location: $logout_redirect_url");
				}
						}

}

$uppercase = preg_match('@[A-Z]@', $_POST['pwd']);
$lowercase = preg_match('@[a-z]@', $_POST['pwd']);
$number = preg_match('@[0-9]@', $_POST['pwd']);

/*if(!$uppercase || !$lowercase || !$number and $_POST['doRegister']=='Register')
{
$messagepass='<span class="error">Password should atleast contain 1 uppercase, 1 lowercase and 1 number</span>';	
}
if($_POST['username']==$_POST['pwd'] and $_POST['doRegister']=='Register'){
$messagepass2='<span class="error"><br>Username should not be the same as password</span>';
}*/

if($_POST['doRegister']=='Register' and $_POST['fname'] and $_POST['username'] and $_POST['Institution'] and $_POST['phone'] and $_POST['email']){//$_POST['username']!=$_POST['pwd'] and  and $lowercase and $number
require("pages/class.phpmailer.php");
require("pages/class.smtp.php");

	function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
define ("MAX_SIZE","400");
 $errors=0;

$image =str_replace(' ', '_', $_FILES["profilepic"]["name"]);
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
$hp="uncst_";
$newname=$hp.$image;

$filename = "../uploads/photos/". $newname;
$filename1 = "../uploads/photos/thumb_". $newname;

imagejpeg($tmp,$filename,100);
imagejpeg($tmp1,$filename1,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);


}
}

//Get Country details
$Nationality=$mysqli->real_escape_string($_POST['Nationality']);

	$username=$mysqli->real_escape_string($_POST['username']);
	$fname=$mysqli->real_escape_string($_POST['fname']);
	$sname=$mysqli->real_escape_string($_POST['sname']);
	
	$phone=$mysqli->real_escape_string($_POST['phone']);
	$email=$mysqli->real_escape_string($_POST['email']);
	$Gender=$mysqli->real_escape_string($_POST['Gender']);
	$Qualifications=$mysqli->real_escape_string($_POST['Qualifications']);
	$master2=md5($_POST['email']);///md5 email
	$Institution=$mysqli->real_escape_string($_POST['Institution']);
	
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
	
	$sqlUsers="SELECT * FROM ".$prefix."musers where `usrm_email`='$email'";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		
		if($totalUsers){
		
			$errormessage='<p class="error3" style="font-size:18px;">$lang_username_withemail <b>'.$email.'</b>. <a href="#" class="nav-link join_now js-modal-show">$lang_ClickheretoLogin</a></p>';
	
            $error="error";

		}
		
		
		if(!$totalUsers){
$sqlA2="insert into ".$prefix."musers (`usrm_username`,`usrm_NameofInstitution`,`usrm_fname`,`usrm_sname`,`usrm_Nationality`,`usrm_password`,`usrm_phone`,`usrm_email`,`usrm_updated`,`usrm_approved`,`usrm_usrtype`,`usrm_profilepic`,`usrm_no`,`usrm_gender`,`usrm_Qualification`,`usrm_dob`) values('$username','$Institution','$fname','$sname','$Nationality','$md5pass','$phone','$email',now(),'0','user','$newname','$master2','$Gender','$Qualifications','$dob')";
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
$mail->setFrom("$emailUsername", "Grants Management");
$mail->FromName = "$lang_grants_management_system"; //From Name -- CHANGE --


$mail->addBcc("$emailBcc",'$lang_grants_management_system');
$mail->AddAddress($email, $sname); //To Address -- CHANGE --
$mail->AddReplyTo("$emailUsername", "$lang_grants_management_system-$lang_UserRegistration"); //Reply-To Address -- CHANGE --

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$lang_grants_management_system - $lang_UserRegistration";
$body="<p>$lang_dear $fname,<br>
$lang_account_creation_message

**********$lang_activation_link**********<br>
<p>
<a href='$base_urlconfirm.php?uncrd=$master2&code=$refNo'>$lang_ClicktoActivateAccount</a>
</p>


$base_urlconfirm.php?uncrd=$master2&code=$refNo</p>

<p>$fulladdress
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$sqlA = "INSERT INTO ".$prefix."mlogs (log_details, logname, logemail,logip,logdate) VALUES('A new user called $fname has been added by $session_fullname', '".$_SESSION['mmfullname']."', '$email','',now())";
//$mysqli->query($sqlA);	

$message='<p class="error2" style="font-size:18px;">$lang_Dear '.$fname.', $lang_accounthasbeensuccessfully</p>';

$error="success";
		}



}//end post



if($_POST['doResendANumber']=='Reset Password' and $_POST['name']){
	
require("pages/class.phpmailer.php");
require("pages/class.smtp.php");

    $email=$mysqli->real_escape_string($_POST['name']);
    $hostmain  = $_SERVER['HTTP_HOST'];
    $host_upper = strtoupper($host);
    $path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	
	$length=25;
    $refNo = md5(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length));
	
	$sqlUsers="SELECT * FROM ".$prefix."musers where `usrm_email`='$email'";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$r =$QueryUsers->fetch_array();
		$user_email=$r['usrm_email'];
		$usrm_username=$r['usrm_username'];

		$fullName=$r['usrm_fname'].' '.$r['usrm_lname'];
		
		if(!$totalUsers){
			$message='<p class="error2">$lang_email <b>'.$email.'</b> $lang_doesnotexists';
			
		}
		
		
if($totalUsers){
	 $hostmain  = $_SERVER['HTTP_HOST'];
    $host_upper = strtoupper($host);
    $path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

$message='<p class="error2">&nbsp;$lang_grants_management_system - $lang_password_reset <strong>&nbsp;inbox or junk</strong>.';	
 $length=25;
    $refNo = md5(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length));

$rs_activ = $mysqli->query("update ".$prefix."musers set usrm_no='$refNo' WHERE `usrm_email`='$email'");

$error="error";
	
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
$mail->FromName = "$lang_grants_management_system"; //From Name -- CHANGE --


$mail->AddAddress($email, $fname); //To Address -- CHANGE --
$mail->AddReplyTo("$emailUsername", "$lang_grants_management_system - $lang_passwordReset"); //Reply-To Address -- CHANGE --
$mail->addBcc("$emailBcc",'$lang_grants_management_system - $lang_passwordReset');

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$lang_grants_management_system - $lang_passwordReset";
$body="
<b>$lang_how_torest</b><br>
Dear $fullName,<br>
$lang_Yourequestedyour <br><br>

<a href='https://$hostmain$path/mreset.php?subs=$refNo'>Click to Re-set Password</a><br><br>
Your username: $email<br><br>

https://$hostmain$path/mreset.php?subs=$refNo<br>

<u>$lang_grants_management_system</u><br>
$fulladdress


";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}
//echo "Message has been sent";
	}
}//end post
	
$vision=$mysqli->real_escape_string($_GET['subs']);
			
if(isset($vision) && !empty($vision) ) {
	//$mysqli->real_escape_string(
$user = $mysqli->real_escape_string($_GET['subs']);
$activ = $mysqli->real_escape_string($_GET['subs']);
 $hostmain  = $_SERVER['HTTP_HOST'];
    $host_upper = strtoupper($host);
    $path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
//check if activ code and user is valid
$rs_check = $mysqli->query("select * from ".$prefix."musers where usrm_no='$activ'"); 
$num= $rs_check->num_rows;
$r = $rs_check->fetch_array();
$email=$r['usrm_email'];
$dbusrm_fname=$r['usrm_fname'];
$usrm_username=$r['usrm_username'];
  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num <= 0 ) { 
	$errormsgforgot = '<p class="error2">$lang_expired_link <br><a href="$base_urlforgot-password.php" class="text-center" style="color:#ffffff; text-decoration:underline; font-size:16px;">$lang_Clickheretoresetpasswordagain.</a></p>';
	$errormsg="true";

	}
if ( $num >=1 ) { 

if($mysqli->real_escape_string($_POST['doResetPassword']=='Change Password'))
{
$md5pass=$mysqli->real_escape_string(md5($_POST['pwd']));
$Notmd5pass=$mysqli->real_escape_string($_POST['pwd']);

////////////////////////////Now, send a mail
require("pages/class.phpmailer.php");
require("pages/class.smtp.php");
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
$mail->FromName = "$lang_grants_management_system"; //From Name -- CHANGE --


$mail->AddAddress($email, $fname); //To Address -- CHANGE --
$mail->AddReplyTo("$emailUsername", "$lang_grants_management_system - Password Re-set"); //Reply-To Address -- CHANGE --
$mail->addBcc("$emailBcc",'$lang_grants_management_system - Password Re-set');

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$lang_grants_management_system Password Updated";
$body="
$lang_Dear $dbusrm_fname, $lang_your_password_with<br>
$lang_youcan_now_login<br><br>
Username: $usrm_username<br>
Password: $Notmd5pass<br><br>
$base_url<br>
<a href='$base_url'>Click to Login</a>
<br><br>

$lang_grants_management_system<br>
$fulladdress


";
$mail->MsgHTML($body);
if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

// set the approved field to 1 to comfirm the account
$rs_activ = $mysqli->query("update ".$prefix."musers set usrm_password='$md5pass',usrm_no='' WHERE usrm_no= '$activ' ");/**/

$msg = "<p class='success'>$lang_CongratulationsPasswordReset<br><br><a href='$base_url' class='text-center' style='color:#000000; text-decoration:underline; font-size:16px;'>$lang_ClickheretoLogin</a></p>";	
$errormsg="false";


}	
}
	}
function RecentCalls(){
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sqlGroupDIspC="SELECT *,DATE_FORMAT(`startDate`,'%d %M, %Y') AS startDate,DATE_FORMAT(`EndDate`,'%d %M, %Y') AS EndDate,DATE_FORMAT(`EndDate`,'%b') AS month,DATE_FORMAT(`EndDate`,'%d') AS date FROM ".$prefix."grantcalls where startDate>='$today' and EndDate>='$today' order by grantID desc limit 0,3";
$sqlFGrpDisC=$mysqli->query($sqlGroupDIspC);
$totalUserReports = $sqlFGrpDisC->num_rows;
while($rGRSPC=$sqlFGrpDisC->fetch_array()){?>
<div class="events_single">
                <!--    <div class="event_banner">
                        <a href="#"><img src="images/events/event_3.jpg" alt="" class="img-fluid" style="overflow:hidden; margin-bottom:10px;"></a>
                    </div>-->
                    <div class="event_info">
                        <h3><a href="#" title=""><?php echo $rGRSPC['title'];?></a></h3>
                        
                        <div class="events_time">
                            <span class="time"><i class="flaticon-clock-circular-outline"></i>Deadline: </span>
                            <span><i class="fas fa-map-marker-alt"></i><?php echo $rGRSPC['EndDate'];?></span>
                        </div>
                         <p><?php echo $rGRSPC['details'];?> <?php if($rGRSPC['attachment']){?><a href="<?php echo  $base_url;?>app/files/<?php echo $rGRSPC['attachment'];?>" title="" target="_blank">More Details</a><?php }?></p>
                        <div class="event_dete">
                            <span class="date"><?php echo $rGRSPC['date'];?></span>
                            <span><?php echo $rGRSPC['month'];?></span>
                        </div>
                    </div>
                </div>

	
<?php 
}
}//end Function

function TotalCalls(){
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sqlGrants="SELECT * FROM ".$prefix."grantcalls order by grantID desc";
$sqlGrants=$mysqli->query($sqlGrants);
echo $totalGrants = $sqlGrants->num_rows;
}
function NumberofSubmissionsReceived(){
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sqlGrants1="SELECT * FROM ".$prefix."submissions_concepts order by conceptID desc";
$sqlGrants1=$mysqli->query($sqlGrants1);
$totalGrants1 = $sqlGrants1->num_rows;
///Get Proposals as well
$sqlGrants2="SELECT * FROM ".$prefix."submissions_proposals order by projectID desc";
$sqlGrants2=$mysqli->query($sqlGrants2);
$totalGrants2 = $sqlGrants2->num_rows;
echo ($totalGrants1+$totalGrants2);
}

function GrantsAwarded(){
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sqlGrants1="SELECT * FROM ".$prefix."submissions_concepts where awarded='Yes' order by conceptID desc";
$sqlGrants1=$mysqli->query($sqlGrants1);
$totalGrants1 = $sqlGrants1->num_rows;
///Get Proposals as well
$sqlGrants2="SELECT * FROM ".$prefix."submissions_proposals where awarded='Yes' order by projectID desc";
$sqlGrants2=$mysqli->query($sqlGrants2);
$totalGrants2 = $sqlGrants2->num_rows;
echo ($totalGrants1+$totalGrants2);
}

function TotalUsers(){
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sqlUsers="SELECT * FROM ".$prefix."musers order by usrm_id desc";
$sqlUsers=$mysqli->query($sqlUsers);
echo $totalUsers = $sqlUsers->num_rows;
}

function Slider()
{
	global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sql_slider="SELECT * FROM ".$prefix."slider order by rank asc limit 0,4";
$sqlF_slider=$mysqli->query($sql_slider);
while($rs_slider=$sqlF_slider->fetch_array()){
?><li data-index="rs-1708" data-transition="fade" data-slotamount="7" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="1000"  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                    <div class="slider-overlay"></div>
                    <img src="images/banner/<?php echo $rs_slider['image'];?>" alt="Sky" class="rev-slidebg"  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" data-no-retina>
                    <!-- LAYER NR. 1 -->
                    <div class="tp-caption font-lora sfb tp-resizeme letter-space-5 h-p" 
                        data-x="['left','center','center','center']" data-hoffset="['0','0','0','0']" 
                        data-y="['middle','middle','middle','middle']" data-voffset="['-200','-280','-250','-200']" 
                        data-fontsize="['20','40','40','28']"
                        data-lineheight="['70','80','70','70']"
                        data-width="none"
                        data-height="none"
                        data-whitespace="nowrap"
                        data-type="text" 
                        data-responsive_offset="on" 
                        data-frames='[{"from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","speed":400,"to":"o:1;","delay":100,"split":"chars","splitdelay":0.05,"ease":"Power3.easeInOut"},{"delay":"wait","speed":100,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                        
                        style="z-index: 7; color:#fff; font-family:'Rubik', sans-serif; max-width: auto; max-height: auto; white-space: nowrap; font-weight:500;"><?php echo $rs_slider['txt_1'];?>
                    </div>
                    <!-- LAYER NR. 2 -->
                    <div class="tp-caption NotGeneric-Title   tp-resizeme" 
                        id="slide-3045-layer-11" 
                        data-x="['left','center','center','center']" data-hoffset="['0','0','0','0']" 
                        data-y="['middle','middle','middle','middle']" data-voffset="['-120','-140','-140','-120']" 
                        data-fontsize="['65','120','100','70']"
                        data-lineheight="['70','120','70','70']"
                        data-width="none"
                        data-height="none"
                        data-whitespace="nowrap"
                        data-type="text" 
                        data-responsive_offset="on" 
                        data-frames='[{"from":"x:[105%];z:0;rX:45deg;rY:0deg;rZ:90deg;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1000,"split":"chars","splitdelay":0.05,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                        data-textAlign="['left','left','left','left']"
                        data-paddingtop="[10,10,10,10]"
                        data-paddingright="[0,0,0,0]"
                        data-paddingbottom="[10,10,10,10]"
                        data-paddingleft="[0,0,0,0]"

                        style="z-index: 5; font-family:'Roboto', sans-serif; font-weight: 700; white-space: nowrap;text-transform:left;"><?php echo $rs_slider['txt_2'];?>
                    </div>

                 <?php /*?>   <!-- LAYER NR.3 -->
                    <div class="tp-caption NotGeneric-Title   tp-resizeme" 
                        id="slide-3045-layer-12" 
                        data-x="['left','center','center','center']" data-hoffset="['0','0','0','0']" 
                        data-y="['middle','middle','middle','middle']" data-voffset="['-40','0','-10','-40']" 
                        data-fontsize="['65','120','100','70']"
                        data-lineheight="['70','120','70','70']"
                        data-width="none"
                        data-height="none"
                        data-whitespace="nowrap"
                        data-type="text" 
                        data-responsive_offset="on" 
                        data-frames='[{"from":"x:[105%];z:0;rX:45deg;rY:0deg;rZ:90deg;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1000,"split":"chars","splitdelay":0.05,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                        data-textAlign="['left','left','left','left']"
                        data-paddingtop="[10,10,10,10]"
                        data-paddingright="[0,0,0,0]"
                        data-paddingbottom="[10,10,10,10]"
                        data-paddingleft="[0,0,0,0]"

                        style="z-index: 5; font-family:'Roboto', sans-serif; font-weight: 700; white-space: nowrap;text-transform:left;"><?php echo $rs_slider['txt_3'];?>
                    </div><?php */?>
                        <!-- LAYER NR. 5 -->
                    <div class="tp-caption rev-btn rev-btn right-btn" 
                        id="slide-2939-layer-15" 
                        data-x="['left','left','left','left']" data-hoffset="['250','-60','-130','-100']" 
                        data-y="['middle','middle','middle','middle']" data-voffset="['75','220','190','100']" 
                        data-fontsize="['14','14','10','8']"
                        data-lineheight="['34','34','30','20']"
                        data-width="none"
                        data-height="none"
                        data-whitespace="nowrap"
                        data-type="button" 
                        data-actions='[{"event":"click","action":"jumptoslide","slide":"rs-2939","delay":""}]'
                        data-responsive_offset="on" 
                        data-responsive="off"
                        data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1750,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:#fff;bg:#ff5a2c;bw:2px 2px 2px 2px; "}]'
                        data-textAlign="['left','left','left','left']"
                        data-paddingtop="[12,12,8,8]"
                        data-paddingright="[40,40,30,25]"
                        data-paddingbottom="[12,12,8,8]"
                        data-paddingleft="[40,40,30,25]"

                        style="z-index: 14; white-space: nowrap;  font-weight:500; color:#ffffff; font-family:Rubik; text-transform:uppercase; background-color:#092ace; letter-spacing:1px; border-radius: 3px;"><?php echo $rs_slider['txt_3'];?>
                    </div>
                </li>
	
	
<?php }// ENd loop
}// End Function


function WelcomeText()
{
	global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sql_welcome="SELECT * FROM ".$prefix."pages where section='welcome' order by rank asc limit 0,1";
$sqlF_welcome=$mysqli->query($sql_welcome);
while($rs_welcome=$sqlF_welcome->fetch_array()){
?><div class="col-12 col-sm-6 col-md-7 col-lg-7">
                    <div class="story_banner">
                        <img src="images/banner/<?php echo $rs_welcome['image_file'];?>" alt="" class="img-fluid">
                     </div>
                </div>
                <div class="col-12 col-sm-6 col-md-5 col-lg-5">
                    <div class="about_story_title"><h2><?php echo $rs_welcome['title'];?></h2>
					<?php echo $rs_welcome['details'];?>
                      
                     </div>
                </div>
	
	
<?php }// ENd loop
}// End Function

function TopBarTelephone()
{
	global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sql_welcome_2="SELECT * FROM ".$prefix."pages where section='tel_top' order by rank asc limit 0,1";
$sqlF_welcome_2=$mysqli->query($sql_welcome_2);
$rs_welcome_2=$sqlF_welcome_2->fetch_array();
?>
     
<li><i class="flaticon-phone-receiver"></i><?php echo $rs_welcome_2['details'];?></li>
<?php 
}// End Function

function TopBarTelephoneBottom()
{
	global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sql_welcome_2="SELECT * FROM ".$prefix."pages where section='tel_top' order by rank asc limit 0,1";
$sqlF_welcome_2=$mysqli->query($sql_welcome_2);
$rs_welcome_2=$sqlF_welcome_2->fetch_array();
?>
<span><?php echo $rs_welcome_2['details'];?></span>
<?php 
}// End Function

function TopBarEmail()
{
	global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sql_welcome_3="SELECT * FROM ".$prefix."pages where section='email_top' order by rank asc limit 0,1";
$sqlF_welcome_3=$mysqli->query($sql_welcome_3);
$rs_welcome_3=$sqlF_welcome_3->fetch_array();
?>
<li><i class="flaticon-mail-black-envelope-symbol"></i><?php echo $rs_welcome_3['details'];?></li>

<?php 
}// End Function

function TopBarEmailBottom()
{
	global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sql_welcome_3="SELECT * FROM ".$prefix."pages where section='email_top' order by rank asc limit 0,1";
$sqlF_welcome_3=$mysqli->query($sql_welcome_3);
$rs_welcome_3=$sqlF_welcome_3->fetch_array();
?>
<span class="email"><?php echo $rs_welcome_3['details'];?></span>

<?php 
}// End Function

function Sponsors()
{
	global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sql_sponsors="SELECT * FROM ".$prefix."pages_collaboration order by rank asc limit 0,10";
$sqlF_sponsors=$mysqli->query($sql_sponsors);
while($rs_sponsors=$sqlF_sponsors->fetch_array()){
?>
<li><a href="<?php echo $rs_sponsors['logo_link'];?>" target="_blank"><img src="images/logos/<?php echo $rs_sponsors['logo_img'];?>" alt="" class="img-fluid  wow fadeIn" data-wow-duration="2s" data-wow-delay=".1s" border="0"></a></li>
<?php
}
}// End Function

function SocialMedia()
{
	global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	
$sql_socialmedia="SELECT * FROM ".$prefix."pages_socialmedia order by rank asc limit 0,1";
$sqlF_socialmedia=$mysqli->query($sql_socialmedia);//'facebook','twitter','linkedin','integram','youtube'
while($rs_socialmedia=$sqlF_socialmedia->fetch_array()){
?>

<?php if($rs_socialmedia['facebook']){?><li><a href="<?php echo $rs_socialmedia['facebook'];?>" target="_blank"><i class="fab fa-facebook-f fb-icon"></i></a></li><?php }?>
<?php if($rs_socialmedia['twitter']){?><li><a href="<?php echo $rs_socialmedia['twitter'];?>" target="_blank"><i class="fab fa-twitter twitt-icon"></i></a></li><?php }?>
<?php if($rs_socialmedia['linkedin']){?><li><a href="<?php echo $rs_socialmedia['linkedin'];?>" target="_blank"><i class="fab fa-linkedin-in link-icon"></i></a></li><?php }?>
<?php if($rs_socialmedia['integram']){?><li><a href="<?php echo $rs_socialmedia['integram'];?>" target="_blank"><i class="fab fa-instagram ins-icon"></i></a></li><?php }?>
<?php if($rs_socialmedia['youtube']){?><li><a href="<?php echo $rs_socialmedia['youtube'];?>" target="_blank"><i class="fab fa-youtube ins-icon"></i></a></li><?php }?>

<?php
}
}// End Function

?>