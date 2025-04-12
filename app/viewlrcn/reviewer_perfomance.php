<!-- Modern Reviewer Performance Dashboard -->
<div class="container-fluid reviewer-dashboard">
  <div class="row mb-4">
    <div class="col-12">
      <div class="card shadow border-0">
        <div class="card-header bg-gradient-indigo text-white d-flex justify-content-between align-items-center">
          <h4 class="m-0"><?php echo $lang_ReviewerPerformance; ?></h4>
          <a href="exportperfomance.php" class="btn btn-light btn-sm">
            <i class="fas fa-file-export me-2"></i><?php echo $lang_ExportResults; ?>
          </a>
        </div>
        <div class="card-body">
          <?php
          $category = $_POST['category'];
          $page = 'main.php?';
          $url = 'category=';
          $value = 'ReviewerPerfomance&id=' . $id;

          $tbl_name = "";
          $adjacents = 3;

          // Get total number of rows
          $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "musers where usrm_usrtype='reviewer' order by usrm_fname asc");
          $row = $query->fetch_array(MYSQLI_NUM);
          $total_pages = $row[0];

          $targetpage = $page . $url . $value;
          $limitm = 50;
          $page = $_GET['pages'];

          if ($page)
            $start = ($page - 1) * $limitm;
          else
            $start = 0;

          // Get data
          $sql = "select * FROM " . $prefix . "musers where usrm_usrtype='reviewer' order by usrm_fname asc LIMIT $start, $limitm";
          $result = $mysqli->query($sql);

          // Setup pagination
          if ($page == 0) $page = 1;
          $prev = $page - 1;
          $next = $page + 1;
          $lastpage = ceil($total_pages / $limitm);
          $lpm1 = $lastpage - 1;

          // Build pagination
          $pagination = "";
          if ($lastpage > 1) {
            $pagination .= "<ul class='pagination pagination-sm justify-content-center mb-0'>";
            
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
              // Close to beginning
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
              // In middle
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
              // Close to end
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
            <!-- Performance Overview Cards -->
            <div class="performance-stats mb-4">
              <?php
              // Calculate overall stats
              $totalAssigned = 0;
              $totalReviewed = 0;
              $totalPending = 0;
              $reviewerData = array();
              
              // Store original result
              $resultCopy = $result;
              
              while ($reviewer = $resultCopy->fetch_array()) {
                $reviewer_id = $reviewer['usrm_id'];
                
                // Get assignments
                $queryAssigned = "select * from " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$reviewer_id' order by assignm_id desc";
                $resultAssigned = $mysqli->query($queryAssigned);
                $assigned = $resultAssigned->num_rows;
                
                // Get completed reviews
                $queryCompleted = "select * from " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$reviewer_id' and logm_status='completed' order by assignm_id desc";
                $resultCompleted = $mysqli->query($queryCompleted);
                $completed = $resultCompleted->num_rows;
                
                // Get pending reviews
                $queryPending = "select * from " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$reviewer_id' and logm_status='new' order by assignm_id desc";
                $resultPending = $mysqli->query($queryPending);
                $pending = $resultPending->num_rows;
                
                // Add to totals
                $totalAssigned += $assigned;
                $totalReviewed += $completed;
                $totalPending += $pending;
                
                // Store for chart
                $reviewerData[] = array(
                  'name' => $reviewer['usrm_fname'] . ' ' . $reviewer['usrm_sname'],
                  'assigned' => $assigned,
                  'completed' => $completed,
                  'pending' => $pending,
                  'id' => $reviewer_id
                );
              }
              
              // Reset result pointer
              $result->data_seek(0);
              
              // Calculate completion rate
              $completionRate = ($totalAssigned > 0) ? round(($totalReviewed / $totalAssigned) * 100) : 0;
              ?>
              
              <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                  <div class="stat-card bg-light-indigo p-3 rounded-lg h-100">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h3 class="mb-0"><?php echo $total_pages; ?></h3>
                        <p class="text-muted mb-0">Total Reviewers</p>
                      </div>
                      <div class="stat-icon">
                        <i class="fas fa-users fa-2x text-indigo"></i>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                  <div class="stat-card bg-light-blue p-3 rounded-lg h-100">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h3 class="mb-0"><?php echo $totalAssigned; ?></h3>
                        <p class="text-muted mb-0">Total Assignments</p>
                      </div>
                      <div class="stat-icon">
                        <i class="fas fa-tasks fa-2x text-blue"></i>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                  <div class="stat-card bg-light-green p-3 rounded-lg h-100">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h3 class="mb-0"><?php echo $totalReviewed; ?></h3>
                        <p class="text-muted mb-0">Completed Reviews</p>
                      </div>
                      <div class="stat-icon">
                        <i class="fas fa-check-circle fa-2x text-green"></i>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                  <div class="stat-card bg-light-orange p-3 rounded-lg h-100">
                    <div class="d-flex justify-content-between">
                      <div>
                        <h3 class="mb-0"><?php echo $completionRate; ?>%</h3>
                        <p class="text-muted mb-0">Completion Rate</p>
                      </div>
                      <div class="stat-icon">
                        <i class="fas fa-chart-pie fa-2x text-orange"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Chart Section -->
            <div class="row mb-4">
              <div class="col-lg-8">
                <div class="card shadow-sm">
                  <div class="card-header bg-light">
                    <h5 class="m-0">Reviewer Workload Distribution</h5>
                  </div>
                  <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                      <canvas id="reviewerWorkloadChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                  <div class="card-header bg-light">
                    <h5 class="m-0">Completion Status</h5>
                  </div>
                  <div class="card-body d-flex align-items-center justify-content-center">
                    <div class="chart-container" style="position: relative; height:250px; width:100%">
                      <canvas id="completionStatusChart"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Reviewer List Table -->
            <div class="table-responsive rounded">
              <table class="table table-hover border-0 align-middle">
                <thead class="bg-light">
                  <tr>
                    <th class="border-0"><?php echo $lang_ReviewName; ?></th>
                    <th class="border-0"><?php echo $lang_SubmissionsAssigned; ?></th>
                    <th class="border-0"><?php echo $lang_SubmissionsReviewed; ?></th>
                    <th class="border-0"><?php echo $lang_SubmissionsnotReviewed; ?></th>
                    <th class="border-0">Completion Rate</th>
                    <th class="border-0">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($reviewer = $result->fetch_array()) {
                    $reviewer_id = $reviewer['usrm_id'];
                    
                    // Get assignments count
                    $queryAssigned = "select * from " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$reviewer_id' order by assignm_id desc";
                    $resultAssigned = $mysqli->query($queryAssigned);
                    $assignedCount = $resultAssigned->num_rows;
                    
                    // Get completed reviews count
                    $queryCompleted = "select * from " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$reviewer_id' and logm_status='completed' order by assignm_id desc";
                    $resultCompleted = $mysqli->query($queryCompleted);
                    $completedCount = $resultCompleted->num_rows;
                    
                    // Get pending reviews count
                    $queryPending = "select * from " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$reviewer_id' and logm_status='new' order by assignm_id desc";
                    $resultPending = $mysqli->query($queryPending);
                    $pendingCount = $resultPending->num_rows;
                    
                    // Calculate individual completion rate
                    $individualRate = ($assignedCount > 0) ? round(($completedCount / $assignedCount) * 100) : 0;
                    
                    // Determine status class based on completion rate
                    $statusClass = 'bg-danger';
                    if ($individualRate >= 75) {
                      $statusClass = 'bg-success';
                    } elseif ($individualRate >= 50) {
                      $statusClass = 'bg-warning';
                    } elseif ($individualRate >= 25) {
                      $statusClass = 'bg-info';
                    }
                  ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="avatar-circle me-3">
                            <?php 
                            $initials = strtoupper(substr($reviewer['usrm_fname'], 0, 1) . substr($reviewer['usrm_sname'], 0, 1));
                            echo $initials;
                            ?>
                          </div>
                          <div>
                            <h6 class="mb-0"><?php echo $reviewer['usrm_fname'] . ' ' . $reviewer['usrm_sname']; ?></h6>
                            <small class="text-muted"><?php echo $reviewer['usrm_email']; ?></small>
                          </div>
                        </div>
                      </td>
                      <td>
                        <a href="./main.php?option=reviewerviewall&id=<?php echo $reviewer_id; ?>&status=Assigned" class="badge bg-primary rounded-pill">
                          <?php echo $assignedCount; ?>
                        </a>
                      </td>
                      <td>
                        <a href="./main.php?option=reviewerviewall&id=<?php echo $reviewer_id; ?>&status=Reviewed" class="badge bg-success rounded-pill">
                          <?php echo $completedCount; ?>
                        </a>
                      </td>
                      <td>
                        <a href="./main.php?option=reviewerviewall&id=<?php echo $reviewer_id; ?>&status=Pending" class="badge bg-warning rounded-pill">
                          <?php echo $pendingCount; ?>
                        </a>
                      </td>
                      <td>
                        <div class="progress" style="height: 8px;">
                          <div class="progress-bar <?php echo $statusClass; ?>" role="progressbar" style="width: <?php echo $individualRate; ?>%;" aria-valuenow="<?php echo $individualRate; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="mt-1 d-block"><?php echo $individualRate; ?>%</small>
                      </td>
                      <td>
                        <div class="action-buttons">
                          <a href="./main.php?option=reviewerviewall&id=<?php echo $reviewer_id; ?>&status=Assigned" class="btn btn-sm btn-outline-primary me-1" title="View all assignments">
                            <i class="fas fa-tasks"></i>
                          </a>
                          <a href="./main.php?option=reviewerviewall&id=<?php echo $reviewer_id; ?>&status=Reviewed" class="btn btn-sm btn-outline-success me-1" title="View completed reviews">
                            <i class="fas fa-check-circle"></i>
                          </a>
                          <a href="./main.php?option=reviewerviewall&id=<?php echo $reviewer_id; ?>&status=Pending" class="btn btn-sm btn-outline-warning" title="View pending reviews">
                            <i class="fas fa-clock"></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          <?php } ?>
          
          <!-- Pagination Bottom -->
          <div class="pagination-container mt-4">
            <?php echo $pagination; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for Charts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  <?php if ($total_pages > 0) { ?>
  // Prepare data for charts
  const reviewerData = <?php echo json_encode(array_slice($reviewerData, 0, 10)); ?>;
  
  // Workload chart (top 10 reviewers)
  const workloadCtx = document.getElementById('reviewerWorkloadChart').getContext('2d');
  const workloadChart = new Chart(workloadCtx, {
    type: 'bar',
    data: {
      labels: reviewerData.map(item => item.name),
      datasets: [
        {
          label: 'Completed',
          data: reviewerData.map(item => item.completed),
          backgroundColor: '#10b981',
          borderColor: '#10b981',
          borderWidth: 0
        },
        {
          label: 'Pending',
          data: reviewerData.map(item => item.pending),
          backgroundColor: '#f59e0b',
          borderColor: '#f59e0b',
          borderWidth: 0
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          stacked: true,
          grid: {
            display: false
          }
        },
        y: {
          stacked: true,
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      },
      plugins: {
        tooltip: {
          mode: 'index',
          intersect: false
        },
        legend: {
          position: 'top',
        }
      }
    }
  });
  
  // Completion Status chart
  const completionCtx = document.getElementById('completionStatusChart').getContext('2d');
  const completionChart = new Chart(completionCtx, {
    type: 'doughnut',
    data: {
      labels: ['Completed', 'Pending'],
      datasets: [{
        data: [<?php echo $totalReviewed; ?>, <?php echo $totalPending; ?>],
        backgroundColor: ['#10b981', '#f59e0b'],
        hoverOffset: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '65%',
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
  <?php } ?>
  
  // Add tooltip functionality manually
  const actionButtons = document.querySelectorAll('.action-buttons .btn');
  actionButtons.forEach(button => {
    const title = button.getAttribute('title');
    if (title) {
      button.addEventListener('mouseover', function(e) {
        // Create tooltip element
        let tooltip = document.createElement('div');
        tooltip.className = 'custom-tooltip';
        tooltip.textContent = title;
        document.body.appendChild(tooltip);
        
        // Position tooltip
        const rect = button.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
        
        // Show tooltip
        tooltip.style.opacity = '1';
        
        // Store tooltip reference
        button._tooltip = tooltip;
      });
      
      button.addEventListener('mouseout', function() {
        if (button._tooltip) {
          document.body.removeChild(button._tooltip);
          button._tooltip = null;
        }
      });
    }
  });
});
</script>

<!-- Custom CSS -->
<style>
.reviewer-dashboard {
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

.bg-gradient-indigo {
  background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
}

.avatar-circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background-color: #4f46e5;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  font-weight: bold;
}

.stat-card {
  transition: transform 0.3s, box-shadow 0.3s;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.08);
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.bg-light-indigo {
  background-color: #eef2ff;
}

.bg-light-blue {
  background-color: #eff6ff;
}

.bg-light-green {
  background-color: #ecfdf5;
}

.bg-light-orange {
  background-color: #fff7ed;
}

.text-indigo {
  color: #4f46e5;
}

.text-blue {
  color: #3b82f6;
}

.text-green {
  color: #10b981;
}

.text-orange {
  color: #f59e0b;
}

.stat-icon {
  padding: 10px;
  border-radius: 50%;
  background-color: rgba(255, 255, 255, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.table {
  border-collapse: separate;
  border-spacing: 0;
}

.table th {
  font-weight: 600;
  color: #4b5563;
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.table-hover tbody tr:hover {
  background-color: #f9fafb;
}

.badge {
  padding: 0.5em 0.75em;
  font-weight: 500;
}

.action-buttons {
  display: flex;
  align-items: center;
}

.action-buttons .btn {
  padding: 0.25rem 0.5rem;
  margin: 0 0.1rem;
}

.action-buttons .btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.page-link {
  color: #4f46e5;
  border-color: #e5e7eb;
  padding: 0.4rem 0.65rem;
  font-size: 0.875rem;
}

.page-item.active .page-link {
  background-color: #4f46e5;
  border-color: #4f46e5;
}

.page-link:hover {
  color: #4338ca;
  background-color: #f3f4f6;
  border-color: #d1d5db;
}

.page-item.disabled .page-link {
  color: #9ca3af;
}

/* Custom tooltip */
.custom-tooltip {
  position: fixed;
  background-color: #333;
  color: white;
  padding: 5px 10px;
  border-radius: 4px;
  font-size: 12px;
  z-index: 9999;
  opacity: 0;
  transition: opacity 0.3s;
  pointer-events: none;
}

.custom-tooltip::after {
  content: '';
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #333 transparent transparent transparent;
}

/* Animation */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

.reviewer-dashboard {
  animation: fadeIn 0.5s ease-in-out;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .avatar-circle {
    width: 32px;
    height: 32px;
    font-size: 12px;
  }
  
  .stat-card h3 {
    font-size: 1.25rem;
  }
  
  .chart-container {
    height: 250px !important;
  }
  
  .table th, .table td {
    padding: 0.5rem 0.75rem;
    font-size: 0.85rem;
  }
  
  .action-buttons {
    flex-wrap: wrap;
  }
  
  .action-buttons .btn {
    margin-bottom: 0.25rem;
  }
}
</style>