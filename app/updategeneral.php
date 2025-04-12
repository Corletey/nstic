<?php
session_start();
require_once('contrlrcn/c_mlsrcontrol.php'); 


$sqlReviewedm="SELECT  *,sum(EvTotalScore) As TotalEvTotalScore,count(*) as TotalRevs FROM ".$prefix."mscores where categorym='proposals' group by conceptm_id";
$QueryReviewedm=$mysqli->query($sqlReviewedm);
while($rConcepts = $QueryReviewedm->fetch_array()){
//$totalReviewedm = $QueryReviewedm->num_rows;
//echo $rConcepts['EVivaScore'].'=>'.($rConcepts['TotalEvTotalScore']/$rConcepts['TotalRevs']).'mm:'.$rConcepts['TotalRevs'].'::::ID=>'.$rConcepts['scoredmID'].'<br>';

$sconceptm_id=$rConcepts['conceptm_id'];
$susrm_id=$rConcepts['usrm_id'];


$TotalScore=($rConcepts['TotalEvTotalScore']/$rConcepts['TotalRevs']);
$getGeneralTotalAll=($TotalScore+$rConcepts['EVivaScore']);

$getGeneralTotalAll=round(($TotalScore+$rConcepts['EVivaScore']),2);

$sqlGeneral="update ".$prefix."mscores set EvgeneralTotal='$getGeneralTotalAll' where conceptm_id='$sconceptm_id' and usrm_id='$susrm_id'";// order by 
$mysqli->query($sqlGeneral);


}
?>
