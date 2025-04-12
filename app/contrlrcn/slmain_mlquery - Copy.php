<?php
//$Auth = new Auth();
////////////////Begin Table Prefix////////////////////////////////////////////////

$photos_folder="images/photos/";
$requsitions_folder="../files/requsitions/";
////////////////End Table Prefix///////////////////////////////////////////////////

function numberformat($nvalue)
{   
	$returnno=number_format($nvalue,0);  
	return $returnno;
}
//////////////////////////////////////////////////////////////////////////////////////////
function EscapeString($evalue)
{
$returnES=mysql_real_escape_string($evalue);
return $returnES;	
}
///////////////////////date/////////////////
function dateformat($date,$format="")
{
	$default_format="l dS F, Y";
	$format=($format)?$format:$default_format;
	
$new_date=new DateTime($date);
$new_date=$new_date->format($format);

return $new_date;
	
}

function Error($errorvalue)
{
$returnerrorVal=print(mysql_error($errorvalue));
return $returnerrorVal;	
}

if ($_POST['doLogin']=='Sign in')
{

		$name = $mysqli->real_escape_string($_POST['name']);
		$md5pass = md5($mysqli->real_escape_string($_POST['pwd']));

		$sqlUser = "SELECT * FROM ".$prefix."musers where usrm_username='$name' and usrm_password='$md5pass'";
		$queryUser = $mysqli->query($sqlUser);
       $totalUser = $queryUser->num_rows;
        $r = $queryUser->fetch_array();
	
		$dbusrm_id=$r['usrm_id'];
		$dbprdffullname=$r['usrm_fname'];
		$dbusrm_email=$r['usrm_email'];
		$dbusrm_password=$r['usrm_password'];
		$dbusrm_username=$r['usrm_username'];
		$dbusrm_approved=$r['usrm_approved'];
		$dbusrm_usrtype=$r['usrm_usrtype'];
//////////////////////////////////////////////////////////////////////////////////////////////////////////


		if($totalUser==1 && $dbusrm_approved=="1"){ 
		$_SESSION['usrm_username']=$dbusrm_username;
		$_SESSION['usrm_email']=$dbusrm_email;
		$_SESSION['usrm_id']=$dbusrm_id;
		$_SESSION['usrm_usrtype']=$dbusrm_usrtype;
		$_SESSION['mmfullname']=$dbprdffullname;	


//////////////////record action//////////////////////////////////////
$sqlA = "INSERT INTO ".$prefix."logs(lg_action, lg_user, lg_user_level,lg_time) VALUES('$dbusrm_username Logged in from $usersipaddress', '".$_SESSION['mmfullname']."', '".$_SESSION['usrm_usrtype']."','$dateSubmitted')";
$mysqli->query($sqlA);

header("location:./main.php?option=dashboard");

		}
		
		if($totalUser==1 && $dbusrm_approved=="1" and $dbusrm_usrtype=='reviewer'){
			$err2='<span class="error">Thank You for reviewing the NSTIP 2015 Proposals. </span>';
			}
		else {
$err2='<span class="error">Error: Wrong username, password!</span>';
		
		
			}
					}//end if post
			

$category=$mysqli->real_escape_string($_GET['option']);
$pd=$mysqli->real_escape_string($_GET['mdc']);
$id=$mysqli->real_escape_string($_GET['id']);
$bt=$mysqli->real_escape_string($_GET['bt']);
$c=$mysqli->real_escape_string($_GET['c']);
$n=$mysqli->real_escape_string($_GET['n']);
$bkey=$mysqli->real_escape_string($_GET['bkey']);
$bmw=$mysqli->real_escape_string($_GET['bmw']);
$address=$_SERVER['REQUEST_URI'];

///////////////////Begin main link/////////////////
function main($MainLink)
{
	global $category; 
	echo $mlink="main.php?option=";
}
///////////////////End main link/////////////////

//////////////sessions//////////////////////////////////////////////////////////////////////////
		$usrm_username=$_SESSION['usrm_username'];
		$usrm_id=$_SESSION['usrm_id'];
		$session_usertype=$_SESSION['usrm_usrtype'];
		$session_fullname=$_SESSION['mmfullname'];
        $cfn_organisation=$_SESSION['cfn_organisation'];

///////////end sessions/////////////////////////////////////////////////////////////////////////

function authent($value)
{  global  $cac_role,$cm,$mdc;
	if($cac_role==$cm OR $cac_role==$mdc)
	{
	return($value);
	}
}

////////Begin time out////////////////////////////////////////////////////////////////////////////
function timeout($timeout)
				{
    global $usrm_username,$usrm_id,$session_usertype,$session_fullname,$ca_privillages;
		
			if(!$usrm_username and !$usrm_id and !$ca_privillages){
				
			header("Location: ./");
			//die("You are not authorized to see this page");
					}

			$timeout = 10; // Set timeout minutes
			$logout_redirect_url = "./"; // Set logout URL
				
			$timeout = $timeout * 60; // Converts minutes to seconds
			if (isset($_SESSION['start_time'])) {
			$elapsed_time = time() - $_SESSION['start_time'];
			if ($elapsed_time >= $timeout) {
			session_destroy();
			header("Location: $logout_redirect_url");
				}
						}

}
function GenerateCategories()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id;
	
	$sqlGroupDIspC="SELECT cpt_sector FROM ".$prefix."concepts group by cpt_sector";
$sqlFGrpDisC=$mysqli->query($sqlGroupDIspC);
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

////////end time out///////////////////////////////////////////////////////////////////////

function User()
{
global $usrm_username,$usrm_id,$session_usertype,$session_fullname;

}
function UserRegistrationsDisp()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id;

$sqlGroupDIsp="SELECT count(*) as TotalUsers FROM ".$prefix."musers";
$sqlFGrpDis=$mysqli->query($sqlGroupDIsp);
$rGRSP=$sqlFGrpDis->fetch_array();
echo $rGRSP['TotalUsers'];
}

function ConferenceDisp()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsActive="SELECT count(*) as TotalConfs FROM ".$prefix."concepts where conceptm_status='new'";
$sqlConfsActive=$mysqli->query($sqlConfsActive);
$rConfsActive=$sqlConfsActive->fetch_array();
echo $rConfsActive['TotalConfs'];
}


