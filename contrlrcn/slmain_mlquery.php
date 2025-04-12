<?php
//$Auth = new Auth();
////////////////Begin Table Prefix////////////////////////////////////////////////

$photos_folder = "images/photos/";
$requsitions_folder = "../files/requsitions/";
////////////////End Table Prefix///////////////////////////////////////////////////

function numberformat($nvalue)
{
    $returnno = number_format($nvalue, 0);
    return $returnno;
}
//////////////////////////////////////////////////////////////////////////////////////////
function EscapeString($evalue)
{
    $returnES = mysql_real_escape_string($evalue);
    return $returnES;
}
///////////////////////date/////////////////
function dateformat($date, $format = "")
{
    $default_format = "l dS F, Y";
    $format = ($format) ? $format : $default_format;

    $new_date = new DateTime($date);
    $new_date = $new_date->format($format);

    return $new_date;
}

function Error($errorvalue)
{
    $returnerrorVal = print(mysql_error($errorvalue));
    return $returnerrorVal;
}

if ($_POST['doLogin']) { //=="$lang_Signmein"

    $name = $mysqli->real_escape_string($_POST['name']);
    $md5pass = md5($mysqli->real_escape_string($_POST['pwd']));

    // Get the redirect URL if it exists
    $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : '';

    $sqlUser = "SELECT * FROM " . $prefix . "musers where usrm_username='$name' and usrm_password='$md5pass'";
    $queryUser = $mysqli->query($sqlUser);
    $totalUser = $queryUser->num_rows;
    $r = $queryUser->fetch_array();

    $dbusrm_id = $r['usrm_id'];
    $dbprdffullname = $r['usrm_fname'];
    $dbusrm_email = $r['usrm_email'];
    $dbusrm_password = $r['usrm_password'];
    $dbusrm_username = $r['usrm_username'];
    $dbusrm_approved = $r['usrm_approved'];
    $dbusrm_usrtype = $r['usrm_usrtype'];
    $dbsentNotify = $r['sentNotify'];
    //////////////////////////////////////////////////////////////////////////////////////////////////////////


    if ($totalUser == 1 && $dbusrm_approved == "1") {
        $_SESSION['usrm_username'] = $dbusrm_username;
        $_SESSION['usrm_email'] = $dbusrm_email;
        $_SESSION['usrm_id'] = $dbusrm_id;
        $_SESSION['usrm_usrtype'] = $dbusrm_usrtype;
        $_SESSION['mmfullname'] = $dbprdffullname;


        //////////////////record action//////////////////////////////////////
        $sqlA = "INSERT INTO " . $prefix . "logs(lg_action, lg_user, lg_user_level,lg_time) VALUES('$dbusrm_username Logged in from $usersipaddress', '" . $_SESSION['mmfullname'] . "', '" . $_SESSION['usrm_usrtype'] . "','$dateSubmitted')";
        //$mysqli->query($sqlA);

        // Check if there's a redirect URL
        if (!empty($_POST['redirect_url'])) {
            // Redirect to the specified URL (e.g., grant application page)
            echo ("<script>location.href = '" . $redirect_url . "';</script>");
            exit();
        } else {
            // Default redirect to dashboard
            echo ("<script>location.href = './app/main.php?option=dashboard';</script>");
            exit();
        }
    }


    if ($totalUser == 1 && $dbusrm_approved == "1" and $dbusrm_usrtype == 'reviewer') {
        $err2 = '<span class="error"> </span>';
    } else {
        $err2 = "$lang_wrong_username";
    }
} //end if post


$category = $mysqli->real_escape_string($_GET['option']);
$pd = $mysqli->real_escape_string($_GET['mdc']);
$id = $mysqli->real_escape_string($_GET['id']);
$bt = $mysqli->real_escape_string($_GET['bt']);
$c = $mysqli->real_escape_string($_GET['c']);
$n = $mysqli->real_escape_string($_GET['n']);
$bkey = $mysqli->real_escape_string($_GET['bkey']);
$bmw = $mysqli->real_escape_string($_GET['bmw']);
$address = $_SERVER['REQUEST_URI'];

///////////////////Begin main link/////////////////
function main($MainLink)
{
    global $category;
    echo $mlink = "main.php?option=";
}
///////////////////End main link/////////////////

