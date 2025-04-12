<script type="text/javascript">
function findTotal(){
    var arr = document.getElementsByClassName('amount');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseFloat(arr[i].value))
            tot += parseFloat(arr[i].value);
    }
    document.getElementById('TotalCeiling').value = tot;
}

    </script>
    <script language="JavaScript">
function toggle(source) {
    var radio = document.querySelectorAll('input[type="radio"]');
    for (var i = 0; i < radio.length; i++) {
        if (radio[i] != source)
            radio[i].checked = source.checked;
    }
}
</script>
<?php
$sessionusrm_id=$_SESSION['usrm_id'];

//Save only Category 1

if($_POST['doSaveDataProjectInformation']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//


$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$qn_title=$mysqli->real_escape_string($_POST['qn_title']);
$qn_title_number=$mysqli->real_escape_string($_POST['qn_title_number']);
$qn_title_status=$mysqli->real_escape_string($_POST['qn_title_status']);
$qn_acronym=$mysqli->real_escape_string($_POST['qn_acronym']);
$qn_acronym_number=$mysqli->real_escape_string($_POST['qn_acronym_number']);
$qn_acronym_status=$mysqli->real_escape_string($_POST['qn_acronym_status']);
$qn_relevantKeywords=$mysqli->real_escape_string($_POST['qn_relevantKeywords']);
$qn_relevantKeywords_number=$mysqli->real_escape_string($_POST['qn_relevantKeywords_number']);

$qn_relevantKeywords_status=$mysqli->real_escape_string($_POST['qn_relevantKeywords_status']);
$qn_researchTypeID=$mysqli->real_escape_string($_POST['qn_researchTypeID']);
$qn_researchTypeID_number=$mysqli->real_escape_string($_POST['qn_researchTypeID_number']);
$qn_researchTypeID_status=$mysqli->real_escape_string($_POST['qn_researchTypeID_status']);
$qn_HostInstitution=$mysqli->real_escape_string($_POST['qn_HostInstitution']);
$qn_HostInstitution_number=$mysqli->real_escape_string($_POST['qn_HostInstitution_number']);
$qn_HostInstitution_status=$mysqli->real_escape_string($_POST['qn_HostInstitution_status']);
$qn_projectDurationID=$mysqli->real_escape_string($_POST['qn_projectDurationID']);
$qn_projectDurationID_number=$mysqli->real_escape_string($_POST['qn_projectDurationID_number']);
$qn_projectDurationID_status=$mysqli->real_escape_string($_POST['qn_projectDurationID_status']);

$qn_fundingappliedfor=$mysqli->real_escape_string($_POST['qn_fundingappliedfor']);
$qn_fundingappliedfor_status=$mysqli->real_escape_string($_POST['qn_fundingappliedfor_status']);
$qn_fundingappliedfor_number=$mysqli->real_escape_string($_POST['qn_fundingappliedfor_number']);

$qn_OrchidID=$mysqli->real_escape_string($_POST['qn_OrchidID']);
$qn_OrchidID_number=$mysqli->real_escape_string($_POST['qn_OrchidID_number']);
$qn_OrchidID_status=$mysqli->real_escape_string($_POST['qn_OrchidID_status']);



$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_a where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='proposal' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_a (`categoryID`,`catadmin_id`,`categorym`,`qn_title`,`qn_title_number`,`qn_title_status`,`qn_acronym`,`qn_acronym_number`,`qn_acronym_status`,`qn_relevantKeywords`,`qn_relevantKeywords_number`,`qn_relevantKeywords_status`,`qn_researchTypeID`,`qn_researchTypeID_number`,`qn_researchTypeID_status`,`qn_HostInstitution`,`qn_HostInstitution_number`,`qn_HostInstitution_status`,`qn_projectDurationID`,`qn_projectDurationID_number`,`qn_projectDurationID_status`,`qn_OrchidID`,`qn_OrchidID_number`,`qn_OrchidID_status`,`is_sent`,`Date_added`,`grantID`,`qn_fundingappliedfor`,`qn_fundingappliedfor_status`,`qn_fundingappliedfor_number`) 

values('$categoryID','$sessionusrm_id','proposal','$qn_title','$qn_title_number','$qn_title_status','$qn_acronym','$qn_acronym_number','$qn_acronym_status','$qn_relevantKeywords','$qn_relevantKeywords_number','$qn_relevantKeywords_status','$qn_researchTypeID','$qn_researchTypeID_number','$qn_researchTypeID_status','$qn_HostInstitution','$qn_HostInstitution_number','$qn_HostInstitution_status','$qn_projectDurationID','$qn_projectDurationID_number','$qn_projectDurationID_status','$qn_OrchidID','$qn_OrchidID_number','$qn_OrchidID_status','0',now(),'$id','$qn_fundingappliedfor','$qn_fundingappliedfor_status','$qn_fundingappliedfor_number')";
$mysqli->query($sqlA2);	
$questionID = $mysqli->insert_id;
logaction("$session_fullname added created Project Information");

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `ProjectInformation`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

}
//Totals already submitted
if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_a set `qn_title`='$qn_title',`qn_title_number`='$qn_title_number',`qn_title_status`='$qn_title_status',`qn_acronym`='$qn_acronym',`qn_acronym_number`='$qn_acronym_number',`qn_acronym_status`='$qn_acronym_status',`qn_relevantKeywords`='$qn_relevantKeywords',`qn_relevantKeywords_number`='$qn_relevantKeywords_number',`qn_relevantKeywords_status`='$qn_relevantKeywords_status',`qn_researchTypeID`='$qn_researchTypeID'
,`qn_researchTypeID_number`='$qn_researchTypeID_number',`qn_researchTypeID_status`='$qn_researchTypeID_status',`qn_HostInstitution`='$qn_HostInstitution',`qn_HostInstitution_number`='$qn_HostInstitution_number',`qn_HostInstitution_status`='$qn_HostInstitution_status',`qn_projectDurationID`='$qn_projectDurationID',`qn_projectDurationID_number`='$qn_projectDurationID_number',`qn_projectDurationID_status`='$qn_projectDurationID_status',`qn_OrchidID`='$qn_OrchidID',`qn_OrchidID_number`='$qn_OrchidID_number',`qn_OrchidID_status`='$qn_OrchidID_status',`qn_fundingappliedfor`='$qn_fundingappliedfor',`qn_fundingappliedfor_status`='$qn_fundingappliedfor_status',`qn_fundingappliedfor_number`='$qn_fundingappliedfor_number' where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id' and categorym='proposal'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added created Project Information");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	
/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `ProjectInformation`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);
}

}
//End Project Information