function PendingEvaluationTotals()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsActivedf="SELECT count(*) as TotalConfDFs FROM ".$prefix."concepts where conceptm_status='pending'";
$sqlConfsActivedf=$mysqli->query($sqlConfsActivedf);
$rConfsActivedf=$sqlConfsActivedf->fetch_array();
echo $rConfsActivedf['TotalConfDFs'];
}

function CompletedEvaluationTotals()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsActivedfd="SELECT count(*) as TotalEcConfs FROM ".$prefix."concepts where conceptm_status='completed'";
$sqlConfsActivedfd=$mysqli->query($sqlConfsActivedfd);
$rConfsActivedfd=$sqlConfsActivedfd->fetch_array();
echo $rConfsActivedfd['TotalEcConfs'];
}

function PassedEvaluationTotals()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsPassed="SELECT count(*) as TotalPassed FROM ".$prefix."concepts where conceptm_status='evaluated' and conceptm_Avg>=75";
$sqlConfsPassed=$mysqli->query($sqlConfsPassed);
$rConfsPassed=$sqlConfsPassed->fetch_array();
echo $rConfsPassed['TotalPassed'];
}

function ForwardedSubmissions()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsActive="SELECT count(*) as TotalConfs FROM ".$prefix."concepts where conceptm_status='forwaded'";
$sqlConfsActive=$mysqli->query($sqlConfsActive);
$rConfsActive=$sqlConfsActive->fetch_array();
echo $rConfsActive['TotalConfs'];
}

function MyForwardedSubmissions()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
//conceptsasslogs where conceptm_assignedto='$usrm_id'
$sqlConfsActive="SELECT count(*) as TotalConfs FROM ".$prefix."conceptsasslogs where `conceptm_assignedto`='$usrm_id' and `logm_status`='new'";
$sqlConfsActive=$mysqli->query($sqlConfsActive);
$rConfsActive=$sqlConfsActive->fetch_array();

echo $rConfsActive['TotalConfs'];
}





function MyForwardedProposals()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
//conceptsasslogs where conceptm_assignedto='$usrm_id'
$sqlConfsActive="SELECT count(*) as TotalConfs FROM ".$prefix."conceptsasslogs where `conceptm_assignedto`='$usrm_id' and `logm_status`='new'";
$sqlConfsActive=$mysqli->query($sqlConfsActive);
$rConfsActive=$sqlConfsActive->fetch_array();

echo $rConfsActive['TotalConfs'];
}


function MyCompletedProposals()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
//conceptsasslogs where conceptm_assignedto='$usrm_id'
$sqlConfsActivew="SELECT count(*) as TotalConfs FROM ".$prefix."conceptsasslogs where `conceptm_assignedto`='$usrm_id' and `logm_status`='completed'";
$sqlConfsActivew=$mysqli->query($sqlConfsActivew);
$rConfsActivew=$sqlConfsActivew->fetch_array();

echo $rConfsActivew['TotalConfs'];
}





function MyCompletedSubmissions()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
//conceptsasslogs where conceptm_assignedto='$usrm_id'
$sqlConfsActivep="SELECT count(*) as TotalConfsCompleted FROM ".$prefix."conceptsasslogs where `conceptm_assignedto`='$usrm_id' and `logm_status`='completed'";
$sqlConfsActivep=$mysqli->query($sqlConfsActivep);
$rConfsActivep=$sqlConfsActivep->fetch_array();

echo $rConfsActivep['TotalConfsCompleted'];
}


function TotalConferenceDisp()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsActive1="SELECT count(*) as TotalConfs FROM ".$prefix."concepts";
$sqlConfsActive1=$mysqli->query($sqlConfsActive1);
$rConfsActive1=$sqlConfsActive1->fetch_array();
echo $rConfsActive1['TotalConfs'];
}


function NewSubmissions()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsActive1="SELECT count(*) as TotalConfs FROM ".$prefix."concepts where conceptm_status='new'";
$sqlConfsActive1=$mysqli->query($sqlConfsActive1);
$rConfsActive1=$sqlConfsActive1->fetch_array();
echo $rConfsActive1['TotalConfs'];
}


function FowardedconceptsDisp()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsPending="SELECT count(*) as TotalConfs FROM ".$prefix."concepts where conceptm_status='forwaded'";
$sqlConfsPending=$mysqli->query($sqlConfsPending);
$rConfsPending=$sqlConfsPending->fetch_array();
echo $rConfsPending['TotalConfs'];
}

function rejectedconceptsDisp()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsRejected="SELECT count(*) as TotalConfs FROM ".$prefix."concepts where conceptm_status='rejected'";
$sqlConfsRejected=$mysqli->query($sqlConfsRejected);
$rConfsRejected=$sqlConfsRejected->fetch_array();
echo $rConfsRejected['TotalConfs'];
}
function ApprovedforReviewDisp()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsApproved="SELECT count(*) as TotalConfs FROM ".$prefix."concepts where conceptm_status='approved'";
$sqlConfsApproved=$mysqli->query($sqlConfsApproved);
$rConfsApproved=$sqlConfsApproved->fetch_array();
echo $rConfsApproved['TotalConfs'];
}
function reviewedDisp()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsRejected="SELECT count(*) as TotalConfs FROM ".$prefix."concepts  where conceptm_status='completed'";
$sqlConfsRejected=$mysqli->query($sqlConfsRejected);
$rConfsRejected=$sqlConfsRejected->fetch_array();
echo $rConfsRejected['TotalConfs'];
}
////////////begin packs

function TotalSubmissions()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlConfsSubmns="SELECT count(*) as TotalConfs FROM ".$prefix."concepts where conceptm_status='new'";
$sqlConfsSubms=$mysqli->query($sqlConfsSubmns);
$symposiumpaper1=$sqlConfsSubms->fetch_array();
////////////////////////////////////////////////////////////////////////////
$sqlConfsSubmns2="SELECT count(*) as TotalConfs FROM ".$prefix."concepts where conceptm_status='forwarded'";
$sqlConfsSubms2=$mysqli->query($sqlConfsSubmns2);
$symposiumpaper2=$sqlConfsSubms2->fetch_array();
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
$sqlConfsSubmns3="SELECT count(*) as TotalConfs FROM ".$prefix."concepts where conceptm_status='reviewed'";
$sqlConfsSubms3=$mysqli->query($sqlConfsSubmns3);
$symposiumpaper3=$sqlConfsSubms3->fetch_array();
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
$sqlConfsSubmns4="SELECT count(*) as TotalConfs FROM ".$prefix."concepts where conceptm_status='rejected'";
$sqlConfsSubms4=$mysqli->query($sqlConfsSubmns4);
$symposiumpaper4=$sqlConfsSubms4->fetch_array();
////////////////////////////////////////////////////////////////////////////
?>

