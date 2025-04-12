<?php
require_once('../configlrcn/db_mconfig.php');
$country=$_GET['country'];
if($country=='Partial Amount'){
?>

<div class="row success">

    <div class="col-100">
    <label for="fname">State Amount of Grant you are requesting for:</label>
      <input type="number" id="MyTextBox3" name="AmountofGrantRequesting" placeholder="Amount of Grant you are requesting for..." value="" required style="width:100%;">
    </div>
  </div>
  
   
  
<?php }
if($country=='no'){}

?>

