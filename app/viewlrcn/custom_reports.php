 <?php
 //include("viewlrcn/proposals_statistics.php");
 ////////////////////////////////////////////////
if($_POST['category']){
$category=$mysqli->real_escape_string($_POST['category']);	 
 }
if($_GET['category']){
$category=$mysqli->real_escape_string($_GET['category']);	 
 }
if($_POST['ssCategory']){
$ssCategory=$mysqli->real_escape_string($_POST['ssCategory']);	 
 }
if($_GET['ssCategory']){
$ssCategory=$mysqli->real_escape_string($_GET['ssCategory']);	 
 }
 
  if($_POST['sstatus']){
$sstatus=$mysqli->real_escape_string($_POST['sstatus']);	 
 }
if($_GET['sstatus']){
$sstatus=$mysqli->real_escape_string($_GET['sstatus']);	 
 }
 
  if($_POST['ssbudget']){
$ssbudget=$mysqli->real_escape_string($_POST['ssbudget']);	 
 }
if($_GET['ssbudget']){
$ssbudget=$mysqli->real_escape_string($_GET['ssbudget']);	 
 }
 
 if($_POST['ssall']){
$ssall=$mysqli->real_escape_string($_POST['ssall']);	 
 }
if($_GET['ssall']){
$ssall=$mysqli->real_escape_string($_GET['ssall']);	 
 }
 
if($_POST['yearfrom']){
$yearfrom=$mysqli->real_escape_string($_POST['yearfrom']);
$monthfrom=$mysqli->real_escape_string($_POST['monthfrom']);	

$searchYearFrom="$yearfrom-$monthfrom";
 }
if($_GET['yearfrom']){
$yearfrom=$mysqli->real_escape_string($_GET['yearfrom']);
$monthfrom=$mysqli->real_escape_string($_GET['monthfrom']);
$searchYearFrom="$yearfrom-$monthfrom";	 
 }

if($_POST['yearto']){
$yearto=$mysqli->real_escape_string($_POST['yearto']);
$monthto=$mysqli->real_escape_string($_POST['monthto']);	
$searchYearTo="$yearto-$monthto"; 
 }
if($_GET['yearto']){
$yearto=$mysqli->real_escape_string($_GET['yearto']);
$monthto=$mysqli->real_escape_string($_GET['monthto']);	
$searchYearTo="$yearto-$monthto";	 
 }
 
  ?>
 
 <h4 class="niceheaders"><?php echo $lang_CustomReports;?></h4><hr />
 <form method="post" action="">
 
<table width="90%" border="0">
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $from;?></td>
    <td><?php echo $to;?></td>

  </tr>
 
  <tr>
    <td width="14%" rowspan="2"><?php echo $lang_Searchbyperiod;?> </td>
    <td width="43%">
   <select name="yearfrom" id="dropdown" class="form-control" tabindex="6" style=" width:200px; float:left;" required>  
    
    <option value=""><?php echo $lang_Year;?></option>
<?php
$startYear=date('2021');
define('DOB_YEAR_START', $startYear);

$current_year = date('Y')+0;

for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
 <option value="<?php echo $count;?>" <?php if($yearfrom==$count){?>selected="selected"<?php }?>><?php echo $count;?></option>
<?php }?>

  </select>
  
  <select name="monthfrom" id="dropdown" class="form-control" tabindex="6" style=" width:200px; float:left;" required>
    <option value=""><?php echo $lang_Month;?></option>
   <option value="01-31" <?php if($monthfrom=='01-31'){?>selected="selected"<?php }?>>&nbsp;January</option>
   <option value="02-28" <?php if($monthfrom=='02-28'){?>selected="selected"<?php }?>>&nbsp;February</option>
   <option value="03-31" <?php if($monthfrom=='03-31'){?>selected="selected"<?php }?>>&nbsp;March</option>
   <option value="04-30" <?php if($monthfrom=='04-30'){?>selected="selected"<?php }?>>&nbsp;April</option>
   <option value="05-31" <?php if($monthfrom=='05-31'){?>selected="selected"<?php }?>>&nbsp;May</option>
   <option value="06-30" <?php if($monthfrom=='06-30'){?>selected="selected"<?php }?>>&nbsp;June</option>
   <option value="07-31" <?php if($monthfrom=='07-31'){?>selected="selected"<?php }?>>&nbsp;July</option>
   <option value="08-31" <?php if($monthfrom=='08-31'){?>selected="selected"<?php }?>>&nbsp;August</option>
   <option value="09-30" <?php if($monthfrom=='09-30'){?>selected="selected"<?php }?>>&nbsp;September</option>
   <option value="10-31" <?php if($monthfrom=='10-31'){?>selected="selected"<?php }?>>&nbsp;October</option>
   <option value="11-30" <?php if($monthfrom=='11-30'){?>selected="selected"<?php }?>>&nbsp;November</option>
   <option value="12-31" <?php if($monthfrom=='12-31'){?>selected="selected"<?php }?>>&nbsp;December</option>
  </select>
  
  
  </td>
    <td width="43%">
    
    <select name="yearto" id="dropdown" class="form-control" tabindex="6" style=" width:200px; float:left;" required>  
    
    <option value=""><?php echo $lang_Year;?></option>
