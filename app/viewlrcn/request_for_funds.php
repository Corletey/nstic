<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$grantID=$mysqli->real_escape_string($_GET['grantID']);
if($_POST['doSaveData']=='Save' and $sessionusrm_id and $id and $grantID){
  $TotalBudgetm=$_POST['TotalBudget'];
  
  $sqlUsers="SELECT * FROM ".$prefix."request_for_funds_main where `projectID`='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
$TotalFunds=$QueryUsers->num_rows;
$rpData=$QueryUsers->fetch_array();
$TotalBudget = floatval($rpData['BudgetItem']);

// First get all existing costs from database
$sqlExistingCosts = "SELECT TotalCOST FROM ".$prefix."request_for_funds 
                     WHERE owner_id='$sessionusrm_id' 
                     AND projectID='$id' 
                     AND grantID='$grantID'";
$QueryExistingCosts = $mysqli->query($sqlExistingCosts);
$existingTotal = 0;

// Sum up all existing costs
while($row = $QueryExistingCosts->fetch_array()) {
    $existingTotal += floatval($row['TotalCOST']); // Simply convert varchar to float
}

// Get costs from request_for_procurement table
$sqlProcurementCosts = "SELECT TotalCost FROM ".$prefix."request_for_procurement 
                       WHERE owner_id='$sessionusrm_id' 
                       AND projectID='$id' 
                       AND grantID='$grantID'";
$QueryProcurementCosts = $mysqli->query($sqlProcurementCosts);
$procurementTotal = 0;

// Sum up costs from request_for_procurement
while($row = $QueryProcurementCosts->fetch_array()) {
    $procurementTotal += floatval($row['TotalCost']);
}

// Total of existing costs from both tables
$totalExistingCosts = $existingTotal + $procurementTotal;


// Calculate new entries total
$sumTotalCost = 0;
if(isset($_POST['TotalCost'])) {
    foreach ($_POST['TotalCost'] as $cost) {
        $sumTotalCost += floatval($cost);
    }
}

// Add existing total to new total
$grandTotal = $sumTotalCost + $totalExistingCosts;

// Check if grand total exceeds budget
if ($grandTotal > $TotalBudget) {
    $message = '<p class="error2">Total cost (' . number_format($grandTotal, 2) . ') exceeds the requested budget of ' . number_format($TotalBudget, 2) . '. 
                <br>Existing costs from Funds: ' . number_format($existingTotal, 2) . 
                '<br>Existing costs from Procurement: ' . number_format($procurementTotal, 2) . 
                '<br>New costs: ' . number_format($sumTotalCost, 2) . '</p>';
} else {

for ($i=0; $i < count($_POST['BudgetItem']); $i++) {
$BudgetItem=$_POST['BudgetItem'][$i];
$DescriptionofExpenditure=$_POST['DescriptionofExpenditure'][$i];
$TotalCost=$_POST['TotalCost'][$i];
$TotalCost2.=$_POST['TotalCost'][$i];
$EstimatedUnitCost=$_POST['EstimatedUnitCost'][$i];

$BalanceonTotalBudget=('0');

  $mainFunds_id=$mysqli->real_escape_string($_POST['mainFunds_id']);
  
$sqlUsers="SELECT * FROM ".$prefix."request_for_funds where `owner_id`='$sessionusrm_id' and `projectID`='$id' and grantID='$grantID'  and BudgetItem='$BudgetItem' order by id desc limit 0,1";
    $QueryUsers = $mysqli->query($sqlUsers);
    $totalUsers = $QueryUsers->num_rows;
    $rUserInv=$QueryUsers->fetch_array();
///Check total submitted budget
$totalsubmittedbyUser=($Personnel+$ResearchCosts+$Equipment+$kickoff+$Travel+$KnowledgeSharing);
  
if(!$totalUsers and $sessionusrm_id){

$Insert_QR2="insert into ".$prefix."request_for_funds (`projectID`,`conceptID`,`owner_id`,`ApprovedGrantTotal`,`BudgetItem`,`DescriptionofExpenditure`,`TotalCOST`,`EstimatedUnitCost`,`BalanceonTotalBudget`,`dateRequested`,`receivedBy`,`actionOnRequest`,`ProcurementPlanReference`,`LocationforDelivery`,`DateRequired`,`mainFunds_id`,`actionStatus`,`is_sent`,`currency`,`grantID`) 

values ('$id',NULL,'$sessionusrm_id','$AmountofGrantawarded','$BudgetItem','$DescriptionofExpenditure','$TotalCost','$EstimatedUnitCost','$BalanceonTotalBudget',now(),NULL,'Pending','$ProcurementPlanReference','$LocationforDelivery','$DateRequired','$mainFunds_id','Pending','0',NULL,'$grantID')";
$mysqli->query($Insert_QR2);
$record_id .= $mysqli->insert_id;

}
 }
if ($record_id >= 1) {
            $message = '<p class="success">Dear ' . $session_fullname . ', details have been submitted. Proceed to continue.</p>';
            logaction("$session_fullname created Budget");
        } else {
            $message = '<p class="error2">Details have not been saved. Re-enter and submit again.</p>';
        }
    }
}
echo $message;
?>
<div class="tab">

  <button class="tablinks" onclick="openCity(event, 'requestFunds')" id="defaultOpen">Request for Funds</button>

  
