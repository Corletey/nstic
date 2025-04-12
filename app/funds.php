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

<script src="./js/ajax_populate.js"></script>
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
 $pid=$_GET['pid'];
 $true=$_GET['true'];
$sqlSOwner = "select * from ".$prefix."musers where usrm_id='$owner_id'";
$resOwner = $mysqli->query($sqlSOwner);
$sqOwner = $resOwner->fetch_array();
$OwnerName=$sqOwner['usrm_fname'].' '.$sqOwner['usrm_sname'];
$reviewerEmail=$sqOwner['usrm_email'];
?>    
               
   <div class="success" style="font-size:18px;">Funds for <?php echo $OwnerName;?></div>             
      <?php
$categorym=$_GET['categorym'];

$assignm_id=$_GET['assignm_id'];
//doSaveFive
if($_POST['doSaveAward'] and $id and $_POST['totalsubmitted']){


	$reviewer_id=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$reason=$mysqli->real_escape_string($_POST['reason']);
	$AmountofGrantawarded=$mysqli->real_escape_string($_POST['AmountofGrantawarded']);
    $DurationofGrant=$mysqli->real_escape_string($_POST['DurationofGrant']);
	$currency=$mysqli->real_escape_string($_POST['currency']);
	$BalanceonTotalBudget=$mysqli->real_escape_string($_POST['BalanceLeft']);
	$totalsubmitted=$mysqli->real_escape_string($_POST['totalsubmitted']);
	$totalsubmitted2=numberformat($_POST['totalsubmitted']);
	$awarded=$mysqli->real_escape_string($_POST['awarded']);
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

if($awarded=='Approved'){////Approved
$sqlA2ProtocolaSS="update ".$prefix."request_for_funds_main set `actionOnRequest`='Approved',`BalanceonTotalBudget`='$BalanceonTotalBudget' ,`reason`='$reason' where projectID='$pid' and id='$id'";
$mysqli->query($sqlA2ProtocolaSS);	

$sqlA2ProtocolaSS22="update ".$prefix."submissions_proposals set `GrantBalance`='$BalanceonTotalBudget' where projectID='$pid'";
$mysqli->query($sqlA2ProtocolaSS22);

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 	

require_once("viewlrcn/mail_template_request_for_funds_approved.php");
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
$mail->addCc("$emailBcc",'Grants Management Office');
//$mail->addBcc("mawandammoses@gmail.com",'Grants Management Office');//$mail->addBcc($reviewerEmail,$ReviewerName);

$mail->FromName = "Grants Management Office"; //From Name -- CHANGE --
$mail->AddAddress($OwnerEmail, $OwnerName2); //To Address -- CHANGE --$email
//if($dbEmail2){echo $mail->addCc($dbEmail2,'Activation Link from UNCST');}
$mail->AddReplyTo("$emailBcc", "Grants Management Office"); //Reply-To Address -- CHANGE --$usrm_email


$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Request for Funds Approved - $public_title";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}///end	
	

echo "
<script type=\"text/javascript\">
        alert('Successfully Approved...');
        window.close();
</script>";
}/////////////////////////End Approved Action

if($awarded=='Rejected'){////Approved
$sqlA2ProtocolaSS="update ".$prefix."request_for_funds_main set `actionOnRequest`='Rejected',`reason`='$reason' where projectID='$pid' and id='$id'";
$mysqli->query($sqlA2ProtocolaSS);	

$sqlA2ProtocolaSS22="update ".$prefix."request_for_funds set `actionStatus`='Rejected' where projectID='$pid' and mainFunds_id='$id'";
$mysqli->query($sqlA2ProtocolaSS22);	

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 	

require_once("viewlrcn/mail_template_request_for_funds_rejected.php");
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
$mail->addCc("$emailBcc",'Grants Management Office');
//$mail->addBcc("mawandammoses@gmail.com",'Grants Management Office');//$mail->addBcc($reviewerEmail,$ReviewerName);

$mail->FromName = "Grants Management Office"; //From Name -- CHANGE --
$mail->AddAddress($OwnerEmail, $OwnerName2); //To Address -- CHANGE --$email
//if($dbEmail2){echo $mail->addCc($dbEmail2,'Activation Link from UNCST');}
$mail->AddReplyTo("$emailBcc", "Grants Management Office"); //Reply-To Address -- CHANGE --$usrm_email

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Request for Funds REJECTED - $public_title";
$body="$allSentMessage
";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}///end	
	

echo "
<script type=\"text/javascript\">
        alert('Successfully REJECTED...');
        window.close();
</script>";
}/////////////////////////End Rejected Action




}//end post

$sqlUsers="SELECT * FROM ".$prefix."request_for_funds_main where `projectID`='$pid' and is_sent='1' and id='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
$TotalFunds=$QueryUsers->num_rows;
$rpData=$QueryUsers->fetch_array();
$TotalBudget=$rpData['BudgetItem'];

$sqlUsers22="SELECT * FROM ".$prefix."request_for_funds where `projectID`='$pid' and mainFunds_id='$id' order by id desc limit 0,1";
		$QueryUsers22 = $mysqli->query($sqlUsers22);
		$totalUsers22 = $QueryUsers22->num_rows;
		$rUserInv2=$QueryUsers22->fetch_array();
		
$wProposal="select * from ".$prefix."submissions_proposals where projectID='$pid'";
$cmProposal = $mysqli->query($wProposal);
$rUProposal=$cmProposal->fetch_array();
$rconceptID=$rUProposal['conceptID'];

$rowner_id=$rUProposal['owner_id'];
$wpi="select * from ".$prefix."musers where usrm_id='$rowner_id'";
$cmpi = $mysqli->query($wpi);
$rpi=$cmpi->fetch_array();

