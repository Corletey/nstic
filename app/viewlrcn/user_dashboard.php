<?php
// Database queries section
$sessionusrm_id = $_SESSION['usrm_id'];

// Concepts queries
$sqlFListsconcepts = "SELECT * FROM ".$prefix."submissions_concepts WHERE invited_for_proposal='invited' AND owner_id='$sessionusrm_id'";
$QueryFListconcepts = $mysqli->query($sqlFListsconcepts);
$totalFLconcepts = $QueryFListconcepts->num_rows;
$rsOwnerconcepts = $QueryFListconcepts->fetch_array();

// Current grant call
$sql = "SELECT * FROM ".$prefix."grantcalls WHERE category='concepts' ORDER BY grantID DESC LIMIT 0,1";
$result = $mysqli->query($sql);
$rsGrants = $result->fetch_array();

// All user concepts
$sqlFListsconceptsNoconcept = "SELECT * FROM ".$prefix."submissions_concepts WHERE owner_id='$sessionusrm_id'";
$QueryFListNoconcept = $mysqli->query($sqlFListsconceptsNoconcept);
$totalFLNoconcept = $QueryFListNoconcept->num_rows;
$rsConcept = $QueryFListNoconcept->fetch_array();

// Awarded proposals
$sqlFListsProposal = "SELECT * FROM ".$prefix."submissions_proposals WHERE awarded='Yes' AND owner_id='$sessionusrm_id' ORDER BY projectID DESC";
$QueryFListProposal = $mysqli->query($sqlFListsProposal);
$totalAwards = $QueryFListProposal->num_rows;

// Get recent calls (pagination logic)
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limitm = 5;
$start = ($page - 1) * $limitm;

$query = $mysqli->query("SELECT COUNT(*) as num FROM ".$prefix."grantcalls WHERE publish='Yes' ORDER BY grantID DESC");
$row = $query->fetch_array(MYSQLI_NUM);
$total_pages = $row[0];

$sql = "SELECT * FROM ".$prefix."grantcalls WHERE publish='Yes' ORDER BY grantID DESC LIMIT $start, $limitm";
$result = $mysqli->query($sql);

// Calculate pagination
$prev = $page - 1;
$next = $page + 1;
$lastpage = ceil($total_pages/$limitm);