</div>

<script>
function deleteRow(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable').deleteRow(-1);
  //document.getElementById("myTable").deleteRow(0);
}


function insRow()
{
    console.log( 'hi');
    var x=document.getElementById('POITable');
    var new_row = x.rows[1].cloneNode(true);
    var len = x.rows.length;
    new_row.cells[0].innerHTML = len;
    
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.value = '';
  /**/var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = '';
    
  var inp3 = new_row.cells[3].getElementsByTagName('input')[0];
    inp3.id += len;
    inp3.value = '';
  
  new_row.cells[4].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
}
</script>



<?php
if($category=='RequestforFundsDel' and $fid){
$wProposalDel="delete from ".$prefix."request_for_funds where id='$fid' and conceptID='$id' and grantID='$grantID'";
$mysqli->query($wProposalDel);  
}
$sessionusrm_id=$_SESSION['usrm_id'];
$wProposal="select * from ".$prefix."submissions_proposals where projectID='$id'";
$cmProposal = $mysqli->query($wProposal);
$rUProposal=$cmProposal->fetch_array();
$rconceptID=$rUProposal['conceptID'];

$rowner_id=$rUProposal['owner_id'];
$wpi="select * from ".$prefix."musers where usrm_id='$rowner_id'";
$cmpi = $mysqli->query($wpi);
$rpi=$cmpi->fetch_array();

$sqlUsers="SELECT * FROM ".$prefix."request_for_funds_main where `projectID`='$id' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
$TotalFunds=$QueryUsers->num_rows;
$rpData=$QueryUsers->fetch_array();
$TotalBudget = floatval($rpData['BudgetItem']);

$sqlUsers22="SELECT * FROM ".$prefix."request_for_funds where `owner_id`='$sessionusrm_id' and `projectID`='$id' order by id desc limit 0,1";
    $QueryUsers22 = $mysqli->query($sqlUsers22);
    $totalUsers22 = $QueryUsers22->num_rows;
    $rUserInv2=$QueryUsers22->fetch_array();
    
    
?>


<div id="requestFundsss" class="tabcontentss">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
<?php if($TotalFunds and $totalUsers22){?><div class="error2" style="text-transform:uppercase;">Your request of <b><?php echo numberformat($rpData['BudgetItem']);?> <?php echo $rUFunds['currency'];?></b> for <?php echo $rpData['requisitioning'];?> is pending completion. Click Submit Now to Finish.</div> <?php }?>
    
  <h3><?php echo $lang_RequestforFunds;?> </h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 
 <input type="hidden" name="owner_id" value="<?php echo $sessionusrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUProposal['projectID'];?>" >
 <input type="hidden" name="conceptID" value="<?php echo $rUProposal['conceptID'];?>" >
  <input type="hidden" name="grantID" value="<?php echo $rUProposal['grantcallID'];?>" >
  <input type="hidden" name="mainFunds_id" value="<?php echo $rpData['id'];?>" >
  <input type="hidden" name="AmountofGrantawarded" value="<?php echo $rUProposal['AmountofGrantawarded'];?>" >
  <input type="hidden" name="currency" value="<?php echo $rUFunds['currency'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
    
     
 <div class="row success" style="margin-bottom:15px;">

    <div class="col-100">
     <label for="lname"><strong>Total Budget Submitted</strong> <span class="error">*</span></label>
      <input type="hidden" id="TotalBudget" name="TotalBudget" placeholder=".." class="requiredm number"  value="<?php echo numberformat($rpData['BudgetItem']);?>">
      
       <input type="text" id="TotalBudgetmm" name="TotalBudgetmm" placeholder=".." class="requiredm number"  value="<?php echo numberformat($rpData['BudgetItem']);?> <?php echo $rpData['currency'];?>" required readonly="readonly" style="background:#F60; color:#ffffff;">
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="fname">Project Title: </label>
<?php echo $rUProposal['projectTitle'];?>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="fname">Name of PI: </label>
<?php echo $rpi['usrm_fname'];?> <?php echo $rpi['usrm_sname'];?>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Approved Grant Total: </label> <strong style="color:#F00; font-size:16px;"><?php echo numberformat($rUProposal['AmountofGrantawarded']);?> <?php echo $rUProposal['currency'];?></strong>
    </div>
  </div>

  
   <div class="row success">

    <div class="col-100">


    
    <?php
 $mmPersonnelTotal=($TotalBudget*0.08);
