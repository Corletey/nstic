
<script type="text/javascript">
var total = 0;
function getValues() {
var qty = 0;
var rate = 0;
var obj = document.getElementsByTagName("input");
      for(var i=0; i<obj.length; i++){

         if(obj[i].name == "amount[]"){var amount = obj[i].value;}
         if(obj[i].name == "amount[]"){
          		if(amount > 0){//obj[i].value = qty*rate; 
				total+=(obj[i].value*1);}
          				else{obj[i].value = 0;total+=(obj[i].value*1);}
          		}
         			
         	 }
        document.getElementById("total").value = addCommas(total*1);
        total=0;
}
</script>
<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$_GET['categoryID'];

if($_POST['doSaveBudget']=='Save' and $_POST['questionID']){
	
		$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
$questionID=$mysqli->real_escape_string($_POST['questionID']);
///initialtotalBudget
	
for ($i=0; $i < count($_POST['item']); $i++ and $_POST['TotalSubmitted']) {
$item=$mysqli->real_escape_string($_POST['item'][$i]);
$amount=$mysqli->real_escape_string($_POST['amount'][$i]);
$percentage=$mysqli->real_escape_string($_POST['percentage'][$i]);
$ceiling_id=$mysqli->real_escape_string($_POST['ceiling_id'][$i]);
$budget_id=$mysqli->real_escape_string($_POST['budget_id'][$i]);
$MaximumBudget=$mysqli->real_escape_string($_POST['TotalSubmitted']);

$sqldropdown="SELECT * FROM ".$prefix."dynamic_budget_ceilings_answers where `grantID`='$id' and owner_id='$sessionusrm_id' and `item`='$item' and is_sent='0' order by id desc limit 0,1";
$Querydropdown = $mysqli->query($sqldropdown);
if(!$Querydropdown->num_rows){
$sqldropdown = "INSERT INTO ".$prefix."dynamic_budget_ceilings_answers (`ceiling_id`,`item`,`amount`,`percentage`,`maximum_budget`,`categoryID`,`status`,`categorym`,`grantID`,`questionID`,`owner_id`,`is_sent`) VALUES ('$ceiling_id','$item','$amount','$percentage','$MaximumBudget','$categoryID','new','concept','$id','$questionID','$sessionusrm_id','0')";
$mysqli->query($sqldropdown);
}
if($Querydropdown->num_rows and $sessionusrm_id and $amount){
$sqlA44="update ".$prefix."dynamic_budget_ceilings_answers set amount='$amount' where `grantID`='$id' and owner_id='$sessionusrm_id' and `ceiling_id`='$ceiling_id' and is_sent='0' and id='$budget_id'";
$mysqli->query($sqlA44);
}
}// end addattachments




 ////////////////Check if any record was added

//Insert into Submission Stages
//Insert into Submission Stages
$wm="select * from ".$prefix."dynamic_concept_stages where  categoryID='$maincategoryID' and owner_id='$sessionusrm_id' and status='new' and grantID='$id' order by id desc";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$record_id2;
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."dynamic_concept_stages (`categoryID`,`owner_id`,`status`,`grantID`,`is_sent`,`dconceptID`)  values('$maincategoryID','$sessionusrm_id','new','$id','0','$mdconceptID')";
$mysqli->query($sqlASubmissionStages);
//Reload After saving
//Reload After saving
echo '<meta http-equiv="REFRESH" content="0;url='.$base_url.'main.php?option=SubmitConceptDynamic&id='.$id.'&categoryID='.$maincategoryID.'">';
}

 
 


}//end post

$sqlUsers2="SELECT * FROM ".$prefix."dynamic_budget_answers where `owner_id`='$sessionusrm_id' and `is_sent`='0' and conceptID='$id' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();
$TotalBudget=$rUserInv2['initialtotalBudget'];

//dynamic_budget_ceilings
$sqltotalAmount="SELECT * FROM ".$prefix."dynamic_budget_ceilings where categoryID='$maincategoryID' and grantID='$id' order by id desc limit 0,1";
$QueryAmount = $mysqli->query($sqltotalAmount);
$ramount=$QueryAmount->fetch_array();
$TotalBudget=$ramount['maximum_budget'];

?>

 <?php



?>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="usrm_id" value="<?php echo $_SESSION['usrm_id'];?>" >
 
<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
   <tr>
    <td width="37" valign="top"><p align="center"><strong>&nbsp;</strong></td>
    <td width="256" valign="top"><p align="center"><strong><?php echo $lang_new_Item;?></strong></td>
    <td width="530" valign="top"><p align="center"><strong><?php echo $lang_new_Amount;?> (<?php echo $TotalBudget;?>)</strong></td>
    <td valign="top"><p align="center"><strong><?php echo $lang_new_PercentageCeiling;?></strong></td>
    <td valign="top"><p align="center"><strong><?php echo $lang_new_MaAllowableAmount;?></strong></td>
    </tr>
    
   <?php
   $count=0;
   $sqltotalAmount2="SELECT * FROM ".$prefix."dynamic_budget_ceilings where categoryID='$maincategoryID' and grantID='$id' and categorym='concept' order by id asc limit 0,20";
