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

if ($_POST['doLogin'] == 'Sign me in') {

  $name = $mysqli->real_escape_string($_POST['name']);
  $md5pass = md5($mysqli->real_escape_string($_POST['pwd']));

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
    $mysqli->query($sqlA);
    echo ("<script>location.href = './main.php?option=dashboard';</script>");
    //header("location:./main.php?option=dashboard");

  }

  if ($totalUser == 1 && $dbusrm_approved == "1" and $dbusrm_usrtype == 'reviewer') {
    $err2 = '<span class="error">Thank You for reviewing the NSTIP 2017 Proposals. </span>';
  } else {
    $err2 = '<span class="error">Error: Wrong username, password!</span>';
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
$categoryID = $mysqli->real_escape_string($_GET['categoryID']);
$conceptID = $mysqli->real_escape_string($_GET['conceptID']);
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

    header("Location: $base_url");
    //die("You are not authorized to see this page");
  }

  $timeout = 400; // Set timeout minutes
  $logout_redirect_url = "$base_url"; // Set logout URL

  $timeout = $timeout * 60; // Converts minutes to seconds
  if (isset($_SESSION['start_time'])) {
    $elapsed_time = time() - $_SESSION['start_time'];
    if ($elapsed_time >= $timeout) {
      session_destroy();
      header("Location: $logout_redirect_url");
    }
  }
}
function GenerateCategories()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id;

  $sqlGroupDIspC = "SELECT cpt_sector FROM " . $prefix . "concepts group by cpt_sector";
  $sqlFGrpDisC = $mysqli->query($sqlGroupDIspC);
  $totalUserReports = $sqlFGrpDisC->num_rows;
  //$category=$_POST['category'];


?>
  <form action="" method="post">
    <select name="category" class="select">
      <?php
      while ($rGRSPC = $sqlFGrpDisC->fetch_array()) { ?>
        <option value="<?php echo $rGRSPC['cpt_sector']; ?>" <?php if ($_POST['category'] == $rGRSPC['cpt_sector']) { ?>selected="selected" <?php } ?>>&nbsp;<?php echo $rGRSPC['cpt_sector']; ?> </option>
      <?php } ?>
    </select>

    <input name="doSearch" type="submit" value="Search Category" class="serch" />
  </form>
  <?php

}
function CheckSubmittedCVS()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id;
  $querysrtcvs = "select * from " . $prefix . "concepts_cvs where usrm_id='$usrm_id'";
  $rs_seeecvs = $mysqli->query($querysrtcvs);
  $totalUsercvs = $rs_seeecvs->num_rows;
  $rsusercvs = $rs_seeecvs->fetch_array();
  /////////////
  $querysrtcvsallmm = "select * from " . $prefix . "concepts where usrm_id='$usrm_id'";
  $rs_seeecvsallmm = $mysqli->query($querysrtcvsallmm);
  $totalUsercvsMM = $rs_seeecvsallmm->num_rows;
  $rsusercvsNotify = $rs_seeecvsallmm->fetch_array();
  /////////////////////////////////////////////////////
  $queryuser = "select * from " . $prefix . "musers where usrm_id='$usrm_id' and usrm_usrtype='user'";
  $rs_user = $mysqli->query($queryuser);
  $userExists = $rs_user->num_rows;
  $rsusenot = $rs_user->fetch_array();
  $email = $rsusenot['usrm_email'];
  $nameofpi = $rsusenot['usrm_fname'] . ' ' . $rsusenot['usrm_sname'];

  if ($totalUsercvs <= 2 and $totalUsercvsMM and $userExists) {
  ?>
    <div class="redflag">
      <h3>Important!! <br />You have uploaded <strong><?php echo $totalUsercvs; ?> cvs</strong>, you need to upload atleast 2 Cvs for your application to be considered. On your left hand side or click add Cvs. Click view my Cvs to see those you have uploaded</h3>

    </div>

  <?php
  }
  if ($totalUsercvs >= 2 and $rsusercvsNotify['sentNotify'] == 'No' and $userExists) {
  ?>
    <div class="successflag">
      <h3>Congratulations, you have uploaded a minimum of <strong><?php echo $totalUsercvs; ?></strong> Cvs for your application. You can as well upload more. Minimum is Two (2) cvs and Maximum is ten (10) cvs. Please review them to confirm</h3>
    </div>

  <?php
  }
  if ($totalUsercvs >= 2 and $rsusercvsNotify['sentNotify'] == 'No' and $userExists) {

    require("viewlrcn/class.phpmailer.php");
    require("viewlrcn/class.smtp.php");
    $proposalTittle = $rsusercvsNotify['proposalmTittle'];
    $NameofInstitution = $rsusercvsNotify['conceptm_NameofInstitution'];
    $refno = $rsusercvsNotify['referenceno'];

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
    $mail->FromName = "Public - Private Partnerships"; //From Name -- CHANGE --


    $mail->addBcc("$emailBcc", 'Public - Private Partnerships');
    $mail->addBcc('sgcigrants.uncst.go.ug', 'Public - Private Partnerships');


    $mail->AddAddress($email, $nameofpi); //To Address -- CHANGE --
    $mail->AddReplyTo("sgcigrants.uncst.go.ug", "Public - Private Partnerships"); //Reply-To Address -- CHANGE --

    $mail->WordWrap = 50; // set word wrap to 50 characters
    $mail->IsHTML(false); // set email format to HTML
    $mail->Subject = "Public - Private Partnerships - Concept Received";
    $body = "
<p>Hello $nameofpi!<br>
This is an automatic Email sent from Public - Private Partnerships submission system. Your concept has been received.</p>

<p>Proposal Title: <b>$proposalTittle</b><br>
Name of PI: $nameofpi<br>
Name of Institution: $NameofInstitution<br>
Reference No: $refno</p>

<p>Thank you for responding to the Public - Private Partnerships (PPP) in Research and Innovation Grants call. We wish the best of Luck.<br>

Regards</p>

<p>$fulladdress
</p>

";
    $mail->MsgHTML($body);

    if (!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    }
    $upmDate = "update " . $prefix . "concepts set sentNotify='Yes' where usrm_id='$usrm_id'";
    $mysqli->query($upmDate);
  }
}

function GenerateReviewrs()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id;

  $sqlGroupDIspC = "SELECT * FROM " . $prefix . "musers where usrm_usrtype='reviewer' order by usrm_fname asc";
  $sqlFGrpDisC = $mysqli->query($sqlGroupDIspC);
  $totalUserReports = $sqlFGrpDisC->num_rows;
  //$category=$_POST['category'];


  ?>
  <form action="" method="post">
    <select name="reviewer" class="select">
      <option value="">Please Select Reviewer</option>
      <?php
      while ($rGRSPC = $sqlFGrpDisC->fetch_array()) { ?>
        <option value="<?php echo $rGRSPC['usrm_id']; ?>" <?php if ($_POST['reviewer'] == $rGRSPC['usrm_id']) { ?>selected="selected" <?php } ?>>&nbsp;<?php echo $rGRSPC['usrm_fname']; ?> </option>
      <?php } ?>
    </select>

    <input name="doSearch" type="submit" value="Search Reviewer" class="serch" />
  </form>
<?php

}
function GenerateReviewrsByCategory()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id;

  $sqlGroupDIspC = "SELECT * FROM " . $prefix . "concepts  group by cpt_sector order by cpt_sector asc";
  $sqlFGrpDisC = $mysqli->query($sqlGroupDIspC);
  $totalUserReports = $sqlFGrpDisC->num_rows;
  //$category=$_POST['category'];


?>
  <form action="" method="post">
    <select name="category" class="select">
      <option value="">Please Select Category</option>
      <?php
      while ($rGRSPC = $sqlFGrpDisC->fetch_array()) { ?>
        <option value="<?php echo $rGRSPC['cpt_sector']; ?>" <?php if ($_POST['category'] == $rGRSPC['cpt_sector']) { ?>selected="selected" <?php } ?>>&nbsp;<?php echo $rGRSPC['cpt_sector']; ?> </option>
      <?php } ?>
    </select>

    <input name="doSearch" type="submit" value="Search Category" class="serch" />
  </form>
<?php

}
////////end time out///////////////////////////////////////////////////////////////////////

function User()
{
  global $usrm_username, $usrm_id, $session_usertype, $session_fullname;
}
function UserRegistrationsDisp()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id;

  $sqlGroupDIsp = "SELECT count(*) as TotalUsers FROM " . $prefix . "musers";
  $sqlFGrpDis = $mysqli->query($sqlGroupDIsp);
  $rGRSP = $sqlFGrpDis->fetch_array();
  echo $rGRSP['TotalUsers'];
}

function ConferenceDisp()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActive = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='new'";
  $sqlConfsActive = $mysqli->query($sqlConfsActive);
  $rConfsActive = $sqlConfsActive->fetch_array();
  echo $rConfsActive['TotalConfs'];
}

function TotalApplicantsYR()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActivedfdoow = "SELECT count(*) as TotalApplis FROM " . $prefix . "musers where usrm_usrtype='user'";
  $sqlConfsActivedfdoowe = $mysqli->query($sqlConfsActivedfdoow);
  $rConfsActivedfdof = $sqlConfsActivedfdoowe->fetch_array();
  echo $rConfsActivedfdof['TotalApplis'];
}
function TotalReviewersYR()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActivedfdoo = "SELECT count(*) as TotalApplis FROM " . $prefix . "musers where usrm_usrtype='reviewer'";
  $sqlConfsActivedfdoo = $mysqli->query($sqlConfsActivedfdoo);
  $rConfsActivedfdo = $sqlConfsActivedfdoo->fetch_array();
  echo $rConfsActivedfdo['TotalApplis'];
}

function TotalAdminsYR()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsAdmins = "SELECT count(*) as TotalAdmins FROM " . $prefix . "musers where usrm_usrtype='superadmin' || usrm_usrtype='admin'";
  $sqlConfsAdmins = $mysqli->query($sqlConfsAdmins);
  $rConfsActivedAdmins = $sqlConfsAdmins->fetch_array();
  echo $rConfsActivedAdmins['TotalAdmins'];
}

function PendingEvaluationTotals()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActivedf = "SELECT count(*) as TotalConfDFs FROM " . $prefix . "concepts where conceptm_status='pending' and categorym='concepts'";
  $sqlConfsActivedf = $mysqli->query($sqlConfsActivedf);
  $rConfsActivedf = $sqlConfsActivedf->fetch_array();
  echo $rConfsActivedf['TotalConfDFs'];
}

function PendingEvaluationTotalsPropals()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActivedf = "SELECT count(*) as TotalConfDFs FROM " . $prefix . "concepts where conceptm_status='pending' and categorym='proposals'";
  $sqlConfsActivedf = $mysqli->query($sqlConfsActivedf);
  $rConfsActivedf = $sqlConfsActivedf->fetch_array();
  echo $rConfsActivedf['TotalConfDFs'];
}

function CompletedEvaluationTotals()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActivedfd = "SELECT count(*) as TotalEcConfs FROM " . $prefix . "concepts where conceptm_status='completed' and categorym='concepts'";
  $sqlConfsActivedfd = $mysqli->query($sqlConfsActivedfd);
  $rConfsActivedfd = $sqlConfsActivedfd->fetch_array();
  echo $rConfsActivedfd['TotalEcConfs'];
}

function CompletedEvaluationTotalsProposals()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActivedfd = "SELECT count(*) as TotalEcConfs FROM " . $prefix . "concepts where conceptm_status='completed' and categorym='proposals' and openstatus='open'";
  $sqlConfsActivedfd = $mysqli->query($sqlConfsActivedfd);
  $rConfsActivedfd = $sqlConfsActivedfd->fetch_array();
  echo $rConfsActivedfd['TotalEcConfs'];
}

function PassedEvaluationTotals()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsPassed = "SELECT count(*) as TotalPassed FROM " . $prefix . "concepts where conceptm_status='evaluated' and conceptm_Avg>=75";
  $sqlConfsPassed = $mysqli->query($sqlConfsPassed);
  $rConfsPassed = $sqlConfsPassed->fetch_array();
  echo $rConfsPassed['TotalPassed'];
}

function ForwardedSubmissions()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActive = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='forwaded'";
  $sqlConfsActive = $mysqli->query($sqlConfsActive);
  $rConfsActive = $sqlConfsActive->fetch_array();
  echo $rConfsActive['TotalConfs'];
}

function MyForwardedSubmissions()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today, $usrrsmyLoggedIdm;
  //conceptsasslogs where conceptm_assignedto='$usrm_id'
  $sqlConfsActive = "SELECT count(*) as TotalConfs FROM " . $prefix . "conceptsasslogs where `conceptm_assignedto`='$usrrsmyLoggedIdm' and `logm_status`='new'";
  $sqlConfsActive = $mysqli->query($sqlConfsActive);
  $rConfsActive = $sqlConfsActive->fetch_array();

  echo $rConfsActive['TotalConfs'];
}





function MyForwardedProposals()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today, $usrrsmyLoggedIdm;
  //conceptsasslogs where conceptm_assignedto='$usrm_id'
  $sqlConfsActive = "SELECT count(*) as TotalConfs FROM " . $prefix . "conceptsasslogs where `conceptm_assignedto`='$usrrsmyLoggedIdm' and `logm_status`='new' and `openstatus`='open'";
  $sqlConfsActive = $mysqli->query($sqlConfsActive);
  $rConfsActive = $sqlConfsActive->fetch_array();

  echo $rConfsActive['TotalConfs'];
}


function MyPendingForwardedConceptsReviwer()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today, $usrrsmyLoggedIdm;
  //conceptsasslogs where conceptm_assignedto='$usrm_id'
  $sqlConfsActive = "SELECT count(*) as TotalConfs FROM " . $prefix . "conceptsasslogs where `conceptm_assignedto`='$usrrsmyLoggedIdm' and `logm_status`='new' and categorym='proposals' and `openstatus`='open'";
  $sqlConfsActive = $mysqli->query($sqlConfsActive);
  $rConfsActive = $sqlConfsActive->fetch_array();

  echo $rConfsActive['TotalConfs'];
}


function MyCompletedProposals()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today, $usrrsmyLoggedIdm;
  //conceptsasslogs where conceptm_assignedto='$usrm_id'
  $sqlConfsActivew = "SELECT count(*) as TotalConfs FROM " . $prefix . "conceptsasslogs where `conceptm_assignedto`='$usrrsmyLoggedIdm' and `logm_status`='completed' and `openstatus`='open'";
  $sqlConfsActivew = $mysqli->query($sqlConfsActivew);
  $rConfsActivew = $sqlConfsActivew->fetch_array();

  echo $rConfsActivew['TotalConfs'];
}

