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
<th style="background:#796AEE; color:#FFFFFF; height:20px;"><?php echo $lang_Name;?></th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;"> </th>

</tr>

<?php
$sql = "select * FROM ".$prefix."musers where usrm_usrtype='reviewer' order by usrm_fname asc";//and conceptm_status='new' 
$rFetch = $mysqli->query($sql);

while ($rFLists2 = $rFetch->fetch_array()){
$grantID=$rFLists2['grantID'];
$owner_id=$rFLists2['usrm_id'];

$queryDistrictsMain245="select * from ".$prefix."conceptsasslogs_new where conceptm_assignedto='$owner_id' order by assignm_id desc";
$queryConcepts=$mysqli->query($queryDistrictsMain245);	
$total_SubmissionsnotReviewed = $queryConcepts->num_rows;
	
////Five
echo "<td><b>".$rFLists2['usrm_fname'].' '.$rFLists2['usrm_sname'].'</b>'; if($total_SubmissionsnotReviewed){?><table width='100%' border='1'>
<tr>
    <td style="background:#999;"><b><?php echo $lang_Proposals;?></b></td>
    <td style="background:#999;"><b><?php echo $lang_Date;?></b></td>
    <td style="background:#999;"><b><?php echo $lang_Status;?></b></td>
  </tr><?php while($rows_submissions=$queryConcepts->fetch_array()){
$categorym=$rows_submissions['categorym'];
$conceptm_idd=$rows_submissions['conceptm_id'];

if($categorym=='concepts'){														////////////////////subs///////////////
$sqlFLists1="SELECT *,DATE_FORMAT(`updatedon`,'%d/%m/%Y %H:%s:%i') AS updatedonm FROM ".$prefix."submissions_concepts where conceptID='$conceptm_idd'  order by conceptID desc";
$QueryFListsm1=$mysqli->query($sqlFLists1);
$rFLists2=$QueryFListsm1->fetch_array(); 
$conceptm_id=$rFLists2['conceptID']; 
$projectTitle=$rFLists2['projectTitle'];
$dynamic=$rFLists2['dynamic'];
$grantcallID=$rFLists2['grantcallID'];
}


 
if($categorym=='proposals'){															////////////////////subs///////////////
$sqlFLists1="SELECT *,DATE_FORMAT(`updatedon`,'%d/%m/%Y %H:%s:%i') AS updatedonm FROM ".$prefix."submissions_proposals where projectID='$conceptm_idd'  order by projectID desc";
$QueryFListsm1=$mysqli->query($sqlFLists1);
$rFLists2=$QueryFListsm1->fetch_array(); 
$conceptm_id=$rFLists2['projectID']; 
$projectTitle=$rFLists2['projectTitle'];
$dynamic=$rFLists2['dynamic'];
$grantcallID=$rFLists2['grantcallID'];
}
$updatedonm=$rows_submissions['assignm_date'];

if($rows_submissions['logm_status']=='completed'){
$logm_status="Completed";
}
if($rows_submissions['logm_status']=='new'){
$logm_status="Pending";
}

echo $projectTitleMain="
  <tr>
    <td>$projectTitle</td>
    <td>$updatedonm</td>
    <td>$logm_status</td>
  </tr>
";
	
}?></table><?php }"</td>";


echo "</tr>";

}


echo "</table>";
?>
