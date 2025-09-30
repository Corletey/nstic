<?php
session_start(); error_reporting(1);
require_once('contrlrcn/c_mlsrcontrol.php'); 
$timestamp=date("Ymdhsi");//xlsx
header('Content-Type: application/octet-stream');
header("Content-Type: application/force-download");
header("Content-Type: application/x-msdownload");
header("Content-Disposition: attachment; filename=".$timestamp.".xls");
header("Pragma: no-cache");
header("Expires: 0");

$searchResearchers=$mysqli->real_escape_string($_GET['searchResearchers']);

?>

<table border="1" align="center" style="width:50%;">

<tr>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Name;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Gender;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Contacts;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Expertise;?></th>

</tr>

<?php
if($searchResearchers){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."principal_investigators  where (Surname like '%$searchResearchers' OR Expertise like '%$searchResearchers%' OR emailaddress like '%$searchResearchers%') order by piID desc";//and conceptm_status='new' 
}

if(!$searchYearFrom){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."principal_investigators order by piID desc";//and conceptm_status='new' 
}

$rFetch = $mysqli->query($sql);

while ($rFLists2 = $rFetch->fetch_array()){
	
	
echo "<tr>";
////Five
echo "<td>".$rFLists2['Surname'].' '.$rFLists2['Othername']."</td>";
echo "<td>".$rFLists2['Gender']."</td>";
echo "<td>".$rFLists2['Contacts'].' | '.$rFLists2['emailaddress']."</td>"; 	
echo "<td>".$rFLists2['Expertise']."</td>";

echo "</tr>";

}


echo "</table>";
?>
