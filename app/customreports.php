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

$category=$mysqli->real_escape_string($_GET['category']);
$ssCategory=$mysqli->real_escape_string($_GET['ssCategory']);
$searchYearFrom=$mysqli->real_escape_string($_GET['searchYearFrom']);
$searchYearTo=$mysqli->real_escape_string($_GET['searchYearTo']);
$sstatus=$mysqli->real_escape_string($_GET['sstatus']);

$ssall=$mysqli->real_escape_string($_GET['ssall']);
$ssbudget=$mysqli->real_escape_string($_GET['ssbudget']);

?>

<table border="1" align="center" style="width:50%;">

<tr>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">Grant</th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">Project Title</th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">PI</th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">titleAcronym</th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">Relevant Keywords</th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">Research Category</th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">Duration</th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">Status</th>	
<th style="background:#796AEE; color:#FFFFFF; height:20px;">Host Institution</th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">Total Funding</th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">Amount of Grantawarded</th>
<th style="background:#796AEE; color:#FFFFFF; height:20px;">Currency</th>

</tr>

<?php
if($searchYearFrom and !$ssbudget and !$ssall and !$sstatus and !$ssCategory){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo') order by projectID desc";//and conceptm_status='new' 
}

if($searchYearFrom and !$ssbudget and !$sstatus and $ssall and !$ssCategory){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo')  and (projectTitle like '%$ssall%')  order by projectID desc";//and conceptm_status='new' 
}
if($searchYearFrom and $sstatus and !$ssbudget and !$ssall and !$ssCategory){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo')  and (projectStatus='$sstatus')  order by projectID desc";//and conceptm_status='new' 
}
if($searchYearFrom and $ssCategory and !$sstatus and !$ssbudget and !$ssall){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo')  and (researchTypeID='$ssCategory')  order by projectID desc";//and conceptm_status='new' 
}

if($searchYearFrom and $_POST['ssbudget'] and !$_POST['sstatus'] and !$_POST['ssall'] and !$_POST['ssCategory']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ppr_submissions_proposals,ppr_concept_budget where ppr_submissions_proposals.conceptID=ppr_concept_budget.conceptID and ppr_submissions_proposals.owner_id=ppr_concept_budget.owner_id and (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo') order by projectID desc";//and conceptm_status='new' 
}


if(!$searchYearFrom){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals order by projectID desc";//and conceptm_status='new' 
}

$rFetch = $mysqli->query($sql);

while ($results = $rFetch->fetch_array()){
	$owner_id=$results['owner_id'];
$researchTypeID=$results['researchTypeID'];
$projectDurationID=$results['projectDurationID'];
$grantcallID=$results['grantcallID'];

$sqAffiliatedTo = "select * from ".$prefix."grantcalls where grantID='$grantcallID'";
$resultAffiliatedTo = $mysqli->query($sqAffiliatedTo);
$rAffiliatedTo = $resultAffiliatedTo->fetch_array();


$sqlSRR = "select * from ".$prefix."musers where usrm_id='$owner_id'";
$resultSSS = $mysqli->query($sqlSRR);
$sqUserdd = $resultSSS->fetch_array();
$fullname=$sqUserdd['usrm_fname'].' '.$sqUserdd['usrm_sname']; 	


////////////////////////////////////////////////////////////////////
$sqCategories = "select * from ".$prefix."categories where rstug_categoryID='$researchTypeID' order by rstug_categoryID desc";
$resultCategories = $mysqli->query($sqCategories);
$rcategories = $resultCategories->fetch_array();//

$sqDuration = "select * from ".$prefix."duration where durationID='$projectDurationID' order by durationID desc limit 0,1";
$resultDuration = $mysqli->query($sqDuration);
$rDuration = $resultDuration->fetch_array();//


	
echo "<tr>";
////Five
echo "<td>".$rAffiliatedTo['title']."</td>";
echo "<td>".$results['projectTitle']."</td>";
echo "<td>".$fullname."</td>"; 	
echo "<td>".$results['titleAcronym']."</td>";
echo "<td>".$results['relevantKeywords']."</td>";
echo "<td>".$rcategories['rstug_categoryName']."</td>";
echo "<td>".$rDuration['duration']."</td>";
echo "<td>".$results['projectStatus']."</td>";

echo "<td>".$results['HostInstitution']."</td>";//
echo "<td>".$results['Totalfunding']."</td>";

echo "<td>".$results['AmountofGrantawarded']."</td>";
echo "<td>".$results['currency']."</td>";


echo "</tr>";

}


echo "</table>";
?>
