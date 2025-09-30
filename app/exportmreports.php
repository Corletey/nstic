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
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Title;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Name;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Date;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Assignedto;?></th>

</tr>

<?php
if($en=="Monitoring"){
$sql = "select * FROM ".$prefix."monitoring_reports where category='Monitoring'  order by id desc";//and conceptm_status='new' 
}
if($en=="Technical"){
$sql = "select * FROM ".$prefix."monitoring_reports where category='Technical'  order by id desc";//and conceptm_status='new' 
}
if($en=="Financial"){
$sql = "select * FROM ".$prefix."monitoring_reports where category='Financial'  order by id desc";//and conceptm_status='new' 
}
$rFetch = $mysqli->query($sql);

while ($rFLists2 = $rFetch->fetch_array()){
	
$owner_id=$rFLists2['owner_id'];
$protocol_id=$rFLists2['protocol_id'];
$conceptID=$rFLists2['conceptID'];

	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$owner_id'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();

$queryproposal="select * from ".$prefix."submissions_proposals where projectID='$protocol_id'";
$R_proposal=$mysqli->query($queryproposal);	
$rFproposal=$R_proposal->fetch_array();
	
echo "<tr>";
////Five
echo "<td>".$rFproposal['projectTitle']."</td>";
echo "<td>".$rFLists2['filename']."</td>";
echo "<td>".$rFLists2['docDate']."</td>"; 	
echo "<td>".$rFLists2['Version']."</td>";

echo "</tr>";

}


echo "</table>";
?>
