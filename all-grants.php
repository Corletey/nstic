<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('contrlrcn/c_mlsrcontrol.php');

// Function to display all grants
// Function to display all grants with proper date comparison
function AllGrantCalls()
{
    global $mysqli, $gr_mgroup_id, $prefix, $usrm_id, $today, $lang_Deadline, $lang_ClicktoViewDetails;

    // First, ensure $today is in the correct format for comparison
    $currentDate = date('Y-m-d'); // Format: YYYY-MM-DD

    // Modified query to order by active status first, then by EndDate
    $sqlGroupDIspC = "SELECT *, 
                      DATE_FORMAT(`startDate`,'%d %M, %Y') AS startDate, 
                      DATE_FORMAT(`EndDate`,'%d %M, %Y') AS EndDate, 
                      DATE_FORMAT(`EndDate`,'%b') AS month, 
                      DATE_FORMAT(`EndDate`,'%d') AS date,
                      EndDate as rawEndDate,
                      CASE 
                        WHEN EndDate >= '$currentDate' THEN 1 
                        ELSE 0 
                      END AS is_active
                      FROM " . $prefix . "grantcalls 
                      WHERE publish='Yes' 
                      ORDER BY is_active DESC, EndDate DESC";
                      
    $sqlFGrpDisC = $mysqli->query($sqlGroupDIspC);
    $totalGrants = $sqlFGrpDisC->num_rows;
    
    if($totalGrants == 0) {
        echo '<div class="no-grants-message">No grant calls available at the moment. Please check back later.</div>';
        return;
    }
    
    echo '<div class="all-grants-count">Showing all ' . $totalGrants . ' grant calls</div>';
    
    while ($rGRSPC = $sqlFGrpDisC->fetch_array()) {
        // Proper date comparison using the raw date from database
        $isActive = (strtotime($rGRSPC['rawEndDate']) >= strtotime($currentDate)) ? true : false;
    ?>
        <div class="call-card <?php echo $isActive ? 'active' : 'expired'; ?>">
            <!-- Status indicator -->
            <div class="call-status">
                <?php if($isActive) { ?>
                    <span class="status-badge active">Active</span>
                <?php } else { ?>
                    <span class="status-badge expired">Expired</span>
                <?php } ?>
            </div>
            
            <!-- Date badge -->
            <div class="call-date">
                <span class="date-day"><?php echo $rGRSPC['date']; ?></span>
                <span class="date-month"><?php echo $rGRSPC['month']; ?></span>
            </div>
            
            <!-- Call content -->
            <div class="call-content">
                <h3 class="call-title"><a href="#"><?php echo $rGRSPC['title']; ?></a></h3>
                
                <div class="call-meta">
                    <div class="deadline">
                        <i class="flaticon-clock-circular-outline"></i>
                        <span><?php echo $lang_Deadline; ?>: <?php echo $rGRSPC['EndDate']; ?></span>
                    </div>
                    
                    <div class="start-date">
                        <i class="flaticon-calendar"></i>
                        <span>Start Date: <?php echo $rGRSPC['startDate']; ?></span>
                    </div>
                </div>
                
                <?php if(!empty($rGRSPC['shortDescription'])) { ?>
                <div class="call-description">
                    <?php echo substr($rGRSPC['shortDescription'], 0, 200); ?>
                    <?php if(strlen($rGRSPC['shortDescription']) > 200) echo '...'; ?>
                </div>
                <?php } ?>
                
                <div class="call-action">
                    <a href="grant-details.php?id=<?php echo $rGRSPC['grantID']; ?>" class="view-details-btn">
                        <?php echo $lang_ClicktoViewDetails; ?>
                    </a>
                </div>
            </div>
        </div>
    <?php
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo $base_url; ?>" />
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="description" content="All Available Grant Calls">
    <meta name="keywords" content="Grants, Funding, Research">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Grant Calls - <?php echo $lang_grants_management_system; ?></title>
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
    <!-- Revolution Slider -->
    <link rel="stylesheet" href="css/assets/revolution/layers.css">
    <link rel="stylesheet" href="css/assets/revolution/navigation.css">
    <link rel="stylesheet" href="css/assets/revolution/settings.css">
    <!-- Mean Menu-->
    <link rel="stylesheet" href="css/assets/meanmenu.css">
    <!-- main style-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    
    <style>
    /* All Grants Page Styles */
    .all-grants-area {
        padding: 60px 0;
        background-color: #f8f9fa;
    }
    
    .page-header {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('./images/banner/grantsbanner.jpg');
        background-size: cover;
        background-position: center;
        padding: 80px 0;
        color: #fff;
        text-align: center;
        margin-bottom: 40px;
    }
    
    .page-header h1 {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #fff;
    }
    
    .breadcrumb {
        background: transparent;
        display: flex;
        justify-content: center;
    }
    
    .breadcrumb-item {
        color: #fff;
    }
    
    .breadcrumb-item a {
        color: #f58f14;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: #fff;
    }
    
    .all-grants-count {
        margin-bottom: 20px;
        color: #666;
        font-style: italic;
    }
    
    .all-grants-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        width: 100%;
    }
    
    .call-card {
        position: relative;
        display: flex;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .call-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }
    
    .call-card.expired {
        opacity: 0.8;
    }
    
    .call-status {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1;
    }
    
    .status-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
    }
    
    .status-badge.active {
        background-color: #28a745;
        color: #fff;
    }
    
    .status-badge.expired {
        background-color: #dc3545;
        color: #fff;
    }
    
    .call-date {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-width: 80px;
        background-color: #f58f14;
        color: #fff;
        padding: 15px 10px;
        text-align: center;
    }
    
    .date-day {
        font-size: 24px;
        font-weight: 700;
        line-height: 1;
    }
    
    .date-month {
        font-size: 16px;
        text-transform: uppercase;
        margin-top: 5px;
    }
    
    .call-content {
        padding: 20px;
        flex-grow: 1;
    }
    
    .call-title {
        font-size: 18px;
        font-weight: 600;
        margin-top: 0;
        margin-bottom: 15px;
    }
    
    .call-title a {
        color: #333;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .call-title a:hover {
        color: #f58f14;
    }
    
    .call-meta {
        margin-bottom: 15px;
    }
    
    .deadline, .start-date {
        display: flex;
        align-items: center;
        color: #666;
        font-size: 14px;
        margin-bottom: 5px;
    }
    
    .deadline i, .start-date i {
        margin-right: 8px;
        color: #f58f14;
    }
    
    .call-description {
        font-size: 14px;
        color: #777;
        margin-bottom: 15px;
        line-height: 1.5;
    }
    
    .call-action {
        margin-top: 15px;
    }
    
    .view-details-btn {
        display: inline-block;
        background-color: #0066cc;
        color: #fff;
        font-size: 14px;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }
    
    .view-details-btn:hover {
        background-color: #0052a3;
        color: #fff;
    }
    
    .no-grants-message {
        text-align: center;
        padding: 40px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        font-size: 18px;
        color: #666;
    }
    
    /* Responsive adjustments */
    @media (max-width: 991px) {
        .page-header {
            padding: 60px 0;
        }
        
        .page-header h1 {
            font-size: 36px;
        }
        
        .all-grants-container {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }
    
    @media (max-width: 767px) {
        .page-header {
            padding: 40px 0;
        }
        
        .page-header h1 {
            font-size: 30px;
        }
        
        .all-grants-area {
            padding: 40px 0;
        }
        
        .all-grants-container {
            grid-template-columns: 1fr;
            max-width: 500px;
            margin: 0 auto;
        }
    }
    
    @media (max-width: 480px) {
        .call-card {
            flex-direction: column;
        }
        
        .call-date {
            flex-direction: row;
            width: 100%;
            padding: 10px;
            justify-content: center;
        }
        
        .date-day {
            font-size: 20px;
            margin-right: 5px;
        }
        
        .date-month {
            font-size: 14px;
            margin-top: 0;
        }
        
        .call-title {
            font-size: 16px;
        }
        
        .view-details-btn {
            display: block;
            text-align: center;
        }
    }
    </style>
</head>

<body>
    <header class="header_four">
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
    </header>
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>All Grant Calls</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Grant Calls</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <!-- All Grants Section -->
    <section class="all-grants-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="all-grants-container">
                        <?php AllGrantCalls(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <footer>
        <?php include("pages/footer_section.php"); ?>
    </footer>
    
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
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/jquery.meanmenu.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/custom.js"></script>
</body>
</html>