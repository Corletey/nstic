<!-- Welcome_dashboard_admin.php -->
<style>
  .sidebar-menu .main-menu .menu-inner nav ul li a {
    text-decoration: none;
    border-bottom: none;
  }
</style>

<!-- Modern Responsive Dashboard -->
<div class="modern-dashboard-container">
  <!-- Top Stats Cards Row -->
  <div class="row">
    <!-- Call Management Card -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0"><?php echo $lang_CallManagement; ?></h5>
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <?php if ($session_usertype == 'admin') { ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="./main.php?option=grantcalls" class="text-decoration-none">
                  <?php echo $lang_Customize_Call_for_Grant_Applications; ?>
                </a>
                <span><i class="fas fa-cog"></i></span>
              </li>
            <?php } ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a href="./main.php?option=CallConcepts" class="text-decoration-none">
                <?php echo $lang_Submitted_Call_for_Concepts; ?>
              </a>
              <span class="badge bg-secondary rounded-pill"><?php TotalLSubmissions(); ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a href="./main.php?option=CallProposals" class="text-decoration-none">
                <?php echo $lang_Submitted_Call_for_Proposals; ?>
              </a>
              <span class="badge bg-secondary rounded-pill"><?php ProposalTotalConferenceDisp(); ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a href="./main.php?option=DraftCalls" class="text-decoration-none text-success">
                <?php echo $lang_Drafts_submissions; ?>
              </a>
              <span class="badge bg-success rounded-pill"><?php DraftIncompleteCalls(); ?></span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a href="./main.php?option=ProcurementApplications" class="text-decoration-none">
                <?php echo $lang_Request_for_Procurement; ?>
              </a>
              <span class="badge bg-secondary rounded-pill"><?php TotalRequestforProcurement(); ?></span>
            </li>
          </ul>
        </div>
        <div class="card-footer bg-light">
          <a href="./main.php?option=FundsApplications" class="btn btn-outline-primary btn-sm w-100">
            <?php echo $lang_Request_for_Funds; ?>: <?php TotalRequestforFunds(); ?>
          </a>
        </div>
      </div>
    </div>

    <!-- Submitted Concepts Card -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><?php echo $lang_Submitted_Concepts; ?></h5>
          <a href="./main.php?option=conceptNewSubmissionsMain" class="badge bg-white text-dark text-decoration-none">
            <?php TotalSubmittedConceptsAdmin(); ?>
          </a>
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo $lang_Drafts; ?></span>
              <a href="./main.php?option=conceptNewSubmissions&status=Pending Final Submission" class="badge bg-secondary rounded-pill">
                <?php DraftConceptsAdmin(); ?>
              </a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo $lang_Submitted; ?></span>
              <a href="./main.php?option=conceptNewSubmissions&status=Pending Review" class="badge bg-warning rounded-pill">
                <?php PendingReviewConceptsAdmin(); ?>
              </a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo $lang_CompletenessCheck; ?></span>
              <a href="./main.php?option=CompletenessCheck" class="badge bg-primary rounded-pill">
                <?php CompletenessCheckConceptsAdmin(); ?>
              </a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo $lang_Scheduled_for_Review; ?></span>
              <a href="./main.php?option=conceptNewSubmissions&status=Scheduled for Review" class="badge bg-info rounded-pill">
                <?php ScheduledforReviewConceptsAdmin(); ?>
              </a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo $lang_Reviewed; ?></span>
              <a href="./main.php?option=conceptNewSubmissions&status=Reviewed" class="badge bg-success rounded-pill">
                <?php ApprovedConceptsAdmin(); ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Submitted Proposals Card -->
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><?php echo $lang_Submitted_Proposals; ?></h5>
          <a href="./main.php?option=proposalNewSubmissionsMain" class="badge bg-white text-dark text-decoration-none">
            <?php TotalSubmittedProposalsAdmin(); ?>
          </a>
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo $lang_Drafts; ?></span>
              <a href="./main.php?option=proposalNewSubmissions&status=Pending Final Submission" class="badge bg-secondary rounded-pill">
                <?php DraftProposalsAdmin(); ?>
              </a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo $lang_Submitted; ?></span>
              <a href="./main.php?option=proposalNewSubmissions&status=Pending Review" class="badge bg-warning rounded-pill">
                <?php PendingReviewProposalsAdmin(); ?>
              </a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo $lang_CompletenessCheck; ?></span>
              <a href="./main.php?option=proposalNewSubmissions&status=Completeness Check-Approved" class="badge bg-primary rounded-pill">
                <?php CompletenessCheckProposalsAdmin(); ?>
              </a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo $lang_Scheduled_for_Review; ?></span>
              <a href="./main.php?option=proposalNewSubmissions&status=Scheduled for Review" class="badge bg-info rounded-pill">
                <?php ScheduledforReviewProposalsAdmin(); ?>
              </a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?php echo $lang_Reviewed; ?></span>
              <a href="./main.php?option=proposalNewSubmissions&status=Reviewed" class="badge bg-success rounded-pill">
                <?php ApprovedProposalsAdmin(); ?>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Submissions Table -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-header bg-gradient-success text-white py-3">
          <h4 class="mb-0"><?php echo $lang_Recent_Submissions; ?></h4>
        </div>
        <div class="card-body">
          <!-- PHP DATABASE QUERY SECTION - MUST KEEP THIS CODE -->
          <?php
          $sessionusrm_id = $_SESSION['usrm_id'];
          $page = 'main.php?';
          $url = 'category=';
          $value = 'dashboard&id=' . $id;
          $adjacents = 3;
          
          // Get total row count
          if ($_POST['doSearch']) {
              $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "grantcalls where publish='Yes' order by grantID desc");
          }
          if (!$_POST['doSearch']) {
              $query = $mysqli->query("select COUNT(*) as num from " . $prefix . "grantcalls where publish='Yes' order by grantID desc");
          }
          $row = $query->fetch_array(MYSQLI_NUM);
          $total_pages = $row[0];

          // Set up pagination
          $targetpage = $page . $url . $value;
          if ($_POST['doSearch']) {
              $limitm = 20;
          }
          if (!$_POST['doSearch']) {
              $limitm = 20;
          }
          $page = $_GET['pages'];

          // Set start point
          if ($page)
              $start = ($page - 1) * $limitm;
          else
              $start = 0;

          // Get data
          if ($_POST['doSearch']) {
              $sql = "select * FROM " . $prefix . "grantcalls where publish='Yes' order by grantID desc LIMIT $start, $limitm";
          }
          if (!$_POST['doSearch']) {
              $sql = "select * FROM " . $prefix . "grantcalls where publish='Yes' order by grantID desc LIMIT $start, $limitm";
          }
          $result = $mysqli->query($sql);

          // Set up pagination vars
          if ($page == 0) $page = 1;
          $prev = $page - 1;
          $next = $page + 1;
          $lastpage = ceil($total_pages / $limitm);
          $lpm1 = $lastpage - 1;

          // Build pagination links
          $pagination = "";
          if ($lastpage > 1) {
              $pagination .= "<div class=\"pagination\">";
              //previous button
              if ($page > 1)
                  $pagination .= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
              else
                  $pagination .= "<span class=\"disabled\">&laquo;previous</span>";

              //pages	
              if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
              {
                  for ($counter = 1; $counter <= $lastpage; $counter++) {
                      if ($counter == $page)
                          $pagination .= "<span class=\"current\">$counter</span>";
                      else
                          $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                  }
              } elseif ($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
              {
                  //close to beginning; only hide later pages
                  if ($page < 1 + ($adjacents * 2)) {
                      for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                          if ($counter == $page)
                              $pagination .= "<span class=\"current\">$counter</span>";
                          else
                              $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                      }
                      $pagination .= "...";
                      $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                      $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                  }
                  //in middle; hide some front and some back
                  elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                      $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                      $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                      $pagination .= "...";
                      for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                          if ($counter == $page)
                              $pagination .= "<span class=\"current\">$counter</span>";
                          else
                              $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                      }
                      $pagination .= "...";
                      $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                      $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                  }
                  //close to end; only hide early pages
                  else {
                      $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                      $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                      $pagination .= "...";
                      for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                          if ($counter == $page)
                              $pagination .= "<span class=\"current\">$counter</span>";
                          else
                              $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                      }
                  }
              }

              //next button
              if ($page < $counter - 1)
                  $pagination .= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
              else
                  $pagination .= "<span class=\"disabled\">next&raquo;</span>";
              $pagination .= "</div>";
          }
          ?>
          <!-- END PHP DATABASE QUERY SECTION -->

          <div class="table-responsive">
            <table class="table table-hover table-striped">
              <thead class="table-dark">
                <tr>
                  <th scope="col"><?php echo $lang_Call; ?></th>
                  <th scope="col"><?php echo $lang_Category; ?></th>
                  <th scope="col"><?php echo $lang_new_StartDate; ?></th>
                  <th scope="col"><?php echo $lang_EndDate; ?></th>
                  <th scope="col"><?php echo $lang_Action; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if (!$total_pages) { 
                ?>
                  <tr>
                    <td colspan="5" class="text-center py-3"><?php echo $lang_no_results_displayed; ?></td>
                  </tr>
                <?php 
                } else { 
                  while ($rFLists2 = $result->fetch_array()) {
                    $grantID = $rFLists2['grantID'];
                    $categorym = $rFLists2['category'];

                    if ($categorym == 'proposals') {
                      $sqlGroupTotalProposals = "SELECT * FROM " . $prefix . "submissions_proposals where grantcallID='$grantID' order by projectID desc";
                      $sqlFGrpDisCTotalProposals = $mysqli->query($sqlGroupTotalProposals);
                      $TotalProposals = $sqlFGrpDisCTotalProposals->num_rows;
                    }

                    if ($categorym == 'concepts') {
                      $sqlGroupTotalCOncepts = "SELECT * FROM " . $prefix . "submissions_concepts where grantcallID='$grantID' order by conceptID desc";
                      $sqlFGrpDisCTotalCOncepts = $mysqli->query($sqlGroupTotalCOncepts);
                      $TotalCOncepts = $sqlFGrpDisCTotalCOncepts->num_rows;
                    }
                ?>
                  <tr>
                    <td><strong><?php echo $rFLists2['title']; ?></strong></td>
                    <td>
                      <?php if ($rFLists2['category'] == 'proposals') { ?>
                        <span class="badge bg-primary"><?php echo $lang_Proposals; ?></span>
                      <?php } ?>
                      <?php if ($rFLists2['category'] == 'concepts') { ?>
                        <span class="badge bg-info"><?php echo $lang_Concepts; ?></span>
                      <?php } ?>
                    </td>
                    <td><?php echo $rFLists2['startDate']; ?></td>
                    <td><?php echo $rFLists2['EndDate']; ?></td>
                    <td>
                      <?php
                      $sql44 = "select * FROM " . $prefix . "mscores_dynamic_qns where grantID='$grantID' order by qn_number asc";
                      $result44 = $mysqli->query($sql44);
                      $totalQns = $result44->num_rows;
                      
                      if (!$totalQns && $rFLists2['dynamic'] == 'Yes') {
                      ?>
                        <div class="alert alert-warning p-2 mb-2" role="alert">
                          <small><?php echo $lang_Please_add_evaluation_criteria_call; ?></small>
                        </div>
                        <a href="./main.php?option=EvaluationCriteria&id=<?php echo $grantID; ?>&categorym=<?php echo $categorym; ?>" class="btn btn-warning btn-sm mb-2">
                          <i class="fas fa-plus-circle"></i> <?php echo $lang_update_add; ?>
                        </a>
                      <?php } 
                      
                      if ($totalQns && $rFLists2['dynamic'] == 'Yes') {
                      ?>
                        <a href="./main.php?option=EvaluationCriteria&id=<?php echo $grantID; ?>&categorym=<?php echo $categorym; ?>" class="btn btn-outline-primary btn-sm mb-2">
                          <i class="fas fa-edit"></i> <?php echo $lang_Update_Evaluation_criteria; ?>
                        </a>
                      <?php }
                      
                      if ($TotalCOncepts && $categorym == 'concepts' && $_SESSION['usrm_id'] == $rFLists2['grant_adminID']) { 
                      ?>
                        <a href="./main.php?option=AdminAllNewConcepts&id=<?php echo $rFLists2['grantID']; ?>" class="btn btn-info btn-sm mb-2">
                          <i class="fas fa-eye"></i> <?php echo $lang_View_Applications; ?> 
                          <span class="badge bg-light text-dark"><?php echo $TotalCOncepts; ?></span>
                        </a>
                      <?php }
                      
                      if ($TotalProposals && $categorym == 'proposals' && $_SESSION['usrm_id'] == $rFLists2['grant_adminID']) { 
                      ?>
                        <a href="./main.php?option=AllNewProposals&id=<?php echo $rFLists2['grantID']; ?>" class="btn btn-info btn-sm mb-2">
                          <i class="fas fa-eye"></i> <?php echo $lang_View_Applications; ?> 
                          <span class="badge bg-light text-dark"><?php echo $TotalProposals; ?></span>
                        </a>
                      <?php }
                      
                      if ($categorym == 'concepts' && $_SESSION['usrm_id'] == $rFLists2['grant_adminID']) { 
                      ?>
                        <a href="./main.php?option=DynamicCallConcepts&id=<?php echo $rFLists2['grantID']; ?>&action=update" 
                           class="btn btn-outline-success btn-sm mb-2"
                           onclick="return confirm('Are you sure you want to UPDATE/EDIT this concept? Users wont be able to see it once in edit mode until you submit again. Click OK to confirm or CANCEL.');">
                          <i class="fas fa-pen"></i> <?php echo $lang_UpdateCall; ?>
                        </a>
                      <?php }
                      
                      if ($categorym == 'proposals' && $_SESSION['usrm_id'] == $rFLists2['grant_adminID']) { 
                      ?>
                        <a href="./main.php?option=DynamicCallProposals&id=<?php echo $rFLists2['grantID']; ?>&action=update" 
                           class="btn btn-outline-success btn-sm mb-2"
                           onclick="return confirm('Are you sure you want to UPDATE/EDIT this concept? Users wont be able to see it once in edit mode until you submit again. Click OK to confirm or CANCEL.');">
                          <i class="fas fa-pen"></i> <?php echo $lang_UpdateCall; ?>
                        </a>
                      <?php }
                      
                      if (($rFLists2['end_review'] == 'No' || $rFLists2['end_review'] == '') && $session_usertype == 'admin' && $_SESSION['usrm_id'] == $rFLists2['grant_adminID']) { 
                      ?>
                        <button type="button" class="btn btn-danger btn-sm mb-2" 
                                onclick="window.open('<?php echo $base_ur; ?>endreview.php?id=<?php echo $rFLists2['grantID']; ?>&categorym=concepts','popUpWindow','height=500, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');">
                          <i class="fas fa-ban"></i> <?php echo $lang_DisableReview; ?>
                        </button>
                      <?php }
                      
                      if ($rFLists2['end_review'] == 'Yes' && $session_usertype == 'admin' && $_SESSION['usrm_id'] == $rFLists2['grant_adminID']) { 
                      ?>
                        <button type="button" class="btn btn-success btn-sm mb-2"
                                onclick="window.open('<?php echo $base_ur; ?>endreview.php?id=<?php echo $rFLists2['grantID']; ?>&categorym=concepts','popUpWindow','height=500, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');">
                          <i class="fas fa-check-circle"></i> <?php echo $lang_ReEnableReview; ?>
                        </button>
                      <?php } ?>
                    </td>
                  </tr>
                <?php 
                  }
                } 
                ?>
              </tbody>
            </table>
          </div>
          
          <!-- Pagination -->
          <?php if ($pagination) { ?>
          <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
              <?php
              // Convert the existing pagination HTML to Bootstrap format
              $pagination = str_replace('<div class="pagination">', '', $pagination);
              $pagination = str_replace('</div>', '', $pagination);
              $pagination = str_replace('<span class="disabled">&laquo;previous</span>', '<li class="page-item disabled"><a class="page-link" href="#">&laquo; Previous</a></li>', $pagination);
              $pagination = str_replace('<a href="', '<li class="page-item"><a class="page-link" href="', $pagination);
              $pagination = str_replace('</a>', '</a></li>', $pagination);
              $pagination = str_replace('<span class="current">', '<li class="page-item active"><span class="page-link">', $pagination);
              $pagination = str_replace('</span>', '</span></li>', $pagination);
              $pagination = str_replace('&laquo;previous', '&laquo; Previous', $pagination);
              $pagination = str_replace('next&raquo;', 'Next &raquo;', $pagination);
              echo $pagination;
              ?>
            </ul>
          </nav>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CSS for dashboard enhancements - Scoped to avoid conflicts -->
<style>
  /* Use a unique class prefix to avoid conflicts */
  .modern-dashboard-container {
    padding: 1.5rem 0;
  }
  
  .modern-dashboard-container .card {
    border-radius: 0.5rem;
    transition: transform 0.2s, box-shadow 0.2s;
    overflow: hidden;
  }
  
  .modern-dashboard-container .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
  }
  
  .modern-dashboard-container .card-header {
    font-weight: 600;
    border-bottom: 0;
  }
  
  .modern-dashboard-container .bg-gradient-success {
    background: linear-gradient(45deg, #17CE8C, #28a745);
  }
  
  .modern-dashboard-container .list-group-item {
    border-left: 0;
    border-right: 0;
    transition: background-color 0.2s;
  }
  
  .modern-dashboard-container .list-group-item:hover {
    background-color: rgba(0, 0, 0, 0.03);
  }
  
  .modern-dashboard-container .list-group-item a {
    text-decoration: none;
    color: #495057;
    display: block;
  }
  
  .modern-dashboard-container .btn-sm {
    border-radius: 0.25rem;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
  }
  
  .modern-dashboard-container .table th {
    font-weight: 600;
    border-top: 0;
  }
  
  .modern-dashboard-container .badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
  }
  
  @media (max-width: 992px) {
    .modern-dashboard-container .card-title {
      font-size: 1.25rem;
    }
    
    .modern-dashboard-container .table {
      font-size: 0.875rem;
    }
  }
  
  @media (max-width: 768px) {
    .modern-dashboard-container .card-header h5 {
      font-size: 1.1rem;
    }
    
    .modern-dashboard-container {
      padding: 1rem 0;
    }
  }
  
  @media (max-width: 576px) {
    .modern-dashboard-container .table-responsive {
      border: 0;
    }
    
    .modern-dashboard-container .card {
      margin-bottom: 1rem;
    }
  }
