

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
$grantID=$mysqli->real_escape_string($_GET['grantID']);
if($_POST['doSaveData']=='Proceed' and $id and $grantID){

	

	$AmountofGrantawarded=$mysqli->real_escape_string($_POST['AmountofGrantawarded']);
	$amountvalue=$mysqli->real_escape_string($_POST['amountvalue']);
	
	$TotalCost=$mysqli->real_escape_string($_POST['TotalCost']);
	$conceptID=$mysqli->real_escape_string($_POST['conceptID']);
	$owner_id=$mysqli->real_escape_string($_POST['owner_id']);
	$conceptID=$mysqli->real_escape_string($_POST['conceptID']);
	$currency=$mysqli->real_escape_string($_POST['currency']);
	
	if($amountvalue=='Partial Amount'){$BudgetItem=$mysqli->real_escape_string($_POST['AmountofGrantRequesting']);}
	if($amountvalue=='Full Amount'){$BudgetItem=$AmountofGrantawarded;}
	
$sqlUsers="SELECT * FROM ".$prefix."request_for_funds_main where `conceptID`='$conceptID' and `owner_id`='$owner_id'  and grantID='$grantID' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);

if(!$totalUsers = $QueryUsers->num_rows  and $_POST['AmountofGrantRequesting']<=$_POST['TotalCost']){
$Insert_QR2="insert into ".$prefix."request_for_funds_main (`projectID`,`conceptID`,`owner_id`,`ApprovedGrantTotal`,`BudgetItem`,`DescriptionofExpenditure`,`TotalCOST`,`BalanceonTotalBudget`,`dateRequested`,`receivedBy`,`actionOnRequest`,`requisitioning`,`is_sent`,`currency`,`grantID`) values (NULL,'$conceptID','$owner_id','$AmountofGrantawarded','$BudgetItem','$DescriptionofExpenditure','$TotalCost','$BalanceonTotalBudget',now(),NULL,'Pending','$amountvalue','0','$currency','$grantID')";
$mysqli->query($Insert_QR2);
$record_id = $mysqli->insert_id;



}	

if($record_id){
	echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=RequestforFundsConcept&id=$id&grantID=$grantID'>";
}

if(!$totalUsers = $QueryUsers->num_rows  and $_POST['AmountofGrantRequesting']>=$_POST['TotalCost']){
	$AmountofGrantawarded2=$mysqli->real_escape_string($_POST['AmountofGrantawarded']);
	$error="<div class='error2'>Your requisition amount should be lessthan Approved Grant Total: <b>$AmountofGrantawarded2</b></div>";
}
	
if($totalUsers = $QueryUsers->num_rows  and $_POST['AmountofGrantRequesting']<=$_POST['TotalCost']){
$Insert_QR2="update ".$prefix."request_for_funds_main  set `requisitioning`='$amountvalue',`BudgetItem`='$BudgetItem',`TotalCOST`='$TotalCost' where is_sent='0' and conceptID='$conceptID' and grantID='$grantID'";
$mysqli->query($Insert_QR2);

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=RequestforFundsConcept&id=$id&grantID=$grantID'>";
}

if($totalUsers = $QueryUsers->num_rows  and $_POST['AmountofGrantRequesting']>=$_POST['TotalCost']){
	$AmountofGrantawarded2=$mysqli->real_escape_string($_POST['AmountofGrantawarded']);
	$error="<div class='error2'>Your requisition amount should be lessthan Approved Grant Total: <b>$AmountofGrantawarded2</b></div>";
}

}
?>

<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$wProposal="select * from ".$prefix."submissions_concepts where conceptID='$id' and grantcallID='$grantID'";
$cmProposal = $mysqli->query($wProposal);
$rUProposal=$cmProposal->fetch_array();
$rconceptID=$rUProposal['conceptID'];

$rowner_id=$rUProposal['owner_id'];
$wpi="select * from ".$prefix."musers where usrm_id='$rowner_id'";
$cmpi = $mysqli->query($wpi);
$rpi=$cmpi->fetch_array();