//////////////sessions//////////////////////////////////////////////////////////////////////////
$usrm_username = $_SESSION['usrm_username'];
$usrm_id = $_SESSION['usrm_id'];
$session_usertype = $_SESSION['usrm_usrtype'];
$session_fullname = $_SESSION['mmfullname'];
$cfn_organisation = $_SESSION['cfn_organisation'];

///////////end sessions/////////////////////////////////////////////////////////////////////////

function authent($value)
{
    global  $cac_role, $cm, $mdc;
    if ($cac_role == $cm or $cac_role == $mdc) {
        return ($value);
    }
}

$queryMyLogged = "select * from " . $prefix . "musers where usrm_username='$usrm_username'";
$rs_MyLogged = $mysqli->query($queryMyLogged);
$rsLoggedMy = $rs_MyLogged->fetch_array();
$usrrsmyLoggedIdm = $rsLoggedMy['usrm_id'];

////////Begin time out////////////////////////////////////////////////////////////////////////////
function timeout($timeout)
{
    global $usrm_username, $usrm_id, $session_usertype, $session_fullname, $ca_privillages;

    if (!$usrm_username and !$usrm_id and !$ca_privillages) {

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



//Register New User- Here user creates their own account
if ($_POST['doRegister'] and $_POST['fname'] and $_POST['username'] and $_POST['Institution'] and $_POST['phone'] and $_POST['email']) {
    // captcha 
    //when validation code doesnt match, then an error message is displayed, else the user will be registered
    if (empty($_SESSION['captcha_code']) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0) {
        $message = '<p class="error" style="font-size:18px; padding:10px;">The Validation code does not match!</p>';
    } else {
        require("pages/class.phpmailer.php");
        require("pages/class.smtp.php");

        //Get Country details
        $Nationality = $mysqli->real_escape_string($_POST['Nationality']);
        $username = $mysqli->real_escape_string($_POST['username']);
        $fname = $mysqli->real_escape_string($_POST['fname']);
        $sname = $mysqli->real_escape_string($_POST['sname']);
        $phone = $mysqli->real_escape_string($_POST['phone']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $Gender = $mysqli->real_escape_string($_POST['Gender']);
        $Qualifications = $mysqli->real_escape_string($_POST['Qualifications']);
        $master2 = md5($_POST['email']); ///md5 email
        $Institution = $mysqli->real_escape_string($_POST['Institution']);

        $date = $mysqli->real_escape_string($_POST['date']);
        $month = $mysqli->real_escape_string($_POST['month']);
        $yearm = $mysqli->real_escape_string($_POST['yearm']);
        $dob = ($yearm . '-' . $month . '-' . $date);

        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $md5pass = md5($mysqli->real_escape_string($_POST['pwd']));
        $NotPassword = $mysqli->real_escape_string($_POST['pwd']);

        $hostmain = $_SERVER['HTTP_HOST'];
        $host_upper = strtoupper($host);
        $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        $length = 25;
        $refNo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

        $sqlUsers = "SELECT * FROM " . $prefix . "musers where `usrm_email`='$email'";
        $QueryUsers = $mysqli->query($sqlUsers);
        $totalUsers = $QueryUsers->num_rows;

        if ($totalUsers) {
            $errormessage = '<p class="error" style="font-size:18px;">Username with email address already exists <b>' . $email . '</b>. <a href="#" class="nav-link join_now js-modal-show">' . $lang_ClickheretoLogin . '</a></p>';
            $error = "error";
        }

        if (!$totalUsers) {
            $sqlA2 = "insert into " . $prefix . "musers (`usrm_username`,`usrm_NameofInstitution`,`usrm_fname`,`usrm_sname`,`usrm_Nationality`,`usrm_password`,`usrm_phone`,`usrm_email`,`usrm_updated`,`usrm_approved`,`usrm_usrtype`,`usrm_profilepic`,`usrm_no`,`usrm_gender`,`usrm_Qualification`,`usrm_dob`) values('$username','$Institution','$fname','$sname','$Nationality','$md5pass','$phone','$email',now(),'0','user','$newname','$master2','$Gender','$Qualifications','$dob')";
            $mysqli->query($sqlA2);

            // SMTP DETAILS for email
            $usmtpportNo = "465"; // SMTP Port
            $usmtpHost = "smtp.hostinger.com";
            $emailUsername = "emmanuel@mannie-sl.com";
            $emailPassword = "Emmanuel12555.";
            $emailSSL = "ssl";
            $emailBcc = "emmanuel@mannie-sl.com";
            $fromEmail = "emmanuel@mannie-sl.com";
            $fromName = "NCRST Grant Management";

            // Create a simpler, more reliable HTML email
            $emailBody = '<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NCRST Grant Management System - Welcome</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; font-size: 16px; line-height: 1.5; color: #333333;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 0 auto;">
        <tr>
            <td style="background-color: #00457C; padding: 20px; text-align: center;">
                <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: normal;">NCRST Grant Management System</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; background-color: #ffffff;">
                <p style="font-weight: bold;">Dear ' . $fname . ',</p>
                <p>' . (!empty($lang_account_creation_message) ? $lang_account_creation_message : 'An account has been created for you on Grants Management. Please click the link below to login or copy and paste link in your browser.
After Registration Confirmation, you can proceed to login') . '</p>
                
                <div style="text-align: center; margin: 25px 0;">
                    <a href="https://' . $hostmain . $path . '/confirm.php?uncrd=' . $master2 . '&code=' . $refNo . '" style="background-color: #00457C; color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-weight: bold; display: inline-block;">' . (!empty($lang_ClicktoActivateAccount) ? $lang_ClicktoActivateAccount : 'Activate Your Account') . '</a>
                </div>
                
                <p>If the button above doesn\'t work, please copy and paste the following link into your browser:</p>
                <p><a href="https://' . $hostmain . $path . '/confirm.php?uncrd=' . $master2 . '&code=' . $refNo . '" style="color: #00457C; text-decoration: underline;">https://' . $hostmain . $path . '/confirm.php?uncrd=' . $master2 . '&code=' . $refNo . '</a></p>
                
                <div style="border-top: 1px solid #eeeeee; margin: 20px 0;"></div>
                
                <p>Once your account is activated, you will be able to:</p>
                <ul>
                    <li>Apply for available grants</li>
                    <li>Track your application status</li>
                    <li>Communicate with the grants team</li>
                    <li>Access resources and guidelines</li>
                </ul>
                
                <p>If you have any questions or need assistance, please don\'t hesitate to contact our support team.</p>
            </td>
        </tr>
        <tr>
            <td style="background-color: #f5f5f5; padding: 20px; text-align: center; font-size: 14px; color: #666666;">
                <p>&copy; ' . date('Y') . ' NCRST Grant Management System</p>
                <p>' . (!empty($fulladdress) ? $fulladdress : 'National Science, Technology and Innovation Council<br>Freetown, Sierra Leone') . '</p>
                <p>This is an automated message. Please do not reply to this email.</p>
            </td>
        </tr>
    </table>
</body>
</html>';

            // Plain text alternative
            $textBody = "Dear $fname,

" . (!empty($lang_account_creation_message) ? strip_tags($lang_account_creation_message) : 'An account has been created for you on Grants Management. Please click the link below to login or copy and paste link in your browser.
After Registration Confirmation, you can proceed to login') . "

To activate your account, please visit:
https://$hostmain$path/confirm.php?uncrd=$master2&code=$refNo

Once your account is activated, you will be able to:
- Apply for available grants
- Track your application status
- Communicate with the grants team
- Access resources and guidelines

If you have any questions or need assistance, please don't hesitate to contact our support team.

© " . date('Y') . " NCRST Grant Management System
" . (!empty($fulladdress) ? strip_tags($fulladdress) : 'National Science, Technology and Innovation Council
Freetown, Sierra Leone') . "

This is an automated message. Please do not reply to this email.";

            // PHPMailer settings
            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            $mail->Port = $usmtpportNo;
            $mail->CharSet = "utf-8";
            $mail->Host = $usmtpHost;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = $emailSSL;
            $mail->Username = $emailUsername;
            $mail->Password = $emailPassword;
            $mail->SMTPDebug = 0; // Set to 2 for debugging, 0 for production

            // Email content
            $mail->setFrom($emailUsername, "NCRST Grants Management");
            $mail->AddAddress($email, $fname . ' ' . $sname);
            $mail->AddReplyTo($fromEmail, (!empty($lang_grants_management_system) ? $lang_grants_management_system : 'NCRST Grants Management') . " - User Registration");

            // Email settings
            $mail->WordWrap = 50;
            $mail->IsHTML(true); // Must be true for HTML email
            $mail->Subject = "Welcome to NCRST Grant Management System";
            $mail->Body = $emailBody; // Set the HTML body directly
            $mail->AltBody = $textBody; // Plain text alternative

            // Send the email
            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
                error_log("PHPMailer Error: " . $mail->ErrorInfo);
            } else {
                // Log successful email sending
                $sqlA = "INSERT INTO " . $prefix . "mlogs (log_details, logname, logemail, logip, logdate) VALUES('Registration confirmation email sent to $fname', '" . (isset($_SESSION['mmfullname']) ? $_SESSION['mmfullname'] : 'System') . "', '$email', '" . $_SERVER['REMOTE_ADDR'] . "', now())";
                $mysqli->query($sqlA);
            }

            $message = '<p class="success" style="font-size:18px; padding:10px;">Dear ' . $fname . ' ' . (!empty($lang_accounthasbeensuccessfully) ? $lang_accounthasbeensuccessfully : 'your account has been successfully created') . ' .</p>';
            $error = "success";
        } // end totals
    } // end captcha check
} // end POST check //end post


//Below user re-sets password
if ($_POST['doResendANumber'] and $_POST['name']) {

    require("pages/class.phpmailer.php");
    require("pages/class.smtp.php");

    $email = $mysqli->real_escape_string($_POST['name']);
    $hostmain  = $_SERVER['HTTP_HOST'];
    $host_upper = strtoupper($host);
    $path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

    $length = 25;
    $refNo = md5(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length));

    $sqlUsers = "SELECT * FROM " . $prefix . "musers where `usrm_email`='$email'";
    $QueryUsers = $mysqli->query($sqlUsers);
    $totalUsers = $QueryUsers->num_rows;
    $r = $QueryUsers->fetch_array();
    $user_email = $r['usrm_email'];
    $usrm_username = $r['usrm_username'];

    $fullName = $r['usrm_fname'] . ' ' . $r['usrm_lname'];

    if (!$totalUsers) {
        $message = '<p class="error">' . $lang_email . ' <b>' . $email . '</b> ' . $lang_doesnotexists . '</p>';
    }


    if ($totalUsers) {
        $hostmain  = $_SERVER['HTTP_HOST'];
        $host_upper = strtoupper($host);
        $path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

        $message = '<p class="error">&nbsp;' . $lang_grants_management_system . ' - ' . $lang_password_reset . ' <strong>&nbsp;inbox or junk</strong>.';
        $length = 25;
        $refNo = md5(substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length));

        $rs_activ = $mysqli->query("update " . $prefix . "musers set usrm_no='$refNo' WHERE `usrm_email`='$email'");

        $error = "error";

        $usmtpportNo = "465"; // SMTP Port
            $usmtpHost = "smtp.hostinger.com";
            $emailUsername = "emmanuel@mannie-sl.com";
            $emailPassword = "Emmanuel12555.";
            $emailSSL = "ssl";
            $emailBcc = "emmanuel@mannie-sl.com";

        // Email content
        $fromEmail = "emmanuel@mannie-sl.com";
        $fromName = "NCRST Grant Management";
        $subject = "NCRST Grant Management System - Password Reset";
        //$subject = (isset($lang_NCRST_grants_management_system) ? $lang_NCRST_grants_management_system : "Grants Management System") . " - " . $lang_passwordReset;
        //$body = "<p>Dear $fname,<br>$lang_password_reset_message</p>";


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
        $mail->setFrom("$emailUsername", "Grants Management");

        $mail->addBcc($emailBcc, $lang_NCRST_grant_management_system);
        $mail->AddAddress($email, $sname); // To Address -- CHANGE --
        $mail->AddReplyTo($fromEmail, $lang_NCRST_grants_management_system . "-" . $lang_passwordReset); // Reply-To Address -- CHANGE --

        $mail->WordWrap = 50; // set word wrap to 50 characters
        $mail->IsHTML(false); // set email format to HTML
        $mail->Subject = "$lang_grants_management_system - $lang_passwordReset";
        $body = "
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

        if (!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
        //echo "Message has been sent";
    }
} //end post

$vision = $mysqli->real_escape_string($_GET['subs']);

//User inputs new password after clicking re-set window
if (isset($vision) && !empty($vision)) {
    //$mysqli->real_escape_string(
    $user = $mysqli->real_escape_string($_GET['subs']);
    $activ = $mysqli->real_escape_string($_GET['subs']);
    $hostmain  = $_SERVER['HTTP_HOST'];
    $host_upper = strtoupper($host);
    $path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    //check if activ code and user is valid
    $rs_check = $mysqli->query("select * from " . $prefix . "musers where usrm_no='$activ'");
    $num = $rs_check->num_rows;
    $r = $rs_check->fetch_array();
    $email = $r['usrm_email'];
    $dbusrm_fname = $r['usrm_fname'];
    $usrm_username = $r['usrm_username'];
    // Match row found with more than 1 results  - the user is authenticated. 
    if ($num <= 0) {
        $errormsgforgot = '<p class="error">$lang_expired_link <br><a href="https://$hostmain$path/forgot-password.php" class="text-center" style="color:#ffffff; text-decoration:underline; font-size:16px;">Click here to re-set password again.</a></p>';
        $errormsg = "true";
    }
    if ($num >= 1) {

        if ($mysqli->real_escape_string($_POST['doResetPassword'] == 'Change Password')) {
            $md5pass = $mysqli->real_escape_string(md5($_POST['pwd']));
            $Notmd5pass = $mysqli->real_escape_string($_POST['pwd']);

            ////////////////////////////Now, send a mail
            require("pages/class.phpmailer.php");
            require("pages/class.smtp.php");

            $usmtpportNo = "465"; // SMTP Port
            $usmtpHost = "smtp.hostinger.com";
            $emailUsername = "emmanuel@mannie-sl.com";
            $emailPassword = "Emmanuel12555.";
            $emailSSL = "ssl";
            $emailBcc = "emmanuel@mannie-sl.com";

        // Email content
        $fromEmail = "emmanuel@mannie-sl.com";
            $fromName = "NCRST Grant Management";
            $subject = "NCRST Grant Management System - Password Re-set";
            $body = "<p>Dear $fname,<br>$lang_Password_Reset_message";

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
            $mail->setFrom("$emailUsername", "Grants Management");


            $mail->AddAddress($email, $sname); // To Address -- CHANGE --
            $mail->AddReplyTo("$emailUsername", "$lang_grants_management_system - Password Re-set"); //Reply-To Address -- CHANGE --
            $mail->addBcc("$emailBcc", '$lang_grants_management_system - Password Re-set');

            $mail->WordWrap = 50; // set word wrap to 50 characters
            $mail->IsHTML(false); // set email format to HTML
            $mail->Subject = "$lang_grants_management_system Password Updated";
            $body = "
$lang_Dear $dbusrm_fname, $lang_your_password_with<br>
$lang_youcan_now_login<br><br>
Username: $usrm_username<br>
Password: $Notmd5pass<br><br>
https://$hostmain$path/<br>
<a href='https://$hostmain$path/'>Click to Login</a>
<br><br>

$lang_grants_management_system<br>
$fulladdress


";
            $mail->MsgHTML($body);
            if (!$mail->Send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }

            // set the approved field to 1 to comfirm the account
            $rs_activ = $mysqli->query("update " . $prefix . "musers set usrm_password='$md5pass',usrm_no='' WHERE usrm_no= '$activ' ");/**/

            $msg = "<p class='success'>Congratulations!!!. Your password with NCRST Grants Management System has been re-set, you can now login by clicking on Login below<br><br><a href='https://$hostmain$path/' class='text-center' style='color:#000000; text-decoration:underline; font-size:16px;'>$lang_ClickheretoLogin</a></p>";
            $errormsg = "false";
        }
    }
}


function RecentCalls()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today, $lang_Deadline, $lang_ClicktoViewDetails;

    $sqlGroupDIspC = "SELECT *,DATE_FORMAT(`startDate`,'%d %M, %Y') AS startDate,DATE_FORMAT(`EndDate`,'%d %M, %Y') AS EndDate,DATE_FORMAT(`EndDate`,'%b') AS month,DATE_FORMAT(`EndDate`,'%d') AS date FROM " . $prefix . "grantcalls where EndDate>='$today' and publish='Yes' order by grantID desc limit 0,10";
    $sqlFGrpDisC = $mysqli->query($sqlGroupDIspC);
    $totalUserReports = $sqlFGrpDisC->num_rows;

    // Start the card container
    echo '<div class="recent-calls-grid">';

    // Check if there are any recent calls
    if ($totalUserReports > 0) {
        while ($rGRSPC = $sqlFGrpDisC->fetch_array()) { ?>
            <div class="call-card">
                <!-- Date badge -->
                <div class="call-date">
                    <span class="date-day"><?php echo $rGRSPC['date']; ?></span>
                    <span class="date-month"><?php echo $rGRSPC['month']; ?></span>
                </div>

                <!-- Call content -->
                <div class="call-content">
                    <h3 class="call-title"><a href="grant-details.php?id=<?php echo $rGRSPC['grantID']; ?>"><?php echo $rGRSPC['title']; ?></a></h3>

                    <div class="call-meta">
                        <div class="deadline">
                            <i class="flaticon-clock-circular-outline"></i>
                            <span><?php echo $lang_Deadline; ?>: <?php echo $rGRSPC['EndDate']; ?></span>
                        </div>
                    </div>

                    <div class="call-actions">
                        <div class="button-group">
                            <a href="grant-details.php?id=<?php echo $rGRSPC['grantID']; ?>" class="view-details-btn">
                                <?php echo $lang_ClicktoViewDetails; ?>
                            </a>

                            <a href="#" class="apply-btn nav-link sign-in js-modal-show" data-redirect="app/main.php?option=apply&grant_id=<?php echo $rGRSPC['grantID']; ?>">
                                <i class="fa fa-paper-plane"></i> Apply Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    } else {
        // Display message when no recent calls are available
        echo '<div class="no-calls-message">
                <p>No Call Available at the moment. You can click the View All Grants button to see past Grants.</p>
              </div>';
    }

    // End the card container
    echo '</div>';
}

function TotalCalls()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sqlGrants = "SELECT * FROM " . $prefix . "grantcalls where EndDate>='$today' and publish='Yes' order by grantID desc";
    $sqlGrants = $mysqli->query($sqlGrants);
    echo $totalGrants = $sqlGrants->num_rows;
}
function NumberofSubmissionsReceived()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sqlGrants1 = "SELECT * FROM " . $prefix . "submissions_concepts order by conceptID desc";
    $sqlGrants1 = $mysqli->query($sqlGrants1);
    $totalGrants1 = $sqlGrants1->num_rows;
    ///Get Proposals as well
    $sqlGrants2 = "SELECT * FROM " . $prefix . "submissions_proposals order by projectID desc";
    $sqlGrants2 = $mysqli->query($sqlGrants2);
    $totalGrants2 = $sqlGrants2->num_rows;
    echo ($totalGrants1 + $totalGrants2);
}

