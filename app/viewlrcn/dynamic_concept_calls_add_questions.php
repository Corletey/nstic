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

$qn_OrchidID=$mysqli->real_escape_string($_POST['qn_OrchidID']);
$qn_OrchidID_number=$mysqli->real_escape_string($_POST['qn_OrchidID_number']);
$qn_OrchidID_status=$mysqli->real_escape_string($_POST['qn_OrchidID_status']);




$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_a where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='concept' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_a (`categoryID`,`catadmin_id`,`categorym`,`qn_title`,`qn_title_number`,`qn_title_status`,`qn_acronym`,`qn_acronym_number`,`qn_acronym_status`,`qn_relevantKeywords`,`qn_relevantKeywords_number`,`qn_relevantKeywords_status`,`qn_researchTypeID`,`qn_researchTypeID_number`,`qn_researchTypeID_status`,`qn_HostInstitution`,`qn_HostInstitution_number`,`qn_HostInstitution_status`,`qn_projectDurationID`,`qn_projectDurationID_number`,`qn_projectDurationID_status`,`qn_OrchidID`,`qn_OrchidID_number`,`qn_OrchidID_status`,`is_sent`,`Date_added`,`grantID`) 

values('$categoryID','$sessionusrm_id','concept','$qn_title','$qn_title_number','$qn_title_status','$qn_acronym','$qn_acronym_number','$qn_acronym_status','$qn_relevantKeywords','$qn_relevantKeywords_number','$qn_relevantKeywords_status','$qn_researchTypeID','$qn_researchTypeID_number','$qn_researchTypeID_status','$qn_HostInstitution','$qn_HostInstitution_number','$qn_HostInstitution_status','$qn_projectDurationID','$qn_projectDurationID_number','$qn_projectDurationID_status','$qn_OrchidID','$qn_OrchidID_number','$qn_OrchidID_status','0',now(),'$id')";
$mysqli->query($sqlA2);	
$questionID = $mysqli->insert_id;
logaction("$session_fullname added created Project Information");

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `ProjectInformation`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

}
//Totals already submitted
if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_a set `qn_title`='$qn_title',`qn_title_number`='$qn_title_number',`qn_title_status`='$qn_title_status',`qn_acronym`='$qn_acronym',`qn_acronym_number`='$qn_acronym_number',`qn_acronym_status`='$qn_acronym_status',`qn_relevantKeywords`='$qn_relevantKeywords',`qn_relevantKeywords_number`='$qn_relevantKeywords_number',`qn_relevantKeywords_status`='$qn_relevantKeywords_status',`qn_researchTypeID`='$qn_researchTypeID'
,`qn_researchTypeID_number`='$qn_researchTypeID_number',`qn_researchTypeID_status`='$qn_researchTypeID_status',`qn_HostInstitution`='$qn_HostInstitution',`qn_HostInstitution_number`='$qn_HostInstitution_number',`qn_HostInstitution_status`='$qn_HostInstitution_status',`qn_projectDurationID`='$qn_projectDurationID',`qn_projectDurationID_number`='$qn_projectDurationID_number',`qn_projectDurationID_status`='$qn_projectDurationID_status',`qn_OrchidID`='$qn_OrchidID',`qn_OrchidID_number`='$qn_OrchidID_number',`qn_OrchidID_status`='$qn_OrchidID_status' where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added created Project Information");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	
/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `ProjectInformation`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);
}

}
//End Project Information


