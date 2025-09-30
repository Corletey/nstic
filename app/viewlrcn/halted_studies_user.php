 <?php
 include("viewlrcn/proposals_statistics.php");
 ?>
 
 <h4 class="success">Halted Studies</h4><hr />
 
 <?php 
 $sessionusrm_id=$_SESSION['usrm_id'];
$category=$_POST['category'];
$page='main.php?';
$url='category=';
$value='HaltedStudiesUser&id='.$id;
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals where haltstudy='Yes' and owner_id='$sessionusrm_id' order by projectID desc");//and conceptm_status='new' 
}

if(!$_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals where haltstudy='Yes' and owner_id='$sessionusrm_id' order by projectID desc");//and conceptm_status='new' 
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
if($_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where haltstudy='Yes' and owner_id='$sessionusrm_id' order by projectID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if(!$_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where haltstudy='Yes' and owner_id='$sessionusrm_id' order by projectID desc LIMIT $start, $limitm";//and conceptm_status='new' 
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
                                                      <th width="206" class="name"><strong><?php echo $lang_Name_of_Institution;?></strong></th>
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


$queryDistrictsMain="select * from ".$prefix."musers where usrm_id='$owner_id'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$rFListsOnwner=$R_DMain->fetch_array();

$sqlwwScores2 = "select *,count(EvaluatedBy) AS TotalReviewers,sum(EvTotalScore) AS Total FROM ".$prefix."mscores_new where usrm_id='$owner_id' and conceptm_id='$projectID' and categorym='proposals' group by conceptm_id order by scoredmID desc limit 0,10";
$resultwwScores2 = $mysqli->query($sqlwwScores2);
$rFListsScores2=$resultwwScores2->fetch_array(); 

$queryCategoryReviewFa="select * from ".$prefix."mscores_new where conceptm_id='$projectID' and usrm_id='$owner_id'  and categorym='proposals' and EVivaScore>1 order by scoredmID desc";
$R_CategoryReviewFa=$mysqli->query($queryCategoryReviewFa);	
$rCReviewFa=$R_CategoryReviewFa->fetch_array();
  
  $rCReviewFa['EVivaScore'];
 if($rCReviewFa['EVivaScore']){
$totalReviers=($rFListsScores2['TotalReviewers']+1);//one for VIVA SCORE
}
if(!$rCReviewFa['EVivaScore']){
$totalReviers=($rFListsScores2['TotalReviewers']);//one for VIVA SCORE
}

if($rFListsScores2['Total']){$TotalScore2=(($rFListsScores2['Total']+$rCReviewFa['EVivaScore'])/$totalReviers);//if score has VIVA


$update2="update ".$prefix."mscores_new set  EvgeneralTotal='$TotalScore2' where conceptm_id='$projectID' and usrm_id='$owner_id'  and categorym='proposals'";
$mysqli->query($update2); }

 $EvaluatedBy=$rCReview['EvaluatedBy']; 
	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();

$queryHalted="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DHalted=$mysqli->query($queryHalted);	
$rFListsHalted=$R_DHalted->fetch_array();

$queryStudy="select * from ".$prefix."appeal_halted_studies where projectID='$projectID' order by id desc limit 0,1";
$RStudy=$mysqli->query($queryStudy);	
$rFListsStudy=$RStudy->fetch_array();


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
                            <?php if($rFLists2['haltstudy']=='Yes'){?> <span class="button1">Study Halted</span>  <?php }?>                         
                                                        
                <?php if($rFLists2['haltstudy']=='Yes' and $rFListsStudy['appealSubmitted']!='Yes'){?> 
   <input id="go" type="button" value="Make an Appeal" onclick="window.open('appeal.php?id=<?php echo $rFLists2['projectID'];?>&owner_id=<?php echo $rFLists2['owner_id'];?>&act=<?php echo $rFListsStudy['id'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="button2" >
   <?php }?>

 <?php if($rFLists2['haltstudy']=='Yes' and $rFListsStudy['appealSubmitted']=='Yes'){?><span class="button2"><?php echo $rFListsStudy['status'];?></span>    <?php }?>
 
                                               
                                                        
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