function GrantsAwarded()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sqlGrants1 = "SELECT * FROM " . $prefix . "submissions_concepts where awarded='Yes' order by conceptID desc";
    $sqlGrants1 = $mysqli->query($sqlGrants1);
    $totalGrants1 = $sqlGrants1->num_rows;
    ///Get Proposals as well
    $sqlGrants2 = "SELECT * FROM " . $prefix . "submissions_proposals where awarded='Yes' order by projectID desc";
    $sqlGrants2 = $mysqli->query($sqlGrants2);
    $totalGrants2 = $sqlGrants2->num_rows;
    echo ($totalGrants1 + $totalGrants2);
}

function TotalUsers()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sqlUsers = "SELECT * FROM " . $prefix . "musers order by usrm_id desc";
    $sqlUsers = $mysqli->query($sqlUsers);
    echo $totalUsers = $sqlUsers->num_rows;
}

function Slider()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sql_slider = "SELECT * FROM " . $prefix . "slider order by rank asc limit 0,4";
    $sqlF_slider = $mysqli->query($sql_slider);
    while ($rs_slider = $sqlF_slider->fetch_array()) {
    ?>
        <li data-index="rs-1708"
            data-transition="fade"
            data-slotamount="7"
            data-hideafterloop="0"
            data-hideslideonmobile="off"
            data-easein="default"
            data-easeout="default"
            data-masterspeed="1000"
            data-rotate="0"
            data-saveperformance="off"
            data-title="Slide">

            <div class="slider-overlay"></div>

            <!-- Responsive background image -->
            <img src="images/banner/<?php echo $rs_slider['image']; ?>"
                alt="<?php echo $rs_slider['txt_1']; ?>"
                class="rev-slidebg"
                data-bgposition="center center"
                data-bgfit="cover"
                data-bgrepeat="no-repeat"
                data-bgparallax="10"
                data-no-retina>

            <!-- LAYER 1: Subtitle text with responsive settings -->
            <div class="tp-caption font-lora sfb tp-resizeme letter-space-5 h-p"
                data-x="['left','left','center','center']"
                data-hoffset="['0','0','0','0']"
                data-y="['middle','middle','middle','middle']"
                data-voffset="['-200','-180','-150','-120']"
                data-fontsize="['20','18','16','14']"
                data-lineheight="['70','60','50','40']"
                data-width="['none','none','480','320']"
                data-height="none"
                data-whitespace="['nowrap','nowrap','normal','normal']"
                data-type="text"
                data-responsive_offset="on"
                data-frames='[{"from":"z:0;rX:0;rY:0;rZ:0;sX:0.9;sY:0.9;skX:0;skY:0;opacity:0;","speed":400,"to":"o:1;","delay":100,"split":"chars","splitdelay":0.05,"ease":"Power3.easeInOut"},{"delay":"wait","speed":100,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                style="z-index: 7; color:#f58f14; font-family:'Rubik', sans-serif; max-width: auto; max-height: auto; white-space: nowrap; font-weight:500;">
                <?php echo $rs_slider['txt_1']; ?>
            </div>

            <!-- LAYER 2: Main heading with responsive settings -->
            <div class="tp-caption NotGeneric-Title tp-resizeme"
                id="slide-3045-layer-11"
                data-x="['left','left','center','center']"
                data-hoffset="['0','0','0','0']"
                data-y="['middle','middle','middle','middle']"
                data-voffset="['-120','-100','-80','-60']"
                data-fontsize="['65','55','45','32']"
                data-lineheight="['70','60','50','40']"
                data-width="['none','none','480','320']"
                data-height="none"
                data-whitespace="['nowrap','nowrap','normal','normal']"
                data-type="text"
                data-responsive_offset="on"
                data-frames='[{"from":"x:[105%];z:0;rX:45deg;rY:0deg;rZ:90deg;sX:1;sY:1;skX:0;skY:0;","mask":"x:0px;y:0px;s:inherit;e:inherit;","speed":2000,"to":"o:1;","delay":1000,"split":"chars","splitdelay":0.05,"ease":"Power4.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
                data-textAlign="['left','left','center','center']"
                data-paddingtop="[10,10,10,10]"
                data-paddingright="[0,0,0,0]"
                data-paddingbottom="[10,10,10,10]"
                data-paddingleft="[0,0,0,0]"
                style="z-index: 5; color:#f58f14; font-family:'Roboto', sans-serif; font-weight: 700; white-space: nowrap; text-transform:left;">
                <?php echo $rs_slider['txt_2']; ?>
            </div>

            <!-- LAYER 5: Button with responsive positioning and sizing -->
            <div class="tp-caption rev-btn rev-btn right-btn"
                id="slide-2939-layer-15"
                data-x="['left','left','center','center']"
                data-hoffset="['250','180','0','0']"
                data-y="['middle','middle','middle','middle']"
                data-voffset="['75','80','80','70']"
                data-fontsize="['14','13','12','11']"
                data-lineheight="['34','32','30','28']"
                data-width="none"
                data-height="none"
                data-whitespace="nowrap"
                data-type="button"
                data-actions='[{"event":"click","action":"jumptoslide","slide":"rs-2939","delay":""}]'
                data-responsive_offset="on"
                data-responsive="on"
                data-frames='[{"from":"x:-50px;opacity:0;","speed":1000,"to":"o:1;","delay":1750,"ease":"Power2.easeOut"},{"delay":"wait","speed":1500,"to":"opacity:0;","ease":"Power4.easeIn"},{"frame":"hover","speed":"300","ease":"Linear.easeNone","to":"o:1;rX:0;rY:0;rZ:0;z:0;","style":"c:#fff;bg:#ff5a2c;bw:2px 2px 2px 2px; "}]'
                data-textAlign="['center','center','center','center']"
                data-paddingtop="[12,10,10,8]"
                data-paddingright="[40,35,30,25]"
                data-paddingbottom="[12,10,10,8]"
                data-paddingleft="[40,35,30,25]"
                style="z-index: 14; white-space: nowrap; font-weight:500; color:#fff; font-family:Rubik; text-transform:uppercase; background-color:blue; letter-spacing:1px; border-radius: 3px;">
                <?php echo $rs_slider['txt_3']; ?>
            </div>
        </li>
    <?php } // End loop
} // End Function

