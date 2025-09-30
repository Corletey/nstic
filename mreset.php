<?php
session_start();
require_once('contrlrcn/c_mlsrcontrol.php');
//require_once('./app/contrlrcn/c_mlsrcontrol.php'); 
?><!doctype html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="Ecology Theme">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang_grants_management_system;?> - <?php echo $lang_forgot_pasword;?></title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <!-- Goole Font -->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet"> 
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/assets/bootstrap.min.css">
    <!-- Font awsome CSS -->
    <link rel="stylesheet" href="css/assets/font-awesome.min.css">    
    <link rel="stylesheet" href="css/assets/flaticon.css">
    <link rel="stylesheet" href="css/assets/magnific-popup.css">    
    <!-- owl carousel -->
    <link rel="stylesheet" href="css/assets/owl.carousel.css">
    <link rel="stylesheet" href="css/assets/owl.theme.css">     
    <link rel="stylesheet" href="css/assets/animate.css"> 
    <!-- Slick Carousel -->
    <link rel="stylesheet" href="css/assets/slick.css">  
   
    <!-- Mean Menu-->
    <link rel="stylesheet" href="css/assets/meanmenu.css">
    <!-- main style-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/demo.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header class="header_inner contact_page">
<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>    
    <div class="header_top">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-12">
                    <div class="info_wrapper">
                        <div class="contact_info">                   
                            <ul class="list-unstyled">
                                <?php TopBarTelephone();?>
        						<?php TopBarEmail();?>
                            </ul>                    
                        </div>
                        <div class="login_info">
                            <?php require_once("pages/top_menu.php");?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="edu_nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light bg-faded">
                <a class="navbar-brand" href="./"><img src="images/logo.png" alt="logo"></a>
                <div class="collapse navbar-collapse main-menu" id="navbarSupportedContent">
                   <?php include("pages/menu.php");?>
                </div>
                <div class="mr-auto search_area ">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><i class="search_btn flaticon-magnifier"></i>
                            <div id="search">
                                <button type="button" class="close">×</button>
                                 <form>
                                     <input type="search" value="" placeholder="Search here...."  required/>
                                 </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav><!-- END NAVBAR -->
        </div> 
    </div>

    <div class="intro_wrapper">
        <div class="container">  
            <div class="row">        
                 <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="intro_text">
                        <h1><?php echo $lang_forgot_pasword;?></h1>
                        <div class="pages_links">
                            <a href="#" title=""><?php echo $lang_home;?></a>
                            <a href="#" title="" class="active"><?php echo $lang_forgot_pasword;?></a>
                        </div>
                    </div>
                </div>              
            </div>
        </div> 
    </div> 
</header> <!-- End Header -->



<section class="login_signup_option">
    <div class="l-modal is-hidden--off-flow js-modal-shopify">
        <div class="l-modal__shadow js-modal-hide"></div>
        <div class="login_popup login_modal_body">
            <div class="Popup_title d-flex justify-content-between">
                <h2 class="hidden">&nbsp;</h2>
                <!-- Nav tabs -->
                <div class="row">
                    <div class="col-12 col-lg-12 col-md-12 col-lg-12 login_option_btn">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#login" role="tab"><?php echo $lang_Login;?></a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel2" role="tab"><?php echo $lang_Register;?></a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                        <!-- Tab panels -->
                        <div class="tab-content card">
                            <!--Login-->
                            <div class="tab-pane fade in show active" id="login" role="tabpanel">
                               <form action=""  method="post" name="regForm" id="regForm" enctype="multipart/form-data" autocomplete="off">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $lang_username;?></label>
                                                <input type="text" class="form-control" placeholder="Username" name="name">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="control-label"><?php echo $lang_pasword;?></label>
                                                <input type="password" class="form-control" placeholder="Password" name="pwd">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 col-lg-12 d-flex justify-content-between login_option">
                                            <a href="forgot-password.php" title="" class="forget_pass"><?php echo $lang_forgot_pasword;?></a>
                                        
                                            <input name="doLogin" type="submit" class="btn btn-default login_btn" id="login" tabindex="10" value="<?php echo $lang_Signmein;?>"/>
                                            
                                            
                                        </div> 
                                      
                                    </div>
                                </form>
                            </div>
                            <!--/.Panel 1-->
                            <!--Panel 2-->
                            <div class="tab-pane fade" id="panel2" role="tabpanel">
                              <div class="tab-pane fade" id="panel2" role="tabpanel" style="height:300px; overflow:scroll;">
                     
                            <form action="" class="register" method="post" name="regForm" id="regForm" enctype="multipart/form-data" autocomplete="off">
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_first_name;?></label>
                                                <input type="text" class="form-control" placeholder="<?php echo $lang_first_name;?>" name="fname"  required>
                                            </div>
                                        </div>  
                                           <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_last_name;?></label>
                                                <input type="text" class="form-control" placeholder="<?php echo $lang_last_name;?>" name="sname"  required>
                                            </div>
                                        </div>  
                                                                              
                                        <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_email;?></label>
                                                <input type="email" class="form-control" placeholder="<?php echo $lang_email;?>" name="email" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_username;?></label>
                                                <input type="text" class="form-control" placeholder="<?php echo $lang_username;?>" name="username" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_password_must;?></label>
                                                <input type="password" class="form-control" placeholder="<?php echo $lang_password_must;?>" name="pwd" minlength="5" id="pwd" required>
                                            </div>
                                        </div>
                                        
                                         <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_retype_password;?></label>
                                               <input type="password" class="form-control" name="pwd2" id="pwd2" minlength="5"   equalto="#pwd" required>
                                            </div>
                                        </div>
                                        
                                          <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_institution_of_affiliation;?></label>
                                               <input type="text" class="form-control" name="Institution" id="Institution" required minlength="5">
                                            </div>
                                        </div>
                                        
                                          <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_phone_number;?></label>
                                               <input type="text" class="form-control" name="phone" id="phone" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_phone_number;?></label>
     
      <select name="Gender" id="Gender" class="required form-control" tabindex="6" required>
        <option value="">&nbsp; <?php echo $lang_gender;?></option>
        <option value="Male">&nbsp;<?php echo $lang_male;?></option>
        <option value="Female">&nbsp;<?php echo $lang_female;?></option>
      </select>
                                            </div>
                                        </div>
                                        
                                         <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_Qualifications;?></label>
