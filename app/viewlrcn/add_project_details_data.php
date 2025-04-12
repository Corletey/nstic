 <?php
 $sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_c where categoryID='$categoryIDm' and catadmin_id='$sessionusrm_id' and grantID='$id' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
?> 
<label for="fname"><?php echo $lang_new_Projectprimarybeneficiaries;?></label>
<table width="100%" border="0" class="success">
  <tr>
    <th width="72%"><strong><?php echo $lang_new_Question;?></strong></th>
    <th width="14%"><strong><?php echo $$lang_new_QnNumber;?></strong></th>
    <th width="14%"><strong><?php echo $$lang_new_Status;?> <input type="checkbox" onclick="toggle(this);" /><?php echo $lang_new_Enable;?>?</strong></th>
  </tr>
  <tr>
    <td> 
<input name="categoryID" type="hidden" value="<?php echo $categoryIDm;?>" />
 
      <input type="text" id="MyTextBox" name="qn_category_of_beneficiary" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_category_of_beneficiary']){echo $rowsSubmitted_c['qn_category_of_beneficiary'];}else{ echo "$lang_new_Categoryofbeneficiary";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_category_of_beneficiary_number" class="required" value="<?php if($rowsSubmitted_c['qn_category_of_beneficiary_number']){echo $rowsSubmitted_c['qn_category_of_beneficiary_number'];}else{echo "1";}?>" required>

  </td>
    <td>
    <input name="qn_category_of_beneficiary_status" type="radio" value="Disable" class="required" id="qn_category_of_beneficiary_status" <?php if($rowsSubmitted_c['qn_category_of_beneficiary_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_category_of_beneficiary_status" type="radio" value="Enable" class="required"  id="qn_category_of_beneficiary_status" <?php if($rowsSubmitted_c['qn_category_of_beneficiary_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  
   <tr>
    <td><select id="qn_gender" name="qn_gender" class="form-control <?php echo $required;?>" style="width:110px;">
<option value=""><?php echo $lang_Gender;?></option> 
<option value="Male"> <?php echo $lang_new_Male;?></option>
<option value="Female"> <?php echo $lang_new_Female;?></option>
      </select>
  
</td>
    <td>

      <input type="text" id="MyTextBox" name="qn_gender_number" class="required" value="<?php if($rowsSubmitted_c['qn_gender_number']){echo $rowsSubmitted_c['qn_gender_number'];}else{echo "2";}?>" required>
 
</td>
    <td>
    
    <input name="qn_gender_status" type="radio" value="Disable" id="qn_gender_status" class="required"  <?php if($rowsSubmitted_c['qn_gender_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_gender_status" type="radio" value="Enable" id="qn_gender_status" class="required"  <?php if($rowsSubmitted_c['qn_gender_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_quantities" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_quantities']){echo $rowsSubmitted_c['qn_quantities'];}else{ echo "$lang_new_Quantities";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_quantities_number" class="required" value="<?php if($rowsSubmitted_c['qn_quantities_number']){echo $rowsSubmitted_c['qn_quantities_number'];}else{echo "3";}?>" required>
   </td>
    <td>
    <input name="qn_quantities_status" type="radio" value="Disable" id="qn_quantities_status" class="required"  <?php if($rowsSubmitted_c['qn_quantities_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_quantities_status" type="radio" value="Enable" id="qn_quantities_status" class="required"  <?php if($rowsSubmitted_c['qn_quantities_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
 
  <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_locationbeneficiaries" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_locationbeneficiaries']){echo $rowsSubmitted_c['qn_locationbeneficiaries'];}else{ echo "$lang_new_Locationofbeneficiaries";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_locationbeneficiaries_number" class="required" value="<?php if($rowsSubmitted_c['qn_locationbeneficiaries_number']){echo $rowsSubmitted_c['qn_locationbeneficiaries_number'];}else{echo "4";}?>" required>
   </td>
    <td>
    
    <input name="qn_locationbeneficiaries_status" type="radio" value="Disable" id="qn_locationbeneficiaries_status" class="required"  <?php if($rowsSubmitted_c['qn_locationbeneficiaries_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_locationbeneficiaries_status" type="radio" value="Enable" id="qn_locationbeneficiaries_status" class="required"  <?php if($rowsSubmitted_c['qn_locationbeneficiaries_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    </td>
  </tr>
  
  
  




<table width="100%" border="0" class="success">
  <tr>
    <th width="72%"><strong><?php echo $lang_new_Question;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_QnNumber;?></strong></th>
    <th width="14%"><strong><?php echo $lang_new_Status;?> <input type="checkbox" onclick="toggle(this);" /><?php echo $lang_new_Enable;?></strong></th>
  </tr>
  <tr>
    <td> 
<input name="categoryID" type="hidden" value="<?php echo $categoryIDm;?>" />
 
      <input type="text" id="MyTextBox" name="qn_methodology" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_methodology']){echo $rowsSubmitted_c['qn_methodology'];}else{ echo "$lang_new_Methodology";}?>" required>

  </td>
    <td> 

 
      <input type="text" id="MyTextBox" name="qn_methodology_number" class="required" value="<?php if($rowsSubmitted_c['qn_methodology_number']){echo $rowsSubmitted_c['qn_methodology_number'];}else{echo "5";}?>" required>

  </td>
    <td>
    
    <input name="qn_methodology_status" type="radio" value="Disable" class="required" id="qn_methodology_status" <?php if($rowsSubmitted_c['qn_methodology_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_methodology_status" type="radio" value="Enable" class="required"  id="qn_methodology_status" <?php if($rowsSubmitted_c['qn_methodology_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    </td>
  </tr>
  
  
  
   <tr>
    <td><input type="text" id="MyTextBox" name="qn_scientificsolution" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_scientificsolution']){echo $rowsSubmitted_c['qn_scientificsolution'];}else{ echo "$lang_new_Scientifictechnological";}?>" required>
  
</td>
    <td>

      <input type="text" id="MyTextBox" name="qn_scientificsolution_number" class="required" value="<?php if($rowsSubmitted_c['qn_scientificsolution_number']){echo $rowsSubmitted_c['qn_scientificsolution_number'];}else{echo "6";}?>" required>
 
</td>
    <td>
    
    
    <input name="qn_scientificsolution_number_status" type="radio" value="Disable" id="qn_scientificsolution_number_status" class="required"  <?php if($rowsSubmitted_c['qn_scientificsolution_number_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_scientificsolution_number_status" type="radio" value="Enable" id="qn_scientificsolution_number_status" class="required"  <?php if($rowsSubmitted_c['qn_scientificsolution_number_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    
    </td>
  </tr>
  
  <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_specialinterestgroup" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_specialinterestgroup']){echo $rowsSubmitted_c['qn_specialinterestgroup'];}else{ echo "$lang_new_SpecialInterestgroup";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_specialinterestgroup_number" class="required" value="<?php if($rowsSubmitted_c['qn_specialinterestgroup_number']){echo $rowsSubmitted_c['qn_specialinterestgroup_number'];}else{echo "7";}?>" required>
   </td>
    <td>
    
    <input name="qn_specialinterestgroup_status" type="radio" value="Disable" id="qn_specialinterestgroup_status" class="required"  <?php if($rowsSubmitted_c['qn_specialinterestgroup_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_specialinterestgroup_status" type="radio" value="Enable" id="qn_specialinterestgroup_status" class="required"  <?php if($rowsSubmitted_c['qn_specialinterestgroup_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    </td>
  </tr>
  
  
 
  <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_PartnershipsCollaborations" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_PartnershipsCollaborations']){echo $rowsSubmitted_c['qn_PartnershipsCollaborations'];}else{ echo "$lang_new_Partnerships";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_PartnershipsCollaborations_number" class="required" value="<?php if($rowsSubmitted_c['qn_PartnershipsCollaborations_number']){echo $rowsSubmitted_c['qn_PartnershipsCollaborations_number'];}else{echo "8";}?>" required>
   </td>
    <td>
   
    <input name="qn_PartnershipsCollaborations_status" type="radio" value="Disable" id="qn_PartnershipsCollaborations_status" class="required"  <?php if($rowsSubmitted_c['qn_PartnershipsCollaborations_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
     <input name="qn_PartnershipsCollaborations_status" type="radio" value="Enable" id="qn_PartnershipsCollaborations_status" class="required"  <?php if($rowsSubmitted_c['qn_PartnershipsCollaborations_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    </td>
  </tr>
  
  
  <tr>
    <td>
    <label for="lname"><?php echo $lang_new_ExpectedIntellectualProperty;?></label>
      <?php
$shcategoryID4=$rowsSubmitted_c['qn_ExpectedIntellectualProperty'];
$categoryChunks = explode(",", $shcategoryID4);
$chop1="$categoryChunks[0]";
$chop2="$categoryChunks[1]";
$chop3="$categoryChunks[2]";
$chop4="$categoryChunks[3]";
$chop5="$categoryChunks[4]";
?>
<br />
<input name="qn_ExpectedIntellectualProperty[]" type="checkbox" value="Copy Rights"  <?php if($chop1=='Copy Rights' || $chop2=='Copy Rights' || $chop3=='Copy Rights' || $chop4=='Copy Rights' || $chop5=='Copy Rights'){?>checked="checked"<?php }?>/> <?php echo $lang_new_CopyRights;?><br />

<input name="qn_ExpectedIntellectualProperty[]" type="checkbox" value="Industrial designs"  <?php if($chop1=='Industrial designs' || $chop2=='Industrial designs' || $chop3=='Industrial designs' || $chop4=='Industrial designs' || $chop5=='Industrial designs'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Industrialdesigns;?><br />

<input name="qn_ExpectedIntellectualProperty[]" type="checkbox" value="Utility Models"  <?php if($chop1=='Utility Models' || $chop2=='Utility Models' || $chop3=='Utility Models' || $chop4=='Utility Models' || $chop5=='Utility Models'){?>checked="checked"<?php }?>/> <?php echo $lang_new_UtilityModels;?><br />

<input name="qn_ExpectedIntellectualProperty[]" type="checkbox" value="Trade Marks"  <?php if($chop1=='Trade Marks' || $chop2=='Trade Marks' || $chop3=='Trade Marks' || $chop4=='Trade Marks' || $chop5=='Trade Marks'){?>checked="checked"<?php }?>/> <?php echo $lang_new_TradeMarks;?><br />

<input name="qn_ExpectedIntellectualProperty[]" type="checkbox" value="Trade Secrets" <?php if($chop1=='Trade Secrets' || $chop2=='Trade Secrets' || $chop3=='Trade Secrets' || $chop4=='Trade Secrets' || $chop5=='Trade Secrets'){?>checked="checked"<?php }?>/> <?php echo $lang_new_TradeSecrets;?><br />

<input name="qn_ExpectedIntellectualProperty[]" type="checkbox" value="Patent" <?php if($chop1=='Patent' || $chop2=='Patent' || $chop3=='Patent' || $chop4=='Patent' || $chop5=='Patent'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Patent;?>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_ExpectedIntellectualProperty_number" class="required" value="<?php if($rowsSubmitted_c['qn_ExpectedIntellectualProperty_number']){echo $rowsSubmitted_c['qn_ExpectedIntellectualProperty_number'];}else{echo "9";}?>" required>
   </td>
    <td>
    
    
    <input name="qn_ExpectedIntellectualProperty_status" type="radio" value="Disable" id="qn_ExpectedIntellectualProperty_status" class="required"  <?php if($rowsSubmitted_c['qn_ExpectedIntellectualProperty_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_ExpectedIntellectualProperty_status" type="radio" value="Enable" id="qn_ExpectedIntellectualProperty_status" class="required"  <?php if($rowsSubmitted_c['qn_ExpectedIntellectualProperty_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    
    </td>
  </tr>
  
  

  
  
  
  
    <tr>
    <td>
      <input type="text" id="MyTextBox" name="qn_TotalBudget" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_TotalBudget']){echo $rowsSubmitted_c['qn_TotalBudget'];}else{ echo "$lang_new_TotalBudgetCost";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_TotalBudget_number" class="required" value="<?php if($rowsSubmitted_c['qn_TotalBudget_number']){echo $rowsSubmitted_c['qn_TotalBudget_number'];}else{echo "10";}?>" required>
   </td>
    <td>
    
    <input name="qn_TotalBudget_status" type="radio" value="Disable" id="qn_TotalBudget_status" class="required"  <?php if($rowsSubmitted_c['qn_TotalBudget_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_TotalBudget_status" type="radio" value="Enable" id="qn_TotalBudget_status" class="required"  <?php if($rowsSubmitted_c['qn_TotalBudget_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    </td>
  </tr>
  
  
    <tr>
    <td><select name="qn_currency" id="currency" class="required">
      <option value="" selected="selected"><?php echo $lang_please_select;?></option>     
 <?php
$sqlUser = "SELECT * FROM ".$prefix."currency order by currency asc";
$queryUser = $mysqli->query($sqlUser);
while($r = $queryUser->fetch_array()){?>
    <option value="<?php echo $r['currencyID'];?>" <?php if($r['currencyID']==$rUserInv2['currencyPrimaryFunder']){?>selected="selected"<?php }?>>&nbsp;<?php echo $r['currency'];?></option>
    <?php }?>
       </select> 
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_currency_number" class="required" value="<?php if($rowsSubmitted_c['qn_currency_number']){echo $rowsSubmitted_c['qn_currency_number'];}else{echo "11";}?>" required>
   </td>
    <td>
    
    
    <input name="qn_currency_status" type="radio" value="Disable" id="qn_currency_status" class="required"  <?php if($rowsSubmitted_c['qn_currency_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_currency_status" type="radio" value="Enable" id="qn_currency_status" class="required"  <?php if($rowsSubmitted_c['qn_currency_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    
    </td>
  </tr>
  
  
  
  
  
   <tr>
    <td colspan="3"><label for="lname"><strong><?php echo $lang_FundingSource;?></strong> </label>
    <br /><label for="lname">a) <?php echo $lang_PrimaryFunder;?> <span class="error">*</span></label> 
    </td>
  </tr>
  
 
  
  
  <tr>
    <td>
     <input type="text" id="MyTextBox" name="qn_PrimaryFunderName" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_PrimaryFunderName']){echo $rowsSubmitted_c['qn_PrimaryFunderName'];}else{ echo "$lang_new_Name";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_PrimaryFunderName_number" class="required" value="<?php if($rowsSubmitted_c['qn_PrimaryFunderName_number']){echo $rowsSubmitted_c['qn_PrimaryFunderName_number'];}else{echo "12";}?>" required>
   </td>
    <td>
    
    
    <input name="qn_PrimaryFunderName_status" type="radio" value="Disable" id="qn_PrimaryFunderName_status" class="required"  <?php if($rowsSubmitted_c['qn_PrimaryFunderName_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    <input name="qn_PrimaryFunderName_status" type="radio" value="Enable" id="qn_PrimaryFunderName_status" class="required"  <?php if($rowsSubmitted_c['qn_PrimaryFunderName_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    </td>
  </tr>
  
  
  <tr>
    <td> <input type="text" id="MyTextBox" name="qn_PrimaryFunderDuration" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_PrimaryFunderDuration']){echo $rowsSubmitted_c['qn_PrimaryFunderDuration'];}else{ echo "$lang_new_DurationofFunding";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_PrimaryFunderDuration_number" class="required" value="<?php if($rowsSubmitted_c['qn_PrimaryFunderDuration_number']){echo $rowsSubmitted_c['qn_PrimaryFunderDuration_number'];}else{echo "13";}?>" required>
   </td>
    <td>
    
  
    <input name="qn_PrimaryFunderDuration_status" type="radio" value="Disable" id="qn_PrimaryFunderDuration_status" class="required"  <?php if($rowsSubmitted_c['qn_PrimaryFunderDuration_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
      <input name="qn_PrimaryFunderDuration_status" type="radio" value="Enable" id="qn_PrimaryFunderDuration_status" class="required"  <?php if($rowsSubmitted_c['qn_PrimaryFunderDuration_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    
    </td>
  </tr>
  
  
  <tr>
    <td> <input type="text" id="MyTextBox" name="qn_PrimaryFunderAmount" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_PrimaryFunderAmount']){echo $rowsSubmitted_c['qn_PrimaryFunderAmount'];}else{ echo "$lang_new_Amount";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_PrimaryFunderAmount_number" class="required" value="<?php if($rowsSubmitted_c['qn_PrimaryFunderAmount_number']){echo $rowsSubmitted_c['qn_PrimaryFunderAmount_number'];}else{echo "14";}?>" required>
   </td>
    <td>
    
    
    <input name="qn_PrimaryFunderAmount_status" type="radio" value="Disable" id="qn_PrimaryFunderAmount_status" class="required"  <?php if($rowsSubmitted_c['qn_PrimaryFunderAmount_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_PrimaryFunderAmount_status" type="radio" value="Enable" id="qn_PrimaryFunderAmount_status" class="required"  <?php if($rowsSubmitted_c['qn_PrimaryFunderAmount_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    
    </td>
  </tr>
  
 
 <tr>
    <td colspan="3"><label for="lname">b) <?php echo $lang_new_SecondaryFunder;?></label> </td>
  </tr> 
  <tr>
    <td> <input type="text" id="MyTextBox" name="qn_SecondaryFunderName" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_SecondaryFunderName']){echo $rowsSubmitted_c['qn_SecondaryFunderName'];}else{ echo "$lang_new_Name";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_SecondaryFunderName_number" class="required" value="<?php if($rowsSubmitted_c['qn_SecondaryFunderName_number']){echo $rowsSubmitted_c['qn_SecondaryFunderName_number'];}else{echo "15";}?>" required>
   </td>
    <td>
    
    <input name="qn_SecondaryFunderName_status" type="radio" value="Disable" id="qn_SecondaryFunderName_status" class="required"  <?php if($rowsSubmitted_c['qn_SecondaryFunderName_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_SecondaryFunderName_status" type="radio" value="Enable" id="qn_SecondaryFunderName_status" class="required"  <?php if($rowsSubmitted_c['qn_SecondaryFunderName_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    </td>
  </tr>
  
  
  <tr>
    <td> <input type="text" id="MyTextBox" name="qn_SecondaryFunderDuration" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_SecondaryFunderDuration']){echo $rowsSubmitted_c['qn_SecondaryFunderDuration'];}else{ echo "$lang_new_DurationofFunding";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_SecondaryFunderDuration_number" class="required" value="<?php if($rowsSubmitted_c['qn_SecondaryFunderDuration_number']){echo $rowsSubmitted_c['qn_SecondaryFunderDuration_number'];}else{echo "16";}?>" required>
   </td>
    <td>
    
    
    <input name="qn_SecondaryFunderDuration_status" type="radio" value="Disable" id="qn_SecondaryFunderDuration_status" class="required"  <?php if($rowsSubmitted_c['qn_SecondaryFunderDuration_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_SecondaryFunderDuration_status" type="radio" value="Enable" id="qn_SecondaryFunderDuration_status" class="required"  <?php if($rowsSubmitted_c['qn_SecondaryFunderDuration_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    
    </td>
  </tr>
  
  
  <tr>
    <td> <input type="text" id="MyTextBox" name="qn_SecondaryFunderAmount" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_SecondaryFunderAmount']){echo $rowsSubmitted_c['qn_SecondaryFunderAmount'];}else{ echo "$lang_new_Amount";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_SecondaryFunderAmount_number" class="required" value="<?php if($rowsSubmitted_c['qn_SecondaryFunderAmount_number']){echo $rowsSubmitted_c['qn_SecondaryFunderAmount_number'];}else{echo "17";}?>" required>
   </td>
    <td>
    
    
    <input name="qn_SecondaryFunderAmount_status" type="radio" value="Disable" id="qn_SecondaryFunderAmount_status" class="required"  <?php if($rowsSubmitted_c['qn_SecondaryFunderAmount_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_SecondaryFunderAmount_status" type="radio" value="Enable" id="qn_SecondaryFunderAmount_status" class="required"  <?php if($rowsSubmitted_c['qn_SecondaryFunderAmount_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    </td>
  </tr>
  
  
  
  
   <tr>
    <td colspan="3"><label for="lname">b) <?php echo $lang_new_CounterpartFunding;?></label></td>
  </tr> 
  <tr>
    <td> <input type="text" id="MyTextBox" name="qn_CounterpartFundingName" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_CounterpartFundingName']){echo $rowsSubmitted_c['qn_CounterpartFundingName'];}else{ echo "Name";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_CounterpartFundingName_number" class="required" value="<?php if($rowsSubmitted_c['qn_CounterpartFundingName_number']){echo $rowsSubmitted_c['qn_CounterpartFundingName_number'];}else{echo "18";}?>" required>
   </td>
    <td>
    
    <input name="qn_CounterpartFundingName_status" type="radio" value="Disable" id="qn_CounterpartFundingName_status" class="required"  <?php if($rowsSubmitted_c['qn_CounterpartFundingName_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_CounterpartFundingName_status" type="radio" value="Enable" id="qn_CounterpartFundingName_status" class="required"  <?php if($rowsSubmitted_c['qn_CounterpartFundingName_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    </td>
  </tr>
  
  
  <tr>
    <td> <input type="text" id="MyTextBox" name="qn_CounterpartFundingDuration" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_CounterpartFundingDuration']){echo $rowsSubmitted_c['qn_CounterpartFundingDuration'];}else{ echo "$lang_new_DurationofFunding";}?>" required>
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_CounterpartFundingDuration_number" class="required" value="<?php if($rowsSubmitted_c['qn_CounterpartFundingDuration_number']){echo $rowsSubmitted_c['qn_CounterpartFundingDuration_number'];}else{echo "19";}?>" required>
   </td>
    <td>
    
    <input name="qn_CounterpartFundingDuration_status" type="radio" value="Disable" id="qn_CounterpartFundingDuration_status" class="required"  <?php if($rowsSubmitted_c['qn_CounterpartFundingDuration_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
    <input name="qn_CounterpartFundingDuration_status" type="radio" value="Enable" id="qn_CounterpartFundingDuration_status" class="required"  <?php if($rowsSubmitted_c['qn_CounterpartFundingDuration_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    </td>
  </tr>
  
  
  <tr>
    <td> <input type="text" id="MyTextBox" name="qn_CounterpartFundingAmount" placeholder="" class="required" value="<?php if($rowsSubmitted_c['qn_CounterpartFundingAmount']){echo $rowsSubmitted_c['qn_CounterpartFundingAmount'];}else{ echo "$lang_new_Name";}?>" required> 
   </td>
    <td>
      <input type="text" id="MyTextBox" name="qn_CounterpartFundingAmount_number" class="required" value="<?php if($rowsSubmitted_c['qn_CounterpartFundingAmount_number']){echo $rowsSubmitted_c['qn_CounterpartFundingAmount_number'];}else{echo "20";}?>" required>
   </td>
    <td>
    
   
    <input name="qn_CounterpartFundingAmount_status" type="radio" value="Disable" id="qn_CounterpartFundingAmount_status" class="required"  <?php if($rowsSubmitted_c['qn_CounterpartFundingAmount_status']=='Disable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Disable;?><br />
    
     <input name="qn_CounterpartFundingAmount_status" type="radio" value="Enable" id="qn_CounterpartFundingAmount_status" class="required"  <?php if($rowsSubmitted_c['qn_CounterpartFundingAmount_status']=='Enable'){?>checked="checked"<?php }?>/> <?php echo $lang_new_Enable;?>
    
    
    
    </td>
  </tr>
  
  
  
  
  
  
  
   
  
</table>

    
  



<div class="row success">
    <input type="submit" name="doSaveDataProjectIntroduction" value="<?php echo $lang_new_Save;?>">
  </div>

