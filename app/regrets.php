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
               
   <div class="success" style="font-size:18px;">Regret Comments</div>             
      <?php
$categorym=$_GET['categorym'];

$assignm_id=$_GET['assignm_id'];
//doSaveFive
// and $assignm_id and $id and $_POST['AmountofGrantawarded'] and $_POST['projectDurationID']
if($_POST['doSaveRegrets']){


    $owner_idmm=$_GET['owner_id'];
      
    $wmuser="select * from ".$prefix."musers where  usrm_id='$owner_idmm'";
    $cmdwbser = $mysqli->query($wmuser);
    $rcmdwbser= $cmdwbser->fetch_array();
    $OwnerName2=$rcmdwbser['usrm_sname'].' '.$rcmdwbser['usrm_fname'];
    $OwnerEmail2=$rcmdwbser['usrm_email'];
    
    
    $wmproject="select * from ".$prefix."submissions_proposals where  owner_id='$owner_idmm' and projectID='$id' order by projectID desc";
    $cmdwbproject = $mysqli->query($wmproject);
    $SubmittedProject=$cmdwbproject->num_rows;
    $rproject= $cmdwbproject->fetch_array();
    $public_title=$rproject['projectTitle'];
    $referenceNo=$rproject['referenceNo'];


    $reviewer_id=$mysqli->real_escape_string($_POST['asrmApplctID']);
    $regretcomments=$mysqli->real_escape_string($_POST['regretcomments']);

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 	

require_once("viewlrcn/mail_template_send_regrets.php");
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
      //$mail->addCc("$emailBcc",'Grants Management Office');

      
      $mail->FromName = "Grants Management Office"; //From Name -- CHANGE --
      $mail->AddAddress($OwnerEmail2, $OwnerName2); //To Address -- CHANGE --$OwnerEmail 
      //if($dbEmail2){echo $mail->addCc($dbEmail2,'Activation Link from UNCST');}
      $mail->AddReplyTo("$emailBcc", "Grants Management Office"); //Reply-To Address -- CHANGE --$usrm_email
      //////////////
      
      $mail->WordWrap = 50; // set word wrap to 50 characters
      $mail->IsHTML(false); // set email format to HTML
      $mail->Subject = "Regrets - $public_title";
    $body="$allSentMessage
      ";
      $mail->MsgHTML($body);
      
    if(!$mail->Send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
      }///end	
	
//notified
$wmprojectUpdate="update ".$prefix."submissions_proposals set notified='Yes' where  owner_id='$owner_idmm' and projectID='$id'";
$mysqli->query($wmprojectUpdate);

echo "
<script type=\"text/javascript\">
        alert('Successfully updated...');
        window.close();
</script>";


}//end post
////Dont award this Grant. Condition ="yes"
?>


<form action="" name="regForm" id="regForm" method="post" enctype="multipart/form-data" autocomplete="off">

                          
                       
                         <div class="form-group row success">



							<input name="awarded" type="radio" value="No" class="required" onChange="getRegretComments(this.value)"> &nbsp;No &nbsp;&nbsp;<input name="awarded" type="radio" value="Yes" class="required" onChange="getRegretComments(this.value)"> Yes
                    
                            
                            <input type="hidden" name="asrmApplctID" value="<?php echo $_SESSION['usrm_id'];?>">
                            <input type="hidden" name="submission_id" value="<?php echo $id;?>">
                           
                         
                       
                        
                        </div>
                        
                                         
                        <div class="line"></div>
                        
                       <div class="form-group rowm">
                          <div id="regretsdiv"></div>
                          
                        </div>
                       
         
                       
                        
                        <div class="form-group row">
                          <div class="col-sm-4 offset-sm-3">
                    <input name="doSaveRegrets" type="submit"  class="btn btn-primary" value="Confirm"/>

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
