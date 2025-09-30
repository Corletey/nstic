<?php 
$usrm_idsession=$_SESSION['usrm_id'];
$grantID=$_GET['grantID'];
$grantID=$_GET['grantID'];
if(!$_GET['grantID']){
echo '<meta http-equiv="refresh" content="0; url='.$base_url.'main.php?option=AllNewProposals&id='.$grantID.'" />';	
}
$wmConfirm="select * from ".$prefix."review_proposals where  reviewer_id='$usrm_idsession' and projectID='$id' order by id desc limit 0,1";// 
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();//submissions_concepts
//check if this submission was not worked on in 
$wmConfirm2="select * from ".$prefix."submissions_proposals where  (projectStatus='Pending Review' ) and projectID='$id'";
$cmdwbConfirm2 = $mysqli->query($wmConfirm2);// OR projectStatus='Reviewed' OR projectStatus='Scheduled for Review'
$totalStagesConfirm2 = $cmdwbConfirm2->num_rows;
$rrows= $cmdwbConfirm2->fetch_array();

if($rrows['dynamic']=='No'){
	$link="./main.php?option=ReviewDynamicProposalAction&id=$id&grantID=$grantID";
}
if($rrows['dynamic']=='Yes'){
	$link="./main.php?option=ReviewDynamicProposalAction&id=$id&grantID=$grantID";
}
if($totalStagesConfirm and $rConfirm['ProjectInformation']>=1 and $rConfirm['PrincipalInvestigator']>=1 and $rConfirm['Background']>=1 and $rConfirm['Methodology']>=1 and $rConfirm['ProjectResults']>=1 and $rConfirm['ProjectManagement']>=1  and $rConfirm['Followup']>=1 and $rConfirm['Budget']>=1 and $totalStagesConfirm2>=1){?><div class="btnm"><a href="./main.php?option=ReviewDynamicProposalAction&id=<?php echo $rConfirm['projectID'];?>&grantID=<?php echo $grantID;?>"><?php echo $lang_approve_reject;?></a></div><?php }?>