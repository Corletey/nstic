<?php $country=$_GET['country'];
if($country=="Yes"){?>
<label for="fname">State the Donors and components they are funding – State Amount<span class="error">*</span><br /></label>

<table width="50%" border="0" id="POITable">
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td>
              <label><strong>Donor</strong></label>
            </td>
            <td>
              <label><strong>Amount</strong></label>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<input type="text" name="StateDonors[]" id="vvv" tabindex="4" class="required" minlength="5" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:220px; background:#ffffff;"/>
            </td>
            <td><input type="text" name="StateAmount[]" id="customss2" tabindex="5" class="required" minlength="3" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:220px; background:#ffffff;"/></td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>
    </table>
<?php }?>