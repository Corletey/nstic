<?php 
require_once("dynamic_categories2.php");
$wmConfirm="select * from ".$prefix."project_stages where  owner_id='$usrm_id' and grantID='$id'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();

$totalPoints=($rConfirm['ProjectInformation']+$rConfirm['Background']+$rConfirm['Methodology']+$rConfirm['ProjectResults']+$rConfirm['ResearchTeam']+$rConfirm['ProjectManagement']+$rConfirm['Followup']+$rConfirm['Budget']+$rConfirm['attachments']+$rConfirm['citations']);//
//+$rConfirm['PrincipalInvestigatorResearch']+$rConfirm['PrincipalInvestigatorEducation']
if(!$totalStagesConfirm){$stepsDone=0;}

if($totalPoints>=1 and $totalPoints<=2){$stepsDone='20';}
if($totalPoints>=3 and $totalPoints<=4){$stepsDone='50';}
if($totalPoints>=5 and $totalPoints<=6){$stepsDone='80';}
if($totalPoints>=7 and $totalPoints<=8){$stepsDone='90';}
if($totalPoints>=9 and $totalPoints<=10){$stepsDone='100';}
if($totalPoints>=$finalTotalCount){$stepsDone=100;}


?>

<div class="progress">


  <div class="progress-bar progress-bar-striped active" role="progressbar"
  aria-valuenow="<?php echo $stepsDone;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $stepsDone;?>%">
    <?php echo $stepsDone;?>%
  </div>
</div>
<?php 

if($totalPoints>=10){?><div class="btnm"><a href="./main.php?option=proposalSubmitNow&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>" onclick="return confirm('Are you sure you want to submit your proposal? Please conduct a final check of all the sections before submitting.');"><?php echo $lang_submit_now;?></a></div>
<span style="color:#F00; font-weight:bold; font-size:16px;"><?php echo $lang_FinalCheckandSubmission;?></span><?php }?>