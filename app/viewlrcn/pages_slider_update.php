<?php
	//doSaveFive
	$action=$mysqli->real_escape_string($_GET['action']);
if($_POST['doAddSiteConfiguration']){
	
	function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
	define ("MAX_SIZE","400");

 $errors=0;

$image =$_FILES["photo"]["name"];
 $uploadedfile = $_FILES['photo']['tmp_name'];

  if ($image) 
  {
  $filename = stripslashes($_FILES['photo']['name']);
  $extension = getExtension($filename);
  $extension = strtolower($extension);
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
  {
echo ' Unknown Image extension ';
$errors=1;
  }
 else
{
  $size=filesize($_FILES['photo']['tmp_name']);
 
if ($size > MAX_SIZE*1024)
{
$sizelimit='<li class="red"><span class="ico"></span><strong class="system_title">If not uploaded, check Image size, resize to 500px width</strong></li>';
 $errors=1;
}
 
if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['photo']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
$uploadedfile = $_FILES['photo']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}
 
list($width,$height)=getimagesize($uploadedfile);
//image
$newwidth=1440;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);


//$no=rand(1000,0000);
$newname="uncstslide_".preg_replace('/\s+/', '_', $image);

$filename ='../images/banner/'. $newname;
$filename2 ='../images/banner/'. $newname;

imagejpeg($tmp,$filename,100);
imagejpeg($tmp,$filename2,100);

imagedestroy($src);
imagedestroy($tmp);


}
}

$rank=$mysqli->real_escape_string($_POST['rank']);
$txt_1=$mysqli->real_escape_string($_POST['txt_1']);
$txt_2=$mysqli->real_escape_string($_POST['txt_2']);
$txt_3=$mysqli->real_escape_string($_POST['txt_3']);

if($_FILES["photo"]["name"]){
$sqlA2="update ".$prefix."slider set `txt_1`='$txt_1',`txt_2`='$txt_2',`txt_3`='$txt_3',`image`='$newname' where id='$id'";
$mysqli->query($sqlA2);
}
if(!$_FILES["photo"]["name"]){
$sqlA2="update ".$prefix."slider set `txt_1`='$txt_1',`txt_2`='$txt_2',`txt_3`='$txt_3' where id='$id'";
$mysqli->query($sqlA2);
}

 $message="<span class=error2>$lang_details_saved.</span>"; 
}
if($category=="SliderDelete" and $id){
	
	$sqlA2="delete from ".$prefix."slider where id='$id'";
$mysqli->query($sqlA2);
	$message="<span class=error2>$lang_Delete.</span>"; 
}
if( $message){echo  $message;}
	?>
 
 <h4 class="niceheaders"><?php echo $lang_Slider;?> </h4><hr />
 
 <button id="myBtn"><?php echo $lang_AddSlider;?> </button> 

<div style="clear:both;"></div>
<form action="" method="post" name="regForm2" id="regForm2" autocomplete="off"  enctype="multipart/form-data">
 
 <?php 
$sql = "select *  FROM ".$prefix."slider where id='$id' order by rank asc";//and conceptm_status='new' 
$result = $mysqli->query($sql);

		  ?>
 <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table width="100%" class="table table-mailbox">
                                   
                                                
                                                    <tr class="unread">
                                                      <th width="268" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                      <th width="206" class="name"><strong><?php echo $lang_Details;?></strong></th>
                                                      <th width="100" class="time">&nbsp;</th>
                                                        <th width="100" class="time"></th>
                                                    </tr>
                                               
<?php 
$rFLists2=$result->fetch_array();
?>
                                                    <tr>
                                                      <td class="small-col"><?php echo $rFLists2['txt_1'];?>
                                                      
                                                      </td>
                                                      <td class="name">
													  <?php echo $rFLists2['txt_2'];?><br />
                                                      <?php echo $rFLists2['txt_3'];?>
                                                      </td>
                                                      <td class="time"><?php if($rFLists2['image']){?><img src="../images/banner/<?php echo $rFLists2['image'];?>" style="width:200px; overflow:hidden;" /><?php }?></td>
                                                        <td class="time">
                                                        
                           <a href="./main.php?option=UpdateSlider&id=<?php echo $rFLists2['id'];?>"><?php echo $lang_ClicktoUpdateSubmission;?></a><br /><br />
                           <a href="./main.php?option=SliderDelete&id=<?php echo $rFLists2['id'];?>" onclick="return confirm('<?php echo $lang_AreyousureDelete;?>');" style="color:#F00;"><?php echo $lang_RemoveSubmission;?></a>
                           
                           
                           </td>
                                                    </tr>

                                  
                                                   

                                                </table>
</div><!-- /.table-responsive -->
</form>



 <form action="" method="post" name="regForm" id="regForm" enctype="multipart/form-data">

 <div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_Title;?><span class="error">*</span></label>
<div class="col-sm-7">
<textarea name="txt_1" cols="" rows="" class="form-control  required"><?php echo $rFLists2['txt_1'];?></textarea>


</div>
</div> 

 <div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_Details;?><span class="error">*</span></label>
<div class="col-sm-7">
<textarea name="txt_2" cols="" rows="" class="form-control  required"><?php echo $rFLists2['txt_2'];?></textarea>


</div>
</div>

 <div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_Rank;?><span class="error">*</span></label>
<div class="col-sm-7">
<input name="rank" type="text"  class="form-control  required" value="<?php echo $rFLists2['rank'];?>"/>


</div>
</div>  
 

<div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_UploadImage;?></label>
<div class="col-sm-7">
<?php if($rFLists2['image']){?><img src="../images/banner/<?php echo $rFLists2['image'];?>" /><?php }?>
<input type="file" name="photo" tabindex="9" id="file2"/>

</div>
</div> 

      
       <div class="form-group row">
                          <div class="col-sm-4 offset-sm-3">
                    <input name="doAddSiteConfiguration" type="submit"  class="btn btn-primary" value="<?php echo $lang_new_Save;?>"/>

                          </div>
                        </div>
                                          
     </form>                   
  >
    
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