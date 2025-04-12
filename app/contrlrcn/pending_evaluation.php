<?php
   function PendingMEvaluationProposals()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$pages='data/';
$url='admpendingeval/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."concepts  where conceptm_status='pending' and categorym='proposals' order by conceptm_date desc");
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
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where conceptm_status='pending' and categorym='proposals' order by conceptm_date desc LIMIT $start, $limitm";
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
                                                <table class="table table-mailbox">
                                                    <tr class="unread">
                                                        <th class="small-col"><strong>Name Of PI </strong></th>
                                                        <th class="name"><strong>CVS</strong></th>
                                                        <th class="name"><strong>Name of Institution</strong></th>
                                                        <th class="subject"><strong>Contacts</strong></th>
                                                        <th class="time"><strong>Message</strong></th>
                                                        <th class="time"><strong>Date</strong></th>
                                                        <th class="time"><strong>Sector</strong></th>
                                                        <th class="time"><strong>Status</strong></th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="8"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFLists2=$result->fetch_array()){
																										  
																												///////////////////////////////////////////////
														
                                                         $conceptm_id=$rFLists2['conceptm_id'];
                                                         $sqlFLists1Nd="SELECT sum(EvTotalScore/5) AS TotalScores FROM ".$prefix."mscores where conceptm_id='$conceptm_id' and categorym='proposals'";
                                                         $QueryFListsm1Nd=$mysqli->query($sqlFLists1Nd);
                                                          $rScore = $QueryFListsm1Nd->fetch_array();    
															  ?>
                                                    <tr>
                                                        <td class="small-col"><?php echo $rFLists2['ms_NameOfPI'];?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */?></td>
                                                        <td class="name">
                                                        
                                                        <a href="cvs.php?id=<?php echo base64_encode($rFLists2['usrm_id']);?>" onclick="return popitup('cvs.php?id=<?php echo base64_encode($rFLists2['usrm_id']);?>')">View all CVS</a>
                                                      </td>
                                                        <td class="name"><?php echo $rFLists2['conceptm_NameofInstitution'];?></td>
                                                        <td class="subject">Email: <?php echo $rFLists2['conceptm_email'];?><br />
                                                        Phone: <?php echo $rFLists2['conceptm_phone'];?>
                                                        </td>
                                                        <td class="time"><?php echo $rFLists2['conceptm_cmtreject'];?></td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['conceptm_datem'];?>    
                                                        
                                                        </td>
                                                        <td class="name"><?php if($rFLists2['cpt_sector']!='Other'){echo $rFLists2['cpt_sector'];}?>
<?php if($rFLists2['cpt_sector']=='Other'){?><br />Other Sector: <?php echo $rFLists2['cpt_othersector'];}?></td>
<td class="name">
<?php if($rFLists2['conceptm_status']=='new'){?><div class="btn-info-black">New</div><?php }?>
<?php if($rFLists2['conceptm_status']=='approved'){?><div class="btn-info-blue">Approved for Review</div><?php }?>
<?php if($rFLists2['conceptm_status']=='rejected'){?><div class="btn-info-red">Rejected</div><?php }?>
<?php if($rFLists2['conceptm_status']=='completed'){?><div class="btn-info-blue">Complete</div><?php }?>

<?php 
$sqlAssigned="SELECT * FROM ".$prefix."conceptsasslogs where conceptm_id='$conceptm_id' and categorym='proposals'";
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


<?php if($rFLists2['conceptm_status']=='evaluated'){?><div class="btn-info-eval">Reviewed</div><?php }?>
</td>
                                                        

                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="9">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>

</div><!--end purgination section-->
</td>
</tr>
                                                  
                                                  
                                                </table>
</div><!-- /.table-responsive -->
				   
	  <?php


	  }///////////end function
	  
	  
	  function PendingMyConferencesReviewerProposals()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli,$usrrsmyLoggedIdm;
