<?php 
$dproposalID=$_GET['dproposalID'];
$wmConfirm="select * from ".$prefix."review_dynamic_proposals where  reviewer_id='$usrm_id' and grantID='$id' and dproposalID='$dproposalID'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();//submissions_proposals

$wmConfirm2="select * from ".$prefix."grantcall_categories where  grantID='$id'";
$cmdwbConfirm2 = $mysqli->query($wmConfirm2);
$totalStagesConfirm2 = $cmdwbConfirm2->num_rows;

//check if this submission was not worked on in 
$wmConfirm4="select * from ".$prefix."dynamic_proposal_titles where  projectStatus='Pending Review' and dproposalID='$dproposalID'";
$cmdwbConfirm4 = $mysqli->query($wmConfirm4);
$totalStagesConfirm4 = $cmdwbConfirm4->num_rows;
$rConfirmDetails= $cmdwbConfirm4->fetch_array();

if($totalStagesConfirm>=$totalStagesConfirm2 and $rConfirmDetails['projectStatus']=='Pending Review'){?><div class="btnm"><a href="./main.php?option=ReviewDynamicproposalAction&id=<?php echo $id;?>&categoryID=<?php echo $categoryID;?>&ownerm_id=<?php echo $rConfirmDetails['owner_id'];?>&dproposalID=<?php echo $dproposalID;?>">Accept/Reject Proposal </a></div><?php }?>