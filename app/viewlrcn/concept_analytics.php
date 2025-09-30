<!-- Modern Concept Analytics Dashboard -->
<div class="container-fluid dashboard-container">
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header bg-success text-white">
          <h4 class="m-0"><?php echo $lang_ConceptAnalytics; ?></h4>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="export-button">
              <a href="exportconceptanalytics.php" class="btn btn-primary">
                <i class="fas fa-file-export me-2"></i><?php echo $lang_ExportResults; ?>
              </a>
            </div>
            <div class="view-options">
              <button class="btn btn-outline-success btn-sm active" id="table-view-btn">
                <i class="fas fa-table me-1"></i>Table View
              </button>
              <button class="btn btn-outline-success btn-sm" id="chart-view-btn">
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
                    <th>By <?php echo $lang_Gender; ?></th>
                    <th>By <?php echo $lang_Category; ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlGroupTotalCOncepts = "SELECT * FROM " . $prefix . "grantcalls where category='concepts' and publish='Yes' order by grantID desc";
                  $sqlFGrpDisCTotalCOncepts = $mysqli->query($sqlGroupTotalCOncepts);
                  $TotalCOncepts = $sqlFGrpDisCTotalCOncepts->num_rows;
                  while ($rFLists2 = $sqlFGrpDisCTotalCOncepts->fetch_array()) {
                    // grantID submissions_concepts
                    $grantID = $rFLists2['grantID'];
                    // Get all concept submissions
                    $sqlConcepts = "SELECT * FROM " . $prefix . "submissions_concepts where grantcallID='$grantID' order by conceptID desc";
                    $queryConcepts = $mysqli->query($sqlConcepts);
                    $TotalC_submitted = $queryConcepts->num_rows;
                    while ($rows_submissions = $queryConcepts->fetch_array()) {
                      $owner_id = $rows_submissions['owner_id'];
                      $conceptID = $rows_submissions['conceptID'];
                      // submissions by Gender
                      $sqlGender_log = "SELECT * FROM " . $prefix . "user_grantids where owner_id='$owner_id' and grantID='$grantID' and conceptID='$conceptID' and categorym='concept' order by id desc";
                      $queryGender_log = $mysqli->query($sqlGender_log);
                      $TotalCLog = $queryGender_log->num_rows;

                      if (!$TotalCLog && $owner_id) {
                        $sqlGenderLog = "SELECT * FROM " . $prefix . "musers where usrm_id='$owner_id' order by usrm_id desc";
                        $queryGenderLog = $mysqli->query($sqlGenderLog);
                        $rows_GenderLog = $queryGenderLog->fetch_array();
                        $usrm_gender = $rows_GenderLog['usrm_gender'];
                        // Add to user_grantids Table
                        $sqlA4s = "INSERT INTO " . $prefix . "user_grantids (grantID,owner_id,gender,conceptID,categorym) VALUES('$grantID','$owner_id','$usrm_gender','$conceptID','concept')";
                        $mysqli->query($sqlA4s);
                      }
                    }

                    // Women
                    $sqlGenderw = "SELECT * FROM " . $prefix . "user_grantids where gender='Female' and grantID='$grantID' and categorym='concept' order by id desc";
                    $queryGenderw = $mysqli->query($sqlGenderw);
                    $TotalC_Female = $queryGenderw->num_rows;

                    $sqlGenderMale = "SELECT * FROM " . $prefix . "user_grantids where gender='Male' and grantID='$grantID' and categorym='concept' order by id desc";
                    $queryGenderMale = $mysqli->query($sqlGenderMale);
                    $TotalC_Male = $queryGenderMale->num_rows;
                  ?>
                    <tr>
                      <td>
                        <div class="fw-bold"><?php echo $rFLists2['title']; ?></div>
                        <small class="text-muted"><?php echo substr($rFLists2['shortacronym'], 0, 30); ?></small>
                      </td>
                      <td>
                        <span class="badge bg-success fs-6"><?php echo $TotalC_submitted; ?></span>
                      </td>
                      <td>
                        <div class="d-flex flex-column">
                          <div class="mb-2">
                            <span class="text-success"><?php echo $lang_male; ?>:</span> 
                            <span class="badge bg-info"><?php echo $TotalC_Male; ?></span>
                          </div>
                          <div>
                            <span class="text-success"><?php echo $lang_female; ?>:</span> 
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

                            $sqlConcepts2 = "SELECT * FROM " . $prefix . "submissions_concepts where researchTypeID='$rstug_categoryID' and grantcallID='$grantID' order by conceptID desc";
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
              $sqlGroupTotalCOncepts = "SELECT * FROM " . $prefix . "grantcalls where category='concepts' and publish='Yes' order by grantID desc";
              $sqlFGrpDisCTotalCOncepts = $mysqli->query($sqlGroupTotalCOncepts);
              while ($rFLists2 = $sqlFGrpDisCTotalCOncepts->fetch_array()) {
                $grantID = $rFLists2['grantID'];
                
                // Get total submissions
                $sqlConcepts = "SELECT * FROM " . $prefix . "submissions_concepts where grantcallID='$grantID' order by conceptID desc";
                $queryConcepts = $mysqli->query($sqlConcepts);
                $TotalC_submitted = $queryConcepts->num_rows;
                
                // Get gender breakdown
                $sqlGenderw = "SELECT * FROM " . $prefix . "user_grantids where gender='Female' and grantID='$grantID' and categorym='concept' order by id desc";
                $queryGenderw = $mysqli->query($sqlGenderw);
                $TotalC_Female = $queryGenderw->num_rows;

                $sqlGenderMale = "SELECT * FROM " . $prefix . "user_grantids where gender='Male' and grantID='$grantID' and categorym='concept' order by id desc";
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
                            <canvas id="conceptGenderChart<?php echo $grantID; ?>"></canvas>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="chart-container" style="position: relative; height:200px; width:100%">
                            <canvas id="conceptCategoryChart<?php echo $grantID; ?>"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    // Gender breakdown chart
                    const genderCtx<?php echo $grantID; ?> = document.getElementById('conceptGenderChart<?php echo $grantID; ?>').getContext('2d');
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
                    const categoryCtx<?php echo $grantID; ?> = document.getElementById('conceptCategoryChart<?php echo $grantID; ?>').getContext('2d');
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
                            
                            $sqlConcepts2 = "SELECT * FROM " . $prefix . "submissions_concepts where researchTypeID='$rstug_categoryID' and grantcallID='$grantID' order by conceptID desc";
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
        <div class="card-header bg-warning text-dark">
          <h5 class="m-0">Overall Concept Analytics</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="chart-container" style="position: relative; height:300px; width:100%">
                <canvas id="overallConceptsChart"></canvas>
              </div>
            </div>
            <div class="col-md-6">
              <div class="chart-container" style="position: relative; height:300px; width:100%">
                <canvas id="overallConceptGenderChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Category Distribution Card -->
  <div class="row">
    <div class="col-12">
      <div class="card shadow mb-4">
        <div class="card-header bg-info text-white">
          <h5 class="m-0">Category Distribution Across All Concepts</h5>
        </div>
        <div class="card-body">
          <div class="chart-container" style="position: relative; height:350px; width:100%">
            <canvas id="overallCategoryDistributionChart"></canvas>
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
    const overallConceptsCtx = document.getElementById('overallConceptsChart').getContext('2d');
    const overallGenderCtx = document.getElementById('overallConceptGenderChart').getContext('2d');
    const overallCategoryCtx = document.getElementById('overallCategoryDistributionChart').getContext('2d');
    
    // Extract data from PHP for overall charts
    <?php
      $sqlGroupOverall = "SELECT * FROM " . $prefix . "grantcalls where category='concepts' and publish='Yes' order by grantID desc";
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
        $sqlConcepts = "SELECT * FROM " . $prefix . "submissions_concepts where grantcallID='$grantID'";
        $queryConcepts = $mysqli->query($sqlConcepts);
        $totalSubmitted = $queryConcepts->num_rows;
        
        // Get gender data
        $sqlGenderw = "SELECT * FROM " . $prefix . "user_grantids where gender='Female' and grantID='$grantID' and categorym='concept'";
        $queryGenderw = $mysqli->query($sqlGenderw);
        $totalFemale += $queryGenderw->num_rows;
        
        $sqlGenderMale = "SELECT * FROM " . $prefix . "user_grantids where gender='Male' and grantID='$grantID' and categorym='concept'";
        $queryGenderMale = $mysqli->query($sqlGenderMale);
        $totalMale += $queryGenderMale->num_rows;
        
        $grantLabels[] = "'" . addslashes($grantTitle) . "'";
        $submissionData[] = $totalSubmitted;
        $maleData[] = $queryGenderMale->num_rows;
        $femaleData[] = $queryGenderw->num_rows;
      }
      
      // Get overall category data
      $sqlOverallCat = "SELECT * FROM " . $prefix . "categories order by rstug_categoryName asc";
      $queryOverallCat = $mysqli->query($sqlOverallCat);
      $overallCategoryLabels = [];
      $overallCategoryData = [];
      
      while ($rowCat = $queryOverallCat->fetch_array()) {
        $rstug_categoryID = $rowCat['rstug_categoryID'];
        
        $sqlCatTotal = "SELECT * FROM " . $prefix . "submissions_concepts where researchTypeID='$rstug_categoryID'";
        $queryCatTotal = $mysqli->query($sqlCatTotal);
        $totalInCategory = $queryCatTotal->num_rows;
        
        if ($totalInCategory > 0) {
          $categoryName = '';
          if ($base_lang == 'en') {
            $categoryName = $rowCat['rstug_categoryName'];
          } elseif ($base_lang == 'fr') {
            $categoryName = $rowCat['rstug_categoryName_fr'];
          } elseif ($base_lang == 'pt') {
            $categoryName = $rowCat['rstug_categoryName_pt'];
          }
          
          $overallCategoryLabels[] = "'" . addslashes($categoryName) . "'";
          $overallCategoryData[] = $totalInCategory;
        }
      }
    ?>
    
    // Overall submissions chart
    const overallConceptsChart = new Chart(overallConceptsCtx, {
      type: 'bar',
      data: {
        labels: [<?php echo implode(', ', $grantLabels); ?>],
        datasets: [{
          label: '<?php echo $lang_TotalSubmissions; ?>',
          data: [<?php echo implode(', ', $submissionData); ?>],
          backgroundColor: 'rgba(40, 167, 69, 0.6)',
          borderColor: 'rgba(40, 167, 69, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          title: {
            display: true,
            text: 'Concept Submissions by Grant Call'
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
    const overallConceptGenderChart = new Chart(overallGenderCtx, {
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
            text: 'Overall Gender Distribution for Concepts'
          }
        }
      }
    });
    
    // Overall category distribution chart
    const overallCategoryDistributionChart = new Chart(overallCategoryCtx, {
      type: 'horizontalBar',
      data: {
        labels: [<?php echo implode(', ', $overallCategoryLabels); ?>],
        datasets: [{
          label: 'Submissions',
          data: [<?php echo implode(', ', $overallCategoryData); ?>],
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(199, 199, 199, 0.6)',
            'rgba(83, 102, 255, 0.6)',
            'rgba(40, 159, 64, 0.6)',
            'rgba(210, 199, 199, 0.6)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(199, 199, 199, 1)',
            'rgba(83, 102, 255, 1)',
            'rgba(40, 159, 64, 1)',
            'rgba(210, 199, 199, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          title: {
            display: true,
            text: 'Concept Submissions by Category'
          }
        },
        scales: {
          x: {
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

<!-- Additional CSS for styling -->
<style>
  .dashboard-container {
    padding: 20px 0;
  }
  
  .card {
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 20px;
    transition: transform 0.3s, box-shadow 0.3s;
  }
  
  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  }
  
  .card-header {
    border-bottom: 1px solid rgba(0,0,0,0.1);
    padding: 15px 20px;
  }
  
  .category-name {
    font-weight: 500;
  }
  
  .category-breakdown {
    max-height: 150px;
    overflow-y: auto;
    scrollbar-width: thin;
  }
  
  .category-breakdown::-webkit-scrollbar {
    width: 6px;
  }
  
  .category-breakdown::-webkit-scrollbar-track {
    background: #f1f1f1;
  }
  
  .category-breakdown::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
  }
  
  .analytics-view {
    transition: all 0.3s ease;
  }
  
  .export-button .btn {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: all 0.3s;
  }
  
  .export-button .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  }
  
  .badge {
    font-weight: 500;
    padding: 0.4em 0.6em;
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
    
    .view-options {
      margin-top: 10px;
    }
    
    .d-flex {
      flex-direction: column;
    }
  }
  
  @media (max-width: 576px) {
    .card-body {
      padding: 15px 10px;
    }
    
    .chart-container {
      height: 200px !important;
    }
  }
</style>