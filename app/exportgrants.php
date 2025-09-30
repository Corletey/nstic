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
<th style="background:#796AEE; color:#FFFFFF; height:20px;"> </th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_new_StartDate;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_new_EndDate;?></th>

</tr>

<?php
$sql = "select * FROM ".$prefix."grantcalls  where  category='proposals' order by grantID desc";//and conceptm_status='new' 
$rFetch = $mysqli->query($sql);

while ($rFLists2 = $rFetch->fetch_array()){
$grantID=$rFLists2['grantID'];

$sqlConcepts2="SELECT * FROM ".$prefix."submissions_proposals where awarded='Yes' and grantcallID='$grantID' order by projectID desc";
$queryConcepts2=$mysqli->query($sqlConcepts2);
$Awarded = $queryConcepts2->num_rows;

$sqlConcepts="SELECT * FROM ".$prefix."submissions_proposals where awarded='Yes' and grantcallID='$grantID' order by projectID desc";
$queryConcepts=$mysqli->query($sqlConcepts);
$TotalC_submittedm = $queryConcepts->num_rows;

	
////Five
echo "<td>".$rFLists2['title']; if($TotalC_submittedm){?><table width='100%' border='1'>
<tr>
    <td style="background:#999;"><b>Project</b></td>
    <td style="background:#999;"><b>Award</b></td>
    <td style="background:#999;"><b>Gender</b></td>
  </tr><?php while($rows_submissions=$queryConcepts->fetch_array()){

$owner_id=$rows_submissions['owner_id'];
$grantID=$rows_submissions['grantcallID'];
$projectID=$rows_submissions['projectID'];
$rstug_categoryID=$rows_submissions['researchTypeID'];
$projectTitle=$rows_submissions['projectTitle'];
$AmountofGrantawarded=numberformat($rows_submissions['AmountofGrantawarded']);

///submissions by Gender
//Women
$sqlGenderLog="SELECT * FROM ".$prefix."musers where usrm_id='$owner_id' order by usrm_id desc";
$queryGenderLog=$mysqli->query($sqlGenderLog);
$rows_GenderLog=$queryGenderLog->fetch_array();
$usrm_gender=$rows_GenderLog['usrm_gender'];
echo $projectTitleMain="
  <tr>
    <td>$projectTitle</td>
    <td>$AmountofGrantawarded</td>
    <td>$usrm_gender</td>
  </tr>
";
	
}?></table><?php }"</td>";




echo "<td>".$rFLists2['startDate']."</td>";
echo "<td>".$rFLists2['EndDate']."</td>"; 	

echo "</tr>";

}


echo "</table>";
?>