<select name="Qualifications" id="Qualifications" class="required form-control" tabindex="6" onChange="getQualification(this.value)">
        <option value="">&nbsp; <?php echo $lang_please_select;?></option>
        <option value="Diploma">&nbsp;<?php echo $lang_Diploma;?></option>
        <option value="Bachelor's Degree">&nbsp;<?php echo $lang_Bachelor;?></option>
        <option value="Master's Degree">&nbsp;<?php echo $lang_Master;?></option>
        <option value="PHD">&nbsp;<?php echo $lang_PHD;?></option>
        <option value="Post-Doctoral">&nbsp;<?php echo $lang_post_Doctoral;?> </option>
        <option value="Other">&nbsp;<?php echo $lang_Other;?></option>
      </select>
                                            </div>
                                        </div>
                                        
                                      
                                      
                                         <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label  class="control-label"><?php echo $lang_Nationality;?></label>
                <select name="Nationality"  id="myUL" class="required form-control" tabindex="6" required>
    <option value="" selected>&nbsp; <?php echo $lang_please_select;?></option>
    <?php
$sqlUser = "SELECT * FROM ".$prefix."countries order by cidm_country_name asc";
$queryUser = $mysqli->query($sqlUser);
while($r = $queryUser->fetch_array()){?>
    <option value="<?php echo $r['cidm_country_id'];?>"  id="myUL">&nbsp;<?php echo $r['cidm_country_name'];?></option>
    <?php }?>
  </select>
                                            </div>
                                        </div>
                                        
                                          
                                        
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-12 col-md-12 col-lg-12 d-flex justify-content-between login_option">
                                      
                                           <input name="doRegister" type="submit" class="btn btn-default login_btn" value="<?php echo $lang_Register;?>"/> 
                                            
                                        </div> 
                                    </div>
                                </form>
                            </div><!--/.Panel 2-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>  <!-- End Login Signup Option -->




<!-- forgot pass section -->
<section class="forgot_pass">

<?php if(isset($err2) and $_POST['doLogin']){?><div style="background:rgb(255, 90, 44); text-align:center; color:#FFF; padding:3px;">ERROR: <?php echo $err2;?></div><?php }?> 
<?php if(isset($errormessage) and $_POST['doRegister']){?><div style="background:rgb(255, 90, 44); text-align:center; color:#FFF; padding:3px;">ERROR: <?php echo $errormessage;?></div><?php }?>
<?php if(isset($message)  and $_POST['doRegister']){?><div style="background:#92BF3E; text-align:center; color:#FFF; padding:3px;">SUCCESS: <?php echo $message;?></div><?php }?>

<?php if(isset($message)  and $_POST['doResendANumber']){?><div style="background:#92BF3E; text-align:center; color:#FFF; padding:3px;"><?php echo $message;?></div><?php }?>
<?php if($_POST['doResetPassword']){?><div style="background:#92BF3E; text-align:center; color:#FFF; padding:3px;">Congratulations!!!. Your password with UNCST Grants Management System has been re-set, you can now login now.</div><?php }?>

	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-7 col-sm-7 col-md-7 col-lg-7 mx-auto">
				<div class="forgot_wrapper">
					
					<form action="" method="post" name="regForm" id="regForm" enctype="multipart/form-data">
						<div class="form-group"> 
                        <label class="control-label" for="inputSuccess">Password <font color="#CC0000">*</font></label>
						  <input name="pwd" type="password" class="form-control password" minlength="6" id="pwd">
                     
						</div>
                        
                        <div class="form-group"> 
                        <label class="control-label" for="inputSuccess">Re-type Password <font color="#CC0000">*</font></label>
						<input name="pwd2"  id="pwd2" class="form-control required password" type="password" minlength="6" equalto="#pwd">
                     
						</div>
                        
						 <div class="col-12 col-lg-12 col-md-12 col-lg-12 d-flex justify-content-between login_option">
					                            
                            <input name="doResetPassword" type="submit" class="btn btn-primary reset_pass_btn" value="Change Password"/> 
						</div>	
					</form>
				</div>
			</div>												
		</div>
	</div>
</section>
<!-- ./ End section -->




<footer class="footer_2">
<?php include("pages/footer_section.php");?>
</footer><!-- End Footer -->

<section id="scroll-top" class="scroll-top">
    <h2 class="disabled">Scroll to top</h2>
    <div class="to-top pos-rtive">
        <a href="#"><i class = "flaticon-right-arrow"></i></a>
    </div>
</section>

    <!--  JavaScript -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>     
    <script src="js/owl.carousel.min.js"></script>  
    <script src="js/map-helper.js"></script>     
    <script src="js/slick.min.js"></script>   
    <script src="js/jquery.meanmenu.min.js"></script>  
    <script src="js/wow.min.js"></script> 
    <!-- Counter Script -->
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/custom.js"></script> 
    
  
</body>


</html>
