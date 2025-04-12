<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('contrlrcn/c_mlsrcontrol.php');

// Function to get statistics for awarded grants
function GetAwardedGrantsStats()
{
    global $mysqli, $prefix;

    $stats = [];

    // Total awarded grants
    $sqlTotal = "SELECT COUNT(*) as count FROM " . $prefix . "submissions_proposals WHERE awarded='Yes'";
    $resultTotal = $mysqli->query($sqlTotal);
    $stats['total'] = $resultTotal->fetch_array()['count'];

    // Total funding awarded
    $sqlFunding = "SELECT SUM(AmountofGrantawarded) as total FROM " . $prefix . "submissions_proposals WHERE awarded='Yes'";
    $resultFunding = $mysqli->query($sqlFunding);
    $stats['funding'] = $resultFunding->fetch_array()['total'];

    // Grants by gender
    $sqlMale = "SELECT COUNT(*) as count FROM " . $prefix . "submissions_proposals p 
               JOIN " . $prefix . "musers u ON p.owner_id = u.usrm_id 
               WHERE p.awarded='Yes' AND u.usrm_gender='Male'";
    $resultMale = $mysqli->query($sqlMale);
    $stats['male'] = $resultMale->fetch_array()['count'];

    $sqlFemale = "SELECT COUNT(*) as count FROM " . $prefix . "submissions_proposals p 
                 JOIN " . $prefix . "musers u ON p.owner_id = u.usrm_id 
                 WHERE p.awarded='Yes' AND u.usrm_gender='Female'";
    $resultFemale = $mysqli->query($sqlFemale);
    $stats['female'] = $resultFemale->fetch_array()['count'];

    // Top institutions 
    $sqlInstitutions = "SELECT HostInstitution, COUNT(*) as count 
                       FROM " . $prefix . "submissions_proposals 
                       WHERE awarded='Yes' 
                       GROUP BY HostInstitution 
                       ORDER BY count DESC 
                       LIMIT 5";
    $resultInstitutions = $mysqli->query($sqlInstitutions);
    $stats['institutions'] = [];
    while ($row = $resultInstitutions->fetch_array()) {
        $stats['institutions'][] = $row;
    }

    return $stats;
}

