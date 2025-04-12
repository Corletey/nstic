<?php 
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$_GET['categoryID'];
$ownerm_id=$_GET['ownerm_id'];
$dproposalID=$_GET['dproposalID'];

$wmConfirm1="select * from ".$prefix."review_dynamic_proposals where  grantID='$id' and reviewer_id='$usrm_id' and dproposalID='$dproposalID'";
$cmdwbConfirm1 = $mysqli->query($wmConfirm1);
$totalStagesConfirm1 = $cmdwbConfirm1->num_rows;
$rConfirm1= $cmdwbConfirm1->fetch_array();

$wmConfirm2="select * from ".$prefix."grantcall_categories where  grantID='$id'";
$cmdwbConfirm2 = $mysqli->query($wmConfirm2);
$totalStagesConfirm2 = $cmdwbConfirm2->num_rows;

//check if this submission was not worked on in 
$wmConfirm3="select * from ".$prefix."dynamic_proposal_titles where  (projectStatus='Approved'  || projectStatus='Scheduled for Review') and dproposalID='$dproposalID' and grantID='$id'";
$cmdwbConfirm3 = $mysqli->query($wmConfirm3);
$totalStagesConfirm3 = $cmdwbConfirm3->num_rows;

if($rConfirm1>=$totalStagesConfirm3 and $session_usertype!='user'){?><div class="btnm"><a href="./main.php?option=ReviewDynamicproposalAssign&id=<?php echo $id;?>&categoryID=<?php echo $categoryID;?>&ownerm_id=<?php echo $ownerm_id;?>&dproposalID=<?php echo $dproposalID;?>"><?php echo $lang_fowardProposal;?></a></div><?php }?>

