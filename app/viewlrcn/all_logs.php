
<?php 
if($session_usertype=='superadmin' || $session_usertype=='admin'){?>  
 <div class="table-responsive">
 <h4 class="niceheaders">System Log Activity</h4>
                                    <table id="customers">
                                      <thead>
                                            <tr class="unread">
                                                        <th class="small-col"><strong>Log Details</strong></th>
                                                        <th class="time"><strong><?php echo $lang_Date;?></strong></th>
                                                    </tr>
                                        </thead>
                              
                         <?php
  //main.php?option=publications/
/*$pages='details.php?';
$url='option=publications';*/

$pages='main.php?option=';
$url='Logs';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;

/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/ 
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."mlogs order by lid desc");
$row = $query -> fetch_array(MYSQLI_NUM);
$total_pages = $row[0];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
$limitm = 15;

/*Extract Last Value from a link*/
$page = $_GET['page'];
								//how many items to show per page
if($page) 
$start = ($page - 1) * $limitm; 			//first item to display on this page
else
$start = 0;								//if no page var is given, set start to 0

/* Get data. */
$sql = "select * from ".$prefix."mlogs order by lid desc LIMIT $start, $limitm";
$result = $mysqli->query($sql);
//,DATE_FORMAT(`logdate`,'%d/%m/%Y') AS logdatem
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
$pagination .= "<div class=\"paginationm\">";
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
while($rFLists2 =$result->fetch_array())
{
	
	?>
                   <tbody>
                                        <tr>
                                                        <td class="small-col"><?php echo $rFLists2['log_details'];?> </td>
                                                        <td class="time"><?php echo $rFLists2['logdate'];?> </td>
                                            
                                                    </tr>
<?php }?>
</tbody>

<tr>
<td colspan="2"><div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>

</div><!--end purgination section-->
</td>
</tr>
  </table>
        </div><!-- /.box-body -->

                      <?php }?>                     
     