// Function to display all awarded grants in card format, grouped by grantcallID
function AllAwardedGrants()
{
    global $mysqli, $prefix, $base_url;

    // Get all awarded grants grouped by grantcallID
    $sqlAwarded = "SELECT p.*, 
                  DATE_FORMAT(p.awardDate, '%d %M, %Y') AS formattedAwardDate,
                  DATE_FORMAT(p.awardDate, '%b') AS awardMonth,
                  DATE_FORMAT(p.awardDate, '%d') AS awardDay,
                  g.title AS grantCallTitle,
                  g.grantID AS grantCallID,
                  DATE_FORMAT(g.startDate, '%d %M, %Y') AS grantCallStartDate
                  FROM " . $prefix . "submissions_proposals p
                  LEFT JOIN " . $prefix . "grantcalls g ON p.grantcallID = g.grantID
                  WHERE p.awarded = 'Yes'
                  ORDER BY g.grantID, p.awardDate DESC, p.projectID DESC";

    $resultAwarded = $mysqli->query($sqlAwarded);
    $totalAwardedGrants = $resultAwarded->num_rows;

    if ($totalAwardedGrants == 0) {
        echo '<div class="no-grants-message">No awarded grants available at the moment.</div>';
        return;
    }

    $groupedGrants = [];
    while ($grant = $resultAwarded->fetch_array()) {
        $grantCallID = $grant['grantCallID'];
        if (!isset($groupedGrants[$grantCallID])) {
            $groupedGrants[$grantCallID] = [
                'title' => $grant['grantCallTitle'],
                'startDate' => $grant['grantCallStartDate'],
                'grants' => []
            ];
        }
        $groupedGrants[$grantCallID]['grants'][] = $grant;
    }

    foreach ($groupedGrants as $grantCallID => $grantCall) {
        echo '<div class="grant-call-group">';
        echo '<h3 class="grant-call-title">' . $grantCall['title'] . ' <span class="grant-call-date">(Published on ' . $grantCall['startDate'] . ')</span></h3>';
        echo '<div class="row grants-card-container">';

        foreach ($grantCall['grants'] as $grant) {
            $owner_id = $grant['owner_id'];
            $rstug_categoryID = $grant['researchTypeID'];

            // Get PI information
            $sqlPI = "SELECT * FROM " . $prefix . "musers WHERE usrm_id='$owner_id'";
            $resultPI = $mysqli->query($sqlPI);
            $rowPI = $resultPI->fetch_array();
            $PIName = $rowPI['usrm_fname'] . ' ' . $rowPI['usrm_sname'];
            $usrm_gender = $rowPI['usrm_gender'];

            // Get institution information
            $hostID = $grant['HostInstitution'];
            $institutionName = $hostID;
            if (is_numeric($hostID)) {
                $sqlInst = "SELECT * FROM " . $prefix . "institutions WHERE id='$hostID'";
                $resultInst = $mysqli->query($sqlInst);
                if ($resultInst->num_rows > 0) {
                    $rowInst = $resultInst->fetch_array();
                    $institutionName = $rowInst['name'];
                }
            }

            // Get category information
            $categoryName = "N/A";
            if ($rstug_categoryID) {
                $sqlCat = "SELECT * FROM " . $prefix . "categories WHERE rstug_categoryID='$rstug_categoryID'";
                $resultCat = $mysqli->query($sqlCat);
                if ($resultCat->num_rows > 0) {
                    $rowCat = $resultCat->fetch_array();
                    $categoryName = $rowCat['rstug_categoryName'];
                }
            }

            // Define a gender badge color
            $genderColor = ($usrm_gender == 'Female') ? 'badge-pink' : 'badge-primary';

            // Output grant card
            ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="grant-card">
                    <div class="grant-card-header">
                        <?php if ($grant['awardDay'] && $grant['awardMonth']) { ?>
                            <div class="award-date">
                                <span class="date-day"><?php echo $grant['awardDay']; ?></span>
                                <span class="date-month"><?php echo $grant['awardMonth']; ?></span>
                            </div>
                        <?php } ?>
                        <h5 class="grant-title">
                            <?php echo $grant['projectTitle']; ?>
                        </h5>
                    </div>

                    <div class="grant-card-body">
                        <div class="grant-meta">
                            <div class="meta-item">
                                <i class="fa fa-user"></i>
                                <span><?php echo $PIName; ?></span>
                                <span class="badge <?php echo $genderColor; ?>"><?php echo $usrm_gender; ?></span>
                            </div>

                            <div class="meta-item">
                                <i class="fa fa-building"></i>
                                <span><?php echo $institutionName; ?></span>
                            </div>

                            <div class="meta-item">
                                <i class="fa fa-money"></i>
                                <span><?php echo numberformat($grant['AmountofGrantawarded']); ?> <?php echo $grant['currency']; ?></span>
                            </div>

                            <!-- <?php if ($grant['grantCallTitle']) { ?>
                                <div class="meta-item">
                                    <i class="fa fa-bookmark"></i>
                                    <span><?php echo $grant['grantCallTitle']; ?></span>
                                </div>
                            <?php } ?> -->

                            <?php if ($categoryName != "N/A") { ?>
                                <div class="meta-item">
                                    <i class="fa fa-tag"></i>
                                    <span class="category-badge"><?php echo $categoryName; ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        echo '</div></div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <base href="<?php echo $base_url; ?>" />
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="description" content="Awarded Grants">
    <meta name="keywords" content="Grants, Funding, Research, Awards">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Awarded Grants - <?php echo $lang_grants_management_system; ?></title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <!-- Goole Font -->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/assets/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Font awesome CSS -->
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

    <link rel="stylesheet" href="css/awarded-grants.css">

    
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
                    <div class="logo"></div>
                    <div class="collapse navbar-collapse main-menu" id="navbarSupportedContent">
                        <?php include("pages/menu.php"); ?>
                    </div>
                    <div class="mr-auto search_area">
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
                </nav>
            </div>
        </div>
    </header>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Awarded Grants</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Awarded Grants</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Awarded Grants Section -->
    <section class="awarded-grants-area">
        <div class="container">
            <!-- Stats Cards -->
            <div class="row">
                <div class="col-12">
                    <h4 class="stats-heading">Awarded Grants Statistics</h4>
                </div>
            </div>

            <div class="row stats-cards">
                <?php
                $stats = GetAwardedGrantsStats();
                ?>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="stats-card stats-card-primary">
                        <div class="stats-icon">
                        <i class="fa fa-trophy"></i>
                        </div>
                        <div class="stats-title">Total Grants</div>
                        <div class="stats-number"><?php echo $stats['total']; ?></div>
                        <div class="stats-label">Awarded projects</div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="stats-card stats-card-success">
                        <div class="stats-icon">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="stats-title">Total Funding</div>
                        <div class="stats-number">$<?php echo numberformat($stats['funding']); ?></div>
                        <div class="stats-label">Funds awarded</div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-4">
                <div class="stats-card stats-card-info">
                    <div class="stats-icon">
                        <i class="fa fa-venus-mars"></i>
                    </div>
                    <div class="stats-title">Gender Distribution</div>
                    <div class="gender-distribution">
                        <!-- Make sure canvas has explicit width and height attributes -->
                        <canvas id="genderChart" width="200" height="200"></canvas>
                    </div>
                    <div class="gender-legend">
                        <div class="legend-item">
                            <div class="legend-color male-color"></div>
                            <span>Male: <?php echo $stats['male']; ?></span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-color female-color"></div>
                            <span>Female: <?php echo $stats['female']; ?></span>
                        </div>
                    </div>
                </div>
                </div>


                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="stats-card stats-card-warning">
                        <div class="stats-icon">
                            <i class="fa fa-university"></i>
                        </div>
                        <div class="stats-title">Top Institutions</div>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($stats['institutions'] as $index => $institution):
                                if ($index < 3): // Show only top 3
                                    $instName = $institution['HostInstitution'];
                                    if (is_numeric($instName)) {
                                        $sqlInst = "SELECT name FROM " . $prefix . "institutions WHERE id='$instName'";
                                        $resultInst = $mysqli->query($sqlInst);
                                        if ($resultInst->num_rows > 0) {
                                            $rowInst = $resultInst->fetch_array();
                                            $instName = $rowInst['name'];
                                        }
                                    }
                            ?>
                                    <li class="mb-2">
                                        <div class="d-flex justify-content-between">
                                            <span><?php echo $instName; ?></span>
                                            <span class="badge badge-primary"><?php echo $institution['count']; ?></span>
                                        </div>
                                    </li>
                            <?php endif;
                            endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Awarded Grants Cards -->
            <div class="row">
                <div class="col-12">
                    <h4 class="grants-heading">Awarded Grants List</h4>
                </div>
            </div>

            <?php AllAwardedGrants(); ?>
        </div>
    </section>

    <footer class="modern-footer">
        <!-- Footer content from your previous implementation -->
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

    <!-- Chart.js for gender distribution -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Make sure the DOM is fully loaded before initializing the chart
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure the canvas element exists
            var canvas = document.getElementById('genderChart');
            if (canvas) {
                var ctx = canvas.getContext('2d');

                // Create the chart with more robust configuration
                var genderChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Male', 'Female'],
                        datasets: [{
                            data: [<?php echo $stats['male']; ?>, <?php echo $stats['female']; ?>],
                            backgroundColor: ['#4e73df', '#e83e8c'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: true
                            }
                        }
                    }
                });

                console.log('Gender chart initialized successfully');
            } else {
                console.error('Cannot find canvas element with id "genderChart"');
            }
        });
    </script>
</body>

</html>