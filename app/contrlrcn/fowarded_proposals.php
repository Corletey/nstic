<?php
  function FrowardedFMPropals()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$pages='data/';
$url='propforwaded/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."concepts  where conceptm_status='forwaded' and categorym='proposals' order by conceptm_date desc");
$total_pages = $query->fetch_array();
$total_pages = $total_pages[num];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
$limitm = 15; 								//how many items to show per page
$page = $_GET['pages'];

/*Extract Last Value from a link*/
$RequestURI=end(explode("/", $_SERVER['REQUEST_URI']));
$page = preg_replace('/\D/', '', $RequestURI);
								//how many items to show per page
if($page) 
$start = ($page - 1) * $limitm; 			//first item to display on this page
else
$start = 0;								//if no page var is given, set start to 0

/* Get data. */
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where conceptm_status='forwaded' and categorym='proposals' order by conceptm_date desc LIMIT $start, $limitm";
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
                                                    <tr class="unread">
                                                      <th width="299" class="small-col"><strong>Proposal</strong></th>
                                                      <th width="143" class="small-col"><strong>CVS</strong></th>
                                                        <th width="143" class="small-col"><strong>Name Of PI</strong></th>
                                                        <th width="153" class="name"><strong>Name of Institution</strong></th>
                                                        <th width="134" class="subject"><strong>Contacts</strong></th>
                                                        <th width="122" class="time"><strong>Date</strong></th>
                                                        <th width="119" class="time"><strong>Sector</strong></th>
                                                        <th width="140" class="time"><strong>Status</strong></th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="8"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFLists2=$result->fetch_array()){
																										  
																												///////////////////////////////////////////////
														
                                                         $conceptm_id=$rFLists2['conceptm_id'];
                                                         $sqlFLists1Nd="SELECT sum(EvTotalScore/5) AS TotalScores FROM ".$prefix."mscores where conceptm_id='$conceptm_id'";
                                                         $QueryFListsm1Nd=$mysqli->query($sqlFLists1Nd);
                                                          $rScore = $QueryFListsm1Nd->fetch_array();    
															  ?>
                                                    <tr>
                                                      <td class="small-col"><span class="time"><a href="./files/<?php echo $rFLists2['proposalm_upload'];?>" target="_blank"><?php echo $rFLists2['proposalmTittle'];?></a></span></td>
                                                      <td class="small-col">
                                                      
                                                      <a href="cvs.php?id=<?php echo base64_encode($rFLists2['usrm_id']);?>" onclick="return popitup('cvs.php?id=<?php echo base64_encode($rFLists2['usrm_id']);?>')">View all CVS</a></td>
                                                        <td class="small-col"><?php echo $rFLists2['ms_NameOfPI'];?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */?></td>
                                                        <td class="name"><?php echo $rFLists2['conceptm_NameofInstitution'];?></td>
                                                        <td class="subject">Email: <?php echo $rFLists2['conceptm_email'];?><br />
                                                        Phone: <?php echo $rFLists2['conceptm_phone'];?>                                                        </td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['conceptm_datem'];?>                                                        </td>
                                                        <td class="name"><?php if($rFLists2['cpt_sector']!='Other'){echo $rFLists2['cpt_sector'];}?>
<?php if($rFLists2['cpt_sector']=='Other'){?><br />Other Sector: <?php echo $rFLists2['cpt_othersector'];}?></td>
<td class="name">
<?php if($rFLists2['conceptm_status']=='new'){?><div class="btn-info-black">New</div><?php }?>
<?php if($rFLists2['conceptm_status']=='approved'){?><div class="btn-info-blue">Approved for Review</div><?php }?>
<?php if($rFLists2['conceptm_status']=='rejected'){?><div class="btn-info-red">Rejected</div><?php }?>
<?php if($rFLists2['conceptm_status']=='completed'){?><div class="btn-info-blue">Complete</div><?php }?>

<?php 
$sqlAssigned="SELECT * FROM ".$prefix."conceptsasslogs where conceptm_id='$conceptm_id'";
$QueryAssigned=$mysqli->query($sqlAssigned);
$totalAssigned = $QueryAssigned->num_rows;



if($rFLists2['conceptm_status']=='forwaded'){?><div class="btn-info-orange">Forwarded to <a href="./main.php?option=dashboard" title="
<?php 
while($rQueryAssigned = $QueryAssigned->fetch_array()){ 
$sto=$rQueryAssigned['conceptm_assignedto'];
$sqlAssigned="SELECT * FROM ".$prefix."musers where usrm_id='$sto'";
$sqlAssigned=$mysqli->query($sqlAssigned);
$syAssigned=$sqlAssigned->fetch_array();
echo $syAssigned['usrm_fname'].'&nbsp;|&nbsp;'; }?>" style="color:#FFF; font-weight:bold;"><?php echo $totalAssigned;?></a> Reviewers</div><?php }?>


<?php if($rFLists2['conceptm_status']=='evaluated'){?><div class="btn-info-eval">Reviewed</div><?php }?></td>
                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="9">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                </table>
</div><!-- /.table-responsive -->
				   
  <?php


	  }///////////end function  
	  ?>