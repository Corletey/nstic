<?php
$sqlConceptLogs = "SELECT * FROM " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$usrrsmyLoggedIdm' and logm_status='new' and categorym='proposals' order by assignm_date desc limit 0,20";
$QueryConcept = $mysqli->query($sqlConceptLogs);
$totalFL1 = $QueryConcept->num_rows;
?>

<div class="proposals-container">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"><?php echo $lang_Proposal; ?> <?php echo $lang_PendingReview; ?></h4>
    </div>
    <div class="card-body">
      <?php if (!$totalFL1) { ?>
        <div class="alert alert-info">
          <p><?php echo $lang_no_results_displayed; ?></p>
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

                $conceptm_id = $rFLists2['conceptID'];
                $sqlFLists1Nd = "SELECT * FROM " . $prefix . "mscores_new where conceptm_id='$conceptm_id' and EvaluatedBy='$usrrsmyLoggedIdm' and categorym='proposals'";
                $QueryFListsm1Nd = $mysqli->query($sqlFLists1Nd);
                $totalScores = $QueryFListsm1Nd->num_rows;
                $rScore = $QueryFListsm1Nd->fetch_array();
              ?>
                <tr>
                  <td data-label="<?php echo $lang_Proposal; ?>"><?php echo $rFLists2['projectTitle']; ?></td>
                  <td data-label="<?php echo $lang_Date; ?>"><?php echo $rFLists2['updatedonm']; ?></td>
                  <td data-label="<?php echo $lang_Status; ?>">
                    <?php if ($rFListsmain['logm_status'] == 'new') { ?>
                      <span class="badge bg-warning"><?php echo $lang_PendingReview; ?></span>
                    <?php } ?>
                    <?php if ($rFListsmain['logm_status'] == 'completed') { ?>
                      <span class="badge bg-success"><?php echo $lang_ReviewCompleted; ?></span>
                    <?php } ?>
                  </td>
                  <td data-label="<?php echo $lang_Score; ?>">
                    <?php if ($totalScores) { ?>
                      <strong class="text-success"><?php echo $rScore['EvTotalScore']; ?></strong>
                    <?php } ?>
                  </td>
                  <td data-label="<?php echo $lang_Action; ?>">
                    <?php if ($rFListsmain['logm_status'] == 'completed') { ?>
                      <button class="btn btn-sm btn-secondary" disabled>Completed</button>
                    <?php } ?>

                    <?php if ($rFListsmain['logm_status'] != 'completed' && $rFListsmain['conflictofInterest'] == 'No') { ?>
                      <a href="./main.php?option=reviewPrososal&id=<?php echo $rFLists2['projectID']; ?>" class="btn btn-sm btn-primary">Review</a>
                    <?php } ?>

                    <?php if ($rFListsmain['conflictofInterest'] == 'none') { ?>
                      <button type="button" class="btn btn-sm btn-danger" onclick="window.open('<?php echo $base_ur; ?>conflict.php?id=<?php echo $conceptm_id; ?>&categorym=<?php echo $categorym; ?>&assignm_id=<?php echo $rFListsmain['assignm_id']; ?>','popUpWindow','height=500, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');">
                        Declare Conflict
                      </button>
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

<!-- CSS for the responsive table -->
<style>
:root {
  --primary-color: #3498db;
  --success-color: #2ecc71;
  --warning-color: #f39c12;
  --danger-color: #e74c3c;
  --text-color: #333;
  --border-color: #e0e0e0;
  --card-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.proposals-container {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin-bottom: 2rem;
  color: var(--text-color);
}

.card {
  border-radius: 8px;
  box-shadow: var(--card-shadow);
  background-color: #fff;
  overflow: hidden;
  border: 1px solid var(--border-color);
}

.card-header {
  padding: 1rem 1.5rem;
  background-color: #f8f9fa;
  border-bottom: 1px solid var(--border-color);
}

.card-title {
  margin: 0;
  font-size: 1.25rem;
  color: #2c3e50;
}

.card-body {
  padding: 1.5rem;
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
  border-bottom: 2px solid var(--border-color);
}

.table td {
  padding: 0.75rem;
  vertical-align: middle;
  border-top: 1px solid var(--border-color);
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.02);
}

.table-hover tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.04);
}

.badge {
  display: inline-block;
  padding: 0.25em 0.6em;
  font-size: 0.75rem;
  font-weight: 600;
  line-height: 1;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: 0.25rem;
  color: white;
}

.bg-warning {
  background-color: var(--warning-color);
}

.bg-success {
  background-color: var(--success-color);
}

.text-success {
  color: var(--success-color);
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
  background-color: var(--primary-color);
  border-color: var(--primary-color);
}

.btn-primary:hover {
  background-color: #2980b9;
  border-color: #2980b9;
}

.btn-secondary {
  color: #fff;
  background-color: #7f8c8d;
  border-color: #7f8c8d;
}

.btn-danger {
  color: #fff;
  background-color: var(--danger-color);
  border-color: var(--danger-color);
}

.btn-danger:hover {
  background-color: #c0392b;
  border-color: #c0392b;
}

.alert {
  position: relative;
  padding: 0.75rem 1.25rem;
  margin-bottom: 1rem;
  border: 1px solid transparent;
  border-radius: 0.25rem;
}

.alert-info {
  color: #0c5460;
  background-color: #d1ecf1;
  border-color: #bee5eb;
}

/* Responsive styles for tables */
@media (max-width: 992px) {
  .table thead {
    display: none;
  }
  
  .table tr {
    display: block;
    margin-bottom: 1rem;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }
  
  .table td {
    display: block;
    text-align: right;
    border-top: none;
    border-bottom: 1px solid var(--border-color);
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