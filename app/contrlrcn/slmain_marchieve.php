<?php

function AchieveConcepts()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today,$usrrsmyLoggedIdm;

$sqlConfsActive1pp="SELECT count(*) as TotalConfsProposals FROM ".$prefix."oldconcepts";
$sqlConfsActive1pp=$mysqli->query($sqlConfsActive1pp);
$rConfsActive1pp=$sqlConfsActive1pp->fetch_array();
echo $rConfsActive1pp['TotalConfsProposals'];
}

function RejectedAchieved()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today,$usrrsmyLoggedIdm;

$sqlConfsActive1pp="SELECT count(*) as TotalConfsProposals FROM ".$prefix."oldconcepts where conceptm_status='rejected'";
$sqlConfsActive1pp=$mysqli->query($sqlConfsActive1pp);
$rConfsActive1pp=$sqlConfsActive1pp->fetch_array();
echo $rConfsActive1pp['TotalConfsProposals'];
}


function ReviewedAchieved()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today,$usrrsmyLoggedIdm;

$sqlConfsActive1pp2="SELECT count(*) as TotalConfsProposals FROM ".$prefix."oldconcepts where conceptm_status='completed'";
$sqlConfsActive1pp2=$mysqli->query($sqlConfsActive1pp2);
$rConfsActive1pp2=$sqlConfsActive1pp2->fetch_array();
echo $rConfsActive1pp2['TotalConfsProposals'];
}
function TotalAchieved()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today,$usrrsmyLoggedIdm;

$sqlConfsActive1pp3="SELECT count(*) as TotalConfsProposals FROM ".$prefix."oldmproposals";
$sqlConfsActive1pp3=$mysqli->query($sqlConfsActive1pp3);
$rConfsActive1pp3=$sqlConfsActive1pp3->fetch_array();
echo $rConfsActive1pp3['TotalConfsProposals'];
}

function UnassignedAchieved()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today,$usrrsmyLoggedIdm;

$sqlConfsActive1pp4="SELECT count(*) as TotalConfsProposals FROM ".$prefix."oldconcepts where conceptm_status='new'";
$sqlConfsActive1pp4=$mysqli->query($sqlConfsActive1pp4);
$rConfsActive1pp4=$sqlConfsActive1pp4->fetch_array();
echo $rConfsActive1pp4['TotalConfsProposals'];
}


function AchieveGenerateCategories()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id;
	
	$sqlGroupDIspC="SELECT cpt_sector FROM ".$prefix."oldconcepts group by cpt_sector";
$sqlFGrpDisC=$mysqli->query($sqlGroupDIspC);
$totalUserReports = $sqlFGrpDisC->num_rows;
//$category=$_POST['category'];
	
	
?>
<form action="" method="post">
<select name="category" class="select">
<?php
while($rGRSPC=$sqlFGrpDisC->fetch_array()){?>
    <option value="<?php echo $rGRSPC['cpt_sector'];?>" <?php if($_POST['category']==$rGRSPC['cpt_sector']){?>selected="selected"<?php }?>>&nbsp;<?php echo $rGRSPC['cpt_sector'];?> </option>
 <?php }?>                           
</select>

<input name="doSearch" type="submit" value="Search Category" class="serch"/>
</form>
 <?php                                	
	
}

function AchievedConferences()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli,$usrrsmyLoggedIdm;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$category=$_POST['category'];
$pages='data/';
$url='achieve/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."oldconcepts where cpt_sector='$category' order by conceptm_date desc");
}

if(!$_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."oldconcepts order by conceptm_date desc");
}
$total_pages = $query->fetch_array();
$total_pages = $total_pages[num];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
if($_POST['doSearch']){
$limitm = 40;
}
if(!$_POST['doSearch']){
$limitm = 15;
}
//how many items to show per page
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
if($_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."oldconcepts where cpt_sector='$category' order by conceptm_date desc LIMIT $start, $limitm";
}

