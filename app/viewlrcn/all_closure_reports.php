 <h4 class="success">
 <span  class="button2" style="float:right;"><a href="./main.php?option=ClosureReports&id=<?php echo $rFLists2['grantID'];?>"><?php echo $lang_ClosureReports;?></a></span>
 
 
 <b><?php echo $lang_ClosureReports;?></b></h4>
<?php

$page='main.php?';
$url='category=';
$value='ClosureReports&id='.$id;
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."progress_report_signature_page  order by progressID desc");//and conceptm_status='new' 
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
$page = $_GET['pages'];

/*Extract Last Value from a link*/
/*$RequestURI=end(explode("/", $_SERVER['REQUEST_URI']));
$page = preg_replace('/\D/', '', $RequestURI);*/




								//how many items to show per page
if($page) 
$start = ($page - 1) * $limitm; 			//first item to display on this page
else
$start = 0;								//if no page var is given, set start to 0

/* Get data. */
$sql = "select * FROM ".$prefix."progress_report_signature_page order by progressID desc LIMIT $start, $limitm";//and conceptm_status='new' 
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
 <td class="small-col" colspan="6">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                <tr class="unread" style="font-size:13px;">
                                                
                                                        <th width="265" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                        <th width="359" class="time">Project Quarter</th>
                                                        <th width="216" class="time"><strong><?php echo $lang_Status;?></strong></th>
                                                        <th width="219" class="time"><strong><?php echo $lang_Action;?></strong></th>

                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="5"><p><?php echo $lang_no_results_displayed;?></p></td>
                                                    </tr>
                                                    <?php }else{
while($rFLists2=$result->fetch_array()){
	$projectID=$rFLists2['projectID'];
	
$sqlProject="SELECT * FROM ".$prefix."submissions_proposals where projectID='$projectID'";
$sqlFGrProject=$mysqli->query($sqlProject);
$rProject=$sqlFGrProject->fetch_array();
															  ?>
                                                    <tr class="unread" style="font-size:13px;">
                                                
                                                        <td width="265" class="small-col"><strong><?php echo $rProject['projectTitle'];?></strong></td>
                                                        <td width="359" class="time"><strong><?php echo $rFLists2['projectQuarter'];?></strong></td>
                                                        <td width="216" class="time">
                                                        
<?php if($rFLists2['reportStatus']=='Pending'){?><div  class='button3'>Pending</div><?php }?>
<?php if($rFLists2['reportStatus']=='Submitted'){?><div  class='button2'>Submitted</div> <?php }?>
<?php if($rFLists2['reportStatus']=='Approved'){?><div  class='button2'>Approved</div> <?php }?>
<?php if($rFLists2['reportStatus']=='Rejected'){?><div  class='button2'>Request for Revisions</div> <?php }?>
                                                        

                                                        
                                                        </td>
                                                        <td width="219" class="time">
                                                        
<?php if($rFLists2['is_sent']==0){?><span  class="button3"><a href="./main.php?option=submitProgressReport&id=<?php echo $rFLists2['grantID'];?>">Update Report</a></span><?php }?>
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