<?php
$startYear=date('2021');
define('DOB_YEAR_START', $startYear);

$current_year = date('Y')+0;

for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
 <option value="<?php echo $count;?>" <?php if($yearto==$count){?>selected="selected"<?php }?>><?php echo $count;?></option>
<?php }?>

  </select>
  
  <select name="monthto" id="dropdown" class="form-control" tabindex="6" style=" width:200px; float:left;" required>
    <option value=""><?php echo $lang_Month;?></option>
<option value="01-31" <?php if($monthto=='01-31'){?>selected="selected"<?php }?>>&nbsp;January</option>
   <option value="02-28" <?php if($monthto=='02-28'){?>selected="selected"<?php }?>>&nbsp;February</option>
   <option value="03-31" <?php if($monthto=='03-31'){?>selected="selected"<?php }?>>&nbsp;March</option>
   <option value="04-30" <?php if($monthto=='04-30'){?>selected="selected"<?php }?>>&nbsp;April</option>
   <option value="05-31" <?php if($monthto=='05-31'){?>selected="selected"<?php }?>>&nbsp;May</option>
   <option value="06-30" <?php if($monthto=='06-30'){?>selected="selected"<?php }?>>&nbsp;June</option>
   <option value="07-31" <?php if($monthto=='07-31'){?>selected="selected"<?php }?>>&nbsp;July</option>
   <option value="08-31" <?php if($monthto=='08-31'){?>selected="selected"<?php }?>>&nbsp;August</option>
   <option value="09-30" <?php if($monthto=='09-30'){?>selected="selected"<?php }?>>&nbsp;September</option>
   <option value="10-31" <?php if($monthto=='10-31'){?>selected="selected"<?php }?>>&nbsp;October</option>
   <option value="11-30" <?php if($monthto=='11-30'){?>selected="selected"<?php }?>>&nbsp;November</option>
   <option value="12-31" <?php if($monthto=='12-31'){?>selected="selected"<?php }?>>&nbsp;December</option>
  </select>
    
    
    
    </td>

  </tr>
  
   <tr>
    <td><select name="ssCategory" id="dropdown" class="requiredm">
      <option value="" selected="selected">&nbsp;<?php echo $lang_SearchbyCategory;?></option>
  <?php
$qRCat="select * from ".$prefix."categories order by rstug_categoryName asc";
$RCat = $mysqli->query($qRCat);
while($TCat = $RCat->fetch_array()){
?>
  <option value="<?php echo $TCat['rstug_categoryID'];?>"  <?php if($TCat['rstug_categoryID']==$ssCategory){?>selected="selected"<?php }?>>&nbsp;<?php if($base_lang=='en'){echo $TCat['rstug_categoryName'];}
if($base_lang=='fr'){echo $TCat['rstug_categoryName_fr'];}
if($base_lang=='pt'){echo $TCat['rstug_categoryName_pt'];}?></option>
  <?php }?>
  </select>
</td>
    <td><select name="sstatus" id="dropdown" class="requiredm">
   <option value="" selected="selected">&nbsp;<?php echo $lang_SearchbyStatus;?></option>