if(!$_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."oldconcepts order by conceptm_date desc LIMIT $start, $limitm";
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
                                                <table class="table table-mailbox">
                                                
                                                
                                                  <tr>
 <td class="small-col" colspan="8">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                
                                                    <tr class="unread">
                                                      <th width="226" class="small-col"><strong>Proposal</strong></th>
                                                        <th width="140" class="small-col"><strong>Name Of PI</strong></th>
                                                        <th width="174" class="name"><strong>Name of Institution</strong></th>
                                                        <th width="136" class="subject"><strong>Contacts</strong></th>
                                                        <th width="84" class="time"><strong>Date</strong></th>
                                                        <th width="110" class="time"><strong>Sector</strong></th>
                                                        <th width="126" class="time"><strong>Status</strong></th>
                                                        <th width="110" class="time"><strong>Concept Total Score</strong></th>
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
                                                        <td class="small-col"><?php echo $rFLists2['ms_NameOfPI'];?> <br />
														
														<?php //echo $rFLists2['proposalm_upload'];?>
														<?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */?></td>
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
<?php if($rFLists2['conceptm_status']=='pending'){?><div class="btn-info-blue">Pending Review</div><?php }?>
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
echo $syAssigned['usrm_fname'].'&nbsp;'.$syAssigned['usrm_sname'].'&nbsp;|&nbsp;'; }?>" style="color:#FFF; font-weight:bold;"><?php echo $totalAssigned;?></a> Reviewers</div><?php }?>


<?php if($rFLists2['conceptm_status']=='evaluated'){?><div class="btn-info-eval">Reviewed</div><?php }?></td>
                                                        
<td class="name">


<?php 
//oldmpropoasal_scores
$sqlAssignedTotal="SELECT * FROM ".$prefix."oldmscores where conceptm_id='$conceptm_id'";
$QueryAssignedTotal=$mysqli->query($sqlAssignedTotal);
$totalAssignedTotal=$QueryAssignedTotal->fetch_array();

echo $totalAssignedTotal['EvTotalScore'];?></td>
                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="8">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                </table>
</div><!-- /.table-responsive -->
				   
	  <?php


	  }///////////end function
	  
	  
	 function ProposalsSubmittedArchieve()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli,$usrrsmyLoggedIdm;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$category=$_POST['category'];
$pages='data/';
$url='achievepropsubmitted/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."oldmproposals where cpt_sector='$category' order by propDateUploaded desc");
}

if(!$_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."oldmproposals order by propDateUploaded desc");
}
$total_pages = $query->fetch_array();
$total_pages = $total_pages[num];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
if($_POST['doSearch']){
$limitm = 40;
}
if(!$_POST['doSearch']){
$limitm = 15;
}
//how many items to show per page
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
if($_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`propDateUploaded`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."oldmproposals where cpt_sector='$category' order by propDateUploaded desc LIMIT $start, $limitm";
}

