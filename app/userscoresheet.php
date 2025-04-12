<?php
session_start();
require_once('contrlrcn/c_mlsrcontrol.php'); 
timeout($timeout);
?><!DOCTYPE html>
<html>
  <head>
  <base href="<?php echo $base_url;?>" />
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title><?php echo $sitename;?></title>
    <link rel="shortcut icon" href="img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="pages/ico/60.png">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />

    <link href="assets/plugins/mapplic/css/mapplic.css" rel="stylesheet" type="text/css" />
 
    <link href="pages/css/pages-icons.css" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="pages/css/pages.css" rel="stylesheet" type="text/css" />
    

    

  <script language="JavaScript" type="text/javascript" src="js/ajax_populate.js"></script>
  <script language="javascript" type="text/javascript">

function popitup(url) {
newwindow=window.open(url,'name','height=680,width=650');
if (window.focus) {newwindow.focus()}
return false;
}


</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <!--[if lte IE 9]>
	<link href="assets/plugins/codrops-dialogFx/dialog.ie.css" rel="stylesheet" type="text/css" media="screen" />
	<![endif]-->
  </head>
  <body class="fixed-header dashboard">
    <!-- BEGIN SIDEBPANEL-->
    <nav class="page-sidebar" data-pages="sidebar">
      <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
      <div class="sidebar-overlay-slide from-top" id="appMenu">
        <div class="row">
          <div class="col-xs-6 no-padding">
            <a href="#" class="p-l-40"><img src="assets/img/demo/social_app.svg" alt="socail">
            </a>
          </div>
          <div class="col-xs-6 no-padding">
            <a href="#" class="p-l-10"><img src="assets/img/demo/email_app.svg" alt="socail">
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 m-t-20 no-padding">
            <a href="#" class="p-l-40"><img src="assets/img/demo/calendar_app.svg" alt="socail">
            </a>
          </div>
          <div class="col-xs-6 m-t-20 no-padding">
            <a href="#" class="p-l-10"><img src="assets/img/demo/add_more.svg" alt="socail">
            </a>
          </div>
        </div>
      </div>
      <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header">
Grants   
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- START SIDEBAR MENU -->
      
      
      <div class="sidebar-menu">
        <!-- BEGIN SIDEBAR MENU ITEMS-->
        <ul class="menu-items">
        
        
        
        
          <li class="m-t-30 ">
            <a href="./data/dashboard" class="detailed">
              <span class="title">Dashboard</span>
            </a>
            <span class="bg-success icon-thumbnail"><i class="pg-home"></i></span>
          </li>
          
          <?php include("viewlrcn/listm_left_menu.php");?>
          <?php
		  //$auth_type=$this->session->userdata('auth_type');
		  //if($auth_type=='superadimin'){//Begin Security?>
         
       
        </ul>
        <div class="clearfix"></div>
      </div>
      <!-- END SIDEBAR MENU -->
    </nav>
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL-->
    <!-- START PAGE-CONTAINER -->
    <div class="page-container ">
      <!-- START HEADER -->
      <div class="header ">
        <!-- START MOBILE CONTROLS -->
        <div class="container-fluid relative">
          <!-- LEFT SIDE -->
          <div class="pull-left full-height visible-sm visible-xs">
            <!-- START ACTION BAR -->
            <div class="header-inner">
              <a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar">
                <span class="icon-set menu-hambuger"></span>
              </a>
            </div>
            <!-- END ACTION BAR -->
          </div>
          <div class="pull-center hidden-md hidden-lg">
            <div class="header-inner">
              <div class="brand inline" style="background:#ffffff;">
                <img src="assets/img/logosmall.png" alt="logo" data-src="assets/img/logosmall.png" data-src-retina="assets/img/logosmall.png" width="140" height="60">
              </div>
            </div>
          </div>
          <!-- RIGHT SIDE -->
          <div class="pull-right full-height visible-sm visible-xs">
            <!-- START ACTION BAR -->
            <div class="header-inner">
              <a href="#" class="btn-link visible-sm-inline-block visible-xs-inline-block" data-toggle="quickview" data-toggle-element="#quickview">
                <span class="icon-set menu-hambuger-plus"></span>
              </a>
            </div>
            <!-- END ACTION BAR -->
          </div>
        </div>
        <!-- END MOBILE CONTROLS -->
        <div class=" pull-left sm-table hidden-xs hidden-sm">
          <div class="header-inner">
            <div class="brand inline">
              <img src="assets/img/logosmall.png" alt="logo" data-src="assets/img/logosmall.png" data-src-retina="assets/img/logosmall.png" width="140" height="60">
            </div>
            <!-- START NOTIFICATION LIST -->
            <ul class="notification-list no-margin hidden-sm hidden-xs b-grey b-l b-r no-style p-l-30 p-r-20">
              <li class="p-r-15 inline">
                <div class="dropdown">
                  <a href="./data/MyAccount/" id="notification-center" class="icon-set globe-fill" data-toggle="dropdown">
                    <span class="bubble"></span>
                  </a>
            
                </div>
              </li>
              <li class="p-r-15 inline">
                <a href="./data/MyAccount/" class="icon-set clip "></a>
              </li>
              <li class="p-r-15 inline">
                <a href="./data/MyAccount/" class="icon-set grid-box"></a>
              </li>
            </ul>
          </div>
        </div>
        <div class=" pull-right">
          <div class="header-inner">
            <a href="./data/MyAccount/" class="btn-link icon-set menu-hambuger-plus m-l-20 sm-no-margin hidden-sm hidden-xs" data-toggle="quickview" data-toggle-element="#quickview"></a>
          </div>
        </div>
        <div class=" pull-right">
          <!-- START User Info-->
          <div class="visible-lg visible-md m-t-10">
            <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
              <span class="semi-bold"><a href="./data/MyAccount/"><?php echo $_SESSION['usrm_username'];?>,</a></span> <span class="text-master"><a href="signout.php">Logout <i class="fs-13 pg-power"></i></a></span>
            </div>
            <div class="dropdown pull-right">
              <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="thumbnail-wrapper d32 circular inline m-t-5">
                <?php photo();?>
            </span>
              </button>
              <ul class="dropdown-menu profile-dropdown" role="menu">
                <li><a href="./data/MyAccount/"><i class="pg-settings_small"></i> MyAccount</a>
                </li>
               
                <li class="bg-master-lighter">
                  <a href="signout.php" class="clearfix">
                    <span class="pull-left">Logout</span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <!-- END User Info-->
        </div>
      </div>
      <!-- END HEADER -->
      
        <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper ">
        <!-- START PAGE CONTENT -->
        <div class="content sm-gutter">
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid padding-25 sm-padding-10">
            <!-- START ROW -->
     
               
                
  <?php
