<?php 
include("viewlrcn/user_dashboard2.php");

$sql = "select * FROM ".$prefix."submissions_concepts where owner_id='$usrm_id' order by conceptID desc limit 0,10";
$result = $mysqli->query($sql);
$total_pages = $result->num_rows;
if(!$total_pages){}
if($total_pages){
		  ?>
           
 <div class="table-responsive">

                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox" width="100%">
                                                    <tr class="unread" style="font-size:16px;">
                                                
                                                        <th width="692" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                        <th width="120" class="time"><strong><?php echo $lang_Score;?></strong></th>
                                       
                                                        <th width="269" class="time"><strong><?php echo $lang_Status;?></strong></th>

                                                    </tr>
                                         

<?php while($rFLists2=$result->fetch_array()){
							  //Check whether something was posted
$conceptID=$rFLists2['conceptID'];
$grantcallID=$rFLists2['grantcallID'];


$sqlCalls = "select * FROM ".$prefix."grantcalls where grantID='$grantcallID' order by grantID desc";
$resultCalls = $mysqli->query($sqlCalls);
$rFListsScoresCalls=$resultCalls->fetch_array();
							  
$sqlww = "select * FROM ".$prefix."submissions_proposals where owner_id='$usrm_id' and conceptID='$conceptID' order by projectID desc limit 0,10";
$resultww = $mysqli->query($sqlww);

$grantcallID=$rFLists2['grantcallID'];
$dynamic=$rFLists2['dynamic'];
$owner_id=$rFLists2['owner_id'];


if($dynamic=='No'){
$sqlwwScores = "select *,count(EvaluatedBy) AS TotalReviewers,sum(EvTotalScore) AS Total FROM ".$prefix."mscores_new where usrm_id='$owner_id' and conceptm_id='$conceptID'  and categorym='concepts' group by conceptm_id order by scoredmID desc limit 0,60";
$resultwwScores = $mysqli->query($sqlwwScores);
$rFListsScores=$resultwwScores->fetch_array();

$sqlwwScores2 = "select DISTINCT(EvaluatedBy) AS TotalReviewers FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$conceptID'  and categorym='concepts' group by EvaluatedBy order by scoredmID desc";
$resultwwScores2 = $mysqli->query($sqlwwScores2);
$rFListsScores2=$resultwwScores2->fetch_array();
$TotalReviewers=$resultwwScores2->num_rows;
$EvaluatedBy=$rFListsScores['EvaluatedBy'];

if($rFListsScores['Total']){$TotalScore=($rFListsScores['Total']/$TotalReviewers);}///$rFListsScores['TotalReviewers']
}

if($dynamic=='Yes'){
$sqlwwScores = "select conceptm_id,sum(EvTotalScore) AS Total FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$conceptID'  and categorym='concepts' group by conceptm_id order by conceptm_id desc";
$resultwwScores = $mysqli->query($sqlwwScores);
$rFListsScores=$resultwwScores->fetch_array();
$EvaluatedBy=$rFListsScores['EvaluatedBy']; 

$sqlwwScores2 = "select DISTINCT(EvaluatedBy) AS TotalReviewers FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$conceptID'  and categorym='concepts' group by EvaluatedBy order by conceptm_id desc";
$resultwwScores2 = $mysqli->query($sqlwwScores2);
$rFListsScores2=$resultwwScores2->fetch_array();
$TotalReviewers=$resultwwScores2->num_rows;

if($rFListsScores['Total']){$TotalScore=($rFListsScores['Total']/$TotalReviewers);}///$rFListsScores['TotalReviewers']

}
							  ?>
                                                   <tr class="unread" style="font-size:13px;">
                                                
                                                        <td width="692" class="small-col"><p style="font-size:16px;"><?php echo $rFLists2['projectTitle'];?></p></td>
                                                        <td width="120" class="time"><strong style="color:#F00; font-size:22px;"><?php echo $TotalScore;?>%</strong>

<?php
$countRev=0;
if($dynamic=='No'){
$queryCategoryReview="select usrm_id,conceptm_id,EvaluatedBy from ".$prefix."mscores_new where conceptm_id='$conceptID' and usrm_id='$owner_id'  and categorym='concepts' group by EvaluatedBy order by EvaluatedBy";
$R_CategoryReview=$mysqli->query($queryCategoryReview);	
while($rCReview=$R_CategoryReview->fetch_array()){
	$countRev++;
	 $EvaluatedBy=$rCReview['EvaluatedBy']; 
	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();
	
	?>
    <?php if($TotalScore and $rFListsReviewer['usrm_sname']){?>
<input id="go" type="button" value="<?php echo $lang_Reviewer;?> <?php echo $countRev;?> View Score" onclick="window.open('adminscoresheet.php?id=<?php echo $EvaluatedBy;?>&ds=<?php echo $rCReview['scoredmID'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-blue" ><br /><?php }?>                                                
                                                    
 <?php }
 
}///end No

if($dynamic=='Yes'){
$queryCategoryReview="select usrm_id,conceptm_id,EvaluatedBy from ".$prefix."mscores_dynamic where conceptm_id='$conceptID' and usrm_id='$owner_id'  and categorym='concepts' group by EvaluatedBy order by EvaluatedBy";
$R_CategoryReview=$mysqli->query($queryCategoryReview);	
while($rCReview=$R_CategoryReview->fetch_array()){
	$countRev++;
	 $EvaluatedBy=$rCReview['EvaluatedBy']; 
	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();
	
	?>
    <?php if($TotalScore and $rFListsReviewer['usrm_sname']){?>
<input id="go" type="button" value="Reviewer <?php echo $countRev;?>, View Score" onclick="window.open('scoresheetdynamic.php?id=<?php echo $EvaluatedBy;?>&ds=<?php echo $rCReview['scoredmID'];?>&grantID=<?php echo $rCReview['grantID'];?>&dconceptID=<?php echo $conceptID;?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-blue" ><br /><?php }?>                                                
                                                    
 <?php }
 
}///end No
?>                                                 
                                                        
                                                        
                                                        </td>
                                           
                                                        <td width="269" class="time">
<?php if($rFLists2['projectStatus']=='Pending Review'){ echo "<span class='button2'>$lang_PendingReview</span>";?><br /><?php }?>

<?php 
if($rFLists2['projectStatus']=='Pending Review' and $rFListsScoresCalls['EndDate']>=$today  and $rFLists2['dynamic']=='No'){?><div class='button4'><a href="./main.php?option=UpdateMySubmitConcept&id=<?php echo $rFLists2['conceptID'];?>"><?php echo $lang_ClicktoUpdateSubmission;?></a></div>
<?php }?>

<?php 
if(($rFLists2['projectStatus']=='Pending Review' || $rFLists2['projectStatus']=='Completeness Check-Resubmission' || $rFLists2['projectStatus']=='Completeness Check-Rejected') and $rFListsScoresCalls['EndDate']>=$today  and $rFLists2['dynamic']=='Yes'){?><div class='button4'><a href="./main.php?option=newConceptMySubmission&id=<?php echo $rFLists2['grantcallID'];?>&conceptID=<?php echo $rFLists2['conceptID'];?>"><?php echo $lang_ClicktoUpdateSubmission;?></a></div>
<?php }?>

<?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['invited_for_proposal']=='invited'){ echo "<span class='button2'><a href='./main.php?option=usrCallforProposals'>$lang_InviteFOrfullProposal</a></span>";}?>
<?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['invited_for_proposal']=='notinvited'){ echo "<span class='button1'>$lang_ConceptHasbeenReviewed</span>";}?>



  <?php if($rFLists2['projectStatus']=='Rejected' || $rFLists2['projectStatus']=='Completeness Check-Rejected'){?>
  
  <input id="go" type="button" value="Rejected, Click to View Comments" onclick="window.open('comments.php?id=<?php echo $rFLists2['conceptID'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-red" >
  
  
  
  <?php }?>
  
