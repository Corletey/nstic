<style>
  .sidebar-menu .main-menu .menu-inner nav ul li a {
    text-decoration: none;
    border-bottom: none;
  }
</style>
<?php
$sqlConceptLogs = "SELECT * FROM " . $prefix . "conceptsasslogs_new 
                   WHERE conceptm_assignedto='$usrrsmyLoggedIdm' 
                   AND logm_status='new' 
                   ORDER BY assignm_date DESC 
                   LIMIT 0,20";
$QueryConcept = $mysqli->query($sqlConceptLogs);
$rReview = $QueryConcept->fetch_array();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --light-bg: #f8f9fa;
        }
        
        body {
            background-color: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-title {
            background: linear-gradient(45deg, var(--primary-color), #0099ff);
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background: linear-gradient(45deg, var(--primary-color), #0088cc);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            font-weight: 500;
            padding: 15px 20px;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            background: linear-gradient(45deg, var(--primary-color), #0088cc);
            color: white;
            border-radius: 12px 12px 0 0;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <!-- Dashboard Header -->
        <div class="dashboard-title text-center mb-4">
            <h2 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i><?php echo $lang_WelcometoCallManagement; ?></h2>
        </div>
        
        <div class="row g-4">
            <!-- Concepts Card -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-lightbulb me-2"></i><?php echo $lang_Concepts; ?></h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="card-text mb-4"><?php echo $lang_Concepts; ?>:</p>
                        <a href="<?php echo $base_url; ?>main.php?option=DynamicCallConcepts&id=&action=new" 
                           class="btn btn-primary mt-auto">
                            <i class="fas fa-edit me-2"></i><?php echo $lang_customizeCallforConcepts; ?>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Proposals Card -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0"><i class="fas fa-file-contract me-2"></i><?php echo $lang_Proposals; ?></h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <p class="card-text mb-4"><?php echo $lang_Proposals; ?>:</p>
                        <a href="<?php echo $base_url; ?>main.php?option=DynamicCallProposals&id=&action=new" 
                           class="btn btn-primary mt-auto">
                            <i class="fas fa-edit me-2"></i><?php echo $lang_customizeCallforProposals; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="callOptionsModal" tabindex="-1" aria-labelledby="callOptionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="callOptionsModalLabel"><?php echo $lang_Concept; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <div class="d-grid gap-3">
                                <a href="./main.php?option=SubmitCallConcepts/" class="btn btn-outline-primary">
                                    <?php echo $lang_LoadthedefaultcallforConcepts; ?>
                                </a>
                                <a href="./main.php?option=DynamicCallConcepts" class="btn btn-outline-primary">
                                    <?php echo $lang_CreateCustomcallforConcepts; ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-grid gap-3">
                                <a href="./main.php?option=SubmitCallProposals" class="btn btn-outline-primary">
                                    <?php echo $lang_CreateCustomcallforConcepts; ?>
                                </a>
                                <a href="./main.php?option=DynamicCallProposals" class="btn btn-outline-primary">
                                    <?php echo $lang_CreateCustomcallforConcepts; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript for modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modalButtons = document.querySelectorAll('[data-toggle="modal"]');
            modalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const target = this.getAttribute('data-target');
                    const modal = new bootstrap.Modal(document.querySelector(target));
                    modal.show();
                });
            });
        });
    </script>
</body>
</html>