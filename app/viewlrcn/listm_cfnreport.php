<?php
 //include("viewlrcn/proposals_statistics.php");
 ?>
 
 <h4 class="niceheaders"><?php echo $lang_all_submission;?></h4><hr />
 <span  class="button2" style="float:left; padding:10px;"><a href="exportreports.php"> <?php echo $lang_ExportResults;?></a></span>
 
 
 <div style="clear:both;"></div>
 <?php
$sqlGroupDIspCN="SELECT * FROM ".$prefix."categories order by rstug_categoryName asc";
$sqlFGrpDisCN=$mysqli->query($sqlGroupDIspCN);
$totalUserF = $sqlFGrpDisCN->num_rows;
$cc=1;
while($rGRSPCv=$sqlFGrpDisCN->fetch_array())
{
	$rstug_categoryID=$rGRSPCv['rstug_categoryID'];
	
	$sqlConcepts2="SELECT * FROM ".$prefix."submissions_proposals where researchTypeID='$rstug_categoryID' order by projectID desc";
$queryConcepts2=$mysqli->query($sqlConcepts2);
$TotalC_submitted2 = $queryConcepts2->num_rows;
	
	$ho=$cc++;
?>
<div class="col-mm10 halfgraph3"><?php echo $ho;?>. <?php if($base_lang=='en'){echo $rGRSPCv['rstug_categoryName'];}
if($base_lang=='fr'){echo $rGRSPCv['rstug_categoryName_fr'];}
if($base_lang=='pt'){echo $rGRSPCv['rstug_categoryName_pt'];}?> <strong><a href="./main.php?option=Reports&id=<?php echo $rGRSPCv['rstug_categoryID'];?>">[<?php echo ($TotalC_submitted2);?>]</a></strong></div>

<?php }?>
<div style="clear:both;"></div>


 <?php 
$category=$_POST['category'];
$page='main.php?';
$url='option=';
$value='Reports&id='.$id;
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($id){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals where researchTypeID='$id' order by projectID desc");//and conceptm_status='new' 
}

if(!$id){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals order by projectID desc");//and conceptm_status='new' 
}

$row = $query -> fetch_array(MYSQLI_NUM);
$total_pages = $row[0];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $page.$url.$value; 	//your file name  (the name of this file)
if($_POST['doSearch']){
$limitm = 40;
}
if(!$_POST['doSearch']){
$limitm = 15;
}
//how many items to show per page

/*Extract Last Value from a link*/
$RequestURI = explode("/", $_SERVER['REQUEST_URI']);
$RequestURI = end($RequestURI); // Get the last part of the URI

$page = filter_var(preg_replace('/\D/', '', $RequestURI), FILTER_VALIDATE_INT);
$page = ($page) ? $page : 1; // Default to 1 if invalid or empty


/*Extract Last Value from a link*/
/*$RequestURI=end(explode("/", $_SERVER['REQUEST_URI']));
$page = preg_replace('/\D/', '', $RequestURI);*/




								//how many items to show per page
if($page) 
$start = ($page - 1) * $limitm; 			//first item to display on this page
else
$start = 0;								//if no page var is given, set start to 0

/* Get data. */
if($id){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where researchTypeID='$id' order by projectID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if(!$id){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals order by projectID desc LIMIT $start, $limitm";//and conceptm_status='new' 
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
 <td class="small-col" colspan="5">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                
                                                    <tr class="unread">
                                                      <th width="268" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                      <th width="206" class="name"><strong><?php echo $lang_Call;?></strong></th>
                                                        <th width="161" class="subject"><strong><?php echo $lang_Submittedby;?></strong></th>
                                                        <th width="100" class="time"><strong><?php echo $lang_Date;?></strong></th>
                                                        <th width="151" class="time"><strong><?php echo $lang_Status;?></strong></th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="5"><p><?php echo $lang_no_results_displayed;?></p></td>
                                                    </tr>
                                                    <?php }else{
while($rFLists2=$result->fetch_array()){
$owner_id=$rFLists2['owner_id'];
$projectID=$rFLists2['projectID'];
$conceptID=$rFLists2['conceptID'];
$grantID=$rFLists2['grantcallID'];


$queryDistrictsMain="select * from ".$prefix."musers where usrm_id='$owner_id'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$rFListsOnwner=$R_DMain->fetch_array();

$queryDistrictsMain2="select * from ".$prefix."grantcalls where grantID='$grantID'";
$R_DMain2=$mysqli->query($queryDistrictsMain2);	
$rFListsOnwner2=$R_DMain2->fetch_array(); 	





															  ?>
                                                    <tr>
                                                      <td class="small-col"><?php echo $rFLists2['projectTitle'];?><br />
                                                       RefNo: <strong><?php echo $rFLists2['referenceNo'];?></strong>
                                                      
                                                      </td>
                                                      <td class="name"><?php echo $rFListsOnwner2['title'];?></td>
                                                        <td class="subject">
                                                        <?php echo $rFListsOnwner['usrm_fname'];?> <?php echo $rFListsOnwner['usrm_sname'];?><br />
                                                        <?php echo $rFListsOnwner['usrm_email'];?><br />
                                                        <?php echo $rFListsOnwner['usrm_phone'];?>                                                        </td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['updatedonm'];?>                                                        </td>
                                                      <td class="name">
                                                        
                                                        
                                                        <?php if($rFLists2['projectStatus']=='Pending Final Submission'){?><div class="btn-info-black"><?php echo $lang_PendingFinalSubmission;?></div><?php }?>
                                                        <?php if($rFLists2['projectStatus']=='Approved'){?><div class="btn-info-blue"><?php echo $lang_ApprovedforReview;?></div><?php }?>
                                                        <?php if($rFLists2['projectStatus']=='Rejected'){?><div class="btn-info-red"><?php echo $lang_Rejected;?></div><?php }?>
                                                        <?php if($rFLists2['projectStatus']=='Pending Review'){?><div class="btn-info-blue"><?php echo $lang_PendingReview;?></div><?php }?>
             <?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['awarded']=='No'){?><div class="btn-info-blue"><?php echo $lang_Reviewed;?></div><?php }?>
             <?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['awarded']=='Yes'){?><div class="btn-info-blue"><?php echo $lang_Grants_Awarded;?></div>
			 
			 <div class="btn-info-purple"><?php echo numberformat($rFLists2['AmountofGrantawarded']);?> <?php echo $rFLists2['currency'];?></div>
			 
			 <?php }?>
             
                                                        <?php if($rFLists2['projectStatus']=='Scheduled for Review'){?><div class="btn-info-blue"><?php echo $lang_Scheduled_for_Review;?></div><?php }?>
                                                        
                                                        <?php if($rFLists2['projectStatus']=='Completeness Check-Approved'){?><div class="btn-info-blue"><?php echo $lang_CompletenessCheckApproved;?></div><?php }?>
                                                        <?php if($rFLists2['projectStatus']=='Completeness Check-Rejected'){?><div class="btn-info-blue"><?php echo $lang_CompletenessCheckRejected;?></div><?php }?>
                                                        
                                                        
                                                        	 
                                                        
                                                      </td>
                                                  </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="5">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                </table>
</div><!-- /.table-responsive -->
