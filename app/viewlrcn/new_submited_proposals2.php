 <?php
  
$sql44 = "select * FROM ".$prefix."grantcalls where grantID='$id'";//and conceptm_status='new' 
$result44 = $mysqli->query($sql44);
$rFLists24=$result44->fetch_array()
 ?>
 
 <h4 class="niceheaders"><?php echo $rFLists24['title'];?></h4><hr />
 
 <?php 
$category=$_POST['category'];
$pages='main.php?option=';
$url='AllNewProposals&id='.$id;
$value='';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals where (finalSubmission='Made Final Submission' || finalSubmission='Pending Final Submission')  and grantcallID='$id' order by conceptID desc");//and conceptm_status='new' 
}

if(!$_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals where (finalSubmission='Made Final Submission' || finalSubmission='Pending Final Submission') and grantcallID='$id' order by conceptID desc");//and conceptm_status='new' 
}
$row = $query -> fetch_array(MYSQLI_NUM);
$total_pages = $row[0];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
$limitm = 15;

/*Extract Last Value from a link*/
$page = $_GET['page'];

/*Extract Last Value from a link*/
/*$RequestURI=end(explode("/", $_SERVER['REQUEST_URI']));
$page = preg_replace('/\D/', '', $RequestURI);*/




								//how many items to show per page
if($page) 
$start = ($page - 1) * $limitm; 			//first item to display on this page
else
$start = 0;								//if no page var is given, set start to 0

/* Get data. */
if($_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where (finalSubmission='Made Final Submission' || finalSubmission='Pending Final Submission') and grantcallID='$id' order by conceptID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if(!$_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where (finalSubmission='Made Final Submission' || finalSubmission='Pending Final Submission') and grantcallID='$id' order by conceptID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}
$result = $mysqli->query($sql);

/* Setup page vars for display. */
if ($page == 0) $page = 1;					//if no page var is given, default to 1.
$prev = $page - 1;							//previous page is page - 1
$next = $page + 1;							//next page is page + 1
$lastpage = ceil($total_pages/$limitm);		//lastpage is = total pages / items per page, rounded up.
$lpm1 = $lastpage - 1;						//last page minus 1

/* 
Now we apply our rules and draw the pagination object. 
We're actually saving the code to a variable in case we want to draw it more than once.
*/
$pagination = "";
if($lastpage > 1)
{	
$pagination .= "<div class=\"pagination\">";
//previous button
if ($page > 1) 
$pagination.= "<a href=\"$targetpage&page=$prev\">&laquo;previous</a>";
else
$pagination.= "<span class=\"disabled\">&laquo;previous</span>";	

//pages	
if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
{	
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<span class=\"current\">$counter</span>";
else
$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
}
}
elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
{
//close to beginning; only hide later pages
if($page < 1 + ($adjacents * 2))		
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<span class=\"current\">$counter</span>";
else
$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
}
$pagination.= "...";
$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
}
//in middle; hide some front and some back
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
$pagination.= "...";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<span class=\"current\">$counter</span>";
else
$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
}
$pagination.= "...";
$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
}
//close to end; only hide early pages
else
{
$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
$pagination.= "...";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<span class=\"current\">$counter</span>";
else
$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
}
}
}