if($_POST['doSaveDataProjectDetails']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//


$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$qn_introduction=$mysqli->real_escape_string($_POST['qn_introduction']);
$qn_introduction_number=$mysqli->real_escape_string($_POST['qn_introduction_number']);
$qn_introduction_status=$mysqli->real_escape_string($_POST['qn_introduction_status']);
$qn_objectives=$mysqli->real_escape_string($_POST['qn_objectives']);
$qn_objectives_number=$mysqli->real_escape_string($_POST['qn_objectives_number']);
$qn_acronym_status=$mysqli->real_escape_string($_POST['qn_acronym_status']);
$qn_objectives_status=$mysqli->real_escape_string($_POST['qn_objectives_status']);
$qn_expectedoutput=$mysqli->real_escape_string($_POST['qn_expectedoutput']);
$qn_expectedoutput_number=$mysqli->real_escape_string($_POST['qn_expectedoutput_number']);
$qn_expectedoutput_status=$mysqli->real_escape_string($_POST['qn_expectedoutput_status']);
$qn_expectedoutcome=$mysqli->real_escape_string($_POST['qn_expectedoutcome']);
$qn_expectedoutcome_number=$mysqli->real_escape_string($_POST['qn_expectedoutcome_number']);
$qn_expectedoutcome_status=$mysqli->real_escape_string($_POST['qn_expectedoutcome_status']);
$qn_scientific_impact=$mysqli->real_escape_string($_POST['qn_scientific_impact']);
$qn_scientific_impact_number=$mysqli->real_escape_string($_POST['qn_scientific_impact_number']);
$qn_scientific_impact_status=$mysqli->real_escape_string($_POST['qn_scientific_impact_status']);
$qn_environmental_impact=$mysqli->real_escape_string($_POST['qn_environmental_impact']);
$qn_environmental_impact_number=$mysqli->real_escape_string($_POST['qn_environmental_impact_number']);
$qn_environmental_impact_status=$mysqli->real_escape_string($_POST['qn_environmental_impact_status']);
$qn_societal_impact=$mysqli->real_escape_string($_POST['qn_societal_impact']);
$qn_societal_impact_number=$mysqli->real_escape_string($_POST['qn_societal_impact_number']);
$qn_societal_impact_status=$mysqli->real_escape_string($_POST['qn_societal_impact_status']);
$qn_describe_project_alignment=$mysqli->real_escape_string($_POST['qn_describe_project_alignment']);
$qn_describe_project_alignment_number=$mysqli->real_escape_string($_POST['qn_describe_project_alignment_number']);



$qn_describe_project_alignment_status=$mysqli->real_escape_string($_POST['qn_describe_project_alignment_status']);

$qn_Economicimpact=$mysqli->real_escape_string($_POST['qn_Economicimpact']);
$qn_Economicimpact_number=$mysqli->real_escape_string($_POST['qn_Economicimpact_number']);
$qn_Economicimpact_status=$mysqli->real_escape_string($_POST['qn_Economicimpact_status']);

$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_b where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='concept' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_b (`categoryID`,`catadmin_id`,`categorym`,`qn_introduction`,`qn_introduction_number`,`qn_introduction_status`,`qn_objectives`,`qn_objectives_number`,`qn_objectives_status`,`qn_expectedoutput`,`qn_expectedoutput_number`,`qn_expectedoutput_status`,`qn_expectedoutcome`,`qn_expectedoutcome_number`,`qn_expectedoutcome_status`,`qn_scientific_impact`,`qn_scientific_impact_number`,`qn_scientific_impact_status`,`qn_environmental_impact`,`qn_environmental_impact_number`,`qn_environmental_impact_status`,`qn_societal_impact`,`qn_societal_impact_number`,`qn_societal_impact_status`,`qn_describe_project_alignment`,`qn_describe_project_alignment_number`,`qn_describe_project_alignment_status`,`qn_Economicimpact`,`qn_Economicimpact_number`,`qn_Economicimpact_status`,`is_sent`,`Date_added`,`grantID`) 

values('$categoryID','$sessionusrm_id','concept','$qn_introduction','$qn_introduction_number','$qn_introduction_status','$qn_objectives','$qn_objectives_number','$qn_objectives_status','$qn_expectedoutput','$qn_expectedoutput_number','$qn_expectedoutput_status','$qn_expectedoutcome','$qn_expectedoutcome_number','$qn_expectedoutcome_status','$qn_scientific_impact','$qn_scientific_impact_number','$qn_scientific_impact_status','$qn_environmental_impact','$qn_environmental_impact_number','$qn_environmental_impact_status','$qn_societal_impact','$qn_societal_impact_number','$qn_societal_impact_status','$qn_describe_project_alignment','$qn_describe_project_alignment_number','$qn_describe_project_alignment_status','$qn_Economicimpact','$qn_Economicimpact_number','$qn_Economicimpact_status','0',now(),'$id')";
$mysqli->query($sqlA2);	
logaction("$session_fullname added created Project Details");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `ProjectDetails`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);
}
//Totals already submitted
if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_b set `qn_introduction`='$qn_introduction',`qn_introduction_number`='$qn_introduction_number',`qn_introduction_status`='$qn_introduction_status',`qn_objectives`='$qn_objectives',`qn_objectives_number`='$qn_objectives_number',`qn_objectives_status`='$qn_objectives_status',`qn_expectedoutput`='$qn_expectedoutput',`qn_expectedoutput_number`='$qn_expectedoutput_number',`qn_expectedoutput_status`='$qn_expectedoutput_status',`qn_expectedoutcome`='$qn_expectedoutcome',`qn_expectedoutcome_number`='$qn_expectedoutcome_number',`qn_expectedoutcome_status`='$qn_expectedoutcome_status',`qn_scientific_impact`='$qn_scientific_impact',`qn_scientific_impact_number`='$qn_scientific_impact_number',`qn_scientific_impact_status`='$qn_scientific_impact_status',`qn_environmental_impact`='$qn_environmental_impact',`qn_environmental_impact_number`='$qn_environmental_impact_number',`qn_environmental_impact_status`='$qn_environmental_impact_status',`qn_societal_impact`='$qn_societal_impact',`qn_societal_impact_status`='$qn_societal_impact_status',`qn_describe_project_alignment`='$qn_describe_project_alignment',`qn_describe_project_alignment_number`='$qn_describe_project_alignment_number',`qn_describe_project_alignment_status`='$qn_describe_project_alignment_status',`qn_Economicimpact`='$qn_Economicimpact',`qn_Economicimpact_number`='$qn_Economicimpact_number',`qn_Economicimpact_status`='$qn_Economicimpact_status'


 where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added created Project Details");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `ProjectDetails`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);
}

}
//End Project Information


