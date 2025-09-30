<?php
	//doSaveFive
if($_POST['doFilesUpload'] and $_FILES['Attachment']['name']){
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
	$DocumentName=$mysqli->real_escape_string($_POST['DocumentName']);

	$recAffiliated_id=$mysqli->real_escape_string($_POST['recAffiliated_id']);
	$protocol_id=$mysqli->real_escape_string($_POST['protocol_id']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$Version=$mysqli->real_escape_string($_POST['Version']);
	$Language=$mysqli->real_escape_string($_POST['Language']);
	$Description=$mysqli->real_escape_string($_POST['Description']);
	$mdate=$mysqli->real_escape_string($_POST['date']);
	$month=$mysqli->real_escape_string($_POST['month']);
	$year=$mysqli->real_escape_string($_POST['year']);
	$DateofProposal=$mysqli->real_escape_string($year.'-'.$month.'-'.$mdate);

$extensionw = getExtension(preg_replace('/\s+/', '_', $_FILES['Attachment']['name']));

if($extensionw=='pdf'){
	
if($_FILES['Attachment']['name']){
$Attachment = preg_replace('/\s+/', '_', $_FILES['Attachment']['name']);
$Attachment2 = $asrmApplctID.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['Attachment']['name']));
$targetw1 = "files/meetings/". basename($asrmApplctID.preg_replace('/\s+/', '_', $_FILES['Attachment']['name']));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['Attachment']['tmp_name']), $targetw1);

}

$sqlstudy="SELECT * FROM ".$prefix."monitoring_reports where filename='$DocumentName'  and Attachment='$Attachment2'";//
$Querystudy = $mysqli->query($sqlstudy);
$totalstudy = $Querystudy->num_rows;
if(!$totalstudy){
$sqlA2="insert into ".$prefix."monitoring_reports (`owner_id`,`protocol_id`,`filename`,`Version`,`Description`,`Attachment`,`docDate`,`category`) 

values('$asrmApplctID','$protocol_id','$DocumentName','$Version','$Description','$Attachment2',now(),'Financial')";
$mysqli->query($sqlA2);



$message='<div class="success">Dear '.$session_fullname.', Monitoring Reports details have been added.</div>';
logaction("$session_fullname added Monitoring Reports details");
}
if($totalstudy){
$message='<div class="error2">Dear '.$session_fullname.', looks like duplicate file attached</div>';	
}
}else{$message="<span class=error2>Please upload PDF file (s) only. Your File was not uploaded</span>";}


}//end post
	
if($_GET['comnme']=="delete"){
	
$sqlstudy33="SELECT * FROM ".$prefix."monitoring_reports where id='$id'";//
$Querystudy33 = $mysqli->query($sqlstudy33);	
$rInGoal=$Querystudy33->fetch_array();
$Attachment=$rInGoal['Attachment'];
$upDelete="delete from ".$prefix."monitoring_reports  where  id='$id'";
$mysqli->query($upDelete);

$file = "./files/meetings/$Attachment";
if (!unlink($file))
  {
  //echo ("Error deleting $file");
  }
else
  {
 // echo ("Deleted $file");
  }
 $message="<span class=error2>$lang_FinancialReports has been successfully removed.</span>"; 
}
if( $message){echo  $message;}
	?>
 
 <h4 class="niceheaders"><?php echo $lang_FinancialReports;?></h4><hr />
  <div style="margin-top:5px;"></div>
<span  class="button2" style="float:left; padding:10px;"><a href="exportmreports.php?en=Financial"> <?php echo $lang_ExportResults;?></a></span>
 
 <button id="myBtn"><?php echo $lang_AddNew.' '. $lang_FinancialReports;?> </button> 

<div style="clear:both;"></div>
 
 <?php 
$category=$_POST['category'];
$page='main.php?';
$url='category=';
$value='FinancialReports&id='.$id;
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($id){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."monitoring_reports where category='Financial' order by id desc");//and conceptm_status='new' 
}