<li><!-- Task item -->
<a href="./data/submissions/">
<h3>
New Submissions <span style="color:#00C0EF;">[<?php echo $symposiumpaper1['TotalConfs'];?>]</span>
</h3>
                                              
</a>
</li><!-- end task item -->
                                        
                                        
<li><!-- Task item -->
<a href="./data/submissions/">
<h3>
Forwaded for Review <span style="color:#00A65A;">[<?php echo $symposiumpaper2['TotalConfs'];?>]</span>
</h3>
                                              
</a>
</li><!-- end task item -->
                                        
                                        
<li><!-- Task item -->
<a href="./data/submissions/">
<h3>
Reviewed Submissions <span style="color:#F56954;">[<?php echo $symposiumpaper3['TotalConfs'];?>]</span>
</h3>
                                              
</a>
</li><!-- end task item -->
                                        
<li><!-- Task item -->
<a href="./data/submissions/">
<h3>
Rejected Proposals <span style="color:#F39C12;">[<?php echo $symposiumpaper4['TotalConfs'];?>]</span>
</h3>
                                              
</a>
</li><!-- end task item -->
<?php 
}
////////////begin packs




function MyConferences()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$pages='data/';
$url='dashboard/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."concepts order by conceptm_date desc");
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
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc LIMIT $start, $limitm";
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
                                                      <td width="226" class="small-col"><strong>Proposal</strong></td>
                                                        <td width="140" class="small-col"><strong>Name Of PI</strong></td>
                                                        <td width="174" class="name"><strong>Name of Institution</strong></td>
                                                        <td width="136" class="subject"><strong>Contacts</strong></td>
                                                        <td width="84" class="time"><strong>Date</strong></td>
                                                        <td width="110" class="time"><strong>Sector</strong></td>
                                                        <td width="126" class="time"><strong>Status</strong></td>
                                                        <td width="110" class="time"><strong>Action</strong></td>
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
	  
	function RejectedMSubmission()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$pages='data/';
$url='rejected/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."concepts  where conceptm_status='rejected' order by conceptm_date desc");
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
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where conceptm_status='rejected' order by conceptm_date desc LIMIT $start, $limitm";
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
                                                        <td class="small-col"><strong>Name Of PI ffff</strong></td>
                                                        <td class="name"><strong>Name of Institution</strong></td>
                                                        <td class="subject"><strong>Contacts</strong></td>
                                                        <td class="time"><strong>Message</strong></td>
                                                        <td class="time"><strong>Date</strong></td>
                                                        <td class="time"><strong>Sector</strong></td>
                                                        <td class="time"><strong>Status</strong></td>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="7"><p>No results displayed</p></td>
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
                                                        <td class="small-col"><?php echo $rFLists2['ms_NameOfPI'];?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */?></td>
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


<?php if($rFLists2['conceptm_status']=='evaluated'){?><div class="btn-info-eval">Reviewed</div><?php }?>
</td>
                                                        

                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="8">                                                
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
	  
	  
	  
	  
	  
		function FrowardedFMSubmission()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$pages='data/';
$url='forwaded/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."concepts  where conceptm_status='forwaded' order by conceptm_date desc");
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
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where conceptm_status='forwaded' order by conceptm_date desc LIMIT $start, $limitm";
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
                                                      <td width="299" class="small-col"><strong>Proposal</strong></td>
                                                        <td width="143" class="small-col"><strong>Name Of PI</strong></td>
                                                        <td width="153" class="name"><strong>Name of Institution</strong></td>
                                                        <td width="134" class="subject"><strong>Contacts</strong></td>
                                                        <td width="122" class="time"><strong>Date</strong></td>
                                                        <td width="119" class="time"><strong>Sector</strong></td>
                                                        <td width="140" class="time"><strong>Status</strong></td>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="7"><p>No results displayed</p></td>
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
	  
	  
	  
	  
	function ApprovedFrowardedForReview()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$pages='data/';
$url='approvedfr/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."concepts  where conceptm_status='approved' order by conceptm_date desc");
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
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where conceptm_status='approved' order by conceptm_date desc LIMIT $start, $limitm";
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
                                                      <td width="223" class="small-col"><strong>Proposal</strong></td>
                                                        <td width="124" class="small-col"><strong>Name Of PI</strong></td>
                                                        <td width="167" class="name"><strong>Name of Institution</strong></td>
                                                        <td width="149" class="subject"><strong>Contacts</strong></td>
                                                        <td width="101" class="time"><strong>Date</strong></td>
                                                        <td width="125" class="time"><strong>Sector</strong></td>
                                                        <td width="123" class="time"><strong>Status</strong></td>
                                                        <td width="94" class="time"><strong>Action</strong></td>
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
	  
  
	  