//next button
if ($page < $counter - 1) 
$pagination.= "<a href=\"$targetpage&page=$next\">next&raquo;</a>";
else
$pagination.= "<span class=\"disabled\">next&raquo;</span>";
$pagination.= "</div>";		
}
		  ?>
 <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table width="100%" class="table table-mailbox">
                                                
                                                
                                                  <tr>
 <td class="small-col" colspan="7">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                
                                                    <tr class="unread">
                                                      <th width="268" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                      <th width="206" class="name"><strong><?php echo $lang_Name_of_Institution;?></strong></th>
                                                        <th width="161" class="subject"><strong><?php echo $lang_Submittedby;?></strong></th>
                                                        <th width="100" class="time"><strong><?php echo $lang_Date;?></strong></th>
                                                        <th width="151" class="time"><strong><?php echo $lang_Status;?></strong></th>
                                                        <th width="165" class="time">Score</th>
                                                        <th width="165" class="time"><strong><?php echo $lang_Action;?></strong></th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="7"><p><?php echo $lang_no_results_displayed;?></p></td>
                                                    </tr>
                                                    <?php }else{
while($rFLists2=$result->fetch_array()){
$owner_id=$rFLists2['owner_id'];
$projectID=$rFLists2['projectID'];
$conceptID=$rFLists2['conceptID'];
$grantcallID=$rFLists2['grantcallID'];
$projectStatus=$rFLists2['projectStatus'];
$dynamic=$rFLists2['dynamic'];

$queryDistrictsMain="select * from ".$prefix."musers where usrm_id='$owner_id'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$rFListsOnwner=$R_DMain->fetch_array();
//review_proposals
$wmConfirm="select * from ".$prefix."review_proposals where  owner_id='$owner_id' and status='new'";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$rConfirm= $cmdwbConfirm->fetch_array();
$confirmedID=$rConfirm['id'];
if($rConfirm['ProjectInformation']>=1 and $rConfirm['Background']>=1 and $rConfirm['Methodology']>=1 and $rConfirm['ProjectResults']>=1 and $rConfirm['PrincipalInvestigator']>=1 and $rConfirm['ProjectManagement']>=1 and $rConfirm['Followup']>=1 and $rConfirm['Budget']>=1 and $rConfirm['conceptAttachments']>=1 and $rConfirm['cReferences']>=1){

//$wmConfirmUpdated="update ".$prefix."review_proposals set status='completed' where  owner_id='$owner_id' and id='$confirmedID'";
//$mysqli->query($wmConfirmUpdated);
}

if($dynamic=='No'){
$sqlwwScores = "select *,count(EvaluatedBy) AS TotalReviewers,sum(EvTotalScore) AS Total FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$projectID'  and categorym='proposals'  and grantID='$grantcallID' group by conceptm_id order by scoredmID desc limit 0,60";
$resultwwScores = $mysqli->query($sqlwwScores);
$rFListsScores=$resultwwScores->fetch_array();

$sqlwwScores2 = "select DISTINCT(EvaluatedBy) AS TotalReviewers FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$projectID'  and categorym='proposals'  and grantID='$grantcallID' group by EvaluatedBy order by scoredmID desc";
$resultwwScores2 = $mysqli->query($sqlwwScores2);
$rFListsScores2=$resultwwScores2->fetch_array();
$TotalReviewers=$resultwwScores2->num_rows;

if($rFListsScores['Total']){$TotalScore=($rFListsScores['Total']/$TotalReviewers);}///$rFListsScores['TotalReviewers']
}



	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();

$queryHalted="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DHalted=$mysqli->query($queryHalted);	
$rFListsHalted=$R_DHalted->fetch_array();

$queryStudy="select * from ".$prefix."appeal_halted_studies where projectID='$projectID' order by id desc limit 0,1";
$RStudy=$mysqli->query($queryStudy);	
$rFListsStudy=$RStudy->fetch_array();
//grantcalls 
$queryGrants="select * from ".$prefix."grantcalls where grantID='$grantcallID' order by grantID desc limit 0,1";
$RSGrants=$mysqli->query($queryGrants);	
$rowsGrants=$RSGrants->fetch_array();

															  ?>
                                                    <tr>
                                                      <td class="small-col"><?php echo $rFLists2['projectTitle'];?><br />
                                                       RefNo: <strong><?php echo $rFLists2['referenceNo'];?></strong>
                                                      
                                                      </td>
                                                      <td class="name"><?php echo $rFLists2['HostInstitution'];?></td>
                                                        <td class="subject">
                                                        Name: <?php echo $rFListsOnwner['usrm_fname'];?> <?php echo $rFListsOnwner['usrm_sname'];?><br />
                                                        Email: <?php echo $rFListsOnwner['usrm_email'];?><br />
                                                        Phone: <?php echo $rFListsOnwner['usrm_phone'];?>                                                        </td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['updatedonm'];?>                                                        </td>
                                                      <td class="name">
                                         
                                                      
  <?php if($rFLists2['projectStatus']=='Pending Final Submission'){?><div class="btn-info-black"><?php echo $lang_PendingFinalSubmission;?></div><?php }?>
  <?php if($rFLists2['projectStatus']=='Approved'){?><div class="btn-info-blue"><?php echo $lang_ApprovedforReview;?></div><?php }?>
  <?php if($rFLists2['projectStatus']=='Rejected' || $rFLists2['projectStatus']=='Completeness Check-Rejected'){?><div class="btn-info-red"><?php echo $lang_Rejected;?></div><?php }?>
  <?php if($rFLists2['projectStatus']=='Pending Review'){?><div class="btn-info-blue"><?php echo $lang_PendingReview;?></div><?php }?>
  <?php if($rFLists2['projectStatus']=='Reviewed'){?><div class="btn-info-blue"><?php echo $lang_Reviewed;?></div><?php }?>
  <?php if($rFLists2['projectStatus']=='Scheduled for Review'){?><div class="btn-info-blue"><?php echo $lang_Scheduled_for_Review;?></div><?php }?>
  
  
  </td>
                                                      <td class="time">
                                                      
<?php
if($dynamic=='Yes' || $dynamic==''){
$sqlwwScores = "select usrm_id,sum(EvTotalScore) AS Total,conceptm_id FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$projectID'  and categorym='proposals'  and grantID='$grantcallID'  and openstatus='closed' group by conceptm_id order by conceptm_id desc";
$resultwwScores = $mysqli->query($sqlwwScores);
$rFListsScores=$resultwwScores->fetch_array();

$sqlwwScores2 = "select DISTINCT(EvaluatedBy) AS TotalReviewers FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$projectID'  and categorym='proposals'  and grantID='$grantcallID' and openstatus='closed' group by EvaluatedBy order by EvaluatedBy desc";
$resultwwScores2 = $mysqli->query($sqlwwScores2);
$rFListsScores2=$resultwwScores2->fetch_array();
$TotalReviewers=$resultwwScores2->num_rows;

///Dirty
$sqlwwScores3 = "select scoredmID,EVivaScore FROM ".$prefix."mscores_dynamic where usrm_id='$owner_id' and conceptm_id='$projectID'  and categorym='proposals'  and grantID='$grantcallID'  and openstatus='closed' order by scoredmID desc";
$resultwwScores3 = $mysqli->query($sqlwwScores3);
$rFListsScores3=$resultwwScores3->fetch_array();

if($rFListsScores['Total']){$TotalScore=($rFListsScores['Total']/$TotalReviewers);
?><strong style="font-size:24px; font-weight:bold; color:#F00;"><?php echo round($TotalScore,2);?>%</strong><br />
<?php 
}///$rFListsScores['TotalReviewers']
}?> 
                                                      
                                                      
                                                      
                                                      
   
   <?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['haltstudy']!='Yes' and $rFLists2['awarded']=='Yes'){?> 
   <input id="go" type="button" value="Halt this Study" onclick="window.open('haltstudies.php?id=<?php echo $rFLists2['projectID'];?>&owner_id=<?php echo $rFLists2['owner_id'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="button2" >
   <?php }?>
   
   
   <?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['haltstudy']=='Yes'){?> 
   <input id="go" type="button" value="Study Halted" onclick="window.open('haltstudies.php?id=<?php echo $rFLists2['projectID'];?>&owner_id=<?php echo $rFLists2['owner_id'];?>&act=<?php echo $rFListsStudy['id'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-purple" >
   <?php }?>
   
   
  <?php // and $rFLists2['invitedforviva']!='Yes'
     if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['invitedforviva']!='Yes' and $rowsGrants['end_review']=='Yes'){?>
                                          
<input id="go" type="button" value="Invite for Viva Score" onclick="window.open('invitevivascore.php?id=<?php echo $rFLists2['projectID'];?>&owner_id=<?php echo $rFLists2['owner_id'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-purple" >

<?php }?>

 <?php // and $rFLists2['invitedforviva']!='Yes'
     if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['invitedforviva']=='Yes' and $rowsGrants['end_review']=='Yes'){?>
                                          
<input id="go" type="button" value="Re-Invite for Viva Score" onclick="window.open('invitevivascore.php?id=<?php echo $rFLists2['projectID'];?>&owner_id=<?php echo $rFLists2['owner_id'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-purple" >

<?php }?>

 <?php 
     if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['invitedforviva']=='Yes' and $rowsGrants['end_review']=='Yes'){?>
<input id="go" type="button" value="Add Viva Score <?php echo $rFListsScores3['EVivaScore'];?>%" onclick="window.open('addvivascore.php?ds=<?php echo $rFListsScores3['scoredmID']; ?>&grantID=<?php echo $rFLists2['grantcallID'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-purple" >

<?php }?>
                                                      
  <?php