if($_POST['doSaveDataProjectBackground']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//


$categoryID=$mysqli->real_escape_string($_POST['categoryID']);

$SummaryAudience=$mysqli->real_escape_string($_POST['SummaryAudience']);
$SummaryAudience_number=$mysqli->real_escape_string($_POST['SummaryAudience_number']);
$SummaryAudience_status=$mysqli->real_escape_string($_POST['SummaryAudience_status']);

$explanationObjectives=$mysqli->real_escape_string($_POST['explanationObjectives']);
$explanationObjectives_number=$mysqli->real_escape_string($_POST['explanationObjectives_number']);
$explanationObjectives_status=$mysqli->real_escape_string($_POST['explanationObjectives_status']);
$researchInnovationIssues=$mysqli->real_escape_string($_POST['researchInnovationIssues']);

$researchInnovationIssues_number=$mysqli->real_escape_string($_POST['researchInnovationIssues_number']);
$researchInnovationIssues_status=$mysqli->real_escape_string($_POST['researchInnovationIssues_status']);
$NovelCharacterScientificResearch=$mysqli->real_escape_string($_POST['NovelCharacterScientificResearch']);
$NovelCharacterScientificResearch_number=$mysqli->real_escape_string($_POST['NovelCharacterScientificResearch_number']);
$NovelCharacterScientificResearch_status=$mysqli->real_escape_string($_POST['NovelCharacterScientificResearch_status']);
$ClearJustificationDemonstration=$mysqli->real_escape_string($_POST['ClearJustificationDemonstration']);
$ClearJustificationDemonstration_number=$mysqli->real_escape_string($_POST['ClearJustificationDemonstration_number']);
$ClearJustificationDemonstration_status=$mysqli->real_escape_string($_POST['ClearJustificationDemonstration_status']);
$interdisciplinaryTransdisciplinary=$mysqli->real_escape_string($_POST['interdisciplinaryTransdisciplinary']);
$interdisciplinaryTransdisciplinary_number=$mysqli->real_escape_string($_POST['interdisciplinaryTransdisciplinary_number']);
$interdisciplinaryTransdisciplinary_status=$mysqli->real_escape_string($_POST['interdisciplinaryTransdisciplinary_status']);

$addedValue=$mysqli->real_escape_string($_POST['addedValue']);
$addedValue_number=$mysqli->real_escape_string($_POST['addedValue_number']);
$addedValue_status=$mysqli->real_escape_string($_POST['addedValue_status']);
$ImportanceResearchInnovation=$mysqli->real_escape_string($_POST['ImportanceResearchInnovation']);
$ImportanceResearchInnovation_number=$mysqli->real_escape_string($_POST['ImportanceResearchInnovation_number']);
$ImportanceResearchInnovation_status=$mysqli->real_escape_string($_POST['ImportanceResearchInnovation_status']);
$PartofInternationalProject=$mysqli->real_escape_string($_POST['PartofInternationalProject']);
$PartofInternationalProject_number=$mysqli->real_escape_string($_POST['PartofInternationalProject_number']);
$PartofInternationalProject_status=$mysqli->real_escape_string($_POST['PartofInternationalProject_status']);
$projectSpecificActivities=$mysqli->real_escape_string($_POST['projectSpecificActivities']);
$projectSpecificActivities_number=$mysqli->real_escape_string($_POST['projectSpecificActivities_number']);
$projectSpecificActivities_status=$mysqli->real_escape_string($_POST['projectSpecificActivities_status']);



$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_g where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='proposal' and catadmin_id='$sessionusrm_id'  and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_g (`categoryID`,`catadmin_id`,`categorym`,`SummaryAudience`,`SummaryAudience_number`,`SummaryAudience_status`,`explanationObjectives`,`explanationObjectives_number`,`explanationObjectives_status`,`researchInnovationIssues`,`researchInnovationIssues_number`,`researchInnovationIssues_status`,`NovelCharacterScientificResearch`,`NovelCharacterScientificResearch_number`,`NovelCharacterScientificResearch_status`,`ClearJustificationDemonstration`,`ClearJustificationDemonstration_number`,`ClearJustificationDemonstration_status`,`interdisciplinaryTransdisciplinary`,`interdisciplinaryTransdisciplinary_number`,`interdisciplinaryTransdisciplinary_status`,`addedValue`,`addedValue_number`,`addedValue_status`,`ImportanceResearchInnovation`,`ImportanceResearchInnovation_number`,`ImportanceResearchInnovation_status`,`PartofInternationalProject`,`PartofInternationalProject_number`,`PartofInternationalProject_status`,`projectSpecificActivities`,`projectSpecificActivities_number`,`projectSpecificActivities_status`,`is_sent`,`Date_added`,`grantID`
) 

values('$categoryID','$sessionusrm_id','proposal','$SummaryAudience','$SummaryAudience_number','$SummaryAudience_status','$explanationObjectives','$explanationObjectives_number','$explanationObjectives_status','$researchInnovationIssues','$researchInnovationIssues_number','$researchInnovationIssues_status','$NovelCharacterScientificResearch','$NovelCharacterScientificResearch_number','$NovelCharacterScientificResearch_status','$ClearJustificationDemonstration','$ClearJustificationDemonstration_number','$ClearJustificationDemonstration_status','$interdisciplinaryTransdisciplinary','$interdisciplinaryTransdisciplinary_number','$interdisciplinaryTransdisciplinary_status','$addedValue','$addedValue_number','$addedValue_status','$ImportanceResearchInnovation','$ImportanceResearchInnovation_number','$ImportanceResearchInnovation_status','$PartofInternationalProject','$PartofInternationalProject_number','$PartofInternationalProject_status','$projectSpecificActivities','$projectSpecificActivities_number','$projectSpecificActivities_status','0',now(),'$id')";
$mysqli->query($sqlA2);	
logaction("$session_fullname added created Project Details");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `ProjectDetails`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);
}
//Totals already submitted
if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_g set `SummaryAudience`='$SummaryAudience',`SummaryAudience_number`='$SummaryAudience_number',`SummaryAudience_status`='$SummaryAudience_status',`explanationObjectives`='$explanationObjectives',`explanationObjectives_number`='$explanationObjectives_number',`explanationObjectives_status`='$explanationObjectives_status',`researchInnovationIssues`='$researchInnovationIssues'
,`researchInnovationIssues_number`='$researchInnovationIssues_number',`researchInnovationIssues_status`='$researchInnovationIssues_status',`NovelCharacterScientificResearch`='$NovelCharacterScientificResearch'
,`NovelCharacterScientificResearch_number`='$NovelCharacterScientificResearch_number',`NovelCharacterScientificResearch_status`='$NovelCharacterScientificResearch_status',`ClearJustificationDemonstration`='$ClearJustificationDemonstration',`ClearJustificationDemonstration_number`='$ClearJustificationDemonstration_number',`ClearJustificationDemonstration_status`='$ClearJustificationDemonstration_status',`interdisciplinaryTransdisciplinary`='$interdisciplinaryTransdisciplinary',`interdisciplinaryTransdisciplinary_number`='$interdisciplinaryTransdisciplinary_number',`interdisciplinaryTransdisciplinary_status`='$interdisciplinaryTransdisciplinary_status',`addedValue`='$addedValue',`addedValue_number`='$addedValue_number',`addedValue_status`='$addedValue_status',`ImportanceResearchInnovation`='$ImportanceResearchInnovation'
,`ImportanceResearchInnovation_number`='$ImportanceResearchInnovation_number',`ImportanceResearchInnovation_status`='$ImportanceResearchInnovation_status',`PartofInternationalProject`='$PartofInternationalProject'
,`PartofInternationalProject_number`='$PartofInternationalProject_number',`PartofInternationalProject_status`='$PartofInternationalProject_status',`projectSpecificActivities`='$projectSpecificActivities',`projectSpecificActivities_number`='$projectSpecificActivities_number',`projectSpecificActivities_status`='$projectSpecificActivities_status'


 where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added created Project Details");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `ProjectDetails`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);
}

}
//End Project Information


