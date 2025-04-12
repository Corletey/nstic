<?php
if($_POST['doSaveData']=='Save' and $_POST['conceptID'] and $id and $_POST['DateRequired'] and $_POST['LocationforDelivery']){

$conceptID=$mysqli->real_escape_string($_POST['conceptID']);
$conceptID=$mysqli->real_escape_string($_POST['conceptID']);
$owner_id=$mysqli->real_escape_string($_POST['owner_id']);

$grantcallID=$mysqli->real_escape_string($_POST['grantID']);
$AmountofGrantawarded=$mysqli->real_escape_string($_POST['AmountofGrantawarded']);
$ProcurementPlanReference=$mysqli->real_escape_string($_POST['ProcurementPlanReference']);
$LocationforDelivery=$mysqli->real_escape_string($_POST['LocationforDelivery']);
$DateRequired=$mysqli->real_escape_string($_POST['DateRequired']);

$sqlUsers="SELECT * FROM ".$prefix."grants_funds where `grantID`='$grantcallID' order by grantID desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
$rUserInvs=$QueryUsers->fetch_array();
		
$BalanceonTotalBudget1=$rUserInvs['BalanceonTotalBudget'];
	///Add education Details
for ($i=0; $i < count($_POST['BudgetItem']); $i++) {
$BudgetItem=$_POST['BudgetItem'][$i];
$DescriptionofExpenditure=$_POST['DescriptionofExpenditure'][$i];
$TotalCost=$_POST['TotalCost'][$i];
$TotalCost2.=$_POST['TotalCost'][$i];
$EstimatedUnitCost=$_POST['EstimatedUnitCost'][$i];

$BalanceonTotalBudget=($BalanceonTotalBudget1-$TotalCost2);

$sqlUsers="SELECT * FROM ".$prefix."request_for_procurement where `conceptID`='$conceptID' and `owner_id`='$owner_id' and  `BudgetItem`='$BudgetItem' and `DescriptionofExpenditure`='$DescriptionofExpenditure' and grantID='$grantcallID' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$totalUsers = $QueryUsers->num_rows and strlen($BudgetItem)>=2){
$Insert_QR2="insert into ".$prefix."request_for_procurement (`projectID`,`conceptID`,`owner_id`,`ApprovedGrantTotal`,`BudgetItem`,`DescriptionofExpenditure`,`TotalCOST`,`EstimatedUnitCost`,`BalanceonTotalBudget`,`dateRequested`,`receivedBy`,`actionOnRequest`,`ProcurementPlanReference`,`LocationforDelivery`,`DateRequired`,`grantID`) values ('$projectID','$conceptID','$owner_id','$AmountofGrantawarded','$BudgetItem','$DescriptionofExpenditure','$TotalCost','$EstimatedUnitCost','$BalanceonTotalBudget',now(),'','Submitted','$ProcurementPlanReference','$LocationforDelivery','$DateRequired','$grantcallID')";
$mysqli->query($Insert_QR2);
}

}
$sqlUsersUpdte="update ".$prefix."grants_funds set `BalanceonTotalBudget`='$BalanceonTotalBudget' where `grantID`='$grantID'";
//$mysqli->query($sqlUsersUpdte);
}
?>
<div class="tab">

  <button class="tablinks" onclick="openCity(event, 'requestFunds')" id="defaultOpen">Request for Procurement</button>

  
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
	
	var inp4 = new_row.cells[4].getElementsByTagName('input')[0];
    inp4.id += len;
    inp4.value = '';
	
	new_row.cells[5].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
}
</script>



<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$wProposal="select * from ".$prefix."submissions_concepts where conceptID='$id'";
$cmProposal = $mysqli->query($wProposal);
$rUProposal=$cmProposal->fetch_array();
$rconceptID=$rUProposal['conceptID'];
$grantcallID=$rUProposal['grantcallID'];

$rowner_id=$rUProposal['owner_id'];
$wpi="select * from ".$prefix."musers where usrm_id='$rowner_id'";
$cmpi = $mysqli->query($wpi);
$rpi=$cmpi->fetch_array();