///pending evaluation
function PendingMEvaluation()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$pages='data/';
$url='pendingeval/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."concepts where conceptm_status='pending' order by conceptm_Avg desc");
$total_pages = $query->fetch_array();
$total_pages = $total_pages[num];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
$limitm = 10; 								//how many items to show per page
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
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where conceptm_status='pending' order by conceptm_Avg desc LIMIT $start, $limitm";
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
                                                        <td width="140" class="small-col"><strong>Proposal</strong></td>
                                                        <td width="233" class="time"><strong>Name Of PI</strong></td>
                                                        <td width="144" class="time"><strong>Score by Reviewer</strong></td>
                                                        <td width="65" class="time"><strong>Average Score</strong></td>
                                                        <td width="79" class="time"><strong>Submission Date</strong></td>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="5"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFLists2=$result->fetch_array()){
																										  
																												///////////////////////////////////////////////
														
                                                         $conceptm_id=$rFLists2['conceptm_id'];
                                                         $sqlFLists1Nd="SELECT sum(EvTotalScore/5) AS TotalScores FROM ".$prefix."mscores where conceptm_id='$conceptm_id'";
                                                         $QueryFListsm1Nd=$mysqli->query($sqlFLists1Nd);
                                                          $rScore = $QueryFListsm1Nd->fetch_array(); 
												  
if($rFLists2['conceptm_Reviewers']==5){
$queryScores2="update ".$prefix."concepts  set `conceptm_status`='evaluated' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2);
}
if($rFLists2['conceptm_Reviewers']!=5){//5 evauaters have not finished
$queryScores2="update ".$prefix."concepts  set `conceptm_status`='pending' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2);
}
///updte verge
$EvTotalScore=round($rScore['TotalScores'],0);
$queryScores2ev="update ".$prefix."concepts  set `conceptm_Avg`='$EvTotalScore' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2ev);
															  ?>
                                                    <tr>
                                                        <td class="small-col"><span class="time"><a href="./files/<?php echo $rFLists2['proposalm_upload'];?>" target="_blank"><?php echo $rFLists2['proposalmTittle'];?></a></span></td>
                                                       
                                                        <td class="time"><span class="small-col"><?php echo $rFLists2['ms_NameOfPI'];?></span></td>
                                                      <td class="time">
                                                 
<?php                                                  
$sqlScoreReview="SELECT * FROM ".$prefix."mscores where conceptm_id='$conceptm_id'";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
while($rScoreReview = $QueryScoreReview->fetch_array())
{
	$evaluatedBy=$rScoreReview['EvaluatedBy'];
	//now get this reviewer
$sqlReviewer="SELECT * FROM ".$prefix."musers where usrm_id='$evaluatedBy'";
$QueryReviewer=$mysqli->query($sqlReviewer);
$rReviewer = $QueryReviewer->fetch_array();
	
	?>
  <table width="100%" border="0">
  <tr>
    <td><?php echo $rReviewer['usrm_fname'];?><br />
   <?php /*?> <a href="scoresheet.php?id=<?php echo base64_encode($rScoreReview['EvaluatedBy']);?>&ds=<?php echo base64_encode($conceptm_id);?>" onclick="return popitup('scoresheet.php?id=<?php echo base64_encode($rScoreReview['EvaluatedBy']);?>&ds=<?php echo base64_encode($conceptm_id);?>')">Score Sheet</a><?php */?></td>
    <td style="color:#00A3CB; text-align:center;" valign="top"><?php echo $rScoreReview['EvTotalScore'];?>%</td>
  </tr>
</table>


<?php }?>                                                        </td>
                                                        <td class="name" style="font-size:14px; color:#00A65A; font-weight:bold; text-align:center;"><?php echo round($rScore['TotalScores'],0);?>%</td>
<td class="name"><?php echo $rFLists2['conceptm_datem'];?></td>
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
				   
	  <?php


	  }///////////end function	  
	  
	  
	  
	  
