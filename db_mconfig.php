<?php
error_reporting(0);
$hostm   = "localhost";
$dbm = "slgrants";//slgrants
$usrm   = "root";//root
$pwdm   = "";//
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
date_default_timezone_set('Africa/Kampala');
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
    $base_url = 'http://http://appelaprojets.fonrid.com/h/app/';
} 
if ($_SERVER['HTTP_HOST'] == "http://appelaprojets.fonrid.com/") {
    $base_url = 'http://http://appelaprojets.fonrid.com//app/';
} 
if ($_SERVER['HTTP_HOST'] == "www.http://appelaprojets.fonrid.com/") {
   $base_url = 'http://http://www.appelaprojets.fonrid.com//app/';
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
$usmtpportNo="465"; // SMTP Port
$usmtpHost="mailer.gov.bf";/**/

$emailUsername="herve.pale@fonrid.bf"; // SMTP username -- CHANGE --
$emailPassword="B@rga1n01"; // SMTP password -- CHANGE --
$emailSSL="tls";
$emailBcc="herve.pale@fonrid.bf";
/*
//Office 365
$mail->Port = "587"; // SMTP Port
$mail->Host = "smtp.office365.com";


*/
?>
