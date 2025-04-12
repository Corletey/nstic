<?php 
$sql = "select * FROM ".$prefix."submissions_proposals where owner_id='$usrm_id' order by projectID desc limit 0,100";
$result = $mysqli->query($sql);
$total_pages = $result->num_rows;

		  ?>
           
 <div class="table-responsive">
    <h4 class="niceheaders"><?php echo $lang_MySubmissions;?></h4><hr />
    <?php if($total_pages){?>
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox" width="100%">
                                                    <tr class="unread" style="font-size:16px;">
                                                
                                                        <th width="484" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                        <th width="172" class="time"><strong><?php echo $lang_Score;?></strong></th>
                                                       
                          
                                                        <th class="time" ><strong>Comments</strong></th>
                                                        <th class="time" ><strong><?php echo $lang_Action;?></strong></th>
                                                    </tr>
                                         

<?php while($rFLists2=$result->fetch_array()){
							  //Check whether something was posted
$owner_id=$rFLists2['owner_id'];
$projectID=$rFLists2['projectID'];
$conceptID=$rFLists2['conceptID'];
$grantcallID=$rFLists2['grantcallID'];
$projectStatus=$rFLists2['projectStatus'];
//Get grants table
$sqlGrants = "select * FROM ".$prefix."grantcalls where grantID='$grantcallID' order by grantID desc limit 0,1";
$resultGrants = $mysqli->query($sqlGrants);
$RowGrants=$resultGrants->fetch_array();
$RowGrants['EndDate'];
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
                                                        RefNo: <strong><?php echo $rFLists2['referenceNo'];?></strong>
                                                        
                                                        
                                                        
                                                        </p></td>
                                                        <td width="172" class="time">
         <table width="98%" border="0">
  <tr>
    <td><strong style="color:#F00; font-size:22px;"><?php if($TotalScore){echo round($TotalScore,2).'%';}else{}?> </strong></td>
    <td>
	
       <?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['haltstudy']=='Yes'){?> 
   <input id="go" type="button" value="Study Halted" onclick="window.open('haltstudies.php?id=<?php echo $rFLists2['projectID'];?>&owner_id=<?php echo $rFLists2['owner_id'];?>&act=<?php echo $rFListsStudy['id'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-purple" >
   <?php }?>
   
   
   <?php 
     if($rFLists2['projectStatus']=='Reviewed' and $rowsGrants['end_review']=='Yes'){?> 
                                          
<input id="go" type="button" value="Add Viva Score <?php echo $rFListsScores['EVivaScore'];?>%" onclick="window.open('addvivascore.php?ds=<?php echo $rFListsScores['scoredmID']; ?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="button3" >

<?php }?>
    
    
    
    </td>
  </tr>
</table>
                                               
                                                        
                                                        
                                                        
                                                           
                                                        
                                                        </td>
                                                        <td width="171" class="time">
                                  




 <?php
 //display reviewer comments for applicants 
  $qn_no=0;
  $grantcallID=$rFLists2['grantcallID'];
$queryCategoryReview="select EvaluatedBy,conceptm_id,usrm_id,grantID from ".$prefix."mscores_dynamic where conceptm_id='$projectID' and usrm_id='$usrm_id'  and categorym='proposals'  and grantID='$grantcallID' group by EvaluatedBy order by EvaluatedBy";
$R_CategoryReview=$mysqli->query($queryCategoryReview);	
while($rCReview=$R_CategoryReview->fetch_array()){
$EvaluatedBy=$rCReview['EvaluatedBy'];
$qn_no++;	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();
	
	?>
 
<input id="go" type="button" value="Reviewer -<?php echo $qn_no;?> , View Comments" onclick="window.open('scoresheetdynamic.php?id=<?php echo $EvaluatedBy;?>&ds=<?php echo $rCReview['scoredmID'];?>&grantID=<?php echo $grantcallID;?>&dconceptID=<?php echo $projectID;?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-blue" ><br /><?php }?>















 
<?php /*?><?php if($rFLists2['projectStatus']=='Approved'){?> <a href="https://research.uncst.go.ug/" class='errorm3' target="_blank">Apply for UNCST Research Permit</a><?php }?><?php */?>
                                                        
                                                        
                                                        </td>
              
                                                      
                                                      <td width="229" class="time">



                     
                                                      <?php 
if($rFLists2['projectStatus']=='Pending Review'){ echo "<span class='button2'>Proposal is Pending Review</span>";}?>
<?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['awarded']!='Yes'){ echo "<span class='button1'>$lang_ProposalHasbeenReviewed</span>";?> <?php }?>
<?php if($rFLists2['projectStatus']=='Completeness Check-Approved'){ echo "<span class='button1'>Proposal Passed Completeness Check</span>";}?>

