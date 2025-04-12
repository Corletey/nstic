 <?php
 //include("viewlrcn/proposals_statistics.php");
 ?>
 
 <h4 class="niceheaders"><?php echo $lang_AnylysisofReviewers;?></h4>
 

 
<div style="clear:both;"></div>

 <?php 
$category=$_POST['category'];
$page='main.php?';
$url='category=';
$value='AnylysisofReviewers&id='.$id;
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."musers where usrm_usrtype='reviewer' order by usrm_fname asc");//and conceptm_status='new' 

$row = $query -> fetch_array(MYSQLI_NUM);
$total_pages = $row[0];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $page.$url.$value; 	//your file name  (the name of this file)
$limitm = 50;
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
$sql = "select * FROM ".$prefix."musers where usrm_usrtype='reviewer' order by usrm_fname asc LIMIT $start, $limitm";//and conceptm_status='new' 

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
 <td class="small-col" colspan="4">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                
                                                    <tr class="unread">
                                                      <th width="268" class="small-col"><strong><?php echo $lang_ReviewName;?></strong></th>
                                                      <th width="206" class="name"><strong><?php echo $lang_SubmissionsAssigned;?></strong></th>
                                                        <th width="161" class="subject"><strong><?php echo $lang_SubmissionsReviewed;?></strong></th>
                                                        <th width="100" class="time"><strong><?php echo $lang_SubmissionsnotReviewed;?></strong></th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="4"><p><?php echo $lang_no_results_displayed;?></p></td>
                                                    </tr>
                                                    <?php }else{
while($rFLists2=$result->fetch_array()){
$owner_id=$rFLists2['usrm_id'];
$projectID=$rFLists2['projectID'];
$conceptID=$rFLists2['conceptID'];
$grantID=$rFLists2['grantcallID'];


/*$queryDistrictsMain="select * from ".$prefix."musers where usrm_id='$owner_id'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$rFListsOnwner=$R_DMain->fetch_array();*/

$queryDistrictsMain2="select * from ".$prefix."conceptsasslogs_new where conceptm_assignedto='$owner_id'  order by assignm_id desc";
$R_DMain2=$mysqli->query($queryDistrictsMain2);	
$total_SubmissionsAssigned = $R_DMain2->num_rows;	

$queryDistrictsMain24="select * from ".$prefix."conceptsasslogs_new where conceptm_assignedto='$owner_id' and logm_status='completed' order by assignm_id desc";
$R_DMain24=$mysqli->query($queryDistrictsMain24);	
$total_SubmissionsReviewed = $R_DMain24->num_rows;

$queryDistrictsMain245="select * from ".$prefix."conceptsasslogs_new where conceptm_assignedto='$owner_id' and logm_status='new' order by assignm_id desc";
$R_DMain245=$mysqli->query($queryDistrictsMain245);	
$total_SubmissionsnotReviewed = $R_DMain245->num_rows;




															  ?>
                                                    <tr>
                                                      <td class="small-col"><?php echo $rFLists2['usrm_fname'];?> <?php echo $rFLists2['usrm_sname'];?>
                                                      
                                                      </td>
                                                      <td class="name"><?php echo $total_SubmissionsAssigned;?></td>
                                                        <td class="subject"><?php echo $total_SubmissionsReviewed;?></td>
                                                        <td class="time"><?php echo $total_SubmissionsnotReviewed;?></td>
                                                  </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="4">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                </table>
</div><!-- /.table-responsive -->
