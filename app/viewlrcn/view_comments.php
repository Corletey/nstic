<?php
$grantID=$_GET['grantID'];
$usrm_id=$_SESSION['usrm_id'];
echo $wmOwner="select * from ".$prefix."submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();

?>
<div class="tab">

  <button <?php if($rProjectStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewPrososal')" id="defaultOpen">View Comments</button>
  
  

</div>

<div id="reviewPrososal" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   
    
  <h3>Comments from Reviewers</h3>

  <?php
$EvaluatedBy=$_GET['id'];;
$dconceptID=$mysqli->real_escape_string($_GET['dconceptID']);
$grantID=$mysqli->real_escape_string($_GET['grantID']);
?>
<table width="100%" border="0" id="customers">
  <tr>
    <th width="35%"><strong>Score</strong></th>
    <th width="49%"><strong>Comment</strong></th>
  </tr>
  
  
  <?php
  $qn_no=0;

 
$queryCategoryReview="select EvaluatedBy,conceptm_id,usrm_id,grantID from ".$prefix."mscores_dynamic where conceptm_id='$conceptID' and usrm_id='$usrm_id'  and categorym='proposals'  and grantID='$grantID' group by EvaluatedBy order by EvaluatedBy";
$R_CategoryReview=$mysqli->query($queryCategoryReview);	
while($rCReview=$R_CategoryReview->fetch_array()){
$EvaluatedBy=$rCReview['EvaluatedBy'];
$qn_no++;	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();
	
	?>
 
<input id="go" type="button" value="Reviewer -<?php echo $qn_no;?> , View Score" onclick="window.open('scoresheetdynamic.php?id=<?php echo $EvaluatedBy;?>&ds=<?php echo $rCReview['scoredmID'];?>&grantID=<?php echo $grantID;?>&dconceptID=<?php echo $conceptID;?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-blue" ><br /><?php }?>   <br>                                             
                                                    
 <?php 
	
	
  $sqlScores2 = "SELECT * FROM ".$prefix."mscores_dynamic where conceptm_id='$conceptID' and usrm_id='$usrm_id' and grantID='$grantID'";//and question_id='$question_id'  
		$queryScores2 = $mysqli->query($sqlScores2);
       $totalScores2 = $queryScores2->num_rows;
        while($rScores2 = $queryScores2->fetch_array()){
            $question_id=$rScores2['question_id'];

$sqlQuestions="SELECT * FROM ".$prefix."mscores_dynamic_qns WHERE `id`='$question_id';
";
$QueryQuestions = $mysqli->query($sqlQuestions);
$rQuestions=$QueryQuestions->fetch_array();
	$qn_no++;
?>
  <tr><td colspan="2"><strong><?php echo $qn_no;?>. <?php echo $rQuestions['question'];?> (<?php echo $rQuestions['percentScore'];?> %)</strong></td></tr> 	
  <tr>
  <td align="center" valign="top" style="color:#06F;"><?php echo $rScores2['EvTotalScore'];?></td>
    <td valign="top" style="color:#06F;"><?php echo $rScores2['scomment'];?></td>
  </tr>
  
<?php //end 
$EvTotalScore=($rScores2['EvTotalScore']+$EvTotalScore);
}?>

  <tr><td colspan="2"><strong></strong></td></tr> 	
  <tr>
  <td align="center" valign="top" style="color:#F00;"><?php echo $EvTotalScore;?>%</td>
    <td valign="top" style="color:#06F;"></td>
  </tr>
</table>

 
 
</div>









<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>