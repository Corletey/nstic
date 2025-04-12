<?php
session_start();
require_once('contrlrcn/c_mlsrcontrol.php'); 
timeout($timeout);
?><!doctype html>
<html class="no-js" lang="en">

<head>
<base href="<?php echo $base_url;?>" />
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $sitename;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
  <script src="js/ajax_populate.js"></script>
    
    
   <script type="text/javascript">
        function refreshParent() {
            if (window.opener != null && !window.opener.closed) {
                window.opener.location.reload();
            }
        }
        //call the refresh page on closing the window
        window.onunload = refreshParent;
    </script>


</head>

<body>
    <!--[if lt IE 8]>
         
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="./main.php?option=dashboard"><img src="assets/images/icon/logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                      <?php include("viewlrcn/menu.php");?>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
       
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6" >
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="./data/dashboard">Home</a></li>
                                <li><span>Dashboard</span></li>
                            </ul>
                        </div>
                        
                        
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <?php photo();?>
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['usrm_username'];?> <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
 
                                <a class="dropdown-item" href="signout.php?Logout">Log Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">
                   
<?php
 $owner_id=$_GET['owner_id'];
$sqlSOwner = "select * from ".$prefix."musers where usrm_id='$owner_id'";
$resOwner = $mysqli->query($sqlSOwner);
$sqOwner = $resOwner->fetch_array();
$OwnerName=$sqOwner['usrm_fname'].' '.$sqOwner['usrm_sname'];
$reviewerEmail=$sqOwner['usrm_email'];
?>    
               
   <div class="success" style="font-size:18px;">Award Grant  to <?php echo $OwnerName;?></div>             
      <?php
$categorym=$_GET['categorym'];

$assignm_id=$_GET['assignm_id'];
//doSaveFive
// and $assignm_id and $id and $_POST['AmountofGrantawarded'] and $_POST['projectDurationID']
if($_POST['doSaveAward'] and $_POST['awarded']="Yes" and $_FILES['awardagreement']['name']){


	$reviewer_id=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$awarded=$mysqli->real_escape_string($_POST['awarded']);
	$AmountofGrantawarded=$mysqli->real_escape_string($_POST['AmountofGrantawarded']);
    $DurationofGrant=$mysqli->real_escape_string($_POST['DurationofGrant']);
	$currency=$mysqli->real_escape_string($_POST['currency']);
	$projectDurationID=$mysqli->real_escape_string($_POST['projectDurationID']);
    $awardDate=$mysqli->real_escape_string($_POST['awardDate']);
//////////////update
$awardagreement = preg_replace('/\s+/', '_', $_FILES['awardagreement']['name']);
if($awardagreement2 = $owner_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['awardagreement']['name']))){
	
$targetw1 = "files/". basename($owner_id.preg_replace('/\s+/', '_', $_FILES['awardagreement']['name']));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['awardagreement']['tmp_name']), $targetw1);

$sqlFLists1="SELECT *,DATE_FORMAT(`updatedon`,'%d/%m/%Y %H:%s:%i') AS updatedonm FROM ".$prefix."submissions_proposals where projectID='$id' order by projectID desc";
$QueryFListsm1=$mysqli->query($sqlFLists1);
$rFLists2=$QueryFListsm1->fetch_array(); 
$conceptm_id=$rFLists2['projectID']; 
$public_title=$rFLists2['projectTitle']; 



///Send Mail to Admin
	///Which admin has reviewed this protocol
$sqlSOwner2 = "select * from ".$prefix."musers where usrm_id='$owner_id'";
$resOwner2 = $mysqli->query($sqlSOwner2);
$sqOwner2 = $resOwner2->fetch_array();
$OwnerName2=$sqOwner2['usrm_fname'].' '.$sqOwner2['usrm_sname'];
$OwnerEmail=$sqOwner2['usrm_email'];
//$period = preg_replace('/\D/', '', $rFLists2['projectDurationID']);
$period = preg_replace('/\D/', '', $projectDurationID);
//$endofproject = date("d/m/Y", strtotime($dateSubmitted . "+$period month"));
if($period>=1 and $period<=12){
$periodYears=12;	
}
if($period>=13 and $period<=24){
$periodYears=24;
}
if($period>=25 and $period<=36){
$periodYears=36;
}
if($period>=37 and $period<=48){
$periodYears=48;
}
if($period>=49 and $period<=60){
$periodYears=60;
}

$dateSubmitted2=date("Y-m-d");

$endofproject = date("d/m/Y", strtotime($dateSubmitted . "+$periodYears month"));
$startOfProject=date("d/m/Y", strtotime($dateSubmitted));
$PrevDateSubmited=date("d/m/Y", strtotime($dateSubmitted));

$endofproject22 = date("Y-m-d", strtotime($dateSubmitted . "+$periodYears month"));

$DurationofGrant="$projectDurationID Months";
$sqlA2ProtocolaSS="update ".$prefix."submissions_proposals set projectStatus='Reviewed',awarded='$awarded',`awardDate`='$awardDate',`EndProject`='$endofproject22',`AmountofGrantawarded`='$AmountofGrantawarded',`DurationofGrant`='$DurationofGrant',`TermsConditions`='No',`currency`='$currency',`award_agreement`='$awardagreement2' where projectID='$id'";
$mysqli->query($sqlA2ProtocolaSS);	

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 	

require_once("viewlrcn/mail_template_award_grants.php");
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
$mail->setFrom("$emailUsername", "$OwnerName2");
$mail->FromName = "$OwnerName2"; // From Name -- CHANGE --

$mail->addBcc("$emailBcc", "Grant Management Team");

