<?php
require_once('../configlrcn/db_mconfig.php');

$country=$_GET['country'];?>


<select id="country" name="projectDurationID" class="required">
       <?php
$sqlFeaturedCall = "SELECT * FROM ".$prefix."duration where yearID='$country' order by durationID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
while($rFeaturedCall = $queryFeaturedCall->fetch_array()){
?>
<option value="<?php echo $rFeaturedCall['durationID'];?>"><?php echo $rFeaturedCall['duration'];?> <?php echo $rFeaturedCall['durationdesc'];?></option>
<?php }?>
      </select>