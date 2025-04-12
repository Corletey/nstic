<?php
session_start();
require_once('../configlrcn/db_mconfig.php');
$country=$_GET['country'];


$q = $_GET['q'];
//$q = intval($_GET['q']);
$sql="SELECT * FROM ".$prefix."dynamic_categories_main WHERE category_name LIKE '%".$q."%'";
$result = $mysqli->query($sql);
$totalUser = $result->num_rows;

if(!$totalUser){echo "No Theme/category found related to the one you have entered";}else{
while($row = $result->fetch_array()) {?>
    
<input name="categoryExist" type="text" value="<?php echo $row['category_name'];?>"/>
<?php }

}
?>
