 <?php
 $sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_g where categoryID='$categoryIDm' and catadmin_id='$sessionusrm_id' and grantID='$id' and categorym='proposal' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
?> 

<table width="100%" border="0" class="success">
  <tr>
    <th width="72%"><strong><?php echo $lang_new_Question;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_QnQuestion;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_Status;?> <input type="checkbox" onclick="toggle(this);" /><?php echo $lang_new_Enable;?></strong></th>
  </tr>
  <tr>
    <td> 
<input name="categoryID" type="hidden" value="<?php echo $categoryIDm;?>" />
 
   
      <textarea id="MyTextBox11" name="SummaryAudience" style="height:150px" class="required" required><?php if($rowsSubmitted_c['SummaryAudience']){echo $rowsSubmitted_c['SummaryAudience'];}else{ echo "$lang_new_broaderaudience";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="SummaryAudience_number" class="requiredm" value="<?php if($rowsSubmitted_c['SummaryAudience_number']){echo $rowsSubmitted_c['SummaryAudience_number'];}else{echo "1";}?>" required>

  </td>
    <td>
    <input name="SummaryAudience_status" type="radio" value="Disable" class="required" id="SummaryAudience_status" <?php if($rowsSubmitted_c['SummaryAudience_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="SummaryAudience_status" type="radio" value="Enable" class="required"  id="SummaryAudience_status" <?php if($rowsSubmitted_c['SummaryAudience_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="explanationObjectives" placeholder="" style="height:150px" class="required" required><?php if($rowsSubmitted_c['explanationObjectives']){echo $rowsSubmitted_c['explanationObjectives'];}else{ echo "$lang_new_BackgroundQuestions";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="explanationObjectives_number" class="requiredm" value="<?php if($rowsSubmitted_c['explanationObjectives_number']){echo $rowsSubmitted_c['explanationObjectives_number'];}else{echo "2";}?>" required>

  </td>
    <td>
    <input name="explanationObjectives_status" type="radio" value="Disable" class="required" id="explanationObjectives_status" <?php if($rowsSubmitted_c['explanationObjectives_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="explanationObjectives_status" type="radio" value="Enable" class="required"  id="explanationObjectives_status" <?php if($rowsSubmitted_c['explanationObjectives_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="researchInnovationIssues" placeholder="" style="height:150px" class="required" required><?php if($rowsSubmitted_c['researchInnovationIssues']){echo $rowsSubmitted_c['researchInnovationIssues'];}else{ echo "$lang_new_Presenttheresearch";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="researchInnovationIssues_number" class="requiredm" value="<?php if($rowsSubmitted_c['researchInnovationIssues_number']){echo $rowsSubmitted_c['researchInnovationIssues_number'];}else{echo "3";}?>" required>

  </td>
    <td>
    <input name="researchInnovationIssues_status" type="radio" value="Disable" class="required" id="researchInnovationIssues_status" <?php if($rowsSubmitted_c['researchInnovationIssues_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="researchInnovationIssues_status" type="radio" value="Enable" class="required"  id="researchInnovationIssues_status" <?php if($rowsSubmitted_c['researchInnovationIssues_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  

  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="NovelCharacterScientificResearch"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['NovelCharacterScientificResearch']){echo $rowsSubmitted_c['NovelCharacterScientificResearch'];}else{ echo "$lang_new_Explainthenovel";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="NovelCharacterScientificResearch_number" class="requiredm" value="<?php if($rowsSubmitted_c['NovelCharacterScientificResearch_number']){echo $rowsSubmitted_c['NovelCharacterScientificResearch_number'];}else{echo "5";}?>" required>

  </td>
    <td>
    <input name="NovelCharacterScientificResearch_status" type="radio" value="Disable" class="required" id="NovelCharacterScientificResearch_status" <?php if($rowsSubmitted_c['NovelCharacterScientificResearch_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="NovelCharacterScientificResearch_status" type="radio" value="Enable" class="required"  id="NovelCharacterScientificResearch_status" <?php if($rowsSubmitted_c['NovelCharacterScientificResearch_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="ClearJustificationDemonstration"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['ClearJustificationDemonstration']){echo $rowsSubmitted_c['ClearJustificationDemonstration'];}else{ echo "$lang_new_Clearjustification";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="ClearJustificationDemonstration_number" class="requiredm" value="<?php if($rowsSubmitted_c['ClearJustificationDemonstration_number']){echo $rowsSubmitted_c['ClearJustificationDemonstration_number'];}else{echo "6";}?>" required>

  </td>
    <td>
    <input name="ClearJustificationDemonstration_status" type="radio" value="Disable" class="required" id="ClearJustificationDemonstration_status" <?php if($rowsSubmitted_c['ClearJustificationDemonstration_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="ClearJustificationDemonstration_status" type="radio" value="Enable" class="required"  id="ClearJustificationDemonstration_status" <?php if($rowsSubmitted_c['ClearJustificationDemonstration_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="interdisciplinaryTransdisciplinary"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['interdisciplinaryTransdisciplinary']){echo $rowsSubmitted_c['interdisciplinaryTransdisciplinary'];}else{ echo "$lang_new_Highlighttheinterdisciplinary";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="interdisciplinaryTransdisciplinary_number" class="requiredm" value="<?php if($rowsSubmitted_c['interdisciplinaryTransdisciplinary_number']){echo $rowsSubmitted_c['interdisciplinaryTransdisciplinary_number'];}else{echo "7";}?>" required>

  </td>
    <td>
    
    <input name="interdisciplinaryTransdisciplinary_status" type="radio" value="Disable" class="required" id="interdisciplinaryTransdisciplinary_status" <?php if($rowsSubmitted_c['interdisciplinaryTransdisciplinary_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="interdisciplinaryTransdisciplinary_status" type="radio" value="Enable" class="required"  id="interdisciplinaryTransdisciplinary_status" <?php if($rowsSubmitted_c['interdisciplinaryTransdisciplinary_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="addedValue"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['addedValue']){echo $rowsSubmitted_c['addedValue'];}else{ echo "$lang_new_StateandExplain";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="addedValue_number" class="requiredm" value="<?php if($rowsSubmitted_c['addedValue_number']){echo $rowsSubmitted_c['addedValue_number'];}else{echo "8";}?>" required>

  </td>
    <td>
    
    <input name="addedValue_status" type="radio" value="Disable" class="required" id="addedValue_status" <?php if($rowsSubmitted_c['addedValue_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="addedValue_status" type="radio" value="Enable" class="required"  id="addedValue_status" <?php if($rowsSubmitted_c['addedValue_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="ImportanceResearchInnovation"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['ImportanceResearchInnovation']){echo $rowsSubmitted_c['ImportanceResearchInnovation'];}else{ echo "$lang_new_Explaintherelevance";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="ImportanceResearchInnovation_number" class="requiredm" value="<?php if($rowsSubmitted_c['ImportanceResearchInnovation_number']){echo $rowsSubmitted_c['ImportanceResearchInnovation_number'];}else{echo "9";}?>" required>

  </td>
    <td>
    <input name="ImportanceResearchInnovation_status" type="radio" value="Disable" class="required" id="ImportanceResearchInnovation_status" <?php if($rowsSubmitted_c['ImportanceResearchInnovation_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="ImportanceResearchInnovation_status" type="radio" value="Enable" class="required"  id="ImportanceResearchInnovation_status" <?php if($rowsSubmitted_c['ImportanceResearchInnovation_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
   
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="PartofInternationalProject"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['PartofInternationalProject']){echo $rowsSubmitted_c['PartofInternationalProject'];}else{ echo "$lang_new_proposalpart";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="PartofInternationalProject_number" class="requiredm" value="<?php if($rowsSubmitted_c['PartofInternationalProject_number']){echo $rowsSubmitted_c['PartofInternationalProject_number'];}else{echo "10";}?>" required>

  </td>
    <td>
    
    <input name="PartofInternationalProject_status" type="radio" value="Disable" class="required" id="PartofInternationalProject_status" <?php if($rowsSubmitted_c['PartofInternationalProject_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="PartofInternationalProject_status" type="radio" value="Enable" class="required"  id="PartofInternationalProject_status" <?php if($rowsSubmitted_c['PartofInternationalProject_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="projectSpecificActivities"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['projectSpecificActivities']){echo $rowsSubmitted_c['projectSpecificActivities'];}else{ echo "$lang_new_specificactivities";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="projectSpecificActivities_number" class="requiredm" value="<?php if($rowsSubmitted_c['projectSpecificActivities_number']){echo $rowsSubmitted_c['projectSpecificActivities_number'];}else{echo "11";}?>" required>

  </td>
    <td>
    
    <input name="projectSpecificActivities_status" type="radio" value="Disable" class="required" id="projectSpecificActivities_status" <?php if($rowsSubmitted_c['projectSpecificActivities_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="projectSpecificActivities_status" type="radio" value="Enable" class="required"  id="projectSpecificActivities_status" <?php if($rowsSubmitted_c['projectSpecificActivities_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
</table>

    
  



<div class="row success">
    <input type="submit" name="doSaveDataProjectBackground" value="Save">
  </div>

