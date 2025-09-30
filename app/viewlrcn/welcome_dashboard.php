                          
<?php if($session_usertype=='reviewer'){//require_once("viewlrcn/reviewer_dashboard_stats.php"); 
require_once("viewlrcn/reviewer_dashboard.php"); }?>

<?php if($session_usertype=='user'){ require_once("viewlrcn/user_dashboard.php"); //require_once("user_dashboard_stats.php");
}?>                                
                              