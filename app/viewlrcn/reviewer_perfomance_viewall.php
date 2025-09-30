<?php
$status = $mysqli->real_escape_string($_GET['status']);
if ($status == 'Assigned') {
  $sqlConceptLogs = "SELECT * FROM " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$id' order by assignm_date desc limit 0,500";
}
if ($status == 'Reviewed') {
  $sqlConceptLogs = "SELECT * FROM " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$id' and logm_status='completed' order by assignm_date desc limit 0,500";
}
if ($status == 'Pending') {
  $sqlConceptLogs = "SELECT * FROM " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$id' and logm_status='new' order by assignm_date desc limit 0,500";
}

// Get reviewer details
$sqlReviewer = "SELECT * FROM " . $prefix . "musers where usrm_id='$id'";
$queryReviewer = $mysqli->query($sqlReviewer);
$reviewerData = $queryReviewer->fetch_array();

// Handle email reminder submission
if(isset($_POST['sendReminder']) && !empty($_POST['conceptID']) && !empty($_POST['categoryType'])) {
  $reminderConceptID = $mysqli->real_escape_string($_POST['conceptID']);
  $reminderCategoryType = $mysqli->real_escape_string($_POST['categoryType']);
  $reminderProjectTitle = $mysqli->real_escape_string($_POST['projectTitle']);
  
  // Email reminder code
  require("viewlrcn/class.phpmailer.php");
  require("viewlrcn/class.smtp.php");

  $usmtpportNo = 
  $usmtpHost = 
  $emailUsername =
  $emailPassword = 
  $emailSSL = "ssl";
  $emailBcc = 

  // Email content
  $fromEmail = 
  $fromName = "NCRST Grant Management";
  $subject = "Reminder: Pending Review Assignment";
  
  $reviewerName = $reviewerData['usrm_fname'] . ' ' . $reviewerData['usrm_sname'];
  $reviewerEmail = $reviewerData['usrm_email'];
  $hostmain = $_SERVER['HTTP_HOST'];
  $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  
  // Build the review link based on category type
  $reviewLink = "https://{$hostmain}{$path}/main.php?option=";
  if($reminderCategoryType == 'concepts') {
    $reviewLink .= "ReviewConcept&id={$reminderConceptID}";
  } else {
    $reviewLink .= "ReviewProposal&id={$reminderConceptID}";
  }
  
  $body = "
Dear {$reviewerName},

This is a friendly reminder that you have a pending review assignment for:
\"{$reminderProjectTitle}\"

Please complete your review at your earliest convenience.

You can access the review by clicking the link below:
{$reviewLink}

Thank you for your contribution to the review process.

NCRST Grants Management System
";

  // PHPMailer settings
  $mail = new PHPMailer(true);
  $mail->IsSMTP();
  $mail->Port = $usmtpportNo;
  $mail->CharSet = "utf-8";
  $mail->Host = $usmtpHost;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = $emailSSL;
  $mail->Username = "$emailUsername";
  $mail->Password = "$emailPassword";
  $mail->SMTPDebug = 0;

  $mail->setFrom("$emailUsername", "Grants Management");
  $mail->AddAddress($reviewerEmail, $reviewerName);
  $mail->AddReplyTo("$emailUsername", "NCRST Grants Management");
  $mail->addBcc("$emailBcc", "NCRST Grants Management");

  $mail->WordWrap = 50;
  $mail->IsHTML(false);
  $mail->Subject = $subject;
  $mail->Body = $body;
  
  if($mail->Send()) {
    $reminderSuccess = true;
    $reminderMessage = "Reminder email has been sent successfully to {$reviewerName}.";
  } else {
    $reminderError = true;
    $reminderMessage = "Failed to send reminder: " . $mail->ErrorInfo;
  }
}
?>

