<?php
// Query for proposals
$sql = "select * FROM " . $prefix . "submissions_proposals where owner_id='$usrm_id' and awarded='Yes' order by projectID desc limit 0,100";
$result = $mysqli->query($sql);
$proposals_count = $result->num_rows;

// Query for concepts
$sqlConcepts = "select * FROM " . $prefix . "submissions_concepts where owner_id='$usrm_id' and awarded='Yes' order by conceptID desc limit 0,100";
$resultConcepts = $mysqli->query($sqlConcepts);
$concepts_count = $resultConcepts->num_rows;

$total_grants = $proposals_count + $concepts_count;
?>

<div class="awarded-grants-container">
  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="card-title"><?php echo $lang_MySubmissions; ?></h4>
        <span class="badge badge-primary"><?php echo $total_grants; ?> <?php echo $total_grants == 1 ? 'Grant' : 'Grants'; ?></span>
      </div>
    </div>
    
    <div class="card-body">
      <?php if ($total_grants == 0) { ?>
        <div class="alert alert-info">
          <i class="fa fa-info-circle mr-2"></i> You don't have any awarded grants yet.
        </div>
      <?php } else { ?>
      
        <!-- Proposals Section -->
        <?php if ($proposals_count > 0) { ?>
          <h5 class="section-title">Awarded Proposals</h5>
          <div class="table-responsive">
            <table class="table table-hover grants-table">
              <thead>
                <tr>
                  <th><?php echo $lang_Title; ?></th>
                  <th class="text-center"><?php echo $lang_Action; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php while ($rFLists2 = $result->fetch_array()) {
                  $owner_id = $rFLists2['owner_id'];
                  $projectID = $rFLists2['projectID'];
                  $conceptID = $rFLists2['conceptID'];
                  $grantcallID = $rFLists2['grantcallID'];
                  $projectStatus = $rFLists2['projectStatus'];
                  $dynamic = $rFLists2['dynamic'];
                ?>
                  <tr>
                    <td data-label="<?php echo $lang_Title; ?>">
                      <div class="grant-info">
                        <h6 class="grant-title"><?php echo $rFLists2['projectTitle']; ?></h6>
                        <span class="reference-number">RefNo: <strong><?php echo $rFLists2['referenceNo']; ?></strong></span>
                      </div>
                    </td>
                    <td data-label="<?php echo $lang_Action; ?>" class="action-cell">
                      <?php if ($rFLists2['awarded'] == 'Yes' && $rFLists2['TermsConditions'] == 'No') { ?>
                        <button class="btn btn-purple" onclick="window.open('terms_and_conditions.php?id=<?php echo base64_encode($projectID); ?>&categorym=proposals&owner_id=<?php echo $rFLists2['owner_id']; ?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');" title="<?php echo $lang_Grant_awarded_toyou; ?>">
                          <i class="fa fa-handshake mr-1"></i> <?php echo $lang_GrantAwardedclicktoAccept; ?>
                        </button>
                      <?php } ?>

                      <?php if ($rFLists2['awarded'] == 'Yes' && $rFLists2['TermsConditions'] == 'Yes') { ?>
                        <div class="action-buttons">
                          <a href="./main.php?option=urRequestforFunds&id=<?php echo $rFLists2['projectID']; ?>&grantID=<?php echo $rFLists2['grantcallID']; ?>" class="btn btn-primary">
                            <i class="fa fa-dollar-sign mr-1"></i> <?php echo $lang_RequestforFunds; ?>
                          </a>
                          <a href="./main.php?option=RequestforProcurement&id=<?php echo $rFLists2['projectID']; ?>&grantID=<?php echo $rFLists2['grantcallID']; ?>" class="btn btn-secondary">
                            <i class="fa fa-shopping-cart mr-1"></i> <?php echo $lang_RequestforProcurement; ?>
                          </a>
                        </div>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        <?php } ?>
        
        <!-- Concepts Section -->
        <?php if ($concepts_count > 0) { ?>
          <?php if ($proposals_count > 0) { ?>
            <hr class="section-divider">
          <?php } ?>
          
          <h5 class="section-title">Awarded Concepts</h5>
          <div class="table-responsive">
            <table class="table table-hover grants-table">
              <thead>
                <tr>
                  <th><?php echo $lang_Title; ?></th>
                  <th class="text-center"><?php echo $lang_Action; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php while ($rFLists2 = $resultConcepts->fetch_array()) {
                  $owner_id = $rFLists2['owner_id'];
                  $conceptID = $rFLists2['projectID']; // Using projectID as in original code
                  $grantcallID = $rFLists2['grantcallID'];
                  $projectStatus = $rFLists2['projectStatus'];
                  $dynamic = $rFLists2['dynamic'];
                ?>
                  <tr>
                    <td data-label="<?php echo $lang_Title; ?>">
                      <div class="grant-info">
                        <h6 class="grant-title"><?php echo $rFLists2['projectTitle']; ?></h6>
                        <span class="reference-number">RefNo: <strong><?php echo $rFLists2['referenceNo']; ?></strong></span>
                      </div>
                    </td>
                    <td data-label="<?php echo $lang_Action; ?>" class="action-cell">
                      <?php if ($rFLists2['awarded'] == 'Yes' && $rFLists2['TermsConditions'] == 'No') { ?>
                        <button class="btn btn-purple" onclick="window.open('terms_and_conditions.php?id=<?php echo base64_encode($projectID); ?>&categorym=proposals&owner_id=<?php echo $rFLists2['owner_id']; ?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');" title="<?php echo $lang_Grant_awarded_toyou; ?>">
                          <i class="fa fa-handshake mr-1"></i> <?php echo $lang_GrantAwardedclicktoAccept; ?>
                        </button>
                      <?php } ?>

                      <?php if ($rFLists2['awarded'] == 'Yes' && $rFLists2['TermsConditions'] == 'Yes') { ?>
                        <div class="action-buttons">
                          <a href="./main.php?option=urRequestforFunds&id=<?php echo $rFLists2['projectID']; ?>&grantID=<?php echo $rFLists2['grantcallID']; ?>" class="btn btn-primary">
                            <i class="fa fa-dollar-sign mr-1"></i> <?php echo $lang_RequestforFunds; ?>
                          </a>
                          <a href="./main.php?option=RequestforProcurement&id=<?php echo $rFLists2['projectID']; ?>&grantID=<?php echo $rFLists2['grantcallID']; ?>" class="btn btn-secondary">
                            <i class="fa fa-shopping-cart mr-1"></i> <?php echo $lang_RequestforProcurement; ?>
                          </a>
                        </div>
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
  /* Awarded Grants Styles */
  .awarded-grants-container {
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
  
  .badge-primary {
    background-color: #3498db;
    color: white;
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
    border-radius: 20px;
  }
  
  .card-body {
    padding: 1.5rem;
  }
  
  .section-title {
    color: #2c3e50;
    font-size: 1.1rem;
    margin-bottom: 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
  }
  
  .section-title::after {
    content: "";
    flex: 1;
    height: 1px;
    background-color: #e0e0e0;
    margin-left: 1rem;
  }
  
  .section-divider {
    margin: 1.5rem 0;
    border-top: 1px solid #e0e0e0;
  }
  
  .table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
  }
  
  .grants-table th {
    background-color: #f8f9fa;
    color: #2c3e50;
    font-weight: 600;
    text-align: left;
    padding: 0.75rem;
    border-bottom: 2px solid #e0e0e0;
  }
  
  .grants-table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
    border-top: 1px solid #e0e0e0;
  }
  
  .grants-table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.03);
  }
  
  .grant-info {
    display: flex;
    flex-direction: column;
  }
  
  .grant-title {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
  }
  
  .reference-number {
    font-size: 0.875rem;
    color: #7f8c8d;
  }
  
  .action-cell {
    text-align: center;
  }
  
  .action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
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
  
  .btn-primary {
    color: #fff;
    background-color: #3498db;
    border-color: #3498db;
  }
  
  .btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
  }
  
  .btn-secondary {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
  }
  
  .btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
  }
  
  .btn-purple {
    color: #fff;
    background-color: #8e44ad;
    border-color: #8e44ad;
  }
  
  .btn-purple:hover {
    background-color: #7d3c98;
    border-color: #7d3c98;
  }
  
  .alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 4px;
    border-left: 4px solid transparent;
  }
  
  .alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
    border-left-color: #17a2b8;
  }
  
  /* For better display on mobile */
  @media (max-width: 767.98px) {
    .grants-table thead {
      display: none;
    }
    
    .grants-table tbody tr {
      display: block;
      border: 1px solid #e0e0e0;
      border-radius: 4px;
      margin-bottom: 1rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    
    .grants-table td {
      display: block;
      text-align: right;
      padding: 0.75rem;
      position: relative;
      border-bottom: 1px solid #e0e0e0;
    }
    
    .grants-table td:last-child {
      border-bottom: none;
    }
    
    .grants-table td::before {
      content: attr(data-label);
      position: absolute;
      left: 0.75rem;
      top: 50%;
      transform: translateY(-50%);
      font-weight: 600;
      color: #2c3e50;
    }
    
    .grant-info {
      text-align: left;
      padding-left: 6rem;
    }
    
    .action-cell {
      text-align: center;
      padding-left: 0.75rem !important;
    }
    
    .action-cell::before {
      content: none !important;
    }
    
    .action-buttons {
      justify-content: center;
    }
  }
  
  @media (max-width: 575.98px) {
    .action-buttons {
      flex-direction: column;
      align-items: stretch;
    }
    
    .btn {
      margin-bottom: 0.5rem;
    }
  }
  
  /* Utilities */
  .d-flex {
    display: flex !important;
  }
  
  .justify-content-between {
    justify-content: space-between !important;
  }
  
  .align-items-center {
    align-items: center !important;
  }
  
  .text-center {
    text-align: center !important;
  }
  
  .mr-1 {
    margin-right: 0.25rem !important;
  }
  
  .mr-2 {
    margin-right: 0.5rem !important;
  }
</style>