if($_POST['doSaveDataProjectMethodology']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//

if($_POST['qn_ExpectedIntellectualProperty']){
for ($i=0; $i < count($_POST['qn_ExpectedIntellectualProperty']); $i++) {

$qn_ExpectedIntellectualProperty.=$mysqli->real_escape_string($_POST['qn_ExpectedIntellectualProperty'][$i]).',';
}}

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$generalApproach=$mysqli->real_escape_string($_POST['generalApproach']);
$generalApproach_number=$mysqli->real_escape_string($_POST['generalApproach_number']);
$generalApproach_status=$mysqli->real_escape_string($_POST['generalApproach_status']);
$RelationshipOngoingResearch=$mysqli->real_escape_string($_POST['RelationshipOngoingResearch']);
$RelationshipOngoingResearch_number=$mysqli->real_escape_string($_POST['RelationshipOngoingResearch_number']);
$RelationshipOngoingResearch_status=$mysqli->real_escape_string($_POST['RelationshipOngoingResearch_status']);
$otherDonorsFunding=$mysqli->real_escape_string($_POST['otherDonorsFunding']);
$otherDonorsFunding_number=$mysqli->real_escape_string($_POST['otherDonorsFunding_number']);

$otherDonorsFunding_status=$mysqli->real_escape_string($_POST['otherDonorsFunding_status']);
$drawSynergiesOngoingProjects=$mysqli->real_escape_string($_POST['drawSynergiesOngoingProjects']);
$drawSynergiesOngoingProjects_number=$mysqli->real_escape_string($_POST['drawSynergiesOngoingProjects_number']);
$drawSynergiesOngoingProjects_status=$mysqli->real_escape_string($_POST['drawSynergiesOngoingProjects_status']);



$furtheringwork=$mysqli->real_escape_string($_POST['furtheringwork']);
$furtheringwork_number=$mysqli->real_escape_string($_POST['furtheringwork_number']);
$furtheringwork_status=$mysqli->real_escape_string($_POST['furtheringwork_status']);
$synergymayexistbetween=$mysqli->real_escape_string($_POST['synergymayexistbetween']);
$synergymayexistbetween_number=$mysqli->real_escape_string($_POST['synergymayexistbetween_number']);
$synergymayexistbetween_status=$mysqli->real_escape_string($_POST['synergymayexistbetween_status']);

$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_h where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='proposal' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_h (`categoryID`,`catadmin_id`,`categorym`,`generalApproach`,`generalApproach_number`,`generalApproach_status`,`RelationshipOngoingResearch`,`RelationshipOngoingResearch_number`,`RelationshipOngoingResearch_status`,`otherDonorsFunding`,`otherDonorsFunding_number`,`otherDonorsFunding_status`,`drawSynergiesOngoingProjects`,`drawSynergiesOngoingProjects_number`,`drawSynergiesOngoingProjects_status`,`is_sent`,`Date_added`,`grantID`,`furtheringwork`,`furtheringwork_number`,`furtheringwork_status`,`synergymayexistbetween`,`synergymayexistbetween_number`,`synergymayexistbetween_status`) 

values('$categoryID','$sessionusrm_id','proposal','$generalApproach','$generalApproach_number','$generalApproach_status','$RelationshipOngoingResearch','$RelationshipOngoingResearch_number','$RelationshipOngoingResearch_status','$otherDonorsFunding','$otherDonorsFunding_number','$otherDonorsFunding_status','$drawSynergiesOngoingProjects','$drawSynergiesOngoingProjects_number','$drawSynergiesOngoingProjects_status','0',now(),'$id','$furtheringwork','$furtheringwork_number','$furtheringwork_status','$synergymayexistbetween','$synergymayexistbetween_number','$synergymayexistbetween_status')";
$mysqli->query($sqlA2);	
logaction("$session_fullname added created Project Introduction");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `Methodology`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);

}
//Totals already submitted
if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_h set `generalApproach`='$generalApproach',`generalApproach_number`='$generalApproach_number',`generalApproach_status`='$generalApproach_status',`RelationshipOngoingResearch`='$RelationshipOngoingResearch',`RelationshipOngoingResearch_number`='$RelationshipOngoingResearch_number',`RelationshipOngoingResearch_status`='$RelationshipOngoingResearch_status',`otherDonorsFunding`='$otherDonorsFunding',`otherDonorsFunding_number`='$otherDonorsFunding_number',`otherDonorsFunding_status`='$otherDonorsFunding_status',`drawSynergiesOngoingProjects`='$drawSynergiesOngoingProjects',`drawSynergiesOngoingProjects_number`='$drawSynergiesOngoingProjects_number',`drawSynergiesOngoingProjects_status`='$drawSynergiesOngoingProjects_status',`furtheringwork`='$furtheringwork',`furtheringwork_number`='$furtheringwork_number',`furtheringwork_status`='$furtheringwork_status',`synergymayexistbetween`='$synergymayexistbetween',`synergymayexistbetween_number`='$synergymayexistbetween_number',`synergymayexistbetween_status`='$synergymayexistbetween_status' where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added created Project Introduction");

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `Methodology`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);
}

}
//End Project Information

if($_POST['doSaveDataProjectTeam']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//
$categoryID=$mysqli->real_escape_string($_POST['categoryID']);

$qn_principle_investigator=$mysqli->real_escape_string($_POST['qn_principle_investigator']);
$qn_principle_investigator_number=$mysqli->real_escape_string($_POST['qn_principle_investigator_number']);
$qn_principle_investigator_status=$mysqli->real_escape_string($_POST['qn_principle_investigator_status']);


$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_d where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='concept' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_d (`categoryID`,`catadmin_id`,`categorym`,`qn_principle_investigator`,`qn_principle_investigator_number`,`qn_principle_investigator_status`,`is_sent`,`Date_added`,`grantID`) 

values('$categoryID','$sessionusrm_id','proposal','$qn_principle_investigator','$qn_principle_investigator_number','$qn_principle_investigator_status','0',now(),'$id')";
$mysqli->query($sqlA2);	
logaction("$session_fullname added created Project Team");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	


/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `ProjectTeam`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
//$mysqli->query($sqlAStatus);

}
//Totals already submitted
if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_d set `qn_principle_investigator`='$qn_principle_investigator',`qn_principle_investigator_number`='$qn_principle_investigator_number',`qn_principle_investigator_status`='$qn_principle_investigator_status' where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added created Project Team");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `ProjectTeam`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);
}


}
//End Project Team
/////////////////////////////////update Budget

