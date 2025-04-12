<?php
$sessionusrm_id = $_SESSION['usrm_id'];
$sqlFListsconcepts = "SELECT * FROM ".$prefix."submissions_concepts WHERE invited_for_proposal='invited' AND owner_id='$sessionusrm_id'";
$QueryFListconcepts = $mysqli->query($sqlFListsconcepts);
$rsOwnerconcepts = $QueryFListconcepts->fetch_array();
$totalFLconcepts = $QueryFListconcepts->num_rows;
?>
<style>
    /* Quick Links Section Styles */
.quick-links-container {
    background-color: var(--panel-bg);
    border-radius: 0.5rem;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    margin-bottom: 2rem;
}

.quick-links-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
    padding: 1.5rem;
}

.quick-link-card {
    display: flex;
    align-items: center;
    padding: 1.25rem;
    background-color: var(--bg-light);
    border-radius: 0.5rem;
    border: 1px solid var(--border-color);
    text-decoration: none;
    transition: var(--transition);
}

.quick-link-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-sm);
    border-color: var(--primary-color);
    text-decoration: none;
}

.quick-link-card .card-icon {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    margin-right: 1rem;
    flex-shrink: 0;
}

.quick-link-card:nth-child(2) .card-icon {
    background-color: var(--secondary-color);
}

.quick-link-card:nth-child(3) .card-icon {
    background-color: var(--info-color);
}

.count-badge {
    display: inline-block;
    background-color: rgba(0, 0, 0, 0.1);
    color: var(--text-color);
    padding: 0.15rem 0.5rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 600;
    transition: var(--transition);
}

.quick-link-card:hover .count-badge {
    background-color: var(--primary-color);
    color: white;
}

.unknown-count {
    opacity: 0.6;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .quick-links-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
        padding: 1rem;
    }
}
</style>
<!-- Quick Links Section -->
<div class="quick-links-container">
    <div class="section-header">
        <h2><i class="fas fa-link"></i> <?php echo $lang_QuickLinks ?? 'Quick Links'; ?></h2>
    </div>
    
    <div class="quick-links-grid">
        <!-- Call for Concepts Card -->
        <a href="./main.php?option=usrCallforConcepts" class="quick-link-card">
            <div class="card-icon">
                <i class="fas fa-lightbulb"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $lang_CallforConcepts ?? 'Call for Concepts'; ?></h3>
                <div class="count-badge">
                    <?php if(function_exists('TotalCallforConcepts')): ?>
                        <?php echo TotalCallforConcepts(); ?>
                    <?php else: ?>
                        <span class="unknown-count">–</span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
        
        <!-- Choose between Call for Proposals OR Submitted Concepts based on condition -->
        <?php if($totalFLconcepts): ?>
        <a href="./main.php?option=usrCallforProposals" class="quick-link-card">
            <div class="card-icon">
                <i class="fas fa-file-signature"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $lang_CallforProposals ?? 'Call for Proposals'; ?></h3>
                <div class="count-badge">
                    <?php if(function_exists('TotalCallforProposals')): ?>
                        <?php echo TotalCallforProposals(); ?>
                    <?php else: ?>
                        <span class="unknown-count">–</span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
        <?php else: ?>
        <!-- Submitted Concepts Card (shown only if Call for Proposals is not shown) -->
        <a href="./main.php?option=usrSubmittedConcepts" class="quick-link-card">
            <div class="card-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $lang_SubmittedConcepts ?? 'Submitted Concepts'; ?></h3>
                <div class="count-badge">
                    <?php if(function_exists('TotalSubmittedConcepts')): ?>
                        <?php echo TotalSubmittedConcepts(); ?>
                    <?php else: ?>
                        <span class="unknown-count">–</span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
        <?php endif; ?>
        
        <!-- Submitted Proposals Card (always shown) -->
        <a href="./main.php?option=usrSubmittedProposals" class="quick-link-card">
            <div class="card-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="card-content">
                <h3><?php echo $lang_SubmittedProposals ?? 'Submitted Proposals'; ?></h3>
                <div class="count-badge">
                    <?php if(function_exists('TotalSubmittedProposals')): ?>
                        <?php echo TotalSubmittedProposals(); ?>
                    <?php else: ?>
                        <span class="unknown-count">–</span>
                    <?php endif; ?>
                </div>
            </div>
        </a>
    </div>
</div>