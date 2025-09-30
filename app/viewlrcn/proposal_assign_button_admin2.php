<?php 
$usrm_idsession=$_SESSION['usrm_id'];
$grantID=$_GET['grantID'];
$wmConfirm1="select * from ".$prefix."review_proposals where  reviewer_id='$usrm_idsession' and projectID='$id'  and grantID='$grantID' order by id desc";
$cmdwbConfirm1 = $mysqli->query($wmConfirm1);
$totalStagesConfirm1 = $cmdwbConfirm1->num_rows;
$rConfirm1= $cmdwbConfirm1->fetch_array();

//check if this submission was not worked on in 
$wmConfirm3="select * from ".$prefix."submissions_proposals where  (projectStatus='Completeness Check-Approved'  || projectStatus='Scheduled for Review' OR projectStatus='Reviewed') and projectID='$id' and grantcallID='$grantID'";
$cmdwbConfirm3 = $mysqli->query($wmConfirm3);
$totalStagesConfirm3 = $cmdwbConfirm3->num_rows;

if($totalStagesConfirm1 and $rConfirm1['ProjectInformation']>=1 and $rConfirm1['PrincipalInvestigator']>=1 and $rConfirm1['Background']>=1 and $rConfirm1['Methodology']>=1 and $rConfirm1['ProjectResults']>=1 and $rConfirm1['ProjectManagement']>=1 and $rConfirm1['Followup']>=1 and $rConfirm1['Budget']>=1 and $totalStagesConfirm3>=1 and $session_usertype!='user'){
?><div class="btnm"><a href="./main.php?option=ReviewproposalAssign&id=<?php echo $rConfirm1['projectID'];?>&grantID=<?php echo $grantID;?>"><?php echo $lang_fowardProposal;?></a></div><?php }?>