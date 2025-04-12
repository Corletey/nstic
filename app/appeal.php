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
                   
 <div class="success">Reasons for Halting this study</div>             
      <?php
$act=$_GET['act'];
$owner_id=$_GET['owner_id'];
$sessionLoggedin=$_SESSION['usrm_id'];
//doSaveFive

//doSaveFive
if($_POST['doSaveHalting'] and $id and $_POST['appealReason'] and $sessionLoggedin){

	$reason=$mysqli->real_escape_string($_POST['reason']);
	$type_of_review=$mysqli->real_escape_string($_POST['type_of_review']);
	$appealReason=$mysqli->real_escape_string($_POST['appealReason']);
	$appealHalting=$mysqli->real_escape_string($_POST['appealReason']);


$sqlFLists1="SELECT *,DATE_FORMAT(`updatedon`,'%d/%m/%Y %H:%s:%i') AS updatedonm FROM ".$prefix."submissions_proposals where projectID='$id' order by projectID desc";
$QueryFListsm1=$mysqli->query($sqlFLists1);
$rFLists2=$QueryFListsm1->fetch_array(); 
$conceptm_id=$rFLists2['projectID']; 
$public_title=$rFLists2['projectTitle'];


	
	///Which admin has reviewed this protocol
$sqlSReviewer = "select * from ".$prefix."musers where usrm_id='$sessionLoggedin'";
$resReviewer = $mysqli->query($sqlSReviewer);
$sqReviewer = $resReviewer->fetch_array();
$OwnerName=$sqReviewer['usrm_fname'].' '.$sqReviewer['usrm_sname'];
echo $OwnerEmail=$sqReviewer['usrm_email'];

$sqlChceckMembersNew2ee="update ".$prefix."appeal_halted_studies set appealReason='$appealReason',appealDate=now(),appealSubmitted='Yes' where projectID='$id' and owner_id='$sessionLoggedin' and id='$act'";
$mysqli->query($sqlChceckMembersNew2ee);//status='notallowedaccess'

$sqlChceckMembersNew2="update ".$prefix."submission set appeals='Yes', appealHalting='$appealReason' where  projectID='$id'";
$mysqli->query($sqlChceckMembersNew2);//status='notallowedaccess'
logaction("$session_fullname has made an appeal on halted study for $public_title");

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 
$adminEmail="$emailBcc";
if($adminEmail){///Grants Office
	

require_once("viewlrcn/mail_template_halting_submission_appeal.php");
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
/////////////////////////////Begin Mail Body
$mail->addCc("$emailBcc",$OwnerName);
//$mail->addBcc("uncstuganda@gmail.com",$OwnerName);//$mail->addBcc($reviewerEmail,$ReviewerName);

$mail->FromName = $OwnerName; //From Name -- CHANGE --
$mail->AddAddress($OwnerEmail, $OwnerName); //To Address -- CHANGE --$recemail
//if($dbEmail2){echo $mail->addCc($dbEmail2,'Activation Link from UNCST');}
$mail->AddReplyTo($OwnerEmail, $OwnerName); //Reply-To Address -- CHANGE --$usrm_email

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Appeal for Halted Study - $public_title";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}///end	
}//end REC

if($OwnerEmail){

require_once("viewlrcn/mail_template_halting_submission_appeal2.php");
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
/////////////////////////////Begin Mail Body
//$mail->addCc("mawandammoses@gmail.com",$OwnerName);
//$mail->addBcc("",$OwnerName);//$mail->addBcc($reviewerEmail,$ReviewerName);

$mail->FromName = $OwnerName; //From Name -- CHANGE --
$mail->AddAddress("$emailBcc", $OwnerName); //To Address -- CHANGE --$recemail 
//if($dbEmail2){echo $mail->addCc($dbEmail2,'Activation Link from UNCST');}
$mail->AddReplyTo($OwnerEmail, $OwnerName); //Reply-To Address -- CHANGE --$usrm_email

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Appeal for Halted Study - $public_title";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}///end	
}//end Owner

echo "
<script type=\"text/javascript\">
        alert('Infomation has been updated, please wait..');
        window.close();
</script>";


}//end post



$sqlstudym2="SELECT * FROM ".$prefix."appeal_halted_studies where projectID='$id' and id='$act'";
$Querystudym2 = $mysqli->query($sqlstudym2);
$rstudym2 = $Querystudym2->fetch_array();
$totalStudiesHalted = $Querystudym2->num_rows;
?>


<form action="" name="regForm" id="regForm" method="post" enctype="multipart/form-data" autocomplete="off">

                       <div class="form-group row success">
                          <label class="col-sm-7 form-control-label">Reasons for Halting: <span class="error">*</span></label>
                          <textarea name="bbb" id="mawanda1hh" cols="" rows="5" class="form-control  required" readonly><?php echo $rstudym2['reasonsforhalting'];?></textarea>
                        </div>
                        
                        
                         <div class="form-group row success">
                          <label class="col-sm-7 form-control-label">Provide reasons: <span class="error">*</span></label>
                          <textarea name="appealReason" id="mawanda1hh" cols="" rows="5" class="form-control  required"><?php if($rstudym2['appealReason']){echo $rstudym2['appealReason'];}else{$_POST['appealReason'];}?></textarea>
                        </div>
                             
                       
                         <div class="form-group row">

                    
                            
                            <input type="hidden" name="asrmApplctID" value="<?php echo $owner_id;?>">
                            <input type="hidden" name="submission_id" value="<?php echo $rstudym['id'];?>">
                            <input type="hidden" name="public_title" value="<?php echo $rstudym['public_title'];?>">
                         <input type="hidden" name="oldtype_of_review" value="<?php echo $rstudym['type_of_review'];?>">
                       
                        
                        </div>
                        
                        
                        <div class="form-group row">

 <div id="conflictdiv"></div>  
                       
                        
                        </div>
                        
                        <div class="line"></div>
                        
                         <?php /*?> <div class="form-group row">
                          <label class="col-sm-4 form-control-label">Prior Ethical Approval:</label>

                          <input name="prior_ethical_approval" type="radio" value="1" class="required"  onChange="getState(this.value)"/> Yes &nbsp;<input name="prior_ethical_approval" type="radio" value="0" class="required" onChange="getState(this.value)"/> No
  
                          
                          
                        </div>
                        <div id="statediv"></div><?php */?>
         
                       
                        
                        <div class="form-group row">
                          <div class="col-sm-4 offset-sm-3">
                    <input name="doSaveHalting" type="submit"  class="btn btn-primary" value="Submit"/>

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
