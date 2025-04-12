<?php 
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$_GET['categoryID'];
$ownerm_id=$_GET['ownerm_id'];
$dconceptID=$_GET['dconceptID'];

$wmConfirm1="select * from ".$prefix."review_dynamic_concepts where  grantID='$id' and reviewer_id='$sessionusrm_id'";
$cmdwbConfirm1 = $mysqli->query($wmConfirm1);
$totalStagesConfirm1 = $cmdwbConfirm1->num_rows;
$rConfirm1= $cmdwbConfirm1->fetch_array();

$wmConfirm2="select * from ".$prefix."grantcall_categories where  grantID='$id'";
$cmdwbConfirm2 = $mysqli->query($wmConfirm2);
$totalStagesConfirm2 = $cmdwbConfirm2->num_rows;

//check if this submission was not worked on in 
$wmConfirm3="select * from ".$prefix."dynamic_concept_titles where  (projectStatus='Approved'  || projectStatus='Scheduled for Review') and grantID='$id' and owner_id='$ownerm_id'";
$cmdwbConfirm3 = $mysqli->query($wmConfirm3);
$totalStagesConfirm3 = $cmdwbConfirm3->num_rows;

if($rConfirm1 and $session_usertype!='user' and $totalStagesConfirm3){?><div class="btnm"><a href="./main.php?option=ReviewDynamicconceptAssign&id=<?php echo $id;?>&categoryID=<?php echo $categoryID;?>&ownerm_id=<?php echo $ownerm_id;?>&dconceptID=<?php echo $dconceptID;?>"><?php echo $lang_fowardConcept;?></a></div>
<div style="clear:both;"></div>
<?php }?>

