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
                   
<div class="success" style="text-align:center;">VIVA SCORE / 100%</div>             
     
     
     <?php 
	 $EvaluatedBy=($id);
$ds=$mysqli->real_escape_string($_GET['ds']);                                                
$sqlScoreReview="SELECT * FROM ".$prefix."mscores_dynamic where scoredmID='$ds'";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
$rScoreReview = $QueryScoreReview->fetch_array();
$mconceptm_id=$rScoreReview['conceptm_id'];


if($_POST['doViVAScore']=='Submit'){
$vvscore=$mysqli->real_escape_string($_POST['vvscore']);
$vvcomment=$mysqli->real_escape_string($_POST['vvcomment']);
$mconceptm_id=$mysqli->real_escape_string($_POST['mconceptm_id']);
if($vvscore<=100){
$query="update ".$prefix."mscores_dynamic  set `EVivaScore`='$vvscore',`EvVivaComments`='$vvcomment' where scoredmID='$ds'";//scoredmID='$ds'
$mysqli->query($query);


$message="<p style='color:#09F!important;'>Score has been added</p>";
echo "
<script type=\"text/javascript\">
        alert('VIVA Score has been updated..');
        window.close();
</script>";

}else{
$message="<p style='color:#F00!important;'>VIVA Score cannot go beyond limit of 100</p>";
	
}
}

	?>
    <form action="" method="post"  enctype="multipart/form-data" name="regForm" id="regForm" >
    <div style="width:600px; margin:0 auto; padding-top:10px;" class="success">
    <h3>Add Viva Score</h3><hr>
    <?php echo $message;?>
   <p> <?php echo $rsContribution2['proposalmTittle'];?></p>
    
    <p><strong>Viva Score</strong></p>
<input name="vvscore" type="text" style=" width:100%; height:25px; clear:both; margin-bottom:30px;" class="required number" id="vvscore" value="<?php echo $rScoreReview['EVivaScore'];?>"/>

<input name="mconceptm_id" type="hidden" id="vvscorse" value="<?php echo $mconceptm_id;?>"/>
<p><strong>Add Comment below</strong></p>
<textarea name="vvcomment" cols="" rows="" style=" width:100%; height:250px; clear:both; margin-bottom:30px;" class="required" id="vvcomment"><?php echo $rScoreReview['EvVivaComments'];?></textarea>

<input name="doViVAScore" type="submit" value="Submit" class="btn btn-info btn-flat" style="float:right;"/>
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