$QueryAmount2 = $mysqli->query($sqltotalAmount2);
while($rUserInv2=$QueryAmount2->fetch_array()){
	$count++;
	$questionID=$rUserInv2['questionID'];
	$ceiling_id=$rUserInv2['id'];
	
$sqltotalAmount3="SELECT * FROM ".$prefix."dynamic_budget_ceilings_answers where categoryID='$maincategoryID' and grantID='$id' and questionID='$questionID' and  	categorym='concept' and ceiling_id='$ceiling_id' and owner_id='$sessionusrm_id' and is_sent='0'";
$QueryAmount3 = $mysqli->query($sqltotalAmount3);
$rUserInv3=$QueryAmount3->fetch_array();
	
	
	
	$TotalBudget2=$rUserInv2['maximum_budget'];
	
	$percentate=($rUserInv2['percentage']/100);
	 
	 
$mmPersonnelTotal=($TotalBudget2*$percentate);
/*$mmResearchCosts=($TotalBudget*0.6);
$mmEquipmentTotal=($TotalBudget*0.15);
$mmTravel=($TotalBudget*0.02);
$mmkickoff=($TotalBudget*0.02);
$mmKnowledgeSharing=($TotalBudget*0.05);
$mmOverheadCostsTotal=($TotalBudget*0.05);
$mmOtherGoods=($TotalBudget*0.02);
$mmMatchingSupport=($TotalBudget*0.01);*/
$ItemCount=$rUserInv2['item'];
$normalpercentage=$rUserInv2['percentage'];
$wordamount=numberformat($mmPersonnelTotal);
$wordings="$ItemCount costs should not exceed $normalpercentage % of the total budget which is $wordamount";

$fakeAmount=($mmPersonnelTotal+1000);


?> 
  <tr>
    <td width="35" valign="top"><?php echo $count;?>. &nbsp;</td>
    <td width="241" valign="top"><?php echo $rUserInv2['item'];?>
    <input name="item[]" type="hidden" value="<?php echo $rUserInv2['item'];?>" />
    <input name="ceiling_id[]" type="hidden" value="<?php echo $rUserInv2['id'];?>" />
    <input name="questionID" type="hidden" value="<?php echo $rUserInv2['questionID'];?>" />
    <input name="budget_id[]" type="hidden" value="<?php echo $rUserInv3['id'];?>" />
    </td>
    <td width="561" valign="top">
<?php /*?><script type="text/javascript">
function fnc(value, min, max) 
{
    if(parseInt(value) < 0 || isNaN(value)) 
        return 0; 
    else if(parseInt(value)><?php echo ($mmPersonnelTotal);?>) 
        return "Amount is exceeding Maximum allowed. <?php echo ($mmPersonnelTotal);?>"; 
    else return value;
}
</script>


<input type="text" id="amount" name="amount[]" placeholder="<?php echo $rUserInv2['item'];?>" class="requiredm number" value="<?php echo $rUserInv3['amount'];?>" maxlength="<?php echo $mmPersonnelTotal;?>" required onkeyup="this.value = fnc(this.value, 0, <?php echo $mmPersonnelTotal;?>)"><?php */?>

<script type="text/javascript">
function imposeMinMax(el){
  if(el.value != ""){
    if(parseInt(el.value) < parseInt(el.min)){
      el.value = el.min;
    }
    if(parseInt(el.value) > parseInt(el.max)){
      el.value = el.max;
    }
  }
}</script>
<input type="text" id="amount" name="amount[]" placeholder="<?php echo $rUserInv2['item'];?>" class="requiredm number" value="<?php echo $rUserInv3['amount'];?>" min=1 max="<?php echo $mmPersonnelTotal;?>" required onkeyup=imposeMinMax(this)>

    
    </td>
    
    <td width="86" valign="top" class="txtalign" align="center"><?php echo $rUserInv2['percentage'];?></td>
    <td width="144" valign="top">
    <input type="text" id="PersonnelTotal" name="percentage[]" placeholder=".." class="requiredm number" value="<?php echo ($mmPersonnelTotal);?>" required  readonly="readonly"></td>
  </tr>
  <?php $taotal=($rUserInv2['percentage']+$taotal);
  $SumTotal=($mmPersonnelTotal+$SumTotal);
  $userTotal=($rUserInv3['amount']+$userTotal);
  }?>

  <tr>
    <td width="35" valign="top">&nbsp;</td>
    <td width="241" valign="top"><p align="center"><strong>TOTAL</strong></td>
    <td width="561" valign="top"><strong>
    
    <?php if($userTotal){?><input type="text" id="total" name="totalAmount" placeholder=".." class="required number" value="<?php echo $userTotal;?>" onkeyup="figure(this.value)"><?php }?>
    </strong></td>
    <td width="86" align="center" valign="top"><strong><?php echo $taotal;?></strong></td>
    <td width="144" valign="top"><input type="text" id="TotalSubmitted" name="TotalSubmitted" placeholder=".." class="required number" value="<?php echo $SumTotal;?>" ></td>
  </tr>
</table>

 <div class="rightm">
    <input type="submit" name="doSaveBudget" value="Save">
    </div>
    </form>