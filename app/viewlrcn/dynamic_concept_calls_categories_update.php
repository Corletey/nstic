<?php
/*Begin add new category*/
$sessionusrm_id=$_SESSION['usrm_id'];
	
	////doSaveUpdate
	
	if($_POST['doSaveUpdate']=='Update Categories' and $_SESSION['usrm_id'] and $id){

	
	for ($i=0; $i < count($_POST['finalCategoryID']); $i++) {

$category_number=$mysqli->real_escape_string($_POST['category_number'][$i]);
$finalCategoryID=$mysqli->real_escape_string($_POST['finalCategoryID'][$i]);

$sqlA2="update ".$prefix."grantcall_categories set `category_number`='$category_number' where `categoryID`='$finalCategoryID' and grantID='$id'";
$mysqli->query($sqlA2);		

/////Update Stages
$sqlAStatus="update ".$prefix."concept_dynamic_stages set `catordering_up`='1' where `grantcallID`='$id'";
$mysqli->query($sqlAStatus);

}//end foreach

	
	
	
	
	
$sqlCatNos="SELECT count(*) AS TotalCount FROM ".$prefix."grantcall_categories where `grantID`='$id'  and categorym='concept' group by category_number order by TotalCount desc";
$QueryCatNos = $mysqli->query($sqlCatNos);
$rowsCount=$QueryCatNos->fetch_array();

$rowsCount['TotalCount'];
if($rowsCount['TotalCount']>=2){
$message='<p class="error2">Dear '.$session_fullname.', you have duplicate naming of category numbers, please review. Note; Project Title should be number 1</p>';
}

/*if($rowsCount['TotalCount']<=1){
echo '<img src="./img/ajax-loader1.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=DynamicCallConceptsQns/$id/';</script>");
}/////////////end*/
	}//end Post	\
	
	if($_POST['doNextPage']=='Proceed to Next Page'){
echo '<img src="./img/ajax-loader1.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=DynamicCallConceptsQns&id=$id&action=update'>";

}


//Get the last category
$sqlLastQn="SELECT * FROM ".$prefix."grantcall_categories where `status`='new' order by categoryID desc limit 0,1";
$QueryLastQn = $mysqli->query($sqlLastQn);
$rUserLastQn=$QueryLastQn->fetch_array();