if($_POST['doSaveDataProjectIntroduction']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//

if($_POST['qn_ExpectedIntellectualProperty']){
for ($i=0; $i < count($_POST['qn_ExpectedIntellectualProperty']); $i++) {

$qn_ExpectedIntellectualProperty.=$mysqli->real_escape_string($_POST['qn_ExpectedIntellectualProperty'][$i]).',';
}
}

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$qn_category_of_beneficiary=$mysqli->real_escape_string($_POST['qn_category_of_beneficiary']);
$qn_category_of_beneficiary_number=$mysqli->real_escape_string($_POST['qn_category_of_beneficiary_number']);
$qn_category_of_beneficiary_status=$mysqli->real_escape_string($_POST['qn_category_of_beneficiary_status']);
$qn_gender=$mysqli->real_escape_string($_POST['qn_gender']);
$qn_gender_number=$mysqli->real_escape_string($_POST['qn_gender_number']);
$qn_gender_status=$mysqli->real_escape_string($_POST['qn_gender_status']);
$qn_quantities=$mysqli->real_escape_string($_POST['qn_quantities']);
$qn_quantities_number=$mysqli->real_escape_string($_POST['qn_quantities_number']);
$qn_quantities_status=$mysqli->real_escape_string($_POST['qn_quantities_status']);
$qn_locationbeneficiaries=$mysqli->real_escape_string($_POST['qn_locationbeneficiaries']);
$qn_locationbeneficiaries_number=$mysqli->real_escape_string($_POST['qn_locationbeneficiaries_number']);
$qn_locationbeneficiaries_status=$mysqli->real_escape_string($_POST['qn_locationbeneficiaries_status']);
$qn_methodology=$mysqli->real_escape_string($_POST['qn_methodology']);//////////////////////
$qn_methodology_number=$mysqli->real_escape_string($_POST['qn_methodology_number']);
$qn_methodology_status=$mysqli->real_escape_string($_POST['qn_methodology_status']);
$qn_scientificsolution=$mysqli->real_escape_string($_POST['qn_scientificsolution']);
$qn_scientificsolution_number=$mysqli->real_escape_string($_POST['qn_scientificsolution_number']);
$qn_scientificsolution_number_status=$mysqli->real_escape_string($_POST['qn_scientificsolution_number_status']);
$qn_specialinterestgroup=$mysqli->real_escape_string($_POST['qn_specialinterestgroup']);
$qn_specialinterestgroup_number=$mysqli->real_escape_string($_POST['qn_specialinterestgroup_number']);
$qn_specialinterestgroup_status=$mysqli->real_escape_string($_POST['qn_specialinterestgroup_status']);
$qn_PartnershipsCollaborations=$mysqli->real_escape_string($_POST['qn_PartnershipsCollaborations']);
$qn_PartnershipsCollaborations_number=$mysqli->real_escape_string($_POST['qn_PartnershipsCollaborations_number']);
$qn_PartnershipsCollaborations_status=$mysqli->real_escape_string($_POST['qn_PartnershipsCollaborations_status']);




$qn_ExpectedIntellectualProperty_number=$mysqli->real_escape_string($_POST['qn_ExpectedIntellectualProperty_number']);
$qn_ExpectedIntellectualProperty_status=$mysqli->real_escape_string($_POST['qn_ExpectedIntellectualProperty_status']);
$qn_TotalBudget=$mysqli->real_escape_string($_POST['qn_TotalBudget']);
$qn_TotalBudget_number=$mysqli->real_escape_string($_POST['qn_TotalBudget_number']);


$qn_TotalBudget_status=$mysqli->real_escape_string($_POST['qn_TotalBudget_status']);
$qn_currency=$mysqli->real_escape_string($_POST['qn_currency']);
$qn_currency_number=$mysqli->real_escape_string($_POST['qn_currency_number']);
$qn_currency_status=$mysqli->real_escape_string($_POST['qn_currency_status']);


$qn_PrimaryFunderName=$mysqli->real_escape_string($_POST['qn_PrimaryFunderName']);
$qn_PrimaryFunderName_number=$mysqli->real_escape_string($_POST['qn_PrimaryFunderName_number']);
$qn_PrimaryFunderName_status=$mysqli->real_escape_string($_POST['qn_PrimaryFunderName_status']);
$qn_PrimaryFunderDuration=$mysqli->real_escape_string($_POST['qn_PrimaryFunderDuration']);
$qn_PrimaryFunderDuration_number=$mysqli->real_escape_string($_POST['qn_PrimaryFunderDuration_number']);

$qn_PrimaryFunderDuration_status=$mysqli->real_escape_string($_POST['qn_PrimaryFunderDuration_status']);
$qn_PrimaryFunderAmount=$mysqli->real_escape_string($_POST['qn_PrimaryFunderAmount']);
$qn_PrimaryFunderAmount_number=$mysqli->real_escape_string($_POST['qn_PrimaryFunderAmount_number']);
$qn_PrimaryFunderAmount_status=$mysqli->real_escape_string($_POST['qn_PrimaryFunderAmount_status']);
$qn_SecondaryFunderName=$mysqli->real_escape_string($_POST['qn_SecondaryFunderName']);

$qn_SecondaryFunderName_number=$mysqli->real_escape_string($_POST['qn_SecondaryFunderName_number']);
$qn_SecondaryFunderName_status=$mysqli->real_escape_string($_POST['qn_SecondaryFunderName_status']);
$qn_SecondaryFunderDuration=$mysqli->real_escape_string($_POST['qn_SecondaryFunderDuration']);
$qn_SecondaryFunderDuration_number=$mysqli->real_escape_string($_POST['qn_SecondaryFunderDuration_number']);
$qn_SecondaryFunderDuration_status=$mysqli->real_escape_string($_POST['qn_SecondaryFunderDuration_status']);

$qn_SecondaryFunderAmount=$mysqli->real_escape_string($_POST['qn_SecondaryFunderAmount']);
$qn_SecondaryFunderAmount_number=$mysqli->real_escape_string($_POST['qn_SecondaryFunderAmount_number']);
$qn_SecondaryFunderAmount_status=$mysqli->real_escape_string($_POST['qn_SecondaryFunderAmount_status']);
$qn_CounterpartFundingName=$mysqli->real_escape_string($_POST['qn_CounterpartFundingName']);
$qn_CounterpartFundingName_number=$mysqli->real_escape_string($_POST['qn_CounterpartFundingName_number']);

$qn_CounterpartFundingName_status=$mysqli->real_escape_string($_POST['qn_CounterpartFundingName_status']);
$qn_CounterpartFundingDuration=$mysqli->real_escape_string($_POST['qn_CounterpartFundingDuration']);
$qn_CounterpartFundingDuration_number=$mysqli->real_escape_string($_POST['qn_CounterpartFundingDuration_number']);
$qn_CounterpartFundingDuration_status=$mysqli->real_escape_string($_POST['qn_CounterpartFundingDuration_status']);
$qn_CounterpartFundingAmount=$mysqli->real_escape_string($_POST['qn_CounterpartFundingAmount']);
$qn_CounterpartFundingAmount_number=$mysqli->real_escape_string($_POST['qn_CounterpartFundingAmount_number']);
$qn_CounterpartFundingAmount_status=$mysqli->real_escape_string($_POST['qn_CounterpartFundingAmount_status']);


$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_c where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='concept' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_c (`categoryID`,`catadmin_id`,`categorym`,`qn_category_of_beneficiary`,`qn_category_of_beneficiary_number`,`qn_category_of_beneficiary_status`,`qn_gender`,`qn_gender_number`,`qn_gender_status`,`qn_quantities`,`qn_quantities_number`,`qn_quantities_status`,`qn_locationbeneficiaries`,`qn_locationbeneficiaries_number`,`qn_locationbeneficiaries_status`,`qn_methodology`,`qn_methodology_number`,`qn_methodology_status`,`qn_scientificsolution`,`qn_scientificsolution_number`,`qn_scientificsolution_number_status`,`qn_specialinterestgroup`,`qn_specialinterestgroup_number`,`qn_specialinterestgroup_status`,`qn_PartnershipsCollaborations`,`qn_PartnershipsCollaborations_number`,`qn_PartnershipsCollaborations_status`,`qn_ExpectedIntellectualProperty`,`qn_ExpectedIntellectualProperty_number`,`qn_ExpectedIntellectualProperty_status`,`qn_TotalBudget`,`qn_TotalBudget_number`,`qn_TotalBudget_status`,`qn_currency`,`qn_currency_number`,`qn_currency_status`,`qn_PrimaryFunderName`,`qn_PrimaryFunderName_number`,`qn_PrimaryFunderName_status`,`qn_PrimaryFunderDuration`,`qn_PrimaryFunderDuration_number`,`qn_PrimaryFunderDuration_status`,`qn_PrimaryFunderAmount`,`qn_PrimaryFunderAmount_number`,`qn_PrimaryFunderAmount_status`,`qn_SecondaryFunderName`,`qn_SecondaryFunderName_number`,`qn_SecondaryFunderName_status`,`qn_SecondaryFunderDuration`,`qn_SecondaryFunderDuration_number`,`qn_SecondaryFunderDuration_status`,`qn_SecondaryFunderAmount`,`qn_SecondaryFunderAmount_number`,`qn_SecondaryFunderAmount_status`,`qn_CounterpartFundingName`,`qn_CounterpartFundingName_number`,`qn_CounterpartFundingName_status`,`qn_CounterpartFundingDuration`,`qn_CounterpartFundingDuration_number`,`qn_CounterpartFundingDuration_status`,`qn_CounterpartFundingAmount`,`qn_CounterpartFundingAmount_number`,`qn_CounterpartFundingAmount_status`,`is_sent`,`Date_added`,`grantID`) 

values('$categoryID','$sessionusrm_id','concept','$qn_category_of_beneficiary','$qn_category_of_beneficiary_number','$qn_category_of_beneficiary_status','$qn_gender','$qn_gender_number','$qn_gender_status','$qn_quantities','$qn_quantities_number','$qn_quantities_status','$qn_locationbeneficiaries','$qn_locationbeneficiaries_number','$qn_locationbeneficiaries_status','$qn_methodology','$qn_methodology_number','$qn_methodology_status','$qn_scientificsolution','$qn_scientificsolution_number','$qn_scientificsolution_number_status','$qn_specialinterestgroup','$qn_specialinterestgroup_number','$qn_specialinterestgroup_status','$qn_PartnershipsCollaborations','$qn_PartnershipsCollaborations_number','$qn_PartnershipsCollaborations_status','$qn_ExpectedIntellectualProperty','$qn_ExpectedIntellectualProperty_number','$qn_ExpectedIntellectualProperty_status','$qn_TotalBudget','$qn_TotalBudget_number','$qn_TotalBudget_status','$qn_currency','$qn_currency_number','$qn_currency_status','$qn_PrimaryFunderName','$qn_PrimaryFunderName_number','$qn_PrimaryFunderName_status','$qn_PrimaryFunderDuration','$qn_PrimaryFunderDuration_number','$qn_PrimaryFunderDuration_status','$qn_PrimaryFunderAmount','$qn_PrimaryFunderAmount_number','$qn_PrimaryFunderAmount_status','$qn_SecondaryFunderName','$qn_SecondaryFunderName_number','$qn_SecondaryFunderName_status','$qn_SecondaryFunderDuration','$qn_SecondaryFunderDuration_number','$qn_SecondaryFunderDuration_status','$qn_SecondaryFunderAmount','$qn_SecondaryFunderAmount_number','$qn_SecondaryFunderAmount_status','$qn_CounterpartFundingName','$qn_CounterpartFundingName_number','$qn_CounterpartFundingName_status','$qn_CounterpartFundingDuration','$qn_CounterpartFundingDuration_number','$qn_CounterpartFundingDuration_status','$qn_CounterpartFundingAmount','$qn_CounterpartFundingAmount_number','$qn_CounterpartFundingAmount_status','0',now(),'$id')";
$mysqli->query($sqlA2);	
logaction("$session_fullname added created Project Introduction");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `Introduction`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);

}
//Totals already submitted
if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_c set `qn_category_of_beneficiary`='$qn_category_of_beneficiary',`qn_category_of_beneficiary_number`='$qn_category_of_beneficiary_number',`qn_category_of_beneficiary_status`='$qn_category_of_beneficiary_status',`qn_gender`='$qn_gender',`qn_gender_number`='$qn_gender_number',`qn_gender_status`='$qn_gender_status',`qn_quantities`='$qn_quantities',`qn_quantities_number`='$qn_quantities_number',`qn_quantities_status`='$qn_quantities_status',`qn_locationbeneficiaries`='$qn_locationbeneficiaries',
`qn_locationbeneficiaries_number`='$qn_locationbeneficiaries_number',`qn_locationbeneficiaries_status`='$qn_locationbeneficiaries_status',`qn_methodology`='$qn_methodology',`qn_methodology_number`='$qn_methodology_number',`qn_methodology_status`='$qn_methodology_status',
`qn_scientificsolution`='$qn_scientificsolution',`qn_scientificsolution_number`='$qn_scientificsolution_number',`qn_scientificsolution_number_status`='$qn_scientificsolution_number_status',`qn_specialinterestgroup`='$qn_specialinterestgroup',`qn_specialinterestgroup_number`='$qn_specialinterestgroup_number',`qn_specialinterestgroup_status`='$qn_specialinterestgroup_status',`qn_PartnershipsCollaborations`='$qn_PartnershipsCollaborations',`qn_PartnershipsCollaborations_number`='$qn_PartnershipsCollaborations_number',`qn_PartnershipsCollaborations_status`='$qn_PartnershipsCollaborations_status',`qn_ExpectedIntellectualProperty`='$qn_ExpectedIntellectualProperty',`qn_ExpectedIntellectualProperty_number`='$qn_ExpectedIntellectualProperty_number',`qn_ExpectedIntellectualProperty_status`='$qn_ExpectedIntellectualProperty_status',`qn_TotalBudget`='$qn_TotalBudget',`qn_TotalBudget_number`='$qn_TotalBudget_number',`qn_TotalBudget_status`='$qn_TotalBudget_status',
`qn_currency`='$qn_currency',`qn_currency_number`='$qn_currency_number',`qn_currency_status`='$qn_currency_status',`qn_PrimaryFunderName`='$qn_PrimaryFunderName',`qn_PrimaryFunderName_number`='$qn_PrimaryFunderName_number'
,`qn_PrimaryFunderName_status`='$qn_PrimaryFunderName_status',`qn_PrimaryFunderDuration`='$qn_PrimaryFunderDuration',`qn_PrimaryFunderDuration_number`='$qn_PrimaryFunderDuration_number',`qn_PrimaryFunderDuration_status`='$qn_PrimaryFunderDuration_status',`qn_PrimaryFunderAmount`='$qn_PrimaryFunderAmount',`qn_PrimaryFunderAmount_number`='$qn_PrimaryFunderAmount_number',`qn_PrimaryFunderAmount_status`='$qn_PrimaryFunderAmount_status',`qn_SecondaryFunderName`='$qn_SecondaryFunderName'