$EvaluatedBy=base64_decode($id);
$ds=$mysqli->real_escape_string(base64_decode($id));
?>
<?php 
$categorym=$_GET['categorym'];                                                 
 $sqlScoreReview22="SELECT * FROM ".$prefix."mscores_new where conceptm_id='$ds'";
$QueryScoreReview22=$mysqli->query($sqlScoreReview22);
$count=0;
while($rScoreReview22 = $QueryScoreReview22->fetch_array()){
$count++;
$conceptm_id=$rScoreReview22['conceptm_id'];
$EvaluatedBy=$rScoreReview22['EvaluatedBy'];
$scoredmID=$rScoreReview22['scoredmID'];

$sqlScoreReview="SELECT * FROM ".$prefix."mscores_new where conceptm_id='$conceptm_id' and EvaluatedBy='$EvaluatedBy' and scoredmID='$scoredmID' and categorym='$categorym'";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
$rScoreReview = $QueryScoreReview->fetch_array();
	/*$evaluatedBy=$rScoreReview['EvaluatedBy'];
	//now get this reviewer
$sqlReviewer="SELECT * FROM ".$prefix."musers where usrm_id='$evaluatedBy'";
$QueryReviewer=$mysqli->query($sqlReviewer);
$rReviewer = $QueryReviewer->fetch_array();*/
	$totalScore=($rScoreReview['STQnewMethods']+$rScoreReview['STQhighQuality']+$rScoreReview['STQSatisfactoryPartnership']+$rScoreReview['AppAddressIssues']+$rScoreReview['ImpactClearlyConvincingly']+$rScoreReview['ImpactGenderIssues']+$rScoreReview['Potential']+$rScoreReview['Budget']);
	?>
    <div style="width:100%; margin:0 auto; padding-top:30px;">

<div class="success">Reviewer <?php echo $count;?></div>

 <b>1. Scientific quality and innovation of the joint research proposal (30%).</b> <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['STQnewMethods'];?></b></p>

<p><b>2. Feasibility  of the joint research proposal (Practicality, feasibility and consistency of proposed activities with the objectives  of the call, and feasibility of the methodology provided) (15%) </b><b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['STQhighQuality'];?></b></p>

<p><b>3. Added value  to expect  from  collaboration Technological  capacity  building (15%).</b> <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['STQSatisfactoryPartnership'];?>%</b></p>



<p><b>4. Competence, expertise and experience of principal investigators and relevant  scientists  / research  teams (5%)</b> <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['AppAddressIssues'];?>%</b></p>

<p><b>5. Clarity of expected results (15%).</b> <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['ImpactClearlyConvincingly'];?>%</b></p>


<p><b>6. Relevance and impact of  research (Industrial Development, Technological Capacity Building, Marketing of Research Results, Agricultural Production,   Improved Health Outcomes, Economic  Growth  Improved  Livelihoods) (10%)</b> <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['ImpactGenderIssues'];?>%</b>
</p>

<p><b>Potential to promote equity and ethics (5%)</b> <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['Potential'];?>%</b>
</p>

<p><b>7. Budget (Consistency  with  the  budget  ratio  or  percentage  provided  by  the  appeal guide, Basis of  estimates - How  well the  proposed  expenses  reflect the actual  cost of the  proposed action?) (5%)</b> <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['Budget'];?>%</b>
</p>

<p><b>Overall Comment</b> <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['EvoverallComment'];?></b>
</p>

<p><b>Total: <span style="color:#00A65A; font-weight:bold;"><?php echo $totalScore;?>%</span></b></p>
</div>
<?php }

