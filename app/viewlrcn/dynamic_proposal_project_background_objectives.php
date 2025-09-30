<?php
$conceptm_id=$_GET['conceptID'];
$conceptID=$_GET['conceptID'];

if($_POST['doSaveData'] and $_POST['projectID'] and $_POST['asrmApplctID']){
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$SummaryAudience=$mysqli->real_escape_string($_POST['SummaryAudience']);
	$explanationObjectives=$mysqli->real_escape_string($_POST['explanationObjectives']);
	$researchInnovationIssues=$mysqli->real_escape_string($_POST['researchInnovationIssues']);
	$NovelCharacterScientificResearch=$mysqli->real_escape_string($_POST['NovelCharacterScientificResearch']);
	$ClearJustificationDemonstration=$mysqli->real_escape_string($_POST['ClearJustificationDemonstration']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$interdisciplinaryTransdisciplinary=$mysqli->real_escape_string($_POST['interdisciplinaryTransdisciplinary']);
	$addedValue=$mysqli->real_escape_string($_POST['addedValue']);
	$ImportanceResearchInnovation=$mysqli->real_escape_string($_POST['ImportanceResearchInnovation']);
	$PartofInternationalProject=$mysqli->real_escape_string($_POST['PartofInternationalProject']);
	$projectSpecificActivities =$mysqli->real_escape_string($_POST['projectSpecificActivities']);
	
	$sqlUsers="SELECT * FROM ".$prefix."project_background where `owner_id`='$asrmApplctID' and grantID='$id' order by projectID desc limit 0,1";
	$QueryUsers = $mysqli->query($sqlUsers);
	$totalUsers = $QueryUsers->num_rows;
	$rUserInv=$QueryUsers->fetch_array();

if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."project_background (`projectID`,`owner_id`,`SummaryAudience`,`explanationObjectives`,`researchInnovationIssues`,`NovelCharacterScientificResearch`,`ClearJustificationDemonstration`,`interdisciplinaryTransdisciplinary`,`addedValue`,`ImportanceResearchInnovation`,`PartofInternationalProject`,`projectSpecificActivities`,`is_sent`,`grantID`) 

values('$projectID','$asrmApplctID','$SummaryAudience','$explanationObjectives','$researchInnovationIssues','$NovelCharacterScientificResearch','$ClearJustificationDemonstration','$interdisciplinaryTransdisciplinary','$addedValue','$ImportanceResearchInnovation','$PartofInternationalProject','$projectSpecificActivities','0','$id')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Dear '.$session_fullname.', details have been submitted, proceed to continue.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
logaction("$session_fullname added created new protocol");
}
if($record_id<=0){
$message='<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';	
}

}	/////end totals

if($totalUsers){
	///update
	
$sqlA2="update ".$prefix."project_background set  `SummaryAudience`='$SummaryAudience',`explanationObjectives`='$explanationObjectives',`researchInnovationIssues`='$researchInnovationIssues',`NovelCharacterScientificResearch`='$NovelCharacterScientificResearch',`ClearJustificationDemonstration`='$ClearJustificationDemonstration',`interdisciplinaryTransdisciplinary`='$interdisciplinaryTransdisciplinary',`addedValue`='$addedValue',`ImportanceResearchInnovation`='$ImportanceResearchInnovation',`PartofInternationalProject`='$PartofInternationalProject',`projectSpecificActivities`='$projectSpecificActivities' where owner_id='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlA2);

/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newproposalMethodology&id=$id&categoryID=$categoryID&conceptID=$conceptID';</script>");
	*/
}//end


if(!$record_id){$record_idm=$_POST['projectID'];}
if($record_id){$record_idm=$record_id;}		
//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and grantID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."project_stages (`owner_id`,`projectID`,`ProjectInformation`,`Background`,`Methodology`,`ProjectResults`,`ResearchTeam`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`)  values('$asrmApplctID','$record_idm','1','1','0','0','0','0','0','0',now(),'new')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `Background`='1' where `owner_id`='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlASubmissionStages);
}

}//end post



if(isset($message)){echo $message;}
$asrmApplctID2=$usrm_id;
$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and grantcallID='$id' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();

