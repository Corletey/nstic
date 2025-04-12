<?php
   function MyConferences()
	  {
	  global $prefix,$usrm_id,$usrm_username,$mysqli,$usrrsmyLoggedIdm,$category,$id;
if($category=='InviteForFullProposal'){	  
$sqlFLists1="SELECT * FROM ".$prefix."submissions_concepts where conceptID='$id'";
$QueryFListsm1=$mysqli->query($sqlFLists1);
$totalFL1 = $QueryFListsm1->num_rows;

//Get User details
if($totalFL1){
	//if concept exist, get user details
$rsuseYes=$QueryFListsm1->fetch_array();
$owner_id=$rsuseYes['owner_id'];
$rstug_rsch_project_title=$rsuseYes['projectTitle'];	
///seletct
$sqlFListsOwner="SELECT * FROM ".$prefix."musers where usrm_id='$owner_id'";
$QueryFListOwner=$mysqli->query($sqlFListsOwner);
$rsOwner=$QueryFListOwner->fetch_array();
$email=$rsOwner['usrm_email'];
$dbfirstname=$rsOwner['usrm_fname'].' '.$rsOwner['usrm_sname'];
$dbsurname=$rsOwner['usrm_fname'];

$sqlA2="update ".$prefix."submissions_concepts set `invited_for_proposal`='invited' where conceptID='$id'";
$mysqli->query($sqlA2);
////Send email now

require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php"); 

require("viewlrcn/mail_template_userto_send_proposal.php");
///Now send Email
$mail = new PHPMailer(true); //important
$mail->IsSMTP(); // set mailer to use SMTP
$mail->Port = $usmtpportNo; // SMTP Port
$mail->CharSet =  "utf-8";
$mail->Host = $usmtpHost; // specify SMTP server//nemesis.eahd.or.ug mailhost02.cfi.co.ug
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->SMTPSecure = $emailSSL;
$mail->SMTPDebug = 0;


$mail->Username = "$emailUsername"; // SMTP username -- CHANGE --
$mail->Password = "$emailPassword"; // SMTP password -- CHANGE --
$mail->setFrom("$emailUsername", "Admin");
$mail->FromName = "Grants Management - UNCST"; //From Name -- CHANGE --
$mail->AddReplyTo($email, $dbfirstname); //To Address -- CHANGE --
$mail->AddAddress($email, $dbfirstname);
/////////////////////////////Begin Mail Body
//$mail->addCc('$emailUsername','Activation Link from UNCST');//
//$mail->addBcc('mawandammoses@gmail.com','Grants Final Submission');//

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Management - $rstug_rsch_project_title";
$body="$allSentMessage";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

//////////////////////////////End Mail Body


//$email=$rsOwner['usrm_email'];

///end email
echo $message='<p class="success">Dear <strong>'.$usrm_username.'</strong>, concept has been invited for full proposal. A mail notification has been sent to <strong>'.$dbfirstname.'</strong></p>';
}
}///This concept exists
?>
 <h4 class="niceheaders">Latest Submitted Concepts</h4><hr />
 <?php 
//$category=$_POST['category'];
$page='main.php?';
$url='category=';
$value='dashboard&id='.$id;
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_concepts where finalSubmission='Made Final Submission' order by conceptID desc");//and conceptm_status='new' 
}

