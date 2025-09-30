<?php 
$sessionusrm_id=$_SESSION['usrm_id'];
$conceptID=$_GET['conceptID'];
$Insert_QR2m="UPDATE ".$prefix."submissions_concepts SET `is_sent`='0' where  owner_id='$sessionusrm_id' and conceptID='$conceptID' and grantcallID='$id'";
$mysqli->query($Insert_QR2m);
////////////////////////////////////////////////////////
$Insert_QR2m1="UPDATE ".$prefix."concept_stages SET `status`='new' where owner_id='$sessionusrm_id' and grantcallID='$id' and conceptID='$conceptID'";
$mysqli->query($Insert_QR2m1);
/**/
$Insert_QR2m1mm="UPDATE ".$prefix."introduction_concept SET `is_sent`='0' where owner_id='$sessionusrm_id' and grantcallID='$id' and conceptID='$conceptID'";
$mysqli->query($Insert_QR2m1mm);

$Insert_QR2m1nn="UPDATE ".$prefix."concept_attachments SET `is_sent`='0' where owner_id='$sessionusrm_id' and grantcallID='$id' and conceptID='$conceptID'";
$mysqli->query($Insert_QR2m1nn);

$Insert_QR2m1nnr="UPDATE ".$prefix."principal_investigators SET `is_sent`='0' where owner_id='$sessionusrm_id' and conceptm_id='$conceptID'";
$mysqli->query($Insert_QR2m1nnr);

$Insert_QR2m1nnr2="UPDATE ".$prefix."concept_budget SET `is_sent`='0' where conceptID='$conceptID' and grantcallID='$id'";
$mysqli->query($Insert_QR2m1nnr2);

$Insert_QR2m1nnr3="UPDATE ".$prefix."project_details_concept SET `is_sent`='0' where conceptID='$conceptID' and grantcallID='$id'";
$mysqli->query($Insert_QR2m1nnr3);

echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=newSubmitConcept&id=$id&conceptID=$conceptID'>";



?>
