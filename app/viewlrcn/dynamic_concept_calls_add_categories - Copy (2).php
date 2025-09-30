<?php
/*Begin add new category*/
$sessionusrm_id=$_SESSION['usrm_id'];
if($_POST['doSaveData']=='Save' and $_POST['newcategory'] and $_SESSION['usrm_id']){

	
$category=$mysqli->real_escape_string($_POST['newcategory']);
$category_number=$mysqli->real_escape_string($_POST['category_number']);
$sqlUsers="SELECT * FROM ".$prefix."dynamic_categories_main where `category_name`='$category' and catadminstatus='dynamic' and catadmin_id='$sessionusrm_id' order by  	category_id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."dynamic_categories_main (`category_name`,`category_rank`,`published`,`catadmin_id`,`catadminstatus`) 

values('$category','','Yes','$sessionusrm_id','dynamic')";
$mysqli->query($sqlA2);	
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another category.</p>';	
}

if($QueryUsers->num_rows){
$message='<p class="error2">Dear '.$session_fullname.', details were already submitted, please add another category.</p>';		
}
	
}
/*End add new category*/

if($_POST['doSaveData']=='Save & Proceed to Add Questions' and $_SESSION['usrm_id']){

	
	for ($i=0; $i < count($_POST['category']); $i++) {
$category=$mysqli->real_escape_string($_POST['category'][$i]);

$category_number=$mysqli->real_escape_string($_POST['question_no'][$i]);
$finalCategoryID=$mysqli->real_escape_string($_POST['finalCategoryID'][$i]);

$sqlUsers="SELECT * FROM ".$prefix."grantcall_categories where `categoryName`='$category' and `status`='new'  and categorym='concept' order by categoryID desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."grantcall_categories (`categoryName`,`categorym`,`date_added`,`status`,`category_number`,`catadmin_id`,`catadminstatus`) 

values('$category','concept',now(),'new','$category_number','$sessionusrm_id','dynamic')";
$mysqli->query($sqlA2);	
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another category.</p>';


}

if($QueryUsers->num_rows){
$sqlA2="update ".$prefix."grantcall_categories set `category_number`='$category_number' where categoryID='$finalCategoryID'";
$mysqli->query($sqlA2);		
	
}

	}//end foreach
echo '<img src="img/ajax-loader1.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=DynamicCallConceptsQns&id=$id'>";
	
}

//Get the last category
$sqlLastQn="SELECT * FROM ".$prefix."grantcall_categories where `status`='new' order by categoryID desc limit 0,1";
$QueryLastQn = $mysqli->query($sqlLastQn);
$rUserLastQn=$QueryLastQn->fetch_array();
?><div class="tab">

    <button class="tablinks"  onclick="openCity(event, 'DynamicCallConcepts')" id="defaultOpen"><?php echo $lang_new_SubmitConceptCategories;?> </button>

<button onClick="window.location.href='./main.php?option=DynamicCallConceptsQns&id=<?php echo $id;?>'"><?php echo $lang_new_AddQuestionsCategories;?> </button>
<button onClick="window.location.href='./main.php?option=SubmitCallforConceptNew&id=<?php echo $id;?>'"><?php echo $lang_new_FInishSubmitCOncept;?></button>


</div>

<div id="DynamicCallConcepts" class="tabcontent ">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>

   
  <h3>Dynamic Concept Calls Categories</h3>
