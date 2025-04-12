<?php
session_start();
require_once('contrlrcn/c_mlsrcontrol.php');
timeout($timeout);
if (!$mysqli->real_escape_string($_SESSION['usrm_username']) and !$mysqli->real_escape_string($_SESSION['usrm_id'])) {
    echo '<meta http-equiv="REFRESH" content="0;url=../">';

    die;
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <base href="<?php echo $base_url; ?>" />
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $sitename; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">


    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/app/assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>

    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script language="JavaScript" type="text/javascript" src="js/ajax_populate.js"></script>
    <script language="javascript" type="text/javascript">
        function popitup(url) {
            newwindow = window.open(url, 'name', 'height=680,width=650');
            if (window.focus) {
                newwindow.focus()
            }
            return false;
        }
    </script>
    <script>
        function showTeam(str) {
            if (str == "") {
                document.getElementById("txtHintTeam").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHintTeam").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "viewlrcn/search_team_members.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>
    <script>
        function showUser(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "viewlrcn/search_themes.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
         
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        <!-- sidebar menu area start -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="./main.php?option=dashboard"><img src="assets/images/icon/logo.png" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <nav>
                        <?php include("viewlrcn/menu.php"); ?>
                    </nav>
                </div>
            </div>
        </div>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="search-box pull-left">
                            <div class="pull-right">
                                <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $lang_chooselanguage; ?></span><i class="fa fa-angle-down"></i></h4>
                                <div class="dropdown-menu">
                                    <li class="nav-item"><a href="./main.php?lang=en" class="dropdown-item" <?php if ($base_lang == 'en') { ?>style="color:#F00;" <?php } ?>>English</a></li>
                                    <li class="nav-item"><a href="./main.php?lang=fr" class="dropdown-item" <?php if ($base_lang == 'fr') { ?>style="color:#F00;" <?php } ?>>French</a></li>
                                    <li class="nav-item"><a href="./main.php?lang=pt" class="dropdown-item" <?php if ($base_lang == 'pt') { ?>style="color:#F00;" <?php } ?>>Portuguese</a></li>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                            <li class="dropdown">
                                <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
                                    <span>0</span>
                                </i>

                            </li>

                            <li class="settings-btn">
                                <i class="ti-settings"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left"><?php echo $lang_Grants; ?></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="./main.php?option=dashboard"><?php echo $lang_home; ?></a></li>
                                <li><span>Dashboard</span></li>
                            </ul>
                        </div>


                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <?php photo(); ?>
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['usrm_username']; ?> <br><span style="color:#9F6; font-size:11px; font-weight:bold;"><?php if ($_SESSION['usrm_usrtype'] == 'user') {
                                                                                                                                                                                                        echo "$lang_Applicant";
                                                                                                                                                                                                    }
                                                                                                                                                                                                    if ($_SESSION['usrm_usrtype'] == 'superadmin') {
                                                                                                                                                                                                        echo "$lang_Superadmin";
                                                                                                                                                                                                    }
                                                                                                                                                                                                    if ($_SESSION['usrm_usrtype'] == 'admin') {
                                                                                                                                                                                                        echo "$lang_GrantsOffice";
                                                                                                                                                                                                    }
                                                                                                                                                                                                    if ($_SESSION['usrm_usrtype'] == 'reviewer') {
                                                                                                                                                                                                        echo "$lang_Reviewer";
                                                                                                                                                                                                    } ?></span><i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">

                                <a class="dropdown-item" href="signout.php?Logout"><?php echo $lang_LogOut; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <div class="main-content-inner">

                <?php if ($session_usertype == 'superadmin' || $session_usertype == 'admin' and $category == 'dashboard') {
                    require_once("viewlrcn/welcome_dashboard_admin.php");
                } ?>


                <?php
                $pages_list = array(
                    'dashboard' => 'welcome_dashboard',
                    'SubmitConcept' => 'concept_first_information',
                    'UpdateMySubmitConcept' => 'concept_first_information_update',
                    'conceptPrincipalInvestigator' => 'concept_principal_investigator',
                    'conceptPrincipalInvestigatorDelete' => 'concept_principal_investigator',
                    'conceptTeamMembers' => 'concept_team_members',
                    'conceptIntroduction' => 'concept_introduction',
                    'conceptProjectDetails' => 'concept_project_details',
                    'conceptProjectDetailsDel' => 'concept_project_details',
                    'conceptBudget' => 'concept_budget',
                    'conceptReferences' => 'concept_references',
                    'conceptSubmitNow' => 'concept_make_final_submission',
                    'reviewProjectInformation' => 'concept_review_project_information',
                    'ReviewconceptPrincipalInvestigator' => 'concept_review_principal_investigator',
                    'ReviewconceptIntroduction' => 'concept_review_introduction',
                    'ReviewconceptProjectDetails' => 'concept_review_project_details',
                    'ReviewconceptBudget' => 'concept_review_budget',
                    'ReviewconceptReferences' => 'concept_review_references',
                    'ReviewconceptAttachments' => 'concept_review_attachments',
                    'ReviewconceptAction' => 'concept_assign_to_approve_reject',
                    'ReviewconceptAssign' => 'concept_assign_to_reviewers',
                    'AdminPendingConcepts' => 'admin_pending_concepts',
                    'AdminRejectedConcepts' => 'admin_rejected_concepts',
                    'AdminApprovedReview' => 'admin_approved_for_concepts',
                    'AdminPendingReview' => 'admin_concepts_pending_reviewon_reviewers',
                    'AdminReviewedConcepts' => 'admin_concepts_reviewedby_reviewers',
                    'admins' => 'all_admins',
                    'Reviewers' => 'all_reviewers',
                    'Users' => 'all_users',
                    'DisableUsers' => 'all_users',
                    'Logs' => 'all_logs',
                    'CallProposals' => 'all_submited_call_for_proposals',
                    'CallConcepts' => 'all_submited_call_for_concepts',
                    'UpdateSubmitCallConcepts' => 'update_call_for_concepts',
                    'UpdateSubmitCallProposals' => 'update_call_for_proposals',
                    'conceptScoreReviewers' => 'concept_score_reviewers',
                    'conceptScoreReviewersFinal' => 'concept_score_reviewers_finalsubmission',
                    'conceptScoreReviewersUpdate' => 'concept_score_reviewers_update',
                    'PendingConceptsReviewer' => 'reviewer_pending_concepts',
                    'PendingProposalReviewer' => 'reviewer_pending_proposals',
                    'CompleteConceptsReviewer' => 'reviewer_complete_concepts',
                    'CompleteProposalReviewer' => 'reviewer_complete_proposals',
                    'SubmitCallProposals' => 'submit_call_for_proposals',
                    'SubmitCallConcepts' => 'submit_call_for_concepts',
                    'upusers' => 'update_user',
                    'Addusers' => 'add_user',
                    'AddReviewers' => 'add_reviewers',
                    'suser' => 'successm_cfnusers',
                    'NewProposals' => 'new_submited_proposals',
                    'AllNewProposals' => 'new_submited_proposals2',
                    'AllNewDynamicProposals' => 'new_submited_proposals_dynamic',
                    'AdminPendingProposals' => 'proposals_pending_admin_review',
                    'AdminRejectedProposals' => 'proposals_rejected_admin_review',
                    'AdminApprovedProposalsReview' => 'proposals_scheduled_for_review_admin',
                    'AdminScheduledProposalsReview' => 'proposals_scheduled_for_review_admin',
                    'AdminPendingProposalsReview' => 'proposals_pending_review_onreviewer',
                    'AdminReviewedProposals' => 'proposals_reviewed_by_reviewers',
                    'conceptAddEducationBackground' => 'concept_add_education_background',
                    'conceptAddResearchExperience' => 'concept_add_research_experience',
                    'conceptAddEducationBackgroundAdmin' => 'concept_add_education_background_admin',
                    'conceptAddResearchExperienceAdmin' => 'concept_add_research_experience_admin',
                    'UserConcepts' => 'user_my_concepts_submitted',

                    'SubmitProposal' => 'proposal_first_information',
                    'proposalBackground' => 'proposal_project_background_objectives',
                    'proposalMethodology' => 'proposal_project_approach_methodology',
                    'proposalResults' => 'proposal_project_results',
                    'proposalResearchTeam' => 'proposal_project_research_team',
                    'proposalManagement' => 'proposal_project_management',
                    'proposalFollowup' => 'proposal_project_followup',
                    'proposalBudget' => 'proposal_project_budget',
                    'proposalSubmitNow' => 'proposal_make_final_submission',
                    'proposalAddEducationBackground' => 'proposal_add_education_background',
                    'AdminNewConcepts' => 'admin_new_concepts',
                    'AdminAllNewConcepts' => 'admin_new_concepts2',
                    'AdminAllNewDynamicConcepts' => 'admin_new_concepts_dynamic',
                    'NotConsideredforAward' => 'admin_new_concepts_dynamic',
                    'AdminEditDynamicCall' => 'admin_edit_dynamic_call',
                    'AdminEditDynamicConcept' => 'admin_edit_dynamic_concepts',
                    'conceptEducationBackground' => 'concept_review_background',
                    'conceptAttachments' => 'concept_attachments',

                    'reviewPrososal' => 'review_proposal_first_information',
                    'reviewProjectTeam' => 'review_proposal_project_research_team',
                    'reviewproposalBackground' => 'review_proposal_project_background_objectives',
                    'reviewproposalMethodology' => 'review_proposal_project_approach_methodology',
                    'reviewproposalBudget' => 'review_proposal_project_budget',
                    'reviewproposalResults' => 'review_proposal_project_results',
                    'reviewproposalManagement' => 'review_proposal_project_management',
                    'reviewproposalFollowup' => 'review_proposal_project_followup',
                    'reviewProposalEducationBackground' => 'review_proposal_education_background',
                    'proposalScoreReviewers' => 'proposal_score_reviewers',
                    'proposalScoreFinal' => 'proposal_score_reviewers_finalsubmission',
                    'ReviewproposalAssign' => 'proposal_assign_to_reviewers',
                    'InviteForFullProposal' => 'admin_new_concepts2',


                    'usrCallforConcepts' => 'user_call_for_concepts',
                    'usrCallforProposals' => 'user_call_for_proposals',
                    'usrSubmittedConcepts' => 'user_submitted_concepts',
                    'usrSubmittedProposals' => 'user_submitted_proposals',
                    'MyAccount' => 'myaccount_details',
                    'Reports' => 'listm_cfnreport',
                    'ReportsPr' => 'listm_cfnreport2',
                    'CustomReports' => 'custom_reports',
                    'ConceptAnalytics' => 'concept_analytics',
                    'ProposalAnalytics' => 'proposal_analytics',
                    'MonitoringReports' => 'monitoring_reports',
                    'TechnicalReports' => 'technical_reports',
                    'FinancialReports' => 'financial_reports',

                    'ConflictofInterestConcepts' => 'conflict_of_interest_concepts',
                    'ConflictofInterestProposals' => 'conflict_of_interest_proposals',
                    'ReviewerallProposals' => 'reviewer_all_proposals',
                    'urRequestforFunds' => 'request_for_funds_step_one',
                    'RequestforFunds' => 'request_for_funds',
                    'urRequestforFundsResubmit' => 'request_for_funds',
                    'RequestforFundsDel' => 'request_for_funds',
                    'RequestforFundsFinal' => 'request_for_funds_final_submission',
                    'RequestforProcFinal' => 'request_for_procument_final_submission',
                    'RequestforProcurement' => 'request_for_procurement',
                    'RequestforProcurementDel' => 'request_for_procurement',
                    'grantcalls' => 'grantcalls_dashboard_stats',
                    'DynamicCallConcepts' => 'dynamic_concept_calls_add_categories',
                    'DynamicCallConceptsUpdate' => 'dynamic_concept_calls_categories_update',
                    'DynamicCallConceptsQns' => 'dynamic_concept_calls_add_questions',
                    'DynamicCallProposals' => 'dynamic_proposal_calls_add_categories',

                    'DynamicCallProposalsUpdate' => 'dynamic_proposal_calls_categories_update',
                    'DynamicCallProposalQns' => 'dynamic_proposal_calls_add_questions',
                    'SubmitCallforConceptNew' => 'dynamic_submit_call_for_concept',
                    'SubmitCallforProposalNew' => 'dynamic_submit_call_for_proposal',

                    'FundsApplications' => 'request_for_funds_applications',
                    'ProcurementApplications' => 'request_for_procurement_applications',
                    'ProgressReports' => 'all_progress_reports',
                    'AdmProgressReports' => 'all_progress_reports_admin',
                    'submitProgressReport' => 'submit_progress_reports',
                    'UpdateProgressReport' => 'update_progress_reports',
                    'ClosureReports' => 'all_closure_reports',

                    'Abstract' => 'submit_progress_abstract',
                    'SummaryofScientificProgress' => 'submit_progress_summaryof_scientific_progress',
                    'KeyPersonnelEffort' => 'submit_progress_key_personnel_effort',
                    'Publications' => 'submit_progress_publications',
                    'reportSubmitNow' => 'progress_report_make_final_submission',


                    'reviewProgressReport' => 'review_progress_reports',
                    'reviewAbstract' => 'review_progress_abstract',
                    'reviewSummaryofScientificProgress' => 'review_progress_summaryof_scientific_progress',
                    'reviewKeyPersonnelEffort' => 'review_progress_key_personnel_effort',
                    'reviewPublications' => 'review_progress_publications',
                    'ReviewActionReport' => 'review_report_make_final_submission',
                    'ReviewActionReportRevisions' => 'review_report_make_final_submission_revisions',
                    'HaltedStudiesUser' => 'halted_studies_user',
                    'HaltedStudiesAdmin' => 'halted_studies_admin',

                    'SubmitConceptDynamic' => 'dynamic_concept_stage_one',
                    'SubmitProposalDynamic' => 'dynamic_proposal_stage_one',
                    'dynamicConceptSubmitNow' => 'dynamic_concept_make_final_submission',
                    'dynamicProposalSubmitNow' => 'dynamic_proposal_make_final_submission',

                    'reviewDynamicConceptinformation' => 'review_dynamic_concept_information',
                    'ReviewDynamicconceptAction' => 'dynamic_concept_assign_to_approve_reject',
                    'ReviewDynamicconceptAssign' => 'dynamic_concept_assign_to_reviewers',
                    'reviewDynamicProposalinformation' => 'review_dynamic_proposal_information',
                    'ReviewDynamicProposalAction' => 'dynamic_proposal_assign_to_approve_reject',
                    'ReviewDynamicProposalAssign' => 'dynamic_proposal_assign_to_reviewers',

                    'ConceptViewAdmin' => 'concept_view_details_admin',

                    'reviewDynamicReviewer' => 'review_dynamic_concept_information',
                    'DynamicconceptScoreReviewers' => 'dynamic_concept_score_reviewers_final',
                    'EvaluationCriteriaMain' => 'dynamic_evaluation_criteria_main',
                    'EvaluationCriteria' => 'dynamic_evaluation_criteria',
                    'EvaluationCriteriaDel' => 'dynamic_evaluation_criteria',
                    'EvaluationCriteriaUpdate' => 'dynamic_evaluation_criteria',
                    'UserEditDynamicSubmission' => 'user_edit_dynamic_pending_submission',
                    'CompletenessCheck' => 'dynamic_concepts_completeness_check',
                    'ApprovedConceptsAdmin' => 'dynamic_concepts_approved_concepts', //New Dynamic submissiom  
                    'newSubmitConcept' => 'new_dynamic_concept_first_information',
                    'newconceptPrincipalInvestigator' => 'new_dynamic_concept_principal_investigator',
                    'newconceptIntroduction' => 'new_dynamic_concept_introduction',
                    'newconceptProjectDetails' => 'new_dynamic_concept_project_details',
                    'newconceptBudget' => 'new_dynamic_concept_budget',
                    'newconceptReferences' => 'new_dynamic_concept_references',
                    'newconceptAttachments' => 'new_dynamic_concept_attachments',
                    'newconceptAddEducationBackground' => 'new_dynamic_concept_add_education_background',
                    'newconceptAddResearchExperience' => 'new_dynamic_concept_add_research_experience',
                    'newconceptPrincipalInvestigatorDelete' => 'new_dynamic_concept_principal_investigator',
                    'newconceptProjectDetailsDel' => 'new_dynamic_concept_project_details',
                    'newreviewProjectInformation' => 'dynamic_concept_review_project_information',
                    'newReviewconceptPrincipalInvestigator' => 'dynamic_concept_review_principal_investigator',
                    'newReviewconceptIntroduction' => 'dynamic_concept_review_introduction',
                    'newReviewconceptProjectDetails' => 'dynamic_concept_review_project_details',
                    'newReviewconceptBudget' => 'dynamic_concept_review_budget',
                    'newReviewconceptReferences' => 'dynamic_concept_review_references',
                    'newReviewconceptAttachments' => 'dynamic_concept_review_attachments',
                    'newconceptEducationBackground' => 'dynamic_concept_review_background',
                    'newReviewconceptAction' => 'dynamic_concept_assign_to_approve_reject',
                    'newReviewconceptAssign' => 'dynamic_concept_assign_to_reviewers',
                    'newconceptScoreReviewers' => 'dynamic_concept_score_reviewers',
                    'EditDynamicProposal' => 'admin_edit_dynamic_proposal',

                    'newSubmitProposal' => 'dynamic_proposal_first_information',
                    'newSubmitProposalUpdate' => 'dynamic_proposal_first_information_stepone',
                    'newproposalBackground' => 'dynamic_proposal_project_background_objectives',
                    'newproposalMethodology' => 'dynamic_proposal_project_approach_methodology',
                    'newproposalResults' => 'dynamic_proposal_project_results',
                    'newproposalResearchTeam' => 'dynamic_proposal_project_research_team',
                    'newproposalManagement' => 'dynamic_proposal_project_management',
                    'newproposalFollowup' => 'dynamic_proposal_project_followup',
                    'newproposalBudget' => 'dynamic_proposal_project_budget',
                    'newproposalSubmitNow' => 'dynamic_proposal_make_final_submission',
                    'newproposalAddEducationBackground' => 'dynamic_proposal_add_education_background',

                    'newreviewPrososal' => 'dynamic_review_proposal_first_information',
                    'newreviewProjectTeam' => 'dynamic_review_proposal_project_research_team',
                    'newreviewproposalBackground' => 'dynamic_review_proposal_project_background_objectives',
                    'newreviewproposalMethodology' => 'dynamic_review_proposal_project_approach_methodology',
                    'newreviewproposalBudget' => 'dynamic_review_proposal_project_budget',
                    'newreviewproposalResults' => 'dynamic_review_proposal_project_results',
                    'newreviewproposalManagement' => 'dynamic_review_proposal_project_management',
                    'newreviewproposalFollowup' => 'dynamic_review_proposal_project_followup',
                    'newreviewProposalEducationBackground' => 'dynamic_review_proposal_education_background',
                    'newreviewproposalReferences' => 'dynamic_review_proposal_references',
                    'newreviewproposalAttachments' => 'dynamic_review_proposal_attachments',
                    'newReviewproposalAssign' => 'dynamic_proposal_assign_to_reviewers',

                    'newproposalScoreReviewers' => 'dynamic_proposal_score_reviewers',
                    'newConceptMySubmission' => 'concept_edit_my_submission',
                    'ApprovedProposalsAdmin' => 'dynamic_proposals_approved_concepts',



                    'newProposalReferences' => 'dynamic_proposal_references',
                    'newProposalAttachments' => 'dynamic_proposal_attachments',
                    'GrantsAwarded' => 'grants_awarded',
                    'GrantsUserAwarded' => 'grants_awarded_user',
                    'ListofResearchers' => 'list_of_researchers',
                    'ViewPI' => 'view_pi_details',
                    'ManageCategories' => 'manage_categories',
                    'ManageCategoriesUpdate' => 'manage_categories',


                    'conceptNewSubmissions' => 'stats_concept_new_submission',
                    'proposalNewSubmissions' => 'stats_proposal_new_submission',
                    'CompletenessCheckProposal' => 'stats_proposal_new_submission',
                    'conceptNewSubmissionsMain' => 'stats_concept_new_submission_main',
                    'proposalNewSubmissionsMain' => 'stats_proposal_new_submission_main',
                    'userproposalNewSubmissions' => 'user_submitted_proposals_main',
                    'userconceptsNewSubmissions' => 'user_submitted_concepts_main',
                    'userconceptDetails' => 'user_call_for_concepts_details',
                    'ReviewerPerfomance' => 'reviewer_perfomance',
                    'AnylysisofReviewers' => 'anylysis_of_reviewers',
                    'GrantsWonbyInstitution' => 'grants_won_by_institution',
                    'Amendments' => 'all_amendments',
                    'SubmitAmendments' => 'submit_amendments',
                    'UpdateAmendments' => 'update_amendments',
                    'ViewAmendments' => 'view_amendment',

                    'Pages' => 'pages_pages',
                    'UpdatePage' => 'pages_pages_update',
                    'PagesDelete' => 'pages_pages',
                    'Slider' => 'pages_slider',
                    'UpdateSlider' => 'pages_slider_update',
                    'SliderDelete' => 'pages_slider',

                    'Sponsors' => 'pages_sponsors',
                    'UpdateSponsors' => 'pages_sponsors_update',
                    'SponsorsDelete' => 'pages_sponsors',

                    'SocialMedia' => 'pages_social_media',
                    'SiteConfiguration' => 'site_configuration',
                    'reviewerviewall' => 'reviewer_perfomance_viewall',
                    'DraftCalls' => 'draft_calls_incomplete',

                    'urRequestforFundsConcept' => 'request_for_funds_step_one_concept',
                    'RequestforFundsConcept' => 'request_for_funds_concept',
                    'urRequestforFundsResubmitConcept' => 'request_for_funds_concept',
                    'RequestforFundsDelConcept' => 'request_for_funds_concept',
                    'RequestforFundsFinalConcept' => 'request_for_funds_final_submission_concept',
                    'RequestforProcurementConcept' => 'request_for_procurement_concept',
                    'RequestforProcurementDelConcept' => 'request_for_procurement_concept',
                    'newproposalResearchTeamUpdate' => 'new_proposal_research_team_update',
                );

                $array_file = 'viewlrcn/' . $pages_list[$category] . ".php";
                $array_file = (file_exists($array_file)) ? $array_file : 'viewlrcn/error_pager.php';
                //echo $array_file;
                include($array_file);

                ?>







            </div>
            <!-- row area end -->

            <!-- row area start-->
        </div>
    </div>
    <!-- main content area end -->
    <!-- footer area start-->
    <footer>
        <div class="footer-area">
            <p>© Copyright 2020 - <?php echo $year; ?>. All right reserved. <?php echo $lang_grants_management_system; ?>.</p>
        </div>
    </footer>
    <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
    <div class="offset-area">
        <div class="offset-close"><i class="ti-close"></i></div>
        <ul class="nav offset-menu-tab">
            <li><a class="active" data-toggle="tab" href="#activity">Activity</a></li>
            <li><a data-toggle="tab" href="#settings">Settings</a></li>
        </ul>
        <div class="offset-content tab-content">
            <div id="activity" class="tab-pane fade in show active">
                <div class="recent-activity">
                    <div class="timeline-task">
                        <div class="icon bg1">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Moses Mawanda sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:35</span>
                        </div>
                        <p>Good Morning, we have submitted our Grant
                        </p>
                    </div>

                    <div class="timeline-task">
                        <div class="icon bg2">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="tm-title">
                            <h4>Mwesigwa Collins sent you an email</h4>
                            <span class="time"><i class="ti-time"></i>09:20 Am</span>
                        </div>
                    </div>






                </div>
            </div>
            <div id="settings" class="tab-pane fade">
                <div class="offset-settings">
                    <h4>General Settings</h4>
                    <div class="settings-list">
                        <div class="s-settings">
                            <div class="s-sw-title">
                                <h5>System Updates</h5>
                                <div class="s-swtich">
                                    <input type="checkbox" id="switch1" />
                                    <label for="switch1">Toggle</label>
                                </div>
                            </div>
                            <p>Coming Soon</p>
                        </div>



                    </div>
                </div>
            </div>
        </div>


        <?php if ($category == 'reviewProjectInformation' || $category == 'ReviewconceptPrincipalInvestigator' || $category == 'ReviewconceptIntroduction' || $category == 'ReviewconceptProjectDetails' || $category == 'ReviewconceptBudget' || $category == 'ReviewconceptReferences' || $category == 'reviewDynamicConceptinformation' || $category == 'newreviewProjectInformation' || $category == 'newReviewconceptPrincipalInvestigator' || $category == 'newReviewconceptIntroduction' || $category == 'newReviewconceptProjectDetails' || $category == 'newReviewconceptBudget' || $category == 'newReviewconceptReferences' || $category == 'newReviewconceptAttachments' and $session_usertype == 'reviewer') { ?>
            <button id="myBtn2"><?php echo $lang_Score_click; ?> </button>


            <!-- The Modal -->
            <div id="myModal" class="modal">

                <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                        <h3><strong><?php echo $lang_DraftScoreSheet; ?></strong></h3>
                    </div>
                    <div class="modal-body" style="height:450px; overflow:scroll; padding:5px;">

                        <?php if ($category != 'reviewDynamicConceptinformation') {
                            include("viewlrcn/concept_score_reviewers_draft.php");
                        }
                        if ($category == 'reviewDynamicConceptinformation') {
                            include("viewlrcn/concept_score_reviewers_draft_dynamic.php");
                        }
                        ?>
                    </div>
                </div>
            </div>




            <script>
                // Get the modal
                var modal = document.getElementById('myModal');

                // Get the button that opens the modal
                var btn = document.getElementById("myBtn2");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks the button, open the modal 
                btn.onclick = function() {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script>
        <?php } ?>




        <?php if ($category == 'reviewPrososal' || $category == 'reviewProjectTeam' || $category == 'reviewproposalBackground' || $category == 'reviewproposalMethodology' || $category == 'reviewproposalBudget' || $category == 'reviewproposalResults' || $category == 'reviewproposalManagement' || $category == 'reviewproposalFollowup' || $category == 'newreviewPrososal' || $category == 'newreviewProjectTeam' || $category == 'newreviewproposalBackground' || $category == 'newreviewproposalMethodology' || $category == 'newreviewproposalBudget' || $category == 'newreviewproposalResults' || $category == 'newreviewproposalManagement' || $category == 'newreviewproposalFollowup' and $session_usertype == 'reviewer' and $category != 'grantcalls') { ?>
            <button id="myBtn2"><?php echo $lang_ProposalScore_click; ?> </button>


            <!-- The Modal -->
            <div id="myModal" class="modal">

                <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close">&times;</span>
                        <h3><strong><?php echo $lang_DraftScoreSheet; ?></strong></h3>
                    </div>
                    <div class="modal-body" style="height:450px; overflow:scroll; padding:5px;">

                        <?php include("viewlrcn/proposal_score_reviewers_draft.php"); ?>
                    </div>
                </div>
            </div>




            <script>
                // Get the modal
                var modal = document.getElementById('myModal');

                // Get the button that opens the modal
                var btn = document.getElementById("myBtn2");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks the button, open the modal 
                btn.onclick = function() {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script>
        <?php } ?>

        <?php if ($category != 'reviewProjectInformation' and $category != 'ReviewconceptPrincipalInvestigator' and $category != 'ReviewconceptIntroduction' and $category != 'ReviewconceptProjectDetails' and $category != 'ReviewconceptBudget' and $category != 'ReviewconceptReferences' and $category != 'grantcalls' and $category != 'newreviewProjectInformation' and $category != 'newReviewconceptPrincipalInvestigator' and $category != 'newReviewconceptIntroduction' and $category != 'newReviewconceptProjectDetails' and $category != 'newReviewconceptBudget' and $category != 'newReviewconceptReferences' and $category != 'newReviewconceptAttachments') { ?>



            <script>
                // Get the modal
                var modal = document.getElementById('myModal');

                // Get the button that opens the modal
                var btn = document.getElementById("myBtn");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks the button, open the modal 
                btn.onclick = function() {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script><?php } ?>

        <?php if ($category == 'grantcalls') { ?><script>
                // Get the modal
                var modal = document.getElementById('id01');

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script><?php } ?>
        <!-- offset area end -->
        <!-- jquery latest version -->




        <?php /*?><?php */ ?><script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
        <!-- bootstrap 4 js -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/metisMenu.min.js"></script>
        <script src="assets/js/jquery.slimscroll.min.js"></script>
        <script src="assets/js/jquery.slicknav.min.js"></script>


        <!--Begin Word count-->
        <?php /*?><script type="text/javascript" src="js/jquery-1.7.2.min.js"></script><?php */ ?>
        <script type="text/javascript" src="js/jquery.inputlimiter.1.3.1.min.js"></script>
        <script type="text/javascript" src="js/word-count.js"></script>
        <link rel="stylesheet" type="text/css" href="js/jquery.inputlimiter.1.0.css" />
        <!--End Word count-->

        <?php /*?>    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script><?php */ ?>
        <!-- others plugins -->
        <script src="assets/js/plugins.js"></script>
        <script src="assets/js/scripts.js"></script>




        <!--  <script type="text/javascript"> 
        function googleTranslateElementInit() { 
            new google.translate.TranslateElement(
                {pageLanguage: 'en',includedLanguages: 'en,pt,fr,es', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 
				
                'google_translate_element'
            ); 
        } 
    </script> 
      
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>-->



        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/60781d5a067c2605c0c2ac67/1f3aj5cdj';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
        <!--End of Tawk.to Script-->
</body>

</html>