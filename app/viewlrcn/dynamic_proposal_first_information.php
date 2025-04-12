<?php
$conceptID = $_GET['conceptID'];

if ($_POST['doSaveData'] and $_POST['projectTitle'] and $_POST['asrmApplctID'] and $id) {
  $projectTitle = $mysqli->real_escape_string($_POST['projectTitle']);
  $titleAcronym = $mysqli->real_escape_string($_POST['titleAcronym']);
  $relevantKeywords = $mysqli->real_escape_string($_POST['relevantKeywords']);
  $researchTypeID = $mysqli->real_escape_string($_POST['researchTypeID']);
  $projectDurationID = $mysqli->real_escape_string($_POST['projectDurationID']);
  $HostInstitution = $mysqli->real_escape_string($_POST['HostInstitution']);
  $asrmApplctID = $mysqli->real_escape_string($_POST['asrmApplctID']);
  $PrincipalInvestigator = $mysqli->real_escape_string($_POST['PrincipalInvestigator']);
  $Totalfunding = $mysqli->real_escape_string($_POST['Totalfunding']);
  $conceptID = $mysqli->real_escape_string($_POST['conceptID']);
  $conceptreferenceNo = $mysqli->real_escape_string($_POST['conceptreferenceNo']);
  $qn_OrchidID = $mysqli->real_escape_string($_POST['qn_OrchidID']);

  // Get Category
  $sqlCategory = "SELECT * FROM " . $prefix . "categories where rstug_categoryID='$researchTypeID' order by rstug_categoryName asc";
  $QueryCategory = $mysqli->query($sqlCategory);
  $rUserCategory = $QueryCategory->fetch_array();

  // Get call ID
  $sqlUsersCall = "SELECT * FROM " . $prefix . "grantcalls where category='proposals' order by grantID desc limit 0,1";
  $QueryUsersCall = $mysqli->query($sqlUsersCall);
  $rUserInvCall = $QueryUsersCall->fetch_array();
  $shortacronym = $rUserInvCall['shortacronym'];
  
  if (!$id) {
    $grantcallID = $rUserInvCall['grantID'];
  }
  if ($id) {
    $grantcallID = $id;
  }

  $sqlUsers2 = "SELECT * FROM " . $prefix . "submissions_proposals where `owner_id`='$asrmApplctID' order by projectID desc limit 0,1";
  $QueryUsers2 = $mysqli->query($sqlUsers2);
  $totalUsers2 = $QueryUsers2->num_rows;
  $rUserInv2 = $QueryUsers2->fetch_array();

  $sqlUsers6 = "SELECT * FROM " . $prefix . "submissions_proposals order by projectID desc limit 0,1";
  $QueryUsers6 = $mysqli->query($sqlUsers6);
  $totalUsers6 = $QueryUsers6->num_rows;
  $rUserInv6 = $QueryUsers6->fetch_array();

  if (!$totalUsers6) {
    $serialBegin = '0001';
  }
  if ($totalUsers6) {
    $NewserialBegin = $rUserInv6['projectID'] + 1;

    if ($NewserialBegin >= 0 and $NewserialBegin <= 9) {
      $serialBegin = '000' . $NewserialBegin;
    }

    if ($NewserialBegin >= 10 and $NewserialBegin <= 99) {
      $serialBegin = '00' . $NewserialBegin;
    }

    if ($NewserialBegin >= 100 and $NewserialBegin <= 199) {
      $serialBegin = '0' . $NewserialBegin;
    }

    if ($NewserialBegin >= 200 and $NewserialBegin <= 9000000000) {
      $serialBegin = $NewserialBegin;
    }
  }
  
  // Assign Reference number
  $mmCOnecpt = $totalUsers6['projectID'] + 1;
  $referenceNo = "$shortacronym" . "-" . $grantcallID . "-" . date("Y") . "-" . "$serialBegin";

  $sqlUsers = "SELECT * FROM " . $prefix . "submissions_proposals where `owner_id`='$asrmApplctID' and `grantcallID`='$id' order by projectID desc limit 0,1";
  $QueryUsers = $mysqli->query($sqlUsers);
  $totalUsers = $QueryUsers->num_rows;
  $rUserInv = $QueryUsers->fetch_array();

  if (!$totalUsers and $_POST['asrmApplctID']) {
    $sqlA2 = "insert into " . $prefix . "submissions_proposals (`conceptID`,`projectTitle`,`titleAcronym`,`relevantKeywords`,`researchTypeID`,`projectDurationID`,`updatedon`,`owner_id`,`projectCategory`,`projectStatus`,`is_sent`,`HostInstitution`,`rejectComents`,`finalSubmission`,`PrincipalInvestigator`,`Totalfunding`,`conceptm_Times`,`conceptm_Reviewers`,`category`,`projectYears`,`grantcallID`,`creferences`,`referenceNo`,`dynamic`,`qn_OrchidID`,`awarded`,`BeginProject`,`EndProject`,`AmountofGrantawarded`,`DurationofGrant`,`TermsConditions`,`currency`) 

values('$conceptID','$projectTitle','$titleAcronym','$relevantKeywords','$researchTypeID','$projectDurationID',now(),'$asrmApplctID','Proposal','Pending Final Submission','0','$HostInstitution','','Pending Final Submission','$PrincipalInvestigator','$Totalfunding',NULL,NULL,'proposal',NULL,'$grantcallID',NULL,'$referenceNo','Yes','$qn_OrchidID','No',NULL,NULL,NULL,NULL,'No','USD')";
    $mysqli->query($sqlA2);
    $record_id = $mysqli->insert_id;

    if ($record_id >= 1) {
      $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Dear ' . $session_fullname . ', details have been submitted, proceed to continue.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
      logaction("$session_fullname added created new protocol");

      echo '<img src="img/loading_wait.gif" class="img-fluid mx-auto d-block">';
      echo '<div class="spacer"></div>';
      echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=newproposalResearchTeam&id=$id&categoryID=$categoryID&conceptID=$conceptID'>";
    }
    if ($record_id <= 0) {
      $message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Dear ' . $session_fullname . ', details have not been saved. Re-enter and submit again.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
  }

  if ($totalUsers) {
    // Update
    $sqlA2 = "update " . $prefix . "submissions_proposals set  `projectTitle`='$projectTitle',`titleAcronym`='$titleAcronym',`relevantKeywords`='$relevantKeywords',`researchTypeID`='$researchTypeID',`projectDurationID`='$projectDurationID',`HostInstitution`='$HostInstitution',`finalSubmission`='Pending Final Submission',`PrincipalInvestigator`='$PrincipalInvestigator',`Totalfunding`='$Totalfunding',`referenceNo`='$conceptreferenceNo',`dynamic`='Yes',`qn_OrchidID`='$qn_OrchidID' where owner_id='$asrmApplctID' and grantcallID='$id'";
    $mysqli->query($sqlA2);

    echo '<img src="img/loading_wait.gif" class="img-fluid mx-auto d-block">';
    echo '<div class="spacer"></div>';
    echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=newproposalResearchTeam&id=$id&categoryID=$categoryID&conceptID=$conceptID'>";
  }

  if (!$record_id) {
    $record_idm = $_POST['projectID'];
  }
  if ($record_id) {
    $record_idm = $record_id;
  }
  
  // Insert into Submission Stages
  $wm = "select * from " . $prefix . "project_stages where  owner_id='$asrmApplctID' and status='new' and grantID='$id'";
  $cmdwb = $mysqli->query($wm);
  $totalStages = $cmdwb->num_rows;
  $r = $cmdwb->fetch_array();
  
  if (!$totalStages) {
    $sqlASubmissionStages = "insert into " . $prefix . "project_stages (`owner_id`,`projectID`,`ProjectInformation`,`Background`,`Methodology`,`ProjectResults`,`ResearchTeam`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`,`PrincipalInvestigatorEducation`,`PrincipalInvestigatorResearch`,`attachments`,`citations`,`conceptID`,`grantID`)  values('$asrmApplctID','$record_idm','1','0','0','0','0','0','0','0',now(),'new','0','0','0','0','$conceptID','$id')";
    $mysqli->query($sqlASubmissionStages);
  }
  if ($totalStages) {
    $sqlASubmissionStages = "update " . $prefix . "project_stages  set `ProjectInformation`='1' where `owner_id`='$asrmApplctID' and status='new' and grantID='$id'";
    $mysqli->query($sqlASubmissionStages);
  }
}

if (isset($message)) {
  echo $message;
}
$asrmApplctID2 = $usrm_id;

$sqlUsers2 = "SELECT * FROM " . $prefix . "submissions_proposals where `owner_id`='$usrm_id'  and  grantcallID='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2 = $QueryUsers2->fetch_array();

// Get concept first
if ($conceptID) {
  $sqlConcept = "SELECT * FROM " . $prefix . "submissions_concepts where `owner_id`='$usrm_id' and conceptID='$conceptID' order by conceptID desc limit 0,1";
  $QueryConcept = $mysqli->query($sqlConcept);
  $rUserConcept = $QueryConcept->fetch_array();
  $conceptID = $rUserConcept['conceptID'];

  $sqlUsers2mm = "SELECT * FROM " . $prefix . "concept_budget where `owner_id`='$usrm_id' and conceptID='$conceptID' order by id desc limit 0,1";
  $QueryUsers2mm = $mysqli->query($sqlUsers2mm);
  $rUserInv2mm = $QueryUsers2mm->fetch_array();
}
if ($totalUsers) {
  $projectTitle = $rUserInv2['projectTitle'];
  $titleAcronym = $rUserInv2['titleAcronym'];
  $researchTypeID = $rUserInv2['researchTypeID'];
  $Totalfunding = $rUserInv2['Totalfunding'];
  $projectDurationID = $rUserInv2['projectDurationID'];
  $relevantKeywords = $rUserInv2['relevantKeywords'];
  $HostInstitution = $rUserInv2['HostInstitution'];
  $conceptID = $rUserInv2['conceptID'];
  $mmTotalBudget = $rUserInv2['Totalfunding'];
  $conceptreferenceNo = $rUserInv2['referenceNo'];
}
if (!$totalUsers) {
  $projectTitle = $rUserConcept['projectTitle'];
  $titleAcronym = $rUserConcept['titleAcronym'];
  $researchTypeID = $rUserConcept['researchTypeID'];
  $Totalfunding = $rUserConcept['Totalfunding'];
  $projectDurationID = $rUserConcept['projectDurationID'];
  $relevantKeywords = $rUserConcept['relevantKeywords'];
  $HostInstitution = $rUserConcept['HostInstitution'];
  $conceptID = $rUserConcept['conceptID'];
  $mmTotalBudget = $rUserConcept['TotalSubmitted'];
  $conceptreferenceNo = $rUserConcept['referenceNo'];
}

$sessionusrm_id = $_SESSION['usrm_id'];
$wConceptStages = "select * from " . $prefix . "project_stages where  owner_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages = $cmConceptStages->fetch_array();
?>

<!-- Modern Bootstrap-style CSS -->
<style>
    /* Main tab navigation */
    .tab {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 1px;
    }
    
    .tab button {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-bottom: none;
        border-radius: 0.25rem 0.25rem 0 0;
        padding: 0.75rem 1.25rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #495057;
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
        margin-bottom: -1px;
    }
    
    .tab button:hover {
        background-color: #e9ecef;
    }
    
    .tab button.active {
        background-color: #fff;
        border-bottom: 1px solid #fff;
        color: #007bff;
        font-weight: 600;
    }
    
    /* Make sure the background color for completed sections overrides the active state */
    .tab button.active[style*="background-color: #4CAF50"] {
        color: white !important;
        border-bottom: 1px solid #4CAF50 !important;
    }
    
    /* Tab content styling */
    .tabcontent {
        display: none;
        padding: 1.5rem;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 0.25rem 0.25rem;
        background-color: #fff;
        animation: fadeEffect 0.5s;
    }
    
    @keyframes fadeEffect {
        from {opacity: 0;}
        to {opacity: 1;}
    }
    
    /* Form elements */
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-control {
        display: block;
        width: 100%;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: inline-block;
    }
    
    /* Container and layout */
    .container {
        max-width: 1140px;
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }
    
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
        margin-bottom: 1rem;
    }
    
    .col-100 {
        flex: 0 0 100%;
        max-width: 100%;
        padding-right: 15px;
        padding-left: 15px;
    }
    
    /* Buttons */
    input[type="submit"], button {
        background-color: #007bff;
        color: #fff;
        border: 1px solid #007bff;
        padding: 0.5rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }
    
    input[type="submit"]:hover, button:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
    
    /* Alerts and text styling */
    .text-danger {
        color: #dc3545 !important;
    }
    
    .alert {
        padding: 0.75rem 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }
    
    .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }
    
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    
    .success {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 0.25rem;
    }
    
    /* Input groups */
    .input-group {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        width: 100%;
    }
    
    .input-group-prepend {
        display: flex;
        margin-right: -1px;
    }
    
    .input-group-text {
        display: flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 0.25rem 0 0 0.25rem;
    }
    
    .input-group .form-control {
        position: relative;
        flex: 1 1 auto;
        width: 1%;
        margin-bottom: 0;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>

<!-- Tab navigation -->
<div class="tab">
  <?php
  require("dynamic_categories.php");
  ?>

  <?php if ($total_Information) { ?><button <?php if ($rUConceptStages['ProjectInformation'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?> onclick="openCity(event, 'newFirstInformation')" id="defaultOpen"><?php echo $lang_new_ProjectInformation; ?></button><?php } ?>

  <?php if ($totalUsers) { ?>
    <?php if ($total_Team) { ?><button <?php if ($rUConceptStages['ResearchTeam'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?> onClick="window.location.href='./main.php?option=newproposalResearchTeam&id=<?php echo $id ?>&categoryID=<?php echo $categoryID; ?>&conceptID=<?php echo $conceptID; ?>'"><?php echo $lang_new_ProjectTeam; ?> </button><?php } ?>

    <?php if ($total_Background) { ?><button <?php if ($rUConceptStages['Background'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?> onClick="window.location.href='./main.php?option=newproposalBackground&id=<?php echo $id ?>&categoryID=<?php echo $categoryID; ?>&conceptID=<?php echo $conceptID; ?>'"><?php echo $lang_new_Background; ?> </button><?php } ?>

    <?php if ($total_Methodology) { ?><button <?php if ($rUConceptStages['Methodology'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?> onClick="window.location.href='./main.php?option=newproposalMethodology&id=<?php echo $id ?>&categoryID=<?php echo $categoryID; ?>&conceptID=<?php echo $conceptID; ?>'"><?php echo $lang_new_ApproachMethodology; ?> </button><?php } ?>

    <?php if ($total_Budget) { ?><button <?php if ($rUConceptStages['Budget'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?> onClick="window.location.href='./main.php?option=newproposalBudget&id=<?php echo $id ?>&categoryID=<?php echo $categoryID; ?>&conceptID=<?php echo $conceptID; ?>'"><?php echo $lang_new_Budget; ?></button><?php } ?>

    <?php if ($total_Results) { ?><button <?php if ($rUConceptStages['ProjectResults'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?> onClick="window.location.href='./main.php?option=newproposalResults&id=<?php echo $id ?>&categoryID=<?php echo $categoryID; ?>&conceptID=<?php echo $conceptID; ?>'"><?php echo $lang_new_ProjectResults; ?></button><?php } ?>

    <?php if ($total_Management) { ?><button <?php if ($rUConceptStages['ProjectManagement'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?> onClick="window.location.href='./main.php?option=newproposalManagement&id=<?php echo $id ?>&categoryID=<?php echo $categoryID; ?>&conceptID=<?php echo $conceptID; ?>'"><?php echo $lang_new_ProjectManagement; ?></button><?php } ?>

    <?php if ($total_Followup) { ?><button <?php if ($rUConceptStages['Followup'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?> onClick="window.location.href='./main.php?option=newproposalFollowup&id=<?php echo $id ?>&categoryID=<?php echo $categoryID; ?>&conceptID=<?php echo $conceptID; ?>'"><?php echo $lang_new_ProjectFollowup; ?></button><?php } ?>

    <?php if ($total_Attachments) { ?><button <?php if ($rUConceptStages['attachments'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?> onClick="window.location.href='./main.php?option=newProposalAttachments&id=<?php echo $id ?>&categoryID=<?php echo $categoryID; ?>&conceptID=<?php echo $conceptID; ?>'"><?php echo $lang_new_ResearchAttachments; ?></button><?php } ?>

    <?php if ($total_Citations) { ?><button <?php if ($rUConceptStages['citations'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?> onClick="window.location.href='./main.php?option=newProposalReferences&id=<?php echo $id ?>&categoryID=<?php echo $categoryID; ?>&conceptID=<?php echo $conceptID; ?>'"><?php echo $lang_new_Citations; ?></button><?php } ?>
  <?php } ?>

  <?php if (!$totalUsers) { ?>
    <button <?php if ($rUConceptStages['ResearchTeam'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?>><?php echo $lang_new_ProjectTeam; ?> </button>

    <button <?php if ($rUConceptStages['Background'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?>><?php echo $lang_new_Background; ?> </button>

    <button <?php if ($rUConceptStages['Methodology'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?>><?php echo $lang_new_ApproachMethodology; ?> </button>

    <button <?php if ($rUConceptStages['Budget'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?>><?php echo $lang_new_Budget; ?></button>

    <button <?php if ($rUConceptStages['ProjectResults'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?>><?php echo $lang_new_ProjectResults; ?></button>

    <button <?php if ($rUConceptStages['ProjectManagement'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?>><?php echo $lang_new_ProjectManagement; ?></button>

    <button <?php if ($rUConceptStages['Followup'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?>><?php echo $lang_new_ProjectFollowup; ?></button>
    
    <button <?php if ($rUConceptStages['attachments'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?>><?php echo $lang_new_ResearchAttachments; ?></button>
    
    <?php if ($total_1) { ?><button <?php if ($rUConceptStages['citation'] == 1) { ?>class="tablinks active" style="background-color: #4CAF50; color: white;" <?php } else { ?>class="tablinks"<?php } ?>><?php echo $lang_new_Citations; ?></button><?php } ?>
  <?php } ?>
</div>

<!-- Project Information Tab Content -->
<div id="newFirstInformation" class="tabcontent" style="display: block;">
    <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
    
    <?php include("proposal_submit_now_final_button.php"); ?>
    
    <?php
    $sqlDynamic = "SELECT * FROM " . $prefix . "concept_dynamic_questions_all_a where grantID='$id' and categorym='proposal' order by id asc";
    $QueryDynamic = $mysqli->query($sqlDynamic);
    $rowsDynamic = $QueryDynamic->fetch_array();
    ?>
    
    <h3><?php echo $lang_new_ProjectInformation; ?></h3>
    
    <div class="alert alert-info">
        <i class="fa fa-info-circle" style="margin-right: 8px;"></i> <?php echo $lang_importantInformation; ?>
    </div>
    
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off" class="needs-validation" novalidate>
        <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id; ?>">
        <input type="hidden" name="projectID" value="<?php echo $rUserInv2['projectID']; ?>">
        <input type="hidden" name="conceptID" value="<?php echo $conceptID; ?>">
        
        <p style="margin-bottom: 20px; color: #6c757d;">
            <?php echo $lang_new_RequiredFieldsMarked; ?> (<span class="text-danger">*</span>)
        </p>
                    
                    <?php if ($rowsDynamic['qn_title_status'] == 'Enable') { ?>
                        <div class="form-group row">
                            <label for="projectTitle" class="col-md-3 col-form-label">
                                <?php echo $rowsDynamic['qn_title']; ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="MyTextBox50" name="projectTitle" 
                                       class="form-control" required 
                                       placeholder="Give the title of your project..." 
                                       value="<?php echo $projectTitle; ?>">
                                <div class="invalid-feedback">Please provide a project title.</div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if ($rowsDynamic['qn_acronym_status'] == 'Enable') { ?>
                        <div class="form-group row">
                            <label for="titleAcronym" class="col-md-3 col-form-label">
                                <?php echo $rowsDynamic['qn_acronym']; ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="MyTextBox20" name="titleAcronym" 
                                       class="form-control" required 
                                       placeholder="Short Title or Acronym (10 characters only)" 
                                       value="<?php echo $titleAcronym; ?>">
                                <div class="invalid-feedback">Please provide a title acronym.</div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if ($rowsDynamic['qn_relevantKeywords_status'] == 'Enable') { ?>
                        <div class="form-group row">
                            <label for="relevantKeywords" class="col-md-3 col-form-label">
                                <?php echo $rowsDynamic['qn_relevantKeywords']; ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="MyTextBox2" name="relevantKeywords" 
                                       class="form-control" required 
                                       placeholder="Enter relevant keywords..." 
                                       value="<?php echo $relevantKeywords; ?>">
                                <div class="invalid-feedback">Please provide relevant keywords.</div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if ($rowsDynamic['qn_researchTypeID_status'] == 'Enable') { ?>
                        <div class="form-group row">
                            <label for="researchTypeID" class="col-md-3 col-form-label">
                                <?php echo $lang_new_researchTypeID; ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <select id="researchTypeID" name="researchTypeID" class="form-control" required>
                                    <option value=""><?php echo $lang_please_select; ?></option>
                                    <?php
                                    $sqlCat = "SELECT * FROM " . $prefix . "categories order by rstug_categoryName asc";
                                    $queryCat = $mysqli->query($sqlCat);
                                    while ($rCat = $queryCat->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $rCat['rstug_categoryID']; ?>" 
                                                <?php if ($rCat['rstug_categoryID'] == $researchTypeID) { ?>selected="selected" <?php } ?>>
                                            <?php echo $rCat['rstug_categoryName']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">Please select a research type.</div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if ($rowsDynamic['qn_HostInstitution_status'] == 'Enable') { ?>
                        <div class="form-group row">
                            <label for="HostInstitution" class="col-md-3 col-form-label">
                                <?php echo $rowsDynamic['qn_HostInstitution']; ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="HostInstitution" name="HostInstitution" 
                                       class="form-control" required 
                                       placeholder="Enter host institution..." 
                                       value="<?php echo $HostInstitution; ?>">
                                <input name="conceptreferenceNo" type="hidden" value="<?php echo $conceptreferenceNo; ?>" />
                                <div class="invalid-feedback">Please provide a host institution.</div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if ($rowsDynamic['qn_projectDurationID_status'] == 'Enable') { ?>
                        <div class="form-group row">
                            <label for="projectDurationID" class="col-md-3 col-form-label">
                                <?php echo $lang_new_titleDurationtheproject; ?>
                                <span class="text-danger">Maximum period is <?php echo $rowsDynamic['qn_projectDurationID']; ?> Months *</span>
                            </label>
                            <div class="col-md-9">
                                <select id="projectDurationID" name="projectDurationID" class="form-control" required>
                                    <?php
                                    $sqlFeaturedCall = "SELECT * FROM " . $prefix . "duration order by durationID asc";
                                    $queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
                                    while ($rFeaturedCall = $queryFeaturedCall->fetch_array()) {
                                    ?>
                                        <option value="<?php echo $rFeaturedCall['durationID']; ?>" 
                                                <?php if ($rFeaturedCall['durationID'] == $projectDurationID) { ?>selected="selected" <?php } ?>>
                                            <?php echo $rFeaturedCall['duration']; ?> <?php echo $rFeaturedCall['durationdesc']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <div class="invalid-feedback">Please select a project duration.</div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if ($rowsDynamic['qn_OrchidID_status'] == 'Enable') { ?>
                        <div class="form-group row">
                            <label for="qn_OrchidID" class="col-md-3 col-form-label">
                                <?php echo $rowsDynamic['qn_OrchidID']; ?>
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="MyTextBoxmmOCIDIDw" name="qn_OrchidID" 
                                       class="form-control" 
                                       placeholder="Enter ORCID ID..." 
                                       value="<?php echo $rUserInv2['qn_OrchidID']; ?>" 
                                       min="16" maxlength="16">
                                <small class="form-text text-muted">Your ORCID identifier (optional)</small>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if ($rowsDynamic['qn_fundingappliedfor_status'] == 'Enable') { ?>
                        <div class="form-group row">
                            <label for="Totalfunding" class="col-md-3 col-form-label">
                                <?php echo $rowsDynamic['qn_fundingappliedfor']; ?> <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" inputmode="numeric" pattern="[0-9]+([,\.][0-9]+)?" 
                                           id="Totalfunding" name="Totalfunding" 
                                           class="form-control" required 
                                           placeholder="Enter value (e.g., 800000.00)" 
                                           value="<?php echo $rUserInv2['Totalfunding']; ?>">
                                </div>
                                <div class="invalid-feedback">Please provide the total funding amount.</div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <div class="row" style="padding-top:5px;">
                        <input type="submit" name="doSaveData" value="<?php echo $lang_SaveandNext; ?>">
                    </div>
                </form>
            </div>


<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

// Form validation 
(function() {
  'use strict';
  
  // Fetch all forms we want to apply validation to
  var forms = document.querySelectorAll('.needs-validation');
  
  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function(form) {
    form.addEventListener('submit', function(event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>

<!-- Form Validation Script -->
<script>
    // Form validation script
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all forms we want to apply validation to
            var forms = document.getElementsByClassName('needs-validation');
            
            // Loop over them and prevent submission
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-pane");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("nav-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Auto-activate the first tab
    document.getElementById("projectInfo-tab").click();
</script>