if(!$_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_concepts where finalSubmission='Made Final Submission' order by conceptID desc");//and conceptm_status='new' 
}
$total_pages = $query->fetch_array($mysqli->query($query));
$rFListss2=$query->fetch_array();
$total_pages = $rFListss2['num'];

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
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y %H:%s:%i') AS updatedonm FROM ".$prefix."submissions_concepts  where finalSubmission='Made Final Submission' order by conceptID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if(!$_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y %H:%s:%i') AS updatedonm FROM ".$prefix."submissions_concepts  where finalSubmission='Made Final Submission' order by conceptID desc LIMIT $start, $limitm";//and conceptm_status='new' 
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
 <td class="small-col" colspan="8">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                
                                                    <tr class="unread">
                                                      <th width="171" class="small-col"><strong>Title</strong></th>
                                                      <th width="147" class="name"><strong>Category</strong></th>
                                                        <th width="124" class="subject"><strong>Submitted by</strong></th>
                                                        <th width="72" class="time"><strong>Date</strong></th>
                                                        <th width="118" class="time"><strong>Status</strong></th>
                                                        <th width="91" class="time">Score %</th>
                                                        <th width="325" class="time">Reviewers</th>
                                                        <th width="325" class="time"><strong>Action</strong></th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="8"><p>No results displayed</p></td>
                                                    </tr>
                                                    <?php }else{
while($rFLists2=$result->fetch_array()){
$owner_id=$rFLists2['owner_id'];
$researchTypeID=$rFLists2['researchTypeID'];
$conceptID=$rFLists2['conceptID'];



$queryDistrictsMain="select * from ".$prefix."musers where usrm_id='$owner_id'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$rFListsOnwner=$R_DMain->fetch_array();

$queryCategory="select * from ".$prefix."categories where rstug_categoryID='$researchTypeID'";
$R_Category=$mysqli->query($queryCategory);	
$rCategory=$R_Category->fetch_array();

$sqlwwScores = "select *,count(EvaluatedBy) AS TotalReviewers,sum(EvTotalScore) AS Total FROM ".$prefix."mscores_new where usrm_id='$owner_id' and conceptm_id='$conceptID'  and categorym='concepts' group by conceptm_id order by scoredmID desc limit 0,10";
$resultwwScores = $mysqli->query($sqlwwScores);
$rFListsScores=$resultwwScores->fetch_array();
$TotalScore=($rFListsScores['Total']/$rFListsScores['TotalReviewers']);

$update="update ".$prefix."mscores_new set  EvgeneralTotal='$TotalScore' where conceptm_id='$conceptID' and usrm_id='$owner_id'  and categorym='concepts'";
$mysqli->query($update);
															  ?>
                                                    <tr>
                                                      <td class="small-col"><?php echo $rFLists2['projectTitle'];?></td>
                                                      <td class="name"><?php echo $rCategory['rstug_categoryName'];?></td>
                                                        <td class="subject">
                                                        Name: <?php echo $rFListsOnwner['usrm_fname'];?> <?php echo $rFListsOnwner['usrm_sname'];?><br />
                                                        Email: <?php echo $rFListsOnwner['usrm_email'];?><br />
                                                        Phone: <?php echo $rFListsOnwner['usrm_phone'];?>                                                        </td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['updatedonm'];?>                                                        </td>
                                                      <td class="name">
                                         
                                                      
  <?php if($rFLists2['projectStatus']=='Pending Final Submission'){?><div class="btn-info-black">Pending Final Submission</div><?php }?>
  <?php if($rFLists2['projectStatus']=='Approved'){?><div class="btn-info-blue">Approved for Review</div><?php }?>
  <?php if($rFLists2['projectStatus']=='Rejected'){?><div class="btn-info-red">Rejected</div><?php }?>
  <?php if($rFLists2['projectStatus']=='Pending Review'){?><div class="btn-info-blue">Pending Review</div><?php }?>
  <?php if($rFLists2['projectStatus']=='Reviewed'){?><div class="btn-info-blue">Reviewed</div><?php }?>
  <?php if($rFLists2['projectStatus']=='Scheduled for Review'){?><div class="btn-info-blue">Scheduled for Review</div><?php }?>
  
  
  </td>
                                                      <td class="time">
<strong style="font-size:24px; font-weight:bold; color:#F00;"><?php echo $TotalScore;?></strong>



</td>
                                                      <td class="time">
                                                      
  <?php
$queryCategoryReview="select * from ".$prefix."mscores_new where conceptm_id='$conceptID' and usrm_id='$owner_id'  and categorym='concepts'";
$R_CategoryReview=$mysqli->query($queryCategoryReview);	
while($rCReview=$R_CategoryReview->fetch_array()){
	 $EvaluatedBy=$rCReview['EvaluatedBy']; 
	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();
	
	?>
    <?php if($TotalScore and $rFListsReviewer['usrm_sname']){?>
<input id="go" type="button" value="<?php echo $rFListsReviewer['usrm_sname'];?> <?php echo $rFListsReviewer['usrm_fname'];?>, View Score" onclick="window.open('adminscoresheet.php?id=<?php echo base64_encode($EvaluatedBy);?>&ds=<?php echo base64_encode($rCReview['scoredmID']);?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-blue" ><br /><?php }?>                                                
                                                    
 <?php }?>                                                
                                                      
                                                      </td>
<td class="time">

<?php if($rFLists2['projectStatus']=='Pending Review'){?><a href="./data/reviewProjectInformation/<?php echo $rFLists2['conceptID'];?>/" class='button2'>Click to Review</a> <?php }?>

<?php if($rFLists2['projectStatus']=='Reviewed'){?><a href="./data/reviewProjectInformation/<?php echo $rFLists2['conceptID'];?>/" class='button3'>Click to View Details</a> <?php }?>

<?php if($rFLists2['projectStatus']=='Approved'){?><a href="./data/reviewProjectInformation/<?php echo $rFLists2['conceptID'];?>/" class='button3'>Foward for Review</a> <?php }?><br />

<?php if($rFLists2['invited_for_proposal']!='invited' and $rFLists2['projectStatus']=='Reviewed'){?><div class="button2"><a href="./data/InviteForFullProposal/<?php echo $rFLists2['conceptID'];?>/" onclick="return confirm('Are you sure you want to Invite to Submit full Proposal? Click OK to confirm or CANCEL.');">Invite to Submit full Proposal</a></div>


<?php }?>

</td>
                                                    </tr>

                                                    <?php }}?>
                                                   

	
    </table>			   
	  <?php


	  }///////////end function
	  ?>