if($_POST['doSaveDataProjectBudget']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//
//Check Budget Ceiling. Maximum should be 100
$TotalCeiling=$mysqli->real_escape_string($_POST['TotalCeiling']);
if($TotalCeiling>100){
	$message='<p class="error">Dear '.$session_fullname.', Total Budget Ceiling is greaterthan 100. Budget has NOT been added.</p>';
}else{

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$qn_Personnel=$mysqli->real_escape_string($_POST['qn_Personnel']);
$qn_PersonnelPercentage_Ceiling=$mysqli->real_escape_string($_POST['qn_PersonnelPercentage_Ceiling']);
$qn_Personnel_status=$mysqli->real_escape_string($_POST['qn_Personnel_status']);
$qn_ResearchCosts=$mysqli->real_escape_string($_POST['qn_ResearchCosts']);
$qn_ResearchCosts_Ceiling=$mysqli->real_escape_string($_POST['qn_ResearchCosts_Ceiling']);
$qn_ResearchCosts_status=$mysqli->real_escape_string($_POST['qn_ResearchCosts_status']);
$qn_Equipment=$mysqli->real_escape_string($_POST['qn_Equipment']);
$qn_Equipment_Ceiling=$mysqli->real_escape_string($_POST['qn_Equipment_Ceiling']);
$qn_Equipment_Ceiling_status=$mysqli->real_escape_string($_POST['qn_Equipment_Ceiling_status']);
$qn_Travel=$mysqli->real_escape_string($_POST['qn_Travel']);
$qn_Travel_Ceiling=$mysqli->real_escape_string($_POST['qn_Travel_Ceiling']);
$qn_Travel_status=$mysqli->real_escape_string($_POST['qn_Travel_status']);
$qn_kickoff=$mysqli->real_escape_string($_POST['qn_kickoff']);
$qn_kickoff_Ceiling=$mysqli->real_escape_string($_POST['qn_kickoff_Ceiling']);
$qn_kickoff_status=$mysqli->real_escape_string($_POST['qn_kickoff_status']);
$qn_KnowledgeSharing=$mysqli->real_escape_string($_POST['qn_KnowledgeSharing']);
$qn_KnowledgeSharing_Ceiling=$mysqli->real_escape_string($_POST['qn_KnowledgeSharing_Ceiling']);
$qn_KnowledgeSharing_status=$mysqli->real_escape_string($_POST['qn_KnowledgeSharing_status']);
$qn_OverheadCosts=$mysqli->real_escape_string($_POST['qn_OverheadCosts']);
$qn_OverheadCosts_Ceiling=$mysqli->real_escape_string($_POST['qn_OverheadCosts_Ceiling']);
$qn_OverheadCosts_status=$mysqli->real_escape_string($_POST['qn_OverheadCosts_status']);
$qn_OtherGoods=$mysqli->real_escape_string($_POST['qn_OtherGoods']);
$qn_OtherGoods_Ceiling=$mysqli->real_escape_string($_POST['qn_OtherGoods_Ceiling']);
$qn_OtherGoods_status=$mysqli->real_escape_string($_POST['qn_OtherGoods_status']);
$qn_MatchingSupport=$mysqli->real_escape_string($_POST['qn_MatchingSupport']);


$qn_MatchingSupport_Ceiling=$mysqli->real_escape_string($_POST['qn_MatchingSupport_Ceiling']);
$qn_MatchingSupport_status=$mysqli->real_escape_string($_POST['qn_MatchingSupport_status']);


$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_e where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='proposal' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_e (`categoryID`,`catadmin_id`,`categorym`,`qn_Personnel`,`qn_PersonnelPercentage_Ceiling`,`qn_Personnel_status`,`qn_ResearchCosts`,`qn_ResearchCosts_Ceiling`,`qn_ResearchCosts_status`,`qn_Equipment`,`qn_Equipment_Ceiling`,`qn_Equipment_Ceiling_status`,`qn_Travel`,`qn_Travel_Ceiling`,`qn_Travel_status`,`qn_kickoff`,`qn_kickoff_Ceiling`,`qn_kickoff_status`,`qn_KnowledgeSharing`,`qn_KnowledgeSharing_Ceiling`,`qn_KnowledgeSharing_status`,`qn_OverheadCosts`,`qn_OverheadCosts_Ceiling`,`qn_OverheadCosts_status`,`qn_OtherGoods`,`qn_OtherGoods_Ceiling`,`qn_OtherGoods_status`,`qn_MatchingSupport`,`qn_MatchingSupport_Ceiling`,`qn_MatchingSupport_status`,`is_sent`,`Date_added`,`grantID`,`TotalCeiling`) 

values('$categoryID','$sessionusrm_id','proposal','$qn_Personnel','$qn_PersonnelPercentage_Ceiling','$qn_Personnel_status','$qn_ResearchCosts','$qn_ResearchCosts_Ceiling','$qn_ResearchCosts_status','$qn_Equipment','$qn_Equipment_Ceiling','$qn_Equipment_Ceiling_status','$qn_Travel','$qn_Travel_Ceiling','$qn_Travel_status','$qn_kickoff','$qn_kickoff_Ceiling','$qn_kickoff_status','$qn_KnowledgeSharing','$qn_KnowledgeSharing_Ceiling','$qn_KnowledgeSharing_status','$qn_OverheadCosts','$qn_OverheadCosts_Ceiling','$qn_OverheadCosts_status','$qn_OtherGoods','$qn_OtherGoods_Ceiling','$qn_OtherGoods_status','$qn_MatchingSupport','$qn_MatchingSupport_Ceiling','$qn_MatchingSupport_status','0',now(),'$id','$TotalCeiling')";
$mysqli->query($sqlA2);	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `Budget`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	
logaction("$session_fullname added created Project Budget");
}
//Totals already submitted
if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_e set `qn_Personnel`='$qn_Personnel',`qn_PersonnelPercentage_Ceiling`='$qn_PersonnelPercentage_Ceiling',`qn_Personnel_status`='$qn_Personnel_status',`qn_ResearchCosts`='$qn_ResearchCosts',`qn_ResearchCosts_Ceiling`='$qn_ResearchCosts_Ceiling',`qn_ResearchCosts_status`='$qn_ResearchCosts_status',`qn_Equipment`='$qn_Equipment',`qn_Equipment_Ceiling`='$qn_Equipment_Ceiling',`qn_Equipment_Ceiling_status`='$qn_Equipment_Ceiling_status',`qn_Travel`='$qn_Travel',`qn_Travel_Ceiling`='$qn_Travel_Ceiling',`qn_Travel_status`='$qn_Travel_status',`qn_kickoff`='$qn_kickoff',`qn_kickoff_Ceiling`='$qn_kickoff_Ceiling',`qn_kickoff_status`='$qn_kickoff_status',`qn_KnowledgeSharing`='$qn_KnowledgeSharing',`qn_KnowledgeSharing_Ceiling`='$qn_KnowledgeSharing_Ceiling',`qn_KnowledgeSharing_status`='$qn_KnowledgeSharing_status',`qn_OverheadCosts`='$qn_OverheadCosts',`qn_OverheadCosts_Ceiling`='$qn_OverheadCosts_Ceiling'
,`qn_OverheadCosts_status`='$qn_OverheadCosts_status',`qn_OtherGoods`='$qn_OtherGoods',`qn_OtherGoods_Ceiling`='$qn_OtherGoods_Ceiling',`qn_OtherGoods_status`='$qn_OtherGoods_status',`qn_MatchingSupport`='$qn_MatchingSupport',`qn_MatchingSupport_Ceiling`='$qn_MatchingSupport_Ceiling',`qn_MatchingSupport_status`='$qn_MatchingSupport_status',`TotalCeiling`='$TotalCeiling' where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id' and categorym='proposal'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added updated Project Budget");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `Budget`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);

}
}///end TotalCeiling
}
//End Project Budget