,`qn_SecondaryFunderName_number`='$qn_SecondaryFunderName_number',`qn_SecondaryFunderName_status`='$qn_SecondaryFunderName_status',`qn_SecondaryFunderDuration`='$qn_SecondaryFunderDuration',`qn_SecondaryFunderDuration_number`='$qn_SecondaryFunderDuration_number',`qn_SecondaryFunderDuration_status`='$qn_SecondaryFunderDuration_status'

,`qn_SecondaryFunderAmount`='$qn_SecondaryFunderAmount',`qn_SecondaryFunderAmount_number`='$qn_SecondaryFunderAmount_number',`qn_SecondaryFunderAmount_status`='$qn_SecondaryFunderAmount_status',`qn_CounterpartFundingName`='$qn_CounterpartFundingName',`qn_CounterpartFundingName_number`='$qn_CounterpartFundingName_number',`qn_CounterpartFundingName_status`='$qn_CounterpartFundingName_status'

,`qn_CounterpartFundingDuration`='$qn_CounterpartFundingDuration',`qn_CounterpartFundingDuration_number`='$qn_CounterpartFundingDuration_number',`qn_CounterpartFundingDuration_status`='$qn_CounterpartFundingDuration_status',`qn_CounterpartFundingAmount`='$qn_CounterpartFundingAmount',`qn_CounterpartFundingAmount_number`='$qn_CounterpartFundingAmount_number',`qn_CounterpartFundingAmount_status`='$qn_CounterpartFundingAmount_status'


 where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added created Project Introduction");

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `Introduction`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
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