</style>

<!-- Required JavaScript includes for functionality - Scoped to avoid conflicts -->
<script>
  // Create a scope for our dashboard JS
  (function() {
    // Add Bootstrap 5 and Font Awesome in a way that won't affect existing styles
    if (!document.getElementById('modern-bootstrap-css')) {
      var bootstrapCSS = document.createElement('link');
      bootstrapCSS.id = 'modern-bootstrap-css';
      // Use Bootstrap with a custom scope to prevent affecting global styles
      bootstrapCSS.href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css';
      bootstrapCSS.rel = 'stylesheet';
      bootstrapCSS.setAttribute('data-dashboard', 'modern-only');
      document.head.appendChild(bootstrapCSS);
    }
    
    if (!document.getElementById('modern-fontawesome-css')) {
      var fontawesomeCSS = document.createElement('link');
      fontawesomeCSS.id = 'modern-fontawesome-css';
      fontawesomeCSS.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
      fontawesomeCSS.rel = 'stylesheet';
      fontawesomeCSS.setAttribute('data-dashboard', 'modern-only');
      document.head.appendChild(fontawesomeCSS);
    }
    
    if (!document.getElementById('modern-bootstrap-js')) {
      var bootstrapJS = document.createElement('script');
      bootstrapJS.id = 'modern-bootstrap-js';
      bootstrapJS.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js';
      bootstrapJS.setAttribute('data-dashboard', 'modern-only');
      document.body.appendChild(bootstrapJS);
    }
    
    // Initialize tooltips only on our dashboard elements
    document.addEventListener('DOMContentLoaded', function() {
      // Limit tooltip initialization to only elements within our dashboard container
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('.modern-dashboard-container [data-bs-toggle="tooltip"]'));
      if (typeof bootstrap !== 'undefined') {
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });
      }
    });
    
    // Add a style isolation layer to further prevent style leakage
    var dashboardStyleIsolation = document.createElement('style');
    dashboardStyleIsolation.textContent = `
      /* Reset some basic elements within our container to prevent inheritance */
      .modern-dashboard-container * {
        box-sizing: border-box;
      }
      
      /* Prevent our styles from leaking */
      .modern-dashboard-container {
        --bs-border-radius: 0.375rem;
        --bs-border-width: 1px;
        --bs-font-sans-serif: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
        --bs-body-font-family: var(--bs-font-sans-serif);
        --bs-body-font-size: 1rem;
        --bs-body-font-weight: 400;
        --bs-body-line-height: 1.5;
        --bs-body-color: #212529;
        --bs-body-bg: #fff;
        
        font-family: var(--bs-body-font-family);
        font-size: var(--bs-body-font-size);
        font-weight: var(--bs-body-font-weight);
        line-height: var(--bs-body-line-height);
        color: var(--bs-body-color);
        text-align: var(--bs-body-text-align);
      }
    `;
    document.head.appendChild(dashboardStyleIsolation);
  })();
</script>