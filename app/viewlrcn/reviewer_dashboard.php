<?php
require_once("viewlrcn/reviewer_dashboard_stats.php");

$sqlConceptLogs = "SELECT * FROM " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$usrrsmyLoggedIdm' and logm_status='new' order by assignm_date desc limit 0,100";
$QueryConcept = $mysqli->query($sqlConceptLogs);
$totalFL1 = $QueryConcept->num_rows;
$queryLoggd = $QueryConcept->fetch_array();

$queryLoggd['availableReview'];

$sqlUserReview = "SELECT * FROM " . $prefix . "musers where usrm_id='$usrrsmyLoggedIdm'";
$queryUserReview = $mysqli->query($sqlUserReview);
$rReview = $queryUserReview->fetch_array();
?>

<div class="reviewer-dashboard">
  <div class="card">
    <?php if ($queryLoggd['availableReview'] == 'yes') { ?>
      <div class="card-header">
        <h4 class="card-title"><?php echo $lang_ProposalsConceptsforReview; ?></h4>
      </div>
    <?php } ?>

    <div class="card-body">
      <?php if ($queryLoggd['availableReview'] == 'yes' && $queryLoggd['conflictofInterest'] != 'No') { ?>
        <div class="alert alert-warning">
          <i class="fa fa-exclamation-triangle mr-2"></i>
          <?php echo $lang_Declaire_conflict; ?>
        </div>
      <?php } ?>

      <?php if ($queryLoggd['availableReview'] != 'yes' && $totalFL1) { ?>
        <div class="text-center my-4">
          <button type="button" class="btn btn-primary" onclick="window.open('<?php echo $base_ur; ?>undertakereview.php?id=<?php echo $usrrsmyLoggedIdm; ?>&grantID=<?php echo $queryLoggd['grantID']; ?>','popUpWindow','height=500, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');">
            <i class="fa fa-check-circle mr-2"></i><?php echo $lang_Available_to_undertake; ?>
          </button>
        </div>
      <?php } ?>

      <?php
      $sqlConceptLogs2 = "SELECT * FROM " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$usrrsmyLoggedIdm' and logm_status='new' order by assignm_date desc limit 0,20";
      $QueryConcept2 = $mysqli->query($sqlConceptLogs2);
      $totalFL11 = $QueryConcept2->num_rows;
      
      if ($queryLoggd['availableReview'] == 'yes') { 
      ?>
        <?php if (!$totalFL11) { ?>
          <div class="alert alert-info">
            <p class="mb-0"><?php echo $lang_no_results_displayed; ?></p>
          </div>
        <?php } else { ?>
          <div class="table-responsive">
            <table class="table table-hover table-striped">
              <thead>
                <tr>
                  <th width="38%"><?php echo $lang_Proposal; ?></th>
                  <th width="17%"><?php echo $lang_Date; ?></th>
                  <th width="12%"><?php echo $lang_Status; ?></th>
                  <th width="9%"><?php echo $lang_Score; ?></th>
                  <th width="11%"><?php echo $lang_Action; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
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
                  }

                  if ($categorym == 'proposals') {                              
                    $sqlFLists1 = "SELECT *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM " . $prefix . "submissions_proposals where projectID='$conceptm_idd' order by projectID desc";
                    $QueryFListsm1 = $mysqli->query($sqlFLists1);
                    $rFLists2 = $QueryFListsm1->fetch_array();
                    $conceptm_id = $rFLists2['projectID'];
                    $projectTitle = $rFLists2['projectTitle'];
                    $dynamic = $rFLists2['dynamic'];
                    $grantcallID = $rFLists2['grantcallID'];
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
                ?>
                  <tr>
                    <td data-label="<?php echo $lang_Proposal; ?>"><?php echo $projectTitle; ?></td>
                    <td data-label="<?php echo $lang_Date; ?>"><?php echo $rFLists2['updatedonm']; ?></td>
                    <td data-label="<?php echo $lang_Status; ?>">
                      <?php if ($rFListsmain['logm_status'] == 'new') { ?>
                        <span class="badge badge-warning"><?php echo $lang_PendingReview; ?></span>
                      <?php } ?>
                      <?php if ($rFListsmain['logm_status'] == 'completed') { ?>
                        <span class="badge badge-success"><?php echo $lang_ReviewCompleted; ?></span>
                      <?php } ?>
                    </td>
                    <td data-label="<?php echo $lang_Score; ?>">
                      <?php if ($totalScores) { ?>
                        <span class="score"><?php echo $rScore['EvTotalScore']; ?></span>
                      <?php } ?>
                    </td>
                    <td data-label="<?php echo $lang_Action; ?>">
                      <?php if ($rFListsmain['logm_status'] == 'completed') { ?>
                        <span class="badge badge-secondary">Completed</span>
                      <?php } ?>

                      <?php if ($categorym == 'concepts' && $rFListsmain['logm_status'] != 'completed' && $rFListsmain['conflictofInterest'] == 'No' && $dynamic == 'No' && $rowsProps['end_review'] == 'No') { ?>
                        <div class="message"><?php echo $lang_review_process_completed; ?></div>
                      <?php } ?>

                      <?php if ($categorym == 'concepts' && $rFListsmain['logm_status'] != 'completed' && $rFListsmain['conflictofInterest'] == 'No' && $dynamic == 'No' && $rowsProps['end_review'] == 'Yes') { ?>
                        <a href="./main.php?option=reviewProjectInformation&id=<?php echo $conceptm_id; ?>" class="btn btn-sm btn-primary">
                          <?php echo $lang_ClicktoReview; ?>
                        </a>
                      <?php } ?>

                      <?php if ($categorym == 'concepts' && $rFListsmain['logm_status'] != 'completed' && $rFListsmain['conflictofInterest'] == 'No' && $dynamic == 'Yes' && $rowsProps['end_review'] == 'Yes') { ?>
                        <div class="message"><?php echo $lang_review_process_completed; ?></div>
                      <?php } ?>

                      <?php if ($categorym == 'concepts' && $rFListsmain['logm_status'] != 'completed' && $rFListsmain['conflictofInterest'] == 'No' && $dynamic == 'Yes' && $rowsProps['end_review'] == 'No') { ?>
                        <a href="./main.php?option=newreviewProjectInformation&conceptID=<?php echo $conceptm_id; ?>&id=<?php echo $grantcallID; ?>" class="btn btn-sm btn-primary">
                          <?php echo $lang_ClicktoReview; ?>
                        </a>
                      <?php } ?>

                      <?php if ($categorym == 'concepts' && $rFListsmain['logm_status'] != 'completed' && ($rFListsmain['conflictofInterest'] == 'none' || $rFListsmain['conflictofInterest'] == '') && $reviewStatus == 'dynamic') { ?>
                        <a href="./main.php?option=newreviewProjectInformation&conceptID=<?php echo $conceptm_id; ?>&id=<?php echo $grantcallID; ?>" class="btn btn-sm btn-outline-primary">
                          <?php echo $lang_ClicktoViewSubmission; ?>
                        </a>
                      <?php } ?>

                      <?php if ($categorym == 'proposals' && $rFListsmain['logm_status'] != 'completed' && $rFListsmain['conflictofInterest'] == 'No' && $dynamic == 'No') { ?>
                        <a href="./main.php?option=reviewPrososal&id=<?php echo $conceptm_id; ?>" class="btn btn-sm btn-primary">
                          <?php echo $lang_ClicktoReview; ?>
                        </a>
                      <?php } ?>

                      <?php if ($categorym == 'proposals' && $rFListsmain['logm_status'] != 'completed') { ?>
                        <a href="./main.php?option=newreviewPrososal&id=<?php echo $conceptm_id; ?>&grantID=<?php echo $grantcallID; ?>" class="btn btn-sm btn-primary">
                          <?php echo $lang_ClicktoReview; ?>
                        </a>
                      <?php } ?>

                      <?php if ($rFListsmain['conflictofInterest'] != 'No') { ?>
                        <button type="button" class="btn btn-sm btn-danger" onclick="window.open('<?php echo $base_ur; ?>conflict.php?id=<?php echo $conceptm_id; ?>&categorym=<?php echo $categorym; ?>&assignm_id=<?php echo $rFListsmain['assignm_id']; ?>','popUpWindow','height=500, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');">
                          <?php echo $lang_DeclareConflictofInterest; ?>
                        </button>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        <?php } ?>
      <?php } ?>
    </div>
  </div>
</div>

<style>
  /* Reviewer dashboard styles */
  .reviewer-dashboard {
    margin-bottom: 2rem;
  }
  
  .card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #e0e0e0;
    overflow: hidden;
  }
  
  .card-header {
    padding: 1rem 1.5rem;
    background-color: #f8f9fa;
    border-bottom: 1px solid #e0e0e0;
  }
  
  .card-title {
    margin: 0;
    font-size: 1.25rem;
    color: #2c3e50;
    font-weight: 600;
  }
  
  .card-body {
    padding: 1.5rem;
  }
  
  .alert {
    padding: 1rem;
    margin-bottom: 1.5rem;
    border-radius: 4px;
    border-left: 4px solid transparent;
  }
  
  .alert-warning {
    background-color: #fff3cd;
    color: #856404;
    border-left-color: #ffc107;
  }
  
  .alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
    border-left-color: #17a2b8;
  }
  
  .table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
  }
  
  .table th {
    background-color: #f8f9fa;
    color: #2c3e50;
    font-weight: 600;
    text-align: left;
    padding: 0.75rem;
    border-bottom: 2px solid #e0e0e0;
  }
  
  .table td {
    padding: 0.75rem;
    vertical-align: middle;
    border-top: 1px solid #e0e0e0;
  }
  
  .table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.02);
  }
  
  .table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.04);
  }
  
  .badge {
    display: inline-block;
    padding: 0.35em 0.65em;
    font-size: 0.75rem;
    font-weight: 600;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
    color: white;
  }
  
  .badge-warning {
    background-color: #f39c12;
  }
  
  .badge-success {
    background-color: #2ecc71;
  }
  
  .badge-secondary {
    background-color: #7f8c8d;
  }
  
  .btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: all 0.15s ease-in-out;
    cursor: pointer;
  }
  
  .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    border-radius: 0.2rem;
  }
  
  .btn-primary {
    color: #fff;
    background-color: #3498db;
    border-color: #3498db;
  }
  
  .btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
  }
  
  .btn-outline-primary {
    color: #3498db;
    background-color: transparent;
    border-color: #3498db;
  }
  
  .btn-outline-primary:hover {
    color: #fff;
    background-color: #3498db;
    border-color: #3498db;
  }
  
  .btn-danger {
    color: #fff;
    background-color: #e74c3c;
    border-color: #e74c3c;
  }
  
  .btn-danger:hover {
    background-color: #c0392b;
    border-color: #c0392b;
  }
  
  .score {
    font-size: 1rem;
    font-weight: 600;
    color: #2ecc71;
  }
  
  .message {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-style: italic;
  }
  
  /* Responsive styles for tables */
  @media (max-width: 992px) {
    .table thead {
      display: none;
    }
    
    .table tr {
      display: block;
      margin-bottom: 1rem;
      border: 1px solid #e0e0e0;
      border-radius: 4px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    .table td {
      display: block;
      text-align: right;
      border-top: none;
      border-bottom: 1px solid #e0e0e0;
      position: relative;
      padding-left: 50%;
    }
    
    .table td:last-child {
      border-bottom: none;
    }
    
    .table td::before {
      content: attr(data-label);
      position: absolute;
      left: 0.75rem;
      width: 45%;
      padding-right: 10px;
      text-align: left;
      font-weight: 600;
    }
  }
</style>