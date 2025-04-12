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
                   
<div class="success">Accept Terms and Conditions in order to proceed and Request for Funds.</div>             
      <?php
	$projectID=base64_decode($id);
	$owner_id=$_GET['owner_id'];
	
if($_POST['doAcceptTerms'] and $owner_id and $projectID){
$TermsandConditions=$mysqli->real_escape_string($_POST['TermsandConditions']);
$public_title=$mysqli->real_escape_string($_POST['public_title']);
$rejectGrantComment=$mysqli->real_escape_string($_POST['rejectGrantComment']);

///Send Mail to Admin
	///Which admin has reviewed this protocol
$sqlSOwner2 = "select * from ".$prefix."musers where usrm_id='$owner_id'";
$resOwner2 = $mysqli->query($sqlSOwner2);
$sqOwner2 = $resOwner2->fetch_array();
$OwnerName2=$sqOwner2['usrm_fname'].' '.$sqOwner2['usrm_sname'];
$OwnerEmail=$sqOwner2['usrm_email'];

	$signedagreement = preg_replace('/\s+/', '_', $_FILES['signedagreement']['name']);
$signedagreement2 = $owner_id.'signedgrant'.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['signedagreement']['name']));
$targetw1 = "files/". basename($owner_id.'signedgrant'.preg_replace('/\s+/', '_', $_FILES['signedagreement']['name']));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['signedagreement']['tmp_name']), $targetw1);
//////////////update
if($_FILES['signedagreement']['name']){
$sqlA2ProtocolaSS="update ".$prefix."submissions_proposals set TermsConditions='$TermsandConditions',signedagreement='$signedagreement2',`grantrejectcomment`='$rejectGrantComment' where projectID='$projectID' and owner_id='$owner_id'";
$mysqli->query($sqlA2ProtocolaSS);

///Send Mail to Admin

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 	

require_once("viewlrcn/mail_accept_terms_conditions.php");
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
$mail->AddAddress($OwnerEmail, $OwnerName2); //To Address -- CHANGE --$email
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
        alert('Terms and Conditions have been accepted, click to proceed..');
        window.close();
</script>";
}

}//end post

///Reject Grant Offers

if($_POST['doRejectGrant'] and $owner_id and $projectID){
    $TermsandConditions=$mysqli->real_escape_string($_POST['TermsandConditions']);
    $public_title=$mysqli->real_escape_string($_POST['public_title']);
   $rejectGrantComment=$mysqli->real_escape_string($_POST['rejectGrantComment']);

    ///Send Mail to Admin
        ///Which admin has reviewed this protocol
    $sqlSOwner2 = "select * from ".$prefix."musers where usrm_id='$owner_id'";
    $resOwner2 = $mysqli->query($sqlSOwner2);
    $sqOwner2 = $resOwner2->fetch_array();
    $OwnerName2=$sqOwner2['usrm_fname'].' '.$sqOwner2['usrm_sname'];
    $OwnerEmail=$sqOwner2['usrm_email'];
    
    
   $sqlA2ProtocolaSS="update ".$prefix."submissions_proposals set TermsConditions='$TermsandConditions',`grantrejectcomment`='$rejectGrantComment' where projectID='$projectID' and owner_id='$owner_id'";
    $mysqli->query($sqlA2ProtocolaSS);
    
    ///Send Mail to Admin
    
    require("viewlrcn/class.phpmailer.php");
    require("viewlrcn/class.smtp.php"); 	
    
    require_once("viewlrcn/mail_accept_terms_conditions_reject.php");
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
    $mail->AddAddress($OwnerEmail, $OwnerName2); //To Address -- CHANGE --$email
    //if($dbEmail2){echo $mail->addCc($dbEmail2,'Activation Link from UNCST');}
    $mail->AddReplyTo("$emailBcc", "Grants Management Office"); //Reply-To Address -- CHANGE --$usrm_email
    
    
    $mail->WordWrap = 50; // set word wrap to 50 characters
    $mail->IsHTML(false); // set email format to HTML
    $mail->Subject = "Reject Grant - $public_title";
    $body="$allSentMessage
    ";
    $mail->MsgHTML($body);
    
    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
    }///end	
        
    
    
    echo "
    <script type=\"text/javascript\">
            alert('Terms and Conditions have been accepted, click to proceed..');
            window.close();
    </script>";

    
    }//end post
    

$sql = "select * FROM ".$prefix."submissions_proposals where projectID='$projectID' order by projectID desc limit 0,10";
$result = $mysqli->query($sql);
$rFLists2=$result->fetch_array();
$conceptm_id=$rFLists2['projectID']; 
$public_title=$rFLists2['projectTitle']; 
?>


<form action="" name="regForm" id="regForm" method="post" enctype="multipart/form-data" autocomplete="off">

                          <div class="form-group row" style="height:350px; overflow:scroll; margin-left:10px;">
                          <h3 style="width:100%;">Welcome to Grants Management System Terms and Conditions!</h3>

Dear <?php echo $session_fullname;?>,<br><br>

We are pleased to inform you that on <?php echo $rFLists2['BeginProject'];?>, the <?php echo $mysqli->real_escape_string($rowsWT['name_granting_council']);?>	Grants Management Office approved your proposal titled, <b><?php echo $rFLists2['projectTitle'];?></b>The Approval is valid for the period of <?php echo $rFLists2['BeginProject'];?> to <?php echo $rFLists2['EndProject'];?>.<br><br>

Amount of Grant awarded: <?php echo numberformat($rFLists2['AmountofGrantawarded']);?> <?php echo $rFLists2['currency'];?><br>
Duration of Grant: <?php echo $rFLists2['DurationofGrant'];?><br><br>

<span class="error"><b>Please download the Grants agreement here attached and append a date, initials/Signature on each page to accept terms and conditions of the grant. Pelase attached the signed copy below.</b></span><br><br>
<a href="./files/<?php echo $rFLists2['award_agreement'];?>" target="_blank">Click to download Grant Agreement</a>
</div>
                       
                         <div class="form-group row success">



 Accept Terms and Conditions <input name="TermsandConditions" type="radio" value="Yes" required onChange="getAwardGrantedAccept(this.value)"> Yes <input name="TermsandConditions" type="radio" value="No" required onChange="getAwardGrantedAccept(this.value)"> No
                    
                            
                            <input type="hidden" name="asrmApplctID" value="<?php echo $_SESSION['usrm_id'];?>">
                            <input type="hidden" name="submission_id" value="<?php echo $id;?>">
                            <input type="hidden" name="public_title" value="<?php echo $public_title;?>">
                         
                       <div id="awardgrantacceptdiv"></div>
                        
                        </div>
                                     
               
         
                       
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
                        
   
   </form>
   
</div>
 
                        
                        
           
              
                
                
             
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
