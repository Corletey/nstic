<?php
$sqlConceptLogs = "SELECT * FROM " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$usrrsmyLoggedIdm' and logm_status='completed' and categorym='proposals' order by assignm_date desc limit 0,20";
$QueryConcept = $mysqli->query($sqlConceptLogs);
$totalFL1 = $QueryConcept->num_rows;
?>

<div class="complete-proposals-container">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"><?php echo $lang_CompleteProposals; ?></h4>
    </div>
    <div class="card-body">
      <?php if (!$totalFL1) { ?>
        <div class="alert alert-info">
          <p class="mb-0"><?php echo $lang_no_results_displayed; ?></p>
        </div>
      <?php } else { ?>
        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead>
              <tr>
                <th width="38%"><?php echo $lang_Concept; ?></th>
                <th width="17%"><?php echo $lang_Date; ?></th>
                <th width="12%"><?php echo $lang_Status; ?></th>
                <th width="9%"><?php echo $lang_Score; ?></th>
                <th width="11%"><?php echo $lang_Action; ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($rFListsmain = $QueryConcept->fetch_array()) {
                $conceptm_idd = $rFListsmain['conceptm_id'];
                // Get submissions proposals
                $sqlFLists1 = "SELECT *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM " . $prefix . "submissions_proposals where projectID='$conceptm_idd' order by projectID desc";
                $QueryFListsm1 = $mysqli->query($sqlFLists1);
                $rFLists2 = $QueryFListsm1->fetch_array();

                $sto = $rFLists2['conceptm_assignedto'];
                $sqlAssigned = "SELECT * FROM " . $prefix . "musers where usrm_id='$sto'";
                $sqlAssigned = $mysqli->query($sqlAssigned);
                $syAssigned = $sqlAssigned->fetch_array();

                $conceptm_id = $rFLists2['projectID'];
                $sqlFLists1Nd = "SELECT * FROM " . $prefix . "mscores_new where conceptm_id='$conceptm_id' and EvaluatedBy='$usrrsmyLoggedIdm' and categorym='proposals'";
                $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
                $totalScores = $QueryFListsm1Nd->num_rows;
                $rScore = $QueryFListsm1Nd->fetch_array();
              ?>
                <tr>
                  <td data-label="<?php echo $lang_Concept; ?>"><?php echo $rFLists2['projectTitle']; ?></td>
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
                      <div class="score-container">
                        <span class="score-value"><?php echo $rScore['EvTotalScore']; ?>%</span>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="window.open('scoresheet.php?id=<?php echo base64_encode($rScore['EvaluatedBy']); ?>&ds=<?php echo base64_encode($rScore['scoredmID']); ?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');">
                          <i class="fa fa-eye mr-1"></i>View Score
                        </button>
                      </div>
                    <?php } ?>
                  </td>
                  <td data-label="<?php echo $lang_Action; ?>">
                    <?php if ($rFListsmain['logm_status'] != 'completed' && $rFListsmain['conflictofInterest'] == 'No') { ?>
                      <a href="./main.php?option=reviewPrososal&id=<?php echo $rFLists2['projectID']; ?>" class="btn btn-sm btn-primary">
                        <i class="fa fa-edit mr-1"></i>Click to Review
                      </a>
                    <?php } ?>
                    <?php if ($rFListsmain['logm_status'] == 'completed') { ?>
                      <span class="badge badge-secondary">Completed</span>
                    <?php } ?>
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

<style>
  /* Complete Proposals styles */
  .complete-proposals-container {
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
  
  .score-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
  }
  
  .score-value {
    font-size: 1rem;
    font-weight: 600;
    color: #2ecc71;
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
    
    .score-container {
      justify-content: flex-end;
    }
  }
</style>