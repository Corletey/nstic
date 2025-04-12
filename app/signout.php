<?php
session_start();
require_once('configlrcn/db_mconfig.php');

$user=$_SESSION['mmfullname'];
$usersipaddress=$_SERVER['REMOTE_ADDR'];
//set logut time
$sql4 = "INSERT INTO ".$prefix."logs(lg_action, lg_user, lg_user_level,lg_time) VALUES('$user Logged out from $usersipaddress', '$user', '".$_SESSION['usrm_user_group']."','$dateSubmitted')";
//$mysqli->query($sql4);

unset($_SESSION['cfn_user_id']);
unset($_SESSION['cfn_email']);
unset($_SESSION['cfn_usrtype']);
unset($_SESSION['cfn_usrname']);
unset($_SESSION['cfn_profession']);
unset($_SESSION['cfn_organisation']);
unset($_SESSION['mmfullname']);
/* Delete the cookies*******************/
setcookie("cfn_user_id", '', time()-60*60*24*60, "/");
setcookie("cfn_email", '', time()-60*60*24*60, "/");
setcookie("cfn_usrtype", '', time()-60*60*24*60, "/");
setcookie("cfn_usrname", '', time()-60*60*24*60, "/");
setcookie("cfn_profession", '', time()-60*60*24*60, "/");
setcookie("cfn_organisation", '', time()-60*60*24*60, "/");
setcookie("mmfullname", '', time()-60*60*24*60, "/");
/******************* After Logout set this to any redirect page you want*************/



//header("Location:".$base_url);
echo '<meta http-equiv="refresh" content="0;url=../"> ';




?> 