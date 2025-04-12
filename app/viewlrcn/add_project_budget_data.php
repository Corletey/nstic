 <?php
 $sqlQnsubmitted_d="SELECT * FROM ".$prefix."concept_dynamic_questions_all_e where categoryID='$categoryIDm' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc";
$Querysubmitted_d = $mysqli->query($sqlQnsubmitted_d);
$rowsSubmitted_d=$Querysubmitted_d->fetch_array();
$totalStages_d = $Querysubmitted_d->num_rows;
?>

 
<table width="100%" border="0" class="success">
  <tr>
    <th width="72%"><strong><?php echo $lang_new_Item;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_PercentageCeiling;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_Status;?> <input type="checkbox" onclick="toggle(this);" /><?php echo $lang_new_Enable;?></strong></th>
  </tr>
  
  
   <tr>
    <td> 

      <input type="text" id="MyTextBox" name="qn_Personnel" placeholder="" class="required" value="<?php if($rowsSubmitted_d['qn_Personnel']){echo $rowsSubmitted_d['qn_Personnel'];}else{ echo "$lang_new_Personnel";}?>" required>

  </td>
    <td> 

 <input name="categoryID" type="hidden" value="<?php echo $categoryIDm;?>" />
      <input type="text" id="qty" name="qn_PersonnelPercentage_Ceiling" placeholder="8" class="required amount" value="<?php echo $rowsSubmitted_d['qn_PersonnelPercentage_Ceiling'];?>" required onkeyup="findTotal()">

  </td>
    <td> <input name="qn_Personnel_status" type="radio" value="Disable" class="required" id="qn_Personnel_status" <?php if($rowsSubmitted_d['qn_Personnel_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_Personnel_status" type="radio" value="Enable" class="required"  id="qn_Personnel_status" <?php if($rowsSubmitted_d['qn_Personnel_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
   
    </td>
  </tr> 
  
   
   
    <tr>
    <td> 

      <input type="text" id="MyTextBox" name="qn_ResearchCosts" placeholder="" class="required" value="<?php if($rowsSubmitted_d['qn_ResearchCosts']){echo $rowsSubmitted_d['qn_ResearchCosts'];}else{ echo "$lang_new_ResearchCosts";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="qn_ResearchCosts_Ceiling" name="qn_ResearchCosts_Ceiling" class="required amount" placeholder="60" value="<?php echo $rowsSubmitted_d['qn_ResearchCosts_Ceiling'];?>" onkeyup="findTotal()">

  </td>
    <td><input name="qn_ResearchCosts_status" type="radio" value="Disable" class="required" id="qn_ResearchCosts_status" <?php if($rowsSubmitted_d['qn_ResearchCosts_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_ResearchCosts_status" type="radio" value="Enable" class="required"  id="qn_ResearchCosts_status" <?php if($rowsSubmitted_d['qn_ResearchCosts_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr> 
  
   <tr>
    <td> 

      <input type="text" id="MyTextBox" name="qn_Equipment" placeholder="" class="required" value="<?php if($rowsSubmitted_d['qn_Equipment']){echo $rowsSubmitted_d['qn_Equipment'];}else{ echo "$lang_new_Equipment";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_Equipment_Ceiling" class="required amount" placeholder="15" value="<?php echo $rowsSubmitted_d['qn_Equipment_Ceiling'];?>" onkeyup="findTotal()">

  </td>
    <td><input name="qn_Equipment_Ceiling_status" type="radio" value="Disable" class="required" id="qn_Equipment_Ceiling_status" <?php if($rowsSubmitted_d['qn_Equipment_Ceiling_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_Equipment_Ceiling_status" type="radio" value="Enable" class="required"  id="qn_Equipment_Ceiling_status" <?php if($rowsSubmitted_d['qn_Equipment_Ceiling_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr> 
  
   <tr>
    <td> 

      <input type="text" id="MyTextBox" name="qn_Travel" placeholder="" class="required" value="<?php if($rowsSubmitted_d['qn_Travel']){echo $rowsSubmitted_d['qn_Travel'];}else{ echo "$lang_new_TravelandSubsistence";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_Travel_Ceiling" class="required amount" placeholder="2" value="<?php echo $rowsSubmitted_d['qn_Travel_Ceiling'];?>" onkeyup="findTotal()">

  </td>
    <td>
     <input name="qn_Travel_status" type="radio" value="Disable" class="required" id="qn_Travel_status" <?php if($rowsSubmitted_d['qn_Travel_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_Travel_status" type="radio" value="Enable" class="required"  id="qn_Travel_status" <?php if($rowsSubmitted_d['qn_Travel_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
   
    </td>
  </tr> 
  
   <tr>
    <td> 

      <input type="text" id="MyTextBox" name="qn_kickoff" placeholder="" class="required" value="<?php if($rowsSubmitted_d['qn_kickoff']){echo $rowsSubmitted_d['qn_kickoff'];}else{ echo "$lang_new_GRatKickoff";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_kickoff_Ceiling" class="required  amount" placeholder="2" value="<?php echo $rowsSubmitted_d['qn_kickoff_Ceiling'];?>" onkeyup="findTotal()">

  </td>
    <td><input name="qn_kickoff_status" type="radio" value="Disable" class="required" id="qn_kickoff_status" <?php if($rowsSubmitted_d['qn_kickoff_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_kickoff_status" type="radio" value="Enable" class="required"  id="qn_kickoff_status" <?php if($rowsSubmitted_d['qn_kickoff_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr> 
  
   <tr>
    <td> 

      <input type="text" id="MyTextBox" name="qn_KnowledgeSharing" placeholder="" class="required" value="<?php if($rowsSubmitted_d['qn_KnowledgeSharing']){echo $rowsSubmitted_d['qn_KnowledgeSharing'];}else{ echo "$lang_new_KnowledgeSharing";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_KnowledgeSharing_Ceiling" class="required amount" placeholder="5" value="<?php echo $rowsSubmitted_d['qn_KnowledgeSharing_Ceiling'];?>" onkeyup="findTotal()">

  </td>
    <td>
    <input name="qn_KnowledgeSharing_status" type="radio" value="Disable" class="required" id="qn_KnowledgeSharing_status" <?php if($rowsSubmitted_d['qn_KnowledgeSharing_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_KnowledgeSharing_status" type="radio" value="Enable" class="required"  id="qn_KnowledgeSharing_status" <?php if($rowsSubmitted_d['qn_KnowledgeSharing_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr> 
  
   <tr>
    <td> 

      <input type="text" id="MyTextBox" name="qn_OverheadCosts" placeholder="" class="required" value="<?php if($rowsSubmitted_d['qn_OverheadCosts']){echo $rowsSubmitted_d['qn_OverheadCosts'];}else{ echo "$lang_new_Overheadcosts";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_OverheadCosts_Ceiling" class="required amount" placeholder="5" value="<?php echo $rowsSubmitted_d['qn_OverheadCosts_Ceiling'];?>" onkeyup="findTotal()">

  </td>
    <td>
    <input name="qn_OverheadCosts_status" type="radio" value="Disable" class="required" id="qn_OverheadCosts_status" <?php if($rowsSubmitted_d['qn_OverheadCosts_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_OverheadCosts_status" type="radio" value="Enable" class="required"  id="qn_OverheadCosts_status" <?php if($rowsSubmitted_d['qn_OverheadCosts_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr> 
  
   <tr>
    <td> 

      <input type="text" id="MyTextBox" name="qn_OtherGoods" placeholder="" class="required" value="<?php if($rowsSubmitted_d['qn_OtherGoods']){echo $rowsSubmitted_d['qn_OtherGoods'];}else{ echo "$lang_new_Othergoodsservices";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_OtherGoods_Ceiling" class="required amount" placeholder="2" value="<?php echo $rowsSubmitted_d['qn_OtherGoods_Ceiling'];?>" onkeyup="findTotal()">

  </td>
    <td>
     <input name="qn_OtherGoods_status" type="radio" value="Disable" class="required" id="qn_OtherGoods_status" <?php if($rowsSubmitted_d['qn_OtherGoods_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_OtherGoods_status" type="radio" value="Enable" class="required"  id="qn_Personnel_status" <?php if($rowsSubmitted_d['qn_OtherGoods_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
   
    </td>
  </tr> 
  
  
  
   <tr>
    <td> 

      <input type="text" id="MyTextBox" name="qn_MatchingSupport" placeholder="" class="required" value="<?php if($rowsSubmitted_d['qn_MatchingSupport']){echo $rowsSubmitted_d['qn_MatchingSupport'];}else{ echo "$lang_new_MatchingSupportifany";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_MatchingSupport_Ceiling" class="required amount" placeholder="1" value="<?php echo $rowsSubmitted_d['qn_MatchingSupport_Ceiling'];?>" onkeyup="findTotal()">

  </td>
    <td>
     <input name="qn_MatchingSupport_status" type="radio" value="Disable" class="required" id="qn_MatchingSupport_status" <?php if($rowsSubmitted_d['qn_MatchingSupport_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_MatchingSupport_status" type="radio" value="Enable" class="required"  id="qn_MatchingSupport_status" <?php if($rowsSubmitted_d['qn_MatchingSupport_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
   
    </td>
  </tr> 
  
  <tr>
    <td>&nbsp; 


  </td>
    <td> 
    <?php
	
	if($rowsSubmitted_d['qn_PersonnelPercentage_Ceiling']){$qn_PersonnelPercentage_Ceiling=$rowsSubmitted_d['qn_PersonnelPercentage_Ceiling'];}
	if($rowsSubmitted_d['qn_ResearchCosts_Ceiling']){$qn_ResearchCosts_Ceiling=$rowsSubmitted_d['qn_ResearchCosts_Ceiling'];}
	
	if($rowsSubmitted_d['qn_Equipment_Ceiling']){$qn_Equipment_Ceiling=$rowsSubmitted_d['qn_Equipment_Ceiling'];}
	if($rowsSubmitted_d['qn_Travel_Ceiling']){$qn_Travel_Ceiling=$rowsSubmitted_d['qn_Travel_Ceiling'];}
	
	if($rowsSubmitted_d['qn_kickoff_Ceiling']){$qn_kickoff_Ceiling=$rowsSubmitted_d['qn_kickoff_Ceiling'];}
	if($rowsSubmitted_d['qn_KnowledgeSharing_Ceiling']){$qn_KnowledgeSharing_Ceiling=$rowsSubmitted_d['qn_KnowledgeSharing_Ceiling'];}
	if($rowsSubmitted_d['qn_OverheadCosts_Ceiling']){$qn_OverheadCosts_Ceiling=$rowsSubmitted_d['qn_OverheadCosts_Ceiling'];}
	
	if($rowsSubmitted_d['qn_OtherGoods_Ceiling']){$qn_OtherGoods_Ceiling=$rowsSubmitted_d['qn_OtherGoods_Ceiling'];}
	if($rowsSubmitted_d['qn_MatchingSupport_Ceiling']){$qn_MatchingSupport_Ceiling=$rowsSubmitted_d['qn_MatchingSupport_Ceiling'];}
	
	//+$rowsSubmitted_d['qn_MatchingSupport_Ceiling']
	
if($_POST['doSaveDataProjectBudget']){
$totals=($rowsSubmitted_d['TotalCeiling']);

}
if(!$_POST['doSaveDataProjectBudget']){

$totals=($qn_PersonnelPercentage_Ceiling+$qn_ResearchCosts_Ceiling+$qn_Equipment_Ceiling+$qn_Travel_Ceiling+$qn_kickoff_Ceiling+$qn_KnowledgeSharing_Ceiling+$qn_OverheadCosts_Ceiling+$qn_OtherGoods_Ceiling+$qn_MatchingSupport_Ceiling);
}
	?>
<div style="width:100%; text-align:right; font-size:20px; font-weight:bold;">
<?php if(!$totalStages_d){?><input value="" name="TotalCeiling" id="TotalCeiling"  class="required number inputmain31" tabindex="14"  style=" width:120px; border:2px solid #F00; text-align:center;"/><?php }?>
<?php if($totalStages_d){?><input value="<?php echo $totals;?>" name="TotalCeiling" id="TotalCeiling"  class="required number inputmain31" tabindex="14"  style=" width:120px; border:2px solid #F00; text-align:center;"/><?php }?>
    
    
   <?php echo $lang_Max;?>=100</div>
   


  </td>
    <td>&nbsp;
    </td>
  </tr> 
  
  
  
</table>




<div class="row success">
    <input type="submit" name="doSaveDataProjectBudget" value="<?php echo $lang_new_Save;?>">
  </div>