function WelcomeText()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sql_welcome = "SELECT * FROM " . $prefix . "pages where section='welcome' order by rank asc limit 0,1";
    $sqlF_welcome = $mysqli->query($sql_welcome);
    while ($rs_welcome = $sqlF_welcome->fetch_array()) {
    ?><div class="col-12 col-sm-6 col-md-7 col-lg-7">
            <div class="story_banner">
                <img src="images/banner/<?php echo $rs_welcome['image_file']; ?>" alt="" class="img-fluid">
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-5 col-lg-5">
            <div class="about_story_title">
                <h2><?php echo $rs_welcome['title']; ?></h2>
                <?php echo $rs_welcome['details']; ?>

            </div>
        </div>


    <?php } // ENd loop
} // End Function

function TopBarTelephone()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sql_welcome_2 = "SELECT * FROM " . $prefix . "pages where section='tel_top' order by rank asc limit 0,1";
    $sqlF_welcome_2 = $mysqli->query($sql_welcome_2);
    $rs_welcome_2 = $sqlF_welcome_2->fetch_array();
    ?>

    <li><i class="flaticon-phone-receiver"></i><?php echo $rs_welcome_2['details']; ?></li>
<?php
} // End Function

function TopBarTelephoneBottom()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sql_welcome_2 = "SELECT * FROM " . $prefix . "pages where section='tel_top' order by rank asc limit 0,1";
    $sqlF_welcome_2 = $mysqli->query($sql_welcome_2);
    $rs_welcome_2 = $sqlF_welcome_2->fetch_array();