<?php if($rFLists2['projectStatus']=='Scheduled for Review'){ echo "<span class='button1'>$lang_ProposalHasbeenScheduledforReview</span>";}?>

 <?php if($rFLists2['projectStatus']=='Completeness Check-Rejected'){ echo "<span class='btn-info-red'>$lang_Rejected</span><br>";
 
 echo '<b>'.$rFLists2['rejectComents'].'</b>';
 }?>
 
 
 <?php if($rFLists2['projectStatus']=='Pending Final Submission' and $dynamic=='No'){ echo "<span class='button1'>$lang_PendingFinalSubmission</span>";?> <div class='button3'><a href="main.php?option=SubmitProposal&conceptID=<?php echo $rFLists2['conceptID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>" ><?php echo $lang_ClicktoUpdateSubmission;?></a></div><?php }?>
 
  <?php if($rFLists2['projectStatus']=='Pending Final Submission' || $rFLists2['projectStatus']=='Completeness Check-Rejected' and $dynamic=='Yes'  and $RowGrants['EndDate']>=$today){ echo "<span class='button1'>$lang_PendingFinalSubmission</span>";?> <div class='button3'><a href="main.php?option=newSubmitProposalUpdate&conceptID=<?php echo $rFLists2['conceptID'];?>&id=<?php echo $rFLists2['grantcallID'];?>&projectID=<?php echo $rFLists2['projectID'];?>" ><?php echo $lang_ClicktoUpdateSubmission;?></a></div><?php }?><?php //echo $rFLists2['projectID'];?>
  

 
 <?php if($rFLists2['projectStatus']!='Pending Final Submission' and $dynamic=='Yes'){?>                                                
 <div class='button3'><a href="./main.php?option=newreviewPrososal&id=<?php echo $projectID;?>&grantID=<?php echo $rFLists2['grantcallID'];?>&conceptID=<?php echo $projectID;?>"><?php echo $lang_ClicktoViewDetails;?></a></div>

 


 <?php }?>
 <div class='btn-info-purple'><a href="./download.php?id=<?php echo $projectID;?>&grantID=<?php echo $rFLists2['grantcallID'];?>&conceptID=<?php echo $projectID;?>" target="_blank">Print Application</a></div>

<?php if($rFLists2['awarded']=='Yes' and $rFLists2['TermsConditions']=='No'){?>

<input id="go" type="button" value="<?php echo $lang_GrantAwardedclicktoAccept;?>" onclick="window.open('terms_and_conditions.php?id=<?php echo base64_encode($projectID);?>&categorym=proposals&owner_id=<?php echo $rFLists2['owner_id'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-purple" title="<?php echo $lang_Grant_awarded_toyou;?>"> 

 <?php }?>

    
    
    <?php if($rFLists2['awarded']=='Yes' and $rFLists2['TermsConditions']=='Yes'){?>
<div class='button1'><a href="./main.php?option=urRequestforFunds&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_RequestforFunds;?></a></div>

<div class='button1'><a href="./main.php?option=RequestforProcurement&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_RequestforProcurement;?></a></div>

 <?php }?>
                                                     </td>

                                                    </tr>
                                                  <?php } //End Loop?>
                                                  
                                                </table>
                                                <?php } //End Loop?>
              </div><!-- /.table-responsive -->
				   