//check any category
$sqlCatGrantCategoryUp="SELECT * FROM ".$prefix."concept_dynamic_stages where `grantcallID`='$id'  and categorym='concept' and catadmin_id='$sessionusrm_id' order by id desc";
$AnyCategorySavedUP = $mysqli->query($sqlCatGrantCategoryUp);
$AnyCategoryRows=$AnyCategorySavedUP->fetch_array();
$AnyCategorySavedG=$AnyCategorySavedUP->num_rows;
?><div class="tab">
<?php
if($AnyCategorySavedG){?>

    
   <button <?php if($AnyCategoryRows['categories_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=DynamicCallConcepts&id=<?php echo $id;?>&action=update'"><?php echo $lang_new_SubmitConceptCategories;?> </button> 
    
    
    <button <?php if($AnyCategoryRows['catordering_up']=='1'){?>class="tablinks"<?php }?> onclick="openCity(event, 'DynamicCallConcepts')" id="defaultOpen"><?php echo $lang_new_UpdateOrdering;?> </button>

<button <?php if($AnyCategoryRows['questions_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=DynamicCallConceptsQns&id=<?php echo $id;?>&action=update'"><?php echo $lang_new_AddQuestionsCategories;?> </button>
<button <?php if($AnyCategoryRows['call_up']=='1'){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitCallforConceptNew&id=<?php echo $id;?>&action=update'"><?php echo $lang_new_FInishSubmitCOncept;?></button>
<?php }?>

</div>

<div id="DynamicCallConcepts" class="tabcontent ">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>

   
  <h3><?php echo $lang_new_ConceptCallsCategories;?></h3>
<?php if($message){?><div style="color:#F00; font-size:18px;"><?php echo $message;?></div><?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">

 
 <div class="container success"><!--begin-->
 
 <label for="fname"><?php echo $lang_new_PleaseChooseCategories;?> (<span class="error">*</span>)</label>
  
  
   <div class="row success">
   
  
  <?php
	if($id and !$_POST['doSaveData'] and $sessionusrm_id){
$sqlProjectIDDel="SELECT * FROM ".$prefix."grantcall_categories where grantID='$id' order by categoryID desc";
$QueryProjectIDDel = $mysqli->query($sqlProjectIDDel);
$rUserProjectIDDel=$QueryProjectIDDel->fetch_array();

if($QueryProjectIDDel->num_rows){
	$newcatid=$rUserProjectIDDel['categoryID'];
	$newmaincatid=$rUserProjectIDDel['categoryName'];
	
	//$sqlA2Protocol2="delete from ".$prefix."grantcall_categories where categoryID='$newcatid' and catadmin_id='$sessionusrm_id'";
	//$mysqli->query($sqlA2Protocol2);
	///Dont delete main categories
	
	$sqlProjectIDDelMain="SELECT * FROM ".$prefix."dynamic_categories_main where category_id='$newmaincatid' and catadminstatus='dynamic' order by category_id desc limit 0,1";
$QueryProjectIDDelMain = $mysqli->query($sqlProjectIDDelMain);
	if($QueryProjectIDDelMain->num_rows){
	//$sqlA2Protocol22="delete from ".$prefix."dynamic_categories_main where category_id='$newmaincatid' and catadmin_id='$sessionusrm_id' and catadminstatus='dynamic'";
	//$mysqli->query($sqlA2Protocol22);
	}
	
	$message='<p class="error2">Dear '.$session_fullname.', category has been removed from your list.</p>';	
}
	}
	
$sqlProjectID2="SELECT * FROM ".$prefix."grantcall_categories where `grantID`='$id'  and categorym='concept' and catadmin_id='$sessionusrm_id' order by categoryID desc";
$QueryProjectID2 = $mysqli->query($sqlProjectID2);
if($QueryProjectID2->num_rows){?>
  <table width="100%" border="0">
 <tr>
   <th>&nbsp;</th>
    <th>Category</th>
    <th>Category No (Arrange Categories)</th>
    </tr>


        
        <?php 
while($rUserProjectID3=$QueryProjectID2->fetch_array()){
	$categoryName=$rUserProjectID3['categoryName'];

	/* category_name*/
$sqlProjectID3="SELECT * FROM ".$prefix."dynamic_categories_main where  category_id='$categoryName' order by category_rank asc";
//
$QueryProjectID3 = $mysqli->query($sqlProjectID3);
$rUserProjectID2=$QueryProjectID3->fetch_array();

?>
  <tr>
  <td width="7%" style="border-bottom:2px solid #4CAF50; border-right:2px solid #4CAF50;">
  <?php if($categoryName==1){?>
  <input name="finalCategoryID[]" type="checkbox" value="<?php echo $rUserProjectID3['categoryID'];?>" checked="checked"/>
  <?php }?>
  
  <?php if($categoryName!=1){?>
  <input name="finalCategoryID[]" type="checkbox" value="<?php echo $rUserProjectID3['categoryID'];?>" <?php if($rUserProjectID3['categoryName']==$rUserProjectID2['category_id']){?>checked="checked"<?php }?>/>
  <?php }?>
  
  
   </td>
  
    <td width="47%" style="border-bottom:2px solid #4CAF50; border-right:2px solid #4CAF50;"><?php echo $rUserProjectID2['category_name']; ?></td>
    
    
    <td width="28%" align="center" style="border-bottom:2px solid #4CAF50; border-right:2px solid #4CAF50;">
      
 <?php if($categoryName==1){?><input name="category_number[]" type="text" style="height:30px; width:100px;" value="<?php if(!$rUserProjectID3['category_number']){echo "1";}else{echo $rUserProjectID3['category_number'];}?>" readonly="readonly"/><?php }?>
  
       <?php if($categoryName!=1){?><input name="category_number[]" type="text" style="height:30px; width:100px;" value="<?php echo $rUserProjectID3['category_number'];?>"/><?php }?>
      
    </td>
    </tr>


        <?php }?>

    
 <?php }?>
 
</table>

<div style="clear:both; padding-bottom:20px;"></div>
<?php
if($AnyCategorySavedG){?><input type="submit" name="doNextPage" value="Proceed to Next Page" style="margin-left:20px; background:#F93;"><?php }?>

   <input type="submit" name="doSaveUpdate" value="Update Categories">
    
  </div>
</div><!--End-->


</form>


<div style="clear:both;"></div>
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