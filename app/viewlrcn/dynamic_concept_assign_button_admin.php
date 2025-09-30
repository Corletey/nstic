<?php 
$dconceptID=$_GET['dconceptID'];
$wmConfirm="select * from ".$prefix."review_dynamic_concepts where  reviewer_id='$sessionusrm_id' and grantID='$id' and dconceptID='$dconceptID' order by id desc";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();//submissions_concepts

$wmConfirm2="select * from ".$prefix."grantcall_categories where  grantID='$id'";
$cmdwbConfirm2 = $mysqli->query($wmConfirm2);
$totalStagesConfirm2 = $cmdwbConfirm2->num_rows;

//check if this submission was not worked on in 
$wmConfirm4="select * from ".$prefix."dynamic_concept_titles where  projectStatus='Pending Review' and grantID='$id'  and owner_id='$ownerm_id' order by dconceptID desc limit 0,1";
$cmdwbConfirm4 = $mysqli->query($wmConfirm4);
$totalStagesConfirm4 = $cmdwbConfirm4->num_rows;
$rConfirmDetails= $cmdwbConfirm4->fetch_array();

if($totalStagesConfirm>=$totalStagesConfirm2 and $totalStagesConfirm4){?>

<div class="btnm"><a href="./main.php?option=ReviewDynamicconceptAction&id=<?php echo $id;?>&categoryID=<?php echo $categoryID;?>&ownerm_id=<?php echo $ownerm_id;?>&dconceptID=<?php echo $dconceptID;?>">Accept/Reject Concept </a></div>


<div style="clear:both;"></div>
<?php }?>