values('$categoryID','$sessionusrm_id','concept','$qn_principle_investigator','$qn_principle_investigator_number','$qn_principle_investigator_status','0',now(),'$id')";
$mysqli->query($sqlA2);	
logaction("$session_fullname added created Project Team");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	


}
//Totals already submitted
if($QueryUsers->num_rows){
$sqlA2update="update ".$prefix."concept_dynamic_questions_all_d set `qn_principle_investigator`='$qn_principle_investigator',`qn_principle_investigator_number`='$qn_principle_investigator_number',`qn_principle_investigator_status`='$qn_principle_investigator_status' where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added created Project Team");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

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


$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_e where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='concept' and catadmin_id='$sessionusrm_id'  and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_e (`categoryID`,`catadmin_id`,`categorym`,`qn_Personnel`,`qn_PersonnelPercentage_Ceiling`,`qn_Personnel_status`,`qn_ResearchCosts`,`qn_ResearchCosts_Ceiling`,`qn_ResearchCosts_status`,`qn_Equipment`,`qn_Equipment_Ceiling`,`qn_Equipment_Ceiling_status`,`qn_Travel`,`qn_Travel_Ceiling`,`qn_Travel_status`,`qn_kickoff`,`qn_kickoff_Ceiling`,`qn_kickoff_status`,`qn_KnowledgeSharing`,`qn_KnowledgeSharing_Ceiling`,`qn_KnowledgeSharing_status`,`qn_OverheadCosts`,`qn_OverheadCosts_Ceiling`,`qn_OverheadCosts_status`,`qn_OtherGoods`,`qn_OtherGoods_Ceiling`,`qn_OtherGoods_status`,`qn_MatchingSupport`,`qn_MatchingSupport_Ceiling`,`qn_MatchingSupport_status`,`is_sent`,`Date_added`,`grantID`,`TotalCeiling`) 

