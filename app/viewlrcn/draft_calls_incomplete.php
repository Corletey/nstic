<h4 class="niceheaders success"><b><?php echo $lang_Drafts;?></b></h4>
<?php
if($mysqli->real_escape_string($_GET['action'])=='delete'){
$delete="DELETE from ".$prefix."grantcalls where grantID='$id'";
$mysqli->query($delete);

$sqlAUpdate="DELETE from ".$prefix."concept_dynamic_stages where `grantcallID`='$id'";
$mysqli->query($sqlAUpdate);

$sqlAUpdate2="DELETE from ".$prefix."grantcall_categories where `grantID`='$id' and catadmin_id='$usrm_id'";
$mysqli->query($sqlAUpdate2);

$sqlAUpdate233="DELETE from ".$prefix."grantcall_categories where status='new' and `grantID`='$id' and catadmin_id='$usrm_id'";
$mysqli->query($sqlAUpdate233);
/////Update sections
$sqlAUpdate22="DELETE from ".$prefix."concept_dynamic_questions_all_a where `grantID`='$id'";
$mysqli->query($sqlAUpdate22);

$sqlAUpdate23="DELETE from ".$prefix."concept_dynamic_questions_all_b where `grantID`='$id'";
$mysqli->query($sqlAUpdate23);

$sqlAUpdate24="DELETE from ".$prefix."concept_dynamic_questions_all_c where `grantID`='$id'";
$mysqli->query($sqlAUpdate24);

$sqlAUpdate25="DELETE from ".$prefix."concept_dynamic_questions_all_d  where `grantID`='$id'";
$mysqli->query($sqlAUpdate25);	

$sqlAUpdate26="DELETE from ".$prefix."concept_dynamic_questions_all_e where `grantID`='$id'";
$mysqli->query($sqlAUpdate26);

$sqlAUpdate2y="DELETE from ".$prefix."concept_dynamic_questions_all_f where `grantID`='$id'";
$mysqli->query($sqlAUpdate2y);

$sqlAupdate_call="DELETE from ".$prefix."grantcall_questions where `grantID`='$id'";
$mysqli->query($sqlAupdate_call);
}

$page='main.php?';
$url='option=';
$value='DraftCalls';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."grantcalls where (startDate='0000-00-00' || publish='No') order by grantID desc");//and conceptm_status='new' 
}

if(!$_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."grantcalls where (startDate='0000-00-00' || publish='No') order by grantID desc");//and conceptm_status='new' 
}
$row = $query -> fetch_array(MYSQLI_NUM);
$total_pages = $row[0];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $page.$url.$value; 	//your file name  (the name of this file)
$limitm = 15;

//how many items to show per page
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
$sql = "select * FROM ".$prefix."grantcalls  where (startDate='0000-00-00' || publish='No') order by grantID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if(!$_POST['doSearch']){
$sql = "select * FROM ".$prefix."grantcalls  where (startDate='0000-00-00' || publish='No') order by grantID desc LIMIT $start, $limitm";//and conceptm_status='new' 
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
                                                
                                                <tr class="unread" style="font-size:13px;">
                                                
                                                        <th width="265" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                        <th width="359" class="time"><?php echo $lang_Category;?></th>
                                                        <th width="359" class="time"><strong><?php echo $lang_Summary;?></strong></th>
                                                        <th width="216" class="time"><strong><?php echo $lang_EndDate;?></strong></th>
                                                        <th width="219" class="time"><strong><?php echo $lang_Status;?></strong></th>

                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="6"><p><?php echo $lang_no_results_displayed;?></p></td>
                                                    </tr>
                                                    <?php }else{
while($rFLists2=$result->fetch_array()){

															  ?>
                                                    <tr class="unread" style="font-size:13px;">
                                                
                                                        <td width="265" class="small-col"><strong><?php echo $rFLists2['title'];?></strong></td>
                                                        <td width="359" class="time"><strong><?php if($rFLists2['category']=='proposals'){ echo "$lang_Proposals";}?>
                                                        <?php if($rFLists2['category']=='concepts'){ echo "$lang_Concepts";}?></strong></td>
                                                        <td width="359" class="time"><strong><?php echo $rFLists2['summary'];?></strong></td>
                                                        <td width="216" class="time"><strong><?php echo $rFLists2['EndDate'];?></strong></td>
                                                        <td width="219" class="time"> 

                                                        
   <?php if($rFLists2['category']=='concepts'  and $_SESSION['usrm_id']==$rFLists2['grant_adminID']){?>
    <span  class="button1"><a href="./main.php?option=DynamicCallConcepts&id=<?php echo $rFLists2['grantID'];?>&action=update" onclick="return confirm('Are you sure you want to UPDATE/EDIT this concept? Users wont be able to see it once in edit mode until you submit again. Click OK to confirm or CANCEL.');"><?php echo $lang_ClicktoUpdateSubmission;?></a></span><br />
    
    
    <span  class="button2"><a href="./main.php?option=DraftCalls&id=<?php echo $rFLists2['grantID'];?>&action=delete" onclick="return confirm('Are you sure you want to DELETE this concept?');"><?php echo $lang_Delete;?></a></span>
<?php }?>


<?php if($rFLists2['category']=='proposals'){?>
    <span  class="button1"><a href="./main.php?option=DynamicCallProposals&id=<?php echo $rFLists2['grantID'];?>&action=update" onclick="return confirm('Are you sure you want to UPDATE/EDIT this concept? Users wont be able to see it once in edit mode until you submit again. Click OK to confirm or CANCEL.');"><?php echo $lang_ClicktoUpdateSubmission;?></a></span><br />
    
    <span  class="button2"><a href="./main.php?option=DraftCalls&id=<?php echo $rFLists2['grantID'];?>&action=delete" onclick="return confirm('Are you sure you want to DELETE this concept?');"><?php echo $lang_Delete;?></a></span>
    
    
    
<?php }?>


                                                        
                                                        
                                                        </td>

                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="6">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                </table>
</div><!-- /.table-responsive -->