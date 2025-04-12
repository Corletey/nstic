<?php $country=$_GET['country'];
if($country=="Yes"){?>
<label for="fname">Name the Projects and the objectives. (Max 3 Projects) <span class="error">*</span><br /></label>


<table width="100%" border="0" id="POITable2">
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td>
              <label><strong>Project Name</strong></label>
            </td>
            <td>
              <label><strong>Objectives</strong></label>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<!----><input type="hidden" name="f1" id="vvv" tabindex="4" class="required" minlength="5"/>

<textarea id="projectNamed" name="projectName[]" placeholder="" style="height:60px;width:450px;" class="required"></textarea>

            </td>
            <td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
            <textarea id="projectObjectivess" name="projectObjectives[]" placeholder="" style="height:60px;width:450px;" class="required"></textarea>
      
      </td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow2(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow2()" style="font-size:12px;"/></td>
        </tr>
    </table>
   <?php }?>