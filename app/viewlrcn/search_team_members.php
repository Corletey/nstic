<?php
session_start();
require_once('../configlrcn/db_mconfig.php');
$country=$_GET['country'];


$q = $_GET['q'];
//$q = intval($_GET['q']);
$sql="SELECT DISTINCT(emailaddress),piID  FROM ".$prefix."principal_investigators WHERE emailaddress LIKE '%".$q."%' order by emailaddress desc";
$result = $mysqli->query($sql);
$totalUser = $result->num_rows;

if(!$totalUser){echo "$lang_Noteammemberfound";}else{
while($row = $result->fetch_array()) {

	
	?>
<input name="EnterTeamMemberSelected" type="radio" value="<?php echo $row['piID'];?>" /><?php echo $row['emailaddress'];?><br />
<?php }

}
?>