$sqlConceptLogs="SELECT * FROM ".$prefix."conceptsasslogs where conceptm_assignedto='$usrrsmyLoggedIdm' and logm_status='new' and categorym='proposals' and `openstatus`='open' order by assignm_date desc limit 0,150";
$QueryConcept=$mysqli->query($sqlConceptLogs);
$totalFL1 = $QueryConcept->num_rows;


		  ?>
 <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox" width="100%">
                                                    <tr class="unread">
                                                        <td width="32%" class="time"><strong>Proposal</strong></td>
                                                        <td width="14%" class="time"><strong>CVS</strong></td>
                                                        <td width="14%" class="time"><strong>Date</strong></td>
                                                        <td width="15%" class="time"><strong>Status</strong></td>
                                                        <td width="7%" class="time"><strong>Score</strong></td>
                                                        <td width="18%" class="time"><strong>Action</strong></td>
                                                    </tr>
                                                    <?php if(!$totalFL1){?>
                                                      <tr>
                                                        <td class="small-col" colspan="6"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFListsmain=$QueryConcept->fetch_array()){
															$conceptm_idd=$rFListsmain['conceptm_id'];
															////////////////////subs///////////////
$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where conceptm_id='$conceptm_idd' and categorym='proposals' order by conceptm_date desc";
                                              $QueryFListsm1=$mysqli->query($sqlFLists1);
                                              $rFLists2=$QueryFListsm1->fetch_array();  
															  
															  
															  
														$sto=$rFLists2['conceptm_assignedto'];
														$sqlAssigned="SELECT * FROM ".$prefix."musers where usrm_id='$sto'";
														$sqlAssigned=$mysqli->query($sqlAssigned);
														$syAssigned=$sqlAssigned->fetch_array();											  
														///////////////////////////////////////////////
														
                                                         $conceptm_id=$rFLists2['conceptm_id'];
                                                         $sqlFLists1Nd="SELECT * FROM ".$prefix."mscores where conceptm_id='$conceptm_id' and EvaluatedBy='$usrrsmyLoggedIdm' and categorym='proposals'";
                                                         $QueryFListsm1Nd=$mysqli->query($sqlFLists1Nd);
														 $totalScores = $QueryFListsm1Nd->num_rows;
                                                          $rScore = $QueryFListsm1Nd->fetch_array();  
															  ?>
                                                    <tr>
                                                        <td class="time"><?php if($rFLists2['proposalm_uploadReup']){?><?php echo $rFLists2['proposalmTittle'];?><?php }?> </td>
                                                        <td class="time"><a href="cvs.php?id=<?php echo base64_encode($rFLists2['usrm_id']);?>" onclick="return popitup('cvs.php?id=<?php echo base64_encode($rFLists2['usrm_id']);?>')">View all CVS</a></td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['conceptm_datem'];?>    
                                                        
                                                        </td>

<td class="name">
<?php if($rFListsmain['logm_status']=='new'){?><div class="btn-info-black">New</div><?php }?>
<?php if($rFListsmain['logm_status']=='approved'){?><div class="btn-info-blue">Approved</div><?php }?>
<?php if($rFListsmain['logm_status']=='rejected'){?><div class="btn-info-red">Rejected</div><?php }?>
<?php if($rFListsmain['logm_status']=='forwaded'){?><div class="btn-info-orange">Pending</div><?php }?>
<?php if($rFListsmain['logm_status']=='completed'){?><div class="btn-info-blue">Complete</div><?php }?>
</td>
<td class="name"><?php if($totalScores){?>
<p style="font-size:14px; color:#00A65A; font-weight:bold;"><?php echo $rScore['EvTotalScore'];?></p>  
<?php }?></td>
                                                        
<td class="name">
<?php if($rFListsmain['logm_status']=='completed'){?><div style="color:#00A65A; font-weight:bold;">Complete</div><?php }?>
<?php if(!$totalScores){?>
<a href="./data/pscore/<?php echo $rFLists2['conceptm_id'];?>/">Click to Review</a>    
<?php }?>


</td>
                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
                                                </table>
              </div><!-- /.table-responsive -->
				   
	  <?php


	  }///////////end function
	  	function WorkdedMyConferencesReviewerProposal()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli,$usrrsmyLoggedIdm;