?>
    <span><?php echo $rs_welcome_2['details']; ?></span>
<?php
} // End Function

function TopBarEmail()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sql_welcome_3 = "SELECT * FROM " . $prefix . "pages where section='email_top' order by rank asc limit 0,1";
    $sqlF_welcome_3 = $mysqli->query($sql_welcome_3);
    $rs_welcome_3 = $sqlF_welcome_3->fetch_array();
?>
    <li><i class="flaticon-mail-black-envelope-symbol"></i><?php echo $rs_welcome_3['details']; ?></li>

<?php
} // End Function

function TopBarEmailBottom()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sql_welcome_3 = "SELECT * FROM " . $prefix . "pages where section='email_top' order by rank asc limit 0,1";
    $sqlF_welcome_3 = $mysqli->query($sql_welcome_3);
    $rs_welcome_3 = $sqlF_welcome_3->fetch_array();
?>
    <span class="email"><?php echo $rs_welcome_3['details']; ?></span>

    <?php
} // End Function

function Sponsors()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sql_sponsors = "SELECT * FROM " . $prefix . "pages_collaboration order by rank asc limit 0,10";
    $sqlF_sponsors = $mysqli->query($sql_sponsors);
    while ($rs_sponsors = $sqlF_sponsors->fetch_array()) {
    ?>
        <li><a href="<?php echo $rs_sponsors['logo_link']; ?>" target="_blank"><img src="images/logos/<?php echo $rs_sponsors['logo_img']; ?>" alt="" class="img-fluid  wow fadeIn" data-wow-duration="2s" data-wow-delay=".1s" border="0"></a></li>
    <?php
    }
} // End Function