$mmResearchCosts=($TotalBudget*0.6);
$mmEquipmentTotal=($TotalBudget*0.15);
$mmTravel=($TotalBudget*0.02);
$mmkickoff=($TotalBudget*0.02);
$mmKnowledgeSharing=($TotalBudget*0.05);
$mmOverheadCostsTotal=($TotalBudget*0.05);
$mmOtherGoods=($TotalBudget*0.02);
$mmMatchingSupport=($TotalBudget*0.01);

?>

<table width="50%" border="0" id="POITable">
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <th>Budget Item</th>
            <th>Description </th>
            <th>Estimated Unit Cost</th>
             <th>Total Cost</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr><?php
//$sqlwwScores2 = "select * FROM ".$prefix."concept_budget where owner_id='$rowner_id' and conceptID='$rconceptID' order by id desc";
//$resultwwScores2 = $mysqli->query($sqlwwScores2);
//while($rFListsScores2=$resultwwScores2->fetch_array()){
?>
            <td style=" display:none;">1</td>
            <td>
<input type="hidden" name="BudgetItem1[]" id="vvv" tabindex="4" class="requiredd" minlength="5" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:220px; background:#ffffff;"/>

<select name="BudgetItem[]" id="BudgetItem">
<option value="">Please Select</option>
<option value="Personnel">Personnel</option>
<option value="Research Costs">Research Costs</option>
<option value="Equipment">Equipment</option>
<option value="Travel and Subsistence">Travel and Subsistence</option>
<option value="Grant kick-off, mid-term and final workshops">Grant kick-off, mid-term and final workshops</option>
<option value="Knowledge Sharing and Research Uptake">Knowledge Sharing and Research Uptake</option>
<option value="Overhead Costs">Overhead Costs</option>
<option value="Other goods and services">Other goods and services</option>
<option value="MatchingSupport">Matching Support if any</option>
</select>


            </td>
            <td><input type="text" name="DescriptionofExpenditure[]" id="customss2" tabindex="5" class="requiredd" minlength="3" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:220px; background:#ffffff;"/></td>
            
            <td><input type="number" name="EstimatedUnitCost[]" id="customss2" tabindex="5" class="requiredd" minlength="3" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:220px; background:#ffffff;"/></td>
            
            <td><input type="number" name="TotalCost[]" id="customss2" tabindex="5" class="requiredd" minlength="3" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:220px; background:#ffffff;"/></td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>
        
    <?php 
$sqlProjectID="SELECT * FROM ".$prefix."request_for_funds where `owner_id`='$sessionusrm_id' and `projectID`='$id' and grantID='$grantID'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td>
              <label><?php echo $rUserProjectID['BudgetItem'];?></label>
            </td>
            <td>
              <label><?php echo $rUserProjectID['DescriptionofExpenditure'];?></label>
            </td>
            <td>
              <label><?php echo $rUserProjectID['EstimatedUnitCost'];?></label>
            </td>
            
            <td>
              <label><?php echo $rUserProjectID['TotalCOST'];?></label>
            </td>
            
            <td><a href="main.php?option=RequestforFundsDel&id=<?php echo $rUserProjectID['projectID'];?>&fid=<?php echo $rUserProjectID['id'];?>"  style="background-color:#F00; color:#fff;padding:5px;" onclick="return confirm('Are you sure you want to delete this Budget Item?');">Remove </a></td>
            <td>&nbsp;</td>
        </tr>
        <?php }?>
    </table>


    
        </div>
  </div>
  
  
  <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="Save" style="margin-right:10px;">
    
    <?php if($totalUsers22){?><input type="button" name="doSubmit" value="<?php echo $lang_submit_now;?>"  onClick="window.location.href='./main.php?option=RequestforFundsFinal&id=<?php echo $id;?>&grantID=<?php echo $grantID;?>'" style="margin-right:10px; float:right; padding:8px;" class="btn-info-purple"><?php }?>
    
   <!-- onclick="return confirm('Are you sure you want to submit? Click OK to continue or CANCEL to save, edit and submit later.');"!-->
  </div>

</div><!--End-->
 
 
   </form>
 
 
 
</div>









<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>