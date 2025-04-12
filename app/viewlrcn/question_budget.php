<?php 
$country=$_GET['country'];?>

<table width="100%" border="0">
  <tr>
    <td>Add Budget Percentage Ceiling</td>

  </tr>
</table>

<?php 
if($country=="1"){
?>
<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem" style="border-top:1px solid #000;">
   <tr>
    <td width="37" valign="top"><p align="center"><strong>&nbsp;</strong></td>
    <td width="256" valign="top"><p align="center"><strong><?php echo $lang_new_Item;?></strong></td>
    <td valign="top"><p align="center"><strong><?php echo $lang_new_PercentageCeiling;?></strong></td>
    </tr>
  <tr>
    <td width="35" valign="top">1. &nbsp;</td>
    <td width="241" valign="top">Personnel</td>
    <td width="86" valign="top" class="txtalign" align="center"><input type="text" id="PersonnelTotal" name="PersonnelTotal[]" class="requiredm number" value="8" required></td>
  </tr>
  <tr>
    <td width="35" valign="top">2. &nbsp;</td>
    <td width="241" valign="top">Research Costs</td>
    <td width="86" valign="top" class="txtalign" align="center"><input type="text" id="ResearchCosts" name="ResearchCosts[]" class="requiredm number" value="60" required></td>
  </tr>
  <tr>
    <td width="35" valign="top">3. &nbsp;</td>
    <td width="241" valign="top">Equipment</td>
    <td width="86" valign="top" class="txtalign" align="center"><input type="text" id="Equipment" name="Equipment[]" class="requiredm number" value="15" required></td>
  </tr>
<tr>
    <td width="35" valign="top">4. &nbsp;</td>
    <td width="241" valign="top">Travel and Subsistence</td>
    <td width="86" valign="top" class="txtalign" align="center"><input type="text" id="TravelandSubsistence" name="TravelandSubsistence[]" class="requiredm number" value="15" required></td>
  </tr>
  <tr>
    <td width="35" valign="top">5. &nbsp;</td>
    <td width="241" valign="top">Grant kick-off, mid-term and final workshops</td>
    <td width="86" valign="top" class="txtalign" align="center"><input type="text" id="Grantkickoff" name="Grantkickoff[]" class="requiredm number" value="2" required></td>
  </tr>
  <tr>
    <td width="35" valign="top">6. &nbsp;</td>
    <td width="241" valign="top">Knowledge Sharing and Research Uptake</td>
    <td width="86" valign="top" class="txtalign" align="center"><input type="text" id="KnowledgeSharing" name="KnowledgeSharing[]" class="requiredm number" value="5" required></td>
  </tr>
  <tr>
    <td width="35" valign="top">7. &nbsp;</td>
    <td width="241" valign="top">Overhead costs</td>
    <td width="86" valign="top" class="txtalign" align="center"><input type="text" id="Overheadcosts" name="Overheadcosts[]" class="requiredm number" value="5" required></td>
  </tr>
  <tr>
    <td width="35" valign="top">8. &nbsp;</td>
    <td width="241" valign="top">Other goods and services<br>
      Others (Specify)</td>
    <td width="86" valign="top" class="txtalign" align="center"><input type="text" id="Othergoods" name="Othergoods[]" class="requiredm number" value="2" required></td>
  </tr>
  
  
  <tr>
    <td width="35" valign="top">9. &nbsp;</td>
    <td width="241" valign="top">Matching Support if any</td>
    <td width="86" valign="top" class="txtalign" align="center"><input type="text" id="MatchingSupport" name="MatchingSupport[]" class="requiredm number" value="1" required></td>
  </tr>
  
  <tr>
    <td width="35" valign="top">&nbsp;</td>
    <td width="241" valign="top"><p align="center"><strong>TOTAL</strong></td>
    <td width="86" align="center" valign="top"><strong>100</strong></td>
  </tr>
</table>
<?php }?>

<?php 
if($country=="2"){
?>
<?php }?>
