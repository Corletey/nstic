 <?php
 $sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_k where categoryID='$categoryIDm' and catadmin_id='$sessionusrm_id' and grantID='$id' and categorym='proposal' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
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
 
   
      <textarea id="MyTextBox11" name="overallCoordination" style="height:150px" class="required" required><?php if($rowsSubmitted_c['overallCoordination']){echo $rowsSubmitted_c['overallCoordination'];}else{ echo "$lang_new_overallcoordination";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="overallCoordination_number" class="required" value="<?php if($rowsSubmitted_c['overallCoordination_number']){echo $rowsSubmitted_c['overallCoordination_number'];}else{echo "1";}?>" required>

  </td>
    <td>
    <input name="overallCoordination_status" type="radio" value="Disable" class="required" id="overallCoordination_status" <?php if($rowsSubmitted_c['overallCoordination_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="overallCoordination_status" type="radio" value="Enable" class="required"  id="overallCoordination_status" <?php if($rowsSubmitted_c['overallCoordination_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="GantChart" style="height:150px" class="required" required><?php if($rowsSubmitted_c['GantChart']){echo $rowsSubmitted_c['GantChart'];}else{ echo "$lang_new_appropriateGantChart";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="GantChart_number" class="required" value="<?php if($rowsSubmitted_c['GantChart_number']){echo $rowsSubmitted_c['GantChart_number'];}else{echo "2";}?>" required>

  </td>
    <td>
    <input name="GantChart_status" type="radio" value="Disable" class="required" id="GantChart_status" <?php if($rowsSubmitted_c['GantChart_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="GantChart_status" type="radio" value="Enable" class="required"  id="GantChart_status" <?php if($rowsSubmitted_c['GantChart_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="informationFlow" style="height:150px" class="required" required><?php if($rowsSubmitted_c['informationFlow']){echo $rowsSubmitted_c['informationFlow'];}else{ echo "$lang_new_informationflow";}?></textarea>



  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="informationFlow_number" class="required" value="<?php if($rowsSubmitted_c['informationFlow_number']){echo $rowsSubmitted_c['informationFlow_number'];}else{echo "3";}?>" required>

  </td>
    <td>
    
    <input name="informationFlow_status" type="radio" value="Disable" class="required" id="informationFlow_status" <?php if($rowsSubmitted_c['informationFlow_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="informationFlow_status" type="radio" value="Enable" class="required"  id="informationFlow_status" <?php if($rowsSubmitted_c['informationFlow_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="Riskmanagement" style="height:150px" class="required" required><?php if($rowsSubmitted_c['Riskmanagement']){echo $rowsSubmitted_c['Riskmanagement'];}else{ echo "$lang_new_Riskmanagement";}?></textarea>



  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="Riskmanagement_number" class="required" value="<?php if($rowsSubmitted_c['Riskmanagement_number']){echo $rowsSubmitted_c['Riskmanagement_number'];}else{echo "4";}?>" required>

  </td>
    <td>
    
    <input name="Riskmanagement_status" type="radio" value="Disable" class="required" id="Riskmanagement_status" <?php if($rowsSubmitted_c['Riskmanagement_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="Riskmanagement_status" type="radio" value="Enable" class="required"  id="Riskmanagement_status" <?php if($rowsSubmitted_c['Riskmanagement_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
 
  
   
</table>

    
  



<div class="row success">
    <input type="submit" name="doSaveDataProjectManagement" value="<?php echo $lang_new_Save;?>">
  </div>