$sqlConceptLogs="SELECT * FROM ".$prefix."conceptsasslogs where conceptm_assignedto='$usrrsmyLoggedIdm' and logm_status='completed' and categorym='proposals' and `openstatus`='open' order by assignm_date desc limit 0,150";
$QueryConcept=$mysqli->query($sqlConceptLogs);
$totalFL1 = $QueryConcept->num_rows;


		  ?>
 <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox" width="100%">
                                                    <tr class="unread">
                                                        <td width="32%" class="time"><strong>Proposal</strong></td>
                                                        <td width="11%" class="time"><strong>CVS</strong></td>
                                                        <td width="20%" class="time"><strong>Date</strong></td>
                                                        <td width="15%" class="time"><strong>Status</strong></td>
                                                        <td width="8%" class="time"><strong>Score</strong></td>
                                                        <td width="14%" class="time"><strong>Action</strong></td>
                                                    </tr>
                                                    <?php if(!$totalFL1){?>
                                                      <tr>
                                                        <td class="small-col" colspan="6"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFListsmain=$QueryConcept->fetch_array()){
															$conceptm_idd=$rFListsmain['conceptm_id'];
															////////////////////subs///////////////
 $sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where conceptm_id='$conceptm_idd'  and categorym='proposals' and `openstatus`='open' order by conceptm_date desc";
                                              $QueryFListsm1=$mysqli->query($sqlFLists1);
                                              $rFLists2=$QueryFListsm1->fetch_array();  
															  
															  
															  
														$sto=$rFLists2['conceptm_assignedto'];
														$sqlAssigned="SELECT * FROM ".$prefix."musers where usrm_id='$sto'";
														$sqlAssigned=$mysqli->query($sqlAssigned);
														$syAssigned=$sqlAssigned->fetch_array();											  
														///////////////////////////////////////////////
														
                                                         $conceptm_id=$rFLists2['conceptm_id'];
                                                         $sqlFLists1Nd="SELECT * FROM ".$prefix."mscores where conceptm_id='$conceptm_id' and EvaluatedBy='$usrrsmyLoggedIdm' and categorym='proposals' and `openstatus`='open'";
                                                         $QueryFListsm1Nd=$mysqli->query($sqlFLists1Nd);
														 $totalScores = $QueryFListsm1Nd->num_rows;
                                                          $rScore = $QueryFListsm1Nd->fetch_array();  
															  ?>
                                                    <tr>
                                                        <td class="time"><?php if($rFLists2['proposalm_uploadReup']){?><?php echo $rFLists2['proposalmTittle'];?><?php }?> </td>
                                                        <td class="time"><a href="cvs.php?id=<?php echo base64_encode($rFLists2['usrm_id']);?>" onclick="return popitup('cvs.php?id=<?php echo base64_encode($rFLists2['usrm_id']);?>')">View all CVS</a></td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['conceptm_datem'];?>    
                                                        
                                                        </td>

<td class="name">
<?php if($rFLists2['conceptm_status']=='new'){?><div class="btn-info-black">New</div><?php }?>
<?php if($rFLists2['conceptm_status']=='approved'){?><div class="btn-info-blue">Approved</div><?php }?>
<?php if($rFLists2['conceptm_status']=='rejected'){?><div class="btn-info-red">Rejected</div><?php }?>
<?php if($rFLists2['conceptm_status']=='forwaded'){?><div class="btn-info-orange">Pending</div><?php }?>
<?php if($rFLists2['conceptm_status']=='completed'){?><div class="btn-info-blue">Complete</div><?php }?>
</td>
<td class="name"><?php if($totalScores){?>
<p style="font-size:14px; color:#00A65A; font-weight:bold;"><?php echo $rScore['EvTotalScore'];?></p>  
<?php }?></td>
                                                        
<td class="name">
<?php if($rFLists2['conceptm_status']=='completed'){?><div style="color:#00A65A; font-weight:bold;"><a href="./data/previewscore/<?php echo $rScore['scoredmID'];?>/">Complete, Click to Review</a></div><?php }?>
<?php if(!$totalScores){?>
<a href="./data/pscore/<?php echo $rFLists2['conceptm_id'];?>/">Click to Review</a>    
<?php }?>


</td>
                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
                                                </table>
              </div><!-- /.table-responsive -->
				   
	  <?php


	  }///////////end function  
	  
	  ?>