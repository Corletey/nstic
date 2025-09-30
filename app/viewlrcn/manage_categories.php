<?php
	//doSaveFive
	$action=$mysqli->real_escape_string($_GET['action']);
if($_POST['doFilesUpload']){
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
	$rstug_categoryName=$mysqli->real_escape_string($_POST['rstug_categoryName']);

	$rstug_categoryName_fr=$mysqli->real_escape_string($_POST['rstug_categoryName_fr']);
	$rstug_categoryName_pt=$mysqli->real_escape_string($_POST['rstug_categoryName_pt']);
	$published=$mysqli->real_escape_string($_POST['published']);

$sqlstudy="SELECT * FROM ".$prefix."categories where rstug_categoryName='$rstug_categoryName' order by rstug_categoryID desc";//
$Querystudy = $mysqli->query($sqlstudy);
$totalstudy = $Querystudy->num_rows;
if(!$totalstudy){
$sqlA2="insert into ".$prefix."categories (`rstug_categoryName`,`rstug_categoryName_fr`,`rstug_categoryName_pt`,`rstugshort1`,`rstugshort2`,`rstugNo`,`dateupdated`,`published`) 

values('$rstug_categoryName','$rstug_categoryName_fr','$rstug_categoryName_pt','','','',now(),'$published')";
$mysqli->query($sqlA2);



$message='<div class="success">Dear '.$session_fullname.', Category details have been added.</div>';
logaction("$session_fullname added New Category $rstug_categoryName");
}
if($totalstudy){
$message='<div class="error2">Dear '.$session_fullname.', looks like duplicate Category Name</div>';	
}



}//end post
	
if($_GET['action']=="delete"){
	
$sqlstudy33="SELECT * FROM ".$prefix."categories where rstug_categoryID='$id'";//
$Querystudy33 = $mysqli->query($sqlstudy33);	
$rInGoal=$Querystudy33->fetch_array();
$Attachment=$rInGoal['Attachment'];
$upDelete="update ".$prefix."categories  set published='No' where  rstug_categoryID='$id'";
$mysqli->query($upDelete);

 $message="<span class=error2>Category has been successfully diabled.</span>"; 
}

if($_GET['action']=="deleted"){
	
$sqlstudy33="SELECT * FROM ".$prefix."categories where rstug_categoryID='$id'";//
$Querystudy33 = $mysqli->query($sqlstudy33);	
$rInGoal=$Querystudy33->fetch_array();
$Attachment=$rInGoal['Attachment'];
$upDelete="delete from ".$prefix."categories where  rstug_categoryID='$id'";
$mysqli->query($upDelete);

 $message="<span class=error2>Category has been successfully Deleted.</span>"; 
}

if($_GET['action']=="update" and $_POST['doUpdate']){

$rstug_categoryName=$mysqli->real_escape_string($_POST['eng']);

	$rstug_categoryName_fr=$mysqli->real_escape_string($_POST['fr']);
	$rstug_categoryName_pt=$mysqli->real_escape_string($_POST['pt']);
	

		
$upUpdate="update ".$prefix."categories  set rstug_categoryName='$rstug_categoryName',rstug_categoryName_fr='$rstug_categoryName_fr', rstug_categoryName_pt='$rstug_categoryName_pt' where  rstug_categoryID='$id'";
$mysqli->query($upUpdate);

 $message="<span class=error2>Category has been successfully Updated.</span>"; 
}
if( $message){echo  $message;}
	?>
 
 <h4 class="niceheaders"><?php echo $lang_Category;?> </h4><hr />
 
 <button id="myBtn"><?php echo $lang_AddNewCategory;?> </button> 

<div style="clear:both;"></div>
<form action="" method="post" name="regForm2" id="regForm2" autocomplete="off"  enctype="multipart/form-data">
 
 <?php 
$category=$_POST['category'];
$page='main.php?';
$url='category=';
$value='ManageCategories&id='.$id;
//$value='listuserauthorised';

$tbl_name="";		//your table name
// How many adjacent pages should be shown on each side?
$adjacents = 3;
/* 
First get total number of rows in data table. 
If you have a WHERE clause in your query, make sure you mirror it here.
*/
if($id){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."categories  order by rstug_categoryID desc");//and conceptm_status='new' 
}

if(!$id){
$query = $mysqli->query("select COUNT(*) as num from ".$prefix."categories order by rstug_categoryID desc");//and conceptm_status='new' 
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
$sql = "select *,DATE_FORMAT(`dateupdated`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."categories order by rstug_categoryID desc LIMIT $start, $limitm";//and conceptm_status='new' 
}