if($dynamic=='No'){
$queryCategoryReview="select * from ".$prefix."mscores_new where conceptm_id='$projectID' and usrm_id='$owner_id'  and categorym='proposals' group by EvaluatedBy order by scoredmID";
$R_CategoryReview=$mysqli->query($queryCategoryReview);	
while($rCReview=$R_CategoryReview->fetch_array()){
	 $EvaluatedBy=$rCReview['EvaluatedBy']; 
	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();
	
	?>
    <?php if($TotalScore and $rFListsReviewer['usrm_sname']){?>
<input id="go" type="button" value="<?php echo $rFListsReviewer['usrm_sname'];?> <?php echo $rFListsReviewer['usrm_fname'];?>, View Score" onclick="window.open('adminscoresheet.php?id=<?php echo $EvaluatedBy;?>&ds=<?php echo $rCReview['scoredmID'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-blue" ><br /><?php }?>                                                
                                                    
 <?php }
 
}///end No

if($dynamic=='Yes' || $dynamic==''){
$queryCategoryReview="select EvaluatedBy,conceptm_id,usrm_id,grantID from ".$prefix."mscores_dynamic where conceptm_id='$projectID' and usrm_id='$owner_id'  and categorym='proposals'  and grantID='$grantcallID' and openstatus='closed' group by EvaluatedBy order by EvaluatedBy";
$R_CategoryReview=$mysqli->query($queryCategoryReview);	
while($rCReview=$R_CategoryReview->fetch_array()){
$EvaluatedBy=$rCReview['EvaluatedBy'];
	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();
	
	?>
    <?php if($TotalScore and $rFListsReviewer['usrm_sname']){?>
<input id="go" type="button" value="<?php echo $rFListsReviewer['usrm_sname'];?> <?php echo $rFListsReviewer['usrm_fname'];?>, View Score" onclick="window.open('scoresheetdynamic.php?id=<?php echo $EvaluatedBy;?>&ds=<?php echo $rCReview['scoredmID'];?>&grantID=<?php echo $grantcallID;?>&dconceptID=<?php echo $projectID;?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-blue" ><br /><?php }?>                                                
                                                    
 <?php }
 
}///end No
?>       
                                            
                                                      
                                                      
                                                      </td>
