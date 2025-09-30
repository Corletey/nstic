<?php 
require_once("dynamic_categories2.php");
$maincategoryID=$_GET['categoryID'];
$wmConfirm="select * from ".$prefix."dynamic_proposal_stages where  owner_id='$usrm_id' and status='new' and grantID='$id'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();


////Now, get all categories---grantcall_categories
$wmConfirm2="select * from ".$prefix."grantcall_categories where  grantID='$id'";
$cmdwbConfirm2 = $mysqli->query($wmConfirm2);
$totalStagesConfirm2 = $cmdwbConfirm2->num_rows;///Overall Total categories
//Now Generate steps depending on number of categories, if they are 5 cats, generate on 5 steps
/*$countNumMoze=1;
while($rUTotalStages=$cmdwbConfirm2->fetch_array()){
	echo $countNumMoze++.'<br>';
	if($countNumMoze=='1'){$stepsDone='20';}
}*/

if(!$totalStagesConfirm){$stepsDone=5;}
if($totalStagesConfirm<$totalStagesConfirm2 and $totalStagesConfirm and $totalStagesConfirm<=2){$stepsDone='20';}
if($totalStagesConfirm<$totalStagesConfirm2 and $totalStagesConfirm and $totalStagesConfirm>=2){$stepsDone='50';}
if($totalStagesConfirm>=$totalStagesConfirm2){$stepsDone=100;}

/*if($totalStagesConfirm=='3'){$stepsDone=70;}
if($totalStagesConfirm=='4'){$stepsDone=80;}
if($totalStagesConfirm=='5'){$stepsDone=100;}*/
?>

<div class="progress">


  <div class="progress-bar progress-bar-striped active" role="progressbar"
  aria-valuenow="<?php echo $stepsDone;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $stepsDone;?>%">
    <?php echo $stepsDone;?>%
  </div>
</div>
<?php 



if($totalStagesConfirm>=$totalStagesConfirm2){?><div class="btnm"><a href="./main.php?option=dynamicProposalSubmitNow&id=<?php echo $id;?>&categoryID=<?php echo $maincategoryID;?>" onclick="return confirm('Are you sure you want to submit your proposal? click CANCEL to continue editing or OK to Submit Now.');"><?php echo $lang_submit_now;?></a></div>
<span style="color:#F00; font-weight:bold; font-size:16px;"><?php echo $lang_FinalCheckandSubmission;?><!-- <br />
To submit your proposal note, please click submit now button. Only after having clicked on this button will your proposal be successfully submitted.--></span><?php }?>