<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once('contrlrcn/c_mlsrcontrol.php');

// Check if grant ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect to grants listing if no valid ID
    header("Location: all-grants.php");
    exit();
}

$grantID = intval($_GET['id']);

// Function to get grant details
function getGrantDetails($grantID) {
    global $mysqli, $prefix, $today;
    
    $sql = "SELECT *, 
            DATE_FORMAT(`startDate`, '%d %M, %Y') AS formattedStartDate,
            DATE_FORMAT(`EndDate`, '%d %M, %Y') AS formattedEndDate
            FROM " . $prefix . "grantcalls 
            WHERE grantID = ? AND publish = 'Yes'";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $grantID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return null;
    }
    
    $grant = $result->fetch_assoc();
    
    // Add status
    $currentDate = date('Y-m-d');
    $grant['isActive'] = (strtotime($grant['EndDate']) >= strtotime($currentDate));
    
    return $grant;
}

// Get grant details
$grant = getGrantDetails($grantID);

// Check if grant exists
if (!$grant) {
    header("Location: all-grants.php");
    exit();
}

// Get related grants in the same category
function getRelatedGrants($grantID, $category, $limit = 3) {
    global $mysqli, $prefix, $today;
    
    $currentDate = date('Y-m-d');
    
    $sql = "SELECT grantID, title, 
            DATE_FORMAT(`EndDate`, '%d %M, %Y') AS formattedEndDate,
            DATE_FORMAT(`EndDate`, '%b') AS month,
            DATE_FORMAT(`EndDate`, '%d') AS date
            FROM " . $prefix . "grantcalls 
            WHERE grantID != ? AND category = ? AND publish = 'Yes'
            AND EndDate >= ?
            ORDER BY EndDate ASC 
            LIMIT ?";
    
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("issi", $grantID, $category, $currentDate, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $relatedGrants = array();
    while ($row = $result->fetch_assoc()) {
        $relatedGrants[] = $row;
    }
    
    return $relatedGrants;
}

$relatedGrants = getRelatedGrants($grantID, $grant['category']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo $base_url; ?>" />
    <meta charset="UTF-8">
    <meta name="description" content="<?php echo htmlspecialchars(substr(strip_tags($grant['summary']), 0, 160)); ?>">
    <meta name="keywords" content="Grants, Funding, Research, <?php echo htmlspecialchars($grant['title']); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($grant['title']); ?> - <?php echo $lang_grants_management_system; ?></title>
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
    <link rel="stylesheet" href="css/grants-details.css">
    <!-- PDF.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf_viewer.min.css">
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
                    <h1>Grant Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item"><a href="all-grants.php">All Grants</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Grant Details</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Grant Details Section -->
    <section class="grant-details-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Grant Header -->
                    <div class="grant-header">
                        <div class="grant-status">
                            <?php if($grant['isActive']) { ?>
                                <span class="status-badge active">Active</span>
                            <?php } else { ?>
                                <span class="status-badge expired">Expired</span>
                            <?php } ?>
                        </div>
                        <h2 class="grant-title"><?php echo htmlspecialchars($grant['title']); ?></h2>
                    </div>
                    
                    <!-- Grant Meta Information -->
                    <div class="grant-meta">
                        <div class="meta-item">
                            <span class="meta-label">Start Date</span>
                            <span class="meta-value"><?php echo $grant['formattedStartDate']; ?></span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Deadline</span>
                            <span class="meta-value"><?php echo $grant['formattedEndDate']; ?></span>
                        </div>
                        <?php if(!empty($grant['gnt_hour']) && !empty($grant['gnt_hour_end'])) { ?>
                        <div class="meta-item">
                            <span class="meta-label">Hours</span>
                            <span class="meta-value"><?php echo $grant['gnt_hour'] . ' - ' . $grant['gnt_hour_end']; ?></span>
                        </div>
                        <?php } ?>
                        <div class="meta-item">
                            <span class="meta-label">Category</span>
                            <span class="meta-value"><?php echo ucfirst($grant['category']); ?></span>
                        </div>
                        <?php if(!empty($grant['shortacronym'])) { ?>
                        <div class="meta-item">
                            <span class="meta-label">Acronym</span>
                            <span class="meta-value"><?php echo htmlspecialchars($grant['shortacronym']); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    
                    <!-- Grant Content -->
                    <div class="grant-content">
                        <?php if(!empty($grant['summary'])) { ?>
                        <div class="grant-section">
                            <h3 class="grant-section-title">Summary</h3>
                            <div class="grant-section-content">
                                <?php echo $grant['summary']; ?>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <?php if(!empty($grant['details'])) { ?>
                        <div class="grant-section">
                            <h3 class="grant-section-title">Detailed Information</h3>
                            <div class="grant-section-content">
                                <?php echo $grant['details']; ?>
                            </div>
                        </div>
                        <?php } ?>
                        
                        <?php if(!empty($grant['attachment'])) { ?>
                        <div class="grant-section download-section">
                            <h3 class="grant-section-title">Documents</h3>
                            <!-- PDF Preview Section -->
                            <div id="pdf-preview" class="pdf-preview-container">
                                <canvas id="pdf-canvas"></canvas>
                                <div class="pdf-controls">
                                    <button id="prev-page" class="btn btn-secondary">Previous</button>
                                    <span>Page: <span id="page-num"></span> / <span id="page-count"></span></span>
                                    <button id="next-page" class="btn btn-secondary">Next</button>
                                </div>
                            </div>
                            <a href="./app/files/<?php echo $grant['attachment']; ?>" class="download-btn" download>
                                <i class="fa fa-download"></i> Download Attachment
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                    
                    <!-- Apply Button -->
                    <div class="apply-section">
                        <?php if($grant['isActive']) { ?>
                            <a href="#" class="apply-btn nav-link sign-in js-modal-show" data-redirect="app/main.php?option=apply&grant_id=<?php echo $grant['grantID']; ?>">
                                <i class="fa fa-paper-plane"></i> Apply Now
                            </a>
                        <?php } else { ?>
                            <a href="#" class="apply-btn disabled" onclick="return false;">
                                <i class="fa fa-clock-o"></i> Application Closed
                            </a>
                        <?php } ?>
                    </div>
                    
                    <!-- Related Grants -->
                    <?php if(!empty($relatedGrants)) { ?>
                    <div class="related-grants">
                        <h3 class="related-title">Related Grant Calls</h3>
                        <div class="related-grants-container">
                            <?php foreach($relatedGrants as $relatedGrant) { ?>
                            <div class="related-grant-card">
                                <div class="related-grant-header">
                                    <div class="related-grant-date">
                                        <span class="related-date-day"><?php echo $relatedGrant['date']; ?></span>
                                        <span class="related-date-month"><?php echo $relatedGrant['month']; ?></span>
                                    </div>
                                    <h4 class="related-grant-title"><?php echo htmlspecialchars($relatedGrant['title']); ?></h4>
                                </div>
                                <div class="related-grant-footer">
                                    <a href="grant-details.php?id=<?php echo $relatedGrant['grantID']; ?>" class="related-grant-link">
                                        View Details <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Login/Signup Modal -->
    <section class="login_signup_option">
        <!-- Modal content as in your original code -->
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
    <!-- PDF.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script>
        // PDF Preview Script
        const pdfUrl = './app/files/<?php echo $grant['attachment']; ?>';
        let pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.5,
            canvas = document.getElementById('pdf-canvas'),
            ctx = canvas.getContext('2d');

        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                const renderTask = page.render(renderContext);

                renderTask.promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }
                });
            });

            document.getElementById('page-num').textContent = num;
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        function onPrevPage() {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
        }

        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
        }

        document.getElementById('prev-page').addEventListener('click', onPrevPage);
        document.getElementById('next-page').addEventListener('click', onNextPage);

        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('page-count').textContent = pdfDoc.numPages;
            renderPage(pageNum);
        });
    </script>
</body>
</html>