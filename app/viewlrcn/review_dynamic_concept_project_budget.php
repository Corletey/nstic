<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$_GET['categoryID'];
$sqltotalAmount3="SELECT * FROM ".$prefix."dynamic_budget_ceilings where categoryID='$maincategoryID' and grantID='$id' and categorym='concept' order by id asc limit 0,1";
$QueryAmount3 = $mysqli->query($sqltotalAmount3);
$rUserInv3=$QueryAmount3->fetch_array();
$TotalBudget=$rUserInv3['maximum_budget'];
?>
<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
   <tr>
    <td width="39" valign="top"><p align="center"><strong>&nbsp;</strong></td>
    <td width="622" valign="top"><p align="center"><strong><?php echo $lang_new_Item;?></strong></td>
    <td width="247" valign="top"><p align="center"><strong><?php echo $lang_new_Amount;?> (<?php echo $TotalBudget;?>)</strong></td>
    <td valign="top"><p align="center"><strong><?php echo $lang_new_PercentageCeiling;?></strong></td>
    <td valign="top"><p align="center"><strong><?php echo $lang_new_MaAllowableAmount;?></strong></td>
    </tr>
    
   <?php
   $count=0;
   $sqltotalAmount2="SELECT * FROM ".$prefix."dynamic_budget_ceilings where categoryID='$maincategoryID' and grantID='$id' and categorym='concept' order by id asc limit 0,20";
$QueryAmount2 = $mysqli->query($sqltotalAmount2);
while($rUserInv2=$QueryAmount2->fetch_array()){
	$count++;
	$questionID=$rUserInv2['questionID'];
	$ceiling_id=$rUserInv2['id'];
	
$sqltotalAmount3="SELECT * FROM ".$prefix."dynamic_budget_ceilings_answers where categoryID='$maincategoryID' and grantID='$id' and questionID='$questionID' and  	categorym='concept' and ceiling_id='$ceiling_id'";
$QueryAmount3 = $mysqli->query($sqltotalAmount3);
$rUserInv3=$QueryAmount3->fetch_array();
	
	
	
	$TotalBudget2=$rUserInv2['maximum_budget'];
	
	$percentate=($rUserInv2['percentage']/100);
	 
	 
$mmPersonnelTotal=($TotalBudget2*$percentate);
/*$mmResearchCosts=($TotalBudget*0.6);
$mmEquipmentTotal=($TotalBudget*0.15);
$mmTravel=($TotalBudget*0.02);
$mmkickoff=($TotalBudget*0.02);
$mmKnowledgeSharing=($TotalBudget*0.05);
$mmOverheadCostsTotal=($TotalBudget*0.05);
$mmOtherGoods=($TotalBudget*0.02);
$mmMatchingSupport=($TotalBudget*0.01);*/
$ItemCount=$rUserInv2['item'];
$normalpercentage=$rUserInv2['percentage'];
$wordamount=numberformat($mmPersonnelTotal);
$wordings="$ItemCount costs should not exceed $normalpercentage % of the total budget which is $wordamount"
?> 
  <tr>
    <td width="39" valign="top"><?php echo $count;?>. &nbsp;</td>
    <td width="622" valign="top"><?php echo $rUserInv2['item'];?>
    </td>
    <td width="247" align="center" valign="top"><?php echo $rUserInv3['amount'];?>  

    
    
    </td>
    
    <td width="189" valign="top" class="txtalign" align="center"><?php echo $rUserInv2['percentage'];?></td>
    <td width="240" align="right" valign="top"> <?php echo ($mmPersonnelTotal);?></td>
  </tr>
  <?php $taotal=($rUserInv3['amount']+$taotal);
  $SumTotal=($mmPersonnelTotal+$SumTotal);
  $ceilingTotal=($rUserInv2['percentage']+$ceilingTotal);
  }?>

  <tr>
    <td width="39" valign="top">&nbsp;</td>
    <td width="622" valign="top"><p align="center"><strong>TOTAL</strong></td>
    <td width="247" align="center" valign="top"><strong><?php  echo $taotal;?></strong></td>
    <td width="189" align="center" valign="top"><strong><?php echo $ceilingTotal;?></strong></td>
    <td width="240" align="right" valign="top"><?php echo $SumTotal;?></td>
  </tr>
</table>