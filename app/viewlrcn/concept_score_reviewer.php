<?php $wmConfirm1="select * from ".$prefix."review_concents where  reviewer_id='$usrm_id' and conceptID='$conceptID'";
$cmdwbConfirm1 = $mysqli->query($wmConfirm1);
$totalStagesConfirm1 = $cmdwbConfirm1->num_rows;
$rConfirm1= $cmdwbConfirm1->fetch_array();

//check if this submission was not worked on in 
$wmConfirm3="select * from ".$prefix."conceptsasslogs_new where  conceptm_id='$conceptID' and conceptm_assignedto='$usrm_id'";//logm_status='new' and 
$cmdwbConfirm3 = $mysqli->query($wmConfirm3);
$totalStagesConfirm3 = $cmdwbConfirm3->num_rows;
$rConfirmDetailsDynamic= $cmdwbConfirm3->fetch_array();
$rConfirmDetailsDynamic['reviewStatus'];


$wmConfirm4="select * from ".$prefix."submissions_concepts where  conceptID='$conceptID'";//logm_status='new' and 
$cmdwbConfirm4 = $mysqli->query($wmConfirm4);
$rConfirmDetailsDynamic4= $cmdwbConfirm4->fetch_array();
$rConfirmDetailsDynamic4['dynamic'];

if($rConfirmDetailsDynamic4['dynamic']=='No'){
	$revactionButtoon="./main.php?option=conceptScoreReviewers&conceptID=$conceptID&id=$id";
}
if($rConfirmDetailsDynamic4['dynamic']=='Yes' || $rConfirmDetailsDynamic4['dynamic']==''){
	$revactionButtoon="./main.php?option=newconceptScoreReviewers&conceptID=$conceptID&id=$id";
}

if($totalStagesConfirm1 and $rConfirm1['ProjectInformation']>=1 and $rConfirm1['PrincipalInvestigator']>=1 and $rConfirm1['Budget']>=1 and $totalStagesConfirm3>=1 and $session_usertype!='user'){
?><div class="btnm"><a href="<?php echo $revactionButtoon;?>"><?php echo $lang_final_score;?></a></div><?php }?>