<div class="container-fluid reviewer-details-dashboard">
  <?php if(isset($reminderSuccess) || isset($reminderError)): ?>
  <!-- Simple Alert Message Instead of Modal -->
  <div class="alert <?php echo isset($reminderSuccess) ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show mb-4" role="alert">
    <strong><?php echo isset($reminderSuccess) ? 'Success!' : 'Error!'; ?></strong> <?php echo $reminderMessage; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove()"></button>
  </div>
  <?php endif; ?>

  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <div class="reviewer-avatar me-3">
              <?php 
              $initials = strtoupper(substr($reviewerData['usrm_fname'], 0, 1) . substr($reviewerData['usrm_sname'], 0, 1));
              echo $initials;
              ?>
            </div>
            <div>
              <h4 class="m-0"><?php echo $reviewerData['usrm_fname'] . ' ' . $reviewerData['usrm_sname']; ?></h4>
              <p class="text-muted mb-0"><?php echo $reviewerData['usrm_email']; ?></p>
            </div>
          </div>
          <div class="header-actions">
            <a href="main.php?option=ReviewerPerfomance" class="btn btn-outline-primary">
              <i class="fas fa-arrow-left me-2"></i>Back to Reviewers
            </a>
          </div>
        </div>
        
        <div class="card-body p-0">
          <!-- Status Tabs -->
          <div class="status-tabs">
            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
              <a class="nav-item nav-link <?php echo ($status == 'Assigned') ? 'active' : ''; ?>" href="main.php?option=reviewerviewall&id=<?php echo $id; ?>&status=Assigned">
                <i class="fas fa-tasks me-2"></i>All Assignments
              </a>
              <a class="nav-item nav-link <?php echo ($status == 'Reviewed') ? 'active' : ''; ?>" href="main.php?option=reviewerviewall&id=<?php echo $id; ?>&status=Reviewed">
                <i class="fas fa-check-circle me-2"></i>Completed
              </a>
              <a class="nav-item nav-link <?php echo ($status == 'Pending') ? 'active' : ''; ?>" href="main.php?option=reviewerviewall&id=<?php echo $id; ?>&status=Pending">
                <i class="fas fa-clock me-2"></i>Pending
              </a>
            </div>
          </div>
          
          <!-- Status Content Container -->
          <div class="status-content p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
              <h5 class="status-title mb-0">
                <?php if ($status == 'Assigned') { ?>
                  <span class="badge bg-primary">All Assignments</span>
                <?php } elseif ($status == 'Reviewed') { ?>
                  <span class="badge bg-success">Completed Reviews</span>
                <?php } elseif ($status == 'Pending') { ?>
                  <span class="badge bg-warning">Pending Reviews</span>
                <?php } ?>
              </h5>
              
              <?php
              $QueryConcept2 = $mysqli->query($sqlConceptLogs);
              $totalFL11 = $QueryConcept2->num_rows;
              ?>
              
              <div class="status-count">
                <span class="badge bg-light text-dark">
                  Total: <?php echo $totalFL11; ?> <?php echo ($totalFL11 == 1) ? 'item' : 'items'; ?>
                </span>
              </div>
            </div>
            
            <?php if (!$totalFL11) { ?>
              <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i><?php echo $lang_no_results_displayed; ?>
              </div>
            <?php } else { ?>
              <!-- Proposals Table -->
              <div class="table-responsive">
                <table class="table table-hover border-0 align-middle">
                  <thead>
                    <tr>
                      <th width="45%"><?php echo $lang_Proposals; ?></th>
                      <th width="20%"><?php echo $lang_Date; ?></th>
                      <th width="15%"><?php echo $lang_Status; ?></th>
                      <th width="20%">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Reset pointer
                    $QueryConcept2->data_seek(0);
                    
                    while ($rFListsmain = $QueryConcept2->fetch_array()) {
                      $conceptm_idd = $rFListsmain['conceptm_id'];
                      $categorym = $rFListsmain['categorym'];
                      $reviewStatus = $rFListsmain['reviewStatus'];
                      
                      if ($categorym == 'concepts') {
                        $sqlFLists1 = "SELECT *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM " . $prefix . "submissions_concepts where conceptID='$conceptm_idd' order by conceptID desc";
                        $QueryFListsm1 = $mysqli->query($sqlFLists1);
                        $rFLists2 = $QueryFListsm1->fetch_array();
                        $conceptm_id = $rFLists2['conceptID'];
                        $projectTitle = $rFLists2['projectTitle'];
                        $dynamic = $rFLists2['dynamic'];
                        $grantcallID = $rFLists2['grantcallID'];
                        
                        // Type indicator
                        $submissionType = "Concept";
                        $typeColor = "info";
                        $viewUrl = "main.php?option=ReviewConcept&id=" . $conceptm_id;
                      }
                      
                      if ($categorym == 'proposals') {
                        $sqlFLists1 = "SELECT *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM " . $prefix . "submissions_proposals where projectID='$conceptm_idd' order by projectID desc";
                        $QueryFListsm1 = $mysqli->query($sqlFLists1);
                        $rFLists2 = $QueryFListsm1->fetch_array();
                        $conceptm_id = $rFLists2['projectID'];
                        $projectTitle = $rFLists2['projectTitle'];
                        $dynamic = $rFLists2['dynamic'];
                        $grantcallID = $rFLists2['grantcallID'];
                        
                        // Type indicator
                        $submissionType = "Proposal";
                        $typeColor = "primary";
                        $viewUrl = "main.php?option=ReviewProposal&id=" . $conceptm_id;
                      }
                      
                      $sto = $rFLists2['conceptm_assignedto'];
                      $sqlAssigned = "SELECT * FROM " . $prefix . "musers where usrm_id='$sto'";
                      $sqlAssigned = $mysqli->query($sqlAssigned);
                      $syAssigned = $sqlAssigned->fetch_array();
                      
                      $sqlFLists1Nd = "SELECT * FROM " . $prefix . "mscores_new where conceptm_id='$conceptm_id' and EvaluatedBy='$usrrsmyLoggedIdm' and categorym='$categorym'";
                      $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
                      $totalScores = $QueryFListsm1Nd->num_rows;
                      $rScore = $QueryFListsm1Nd->fetch_array();
                      
                      $sqlProps = "SELECT * FROM " . $prefix . "grantcalls where grantID='$grantcallID' order by grantID asc";
                      $QueryProps = $mysqli->query($sqlProps);
                      $rowsProps = $QueryProps->fetch_array();
                      
                      // Calculate days ago
                      $updateDate = new DateTime($rFLists2['updatedon']);
                      $today = new DateTime();
                      $interval = $updateDate->diff($today);
                      
                      if ($interval->days == 0) {
                        $daysAgo = "Today";
                      } elseif ($interval->days == 1) {
                        $daysAgo = "Yesterday";
                      } else {
                        $daysAgo = $interval->days . " days ago";
                      }
                    ?>
                      <tr>
                        <td>
                          <div class="proposal-title">
                            <span class="badge bg-<?php echo $typeColor; ?> type-badge"><?php echo $submissionType; ?></span>
                            <span class="title-text"><?php echo $projectTitle; ?></span>
                          </div>
                          <small class="text-muted">
                            Grant: <?php echo $rowsProps['title']; ?>
                          </small>
                        </td>
                        <td>
                          <div class="date-info">
                            <div class="actual-date"><?php echo $rFLists2['updatedonm']; ?></div>
                            <small class="text-muted"><?php echo $daysAgo; ?></small>
                          </div>
                        </td>
                        <td>
                          <?php if ($rFListsmain['logm_status'] == 'new') { ?>
                            <span class="badge bg-warning review-status">
                              <i class="fas fa-hourglass-half me-1"></i><?php echo $lang_PendingReview; ?>
                            </span>
                          <?php } ?>
                          
                          <?php if ($rFListsmain['logm_status'] == 'completed') { ?>
                            <span class="badge bg-success review-status">
                              <i class="fas fa-check-circle me-1"></i><?php echo $lang_ReviewCompleted; ?>
                            </span>
                          <?php } ?>
                        </td>
                        <td>
                          <div class="action-buttons">
                            <!-- <a href="<?php echo $viewUrl; ?>" class="btn btn-sm btn-primary" title="View Details">
                              <i class="fas fa-eye"></i>
                            </a> -->
                            
                            <?php if ($rFListsmain['logm_status'] == 'new') { ?>
                              <!-- Direct Email Reminder Form (No Modal) -->
                              <form method="post" action="" class="d-inline">
                                <input type="hidden" name="conceptID" value="<?php echo $conceptm_id; ?>">
                                <input type="hidden" name="categoryType" value="<?php echo $categorym; ?>">
                                <input type="hidden" name="projectTitle" value="<?php echo $projectTitle; ?>">
                                <button type="submit" name="sendReminder" class="btn btn-sm btn-warning ms-1" title="Send Email Reminder"
                                  onclick="return confirm('Send reminder email to <?php echo $reviewerData['usrm_fname'] . ' ' . $reviewerData['usrm_sname']; ?> for review of \'<?php echo $projectTitle; ?>\'?');">
                                  <i class="fas fa-envelope"></i>
                                </button>
                              </form>
                            <?php } ?>
                          </div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
/* Reviewer details dashboard styles */
.reviewer-details-dashboard {
  padding: 20px 0;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

.card {
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  border: none;
}

.card-header {
  background-color: #fff;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  padding: 1.25rem;
}

.reviewer-avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background-color: #4f46e5;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  font-weight: bold;
}

.status-tabs {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.nav-tabs {
  border-bottom: none;
}

.nav-tabs .nav-link {
  border: none;
  color: #6b7280;
  padding: 1rem 1.5rem;
  font-weight: 500;
  border-bottom: 3px solid transparent;
  transition: all 0.2s ease;
}

.nav-tabs .nav-link:hover {
  color: #4f46e5;
  border-bottom-color: #e5e7eb;
}

.nav-tabs .nav-link.active {
  color: #4f46e5;
  border-bottom-color: #4f46e5;
  background-color: transparent;
}

.status-title .badge {
  font-size: 1rem;
  padding: 0.5rem 1rem;
}

.table {
  margin-bottom: 0;
}

.table thead th {
  background-color: #f9fafb;
  color: #4b5563;
  font-weight: 600;
  font-size: 0.875rem;
  border-top: none;
  border-bottom: 2px solid #e5e7eb;
  padding: 0.75rem 1rem;
}

.table tbody td {
  padding: 1rem;
  vertical-align: middle;
  border-bottom: 1px solid #e5e7eb;
}

.proposal-title {
  display: flex;
  align-items: center;
  margin-bottom: 0.25rem;
}

.type-badge {
  font-size: 0.7rem;
  padding: 0.25rem 0.5rem;
  margin-right: 0.75rem;
}

.title-text {
  font-weight: 500;
  color: #1f2937;
}

.date-info {
  display: flex;
  flex-direction: column;
}

.actual-date {
  font-weight: 500;
}

.review-status {
  padding: 0.5rem 0.75rem;
  font-weight: 500;
}

.table-hover tbody tr:hover {
  background-color: #f9fafb;
}

.action-buttons .btn {
  padding: 0.375rem 0.5rem;
  margin-right: 0.25rem;
  transition: all 0.2s ease;
}

.action-buttons .btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.btn-warning {
  background-color: #f59e0b;
  border-color: #f59e0b;
  color: #fff;
}

.btn-warning:hover {
  background-color: #d97706;
  border-color: #d97706;
  color: #fff;
}

.alert-info {
  background-color: #eff6ff;
  border-color: #dbeafe;
  color: #1e40af;
}

.alert-success {
  background-color: #d1fae5;
  border-color: #a7f3d0;
  color: #065f46;
}

.alert-danger {
  background-color: #fee2e2;
  border-color: #fecaca;
  color: #991b1b;
}

/* Alert animation */
.alert.fade {
  opacity: 0;
  transition: opacity 0.15s linear;
}

.alert.fade.show {
  opacity: 1;
}

/* Animation */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.reviewer-details-dashboard {
  animation: fadeIn 0.5s ease-in-out;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .card-header {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .header-actions {
    margin-top: 1rem;
    align-self: flex-start;
  }
  
  .nav-tabs .nav-link {
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
  }
  
  .status-content {
    padding: 1rem !important;
  }
  
  .table thead th,
  .table tbody td {
    padding: 0.75rem 0.5rem;
    font-size: 0.875rem;
  }
  
  .proposal-title {
    flex-direction: column;
    align-items: flex-start;
  }
  
  .type-badge {
    margin-bottom: 0.5rem;
  }
  
  .action-buttons {
    display: flex;
    flex-wrap: wrap;
  }
  
  .action-buttons .btn {
    margin-bottom: 0.25rem;
  }
}
</style>