if(!$id){
$sql = "select *,DATE_FORMAT(`dateupdated`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."categories order by rstug_categoryID desc LIMIT $start, $limitm";//and conceptm_status='new' 
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
 <td class="small-col" colspan="4">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                
                                                
                                                    <tr class="unread">
                                                      <th width="268" class="small-col"><strong><?php echo $lang_Category;?> Eng</strong></th>
                                                      <th width="206" class="name"><strong><?php echo $lang_Category;?> FR</strong></th>
                                                      <th width="100" class="time"><strong><?php echo $lang_Category;?> PT</strong></th>
                                                        <th width="100" class="time">Action</th>
                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="4"><p><?php echo $lang_no_results_displayed;?></p></td>
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
                                                      <td class="small-col"><?php echo $rFLists2['rstug_categoryName'];?>
<?php if($action=='update' and $id==$rFLists2['rstug_categoryID']){?><input name="eng" type="text" value="<?php echo $rFLists2['rstug_categoryName'];?>"/><?php }?>
                                                      
                                                      </td>
                                                      <td class="name">
													  <?php echo $rFLists2['rstug_categoryName_fr'];?>
 <?php if($action=='update' and $id==$rFLists2['rstug_categoryID']){?><input name="fr" type="text" value="<?php echo $rFLists2['rstug_categoryName_fr'];?>"/><?php }?>
                                                      
                                                      </td>
                                                      <td class="time"><?php echo $rFLists2['rstug_categoryName_pt'];?>
                                                      
<?php if($action=='update' and $id==$rFLists2['rstug_categoryID']){?><input name="pt" type="text" value="<?php echo $rFLists2['rstug_categoryName_pt'];?>"/>
	
	<input type="submit" name="doUpdate" value="Update">
	<?php }?>
                                                      
                                                      </td>
                                                        <td class="time">
                                                        
<a href="./main.php?option=ManageCategoriesUpdate&action=update&id=<?php echo $rFLists2['rstug_categoryID'];?>" style="font-size:11px;">Update</a><br />
  <a href="./main.php?option=ManageCategoriesUpdate&action=update&id=<?php echo $rFLists2['rstug_categoryID'];?>" style="font-size:11px;" onclick="return confirm('Are you sure you want to Disable this category? Click OK to confirm or CANCEL.');">Disable</a> <br />
  
  <a href="./main.php?option=ManageCategories&action=deleted&id=<?php echo $rFLists2['rstug_categoryID'];?>" style="font-size:11px; color:#F00;" onclick="return confirm('Are you sure you want to Disable this category? Click OK to confirm or CANCEL.');">Delete</a>                                                      
                                                        
                                                        </td>
                                                    </tr>

                                                    <?php }}?>
                                                   
                                                  
  <tr>
 <td class="small-col" colspan="4">                                                
   <div class="nav_purgination">
<?php echo $pagination;?>
<div class="clear"></div>
</div><!--end purgination section--></td>
</tr>
                                                </table>
</div><!-- /.table-responsive -->
</form>

   <!-- The Modal -->
<div id="myModal" class="modal" style="margin-top:80px;">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
    
    </div>
    <div class="modal-body" style="height:300px; overflow:scroll;">

 <form action="" method="post" name="regForm" id="regForm" enctype="multipart/form-data">
 
 
 <div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_Category;?> Eng: <span class="error">*</span></label>
<div class="col-sm-7">
<input type="text" name="rstug_categoryName" id="rstug_categoryName" tabindex="9" value="" class="form-control  required"/>
</div>
</div> 

 <div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_Category;?> FR: <span class="error">*</span></label>
<div class="col-sm-7">
<input type="text" name="rstug_categoryName_fr" id="rstug_categoryName_fr" tabindex="9" value="" class="form-control  required"/>
</div>
</div>

 <div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_Category;?> PT: <span class="error">*</span></label>
<div class="col-sm-7">
<input type="text" name="rstug_categoryName_pt" id="rstug_categoryName_pt" tabindex="9" value="" class="form-control"/>
</div>
</div>
 
 <div class="form-group row success">
 
<label class="col-sm-4 form-control-label">Publish: <span class="error">*</span></label>
<div class="col-sm-7">
<input name="published" type="radio" value="Yes" /> Yes<br />
<input name="published" type="radio" value="No" /> No
</div>
</div> 

  
  




 

            
                  
       
       <div class="form-group row">
                          <div class="col-sm-4 offset-sm-3">
                    <input name="doFilesUpload" type="submit"  class="btn btn-primary" value="Save"/>

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