<?php if($message){?><div style="color:#F00; font-size:18px;"><?php echo $message;?></div><?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">

 
 <div class="container success"><!--begin-->
 
 <label for="fname">Please choose from categories below for this new call concept. (<span class="error">*</span>)</label>
  
  
   <div class="row success">
   
  
  <?php
	if($id and !$_POST['doSaveData'] and $sessionusrm_id){
$sqlProjectIDDel="SELECT * FROM ".$prefix."grantcall_categories where categoryID='$id' order by categoryID desc";
$QueryProjectIDDel = $mysqli->query($sqlProjectIDDel);
$rUserProjectIDDel=$QueryProjectIDDel->fetch_array();

if($QueryProjectIDDel->num_rows){
	$newcatid=$rUserProjectIDDel['categoryID'];
	$newmaincatid=$rUserProjectIDDel['categoryName'];
	
	$sqlA2Protocol2="delete from ".$prefix."grantcall_categories where categoryID='$newcatid' and catadmin_id='$sessionusrm_id'";
	$mysqli->query($sqlA2Protocol2);
	///Dont delete main categories
	
	$sqlProjectIDDelMain="SELECT * FROM ".$prefix."dynamic_categories_main where category_id='$newmaincatid' and catadminstatus='dynamic' order by category_id desc limit 0,1";
$QueryProjectIDDelMain = $mysqli->query($sqlProjectIDDelMain);
	if($QueryProjectIDDelMain->num_rows){
	$sqlA2Protocol22="delete from ".$prefix."dynamic_categories_main where category_id='$newmaincatid' and catadmin_id='$sessionusrm_id' and catadminstatus='dynamic'";
	$mysqli->query($sqlA2Protocol22);
	}
	
	$message='<p class="error2">Dear '.$session_fullname.', category has been removed from your list.</p>';	
}
	}
	
$sqlProjectID2="SELECT * FROM ".$prefix."dynamic_categories_main where `published`='Yes' and (catadmin_id='$sessionusrm_id' || catadminstatus='fixed')  order by category_rank asc";
$QueryProjectID2 = $mysqli->query($sqlProjectID2);
if($QueryProjectID2->num_rows){?>
  <table width="100%" border="0">
 <tr>
   <th>&nbsp;</th>
    <th>Category</th>
    <th>Category No (Arrange Categories)</th>
    <th>Action</th>
  </tr>


        
        <?php 
while($rUserProjectID2=$QueryProjectID2->fetch_array()){
	$category_id=$rUserProjectID2['category_id'];
	/* category_name*/
	$sqlProjectID3="SELECT * FROM ".$prefix."grantcall_categories where `status`='new'  and categorym='concept' and categoryName='$category_id' order by categoryID desc";
$QueryProjectID3 = $mysqli->query($sqlProjectID3);
$rUserProjectID3=$QueryProjectID3->fetch_array();

?>
  <tr>
  <td width="7%" style="border-bottom:2px solid #4CAF50; border-right:2px solid #4CAF50;">
  <?php if($category_id==18){?>
  <input name="category[]" type="checkbox" value="<?php echo $rUserProjectID2['category_id'];?>" checked="checked"/>
  <?php }?>
  
  <?php if($category_id!=18){?>
  <input name="category[]" type="checkbox" value="<?php echo $rUserProjectID2['category_id'];?>" <?php if($rUserProjectID2['category_id']==$rUserProjectID3['categoryName']){?>checked="checked"<?php }?>/>
  <?php }?>
  
  
  
  <input name="finalCategoryID[]" type="hidden" value="<?php echo $rUserProjectID3['categoryID'];?>" />
  
   </td>
  
    <td width="47%" style="border-bottom:2px solid #4CAF50; border-right:2px solid #4CAF50;"><?php echo $rUserProjectID2['category_name']; ?></td>
    
    
    <td width="28%" align="center" style="border-bottom:2px solid #4CAF50; border-right:2px solid #4CAF50;">
    <?php if($category_id==18){?><input name="question_no[]" type="text" style="height:30px; width:100px;" value="<?php if(!$rUserProjectID3['category_number']){echo "1";}else{echo $rUserProjectID3['category_number'];}?>" readonly="readonly"/><?php }?>
       <?php if($category_id!=18){?><input name="question_no[]" type="text" style="height:30px; width:100px;" value="<?php echo $rUserProjectID3['category_number'];?>"/><?php }?>
    
    </td>
    
    <td width="18%" align="center" style="border-bottom:2px solid #4CAF50;"> 
	
	
	<?php if($QueryProjectID3->num_rows and $rUserProjectID3['categoryName']!=1){?> <a href="./main.php?option=DynamicCallConcepts&id=<?php echo $rUserProjectID3['categoryID'];?>"  style="color:#F00;padding:5px; font-size:12px;" onclick="return confirm('Are you sure you want to remove this Category?');">Remove Category</a><?php }?></td>
  </tr>


        <?php }?>

    
 <?php }?>
 
</table>

 
   <input type="submit" name="doSaveData" value="Save & Proceed to Add Questions">
  </div>
</div><!--End-->


</form>


<div class="container success"><button id="myBtn" style="float:left;">Click to Add More Categories</button>
<div style="clear:both;"></div>
</div>






</div>


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h3><strong>Add new theme/category</strong></h3>
    </div>
    <div class="modal-body" style="height:450px; overflow:scroll;">
    <!--<h4>Name Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal</h4>-->
     <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
     
     
      
 <div class="container"><!--begin-->
 
 <label for="fname">Please add categories for this new call concept. (<span class="error">*</span>)</label>
  
  <div class="row success">

    <div class="col-100">
    <table width="100%" border="0">
  <tr>
    <td width="100%"><label for="fname">Category/Theme <span class="error">*</span></label>
      <input type="text" id="MyTextBox3mmmm" name="newcategory" placeholder="Category/Theme.." value="<?php echo $rUserInv2['categoryName'];?>" required onKeyUp="showUser(this.value)">
      
      
      <div id="txtHint"></div>
      </td>

  </tr>
</table>

      
    </div>
    
    
    
  </div>
  
   <div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
  
  
     </form>
     </div>
     </div>
     </div>
     

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>