<?php $wmConfirm="select * from ".$prefix."review_concents where  reviewer_id='$usrm_id' and conceptID='$conceptID'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();//submissions_concepts
//check if this submission was not worked on in 
$wmConfirm2="select * from ".$prefix."submissions_concepts where  (projectStatus='Pending Review') and conceptID='$conceptID'";
$cmdwbConfirm2 = $mysqli->query($wmConfirm2);
$totalStagesConfirm2 = $cmdwbConfirm2->num_rows;
$rConfirmDetailsDynamic2= $cmdwbConfirm2->fetch_array();

if($rConfirmDetailsDynamic2['dynamic']=='No'){
	$revactionButtoon="./main.php?option=ReviewconceptAction&conceptID=$conceptID&id=$id";
}
if($rConfirmDetailsDynamic2['dynamic']=='Yes'){
	$revactionButtoon="./main.php?option=newReviewconceptAction&conceptID=$conceptID&id=$id";
}

if($totalStagesConfirm and $rConfirm['ProjectInformation']>=1 and $rConfirm['PrincipalInvestigator']>=1 and $rConfirm['Budget']>=1 and $rConfirm['Attachments']>=1 and $totalStagesConfirm2>=1){?><div class="btnm"><a href="<?php echo $revactionButtoon;?>"><?php echo $lang_AcceptRejectConcept;?> </a></div><?php }?>