<option value="Pending Final Submission" <?php if($sstatus=='Pending Final Submission'){?>selected="selected"<?php }?>>&nbsp; <?php echo $lang_PendingFinalSubmission;?></option>
<option value="Pending Review" <?php if($sstatus=='Pending Review'){?>selected="selected"<?php }?>>&nbsp; <?php echo $lang_PendingReview;?></option>
<option value="Scheduled for Review" <?php if($sstatus=='Scheduled for Review'){?>selected="selected"<?php }?>>&nbsp; <?php echo $lang_Scheduled_for_Review;?></option>
<option value="Reviewed" <?php if($sstatus=='Reviewed'){?>selected="selected"<?php }?>>&nbsp; <?php echo $lang_Reviewed;?></option>
<option value="Approved" <?php if($sstatus=='Approved'){?>selected="selected"<?php }?>>&nbsp; <?php echo $lang_Approved;?></option>
<option value="Rejected" <?php if($sstatus=='Rejected'){?>selected="selected"<?php }?>>&nbsp; <?php echo $lang_Rejected;?></option>
<option value="Completeness Check-Approved" <?php if($sstatus=='Completeness Check-Approved'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_CompletenessCheckApproved;?></option>
<option value="Completeness Check-Rejected" <?php if($sstatus=='Completeness Check-Rejected'){?>selected="selected"<?php }?>>&nbsp; <?php echo $lang_CompletenessCheckRejected;?></option>

  </select></td>
  </tr>


<tr>
    <td>&nbsp;</td>
    <td><input type="text" name="ssall"  id="dropdown" value="<?php echo $ssall;?>" placeholder="Search by Any"/>
</td>
<td><select name="ssbudget" id="dropdown" class="requiredm">
      <option value="" selected="selected">&nbsp;<?php echo $lang_SearchbyBudgetItem;?></option>
      

  <option value="Personnel" <?php if($ssbudget=='Personnel'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_new_Personnel;?></option>
 <option value="Research Costs" <?php if($ssbudget=='Research Costs'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_new_ResearchCosts;?></option>
 <option value="Equipment" <?php if($ssbudget=='Equipment'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_new_Equipment;?></option>
 <option value="Travel Subsistence" <?php if($ssbudget=='Travel Subsistence'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_new_TravelandSubsistence;?></option>
 <option value="Grant kick off" <?php if($ssbudget=='Grant kick off'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_new_GRatKickoff;?></option>
 <option value="Knowledge Sharing" <?php if($ssbudget=='Knowledge Sharing'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_new_KnowledgeSharing;?></option>
 <option value="Overhead Costs" <?php if($ssbudget=='Overhead Costs'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_new_Overheadcosts;?></option>
 <option value="Other Goods" <?php if($ssbudget=='Otheroods'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_new_Othergoodsservice;?></option>
 <option value="Matching Support" <?php if($ssbudget=='Matching Support'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_new_MatchingSupportifany;?></option>
  </select>
</td>


  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><input id="c-signup-submit3" name="Search" class="btnLogin" value="<?php echo $lang_Search;?>" type="submit" tabindex="14"/>
</td>


  </tr>
</table>
<div style="margin-top:5px;"></div>
<span  class="button2" style="float:left; padding:10px;"><a href="customreports.php?ssCategory=<?php echo $ssCategory;?>&searchYearFrom=<?php echo $searchYearFrom;?>&searchYearTo=<?php echo $searchYearTo;?>&sstatus=<?php echo $sstatus;?>&ssbudget=<?php echo $ssbudget;?>&ssall=<?php echo $ssall;?>"> <?php echo $lang_ExportResults;?></a></span>

</form>

 <?php 
 
 if($_POST['Search']=='Search'){
$page='main.php?';
$url='category=';
$value='&category='.$category.'&ssCategory='.$ssCategory.'&yearfrom='.$searchYearFrom.'&yearto='.$searchYearTo.'&sstatus='.$sstatus.'&ssbudget='.$ssbudget.'&ssall='.$ssall;
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
//////////////////////

if($searchYearFrom and !$_POST['ssbudget'] and !$_POST['ssall'] and !$_POST['sstatus'] and !$_POST['ssCategory']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo') order by projectID desc");//and conceptm_status='new' 
}

if($searchYearFrom and !$_POST['ssbudget'] and !$_POST['sstatus'] and $_POST['ssall'] and !$_POST['ssCategory']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo')  and (projectTitle like '%$ssall%') order by projectID desc");//and conceptm_status='new' 
}
if($searchYearFrom and $_POST['sstatus'] and !$_POST['ssbudget'] and !$_POST['ssall'] and !$_POST['ssCategory']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo')  and (projectStatus='$sstatus') order by projectID desc");//and conceptm_status='new' 
}
if($searchYearFrom and $_POST['ssCategory'] and !$_POST['sstatus'] and !$_POST['ssbudget'] and !$_POST['ssall']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo')  and (researchTypeID='$ssCategory') order by projectID desc");//and conceptm_status='new' 
}

if($searchYearFrom and $_POST['ssbudget'] and !$_POST['sstatus'] and !$_POST['ssall'] and !$_POST['ssCategory']){
$query = $mysqli->query("select COUNT(*) as num FROM ppr_submissions_proposals,ppr_concept_budget where ppr_submissions_proposals.conceptID=ppr_concept_budget.conceptID and ppr_submissions_proposals.owner_id=ppr_concept_budget.owner_id and (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo') order by projectID desc");//and conceptm_status='new' 
}

if(!$_POST['Search']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_proposals order by projectID desc");//and conceptm_status='new' 
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


if($searchYearFrom and !$_POST['ssbudget'] and !$_POST['ssall'] and !$_POST['sstatus'] and !$_POST['ssCategory']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo') order by projectID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if($searchYearFrom and !$_POST['ssbudget'] and !$_POST['sstatus'] and $_POST['ssall'] and !$_POST['ssCategory']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo')  and (projectTitle like '%$ssall%')  order by projectID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}
if($searchYearFrom and $_POST['sstatus'] and !$_POST['ssbudget'] and !$_POST['ssall'] and !$_POST['ssCategory']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo')  and (projectStatus='$sstatus')  order by projectID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}
if($searchYearFrom and $_POST['ssCategory'] and !$_POST['sstatus'] and !$_POST['ssbudget'] and !$_POST['ssall']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals  where (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo')  and (researchTypeID='$ssCategory')  order by projectID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if($searchYearFrom and $_POST['ssbudget'] and !$_POST['sstatus'] and !$_POST['ssall'] and !$_POST['ssCategory']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ppr_submissions_proposals,ppr_concept_budget where ppr_submissions_proposals.conceptID=ppr_concept_budget.conceptID and ppr_submissions_proposals.owner_id=ppr_concept_budget.owner_id and (updatedon BETWEEN '$searchYearFrom' and '$searchYearTo') order by projectID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}


if(!$_POST['Search']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_proposals order by projectID desc LIMIT $start, $limitm";//and conceptm_status='new' 
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
                                                      <th width="268" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                      <th width="206" class="name"><strong><?php echo $lang_Call;?></strong></th>
                                                        <th width="161" class="subject"><strong><?php echo $lang_Submittedby;?></strong></th>
                                                        <?php if($ssbudget){?><th width="100" class="time"><?php echo $ssbudget;?> <?php echo $lang_Budget;?></th><?php }?>
                                                        <th width="100" class="time"><strong><?php echo $lang_Date;?></strong></th>
                                                        <th width="151" class="time"><strong><?php echo $lang_Status;?></strong></th>
                                                    </tr>
                                                    <?php if(!$total_pages){
														if($ssbudget){$colspan=='6';}
														if(!$ssbudget){$colspan=='5';}
														?>
                                                      <tr>
                                                        <td class="small-col" colspan="<?php echo $colspan;?>"><p><?php echo $lang_no_results_displayed;?></p></td>
                                                    </tr>
                                                    <?php }else{
while($rFLists2=$result->fetch_array()){
$owner_id=$rFLists2['owner_id'];
$projectID=$rFLists2['projectID'];
$conceptID=$rFLists2['conceptID'];
$grantID=$rFLists2['grantcallID'];


$queryDistrictsMain="select * from ".$prefix."musers where usrm_id='$owner_id'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$rFListsOnwner=$R_DMain->fetch_array();

$queryDistrictsMain2="select * from ".$prefix."grantcalls where grantID='$grantID'";
$R_DMain2=$mysqli->query($queryDistrictsMain2);	
$rFListsOnwner2=$R_DMain2->fetch_array(); 	





															  ?>
                                                    <tr>
                                                      <td class="small-col"><?php echo $rFLists2['projectTitle'];?><br />
                                                       RefNo: <strong><?php echo $rFLists2['referenceNo'];?></strong>
                                                      
                                                      </td>
                                                      <td class="name"><?php echo $rFListsOnwner2['title'];?></td>
                                                        <td class="subject">
                                                        Name: <?php echo $rFListsOnwner['usrm_fname'];?> <?php echo $rFListsOnwner['usrm_sname'];?><br />
                                                        Email: <?php echo $rFListsOnwner['usrm_email'];?><br />
                                                        Phone: <?php echo $rFListsOnwner['usrm_phone'];?></td>
                                                        
                                                        
                                                        <?php if($ssbudget){?><td class="time" style="background:#B9E1BB;">
                                                        <?php if($ssbudget=='Personnel'){ echo $costs=numberformat($rFLists2['PersonnelTotal']);}
														if($ssbudget=='Research Costs'){ echo $costs=numberformat($rFLists2['ResearchCostsTotal']);}
														if($ssbudget=='Equipment'){ echo $costs=numberformat($rFLists2['EquipmentTotal']);}
														if($ssbudget=='Grant kick off'){ echo $costs=numberformat($rFLists2['kickoffTotal']);}
														if($ssbudget=='Travel Subsistence'){ echo $costs=numberformat($rFLists2['TravelTotal']);}
														if($ssbudget=='Knowledge Sharing'){ echo $costs=numberformat($rFLists2['KnowledgeSharingTotal']);}
														if($ssbudget=='Overhead Costs'){ echo $costs=numberformat($rFLists2['OverheadCostsTotal']);}
														if($ssbudget=='Other Goods'){ echo $costs=numberformat($rFLists2['OtherGoodsTotal']);}
														if($ssbudget=='Matching Support'){ echo $costs=numberformat($rFLists2['MatchingSupportTotal']);}
														
														echo ' '.$rFLists2['currency'];
														
														if($ssbudget=='Personnel'){$overalCosts=$rFLists2['PersonnelTotal']+$overalCosts;}
														if($ssbudget=='Research Costs'){$overalCosts=$rFLists2['ResearchCostsTotal']+$overalCosts;}
														if($ssbudget=='Equipment'){$overalCosts=$rFLists2['EquipmentTotal']+$overalCosts;}
														
														if($ssbudget=='Grant kick off'){$overalCosts=$rFLists2['kickoffTotal']+$overalCosts;}
														if($ssbudget=='Travel Subsistence'){$overalCosts=$rFLists2['TravelTotal']+$overalCosts;}
														
														if($ssbudget=='Knowledge Sharing'){$overalCosts=$rFLists2['KnowledgeSharingTotal']+$overalCosts;}
														if($ssbudget=='Overhead Costs'){$overalCosts=$rFLists2['OverheadCostsTotal']+$overalCosts;}
														if($ssbudget=='Other Goods'){$overalCosts=$rFLists2['OtherGoodsTotal']+$overalCosts;}
														if($ssbudget=='Matching Support'){$overalCosts=$rFLists2['MatchingSupportTotal']+$overalCosts;}
														?>
                                                        
                                                        
                                                        
                                                        </td><?php }?>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['updatedonm'];?>                                                        </td>
                                                      <td class="name">
                                                        
                                                        
                                                        <?php if($rFLists2['projectStatus']=='Pending Final Submission'){?><div class="btn-info-black"><?php echo $lang_PendingFinalSubmission;?></div><?php }?>
                                                        <?php if($rFLists2['projectStatus']=='Approved'){?><div class="btn-info-blue"><?php echo $lang_ApprovedforReview;?></div><?php }?>
                                                        <?php if($rFLists2['projectStatus']=='Rejected'){?><div class="btn-info-red"><?php echo $lang_Rejected;?></div><?php }?>
                                                        <?php if($rFLists2['projectStatus']=='Pending Review'){?><div class="btn-info-blue"><?php echo $lang_PendingReview;?></div><?php }?>
             <?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['awarded']=='No'){?><div class="btn-info-blue"><?php echo $lang_Reviewed;?></div><?php }?>
             <?php if($rFLists2['projectStatus']=='Reviewed' and $rFLists2['awarded']=='Yes'){?><div class="btn-info-blue"><?php echo $lang_Grants_Awarded;?></div>
			 
			 <div class="btn-info-purple"><?php echo numberformat($rFLists2['AmountofGrantawarded']);?> <?php echo $rFLists2['currency'];?></div>
			 
			 <?php }?>
             
                                                        <?php if($rFLists2['projectStatus']=='Scheduled for Review'){?><div class="btn-info-blue"><?php echo $lang_Scheduled_for_Review;?></div><?php }?>
                                                        
                                                        <?php if($rFLists2['projectStatus']=='Completeness Check-Approved'){?><div class="btn-info-blue"><?php echo $lang_CompletenessCheckApproved;?></div><?php }?>
                                                        <?php if($rFLists2['projectStatus']=='Completeness Check-Rejected'){?><div class="btn-info-blue"><?php echo $lang_CompletenessCheckRejected;?></div><?php }?>
                                                        
                                                        
                                                        	 
                                                        
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
<?php }?>
</div><!-- /.table-responsive -->
