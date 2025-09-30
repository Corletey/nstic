<?php
	$sqlUsers="SELECT * FROM ".$prefix."grantcalls where `grantID`='$id'";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if($totalUsers){
	
	//////////////Update Now grantID
	
$sqlAUpdate="update ".$prefix."concept_dynamic_stages set `status`='new' where categorym='concept' and `grantcallID`='$id'";
$mysqli->query($sqlAUpdate);

$sqlAupdate_call="update ".$prefix."grantcall_questions set `status`='new' where categorym='concept' and `grantID`='$id'";
$mysqli->query($sqlAupdate_call);

$sqlAUpdate2="update ".$prefix."grantcall_categories set `status`='new' where `grantID`='$id'";
$mysqli->query($sqlAUpdate2);
/////Update sections
$sqlAUpdate22="update ".$prefix."concept_dynamic_questions_all_a set `is_sent`='0' where `grantID`='$id'";
$mysqli->query($sqlAUpdate22);

$sqlAUpdate23="update ".$prefix."concept_dynamic_questions_all_b set `is_sent`='0' where `grantID`='$id'";
$mysqli->query($sqlAUpdate23);

$sqlAUpdate24="update ".$prefix."concept_dynamic_questions_all_c set `is_sent`='0' where `grantID`='$id'";
$mysqli->query($sqlAUpdate24);

$sqlAUpdate25="update ".$prefix."concept_dynamic_questions_all_d set `is_sent`='0' where `grantID`='$id'";
$mysqli->query($sqlAUpdate25);	

$sqlAUpdate26="update ".$prefix."concept_dynamic_questions_all_e set `is_sent`='0' where `grantID`='$id'";
$mysqli->query($sqlAUpdate26);

$sqlAUpdate2y="update ".$prefix."concept_dynamic_questions_all_f set `is_sent`='0' where `grantID`='$id'";
$mysqli->query($sqlAUpdate2y);



echo '<img src="img/ajax-loader1.gif">';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=DynamicCallConcepts&id=$id'>";
}
?>