values('$categoryID','$sessionusrm_id','concept','$qn_Personnel','$qn_PersonnelPercentage_Ceiling','$qn_Personnel_status','$qn_ResearchCosts','$qn_ResearchCosts_Ceiling','$qn_ResearchCosts_status','$qn_Equipment','$qn_Equipment_Ceiling','$qn_Equipment_Ceiling_status','$qn_Travel','$qn_Travel_Ceiling','$qn_Travel_status','$qn_kickoff','$qn_kickoff_Ceiling','$qn_kickoff_status','$qn_KnowledgeSharing','$qn_KnowledgeSharing_Ceiling','$qn_KnowledgeSharing_status','$qn_OverheadCosts','$qn_OverheadCosts_Ceiling','$qn_OverheadCosts_status','$qn_OtherGoods','$qn_OtherGoods_Ceiling','$qn_OtherGoods_status','$qn_MatchingSupport','$qn_MatchingSupport_Ceiling','$qn_MatchingSupport_status','0',now(),'$id','$TotalCeiling')";
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
,`qn_OverheadCosts_status`='$qn_OverheadCosts_status',`qn_OtherGoods`='$qn_OtherGoods',`qn_OtherGoods_Ceiling`='$qn_OtherGoods_Ceiling',`qn_OtherGoods_status`='$qn_OtherGoods_status',`qn_MatchingSupport`='$qn_MatchingSupport',`qn_MatchingSupport_Ceiling`='$qn_MatchingSupport_Ceiling',`qn_MatchingSupport_status`='$qn_MatchingSupport_status',`TotalCeiling`='$TotalCeiling' where categoryID='$categoryID' and catadmin_id='$sessionusrm_id' and grantID='$id'";
$mysqli->query($sqlA2update);	
logaction("$session_fullname added updated Project Budget");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `Budget`='1',`questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);

}
}///end TotalCeiling
}
//End Project Budget



if($_POST['doSaveDataCitations']  and $_SESSION['usrm_id'] and $_POST['categoryID'] and $id){//

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$qn_References=$mysqli->real_escape_string($_POST['qn_References']);
$qn_References_number=$mysqli->real_escape_string($_POST['qn_References_number']);
$qn_References_status=$mysqli->real_escape_string($_POST['qn_References_status']);


$sqlUsers="SELECT * FROM ".$prefix."concept_dynamic_questions_all_f where `categoryID`='$categoryID' and `catadmin_id`='$sessionusrm_id' and categorym='concept' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."concept_dynamic_questions_all_f (`categoryID`,`catadmin_id`,`categorym`,`qn_References`,`qn_References_number`,`qn_References_status`,`is_sent`,`Date_added`,`grantID`) 

values('$categoryID','$sessionusrm_id','concept','$qn_References','$qn_References_number','$qn_References_status','0',now(),'$id')";
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



/////////////////Add Dynamic General Questions
if($_POST['doSaveDynamicData'] and $id){//

for ($i=0; $i < count($_POST['Question']); $i++) {
//isit_project_title

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$dynamiCatID=$mysqli->real_escape_string($_POST['categoryID'][$i]);
$Question=$mysqli->real_escape_string($_POST['Question'][$i]);
$qn_number=$mysqli->real_escape_string($_POST['qn_number'][$i]);

$categoryIDmain=$mysqli->real_escape_string($_POST['categoryID']);

$sqlUsers="SELECT * FROM ".$prefix."grantcall_questions where `questionName`='$Question' and `grantID`='$id' and categorym='concept' and catadmin_id='$sessionusrm_id' order by questionID desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows and $Question){
$sqlA2="insert into ".$prefix."grantcall_questions (`categoryID`,`questionName`,`updatedm`,`status`,`categorym`,`grantID`,`qn_number`,`project_title`,`catadmin_id`,`publish`) 

values('$categoryIDmain','$Question',now(),'new','concept','$id','$qn_number','No','$sessionusrm_id','Yes')";
$mysqli->query($sqlA2);	
$questionID = $mysqli->insert_id;

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);
/////////////////////*********************End********************//////////////////////////////////


$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	






}

}//End Loopppppppppppppppppppppppppppppppppppppppppppppppppppp
}
//Get the last question

//////////////////////////Update Questions
if($_POST['doSaveData']=='Update' and $_POST['categoryID']){//

for ($i=0; $i < count($_POST['Question']); $i++) {
//isit_project_title

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$dynamiCatID=$mysqli->real_escape_string($_POST['questionID'][$i]);
$Question=$mysqli->real_escape_string($_POST['Question'][$i]);
$qn_number=$mysqli->real_escape_string($_POST['qn_number'][$i]);


$sqlUsers="SELECT * FROM ".$prefix."grantcall_questions where questionID='$dynamiCatID' order by questionID desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
	
	/////////////////////////************************update********************/////////////////
$QueryUsers->num_rows;
if($QueryUsers->num_rows and $Question and $dynamiCatID>=1){//
$sqlAupdate="update ".$prefix."grantcall_questions set `questionName`='$Question' where questionID='$dynamiCatID'";
$mysqli->query($sqlAupdate);
$message='<p class="success">Dear '.$session_fullname.' '.$Question.', has been updated.</p>';
}

}
/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `questions_up`='1' where `grantcallID`='$id' and catadmin_id='$sessionusrm_id'";
$mysqli->query($sqlAStatus);
}///ENd

////////////////////////////////End Add Dynamic General Questions

//////////////////////////Delete Questions
if($_POST['doDeleteData']=='Delete' and $_POST['categoryID']){//


for ($i=0; $i < count($_POST['Question']); $i++) {
//isit_project_title

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$dynamiCatID=$mysqli->real_escape_string($_POST['questionID'][$i]);
$Question=$mysqli->real_escape_string($_POST['Question'][$i]);
$qn_number=$mysqli->real_escape_string($_POST['qn_number'][$i]);

$sqlUsers="SELECT * FROM ".$prefix."grantcall_questions where questionID='$dynamiCatID' order by questionID desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
	
	/////////////////////////************************update********************/////////////////
$QueryUsers->num_rows;
if($QueryUsers->num_rows and $Question and $dynamiCatID>=1){//
$sqlAupdate="DELETE FROM ".$prefix."grantcall_questions where questionID='$dynamiCatID'";
$mysqli->query($sqlAupdate);
$message='<p class="error2">Dear '.$session_fullname.' '.$Question.', has been deleted.</p>';
}

}
}///ENd


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

<script language="JavaScript">
function toggle(source) {
    var radio = document.querySelectorAll('input[type="radio"]');
    for (var i = 0; i < radio.length; i++) {
        if (radio[i] != source)
            radio[i].checked = source.checked;
    }
}
</script>
<div class="tab">

<?php
//check any category
$sqlCatGrantCategoryUp="SELECT * FROM ".$prefix."concept_dynamic_stages where `grantcallID`='$id'  and categorym='concept' and catadmin_id='$sessionusrm_id' order by id desc";
$AnyCategorySavedUP = $mysqli->query($sqlCatGrantCategoryUp);
$AnyCategoryRows=$AnyCategorySavedUP->fetch_array();
$AnyCategorySavedG=$AnyCategorySavedUP->num_rows;

//check whether Project infornation is filled
$sqlProjectInfo="SELECT * FROM ".$prefix."concept_dynamic_stages where `grantcallID`='$id'  and categorym='concept' and catadmin_id='$sessionusrm_id' order by id desc limit 0,1";
$AnyProjectInfo = $mysqli->query($sqlProjectInfo);
$AnyProjectInfo=$AnyProjectInfo->num_rows;
$AnyCategoryRows['questions_up'];
if($AnyCategorySavedG){?>

    <button <?php if($AnyCategoryRows['categories_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=DynamicCallConcepts&id=<?php echo $id;?>&action=update'"><?php echo $lang_new_SubmitConceptCategories;?> </button>
    <button <?php if($AnyCategoryRows['catordering_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=DynamicCallConceptsUpdate&id=<?php echo $id;?>&action=update'"><?php echo $lang_new_UpdateOrdering;?> </button>

<button  <?php if($AnyCategoryRows['questions_up']=='1'){?>class="tablinks"<?php }?> class="tablinks"  onclick="openCity(event, 'DynamicCallConceptsQns')" id="defaultOpen"><?php echo $lang_new_AddQuestionsCategories;?> </button>

<?php if($AnyProjectInfo and $AnyCategoryRows['questions_up']=='1'){?>
<button <?php if($AnyCategoryRows['call_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitCallforConceptNew&id=<?php echo $id;?>&action=update'"><?php echo $lang_new_FInishSubmitCOncept;?></button><?php }?>
<?php }?>

</div>

<div id="DynamicCallConceptsQns" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>

   
  <h3>Dynamic Concept Calls</h3>
<?php if($message){?><div style="color:#F00; font-size:18px;"><?php echo $message;?></div><?php }?>
     

  </div>
  
   
  
  <?php
  $count=0;
$sqlProjectID2r="SELECT * FROM ".$prefix."grantcall_categories where `grantID`='$id' and catadmin_id='$sessionusrm_id' and categoryName!='7' and categoryName!='9' and categorym='concept' order by category_number asc";
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
 <button class="accordion"><?php echo $count;?>. <?php if($base_lang=='en'){echo $rUserProjectID3['category_name'];} if($base_lang=='fr'){echo $rUserProjectID3['category_name_fr'];} if($base_lang=='pt'){echo $rUserProjectID3['category_name_pt'];}?> <span style="color:#F00;">*</span></button>
  <div class="panel">	
<form action="" method="post" name="regForm" id="regForm" autocomplete="off">

    <?php if($categoryIDm==1){?>
    <?php echo $lang_new_ProjectInformation;?>
    <hr />
    <?php  require_once("viewlrcn/add_project_information_data.php");?>
  <?php 
//End Project Information
	}?>

 </form> 
 
 
<?php if($categoryIDm==5){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_Introduction;?>
    <hr />
    <?php  require_once("viewlrcn/add_project_introduction_data.php");?>
  </form> 
<?php 
//End Project Introduction
	}?>
 
 <?php if($categoryIDm==6){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_ProjectDetails;?>
    <hr />
    <?php  require_once("viewlrcn/add_project_details_data.php");?>
  </form> 
<?php 
//End Project Introduction
	}?>
 
  <?php if($categoryIDm==7){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_ProjectTeam;?>
    <hr />
    <?php  require_once("viewlrcn/add_project_team_data.php");?>
  </form> 
<?php 
//End Project Introduction
	}?>
 
   <?php if($categoryIDm==8){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_ProjectBudget;?>
    <hr />
    <?php  require_once("viewlrcn/add_project_budget_data.php");?>
  </form> 
<?php 
//End Project Introduction
	}?>
 <?php if($categoryIDm==10){?>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
    <?php echo $lang_new_ProjectCitations;?>
    <hr />
    <?php  require_once("viewlrcn/add_project_citations_data.php");?>
  </form> 
<?php 
//End Project Attachments
	}?>
 
 
  <?php if($categoryIDm!=1 and $categoryIDm!=5 and $categoryIDm!=6 and $categoryIDm!=7 and $categoryIDm!=8 and $categoryIDm!=10){
	  ?>
    
   <?php echo $lang_new_AddQuestionsCategories;?>
    <hr />
   
  <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
  <?php
  ///Begin Questions
$sqlProjectID2="SELECT * FROM ".$prefix."grantcall_questions where  `categoryID`='$categoryIDm' and status='new' and catadmin_id='$sessionusrm_id' and project_title='No' order by qn_number asc";
$QueryProjectID2 = $mysqli->query($sqlProjectID2);
$ProjectTotals=$QueryProjectID2->num_rows;
while($rUserProjectID2r=$QueryProjectID2->fetch_array()){
	$questionIDm=$rUserProjectID2r['questionID'];
	///General Questions
?> 
     <!--Begin General Questions-->
 <div class="form-group form-group-default success">
 <input name="categoryID" type="hidden" value="<?php echo $categoryIDm;?>"/>
  
<?php //echo $rUserProjectID2r['qn_number'];?>
<input name="questionID[]" type="checkbox" value="<?php echo $questionIDm;?>" checked="checked"/>    
                <textarea name="Question[]" cols="" rows="2" id="MyTextBox3" required class="questionbox"><?php echo $rUserProjectID2r['questionName'];?></textarea>
              </div>

<!--End General Questions-->
<?php }
if($ProjectTotals){?>
  <div class="row success">
    <input type="submit" name="doSaveData" value="Update">
  <input type="submit" name="doDeleteData" value="Delete" style="background:#F00;" onclick="return confirm('Are you sure you want to DELETE all Questions? TICK only those ones you want to DELETE. Click OK to confirm or CANCEL.');">
  </div><?php }?>
  
</form>


   <form action="" method="post" name="regForm" id="regForm" autocomplete="off"> 
    <input name="categoryID" type="hidden" value="<?php echo $categoryIDm;?>"/>
    
	
    <table width="38%" align="center" cellpadding="0" cellspacing="0" class="normal-text" border="0">
<tr>
<td  align="center"><input type="button" value="Add New Row" onClick="addRow('dataTableMoze')" >&nbsp;
<input type="button" value="Remove Row" onClick="deleteRow('dataTableMoze')" ></td>
</tr>
</table>

<table width="100%" border="0" id="POITable">
<tr>
  <th width="30" valign="top"></th>
  <th width="1013">Add Questions to the Grant new call</th>
  <th width="169">Question Number</th>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="normal-text" id="dataTableMoze">



<tr>
<td width="20" valign="top"><input type="checkbox" name="chk[]" checked="checked"/></td>

<td align="left" valign="top" >

<div class="form-group form-group-default">
              <input type="hidden" class="form-control" name="Questionmm[]">  
                
                <textarea name="Question[]" cols="" rows="" id="MyTextBox3" required class="questionbox"></textarea>
              </div>
 
</td>


<td align="left" valign="top"><div class="form-group form-group-default">
              
                
                <textarea name="qn_number[]" cols="" rows="" id="MyTextBox3mm" required style="width:150px;"><?php echo ($qn_number);?></textarea>
              </div>
              <input name="requireTitleORCIDID" type="hidden" value="ORCIDID"/>
              
              </td>
              
</tr>







</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<div class="row success">
    <input type="submit" name="doSaveDynamicData" value="<?php echo $lang_new_Save;?>">
  </div>
  
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