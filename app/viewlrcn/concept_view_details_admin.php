<?php
//include("viewlrcn/concepts_statistics.php");
$sql44 = "select * FROM ".$prefix."grantcalls where grantID='$id'";//and conceptm_status='new' 
$result44 = $mysqli->query($sql44);
$rFLists24=$result44->fetch_array();

if($category=='InviteForFullProposal'){
	$concepid=$_GET['concepid'];	  
$sqlFLists1="SELECT * FROM ".$prefix."submissions_concepts where conceptID='$concepid'";
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

$sqlGrants="SELECT * FROM ".$prefix."grantcalls where conceptID='$id'";
$QueryFListGrants=$mysqli->query($sqlGrants);
$rsGrants=$QueryFListGrants->fetch_array();
$grantcallIDMain=$rsGrants['grantID'];

$sqlA2="update ".$prefix."submissions_concepts set `invited_for_proposal`='invited',grantcallIDMain='$grantcallIDMain' where conceptID='$concepid'";
$mysqli->query($sqlA2);
////Send email now
$startDate=$rFLists24['startDate'];
$EndDate=$rFLists24['EndDate'];
$details=$rFLists24['details'];
$title=$rFLists24['title'];

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
$mail->addCc('mawandammoses@gmail.com','Grants Proposal Submission');//
$mail->addBcc("$emailBcc",'Grants Proposal Submission');//

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "Grants Proposal Submission - $rstug_rsch_project_title";
$body="$allSentMessage";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

//////////////////////////////End Mail Body


//$email=$rsOwner['usrm_email'];

///end email
echo $message='<p class="success" style="font-size:16px;">Dear <strong>'.$usrm_username.'</strong>, concept has been invited for full proposal. A mail notification has been sent to <strong>'.$dbfirstname.'</strong></p>';
}
}///This concept exists
 ?>
 
 <h4 class="niceheaders"><?php echo $rFLists24['title'];?></h4><hr />
 <?php 
$category=$_POST['category'];
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
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_concepts where finalSubmission='Made Final Submission' and grantcallID='$id' order by conceptID desc");//and conceptm_status='new' 
}

if(!$_POST['doSearch']){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."submissions_concepts where finalSubmission='Made Final Submission' and grantcallID='$id'  order by conceptID desc");//and conceptm_status='new' 
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
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_concepts  where finalSubmission='Made Final Submission' and grantcallID='$id' order by conceptID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if(!$_POST['doSearch']){
$sql = "select *,DATE_FORMAT(`updatedon`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."submissions_concepts  where finalSubmission='Made Final Submission' and grantcallID='$id' order by conceptID desc LIMIT $start, $limitm";//and conceptm_status='new' 
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
                                                      <th width="268" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                      <th width="206" class="name"><strong><?php echo $lang_Category;?></strong></th>
                                                        <th width="161" class="subject"><strong><?php echo $lang_Submittedby;?></strong></th>
                                                        <th width="100" class="time"><strong><?php echo $lang_Date;?></strong></th>
                                                        <th width="151" class="time"><strong><?php echo $lang_Status;?></strong></th>
                                                        <th width="165" class="time"><?php echo $lang_Score;?> %</th>
                                                        <th width="165" class="time"><?php echo $lang_Reviewer;?></th>
                                                        <th width="165" class="time"><strong><?php echo $lang_Action;?></strong></th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="8"><p><?php echo $lang_no_results_displayed;?></p></td>
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
if($rFListsScores['Total']){$TotalScore=($rFListsScores['Total']/$rFListsScores['TotalReviewers']);}

//if($rFLists2['projectStatus']=='Pending Review'){echo $color="#C0E4C2";}
$color="#C0E4C2";

															  ?>
                                                    <tr>
                                                      <td class="small-col" style="background:<?php echo $color;?>!important;"><?php echo $rFLists2['projectTitle'];?><br />
                                                      RefNo: <strong><?php echo $rFLists2['referenceNo'];?></strong>
                                                      
                                                      
                                                      
                                                      </td>
                                                      <td class="name"><?php echo $rCategory['rstug_categoryName'];?></td>
                                                        <td class="subject"  style="background:<?php echo $color;?>!important;">
                                                        Name: <?php echo $rFListsOnwner['usrm_fname'];?> <?php echo $rFListsOnwner['usrm_sname'];?><br />
                                                        Email: <?php echo $rFListsOnwner['usrm_email'];?><br />
                                                        Phone: <?php echo $rFListsOnwner['usrm_phone'];?>                                                        </td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['updatedonm'];?>                                                        </td>
                                                      <td class="name">
                                         
                                                      
  <?php if($rFLists2['projectStatus']=='Pending Final Submission'){?><div class="btn-info-black"><?php echo $lang_PendingFinalSubmission;?></div><?php }?>
  <?php if($rFLists2['projectStatus']=='Approved'){?><div class="btn-info-blue"><?php echo $lang_ApprovedforReview;?></div><?php }?>
  <?php if($rFLists2['projectStatus']=='Rejected'){?>
  
  <input id="go" type="button" value="<?php echo $lang_Rejected;?>" onclick="window.open('comments.php?id=<?php echo $rFLists2['conceptID'];?>','popUpWindow','height=700, width=1000, left=100, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes');"  class="btn-info-red" >
  
  
  
  <?php }
  
  ?>
  <?php if($rFLists2['projectStatus']=='Pending Review'){?><div class="btn-info-blue"><?php echo $lang_PendingReview;?></div><?php }?>
  <?php if($rFLists2['projectStatus']=='Reviewed'){?><div class="btn-info-blue"><?php echo $lang_Reviewed;?></div><?php }?>
  <?php if($rFLists2['projectStatus']=='Scheduled for Review'){?><div class="btn-info-blue"><?php echo $lang_Scheduled_for_Review;?></div><?php }?>
  
  
  </td>
                                                      <td class="time"><strong style="font-size:24px; font-weight:bold; color:#F00;"><?php echo ($TotalScore);?></strong><br />
                                                   

                                                      
                                                      
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

<?php if($rFLists2['projectStatus']=='Pending Review'){?>
<div class='button2'><a href="./main.php?option=reviewProjectInformation&id=<?php echo $rFLists2['conceptID'];?>">Click to Review</a></div> <?php }?>

<?php if($rFLists2['projectStatus']=='Reviewed'){?>
<div class='button3'><a href="./main.php?option=reviewProjectInformation&id=<?php echo $rFLists2['conceptID'];?>"><?php echo $lang_ClicktoViewDetails;?></a></div> <?php }?>

<?php if($rFLists2['projectStatus']=='Approved'){?>
<div class='button3'><a href="./main.php?option=reviewProjectInformation&id=<?php echo $rFLists2['conceptID'];?>"><?php echo $lang_FowardforReview;?></a></div> <?php }?><br />

<?php if($rFLists2['projectStatus']=='Scheduled for Review'){?>
<div class='button2'><a href="./main.php?option=reviewProjectInformation&id=<?php echo $rFLists2['conceptID'];?>"><?php echo $lang_ReassignConcept;?> </a></div> <?php }?><br />



<?php if($rFLists2['invited_for_proposal']!='invited' and $rFLists2['projectStatus']=='Reviewed'){?>

<div class="button2"><a href="main.php?option=InviteForFullProposal&id=<?php echo $id;?>&concepid=<?php echo $rFLists2['conceptID'];?>" onclick="return confirm('Are you sure you want to Invite to Submit full Proposal? Click OK to confirm or CANCEL.');"><?php echo $lang_InvitetoSubmitfullProposal;?></a></div>
<?php }?>

</td>
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
	