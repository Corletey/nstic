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
    <input type="submit" name="doSaveDynamicData" value="Save">
  </div>