function SocialMedia()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

    $sql_socialmedia = "SELECT * FROM " . $prefix . "pages_socialmedia order by rank asc limit 0,1";
    $sqlF_socialmedia = $mysqli->query($sql_socialmedia); //'facebook','twitter','linkedin','integram','youtube'
    while ($rs_socialmedia = $sqlF_socialmedia->fetch_array()) {
    ?>

        <?php if ($rs_socialmedia['facebook']) { ?><li><a href="<?php echo $rs_socialmedia['facebook']; ?>" target="_blank"><i class="fab fa-facebook-f fb-icon"></i></a></li><?php } ?>
        <?php if ($rs_socialmedia['twitter']) { ?><li><a href="<?php echo $rs_socialmedia['twitter']; ?>" target="_blank"><i class="fab fa-twitter twitt-icon"></i></a></li><?php } ?>
        <?php if ($rs_socialmedia['linkedin']) { ?><li><a href="<?php echo $rs_socialmedia['linkedin']; ?>" target="_blank"><i class="fab fa-linkedin-in link-icon"></i></a></li><?php } ?>
        <?php if ($rs_socialmedia['integram']) { ?><li><a href="<?php echo $rs_socialmedia['integram']; ?>" target="_blank"><i class="fab fa-instagram ins-icon"></i></a></li><?php } ?>
        <?php if ($rs_socialmedia['youtube']) { ?><li><a href="<?php echo $rs_socialmedia['youtube']; ?>" target="_blank"><i class="fab fa-youtube ins-icon"></i></a></li><?php } ?>

<?php
    }
} // End Function

?>