$sqlUsers="SELECT * FROM ".$prefix."grants_funds where `grantID`='$grantcallID' order by grantID desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
$rUserInvs=$QueryUsers->fetch_array();

$sqlSdd="SELECT * FROM ".$prefix."grantcalls where `grantID`='$grantcallID' order by grantID desc limit 0,1";
$QuerySddd = $mysqli->query($sqlSdd);
$rGrantRef=$QuerySddd->fetch_array();

$sqlProc="SELECT * FROM ".$prefix."request_for_procurement where `owner_id`='$sessionusrm_id' and `conceptID`='$id' and grantID='$grantcallID'";
$QueryProc = $mysqli->query($sqlProc);
$rUserInv2=$QueryProc->fetch_array();
?>


<div id="requestFundsss" class="tabcontentss">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  

    
  <h3><?php echo $lang_RequestforProcurement;?> </h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 
 <input type="hidden" name="owner_id" value="<?php echo $sessionusrm_id;?>" >

 <input type="hidden" name="conceptID" value="<?php echo $rUProposal['conceptID'];?>" >
  <input type="hidden" name="grantID" value="<?php echo $rUProposal['grantcallID'];?>" >
  <input type="hidden" name="AmountofGrantawarded" value="<?php echo $rUProposal['AmountofGrantawarded'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
    
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
    <label for="fname">Approved Grant Total: </label> <?php echo $rUProposal['AmountofGrantawarded'];?>
    </div>
  </div>
 
 <?php /*<div class="row success">

    <div class="col-100">
    <label for="fname">Available Budget:</label>
<?php echo $rUserInv2['BalanceonTotalBudget'];?>
    </div>
  </div><?php */?>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">Procurement Plan Reference:   <span class="error">*</span></label>
<input name="ProcurementPlanReference" type="text" value="<?php echo $rGrantRef['shortacronym'];?>/<?php echo $rGrantRef['grantID'];?>" class="required" required/>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="fname">Location for Delivery:   <span class="error">*</span></label>
<input name="LocationforDelivery" type="text" value="<?php echo $rUserInv2['LocationforDelivery'];?>" class="required" required/>
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="fname">Date Required:   <span class="error">*</span></label>
<input name="DateRequired" type="date" value="<?php echo $rUserInv2['DateRequired'];?>" class="required" style="width:100%;" required/>
    </div>
  </div>
  
  

  
  
  
  
   <div class="row success">

    <div class="col-100">

<?php
 
   if($category=='RequestforProcurementDelConcept' and $_GET['fid']){
    $fid=$_GET['fid'];
	$sqlA2Protocol2="delete from ".$prefix."request_for_procurement where id='$fid' and grantID='$grantcallID'";
	$mysqli->query($sqlA2Protocol2);
	
	
	echo $message='<p class="error2">Dear '.$session_fullname.', Budget Item has been successfully removed.</p>';
	}
	?>
 <h3>Details relating to the Procurement</h3>
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
$sqlconceptID="SELECT * FROM ".$prefix."request_for_procurement where `owner_id`='$sessionusrm_id' and `conceptID`='$id'";
$QueryconceptID = $mysqli->query($sqlconceptID);
while($rUserconceptID=$QueryconceptID->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td>
              <label><?php echo $rUserconceptID['BudgetItem'];?></label>
            </td>
            <td>
              <label><?php echo $rUserconceptID['DescriptionofExpenditure'];?></label>
            </td>
            <td>
              <label><?php echo $rUserconceptID['EstimatedUnitCost'];?></label>
            </td>
            
            <td>
              <label><?php echo $rUserconceptID['TotalCOST'];?></label>
            </td>
            
            <td><a href="main.php?option=RequestforProcurementDelConcept&id=<?php echo $rUserconceptID['conceptID'];?>&fid=<?php echo $rUserconceptID['id'];?>&grantID=<?php echo $grantcallID;?>"  style="background-color:#F00; color:#fff;padding:5px;" onclick="return confirm('Are you sure you want to delete this Budget Item?');">Remove </a></td>
            <td>&nbsp;</td>
        </tr>
        <?php }?>
    </table>
    
        </div>
  </div>
  
  
  <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="Save">
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