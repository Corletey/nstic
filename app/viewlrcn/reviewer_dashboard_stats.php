<?php
$sqlConceptLogs = "SELECT * FROM " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$usrrsmyLoggedIdm' and logm_status='new' order by assignm_date desc limit 0,20";
$QueryConcept = $mysqli->query($sqlConceptLogs);
$rReview = $QueryConcept->fetch_array();
?>

<div class="dashboard-stats-container">
  <div class="row">
    <!-- Concepts Statistics Card -->
    <div class="col-md-6 mb-4">
      <div class="stats-card">
        <div class="stats-card-header">
          <h5>
            <i class="fa fa-file-alt mr-2"></i><?php echo $lang_Concepts; ?>
            <a href="./main.php?option=CompleteConceptsReviewer" class="total-badge"><?php TotalSubmittedConceptsReviewer(); ?></a>
          </h5>
        </div>
        <div class="stats-card-body">
          <div class="stat-item">
            <div class="stat-label">
              <i class="fa fa-hourglass-half text-warning mr-2"></i><?php echo $lang_Pending; ?>:
            </div>
            <div class="stat-value">
              <a href="./main.php?option=PendingConceptsReviewer" class="pending-link">
                <?php DraftConceptsReviewer(); ?>
              </a>
            </div>
          </div>
          
          <div class="stat-item">
            <div class="stat-label">
              <i class="fa fa-check-circle text-success mr-2"></i><?php echo $lang_Reviewed; ?>:
            </div>
            <div class="stat-value">
              <a href="./main.php?option=CompleteConceptsReviewer" class="completed-link">
                <?php CompletedConceptsReviewer(); ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Proposals Statistics Card -->
    <div class="col-md-6 mb-4">
      <div class="stats-card">
        <div class="stats-card-header">
          <h5>
            <i class="fa fa-file-contract mr-2"></i><?php echo $lang_Proposals; ?>
            <a href="./main.php?option=ReviewerallProposals" class="total-badge"><?php TotalSubmittedProposalsReviewer(); ?></a>
          </h5>
        </div>
        <div class="stats-card-body">
          <div class="stat-item">
            <div class="stat-label">
              <i class="fa fa-hourglass-half text-warning mr-2"></i><?php echo $lang_Pending; ?>:
            </div>
            <div class="stat-value">
              <a href="./main.php?option=PendingProposalReviewer" class="pending-link">
                <?php DraftProposalsReviewer(); ?>
              </a>
            </div>
          </div>
          
          <div class="stat-item">
            <div class="stat-label">
              <i class="fa fa-check-circle text-success mr-2"></i><?php echo $lang_Reviewed; ?>:
            </div>
            <div class="stat-value">
              <a href="./main.php?option=CompleteProposalReviewer" class="completed-link">
                <?php PendingReviewProposalsReviewer(); ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .dashboard-stats-container {
    margin-bottom: 2rem;
  }
  
  .stats-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    height: 100%;
    transition: transform 0.2s, box-shadow 0.2s;
    border: 1px solid rgba(0, 0, 0, 0.08);
    overflow: hidden;
  }
  
  .stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }
  
  .stats-card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    padding: 1rem 1.25rem;
  }
  
  .stats-card-header h5 {
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.1rem;
  }
  
  .stats-card-body {
    padding: 1.25rem;
  }
  
  .stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  }
  
  .stat-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
  }
  
  .stat-label {
    color: #6c757d;
    font-weight: 500;
    display: flex;
    align-items: center;
  }
  
  .stat-value {
    font-weight: 600;
    font-size: 1.1rem;
  }
  
  .total-badge {
    background-color: #3498db;
    color: white;
    padding: 0.25rem 0.6rem;
    border-radius: 20px;
    font-size: 0.9rem;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.2s;
  }
  
  .total-badge:hover {
    background-color: #2980b9;
    color: white;
    text-decoration: none;
  }
  
  .pending-link, .completed-link {
    color: #333;
    text-decoration: none;
    transition: color 0.2s;
    font-weight: 600;
  }
  
  .pending-link:hover {
    color: #f39c12;
    text-decoration: none;
  }
  
  .completed-link:hover {
    color: #2ecc71;
    text-decoration: none;
  }
  
  /* Responsive adjustments */
  @media (max-width: 767px) {
    .stat-item {
      flex-direction: column;
      align-items: flex-start;
    }
    
    .stat-value {
      margin-top: 0.5rem;
      margin-left: 1.5rem;
    }
  }
</style>