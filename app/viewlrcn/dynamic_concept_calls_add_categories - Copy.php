<?php
if($_POST['doSaveData']=='Save' and $_POST['category_number'] and $_POST['category']){

	
$category=$mysqli->real_escape_string($_POST['category']);
$category_number=$mysqli->real_escape_string($_POST['category_number']);
$sqlUsers="SELECT * FROM ".$prefix."grantcall_categories where `categoryName`='$category' and `status`='new'  and categorym='concept' order by categoryID desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows){
$sqlA2="insert into ".$prefix."grantcall_categories (`categoryName`,`categorym`,`date_added`,`status`,`category_number`) 

values('$category','concept',now(),'new','$category_number')";
$mysqli->query($sqlA2);	
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another category.</p>';	
}

if($QueryUsers->num_rows){
$message='<p class="error2">Dear '.$session_fullname.', details were already submitted, please add another category.</p>';		
}
	
}

//Get the last category
$sqlLastQn="SELECT * FROM ".$prefix."grantcall_categories where `status`='new' order by categoryID desc limit 0,1";
$QueryLastQn = $mysqli->query($sqlLastQn);
$rUserLastQn=$QueryLastQn->fetch_array();
?><div class="tab">

    <button class="tablinks"  onclick="openCity(event, 'DynamicCallConcepts')" id="defaultOpen"><?php echo $lang_new_SubmitConceptCategories;?> </button>

<button onClick="window.location.href='./main.php?option=DynamicCallConceptsQns&id=<?php echo $id;?>'"><?php echo $lang_new_AddQuestionsCategories;?> </button>
<button onClick="window.location.href='./main.php?option=SubmitCallforConceptNew'">Submit Call for Concept</button>


</div>

<div id="DynamicCallConcepts" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>

   
  <h3>Dynamic Concept Calls Categories</h3>
<?php if($message){?><div style="color:#F00; font-size:18px;"><?php echo $message;?></div><?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">

 
 <div class="container"><!--begin-->
 
 <label for="fname">Please add categories for this new call concept. (<span class="error">*</span>)</label>
  
  <div class="row success">

    <div class="col-100">
    <table width="100%" border="0">
  <tr>
    <td width="67%"><label for="fname">Category/Theme <span class="error">*</span></label>
      <input type="text" id="MyTextBox3mmmm" name="category" placeholder="Category/Theme.." value="<?php echo $rUserInv2['categoryName'];?>" required onKeyUp="showUser(this.value)">
      
      
      <div id="txtHint"></div>
      </td>
    <td width="6%">&nbsp;</td>
    <td width="27%"> <label for="fname">Category/Theme Number <span class="error">*</span></label>   
    <input type="text" id="MyTextBox3mmmm2" name="category_number" placeholder="" value="<?php echo ($rUserLastQn['category_number']+1);?>" required >
    </td>
  </tr>
</table>

      
    </div>
    
    
    
  </div>
  
   <div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
  
  <?php
$sqlProjectID2="SELECT * FROM ".$prefix."grantcall_categories where `status`='new'  and categorym='concept' order by categoryID desc";
$QueryProjectID2 = $mysqli->query($sqlProjectID2);
if($QueryProjectID2->num_rows){?>
  
  <div class="row">
  <table width="100%" border="0" id="customers2">
        <tr>
            <th>Below are category you have added for the new call</th>
            <th>&nbsp;</th>
        </tr>

        
        <?php 
while($rUserProjectID2=$QueryProjectID2->fetch_array()){
?>
        <tr>
            <td><?php echo $rUserProjectID2['categoryName'];?></td>
                <td>&nbsp;</td>
        </tr>
        <?php }?>
        
    </table>
    
    </div><?php }?>

 
  
</div><!--End-->


</form>







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