<td class="time">

<?php if(($rFLists2['projectStatus']=='Pending Review' || $rFLists2['projectStatus']=='Completeness Check-Approved' || $rFLists2['projectStatus']=='Completeness Check-Rejected') and $rowsGrants['dynamic']=='Yes'){?><div  class='button3'><a href="./main.php?option=newreviewPrososal&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_ClicktoReviewProposal;?></a></div> <?php }?>


<?php if($rFLists2['projectStatus']=='Pending Review' and $rowsGrants['dynamic']=='No'){?><div  class='button3'><a href="./main.php?option=reviewPrososal&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>"><?php echo $lang_ClicktoReviewProposal;?></a></div> <?php }?>




<?php if($rFLists2['projectStatus']=='Reviewed'){?><div  class='button3'><a href="./main.php?option=reviewPrososal&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>" ><?php echo $lang_ClicktoViewDetails;?></a></div> <?php }?>



<?php if($rFLists2['projectStatus']=='Approved'){?><div  class='button3'><a href="./main.php?option=reviewPrososal&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>" ><?php echo $lang_FowardforReview;?></a></div> <?php }?>

<?php if($rFLists2['projectStatus']=='Scheduled for Review'  and $rowsGrants['dynamic']=='No'){?><div  class='button3'><a href="./main.php?option=reviewPrososal&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>" ><?php echo $lang_Reassign;?><?php echo $lang_ClicktoReviewProposal;?></a></div> <?php }?>

<?php if($rFLists2['projectStatus']=='Scheduled for Review'  and $rowsGrants['dynamic']=='Yes'){?><div  class='button3'><a href="./main.php?option=newreviewPrososal&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantcallID'];?>" ><?php echo $lang_Reassign;?></a></div> <?php }?>





<?php if($rowsGrants['end_review']=='Yes' and $rFLists2['awarded']!='Yes' and ($rFLists2['projectStatus']=='Reviewed' || $rFLists2['projectStatus']=='Approved')){?>
<input id="go" type="button" value="<?php echo $lang_ClicktoAwardGrant;?>" onclick="window.open('<?php echo $base_url;?>awardgrant.php?id=<?php echo $rFLists2['projectID'];?>&categorym=proposals&owner_id=<?php echo $owner_id;?>&grantID=<?php echo $rFLists2['grantcallID'];?>','popUpWindow','height=500, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="button2" >

<?php }?>

<?php if($rowsGrants['end_review']=='Yes' and $rFLists2['awarded']=='Yes'){?>
<div class='btn-info-purple'><a href="<?php echo $base_url;?>main.php?option=proposalNewSubmissionsMain"><?php echo $lang_GrantsAwarded;?></a></div>
<?php }?>

</td>
                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="7">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                </table>
</div><!-- /.table-responsive -->
