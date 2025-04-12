<?php
require_once('../configlrcn/db_mconfig.php');

$country=$_GET['country'];
$startYear=($country)?>

  <select name="YearofDeparture[]" id="ssss" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:100px;" required>
<option value="">Year</option>
<?php
define('DOB_YEAR_START', $startYear);

$current_year = date('Y')+0;
?>
 <option value="To date">To date</option>
 <?php
for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
    <option value="<?php echo $count;?>"><?php echo $count;?></option>
<?php }?>

  </select>