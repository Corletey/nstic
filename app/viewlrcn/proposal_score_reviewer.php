<?php 
$usrm_idsession=$_SESSION['usrm_id'];
$wmConfirm1="select * from ".$prefix."review_proposals where  reviewer_id='$usrm_idsession' and projectID='$id'";
$cmdwbConfirm1 = $mysqli->query($wmConfirm1);
$totalStagesConfirm1 = $cmdwbConfirm1->num_rows;
$rConfirm1= $cmdwbConfirm1->fetch_array();

//check if this submission was not worked on in 
$wmConfirm3="select * from ".$prefix."conceptsasslogs_new where  logm_status='new' and conceptm_id='$id' and conceptm_assignedto='$usrm_idsession'";
$cmdwbConfirm3 = $mysqli->query($wmConfirm3);
$totalStagesConfirm3 = $cmdwbConfirm3->num_rows;
$rConfirm3= $cmdwbConfirm3->fetch_array();
$rConfirm3['categorym'];

//check if this submission was not worked on in 
$wmConfirm4="select * from ".$prefix."submissions_proposals where  projectID='$id'";//logm_status='new' and 
$cmdwbConfirm4 = $mysqli->query($wmConfirm4);
$rConfirmDetailsDynamic4= $cmdwbConfirm4->fetch_array();
$rConfirmDetailsDynamic4['dynamic'];

if($rConfirmDetailsDynamic4['dynamic']=='No'){
	$revactionButtoon="proposalScoreReviewers";
}
if($rConfirmDetailsDynamic4['dynamic']=='Yes' || $rConfirmDetailsDynamic4['dynamic']==''){
	$revactionButtoon="newproposalScoreReviewers";
}

if($totalStagesConfirm1 and $rConfirm1['ProjectInformation']>=1 and $rConfirm1['PrincipalInvestigator']>=1 and $rConfirm1['Background']>=1 and $rConfirm1['Methodology']>=1 and $rConfirm1['ProjectResults']>=1 and $rConfirm1['ProjectManagement']>=1 and $rConfirm1['Followup']>=1 and $rConfirm1['Budget']>=1 and $totalStagesConfirm3>=1 and $session_usertype!='user'){
?><div class="btnm"><a href="./main.php?option=<?php echo $revactionButtoon;?>&id=<?php echo $rConfirm1['projectID'];?>"><?php echo $lang_final_score;?></a></div><?php }?>