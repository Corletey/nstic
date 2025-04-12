 
<h2 class="success" style="text-align:center;"><b><?php echo $lang_RequestforFunds;?></b></h2>
 
 <?php 
$category=$_POST['category'];
$page='main.php?';
$url='category=';
$value='FundsApplications&id='.$id;
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($session_usertype=='user'){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."request_for_funds_main where owner_id='$usrm_id' order by id desc");//and conceptm_status='new' 
}

if($session_usertype!='user'){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."request_for_funds_main order by id desc");//and conceptm_status='new' 
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
if($session_usertype=='user'){
$sql = "select *,DATE_FORMAT(`dateRequested`,'%d/%m/%Y') AS dateRequestedm FROM ".$prefix."request_for_funds_main where owner_id='$usrm_id' order by id desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if($session_usertype!='user'){
$sql = "select *,DATE_FORMAT(`dateRequested`,'%d/%m/%Y') AS dateRequestedm FROM ".$prefix."request_for_funds_main order by id desc LIMIT $start, $limitm";//and conceptm_status='new' 
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
                                                      <th width="268" class="small-col"><strong><?php echo $lang_ProposalTitle;?></strong></th>
                                                      <th width="206" class="name"><?php echo $lang_RequestedBy;?></th>
                                                      <th width="206" class="name"><strong><?php echo $lang_ApprovedGrantTotal;?></strong></th>
                                                        <th width="161" class="subject"><strong><?php echo $lang_AmountRequested;?></strong></th>
                                                        <th width="151" class="time"><?php echo $lang_DateRequested;?></th>
                                                        <th width="151" class="time"><strong><?php echo $lang_Status;?></strong></th>
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
$grantID=$rFLists2['grantID'];

$queryDistrictsMain="select * from ".$prefix."musers where usrm_id='$owner_id'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$rFListsOnwner=$R_DMain->fetch_array();
if($projectID>=1){
$sqlwwScores2 = "select * FROM ".$prefix."submissions_proposals where projectID='$projectID' and grantcallID='$grantID' order by projectID desc limit 0,10";
$resultwwScores2 = $mysqli->query($sqlwwScores2);
$rFListsScores2=$resultwwScores2->fetch_array();
$totalFundsProposal=$resultwwScores2->num_rows ;
}
if($conceptID>=1){
$sqlwwScores4 = "select * FROM ".$prefix."submissions_concepts where conceptID='$conceptID' and grantcallID='$grantID' order by conceptID desc limit 0,10";
$resultwwScores4 = $mysqli->query($sqlwwScores4);
$rFListsScores4=$resultwwScores4->fetch_array();
$totalFundsConcept=$resultwwScores4->num_rows ;
}




															  ?>
                                                    <tr>
                                                      <td class="small-col"><?php 
													  if($totalFundsProposal){
													  echo $rFListsScores2['projectTitle'];?><br />
                                                       RefNo: <strong><?php echo $rFListsScores2['referenceNo'];?></strong>
                                                       <?php }?>
                                                       
                                                       <?php 
													  if($totalFundsConcept){
													  echo $rFListsScores4['projectTitle'];?><br />
                                                       RefNo: <strong><?php echo $rFListsScores4['referenceNo'];?></strong>
                                                       <?php }?>
                                                      
                                                      </td>
                                                      <td class="name">Name: <?php echo $rFListsOnwner['usrm_fname'];?> <?php echo $rFListsOnwner['usrm_sname'];?><br />
                                                        Email: <?php echo $rFListsOnwner['usrm_email'];?><br />
                                                        Phone: <?php echo $rFListsOnwner['usrm_phone'];?></td>
                                                      <td class="name"><b><?php echo numberformat($rFLists2['ApprovedGrantTotal']);?> <?php echo $rFLists2['currency'];?></b></td>
                                                        <td class="subject"><b><?php echo numberformat($rFLists2['BudgetItem']);?> <?php echo $rFLists2['currency'];?></b>
                                                                                                                </td>
                                                        <td class="name"><?php echo $rFLists2['dateRequestedm'];?></td>
                                                      <td class="name">
                                                        
                                                   

<?php if($rFLists2['requisitioning']=='Full Amount'){?><div class="btn-info-black"><?php echo $lang_FullAmount;?></div><?php }?>

<?php if($rFLists2['requisitioning']=='Partial Amount'){?><div class="btn-info-blue"><?php echo $lang_PartialAmount;?></div><?php }?>

<?php if($rFLists2['actionOnRequest']=='Pending'){?><div  class='button3'><?php echo $lang_RequestPending;?></div> <?php }?>
                                                        
 <?php if($rFLists2['actionOnRequest']=='Submitted'){?><div  class='btn-info-purple'><?php echo $lang_RequestPending;?></div> <?php }?>
 <?php if($rFLists2['actionOnRequest']=='Approved'){?><div  class='btn-info-blue'><?php echo $lang_RequestApproved;?></div> <?php }?>
 <?php if($rFLists2['actionOnRequest']=='Rejected'){?><div  class='btn-info-red'><?php echo $lang_RequestRejected;?></div> <?php }?>
 <?php if($rFLists2['actionOnRequest']=='Rejected with Comments'){?><div  class='btn-info-red'><?php echo $lang_RequestPending;?></div> <?php }

 ?>                                            
                                                        
                                                        
                                                      </td>
                                                      <td class="time">
                                                      
  <?php 
   //Funds REquest By Proposal
  if($rFLists2['actionOnRequest']=='Rejected' and ($session_usertype=='admin' || $session_usertype=='user') and $totalFundsProposal>=1){?>
  
    <input id="go" type="button" value="<?php echo $lang_ClicktoViewDetails;?>" onclick="window.open('<?php echo $base_url;?>funds.php?pid=<?php echo $rFLists2['projectID'];?>&id=<?php echo $rFLists2['id'];?>&grantID=<?php echo $rFLists2['grantID'];?>&categorym=proposals&owner_id=<?php echo $owner_id;?>&true=No','popUpWindow','height=500, width=1200, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="button2" ><br />
    

    <a href="./main.php?option=urRequestforFunds&id=<?php echo $rFLists2['projectID'];?>&grantID=<?php echo $rFLists2['grantID'];?>" class="button2"><?php echo $lang_ClicktoUpdateSubmission;?></a>

  <?php }?>
  
  <?php 
   //Funds REquest By Concepts
  if($rFLists2['actionOnRequest']=='Rejected' and ($session_usertype=='admin' || $session_usertype=='user') and $totalFundsConcept>=1){?>
  
    <input id="go" type="button" value="<?php echo $lang_ClicktoViewDetails;?>" onclick="window.open('<?php echo $base_url;?>funds.php?pid=<?php echo $rFLists2['conceptID'];?>&id=<?php echo $rFLists2['id'];?>&grantID=<?php echo $rFLists2['grantID'];?>&categorym=proposals&owner_id=<?php echo $owner_id;?>&true=No','popUpWindow','height=500, width=1200, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="button2" ><br />
    

    <a href="./main.php?option=urRequestforFundsResubmitConcept&id=<?php echo $rFLists2['conceptID'];?>&grantID=<?php echo $rFLists2['grantID'];?>" class="button2"><?php echo $lang_ClicktoUpdateSubmission;?></a>

  <?php }?>
  
                                                        
  <?php 
  //Funds REquest By Proposal
  if($rFLists2['actionOnRequest']=='Submitted' and $session_usertype=='admin' and $totalFundsProposal>=1){?>
    <input id="go" type="button" value="Approve/Reject" onclick="window.open('<?php echo $base_url;?>funds.php?pid=<?php echo $rFLists2['projectID'];?>&id=<?php echo $rFLists2['id'];?>&categorym=proposals&grantID=<?php echo $rFLists2['grantID'];?>&owner_id=<?php echo $owner_id;;?>&true=Yes','popUpWindow','height=500, width=1200, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="button2" >
  
  <?php }?>
                                                        
<?php 
  //Funds REquest By Concept
  if($rFLists2['actionOnRequest']=='Submitted' and $session_usertype=='admin' and $totalFundsConcept>=1){?>
    <input id="go" type="button" value="Approve/Reject" onclick="window.open('<?php echo $base_url;?>fundsconcepts.php?pid=<?php echo $rFLists2['conceptID'];?>&id=<?php echo $rFLists2['id'];?>&categorym=concepts&grantID=<?php echo $rFLists2['grantID'];?>&owner_id=<?php echo $owner_id;;?>&true=Yes','popUpWindow','height=500, width=1200, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="button2" >
  
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
