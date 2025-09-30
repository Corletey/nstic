<?php
session_start();
require_once('contrlrcn/c_mlsrcontrol.php'); 
$captcha=$mysqli->real_escape_string($_POST['captcha']);
?><!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?php echo $sitename;?> | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
     <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="img/favicon.png">
        <!-- font Awesome -->
        <!--<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>

  <script>
  $(document).ready(function(){
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();
  });
  </script>
  
  <?php /*?><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><?php */?>
    </head>
    <body class="bg-black">
 <div class="center">
    <div class="center2">
	<a href="./"><img src="img/logo.png" border="0"></a></div>
	</div>
        <div class="form-box2" id="login-box">
            <div class="headerc">Register Now</div>

<?php
$uppercase = preg_match('@[A-Z]@', $_POST['pwd']);
$lowercase = preg_match('@[a-z]@', $_POST['pwd']);
$number = preg_match('@[0-9]@', $_POST['pwd']);

if(!$uppercase || !$lowercase || !$number and $_POST['doRegister']=='Register')
{
$messagepass='<span class="error">Password should atleast contain 1 uppercase, 1 lowercase and 1 number</span>';	
}
if($_POST['username']==$_POST['pwd'] and $_POST['doRegister']=='Register'){
$messagepass2='<span class="error"><br>Username should not be the same as password</span>';
}

if($_POST['doRegister']=='Register' and $_POST['username']!=$_POST['pwd'] and $uppercase and $lowercase and $number){
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
$Nationalitymm=$mysqli->real_escape_string($_POST['Nationality']);
$sqlUser = "SELECT * FROM ".$prefix."countries where cidm_country_name like '%$Nationalitymm%'";
$queryUser = $mysqli->query($sqlUser);
$rcountry = $queryUser->fetch_array();
$Nationality=$rcountry['cidm_country_id'];

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
	
		if(isset($captcha)&&$captcha!=""&&$_SESSION["code"]==$captcha)
{
	$length=25;
    $refNo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	
	$sqlUsers="SELECT * FROM ".$prefix."musers where `usrm_email`='$email' and `usrm_username`='$username'";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		
		if($totalUsers){
		
			$message='<p class="error">Username <b>'.$username.'</b> already exists</p><h3><a href="./" class="text-center">Click here to Login</a></h3>';
	
            $error="error";

		}
		
		
		if(!$totalUsers){
$sqlA2="insert into ".$prefix."musers (`usrm_username`,`usrm_NameofInstitution`,`usrm_fname`,`usrm_sname`,`usrm_Nationality`,`usrm_password`,`usrm_phone`,`usrm_email`,`usrm_updated`,`usrm_approved`,`usrm_usrtype`,`usrm_profilepic`,`usrm_no`,`usrm_gender`,`usrm_Qualification`,`usrm_dob`) values('$username','$Institution','$fname','$sname','$Nationality','$md5pass','$phone','$email',now(),'0','user','$newname','$master2','$Gender','$Qualifications','$dob')";
$mysqli->query($sqlA2);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
$mail = new PHPMailer();
$mail->IsSMTP(); // set mailer to use SMTPMailhost03.i3c.co.ug

$mail->Host = "mailhost03.i3c.co.ug"; // specify SMTP server//nemesis.eahd.or.ug mailhost02.cfi.co.ug
$mail->SMTPAuth = true; // turn on SMTP authentication
//david --> I've uncommented this and changed the value from tls to ssl 
$mail->SMTPSecure = 'ssl';
$mail->SMTPDebug = 0;
$mail->Username = "$emailUsername"; // SMTP username -- CHANGE --
$mail->Password = "$emailPassword"; // SMTP password -- CHANGE --
$mail->From = "$emailUsername"; //From Address -- CHANGE -
$mail->FromName = "UNCST Grants Management System"; //From Name -- CHANGE --


$mail->addBcc("$emailBcc",'UNCST Grants Management System');
$mail->AddAddress($email, $fname); //To Address -- CHANGE --
$mail->AddReplyTo("$emailUsername", "UNCST Grants Management System-User Registration"); //Reply-To Address -- CHANGE --

$mail->Port = "465"; // SMTP Port
$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "UNCST Grants Management System - User Registration";
$body="<p>Hello $fname,<br>
An account has been created for you on $sitename. Please click the link below to login or copy and paste link in your browser.</p>
<p>After Registration Confirmation, you can proceed to login</p>

**********ACTIVATION LINK BELOW**********<br>
<p>
<a href='https://$hostmain$path/confirm.php?uncrd=$master2&code=$refNo'>Click to Activate Account</a>
</p>

If you cant see the activation link above, copy and paste the address below into your browser.<br>
https://$hostmain$path/confirm.php?uncrd=$master2&code=$refNo</p>

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

$message='<p class="success">Dear, this account has been successfully created, you can check your email for details. Thank you</p><h3><a href="./" class="text-center">Click here to Login</a></h3>';

$error="success";
		}
	}//end capatcha


if($_SESSION["code"]!=$captcha)
{
$message='<p class="error">Wrong Verification Code Entered</p>';	
	$error="error";
}//end capatcha	
}//end post