function MyCompletedProposalsReviewer()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today, $usrrsmyLoggedIdm;
  //conceptsasslogs where conceptm_assignedto='$usrm_id'
  $sqlConfsActivew = "SELECT count(*) as TotalConfs FROM " . $prefix . "conceptsasslogs where `conceptm_assignedto`='$usrrsmyLoggedIdm' and `logm_status`='completed' and categorym='proposals' and `openstatus`='open'";
  $sqlConfsActivew = $mysqli->query($sqlConfsActivew);
  $rConfsActivew = $sqlConfsActivew->fetch_array();

  echo $rConfsActivew['TotalConfs'];
}




function MyCompletedSubmissions()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today, $usrrsmyLoggedIdm;
  //conceptsasslogs where conceptm_assignedto='$usrm_id'
  $sqlConfsActivep = "SELECT count(*) as TotalConfsCompleted FROM " . $prefix . "conceptsasslogs where `conceptm_assignedto`='$usrrsmyLoggedIdm' and `logm_status`='completed' and `openstatus`='open'";
  $sqlConfsActivep = $mysqli->query($sqlConfsActivep);
  $rConfsActivep = $sqlConfsActivep->fetch_array();

  echo $rConfsActivep['TotalConfsCompleted'];
}


function TotalConferenceDisp()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActive1 = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts";
  $sqlConfsActive1 = $mysqli->query($sqlConfsActive1);
  $rConfsActive1 = $sqlConfsActive1->fetch_array();
  echo $rConfsActive1['TotalConfs'];
}


function NewSubmissions()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActive1 = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='new' and categorym='proposals' and openstatus='open'";
  $sqlConfsActive1 = $mysqli->query($sqlConfsActive1);
  $rConfsActive1 = $sqlConfsActive1->fetch_array();
  echo $rConfsActive1['TotalConfs'];
}

function NotifiedforProposals()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActivett = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where categorym='concepts' and sentNotify='Yes'";
  $sqlConfsActiveff = $mysqli->query($sqlConfsActivett);
  $rConfsActiveff = $sqlConfsActiveff->fetch_array();
  echo $rConfsActiveff['TotalConfs'];
}

function NewConcepts()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActive1 = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='new' and categorym='concepts'";
  $sqlConfsActive1 = $mysqli->query($sqlConfsActive1);
  $rConfsActive1 = $sqlConfsActive1->fetch_array();
  echo $rConfsActive1['TotalConfs'];
}
function AllNewConcepts()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsActive1 = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where categorym='concepts'";
  $sqlConfsActive1 = $mysqli->query($sqlConfsActive1);
  $rConfsActive1 = $sqlConfsActive1->fetch_array();
  echo $rConfsActive1['TotalConfs'];
}

function FowardedconceptsDisp()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsPending = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='forwaded' and categorym='concepts'";
  $sqlConfsPending = $mysqli->query($sqlConfsPending);
  $rConfsPending = $sqlConfsPending->fetch_array();
  echo $rConfsPending['TotalConfs'];
}

function FowardedProposalDisp()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsPending = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='forwaded' and categorym='proposals'";
  $sqlConfsPending = $mysqli->query($sqlConfsPending);
  $rConfsPending = $sqlConfsPending->fetch_array();
  echo $rConfsPending['TotalConfs'];
}



function rejectedconceptsDisp()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsRejected = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='rejected' and categorym='concepts' and `openstatus`='open'";
  $sqlConfsRejected = $mysqli->query($sqlConfsRejected);
  $rConfsRejected = $sqlConfsRejected->fetch_array();
  echo $rConfsRejected['TotalConfs'];
}

function rejectedProposalsDisp()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsRejected = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='rejected' and categorym='proposals' and `openstatus`='open'";
  $sqlConfsRejected = $mysqli->query($sqlConfsRejected);
  $rConfsRejected = $sqlConfsRejected->fetch_array();
  echo $rConfsRejected['TotalConfs'];
}

function ApprovedforReviewDisp()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsApproved = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='approved' and categorym='concepts' and `openstatus`='open'";
  $sqlConfsApproved = $mysqli->query($sqlConfsApproved);
  $rConfsApproved = $sqlConfsApproved->fetch_array();
  echo $rConfsApproved['TotalConfs'];
}

function ApprovedforReviewDispProposal()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsApproved = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='approved' and categorym='proposals' and `openstatus`='open'";
  $sqlConfsApproved = $mysqli->query($sqlConfsApproved);
  $rConfsApproved = $sqlConfsApproved->fetch_array();
  echo $rConfsApproved['TotalConfs'];
}

function reviewedDisp()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsRejected = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts  where conceptm_status='completed' and `openstatus`='open'";
  $sqlConfsRejected = $mysqli->query($sqlConfsRejected);
  $rConfsRejected = $sqlConfsRejected->fetch_array();
  echo $rConfsRejected['TotalConfs'];
}
////////////begin packs

function TotalSubmissions()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlConfsSubmns = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='new'";
  $sqlConfsSubms = $mysqli->query($sqlConfsSubmns);
  $symposiumpaper1 = $sqlConfsSubms->fetch_array();
  ////////////////////////////////////////////////////////////////////////////
  $sqlConfsSubmns2 = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='forwarded'";
  $sqlConfsSubms2 = $mysqli->query($sqlConfsSubmns2);
  $symposiumpaper2 = $sqlConfsSubms2->fetch_array();
  ////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////
  $sqlConfsSubmns3 = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='reviewed'";
  $sqlConfsSubms3 = $mysqli->query($sqlConfsSubmns3);
  $symposiumpaper3 = $sqlConfsSubms3->fetch_array();
  ////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////
  $sqlConfsSubmns4 = "SELECT count(*) as TotalConfs FROM " . $prefix . "concepts where conceptm_status='rejected'";
  $sqlConfsSubms4 = $mysqli->query($sqlConfsSubmns4);
  $symposiumpaper4 = $sqlConfsSubms4->fetch_array();
  ////////////////////////////////////////////////////////////////////////////
?>

  <li><!-- Task item -->
    <a href="./data/submissions/">
      <h3>
        New Submissions <span style="color:#00C0EF;">[<?php echo $symposiumpaper1['TotalConfs']; ?>]</span>
      </h3>

    </a>
  </li><!-- end task item -->


  <li><!-- Task item -->
    <a href="./data/submissions/">
      <h3>
        Forwaded for Review <span style="color:#00A65A;">[<?php echo $symposiumpaper2['TotalConfs']; ?>]</span>
      </h3>

    </a>
  </li><!-- end task item -->


  <li><!-- Task item -->
    <a href="./data/submissions/">
      <h3>
        Reviewed Submissions <span style="color:#F56954;">[<?php echo $symposiumpaper3['TotalConfs']; ?>]</span>
      </h3>

    </a>
  </li><!-- end task item -->

  <li><!-- Task item -->
    <a href="./data/submissions/">
      <h3>
        Rejected Proposals <span style="color:#F39C12;">[<?php echo $symposiumpaper4['TotalConfs']; ?>]</span>
      </h3>

    </a>
  </li><!-- end task item -->
<?php
}
////////////begin packs






