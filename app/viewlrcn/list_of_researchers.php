 <h4 class="niceheaders"><?php echo $lang_ListofResearchers;?></h4><hr />
 <form action="" method="post" name="regForm" id="regForm" autocomplte="off">
<table width="100%" border="0" style="margin-top:15px;">
  <tr>
    <td width="80%"><?php echo $lang_ListofResearchers;?>:<br />
    <input type="text" class="form-control" name="searchResearchers" value="<?php echo $_POST['searchResearchers'];?>" placeholder="search by Name, email, expertise"></td>

   
   <td width="7%"><br /><input type="submit" name="doSearch" id="button" class="search btn" value="Search" /></td>
  </tr>
</table>
</form>


<div style="margin-top:5px;"></div>
<span  class="button2" style="float:left; padding:10px;"><a href="exportresearchers.php?searchResearchers=<?php echo $searchResearchers;?>"> <?php echo $lang_ExportResults;?></a></span>
 
 <?php 
 if($_POST['searchResearchers']){
$searchResearchers=$mysqli->real_escape_string($_POST['searchResearchers']);
 }

  if($_GET['searchResearchers']){
$searchResearchers=$mysqli->real_escape_string($_GET['searchResearchers']);
 }
$page='./main.php?option=';
$url='ListofResearchers';
$value='&searchResearchers='.$searchResearchers;

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($searchResearchers){
$query = $mysqli->query("select COUNT(DISTINCT emailaddress) as num from ".$prefix."principal_investigators where (Surname like '%$searchResearchers' OR Expertise like '%$searchResearchers%' OR emailaddress like '%$searchResearchers%') order by emailaddress asc");//and conceptm_status='new' 
}

if(!$searchResearchers){
$query = $mysqli->query("select COUNT(DISTINCT emailaddress) as num from ".$prefix."principal_investigators order by emailaddress asc");//and conceptm_status='new' 
}
$row = $query -> fetch_array(MYSQLI_NUM);
$total_pages = $row[0];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $page.$url.$value; 	//your file name  (the name of this file)
$limitm = 50;

//how many items to show per page
$page = $_GET['pages'];


								//how many items to show per page
if($page) 
$start = ($page - 1) * $limitm; 			//first item to display on this page
else
$start = 0;								//if no page var is given, set start to 0

/* Get data. */
if($searchResearchers){
$sql = "select DISTINCT emailaddress FROM ".$prefix."principal_investigators where (Surname like '%$searchResearchers' OR Expertise like '%$searchResearchers%' OR emailaddress like '%$searchResearchers%') order by emailaddress asc LIMIT $start, $limitm";//and conceptm_status='new'  DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedon
}

if(!$searchResearchers){
$sql = "select DISTINCT emailaddress FROM ".$prefix."principal_investigators order by emailaddress asc LIMIT $start, $limitm";//and conceptm_status='new' 
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
 <td class="small-col" colspan="6">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                
                                                    <tr class="unread">
                                                      <th width="268" class="small-col"><strong><?php echo $lang_new_Name;?></strong></th>
                                                      <th width="206" class="name"><?php echo $lang_Gender;?></th>
                                                      <th width="206" class="name"><strong><?php echo $lang_Contacts;?></strong></th>
                                                      <th width="100" class="time"><?php echo $lang_Expertise;?></th>
                                                      <th width="100" class="time"><?php echo $lang_Updatedon;?></th>
                                                        <th width="100" class="time">&nbsp;</th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="6"><p><?php echo $lang_no_results_displayed;?></p></td>
                                                    </tr>
                                                    <?php }else{
while($rFListsMain=$result->fetch_array()){
	
/**/$piID=$rFListsMain['piID'];
$emailaddress=$rFListsMain['emailaddress'];

$sqlMain = "select * FROM ".$prefix."principal_investigators where emailaddress='$emailaddress' order by piID desc";//and conceptm_status='new' 
$resultMain = $mysqli->query($sqlMain);
$rFLists2=$resultMain->fetch_array();



															  ?>
                                                    <tr>
                                                      <td class="small-col"><?php echo $rFLists2['Surname'];?> <?php echo $rFLists2['Othername'];?>
                                                      
                                                      </td>
                                                      <td class="name"><?php echo $rFLists2['Gender'];?></td>
                                                      <td class="name"><?php echo $rFLists2['Contacts'];?><br />
                                                      <?php echo $rFLists2['emailaddress'];?></td>
                                                      <td class="time"><?php echo $rFLists2['Expertise'];?></td>
                                                      <td class="time"><?php echo $rFLists2['updatedon'];?></td>
                                                        <td class="time">
                                                 
                                                 <a href="./main.php?option=ViewPI&id=<?php echo $rFLists2['grantcallID'];?>&bkey=<?php echo $rFLists2['piID'];?>&bt=<?php echo $rFLists2['owner_id'];?>"><?php echo $lang_ClicktoViewDetails;?></a>                                                        </td>
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


    
    <script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>