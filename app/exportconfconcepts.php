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
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Title;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Category;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Date;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Assignedto;?></th>

</tr>

<?php
if($searchResearchers){
$sql = "select * FROM ".$prefix."conceptsasslogs_new where conflictofInterest='Yes' and categorym='concepts' order by assignm_id desc";//and conceptm_status='new' 
}

if(!$searchYearFrom){
$sql = "select * FROM ".$prefix."conceptsasslogs_new where conflictofInterest='Yes' and categorym='concepts' order by assignm_id desc";//and conceptm_status='new' 
}

$rFetch = $mysqli->query($sql);

while ($rFLists2 = $rFetch->fetch_array()){
	
$conceptm_id=$rFLists2['conceptm_id'];
$owner_id=$rFLists2['conceptm_by'];
$conceptm_assignedto=$rFLists2['conceptm_assignedto'];

$queryproposal="select * from ".$prefix."submissions_concepts where conceptID='$conceptm_id'";
$R_proposal=$mysqli->query($queryproposal);	
$rFproposal=$R_proposal->fetch_array();
$researchTypeID=$rFproposal['researchTypeID'];

$queryDistrictsMain="select * from ".$prefix."musers where usrm_id='$conceptm_assignedto'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$rFListsReviewer=$R_DMain->fetch_array();

$queryCategory="select * from ".$prefix."categories where rstug_categoryID='$researchTypeID'";
$R_Category=$mysqli->query($queryCategory);	
$rCategory=$R_Category->fetch_array();
	
echo "<tr>";
////Five
echo "<td>".$rFproposal['projectTitle']."</td>";
echo "<td>".$rCategory['rstug_categoryName']."</td>";
echo "<td>".$rFLists2['assignm_date']."</td>"; 	
echo "<td>".$rFListsReviewer['usrm_sname'].' '.$rFListsReviewer['usrm_fname']."</td>";

echo "</tr>";

}


echo "</table>";
?>