if($_POST['doSaveDataProjectFollowup']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);


$resultExploitationPlan=$mysqli->real_escape_string($_POST['resultExploitationPlan']);
$resultExploitationPlan_number=$mysqli->real_escape_string($_POST['resultExploitationPlan_number']);
$resultExploitationPlan_status=$mysqli->real_escape_string($_POST['resultExploitationPlan_status']);

$resultInnovativeResults=$mysqli->real_escape_string($_POST['resultInnovativeResults']);
$resultInnovativeResults_number=$mysqli->real_escape_string($_POST['resultInnovativeResults_number']);
$resultInnovativeResults_status=$mysqli->real_escape_string($_POST['resultInnovativeResults_status']);

$resultIntellectualProperty=$mysqli->real_escape_string($_POST['resultIntellectualProperty']);
$resultIntellectualProperty_number=$mysqli->real_escape_string($_POST['resultIntellectualProperty_number']);
$resultIntellectualProperty_status=$mysqli->real_escape_string($_POST['resultIntellectualProperty_status']);


$ethicalConsiderations=$mysqli->real_escape_string($_POST['ethicalConsiderations']);
$ethicalConsiderations_number=$mysqli->real_escape_string($_POST['ethicalConsiderations_number']);
$ethicalConsiderations_status=$mysqli->real_escape_string($_POST['ethicalConsiderations_status']);

$DealwithEthicalIssues=$mysqli->real_escape_string($_POST['DealwithEthicalIssues']);
$DealwithEthicalIssues_number=$mysqli->real_escape_string($_POST['DealwithEthicalIssues_number']);
$DealwithEthicalIssues_status=$mysqli->real_escape_string($_POST['DealwithEthicalIssues_status']);

$NeedEthicalClearance=$mysqli->real_escape_string($_POST['NeedEthicalClearance']);
$NeedEthicalClearance_number=$mysqli->real_escape_string($_POST['NeedEthicalClearance_number']);
$NeedEthicalClearance_status=$mysqli->real_escape_string($_POST['NeedEthicalClearance_status']);

$GenderYouth=$mysqli->real_escape_string($_POST['GenderYouth']);
$GenderYouth_number=$mysqli->real_escape_string($_POST['GenderYouth_number']);
$GenderYouth_status=$mysqli->real_escape_string($_POST['GenderYouth_status']);
$YoungResearchers=$mysqli->real_escape_string($_POST['YoungResearchers']);

$YoungResearchers_number=$mysqli->real_escape_string($_POST['YoungResearchers_number']);
$YoungResearchers_status=$mysqli->real_escape_string($_POST['YoungResearchers_status']);
$InterestGroups=$mysqli->real_escape_string($_POST['InterestGroups']);
$InterestGroups_number=$mysqli->real_escape_string($_POST['InterestGroups_number']);

$InterestGroups_status=$mysqli->real_escape_string($_POST['InterestGroups_status']);
$StateNatureofSupport=$mysqli->real_escape_string($_POST['StateNatureofSupport']);
$StateNatureofSupport_number=$mysqli->real_escape_string($_POST['StateNatureofSupport_number']);
$StateNatureofSupport_status=$mysqli->real_escape_string($_POST['StateNatureofSupport_status']);

$AttachLetterofSupport=$mysqli->real_escape_string($_POST['AttachLetterofSupport']);
$AttachLetterofSupport_number=$mysqli->real_escape_string($_POST['AttachLetterofSupport_number']);
$AttachLetterofSupport_status=$mysqli->real_escape_string($_POST['AttachLetterofSupport_status']);

$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_i where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='proposal' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_i (`categoryID`,`catadmin_id`,`categorym`,`resultExploitationPlan`,`resultExploitationPlan_number`,`resultExploitationPlan_status`,`resultInnovativeResults`,`resultInnovativeResults_number`,`resultInnovativeResults_status`,`resultIntellectualProperty`,`resultIntellectualProperty_number`,`resultIntellectualProperty_status`,`ethicalConsiderations`,`ethicalConsiderations_number`,`ethicalConsiderations_status`,`DealwithEthicalIssues`,`DealwithEthicalIssues_number`,`DealwithEthicalIssues_status`,`NeedEthicalClearance`,`NeedEthicalClearance_number`,`NeedEthicalClearance_status`,`GenderYouth`,`GenderYouth_number`,`GenderYouth_status`,`YoungResearchers`,`YoungResearchers_number`,`YoungResearchers_status`,`InterestGroups`,`InterestGroups_number`,`InterestGroups_status`,`StateNatureofSupport`,`StateNatureofSupport_number`,`StateNatureofSupport_status`,`AttachLetterofSupport`,`AttachLetterofSupport_number`,`AttachLetterofSupport_status`,`is_sent`,`Date_added`,`grantID`) 

values('$categoryID','$sessionusrm_id','proposal','$resultExploitationPlan','$resultExploitationPlan_number','$resultExploitationPlan_status','$resultInnovativeResults','$resultInnovativeResults_number','$resultInnovativeResults_status','$resultIntellectualProperty','$resultIntellectualProperty_number','$resultIntellectualProperty_status','$ethicalConsiderations','$ethicalConsiderations_number','$ethicalConsiderations_status','$DealwithEthicalIssues','$DealwithEthicalIssues_number','$DealwithEthicalIssues_status','$NeedEthicalClearance','$NeedEthicalClearance_number','$NeedEthicalClearance_status','$GenderYouth','$GenderYouth_number','$GenderYouth_status','$YoungResearchers','$YoungResearchers_number','$YoungResearchers_status','$InterestGroups','$InterestGroups_number','$InterestGroups_status','$StateNatureofSupport','$StateNatureofSupport_number','$StateNatureofSupport_status','$AttachLetterofSupport','$AttachLetterofSupport_number','$AttachLetterofSupport_status','0',now(),'$id')";
$mysqli->query($sqlA2);	

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	
logaction("$session_fullname added created Project Citation");

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `followup`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);
}
//Totals already submitted


