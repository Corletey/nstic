  <?php
  if ($session_usertype == 'superadmin') { ?>
    <ul class="metismenu" id="menu">
      <li class="<?php if ($category == 'conceptNewSubmissions' || $category == 'grantcalls' || $category == 'CompletenessCheck' || $category == 'proposalNewSubmissions' || $category == 'DynamicCallConcepts' || $category == 'DynamicCallConceptsUpdate' || $category == 'SubmitCallforConceptNew' || $category == 'dashboard' || $category == 'ProcurementApplications' || $category == 'CallConcepts' || $category == 'EvaluationCriteria') { ?>active<?php } ?>" style="border-bottom:1px #8d97ad solid;">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span><?php echo $lang_Submissions_Management; ?></span></a>
        <ul class="collapse">
          <h5><?php echo $lang_Concepts; ?> </h5>
          <li><a href="./main.php?option=conceptNewSubmissions&status=Pending Review"><?php echo $lang_New_Submissions; ?> <span class="badgem bg-green"><?php PendingReviewConceptsAdmin(); ?></span></a></li>

          <li><a href="./main.php?option=conceptNewSubmissions&status=Pending Final Submission"><?php echo $lang_DraftConcepts; ?> <span class="badgem bg-maroon"><?php DraftConceptsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=conceptNewSubmissions&status=Rejected"><?php echo $lang_RejectedConcepts; ?> <span class="badgem bg-red"><?php RejectedConceptsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=CompletenessCheck"><?php echo $lang_CompletenessCheck; ?> <span class="badgem bg-aqua"><?php CompletenessCheckConceptsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=conceptNewSubmissions&status=Scheduled for Review"><?php echo $lang_UnderReview; ?> <span class="badgem bg-orange"><?php ScheduledforReviewConceptsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=conceptNewSubmissions&status=Reviewed"><?php echo $lang_ReviewedConcepts; ?> <span class="badgem bg-blue"><?php ApprovedConceptsAdmin(); ?></span></a></li>



          <h5><?php echo $lang_Proposals; ?></h5>
          <li><a href="./main.php?option=proposalNewSubmissions&status=Pending Review"><?php echo $lang_NewSubmissions; ?> <span class="badgem bg-green"><?php PendingReviewProposalsAdmin(); ?></span></a></li>

          <li><a href="./main.php?option=proposalNewSubmissions&status=Pending Final Submission"><?php echo $lang_DraftProposals; ?> <span class="badgem bg-maroon"><?php DraftProposalsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=proposalNewSubmissions&status=Rejected"><?php echo $lang_RejectedProposals; ?> <span class="badgem bg-red"><?php RejectedProposalsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=proposalNewSubmissions&status=Completeness Check-Approved"><?php echo $lang_CompletenessCheck; ?><span class="badgem bg-aqua"><?php CompletenessCheckProposalsAdmin(); ?></span></a></li>

          <li><a href="./main.php?option=proposalNewSubmissions&status=Scheduled for Review"><?php echo $lang_UnderReview; ?> <span class="badgem bg-orange"><?php ScheduledforReviewProposalsAdmin(); ?></span></a></li>


          <li><a href="./main.php?option=proposalNewSubmissions&status=Approved"><?php echo $lang_ReviewedProposals; ?> <span class="badgem bg-blue"><?php ApprovedProposalsAdmin(); ?></span></a></li>



        </ul>
      </li>
      <li class="<?php if ($category == 'ConceptAnalytics' || $category == 'ProposalAnalytics' || $category == 'GrantsAwarded') { ?>active<?php } ?>">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-pie-chart"></i><span><?php echo $lang_Analytics; ?></span></a>
        <ul class="collapse">
          <li><a href="./main.php?option=ConceptAnalytics"><?php echo $lang_ConceptAnalytics; ?></a></li>
          <li><a href="./main.php?option=ProposalAnalytics"><?php echo $lang_ProposalAnalytics; ?></a></li>
          <li><a href="./main.php?option=GrantsAwarded"><?php echo $lang_Grants_Awarded; ?></a></li>
          <?php /*<li><a href="./main.php?option=Reports/">Grant Agreements</a></li>
<li><a href="./main.php?option=Reports/">Awarded</a></li>
<li><a href="./main.php?option=Reports/">Not Awarded</a></li>
<li><a href="./main.php?option=Reports/">M&E report</a></li>
<li><a href="./main.php?option=Reports/">Grant Closure</a></li><?php */ ?>


        </ul>
      </li>


      <li class="<?php if ($category == 'Reports' || $category == 'MonitoringReports' || $category == 'TechnicalReports' || $category == 'FinancialReports' || $category == 'ListofResearchers' || $category == 'CustomReports') { ?>active<?php } ?>">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-pie-chart"></i><span><?php echo $lang_Reports; ?></span></a>
        <ul class="collapse">
          <li><a href="./main.php?option=Reports"><?php echo $lang_all_submission; ?></a></li>
          <li><a href="./main.php?option=MonitoringReports"><?php echo $lang_MonitoringReports; ?></a></li>
          <li><a href="./main.php?option=TechnicalReports"><?php echo $lang_TechnicalReports; ?></a></li>
          <li><a href="./main.php?option=FinancialReports"><?php echo $lang_FinancialReports; ?></a></li>
          <li><a href="./main.php?option=ListofResearchers"><?php echo $lang_ListofResearchers; ?></a></li>
          <li><a href="./main.php?option=CustomReports"><?php echo $lang_CustomReports; ?></a></li>
        </ul>
      </li>


      <li class="<?php if ($category == 'Reviewers' || $category == 'AddReviewers' || $category == 'Logs' || $category == 'ManageCategories' || $category == 'Pages' || $category == 'Sponsors' || $category == 'SocialMedia' || $category == 'Slider' || $category == 'SiteConfiguration' || $category == 'UpdatePage' || $category == 'PagesDelete' || $category == 'UpdateSlider' || $category == 'SliderDelete' || $category == 'UpdateSponsors' || $category == 'SponsorsDelete' || $category == 'Users' || $category == 'Addusers') { ?>active<?php } ?>">
        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-table"></i>
          <span><?php echo $lang_SystemAdministration; ?></span></a>
        <ul class="collapse">
          <li><a href="./main.php?option=Reviewers"><?php echo $lang_ManageReviewers; ?> [<?php TotalReviewersYR(); ?>]</a></li>
          <li><a href="./main.php?option=admins"><?php echo $lang_ManageAdmins; ?> [<?php TotalAdminsYR(); ?>]</a></li>

          <li><a href="./main.php?option=AddReviewers"><?php echo $lang_AddReviewers; ?></a></li>

          <li><a href="./main.php?option=Users"><?php echo $lang_ManageApplicants; ?> [<?php TotalApplicantsYR(); ?>]</a></li>
          <li><a href="./main.php?option=Addusers"><?php echo $lang_AddUsers; ?></a></li>

          <li><a href="./main.php?option=Logs"><?php echo $lang_ManageLogs; ?></a></li>
          <li><a href="./main.php?option=ManageCategories"><?php echo $lang_ManageCategories; ?></a></li>
          <li><a href="./main.php?option=Pages"><?php echo $lang_Pages; ?></a></li>
          <li><a href="./main.php?option=Slider"><?php echo $lang_Slider; ?></a></li>
          <li><a href="./main.php?option=Sponsors"><?php echo $lang_Sponsors; ?></a></li>
          <li><a href="./main.php?option=SocialMedia"><?php echo $lang_SocialMedia; ?></a></li>
          <li><a href="./main.php?option=SiteConfiguration"><?php echo $lang_site_configuration; ?></a></li>

        </ul>
      </li>

    </ul>
  <?php } ?>



  <?php if ($session_usertype == 'admin') { //Grants Office
  ?>
    <ul class="metismenu" id="menu">
      <li class="<?php if ($category == 'conceptNewSubmissions' || $category == 'grantcalls' || $category == 'CompletenessCheck' || $category == 'proposalNewSubmissions' || $category == 'DynamicCallConcepts' || $category == 'DynamicCallConceptsUpdate' || $category == 'SubmitCallforConceptNew' || $category == 'dashboard' || $category == 'ProcurementApplications' || $category == 'CallConcepts' || $category == 'EvaluationCriteria' || $category == 'Amendments' || $category == 'ViewAmendments' || $category == 'CallProposals' || $category == 'AdmProgressReports' || $category == 'AdminNewConcepts' || $category == 'DynamicCallProposals' || $category == 'AdminAllNewConcepts' || $category == 'InviteForFullProposal' || $category == 'AllNewProposals' || $category == 'proposalNewSubmissionsMain' || $category == 'DraftCalls') { ?>active<?php } ?>" style="border-bottom:1px #8d97ad solid;">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span><?php echo $lang_Submissions_Management; ?></span></a>
        <ul class="collapse">
          <h5><?php echo $lang_Concepts; ?> </h5>
          <li><a href="./main.php?option=conceptNewSubmissions&status=Pending Review"><?php echo $lang_New_Submissions; ?> <span class="badgem bg-green"><?php PendingReviewConceptsAdmin(); ?></span></a></li>

          <li><a href="./main.php?option=conceptNewSubmissions&status=Pending Final Submission"><?php echo $lang_DraftConcepts; ?> <span class="badgem bg-maroon"><?php DraftConceptsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=conceptNewSubmissions&status=Rejected"><?php echo $lang_RejectedConcepts; ?> <span class="badgem bg-red"><?php RejectedConceptsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=CompletenessCheck"><?php echo $lang_CompletenessCheck; ?> <span class="badgem bg-aqua"><?php CompletenessCheckConceptsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=conceptNewSubmissions&status=Scheduled for Review"><?php echo $lang_UnderReview; ?> <span class="badgem bg-orange"><?php ScheduledforReviewConceptsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=conceptNewSubmissions&status=Reviewed"><?php echo $lang_ReviewedConcepts; ?> <span class="badgem bg-blue"><?php ApprovedConceptsAdmin(); ?></span></a></li>



          <h5><?php echo $lang_Proposals; ?></h5>
          <li><a href="./main.php?option=proposalNewSubmissions&status=Pending Review"><?php echo $lang_NewSubmissions; ?> <span class="badgem bg-green"><?php PendingReviewProposalsAdmin(); ?></span></a></li>

          <li><a href="./main.php?option=proposalNewSubmissions&status=Pending Final Submission"><?php echo $lang_DraftProposals; ?> <span class="badgem bg-maroon"><?php DraftProposalsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=proposalNewSubmissions&status=Rejected"><?php echo $lang_RejectedProposals; ?> <span class="badgem bg-red"><?php RejectedProposalsAdmin(); ?></span></a></li>
          <li><a href="./main.php?option=proposalNewSubmissions&status=Completeness Check-Approved"><?php echo $lang_CompletenessCheck; ?><span class="badgem bg-aqua"><?php CompletenessCheckProposalsAdmin(); ?></span></a></li>

          <li><a href="./main.php?option=proposalNewSubmissions&status=Scheduled for Review"><?php echo $lang_UnderReview; ?> <span class="badgem bg-orange"><?php ScheduledforReviewProposalsAdmin(); ?></span></a></li>


          <li><a href="./main.php?option=proposalNewSubmissions&status=Reviewed"><?php echo $lang_ReviewedProposals; ?> <span class="badgem bg-blue"><?php ApprovedProposalsAdmin(); ?></span></a></li>

          <li><a href="./main.php?option=Amendments" style="color:#9F3;"><?php echo $lang_Amendments; ?></a></li>
          <li class=""><a href="./main.php?option=AdmProgressReports"><?php echo $lang_SubmitedReports; ?></a></li>


        </ul>
      </li>

      <li class="<?php if ($category == 'ConceptAnalytics' || $category == 'ProposalAnalytics' || $category == 'GrantsAwarded' || $category == 'AnylysisofReviewers' || $category == 'GrantsWonbyInstitution' || $category == 'ReviewerPerfomance' || $category == 'reviewerviewall') { ?>active<?php } ?>">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-pie-chart"></i><span><?php echo $lang_Analytics; ?></span></a>
        <ul class="collapse">
          <li><a href="./main.php?option=ConceptAnalytics"><?php echo $lang_ConceptAnalytics; ?></a></li>
          <li><a href="./main.php?option=ProposalAnalytics"><?php echo $lang_ProposalAnalytics; ?></a></li>
          <li><a href="./main.php?option=GrantsAwarded"><?php echo $lang_Grants_Awarded; ?></a></li>
          <li class=""><a href="./main.php?option=ReviewerPerfomance"><?php echo $lang_ReviewerPerformance; ?></a></li>
          <?php /*?><li class=""><a href="./main.php?option=AnylysisofReviewers"><?php echo $lang_AnylysisofReviewers;?></a></li><?php */ ?>
          <li class=""><a href="./main.php?option=GrantsWonbyInstitution"><?php echo $lang_GrantsWonbyInstitution; ?></a></li>

        </ul>
      </li>


      <li class="<?php if ($category == 'Reports' || $category == 'MonitoringReports' || $category == 'TechnicalReports' || $category == 'FinancialReports' || $category == 'ListofResearchers' || $category == 'CustomReports' || $category == 'reviewProgressReport' || $category == 'reviewAbstract' || $category == 'reviewSummaryofScientificProgress' || $category == 'reviewKeyPersonnelEffort' || $category == 'reviewPublications' || $category == 'ConflictofInterestConcepts' || $category == 'ConflictofInterestProposals') { ?>active<?php } ?>">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-pie-chart"></i><span><?php echo $lang_Reports; ?></span></a>
        <ul class="collapse">
          <li><a href="./main.php?option=Reports"><?php echo $lang_all_submission; ?></a></li>
          <li><a href="./main.php?option=MonitoringReports"><?php echo $lang_MonitoringReports; ?></a></li>
          <li><a href="./main.php?option=TechnicalReports"><?php echo $lang_TechnicalReports; ?></a></li>
          <li><a href="./main.php?option=FinancialReports"><?php echo $lang_FinancialReports; ?></a></li>
          <li><a href="./main.php?option=ListofResearchers"><?php echo $lang_ListofResearchers; ?></a></li>
          <li><a href="./main.php?option=CustomReports"><?php echo $lang_CustomReports; ?></a></li>



          <li class=""><a href="./main.php?option=ConflictofInterestConcepts"><?php echo $lang_ConflictofInterestConcepts; ?></a></li>
          <li class=""><a href="./main.php?option=ConflictofInterestProposals"><?php echo $lang_ConflictofInterestProposals; ?></a></li>




        </ul>
      </li>


      <li class="<?php if ($category == 'Reviewers' || $category == 'AddReviewers' || $category == 'Logs' || $category == 'ManageCategories' || $category == 'Pages' || $category == 'Sponsors' || $category == 'SocialMedia' || $category == 'Slider' || $category == 'SiteConfiguration' || $category == 'UpdatePage' || $category == 'PagesDelete' || $category == 'UpdateSlider' || $category == 'SliderDelete' || $category == 'UpdateSponsors' || $category == 'SponsorsDelete') { ?>active<?php } ?>">
        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-table"></i>
          <span><?php echo $lang_SystemAdministration; ?></span></a>
        <ul class="collapse">
          <li><a href="./main.php?option=Reviewers"><?php echo $lang_ManageReviewers; ?> [<?php TotalReviewersYR(); ?>]</a></li>
          <li><a href="./main.php?option=AddReviewers"><?php echo $lang_AddReviewers; ?></a></li>
          <li><a href="./main.php?option=Logs"><?php echo $lang_ManageLogs; ?></a></li>
          <li><a href="./main.php?option=ManageCategories"><?php echo $lang_ManageCategories; ?></a></li>
          <li><a href="./main.php?option=Pages"><?php echo $lang_Pages; ?></a></li>
          <li><a href="./main.php?option=Slider"><?php echo $lang_Slider; ?></a></li>
          <li><a href="./main.php?option=Sponsors"><?php echo $lang_Sponsors; ?></a></li>
          <li><a href="./main.php?option=SocialMedia"><?php echo $lang_SocialMedia; ?></a></li>
          <li><a href="./main.php?option=SiteConfiguration"><?php echo $lang_site_configuration; ?></a></li>

        </ul>
      </li>



    </ul>

  <?php } ?>


  <?php if ($session_usertype == 'reviewer') { //and logm_status='new' 
    $sqlConceptLogs = "SELECT * FROM " . $prefix . "conceptsasslogs_new where conceptm_assignedto='$usrrsmyLoggedIdm' order by assignm_date desc limit 0,20";
    $QueryConcept = $mysqli->query($sqlConceptLogs);
    $rReview = $QueryConcept->fetch_array();
  ?>
    <?php //if($rReview['availableReview']=='yes'){
    ?>
    <ul class="metismenu" id="menu">
      <li class="active">
        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span><?php echo $lang_home; ?></span></a>
        <ul class="collapse">
          <li class="active"><a href="./main.php?option=dashboard"><?php echo $lang_Submissions; ?></a></li>
          <li><a href="./main.php?option=PendingConceptsReviewer"><?php echo $lang_PendingConcepts; ?></a></li>
          <li><a href="./main.php?option=CompleteConceptsReviewer"><?php echo $lang_CompleteConcepts; ?></a></li>

          <li><a href="./main.php?option=PendingProposalReviewer"><?php echo $lang_PendingProposals; ?></a></li>
          <li><a href="./main.php?option=CompleteProposalReviewer"><?php echo $lang_CompleteProposals; ?></a></li>

        </ul>
      </li>
    <?php } ?>

    </ul>
    <?php //}
    ?>


    <?php if ($session_usertype == 'user') {
      $usrm_username = $_SESSION['usrm_username'];
      $usrm_id = $_SESSION['usrm_id'];
      $querysrt = "select * from " . $prefix . "musers where usrm_id='$usrm_id' and usrm_username='$usrm_username'";
      $rs_seee = $mysqli->query($querysrt);
      $rsuser = $rs_seee->fetch_array();

      ///check CVS
      $querysrtcvs = "select * from " . $prefix . "concepts_cvs where usrm_id='$usrm_id' and openstatus='open'";
      $rs_seeecvs = $mysqli->query($querysrtcvs);
      $totalUsercvs = $rs_seeecvs->num_rows;
      $rsusercvs = $rs_seeecvs->fetch_array();

      $querysrtcvsall = "select * from " . $prefix . "concepts_cvs where usrm_id='$usrm_id' and openstatus='open'";
      $rs_seeecvsall = $mysqli->query($querysrtcvsall);
      $totalUsercvsall = $rs_seeecvsall->num_rows;


      $sqlFListsProposal = "SELECT * FROM " . $prefix . "submissions_proposals where awarded='Yes' and owner_id='$usrm_id' order by projectID desc";
      $QueryFListProposal = $mysqli->query($sqlFListsProposal);


      $sqlFListsConceptM = "SELECT * FROM " . $prefix . "submissions_concepts where awarded='Yes' and owner_id='$usrm_id' order by conceptID desc";
      $QueryFListConceptM = $mysqli->query($sqlFListsConceptM);
      $totalAwards = ($QueryFListConceptM->num_rows + $QueryFListProposal->num_rows);

      $Now = date("Y-m-d H:i:s"); //2017-02-28 23:59:00
    ?>

      <ul class="metismenu" id="menu">
        <li class="<?php if ($category == 'usrSubmittedConcepts' || $category == 'usrSubmittedProposals' || $category == 'userconceptsNewSubmissions' || $category == 'dashboard' || $category == 'userproposalNewSubmissions' || $category == 'Amendments' || $category == 'SubmitAmendments' || $category == 'usrCallforProposals' || $category == 'newSubmitProposal' || $category == 'newproposalResearchTeam' || $category == 'newproposalBackground' || $category == 'newproposalMethodology' || $category == 'newproposalBudget' || $category == 'newproposalResults' || $category == 'newproposalManagement' || $category == 'newproposalFollowup' || $category == 'newProposalAttachments' || $category == 'newProposalReferences' || $category == 'newconceptPrincipalInvestigator' || $category == 'newSubmitConcept' || $category == 'newconceptIntroduction' || $category == 'newconceptProjectDetails' || $category == 'newconceptBudget' || $category == 'newconceptReferences' || $category == 'newconceptAttachments' || $category == 'CompletenessCheck') { ?>active<?php } ?>">
          <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span><?php echo $lang_Submissions; ?></span></a>
          <ul class="collapse">

            <h5><?php echo $lang_Concepts; ?> <span class="badgem bg-green"><?php TotalSubmittedConcepts(); ?></span></h5>
            <li><a href="./main.php?option=userconceptsNewSubmissions&status=Pending Review"><?php echo $lang_New_Submissions; ?> <span class="badgem bg-green"><?php PendingReviewConcepts(); ?></span></a></li>

            <li><a href="./main.php?option=userconceptsNewSubmissions&status=Pending Final Submission"><?php echo $lang_DraftConcepts; ?> <span class="badgem bg-maroon"><?php DraftConceptsUser(); ?></span></a></li>

            <li><a href="./main.php?option=userconceptsNewSubmissions&status=Rejected"><?php echo $lang_RejectedConcepts; ?> <span class="badgem bg-red"><?php RejectedConceptsUser(); ?></span></a></li>

            <li><a href="./main.php?option=CompletenessCheck&status=Completeness Check-Approved"><?php echo $lang_CompletenessCheck; ?> <span class="badgem bg-aqua"><?php CompletenessCheckConceptsUser(); ?></span></a></li>

            <li><a href="./main.php?option=userconceptsNewSubmissions&status=Scheduled for Review"><?php echo $lang_UnderReview; ?> <span class="badgem bg-orange"><?php ScheduledforReviewConcepts(); ?></span></a></li>

            <li><a href="./main.php?option=userconceptsNewSubmissions&status=Reviewed"><?php echo $lang_ReviewedConcepts; ?> <span class="badgem bg-blue"><?php ApprovedConceptsUser(); ?></span></a></li>



            <h5><?php echo $lang_Proposals; ?> <span class="badgem bg-maroon"><?php TotalSubmittedProposals(); ?></span></h5>
            <li><a href="./main.php?option=userproposalNewSubmissions&status=Pending Review"><?php echo $lang_NewSubmissions; ?> <span class="badgem bg-green"><?php PendingReviewProposalsUser(); ?></span></a></li>

            <li><a href="./main.php?option=userproposalNewSubmissions&status=Pending Final Submission"><?php echo $lang_DraftProposals; ?> <span class="badgem bg-maroon"><?php DraftProposalsUser(); ?></span></a></li>
            <li><a href="./main.php?option=userproposalNewSubmissions&status=Rejected"><?php echo $lang_RejectedProposals; ?> <span class="badgem bg-red"><?php RejectedProposalsUser(); ?></span></a></li>

            <li><a href="./main.php?option=userproposalNewSubmissions&status=Completeness Check-Approved"><?php echo $lang_CompletenessCheck; ?><span class="badgem bg-aqua"><?php CompletenessCheckProposalsUser(); ?></span></a></li>

            <li><a href="./main.php?option=userproposalNewSubmissions&status=Scheduled for Review"><?php echo $lang_UnderReview; ?> <span class="badgem bg-orange"><?php ScheduledforReviewProposalsUser(); ?></span></a></li>


            <li><a href="./main.php?option=userproposalNewSubmissions&status=Reviewed"><?php echo $lang_ReviewedProposals; ?> <span class="badgem bg-blue"><?php ApprovedProposalsUser(); ?></span></a></li>

            <li><a href="./main.php?option=Amendments"><?php echo $lang_Amendments; ?></a></li>




          </ul>
        </li>


        <li class="<?php if ($category == 'FundsApplications' || $category == 'ProcurementApplications' || $category == 'urRequestforFunds') { ?>active<?php } ?>">
          <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span><?php echo $lang_SubmittedRequisitions; ?></span></a>
          <ul class="collapse">
            <li><a href="./main.php?option=FundsApplications"><?php echo $lang_RequestforFunds; ?></a></li>
            <li><a href="./main.php?option=ProcurementApplications"><?php echo $lang_RequestforProcurement; ?></a></li>

          </ul>
        </li>



        <li class="<?php if ($category == 'usrSubmittedProposals' || $category == 'GrantsUserAwarded') { ?>active<?php } ?>">
          <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span><?php echo $lang_GrantsAwarded; ?></span></a>
          <ul class="collapse">
            <li><a href="./main.php?option=GrantsUserAwarded" class="error"><?php echo $lang_GrantsAwarded; ?> <span class="badgem bg-aqua"><?php echo $totalAwards; ?></span></a></li>

          </ul>
        </li>

        <li class="<?php if ($category == 'MyAccount') { ?>active<?php } ?>">
          <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span><?php echo $lang_MyAccount; ?></span></a>
          <ul class="collapse">
            <li><a href="./main.php?option=MyAccount"><?php echo $lang_MyAccount; ?></a></li>

          </ul>
        </li>


        <li class="<?php if ($category == 'ProgressReports' || $category == 'ClosureReports' || $category == 'submitProgressReport') { ?>active<?php } ?>">
          <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span><?php echo $lang_Reports; ?></span></a>
          <ul class="collapse">
            <li class="active"><a href="./main.php?option=ProgressReports"><?php echo $lang_ProgressReports; ?></a></li>



          </ul>
        </li>


      </ul>
    <?php } ?>