if(!$_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`propDateUploaded`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."oldmproposals order by propDateUploaded desc LIMIT $start, $limitm";
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
                                                <table class="table table-mailbox">
                                                
                                                
                                                  <tr>
 <td class="small-col" colspan="7">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                
                                                    <tr class="unread">
                                                      <th width="226" class="small-col"><strong>Proposal</strong></th>
                                                        <th width="140" class="small-col"><strong>Name Of PI</strong></th>
                                                        <th width="174" class="name"><strong>Name of Institution</strong></th>
                                                        <th width="136" class="subject"><strong>Contacts</strong></th>
                                                        <th width="84" class="time"><strong>Date</strong></th>
                                                        <th width="110" class="time"><strong>Sector</strong></th>
                                                        <th width="110" class="time"><strong>Total Score</strong></th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="7"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFLists2=$result->fetch_array()){
																										  
																												///////////////////////////////////////////////
														
                                                         $conceptm_id=$rFLists2['conceptm_id'];
														 $propmID=$rFLists2['propmID'];
                                                         $sqlFLists1Nd="SELECT * FROM ".$prefix."oldconcepts where conceptm_id='$conceptm_id'";
                                                         $QueryFListsm1Nd=$mysqli->query($sqlFLists1Nd);
                                                          $rname = $QueryFListsm1Nd->fetch_array();    
															  ?>
                                                    <tr>
                                                      <td class="small-col"><span class="time"><a href="./files/<?php echo $rFLists2['propUpload'];?>" target="_blank"><?php echo $rFLists2['propTitle'];?></a></span></td>
                                                        <td class="small-col"><?php echo $rname['ms_NameOfPI'];?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */?></td>
                                                        <td class="name"><?php echo $rname['conceptm_NameofInstitution'];?></td>
                                                        <td class="subject">Email: <?php echo $rname['conceptm_email'];?><br />
                                                        Phone: <?php echo $rname['conceptm_phone'];?> <?php //echo $conceptm_id;?>                                              </td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['conceptm_datem'];?>                                                        </td>
                                                        <td class="name"><?php if($rname['cpt_sector']!='Other'){echo $rname['cpt_sector'];}?>
  <?php if($rname['cpt_sector']=='Other'){?><br />Other Sector: <?php echo $rname['cpt_othersector'];}?></td>
<td class="name">
  
  
  <?php 
//oldmpropoasal_scores
$sqlAssignedTotal="SELECT * FROM ".$prefix."oldmpropoasal_scores where propmID='$propmID'";
$QueryAssignedTotal=$mysqli->query($sqlAssignedTotal);
$totalAssignedTotal=$QueryAssignedTotal->fetch_array();

echo $totalAssignedTotal['EvTotalScore'];?></td>
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
				   
	  <?php


	  }///////////end function 
	  
	  
	  
	  
	  
	  
	function AchievedReviewedSubmissions()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli,$usrrsmyLoggedIdm;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$category=$_POST['category'];
$pages='data/';
$url='achieve/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."oldconcepts where cpt_sector='$category' order by conceptm_date desc");
}

if(!$_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."oldconcepts order by conceptm_date desc");
}
$total_pages = $query->fetch_array();
$total_pages = $total_pages[num];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
if($_POST['doSearch']){
$limitm = 40;
}
if(!$_POST['doSearch']){
$limitm = 15;
}
//how many items to show per page
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
if($_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."oldconcepts where cpt_sector='$category' order by conceptm_date desc LIMIT $start, $limitm";
}

if(!$_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."oldconcepts order by conceptm_date desc LIMIT $start, $limitm";
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
                                                <table class="table table-mailbox">
                                                
                                                
                                                  <tr>
 <td class="small-col" colspan="8">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                
                                                    <tr class="unread">
                                                      <th width="226" class="small-col"><strong>Proposal</strong></th>
                                                        <th width="140" class="small-col"><strong>Name Of PI</strong></th>
                                                        <th width="174" class="name"><strong>Name of Institution</strong></th>
                                                        <th width="136" class="subject"><strong>Contacts</strong></th>
                                                        <th width="84" class="time"><strong>Date</strong></th>
                                                        <th width="110" class="time"><strong>Sector</strong></th>
                                                        <th width="126" class="time"><strong>Status</strong></th>
                                                        <th width="110" class="time"><strong>Action</strong></th>
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
<?php if($rFLists2['conceptm_status']=='pending'){?><div class="btn-info-blue">Pending Review</div><?php }?>
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
echo $syAssigned['usrm_fname'].'&nbsp;'.$syAssigned['usrm_sname'].'&nbsp;|&nbsp;'; }?>" style="color:#FFF; font-weight:bold;"><?php echo $totalAssigned;?></a> Reviewers</div><?php }?>


<?php if($rFLists2['conceptm_status']=='evaluated'){?><div class="btn-info-eval">Reviewed</div><?php }?></td>
                                                        
<td class="name"><?php if($rFLists2['conceptm_status']=='approved'){?>
<a href="./data/assign/<?php echo $rFLists2['conceptm_id'];?>/" style="color:#00A65A;">Forward Submission</a>    
<?php }?>

<?php if($rFLists2['conceptm_status']=='new'){?>
<a href="./data/review/<?php echo $rFLists2['conceptm_id'];?>/">Click to Review</a>    
<?php }?></td>
                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="8">                                                
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