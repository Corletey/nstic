<!-- Modern Proposal Analytics Dashboard -->
<div class="container-fluid dashboard-container">
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header bg-primary text-white">
          <h4 class="m-0"><?php echo $lang_ProposalAnalytics; ?></h4>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="export-button">
              <a href="exportproposalanalytics.php" class="btn btn-success">
                <i class="fas fa-file-export me-2"></i><?php echo $lang_ExportResults; ?>
              </a>
            </div>
            <div class="view-options">
              <button class="btn btn-outline-primary btn-sm active" id="table-view-btn">
                <i class="fas fa-table me-1"></i>Table View
              </button>
              <button class="btn btn-outline-primary btn-sm" id="chart-view-btn">
                <i class="fas fa-chart-bar me-1"></i>Chart View
              </button>
            </div>
          </div>

          <!-- Table View Section -->
          <div id="table-view" class="analytics-view">
            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead class="table-dark">
                  <tr>
                    <th><?php echo $lang_Call; ?></th>
                    <th><?php echo $lang_TotalSubmissions; ?></th>
                    <th><?php echo $lang_Gender; ?></th>
                    <th>By <?php echo $lang_Category; ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlGroupTotalCOncepts = "SELECT * FROM " . $prefix . "grantcalls where category='proposals' and publish='Yes' order by grantID desc";
                  $sqlFGrpDisCTotalCOncepts = $mysqli->query($sqlGroupTotalCOncepts);
                  $TotalCOncepts = $sqlFGrpDisCTotalCOncepts->num_rows;
                  while ($rFLists2 = $sqlFGrpDisCTotalCOncepts->fetch_array()) {
                    // grantID submissions_concepts
                    $grantID = $rFLists2['grantID'];
                    // Get all concept submissions
                    $sqlConcepts = "SELECT * FROM " . $prefix . "submissions_proposals where grantcallID='$grantID' order by conceptID desc";
                    $queryConcepts = $mysqli->query($sqlConcepts);
                    $TotalC_submitted = $queryConcepts->num_rows;
                    while ($rows_submissions = $queryConcepts->fetch_array()) {
                      $owner_id = $rows_submissions['owner_id'];
                      $conceptID = $rows_submissions['conceptID'];
                      // submissions by Gender
                      $sqlGender_log = "SELECT * FROM " . $prefix . "user_grantids where owner_id='$owner_id' and grantID='$grantID' and conceptID='$conceptID' and categorym='proposal' order by id desc";
                      $queryGender_log = $mysqli->query($sqlGender_log);
                      $TotalCLog = $queryGender_log->num_rows;

                      if (!$TotalCLog && $owner_id) {
                        $sqlGenderLog = "SELECT * FROM " . $prefix . "musers where usrm_id='$owner_id' order by usrm_id desc";
                        $queryGenderLog = $mysqli->query($sqlGenderLog);
                        $rows_GenderLog = $queryGenderLog->fetch_array();
                        $usrm_gender = $rows_GenderLog['usrm_gender'];
                        // Add to user_grantids Table
                        $sqlA4s = "INSERT INTO " . $prefix . "user_grantids (grantID,owner_id,gender,conceptID,categorym) VALUES('$grantID','$owner_id','$usrm_gender','$conceptID','proposal')";
                        $mysqli->query($sqlA4s);
                      }
                    }

                    // Women
                    $sqlGenderw = "SELECT * FROM " . $prefix . "user_grantids where gender='Female' and grantID='$grantID' and categorym='proposal' order by id desc";
                    $queryGenderw = $mysqli->query($sqlGenderw);
                    $TotalC_Female = $queryGenderw->num_rows;

                    $sqlGenderMale = "SELECT * FROM " . $prefix . "user_grantids where gender='Male' and grantID='$grantID' and categorym='proposal' order by id desc";
                    $queryGenderMale = $mysqli->query($sqlGenderMale);
                    $TotalC_Male = $queryGenderMale->num_rows;
                  ?>
                    <tr>
                      <td>
                        <div class="fw-bold"><?php echo $rFLists2['title']; ?></div>
                        <small class="text-muted"><?php echo substr($rFLists2['shortacronym'], 0, 30); ?></small>
                      </td>
                      <td>
                        <span class="badge bg-primary fs-6"><?php echo $TotalC_submitted; ?></span>
                      </td>
                      <td>
                        <div class="d-flex flex-column">
                          <div class="mb-2">
                            <span class="text-primary"><?php echo $lang_male; ?>:</span> 
                            <span class="badge bg-info"><?php echo $TotalC_Male; ?></span>
                          </div>
                          <div>
                            <span class="text-primary"><?php echo $lang_female; ?>:</span> 
                            <span class="badge bg-danger"><?php echo $TotalC_Female; ?></span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <div class="category-breakdown">
                          <?php
                          $sqlCat = "SELECT * FROM " . $prefix . "categories order by rstug_categoryName asc";
                          $queryCat = $mysqli->query($sqlCat);
                          while ($rCat = $queryCat->fetch_array()) {
                            $rstug_categoryID = $rCat['rstug_categoryID'];

                            $sqlConcepts2 = "SELECT * FROM " . $prefix . "submissions_proposals where researchTypeID='$rstug_categoryID' and grantcallID='$grantID' order by conceptID desc";
                            $queryConcepts2 = $mysqli->query($sqlConcepts2);
                            $TotalC_submitted2 = $queryConcepts2->num_rows;

                            if ($TotalC_submitted2 > 0) {
                              $categoryName = '';
                              if ($base_lang == 'en') {
                                $categoryName = $rCat['rstug_categoryName'];
                              } elseif ($base_lang == 'fr') {
                                $categoryName = $rCat['rstug_categoryName_fr'];
                              } elseif ($base_lang == 'pt') {
                                $categoryName = $rCat['rstug_categoryName_pt'];
                              }
                              echo '<div class="mb-1">';
                              echo '<span class="category-name">' . $categoryName . ':</span> ';
                              echo '<span class="badge bg-secondary">' . $TotalC_submitted2 . '</span>';
                              echo '</div>';
                            }
                          } 
                          ?>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Chart View Section -->
          <div id="chart-view" class="analytics-view" style="display: none;">
            <div class="row">
              <?php
              $sqlGroupTotalCOncepts = "SELECT * FROM " . $prefix . "grantcalls where category='proposals' and publish='Yes' order by grantID desc";
              $sqlFGrpDisCTotalCOncepts = $mysqli->query($sqlGroupTotalCOncepts);
              while ($rFLists2 = $sqlFGrpDisCTotalCOncepts->fetch_array()) {
                $grantID = $rFLists2['grantID'];
                
                // Get total submissions
                $sqlConcepts = "SELECT * FROM " . $prefix . "submissions_proposals where grantcallID='$grantID' order by conceptID desc";
                $queryConcepts = $mysqli->query($sqlConcepts);
                $TotalC_submitted = $queryConcepts->num_rows;
                
                // Get gender breakdown
                $sqlGenderw = "SELECT * FROM " . $prefix . "user_grantids where gender='Female' and grantID='$grantID' and categorym='proposal' order by id desc";
                $queryGenderw = $mysqli->query($sqlGenderw);
                $TotalC_Female = $queryGenderw->num_rows;

                $sqlGenderMale = "SELECT * FROM " . $prefix . "user_grantids where gender='Male' and grantID='$grantID' and categorym='proposal' order by id desc";
                $queryGenderMale = $mysqli->query($sqlGenderMale);
                $TotalC_Male = $queryGenderMale->num_rows;
                
                // Only display charts for grants with submissions
                if ($TotalC_submitted > 0) {
              ?>
                <div class="col-md-6 mb-4">
                  <div class="card shadow-sm h-100">
                    <div class="card-header bg-light">
                      <h5 class="card-title"><?php echo $rFLists2['title']; ?></h5>
                      <span class="text-muted"><?php echo $lang_TotalSubmissions; ?>: <?php echo $TotalC_submitted; ?></span>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="chart-container" style="position: relative; height:200px; width:100%">
                            <canvas id="genderChart<?php echo $grantID; ?>"></canvas>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="chart-container" style="position: relative; height:200px; width:100%">
                            <canvas id="categoryChart<?php echo $grantID; ?>"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    // Gender breakdown chart
                    const genderCtx<?php echo $grantID; ?> = document.getElementById('genderChart<?php echo $grantID; ?>').getContext('2d');
                    const genderChart<?php echo $grantID; ?> = new Chart(genderCtx<?php echo $grantID; ?>, {
                      type: 'doughnut',
                      data: {
                        labels: ['<?php echo $lang_male; ?>', '<?php echo $lang_female; ?>'],
                        datasets: [{
                          data: [<?php echo $TotalC_Male; ?>, <?php echo $TotalC_Female; ?>],
                          backgroundColor: ['#36a2eb', '#ff6384'],
                          hoverOffset: 4
                        }]
                      },
                      options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                          legend: {
                            position: 'bottom',
                          },
                          title: {
                            display: true,
                            text: '<?php echo $lang_Gender; ?> Distribution'
                          }
                        }
                      }
                    });
                    
                    // Category breakdown chart
                    const categoryCtx<?php echo $grantID; ?> = document.getElementById('categoryChart<?php echo $grantID; ?>').getContext('2d');
                    const categoryChart<?php echo $grantID; ?> = new Chart(categoryCtx<?php echo $grantID; ?>, {
                      type: 'bar',
                      data: {
                        labels: [
                          <?php
                          $sqlCat = "SELECT * FROM " . $prefix . "categories order by rstug_categoryName asc";
                          $queryCat = $mysqli->query($sqlCat);
                          $categoryLabels = [];
                          $categoryData = [];
                          
                          while ($rCat = $queryCat->fetch_array()) {
                            $rstug_categoryID = $rCat['rstug_categoryID'];
                            
                            $sqlConcepts2 = "SELECT * FROM " . $prefix . "submissions_proposals where researchTypeID='$rstug_categoryID' and grantcallID='$grantID' order by conceptID desc";
                            $queryConcepts2 = $mysqli->query($sqlConcepts2);
                            $TotalC_submitted2 = $queryConcepts2->num_rows;
                            
                            if ($TotalC_submitted2 > 0) {
                              $categoryName = '';
                              if ($base_lang == 'en') {
                                $categoryName = $rCat['rstug_categoryName'];
                              } elseif ($base_lang == 'fr') {
                                $categoryName = $rCat['rstug_categoryName_fr'];
                              } elseif ($base_lang == 'pt') {
                                $categoryName = $rCat['rstug_categoryName_pt'];
                              }
                              
                              $categoryLabels[] = "'" . $categoryName . "'";
                              $categoryData[] = $TotalC_submitted2;
                            }
                          }
                          
                          echo implode(', ', $categoryLabels);
                          ?>
                        ],
                        datasets: [{
                          label: '<?php echo $lang_Category; ?> Breakdown',
                          data: [<?php echo implode(', ', $categoryData); ?>],
                          backgroundColor: 'rgba(75, 192, 192, 0.6)',
                          borderColor: 'rgba(75, 192, 192, 1)',
                          borderWidth: 1
                        }]
                      },
                      options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                          legend: {
                            display: false
                          },
                          title: {
                            display: true,
                            text: 'By <?php echo $lang_Category; ?>'
                          }
                        },
                        scales: {
                          y: {
                            beginAtZero: true,
                            ticks: {
                              precision: 0
                            }
                          }
                        }
                      }
                    });
                  });
                </script>
              <?php
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Summary Section -->
  <div class="row">
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header bg-info text-white">
          <h5 class="m-0">Overall Submission Analytics</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="chart-container" style="position: relative; height:300px; width:100%">
                <canvas id="overallSubmissionsChart"></canvas>
              </div>
            </div>
            <div class="col-md-6">
              <div class="chart-container" style="position: relative; height:300px; width:100%">
                <canvas id="overallGenderChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Required JavaScript for Charts and UI Enhancements -->