$mail->FromName = "Grants Management Office"; //From Name -- CHANGE --
$mail->AddAddress("$OwnerEmail", $OwnerName2); //To Address -- CHANGE --$email   $OwnerEmail
//if($dbEmail2){echo $mail->addCc($dbEmail2,'Activation Link from UNCST');}
$mail->AddReplyTo("$emailBcc", "Grants Management Office"); //Reply-To Address -- CHANGE --$usrm_email


$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Award of Grant - $public_title";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}///end	
	

echo "
<script type=\"text/javascript\">
        alert('Successfully updated...');
        window.close();
</script>";

}//end Attached Agreement
}//end post
////Dont award this Grant. Condition ="yes"
if($_POST['doSaveAward'] and $_POST['awarded']="no" and !$_FILES['awardagreement']['name']){


	$reviewer_id=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$awarded=$mysqli->real_escape_string($_POST['awarded']);
	$AmountofGrantawarded=$mysqli->real_escape_string($_POST['AmountofGrantawarded']);
    $DurationofGrant=$mysqli->real_escape_string($_POST['DurationofGrant']);
	$grantrejectcomment=$mysqli->real_escape_string($_POST['grantrejectcomment']);
	$projectDurationID=$mysqli->real_escape_string($_POST['projectDurationID']);
//////////////update

$sqlFLists1="SELECT *,DATE_FORMAT(`updatedon`,'%d/%m/%Y %H:%s:%i') AS updatedonm FROM ".$prefix."submissions_proposals where projectID='$id' order by projectID desc";
$QueryFListsm1=$mysqli->query($sqlFLists1);
$rFLists2=$QueryFListsm1->fetch_array(); 
$conceptm_id=$rFLists2['projectID']; 
$public_title=$rFLists2['projectTitle']; 



///Send Mail to Admin
	///Which admin has reviewed this protocol
$sqlSOwner2 = "select * from ".$prefix."musers where usrm_id='$owner_id'";
$resOwner2 = $mysqli->query($sqlSOwner2);
$sqOwner2 = $resOwner2->fetch_array();
$OwnerName2=$sqOwner2['usrm_fname'].' '.$sqOwner2['usrm_sname'];
$OwnerEmail=$sqOwner2['usrm_email'];
//$period = preg_replace('/\D/', '', $rFLists2['projectDurationID']);
$period = preg_replace('/\D/', '', $projectDurationID);
//$endofproject = date("d/m/Y", strtotime($dateSubmitted . "+$period month"));

//Duration is determined by the number of months you choose. If you choose 1 month to 12 months, duration is one year, if you choose 13-24, duration is 2years and so on...
if($period>=1 and $period<=12){
$periodYears=12;	
}
if($period>=13 and $period<=24){
$periodYears=24;
}
if($period>=25 and $period<=36){
$periodYears=36;
}
if($period>=37 and $period<=48){
$periodYears=48;
}
if($period>=49 and $period<=60){
$periodYears=60;
}

$dateSubmitted2=date("Y-m-d");
//Compute when the projects should end
$endofproject = date("d/m/Y", strtotime($dateSubmitted . "+$periodYears month"));
$startOfProject=date("d/m/Y", strtotime($dateSubmitted));
$PrevDateSubmited=date("d/m/Y", strtotime($dateSubmitted));

$endofproject22 = date("Y-m-d", strtotime($dateSubmitted . "+$periodYears month"));

$DurationofGrant="$projectDurationID Months";
$sqlA2ProtocolaSS="update ".$prefix."submissions_proposals set projectStatus='Reviewed',awarded='$awarded',`grantrejectcomment`='$grantrejectcomment' where projectID='$id'";
$mysqli->query($sqlA2ProtocolaSS);	

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 	

require_once("viewlrcn/mail_template_award_grants_no.php");
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
$mail->setFrom("$emailUsername", "$OwnerName2");

$mail->FromName = "Grants Management Office"; //From Name -- CHANGE --
$mail->AddAddress("$OwnerEmail", $OwnerName2); //To Address -- CHANGE - 
//if($dbEmail2){echo $mail->addCc($dbEmail2,'Activation Link from UNCST');}
$mail->AddReplyTo("$emailBcc", "Grants Management Office"); //Reply-To Address -- CHANGE --$usrm_email


$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grant Notification- $public_title";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}///end	
	

echo "
<script type=\"text/javascript\">
        alert('Successfully updated...');
        window.close();
</script>";


}//end post

?>


<form action="" name="regForm" id="regForm" method="post" enctype="multipart/form-data" autocomplete="off">

                          
                       
                         <div class="form-group row success">



							<input name="awarded" type="radio" value="no" class="required" onChange="getAwardGranted(this.value)"> &nbsp;No &nbsp;&nbsp;<input name="awarded" type="radio" value="yes-<?php echo $id;?>" class="required" onChange="getAwardGranted(this.value)"> Yes
                    
                            
                            <input type="hidden" name="asrmApplctID" value="<?php echo $_SESSION['usrm_id'];?>">
                            <input type="hidden" name="submission_id" value="<?php echo $id;?>">
                           
                         
                       
                        
                        </div>
                        
                                         
                        <div class="line"></div>
                        
                       <div class="form-group rowm">
                          <div id="awardgrantdiv"></div>
                          
                        </div>
                       
         
                       
                        
                        <div class="form-group row">
                          <div class="col-sm-4 offset-sm-3">
                    <input name="doSaveAward" type="submit"  class="btn btn-primary" value="Confirm" onclick="return confirm('Are you sure you want to proceed?');"
/>

                          </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
   
   </form>   
                        
                        
           
              
                
                
             
                </div>
                <!-- row area end -->
       
                <!-- row area start-->
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright 2020 - <?php echo $year;?>. All right reserved. Grants Management System.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
      
    <!-- offset area end -->
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
    

</body>

</html>