function SubmittedProposals()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  /*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
  $pages = 'data/';
  $url = 'pdashboard/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts where categorym='proposals' order by conceptm_date desc");
  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  $limitm = 15;                 //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where categorym='proposals' order by conceptm_date desc LIMIT $start, $limitm";
  $result = $mysqli->query($sql);

  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox">


      <tr>
        <td class="small-col" colspan="8">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>
          </div><!--end purgination section-->
        </td>
      </tr>


      <tr class="unread">
        <th width="226" class="small-col"><strong>Proposal</strong></th>
        <th width="140" class="small-col"><strong>Name Of PI</strong></th>
        <th width="174" class="name"><strong>Name of Institution</strong></th>
        <th width="136" class="subject"><strong>Contacts</strong></th>
        <th width="84" class="time"><strong>Date</strong></th>
        <th width="110" class="time"><strong>Sector</strong></th>
        <th width="126" class="time"><strong>Status</strong></th>
        <th width="110" class="time"><strong>Action</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="8">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {

          ///////////////////////////////////////////////

          $conceptm_id = $rFLists2['conceptm_id'];
          $sqlFLists1Nd = "SELECT sum(EvTotalScore/5) AS TotalScores FROM " . $prefix . "mscores where conceptm_id='$conceptm_id'";
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $rScore = $QueryFListsm1Nd->fetch_array();
        ?>
          <tr>
            <td class="small-col"><span class="time"><a href="./files/<?php echo $rFLists2['proposalm_upload']; ?>" target="_blank"><?php echo $rFLists2['proposalmTittle']; ?></a></span></td>
            <td class="small-col"><?php echo $rFLists2['ms_NameOfPI']; ?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */ ?></td>
            <td class="name"><?php echo $rFLists2['conceptm_NameofInstitution']; ?></td>
            <td class="subject">Email: <?php echo $rFLists2['conceptm_email']; ?><br />
              Phone: <?php echo $rFLists2['conceptm_phone']; ?> </td>
            <td class="time">

              <?php echo $rFLists2['conceptm_datem']; ?> </td>
            <td class="name"><?php if ($rFLists2['cpt_sector'] != 'Other') {
                                echo $rFLists2['cpt_sector'];
                              } ?>
              <?php if ($rFLists2['cpt_sector'] == 'Other') { ?><br />Other Sector: <?php echo $rFLists2['cpt_othersector'];
                                                                              } ?></td>
            <td class="name">
              <?php if ($rFLists2['conceptm_status'] == 'new') { ?><div class="btn-info-black">New</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'approved') { ?><div class="btn-info-blue">Approved for Review</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'rejected') { ?><div class="btn-info-red">Rejected</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'pending') { ?><div class="btn-info-blue">Pending Review</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'completed') { ?><div class="btn-info-blue">Complete</div><?php } ?>
              <?php
              $sqlAssigned = "SELECT * FROM " . $prefix . "conceptsasslogs where conceptm_id='$conceptm_id'";
              $QueryAssigned = $mysqli->query($sqlAssigned);
              $totalAssigned = $QueryAssigned->num_rows;



              if ($rFLists2['conceptm_status'] == 'forwaded') { ?><div class="btn-info-orange">Forwarded to <a href="./main.php?option=dashboard" title="
<?php
                while ($rQueryAssigned = $QueryAssigned->fetch_array()) {
                  $sto = $rQueryAssigned['conceptm_assignedto'];
                  $sqlAssigned = "SELECT * FROM " . $prefix . "musers where usrm_id='$sto'";
                  $sqlAssigned = $mysqli->query($sqlAssigned);
                  $syAssigned = $sqlAssigned->fetch_array();
                  echo $syAssigned['usrm_fname'] . '&nbsp;' . $syAssigned['usrm_sname'] . '&nbsp;|&nbsp;';
                } ?>" style="color:#FFF; font-weight:bold;"><?php echo $totalAssigned; ?></a> Reviewers</div><?php } ?>


              <?php if ($rFLists2['conceptm_status'] == 'evaluated') { ?><div class="btn-info-eval">Reviewed</div><?php } ?></td>

            <td class="name"><?php if ($rFLists2['conceptm_status'] == 'approved') { ?>
                <a href="./data/assign/<?php echo $rFLists2['conceptm_id']; ?>/" style="color:#00A65A;">Forward Submission</a>
              <?php } ?>

              <?php if ($rFLists2['conceptm_status'] == 'new') { ?>
                <a href="./data/review/<?php echo $rFLists2['conceptm_id']; ?>/">Click to Review</a>
              <?php } ?>
            </td>
          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="8">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>
          </div><!--end purgination section-->
        </td>
      </tr>
    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function

function RejectedMSubmission()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  /*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
  $category = $_POST['category'];

  $pages = 'data/';
  $url = 'rejected/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  if ($_POST['doSearch']) {
    $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts  where conceptm_status='rejected' and categorym='concepts' and cpt_sector='$category' order by conceptm_date desc");
  }
  if (!$_POST['doSearch']) {
    $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts  where conceptm_status='rejected' and categorym='concepts' order by conceptm_date desc");
  }

  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  if ($_POST['doSearch']) {
    $limitm = 40;
  }
  if (!$_POST['doSearch']) {
    $limitm = 15;
  }                //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  if ($_POST['doSearch']) {
    $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_status='rejected' and categorym='concepts' and cpt_sector='$category' order by conceptm_date desc LIMIT $start, $limitm";
  }
  if (!$_POST['doSearch']) {
    $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_status='rejected' and categorym='concepts' order by conceptm_date desc LIMIT $start, $limitm";
  }


  $result = $mysqli->query($sql);

  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox">
      <tr class="unread">
        <th class="small-col"><strong>Name Of PI </strong></th>
        <th class="name"><strong>Name of Institution</strong></th>
        <th class="subject"><strong>Contacts</strong></th>
        <th class="time"><strong>Message</strong></th>
        <th class="time"><strong>Date</strong></th>
        <th class="time"><strong>Sector</strong></th>
        <th class="time"><strong>Status</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="7">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {

          ///////////////////////////////////////////////

          $conceptm_id = $rFLists2['conceptm_id'];
          $sqlFLists1Nd = "SELECT sum(EvTotalScore/5) AS TotalScores FROM " . $prefix . "mscores where conceptm_id='$conceptm_id' and categorym='concepts'";
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $rScore = $QueryFListsm1Nd->fetch_array();
        ?>
          <tr>
            <td class="small-col"><?php echo $rFLists2['ms_NameOfPI']; ?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */ ?></td>
            <td class="name"><?php echo $rFLists2['conceptm_NameofInstitution']; ?></td>
            <td class="subject">Email: <?php echo $rFLists2['conceptm_email']; ?><br />
              Phone: <?php echo $rFLists2['conceptm_phone']; ?>
            </td>
            <td class="time"><?php echo $rFLists2['conceptm_cmtreject']; ?></td>
            <td class="time">

              <?php echo $rFLists2['conceptm_datem']; ?>

            </td>
            <td class="name"><?php if ($rFLists2['cpt_sector'] != 'Other') {
                                echo $rFLists2['cpt_sector'];
                              } ?>
              <?php if ($rFLists2['cpt_sector'] == 'Other') { ?><br />Other Sector: <?php echo $rFLists2['cpt_othersector'];
                                                                              } ?></td>
            <td class="name">
              <?php if ($rFLists2['conceptm_status'] == 'new') { ?><div class="btn-info-black">New</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'approved') { ?><div class="btn-info-blue">Approved for Review</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'rejected') { ?><div class="btn-info-red">Rejected</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'completed') { ?><div class="btn-info-blue">Complete</div><?php } ?>

              <?php
              $sqlAssigned = "SELECT * FROM " . $prefix . "conceptsasslogs where conceptm_id='$conceptm_id' and categorym='concepts'";
              $QueryAssigned = $mysqli->query($sqlAssigned);
              $totalAssigned = $QueryAssigned->num_rows;



              if ($rFLists2['conceptm_status'] == 'forwaded') { ?><div class="btn-info-orange">Forwarded to <a href="./main.php?option=dashboard" title="
<?php
                while ($rQueryAssigned = $QueryAssigned->fetch_array()) {
                  $sto = $rQueryAssigned['conceptm_assignedto'];
                  $sqlAssigned = "SELECT * FROM " . $prefix . "musers where usrm_id='$sto'";
                  $sqlAssigned = $mysqli->query($sqlAssigned);
                  $syAssigned = $sqlAssigned->fetch_array();
                  echo $syAssigned['usrm_fname'] . '&nbsp;|&nbsp;';
                } ?>" style="color:#FFF; font-weight:bold;"><?php echo $totalAssigned; ?></a> Reviewers</div><?php } ?>


              <?php if ($rFLists2['conceptm_status'] == 'evaluated') { ?><div class="btn-info-eval">Reviewed</div><?php } ?>
            </td>


          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="8">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>

          </div><!--end purgination section-->
        </td>
      </tr>


    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function


function RejectedMSubmissionProposals()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  /*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
  $pages = 'data/';
  $url = 'admprejected/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts  where conceptm_status='rejected' and categorym='proposals' and openstatus='open' order by conceptm_date desc");
  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  $limitm = 15;                 //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_status='rejected' and categorym='proposals' and openstatus='open' order by conceptm_date desc LIMIT $start, $limitm";
  $result = $mysqli->query($sql);

  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox">
      <tr class="unread">
        <th class="small-col"><strong>Name Of PI </strong></th>
        <th class="name"><strong>Name of Institution</strong></th>
        <th class="subject"><strong>Contacts</strong></th>
        <th class="time"><strong>Message</strong></th>
        <th class="time"><strong>Date</strong></th>
        <th class="time"><strong>Sector</strong></th>
        <th class="time"><strong>Status</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="7">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {

          ///////////////////////////////////////////////

          $conceptm_id = $rFLists2['conceptm_id'];
          $sqlFLists1Nd = "SELECT sum(EvTotalScore/5) AS TotalScores FROM " . $prefix . "mscores where conceptm_id='$conceptm_id' and categorym='proposals' and openstatus='open'";
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $rScore = $QueryFListsm1Nd->fetch_array();
        ?>
          <tr>
            <td class="small-col"><?php echo $rFLists2['ms_NameOfPI']; ?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */ ?></td>
            <td class="name"><?php echo $rFLists2['conceptm_NameofInstitution']; ?></td>
            <td class="subject">Email: <?php echo $rFLists2['conceptm_email']; ?><br />
              Phone: <?php echo $rFLists2['conceptm_phone']; ?>
            </td>
            <td class="time"><?php echo $rFLists2['conceptm_cmtreject']; ?></td>
            <td class="time">

              <?php echo $rFLists2['conceptm_datem']; ?>

            </td>
            <td class="name"><?php if ($rFLists2['cpt_sector'] != 'Other') {
                                echo $rFLists2['cpt_sector'];
                              } ?>
              <?php if ($rFLists2['cpt_sector'] == 'Other') { ?><br />Other Sector: <?php echo $rFLists2['cpt_othersector'];
                                                                              } ?></td>
            <td class="name">
              <?php if ($rFLists2['conceptm_status'] == 'new') { ?><div class="btn-info-black">New</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'approved') { ?><div class="btn-info-blue">Approved for Review</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'rejected') { ?><div class="btn-info-red">Rejected</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'completed') { ?><div class="btn-info-blue">Complete</div><?php } ?>

              <?php
              $sqlAssigned = "SELECT * FROM " . $prefix . "conceptsasslogs where conceptm_id='$conceptm_id' and categorym='proposals' and openstatus='open'";
              $QueryAssigned = $mysqli->query($sqlAssigned);
              $totalAssigned = $QueryAssigned->num_rows;



              if ($rFLists2['conceptm_status'] == 'forwaded') { ?><div class="btn-info-orange">Forwarded to <a href="./main.php?option=dashboard" title="
<?php
                while ($rQueryAssigned = $QueryAssigned->fetch_array()) {
                  $sto = $rQueryAssigned['conceptm_assignedto'];
                  $sqlAssigned = "SELECT * FROM " . $prefix . "musers where usrm_id='$sto'";
                  $sqlAssigned = $mysqli->query($sqlAssigned);
                  $syAssigned = $sqlAssigned->fetch_array();
                  echo $syAssigned['usrm_fname'] . '&nbsp;|&nbsp;';
                } ?>" style="color:#FFF; font-weight:bold;"><?php echo $totalAssigned; ?></a> Reviewers</div><?php } ?>


              <?php if ($rFLists2['conceptm_status'] == 'evaluated') { ?><div class="btn-info-eval">Reviewed</div><?php } ?>
            </td>


          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="8">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>

          </div><!--end purgination section-->
        </td>
      </tr>


    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function






function FrowardedFMSubmission()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  /*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
  $category = $_POST['category'];

  $pages = 'data/';
  $url = 'forwaded/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  if ($_POST['doSearch']) {
    $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts  where conceptm_status='forwaded' and categorym='concepts' and cpt_sector='$category' and openstatus='open' order by conceptm_date desc");
  }
  if (!$_POST['doSearch']) {
    $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts  where conceptm_status='forwaded' and categorym='concepts' and openstatus='open' order by conceptm_date desc");
  }

  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  if ($_POST['doSearch']) {
    $limitm = 40;
  }
  if (!$_POST['doSearch']) {
    $limitm = 15;
  }                 //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  if ($_POST['doSearch']) {
    $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_status='forwaded' and categorym='concepts' and cpt_sector='$category' and openstatus='open' order by conceptm_date desc LIMIT $start, $limitm";
  }
  if (!$_POST['doSearch']) {
    $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_status='forwaded' and categorym='concepts' and openstatus='open' order by conceptm_date desc LIMIT $start, $limitm";
  }

  $result = $mysqli->query($sql);

  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table width="100%" class="table table-mailbox">
      <tr class="unread">
        <th width="299" class="small-col"><strong>Proposal</strong></th>
        <th width="143" class="small-col"><strong>Name Of PI</strong></th>
        <th width="153" class="name"><strong>Name of Institution</strong></th>
        <th width="134" class="subject"><strong>Contacts</strong></th>
        <th width="122" class="time"><strong>Date</strong></th>
        <th width="119" class="time"><strong>Sector</strong></th>
        <th width="140" class="time"><strong>Status</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="7">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {

          ///////////////////////////////////////////////

          $conceptm_id = $rFLists2['conceptm_id'];
          $sqlFLists1Nd = "SELECT sum(EvTotalScore/5) AS TotalScores FROM " . $prefix . "mscores where conceptm_id='$conceptm_id'";
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $rScore = $QueryFListsm1Nd->fetch_array();
        ?>
          <tr>
            <td class="small-col"><span class="time"><a href="./files/<?php echo $rFLists2['proposalm_upload']; ?>" target="_blank"><?php echo $rFLists2['proposalmTittle']; ?></a></span></td>
            <td class="small-col"><?php echo $rFLists2['ms_NameOfPI']; ?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */ ?></td>
            <td class="name"><?php echo $rFLists2['conceptm_NameofInstitution']; ?></td>
            <td class="subject">Email: <?php echo $rFLists2['conceptm_email']; ?><br />
              Phone: <?php echo $rFLists2['conceptm_phone']; ?> </td>
            <td class="time">

              <?php echo $rFLists2['conceptm_datem']; ?> </td>
            <td class="name"><?php if ($rFLists2['cpt_sector'] != 'Other') {
                                echo $rFLists2['cpt_sector'];
                              } ?>
              <?php if ($rFLists2['cpt_sector'] == 'Other') { ?><br />Other Sector: <?php echo $rFLists2['cpt_othersector'];
                                                                              } ?></td>
            <td class="name">
              <?php if ($rFLists2['conceptm_status'] == 'new') { ?><div class="btn-info-black">New</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'approved') { ?><div class="btn-info-blue">Approved for Review</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'rejected') { ?><div class="btn-info-red">Rejected</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'completed') { ?><div class="btn-info-blue">Complete</div><?php } ?>

              <?php
              $sqlAssigned = "SELECT * FROM " . $prefix . "conceptsasslogs where conceptm_id='$conceptm_id'";
              $QueryAssigned = $mysqli->query($sqlAssigned);
              $totalAssigned = $QueryAssigned->num_rows;



              if ($rFLists2['conceptm_status'] == 'forwaded') { ?><div class="btn-info-orange">Forwarded to <a href="./main.php?option=dashboard" title="
<?php
                while ($rQueryAssigned = $QueryAssigned->fetch_array()) {
                  $sto = $rQueryAssigned['conceptm_assignedto'];
                  $sqlAssigned = "SELECT * FROM " . $prefix . "musers where usrm_id='$sto'";
                  $sqlAssigned = $mysqli->query($sqlAssigned);
                  $syAssigned = $sqlAssigned->fetch_array();
                  echo $syAssigned['usrm_fname'] . '&nbsp;|&nbsp;';
                } ?>" style="color:#FFF; font-weight:bold;"><?php echo $totalAssigned; ?></a> Reviewers</div><?php } ?>


              <?php if ($rFLists2['conceptm_status'] == 'evaluated') { ?><div class="btn-info-eval">Reviewed</div><?php } ?></td>
          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="8">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>
          </div><!--end purgination section-->
        </td>
      </tr>
    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function  




function ApprovedFrowardedForReview()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  /*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
  $category = $_POST['category'];

  $pages = 'data/';
  $url = 'approvedfr/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  if ($_POST['doSearch']) {
    $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts  where conceptm_status='approved' and categorym='concepts' and cpt_sector='$category' order by conceptm_date desc");
  }
  if (!$_POST['doSearch']) {
    $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts  where conceptm_status='approved' and categorym='concepts' order by conceptm_date desc");
  }

  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  if ($_POST['doSearch']) {
    $limitm = 40;
  }
  if (!$_POST['doSearch']) {
    $limitm = 15;
  }                 //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  if ($_POST['doSearch']) {
    $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_status='approved'  and categorym='concepts' and cpt_sector='$category' order by conceptm_date desc LIMIT $start, $limitm";
  }
  if (!$_POST['doSearch']) {
    $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_status='approved'  and categorym='concepts' order by conceptm_date desc LIMIT $start, $limitm";
  }

  $result = $mysqli->query($sql);

  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox">


      <tr>
        <td class="small-col" colspan="8">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>
          </div><!--end purgination section-->
        </td>
      </tr>


      <tr class="unread">
        <th width="223" class="small-col"><strong>Proposal</strong></th>
        <th width="124" class="small-col"><strong>Name Of PI</strong></th>
        <th width="167" class="name"><strong>Name of Institution</strong></th>
        <th width="149" class="subject"><strong>Contacts</strong></th>
        <th width="101" class="time"><strong>Date</strong></th>
        <th width="125" class="time"><strong>Sector</strong></th>
        <th width="123" class="time"><strong>Status</strong></th>
        <th width="94" class="time"><strong>Action</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="8">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {

          ///////////////////////////////////////////////

          $conceptm_id = $rFLists2['conceptm_id'];
          $sqlFLists1Nd = "SELECT sum(EvTotalScore/5) AS TotalScores FROM " . $prefix . "mscores where conceptm_id='$conceptm_id' and categorym='concepts'";
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $rScore = $QueryFListsm1Nd->fetch_array();
        ?>
          <tr>
            <td class="small-col"><span class="time"><a href="./files/<?php echo $rFLists2['proposalm_upload']; ?>" target="_blank"><?php echo $rFLists2['proposalmTittle']; ?></a></span></td>
            <td class="small-col"><?php echo $rFLists2['ms_NameOfPI']; ?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */ ?></td>
            <td class="name"><?php echo $rFLists2['conceptm_NameofInstitution']; ?></td>
            <td class="subject">Email: <?php echo $rFLists2['conceptm_email']; ?><br />
              Phone: <?php echo $rFLists2['conceptm_phone']; ?> </td>
            <td class="time">

              <?php echo $rFLists2['conceptm_datem']; ?> </td>
            <td class="name"><?php if ($rFLists2['cpt_sector'] != 'Other') {
                                echo $rFLists2['cpt_sector'];
                              } ?>
              <?php if ($rFLists2['cpt_sector'] == 'Other') { ?><br />Other Sector: <?php echo $rFLists2['cpt_othersector'];
                                                                              } ?></td>
            <td class="name">
              <?php if ($rFLists2['conceptm_status'] == 'new') { ?><div class="btn-info-black">New</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'approved') { ?><div class="btn-info-blue">Approved for Review</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'rejected') { ?><div class="btn-info-red">Rejected</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'pending') { ?><div class="btn-info-blue">Pending Review</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'completed') { ?><div class="btn-info-blue">Complete</div><?php } ?>
              <?php
              $sqlAssigned = "SELECT * FROM " . $prefix . "conceptsasslogs where conceptm_id='$conceptm_id'  and categorym='concepts'";
              $QueryAssigned = $mysqli->query($sqlAssigned);
              $totalAssigned = $QueryAssigned->num_rows;



              if ($rFLists2['conceptm_status'] == 'forwaded') { ?><div class="btn-info-orange">Forwarded to <a href="./main.php?option=dashboard" title="
<?php
                while ($rQueryAssigned = $QueryAssigned->fetch_array()) {
                  $sto = $rQueryAssigned['conceptm_assignedto'];
                  $sqlAssigned = "SELECT * FROM " . $prefix . "musers where usrm_id='$sto'";
                  $sqlAssigned = $mysqli->query($sqlAssigned);
                  $syAssigned = $sqlAssigned->fetch_array();
                  echo $syAssigned['usrm_fname'] . '&nbsp;' . $syAssigned['usrm_sname'] . '&nbsp;|&nbsp;';
                } ?>" style="color:#FFF; font-weight:bold;"><?php echo $totalAssigned; ?></a> Reviewers</div><?php } ?>


              <?php if ($rFLists2['conceptm_status'] == 'evaluated') { ?><div class="btn-info-eval">Reviewed</div><?php } ?></td>

            <td class="name"><?php if ($rFLists2['conceptm_status'] == 'approved') { ?>
                <a href="./data/assign/<?php echo $rFLists2['conceptm_id']; ?>/" style="color:#00A65A;">Forward Submission</a>
              <?php } ?>

              <?php if ($rFLists2['conceptm_status'] == 'new') { ?>
                <a href="./data/review/<?php echo $rFLists2['conceptm_id']; ?>/">Click to Review</a>
              <?php } ?>
            </td>
          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="8">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>
          </div><!--end purgination section-->
        </td>
      </tr>
    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function    



///pending evaluation
function PendingMEvaluation()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  /*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
  $pages = 'data/';
  $url = 'pendingeval/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts where conceptm_status='pending' and categorym='concepts' order by conceptm_Avg desc");
  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  $limitm = 10;                 //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_status='pending'  and categorym='concepts' order by conceptm_Avg desc LIMIT $start, $limitm";
  $result = $mysqli->query($sql);

  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox">
      <tr class="unread">
        <th width="140" class="small-col"><strong>Proposal</strong></th>
        <th width="233" class="time"><strong>Name Of PI</strong></th>
        <th width="144" class="time"><strong>Score by Reviewer</strong></th>
        <th width="65" class="time"><strong>Average Score</strong></th>
        <th width="79" class="time"><strong>Submission Date</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="5">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {

          ///////////////////////////////////////////////

          $conceptm_id = $rFLists2['conceptm_id'];
          $sqlFLists1Nd = "SELECT sum(EvTotalScore/5) AS TotalScores FROM " . $prefix . "mscores where conceptm_id='$conceptm_id'";
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $rScore = $QueryFListsm1Nd->fetch_array();

          if ($rFLists2['conceptm_Reviewers'] == 5) {
            $queryScores2 = "update " . $prefix . "concepts  set `conceptm_status`='evaluated' where `conceptm_id`='$conceptm_id'";
            $mysqli->query($queryScores2);
          }
          if ($rFLists2['conceptm_Reviewers'] != 5) { //5 evauaters have not finished
            $queryScores2 = "update " . $prefix . "concepts  set `conceptm_status`='pending' where `conceptm_id`='$conceptm_id'";
            $mysqli->query($queryScores2);
          }
          ///updte verge
          $EvTotalScore = round($rScore['TotalScores'], 0);
          $queryScores2ev = "update " . $prefix . "concepts  set `conceptm_Avg`='$EvTotalScore' where `conceptm_id`='$conceptm_id'";
          $mysqli->query($queryScores2ev);
        ?>
          <tr>
            <td class="small-col"><span class="time"><a href="./files/<?php echo $rFLists2['proposalm_upload']; ?>" target="_blank"><?php echo $rFLists2['proposalmTittle']; ?></a></span></td>

            <td class="time"><span class="small-col"><?php echo $rFLists2['ms_NameOfPI']; ?></span></td>
            <td class="time">

              <?php
              $sqlScoreReview = "SELECT * FROM " . $prefix . "mscores where conceptm_id='$conceptm_id'";
              $QueryScoreReview = $mysqli->query($sqlScoreReview);
              while ($rScoreReview = $QueryScoreReview->fetch_array()) {
                $evaluatedBy = $rScoreReview['EvaluatedBy'];
                //now get this reviewer
                $sqlReviewer = "SELECT * FROM " . $prefix . "musers where usrm_id='$evaluatedBy'";
                $QueryReviewer = $mysqli->query($sqlReviewer);
                $rReviewer = $QueryReviewer->fetch_array();

              ?>
                <table width="100%" border="0">
                  <tr>
                    <td><?php echo $rReviewer['usrm_fname']; ?><br />
                      <?php /*?> <a href="scoresheet.php?id=<?php echo base64_encode($rScoreReview['EvaluatedBy']);?>&ds=<?php echo base64_encode($conceptm_id);?>" onclick="return popitup('scoresheet.php?id=<?php echo base64_encode($rScoreReview['EvaluatedBy']);?>&ds=<?php echo base64_encode($conceptm_id);?>')">Score Sheet</a><?php */ ?></td>
                    <td style="color:#00A3CB; text-align:center;" valign="top"><?php echo $rScoreReview['EvTotalScore']; ?>%</td>
                  </tr>
                </table>


              <?php } ?>
            </td>
            <td class="name" style="font-size:14px; color:#00A65A; font-weight:bold; text-align:center;"><?php echo round($rScore['TotalScores'], 0); ?>%</td>
            <td class="name"><?php echo $rFLists2['conceptm_datem']; ?></td>
          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="5">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>
          </div><!--end purgination section-->
        </td>
      </tr>
    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function	  




function CompletedMEvaluation()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli, $id;
  $category = $_POST['category'];
?>
  <?php GenerateReviewrsByCategory(); ?>
  <?php
  /*$pages='data/';
echo $url='completeval/'.$id;
$value='listuserauthorised';*/
  $page = 'main.php?';
  $url = 'category=';
  $value = 'completeval&id=' . $id;

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "mscores where categorym='concepts' and DateEvaluated like '%$id%' group by conceptm_id order by EvgeneralTotal desc");
  //echo "select COUNT(*) as num from ".$prefix."mscores where categorym='concepts' and DateEvaluated like '%$id%' group by conceptm_id order by EvgeneralTotal desc";
  $total_pages = $query->fetch_array($mysqli->query($query));
  $rFListss2 = $query->fetch_array();
  $total_pages = $rFListss2['num'];
  //while($rFListss2=$query->fetch_array()){
  //echo $total_pages = $rFListss2['num'];}



  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $page . $url . $value;   //your file name  (the name of this file)
  $limitm = 150;                 //how many items to show per page
  $page = $_GET['page'];

  /*Extract Last Value from a link*/
  /*$RequestURI=end(explode("/", $_SERVER['REQUEST_URI']));
$page = preg_replace('/\D/', '', $RequestURI);*/

  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  if ($category) {
    $sql = "select * FROM grantsmr_mscores,grantsmr_concepts where grantsmr_mscores.conceptm_id=grantsmr_concepts.conceptm_id and grantsmr_concepts.categorym='concepts' and grantsmr_concepts.cpt_sector='$category' and conceptm_status='completed' and DateEvaluated like '%$id%' group by grantsmr_concepts.conceptm_id order by EvgeneralTotal desc LIMIT $start, $limitm";
  }
  if (!$category) {
    $sql = "select * FROM " . $prefix . "mscores where categorym='concepts' and DateEvaluated like '%$id%' group by conceptm_id order by EvgeneralTotal desc LIMIT $start, $limitm";
  }


  $result = $mysqli->query($sql);
  //,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem  conceptm_status='evaluated'
  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
  ?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox" width="100%">
      <tr class="unread" style="font-size:13px;">
        <th width="290" class="small-col"><strong>Proposal</strong></th>
        <th width="204" class="time"><strong>Reviewer</strong></th>
        <th width="171" class="time"><strong>Name of PI</strong></th>
        <th width="171" class="time"><strong>Technical Review Score</strong></th>
        <th width="90" class="time"><strong>Average Score</strong></th>
        <!--<th width="117" class="time"><strong>Viva Score</strong></th>-->
        <th width="98" class="time"><strong>Total Score</strong></th>

      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="6">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {






        while ($rFLists2 = $result->fetch_array()) {
          $sconceptm_id = $rFLists2['conceptm_id'];
          $ownerID = $rFLists2['usrm_id'];
          $EvaluatedBy = $rFLists2['EvaluatedBy'];

          $queryContributionRT = "select * from " . $prefix . "concepts where conceptm_id='$sconceptm_id'";
          $rs_ContributionRT = $mysqli->query($queryContributionRT);
          $rsContributionRT = $rs_ContributionRT->fetch_array();



        ?>
          <tr>
            <td class="small-col"><?php //echo $sconceptm_id;
                                  ?> <a href="./files/<?php echo $rsContributionRT['proposalm_upload']; ?>" target="_blank" style="font-size:12px;"><?php echo $rsContributionRT['proposalmTittle']; ?> <?php //echo $rsContributionRT['conceptm_id'];
                                                                                                                                                                                                                                  ?></a>

            </td>




            <td colspan="6" class="time">

              <table width="100%" border="0">
                <?php
                $sqlConcepts = "SELECT * FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id' order by EvTotalScore desc";
                $QueryConcepts = $mysqli->query($sqlConcepts); //EvaluatedBy='$EvaluatedBy' and conceptm_id='$sconceptm_id' 
                while ($rConcepts = $QueryConcepts->fetch_array()) {
                  $dsconceptm_id = $rConcepts['conceptm_id'];
                  $susrm_id = $rConcepts['usrm_id'];
                  $evaluatedBy = $rConcepts['EvaluatedBy'];

                  //////////////////////////////////////////////////////////////////////////////////////
                  $queryReviwer = "select * from " . $prefix . "musers where usrm_id='$evaluatedBy'";
                  $rs_Reviwer = $mysqli->query($queryReviwer);
                  $rsReviwer = $rs_Reviwer->fetch_array();

                  //proposal Owner
                  $queryContribution2 = "select * from " . $prefix . "musers where usrm_id='$susrm_id'";
                  $rs_Contributio2 = $mysqli->query($queryContribution2);
                  $rsContribution2 = $rs_Contributio2->fetch_array();

                  //get concept
                  $sqlConcepts2 = "SELECT * FROM " . $prefix . "concepts where conceptm_id='$sconceptm_id'";
                  $QueryConcepts2 = $mysqli->query($sqlConcepts2);
                  $rConcepts2 = $QueryConcepts2->fetch_array();
                  ///////////////////////get scores
                  /*$sqlScoreReview="SELECT * FROM ".$prefix."mscores where conceptm_id='$sconceptm_id' order by EvTotalScore desc";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
$rScoreReview = $QueryScoreReview->fetch_array();*/

                  ///who has reviewed this proposal?
                  $sqlReviewedm = "SELECT count(*) as TotalRevs,sum(EvTotalScore) as TotalEvScore FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id' and usrm_id='$susrm_id' group by conceptm_id"; // order by EvTotalScore desc
                  $QueryReviewedm = $mysqli->query($sqlReviewedm);
                  $rScReviewedm = $QueryReviewedm->fetch_array();
                  //$totalReviewedm = $QueryReviewedm->num_rows;
                  $rScReviewedm['TotalEvScore'];

                ?>

                  <tr>
                    <td width="24%" style="border-bottom:1px dotted #EAEAEA; padding-right:5px;"><?php echo $rsReviwer['usrm_fname']; ?> <?php echo $rsReviwer['usrm_sname']; ?></td>
                    <td width="20%" style="border-bottom:1px dotted #EAEAEA;"><?php echo $rsContribution2['usrm_fname']; ?> <?php echo $rsContribution2['usrm_sname']; ?></td>


                    <td width="20%" style="color:#0073B7; font-weight:bold; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">

                      <?php echo ($rConcepts['STQnewMethods'] + $rConcepts['STQhighQuality'] + $rConcepts['STQSatisfactoryPartnership'] + $rConcepts['AppAddressIssues'] + $rConcepts['ImpactClearlyConvincingly'] + $rConcepts['ImpactGenderIssues']); ?>

                      <?php if ($rConcepts['scoredmID']) { ?><br />
                        <a href="scoresheetp.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rConcepts['scoredmID']); ?>" onclick="return popitup('scoresheetp.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rConcepts['scoredmID']); ?>')" style="color:#00A65A; font-weight:bold; font-size:12px;">Click to View</a>
                      <?php } ?>






                      <?php //if($rScoreReview['EvTotalScore']){echo numberformat($rScoreReview['EvTotalScore']/75*100).'%';}
                      ?>
                    </td>
                    <td width="12%" style="color:#00A3CB; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">
                      <?php
                      //Average score=Technical Review Score/no of reviewers

                      ?>
                      <?php if ($rConcepts['EvSame'] == 1) { ?><?php echo round(($rScReviewedm['TotalEvScore'] / $rScReviewedm['TotalRevs']), 2); ?> <?php } ?>

                    </td>
                    <?php /*?> <td width="13%" style="color:#00A3CB; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">
    
<?php if($rConcepts['EVivaScore']>=1 and $rConcepts['EvSame']==1){?><?php echo $rConcepts['EVivaScore'];?><?php }

if($rConcepts['vivconceptStatus']!='Done' and $rConcepts['EvSame']==1){?>
  <a href="addvivascore.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']);?>&ds=<?php echo base64_encode($rConcepts['scoredmID']);?>" onclick="return popitup('addvivascore.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']);?>&ds=<?php echo base64_encode($rConcepts['scoredmID']);?>')" style="color:#00A65A; font-weight:bold; font-size:12px;">Click to Add</a><?php }?>
  
 <?php if($rConcepts['EvVivaComments'] and $rConcepts['EvSame']==1){?> <br /><a href="vivcomments.php?id=<?php echo base64_encode($rConcepts['scoredmID']);?>" style="color:#00A65A; font-weight:bold; font-size:12px;"  onclick="return popitup('vivcomments.php?id=<?php echo base64_encode($rConcepts['scoredmID']);?>')">View Comments</a><?php }?>
    
  </td><?php */ ?>
                    <?php /*?><td style="color:#0073B7; font-weight:bold; text-align:right;border-bottom:1px dotted #EAEAEA; padding:5px;"><?php if($rScoreReview['AppPrototypeClearly']){echo $rScoreReview['AppPrototypeClearly'];}else{?><br />
   <a href="./data/psviva/<?php echo $rScoreReview['scoredmID'];?>/" style="font-size:12px;">Add Viva Score</a><?php }?></td><?php */ ?>

                    <td width="11%" style="color:#0073B7; font-weight:bold; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">

                      <?php
                      //Total Score=Average+Total Score
                      if ($rConcepts['EvTotalScore'] and $rConcepts['EvSame'] == 1) {
                        echo round(($rScReviewedm['TotalEvScore'] / $rScReviewedm['TotalRevs']) + $rConcepts['EVivaScore'], 2);
                      }
                      $getGeneralTotal = round(($rScReviewedm['TotalEvScore'] / $rScReviewedm['TotalRevs']) + $rConcepts['EVivaScore'], 2);
                      $sqlGeneral = "update " . $prefix . "mscores set EvgeneralTotal='$getGeneralTotal' where conceptm_id='$sconceptm_id' and usrm_id='$susrm_id'"; // order by EvTotalScore desc
                      //$mysqli->query($sqlGeneral);


                      ?></td>


                  </tr>



                <?php } ?>
              </table>
            </td>

            <td class="small-col"><?php if ($rsContributionRT['sentNotify'] == 'No') { ?><a href="./data/replySuccessful/<?php echo $rFLists2['conceptm_id']; ?>/" style="color:#00C0EF;">Reply Applicant</a> <?php } ?>


              <?php if ($rsContributionRT['sentNotify'] == 'Yes') { ?><a href="notified.php?id=<?php echo base64_encode($rFLists2['conceptm_id']); ?>" onclick="return popitup('notified.php?id=<?php echo base64_encode($rFLists2['conceptm_id']); ?>')" style="color:#09F; font-weight:bold;">Passed</a> <?php } ?>

              <?php if ($rsContributionRT['sentNotify'] == 'Failed') { ?><a href="notified.php?id=<?php echo base64_encode($rFLists2['conceptm_id']); ?>" onclick="return popitup('notified.php?id=<?php echo base64_encode($rFLists2['conceptm_id']); ?>')" style="color:#C30; font-weight:bold;">Failed</a> <?php } ?>
            </td>

          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="6">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>

          </div><!--end purgination section-->
        </td>
      </tr>


    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function	

function CompletedMEvaluationProposals()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;

  $sqlGroupDIspC = "SELECT cpt_sector FROM " . $prefix . "concepts group by cpt_sector";
  $sqlFGrpDisC = $mysqli->query($sqlGroupDIspC);
  $totalUserReports = $sqlFGrpDisC->num_rows;


?>
  <form action="" method="post">
    <select name="category" class="select">
      <?php
      while ($rGRSPC = $sqlFGrpDisC->fetch_array()) { ?>
        <option value="<?php echo $rGRSPC['cpt_sector']; ?>" <?php if ($_POST['category'] == $rGRSPC['cpt_sector']) { ?>selected="selected" <?php } ?>>&nbsp;<?php echo $rGRSPC['cpt_sector']; ?> </option>
      <?php } ?>
    </select>

    <input name="doSearch" type="submit" value="Search Category" class="serch" />
  </form>
  <?php
  $category = $_POST['category'];
  $pages = 'data/';
  $url = 'adpcompleteval/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  if ($_POST['category']) {
    $query = $mysqli->query("select COUNT(*) as num FROM grantsmr_mscores,grantsmr_concepts where grantsmr_mscores.conceptm_id=grantsmr_concepts.conceptm_id and grantsmr_mscores.categorym='proposals' and openstatus='open' and grantsmr_concepts.cpt_sector='$category' group by grantsmr_mscores.conceptm_id order by EvgeneralTotal desc");
  }
  if (!$_POST['category']) {
    $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "mscores where categorym='proposals' and openstatus='open' group by conceptm_id order by EvgeneralTotal desc");
  }
  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  $limitm = 50;                 //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  if ($_POST['category']) {
    $sql = "select * FROM grantsmr_mscores,grantsmr_concepts where grantsmr_mscores.conceptm_id=grantsmr_concepts.conceptm_id and grantsmr_mscores.categorym='proposals'  and openstatus='open' and grantsmr_concepts.cpt_sector='$category' group by grantsmr_mscores.conceptm_id order by EvgeneralTotal desc LIMIT $start, $limitm";
  }
  if (!$_POST['category']) {
    $sql = "select * FROM " . $prefix . "mscores where categorym='proposals' and openstatus='open' group by conceptm_id order by EvgeneralTotal desc LIMIT $start, $limitm";
  }

  $result = $mysqli->query($sql);
  //,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem  conceptm_status='evaluated'
  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
  ?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox" width="100%">
      <tr class="unread" style="font-size:13px;">
        <th width="290" class="small-col"><strong>Proposal</strong></th>
        <th width="204" class="time"><strong>Reviewer</strong></th>
        <th width="171" class="time"><strong>Name of PI</strong></th>
        <th width="171" class="time"><strong>Technical Review Score</strong></th>
        <th width="90" class="time"><strong>Average Score</strong></th>
        <th width="117" class="time"><strong>Viva Score</strong></th>
        <th width="98" class="time"><strong>Total Score</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="7">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {






        while ($rFLists2 = $result->fetch_array()) {
          $sconceptm_id = $rFLists2['conceptm_id'];
          $ownerID = $rFLists2['usrm_id'];
          $EvaluatedBy = $rFLists2['EvaluatedBy'];

          $queryContributionRT = "select * from " . $prefix . "concepts where conceptm_id='$sconceptm_id'";
          $rs_ContributionRT = $mysqli->query($queryContributionRT);
          $rsContributionRT = $rs_ContributionRT->fetch_array();



        ?>
          <tr>
            <td class="small-col"><?php //echo $sconceptm_id;
                                  ?> <a href="./files/<?php echo $rsContributionRT['proposalm_upload']; ?>" target="_blank" style="font-size:12px;"><?php echo $rsContributionRT['proposalmTittle']; ?> <?php //echo $rsContributionRT['conceptm_id'];
                                                                                                                                                                                                                                  ?> </a>

            </td>
            <td colspan="6" class="time">

              <table width="100%" border="0">
                <?php
                $sqlConcepts = "SELECT * FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id' order by EvTotalScore desc";
                $QueryConcepts = $mysqli->query($sqlConcepts); //EvaluatedBy='$EvaluatedBy' and conceptm_id='$sconceptm_id' 
                while ($rConcepts = $QueryConcepts->fetch_array()) {
                  $dsconceptm_id = $rConcepts['conceptm_id'];
                  $susrm_id = $rConcepts['usrm_id'];
                  $evaluatedBy = $rConcepts['EvaluatedBy'];

                  //////////////////////////////////////////////////////////////////////////////////////
                  $queryReviwer = "select * from " . $prefix . "musers where usrm_id='$evaluatedBy'";
                  $rs_Reviwer = $mysqli->query($queryReviwer);
                  $rsReviwer = $rs_Reviwer->fetch_array();

                  //proposal Owner
                  $queryContribution2 = "select * from " . $prefix . "musers where usrm_id='$susrm_id'";
                  $rs_Contributio2 = $mysqli->query($queryContribution2);
                  $rsContribution2 = $rs_Contributio2->fetch_array();

                  //get concept
                  $sqlConcepts2 = "SELECT * FROM " . $prefix . "concepts where conceptm_id='$sconceptm_id'";
                  $QueryConcepts2 = $mysqli->query($sqlConcepts2);
                  $rConcepts2 = $QueryConcepts2->fetch_array();
                  ///////////////////////get scores
                  /*$sqlScoreReview="SELECT * FROM ".$prefix."mscores where conceptm_id='$sconceptm_id' order by EvTotalScore desc";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
$rScoreReview = $QueryScoreReview->fetch_array();*/

                  ///who has reviewed this proposal?
                  $sqlReviewedm = "SELECT count(*) as TotalRevs,sum(EvTotalScore) as TotalEvScore FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id' and usrm_id='$susrm_id' group by conceptm_id";
                  $QueryReviewedm = $mysqli->query($sqlReviewedm);
                  $rScReviewedm = $QueryReviewedm->fetch_array();
                  //$totalReviewedm = $QueryReviewedm->num_rows;
                  $rScReviewedm['TotalEvScore'];

                ?>

                  <tr>
                    <td width="24%" style="border-bottom:1px dotted #EAEAEA; padding-right:5px;"><?php echo $rsReviwer['usrm_fname']; ?> <?php echo $rsReviwer['usrm_sname']; ?></td>
                    <td width="20%" style="border-bottom:1px dotted #EAEAEA;"><?php echo $rsContribution2['usrm_fname']; ?> <?php echo $rsContribution2['usrm_sname']; ?></td>


                    <td width="20%" style="color:#0073B7; font-weight:bold; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">

                      <?php echo ($rConcepts['STQnewMethods'] + $rConcepts['STQhighQuality'] + $rConcepts['STQSatisfactoryPartnership'] + $rConcepts['AppAddressIssues'] + $rConcepts['ImpactClearlyConvincingly'] + $rConcepts['ImpactGenderIssues'] + $rConcepts['Potential'] + $rConcepts['Budget']); ?>

                      <?php if ($rConcepts['scoredmID']) { ?><br />
                        <a href="scoresheetp.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rConcepts['scoredmID']); ?>" onclick="return popitup('scoresheetp.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rConcepts['scoredmID']); ?>')" style="color:#00A65A; font-weight:bold; font-size:12px;">Click to View</a>
                      <?php } ?>


                      <?php //if($rScoreReview['EvTotalScore']){echo numberformat($rScoreReview['EvTotalScore']/75*100).'%';}
                      ?>
                    </td>
                    <td width="12%" style="color:#00A3CB; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">
                      <?php
                      //Average score=Technical Review Score/no of reviewers

                      ?>
                      <?php if ($rConcepts['EvSame'] == 1) { ?><?php echo ($rScReviewedm['TotalEvScore'] / $rScReviewedm['TotalRevs']); ?> <?php } ?>

                    </td>
                    <td width="13%" style="color:#00A3CB; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">

                      <?php if ($rConcepts['EVivaScore'] >= 1 and $rConcepts['EvSame'] == 1) { ?><?php echo $rConcepts['EVivaScore']; ?><?php }

                                                                                                                              if ($rConcepts['vivconceptStatus'] != 'Done' and $rConcepts['EvSame'] == 1) { ?>
                      <a href="addvivascore.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rConcepts['scoredmID']); ?>" onclick="return popitup('addvivascore.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rConcepts['scoredmID']); ?>')" style="color:#00A65A; font-weight:bold; font-size:12px;">Click to Add</a><?php } ?>

                    <?php if ($rConcepts['EvVivaComments'] and $rConcepts['EvSame'] == 1) { ?> <br /><a href="vivcomments.php?id=<?php echo base64_encode($rConcepts['scoredmID']); ?>" style="color:#00A65A; font-weight:bold; font-size:12px;" onclick="return popitup('vivcomments.php?id=<?php echo base64_encode($rConcepts['scoredmID']); ?>')">View Comments</a><?php } ?>

                    </td>
                    <?php /*?><td style="color:#0073B7; font-weight:bold; text-align:right;border-bottom:1px dotted #EAEAEA; padding:5px;"><?php if($rScoreReview['AppPrototypeClearly']){echo $rScoreReview['AppPrototypeClearly'];}else{?><br />
   <a href="./data/psviva/<?php echo $rScoreReview['scoredmID'];?>/" style="font-size:12px;">Add Viva Score</a><?php }?></td><?php */ ?>

                    <td width="11%" style="color:#0073B7; font-weight:bold; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">

                      <?php
                      //Total Score=Average+Total Score
                      if ($rConcepts['EvTotalScore'] and $rConcepts['EvSame'] == 1) {
                        //echo ($rScReviewedm['TotalEvScore']/$rScReviewedm['TotalRevs'])+$rConcepts['EVivaScore'].''; Before all score
                        echo $rConcepts['EvgeneralTotal']; //After all score
                      }

                      ?></td>
                  </tr>



                <?php } ?>
              </table>
            </td>
          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="7">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>

          </div><!--end purgination section-->
        </td>
      </tr>


    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function	





///pending evaluation
function AllocatedSubmissions()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  /*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
  $pages = 'data/';
  $url = 'sallocation/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "musers order by usrm_fname asc");
  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  $limitm = 10;                 //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  $sql = "select * FROM " . $prefix . "musers order by usrm_fname asc LIMIT $start, $limitm";
  $result = $mysqli->query($sql);
  //,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem  conceptm_status='evaluated'
  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox" width="100%">
      <tr class="unread">
        <td width="139" class="small-col"><strong>Reviewer</strong></td>
        <td width="853" class="time"><strong>Concept</strong></td>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="2">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {
          $usermrid = $rFLists2['usrm_id'];
        ?>
          <tr>
            <td class="small-col"><?php echo $rFLists2['usrm_fname']; ?></td>

            <td class="time">

              <table width="100%" border="0">
                <tr>
                  <th width="42%"><b>Concept</b></th>
                  <th width="26%"><b>Name of PI</b></th>
                  <th width="20%" align="right"><b>Technical Review Score</b></th>
                  <th width="12%" align="right"><b>Viva Score</b></th>
                </tr>
                <?php
                $sqlConcepts = "SELECT * FROM " . $prefix . "conceptsasslogs where conceptm_assignedto='$usermrid'";
                $QueryConcepts = $mysqli->query($sqlConcepts);
                while ($rConcepts = $QueryConcepts->fetch_array()) {
                  $sconceptm_id = $rConcepts['conceptm_id'];
                  //$evaluatedBy=$rConcepts['conceptm_id'];
                  //get concept
                  $sqlConcepts2 = "SELECT * FROM " . $prefix . "concepts where conceptm_id='$sconceptm_id'";
                  $QueryConcepts2 = $mysqli->query($sqlConcepts2);
                  $rConcepts2 = $QueryConcepts2->fetch_array();
                  ///////////////////////get scores
                  $sqlScoreReview = "SELECT * FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id'";
                  $QueryScoreReview = $mysqli->query($sqlScoreReview);
                  $rScoreReview = $QueryScoreReview->fetch_array();

                ?>

                  <tr>
                    <td style="border-bottom:1px dotted #EAEAEA;"><a href="./files/<?php echo $rConcepts2['proposalm_upload']; ?>" target="_blank"><?php echo $rConcepts2['proposalmTittle']; ?> </a></td>
                    <td style="border-bottom:1px dotted #EAEAEA;"><?php echo $rConcepts2['ms_NameOfPI']; ?></td>
                    <td style="color:#00A3CB; text-align:right;border-bottom:1px dotted #EAEAEA; padding:5px;"><?php if ($rScoreReview['EvTotalScore']) {
                                                                                                                  echo $rScoreReview['EvTotalScore'] . '';
                                                                                                                } ?></td>

                    <td style="color:#00A3CB; text-align:right;border-bottom:1px dotted #EAEAEA; padding:5px;"><?php if ($rScoreReview['AppPrototypeClearly']) {
                                                                                                                  echo $rScoreReview['AppPrototypeClearly'] . '';
                                                                                                                } else {
                                                                                                                  echo "----";
                                                                                                                } ?></td>
                  </tr>



                <?php } ?>
              </table>

            </td>
          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="2">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>

          </div><!--end purgination section-->
        </td>
      </tr>


    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function	  



















function PassedMEvaluation()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  /*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
  $pages = 'data/';
  $url = 'passed/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts where conceptm_status='evaluated' and conceptm_Avg>=75 order by conceptm_Avg desc");
  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  $limitm = 10;                 //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_status='evaluated' and conceptm_Avg>=75 order by conceptm_Avg desc LIMIT $start, $limitm";
  $result = $mysqli->query($sql);

  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox">
      <tr class="unread">
        <th width="140" class="small-col"><strong>Name Of PI</strong></th>
        <th width="233" class="time"><strong>Concept</strong></th>
        <th width="144" class="time"><strong>Score by Reviewer</strong></th>
        <th width="65" class="time"><strong>Average Score</strong></th>
        <th width="79" class="time"><strong>Submission Date</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="5">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {

          ///////////////////////////////////////////////

          $conceptm_id = $rFLists2['conceptm_id'];
          $sqlFLists1Nd = "SELECT sum(EvTotalScore/5) AS TotalScores FROM " . $prefix . "mscores where conceptm_id='$conceptm_id'";
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $rScore = $QueryFListsm1Nd->fetch_array();

          if ($rFLists2['conceptm_Reviewers'] == 5) {
            $queryScores2 = "update " . $prefix . "concepts  set `conceptm_status`='evaluated' where `conceptm_id`='$conceptm_id'";
            $mysqli->query($queryScores2);
          }
          if ($rFLists2['conceptm_Reviewers'] != 5) { //5 evauaters have not finished
            $queryScores2 = "update " . $prefix . "concepts  set `conceptm_status`='pending' where `conceptm_id`='$conceptm_id'";
            $mysqli->query($queryScores2);
          }
          ///updte verge
          $EvTotalScore = round($rScore['TotalScores'], 0);
          $queryScores2ev = "update " . $prefix . "concepts  set `conceptm_Avg`='$EvTotalScore' where `conceptm_id`='$conceptm_id'";
          $mysqli->query($queryScores2ev);
        ?>
          <tr>
            <td class="small-col"><?php echo $rFLists2['ms_NameOfPI']; ?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */ ?></td>

            <td class="time"><a href="./files/<?php echo $rFLists2['proposalm_upload']; ?>" target="_blank"><?php echo $rFLists2['proposalmTittle']; ?> </a> </td>
            <td class="time">

              <?php
              $sqlScoreReview = "SELECT * FROM " . $prefix . "mscores where conceptm_id='$conceptm_id'";
              $QueryScoreReview = $mysqli->query($sqlScoreReview);
              while ($rScoreReview = $QueryScoreReview->fetch_array()) {
                $evaluatedBy = $rScoreReview['EvaluatedBy'];
                //now get this reviewer
                $sqlReviewer = "SELECT * FROM " . $prefix . "musers where usrm_id='$evaluatedBy'";
                $QueryReviewer = $mysqli->query($sqlReviewer);
                $rReviewer = $QueryReviewer->fetch_array();

              ?>
                <table width="100%" border="0">
                  <tr>
                    <td><?php echo $rReviewer['usrm_fname']; ?><br />
                      <?php /*?>   <a href="scoresheet.php?id=<?php echo base64_encode($rScoreReview['EvaluatedBy']);?>&ds=<?php echo base64_encode($conceptm_id);?>" onclick="return popitup('scoresheet.php?id=<?php echo base64_encode($rScoreReview['EvaluatedBy']);?>&ds=<?php echo base64_encode($conceptm_id);?>')">Score Sheet</a><?php */ ?></td>
                    <td style="color:#00A3CB; text-align:center;" valign="top"><?php echo $rScoreReview['EvTotalScore']; ?>%</td>
                  </tr>
                </table>


              <?php } ?>






            </td>
            <td class="name" style="font-size:14px; color:#00A65A; font-weight:bold; text-align:center;"><?php echo round($rScore['TotalScores'], 0); ?>%</td>
            <td class="name"><?php echo $rFLists2['conceptm_datem']; ?>
            </td>
          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="5">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>

          </div><!--end purgination section-->
        </td>
      </tr>


    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function	  










function MyConferencesReviewer()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  $sqlConceptLogs = "SELECT * FROM " . $prefix . "conceptsasslogs where conceptm_assignedto='$usrm_id' order by assignm_date desc limit 0,150";
  $QueryConcept = $mysqli->query($sqlConceptLogs);
  $totalFL1 = $QueryConcept->num_rows;


?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox" width="100%">
      <tr class="unread">
        <td width="38%" class="time"><strong>Concept</strong></td>
        <td width="17%" class="time"><strong>Date</strong></td>
        <td width="13%" class="time"><strong>Sector</strong></td>

        <td width="12%" class="time"><strong>Status</strong></td>
        <td width="9%" class="time"><strong>Score</strong></td>
        <td width="11%" class="time"><strong>Action</strong></td>
      </tr>
      <?php if (!$totalFL1) { ?>
        <tr>
          <td class="small-col" colspan="6">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFListsmain = $QueryConcept->fetch_array()) {
          $conceptm_idd = $rFListsmain['conceptm_id'];
          ////////////////////subs///////////////
          $sqlFLists1 = "SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_id='$conceptm_idd' order by conceptm_date desc";
          $QueryFListsm1 = $mysqli->query($sqlFLists1);
          $rFLists2 = $QueryFListsm1->fetch_array();



          $sto = $rFLists2['conceptm_assignedto'];
          $sqlAssigned = "SELECT * FROM " . $prefix . "musers where usrm_id='$sto'";
          $sqlAssigned = $mysqli->query($sqlAssigned);
          $syAssigned = $sqlAssigned->fetch_array();
          ///////////////////////////////////////////////

          $conceptm_id = $rFLists2['conceptm_id'];
          $sqlFLists1Nd = "SELECT * FROM " . $prefix . "mscores where conceptm_id='$conceptm_id' and EvaluatedBy='$usrm_id'";
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $totalScores = $QueryFListsm1Nd->num_rows;
          $rScore = $QueryFListsm1Nd->fetch_array();
        ?>
          <tr>
            <td class="time"><?php if ($rFLists2['proposalm_uploadReup']) { ?><?php echo $rFLists2['proposalmTittle']; ?><?php } ?> </td>
            <td class="time">

              <?php echo $rFLists2['conceptm_datem']; ?>

            </td>
            <td class="name"><?php echo $rFLists2['cpt_sector']; ?></td>
            <td class="name">
              <?php if ($rFLists2['conceptm_status'] == 'new') { ?><div class="btn-info-black">New</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'approved') { ?><div class="btn-info-blue">Approved</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'rejected') { ?><div class="btn-info-red">Rejected</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'forwaded') { ?><div class="btn-info-orange">Pending</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'completed') { ?><div class="btn-info-blue">Complete</div><?php } ?>
            </td>
            <td class="name"><?php if ($totalScores) { ?>
                <p style="font-size:14px; color:#00A65A; font-weight:bold;"><?php echo $rScore['EvTotalScore']; ?></p>
              <?php } ?>
            </td>

            <td class="name">
              <?php if ($rFLists2['conceptm_status'] == 'completed') { ?><div style="color:#00A65A; font-weight:bold;">Complete</div><?php } ?>
              <?php if (!$totalScores) { ?>
                <a href="./data/score/<?php echo $rFLists2['conceptm_id']; ?>/">Click to Review</a>
              <?php } ?>


            </td>
          </tr>

      <?php }
      } ?>


    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function  

function MessagesMain()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  //////////////Get all unread messages//////////////////////////
  $sqlMSG = "SELECT * FROM " . $prefix . "rmessages where cac_sent_to='$usrm_id' and msg_status='unread'";
  $QueryMSG = $mysqli->query($sqlMSG);
  $totalMSGUread = $QueryMSG->num_rows;

  //////////////Get all sent messages//////////////////////////
  $sqlMSG1 = "SELECT * FROM " . $prefix . "rmessages where cac_sent_by='$usrm_id'";
  $QueryMSG1 = $mysqli->query($sqlMSG1);
  $totalMSGSent = $QueryMSG1->num_rows;
  //////////////Get all sent messages//////////////////////////
  $sqlMSG2 = "SELECT * FROM " . $prefix . "rmessages where cac_sent_to='$usrm_id' and msg_status='deleted'";
  $QueryMSG2 = $mysqli->query($sqlMSG2);
  $totalMSGDeleted = $QueryMSG2->num_rows;
?>
  <?php /*?><li class="compose"><a class="iconcomp" href="./user/compose/" style=" color:#18587E; font-weight:bold; text-transform:uppercase; font-size:12px;"><b>Compose</b></a></li><?php */ ?>
  <li class="b2"><a class="icon inbox" href="./user/inbox/"><b>Inbox <?php if ($totalMSGUread >= 1) { ?>(<?php echo $totalMSGUread; ?>)<?php } ?></b></a></li>
  <li class="b2"><a class="icon outbox" href="./user/sentmsg/">Sent <?php if ($totalMSGSent >= 1) { ?>(<?php echo $totalMSGSent; ?>)<?php } ?></a></li>


  <?php

} ///////////end function




function MainNotice()
{
  global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today;

  $sqlNotice = "SELECT * FROM " . $prefix . "notices where notice_date>='$today' order by notice_date desc limit 0,1";
  $QueryNotice = $mysqli->query($sqlNotice);
  $rNotice = $QueryNotice->fetch_array();
  $rTotalNotice = $QueryNotice->num_rows;
  if ($rTotalNotice) {
  ?>
    <h4>Important!</h4>
    <p style="margin: 8px 0"><?php echo $rNotice['notice_title']; ?>. <br />
      Venue: <?php echo $rNotice['notice_venue']; ?><br />
      Time: <?php echo dateformat($rNotice['notice_time'], "h:i:s A"); ?></p>
  <?php
  }
}




//begin statistics
function Statistics()
{
  ///unread posts
  global $prefix, $usrm_id, $usrm_username, $mysqli, $cac_role;
  $sqlUnread = "SELECT * FROM " . $prefix . "rmessages where cac_sent_to='$usrm_id' and msg_status='unread'";
  $QueryUnread = $mysqli->query($sqlUnread);
  $totalUnredPosts = $QueryUnread->num_rows;
  ///read posts
  $sqlRead = "SELECT * FROM " . $prefix . "rmessages where cac_sent_to='$usrm_id' and msg_status='read'";
  $QueryRead = $mysqli->query($sqlRead);
  $totalRedPosts = $QueryRead->num_rows;
  ?>

  <?php /*?>               <p class="stat"><span class="number">27</span>Notifications</p>  
   
         <p class="stat"><span class="number">53</span>Unsaved Taks</p>
    <p class="stat"><span class="number">53</span>Assigned Tasks</p><?php */ ?>
  <p class="stat"><span class="number"><?php echo $totalRedPosts; ?></span>Read Posts</p>
  <p class="stat" style="color:#F00;"><span class="number"><?php echo $totalUnredPosts; ?></span>Unread Posts</p>
<?php
} //end statistics
//begin statistics
function photo1()
{
  ///unread posts
  global $prefix, $usrm_id, $usrm_username, $mysqli, $cac_role;
  $sqlphoto1 = "SELECT * FROM " . $prefix . "musers  where usrm_id='$usrm_id' and usrm_username='$usrm_username'";
  $Queryphoto1 = $mysqli->query($sqlphoto1);
  $sqPhoto1 = $Queryphoto1->fetch_array();
?>
  <?php if ($sqPhoto1['usrm_profilepic']) { ?><img src="./files/photos/<?php echo $sqPhoto1['usrm_profilepic']; ?>" class="img-circle" />


  <?php } ?>
<?php
} //end statistics 

//begin statistics
function photo()
{
  ///unread posts
  global $prefix, $usrm_id, $usrm_username, $mysqli, $cac_role;
  $sqlphoto = "SELECT * FROM " . $prefix . "musers  where usrm_id='$usrm_id' and usrm_username='$usrm_username'";
  $Queryphoto = $mysqli->query($sqlphoto);
  $sqPhoto = $Queryphoto->fetch_array();
?>
  <?php if ($sqPhoto['usrm_profilepic']) { ?>
    <img src="./files/photos/<?php echo $sqPhoto['usrm_profilepic']; ?> " class="avatar user-thumb" /><?php } else { ?><img src="./photos/avatar.jpg" class="avatar user-thumb" /><?php } ?>

<?php
} //end statistics  











///pending evaluation
function SubmissionsByCtegories()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  /*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
  $category = $_POST['category'];
  $pages = 'data/';
  $url = 'report/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  if ($_POST['doSearch']) {
    $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts where cpt_sector='$category' and openstatus='open' and conceptm_status='forwaded'  order by conceptm_Avg desc");
  }
  if (!$_POST['doSearch']) {
    $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts  where openstatus='open' and conceptm_status='forwaded' order by conceptm_Avg desc");
  }
  // where conceptm_status='forwaded'
  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  $limitm = 150;                 //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  if ($_POST['doSearch']) {
    $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where cpt_sector='$category' and openstatus='open' and conceptm_status='forwaded' order by conceptm_Avg desc LIMIT $start, $limitm";
  }
  if (!$_POST['doSearch']) {
    $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts  where openstatus='open'  and conceptm_status='forwaded' order by conceptm_Avg desc LIMIT $start, $limitm";
  }
  $result = $mysqli->query($sql);

  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox">
      <tr class="unread">
        <th width="113" class="small-col"><strong>Proposal</strong></th>
        <th width="76" class="name"><strong>Name Of PI</strong></th>
        <th width="66" class="subject"><strong>Reviewer</strong></th>

        <th width="51" class="time"><strong>Date</strong></th>

        <th width="77" class="time"><strong>Technical Score</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="5">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {

          ///////////////////////////////////////////////

          $sconceptm_id = $rFLists2['conceptm_id'];
          $susrm_id = $rFLists2['usrm_id'];

          $sqlFLists1Nd = "SELECT * FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id'";
          //sum(EvTotalScore/5) AS TotalScores
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $rScore = $QueryFListsm1Nd->fetch_array();
          $EvTotalScore = numberformat($rScore['EvTotalScore'] / 75 * 100);
          $update = "update " . $prefix . "concepts set conceptm_Avg='$EvTotalScore' where  conceptm_id='$sconceptm_id'";
          $mysqli->query($update);


          ///who has reviewed this proposal?
          $sqlReviewedm = "SELECT count(*) as TotalRevs,sum(EvTotalScore) as TotalEvScore FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id' and usrm_id='$susrm_id' group by conceptm_id";
          $QueryReviewedm = $mysqli->query($sqlReviewedm);
          $rScReviewedm = $QueryReviewedm->fetch_array();
          //$totalReviewedm = $QueryReviewedm->num_rows;
          $rScReviewedm['TotalEvScore'];
        ?>
          <tr>
            <td class="small-col"><a href="./files/<?php echo $rFLists2['proposalm_upload']; ?>" target="_blank"><?php echo $rFLists2['proposalmTittle']; ?></a></td>
            <td class="name"><?php echo $rFLists2['ms_NameOfPI']; ?></td>
            <td class="subject">


              <?php
              //conceptm_assignedto
              $sqlFLists1NdConcept = "SELECT * FROM " . $prefix . "conceptsasslogs where conceptm_id='$sconceptm_id' ";
              $QueryFListsm1NdConcept = $mysqli->query($sqlFLists1NdConcept);
              while ($rScoreConcept = $QueryFListsm1NdConcept->fetch_array()) {
                $conceptm_assignedto = $rScoreConcept['conceptm_assignedto'];

                $sqlmusers = "SELECT * FROM " . $prefix . "musers where usrm_usrtype='reviewer' and usrm_id='$conceptm_assignedto'";
                $Querymusers = $mysqli->query($sqlmusers);
                $rmusers = $Querymusers->fetch_array(); ?>

                <?php echo $rmusers['usrm_fname']; ?> <?php echo $rmusers['usrm_sname']; ?><br />
              <?php } ?>




            </td>

            <td class="time">

              <?php echo $rFLists2['conceptm_datem']; ?>

            </td>



          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="5">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>

          </div><!--end purgination section-->
        </td>
      </tr>


    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function  





///pending evaluation
function SubmissionsByReviewer()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;

  $reviewer = $_POST['reviewer'];
  $sqlmusers = "SELECT * FROM " . $prefix . "musers where usrm_id='$reviewer'";
  $Querymusers = $mysqli->query($sqlmusers);
  $rmusers = $Querymusers->fetch_array();
?>
  <h4 style="color:#000; font-weight:bold;">Proposals Assigned to; <?php echo $rmusers['usrm_fname']; ?></h4>
  <?php
  if ($_POST['doSearch']) {
    $sql = "select * FROM " . $prefix . "conceptsasslogs where conceptm_assignedto='$reviewer' order by conceptm_id asc limit 0,100";
  }
  if (!$_POST['doSearch']) {
    $sql = "select * FROM " . $prefix . "conceptsasslogs where conceptm_assignedto='$reviewer'  order by conceptm_id asc limit 0,100";
  }
  $result = $mysqli->query($sql);
  $total_pages = $result->num_rows;

  ?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox">
      <tr class="unread">
        <th width="113" class="small-col"><strong>Proposal</strong></th>
        <th width="76" class="name"><strong>Name Of PI</strong></th>
        <th width="66" class="subject"><strong>Contacts</strong></th>
        <th width="104" class="time"><strong>Name of Institution</strong></th>
        <th width="51" class="time"><strong>Date</strong></th>
        <th width="89" class="time"><strong>Category</strong></th>
        <th width="89" class="time"><strong>Review Date</strong></th>
        <th width="77" class="time"><strong>Technical Score</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="8">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {
          ///////////////////////////////////////////////

          $sconceptm_id = $rFLists2['conceptm_id'];
          $sqlConcept = "SELECT * FROM " . $prefix . "concepts where conceptm_id='$sconceptm_id'";
          //sum(EvTotalScore/5) AS TotalScores
          $QueryConcept = $mysqli->query($sqlConcept);
          $rConcept = $QueryConcept->fetch_array();

          $susrm_id = $rConcept['usrm_id'];



          $sqlFLists1Nd = "SELECT * FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id' and EvaluatedBy='$reviewer'";
          //sum(EvTotalScore/5) AS TotalScores
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $rScore = $QueryFListsm1Nd->fetch_array();
          $EvTotalScore = numberformat($rScore['EvTotalScore'] / 75 * 100);
          $update = "update " . $prefix . "concepts set conceptm_Avg='$EvTotalScore' where  conceptm_id='$sconceptm_id'";
          $mysqli->query($update);


          ///who has reviewed this proposal?
          $sqlReviewedm = "SELECT *,count(*) as TotalRevs,sum(EvTotalScore) as TotalEvScore FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id' and usrm_id='$susrm_id' and EvaluatedBy='$reviewer' group by conceptm_id";
          $QueryReviewedm = $mysqli->query($sqlReviewedm);
          $rScReviewedm = $QueryReviewedm->fetch_array();
          //$totalReviewedm = $QueryReviewedm->num_rows;
          $rScReviewedm['TotalEvScore'];
        ?>
          <tr>
            <td class="small-col"><a href="./files/<?php echo $rConcept['proposalm_upload']; ?>" target="_blank"><?php echo $rConcept['proposalmTittle']; ?> </a></td>
            <td class="name"><?php echo $rConcept['ms_NameOfPI']; ?></td>
            <td class="subject">Email: <?php echo $rConcept['conceptm_email']; ?><br />
              Phone: <?php echo $rConcept['conceptm_phone']; ?>
            </td>
            <td class="time"><?php echo $rConcept['conceptm_NameofInstitution']; ?> </td>
            <td class="time">

              <?php echo $rConcept['conceptm_date']; ?>

            </td>
            <td class="name"><?php if ($rConcept['cpt_sector'] != 'Other') {
                                echo $rConcept['cpt_sector'];
                              } ?>
              <?php if ($rConcept['cpt_sector'] == 'Other') { ?><br />Other Sector: <?php echo $rConcept['cpt_othersector'];
                                                                              } ?>
            </td>
            <td class="time"> <?php echo $rScore['DateEvaluated']; ?> </td>

            <td class="name" style="font-size:14px; color:#00A65A; font-weight:bold; text-align:center;">

              <?php echo ($rScReviewedm['TotalEvScore']) . ''; //echo ($rScReviewedm['TotalEvScore']/$rScReviewedm['TotalRevs']).'%'; 
              ?>




              <?php if ($rScReviewedm['scoredmID']) { ?><br />
                <a href="scoresheetp.php?id=<?php echo base64_encode($rScReviewedm['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rScReviewedm['scoredmID']); ?>" onclick="return popitup('scoresheetp.php?id=<?php echo base64_encode($rScReviewedm['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rScReviewedm['scoredmID']); ?>')" style="color:#00A65A; font-weight:bold; font-size:12px;">Click to View</a>
              <?php } ?>

            </td>


          </tr>

      <?php }
      } ?>



    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function  	 


















function ApprovedFrowardedForReviewProposals()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  /*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
  $pages = 'data/';
  $url = 'admpapprovedfr/';
  //$value='listuserauthorised';

  $tbl_name = "";    //your table name
  // How many adjacent pages should be shown on each side?
  $adjacents = 3;
  /* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
  $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "concepts  where conceptm_status='approved' and categorym='proposals' order by conceptm_date desc");
  $total_pages = $query->fetch_array();
  $total_pages = $total_pages[num];

  /* Setup vars for query. */
  //$targetpage = $page.$url.$value; 
  $targetpage = $pages . $url;   //your file name  (the name of this file)
  $limitm = 15;                 //how many items to show per page
  $page = $_GET['pages'];

  /*Extract Last Value from a link*/
  $RequestURI = end(explode("/", $_SERVER['REQUEST_URI']));
  $page = preg_replace('/\D/', '', $RequestURI);
  //how many items to show per page
  if ($page)
    $start = ($page - 1) * $limitm;       //first item to display on this page
  else
    $start = 0;                //if no page var is given, set start to 0

  /* Get data. */
  $sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM " . $prefix . "concepts where conceptm_status='approved'  and categorym='proposals' order by conceptm_date desc LIMIT $start, $limitm";
  $result = $mysqli->query($sql);

  /* Setup page vars for display. */
  if ($page == 0) $page = 1;          //if no page var is given, default to 1.
  $prev = $page - 1;              //previous page is page - 1
  $next = $page + 1;              //next page is page + 1
  $lastpage = ceil($total_pages / $limitm);    //lastpage is = total pages / items per page, rounded up.
  $lpm1 = $lastpage - 1;            //last page minus 1

  /* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
  $pagination = "";
  if ($lastpage > 1) {
    $pagination .= "<div class=\"pagination\">";
    //previous button
    if ($page > 1)
      $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
    else
      $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

    //pages	
    if ($lastpage < 7 + ($adjacents * 2))  //not enough pages to bother breaking it up
    {
      for ($counter = 1; $counter <= $lastpage; $counter++) {
        if ($counter == $page)
          $pagination .= "<span class=\"current\">$counter</span>";
        else
          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
      }
    } elseif ($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
    {
      //close to beginning; only hide later pages
      if ($page < 1 + ($adjacents * 2)) {
        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }
      //in middle; hide some front and some back
      elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
        $pagination .= "...";
        $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
        $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
      }

      //close to end; only hide early pages
      else {
        $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
        $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
        $pagination .= "...";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
          if ($counter == $page)
            $pagination .= "<span class=\"current\">$counter</span>";
          else
            $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
        }
      }
    }

    //next button
    if ($page < $counter - 1)
      $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
    else
      $pagination .= "<span class=\"disabled\">next&raquo;</span>";
    $pagination .= "</div>";
  }
?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox">


      <tr>
        <td class="small-col" colspan="8">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>
          </div><!--end purgination section-->
        </td>
      </tr>


      <tr class="unread">
        <th width="223" class="small-col"><strong>Proposal</strong></th>
        <th width="124" class="small-col"><strong>Name Of PI</strong></th>
        <th width="167" class="name"><strong>Name of Institution</strong></th>
        <th width="149" class="subject"><strong>Contacts</strong></th>
        <th width="101" class="time"><strong>Date</strong></th>
        <th width="125" class="time"><strong>Sector</strong></th>
        <th width="123" class="time"><strong>Status</strong></th>
        <th width="94" class="time"><strong>Action</strong></th>
      </tr>
      <?php if (!$total_pages) { ?>
        <tr>
          <td class="small-col" colspan="8">
            <p>No results displayed</p>
          </td>
        </tr>
        <?php } else {

        while ($rFLists2 = $result->fetch_array()) {

          ///////////////////////////////////////////////

          $conceptm_id = $rFLists2['conceptm_id'];
          $sqlFLists1Nd = "SELECT sum(EvTotalScore/5) AS TotalScores FROM " . $prefix . "mscores where conceptm_id='$conceptm_id' and categorym='proposals'";
          $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
          $rScore = $QueryFListsm1Nd->fetch_array();
        ?>
          <tr>
            <td class="small-col"><span class="time"><a href="./files/<?php echo $rFLists2['proposalm_upload']; ?>" target="_blank"><?php echo $rFLists2['proposalmTittle']; ?></a></span></td>
            <td class="small-col"><?php echo $rFLists2['ms_NameOfPI']; ?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */ ?></td>
            <td class="name"><?php echo $rFLists2['conceptm_NameofInstitution']; ?></td>
            <td class="subject">Email: <?php echo $rFLists2['conceptm_email']; ?><br />
              Phone: <?php echo $rFLists2['conceptm_phone']; ?> </td>
            <td class="time">

              <?php echo $rFLists2['conceptm_datem']; ?> </td>
            <td class="name"><?php if ($rFLists2['cpt_sector'] != 'Other') {
                                echo $rFLists2['cpt_sector'];
                              } ?>
              <?php if ($rFLists2['cpt_sector'] == 'Other') { ?><br />Other Sector: <?php echo $rFLists2['cpt_othersector'];
                                                                              } ?></td>
            <td class="name">
              <?php if ($rFLists2['conceptm_status'] == 'new') { ?><div class="btn-info-black">New</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'approved') { ?><div class="btn-info-blue">Approved for Review</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'rejected') { ?><div class="btn-info-red">Rejected</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'pending') { ?><div class="btn-info-blue">Pending Review</div><?php } ?>
              <?php if ($rFLists2['conceptm_status'] == 'completed') { ?><div class="btn-info-blue">Complete</div><?php } ?>
              <?php
              $sqlAssigned = "SELECT * FROM " . $prefix . "conceptsasslogs where conceptm_id='$conceptm_id'  and categorym='proposals'";
              $QueryAssigned = $mysqli->query($sqlAssigned);
              $totalAssigned = $QueryAssigned->num_rows;



              if ($rFLists2['conceptm_status'] == 'forwaded') { ?><div class="btn-info-orange">Forwarded to <a href="./main.php?option=dashboard" title="
<?php
                while ($rQueryAssigned = $QueryAssigned->fetch_array()) {
                  $sto = $rQueryAssigned['conceptm_assignedto'];
                  $sqlAssigned = "SELECT * FROM " . $prefix . "musers where usrm_id='$sto'";
                  $sqlAssigned = $mysqli->query($sqlAssigned);
                  $syAssigned = $sqlAssigned->fetch_array();
                  echo $syAssigned['usrm_fname'] . '&nbsp;' . $syAssigned['usrm_sname'] . '&nbsp;|&nbsp;';
                } ?>" style="color:#FFF; font-weight:bold;"><?php echo $totalAssigned; ?></a> Reviewers</div><?php } ?>


              <?php if ($rFLists2['conceptm_status'] == 'evaluated') { ?><div class="btn-info-eval">Reviewed</div><?php } ?></td>

            <td class="name"><?php if ($rFLists2['conceptm_status'] == 'approved') { ?>
                <a href="./data/assign/<?php echo $rFLists2['conceptm_id']; ?>/" style="color:#00A65A;">Forward Submission</a>
              <?php } ?>

              <?php if ($rFLists2['conceptm_status'] == 'new') { ?>
                <a href="./data/review/<?php echo $rFLists2['conceptm_id']; ?>/">Click to Review</a>
              <?php } ?>
            </td>
          </tr>

      <?php }
      } ?>


      <tr>
        <td class="small-col" colspan="8">
          <div class="nav_purgination">
            <?php echo $pagination; ?>
            <div class="clear"></div>
          </div><!--end purgination section-->
        </td>
      </tr>
    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function 


function SentToSubmitProposals()
{
  global $prefix, $usrm_id, $usrm_username, $mysqli;
  $category = $_POST['category'];
?>
  <?php GenerateReviewrsByCategory(); ?>
  <?php
  if ($category) {
    $sql = "select * FROM grantsmr_mscores,grantsmr_concepts where grantsmr_mscores.conceptm_id=grantsmr_concepts.conceptm_id and grantsmr_concepts.categorym='concepts' and grantsmr_concepts.cpt_sector='$category' and conceptm_status='completed'  and sentNotify='Yes' group by grantsmr_concepts.conceptm_id order by EvgeneralTotal desc LIMIT 0,100";
  }
  if (!$category) {
    $sql = "select * FROM grantsmr_mscores,grantsmr_concepts where grantsmr_mscores.conceptm_id=grantsmr_concepts.conceptm_id and grantsmr_concepts.categorym='concepts'  and sentNotify='Yes' group by grantsmr_concepts.conceptm_id order by EvgeneralTotal desc LIMIT 0,100";
  }


  $result = $mysqli->query($sql);
  ?>
  <div class="table-responsive">
    <!-- THE MESSAGES -->
    <table class="table table-mailbox" width="100%">
      <tr class="unread" style="font-size:13px;">
        <th width="290" class="small-col"><strong>Proposal</strong></th>
        <th width="204" class="time"><strong>Reviewer</strong></th>
        <th width="171" class="time"><strong>Name of PI</strong></th>
        <th width="171" class="time"><strong>Technical Review Score</strong></th>
        <th width="90" class="time"><strong>Average Score</strong></th>
        <!--<th width="117" class="time"><strong>Viva Score</strong></th>-->
        <th width="98" class="time"><strong>Total Score</strong></th>

      </tr>


      <?php
      while ($rFLists2 = $result->fetch_array()) {
        $sconceptm_id = $rFLists2['conceptm_id'];
        $ownerID = $rFLists2['usrm_id'];
        $usrm_email = $rFLists2['usrm_email'];
        $EvaluatedBy = $rFLists2['EvaluatedBy'];

        $queryContributionRT = "select * from " . $prefix . "concepts where conceptm_id='$sconceptm_id' and sentNotify='Yes'";
        $rs_ContributionRT = $mysqli->query($queryContributionRT);
        $rsContributionRT = $rs_ContributionRT->fetch_array();



      ?>
        <tr>
          <td class="small-col"><?php //echo $sconceptm_id;
                                ?> <a href="./files/<?php echo $rsContributionRT['proposalmTittle']; ?>" target="_blank" style="font-size:12px;"><?php echo $rsContributionRT['proposalmTittle']; ?> | <?php echo $ownerID; //echo $rsContributionRT['conceptm_id'];
                                                                                                                                                                                                                                ?></a>

          </td>




          <td colspan="6" class="time">

            <table width="100%" border="0">
              <?php
              $sqlConcepts = "SELECT * FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id' order by EvTotalScore desc";
              $QueryConcepts = $mysqli->query($sqlConcepts); //EvaluatedBy='$EvaluatedBy' and conceptm_id='$sconceptm_id' 
              while ($rConcepts = $QueryConcepts->fetch_array()) {
                $dsconceptm_id = $rConcepts['conceptm_id'];
                $susrm_id = $rConcepts['usrm_id'];
                $evaluatedBy = $rConcepts['EvaluatedBy'];

                //////////////////////////////////////////////////////////////////////////////////////
                $queryReviwer = "select * from " . $prefix . "musers where usrm_id='$evaluatedBy'";
                $rs_Reviwer = $mysqli->query($queryReviwer);
                $rsReviwer = $rs_Reviwer->fetch_array();

                //proposal Owner
                $queryContribution2 = "select * from " . $prefix . "musers where usrm_id='$susrm_id'";
                $rs_Contributio2 = $mysqli->query($queryContribution2);
                $rsContribution2 = $rs_Contributio2->fetch_array();

                //get concept
                $sqlConcepts2 = "SELECT * FROM " . $prefix . "concepts where conceptm_id='$sconceptm_id'";
                $QueryConcepts2 = $mysqli->query($sqlConcepts2);
                $rConcepts2 = $QueryConcepts2->fetch_array();
                ///////////////////////get scores
                /*$sqlScoreReview="SELECT * FROM ".$prefix."mscores where conceptm_id='$sconceptm_id' order by EvTotalScore desc";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
$rScoreReview = $QueryScoreReview->fetch_array();*/

                ///who has reviewed this proposal?
                $sqlReviewedm = "SELECT count(*) as TotalRevs,sum(EvTotalScore) as TotalEvScore FROM " . $prefix . "mscores where conceptm_id='$sconceptm_id' and usrm_id='$susrm_id' group by conceptm_id"; // order by EvTotalScore desc
                $QueryReviewedm = $mysqli->query($sqlReviewedm);
                $rScReviewedm = $QueryReviewedm->fetch_array();
                //$totalReviewedm = $QueryReviewedm->num_rows;
                $rScReviewedm['TotalEvScore'];

              ?>

                <tr>
                  <td width="24%" style="border-bottom:1px dotted #EAEAEA; padding-right:5px;"><?php echo $rsReviwer['usrm_fname']; ?> <?php echo $rsReviwer['usrm_sname']; ?></td>
                  <td width="20%" style="border-bottom:1px dotted #EAEAEA;"><?php echo $rsContribution2['usrm_fname']; ?> <?php echo $rsContribution2['usrm_sname']; ?></td>


                  <td width="20%" style="color:#0073B7; font-weight:bold; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">

                    <?php echo ($rConcepts['STQnewMethods'] + $rConcepts['STQhighQuality'] + $rConcepts['STQSatisfactoryPartnership'] + $rConcepts['AppAddressIssues'] + $rConcepts['ImpactClearlyConvincingly'] + $rConcepts['ImpactGenderIssues']); ?>

                    <?php if ($rConcepts['scoredmID']) { ?><br />
                      <a href="scoresheetp.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rConcepts['scoredmID']); ?>" onclick="return popitup('scoresheetp.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rConcepts['scoredmID']); ?>')" style="color:#00A65A; font-weight:bold; font-size:12px;">Click to View</a>
                    <?php } ?>






                    <?php //if($rScoreReview['EvTotalScore']){echo numberformat($rScoreReview['EvTotalScore']/75*100).'%';}
                    ?>
                  </td>
                  <td width="12%" style="color:#00A3CB; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">
                    <?php
                    //Average score=Technical Review Score/no of reviewers

                    ?>
                    <?php if ($rConcepts['EvSame'] == 1) { ?><?php echo round(($rScReviewedm['TotalEvScore'] / $rScReviewedm['TotalRevs']), 2); ?> <?php } ?>

                  </td>


                  <td width="11%" style="color:#0073B7; font-weight:bold; text-align:center;border-bottom:1px dotted #EAEAEA; padding:5px;">

                    <?php
                    //Total Score=Average+Total Score
                    if ($rConcepts['EvTotalScore'] and $rConcepts['EvSame'] == 1) {
                      echo round(($rScReviewedm['TotalEvScore'] / $rScReviewedm['TotalRevs']) + $rConcepts['EVivaScore'], 2);
                    }
                    $getGeneralTotal = round(($rScReviewedm['TotalEvScore'] / $rScReviewedm['TotalRevs']) + $rConcepts['EVivaScore'], 2);
                    $sqlGeneral = "update " . $prefix . "mscores set EvgeneralTotal='$getGeneralTotal' where conceptm_id='$sconceptm_id' and usrm_id='$susrm_id'"; // order by EvTotalScore desc
                    //$mysqli->query($sqlGeneral);


                    ?></td>


                </tr>



              <?php } ?>
            </table>
          </td>

          <td class="small-col"><?php if ($rsContributionRT['sentNotify'] == 'No') { ?><a href="./data/replySuccessful/<?php echo $rFLists2['conceptm_id']; ?>/" style="color:#00C0EF;">Reply Applicant</a> <?php } ?>


            <?php if ($rsContributionRT['sentNotify'] == 'Yes') { ?><a href="notified.php?id=<?php echo base64_encode($rFLists2['conceptm_id']); ?>" onclick="return popitup('notified.php?id=<?php echo base64_encode($rFLists2['conceptm_id']); ?>')" style="color:#09F; font-weight:bold;">Passed</a> <?php } ?>

            <?php if ($rsContributionRT['sentNotify'] == 'Failed') { ?><a href="notified.php?id=<?php echo base64_encode($rFLists2['conceptm_id']); ?>" onclick="return popitup('notified.php?id=<?php echo base64_encode($rFLists2['conceptm_id']); ?>')" style="color:#C30; font-weight:bold;">Failed</a> <?php } ?>

          </td>

        </tr>

      <?php } ?>




    </table>
  </div><!-- /.table-responsive -->

<?php


} ///////////end function	

function logaction($action)
{
  global $db, $prefix, $mysqli, $session_fullname, $session_asrmStatus, $address, $usrm_id;
  $SERVER_ADDR = $_SERVER['SERVER_ADDR'];
  $queryMyLogged = "select * from " . $prefix . "musers where usrm_id='$usrm_id'";
  $rs_MyLogged = $mysqli->query($queryMyLogged);
  $rsLoggedMy = $rs_MyLogged->fetch_array();
  $usrm_email = $rsLoggedMy['usrm_email'];

  $action = $mysqli->real_escape_string($action);
  $sql = "INSERT INTO " . $prefix . "mlogs (log_details, logname, logemail,logip,logdate) VALUES('$action', '$session_fullname', '$usrm_email','$SERVER_ADDR',now())";
  $mysqli->query($sql);
}
////////end time out///////////////////////////////////////////////////////////////////////	  

function TotalMembersGraph()
{
  global $mysqli, $prefix, $Mlinks, $category, $id, $asrmApplctID;
  $sqlActive = "SELECT * FROM " . $prefix . "musers where usrm_usrtype='user' order by usrm_id desc";
  $QueryActive = $mysqli->query($sqlActive);
  $rsActive = $QueryActive->num_rows;
  $sqlPending = "SELECT * FROM " . $prefix . "musers where (usrm_usrtype='superadmin' || usrm_usrtype='admin') order by usrm_id desc";
  $QueryPending = $mysqli->query($sqlPending);
  $rsPending = $QueryPending->num_rows;
  $sqlInActive = "SELECT * FROM " . $prefix . "musers where usrm_usrtype='reviewer' order by usrm_id desc";
  $QueryInActive = $mysqli->query($sqlInActive);
  $rsInActive = $QueryInActive->num_rows;
?>
  <canvas id="myChart" width="200" height="200"></canvas>
  <script>
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Users', 'Reviewers', 'Administrators'],
        datasets: [{
          label: 'Members',
          data: [<?php echo $rsActive; ?>, <?php echo $rsPending; ?>, <?php echo $rsInActive; ?>],
          backgroundColor: [
            'rgba(239, 76, 76, 0.9)',
            'rgba(239, 76, 76, 0.6)',
            'rgba(239, 76, 76, 0.4)'
          ],
          borderColor: [
            'rgba(239, 76, 76, 1)',
            'rgba(239, 76, 76, 1)',
            'rgba(239, 76, 76, 1)'
          ],
          borderWidth: 0
        }]
      },
      /*options: {F4516C
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }*/
    });
  </script><?php

          }

          function SubmittedConceptsGraph()
          {
            global $mysqli, $prefix, $Mlinks, $category, $id, $asrmApplctID;
            $sqlChceckWallet = "SELECT *  FROM " . $prefix . "submissions_concepts where projectStatus='Pending Final Submission' order by conceptID desc";
            $QueryceckWallet = $mysqli->query($sqlChceckWallet);
            $pending = $QueryceckWallet->num_rows;


            $sqlChceckWallet2 = "SELECT *  FROM " . $prefix . "submissions_concepts where projectStatus='Scheduled for Review' order by conceptID desc";
            $QueryceckWallet2 = $mysqli->query($sqlChceckWallet2);
            $Scheduled = $QueryceckWallet2->num_rows;

            ?>
  <canvas id="myChart2" width="200" height="200"></canvas>
  <script>
    var ctx = document.getElementById('myChart2');
    var myChart2 = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ['Pending Final Submission', 'Scheduled for Review'],
        datasets: [{
          label: 'Applications',
          data: [<?php echo $pending; ?>, <?php echo $Scheduled; ?>],
          backgroundColor: [
            'rgba(29, 132, 235, 0.9)',
            'rgba(29, 132, 235, 0.4)'
          ],
          borderColor: [
            'rgba(29, 132, 235, 1)',
            'rgba(29, 132, 235, 1)'
          ],
          borderWidth: 0
        }]
      },
      /*options: {F4516C
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }*/
    });
  </script><?php

          }

          function SubmittedProposalsGraph()
          {
            global $mysqli, $prefix, $Mlinks, $category, $id, $asrmApplctID;
            $sqlChceckWallet = "SELECT *  FROM " . $prefix . "submissions_proposals where projectStatus='Pending Final Submission' order by projectID desc";
            $QueryceckWallet = $mysqli->query($sqlChceckWallet);
            $pending = $QueryceckWallet->num_rows;


            $sqlChceckWallet2 = "SELECT *  FROM " . $prefix . "submissions_proposals where projectStatus='Scheduled for Review' order by projectID desc";
            $QueryceckWallet2 = $mysqli->query($sqlChceckWallet2);
            $Scheduled = $QueryceckWallet2->num_rows;

            $sqlApproved = "SELECT *  FROM " . $prefix . "submissions_proposals where projectStatus='Approved' order by projectID desc";
            $QueryApproved = $mysqli->query($sqlApproved);
            $Approved = $QueryApproved->num_rows;

            $sqlReviewed = "SELECT *  FROM " . $prefix . "submissions_proposals where projectStatus='Reviewed' order by projectID desc";
            $QueryReviewed = $mysqli->query($sqlReviewed);
            $Reviewed = $QueryReviewed->num_rows;

            $sqlRejected = "SELECT *  FROM " . $prefix . "submissions_proposals where projectStatus='Rejected' order by projectID desc";
            $QueryRejected = $mysqli->query($sqlRejected);
            $Rejected = $QueryRejected->num_rows;
            //'Pending Review','','Rejected','Reviewed'

            ?>
  <canvas id="myChart4" height="220"></canvas>

  <script type="text/javascript">
    var ctx = document.getElementById('myChart4').getContext('2d');
    var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'line',

      // The data for our dataset
      data: {
        labels: ["Pending Final Submission", "Scheduled for Review", "Reviewed", "Approved", "Rejected"],
        datasets: [{
          label: "Submitted Proposals",
          backgroundColor: 'rgb(255, 99, 132)',
          borderColor: 'rgb(54, 162, 235)',
          data: [<?php echo $pending; ?>, <?php echo $Scheduled; ?>, <?php echo $Reviewed; ?>, <?php echo $Approved; ?>, <?php echo $Rejected; ?>],
        }]
      },

      // Configuration options go here
      options: {}
    });
  </script>

<?php

          }
?>