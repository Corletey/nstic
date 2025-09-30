 <?php
 $sql = "select * FROM ".$prefix."grantcalls where grantID='$id'";
$result = $mysqli->query($sql);
$total_pages = $result->num_rows;
$rFLists2=$result->fetch_array();
?><!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                           <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Register Users</li>
                    </ol>
                </section>

<section class="content">

<?php CheckSubmittedCVS();?>

<?php
$path = $_FILES['attachment']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);


if($_POST['doUploadProposal']=='Save' and $_POST['title'])
{
	
		function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
define ("MAX_SIZE","400");
 $errors=0;

$image =$_FILES["image"]["name"];
 $uploadedfile = $_FILES['image']['tmp_name'];

  if ($image) 
  {
  $filename = stripslashes($_FILES['image']['name']);
  $extension = getExtension($filename);
  $extension = strtolower($extension);
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
  {
echo ' Unknown Image extension ';
$errors=1;
  }
 else
{
   $size=filesize($_FILES['image']['tmp_name']);
 
if ($size > MAX_SIZE*6024)
{
 echo "You have exceeded the size limit";
 $errors=1;
}
 
if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['image']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
$uploadedfile = $_FILES['image']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}
 
list($width,$height)=getimagesize($uploadedfile);
//image
$newwidth=600;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);

//thumbnail
$newwidth1=280;
$newheight1=($height/$width)*$newwidth1;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,

 $width,$height);

imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1, 

$width,$height);

//$no=rand(1000,0000);
$hp="uncst_";
$newname=$hp.$image;

$filename = "../uploads/". $newname;
$filename1 = "../uploads/th". $newname;

imagejpeg($tmp,$filename,100);
imagejpeg($tmp1,$filename1,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);


}
}

	$user_ip = $_SERVER['REMOTE_ADDR'];
	
	$title=$mysqli->real_escape_string($_POST['title']);
	$summary=$mysqli->real_escape_string($_POST['summary']);
	$details=$mysqli->real_escape_string($_POST['details']);
	$startDate=$mysqli->real_escape_string($_POST['startDate']);
	$EndDate=$mysqli->real_escape_string($_POST['EndDate']);
	$applicationProcedure=$mysqli->real_escape_string($_POST['applicationProcedure']);

  
  $document = $usrm_id."_".$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachment']['name']));
  
if($_FILES['attachment']['name']){
$targetw = "files/". basename($usrm_id."_".preg_replace('/\s+/', '_', $_FILES['attachment']['name']));
$studytoolsext_main = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachment']['tmp_name']), $targetw);
$extension_txtm = getExtension($filed_main);
$extension_txtm = strtolower($filed_main);

$query3="update ".$prefix."grantcalls set `attachment`='$document' where grantID='$id'";
$mysqli->query($query3);
}

if($_FILES["image"]["name"]){

$query33="update ".$prefix."grantcalls set `image`='$newname' where grantID='$id'";
$mysqli->query($query33);
}
//}


$query="update ".$prefix."grantcalls set `title`='$title',`summary`='$summary',`details`='$details',`startDate`='$startDate',`EndDate`='$EndDate',`applicationProcedure`='$applicationProcedure',`dateupdated`=now() where grantID='$id'";
$mysqli->query($query);
$record_id = $mysqli->insert_id;

//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`,`proposal_id`) 
values('$nameofpi has updated call for proposal titled $title .','$nameofpi','$email','$user_ip',now(),'$record_id')";
$mysqli->query($queryLog);	
///send email


if($record_id>=1){
echo '<img src="img/ajax-loader1.gif">';
echo '<div class="spacer"></div>';
echo '<meta http-equiv="refresh" content="5; url='.$base_url.'admin/main.php?option=dashboard" />';
/*echo("<script>location.href = './main.php?option=dashboard/';</script>");*/

$message="<p style='color:#09F!important;'>Your call for proposal was Updated Successfully</p>";
}

if($record_id<=0){
$message="<p style='color:#09F!important;'>Your call for proposal was NOT updated please try again later.</p>";	
}



}

?>

<?php if($message){?><?php echo $message;?><?php }?>
<?php if($messagepdf){?><?php echo $messagepdf;?><?php }?>

<form action="" method="post"  enctype="multipart/form-data" name="regForm" id="regForm" >


                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->  
                            <div class="box box-primary">
                                <div class="box-header" style="border-bottom:1px solid #ccc;">
                                    <h3 class="box-title">Submit Call for Proposals</h3>
                                    
                                    
                                    
                                    
                                
                                </div><!-- /.box-header -->
                                <!-- form start -->
<div class="box-body">
<table width="100%" border="0">

      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>

             <tr>
    <td width="20%" valign="top">Call Title <span class="error">*</span></td>
    <td width="80%" class="sepr">
    <textarea name="title" id="title" cols="" rows="2" class="form-control required"  minlength="8" tabindex="3"><?php echo $rFLists2['title'];?></textarea>
     </td>
    </tr>
     
           <tr>
    <td width="20%" valign="top">Summary <span class="error">*</span></td>
    <td width="80%" class="sepr">
    <textarea name="summary" id="summary" cols="" rows="6" class="form-control required"  minlength="8" tabindex="3"><?php echo $rFLists2['summary'];?></textarea>
     </td>
    </tr>     
             
       <tr>
    <td width="20%" valign="top">Details <span class="error">*</span></td>
    <td width="80%" class="sepr">
    <textarea name="details" id="details" cols="" rows="8" class="form-control required"  minlength="8" tabindex="3"><?php echo $rFLists2['details'];?></textarea>
     </td>
    </tr> 
    
    
      <tr>
    <td width="20%" valign="top">Attachment <span class="error">*</span></td>
    <td width="80%" class="sepr">
    <input type="file" name="attachment" id="attachment"/>  <strong>(pdf) </strong>
    
    <?php if($rFLists2['attachment']){?><a href="../uploads/<?php echo $rFLists2['attachment'];?>" target="_blank">Attachment</a><?php }?>
     </td>
    </tr>
    
     <tr>
    <td width="20%" valign="top">Image <span class="error">*</span></td>
    <td width="80%" class="sepr">
    <input type="file" name="image" id="image"/>
    <?php if($rFLists2['image']){?><img src="../uploads/<?php echo $rFLists2['image'];?>" /><?php }?>

     </td>
    </tr>
    
   <tr>
    <td width="20%" valign="top">Start Date <span class="error">*</span></td>
    <td width="80%" class="sepr">
<input name="startDate" type="date" id="startDate"  class="required" value="<?php echo $rFLists2['startDate'];?>"/>

     </td>
    </tr>
 <tr>
    <td width="20%" valign="top">End Date <span class="error">*</span></td>
    <td width="80%" class="sepr">
 <input name="EndDate" type="date" id="EndDate"  class="required" value="<?php echo $rFLists2['EndDate'];?>"/>
     </td>
    </tr>
        
       <tr>
    <td width="20%" valign="top">Application Procedure <span class="error">*</span></td>
    <td width="80%" class="sepr">
    <textarea name="applicationProcedure" id="applicationProcedure" cols="" rows="6" class="form-control required"  minlength="8" tabindex="3"><?php echo $rFLists2['applicationProcedure'];?></textarea>
     </td>
    </tr> 
    
<tr>
               <td>&nbsp;</td>
               <td><input name="doUploadProposal" type="submit" value="Save" class="btn btn-info btn-flat"/></td>
             </tr>
</table>


</div>
 
                           
                            </div><!-- /.box -->

                          </div>

             
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
 
                 </form>
     
                 </section> 
