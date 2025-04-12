<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('contrlrcn/c_mlsrcontrol.php');

?>
<!doctype html>
<html lang="en">


<head>
    <base href="<?php echo $base_url; ?>" />
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="Ecology Theme">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang_grants_management_system; ?></title>
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
    <link rel="stylesheet" href="css/assets/preloader.css" />

    <!-- Revolution Slider -->
    <link rel="stylesheet" href="css/assets/revolution/layers.css">
    <link rel="stylesheet" href="css/assets/revolution/navigation.css">
    <link rel="stylesheet" href="css/assets/revolution/settings.css">
    <!-- Mean Menu-->
    <link rel="stylesheet" href="css/assets/meanmenu.css">
    <!-- main style-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <!-- <link rel="stylesheet" href="css/demo.css"> -->

    <!-- Below javascript to refresh Captcha-->
    <script type='text/javascript'>
        function refreshCaptcha() {
            var img = document.images['captchaimg'];
            img.src = img.src.substring(0, img.src.lastIndexOf("?")) + "?rand=" + Math.random() * 1000;
        }
    </script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->



    <!-- <script type="text/javascript"> 
        function googleTranslateElementInit() { 
            new google.translate.TranslateElement(
                {pageLanguage: 'en',includedLanguages: 'en,pt,fr,es', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 
				
                'google_translate_element'
            ); 
        } 
    </script> 
      
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>-->


</head>

<body>
    <header class="header_four">



        <!-- Preloader -->
        <!-- <div id="preloader">
            <div id="status">&nbsp;</div>
        </div> -->
        <div class="header_top">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-lg-12">
                        <div class="info_wrapper">
                            <div class="contact_info">
                                <ul class="list-unstyled">
                                    <?php TopBarTelephone(); ?>
                                    <?php TopBarEmail(); ?>
                                </ul>
                            </div>
                            <div class="login_info">

                                <?php require_once("pages/top_menu.php"); ?>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="edu_nav">


            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light bg-faded">
                    <!--<a class="navbar-brand logo" href="./" id="logo"></a>-->
                    <div class="logo"></div>
                    <div class="collapse navbar-collapse main-menu" id="navbarSupportedContent">
                        <?php include("pages/menu.php"); ?>


                    </div>


                    <div class="mr-auto search_area ">


                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item"><i class="search_btn flaticon-magnifier"></i>
                                <div id="search">
                                    <button type="button" class="close">×</button>
                                    <form>
                                        <input type="search" value="" placeholder="Search here...." required />
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav><!-- END NAVBAR -->
            </div>
        </div>


        <!--==================
        Slider ===================-->
        <?php if (isset($err2) and $_POST['doLogin']) { ?><div style="background:rgb(255, 90, 44); text-align:center; color:#FFF; padding:3px;"><?php echo $lang_wrong_username; ?></div><?php } ?>
        <?php if (isset($errormessage) and $_POST['doRegister']) { ?><div style="background:rgb(255, 90, 44); text-align:center; color:#FFF; padding:3px;">
                <p class="error3" style="font-size:18px;"><?php echo $lang_username_withemail . ' ' . $email; ?> <a href="#" class="nav-link join_now js-modal-show"><?php echo $lang_ClickheretoLogin; ?></a></p>
            </div><?php } ?>


        <?php if (isset($message)  and $_POST['doRegister']) { ?><div><?php echo $message; ?></div><?php } ?>
        <div class="rev_slider_wrapper">




            <div id="rev_slider_1" class="rev_slider">
                <ul>
                    <?php Slider(); ?>

                </ul><!-- END SLIDES LIST -->
            </div><!-- END SLIDER CONTAINER -->
        </div><!-- END SLIDER CONTAINER WRAPPER -->
    </header> <!--  End header section-->



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
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#login" role="tab"><?php echo $lang_Login; ?></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel2" role="tab"><?php echo $lang_Register; ?></a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                            <!-- Tab panels -->
                            <div class="tab-content card">
                                <!--Login-->
                                <div class="tab-pane fade in show active" id="login" role="tabpanel">

                                    <form action="" method="post" name="regForm" id="regForm" enctype="multipart/form-data" autocomplete="off">
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_username; ?></label>
                                                    <input type="text" class="form-control" placeholder="Username" name="name">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_pasword; ?></label>
                                                    <input type="password" class="form-control" placeholder="Password" name="pwd">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12 d-flex justify-content-between login_option">
                                                <a href="forgot-password.php" title="" class="forget_pass"><?php echo $lang_forgot_pasword; ?></a>

                                                <input name="doLogin" type="submit" class="btn btn-default login_btn" id="login" tabindex="10" value="<?php echo $lang_Signmein; ?>" />


                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <!--/.Panel 1-->
                                <!--Panel 2-->
                                <div class="tab-pane fade" id="panel2" role="tabpanel" style="height:300px; overflow:scroll;">

                                    <form action="" class="register" method="post" name="regForm" id="regForm" enctype="multipart/form-data" autocomplete="off">
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_first_name; ?></label>
                                                    <input type="text" class="form-control" placeholder="<?php echo $lang_first_name; ?>" name="fname" required value="<?php echo $_POST['fname']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_last_name; ?></label>
                                                    <input type="text" class="form-control" placeholder="<?php echo $lang_last_name; ?>" name="sname" required value="<?php echo $_POST['sname']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_email; ?></label>
                                                    <input type="email" class="form-control" placeholder="<?php echo $lang_email; ?>" name="email" required value="<?php echo $_POST['email']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_username; ?></label>
                                                    <input type="text" class="form-control" placeholder="<?php echo $lang_username; ?>" name="username" required value="<?php echo $_POST['username']; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_password_must; ?></label>
                                                    <input type="password" class="form-control" placeholder="<?php echo $lang_password_must; ?>" name="pwd" minlength="5" id="pwd" required>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_retype_password; ?></label>
                                                    <input type="password" class="form-control" name="pwd2" id="pwd2" minlength="5" equalto="#pwd" required>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_institution_of_affiliation; ?></label>
                                                    <input type="text" class="form-control" name="Institution" id="Institution" required minlength="5" value="<?php echo $_POST['Institution']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_phone_number; ?></label>
                                                    <input type="text" class="form-control" name="phone" id="phone" required value="<?php echo $_POST['phone']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_Gender; ?></label>

                                                    <select name="Gender" id="Gender" class="required form-control" tabindex="6" required>
                                                        <option value="">&nbsp; <?php echo $lang_please_select; ?></option>
                                                        <option value="Male" <?php if ($_POST['Gender'] == 'Male') { ?>selected<?php } ?>>&nbsp;<?php echo $lang_male; ?></option>
                                                        <option value="Female" <?php if ($_POST['Gender'] == 'Female') { ?>selected<?php } ?>>&nbsp;<?php echo $lang_female; ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_Qualifications; ?></label>
                                                    <select name="Qualifications" id="Qualifications" class="required form-control" tabindex="6" onChange="getQualification(this.value)">
                                                        <option value="">&nbsp; <?php echo $lang_please_select; ?></option>
                                                        <option value="Diploma" <?php if ($_POST['Qualifications'] == 'Diploma') { ?>selected<?php } ?>>&nbsp;<?php echo $lang_Diploma; ?></option>
                                                        <option value="Bachelor's Degree" <?php if ($_POST['Qualifications'] == "Bachelor's Degree") { ?>selected<?php } ?>>&nbsp;<?php echo $lang_Bachelor; ?></option>
                                                        <option value="Master's Degree" <?php if ($_POST['Qualifications'] == "Master's Degree") { ?>selected<?php } ?>>&nbsp;<?php echo $lang_Master; ?></option>
                                                        <option value="PHD" <?php if ($_POST['Qualifications'] == 'PHD') { ?>selected<?php } ?>>&nbsp;<?php echo $lang_PHD; ?></option>
                                                        <option value="Post-Doctoral" <?php if ($_POST['Qualifications'] == 'Post-Doctoral') { ?>selected<?php } ?>>&nbsp;<?php echo $lang_post_Doctoral; ?> </option>
                                                        <option value="Other" <?php if ($_POST['Qualifications'] == 'Other') { ?>selected<?php } ?>>&nbsp;<?php echo $lang_Other; ?></option>
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo $lang_Nationality; ?></label>
                                                    <select name="Nationality" id="myUL" class="required form-control" tabindex="6" required>
                                                        <option value="" selected>&nbsp; <?php echo $lang_please_select; ?></option>
                                                        <?php
                                                        $sqlUser = "SELECT * FROM " . $prefix . "countries order by cidm_country_name asc";
                                                        $queryUser = $mysqli->query($sqlUser);
                                                        while ($r = $queryUser->fetch_array()) { ?>
                                                            <option value="<?php echo $r['cidm_country_id']; ?>" id="myUL" <?php if ($_POST['Nationality'] == $r['cidm_country_id']) { ?>selected<?php } ?>>&nbsp;<?php echo $r['cidm_country_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label class="control-label">Validation code</label>
                                                    <img src="captcha.php?rand=<?php echo rand(); ?>" id='captchaimg'><br>

                                                    <input id="captcha_code" name="captcha_code" type="text">

                                                    <br>
                                                    Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh.



                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-12 col-md-12 col-lg-12 d-flex justify-content-between login_option">

                                                <input name="doRegister" type="submit" class="btn btn-default login_btn" value="<?php echo $lang_Register; ?>" onclick="return validate();" />

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
    </section> <!-- End Login Signup Option -->



    <!-- Active Call Here -->
    <?php
    require_once('pages/recent-calls.php');
    ?>

    <section class="about_top_wrapper">


        <div class="items_shape"></div>
        <div class="story_about">
            <div class="container">
                <div class="row">
                    <?php WelcomeText(); ?>

                    <?php include("pages/statistic_card.php"); ?>








                </div>
            </div>
        </div>
    </section><!-- End about_top_wrapper -->






    <section class="our_sponsor" style="background:#DFDFDF;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="sub_title">
                        <h2><?php echo $lang_In_collaboration_with; ?></h2>

                    </div><!-- ends: .section-header -->
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="sponsored_company_logos">
                        <?php Sponsors(); ?>

                    </ul>

                </div>
            </div>
        </div>
    </section><!-- ./ End Our Sponsor -->

    <footer>
        <?php include("pages/footer_section.php"); ?>
    </footer><!-- End Footer -->

    <section id="scroll-top" class="scroll-top">
        <h2 class="disabled">Scroll to top</h2>
        <div class="to-top pos-rtive">
            <a href="#"><i class="flaticon-right-arrow"></i></a>
        </div>
    </section>

    <!-- JavaScript -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- Revolution Slider -->
    <script src="js/assets/revolution/jquery.themepunch.revolution.min.js"></script>
    <script src="js/assets/revolution/jquery.themepunch.tools.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/jquery.meanmenu.min.js"></script>
    <!-- Counter Script -->
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/wow.min.js"></script>
    <!-- Revolution Extensions -->
    <script src="js/assets/revolution/extensions/revolution.extension.actions.min.js"></script>
    <script src="js/assets/revolution/extensions/revolution.extension.carousel.min.js"></script>
    <script src="js/assets/revolution/extensions/revolution.extension.kenburn.min.js"></script>
    <script src="js/assets/revolution/extensions/revolution.extension.layeranimation.min.js"></script>
    <script src="js/assets/revolution/extensions/revolution.extension.migration.min.js"></script>
    <script src="js/assets/revolution/extensions/revolution.extension.navigation.min.js"></script>
    <script src="js/assets/revolution/extensions/revolution.extension.parallax.min.js"></script>
    <script src="js/assets/revolution/extensions/revolution.extension.slideanims.min.js"></script>
    <script src="js/assets/revolution/extensions/revolution.extension.video.min.js"></script>
    <script src="js/assets/revolution/revolution.js"></script>
    <script src="js/custom.js"></script>


    <!--<div id="google_translate_element" style="height: 31px;
    width: 132px;
    bottom: 115px;
    right: 30px;
    display: block;
    position: fixed;
    text-align: center;
    z-index: 20001;
    background-color: #FF780F;
    cursor: pointer;
"></div> -->

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/60781d5a067c2605c0c2ac67/1f3aj5cdj';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->





</body>


</html>