 <?php
$sqlQnsubmitted_d="SELECT * FROM ".$prefix."concept_dynamic_questions_all_d where categoryID='$categoryIDm' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc";
$Querysubmitted_d = $mysqli->query($sqlQnsubmitted_d);
$rowsSubmitted_d=$Querysubmitted_d->fetch_array();
?> 
<table width="100%" border="0" class="success">
  <tr>
    <th width="72%"><strong><?php echo $lang_new_Question;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_QnNumber;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_Status;?> <input type="checkbox" onclick="toggle(this);" /><?php echo $lang_new_Enable;?></strong></th>
  </tr>
  <tr>
    <td> 
<input name="categoryID" type="hidden" value="<?php echo $categoryIDm;?>" />
 
      <input type="text" id="MyTextBox" name="qn_principle_investigator" placeholder="" class="required" value="<?php if($rowsSubmitted_d['qn_principle_investigator']){echo $rowsSubmitted_d['qn_principle_investigator'];}else{ echo "$lang_new_NamePrincipalInvestigator";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_principle_investigator_number" class="required" value="<?php if($rowsSubmitted_d['qn_principle_investigator_number']){echo $rowsSubmitted_d['qn_principle_investigator_number'];}else{ echo "1";}?>" required>

      

  </td>
    <td>
    <input name="qn_principle_investigator_status" type="radio" value="Disable" class="required" id="qn_principle_investigator_status" <?php if($rowsSubmitted_d['qn_principle_investigator_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_principle_investigator_status" type="radio" value="Enable" class="required"  id="qn_principle_investigator_status" <?php if($rowsSubmitted_d['qn_principle_investigator_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
  
   
  
</table>

    
  



<div class="row success">
    <input type="submit" name="doSaveDataProjectTeam" value="<?php echo $lang_new_Save;?>">
  </div>

