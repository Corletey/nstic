<!-- Modern Grants Won by Institution Dashboard -->
<div class="container-fluid institution-dashboard">
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow border-0">
        <div class="card-header bg-gradient-teal text-white d-flex justify-content-between align-items-center">
          <h4 class="m-0"><?php echo $lang_GrantsWonbyInstitution; ?></h4>
          <a href="exportgrantswon.php" class="btn btn-light btn-sm">
            <i class="fas fa-file-export me-2"></i><?php echo $lang_ExportResults; ?>
          </a>
        </div>
        <div class="card-body p-0">
          <div class="institutions-list p-3">
            <?php
            // Function to standardize institution names
            function standardizeInstitutionName($institution) {
                // Convert to uppercase for case-insensitive comparison
                $upper = trim(strtoupper($institution));
                
                // Define mapping of variations to standardized names
                $institutionMap = [
                    // Njala University variations
                    'NJALA UNIVERSITY' => 'Njala University',
                    'NJALA' => 'Njala University',
                    'NJALA UNIV' => 'Njala University',
                    
                    // Fourah Bay College variations
                    'FOURAH BAY COLLEGE' => 'Fourah Bay College, University of Sierra Leone',
                    'FBC' => 'Fourah Bay College, University of Sierra Leone',
                    'FBC USL' => 'Fourah Bay College, University of Sierra Leone',
                    'FOURAH BAY COLLEGE USL' => 'Fourah Bay College, University of Sierra Leone',
                    'FOURAH BAY COLLEGE, USL' => 'Fourah Bay College, University of Sierra Leone',
                    
                    // University of Sierra Leone variations
                    'UNIVERSITY OF SIERRA LEONE' => 'University of Sierra Leone',
                    'USL' => 'University of Sierra Leone',
                    
                    // College of Medicine variations
                    'COLLEGE OF MEDICINE AND ALLIED HEALTH SCIENCES' => 'College of Medicine and Allied Health Sciences, USL',
                    'COMAHS' => 'College of Medicine and Allied Health Sciences, USL',
                    'COLLEGE OF MEDICINE' => 'College of Medicine and Allied Health Sciences, USL',
                    
                    // IPAM variations
                    'INSTITUTE OF PUBLIC ADMINISTRATION AND MANAGEMENT' => 'Institute of Public Administration and Management, USL',
                    'IPAM' => 'Institute of Public Administration and Management, USL',
                    
                    // University of Makeni variations
                    'UNIVERSITY OF MAKENI' => 'University of Makeni',
                    'UNIMAK' => 'University of Makeni',
                    
                    // Eastern Polytechnic variations
                    'EASTERN POLYTECHNIC' => 'Eastern Polytechnic',
                    'EP' => 'Eastern Polytechnic',
                    
                    // Milton Margai variations
                    'MILTON MARGAI COLLEGE' => 'Milton Margai College of Education and Technology',
                    'MMCET' => 'Milton Margai College of Education and Technology',
                    'MILTON MARGAI COLLEGE OF EDUCATION' => 'Milton Margai College of Education and Technology',
                ];
                
                // Check if the uppercase version exists in our mapping
                if (array_key_exists($upper, $institutionMap)) {
                    return $institutionMap[$upper];
                }
                
                // Handle partial matches for longer institution names
                foreach ($institutionMap as $variant => $standard) {
                    // Check if the variant is contained within the institution name
                    if (strpos($upper, $variant) !== false) {
                        return $standard;
                    }
                }
                
                // If no match found, return the original with proper capitalization
                return ucwords(strtolower($institution));
            }

            $category = $_POST['category'];
            $page = 'main.php?';
            $url = 'category=';
            $value = 'GrantsWonbyInstitution&id=' . $id;

            $tbl_name = "";    //your table name
            // How many adjacent pages should be shown on each side?
            $adjacents = 3;

            // Get total number of rows
            $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "submissions_proposals where awarded='Yes' order by projectTitle asc");
            $row = $query->fetch_array(MYSQLI_NUM);
            $total_pages = $row[0];

            /* Setup vars for query. */
            $targetpage = $page . $url . $value;
            $limitm = 50;
            $page = $_GET['pages'];

            if ($page)
              $start = ($page - 1) * $limitm;
            else
              $start = 0;

            /* Get data. */
            $sql = "select * FROM " . $prefix . "submissions_proposals where awarded='Yes' order by projectTitle asc LIMIT $start, $limitm";
            $result = $mysqli->query($sql);

            /* Setup page vars for display. */
            if ($page == 0) $page = 1;
            $prev = $page - 1;
            $next = $page + 1;
            $lastpage = ceil($total_pages / $limitm);
            $lpm1 = $lastpage - 1;

            /* Build pagination */
            $pagination = "";
            if ($lastpage > 1) {
              $pagination .= "<ul class='pagination justify-content-center'>";
              
              // Previous button
              if ($page > 1)
                $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=$prev\">&laquo; Previous</a></li>";
              else
                $pagination .= "<li class='page-item disabled'><span class='page-link'>&laquo; Previous</span></li>";

              // Pages
              if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                  if ($counter == $page)
                    $pagination .= "<li class='page-item active'><span class='page-link'>$counter</span></li>";
                  else
                    $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=$counter\">$counter</a></li>";
                }
              } elseif ($lastpage > 5 + ($adjacents * 2)) {
                // Close to beginning; only hide later pages
                if ($page < 1 + ($adjacents * 2)) {
                  for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                    if ($counter == $page)
                      $pagination .= "<li class='page-item active'><span class='page-link'>$counter</span></li>";
                    else
                      $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=$counter\">$counter</a></li>";
                  }
                  $pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                  $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
                  $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=$lastpage\">$lastpage</a></li>";
                }
                // In middle; hide some front and some back
                elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                  $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=1\">1</a></li>";
                  $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=2\">2</a></li>";
                  $pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                  for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                      $pagination .= "<li class='page-item active'><span class='page-link'>$counter</span></li>";
                    else
                      $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=$counter\">$counter</a></li>";
                  }
                  $pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                  $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=$lpm1\">$lpm1</a></li>";
                  $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=$lastpage\">$lastpage</a></li>";
                }
                // Close to end; only hide early pages
                else {
                  $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=1\">1</a></li>";
                  $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=2\">2</a></li>";
                  $pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
                  for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                      $pagination .= "<li class='page-item active'><span class='page-link'>$counter</span></li>";
                    else
                      $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=$counter\">$counter</a></li>";
                  }
                }
              }

              // Next button
              if ($page < $counter - 1)
                $pagination .= "<li class='page-item'><a class='page-link' href=\"$targetpage&page=$next\">Next &raquo;</a></li>";
              else
                $pagination .= "<li class='page-item disabled'><span class='page-link'>Next &raquo;</span></li>";
              
              $pagination .= "</ul>";
            }
            ?>
            
            <!-- Pagination Top -->
            <div class="pagination-container mb-4">
              <?php echo $pagination; ?>
            </div>
            
            <?php if (!$total_pages) { ?>
              <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i><?php echo $lang_no_results_displayed; ?>
              </div>
            <?php } else { ?>
              <!-- Institution Cards -->
              <div class="row g-4">
                <?php
                // Array to store institution data for chart
                $institutionData = [];
                $institutionColors = [
                  '#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', 
                  '#ec4899', '#14b8a6', '#f97316', '#06b6d4', '#a855f7'
                ];
                $colorIndex = 0;
                
                // Reset result pointer
                $result->data_seek(0);
                
                // Group by institution - WITH STANDARDIZATION
                $institutions = [];
                while ($rFLists2 = $result->fetch_array()) {
                  // Apply standardization to institution name
                  $institution = standardizeInstitutionName($rFLists2['HostInstitution']);
                  if (!isset($institutions[$institution])) {
                    $institutions[$institution] = [];
                  }
                  $institutions[$institution][] = $rFLists2;
                }
                
                foreach ($institutions as $institution => $grants) {
                  // Track institution data for chart
                  $totalGrantAmount = 0;
                  $grantCount = count($grants);
                  $piCount = count(array_unique(array_column($grants, 'owner_id')));
                  
                  // Calculate total grants amount
                  $primaryCurrency = "";
                  $currencyAmounts = [];
                  
                  foreach ($grants as $grant) {
                    $currency = $grant['currency'];
                    if (!isset($currencyAmounts[$currency])) {
                      $currencyAmounts[$currency] = 0;
                    }
                    $currencyAmounts[$currency] += $grant['AmountofGrantawarded'];
                    
                    if (empty($primaryCurrency)) {
                      $primaryCurrency = $currency;
                    }
                  }
                  
                  // Store for chart
                  $institutionData[] = [
                    'institution' => $institution,
                    'grants' => $grantCount,
                    'amount' => ($currencyAmounts[$primaryCurrency] ?? 0),
                    'currency' => $primaryCurrency,
                    'color' => $institutionColors[$colorIndex % count($institutionColors)]
                  ];
                  $colorIndex++;
                ?>
                  <div class="col-lg-6 col-md-12" style="margin-bottom: 20px;">
                    <div class="card institution-card h-100 shadow-sm">
                      <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="m-0 text-primary fw-bold"><?php echo $institution; ?></h5>
                        <span class="badge bg-primary rounded-pill">
                          <?php echo $grantCount; ?> <?php echo $grantCount > 1 ? 'Grants' : 'Grant'; ?>
                        </span>
                      </div>
                      <div class="card-body p-0">
                        <div class="table-responsive">
                          <table class="table table-striped table-hover mb-0">
                            <thead>
                              <tr>
                                <th><?php echo $lang_PIName; ?></th>
                                <th><?php echo $lang_Proposals; ?></th>
                                <th><?php echo $lang_Grants_Awarded; ?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($grants as $grant) {
                                $owner_id = $grant['owner_id'];
                                
                                // Get PI details
                                $queryPI = "select * from " . $prefix . "musers where usrm_id='$owner_id'";
                                $resultPI = $mysqli->query($queryPI);
                                $piData = $resultPI->fetch_array();
                              ?>
                                <tr>
                                  <td>
                                    <div class="d-flex align-items-center">
                                      <div class="avatar-circle">
                                        <?php 
                                        $initials = strtoupper(substr($piData['usrm_fname'], 0, 1) . substr($piData['usrm_sname'], 0, 1));
                                        echo $initials;
                                        ?>
                                      </div>
                                      <div class="ms-2">
                                        <?php echo $piData['usrm_fname'] . ' ' . $piData['usrm_sname']; ?>
                                      </div>
                                    </div>
                                  </td>
                                  <td>
                                    <a href="<?php echo $base_url; ?>main.php?option=reviewPrososal&id=<?php echo $grant['projectID']; ?>" class="text-decoration-none" title="View proposal details">
                                      <?php 
                                      $title = $grant['projectTitle'];
                                      echo (strlen($title) > 40) ? substr($title, 0, 40) . '...' : $title; 
                                      ?>
                                    </a>
                                  </td>
                                  <td>
                                    <span class="badge bg-success">
                                      <?php echo number_format($grant['AmountofGrantawarded']); ?> <?php echo $grant['currency']; ?>
                                    </span>
                                  </td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <small class="text-muted">Principal Investigators: <span class="fw-bold"><?php echo $piCount; ?></span></small>
                          </div>
                          <div>
                            <?php foreach ($currencyAmounts as $currency => $amount) { ?>
                              <span class="badge bg-light text-dark">
                                Total: <?php echo number_format($amount); ?> <?php echo $currency; ?>
                              </span>
                            <?php } ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            <?php } ?>
            
            <!-- Pagination Bottom -->
            <div class="pagination-container mt-4">
              <?php echo $pagination; ?>
            </div>
          </div>
          
          <!-- Analytics Section -->
          <?php if ($total_pages > 0) { ?>
          <div class="analytics-section p-4 border-top">
            <h5 class="mb-4">Grant Distribution Analytics</h5>
            <div class="row">
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                  <div class="card-header bg-light">
                    <h6 class="m-0">Grants by Institution</h6>
                  </div>
                  <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                      <canvas id="institutionGrantsChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                  <div class="card-header bg-light">
                    <h6 class="m-0">Grant Amounts by Institution</h6>
                  </div>
                  <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                      <canvas id="institutionAmountsChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Charts initialization -->
<?php if ($total_pages > 0) { ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Prepare data for charts
  const institutionData = <?php echo json_encode($institutionData); ?>;
  
  const labels = institutionData.map(item => item.institution);
  const grantCounts = institutionData.map(item => item.grants);
  const grantAmounts = institutionData.map(item => item.amount);
  const colors = institutionData.map(item => item.color);
  
  // Grants by Institution Chart
  const grantsCtx = document.getElementById('institutionGrantsChart').getContext('2d');
  const grantsChart = new Chart(grantsCtx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Number of Grants',
        data: grantCounts,
        backgroundColor: colors,
        borderColor: colors.map(color => color.replace('0.6', '1')),
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
        tooltip: {
          callbacks: {
            label: function(context) {
              const value = context.raw;
              return `Grants: ${value}`;
            }
          }
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
  
  // Grant Amounts by Institution Chart
  const amountsCtx = document.getElementById('institutionAmountsChart').getContext('2d');
  const amountsChart = new Chart(amountsCtx, {
    type: 'pie',
    data: {
      labels: labels,
      datasets: [{
        data: grantAmounts,
        backgroundColor: colors,
        hoverOffset: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right',
          labels: {
            boxWidth: 12
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const institution = institutionData[context.dataIndex];
              const value = context.raw;
              const formattedValue = new Intl.NumberFormat().format(value);
              return `${institution.institution}: ${formattedValue} ${institution.currency}`;
            }
          }
        }
      }
    }
  });
});
</script>
<?php } ?>

<!-- Custom styles -->
<style>
.institution-dashboard {
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

.bg-gradient-teal {
  background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
}

.institution-card {
  transition: transform 0.3s, box-shadow 0.3s;
}

.institution-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.institution-card .card-header {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  padding: 1rem 1.25rem;
}

.avatar-circle {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background-color: #4f46e5;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: bold;
}

.table {
  margin-bottom: 0;
}

.table th {
  font-weight: 600;
  color: #4b5563;
  background-color: #f9fafb;
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

.pagination {
  margin-bottom: 0;
}

.page-link {
  color: #0d9488;
  border-color: #e5e7eb;
  padding: 0.5rem 0.75rem;
}

.page-item.active .page-link {
  background-color: #0d9488;
  border-color: #0d9488;
}

.page-link:hover {
  color: #0f766e;
  background-color: #f3f4f6;
  border-color: #d1d5db;
}

.page-item.disabled .page-link {
  color: #9ca3af;
}

.analytics-section {
  background-color: #f9fafb;
}

/* Animation for loading */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.institution-dashboard {
  animation: fadeIn 0.5s ease-in-out;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .card-body {
    padding: 1rem;
  }
  
  .table th, .table td {
    padding: 0.5rem 0.75rem;
    font-size: 0.9rem;
  }
  
  .chart-container {
    height: 250px !important;
  }
}

/* Additional color utilities */
.text-primary {
  color: #0d9488 !important;
}

.bg-primary {
  background-color: #0d9488 !important;
}

.bg-success {
  background-color: #10b981 !important;
}

.bg-light-teal {
  background-color: #d1faf5 !important;
}

.text-teal {
  color: #0d9488 !important;
}
</style>