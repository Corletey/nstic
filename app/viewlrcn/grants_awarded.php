<!-- Modern Grants Awarded Dashboard -->
<div class="container-fluid grants-dashboard">
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow border-0">
        <div class="card-header bg-gradient-purple text-white d-flex justify-content-between align-items-center">
          <h4 class="m-0"><?php echo $lang_GrantsAwarded; ?></h4>
          <a href="exportgrants.php" class="btn btn-light btn-sm">
            <i class="fas fa-file-export me-2"></i><?php echo $lang_ExportResults; ?>
          </a>
        </div>
        <div class="card-body p-0">
          <!-- Grants Summary Cards -->
          <div class="grants-summary p-3">
            <?php
            // Initialize counters
            $totalGrantsAwarded = 0;
            $totalMaleAwardees = 0;
            $totalFemaleAwardees = 0;
            $totalValue = 0;
            $currencies = array();
            
            // First pass to collect summary data
            $sqlAllGrants = "SELECT * FROM " . $prefix . "submissions_proposals WHERE awarded='Yes'";
            $queryAllGrants = $mysqli->query($sqlAllGrants);
            while ($rowGrant = $queryAllGrants->fetch_array()) {
              $totalGrantsAwarded++;
              $owner_id = $rowGrant['owner_id'];
              $grantAmount = $rowGrant['AmountofGrantawarded'];
              $currency = $rowGrant['currency'];
              
              // Add currency to tracking array
              if (!isset($currencies[$currency])) {
                $currencies[$currency] = 0;
              }
              $currencies[$currency] += $grantAmount;
              
              // Get gender
              $sqlGender = "SELECT usrm_gender FROM " . $prefix . "musers WHERE usrm_id='$owner_id'";
              $queryGender = $mysqli->query($sqlGender);
              $rowGender = $queryGender->fetch_array();
              $gender = $rowGender['usrm_gender'];
              
              if ($gender == 'Male') {
                $totalMaleAwardees++;
              } else if ($gender == 'Female') {
                $totalFemaleAwardees++;
              }
            }
            ?>
            
            <div class="row g-3">
              <div class="col-lg-3 col-md-6">
                <div class="stat-card bg-light-blue p-3 rounded-lg h-100">
                  <div class="d-flex justify-content-between">
                    <div>
                      <h3 class="mb-0"><?php echo $totalGrantsAwarded; ?></h3>
                      <p class="text-muted mb-0">Total Grants Awarded</p>
                    </div>
                    <div class="stat-icon">
                      <i class="fas fa-award fa-2x text-primary-light"></i>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-3 col-md-6">
                <div class="stat-card bg-light-green p-3 rounded-lg h-100">
                  <div class="d-flex justify-content-between">
                    <div>
                      <h3 class="mb-0">
                        <?php 
                        // Display primary currency total
                        reset($currencies);
                        $mainCurrency = key($currencies);
                        echo number_format($currencies[$mainCurrency]);
                        ?>
                      </h3>
                      <p class="text-muted mb-0">Total Value (<?php echo $mainCurrency; ?>)</p>
                    </div>
                    <div class="stat-icon">
                      <i class="fas fa-money-bill-wave fa-2x text-success-light"></i>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-3 col-md-6">
                <div class="stat-card bg-light-purple p-3 rounded-lg h-100">
                  <div class="d-flex justify-content-between">
                    <div>
                      <h3 class="mb-0"><?php echo $totalMaleAwardees; ?></h3>
                      <p class="text-muted mb-0">Male Awardees</p>
                    </div>
                    <div class="stat-icon">
                      <i class="fas fa-male fa-2x text-purple-light"></i>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-3 col-md-6">
                <div class="stat-card bg-light-pink p-3 rounded-lg h-100">
                  <div class="d-flex justify-content-between">
                    <div>
                      <h3 class="mb-0"><?php echo $totalFemaleAwardees; ?></h3>
                      <p class="text-muted mb-0">Female Awardees</p>
                    </div>
                    <div class="stat-icon">
                      <i class="fas fa-female fa-2x text-pink-light"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Gender Distribution Chart -->
          <div class="row px-3 mb-4">
            <div class="col-md-6 mb-3">
              <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                  <h5 class="card-title">Gender Distribution</h5>
                </div>
                <div class="card-body">
                  <div class="chart-container" style="position: relative; height:250px; width:100%">
                    <canvas id="genderDistributionChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                  <h5 class="card-title">Grants by Category</h5>
                </div>
                <div class="card-body">
                  <div class="chart-container" style="position: relative; height:250px; width:100%">
                    <canvas id="categoriesChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Grants Accordion -->
          <div class="grants-accordions px-3 pb-3">
            <?php
            //Get all concept submissions
            $sqlGroupTotalCOncepts = "SELECT * FROM " . $prefix . "grantcalls where category='proposals' order by grantID desc";
            $sqlFGrpDisCTotalCOncepts = $mysqli->query($sqlGroupTotalCOncepts);
            $TotalCOncepts = $sqlFGrpDisCTotalCOncepts->num_rows;
            
            // Prepare category data for chart
            $categoryData = array();
            $sqlCatAll = "SELECT * FROM " . $prefix . "categories order by rstug_categoryName asc";
            $queryCatAll = $mysqli->query($sqlCatAll);
            while ($rCatAll = $queryCatAll->fetch_array()) {
              $catID = $rCatAll['rstug_categoryID'];
              $catName = $rCatAll['rstug_categoryName'];
              
              $sqlCatCount = "SELECT COUNT(*) as count FROM " . $prefix . "submissions_proposals where awarded='Yes' and researchTypeID='$catID'";
              $queryCatCount = $mysqli->query($sqlCatCount);
              $rowCatCount = $queryCatCount->fetch_array();
              $count = $rowCatCount['count'];
              
              if ($count > 0) {
                $categoryData[$catName] = $count;
              }
            }
            
            // Output the grant calls
            while ($rFLists2 = $sqlFGrpDisCTotalCOncepts->fetch_array()) {
              $grantID = $rFLists2['grantID'];
              
              $sqlConcepts2 = "SELECT * FROM " . $prefix . "submissions_proposals where awarded='Yes' and grantcallID='$grantID' order by projectID desc";
              $queryConcepts2 = $mysqli->query($sqlConcepts2);
              $Awarded = $queryConcepts2->num_rows;
              
              if ($Awarded > 0) { // Only show grant calls with awarded grants
            ?>
                <div class="accordion-item mb-3 border rounded-lg overflow-hidden">
                  <h2 class="accordion-header" id="heading<?php echo $grantID; ?>">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $grantID; ?>" aria-expanded="false" aria-controls="collapse<?php echo $grantID; ?>">
                      <div class="d-flex align-items-center w-100">
                        <div class="me-auto">
                          <span class="fw-bold"><?php echo $rFLists2['title']; ?></span>
                        </div>
                        <span class="badge bg-primary rounded-pill ms-2"><?php echo $Awarded; ?></span>
                      </div>
                    </button>
                  </h2>
                  <div id="collapse<?php echo $grantID; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $grantID; ?>">
                    <div class="accordion-body p-0">
                      <div class="table-responsive">
                        <table class="table table-hover mb-0">
                          <thead class="table-light">
                            <tr>
                              <th><?php echo $lang_Title; ?></th>
                              <th><?php echo $lang_TotalGrant; ?></th>
                              <th><?php echo $lang_Gender; ?></th>
                              <th><?php echo $lang_Category; ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            //Get all concept submissions
                            $sqlConcepts = "SELECT * FROM " . $prefix . "submissions_proposals where awarded='Yes' and grantcallID='$grantID' order by projectID desc";
                            $queryConcepts = $mysqli->query($sqlConcepts);
                            while ($rows_submissions = $queryConcepts->fetch_array()) {
                              $owner_id = $rows_submissions['owner_id'];
                              $projectID = $rows_submissions['projectID'];
                              $rstug_categoryID = $rows_submissions['researchTypeID'];
                              
                              // Get gender
                              $sqlGenderLog = "SELECT * FROM " . $prefix . "musers where usrm_id='$owner_id' order by usrm_id desc";
                              $queryGenderLog = $mysqli->query($sqlGenderLog);
                              $rows_GenderLog = $queryGenderLog->fetch_array();
                              $usrm_gender = $rows_GenderLog['usrm_gender'];
                              
                              // Get category
                              $sqlCat = "SELECT * FROM " . $prefix . "categories where rstug_categoryID='$rstug_categoryID' order by rstug_categoryName asc";
                              $queryCat = $mysqli->query($sqlCat);
                              $rCat = $queryCat->fetch_array();
                            ?>
                              <tr>
                                <td>
                                  <a href="<?php echo $base_url; ?>main.php?option=reviewPrososal&id=<?php echo $rows_submissions['projectID']; ?>" class="fw-medium text-decoration-none" target="_blank">
                                    <?php echo $rows_submissions['projectTitle']; ?>
                                  </a>
                                </td>
                                <td>
                                  <span class="badge bg-success text-white">
                                    <?php echo number_format($rows_submissions['AmountofGrantawarded']); ?> <?php echo $rows_submissions['currency']; ?>
                                  </span>
                                </td>
                                <td>
                                  <?php if($usrm_gender == 'Male') { ?>
                                    <span class="badge bg-info text-white">Male</span>
                                  <?php } else { ?>
                                    <span class="badge bg-danger text-white">Female</span>
                                  <?php } ?>
                                </td>
                                <td>
                                  <span class="badge bg-secondary text-white">
                                    <?php echo $rCat['rstug_categoryName']; ?>
                                  </span>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
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

<!-- Chart initialization -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Gender distribution chart
  const genderCtx = document.getElementById('genderDistributionChart').getContext('2d');
  const genderChart = new Chart(genderCtx, {
    type: 'doughnut',
    data: {
      labels: ['Male', 'Female'],
      datasets: [{
        data: [<?php echo $totalMaleAwardees; ?>, <?php echo $totalFemaleAwardees; ?>],
        backgroundColor: ['#3b82f6', '#ec4899'],
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
        tooltip: {
          callbacks: {
            label: function(context) {
              const total = context.dataset.data.reduce((a, b) => a + b, 0);
              const value = context.raw;
              const percentage = Math.round((value / total) * 100);
              return `${context.label}: ${value} (${percentage}%)`;
            }
          }
        }
      }
    }
  });
  
  // Categories chart
  const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
  const categoriesChart = new Chart(categoriesCtx, {
    type: 'bar',
    data: {
      labels: [
        <?php 
        foreach ($categoryData as $cat => $count) {
          echo "'" . addslashes($cat) . "',";
        }
        ?>
      ],
      datasets: [{
        label: 'Grants Awarded',
        data: [
          <?php 
          foreach ($categoryData as $cat => $count) {
            echo $count . ",";
          }
          ?>
        ],
        backgroundColor: 'rgba(79, 70, 229, 0.6)',
        borderColor: 'rgba(79, 70, 229, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
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
  
  // Bootstrap accordion functionality
  document.querySelectorAll('.accordion-button').forEach(button => {
    button.addEventListener('click', function() {
      this.classList.toggle('collapsed');
      const target = document.querySelector(this.getAttribute('data-bs-target'));
      if (target) {
        target.classList.toggle('show');
      }
    });
  });
});
</script>

<!-- Custom styles -->
<style>
.grants-dashboard {
  padding: 20px 0;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

.card {
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  border: none;
  transition: all 0.3s ease;
}

.bg-gradient-purple {
  background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
}

.accordion-button {
  padding: 1rem 1.25rem;
  background-color: #f9fafb;
  border: none;
  border-radius: 0 !important;
  color: #111827;
  font-weight: 500;
  box-shadow: none;
  transition: all 0.2s ease;
}

.accordion-button:not(.collapsed) {
  background-color: #f3f4f6;
  color: #4f46e5;
}

.accordion-button:focus {
  box-shadow: none;
  border-color: rgba(209, 213, 219, 0.5);
}

.accordion-button::after {
  width: 1.25rem;
  height: 1.25rem;
  background-size: 1.25rem;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%234f46e5'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
}

.accordion-item {
  border: 1px solid #e5e7eb;
  background-color: #fff;
}

.accordion-body {
  padding: 0;
}

.table {
  margin-bottom: 0;
}

.table th {
  font-weight: 600;
  color: #4b5563;
  background-color: #f3f4f6;
  text-transform: uppercase;
  font-size: 0.75rem;
  letter-spacing: 0.05em;
}

.table td, .table th {
  padding: 0.75rem 1rem;
  vertical-align: middle;
}

.badge {
  font-weight: 500;
  padding: 0.35em 0.65em;
  font-size: 0.85em;
}

.badge.bg-primary {
  background-color: #4f46e5 !important;
}

.badge.bg-success {
  background-color: #10b981 !important;
}

.badge.bg-info {
  background-color: #3b82f6 !important;
}

.badge.bg-danger {
  background-color: #ec4899 !important;
}

.badge.bg-secondary {
  background-color: #6b7280 !important;
}

.stat-card {
  border-radius: 10px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}

.stat-card:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.1), 0 10px 10px rgba(0,0,0,0.1);
  transform: translateY(-5px);
}

.bg-light-blue {
  background-color: #eff6ff;
}

.bg-light-green {
  background-color: #ecfdf5;
}

.bg-light-purple {
  background-color: #f5f3ff;
}

.bg-light-pink {
  background-color: #fdf2f8;
}

.text-primary-light {
  color: #3b82f6;
}

.text-success-light {
  color: #10b981;
}

.text-purple-light {
  color: #8b5cf6;
}

.text-pink-light {
  color: #ec4899;
}

.stat-icon {
  padding: 10px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .card-body {
    padding: 1rem;
  }
  
  .stat-card h3 {
    font-size: 1.25rem;
  }
  
  .chart-container {
    height: 200px !important;
  }
  
  .accordion-button {
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
  }
  
  .table th, .table td {
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
  }
}

/* Animation for loading */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.grants-dashboard {
  animation: fadeIn 0.5s ease-in-out;
}

/* Bootstrap accordion collapse animation */
.accordion-collapse {
  overflow: hidden;
  transition: height 0.3s ease;
}

.accordion-collapse:not(.show) {
  height: 0 !important;
  display: block;
}

.accordion-collapse.show {
  height: auto;
}
</style>