<?php if($rFLists2['projectStatus']=='Approved'){ echo "<span class='button1'>$lang_CompletenessCheckApproved</span>";}?>

<?php if($rFLists2['projectStatus']=='Scheduled for Review'){ echo "<span class='button1'>$lang_ConceptHasbeenScheduledforReview</span>";}?>

 <?php if($rFLists2['projectStatus']=='Pending Final Submission' and $rFLists2['dynamic']=='No'){ 
 echo "<span class='button1'>$lang_PendingFinalSubmission</span>";?>                                      
 <div class='button4'><a href="./main.php?option=newSubmitConcept&id=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_ClicktoUpdateConcept;?></a></div><?php }?>
 
  <?php if($rFLists2['projectStatus']=='Pending Final Submission' and $rFLists2['dynamic']=='Yes'){ 
 echo "<span class='button1'>$lang_PendingFinalSubmission</span>";?>                                      
 <div class='button4'><a href="./main.php?option=newConceptMySubmission&id=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_ClicktoUpdateConcept;?></a></div><?php }?>
 
 
  <?php if($rFLists2['projectStatus']!='Pending Final Submission'){?>                                                
<div class='button3'> <a href="./main.php?option=reviewProjectInformation&id=<?php echo $rFLists2['conceptID'];?>"><?php echo $lang_ClicktoViewDetails;?></a></div><?php }?>


<?php if($rFLists2['awarded']=='Yes' and $rFLists2['TermsConditions']=='No'){?>

<input id="go" type="button" value="<?php echo $lang_GrantAwardedclicktoAccept;?>" onclick="window.open('terms_and_condition.php?id=<?php echo base64_encode($rFLists2['conceptID']);?>&categorym=concepts&owner_id=<?php echo $rFLists2['owner_id'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-purple" title="<?php echo $lang_Grant_awarded_toyou;?>"> 

 <?php }?>

    
    
    <?php if($rFLists2['awarded']=='Yes' and $rFLists2['TermsConditions']=='Yes'){?>
<div class='button1'><a href="./main.php?option=urRequestforFundsConcept&id=<?php echo $rFLists2['conceptID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_RequestforFunds;?></a></div>

<div class='button1'><a href="./main.php?option=RequestforProcurementConcept&id=<?php echo $rFLists2['conceptID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_RequestforProcurement;?></a></div>

 <?php }?>
 
 
                                                        </td>

                                                    </tr>
                                                  <?php } //End Loop?>
                                                  
                                                </table>
              </div><!-- /.table-responsive -->
				   
	  <?php

 }
 
 
 
 
 
?>