$queryCategoryReviewFa="select * from ".$prefix."mscores_new where conceptm_id='$ds' and EVivaScore>1 order by scoredmID desc";
$R_CategoryReviewFa=$mysqli->query($queryCategoryReviewFa);	
$rCReviewFa=$R_CategoryReviewFa->fetch_array();
?>

<div class="success">
<p><b>VIVA SCORE: <span style="color:#00A65A; font-weight:bold; font-size:18px;"><?php echo $rCReviewFa['EVivaScore'];?>%</span></b><br>
 <b>TOTAL SCORE: <span style="color:#F00; font-weight:bold;font-size:18px;"><?php echo round($rCReviewFa['EvgeneralTotal'],1);?>%</span></b>
</p>


</div>

 </div>
            <!-- END ROW -->
         
           
         
         
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg footer">
          <div class="copyright sm-text-center">
            <p class="small no-margin pull-left sm-pull-reset">
            
            <div style="clear:both;"></div>
            
              <?php /*?><span class="hint-text">Copyright &copy; <?php echo date("Y");?> </span>
              <span class="font-montserrat">AgroWays (U) Ltd</span>.
              <span class="hint-text">All rights reserved. </span>
              <span class="sm-block"><a href="./dashboard" class="m-l-10 m-r-10">Terms of use</a> | <a href="./dashboard" class="m-l-10">Privacy Policy</a></span><?php */?>
            </p>
           <!-- <p class="small no-margin pull-right sm-pull-reset">
              <a href="./dashboard">SCM - </a> <span class="hint-text">&amp; Supply Chain Management System</span>
            </p>-->
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- END COPYRIGHT -->
      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
    
    
    <!--START QUICKVIEW -->
    <div id="quickview" class="quickview-wrapper" data-pages="quickview">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs">
        <li class="">
          <a href="#quickview-notes" data-toggle="tab">Notes</a>
        </li>
        <li>
          <a href="#quickview-alerts" data-toggle="tab">Alerts</a>
        </li>
        <li class="active">
          <a href="#quickview-chat" data-toggle="tab">Chat</a>
        </li>
      </ul>
      <a class="btn-link quickview-toggle" data-toggle-element="#quickview" data-toggle="quickview"><i class="pg-close"></i></a>
      <!-- Tab panes -->
      <div class="tab-content">
        <!-- BEGIN Notes !-->
        <div class="tab-pane fade  in no-padding" id="quickview-notes">
          <div class="view-port clearfix quickview-notes" id="note-views">
            <!-- BEGIN Note List !-->
            <div class="view list" id="quick-note-list">
              <div class="toolbar clearfix">
                <ul class="pull-right ">
                  <li>
                    <a href="#" class="delete-note-link"><i class="fa fa-trash-o"></i></a>
                  </li>
                  <li>
                    <a href="#" class="new-note-link" data-navigate="view" data-view-port="#note-views" data-view-animation="push"><i class="fa fa-plus"></i></a>
                  </li>
                </ul>
                <button class="btn-remove-notes btn btn-xs btn-block hide"><i class="fa fa-times"></i> Delete</button>
              </div>
              <ul>
                <!-- BEGIN Note Item !-->
                <li data-noteid="1">
                  <div class="left">
                    <!-- BEGIN Note Action !-->
                    <div class="checkbox check-warning no-margin">
                      <input id="qncheckbox1" type="checkbox" value="1">
                      <label for="qncheckbox1"></label>
                    </div>
                    <!-- END Note Action !-->
                    <!-- BEGIN Note Preview Text !-->
                    <p class="note-preview">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <!-- BEGIN Note Preview Text !-->
                  </div>
                  <!-- BEGIN Note Details !-->
                  <div class="right pull-right">
                    <!-- BEGIN Note Date !-->
                    <span class="date">12/12/14</span>
                    <a href="#" data-navigate="view" data-view-port="#note-views" data-view-animation="push"><i class="fa fa-chevron-right"></i></a>
                    <!-- END Note Date !-->
                  </div>
                  <!-- END Note Details !-->
                </li>
                <!-- END Note List !-->
             
              </ul>
            </div>
            <!-- END Note List !-->
            <div class="view note" id="quick-note">
              <div>
                <ul class="toolbar">
                  <li><a href="#" class="close-note-link"><i class="pg-arrow_left"></i></a>
                  </li>
                  <li><a href="#" data-action="Bold"><i class="fa fa-bold"></i></a>
                  </li>
                  <li><a href="#" data-action="Italic"><i class="fa fa-italic"></i></a>
                  </li>
                  <li><a href="#" class=""><i class="fa fa-link"></i></a>
                  </li>
                </ul>
                <div class="body">
                  <div>
                    <div class="top">
                      <span>21st april 2014 2:13am</span>
                    </div>
                    <div class="content">
                      <div class="quick-note-editor full-width full-height js-input" contenteditable="true"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END Notes !-->
        <!-- BEGIN Alerts !-->
        <div class="tab-pane fade no-padding" id="quickview-alerts">
          <div class="view-port clearfix" id="alerts">
            <!-- BEGIN Alerts View !-->
            <div class="view bg-white">
              <!-- BEGIN View Header !-->
              <div class="navbar navbar-default navbar-sm">
                <div class="navbar-inner">
                  <!-- BEGIN Header Controler !-->
                  <a href="javascript:;" class="inline action p-l-10 link text-master" data-navigate="view" data-view-port="#chat" data-view-animation="push-parrallax">
                    <i class="pg-more"></i>
                  </a>
                  <!-- END Header Controler !-->
                  <div class="view-heading">
                    Notications
                  </div>
                  <!-- BEGIN Header Controler !-->
                  <a href="#" class="inline action p-r-10 pull-right link text-master">
                    <i class="pg-search"></i>
                  </a>
                  <!-- END Header Controler !-->
                </div>
              </div>
              <!-- END View Header !-->
              <!-- BEGIN Alert List !-->
  
            </div>
            <!-- EEND Alerts View !-->
          </div>
        </div>
        <!-- END Alerts !-->
        <div class="tab-pane fade in active no-padding" id="quickview-chat">
          <div class="view-port clearfix" id="chat">
            <div class="view bg-white">
              <!-- BEGIN View Header !-->
              <div class="navbar navbar-default">
                <div class="navbar-inner">
                  <!-- BEGIN Header Controler !-->
                  <a href="javascript:;" class="inline action p-l-10 link text-master" data-navigate="view" data-view-port="#chat" data-view-animation="push-parrallax">
                    <i class="pg-plus"></i>
                  </a>
                  <!-- END Header Controler !-->
                  <div class="view-heading">
                    Chat List
                    <div class="fs-11">Show All</div>
                  </div>
                  <!-- BEGIN Header Controler !-->
                  <a href="#" class="inline action p-r-10 pull-right link text-master">
                    <i class="pg-more"></i>
                  </a>
                  <!-- END Header Controler !-->
                </div>
              </div>
              <!-- END View Header !-->
              <div data-init-list-view="ioslist" class="list-view boreded no-top-border">
                <div class="list-view-group-container">
                  <div class="list-view-group-header text-uppercase">
                    a</div>
                  <ul>
                 
                    <!-- END Chat User List Item  !-->
                  </ul>
                </div>
             
         

              </div>
            </div>
            <!-- BEGIN Conversation View  !-->
            <div class="view chat-view bg-white clearfix">
              <!-- BEGIN Header  !-->
              <div class="navbar navbar-default">
                <div class="navbar-inner">
                  <a href="javascript:;" class="link text-master inline action p-l-10 p-r-10" data-navigate="view" data-view-port="#chat" data-view-animation="push-parrallax">
                    <i class="pg-arrow_left"></i>
                  </a>
                  
                  <a href="#" class="link text-master inline action p-r-10 pull-right ">
                    <i class="pg-more"></i>
                  </a>
                </div>
              </div>
              <!-- END Header  !-->
              <!-- BEGIN Conversation  !-->
              <div class="chat-inner" id="my-conversation">
                <!-- BEGIN From Me Message  !-->
                <div class="message clearfix">
                  <div class="chat-bubble from-me">
                    
                  </div>
                </div>
                <!-- END From Me Message  !-->
                <!-- BEGIN From Them Message  !-->
                <div class="message clearfix">
                  <div class="profile-img-wrapper m-t-5 inline">
                    <img class="col-top" width="30" height="30" src="assets/img/profiles/avatar_small.jpg" alt="" data-src="assets/img/profiles/avatar_small.jpg" data-src-retina="assets/img/profiles/avatar_small2x.jpg">
                  </div>
                  <div class="chat-bubble from-them">
                    Hey
                  </div>
                </div>
                <!-- END From Them Message  !-->
                <!-- BEGIN From Me Message  !-->
                <div class="message clearfix">
                  <div class="chat-bubble from-me">
                    Did you check out Pages framework ?
                  </div>
                </div>
                <!-- END From Me Message  !-->
                <!-- BEGIN From Me Message  !-->
                <div class="message clearfix">
                  <div class="chat-bubble from-me">
                    Its an awesome chat
                  </div>
                </div>
                <!-- END From Me Message  !-->
                <!-- BEGIN From Them Message  !-->
                <div class="message clearfix">
                  <div class="profile-img-wrapper m-t-5 inline">
                    <img class="col-top" width="30" height="30" src="assets/img/profiles/avatar_small.jpg" alt="" data-src="assets/img/profiles/avatar_small.jpg" data-src-retina="assets/img/profiles/avatar_small2x.jpg">
                  </div>
                  <div class="chat-bubble from-them">
                    Yea
                  </div>
                </div>
                <!-- END From Them Message  !-->
              </div>
              <!-- BEGIN Conversation  !-->
              <!-- BEGIN Chat Input  !-->
              <div class="b-t b-grey bg-white clearfix p-l-10 p-r-10">
                <div class="row">
                  <div class="col-xs-1 p-t-15">
                    <a href="#" class="link text-master"><i class="fa fa-plus-circle"></i></a>
                  </div>
                  <div class="col-xs-8 no-padding">
                    <input type="text" class="form-control chat-input" data-chat-input="" data-chat-conversation="#my-conversation" placeholder="Say something">
                  </div>
                  <div class="col-xs-2 link text-master m-l-10 m-t-15 p-l-10 b-l b-grey col-top">
                    <a href="#" class="link text-master"><i class="pg-camera"></i></a>
                  </div>
                </div>
              </div>
              <!-- END Chat Input  !-->
            </div>
            <!-- END Conversation View  !-->
          </div>
        </div>
      </div>
    </div>
    <!-- END QUICKVIEW-->

  <script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>



 <?php /*?>   <!-- BEGIN VENDOR JS -->
    <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script><?php */?>
        <!--Begin Word count-->
<!----><script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/jquery.inputlimiter.1.3.1.min.js"></script>
	<script type="text/javascript" src="js/word-count.js"></script>
    <link rel="stylesheet" type="text/css" href="js/jquery.inputlimiter.1.0.css" />
    <!--End Word count-->
    <!--<script src="assets/plugins/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>-->
<?php /*<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>

  <script>
  $(document).ready(function(){
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();
  });
  </script><?php */?>
  
  
    <script src="assets/plugins/modernizr.custom.js" type="text/javascript"></script> 
    <script src="assets/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="assets/plugins/jquery-ios-list/jquery.ioslist.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-actual/jquery.actual.min.js"></script>
    <script src="assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js"></script>
 
    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
   <script src="pages/js/pages.min.js"></script>
    <!-- END CORE TEMPLATE JS -->
    <!-- BEGIN PAGE LEVEL JS -->
    <script src="assets/js/dashboard.js" type="text/javascript"></script>
    <script src="assets/js/scripts.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS -->
  </body>
</html>