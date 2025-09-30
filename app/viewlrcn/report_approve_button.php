<?php 
$usrm_idsession=$_SESSION['usrm_id'];
$wmConfirm1="select * from ".$prefix."progress_report_review where  reviewer_id='$usrm_idsession' and progressID='$id'  and status='new'  order by id desc";
$cmdwbConfirm1 = $mysqli->query($wmConfirm1);
$totalStagesConfirm1 = $cmdwbConfirm1->num_rows;
$rConfirm= $cmdwbConfirm1->fetch_array();

//check if this submission was not worked on in 
$wmConfirm3="select * from ".$prefix."progress_report_signature_page where  progressID='$id'";
$cmdwbConfirm3 = $mysqli->query($wmConfirm3);
$totalStagesConfirm3 = $cmdwbConfirm3->num_rows;
$rRequest= $cmdwbConfirm3->fetch_array();

if($totalStagesConfirm1 and $rConfirm['SignaturePage']>=1 and $rConfirm['Abstract']>=1 and $rConfirm['SummaryofScientificProgress']>=1 and $rConfirm['KeyPersonnelEffort']>=1 and $rConfirm['Publications']>=1 and $rRequest['reportStatus']=='Submitted'){?><div class="btnm"><a href="./main.php?option=ReviewActionReport&id=<?php echo $id;?>">Approve Report</a></div>

<?php /*?><div class="btnm"><a href="./main.php?option=ReviewActionReportRevisions/<?php echo $rConfirm1['projectID'];?>/">Request Revisions</a></div><?php */?>

<input id="go" type="button" value="Request for Revisions" onclick="window.open('<?php echo $base_url;?>reportaction.php?id=<?php echo $id;?>&owner_id=<?php echo $rConfirm['owner_id'];?>&projectID=<?php echo $rConfirm['projectID'];?>','popUpWindow','height=500, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btnm" >


<?php }?>