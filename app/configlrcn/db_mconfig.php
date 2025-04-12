<?php
error_reporting(1);
$hostm   = "localhost";
$dbm = "slgrants";//slgrants
$usrm   = "root";//"aauadmin_grants_sgci";//root
$pwdm   = "";//"4a6LzTBG+H)"
//object oriented style (recommended)
$mysqli = new mysqli($hostm,$usrm,$pwdm,$dbm);
//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
  ///////////////////////site details
$sitename="Grants Management";/*Public – Private Partnerships (PPP) in Research and Innovation Grants*/
$prefix="ppr_";
$siteshortname="Grants Management";
///////////////////key words//////////////////
$keywords="Grants Management";
$metatags="Grants Management";
//////////////////////////////Time Zone////////////////////
date_default_timezone_set('Africa/Accra');
$today=date("Y-m-d");
$year=date("Y");
$time=date("H:i:s");
$usersipaddress=$_SERVER['REMOTE_ADDR'];
$sesdate=date("Y/m/d/");
$sesdatem=date("d/m/Y");
//G-24 hour without a leading zero
//H-24 hour with a leading zero
$localtime=date("G:i:s");
$dateSubmitted=date("Y-m-d G:i:s");
$Hour=date("G:i");
$todayfull=date("l jS \of F Y h:i:s A");
////////////mysql///////////////

////////////////////Get Base URL Link/////////////////////



if ($_SERVER['HTTP_HOST'] == "localhost") {
    $base_url = 'http://localhost/nstic-grants/app/';
} 
if ($_SERVER['HTTP_HOST'] == "careersug.com") {
    $base_url = 'https://careersug.com/grants/app/';
} 
if ($_SERVER['HTTP_HOST'] == "www.careersug.com") {
   $base_url = 'https://careersug.com/grants/app/';
}

///Check from configuration Table
$query_T ="SELECT * FROM ".$prefix."configuration order by id desc limit 0,1";
$rsT = $mysqli->query($query_T);
$rowsWT=$rsT->fetch_array();
$name_granting_council=$rowsWT['name_granting_council'];
$physical_address=$rowsWT['physical_address'];
$postal_address=$rowsWT['postal_address'];
$post_email=$rowsWT['email'];
$post_telephone=$rowsWT['telephone'];
$fulladdress="$name_granting_council<br>
$physical_address<br>
$postal_address<br>
$post_email<br>
$post_telephone<br>
";
//Below are SMTP DETAILS for email
/*
$usmtpportNo="465"; // SMTP Port
$usmtpHost="smtp.gmail.com";

$emailUsername="aaumail1@gmail.com"; // SMTP username -- CHANGE --
$emailPassword="ycrooepturbagkud"; // SMTP password -- CHANGE --
$emailSSL="ssl";
$emailBcc="aaumail1@gmail.com";
/**/ 


//Office 365
//$mail->Port = "587"; // SMTP Port
//$mail->Host = "smtp.office365.com";

$usmtpportNo="465"; // SMTP Port
$usmtpHost="smtp.hostinger.com";/**/

$emailUsername="emmanuel@mannie-sl.com"; // SMTP username -- CHANGE --
$emailPassword="Emmanuel12555."; // SMTP password -- CHANGE --
$emailSSL="ssl";
$emailBcc="emmanuel@mannie-sl.com";


?>