<?php
$asrmApplctID2=$usrm_id;

$wm="update ".$prefix."concept_stages set status='new' where  owner_id='$asrmApplctID2' and conceptID='$id'";
$mysqli->query($wm);


$sqlUsers2="update ".$prefix."submissions_concepts set `is_sent`='0',`updated`='Yes' where `owner_id`='$asrmApplctID2' and conceptID='$id'";
$mysqli->query($sqlUsers2);

$sqlUsers3="update ".$prefix."introduction_concept set `is_sent`='0' where `owner_id`='$asrmApplctID2' and conceptID='$id'";
$mysqli->query($sqlUsers3);

$sqlUsers4="update ".$prefix."project_details_concept set `is_sent`='0' where `owner_id`='$asrmApplctID2' and conceptID='$id'";
$mysqli->query($sqlUsers4);

$sqlUsers5="update ".$prefix."project_primary_beneficiaries set `is_sent`='0' where `owner_id`='$asrmApplctID2' and conceptID='$id'";
$mysqli->query($sqlUsers5);


$sqlUsers6="update ".$prefix."principal_investigators set `is_sent`='0' where `owner_id`='$asrmApplctID2' and conceptm_id='$id'";
$mysqli->query($sqlUsers6);

$sqlUsers7="update ".$prefix."concept_budget set `is_sent`='0' where `owner_id`='$asrmApplctID2' and conceptID='$id'";
$mysqli->query($sqlUsers7);

$sqlUsers8="update ".$prefix."education_history set `is_sent`='0' where `owner_id`='$asrmApplctID2' and conceptID='$id'";
$mysqli->query($sqlUsers8);

$sqlUsers9="update ".$prefix."work_experience set `is_sent`='0' where `owner_id`='$asrmApplctID2' and conceptID='$id'";
$mysqli->query($sqlUsers9);

$sqlUsers10="update ".$prefix."concept_attachments set `is_sent`='0' where `owner_id`='$asrmApplctID2' and conceptID='$id'";
$mysqli->query($sqlUsers10);

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=SubmitConcept&id=$id'>";	

?>