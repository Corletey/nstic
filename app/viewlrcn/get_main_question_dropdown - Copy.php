<?php
require_once('../configlrcn/db_mconfig.php');
$country=$_GET['country'];
$sqlLastQn="SELECT * FROM ".$prefix."grantcall_questions where `status`='new' order by questionID desc limit 0,1";
$QueryLastQn = $mysqli->query($sqlLastQn);
$rUserLastQn=$QueryLastQn->fetch_array();
$qn_number=($rUserLastQn['qn_number']+1);

if($country==8){?>


<div class="form-group form-group-default">
<label for="fname">Add Budget Question/Notes (<span class="error">*</span>)</label>  <br /> 
<textarea name="Question[]" cols="" rows="2" id="MyTextBox3" required class="questionbox"></textarea>
</div>
              
 <div class="form-group form-group-default">
<label for="fname">Maximum Budget (<span class="error">*</span>)</label>  <br />     
<input name="MaximumBudget" type="text"  id="MyTextBox3" class="questionbox" required/>
 </div>
 
 
 
 
  <table width="38%" align="center" cellpadding="0" cellspacing="0" class="normal-text" border="0">
<tr>
<td  align="center"><input type="button" value="Add New Row" onClick="addRow('dataTableMoze')" >&nbsp;
<input type="button" value="Remove Row" onClick="deleteRow('dataTableMoze')" ></td>
</tr>
</table>

<table width="100%" border="0" id="POITable">
<tr>
  <th width="30" valign="top"></th>
  <th width="1013">ITEM</th>
  <th width="169">PERCENTAGE CEILING</th>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="normal-text" id="dataTableMoze">



<tr>
<td width="20" valign="top"><input type="checkbox" name="chk[]" checked="checked"/></td>

<td width="1032" >
<div class="form-group form-group-default">
              <input type="hidden" class="form-control" name="itemmm[]">  
<input type="text" id="item" name="item[]" class="requiredm number" value="" required>
              </div>
 </td>


<td width="174" valign="top"><div class="form-group form-group-default">
<input type="text" id="percentage" name="percentage[]" class="requiredm number" value="" required onKeyUp="getValues()">
              </div></td>
              
</tr>







</table>


  
  
  
  
</td>
</tr>
</table>
</td>
</tr>


</table>

    <div style="width:100%; text-align:right; font-size:20px; font-weight:bold;">
    <input value="" name="totalAmount" id="total"  class="required number inputmain31" tabindex="14"  onkeyup="figure(this.value)" style=" width:50px; border:2px solid #F00; text-align:center;"/>
    
    
   Max=100</div>
    <input name="qn_number[]" type="hidden" value="<?php echo ($qn_number);?>"/>
    
    
    
    
 
 
 
 
 
 
 
 
 
 
 
 

<div class="row success">
    <input type="submit" name="doSaveDataBudget" value="Save">
  </div>
  
  
  



<!--<input value="" name="qty[]" id="p_wp"  class="required inputmain31" onKeyUp="getValues()" tabindex="8" size="10" autocomplete="off"/>
<input value="" name="rate[]" id="req_rate"  class="required inputmain31" onKeyUp="getValues()" tabindex="10" size="10"/>

<input value="" name="amt[]" id="qty1"  class="required number inputmain31" tabindex="11" onkeyup="getValues();"/>-->


<?php 
}

?>

<?php if($country==9){?>
<div class="form-group form-group-default">
       
                <textarea name="Question[]" cols="" rows="4" id="MyTextBox3" required class="questionbox"></textarea>
              </div>

 <div class="form-group form-group-default <?php echo $required;?>">   
    <input type="hidden" class="form-control" name="singleselectmm[]">  
    <select id="singleselect" name="singleattachments[]" class="form-control <?php echo $required;?>" style="width:400px;" onChange="getqnattachments(this.value)" required>
<option value="">Select to add Attachments</option> 
<option value="1"> How many Attachements? 1</option> 
<option value="2"> How many Attachements? 2</option> 
<option value="3"> How many Attachements? 3</option>
<option value="4"> How many Attachements? 4</option>
      </select>
  </div>
  
  <div id="getattachmentsdiv">  </div> 
  <input name="qn_number[]" type="hidden" value="<?php echo ($qn_number);?>"/>

<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
  <?php }?>



<?php if($country==1){?>
<table width="38%" align="center" cellpadding="0" cellspacing="0" class="normal-text" border="0">
<tr>
<td  align="center"><input type="button" value="Add New Row" onClick="addRow('dataTableMoze')" >&nbsp;
<input type="button" value="Remove Row" onClick="deleteRow('dataTableMoze')" ></td>
</tr>
</table>

<table width="100%" border="0" id="POITable">
<tr>
  <th width="30" valign="top"></th>
  <th width="1013">Add Questions to the Grant new call</th>
  <th width="169">Question Number</th>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="normal-text" id="dataTableMoze">



<tr>
<td width="20" valign="top"><input type="checkbox" name="chk[]" checked="checked"/></td>

<td align="left" valign="top" >

<div class="form-group form-group-default">
              <input type="hidden" class="form-control" name="Questionmm[]">  
                
                <textarea name="Question[]" cols="" rows="" id="MyTextBox3" required class="questionbox"></textarea>
              </div>
 
</td>


<td align="left" valign="top"><div class="form-group form-group-default">
              
                
                <textarea name="qn_number[]" cols="" rows="" id="MyTextBox3mm" required style="width:150px;"><?php echo ($qn_number);?></textarea>
              </div>
              <input name="requireTitleORCIDID" type="hidden" value="ORCIDID"/>
              
              </td>
              
</tr>







</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
<?php }