?>
<div id="requestFundsss" class="tabcontentss">
  <span onClick="this.parentElement.style.display='none'" class="topright">&times</span>
  
    
  <h3>Request for Funds </h3>

 
 <div class="container" style="width:95%;"><!--begin-->

  
    
     
 <div class="row success" style="margin-bottom:15px;">

    <div class="col-100">
     <label for="lname"><strong>Total Budget Submitted</strong> <span class="error">*</span></label>
      
     <div style="background:#F60; color:#ffffff; padding:5px;"><?php echo numberformat($rpData['BudgetItem']);?> <?php echo $rpData['currency'];?></div>
     <input name="currency" type="hidden" value="<?php echo $rpData['currency'];?>">
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="fname">Project Title: </label>
<?php echo $rUProposal['projectTitle'];?>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="fname">Name of PI: </label>
<?php echo $rpi['usrm_fname'];?> <?php echo $rpi['usrm_sname'];?>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Approved Grant Total: </label> <strong style="color:#F00; font-size:16px;"><?php echo numberformat($rUProposal['AmountofGrantawarded']);?> <?php echo $rUProposal['currency'];?></strong>
    </div>
  </div>

  
   <div class="row success">

    <div class="col-100">


    
    <?php
 $mmPersonnelTotal=($TotalBudget*0.08);
$mmResearchCosts=($TotalBudget*0.6);
$mmEquipmentTotal=($TotalBudget*0.15);
$mmTravel=($TotalBudget*0.02);
$mmkickoff=($TotalBudget*0.02);
$mmKnowledgeSharing=($TotalBudget*0.05);
$mmOverheadCostsTotal=($TotalBudget*0.05);
$mmOtherGoods=($TotalBudget*0.02);
$mmMatchingSupport=($TotalBudget*0.01);

$SumTotal=($mmPersonnelTotal+$mmResearchCosts+$mmEquipmentTotal+$mmTravel+$mmkickoff+$mmKnowledgeSharing+$mmOverheadCostsTotal+$mmOtherGoods+$mmMatchingSupport);
?>
 

   

    <!-- Funds Table -->
    <h4>Funds Requests</h4>
    <table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
        <tr>
            <th>Budget Item</th>
            <th>Description</th>
            <th>Estimated Cost</th>
            <th>Total Cost</th>
        </tr>
        <?php 
        $sqlFunds = "SELECT * FROM ".$prefix."request_for_funds where `projectID`='$pid' and mainFunds_id='$id'";
        $QueryFunds = $mysqli->query($sqlFunds);
        while($rFunds = $QueryFunds->fetch_array()){
        ?>
        <tr>
            <td><label><?php echo $rFunds['BudgetItem'];?></label></td>
            <td><label><?php echo $rFunds['DescriptionofExpenditure'];?></label></td>
            <td><label><?php echo numberformat($rFunds['EstimatedUnitCost']);?></label></td>
            <td><label><?php echo numberformat($rFunds['TotalCOST']);?></label></td>
        </tr>
        <?php }?>
    </table>

    <!-- Procurement Table -->
    <h4 style="margin-top: 20px;">Procurement Requests</h4>
    <table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
        <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Unit Cost</th>
            <th>Total Cost</th>
        </tr>
        <?php 
        $sqlProcurement = "SELECT * FROM ".$prefix."request_for_procurement where `projectID`='$pid'";
        $QueryProcurement = $mysqli->query($sqlProcurement);
        while($rProcurement = $QueryProcurement->fetch_array()){
        ?>
        <tr>
            <td><label><?php echo $rProcurement['BudgetItem'];?></label></td>
            <td><label><?php echo $rProcurement['DescriptionofExpenditure'];?></label></td>
            <td><label><?php echo number_format($rProcurement['EstimatedUnitCost']);?></label></td>
            <td><label><?php echo number_format($rProcurement['TotalCOST']);?></label></td>
        </tr>
        <?php }?>
    </table>

    



   

   


    
        </div>
  </div>
  
  
</div><!--End-->
 

 
 
</div>

<?php echo $rpData['reason'];?>

<?php if($true=="Yes"){?>

<form action="" name="regForm" id="regForm" method="post" enctype="multipart/form-data" autocomplete="off">

                          
                       
                         <div class="form-group row success" style="font-size:16px;">



							<input name="awarded" type="radio" value="Approved" class="required" onChange="getRequestforFundsApprove(this.value)"> &nbsp;Approve&nbsp;&nbsp;<input name="awarded" type="radio" value="Rejected" class="required" onChange="getRequestforFundsApprove(this.value)"> Reject
                    
                            
                            <input type="hidden" name="asrmApplctID" value="<?php echo $_SESSION['usrm_id'];?>">
                            <input type="hidden" name="submission_id" value="<?php echo $id;?>">
                           <input type="hidden" name="totalsubmitted" value="<?php echo $rpData['BudgetItem'];?>">
                           <input type="hidden" name="BalanceLeft" value="<?php echo ($rpData['ApprovedGrantTotal']-$rpData['BudgetItem']);?>">
                         
                       
                        
                        </div>
                        
                                         
                        <div class="line"></div>
                        
                       <div class="form-group row">
                          <div id="getrequestforfundsapprovediv"></div>
                          
                        </div>
                       
         
                       
                        
                        <div class="form-group row">
                          <div class="col-sm-4 offset-sm-3">
                    <input name="doSaveAward" type="submit"  class="btn btn-primary" value="Confirm"/>

                          </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        
                        
   
   </form>            
                        
   <?php }?>        
              
                
                
             
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
