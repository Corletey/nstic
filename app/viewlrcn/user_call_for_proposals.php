<?php
include("viewlrcn/user_dashboard2.php");
$sql = "SELECT * FROM " . $prefix . "grantcalls WHERE category='proposals' AND publish='Yes' ORDER BY grantID DESC LIMIT 0,10";
$result = $mysqli->query($sql);
$total_pages = $result->num_rows;
$usrrsmyLoggedIdm = $_SESSION['usrm_id'];
?>
<link rel="stylesheet" href="assets/css/dashboard.css">
<!-- Call for Proposals Section -->
<div class="proposals-container">
    <div class="section-header">
        <h2><i class="fas fa-file-signature"></i> <?php echo $lang_CallforProposals ?? 'Call for Proposals'; ?></h2>
        <div class="header-actions">
            <!-- <a href="./main.php?option=AllProposalCalls" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-list"></i> <?php echo $lang_ViewAll ?? 'View All'; ?>
            </a> -->
        </div>
    </div>

    <?php if (!$total_pages) { ?>
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <h3><?php echo $lang_NoCallsAvailable ?? 'No Calls Available'; ?></h3>
            <p><?php echo $lang_NoCallsMessage ?? 'No latest calls at the moment, please check back later...'; ?></p>
        </div>
    <?php } else { ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><?php echo $lang_Title ?? 'Title'; ?></th>
                        <th><?php echo $lang_Call ?? 'Call'; ?></th>
                        <th><?php echo $lang_EndDate ?? 'End Date'; ?></th>
                        <th><?php echo $lang_Status ?? 'Status'; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rFLists2 = $result->fetch_array()) {
                        // Get the proposal ID and grant ID
                        $proposal_id = $rFLists2['grantID'];
                        $grantID = $rFLists2['grantID'];
                        
                        // Check if user has already submitted a proposal
                        $queryDistrictsMain = "SELECT * FROM " . $prefix . "submissions_proposals WHERE owner_id='$usrrsmyLoggedIdm' AND grantcallID='$proposal_id'";
                        $R_DMain = $mysqli->query($queryDistrictsMain);
                        $rFListsConcept = $R_DMain->fetch_array();
                        $totals_R = $R_DMain->num_rows;
                        
                        // Get concept information
                        $queryDistrictsMain2 = "SELECT * FROM " . $prefix . "submissions_concepts WHERE owner_id='$usrrsmyLoggedIdm' AND invited_for_proposal='invited' AND grantcallIDMain='$proposal_id' ORDER BY conceptID DESC LIMIT 0,1";
                        $R_DMain2 = $mysqli->query($queryDistrictsMain2);
                        $rFListsConcept2 = $R_DMain2->fetch_array();
                        $totalFInvited = $R_DMain2->num_rows;
                        
                        // Additional invited concepts check
                        $sqlFListsconcepts4 = "SELECT * FROM " . $prefix . "submissions_concepts WHERE invited_for_proposal='invited' AND owner_id='$sessionusrm_id' AND grantcallIDMain='$proposal_id'";
                        $QueryFListconcepts4 = $mysqli->query($sqlFListsconcepts4);
                        $totalFLconcepts4 = $QueryFListconcepts4->num_rows;
                        
                        // Get first category
                        $wGrantCategories1 = "SELECT * FROM " . $prefix . "grantcall_categories WHERE grantID='$proposal_id' ORDER BY category_number ASC LIMIT 0,1";
                        $cmGrantCategories1 = $mysqli->query($wGrantCategories1);
                        $rUGrantCategories1 = $cmGrantCategories1->fetch_array();
                        $categoryIDFirst = $rUGrantCategories1['categoryID'] ?? '';
                        
                        // Check existing proposals
                        $queryProposals = "SELECT * FROM " . $prefix . "submissions_proposals WHERE owner_id='$usrrsmyLoggedIdm' AND grantcallID='$proposal_id'";
                        $R_DProposals = $mysqli->query($queryProposals);
                        $totals_Proposals = $R_DProposals->num_rows;
                        
                        // Calculate time remaining
                        $endDate = new DateTime($rFLists2['EndDate']);
                        $today = new DateTime();
                        $interval = $today->diff($endDate);
                        $daysLeft = $interval->format('%R%a');
                        $isExpired = ($daysLeft < 0);
                    ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($rFLists2['title']); ?></strong>
                            <?php if (!$isExpired && !empty($rFLists2['attachment'])): ?>
                                <div class="mt-1">
                                    <a href="./files/<?php echo htmlspecialchars($rFLists2['attachment']); ?>" class="attachment-link" target="_blank">
                                        <i class="fas fa-paperclip"></i> <?php echo $lang_ViewAttachment ?? 'View Attachment'; ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="call-summary"><?php echo htmlspecialchars($rFLists2['summary']); ?></span>
                        </td>
                        <td>
                            <?php if($isExpired): ?>
                                <span class="badge badge-danger">
                                    <i class="fas fa-calendar-times"></i> <?php echo $lang_Expired ?? 'Expired'; ?>
                                </span>
                            <?php elseif($daysLeft <= 3): ?>
                                <span class="badge badge-warning">
                                    <i class="fas fa-exclamation-circle"></i> <?php echo $endDate->format('M d, Y'); ?>
                                    <span class="days-left">(<?php echo $daysLeft; ?> days left)</span>
                                </span>
                            <?php else: ?>
                                <span class="badge badge-info">
                                    <i class="fas fa-calendar"></i> <?php echo $endDate->format('M d, Y'); ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="proposal-actions">
                            <?php 
                            // Case 1: Invited to submit proposal based on concept
                            if (!$isExpired && 
                                ($rFLists2['dynamic'] == 'Yes' || $rFLists2['dynamic'] == 'No') && 
                                !isset($QueryTitles4) && // This variable wasn't properly defined in original code 
                                $totalFInvited && 
                                $rFLists2['includeconcept'] == 'Yes'): 
                            ?>
                                <a href="./main.php?option=newSubmitProposal&id=<?php echo $grantID; ?>&categoryID=<?php echo $categoryIDFirst; ?>&conceptID=<?php echo $rFListsConcept2['conceptID']; ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-paper-plane"></i> <?php echo $lang_ApplyNow ?? 'Apply Now'; ?>
                                </a>
                            
                            <?php 
                            // Case 2: Not invited to submit full proposal
                            elseif (($rFLists2['dynamic'] == 'Yes' || $rFLists2['dynamic'] == 'No') && 
                                !isset($QueryTitles4) && 
                                $totalFInvited == '0' && 
                                $rFLists2['includeconcept'] == 'Yes'): 
                            ?>
                                <span class="badge badge-secondary">
                                    <i class="fas fa-ban"></i> <?php echo $lang_NotInvitedtoSubmitfullProposal ?? 'Not Invited to Submit'; ?>
                                </span>
                            
                            <?php 
                            // Case 3: Direct proposal submission (no concept required)
                            elseif (!$isExpired && 
                                ($rFLists2['dynamic'] == 'Yes' || $rFLists2['dynamic'] == 'No') && 
                                !isset($QueryTitles4) && 
                                $rFLists2['includeconcept'] == 'No' && 
                                !$totals_Proposals): 
                            ?>
                                <a href="./main.php?option=newSubmitProposal&id=<?php echo $grantID; ?>&categoryID=<?php echo $categoryIDFirst; ?>&conceptID=<?php echo $rFListsConcept2['conceptID'] ?? ''; ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-paper-plane"></i> <?php echo $lang_ApplyNow ?? 'Apply Now'; ?>
                                </a>
                            
                            <?php 
                            // Case 4: Already submitted proposal (dynamic yes)
                            elseif (!$isExpired && $rFLists2['dynamic'] == 'Yes' && $totals_Proposals >= 1): 
                            ?>
                                <span class="badge badge-primary">
                                    <i class="fas fa-check-circle"></i> <?php echo $lang_Submitted ?? 'Submitted'; ?>
                                </span>
                            
                            <?php 
                            // Case 5: Already submitted (with QueryTitles4)
                            elseif (!$isExpired && $rFLists2['dynamic'] == 'Yes' && isset($QueryTitles4) && $QueryTitles4->num_rows >= 1): 
                            ?>
                                <span class="badge badge-info">
                                    <i class="fas fa-check-double"></i> <?php echo $lang_AlreadySubmitted ?? 'Already Submitted'; ?>
                                </span>
                            
                            <?php 
                            // Case 6: Already submitted (totals_R exists but not dynamic)
                            elseif (!$isExpired && $totals_R && $rFLists2['dynamic'] != 'Yes'): 
                            ?>
                                <span class="badge badge-info">
                                    <i class="fas fa-check-double"></i> <?php echo $lang_AlreadySubmitted ?? 'Already Submitted'; ?>
                                </span>
                            
                            <?php 
                            // Case 7: Pending final submission
                            elseif (!$isExpired): 
                            ?>
                                <div class="status-group">
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock"></i> <?php echo $lang_PendingFinalSubmission ?? 'Pending Final Submission'; ?>
                                    </span>
                                    
                                    <?php if (isset($rFListsConcept['conceptID']) && isset($rFListsConcept['grantcallID']) && isset($rFListsConcept['projectID'])): ?>
                                    <a href="main.php?option=newSubmitProposalUpdate&conceptID=<?php echo $rFListsConcept['conceptID']; ?>&id=<?php echo $rFListsConcept['grantcallID']; ?>&projectID=<?php echo $rFListsConcept['projectID']; ?>" class="btn btn-outline-primary btn-sm mt-2">
                                        <i class="fas fa-edit"></i> <?php echo $lang_ClicktoUpdateSubmission ?? 'Update Submission'; ?>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle"></i> <?php echo $lang_CallExpired ?? 'Call Expired'; ?>
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>