if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_i set `resultExploitationPlan`='$resultExploitationPlan',`resultExploitationPlan_number`='$resultExploitationPlan_number',`resultExploitationPlan_status`='$resultExploitationPlan_status',`resultInnovativeResults`='$resultInnovativeResults',`resultInnovativeResults_number`='$resultInnovativeResults_number'
,`resultInnovativeResults_status`='$resultInnovativeResults_status',`resultIntellectualProperty_number`='$resultIntellectualProperty_number',`resultIntellectualProperty_status`='$resultIntellectualProperty_status',`ethicalConsiderations`='$ethicalConsiderations',`ethicalConsiderations_number`='$ethicalConsiderations_number'
,`ethicalConsiderations_status`='$ethicalConsiderations_status',`DealwithEthicalIssues`='$DealwithEthicalIssues',`DealwithEthicalIssues_number`='$DealwithEthicalIssues_number',`DealwithEthicalIssues_status`='$DealwithEthicalIssues_status',`NeedEthicalClearance`='$NeedEthicalClearance'
,`NeedEthicalClearance_number`='$NeedEthicalClearance_number',`NeedEthicalClearance_status`='$NeedEthicalClearance_status',`GenderYouth`='$GenderYouth',`GenderYouth_number`='$GenderYouth_number',`GenderYouth_status`='$GenderYouth_status'
,`YoungResearchers`='$YoungResearchers',`YoungResearchers_number`='$YoungResearchers_number',`YoungResearchers_status`='$YoungResearchers_status',`InterestGroups`='$InterestGroups',`InterestGroups_number`='$InterestGroups_number'
,`InterestGroups_status`='$InterestGroups_status',`StateNatureofSupport`='$StateNatureofSupport',`StateNatureofSupport_number`='$StateNatureofSupport_number',`StateNatureofSupport_status`='$StateNatureofSupport_status',`AttachLetterofSupport`='$AttachLetterofSupport'
,`AttachLetterofSupport_number`='$AttachLetterofSupport_number',`AttachLetterofSupport_status`='$AttachLetterofSupport_status' where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added updated Project Citation");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `followup`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);
}
}
//End Project Citations



if($_POST['doSaveDataProjectResults']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);


$logicalflow=$mysqli->real_escape_string($_POST['logicalflow']);
$logicalflow_number=$mysqli->real_escape_string($_POST['logicalflow_number']);
$logicalflow_status=$mysqli->real_escape_string($_POST['logicalflow_status']);

$ResearchObjective=$mysqli->real_escape_string($_POST['ResearchObjective']);
$ResearchObjective_number=$mysqli->real_escape_string($_POST['ResearchObjective_number']);
$ResearchObjective_status=$mysqli->real_escape_string($_POST['ResearchObjective_status']);

$Outputs=$mysqli->real_escape_string($_POST['Outputs']);
$Outputs_number=$mysqli->real_escape_string($_POST['Outputs_number']);
$Outputs_status=$mysqli->real_escape_string($_POST['Outputs_status']);


$Outcomes=$mysqli->real_escape_string($_POST['Outcomes']);
$Outcomes_number=$mysqli->real_escape_string($_POST['Outcomes_number']);
$Outcomes_status=$mysqli->real_escape_string($_POST['Outcomes_status']);

$ImpactCapacityDevelopment=$mysqli->real_escape_string($_POST['ImpactCapacityDevelopment']);
$ImpactCapacityDevelopment_number=$mysqli->real_escape_string($_POST['ImpactCapacityDevelopment_number']);
$ImpactCapacityDevelopment_status=$mysqli->real_escape_string($_POST['ImpactCapacityDevelopment_status']);

$ImpactPathwayDiagram=$mysqli->real_escape_string($_POST['ImpactPathwayDiagram']);
$ImpactPathwayDiagram_number=$mysqli->real_escape_string($_POST['ImpactPathwayDiagram_number']);
$ImpactPathwayDiagram_status=$mysqli->real_escape_string($_POST['ImpactPathwayDiagram_status']);

$StakeholderEngagement=$mysqli->real_escape_string($_POST['StakeholderEngagement']);
$StakeholderEngagement_number=$mysqli->real_escape_string($_POST['StakeholderEngagement_number']);
$StakeholderEngagement_status=$mysqli->real_escape_string($_POST['StakeholderEngagement_status']);

$CommunicationWithStakeholders=$mysqli->real_escape_string($_POST['CommunicationWithStakeholders']);
$CommunicationWithStakeholders_number=$mysqli->real_escape_string($_POST['CommunicationWithStakeholders_number']);
$CommunicationWithStakeholders_status=$mysqli->real_escape_string($_POST['CommunicationWithStakeholders_status']);


$ScientificOutput=$mysqli->real_escape_string($_POST['ScientificOutput']);
$ScientificOutput_number=$mysqli->real_escape_string($_POST['ScientificOutput_number']);
$ScientificOutput_status=$mysqli->real_escape_string($_POST['ScientificOutput_status']);

$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_j where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='proposal' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_j (`categoryID`,`catadmin_id`,`categorym`,`logicalflow`,`logicalflow_number`,`logicalflow_status`,`ResearchObjective`,`ResearchObjective_number`,`ResearchObjective_status`,`Outputs`,`Outputs_number`,`Outputs_status`,`Outcomes`,`Outcomes_number`,`Outcomes_status`,`ImpactCapacityDevelopment`,`ImpactCapacityDevelopment_number`,`ImpactCapacityDevelopment_status`,`ImpactPathwayDiagram`,`ImpactPathwayDiagram_number`,`ImpactPathwayDiagram_status`,`StakeholderEngagement`,`StakeholderEngagement_number`,`StakeholderEngagement_status`,`CommunicationWithStakeholders`,`CommunicationWithStakeholders_number`,`CommunicationWithStakeholders_status`,`ScientificOutput`,`ScientificOutput_number`,`ScientificOutput_status`,`is_sent`,`Date_added`,`grantID`) 

values('$categoryID','$sessionusrm_id','proposal','$logicalflow','$logicalflow_number','$logicalflow_status','$ResearchObjective','$ResearchObjective_number','$ResearchObjective_status','$Outputs','$Outputs_number','$Outputs_status','$Outcomes','$Outcomes_number','$Outcomes_status','$ImpactCapacityDevelopment','$ImpactCapacityDevelopment_number','$ImpactCapacityDevelopment_status','$ImpactPathwayDiagram','$ImpactPathwayDiagram_number','$ImpactPathwayDiagram_status','$StakeholderEngagement','$StakeholderEngagement_number','$StakeholderEngagement_status','$CommunicationWithStakeholders','$CommunicationWithStakeholders_number','$CommunicationWithStakeholders_status','$ScientificOutput','$ScientificOutput_number','$ScientificOutput_status','0',now(),'$id')";
$mysqli->query($sqlA2);	

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	
logaction("$session_fullname added created Project Citation");

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `results`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);
}
//Totals already submitted


if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_j set `logicalflow`='$logicalflow',`logicalflow_number`='$logicalflow_number',`logicalflow_status`='$logicalflow_status',`ResearchObjective`='$ResearchObjective',`ResearchObjective_number`='$ResearchObjective_number'
,`ResearchObjective_status`='$ResearchObjective_status',`Outputs_number`='$Outputs_number',`Outputs_status`='$Outputs_status',`Outcomes`='$Outcomes',`Outcomes_number`='$Outcomes_number'
,`Outcomes_status`='$Outcomes_status',`ImpactCapacityDevelopment`='$ImpactCapacityDevelopment',`ImpactCapacityDevelopment_number`='$ImpactCapacityDevelopment_number',`ImpactCapacityDevelopment_status`='$ImpactCapacityDevelopment_status',`ImpactPathwayDiagram`='$ImpactPathwayDiagram'
,`ImpactPathwayDiagram_number`='$ImpactPathwayDiagram_number',`ImpactPathwayDiagram_status`='$ImpactPathwayDiagram_status',`StakeholderEngagement`='$StakeholderEngagement',`StakeholderEngagement_number`='$StakeholderEngagement_number',`StakeholderEngagement_status`='$StakeholderEngagement_status'
,`CommunicationWithStakeholders`='$CommunicationWithStakeholders',`CommunicationWithStakeholders_number`='$CommunicationWithStakeholders_number',`CommunicationWithStakeholders_status`='$CommunicationWithStakeholders_status',`ScientificOutput`='$ScientificOutput',`ScientificOutput_number`='$ScientificOutput_number',`ScientificOutput_status`='$ScientificOutput_status'



 where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added updated Project Citation");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `results`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);
}
}
//End Project Results

