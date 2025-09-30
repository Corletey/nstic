<?php
//grantcall_categories

$wGrantCategories="select * from ".$prefix."grantcall_categories where  grantID='$id' and categorym='concept' order by category_number asc";
$cmGrantCategories = $mysqli->query($wGrantCategories);
while($rUGrantCategories=$cmGrantCategories->fetch_array()){
$selectedcategoryID=$rUGrantCategories['categoryName'];

$categoryName=$rUGrantCategories['categoryName'];
$sqlProjectID3="SELECT * FROM ".$prefix."dynamic_categories_main where category_id='$categoryName' order by category_id desc";
$QueryProjectID3 = $mysqli->query($sqlProjectID3);
$rUserProjectID3=$QueryProjectID3->fetch_array();	

$wConceptStages="select * from ".$prefix."review_dynamic_concepts where  reviewer_id='$sessionusrm_id' and status='new' and categoryID='$selectedcategoryID' and grantID='$id' and owner_id='$ownerm_id' order by id desc";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
$totalCompleted=$cmConceptStages->num_rows;
	
	
	?>

  <button <?php if($totalCompleted){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewDynamicConceptinformation&id=<?php echo $rUGrantCategories['grantID'];?>&categoryID=<?php echo $rUGrantCategories['categoryName'];?>&ownerm_id=<?php echo $ownerm_id;?>&dconceptID=<?php echo $dconceptID;?>'"><?php echo $rUserProjectID3['category_name'];?></button>
  
<?php /*?>  <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptPrincipalInvestigator/<?php echo $id;?>/'"><?php echo $lang_new_ProjectTeam;?></button><?php */?>
 <?php }?>