if(!$id){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."monitoring_reports where category='Financial' order by id desc");//and conceptm_status='new' 
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
if($id){
$sql = "select *,DATE_FORMAT(`docDate`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."monitoring_reports where category='Financial' order by id desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if(!$id){
$sql = "select *,DATE_FORMAT(`docDate`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."monitoring_reports where category='Financial' order by id desc LIMIT $start, $limitm";//and conceptm_status='new' 
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
 <td class="small-col" colspan="3">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                
                                                    <tr class="unread">
                                                      <th width="268" class="small-col"><strong>File Name</strong></th>
                                                      <th width="206" class="name"><strong>Attachment</strong></th>
                                                        <th width="100" class="time"><strong><?php echo $lang_Date;?></strong></th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="3"><p><?php echo $lang_no_results_displayed;?></p></td>
                                                    </tr>
                                                    <?php }else{
while($rFLists2=$result->fetch_array()){
$owner_id=$rFLists2['owner_id'];
$projectID=$rFLists2['projectID'];
$conceptID=$rFLists2['conceptID'];

	
$queryReviewer="select * from ".$prefix."musers where usrm_id='$EvaluatedBy'";
$R_DReviewer=$mysqli->query($queryReviewer);	
$rFListsReviewer=$R_DReviewer->fetch_array();



															  ?>
                                                    <tr>
                                                      <td class="small-col"><?php echo $rFLists2['filename'];?>
                                                      
                                                      </td>
                                                      <td class="name"><?php echo $rFLists2['Attachment'];?></td>
                                                        <td class="time">
                                                 
                                                 <?php echo $rFLists2['docDate'];?>                                                        </td>
                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="3">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                </table>
</div><!-- /.table-responsive -->


   <!-- The Modal -->
<div id="myModal" class="modal" style="margin-top:80px;">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
 
    </div>
    <div class="modal-body" style="height:300px; overflow:scroll;">

 <form action="" method="post" name="regForm" id="regForm" enctype="multipart/form-data">
 
 <div class="form-group row success">
<label class="col-sm-10 form-control-label"><?php echo $lang_protcolSubmittingTo;?>: <span class="error">*</span></label>
<div class="col-sm-10">

<select name="protocol_id" id="protocol_id" class="form-control  required">
<option value=""><?php echo $lang_please_select;?></option>
<?php
$sqlSubmission = "select * FROM ".$prefix."submissions_proposals order by projectID desc"; //where awarded='Yes' 
$QuerySubmission = $mysqli->query($sqlSubmission);
while($resultSubmission=$QuerySubmission->fetch_array()){
?>
<option value="<?php echo $resultSubmission['projectID'];?>"><?php echo $resultSubmission['projectTitle'];?></option>

<?php }?>

</select>
</div>
</div>
 
 <div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_DocumentName;?>: <span class="error">*</span></label>
<div class="col-sm-7">
<input type="text" name="DocumentName" id="DocumentName" tabindex="9" value="" class="form-control  required"/>
</div>
</div> 

 
 <div class="form-group row success">
 
<label class="col-sm-4 form-control-label"><?php echo $lang_Version;?>: <span class="error">*</span></label>
<div class="col-sm-7">
<input type="text" name="Version" id="Version" class="form-control  required" value="" required>

</div>
</div> 


       


 <div class="form-group row success">
 
<label class="col-sm-3 form-control-label"><?php echo $lang_FilePDF;?> <span class="error">*</span>:</label>
<div class="col-sm-8">
<input name="Attachment" type="file" id="Attachment" class="required" required/>

<input type="hidden" name="asrmApplctID" value="<?php echo $_SESSION['asrmApplctID'];?>">
<input type="hidden" name="recAffiliated_id" value="<?php echo $recAffiliated_id;?>">
</div>
</div>
                        
  




 

            
                  
       
       <div class="form-group row">
                          <div class="col-sm-4 offset-sm-3">
                    <input name="doFilesUpload" type="submit"  class="btn btn-primary" value="<?php echo $lang_Save;?>"/>

                          </div>
                        </div>
                                          
     </form>                   
    </div>
    </div>
    </div><!--End-->
    
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