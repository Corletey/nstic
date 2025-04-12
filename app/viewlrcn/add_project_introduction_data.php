 <?php
$sqlQnsubmitted_b="SELECT * FROM ".$prefix."concept_dynamic_questions_all_b where categoryID='$categoryIDm' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc";
$Querysubmitted_b = $mysqli->query($sqlQnsubmitted_b);
$rowsSubmitted_b=$Querysubmitted_b->fetch_array();

?> <table width="100%" border="0" class="success">
  <tr>
    <th width="72%"><strong><?php echo $lang_new_Question;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_QnNumber;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_Status;?> <input type="checkbox" onclick="toggle(this);" /><?php echo $lang_new_Enable;?></strong></th>
  </tr>
  <tr>
    <td> 
<input name="categoryID" type="hidden" value="<?php echo $categoryIDm;?>" />
 
      <input type="text" id="MyTextBox" name="qn_introduction" placeholder="Introduction" class="required" value="<?php if($rowsSubmitted_b['qn_introduction']){echo $rowsSubmitted_b['qn_introduction'];}else{ echo "$lang_new_Introduction";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_introduction_number" class="required" value="<?php if($rowsSubmitted_b['qn_introduction_number']){echo $rowsSubmitted_b['qn_introduction_number'];}else{echo "1";}?>" required>

  </td>
    <td>
    <input name="qn_introduction_status" type="radio" value="Disable" class="required" id="qn_introduction_status" <?php if($rowsSubmitted_b['qn_introduction_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_introduction_status" type="radio" value="Enable" class="required"  id="qn_introduction_status" <?php if($rowsSubmitted_b['qn_introduction_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
   <tr>
    <td><input type="text" id="MyTextBox" name="qn_objectives" placeholder="" class="required" value="<?php if($rowsSubmitted_b['qn_objectives']){echo $rowsSubmitted_b['qn_objectives'];}else{ echo "$lang_new_Objectives";}?>" required>
  
</td>
    <td>

      <input type="text" id="MyTextBox" name="qn_objectives_number" class="required" value="<?php if($rowsSubmitted_b['qn_objectives_number']){echo $rowsSubmitted_b['qn_objectives_number'];}else{echo "2";}?>" required>
 
</td>
    <td>
    
    <input name="qn_objectives_status" type="radio" value="Disable" id="qn_objectives_status" class="required"  <?php if($rowsSubmitted_b['qn_objectives_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_objectives_status" type="radio" value="Enable" id="qn_objectives_status" class="required"  <?php if($rowsSubmitted_b['qn_objectives_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_expectedoutput" placeholder="" class="required" value="<?php if($rowsSubmitted_b['qn_expectedoutput']){echo $rowsSubmitted_b['qn_expectedoutput'];}else{ echo "$lang_new_ExpectedOutput";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_expectedoutput_number" class="required" value="<?php if($rowsSubmitted_b['qn_expectedoutput_number']){echo $rowsSubmitted_b['qn_expectedoutput_number'];}else{echo "3";}?>" required>
   </td>
    <td>
    <input name="qn_expectedoutput_status" type="radio" value="Disable" id="qn_expectedoutput_status" class="required"  <?php if($rowsSubmitted_b['qn_expectedoutput_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_expectedoutput_status" type="radio" value="Enable" id="qn_expectedoutput_status" class="required"  <?php if($rowsSubmitted_b['qn_expectedoutput_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
 
  <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_expectedoutcome" placeholder="" class="required" value="<?php if($rowsSubmitted_b['qn_expectedoutcome']){echo $rowsSubmitted_b['qn_expectedoutcome'];}else{ echo "$lang_new_ExpectedOutcomes";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_expectedoutcome_number" class="required" value="<?php if($rowsSubmitted_b['qn_expectedoutcome_number']){echo $rowsSubmitted_b['qn_expectedoutcome_number'];}else{echo "4";}?>" required>
   </td>
    <td>
    <input name="qn_expectedoutcome_status" type="radio" value="Disable" id="qn_expectedoutcome_status" class="required"  <?php if($rowsSubmitted_b['qn_expectedoutcome_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_expectedoutcome_status" type="radio" value="Enable" id="qn_expectedoutcome_status" class="required"  <?php if($rowsSubmitted_b['qn_expectedoutcome_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  <tr>
    <td>
    <label for="lname"><?php echo $lang_new_Impact;?></label>
      <input type="text" id="MyTextBox" name="qn_scientific_impact" placeholder="" class="required" value="<?php if($rowsSubmitted_b['qn_scientific_impact']){echo $rowsSubmitted_b['qn_scientific_impact'];}else{ echo "$lang_new_ScientificImpact";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_scientific_impact_number" class="required" value="<?php if($rowsSubmitted_b['qn_scientific_impact_number']){echo $rowsSubmitted_b['qn_scientific_impact_number'];}else{echo "5";}?>" required>
   </td>
    <td>
    <input name="qn_scientific_impact_status" type="radio" value="Disable" id="qn_scientific_impact_status" class="required"  <?php if($rowsSubmitted_b['qn_scientific_impact_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_scientific_impact_status" type="radio" value="Enable" id="qn_scientific_impact_status" class="required"  <?php if($rowsSubmitted_b['qn_scientific_impact_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  <tr>
    <td>
    <label for="lname"><?php echo $lang_new_Impact;?></label>
      <input type="text" id="MyTextBox" name="qn_Economicimpact" placeholder="" class="required" value="<?php if($rowsSubmitted_b['qn_Economicimpact']){echo $rowsSubmitted_b['qn_Economicimpact'];}else{ echo "$lang_new_Economicimpact";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_Economicimpact_number" class="required" value="<?php if($rowsSubmitted_b['qn_Economicimpact_number']){echo $rowsSubmitted_b['qn_Economicimpact_number'];}else{echo "6";}?>" required>
   </td>
    <td>
    
    <input name="qn_Economicimpact_status" type="radio" value="Disable" id="qn_Economicimpact_status" class="required"  <?php if($rowsSubmitted_b['qn_Economicimpact_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_Economicimpact_status" type="radio" value="Enable" id="qn_Economicimpact_status" class="required"  <?php if($rowsSubmitted_b['qn_Economicimpact_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>

  
  
  
  
    <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_environmental_impact" placeholder="" class="required" value="<?php if($rowsSubmitted_b['qn_environmental_impact']){echo $rowsSubmitted_b['qn_environmental_impact'];}else{ echo "$lang_new_EnvironmentalImpact";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_environmental_impact_number" class="required" value="<?php if($rowsSubmitted_b['qn_environmental_impact_number']){echo $rowsSubmitted_b['qn_environmental_impact_number'];}else{echo "7";}?>" required>
   </td>
    <td>
    <input name="qn_environmental_impact_status" type="radio" value="Disable" id="qn_environmental_impact_status" class="required"  <?php if($rowsSubmitted_b['qn_environmental_impact_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_environmental_impact_status" type="radio" value="Enable" id="qn_environmental_impact_status" class="required"  <?php if($rowsSubmitted_b['qn_environmental_impact_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
    <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_societal_impact" placeholder="" class="required" value="<?php if($rowsSubmitted_b['qn_societal_impact']){echo $rowsSubmitted_b['qn_societal_impact'];}else{ echo "$lang_new_Societalimpact";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_societal_impact_number" class="required" value="<?php if($rowsSubmitted_b['qn_societal_impact_number']){echo $rowsSubmitted_b['qn_societal_impact_number'];}else{echo "8";}?>" required>
   </td>
    <td>
    <input name="qn_societal_impact_status" type="radio" value="Disable" id="qn_societal_impact_status" class="required"  <?php if($rowsSubmitted_b['qn_societal_impact_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_societal_impact_status" type="radio" value="Enable" id="qn_societal_impact_status" class="required"  <?php if($rowsSubmitted_b['qn_societal_impact_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
    <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_describe_project_alignment" placeholder="" class="required" value="<?php if($rowsSubmitted_b['qn_describe_project_alignment']){echo $rowsSubmitted_b['qn_describe_project_alignment'];}else{ echo "$lang_new_projectalignment";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_describe_project_alignment_number" class="required" value="<?php if($rowsSubmitted_b['qn_describe_project_alignment_number']){echo $rowsSubmitted_b['qn_describe_project_alignment_number'];}else{echo "9";}?>" required>
   </td>
    <td>
    
    <input name="qn_describe_project_alignment_status" type="radio" value="Disable" id="qn_describe_project_alignment_status" class="required"  <?php if($rowsSubmitted_b['qn_scientific_impact_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_describe_project_alignment_status" type="radio" value="Enable" id="qn_describe_project_alignment_status" class="required"  <?php if($rowsSubmitted_b['qn_describe_project_alignment_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
</table>

    
  



<div class="row success">
    <input type="submit" name="doSaveDataProjectDetails" value="<?php echo $lang_new_Save;?>">
  </div>

