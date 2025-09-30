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

?>

<table border="1" align="center" style="width:50%;">

<tr>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Call;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_male;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_female;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Category;?></th>

</tr>
<?php 
$sqlGroupTotalCOncepts="SELECT * FROM ".$prefix."grantcalls where category='concepts' order by grantID desc";
$sqlFGrpDisCTotalCOncepts=$mysqli->query($sqlGroupTotalCOncepts);
$TotalCOncepts = $sqlFGrpDisCTotalCOncepts->num_rows;
while($rFLists2=$sqlFGrpDisCTotalCOncepts->fetch_array()){
	//grantID submissions_concepts
	//ppr_user_grantids
$grantID=$rFLists2['grantID'];
//Get all concept submissions

//Women
$sqlGenderw="SELECT * FROM ".$prefix."user_grantids where gender='Female' and grantID='$grantID' order by id desc";
$queryGenderw=$mysqli->query($sqlGenderw);
$TotalC_Female = $queryGenderw->num_rows;

$sqlGenderMale="SELECT * FROM ".$prefix."user_grantids where gender='Male' and grantID='$grantID' order by id desc";
$queryGenderMale=$mysqli->query($sqlGenderMale);
$TotalC_Male = $queryGenderMale->num_rows;

$sqlCat = "SELECT * FROM ".$prefix."categories order by rstug_categoryName asc";
$queryCat = $mysqli->query($sqlCat);

	
echo "<tr>";
////Five
echo "<td>".$rFLists2['title']."</td>";
echo "<td>".$TotalC_Male."</td>";
echo "<td>".$TotalC_Female."</td>"; 


echo "<td>"?><?php while($rCat = $queryCat->fetch_array()){
	$rstug_categoryID=$rCat['rstug_categoryID'];
	
$sqlConcepts2="SELECT * FROM ".$prefix."submissions_concepts where researchTypeID='$rstug_categoryID' and grantcallID='$grantID' order by conceptID desc";
$queryConcepts2=$mysqli->query($sqlConcepts2);
$TotalC_submitted2 = $queryConcepts2->num_rows;

if($base_lang=='en'){echo $rCat['rstug_categoryName'];}
if($base_lang=='fr'){echo $rCat['rstug_categoryName_fr'];}
if($base_lang=='pt'){echo $rCat['rstug_categoryName_pt'];}
echo ' :<span style="color:#F00;">'.$TotalC_submitted2; echo "</span><br>";
 }"</td>";

echo "</tr>";

}


echo "</table>";
?>
