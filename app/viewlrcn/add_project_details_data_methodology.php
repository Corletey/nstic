 <?php
$sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_h where categoryID='$categoryIDm' and catadmin_id='$sessionusrm_id' and grantID='$id' and categorym='proposal' order by id desc";
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
 
   
      <textarea id="MyTextBox11" name="generalApproach" style="height:150px" class="required" required><?php if($rowsSubmitted_c['generalApproach']){echo $rowsSubmitted_c['generalApproach'];}else{ echo "$lang_new_Explainthegeneralapproach";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="generalApproach_number" class="required" value="<?php if($rowsSubmitted_c['generalApproach_number']){echo $rowsSubmitted_c['generalApproach_number'];}else{echo "1";}?>" required>

  </td>
    <td>
    <input name="generalApproach_status" type="radio" value="Disable" class="required" id="generalApproach_status" <?php if($rowsSubmitted_c['generalApproach_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="generalApproach_status" type="radio" value="Enable" class="required"  id="generalApproach_status" <?php if($rowsSubmitted_c['generalApproach_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="RelationshipOngoingResearch" style="height:150px" class="required" required><?php if($rowsSubmitted_c['explanationObjectives']){echo $rowsSubmitted_c['explanationObjectives'];}else{ echo "$lang_new_Relationship";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="RelationshipOngoingResearch_number" class="required" value="<?php if($rowsSubmitted_c['RelationshipOngoingResearch_number']){echo $rowsSubmitted_c['RelationshipOngoingResearch_number'];}else{echo "2";}?>" required>

  </td>
    <td>
    <input name="RelationshipOngoingResearch_status" type="radio" value="Disable" class="required" id="RelationshipOngoingResearch_status" <?php if($rowsSubmitted_c['RelationshipOngoingResearch_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="RelationshipOngoingResearch_status" type="radio" value="Enable" class="required"  id="RelationshipOngoingResearch_status" <?php if($rowsSubmitted_c['RelationshipOngoingResearch_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="otherDonorsFunding" style="height:150px" class="required" required><?php if($rowsSubmitted_c['otherDonorsFunding']){echo $rowsSubmitted_c['otherDonorsFunding'];}else{ echo "$lang_new_otherDonors";}?></textarea>



  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="otherDonorsFunding_number" class="required" value="<?php if($rowsSubmitted_c['otherDonorsFunding_number']){echo $rowsSubmitted_c['otherDonorsFunding_number'];}else{echo "3";}?>" required>

  </td>
    <td>
    <input name="otherDonorsFunding_status" type="radio" value="Disable" class="required" id="otherDonorsFunding_status" <?php if($rowsSubmitted_c['otherDonorsFunding_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="otherDonorsFunding_status" type="radio" value="Enable" class="required"  id="otherDonorsFunding_status" <?php if($rowsSubmitted_c['otherDonorsFunding_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="drawSynergiesOngoingProjects"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['drawSynergiesOngoingProjects']){echo $rowsSubmitted_c['drawSynergiesOngoingProjects'];}else{ echo "$lang_new_furtheringwork";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="drawSynergiesOngoingProjects_number" class="required" value="<?php if($rowsSubmitted_c['drawSynergiesOngoingProjects_number']){echo $rowsSubmitted_c['drawSynergiesOngoingProjects_number'];}else{echo "4";}?>" required>

  </td>
    <td>
    <input name="drawSynergiesOngoingProjects_status" type="radio" value="Disable" class="required" id="drawSynergiesOngoingProjects_status" <?php if($rowsSubmitted_c['drawSynergiesOngoingProjects_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="drawSynergiesOngoingProjects_status" type="radio" value="Enable" class="required"  id="drawSynergiesOngoingProjects_status" <?php if($rowsSubmitted_c['drawSynergiesOngoingProjects_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
    <tr>
    <td> 
<textarea id="MyTextBox11" name="furtheringwork" style="height:150px" class="required" required><?php if($rowsSubmitted_c['furtheringwork']){echo $rowsSubmitted_c['furtheringwork'];}else{ echo "$lang_furtheringwork";}?></textarea>



  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="furtheringwork_number" class="required" value="<?php if($rowsSubmitted_c['furtheringwork_number']){echo $rowsSubmitted_c['furtheringwork_number'];}else{echo "3";}?>" required>

  </td>
    <td>
    <input name="furtheringwork_status" type="radio" value="Disable" class="required" id="furtheringwork_status" <?php if($rowsSubmitted_c['furtheringwork_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="furtheringwork_status" type="radio" value="Enable" class="required"  id="furtheringwork_status" <?php if($rowsSubmitted_c['furtheringwork_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
    <tr>
    <td> 
<textarea id="MyTextBox11" name="synergymayexistbetween" style="height:150px" class="required" required><?php if($rowsSubmitted_c['synergymayexistbetween']){echo $rowsSubmitted_c['synergymayexistbetween'];}else{ echo "$lang_synergymayexistbetween";}?></textarea>



  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="synergymayexistbetween_number" class="required" value="<?php if($rowsSubmitted_c['synergymayexistbetween_number']){echo $rowsSubmitted_c['synergymayexistbetween_number'];}else{echo "3";}?>" required>

  </td>
    <td>
    <input name="synergymayexistbetween_status" type="radio" value="Disable" class="required" id="synergymayexistbetween_status" <?php if($rowsSubmitted_c['synergymayexistbetween_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="synergymayexistbetween_status" type="radio" value="Enable" class="required"  id="synergymayexistbetween_status" <?php if($rowsSubmitted_c['synergymayexistbetween_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
  
  
  
  
  
  
  
</table>

    
  



<div class="row success">
    <input type="submit" name="doSaveDataProjectMethodology" value="<?php echo $lang_new_Save;?>">
  </div>

