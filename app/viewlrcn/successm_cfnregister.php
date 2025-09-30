     <section class="content-header">
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Register Users</li>
                    </ol>
                </section>
	<?php
if($_POST['doRegister']=='Register'){
	require_once("Mail.php");
	require_once "Mail/mime.php";
	$organisation=$mysqli->real_escape_string($_POST['organisation']);
	$department=$mysqli->real_escape_string($_POST['department']);
	$title=$mysqli->real_escape_string($_POST['title']);
	$profession=$mysqli->real_escape_string($_POST['profession']);
	$firstName=$mysqli->real_escape_string($_POST['firstName']);
	$lastName=$mysqli->real_escape_string($_POST['lastName']);
	$address1=$mysqli->real_escape_string($_POST['address1']);
	$address2=$mysqli->real_escape_string($_POST['address2']);		
	$postalCode=$mysqli->real_escape_string($_POST['postalCode']);	
	$city=$mysqli->real_escape_string($_POST['city']);
	$state=$mysqli->real_escape_string($_POST['state']);
	$countryID=$mysqli->real_escape_string($_POST['countryID']);
	$phone=$mysqli->real_escape_string($_POST['phone']);
	$fax=$mysqli->real_escape_string($_POST['fax']);
	$email=$mysqli->real_escape_string($_POST['email']);	
	$comments=$mysqli->real_escape_string($_POST['comments']);	
	$usrname=$mysqli->real_escape_string($_POST['usrname']);	
	$ipaddress=$_SERVER['REMOTE_ADDR'];
	$md5pass=md5($mysqli->real_escape_string($_POST['pwd']));
	$NotPassword=$mysqli->real_escape_string($_POST['pwd']);
	$length=10;
    $refNo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	
	$sqlUsers="SELECT * FROM ".$prefix."users where `cfn_email`='$email' and `cfn_usrname`='$username'";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		
		if($totalUsers){
		
			$message='<p class="error">Username <b>'.$username.'</b> already exists';


		}
		
		
		if(!$totalUsers){
$sqlA2="insert into ".$prefix."users (`cfn_organisation`,`cfn_department`,`cfn_title`,`cfn_profession`,`cfn_firstName`,`cfn_lastName`,`cfn_address1`,`cfn_address2`,`cfn_postalCode`,`cfn_city`,`cfn_state`,`cfn_countryID`,`cfn_phone`,`cfn_fax`,`cfn_email`,`cfn_comments`,`cfn_usrname`,`cfn_pswd`,`cfn_ip`,`cfn_regdate`,`cfn_usrtype`,`cfn_refNo`,`cfn_approved`) values('$organisation','$department','$title','$profession','$firstName','$lastName','$address1','$address2','$postalCode','$city','$state','$countryID','$phone','$fax','$email','$comments','$usrname','$md5pass','$ipaddress',now(),'user','$refNo','No')";
$mysqli->query($sqlA2);
////////////////////////////////////////////////////////////////////////////////////////////////////////////

$from = "i3Conf <mmawanda@i3c.co.ug>";
$to .= "$lastName <$email>";
//$cc = "mmawanda@i3c.co.ug";
$bcc = "mmawanda@i3c.co.ug";
$subject = "i3Conf  Registration";


	//Bcc Address can not be defined in the header array.
        $recipients =  $to.",".$bcc;
		//$recipients =  $to.",".$cc.",".$bcc ;
        //All the email headers except for BCC
        $headers['From'] = $from;
        $headers['To'] = $to;
        $headers['Subject'] = $subject;
        $headers['Cc'] = $cc;
        $headers['Reply-To'] = $from;

        //SMTP Auth
        $auth = TRUE;
        $host = "nemesis.eahd.or.ug";
        $username = "ugtldreg";
        $password = "OYZZpsgJXzl";

        //Text sent in email
       // $text = 'Text version of email';
		
        //HTML sent in email
       $html = "<p>This is to confirm that we received your details for i3Conf. Thank you for your interest in i3Conf!<br>

You will be contacted by email soon.
The information about your request is as follows:</p>

<p><b>ORGANISATION INFORMATION</b><br>
Organisation: $organisation<br>
Department: $department<br>
Profession: $profession</p>

<p><b>PERSONAL INFORMATION</b><br>
Name: $title $firstName $lastName<br>
Address: $address1<br>
$address2<br>
Postal Code: $postalCode<br>
City: $city<br>
Phone: $phone<br>
Fax: $fax<br>
Email: $email<br>

</p>
<p>
Ref No:$refNo<br>
Password: $NotPassword
</p>
<p>$comments</p>

<p>If any of these data is incorrect or you want to add more  information, you should access your control panel to update.</p>


<p>Best regards,<br>
i3Conf,  Management System</p>
";


        //Create message, required for HTML email
        $mime = new Mail_mime();

        //Set the body of the email
        //$mime->setTXTBody($text);
        $mime->setHTMLBody($html);

        //Prepare Body
        $body = $mime->get();
        //Prepare Headers
        $headers = $mime->headers($headers);

        //Sending Mail
        $mail =& Mail::factory('smtp', array("host"=>$host,"port"=>587,
                         "username"=>$username,"password"=>$password));
        $mail-> send($recipients,$headers,$body);

        //Displays error or outputs message sent
            if (PEAR::isError($mail)) {
                echo("" . $mail->getMessage() . "");
            } 



////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$sqlA = "INSERT INTO ".$prefix."logs (lg_action, lg_user, lg_user_level,lg_time) VALUES('A new user called $firstName $lastName has been added by $username', '".$_SESSION['mmfullname']."', 'supeadmin',now())";
$mysqli->query($sqlA);	
echo $message='<p class="success">Dear, this account has been successfully created, you can check your email for details. Thank you';

		}
		
}



?>