$sqlFunds="SELECT * FROM ".$prefix."request_for_funds_main where conceptID='$id' and `owner_id`='$rowner_id'  and grantID='$grantID' order by id desc limit 0,1";
$QueryFunds = $mysqli->query($sqlFunds);
$TotalFunds=$QueryFunds->num_rows;
$rUFunds=$QueryFunds->fetch_array();

////check to see if our previous submission is NOT pending
$sqlFundsPendingApproval="SELECT * FROM ".$prefix."request_for_funds_main where conceptID='$id' and `owner_id`='$rowner_id'  and grantID='$grantID' and actionOnRequest='Submitted' order by id desc limit 0,1";
$QueryFundsPendingApproval = $mysqli->query($sqlFundsPendingApproval);
$TotalFundsPendingApproval=$QueryFundsPendingApproval->num_rows;
$rUFundsPending=$QueryFundsPendingApproval->fetch_array();

$stripped2=preg_replace('/[^0-9]/', '', $rUProposal['AmountofGrantawarded']);
if($error){echo $error;}
?>


<div id="requestFundsss" class="tabcontentss">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  

    
  <h3>Request for Funds </h3>
<?php if($TotalFundsPendingApproval){?><div class="error2">You have a PENDING request of <b><?php echo numberformat($rUFundsPending['BudgetItem']);?> <?php echo $rUFundsPending['currency'];?></b> . Please wait for approval. Thank You</div> <?php }else{?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 
 <input type="hidden" name="owner_id" value="<?php echo $sessionusrm_id;?>" >
 <input type="hidden" name="conceptID" value="<?php echo $rUProposal['conceptID'];?>" >
 <input type="hidden" name="conceptID" value="<?php echo $rUProposal['conceptID'];?>" >
  <input type="hidden" name="grantID" value="<?php echo $rUProposal['grantcallID'];?>" >
  <input type="hidden" name="AmountofGrantawarded" value="<?php echo $rUProposal['AmountofGrantawarded'];?>" >
  <input type="hidden" name="TotalCost" value="<?php echo $stripped2;?>" >
  <input type="hidden" name="currency" value="<?php echo $rUProposal['currency'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
    

  
    <div class="row success">

    <div class="col-100">
    
    <label for="fname">Project Title: </label>
<?php echo $rUProposal['projectTitle'];?><br />

    <label for="fname">Name of PI: </label>
<?php echo $rpi['usrm_fname'];?> <?php echo $rpi['usrm_sname'];?>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname"><b>Approved Grant Total:</b> <strong style="color:#F00; font-size:18px;"><?php echo numberformat($rUProposal['AmountofGrantawarded']);?> <?php echo $rUProposal['currency'];?></strong></label> <br />
    <?php if($TotalFunds){?><div class="error2">Your request of <b><?php echo numberformat($rUFunds['BudgetItem']);?> <?php echo $rUFunds['currency'];?></b> for <?php echo $rUFunds['requisitioning'];?> is pending completion. Click Proceed to continue.</div> <?php }?>
    
    <label for="fname"><b>Are you requisitioning for full amount or partial amount?</b></label> <br />
    <input name="amountvalue" type="radio" value="Partial Amount" required onChange="getRequestforFunds(this.value)" <?php if($rUFunds['requisitioning']=='Partial Amount'){?>checked="checked"<?php }?>> Partial Amount<br />
    
    <input name="amountvalue" type="radio" value="Full Amount" required onChange="getRequestforFunds(this.value)" <?php if($rUFunds['requisitioning']=='Full Amount'){?>checked="checked"<?php }?>> Full Amount<br />
    
    <div id="requestforfundsdiv">
    <?php if($rUFunds['BudgetItem']){?>
    <label for="fname">State Amount of Grant you are requesting for:</label>
      <input type="number" id="MyTextBox3" name="AmountofGrantRequesting" placeholder="Amount of Grant you are requesting for..." value="<?php echo $rUFunds['BudgetItem'];?>" required style="width:100%;">
    <?php }?>
    </div>
    
    
    
    </div>
  </div>

  

  
  <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="Proceed">
  </div>

</div><!--End-->
 
 
   </form>
 <?php }///No pending request for funds approval
 ?>
 
 
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