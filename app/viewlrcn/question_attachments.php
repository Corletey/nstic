<?php 
$country=$_GET['country'];?>

<table width="100%" border="0">
  <tr>
    <td>Add <b><?php echo $country;?></b> Attachments eg 1. Concept, 2. Work-Plan, 3. Budget</td>

  </tr>
</table>

<?php 
if($country=="1"){
?>
<table width="100%" border="0">
  <tr>
    <td width="3%">1. <span class="error">*</span></td>
    <td width="97%"><input name="dynamicaddattachments[]" type="text" id="dropdown_option1" required/><br /></td>
  </tr>
  
</table>
<?php }?>

<?php 
if($country=="2"){
?>
<table width="100%" border="0">
  <tr>
    <td width="3%">1. <span class="error">*</span></td>
    <td width="97%"><input name="dynamicaddattachments[]" type="text" id="dropdown_option1" required/><br /></td>
  </tr>
   <tr>
    <td width="3%">2. <span class="error">*</span></td>
    <td width="97%"><input name="dynamicaddattachments[]" type="text" id="dropdown_option2" required/><br /></td>
  </tr>
  
</table>
<?php }?>

<?php 
if($country=="3"){
?>
<table width="100%" border="0">
  <tr>
    <td width="3%">1. <span class="error">*</span></td>
    <td width="97%"><input name="dynamicaddattachments[]" type="text" id="dropdown_option1" required/><br /></td>
  </tr>
   <tr>
    <td width="3%">2. <span class="error">*</span></td>
    <td width="97%"><input name="dynamicaddattachments[]" type="text" id="dropdown_option2" required/><br /></td>
  </tr>
  
    <tr>
    <td width="3%">3. <span class="error">*</span></td>
    <td width="97%"><input name="dynamicaddattachments[]" type="text" id="dropdown_option3" required/><br /></td>
  </tr>
 
</table>
<?php }?>


<?php 
if($country=="4"){
?>
<table width="100%" border="0">
  <tr>
    <td width="3%">1. <span class="error">*</span></td>
    <td width="97%"><input name="dynamicaddattachments[]" type="text" id="dropdown_option1" required/><br /></td>
  </tr>
   <tr>
    <td width="3%">2. <span class="error">*</span></td>
    <td width="97%"><input name="dynamicaddattachments[]" type="text" id="dropdown_option2"required /><br /></td>
  </tr>
  
    <tr>
    <td width="3%">3. <span class="error">*</span></td>
    <td width="97%"><input name="dynamicaddattachments[]" type="text" id="dropdown_option3" required/><br /></td>
  </tr>
  
 <tr>
    <td width="3%">4. <span class="error">*</span></td>
    <td width="97%"><input name="dynamicaddattachments[]" type="text" id="dropdown_option4" required/><br /></td>
  </tr> 
  
  
  
</table>
<?php }?>