function CompletedMEvaluation()
	  {
	   global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$DB->Query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $DB->FetchNum($QueryFListsm1);
*/
$pages='data/';
$url='completeval/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."mscores group by conceptm_id order by EvTotalScore asc");
$total_pages = $query->fetch_array();
$total_pages = $total_pages[num];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
$limitm = 50; 								//how many items to show per page
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
$sql = "select * FROM ".$prefix."mscores group by conceptm_id order by EvTotalScore asc LIMIT $start, $limitm";
$result = $mysqli->query($sql);
//,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem  conceptm_status='evaluated'
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
                                                <table class="table table-mailbox" width="100%">
                                                    <tr class="unread">
                                                        <td width="246" class="small-col"><strong>Proposal</strong></td>
                                                        <td width="224" class="time"><strong>Reviewer</strong></td>
                                                        <td width="205" class="time"><strong>Name of PI</strong></td>
                                                        <td width="194" class="time"><strong>Technical Review Score</strong></td>
                                                        <td width="140" class="time"><strong>Score Sheet</strong></td>
                                                        <td width="136" class="time"><strong>Total Score</strong></td>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="6"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFLists2=$result->fetch_array()){
														$sconceptm_id=$rFLists2['conceptm_id'];
														$ownerID=$rFLists2['usrm_id'];		  
														$EvaluatedBy=$rFLists2['EvaluatedBy'];
															  
$queryContributionRT="select * from ".$prefix."concepts where conceptm_id='$sconceptm_id'";
$rs_ContributionRT=$mysqli->query($queryContributionRT);
$rsContributionRT=$rs_ContributionRT->fetch_array();  
															  
															  
															  
														  
							  ?>
                                                    <tr>
                                                        <td class="small-col"><?php //echo $sconceptm_id;?> <a href="./files/<?php echo $rsContributionRT['proposalmTittle'];?>" target="_blank"><?php echo $rsContributionRT['proposalmTittle'];?> </a>
														
														</td>
                                                        <td colspan="5" class="time">
                                                          
                                                          <table width="100%" border="0">
                                                            <tr>
                                                              <td width="25%"><b><!--Reviewer--></b></td>
                                                              <td width="26%"><b><!--Name of PI--></b></td>
                                                              <td width="21%" align="right"><b>Technical Review Score</b></td>
                                                              <td width="14%" align="right"><strong>Score Sheet</strong></td>
                                                              <!--<td width="9%" align="right"><b>Viva Score</b></td>-->
                                                              <td width="14%" align="right"><strong>Total Score</strong></td>
                                                            </tr>
                                                            <?php
$sqlConcepts="SELECT * FROM ".$prefix."mscores where conceptm_id='$sconceptm_id' order by EvTotalScore desc";
$QueryConcepts=$mysqli->query($sqlConcepts);//EvaluatedBy='$EvaluatedBy' and conceptm_id='$sconceptm_id' 
while($rConcepts = $QueryConcepts->fetch_array()){
	$dsconceptm_id=$rConcepts['conceptm_id'];
	$susrm_id=$rConcepts['usrm_id'];
	$evaluatedBy=$rConcepts['EvaluatedBy'];
	
	//////////////////////////////////////////////////////////////////////////////////////
$queryReviwer="select * from ".$prefix."musers where usrm_id='$evaluatedBy'";
$rs_Reviwer=$mysqli->query($queryReviwer);
$rsReviwer=$rs_Reviwer->fetch_array();

//proposal Owner
$queryContribution2="select * from ".$prefix."musers where usrm_id='$susrm_id'";
$rs_Contributio2=$mysqli->query($queryContribution2);
$rsContribution2=$rs_Contributio2->fetch_array();  

	//get concept
$sqlConcepts2="SELECT * FROM ".$prefix."concepts where conceptm_id='$sconceptm_id'";
$QueryConcepts2=$mysqli->query($sqlConcepts2);
$rConcepts2 = $QueryConcepts2->fetch_array();
///////////////////////get scores
/*$sqlScoreReview="SELECT * FROM ".$prefix."mscores where conceptm_id='$sconceptm_id' order by EvTotalScore desc";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
$rScoreReview = $QueryScoreReview->fetch_array();*/

///who has reviewed this proposal?
$sqlReviewedm="SELECT count(*) as TotalRevs,sum(EvTotalScore) as TotalEvScore FROM ".$prefix."mscores where conceptm_id='$sconceptm_id' and usrm_id='$susrm_id' group by conceptm_id";
$QueryReviewedm=$mysqli->query($sqlReviewedm);
$rScReviewedm = $QueryReviewedm->fetch_array();
//$totalReviewedm = $QueryReviewedm->num_rows;
$rScReviewedm['TotalEvScore'];

?>
                                                            
                                                            <tr>
                                                              <td style="border-bottom:1px dotted #EAEAEA; padding-right:5px;"><?php echo $rsReviwer['usrm_fname'];?> <?php echo $rsReviwer['usrm_sname'];?></td>
                                                              <td style="border-bottom:1px dotted #EAEAEA;"><?php echo $rsContribution2['usrm_fname'];?> <?php echo $rsContribution2['usrm_sname'];?></td>
  <td style="color:#0073B7; font-weight:bold; text-align:right;border-bottom:1px dotted #EAEAEA; padding:5px;">
    
  <?php echo ($rConcepts['STQnewMethods']+$rConcepts['STQhighQuality']+$rConcepts['STQSatisfactoryPartnership']+$rConcepts['AppAddressIssues']+$rConcepts['ImpactClearlyConvincingly']+$rConcepts['ImpactGenderIssues']);?>
    
    
  <?php //if($rScoreReview['EvTotalScore']){echo numberformat($rScoreReview['EvTotalScore']/75*100).'%';}?>
  </td>
  <td style="color:#00A3CB; text-align:right;border-bottom:1px dotted #EAEAEA; padding:5px;">
    
  <?php if($rConcepts['scoredmID']){?>
  <a href="scoresheetp.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']);?>&ds=<?php echo base64_encode($rConcepts['scoredmID']);?>" onclick="return popitup('scoresheetp.php?id=<?php echo base64_encode($rConcepts['EvaluatedBy']);?>&ds=<?php echo base64_encode($rConcepts['scoredmID']);?>')" style="color:#00A65A; font-weight:bold; font-size:12px;">Click to View</a>
  <?php }?>
    
  </td>
  <?php /*?><td style="color:#0073B7; font-weight:bold; text-align:right;border-bottom:1px dotted #EAEAEA; padding:5px;"><?php if($rScoreReview['AppPrototypeClearly']){echo $rScoreReview['AppPrototypeClearly'];}else{?><br />
   <a href="./data/psviva/<?php echo $rScoreReview['scoredmID'];?>/" style="font-size:12px;">Add Viva Score</a><?php }?></td><?php */?>
                                                              
                                                              <td style="color:#0073B7; font-weight:bold; text-align:right;border-bottom:1px dotted #EAEAEA; padding:5px;">
                                                                
                                                              <?php 
   
   if($rConcepts['EvTotalScore']){echo ($rScReviewedm['TotalEvScore']/$rScReviewedm['TotalRevs']).'%';}?></td>                                                
                                                            </tr>
                                                            
                                                            
                                                            
                                                            <?php }?>
                                                          </table></td>
  </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="6">                                                
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

	  
	  
	  
	  
	  
	  
	 ///pending evaluation
function AllocatedSubmissions()
	  {
	   global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$pages='data/';
$url='sallocation/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."musers order by usrm_fname asc");
$total_pages = $query->fetch_array();
$total_pages = $total_pages[num];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
$limitm = 10; 								//how many items to show per page
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
$sql = "select * FROM ".$prefix."musers order by usrm_fname asc LIMIT $start, $limitm";
$result = $mysqli->query($sql);
//,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem  conceptm_status='evaluated'
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
                                                <table class="table table-mailbox" width="100%">
                                                    <tr class="unread">
                                                        <td width="139" class="small-col"><strong>Reviewer</strong></td>
                                                        <td width="853" class="time"><strong>Concept</strong></td>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="2"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFLists2=$result->fetch_array()){
														$usermrid=$rFLists2['usrm_id'];	  
							  ?>
                                                    <tr>
                                                        <td class="small-col"><?php echo $rFLists2['usrm_fname'];?></td>
                                                       
                                                        <td class="time">
                                                          
                                                          <table width="100%" border="0">
                                                            <tr>
                                                              <td width="42%"><b>Concept</b></td>
                                                              <td width="26%"><b>Name of PI</b></td>
                                                              <td width="20%" align="right"><b>Technical Review Score</b></td>
                                                              <td width="12%" align="right"><b>Viva Score</b></td>
                                                            </tr>
  <?php
$sqlConcepts="SELECT * FROM ".$prefix."conceptsasslogs where conceptm_assignedto='$usermrid'";
$QueryConcepts=$mysqli->query($sqlConcepts);
while($rConcepts = $QueryConcepts->fetch_array()){
	$sconceptm_id=$rConcepts['conceptm_id'];
	//$evaluatedBy=$rConcepts['conceptm_id'];
	//get concept
$sqlConcepts2="SELECT * FROM ".$prefix."concepts where conceptm_id='$sconceptm_id'";
$QueryConcepts2=$mysqli->query($sqlConcepts2);
$rConcepts2 = $QueryConcepts2->fetch_array();
///////////////////////get scores
$sqlScoreReview="SELECT * FROM ".$prefix."mscores where conceptm_id='$sconceptm_id'";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
$rScoreReview = $QueryScoreReview->fetch_array();

?>
                                                            
         <tr>
 <td style="border-bottom:1px dotted #EAEAEA;"><a href="./files/<?php echo $rConcepts2['proposalm_upload'];?>" target="_blank"><?php echo $rConcepts2['proposalmTittle'];?> </a></td>
   <td style="border-bottom:1px dotted #EAEAEA;"><?php echo $rConcepts2['ms_NameOfPI'];?></td>
<td style="color:#00A3CB; text-align:right;border-bottom:1px dotted #EAEAEA; padding:5px;"><?php if($rScoreReview['EvTotalScore']){echo $rScoreReview['EvTotalScore'].'%';}?></td>

   <td style="color:#00A3CB; text-align:right;border-bottom:1px dotted #EAEAEA; padding:5px;"><?php if($rScoreReview['AppPrototypeClearly']){echo $rScoreReview['AppPrototypeClearly'].'%';}else{echo "----";}?></td>                                                
  </tr>
                                                            
                                                            
                                                            
  <?php }?>
  </table>
                                                          
</td>
</tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="2">                                                
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
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	    
	  
	  function PassedMEvaluation()
	  {
	   global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$pages='data/';
$url='passed/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."concepts where conceptm_status='evaluated' and conceptm_Avg>=75 order by conceptm_Avg desc");
$total_pages = $query->fetch_array();
$total_pages = $total_pages[num];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
$limitm = 10; 								//how many items to show per page
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
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where conceptm_status='evaluated' and conceptm_Avg>=75 order by conceptm_Avg desc LIMIT $start, $limitm";
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
                                                        <td width="140" class="small-col"><strong>Name Of PI</strong></td>
                                                        <td width="233" class="time"><strong>Concept</strong></td>
                                                        <td width="144" class="time"><strong>Score by Reviewer</strong></td>
                                                        <td width="65" class="time"><strong>Average Score</strong></td>
                                                        <td width="79" class="time"><strong>Submission Date</strong></td>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="5"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFLists2=$result->fetch_array()){
																										  
																												///////////////////////////////////////////////
														
                                                         $conceptm_id=$rFLists2['conceptm_id'];
                                                         $sqlFLists1Nd="SELECT sum(EvTotalScore/5) AS TotalScores FROM ".$prefix."mscores where conceptm_id='$conceptm_id'";
                                                         $QueryFListsm1Nd=$mysqli->query($sqlFLists1Nd);
                                                          $rScore = $QueryFListsm1Nd->fetch_array(); 
												  
if($rFLists2['conceptm_Reviewers']==5){
$queryScores2="update ".$prefix."concepts  set `conceptm_status`='evaluated' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2);
}
if($rFLists2['conceptm_Reviewers']!=5){//5 evauaters have not finished
$queryScores2="update ".$prefix."concepts  set `conceptm_status`='pending' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2);
}
///updte verge
$EvTotalScore=round($rScore['TotalScores'],0);
$queryScores2ev="update ".$prefix."concepts  set `conceptm_Avg`='$EvTotalScore' where `conceptm_id`='$conceptm_id'";
$mysqli->query($queryScores2ev);
															  ?>
                                                    <tr>
                                                        <td class="small-col"><?php echo $rFLists2['ms_NameOfPI'];?> <?php /*?><br />(Ref No: <?php echo $rFLists2['referenceno'];?>)<?php */?></td>
                                                       
                                                        <td class="time"><a href="./files/<?php echo $rFLists2['proposalm_upload'];?>" target="_blank"><?php echo $rFLists2['proposalmTittle'];?> </a> </td>
                                                        <td class="time">
                                                 
<?php                                                  
$sqlScoreReview="SELECT * FROM ".$prefix."mscores where conceptm_id='$conceptm_id'";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
while($rScoreReview = $QueryScoreReview->fetch_array())
{
	$evaluatedBy=$rScoreReview['EvaluatedBy'];
	//now get this reviewer
$sqlReviewer="SELECT * FROM ".$prefix."musers where usrm_id='$evaluatedBy'";
$QueryReviewer=$mysqli->query($sqlReviewer);
$rReviewer = $QueryReviewer->fetch_array();
	
	?>
  <table width="100%" border="0">
  <tr>
    <td><?php echo $rReviewer['usrm_fname'];?><br />
 <?php /*?>   <a href="scoresheet.php?id=<?php echo base64_encode($rScoreReview['EvaluatedBy']);?>&ds=<?php echo base64_encode($conceptm_id);?>" onclick="return popitup('scoresheet.php?id=<?php echo base64_encode($rScoreReview['EvaluatedBy']);?>&ds=<?php echo base64_encode($conceptm_id);?>')">Score Sheet</a><?php */?></td>
    <td style="color:#00A3CB; text-align:center;" valign="top"><?php echo $rScoreReview['EvTotalScore'];?>%</td>
  </tr>
</table>


<?php }?>     
                                                 
                                                 
                                                 
                                                 

                                                        
                                                        </td>
                                                        <td class="name" style="font-size:14px; color:#00A65A; font-weight:bold; text-align:center;"><?php echo round($rScore['TotalScores'],0);?>%</td>
<td class="name"><?php echo $rFLists2['conceptm_datem'];?>
</td>
</tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="5">                                                
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
	  
	  
	  
	  
	  
	  
	  
	  
	function LogsD()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
$sqlFLists1="SELECT *,DATE_FORMAT(`logdate`,'%d/%m/%Y') AS logdatem FROM ".$prefix."mlogs order by lid desc limit 0,50";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
		  ?>
 <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox">
                                                    <tr class="unread">
                                                        <td class="small-col"><strong>Log Details</strong></td>
                                                        <td class="name"><strong>Name</strong></td>
                                                        <td class="subject"><strong>Email</strong></td>
                                                        <td class="time"><strong>IP</strong></td>
                                                        <td class="time"><strong>Date</strong></td>
                                                    </tr>
                                                    <?php if(!$totalFL1){?>
                                                      <tr>
                                                        <td class="small-col" colspan="5"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFLists2=$QueryFListsm1->fetch_array()){
																											  
															  
															  ?>
                                                    <tr>
                                                        <td class="small-col"><?php echo $rFLists2['log_details'];?> </td>
                                                        <td class="name"><?php echo $rFLists2['logname'];?></td>
                                                        <td class="subject"><?php echo $rFLists2['logemail'];?></td>
                                                        <td class="time"><?php echo $rFLists2['logip'];?></td>
                                                        <td class="time"><?php echo $rFLists2['logdatem'];?> </td>
                                            
                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
                                                </table>
                                      </div><!-- /.table-responsive -->
				   
	  <?php


	  }///////////end function
  
	
function MyConferencesReviewer()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
$sqlConceptLogs="SELECT * FROM ".$prefix."conceptsasslogs where conceptm_assignedto='$usrm_id' order by assignm_date desc limit 0,150";
$QueryConcept=$mysqli->query($sqlConceptLogs);
$totalFL1 = $QueryConcept->num_rows;


		  ?>
 <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox" width="100%">
                                                    <tr class="unread">
                                                        <td width="38%" class="time"><strong>Concept</strong></td>
                                                        <td width="17%" class="time"><strong>Date</strong></td>
                                                        <td width="13%" class="time"><strong>Sector</strong></td>

                                                        <td width="12%" class="time"><strong>Status</strong></td>
                                                        <td width="9%" class="time"><strong>Score</strong></td>
                                                        <td width="11%" class="time"><strong>Action</strong></td>
                                                    </tr>
                                                    <?php if(!$totalFL1){?>
                                                      <tr>
                                                        <td class="small-col" colspan="6"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFListsmain=$QueryConcept->fetch_array()){
															$conceptm_idd=$rFListsmain['conceptm_id'];
															////////////////////subs///////////////
 $sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where conceptm_id='$conceptm_idd' order by conceptm_date desc";
                                              $QueryFListsm1=$mysqli->query($sqlFLists1);
                                              $rFLists2=$QueryFListsm1->fetch_array();  
															  
															  
															  
														$sto=$rFLists2['conceptm_assignedto'];
														$sqlAssigned="SELECT * FROM ".$prefix."musers where usrm_id='$sto'";
														$sqlAssigned=$mysqli->query($sqlAssigned);
														$syAssigned=$sqlAssigned->fetch_array();											  
														///////////////////////////////////////////////
														
                                                         $conceptm_id=$rFLists2['conceptm_id'];
                                                         $sqlFLists1Nd="SELECT * FROM ".$prefix."mscores where conceptm_id='$conceptm_id' and EvaluatedBy='$usrm_id'";
                                                         $QueryFListsm1Nd=$mysqli->query($sqlFLists1Nd);
														 $totalScores = $QueryFListsm1Nd->num_rows;
                                                          $rScore = $QueryFListsm1Nd->fetch_array();  
															  ?>
                                                    <tr>
                                                        <td class="time"><?php if($rFLists2['proposalm_uploadReup']){?><?php echo $rFLists2['proposalmTittle'];?><?php }?> </td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['conceptm_datem'];?>    
                                                        
                                                        </td>
                                                        <td class="name"><?php echo $rFLists2['cpt_sector'];?></td>
<td class="name">
<?php if($rFLists2['conceptm_status']=='new'){?><div class="btn-info-black">New</div><?php }?>
<?php if($rFLists2['conceptm_status']=='approved'){?><div class="btn-info-blue">Approved</div><?php }?>
<?php if($rFLists2['conceptm_status']=='rejected'){?><div class="btn-info-red">Rejected</div><?php }?>
<?php if($rFLists2['conceptm_status']=='forwaded'){?><div class="btn-info-orange">Pending</div><?php }?>
<?php if($rFLists2['conceptm_status']=='completed'){?><div class="btn-info-blue">Complete</div><?php }?>
</td>
<td class="name"><?php if($totalScores){?>
<p style="font-size:14px; color:#00A65A; font-weight:bold;"><?php echo $rScore['EvTotalScore'];?>% </p>  
<?php }?></td>
                                                        
<td class="name">
<?php if($rFLists2['conceptm_status']=='completed'){?><div style="color:#00A65A; font-weight:bold;">Complete</div><?php }?>
<?php if(!$totalScores){?>
<a href="./data/score/<?php echo $rFLists2['conceptm_id'];?>/">Click to Review</a>    
<?php }?>


</td>
                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
                                                </table>
              </div><!-- /.table-responsive -->
				   
	  <?php


	  }///////////end function  
	  
	  function MessagesMain()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
	  //////////////Get all unread messages//////////////////////////
$sqlMSG="SELECT * FROM ".$prefix."rmessages where cac_sent_to='$usrm_id' and msg_status='unread'";
$QueryMSG=$mysqli->query($sqlMSG);
$totalMSGUread = $QueryMSG->num_rows;

//////////////Get all sent messages//////////////////////////
$sqlMSG1="SELECT * FROM ".$prefix."rmessages where cac_sent_by='$usrm_id'";
$QueryMSG1=$mysqli->query($sqlMSG1);
$totalMSGSent = $QueryMSG1->num_rows;		  
//////////////Get all sent messages//////////////////////////
$sqlMSG2="SELECT * FROM ".$prefix."rmessages where cac_sent_to='$usrm_id' and msg_status='deleted'";
$QueryMSG2=$mysqli->query($sqlMSG2);
$totalMSGDeleted = $QueryMSG2->num_rows;			  
		  ?>
<?php /*?><li class="compose"><a class="iconcomp" href="./user/compose/" style=" color:#18587E; font-weight:bold; text-transform:uppercase; font-size:12px;"><b>Compose</b></a></li><?php */?>
<li class="b2"><a class="icon inbox" href="./user/inbox/"><b>Inbox <?php if($totalMSGUread>=1){?>(<?php echo $totalMSGUread;?>)<?php }?></b></a></li>
<li class="b2"><a class="icon outbox" href="./user/sentmsg/">Sent <?php if($totalMSGSent>=1){?>(<?php echo $totalMSGSent;?>)<?php }?></a></li>

				   
	  <?php
	
	  }///////////end function
	  
	  
	  
	  
	  function MainNotice()
{
global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;

$sqlNotice="SELECT * FROM ".$prefix."notices where notice_date>='$today' order by notice_date desc limit 0,1";
$QueryNotice=$mysqli->query($sqlNotice);
$rNotice=$QueryNotice->fetch_array();
$rTotalNotice=$QueryNotice->num_rows;
if($rTotalNotice){
?>
<h4>Important!</h4>
<p style="margin: 8px 0"><?php echo $rNotice['notice_title'];?>. <br />
Venue: <?php echo $rNotice['notice_venue'];?><br /> 
Time: <?php echo dateformat($rNotice['notice_time'],"h:i:s A");?></p>
<?php 
}
}
	  
	  
	  
	  
	  //begin statistics
	  function Statistics()
	  {
		///unread posts
global $prefix,$usrm_id,$usrm_username,$mysqli,$cac_role;
$sqlUnread="SELECT * FROM ".$prefix."rmessages where cac_sent_to='$usrm_id' and msg_status='unread'";
$QueryUnread=$mysqli->query($sqlUnread);
$totalUnredPosts = $QueryUnread->num_rows;  
		///read posts
$sqlRead="SELECT * FROM ".$prefix."rmessages where cac_sent_to='$usrm_id' and msg_status='read'";
$QueryRead=$mysqli->query($sqlRead);
$totalRedPosts = $QueryRead->num_rows; 		  
		  ?>

<?php /*?>               <p class="stat"><span class="number">27</span>Notifications</p>  
   
         <p class="stat"><span class="number">53</span>Unsaved Taks</p>
    <p class="stat"><span class="number">53</span>Assigned Tasks</p><?php */?>
    <p class="stat"><span class="number"><?php echo $totalRedPosts;?></span>Read Posts</p>
    <p class="stat" style="color:#F00;"><span class="number"><?php echo $totalUnredPosts;?></span>Unread Posts</p>
    <?php
	  }//end statistics
	  		  //begin statistics
	  function photo1()
	  {
		///unread posts
global $prefix,$usrm_id,$usrm_username,$mysqli,$cac_role;
$sqlphoto1="SELECT * FROM ".$prefix."musers  where usrm_id='$usrm_id' and usrm_username='$usrm_username'";
$Queryphoto1=$mysqli->query($sqlphoto1);
$sqPhoto1 = $Queryphoto1->fetch_array(); 		  
		  ?>
<?php if($sqPhoto1['usrm_profilepic']){?><img src="files/photos/<?php echo $sqPhoto1['usrm_profilepic'];?> " class="img-circle"/><?php }?>
    <?php
	  }//end statistics 
	  
		  //begin statistics
	  function photo()
	  {
		///unread posts
global $prefix,$usrm_id,$usrm_username,$mysqli,$cac_role;
$sqlphoto="SELECT * FROM ".$prefix."musers  where usrm_id='$usrm_id' and usrm_username='$usrm_username'";
$Queryphoto=$mysqli->query($sqlphoto);
$sqPhoto = $Queryphoto->fetch_array(); 		  
		  ?>
<?php if($sqPhoto['usrm_profilepic']){?><img src="files/photos/<?php echo $sqPhoto['usrm_profilepic'];?> "/><?php }?>
    <?php
	  }//end statistics  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	    ///pending evaluation
function SubmissionsByCtegories()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli;
/*$sqlFLists1="SELECT *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y') AS conceptm_datem FROM ".$prefix."concepts order by conceptm_date desc limit 0,10";
$QueryFListsm1=$mysqli->query($sqlFLists1);
//where cfn_submittedBy='$usrm_id'
$totalFL1 = $QueryFListsm1->num_rows;
*/
$category=$_POST['category'];
$pages='data/';
$url='report/';
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."concepts where cpt_sector='$category' order by conceptm_Avg desc");
}
if(!$_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."concepts  order by conceptm_Avg desc");
}
// where conceptm_status='forwaded'
$total_pages = $query->fetch_array();
$total_pages = $total_pages[num];

