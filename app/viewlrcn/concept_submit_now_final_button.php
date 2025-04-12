<?php $wmConfirm="select * from ".$prefix."concept_stages where  owner_id='$usrm_id' and grantcallID='$id'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();


$totalPoints=($rConfirm['ProjectInformation']+$rConfirm['PrincipalInvestigator']+$rConfirm['Budget']+$rConfirm['conceptAttachments']);//
//$rConfirm['Introduction']+$rConfirm['ProjectDetails']+$rConfirm['cReferences']
if(!$totalStagesConfirm){$stepsDone=0;}

if($totalPoints=='1'){$stepsDone='20';}
if($totalPoints=='2'){$stepsDone=60;}
if($totalPoints=='3'){$stepsDone=80;}
if($totalPoints=='4'){$stepsDone=91;}
if($totalPoints=='5'){$stepsDone=95;}
if($totalPoints=='6'){$stepsDone=98;}
if($totalPoints=='7'){$stepsDone=100;}
?>

<div class="progress">


  <div class="progress-bar progress-bar-striped active" role="progressbar"
  aria-valuenow="<?php echo $stepsDone;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $stepsDone;?>%">
    <?php echo $stepsDone;?>%
  </div>
</div>
<?php 



if($totalStagesConfirm and $rConfirm['ProjectInformation']>=1 and $rConfirm['PrincipalInvestigator']>=1 and $rConfirm['Budget']>=1 and $rConfirm['conceptAttachments']>=1){?><div class="btnm"><a href="./main.php?option=conceptSubmitNow&id=<?php echo $id;?>" onclick="return confirm('Are you sure you want to submit your concept? click CANCEL to continue editing or OK to Submit Now.');"><?php echo $lang_submit_now;?></a></div>
<span style="color:#F00; font-weight:bold; font-size:16px;"><?php echo $lang_FinalCheckandSubmission;?></span><?php }?>