
<?php 
if($session_usertype=='superadmin' || $session_usertype=='admin'){?>  
 <div class="table-responsive">
 <h4 class="niceheaders">Admins</h4>
                                    <table id="customers">
                                      <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>Full Name</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th width="10%">Role</th>
                                                <th width="10%">Photo</th>
                                            </tr>
                                        </thead>
                              
                         <?php
  //main.php?option=publications/
/*$pages='details.php?';
$url='option=publications';*/

$pages='main.php?option=';
$url='admins/'.$id.'/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;

/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/ 
echo "Reached Here";
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."musers where (usrm_usrtype='superadmin' || usrm_usrtype='admin') order by usrm_fname asc");
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
$sql = "select *,DATE_FORMAT(`usrm_updated`,'%W, %D %M %Y') AS cfn_regdatem from ".$prefix."musers where (usrm_usrtype='superadmin' || usrm_usrtype='admin') order by usrm_fname asc LIMIT $start, $limitm";
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
while($sq =$result->fetch_array())
{
	
	?>
                   <tbody>
                                            <tr>
                                                <td valign="top"><img src="img/edit.gif" /> <a href="./main.php?option=upusers&id=<?php echo $sq['usrm_id'];?>">Update Details</a>
                                                </td>
                                                <td><?php echo $sq['usrm_fname'];?></td>
                                                <td><?php echo $sq['usrm_username'];?></td>
                                                <td><?php echo $sq['usrm_email'];?></td>
                                                <td><?php echo $sq['usrm_phone'];?></td>
                                                <td align="left">
<span style="color:#F00; font-weight:bold; font-size:12px;"><?php if($sq['usrm_usrtype']=='superadmin'){echo "Superadmin";}?></span>
<span style="color:#093; font-weight:bold; font-size:12px;"><?php if($sq['usrm_usrtype']=='admin'){echo "Grants Office";}?></span>

<span style="color:#093; font-weight:bold; font-size:12px;"><?php if($sq['usrm_usrtype']=='reviewer'){echo "Reviewer";}?></span>

<span style="color:#09F; font-weight:bold; font-size:12px;"><?php if($sq['usrm_usrtype']=='user'){echo "Applicant";}?></span>
                                                
                                                
                                                </td>
                                                <td align="right"><?php if($sq['usrm_profilepic']){?><img src="files/photos/thumb_<?php echo $sq['usrm_profilepic'];?>"  style="border:1px solid #CCC; padding:2px; width:100px; overflow:hidden;"/><?php }?>  </td>
                                            </tr>
<?php }?>
</tbody>

<tr>
<td colspan="7"><div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>

</div><!--end purgination section-->
</td>
</tr>
  </table>
        </div><!-- /.box-body -->

                      <?php }?>                     
     