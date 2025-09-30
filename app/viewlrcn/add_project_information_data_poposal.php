 <?php
$sqlQnsubmitted="SELECT * FROM ".$prefix."concept_dynamic_questions_all_a where categoryID='$categoryIDm' and catadmin_id='$sessionusrm_id' and grantID='$id' and categorym='proposal' order by id desc";
$Querysubmitted = $mysqli->query($sqlQnsubmitted);
$rowsSubmitted=$Querysubmitted->fetch_array();
?><table width="100%" border="0" class="success">
  <tr>
    <th width="72%"><strong><?php echo $lang_new_Question;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_QnNumber;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_Status;?> <input type="checkbox" onclick="toggle(this);" /><?php echo $lang_new_Enable;?></strong></th>
  </tr>
  <tr>
    <td> 
<input name="categoryID" type="hidden" value="<?php echo $categoryIDm;?>" />
 
      <input type="text" id="MyTextBox" name="qn_title" placeholder="Give the title of your project.." class="required" value="<?php if($rowsSubmitted['qn_title']){echo $rowsSubmitted['qn_title'];}else{ echo "$lang_new_title";}?>" required>


  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_title_number" class="required" value="<?php if($rowsSubmitted['qn_title_number']){echo $rowsSubmitted['qn_title_number'];}else{echo "1";}?>" required>

  </td>
    <td>
    
    <input name="qn_title_status" type="radio" value="Disable" class="required" id="qn_title_status" <?php if($rowsSubmitted['qn_title_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_title_status" type="radio" value="Enable" class="required"  id="qn_title_status" <?php if($rowsSubmitted['qn_title_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
   <tr>
    <td><input type="text" id="MyTextBox" name="qn_acronym" placeholder="Short Title or Acronym (10 characters)" class="required" value="<?php if($rowsSubmitted['qn_acronym']){echo $rowsSubmitted['qn_acronym'];}else{ echo "$lang_new_titleacronmy";}?>" required>
  
</td>
    <td>

      <input type="text" id="MyTextBox" name="qn_acronym_number" class="required" value="<?php if($rowsSubmitted['qn_acronym_number']){echo $rowsSubmitted['qn_acronym_number'];}else{echo "2";}?>" required>
 
</td>
    <td>
    
    <input name="qn_acronym_status" type="radio" value="Disable" id="qn_acronym_status" class="required"  <?php if($rowsSubmitted['qn_acronym_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_acronym_status" type="radio" value="Enable" id="qn_acronym_status" class="required"  <?php if($rowsSubmitted['qn_acronym_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_relevantKeywords" placeholder="Identify the 5 most relevant keywords that represent the scientific basis of your project (max 5 words)" class="required" value="<?php if($rowsSubmitted['qn_relevantKeywords']){echo $rowsSubmitted['qn_relevantKeywords'];}else{ echo "$lang_new_relevantKeywords";}?>" required>
      
      
      
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_relevantKeywords_number" class="required" value="<?php if($rowsSubmitted['qn_relevantKeywords_number']){echo $rowsSubmitted['qn_relevantKeywords_number'];}else{echo "3";}?>" required>
   </td>
    <td>
    
    <input name="qn_relevantKeywords_status" type="radio" value="Disable" id="qn_relevantKeywords_status" class="required"  <?php if($rowsSubmitted['qn_relevantKeywords_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_relevantKeywords_status" type="radio" value="Enable" id="qn_relevantKeywords_status" class="required"  <?php if($rowsSubmitted['qn_relevantKeywords_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
   <tr>
    <td>
     <label for="country"><?php echo $lang_new_researchTypeID;?> <span class="error">*</span></label>
     
    <select id="country" name="qn_researchTypeID" class="required">
<option value=""><?php echo $lang_please_select;?></option>
       <?php
$sqlCat = "SELECT * FROM ".$prefix."categories order by rstug_categoryName asc";
$queryCat = $mysqli->query($sqlCat);
while($rCat = $queryCat->fetch_array()){
?>
<option value="<?php echo $rCat['rstug_categoryID'];?>" <?php if($rCat['rstug_categoryID']==$rowsSubmitted['qn_researchTypeID']){?>selected="selected"<?php }?>><?php if($base_lang=="en"){echo $rCat['rstug_categoryName'];}if($base_lang=="fr"){echo $rCat['rstug_categoryName'];}if($base_lang=="pt"){echo $rCat['rstug_categoryName'];} ?></option>
<?php }?>
</select>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_researchTypeID_number" class="required" value="<?php if($rowsSubmitted['qn_researchTypeID_number']){echo $rowsSubmitted['qn_researchTypeID_number'];}else{echo "4";}?>" required>
   </td>
    <td><br />
    <input name="qn_researchTypeID_status" type="radio" value="Disable" id="qn_researchTypeID_status" class="required"  <?php if($rowsSubmitted['qn_researchTypeID_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_researchTypeID_status" type="radio" value="Enable" id="qn_researchTypeID_status" class="required"  <?php if($rowsSubmitted['qn_researchTypeID_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
   <tr>
    <td><input type="text" id="qn_HostInstitution" name="qn_HostInstitution" placeholder=".." class="required"  value="<?php if($rowsSubmitted['qn_HostInstitution']){echo $rowsSubmitted['qn_HostInstitution'];}else{ echo "$lang_new_HostInstitution";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBoxs" name="qn_HostInstitution_number" class="required" value="<?php if($rowsSubmitted['qn_HostInstitution_number']){echo $rowsSubmitted['qn_HostInstitution_number'];}else{echo "5";}?>">
   </td>
    <td><br />
    <input name="qn_HostInstitution_status" type="radio" value="Disable" id="qn_HostInstitution_status" class="required"  <?php if($rowsSubmitted['qn_HostInstitution_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_HostInstitution_status" type="radio" value="Enable" id="qn_HostInstitution_status" class="required" <?php if($rowsSubmitted['qn_HostInstitution_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  <tr>
    <td><input type="text" id="qn_OrchidID" name="qn_OrchidID" placeholder="ORCID" class="required"  value="<?php if($rowsSubmitted['qn_OrchidID']){echo $rowsSubmitted['qn_OrchidID'];}else{ echo "$lang_new_ORCIDID";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBoxs" name="qn_OrchidID_number" class="required" value="<?php if($rowsSubmitted['qn_OrchidID_number']){echo $rowsSubmitted['qn_OrchidID_number'];}else{echo "6";}?>">
   </td>
    <td><br /><input name="qn_OrchidID_status" type="radio" value="Disable" id="qn_OrchidID_status" class="required"  <?php if($rowsSubmitted['qn_OrchidID_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_OrchidID_status" type="radio" value="Enable" id="qn_OrchidID_status" class="required" <?php if($rowsSubmitted['qn_OrchidID_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  <tr>
    <td>
     <label for="country"><?php echo $lang_new_titleDurationtheproject;?> <span class="error">*</span></label>
  <select id="qn_projectDurationID" name="qn_projectDurationID" class="required" required>
       <?php
$sqlFeaturedCall = "SELECT * FROM ".$prefix."duration order by durationID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
while($rFeaturedCall = $queryFeaturedCall->fetch_array()){
?>
<option value="<?php echo $rFeaturedCall['durationID'];?>" <?php if($rFeaturedCall['durationID']==$rowsSubmitted['qn_projectDurationID']){?>selected="selected"<?php }?>><?php echo $rFeaturedCall['duration'];?> <?php echo $rFeaturedCall['durationdesc'];?></option>
<?php }?>
      </select>
   
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_projectDurationID_number" class="required" value="<?php if($rowsSubmitted['qn_projectDurationID_number']){echo $rowsSubmitted['qn_projectDurationID_number'];}else{echo "7";}?>" required>
   </td>
    <td><br />
    
    <input name="qn_projectDurationID_status" type="radio" value="Disable" id="qn_projectDurationID_status" class="required" <?php if($rowsSubmitted['qn_projectDurationID_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_projectDurationID_status" type="radio" value="Enable" id="qn_projectDurationID_status" class="required" <?php if($rowsSubmitted['qn_projectDurationID_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
   <tr>
    <td><input type="text" id="qn_fundingappliedfor" name="qn_fundingappliedfor" placeholder="" class="required"  value="<?php if($rowsSubmitted['qn_fundingappliedfor']){echo $rowsSubmitted['qn_fundingappliedfor'];}else{ echo "$lang_new_Totalfundingappliedfor";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBoxs" name="qn_fundingappliedfor_number" class="required" value="<?php if($rowsSubmitted['qn_fundingappliedfor_number']){echo $rowsSubmitted['qn_fundingappliedfor_number'];}else{echo "8";}?>">
   </td>
    <td><?php /*?><br /><input name="qn_fundingappliedfor_status" type="radio" value="Disable" id="qn_fundingappliedfor_status" class="required"  <?php if($rowsSubmitted['qn_fundingappliedfor_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br /><?php */?>
    
    
    <input name="qn_fundingappliedfor_status" type="radio" value="Enable" id="qn_fundingappliedfor_status" class="required" <?php if($rowsSubmitted['qn_fundingappliedfor_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
</table>

    
  



<div class="row success">
    <input type="submit" name="doSaveDataProjectInformation" value="<?php echo $lang_new_Save;?>">
  </div>
