<?php
session_start();
require_once('contrlrcn/c_mlsrcontrol.php'); 
$EvaluatedBy=base64_decode($id);
$ds=$mysqli->real_escape_string(base64_decode($_GET['ds']));
?>
<?php                                                  
$sqlScoreReview="SELECT * FROM ".$prefix."mscores where scoredmID='$ds' and EvaluatedBy='$EvaluatedBy'";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
$rScoreReview = $QueryScoreReview->fetch_array();

	/*$evaluatedBy=$rScoreReview['EvaluatedBy'];
	//now get this reviewer
$sqlReviewer="SELECT * FROM ".$prefix."musers where usrm_id='$evaluatedBy'";
$QueryReviewer=$mysqli->query($sqlReviewer);
$rReviewer = $QueryReviewer->fetch_array();*/
	$totalScore=($rScoreReview['STQnewMethods']+$rScoreReview['STQhighQuality']+$rScoreReview['STQSatisfactoryPartnership']+$rScoreReview['AppPrototypeClearly']+$rScoreReview['AppAddressIssues']+$rScoreReview['ImpactClearlyConvincingly']+$rScoreReview['ImpactGenderIssues']+$rScoreReview['Potential']+$rScoreReview['Budget']);
	?>
    <div style="width:600px; margin:0 auto; padding-top:30px;">

 <b>1. Scientific quality and innovation of the joint research proposal (30%). <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['STQnewMethods'];?></b></p>

<p>2. Feasibility  of the joint  research  proposal (Practicality,   feasibility   and   consistency   of   proposed   activities   with   the objectives  of the call,  and feasibility  of the  methodology  provided) (15%). <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['STQhighQuality'];?></b></p>

<p>3. Added value  to expect  from  collaboration Technological  capacity  building (15%). <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['STQSatisfactoryPartnership'];?>%</b></p>



<p>4. Competence, expertise and experience of principal investigators and relevant  scientists  / research  teams (5%) <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['AppAddressIssues'];?>%</b></p>

<p>5. Clarity of expected results (15%). <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['ImpactClearlyConvincingly'];?>%</b></p>


<p>Potential to promote equity and ethics of the joint project (5%) <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['Potential'];?>%</b>
</p>

<p>7. Budget (Consistency  with  the  budget  ratio  or  percentage  provided  by  the  appeal guide, Basis of  estimates - How  well the  proposed  expenses  reflect the actual  cost of the  proposed action?) (5%) <b style="color:#09F; font-weight:bold;"><?php echo $rScoreReview['Budget'];?>%</b>
</p>



<p><b>Total: <span style="color:#00A65A; font-weight:bold;"><?php echo $totalScore;?></span></b></p>
</div>
