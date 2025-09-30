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

$en=$mysqli->real_escape_string($_GET['en']);

?>

<table border="1" align="center" style="width:50%;">

<tr>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_new_HostInstitution;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_GrantsAwarded;?></th>

</tr>

<?php
$sql = "select * FROM ".$prefix."submissions_proposals where awarded='Yes' order by projectTitle asc";//and conceptm_status='new' 
$rFetch = $mysqli->query($sql);

while ($rFLists2 = $rFetch->fetch_array()){


	
////Five
echo "<td>".$rFLists2['HostInstitution']."</td>";




echo "<td>".numberformat($rFLists2['AmountofGrantawarded']).' '.$rFLists2['currency']."</td>";
 	

echo "</tr>";

}


echo "</table>";
?>