// Create the base URL for pagination
$baseURL = "main.php?option=dashboard";
?>
<link rel="stylesheet" href="assets/css/dashboard.css">
<!-- Modern Dashboard UI -->
<div class="dashboard-container">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1><i class="fas fa-tachometer-alt"></i> <?php echo $lang_UserDashboard ?? 'User Dashboard'; ?></h1>
        <p class="last-login">Last login: <?php echo date('M d, Y h:i A'); ?></p>
    </div>
    
    <!-- Dashboard Overview Cards -->
    <div class="overview-cards">
        <div class="card">
            <div class="card-icon">
                <i class="fas fa-lightbulb"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $lang_SubmittedConcepts ?? 'Submitted Concepts'; ?></h3>
                <p class="card-value"><?php echo TotalSubmittedConcepts(); ?></p>
                <a href="./main.php?option=usrSubmittedConcepts" class="card-link">View All</a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $lang_SubmittedProposals ?? 'Submitted Proposals'; ?></h3>
                <p class="card-value"><?php echo TotalSubmittedProposals(); ?></p>
                <a href="./main.php?option=usrSubmittedProposals" class="card-link">View All</a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-icon">
                <i class="fas fa-award"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $lang_GrantsAwarded ?? 'Grants Awarded'; ?></h3>
                <p class="card-value"><?php echo $totalAwards; ?></p>
                <a href="./main.php?option=GrantsUserAwarded" class="card-link">View All</a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-icon">
                <i class="fas fa-hand-paper"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $lang_HaltedStudies ?? 'Halted Studies'; ?></h3>
                <p class="card-value"><?php echo HaltedStudiesUser(); ?></p>
                <a href="./main.php?option=HaltedStudiesUser" class="card-link">View All</a>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="./main.php?option=usrCallforConcepts" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> <?php echo $lang_CallforConcepts ?? 'Call for Concepts'; ?>
            <span class="badge"><?php if(function_exists('TotalCallforConcepts')) { echo TotalCallforConcepts(); } else { echo '0'; } ?></span>
            <?php if(isset($rsGrants['grantID']) && isset($rsConcept['grantID']) && $rsGrants['grantID'] != $rsConcept['grantID']): ?>
                <span class="new-badge"><i class="fas fa-star"></i> NEW</span>
            <?php endif; ?>
        </a>
        
        <?php if($totalFLconcepts): ?>
        <a href="./main.php?option=usrCallforProposals" class="btn btn-success">
            <i class="fas fa-file-signature"></i> <?php echo $lang_CallforProposals ?? 'Call for Proposals'; ?>
            <span class="badge"><?php if(function_exists('TotalCallforProposals')) { echo TotalCallforProposals(); } else { echo '0'; } ?></span>
            <span class="new-badge"><i class="fas fa-star"></i> NEW</span>
        </a>
        <?php endif; ?>
    </div>
    
    <!-- Stats Panels -->
    <div class="stats-container">
        <!-- Concepts Stats -->
        <div class="stats-panel">
            <div class="panel-header">
                <h2><i class="fas fa-lightbulb"></i> <?php echo $lang_SubmittedConcepts ?? 'Submitted Concepts'; ?></h2>
                <span class="total-badge"><?php if(function_exists('TotalSubmittedConcepts')) { echo TotalSubmittedConcepts(); } else { echo $totalFLNoconcept ?? '0'; } ?></span>
            </div>
            <div class="panel-body">
                <div class="stat-item">
                    <span class="stat-label"><?php echo $lang_Drafts ?? 'Drafts'; ?></span>
                    <span class="stat-value"><?php if(function_exists('DraftConcepts')) { echo DraftConcepts(); } else { echo '<span class="badge badge-secondary">N/A</span>'; } ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label"><?php echo $lang_Submitted ?? 'Submitted'; ?></span>
                    <span class="stat-value"><?php if(function_exists('PendingReviewConcepts')) { echo PendingReviewConcepts(); } else { echo '<span class="badge badge-secondary">N/A</span>'; } ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label"><?php echo $lang_Scheduled_for_Review ?? 'Scheduled for Review'; ?></span>
                    <span class="stat-value"><?php if(function_exists('ScheduledforReviewConcepts')) { echo ScheduledforReviewConcepts(); } else { echo '<span class="badge badge-secondary">N/A</span>'; } ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label"><?php echo $lang_Reviewed ?? 'Reviewed'; ?></span>
                    <span class="stat-value"><?php if(function_exists('ApprovedConceptsUser')) { echo ApprovedConceptsUser(); } else { echo '<span class="badge badge-secondary">N/A</span>'; } ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label"><?php echo $lang_Rejected ?? 'Rejected'; ?></span>
                    <span class="stat-value"><?php if(function_exists('RejectedConceptsUser')) { echo RejectedConceptsUser(); } else { echo '<span class="badge badge-secondary">N/A</span>'; } ?></span>
                </div>
            </div>
        </div>
        
        <!-- Proposals Stats -->
        <div class="stats-panel">
            <div class="panel-header">
                <h2><i class="fas fa-file-alt"></i> <?php echo $lang_SubmittedProposals ?? 'Submitted Proposals'; ?></h2>
                <span class="total-badge"><?php
                    if(function_exists('TotalSubmittedProposals')) { 
                        echo TotalSubmittedProposals(); 
                    } else {
                        $countProposals = $mysqli->query("SELECT COUNT(*) as num FROM ".$prefix."submissions_proposals WHERE owner_id='$sessionusrm_id'")->fetch_array();
                        echo $countProposals['num'] ?? '0';
                    }
                ?></span>
            </div>
            <div class="panel-body">
                <div class="stat-item">
                    <span class="stat-label"><?php echo $lang_Drafts ?? 'Drafts'; ?></span>
                    <span class="stat-value"><?php if(function_exists('DraftProposals')) { echo DraftProposals(); } else { echo '<span class="badge badge-secondary">N/A</span>'; } ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label"><?php echo $lang_Submitted ?? 'Submitted'; ?></span>
                    <span class="stat-value"><?php if(function_exists('PendingReviewProposals')) { echo PendingReviewProposals(); } else { echo '<span class="badge badge-secondary">N/A</span>'; } ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label"><?php echo $lang_Scheduled_for_Review ?? 'Scheduled for Review'; ?></span>
                    <span class="stat-value"><?php if(function_exists('ScheduledforReviewProposals')) { echo ScheduledforReviewProposals(); } else { echo '<span class="badge badge-secondary">N/A</span>'; } ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label"><?php echo $lang_Reviewed ?? 'Reviewed'; ?></span>
                    <span class="stat-value"><?php if(function_exists('ApprovedProposals')) { echo ApprovedProposals(); } else { echo '<span class="badge badge-secondary">N/A</span>'; } ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label"><?php echo $lang_Rejected ?? 'Rejected'; ?></span>
                    <span class="stat-value"><?php if(function_exists('RejectedProposalsUser')) { echo RejectedProposalsUser(); } else { echo '<span class="badge badge-secondary">N/A</span>'; } ?></span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Calls Section -->
    <div class="recent-calls">
        <div class="section-header">
            <h2><i class="fas fa-bullhorn"></i> <?php echo $lang_Recent_Calls ?? 'Recent Calls'; ?></h2>
            <!-- <div class="header-actions">
                <a href="./main.php?option=AllCalls" class="btn btn-outline-primary btn-sm">View All Calls</a>
            </div> -->
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><?php echo $lang_Call ?? 'Call'; ?></th>
                        <th><?php echo $lang_Category ?? 'Category'; ?></th>
                        <th><?php echo $lang_EndDate ?? 'End Date'; ?></th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($total_pages == 0): ?>
                    <tr>
                        <td colspan="4" class="text-center"><?php echo $lang_no_results_displayed ?? 'No results to display'; ?></td>
                    </tr>
                    <?php else: ?>
                        <?php while($rFLists2 = $result->fetch_array()): ?>
                        <tr>
                            <td>
                                <strong><?php echo $rFLists2['title']; ?></strong>
                            </td>
                            <td>
                                <span class="badge <?php echo ($rFLists2['category']=='concepts') ? 'badge-primary' : 'badge-success'; ?>">
                                    <?php 
                                    if($rFLists2['category'] == 'proposals') { 
                                        echo $lang_Proposals ?? 'Proposals'; 
                                    } else { 
                                        echo $lang_Concepts ?? 'Concepts'; 
                                    } 
                                    ?>
                                </span>
                            </td>
                            <td>
                                <?php 
                                $endDate = new DateTime($rFLists2['EndDate']);
                                $today = new DateTime();
                                $interval = $today->diff($endDate);
                                $daysLeft = $interval->format('%R%a');
                                
                                if($daysLeft < 0) {
                                    echo '<span class="badge badge-danger">Expired</span>';
                                } elseif($daysLeft <= 3) {
                                    echo '<span class="badge badge-warning">' . $endDate->format('M d, Y') . ' (' . $daysLeft . ' days left)</span>';
                                } else {
                                    echo '<span class="badge badge-info">' . $endDate->format('M d, Y') . '</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if(strtotime($today->format('Y-m-d')) <= strtotime($rFLists2['EndDate'])): ?>
                                    <?php if($rFLists2['category'] == 'concepts'): ?>
                                        <a href="./main.php?option=usrCallforConcepts" class="btn btn-primary btn-sm">
                                            <i class="fas fa-info-circle"></i> <?php echo $lang_ClicktoViewDetails ?? 'View Details'; ?>
                                        </a>
                                    <?php elseif($rFLists2['category'] == 'proposals'): ?>
                                        <a href="./main.php?option=usrCallforProposals" class="btn btn-success btn-sm">
                                            <i class="fas fa-info-circle"></i> <?php echo $lang_ClicktoViewDetails ?? 'View Details'; ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($rFLists2['attachment'])): ?>
                                        <a href="./files/<?php echo $rFLists2['attachment']; ?>" class="btn btn-outline-secondary btn-sm" target="_blank">
                                            <i class="fas fa-download"></i> <?php echo $lang_new_Attachment ?? 'Download'; ?>
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge badge-secondary"><?php echo $lang_CallExpired ?? 'Call Expired'; ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($lastpage > 1): ?>
        <div class="pagination-container">
            <ul class="pagination">
                <?php if($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $baseURL; ?>&page=<?php echo $prev; ?>">
                        <i class="fas fa-chevron-left"></i> Previous
                    </a>
                </li>
                <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link"><i class="fas fa-chevron-left"></i> Previous</span>
                </li>
                <?php endif; ?>
                
                <?php
                // Display page numbers
                $start_range = max(1, $page - 2);
                $end_range = min($lastpage, $page + 2);
                
                if($start_range > 1): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo $baseURL; ?>&page=1">1</a></li>
                    <?php if($start_range > 2): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php for($i = $start_range; $i <= $end_range; $i++): ?>
                    <?php if($i == $page): ?>
                        <li class="page-item active"><span class="page-link"><?php echo $i; ?></span></li>
                    <?php else: ?>
                        <li class="page-item"><a class="page-link" href="<?php echo $baseURL; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if($end_range < $lastpage): ?>
                    <?php if($end_range < $lastpage - 1): ?>
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    <?php endif; ?>
                    <li class="page-item"><a class="page-link" href="<?php echo $baseURL; ?>&page=<?php echo $lastpage; ?>"><?php echo $lastpage; ?></a></li>
                <?php endif; ?>
                
                <?php if($page < $lastpage): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo $baseURL; ?>&page=<?php echo $next; ?>">
                        Next <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
                <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">Next <i class="fas fa-chevron-right"></i></span>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>