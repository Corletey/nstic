<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];

$sqlA2="update ".$prefix."progress_report_signature_page  set `is_sent`='0' where `owner_id`='$sessionusrm_id' and progressID='$id'";
$mysqli->query($sqlA2);


$sqlASubmissionStages="update ".$prefix."progress_report_stages  set `status`='new' where `owner_id`='$sessionusrm_id' and progressID='$id'";
$mysqli->query($sqlASubmissionStages);


$Insert_QR2m="UPDATE ".$prefix."progress_report_signature_page SET `is_sent`='0',`reportStatus`='Pending' where owner_id='$sessionusrm_id' and progressID='$id'";
$mysqli->query($Insert_QR2m);
////////////////////////////////////////////////////////
$Insert_QR2m1="UPDATE ".$prefix."progress_meeting_abstracts SET `is_sent`='0' where owner_id='$sessionusrm_id' and progressID='$id'";
$mysqli->query($Insert_QR2m1);

$Insert_QR2m2="UPDATE ".$prefix."progress_report_keypersonnel_effort SET `is_sent`='0' where owner_id='$sessionusrm_id' and progressID='$id'";
$mysqli->query($Insert_QR2m2);
$Insert_QR2m2ee="UPDATE ".$prefix."progress_report_otherpresentations SET `is_sent`='0' where owner_id='$sessionusrm_id' and progressID='$id'";
$mysqli->query($Insert_QR2m2ee);
/////////////////////////////////////////////////////////////////////////////
$Insert_QR2m3="UPDATE ".$prefix."progress_report_summary_progress SET `is_sent`='0' where owner_id='$sessionusrm_id' and progressID='$id'";
$mysqli->query($Insert_QR2m3);

/*echo("<script>location.href = '".$base_url."'main.php?option=Abstract/';</script>");*/

echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=submitProgressReport&id=$id'>";

?>