?>

<?php 
if(isset($messagepass)){?><div style="padding-left:20px; background:#FFF;"><?php echo $messagepass;?></div><?php }
if(isset($messagepass2)){?><div style="padding-left:20px; background:#FFF;"><?php echo $messagepass2;?></div><?php }
if(isset($message)){?><div style="padding-left:20px; background:#FFF;"><label class="control-label" for="inputSuccess"><?php echo $message;?> </label></div><?php }
							?>
<?php if($error=="success"){}else{?>
<form action="" method="post" name="regForm" id="regForm" enctype="multipart/form-data" autocomplete="off">


                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->  
                            <div class="box box-primary">
                            
                               <!-- <div class="box-header">
                                    <h3 class="box-title"><strong>Login Details</strong></h3>
                                </div>-->
                                
                                
                                <!-- form start -->
                              
                                    <div class="box-body">
                                   <div class="form-group">
                                   
                                  <label class="control-label" for="inputSuccess">First Name <font color="#CC0000">*</font></label>
                                  <input type="text" class="form-control required" name="fname"  value="<?php echo $_POST['fname'];?>" id="fname"/>
                                  </div>
                                  
                                  <div class="form-group">
                                  <label class="control-label" for="inputSuccess">Last Name <font color="#CC0000">*</font></label>
                                  <input type="text" class="form-control required" name="sname"  value="<?php echo $_POST['sname'];?>" id="sname"/>
                                  </div>
    
                                     <div class="form-group">
                                            <label for="exampleInputEmail1">Email address <font color="#CC0000">*</font></label>
                                            <input type="email" class="form-control required email" name="email" id="exampleInputEmail1" value="<?php echo $_POST['email'];?>">
                                            
                                            
                                        </div>
                                        
                                        
                                          <div class="form-group">
                                            <label for="exampleInputEmail1">Username <font color="#CC0000">*</font></label>
                                            <input type="text" class="form-control required" name="username" id="username" value="" autocomplete="off">
                                            
                                            
                                        </div>                                   
                                        
                                        
                                      <?php /*?>    <div class="form-group">
                                            <label for="exampleInputEmail1">Date of Birth <font color="#CC0000">*</font></label><br>
                                            <select name="date" id="ddate" class="required mmm" tabindex="6" style="width:70px;">
      <option value="">Date</option>
      <option value="01">&nbsp;01</option>
      <option value="02">&nbsp;02</option>
      <option value="03">&nbsp;03</option>
      <option value="04">&nbsp;04</option>
      <option value="05">&nbsp;05</option>
      <option value="06">&nbsp;06</option>
      <option value="07">&nbsp;07</option>
      <option value="08">&nbsp;08</option>
      <option value="09">&nbsp;09</option>
      <option value="10">&nbsp;10</option>
      <option value="11">&nbsp;11</option>
      <option value="12">&nbsp;12</option>
      <option value="13">&nbsp;13</option>
      <option value="14">&nbsp;14</option>
      <option value="15">&nbsp;15</option>
      <option value="16">&nbsp;16</option>
      <option value="17">&nbsp;17</option>
      <option value="18">&nbsp;18</option>
      <option value="19">&nbsp;19</option>
      <option value="20">&nbsp;20</option>
      <option value="21">&nbsp;21</option>
      <option value="22">&nbsp;22</option>
      <option value="23">&nbsp;23</option>
      <option value="24">&nbsp;24</option>
      <option value="465">&nbsp;25</option>
      <option value="26">&nbsp;26</option>
      <option value="27">&nbsp;27</option>
      <option value="28">&nbsp;28</option>
      <option value="29">&nbsp;29</option>
      <option value="30">&nbsp;30</option>
      <option value="31">&nbsp;31</option>
    </select>
      <select name="month" id="dmonth" class="required mmm" tabindex="7">
        <option value="">&nbsp;Month</option>
        <option value="01">&nbsp;January</option>
        <option value="02">&nbsp;February</option>
        <option value="03">&nbsp;March</option>
        <option value="04">&nbsp;April</option>
        <option value="05">&nbsp;May</option>
        <option value="06">&nbsp;June</option>
        <option value="07">&nbsp;July</option>
        <option value="08">&nbsp;August</option>
        <option value="09">&nbsp;September</option>
        <option value="10">&nbsp;October</option>
        <option value="11">&nbsp;November</option>
        <option value="12">&nbsp;December</option>
      </select>
      <select name="yearm" id="dyear" class="required mmm" tabindex="8">
        <option value="">Year</option>
        <?php
define('DOB_YEAR_START', 1920);

$current_year = (date('Y')-17);

for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
        <option value="<?php echo $count;?>"  <?php if($TMM['year']==$count){?> selected="selected"<?php }?>><?php echo $count;?></option>
        <?php }?>
      </select>
                                            
                                            
                                        </div> 
                                        <?php */?>
                                 
                                        
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password  <strong>(Must containg 1 lowercase, 1 Uppercase and 1 Number)</strong><font color="#CC0000">*</font></label>
                                           <input type="password" class="form-control" name="pwd" minlength="5" id="pwd">
                                        </div>
                                  
                                         <div class="form-group">
                                            <label for="exampleInputPassword1">Re-type Password <font color="#CC0000">*</font></label>
                                           
                                            <input type="password" class="form-control" name="pwd2" id="pwd2" minlength="5"   equalto="#pwd">
                                        </div>
                                        
                                        
                                        
                                        
                                    </div><!-- /.box-body -->

                         
                           
                            </div><!-- /.box -->

                          </div>

                        <!-- right column -->
                        <div class="col-md-6">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                              <!--  <div class="box-header">
                                    <h3 class="box-title"><strong>Contacts and Addresses</strong></h3>
                                </div>-->
                                
                                
                                <div class="box-body">

                                        <!-- text input -->
                                  
                                      
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Institution of Affiliation (In Full) <font color="#CC0000">*</font></label>
                                           <input type="text" class="form-control required" name="Institution" id="Institution" value="<?php echo $_POST['Institution'];?>">
                                           
                                           
                                        </div>  
                 
    
    
    <div class="form-group">
    <label class="control-label" for="inputSuccess">Phone <font color="#CC0000">*</font></label>
    <input type="text" class="form-control required" name="phone"  value="<?php echo $_POST['phone'];?>" id="phone"/>
    </div>
    
    
    <div class="form-group">
    <label class="control-label" for="inputSuccess">Gender <font color="#CC0000">*</font></label>
    <input name="Gender" type="radio" value="Male" tabindex="14" id="Gender"/> Male&nbsp;
      <input name="Gender" type="radio" value="Female"  tabindex="15" id="Gender"/> Female
    </div>
    
    <div class="form-group">
    <label class="control-label" for="inputSuccess">Qualifications <font color="#CC0000">*</font></label>
    
    <select name="Qualifications" id="Qualifications" class="required form-control" tabindex="6" onChange="getQualification(this.value)">
        <option value="">&nbsp; Please Select</option>
        <option value="Diploma">&nbsp;Diploma</option>
        <option value="Bachelor's Degree">&nbsp;Bachelor's Degree</option>
        <option value="Master's Degree">&nbsp;Master's Degree</option>
        <option value="PHD">&nbsp;PHD</option>
        <option value="Post-Doctoral">&nbsp;Post-Doctoral </option>
        <option value="Other">&nbsp;Other</option>
      </select>
    </div>
    
    
                                        
                                      <!--  
                                         <div class="form-group">
                                          Upload profile picture                                      
<input name="profilepic" type="file" />
                                        </div>-->

<div class="form-group">
                                            <label for="exampleInputPassword1">Nationality <font color="#CC0000">*</font></label>


<?php /*?><select name="Nationality"  id="myUL" class="required form-control" tabindex="6" >
    <option value="" selected>&nbsp; Please Select</option>
    <?php
$sqlUser = "SELECT * FROM ".$prefix."countries order by cidm_country_name asc";
$queryUser = $mysqli->query($sqlUser);
while($r = $queryUser->fetch_array()){?>
    <option value="<?php echo $r['cidm_country_id'];?>"  id="myUL">&nbsp;<?php echo $r['cidm_country_name'];?></option>
    <?php }?>
  </select><?php */?>
 
 
  

<input list="brow" name="Nationality" class="required form-control">
<datalist id="brow">
  <?php
$sqlUser = "SELECT * FROM ".$prefix."countries order by cidm_country_name asc";
$queryUser = $mysqli->query($sqlUser);
while($r = $queryUser->fetch_array()){?>
    <option value="<?php echo $r['cidm_country_name'];?>">&nbsp;<?php echo $r['cidm_country_name'];?></option>
    <?php }?>
</datalist>

  
</div>

<div class="form-group">
 	
Enter Verification Code below<br>
<input type="text" name="captcha" id="namelgn" tabindex="1" class="form-control required number" minlength="6" placeholder="" autocomplete="off"/> <img src="viewlrcn/captchamr.php" class="valimage"/>
                                        </div>

                                    
                                    
        
        
 <br><input name="doRegister" type="submit" class="btn btn-info btn-flat" value="Register"/>&nbsp;&nbsp;&nbsp;<input name="button" type="button" class="btn btn-info btn-flat" value="Back to Login" onClick="window.location.href='./'"/>
                              
<p>&nbsp;</p>
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                 </form>
            <?php }?>              
                                                  
                                                  
                                                  
                                                  
        </div>


    </body>
</html>