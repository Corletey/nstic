<?php $wmConfirm1="select * from ".$prefix."review_concents where  reviewer_id='$usrm_id' and conceptID='$conceptID'";
$cmdwbConfirm1 = $mysqli->query($wmConfirm1);
$totalStagesConfirm1 = $cmdwbConfirm1->num_rows;
$rConfirm1= $cmdwbConfirm1->fetch_array();

//check if this submission was not worked on in 
$wmConfirm3="select * from ".$prefix."submissions_concepts where  (projectStatus='Completeness Check-Approved' || projectStatus='Scheduled for Review') and conceptID='$conceptID'";
$cmdwbConfirm3 = $mysqli->query($wmConfirm3);
$totalStagesConfirm3 = $cmdwbConfirm3->num_rows;
$rConfirmDetailsDynamic= $cmdwbConfirm3->fetch_array();

if($rConfirmDetailsDynamic['dynamic']=='No'){
	$revactionButtoon="./main.php?option=ReviewconceptAssign&conceptID=$conceptID&id=$id";
}
if($rConfirmDetailsDynamic['dynamic']=='Yes'){
	$revactionButtoon="./main.php?option=newReviewconceptAssign&conceptID=$conceptID&id=$id";
}
if($totalStagesConfirm1 and $rConfirm1['ProjectInformation']>=1 and $rConfirm1['PrincipalInvestigator']>=1 and $rConfirm1['Budget']>=1 and $totalStagesConfirm3>=1 and $session_usertype!='user'){?><div class="btnm"><a href="<?php echo $revactionButtoon;?>"><?php echo $lang_fowardConcept;?></a></div><?php }?>