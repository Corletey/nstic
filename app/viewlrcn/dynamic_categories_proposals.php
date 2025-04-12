<?php
//grantcall_categories

$wGrantCategories="select * from ".$prefix."grantcall_categories where  grantID='$id' and categorym='proposal' order by categoryID asc";
$cmGrantCategories = $mysqli->query($wGrantCategories);
while($rUGrantCategories=$cmGrantCategories->fetch_array()){
$selectedcategoryID=$rUGrantCategories['categoryID'];	

$wConceptStages="select * from ".$prefix."dynamic_proposal_stages where  owner_id='$sessionusrm_id' and status='new' and categoryID='$selectedcategoryID' order by id desc";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
$totalCompleted=$cmConceptStages->num_rows;	
	
	
	?>

  <button <?php if($totalCompleted){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitProposalDynamic&id=<?php echo $rUGrantCategories['grantID'];?>&categoryID=<?php echo $rUGrantCategories['categoryID'];?>'"><?php echo $rUGrantCategories['categoryName'];?></button>
  
<?php /*?>  <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptPrincipalInvestigator/<?php echo $id;?>/'"><?php echo $lang_new_ProjectTeam;?></button><?php */?>
 <?php }?>