if($_POST['doSaveDataProjectManagement']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);


$overallCoordination=$mysqli->real_escape_string($_POST['overallCoordination']);
$overallCoordination_number=$mysqli->real_escape_string($_POST['overallCoordination_number']);
$overallCoordination_status=$mysqli->real_escape_string($_POST['overallCoordination_status']);

$GantChart=$mysqli->real_escape_string($_POST['GantChart']);
$GantChart_number=$mysqli->real_escape_string($_POST['GantChart_number']);
$GantChart_status=$mysqli->real_escape_string($_POST['GantChart_status']);

$informationFlow=$mysqli->real_escape_string($_POST['informationFlow']);
$informationFlow_number=$mysqli->real_escape_string($_POST['informationFlow_number']);
$informationFlow_status=$mysqli->real_escape_string($_POST['informationFlow_status']);

$Riskmanagement=$mysqli->real_escape_string($_POST['Riskmanagement']);
$Riskmanagement_status=$mysqli->real_escape_string($_POST['Riskmanagement_status']);
$Riskmanagement_number=$mysqli->real_escape_string($_POST['Riskmanagement_number']);


$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_k where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='proposal' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_k (`categoryID`,`catadmin_id`,`categorym`,`overallCoordination`,`overallCoordination_number`,`overallCoordination_status`,`GantChart`,`GantChart_number`,`GantChart_status`,`informationFlow`,`informationFlow_number`,`informationFlow_status`,`is_sent`,`Date_added`,`grantID`,`Riskmanagement`,`Riskmanagement_status`,`Riskmanagement_number`) 

values('$categoryID','$sessionusrm_id','proposal','$overallCoordination','$overallCoordination_number','$overallCoordination_status','$GantChart','$GantChart_number','$GantChart_status','$informationFlow','$informationFlow_number','$informationFlow_status','0',now(),'$id','$Riskmanagement','$Riskmanagement_status','$Riskmanagement_number')";
$mysqli->query($sqlA2);	

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	
logaction("$session_fullname added created Project Citation");

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `management`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);
}
//Totals already submitted


if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_k set `overallCoordination`='$overallCoordination',`overallCoordination_number`='$overallCoordination_number',`overallCoordination_status`='$overallCoordination_status',`GantChart`='$GantChart',`GantChart_number`='$GantChart_number'
,`GantChart_status`='$GantChart_status',`informationFlow_number`='$informationFlow_number',`informationFlow_status`='$informationFlow_status',`Riskmanagement`='$Riskmanagement',`Riskmanagement_status`='$Riskmanagement_status',`Riskmanagement_number`='$Riskmanagement_number'

 where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added updated Project Citation");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `management`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id' and categorym='proposal'";
$mysqli->query($sqlAStatus);
}
}
//End Project Results

if($_POST['doSaveDataCitations']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$qn_References=$mysqli->real_escape_string($_POST['qn_References']);
$qn_References_number=$mysqli->real_escape_string($_POST['qn_References_number']);
$qn_References_status=$mysqli->real_escape_string($_POST['qn_References_status']);


$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_f where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='proposal' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_f (`categoryID`,`catadmin_id`,`categorym`,`qn_References`,`qn_References_number`,`qn_References_status`,`is_sent`,`Date_added`,`grantID`) 

values('$categoryID','$sessionusrm_id','proposal','$qn_References','$qn_References_number','$qn_References_status','0',now(),'$id')";
$mysqli->query($sqlA2);	

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	
logaction("$session_fullname added created Project Citation");

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `Citations`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);
}
//Totals already submitted
if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_f set `qn_References`='$qn_References',`qn_References_number`='$qn_References_number',`qn_References_status`='$qn_References_status' where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added updated Project Citation");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `Citations`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);
}
}
//End Project Citations

