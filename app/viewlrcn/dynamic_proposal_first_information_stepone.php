<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];
$usrm_id=$_SESSION['usrm_id'];

$projectID=$_GET['projectID'];

$sqlASubmissionStages="update ".$prefix."project_stages  set `status`='new' where `owner_id`='$sessionusrm_id' and conceptID='$conceptID'";
$mysqli->query($sqlASubmissionStages);


$Insert_QR2m="UPDATE ".$prefix."submissions_proposals SET `is_sent`='0' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m); 

////////////////////////////////////////////////////////
$Insert_QR2m1="UPDATE ".$prefix."project_stages SET `status`='new' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m1);

$Insert_QR2m2="UPDATE ".$prefix."proposal_research_team SET `is_sent`='0' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m2);
$Insert_QR2m2ee="UPDATE ".$prefix."proposal_research_team_ext SET `is_sent`='0' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m2ee);
/////////////////////////////////////////////////////////////////////////////
$Insert_QR2m3="UPDATE ".$prefix."project_background SET `is_sent`='0' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m3);

//////////////////////////////////////////////////////////////////
$Insert_QR2m4="UPDATE ".$prefix."project_budget SET `is_sent`='0' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m4);

$Insert_QR2m5="UPDATE ".$prefix."project_details_concept SET `is_sent`='0' where owner_id='$usrm_id' and conceptID='$projectID'";
//$mysqli->query($Insert_QR2m5);echo "Test2";

$Insert_QR2m6="UPDATE ".$prefix."project_follow_up SET `is_sent`='0' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m6);

$Insert_QR2m7="UPDATE ".$prefix."project_management SET `is_sent`='0' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m7);


$Insert_QR2m8="UPDATE ".$prefix."project_methodology SET `is_sent`='0' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m8);

$Insert_QR2m9="UPDATE ".$prefix."project_primary_beneficiaries SET `is_sent`='0' where owner_id='$usrm_id' and projectID='$projectID'";
//$mysqli->query($Insert_QR2m9);echo "Test1";

$Insert_QR2m10="UPDATE ".$prefix."project_results SET `is_sent`='0' where owner_id='$usrm_id' and projectID='$projectID'";
$mysqli->query($Insert_QR2m10);

$Insert_QR2m11="UPDATE ".$prefix."concept_attachments SET `is_sent`='0' where owner_id='$usrm_id' and  	grantcallID='$id'";
$mysqli->query($Insert_QR2m11);

echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=newSubmitProposal&conceptID=$conceptID&id=$id'>";
?>
