<?php
//grantcall_categories

$wGrantCategories="select * from ".$prefix."grantcall_categories where  grantID='$id' and categorym='proposal' order by categoryID asc";
$cmGrantCategories = $mysqli->query($wGrantCategories);
while($rUGrantCategories=$cmGrantCategories->fetch_array()){
$selectedcategoryID=$rUGrantCategories['categoryID'];	

$wproposalStages="select * from ".$prefix."review_dynamic_proposals where  owner_id='$ownerm_id' and status='new' and categoryID='$selectedcategoryID' order by id desc";
$cmproposalStages = $mysqli->query($wproposalStages);
$rUproposalStages=$cmproposalStages->fetch_array();
$totalCompleted=$cmproposalStages->num_rows;	
	
	
	?>

  <button <?php if($totalCompleted){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewDynamicProposalinformation&id=<?php echo $id;?>&categoryID=<?php echo $rUGrantCategories['categoryID'];?>&ownerm_id=<?php echo $ownerm_id;?>&dproposalID=<?php echo $dproposalID;?>'"><?php echo $rUGrantCategories['categoryName'];?></button>
  
<?php /*?>  <button <?php if($rUproposalStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalPrincipalInvestigator/<?php echo $id;?>/'"><?php echo $lang_new_ProjectTeam;?></button><?php */?>
 <?php }?>