<script>
  // Toggle between table and chart views
  document.addEventListener('DOMContentLoaded', function() {
    const tableViewBtn = document.getElementById('table-view-btn');
    const chartViewBtn = document.getElementById('chart-view-btn');
    const tableView = document.getElementById('table-view');
    const chartView = document.getElementById('chart-view');
    
    tableViewBtn.addEventListener('click', function() {
      tableView.style.display = 'block';
      chartView.style.display = 'none';
      tableViewBtn.classList.add('active');
      chartViewBtn.classList.remove('active');
    });
    
    chartViewBtn.addEventListener('click', function() {
      tableView.style.display = 'none';
      chartView.style.display = 'block';
      chartViewBtn.classList.add('active');
      tableViewBtn.classList.remove('active');
    });
    
    // Overall analytics charts
    const overallSubmissionsCtx = document.getElementById('overallSubmissionsChart').getContext('2d');
    const overallGenderCtx = document.getElementById('overallGenderChart').getContext('2d');
    
    // Extract data from PHP for overall charts
    <?php
      $sqlGroupOverall = "SELECT * FROM " . $prefix . "grantcalls where category='proposals' and publish='Yes' order by grantID desc";
      $queryOverall = $mysqli->query($sqlGroupOverall);
      
      $grantLabels = [];
      $submissionData = [];
      $maleData = [];
      $femaleData = [];
      $totalMale = 0;
      $totalFemale = 0;
      
      while ($rowOverall = $queryOverall->fetch_array()) {
        $grantID = $rowOverall['grantID'];
        $grantTitle = $rowOverall['shortacronym'] ? $rowOverall['shortacronym'] : $rowOverall['title'];
        
        // Get submissions
        $sqlConcepts = "SELECT * FROM " . $prefix . "submissions_proposals where grantcallID='$grantID'";
        $queryConcepts = $mysqli->query($sqlConcepts);
        $totalSubmitted = $queryConcepts->num_rows;
        
        // Get gender data
        $sqlGenderw = "SELECT * FROM " . $prefix . "user_grantids where gender='Female' and grantID='$grantID' and categorym='proposal'";
        $queryGenderw = $mysqli->query($sqlGenderw);
        $totalFemale += $queryGenderw->num_rows;
        
        $sqlGenderMale = "SELECT * FROM " . $prefix . "user_grantids where gender='Male' and grantID='$grantID' and categorym='proposal'";
        $queryGenderMale = $mysqli->query($sqlGenderMale);
        $totalMale += $queryGenderMale->num_rows;
        
        $grantLabels[] = "'" . addslashes($grantTitle) . "'";
        $submissionData[] = $totalSubmitted;
        $maleData[] = $queryGenderMale->num_rows;
        $femaleData[] = $queryGenderw->num_rows;
      }
    ?>
    
    // Overall submissions chart
    const overallSubmissionsChart = new Chart(overallSubmissionsCtx, {
      type: 'bar',
      data: {
        labels: [<?php echo implode(', ', $grantLabels); ?>],
        datasets: [{
          label: '<?php echo $lang_TotalSubmissions; ?>',
          data: [<?php echo implode(', ', $submissionData); ?>],
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: true,
            text: 'Submissions by Grant Call'
          },
          legend: {
            display: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              precision: 0
            }
          }
        }
      }
    });
    
    // Overall gender distribution chart
    const overallGenderChart = new Chart(overallGenderCtx, {
      type: 'pie',
      data: {
        labels: ['<?php echo $lang_male; ?>', '<?php echo $lang_female; ?>'],
        datasets: [{
          data: [<?php echo $totalMale; ?>, <?php echo $totalFemale; ?>],
          backgroundColor: ['#36a2eb', '#ff6384'],
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: true,
            text: 'Overall Gender Distribution'
          }
        }
      }
    });
  });
</script>

<!-- Additional CSS for styling -->
<style>
  .dashboard-container {
    padding: 20px 0;
  }
  
  .card {
    border-radius: 10px;
    overflow: hidden;
  }
  
  .card-header {
    border-bottom: 1px solid rgba(0,0,0,0.1);
  }
  
  .category-name {
    font-weight: 500;
  }
  
  .category-breakdown {
    max-height: 150px;
    overflow-y: auto;
  }
  
  .analytics-view {
    transition: all 0.3s ease;
  }
  
  .export-button {
    margin-right: 10px;
  }
  
  /* Responsive adjustments */
  @media (max-width: 768px) {
    .row {
      margin-right: 0;
      margin-left: 0;
    }
    
    .chart-container {
      height: 250px !important;
    }
    
    .col-md-6 {
      margin-bottom: 15px;
    }
  }
</style>