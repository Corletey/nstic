<?php 
$status=$mysqli->real_escape_string($_GET['status']);
if($status=='Rejected'){
    $status2="Completeness Check-Rejected";  
}else{$status2=$mysqli->real_escape_string($_GET['status']);}
$sql = "select * FROM ".$prefix."submissions_proposals where owner_id='$usrm_id' and projectStatus='$status2' order by projectID desc limit 0,50";
$result = $mysqli->query($sql);
$total_pages = $result->num_rows;

		  ?>
           
 <div class="table-responsive">
    <h4 class="niceheaders"><?php echo $lang_MySubmissions;?></h4><hr />
    
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox" width="100%">
                                                    <tr class="unread" style="font-size:16px;">
                                                
                                                        <th width="484" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                        <th class="time" colspan="2"><strong><?php echo $lang_Action;?></strong></th>

                                                    </tr>
                                         
<?php if($total_pages){?>
<?php while($rFLists2=$result->fetch_array()){
							  //Check whether something was posted
$owner_id=$rFLists2['owner_id'];
$projectID=$rFLists2['projectID'];
$conceptID=$rFLists2['conceptID'];
$grantcallID=$rFLists2['grantcallID'];
$projectStatus=$rFLists2['projectStatus'];
$dynamic=$rFLists2['dynamic'];
 

if($dynamic=='No'){
$sqlwwScores = "select usrm_id,sum(EvTotalScore) AS Total,conceptm_id FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$projectID'  and categorym='proposals'  and grantID='$grantcallID' group by EvTotalScore order by EvTotalScore desc";
$resultwwScores = $mysqli->query($sqlwwScores);
$rFListsScores=$resultwwScores->fetch_array();

$sqlwwScores2 = "select DISTINCT(EvaluatedBy) AS TotalReviewers FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$projectID'  and categorym='proposals'  and grantID='$grantcallID' group by EvaluatedBy order by EvaluatedBy desc";
$resultwwScores2 = $mysqli->query($sqlwwScores2);
$rFListsScores2=$resultwwScores2->fetch_array();
$TotalReviewers=$resultwwScores2->num_rows;

if($rFListsScores['Total']){$TotalScore=($rFListsScores['Total']/$TotalReviewers);}///$rFListsScores['TotalReviewers']
}

if($dynamic=='Yes' || $dynamic==''){
$sqlwwScores = "select usrm_id,sum(EvTotalScore) AS Total,conceptm_id FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$projectID'  and categorym='proposals'  and grantID='$grantcallID' group by conceptm_id order by conceptm_id desc";
$resultwwScores = $mysqli->query($sqlwwScores);
$rFListsScores=$resultwwScores->fetch_array();

$sqlwwScores2 = "select DISTINCT(EvaluatedBy) AS TotalReviewers FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$projectID'  and categorym='proposals'  and grantID='$grantcallID' group by EvaluatedBy order by EvaluatedBy desc";
$resultwwScores2 = $mysqli->query($sqlwwScores2);
$rFListsScores2=$resultwwScores2->fetch_array();
$TotalReviewers=$resultwwScores2->num_rows;

///Dirty
$sqlwwScores3 = "select scoredmID,EVivaScore FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$projectID'  and categorym='proposals'  and grantID='$grantcallID' order by scoredmID desc";
$resultwwScores3 = $mysqli->query($sqlwwScores3);
$rFListsScores3=$resultwwScores3->fetch_array();

if($rFListsScores['Total']){$TotalScore=($rFListsScores['Total']/$TotalReviewers);}///$rFListsScores['TotalReviewers']


}

							  ?>
                                                   <tr class="unread" style="font-size:13px;">
                                                
                                                        <td width="484" class="small-col"><p style="font-size:16px;"><?php echo $rFLists2['projectTitle'];?><br />
                                                        <strong><?php echo $rFLists2['referenceNo'];?></strong>
                                                        
                                                        
                                                        
                                                        </p></td>
                                                        <td width="171" class="time">
                                                        
                                                <?php 
if($rFLists2['projectStatus']=='Pending Review'){ echo "<span class='button2'>Proposal is Pending Review</span>";}?>
<?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['awarded']!='Yes'){ echo "<span class='button1'>$lang_ProposalHasbeenReviewed</span>";?> <?php }?>
<?php if($rFLists2['projectStatus']=='Approved'){ echo "<span class='button1'>$ProposalHasbeenApproved</span>";}?>

<?php if($rFLists2['projectStatus']=='Scheduled for Review'){ echo "<span class='button1'>$lang_ProposalHasbeenScheduledforReview</span>";}?>

 
 
 
 <?php if($rFLists2['projectStatus']=='Pending Final Submission' and $dynamic=='No'){ echo "<span class='button1'>$lang_PendingFinalSubmission</span>";?> <div class='button3'><a href="main.php?option=SubmitProposal&conceptID=<?php echo $rFLists2['conceptID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>" ><?php echo $lang_ClicktoUpdateSubmission;?></a></div><?php }?>
 
  <?php  if(($rFLists2['projectStatus']=='Pending Final Submission' || $status2=='Completeness Check-Rejected') and ($dynamic=='Yes' || $dynamic=='')){ echo "<span class='button1'>$lang_PendingFinalSubmission</span>";?> <div class='button3'><a href="main.php?option=newSubmitProposalUpdate&conceptID=<?php echo $rFLists2['conceptID'];?>&id=<?php echo $rFLists2['grantcallID'];?>&projectID=<?php echo $rFLists2['projectID'];?>" ><?php echo $lang_ClicktoUpdateSubmission;?></a></div><?php }?><?php //echo $rFLists2['projectID'];?>
  
  <?php if($rFLists2['projectStatus']!='Pending Final Submission' and $dynamic=='No'){?>                                                
 <div class='button3'><a href="./main.php?option=reviewPrososal&id=<?php echo $rFLists2['projectID'];?>"><?php echo $lang_ClicktoViewDetails;?></a></div><?php }?>
 
 <?php if($rFLists2['projectStatus']!='Pending Final Submission' and $dynamic=='Yes'){?>                                                
 <div class='button3'><a href="./main.php?option=newreviewPrososal&id=<?php echo $projectID;?>&grantID=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_ClicktoViewDetails;?></a></div><?php }?>
<?php /*?><?php if($rFLists2['projectStatus']=='Approved'){?> <a href="https://research.uncst.go.ug/" class='errorm3' target="_blank">Apply for UNCST Research Permit</a><?php }?><?php */?>
                                                        
                                                        
                                                        </td>
              
                                                      
                                                      <td width="229" class="time">


<?php if($rFLists2['awarded']=='Yes' and $rFLists2['TermsConditions']=='No'){?>

<input id="go" type="button" value="<?php echo $lang_GrantAwardedclicktoAccept;?>" onclick="window.open('terms_and_conditions.php?id=<?php echo base64_encode($projectID);?>&categorym=proposals&owner_id=<?php echo $rFLists2['owner_id'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-purple" title="<?php echo $lang_Grant_awarded_toyou;?>"> 

 <?php }?>

    
    
    <?php if($rFLists2['awarded']=='Yes' and $rFLists2['TermsConditions']=='Yes'){?>
<div class='button1'><a href="./main.php?option=urRequestforFunds&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_RequestforFunds;?></a></div>

<div class='button1'><a href="./main.php?option=RequestforProcurement&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_RequestforProcurement;?></a></div>

 <?php }?>
                                                     </td>

                                                    </tr>
                                                  <?php } //End Loop?> <?php } //End Loop?>
                                                  <?php if(!$total_pages){?>
                                                  <tr class="unread" style="font-size:16px;">
                                                
                                                        <td class="small-col" colspan="3"><strong><?php echo $lang_no_results_displayed;?></strong></td>
                                                    
                                                    </tr><?php }?>
                                                  
                                                </table>
                                               
              </div><!-- /.table-responsive -->
				   
