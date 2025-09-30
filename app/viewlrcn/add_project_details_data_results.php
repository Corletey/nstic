 <?php
 $sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_j where categoryID='$categoryIDm' and catadmin_id='$sessionusrm_id' and grantID='$id' and categorym='proposal' order by id desc";
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
 
   
      <textarea id="MyTextBox11" name="logicalflow" style="height:150px" class="required" required><?php if($rowsSubmitted_c['logicalflow']){echo $rowsSubmitted_c['logicalflow'];}else{ echo "$lang_new_narrative";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="logicalflow_number" class="required" value="<?php if($rowsSubmitted_c['logicalflow_number']){echo $rowsSubmitted_c['logicalflow_number'];}else{echo "1";}?>" required>

  </td>
    <td>
    <input name="logicalflow_status" type="radio" value="Disable" class="required" id="logicalflow_status" <?php if($rowsSubmitted_c['logicalflow_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="logicalflow_status" type="radio" value="Enable" class="required"  id="logicalflow_status" <?php if($rowsSubmitted_c['logicalflow_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="ResearchObjective" style="height:150px" class="required" required><?php if($rowsSubmitted_c['ResearchObjective']){echo $rowsSubmitted_c['ResearchObjective'];}else{ echo "$lang_new_ResearchobjectiveCall";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="ResearchObjective_number" class="required" value="<?php if($rowsSubmitted_c['ResearchObjective_number']){echo $rowsSubmitted_c['ResearchObjective_number'];}else{echo "2";}?>" required>

  </td>
    <td>
    <input name="ResearchObjective_status" type="radio" value="Enable" class="required"  id="ResearchObjective_status" <?php if($rowsSubmitted_c['ResearchObjective_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?><br />
    <input name="ResearchObjective_status" type="radio" value="Disable" class="required" id="ResearchObjective_status" <?php if($rowsSubmitted_c['ResearchObjective_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?>
    
    
    </td>
  </tr>
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="Outputs" style="height:150px" class="required" required><?php if($rowsSubmitted_c['Outputs']){echo $rowsSubmitted_c['Outputs'];}else{ echo "$lang_new_immediateresults";}?></textarea>



  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="Outputs_number" class="required" value="<?php if($rowsSubmitted_c['Outputs_number']){echo $rowsSubmitted_c['Outputs_number'];}else{echo "3";}?>" required>

  </td>
    <td>
    <input name="Outputs_status" type="radio" value="Disable" class="required" id="Outputs_status" <?php if($rowsSubmitted_c['Outputs_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="Outputs_status" type="radio" value="Enable" class="required"  id="Outputs_status" <?php if($rowsSubmitted_c['Outputs_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="Outcomes"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['Outcomes']){echo $rowsSubmitted_c['Outcomes'];}else{ echo "$lang_new_outcomesExternal";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="Outcomes_number" class="required" value="<?php if($rowsSubmitted_c['Outcomes_number']){echo $rowsSubmitted_c['Outcomes_number'];}else{echo "4";}?>" required>

  </td>
    <td>
    
    <input name="Outcomes_status" type="radio" value="Disable" class="required" id="Outcomes_status" <?php if($rowsSubmitted_c['Outcomes_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="Outcomes_status" type="radio" value="Enable" class="required"  id="Outcomes_status" <?php if($rowsSubmitted_c['Outcomes_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="ImpactCapacityDevelopment"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['ImpactCapacityDevelopment']){echo $rowsSubmitted_c['ImpactCapacityDevelopment'];}else{ echo "$lang_new_changesScientific";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="ImpactCapacityDevelopment_number" class="required" value="<?php if($rowsSubmitted_c['ImpactCapacityDevelopment_number']){echo $rowsSubmitted_c['ImpactCapacityDevelopment_number'];}else{echo "5";}?>" required>

  </td>
    <td>
    
    <input name="ImpactCapacityDevelopment_status" type="radio" value="Disable" class="required" id="ImpactCapacityDevelopment_status" <?php if($rowsSubmitted_c['ImpactCapacityDevelopment_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="ImpactCapacityDevelopment_status" type="radio" value="Enable" class="required"  id="ImpactCapacityDevelopment_status" <?php if($rowsSubmitted_c['ImpactCapacityDevelopment_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="ImpactPathwayDiagram"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['ImpactPathwayDiagram']){echo $rowsSubmitted_c['ImpactPathwayDiagram'];}else{ echo "$lang_new_Impactpathwaydiagram";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="ImpactPathwayDiagram_number" class="required" value="<?php if($rowsSubmitted_c['ImpactPathwayDiagram_number']){echo $rowsSubmitted_c['ImpactPathwayDiagram_number'];}else{echo "6";}?>" required>

  </td>
    <td>
    
    <input name="ImpactPathwayDiagram_status" type="radio" value="Disable" class="required" id="ImpactPathwayDiagram_status" <?php if($rowsSubmitted_c['ImpactPathwayDiagram_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="ImpactPathwayDiagram_status" type="radio" value="Enable" class="required"  id="ImpactPathwayDiagram_status" <?php if($rowsSubmitted_c['ImpactPathwayDiagram_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="StakeholderEngagement"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['StakeholderEngagement']){echo $rowsSubmitted_c['StakeholderEngagement'];}else{ echo "$lang_new_Knowledgesharingupdtake";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="StakeholderEngagement_number" class="required" value="<?php if($rowsSubmitted_c['StakeholderEngagement_number']){echo $rowsSubmitted_c['StakeholderEngagement_number'];}else{echo "7";}?>" required>

  </td>
    <td>
    <input name="StakeholderEngagement_status" type="radio" value="Disable" class="required" id="StakeholderEngagement_status" <?php if($rowsSubmitted_c['StakeholderEngagement_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="StakeholderEngagement_status" type="radio" value="Enable" class="required"  id="StakeholderEngagement_status" <?php if($rowsSubmitted_c['StakeholderEngagement_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="CommunicationWithStakeholders"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['CommunicationWithStakeholders']){echo $rowsSubmitted_c['CommunicationWithStakeholders'];}else{ echo "$lang_new_Communicationwithstakeholders";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="CommunicationWithStakeholders_number" class="required" value="<?php if($rowsSubmitted_c['CommunicationWithStakeholders_number']){echo $rowsSubmitted_c['CommunicationWithStakeholders_number'];}else{echo "8";}?>" required>

  </td>
    <td>
    <input name="CommunicationWithStakeholders_status" type="radio" value="Disable" class="required" id="CommunicationWithStakeholders_status" <?php if($rowsSubmitted_c['CommunicationWithStakeholders_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="CommunicationWithStakeholders_status" type="radio" value="Enable" class="required"  id="CommunicationWithStakeholders_status" <?php if($rowsSubmitted_c['CommunicationWithStakeholders_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="ScientificOutput"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['ScientificOutput']){echo $rowsSubmitted_c['ScientificOutput'];}else{ echo "$lang_new_Scientificoutput";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="ScientificOutput_number" class="required" value="<?php if($rowsSubmitted_c['ScientificOutput_number']){echo $rowsSubmitted_c['ScientificOutput_number'];}else{echo "9";}?>" required>

  </td>
    <td>
    
    <input name="ScientificOutput_status" type="radio" value="Disable" class="required" id="ScientificOutput_status" <?php if($rowsSubmitted_c['ScientificOutput_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="ScientificOutput_status" type="radio" value="Enable" class="required"  id="ScientificOutput_status" <?php if($rowsSubmitted_c['ScientificOutput_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
   
</table>

    
  



<div class="row success">
    <input type="submit" name="doSaveDataProjectResults" value="<?php echo $lang_new_Save;?>">
  </div>