if($country=='pmtitle'){?>

<table width="100%" border="0" id="POITable">
<tr>
  <th width="30" valign="top"></th>
  <th width="1013">Add Question for Project Title eg "Project Title"</th>
  <th width="169">Question Number</th>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="normal-text" id="dataTableMoze">



<tr>
<td width="20" valign="top"><input type="checkbox" name="chk[]" checked="checked"/></td>

<td align="left" valign="top" >

<div class="form-group form-group-default">
              <input type="hidden" class="form-control" name="Questionmm[]">  
                
                <textarea name="Question[]" cols="" rows="" id="MyTextBox3" required class="questionbox">Project Title</textarea>
              </div>
  
</td>


<td align="left" valign="top"><div class="form-group form-group-default">
              
                
                <textarea name="qn_number[]" cols="" rows="" id="MyTextBox3mm" required style="width:150px;"><?php echo ($qn_number);?></textarea>
              </div></td>
              
</tr>







</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>

<?php }


if($country!=1 and $country!=2 and $country!=3 and $country!=4 and $country!=7  and $country!=8 and $country!=9 and $country!='pmtitle'){?>

    <table width="38%" align="center" cellpadding="0" cellspacing="0" class="normal-text" border="0">
<tr>
<td  align="center"><input type="button" value="Add New Row" onClick="addRow('dataTableMoze')" >&nbsp;
<input type="button" value="Remove Row" onClick="deleteRow('dataTableMoze')" ></td>
</tr>
</table>

<table width="100%" border="0" id="POITable">
<tr>
  <th width="30" valign="top"></th>
  <th width="1013">Add Questions to the Grant new call</th>
  <th width="169">Question Number</th>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="normal-text" id="dataTableMoze">



<tr>
<td width="20" valign="top"><input type="checkbox" name="chk[]" checked="checked"/></td>

<td align="left" valign="top" >

<div class="form-group form-group-default">
              <input type="hidden" class="form-control" name="Questionmm[]">  
                
                <textarea name="Question[]" cols="" rows="" id="MyTextBox3" required class="questionbox"></textarea>
              </div>



<div class="form-group form-group-default <?php echo $required;?>">
  <input type="hidden" class="form-control" name="Categoryofbeneficiarymm[]">  
                     
<select id="dropdown" name="dropdown[]" class="form-control <?php echo $required;?>" style="width:400px;" onChange="getqndropdown(this.value)">
<option value="">Select to add dropdown to the Question</option> 
<option value="1"> 1</option> 
<option value="2"> 2</option> 
<option value="3"> 3</option>
<option value="4"> 4</option>
<option value="5"> 5</option>

<option value="6"> 6</option>
<option value="7"> 7</option>
<option value="8"> 8</option>
<option value="9"> 9</option>
<option value="10"> 10</option>

      </select>
      
      <div id="getdropdiv">  </div>
     
      
  </div>
  
  
  
  
  
  
  
  
  <div class="form-group form-group-default <?php echo $required;?>">
                
<input type="hidden" class="form-control" name="Gendermm[]">
                
<select id="Gender" name="multipleselect[]" class="form-control <?php echo $required;?>" style="width:400px;"  onChange="getqnmultiple(this.value)">
<option value="">Select  to add Multiple Select Checkboxes  to the Question</option>
<option value="1"> 1</option> 
<option value="2"> 2</option> 
<option value="3"> 3</option>
<option value="4"> 4</option>
<option value="5"> 5</option>

<option value="6"> 6</option>
<option value="7"> 7</option>
<option value="8"> 8</option>
<option value="9"> 9</option>
<option value="10"> 10</option>

      </select>
       <div id="getmultipleselectdiv">  </div>         
                
              </div>
              
              
              
    
 <div class="form-group form-group-default <?php echo $required;?>">   
    <input type="hidden" class="form-control" name="singleselectmm[]">  
    <select id="singleselect" name="singleselect[]" class="form-control <?php echo $required;?>" style="width:400px;" onChange="getqnsingleselect(this.value)">
<option value="">Select  to add radio button  to the Question</option> 
<option value="1"> 1</option> 
<option value="2"> 2</option> 
<option value="3"> 3</option>
<option value="4"> 4</option>
<option value="5"> 5</option>

<option value="6"> 6</option>
<option value="7"> 7</option>
<option value="8"> 8</option>
<option value="9"> 9</option>
<option value="10"> 10</option>
      </select>
  </div>
  
  <div id="getsingleselectdiv">  </div> 

 
  
</td>


<td align="left" valign="top"><div class="form-group form-group-default">
              
                
                <textarea name="qn_number[]" cols="" rows="" id="MyTextBox3mm" required style="width:150px;"><?php echo ($qn_number);?></textarea>
              </div></td>
              
</tr>







</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
<?php }?>