if($_POST['doContinueConcept']=='Save & Proceed to Submit Concept'){
echo '<img src="img/ajax-loader1.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=SubmitCallforConceptNew&id=$id&action=update'>";
}
?>
<script type="text/javascript">
function addRow(tableID) {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var colCount = table.rows[0].cells.length;
            for(var i=0; i<colCount; i++) {
                var newcell = row.insertCell(i);
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
        }
		
				function deleteRow(tableID)
{
            try
                 {
                var table = document.getElementById(tableID);
                var rowCount = table.rows.length;
                    for(var i=0; i<rowCount; i++)
                        {
                        var row = table.rows[i];
                        var chkbox = row.cells[0].childNodes[0];
                        if (null != chkbox && true == chkbox.checked)
                            {
                            if (rowCount <= 1)
                                {
                                alert("Cannot delete all the rows.");
                                break;
                                }
                            table.deleteRow(i);
                            rowCount--;
                            i--;
                            }
                        }
                    } catch(e)
                        {
                        alert(e);
                        }
   getValues();
}
</script>


<div class="tab">

<?php
//check any category
$sqlCatGrantCategoryUp="SELECT * FROM ".$prefix."concept_dynamic_stages where grantcallID='$id' and grantcallID>=1 and categorym='proposal' and catadmin_id='$sessionusrm_id' order by id desc";
$AnyCategorySavedUP = $mysqli->query($sqlCatGrantCategoryUp);
$AnyCategoryRows=$AnyCategorySavedUP->fetch_array();
$AnyCategorySavedG=$AnyCategorySavedUP->num_rows;

//check whether Project infornation is filled
$sqlProjectInfo="SELECT * FROM ".$prefix."concept_dynamic_stages where grantcallID='$id' and grantcallID>=1 and categorym='proposal' and catadmin_id='$sessionusrm_id' order by id desc";
$AnyProjectInfo = $mysqli->query($sqlProjectInfo);
$AnyProjectInfo=$AnyProjectInfo->num_rows;
$AnyCategoryRows['questions_up'];
if($AnyCategorySavedG){?>

    <button <?php if($AnyCategoryRows['categories_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=DynamicCallProposalsUpdate&id=<?php echo $id;?>&action=update'"><?php echo $lang_new_SubmitConceptCategories;?> </button>
    <button <?php if($AnyCategoryRows['catordering_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=DynamicCallProposalsUpdate&id=<?php echo $id;?>&action=update'"><?php echo $lang_new_UpdateOrdering;?> </button>

<button  <?php if($AnyCategoryRows['questions_up']=='1'){?>class="tablinks"<?php }?> class="tablinks"  onclick="openCity(event, 'DynamicCallProposalQns')" id="defaultOpen"><?php echo $lang_new_AddQuestionsCategories;?> </button>

<?php if($AnyProjectInfo and $AnyCategoryRows['questions_up']=='1'){?>
<button <?php if($AnyCategoryRows['call_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitCallforProposalNew&id=<?php echo $id;?>&action=update'"><?php echo $lang_new_FInishSubmitCOncept;?></button><?php }?>
<?php }?>

</div>

<div id="DynamicCallProposalQns" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>

   
  <h3><?php echo $lang_new_ProposalCalls;?></h3>
<?php if($message){?><div style="color:#F00; font-size:18px;"><?php echo $message;?></div><?php }?>
     

  </div>
  
   
  
  <?php
  $count=0;
$sqlProjectID2r="SELECT * FROM ".$prefix."grantcall_categories where catadmin_id='$sessionusrm_id' and grantId='$id' and categorym='proposal' order by category_number asc";//`status`='new' and 
$QueryProjectID2r = $mysqli->query($sqlProjectID2r);
if($QueryProjectID2r->num_rows){?>
  

  
  
  
  <div class="row success">
  <div id="customers2">
  

        
        <?php 
while($rUserProjectID2=$QueryProjectID2r->fetch_array()){
	$count++;
	$categoryIDm=$rUserProjectID2['categoryName'];
	
	$categoryName=$rUserProjectID2['categoryName'];
$sqlProjectID3="SELECT * FROM ".$prefix."dynamic_categories_main where category_id='$categoryName' order by category_id desc";
$QueryProjectID3 = $mysqli->query($sqlProjectID3);
$rUserProjectID3=$QueryProjectID3->fetch_array();

?>
 <button class="accordion"><?php echo $count;?>. <?php if($base_lang=='en'){echo $rUserProjectID3['category_name'];} if($base_lang=='fr'){echo $rUserProjectID3['category_name_fr'];} if($base_lang=='pt'){echo $rUserProjectID3['category_name_pt'];}?><span style="color:#F00;">*</span>
 </button>
  <div class="panel">	
<form action="" method="post" name="regForm" id="regForm" autocomplete="off">

    <?php if($categoryIDm==1){?>
    <?php echo $lang_new_ProjectInformation;?>
    <strong>- <?php if($AnyCategoryRows['ProjectInformation']==1){?><?php echo $lang_new_Uploaded;?> <img src="./img/edit.gif" /><?php }else{?> <?php echo $lang_new_NOTUploaded;?> <img src="./img/redtick.png" /><?php }?><br /></strong>
    <hr />
    <?php  require_once("viewlrcn/add_project_information_data_poposal.php");?>
  <?php 
//End Project Information
	}?>

 </form> 
 
 
 
 <?php if($categoryIDm==6){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_ProjectBackground;?>- <?php if($AnyCategoryRows['ProjectDetails']==1){?><?php echo $lang_new_Uploaded;?> <img src="./img/edit.gif" /><?php }else{?> <?php echo $lang_new_NOTUploaded;?> <img src="./img/redtick.png" /><?php }?><br />
    <hr />
    <?php  require_once("viewlrcn/add_project_details_data_proposal.php");?>
  </form> 
<?php 
//End Project Introduction
	}?>
 
 
 
   <?php if($categoryIDm==8){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_ProjectBudget;?> - <?php if($AnyCategoryRows['Budget']==1){?><?php echo $lang_new_Uploaded;?> <img src="./img/edit.gif" /><?php }else{?> <?php echo $lang_new_NOTUploaded;?> <img src="./img/redtick.png" /><?php }?><br />
    <hr />
    <?php  require_once("viewlrcn/add_project_budget_data_proposal.php");?>
  </form> 
<?php 
//End Project Introduction
	}?>
 <?php if($categoryIDm==10){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_Citations;?>- <?php if($AnyCategoryRows['Citations']==1){?><?php echo $lang_new_Uploaded;?> <img src="./img/edit.gif" /><?php }else{?> <?php echo $lang_new_NOTUploaded;?> <img src="./img/redtick.png" /><?php }?><br />
    <hr />
    <?php  require_once("viewlrcn/add_project_citations_data.php");?>
  </form> 
<?php 
//End Project Introduction
	}?>
 
 <?php if($categoryIDm==19){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_ApproachMethodology;?>- <?php if($AnyCategoryRows['Methodology']==1){?><?php echo $lang_new_Uploaded;?> <img src="./img/edit.gif" /><?php }else{?> <?php echo $lang_new_NOTUploaded;?> <img src="./img/redtick.png" /><?php }?><br />
    <hr />
    <?php  require_once("viewlrcn/add_project_details_data_methodology.php");?>
  </form> 
<?php 
//End Project Introduction
}?>
 
<?php 
//begin Project Team
if($categoryIDm==7){
  
  ?>
   <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
   <?php echo $lang_new_ProjectTeam;?>- <?php if($AnyCategoryRows['ProjectTeam']==1){?><?php echo $lang_new_Uploaded;?> <img src="./img/edit.gif" /><?php }else{?> <?php echo $lang_new_NOTUploaded;?> <img src="./img/redtick.png" /><?php }?><br />
   <hr />
   <?php  require_once("viewlrcn/add_project_team_data.php");?>
 </form> 
<?php 
//End Project Team 
}

?>
    
    <?php if($categoryIDm==20){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_ProjectFollowup;?>- <?php if($AnyCategoryRows['followup']==1){?><?php echo $lang_new_Uploaded;?> <img src="./img/edit.gif" /><?php }else{?>  <?php echo $lang_new_NOTUploaded;?> <img src="./img/redtick.png" /><?php }?><br />
    <hr />
    <?php  require_once("viewlrcn/add_project_details_data_followup.php");?>
  </form> 
<?php 
//End Project Attachments
}?>
  
<?php if($categoryIDm==9){?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <?php echo $lang_new_Attachments;?>- <?php if($AnyCategoryRows['Attachments']==1){?><?php echo $lang_new_Uploaded;?> <img src="./img/edit.gif" /><?php }else{?> <?php echo $lang_new_NOTUploaded;?> <img src="./img/redtick.png" /><?php }?><br />
 <hr />
 <?php  require_once("viewlrcn/question_attachments.php");?>
</form> 
<?php 
//End Project Attachments
	}?>
  
    
  
   <?php if($categoryIDm==21){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_ProjectResults;?>- <?php if($AnyCategoryRows['results']==1){?><?php echo $lang_new_Uploaded;?> <img src="./img/edit.gif" /><?php }else{?> <?php echo $lang_new_NOTUploaded;?> <img src="./img/redtick.png" /><?php }?><br />
    <hr />
    <?php  require_once("viewlrcn/add_project_details_data_results.php");?>
  </form> 
<?php 
//End Project Attachments
	}?>
    
    
   <?php if($categoryIDm==23){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_ProjectManagement;?>- <?php if($AnyCategoryRows['management']==1){?><?php echo $lang_new_Uploaded;?> <img src="./img/edit.gif" /><?php }else{?> <?php echo $lang_new_NOTUploaded;?> <img src="./img/redtick.png" /><?php }?><br />
    <hr />
    <?php  require_once("viewlrcn/add_project_details_data_management.php");?>
  </form> 
<?php 
//End Project Attachments
	}?> 
   </div><!--End Pane-->
  
	<?php  }    //end Totals Budget
	   ?>
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
  
 </div>
 </div>


<?php } // End while loop for Categories
?>

   

  <script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("activem");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}
</script> 

                        
<script type="text/javascript">

var countries=new ddajaxtabs("countrytabs", "countrydivcontainer")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

</script>



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
</script>