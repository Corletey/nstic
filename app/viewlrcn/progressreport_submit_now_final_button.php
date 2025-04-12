<?php $wmConfirm="select * from ".$prefix."progress_report_stages where  owner_id='$usrm_id' and status='new'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();

$totalPoints=($rConfirm['SignaturePage']+$rConfirm['Abstract']+$rConfirm['SummaryofScientificProgress']+$rConfirm['KeyPersonnelEffort']+$rConfirm['Publications']);//

if(!$totalStagesConfirm){$stepsDone=0;}

if($totalPoints=='1'){$stepsDone='20';}
if($totalPoints=='2'){$stepsDone=50;}
if($totalPoints=='3'){$stepsDone=70;}
if($totalPoints=='4'){$stepsDone=85;}
if($totalPoints=='5'){$stepsDone=100;}
?>

<div class="progress">


  <div class="progress-bar progress-bar-striped active" role="progressbar"
  aria-valuenow="<?php echo $stepsDone;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $stepsDone;?>%">
    <?php echo $stepsDone;?>%
  </div>
</div>
<?php 

if($totalStagesConfirm and $rConfirm['SignaturePage']>=1 and $rConfirm['Abstract']>=1 and $rConfirm['SummaryofScientificProgress']>=1 and $rConfirm['KeyPersonnelEffort']>=1 and $rConfirm['Publications']>=1){?><div class="btnm"><a href="./main.php?option=reportSubmitNow" onclick="return confirm('Are you sure you want to submit your report? Please conduct a final check of all the sections before submitting.');"><?php echo $lang_submit_now;?></a></div>
<span style="color:#F00; font-weight:bold; font-size:16px;"><?php echo $lang_FinalCheckandSubmission;?></span><?php }?>