$sqlUsers2="SELECT * FROM ".$prefix."project_background where `owner_id`='$usrm_id' and grantID='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>

<!-- Modern CSS Styles -->
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
        padding: 0.75rem;
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
    
    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }
    
    label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: inline-block;
        color: #212529;
    }
    
    /* Radio buttons */
    .radio-group {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }
    
    .radio-item {
        display: flex;
        align-items: center;
    }
    
    .radio-item input[type="radio"] {
        margin-right: 0.5rem;
    }
    
    /* Container and layout */
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
    
    .success {
        background-color: #f8f9fa;
        border-radius: 0.25rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    
    /* Buttons */
    input[type="submit"], button {
        background-color: #007bff;
        color: #fff;
        border: 1px solid #007bff;
        padding: 0.75rem 1.5rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
        font-weight: 500;
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
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }
    
    .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
    }
    
    /* Section headings */
    h3 {
        color: #212529;
        margin-bottom: 1.5rem;
        font-weight: 600;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 0.75rem;
    }
    
    /* Info text */
    .text-muted {
        color: #6c757d !important;
    }
    
    /* Conditional section */
    #projectSpecificActivities {
        padding-top: 1rem;
    }
</style>

<?php
require("dynamic_categories.php");
?>

<!-- Tab Navigation -->
<div class="tab">
  <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks" style="background-color: #4CAF50; color: white;"<?php }?> onClick="window.location.href='./main.php?option=newSubmitProposal&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectInformation;?> </button><?php }?>
  
  <?php if($total_Team){?><button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks" style="background-color: #4CAF50; color: white;"<?php }?>  onClick="window.location.href='./main.php?option=newproposalResearchTeam&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button><?php }?>
  
  <?php if($total_Background){?><button <?php if($rUConceptStages['Background']==1){?>class="tablinks active" style="background-color: #4CAF50; color: white;"<?php } else {?>class="tablinks active"<?php }?> onclick="openCity(event, 'newproposalBackground')" id="defaultOpen"><?php echo $lang_new_Background;?> </button><?php }?>
  
  <?php if($total_Methodology){?><button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks" style="background-color: #4CAF50; color: white;"<?php }?> onClick="window.location.href='./main.php?option=newproposalMethodology&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button><?php }?>
    
  <?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks" style="background-color: #4CAF50; color: white;"<?php }?> onClick="window.location.href='./main.php?option=newproposalBudget&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
    
  <?php if($total_Results){?><button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks" style="background-color: #4CAF50; color: white;"<?php }?> onClick="window.location.href='./main.php?option=newproposalResults&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectResults;?></button><?php }?>
     
  <?php if($total_Management){?><button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks" style="background-color: #4CAF50; color: white;"<?php }?> onClick="window.location.href='./main.php?option=newproposalManagement&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectManagement;?></button><?php }?>
    
  <?php if($total_Followup){?><button <?php if($rUConceptStages['Followup']==1){?>class="tablinks" style="background-color: #4CAF50; color: white;"<?php }?> onClick="window.location.href='./main.php?option=newproposalFollowup&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectFollowup;?></button><?php }?>
   
  <?php if($total_Attachments){?><button <?php if($rUConceptStages['attachments']==1){?>class="tablinks" style="background-color: #4CAF50; color: white;"<?php }?> onClick="window.location.href='./main.php?option=newProposalAttachments&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ResearchAttachments;?></button><?php }?>
   
  <?php if($total_Citations){?> <button <?php if($rUConceptStages['citations']==1){?>class="tablinks" style="background-color: #4CAF50; color: white;"<?php }?> onClick="window.location.href='./main.php?option=newProposalReferences&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
</div>

<!-- Background Tab Content -->
<div id="newproposalBackground" class="tabcontent" style="display: block;">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times;</span>
  
  <?php include("proposal_submit_now_final_button.php");?>
    
  <?php
  $sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_g  where grantID='$id' and categorym='proposal' order by id desc";
  $Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
  $rowsSubmitted_c=$Querysubmitted_c->fetch_array();
  ?> 
    
  <h3><?php echo $lang_new_Background;?></h3>

  <form action="" method="post" name="regForm" id="regForm" autocomplete="off" class="needs-validation" novalidate>
    <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
    <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
    
    <div class="alert alert-info mb-4">
      <i class="fa fa-info-circle" style="margin-right: 8px;"></i> <?php echo $lang_new_RequiredFieldsMarked;?> (<span class="text-danger">*</span>)
    </div>

    <?php if($rowsSubmitted_c['SummaryAudience_status']=='Enable'){?>
    <div class="form-group">
      <label for="SummaryAudience">
        <?php echo $rowsSubmitted_c['SummaryAudience'];?> <span class="text-danger">*</span>
      </label>
      <textarea id="MyTextBox11" name="SummaryAudience" class="form-control" required placeholder="Summary for a broader audience..."><?php echo $rUserInv2['SummaryAudience'];?></textarea>
      <div class="invalid-feedback">Please provide a summary for broader audience.</div>
    </div>
    <?php }?>

    <?php if($rowsSubmitted_c['explanationObjectives_status']=='Enable'){?>
    <div class="form-group">
      <label for="explanationObjectives">
        <?php echo $rowsSubmitted_c['explanationObjectives'];?> <span class="text-danger">*</span>
      </label>
      <textarea id="MyTextBox2500" name="explanationObjectives" class="form-control" required><?php echo $rUserInv2['explanationObjectives'];?></textarea>
      <div class="invalid-feedback">Please provide explanation of objectives.</div>
    </div>
    <?php }?>

    <?php if($rowsSubmitted_c['SummaryAudience_status']=='Enable'){?>
    <div class="form-group">
      <label for="researchInnovationIssues">
        <?php echo $rowsSubmitted_c['SummaryAudience'];?> <span class="text-danger">*</span>
      </label>
      <textarea id="MyTextBox14" name="researchInnovationIssues" class="form-control" required><?php echo $rUserInv2['researchInnovationIssues'];?></textarea>
      <div class="invalid-feedback">Please provide research innovation issues.</div>
    </div>
    <?php }?>
  
    <?php if($rowsSubmitted_c['NovelCharacterScientificResearch_status']=='Enable'){?>
    <div class="form-group">
      <label for="NovelCharacterScientificResearch">
        <?php echo $rowsSubmitted_c['NovelCharacterScientificResearch'];?> <span class="text-danger">*</span>
      </label>
      <textarea id="MyTextBoxmm3001" name="NovelCharacterScientificResearch" class="form-control" required><?php echo $rUserInv2['NovelCharacterScientificResearch'];?></textarea>
      <div class="invalid-feedback">Please provide novel characteristics of scientific research.</div>
    </div>
    <?php }?>
  
    <?php if($rowsSubmitted_c['ClearJustificationDemonstration_status']=='Enable'){?>
    <div class="form-group">
      <label for="ClearJustificationDemonstration">
        <?php echo $rowsSubmitted_c['ClearJustificationDemonstration'];?> <span class="text-danger">*</span>
      </label>
      <textarea id="MyTextBox13" name="ClearJustificationDemonstration" class="form-control" required><?php echo $rUserInv2['ClearJustificationDemonstration'];?></textarea>
      <div class="invalid-feedback">Please provide clear justification demonstration.</div>
    </div>
    <?php }?>
  
    <?php if($rowsSubmitted_c['interdisciplinaryTransdisciplinary_status']=='Enable'){?>
    <div class="form-group">
      <label for="interdisciplinaryTransdisciplinary">
        <?php echo $rowsSubmitted_c['interdisciplinaryTransdisciplinary'];?> <span class="text-danger">*</span>
      </label>
      <textarea id="MyTextBox3" name="interdisciplinaryTransdisciplinary" class="form-control" required><?php echo $rUserInv2['interdisciplinaryTransdisciplinary'];?></textarea>
      <div class="invalid-feedback">Please provide interdisciplinary or transdisciplinary information.</div>
    </div>
    <?php }?>
  
    <?php if($rowsSubmitted_c['addedValue_status']=='Enable'){?>
    <div class="form-group">
      <label for="addedValue">
        <?php echo $rowsSubmitted_c['addedValue'];?> <span class="text-danger">*</span>
      </label>
      <textarea id="MyTextBox7" name="addedValue" class="form-control" required><?php echo $rUserInv2['addedValue'];?></textarea>
      <div class="invalid-feedback">Please provide added value information.</div>
    </div>
    <?php }?>
  
    <?php if($rowsSubmitted_c['ImportanceResearchInnovation_status']=='Enable'){?>
    <div class="form-group">
      <label for="ImportanceResearchInnovation">
        <?php echo $rowsSubmitted_c['ImportanceResearchInnovation'];?> <span class="text-danger">*</span>
      </label>
      <textarea id="MyTextBox10" name="ImportanceResearchInnovation" class="form-control" required><?php echo $rUserInv2['ImportanceResearchInnovation'];?></textarea>
      <div class="invalid-feedback">Please provide importance of research innovation.</div>
    </div>
    <?php }?>
  
    <?php if($rowsSubmitted_c['PartofInternationalProject_status']=='Enable'){?>
    <div class="form-group">
      <label for="PartofInternationalProject">
        <?php echo $rowsSubmitted_c['PartofInternationalProject'];?> <span class="text-danger">*</span>
      </label>
      <div class="radio-group">
        <div class="radio-item">
          <input type="radio" id="projectNo" name="PartofInternationalProject" value="No" onChange="getProjectSpecificActivities(this.value)" <?php if($rUserInv2['PartofInternationalProject']=='No'){?>checked="checked"<?php }?>>
          <label for="projectNo"><?php echo $lang_No;?></label>
        </div>
        <div class="radio-item">
          <input type="radio" id="projectYes" name="PartofInternationalProject" value="Yes" onChange="getProjectSpecificActivities(this.value)" <?php if($rUserInv2['PartofInternationalProject']=='Yes'){?>checked="checked"<?php }?>>
          <label for="projectYes"><?php echo $lang_Yes;?></label>
        </div>
      </div>
    </div>
    <?php }?>
  
    <?php if($rowsSubmitted_c['projectSpecificActivities_status']=='Enable'){?>
    <div class="form-group">
      <div id="projectSpecificActivities">
        <?php if($rUserInv2['projectSpecificActivities']){?>
        <label for="projectSpecificActivities">
          <?php echo $rowsSubmitted_c['projectSpecificActivities'];?> <span class="text-danger">*</span>
        </label>
        <textarea id="MyTextBox11" name="projectSpecificActivities" class="form-control" required><?php echo $rUserInv2['projectSpecificActivities'];?></textarea>
        <div class="invalid-feedback">Please provide project specific activities.</div>
        <?php }?>
      </div>
    </div>
    <?php }?>
  
    <div class="form-group" style="margin-top: 2rem;">
      <button type="submit" name="doSaveData" class="btn btn-primary">
        <i class="fa fa-save" style="margin-right: 8px;"></i> <?php echo $lang_SaveandNext;?>
      </button>
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

// JavaScript for form validation
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all forms we want to apply custom validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
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

// Handle the conditional display of project specific activities
function getProjectSpecificActivities(val) {
  if(val == 'Yes') {
    // If not already showing, add the field
    var container = document.getElementById('projectSpecificActivities');
    if (!container.querySelector('textarea')) {
      var label = document.createElement('label');
      label.innerHTML = '<?php echo $rowsSubmitted_c['projectSpecificActivities'];?> <span class="text-danger">*</span>';
      
      var textarea = document.createElement('textarea');
      textarea.id = 'MyTextBox11';
      textarea.name = 'projectSpecificActivities';
      textarea.className = 'form-control';
      textarea.required = true;
      
      var feedback = document.createElement('div');
      feedback.className = 'invalid-feedback';
      feedback.textContent = 'Please provide project specific activities.';
      
      container.appendChild(label);
      container.appendChild(textarea);
      container.appendChild(feedback);
    }
  } else {
    // Remove the field if it exists
    document.getElementById('projectSpecificActivities').innerHTML = '';
  }
}
</script>