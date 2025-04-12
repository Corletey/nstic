 <?php
 $sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_i where categoryID='$categoryIDm' and catadmin_id='$sessionusrm_id' and grantID='$id' and categorym='proposal' order by id desc";
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
 
   
      <textarea id="MyTextBox11" name="resultExploitationPlan" style="height:150px" class="required" required><?php if($rowsSubmitted_c['resultExploitationPlan']){echo $rowsSubmitted_c['resultExploitationPlan'];}else{ echo "$lang_new_Sketchout";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="resultExploitationPlan_number" class="required" value="<?php if($rowsSubmitted_c['resultExploitationPlan_number']){echo $rowsSubmitted_c['resultExploitationPlan_number'];}else{echo "1";}?>" required>

  </td>
    <td>
     <input name="resultExploitationPlan_status" type="radio" value="Disable" class="required" id="resultExploitationPlan_status" <?php if($rowsSubmitted_c['resultExploitationPlan_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="resultExploitationPlan_status" type="radio" value="Enable" class="required"  id="resultExploitationPlan_status" <?php if($rowsSubmitted_c['resultExploitationPlan_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
   
    </td>
  </tr>
  
  
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="resultInnovativeResults" style="height:150px" class="required" required><?php if($rowsSubmitted_c['resultInnovativeResults']){echo $rowsSubmitted_c['resultInnovativeResults'];}else{ echo "$lang_new_ifrelevant";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="resultInnovativeResults_number" class="required" value="<?php if($rowsSubmitted_c['resultInnovativeResults_number']){echo $rowsSubmitted_c['resultInnovativeResults_number'];}else{echo "2";}?>" required>

  </td>
    <td>
    <input name="resultInnovativeResults_status" type="radio" value="Disable" class="required" id="resultInnovativeResults_status" <?php if($rowsSubmitted_c['resultInnovativeResults_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="resultInnovativeResults_status" type="radio" value="Enable" class="required"  id="resultInnovativeResults_status" <?php if($rowsSubmitted_c['resultInnovativeResults_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="resultIntellectualProperty" style="height:150px" class="required" required><?php if($rowsSubmitted_c['resultIntellectualProperty']){echo $rowsSubmitted_c['resultIntellectualProperty'];}else{ echo "$lang_new_Howintellectualproperty";}?></textarea>



  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="resultIntellectualProperty_number" class="required" value="<?php if($rowsSubmitted_c['resultIntellectualProperty_number']){echo $rowsSubmitted_c['resultIntellectualProperty_number'];}else{echo "3";}?>" required>

  </td>
    <td>
    <input name="resultIntellectualProperty_status" type="radio" value="Disable" class="required" id="resultIntellectualProperty_status" <?php if($rowsSubmitted_c['resultIntellectualProperty_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="resultIntellectualProperty_status" type="radio" value="Enable" class="required"  id="resultIntellectualProperty_status" <?php if($rowsSubmitted_c['resultIntellectualProperty_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="ethicalConsiderations"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['ethicalConsiderations']){echo $rowsSubmitted_c['ethicalConsiderations'];}else{ echo "$lang_new_ethicalconsiderations";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="ethicalConsiderations_number" class="required" value="<?php if($rowsSubmitted_c['ethicalConsiderations_number']){echo $rowsSubmitted_c['ethicalConsiderations_number'];}else{echo "4";}?>" required>

  </td>
    <td>
    
    <input name="ethicalConsiderations_status" type="radio" value="Disable" class="required" id="ethicalConsiderations_status" <?php if($rowsSubmitted_c['ethicalConsiderations_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="ethicalConsiderations_status" type="radio" value="Enable" class="required"  id="ethicalConsiderations_status" <?php if($rowsSubmitted_c['ethicalConsiderations_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="DealwithEthicalIssues"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['DealwithEthicalIssues']){echo $rowsSubmitted_c['DealwithEthicalIssues'];}else{ echo "$lang_new_Clearlyexplain";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="DealwithEthicalIssues_number" class="required" value="<?php if($rowsSubmitted_c['DealwithEthicalIssues_number']){echo $rowsSubmitted_c['DealwithEthicalIssues_number'];}else{echo "5";}?>" required>

  </td>
    <td>
     <input name="DealwithEthicalIssues_status" type="radio" value="Disable" class="required" id="DealwithEthicalIssues_status" <?php if($rowsSubmitted_c['DealwithEthicalIssues_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="DealwithEthicalIssues_status" type="radio" value="Enable" class="required"  id="DealwithEthicalIssues_status" <?php if($rowsSubmitted_c['DealwithEthicalIssues_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
   
    </td>
  </tr>
  
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="NeedEthicalClearance"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['NeedEthicalClearance']){echo $rowsSubmitted_c['NeedEthicalClearance'];}else{ echo "$lang_new_projectintend";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="NeedEthicalClearance_number" class="required" value="<?php if($rowsSubmitted_c['NeedEthicalClearance_number']){echo $rowsSubmitted_c['NeedEthicalClearance_number'];}else{echo "6";}?>" required>

  </td>
    <td>
    
    <input name="NeedEthicalClearance_status" type="radio" value="Disable" class="required" id="NeedEthicalClearance_status" <?php if($rowsSubmitted_c['NeedEthicalClearance_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="NeedEthicalClearance_status" type="radio" value="Enable" class="required"  id="NeedEthicalClearance_status" <?php if($rowsSubmitted_c['NeedEthicalClearance_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="GenderYouth"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['GenderYouth']){echo $rowsSubmitted_c['GenderYouth'];}else{ echo "$lang_new_Gendertheinclusion";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="GenderYouth_number" class="required" value="<?php if($rowsSubmitted_c['GenderYouth_number']){echo $rowsSubmitted_c['GenderYouth_number'];}else{echo "7";}?>" required>

  </td>
    <td>
    <input name="GenderYouth_status" type="radio" value="Disable" class="required" id="GenderYouth_status" <?php if($rowsSubmitted_c['GenderYouth_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="GenderYouth_status" type="radio" value="Enable" class="required"  id="GenderYouth_status" <?php if($rowsSubmitted_c['GenderYouth_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
 
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="YoungResearchers"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['YoungResearchers']){echo $rowsSubmitted_c['YoungResearchers'];}else{ echo "$lang_new_young_researchers";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="YoungResearchers_number" class="required" value="<?php if($rowsSubmitted_c['YoungResearchers_number']){echo $rowsSubmitted_c['YoungResearchers_number'];}else{echo "8";}?>" required>

  </td>
    <td>
    
    <input name="YoungResearchers_status" type="radio" value="Disable" class="required" id="YoungResearchers_status" <?php if($rowsSubmitted_c['YoungResearchers_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="YoungResearchers_status" type="radio" value="Enable" class="required"  id="YoungResearchers_status" <?php if($rowsSubmitted_c['YoungResearchers_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
   <tr>
    <td> 
<textarea id="MyTextBox11" name="InterestGroups"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['InterestGroups']){echo $rowsSubmitted_c['InterestGroups'];}else{ echo "$lang_new_interestgroups";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="InterestGroups_number" class="required" value="<?php if($rowsSubmitted_c['InterestGroups_number']){echo $rowsSubmitted_c['InterestGroups_number'];}else{echo "9";}?>" required>

  </td>
    <td>
    
    <input name="InterestGroups_status" type="radio" value="Disable" class="required" id="InterestGroups_status" <?php if($rowsSubmitted_c['InterestGroups_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="InterestGroups_status" type="radio" value="Enable" class="required"  id="InterestGroups_status" <?php if($rowsSubmitted_c['InterestGroups_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="StateNatureofSupport"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['StateNatureofSupport']){echo $rowsSubmitted_c['StateNatureofSupport'];}else{ echo "$lang_new_supportStateNature";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="StateNatureofSupport_number" class="required" value="<?php if($rowsSubmitted_c['StateNatureofSupport_number']){echo $rowsSubmitted_c['StateNatureofSupport_number'];}else{echo "10";}?>" required>

  </td>
    <td>
    <input name="StateNatureofSupport_status" type="radio" value="Disable" class="required" id="StateNatureofSupport_status" <?php if($rowsSubmitted_c['StateNatureofSupport_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="StateNatureofSupport_status" type="radio" value="Enable" class="required"  id="StateNatureofSupport_status" <?php if($rowsSubmitted_c['StateNatureofSupport_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  <tr>
    <td> 
<textarea id="MyTextBox11" name="AttachLetterofSupport"  style="height:150px" class="required" required><?php if($rowsSubmitted_c['AttachLetterofSupport']){echo $rowsSubmitted_c['AttachLetterofSupport'];}else{ echo "$lang_new_letterofsupport";}?></textarea>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="AttachLetterofSupport_number" class="required" value="<?php if($rowsSubmitted_c['AttachLetterofSupport_number']){echo $rowsSubmitted_c['AttachLetterofSupport_number'];}else{echo "11";}?>" required>

  </td>
    <td>
    <input name="AttachLetterofSupport_status" type="radio" value="Disable" class="required" id="AttachLetterofSupport_status" <?php if($rowsSubmitted_c['AttachLetterofSupport_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="AttachLetterofSupport_status" type="radio" value="Enable" class="required"  id="AttachLetterofSupport_status" <?php if($rowsSubmitted_c['AttachLetterofSupport_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
</table>

    
  



<div class="row success">
    <input type="submit" name="doSaveDataProjectFollowup" value="<?php echo $lang_new_Save;?>">
  </div>