/* Setup vars for query. */
//$targetpage = $page.$url.$value; 
$targetpage = $pages.$url; 	//your file name  (the name of this file)
$limitm = 150; 								//how many items to show per page
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
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts where cpt_sector='$category' order by conceptm_Avg desc LIMIT $start, $limitm";
}
if(!$_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`conceptm_date`,'%d/%m/%Y %H:%s:%i') AS conceptm_datem FROM ".$prefix."concepts  order by conceptm_Avg desc LIMIT $start, $limitm";
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
                                                    <tr class="unread">
                                                        <td width="113" class="small-col"><strong>Proposal</strong></td>
                                                      <td width="76" class="name"><strong>Name Of PI</strong></td>
                                                      <td width="66" class="subject"><strong>Contacts</strong></td>
                                                      <td width="104" class="time"><strong>Name of Institution</strong></td>
                                                      <td width="51" class="time"><strong>Date</strong></td>
                                                      <td width="89" class="time"><strong>Category</strong></td>
                                                      <td width="77" class="time"><strong>Total Score</strong></td>
                                                  </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="7"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{

														  while($rFLists2=$result->fetch_array()){
																										  
																												///////////////////////////////////////////////
														
                                                         $sconceptm_id=$rFLists2['conceptm_id'];
														 $susrm_id=$rFLists2['usrm_id'];
														 
                                                         $sqlFLists1Nd="SELECT * FROM ".$prefix."mscores where conceptm_id='$sconceptm_id'";
														 //sum(EvTotalScore/5) AS TotalScores
                                                         $QueryFListsm1Nd=$mysqli->query($sqlFLists1Nd);
                                                          $rScore = $QueryFListsm1Nd->fetch_array(); 
														  $EvTotalScore=numberformat($rScore['EvTotalScore']/75*100);
														  $update="update ".$prefix."concepts set conceptm_Avg='$EvTotalScore' where  conceptm_id='$sconceptm_id'";                              $mysqli->query($update);
														    
															
															///who has reviewed this proposal?
$sqlReviewedm="SELECT count(*) as TotalRevs,sum(EvTotalScore) as TotalEvScore FROM ".$prefix."mscores where conceptm_id='$sconceptm_id' and usrm_id='$susrm_id' group by conceptm_id";
$QueryReviewedm=$mysqli->query($sqlReviewedm);
$rScReviewedm = $QueryReviewedm->fetch_array();
//$totalReviewedm = $QueryReviewedm->num_rows;
$rScReviewedm['TotalEvScore'];
															  ?>
                                                    <tr>
                                                        <td class="small-col"><a href="./files/<?php echo $rFLists2['proposalm_upload'];?>" target="_blank"><?php echo $rFLists2['proposalmTittle'];?> </a></td>
                                                        <td class="name"><?php echo $rFLists2['ms_NameOfPI'];?></td>
                                                        <td class="subject">Email: <?php echo $rFLists2['conceptm_email'];?><br />
                                                        Phone: <?php echo $rFLists2['conceptm_phone'];?>
                                                        </td>
                                                        <td class="time"><?php echo $rFLists2['conceptm_NameofInstitution'];?> </td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['conceptm_datem'];?>    
                                                        
                                                        </td>
                                                        <td class="name"><?php if($rFLists2['cpt_sector']!='Other'){echo $rFLists2['cpt_sector'];}?>
<?php if($rFLists2['cpt_sector']=='Other'){?><br />Other Sector: <?php echo $rFLists2['cpt_othersector'];}?>
</td>
<td class="name" style="font-size:14px; color:#00A65A; font-weight:bold; text-align:center;">

<?php 
   echo ($rScReviewedm['TotalEvScore']/$rScReviewedm['TotalRevs']).'%';?>

</td>
                                                        

                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="8">                                                
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
	  
	  
	  

	  
?>