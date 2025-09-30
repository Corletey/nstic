<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$categoryID=$mysqli->real_escape_string($_GET['categoryID']);

	$sqlUsers="SELECT * FROM ".$prefix."grantcalls where `grantID`='$id'";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if($totalUsers){
	
	//////////////Update Now grantID
$sqlAUpdate="update ".$prefix."dynamic_concept_titles set `is_sent`='0' where `owner_id`='$sessionusrm_id' and `grantID`='$id'";
$mysqli->query($sqlAUpdate);

$sqlAUpdate2="update ".$prefix."grantcall_qn_answers_concept set `is_sent`='0' where `usrm_id`='$sessionusrm_id' and `grantID`='$id'";
$mysqli->query($sqlAUpdate2);
/////Update sections
$sqlAUpdate22="update ".$prefix."dynamic_concept_stages set `status`='new',`is_sent`='0' where `owner_id`='$sessionusrm_id' and `grantID`='$id'";
$mysqli->query($sqlAUpdate22);

$sqlAUpdate2y="update ".$prefix."dynamic_budget_ceilings_answers set `is_sent`='0' where `owner_id`='$sessionusrm_id' and `grantID`='$id'";
$mysqli->query($sqlAUpdate2y);

$sqlAUpdate33="update ".$prefix."concept_attachments set `is_sent`='0' where `owner_id`='$sessionusrm_id' and `conceptID`='$id'";
$mysqli->query($sqlAUpdate33);

$sqlAUpdate44="update ".$prefix."principal_investigators set `is_sent`='0' where `owner_id`='$sessionusrm_id' and `conceptm_id`='$id'";
$mysqli->query($sqlAUpdate44);

echo '<img src="img/ajax-loader1.gif">';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=SubmitConceptDynamic&id=$id&categoryID=$categoryID'>";
}
?>