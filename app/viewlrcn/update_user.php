<?php
$sql = "select * from ".$prefix."musers  where usrm_id='$id'";
$result = $mysqli->query($sql);
$sq = $result->fetch_array();

?> 
	<?php
if($_POST['doRegister']=='Update Details'){
	
	function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
define ("MAX_SIZE","400");
 $errors=0;
 
$image =str_replace(' ', '_', $_FILES["profilepic"]["name"]);
 $uploadedfile = $_FILES['profilepic']['tmp_name'];

  if ($image) 
  {
  $filename = stripslashes($_FILES['profilepic']['name']);
  $extension = getExtension($filename);
  $extension = strtolower($extension);
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
  {
echo ' Unknown Image extension ';
$errors=1;
  }
 else
{
   $size=filesize($_FILES['profilepic']['tmp_name']);
 
if ($size > MAX_SIZE*6024)
{
 echo "You have exceeded the size limit";
 $errors=1;
}
 
if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['profilepic']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
$uploadedfile = $_FILES['profilepic']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}
 
list($width,$height)=getimagesize($uploadedfile);
//image
$newwidth=160;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);

//thumbnail
$newwidth1=80;
$newheight1=($height/$width)*$newwidth1;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,

 $width,$height);

imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1, 

$width,$height);

//$no=rand(1000,0000);
$hp="grants_";
$newname=$hp.$image;

$filename = "files/photos/". $newname;
$filename1 = "files/photos/thumb_". $newname;

imagejpeg($tmp,$filename,100);
imagejpeg($tmp1,$filename1,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);


}
}

$username=$mysqli->real_escape_string($_POST['username']);
	$fname=$mysqli->real_escape_string($_POST['fname']);
	$sname=$mysqli->real_escape_string($_POST['sname']);
	$Nationality=$mysqli->real_escape_string($_POST['Nationality']);
	$phone=$mysqli->real_escape_string($_POST['phone']);
	$email=$mysqli->real_escape_string($_POST['email']);
	$Gender=$mysqli->real_escape_string($_POST['Gender']);
	$Qualifications=$mysqli->real_escape_string($_POST['Qualifications']);

	$Institution=$mysqli->real_escape_string($_POST['Institution']);
	$usrm_usrtype=$mysqli->real_escape_string($_POST['usrm_usrtype']);
	
	$ipaddress=$_SERVER['REMOTE_ADDR'];
	$md5pass=md5($mysqli->real_escape_string($_POST['pwd']));
	$NotPassword=$mysqli->real_escape_string($_POST['pwd']);

$date=$mysqli->real_escape_string($_POST['date']);
	$month=$mysqli->real_escape_string($_POST['month']);
	$yearm=$mysqli->real_escape_string($_POST['yearm']);
	$dob=($yearm.'-'.$month.'-'.$date);
	
	foreach($_POST['category'] as $categories) {
   $categoryID .= $categories.',';
    }
		
if($_FILES["profilepic"]["name"] and $_POST['pwd']){
$sqlA1="update ".$prefix."musers set `usrm_NameofInstitution`='$Institution',`usrm_fname`='$fname',`usrm_sname`='$sname',`usrm_Nationality`='$Nationality',`usrm_password`='$md5pass',`usrm_phone`='$phone',`usrm_profilepic`='$newname',`usrm_gender`='$Gender',`usrm_Qualification`='$Qualifications',`usrm_dob`='$dob',`usrm_usrtype`='$usrm_usrtype',`categoryID`='$categoryID',`usrm_approved`='1' where usrm_id='$id'";
$mysqli->query($sqlA1);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
}

if($_FILES["profilepic"]["name"] and !$_POST['pwd']){
$sqlA2="update ".$prefix."musers set `usrm_NameofInstitution`='$Institution',`usrm_fname`='$fname',`usrm_sname`='$sname',`usrm_Nationality`='$Nationality',`usrm_phone`='$phone',`usrm_profilepic`='$newname',`usrm_gender`='$Gender',`usrm_Qualification`='$Qualifications',`usrm_dob`='$dob',`usrm_usrtype`='$usrm_usrtype',`categoryID`='$categoryID',`usrm_approved`='1' where usrm_id='$id'";
$mysqli->query($sqlA2);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
}


if(!$_FILES["profilepic"]["name"] and $_POST['pwd']){
$sqlA3="update ".$prefix."musers set `usrm_NameofInstitution`='$Institution',`usrm_fname`='$fname',`usrm_sname`='$sname',`usrm_Nationality`='$Nationality',`usrm_password`='$md5pass',`usrm_phone`='$phone',`usrm_gender`='$Gender',`usrm_Qualification`='$Qualifications',`usrm_dob`='$dob',`usrm_usrtype`='$usrm_usrtype',`categoryID`='$categoryID' where usrm_id='$id'";
$mysqli->query($sqlA3);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
}


if(!$_FILES["profilepic"]["name"] and !$_POST['pwd']){
$sqlA4="update ".$prefix."musers set `usrm_NameofInstitution`='$Institution',`usrm_fname`='$fname',`usrm_sname`='$sname',`usrm_Nationality`='$Nationality',`usrm_phone`='$phone',`usrm_gender`='$Gender',`usrm_Qualification`='$Qualifications',`usrm_dob`='$dob',`usrm_usrtype`='$usrm_usrtype',`categoryID`='$categoryID' where usrm_id='$id'";
$mysqli->query($sqlA4);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
}



	$sqlA = "INSERT INTO ".$prefix."mlogs (log_details, logname, logemail,logdate) VALUES('$session_fullname has updated his account details', '".$_SESSION['mmfullname']."', '',now())";
$mysqli->query($sqlA);	
$message='<p class="success">Dear '.$session_fullname.', '.$firstName.' account details have been successfully updated. Thank you';

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=Users'>";
		
}

$sqlUsers="SELECT * FROM ".$prefix."musers  where usrm_id='$id'";
$QueryUsers = $mysqli->query($sqlUsers);
$sqUser = $QueryUsers->fetch_array();

$categoryChunks = explode("-", $sqUser['usrm_dob']);
$chop1="$categoryChunks[0]";
$chop2="$categoryChunks[1]";
$chop3="$categoryChunks[2]";

$categoryChunksb = explode(",", $sqUser['categoryID']);
$choper1="$categoryChunksb[0]";
$choper2="$categoryChunksb[1]";
$choper3="$categoryChunksb[2]";
$choper4="$categoryChunksb[3]";
$choper5="$categoryChunksb[4]";
$choper6="$categoryChunksb[5]";
$choper7="$categoryChunksb[6]";
$choper8="$categoryChunksb[7]";
$choper9="$categoryChunksb[8]";
$choper10="$categoryChunksb[9]";
$choper11="$categoryChunksb[10]";
$choper12="$categoryChunksb[11]";
$choper13="$categoryChunksb[12]";
$choper14="$categoryChunksb[13]";
$choper15="$categoryChunksb[14]";
?>

  <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){?> 
<form action="./main.php?option=upusers&id=<?php echo $id;?>" method="post" name="regForm" id="regForm" enctype="multipart/form-data">
<?php echo $message;?>
<div class="box-header"><h3 class="box-title">Update User</h3></div><!-- /.box-header -->
        
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->  
                            <div class="box box-primary">
                        
                              
                                    <div class="box-body">
                                    
                                <div class="form-group">
                                  <label class="control-label" for="inputSuccess">First Name <font color="#CC0000">*</font></label>
                                  <input type="text" class="form-control required" name="fname"  value="<?php echo $sq['usrm_fname'];?>" id="fname"/>
                                  </div>
                                  
                                  <div class="form-group">
                                  <label class="control-label" for="inputSuccess">Last Name <font color="#CC0000">*</font></label>
                                  <input type="text" class="form-control required" name="sname"  value="<?php echo $sq['usrm_sname'];?>" id="sname"/>
                                  </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address <font color="#CC0000">*</font></label>
                                            <input type="email" class="form-control required email" name="email" id="exampleInputEmail1" value="<?php echo $sq['usrm_email'];?>" readonly="readonly">
                                            
                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Username <font color="#CC0000">*</font></label>
                                            <input type="text" class="form-control required email" name="usrm_usernamemm" id="exampleInputEmail1" value="<?php echo $sq['usrm_username'];?>" readonly="readonly">
                                            
                                            
                                        </div>
                          
                                                                           
                                        
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password <font color="#CC0000">*</font></label>
                                           <input type="password" class="form-control" name="pwd" minlength="5" id="pwd" value="" autocomplete="off">
                                        </div>
                                  
                                         <div class="form-group">
                                            <label for="exampleInputPassword1">Re-type Password <font color="#CC0000">*</font></label>
                                            
                                          
                                            
                                            
                                            <input type="password" class="form-control" name="pwd2" id="pwd2" minlength="5"   equalto="#pwd" autocomplete="off">
                                        </div>
                                        
                                        
                                        
                                        
                                       <div class="form-group">
                                            <label for="exampleInputPassword1">User Role <font color="#CC0000">*</font></label>

 <select name="usrm_usrtype" id="usrm_usrtype" class="required form-control" tabindex="6">
    <option value="">&nbsp; Please Select</option>


<option value="user" <?php if($sqUser['usrm_usrtype']=='user'){?>selected="selected"<?php }?>>&nbsp;User</option>
<option value="admin" <?php if($sqUser['usrm_usrtype']=='admin'){?>selected="selected"<?php }?>>&nbsp;Admin</option>
<option value="superadmin" <?php if($sqUser['usrm_usrtype']=='superadmin'){?>selected="selected"<?php }?>>&nbsp;Superadmin</option>
<option value="reviewer" <?php if($sqUser['usrm_usrtype']=='reviewer'){?>selected="selected"<?php }?>>&nbsp;Reviewer</option>
  </select>

                                        </div> 
                                        
                                        
                                        
                                    </div><!-- /.box-body -->

                         
                           
                            </div><!-- /.box -->

                            <!-- Form Element sizes -->
                   

                        </div><!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                          
                                <div class="box-body">

                                        <!-- text input -->
                                  
                                        <div class="form-group">
                                            <label for="exampleInputPassword1"><?php echo $lang_institution_of_affiliation;?> (In Full) <font color="#CC0000">*</font></label>
                                           <input type="text" class="form-control required" name="Institution" id="Institution" value="<?php echo $sq['usrm_NameofInstitution'];?>">
                                           
                                           
                                        </div> 
                                     <div class="form-group">
    <label class="control-label" for="inputSuccess">Gender <font color="#CC0000">*</font></label>
    <input name="Gender" type="radio" value="Male" tabindex="14" id="Gender" <?php if($sq['usrm_gender']=='Male'){?>checked="checked"<?php }?>/> Male&nbsp;
      <input name="Gender" type="radio" value="Female"  tabindex="15" id="Gender" <?php if($sq['usrm_gender']=='Female'){?>checked="checked"<?php }?>/> Female
    </div>
    
    <div class="form-group">
                                            <label class="control-label" for="inputSuccess">Phone <font color="#CC0000">*</font></label>
                                            <input type="text" class="form-control required" name="phone"  value="<?php echo $sq['usrm_phone'];?>"/>
    </div>
    
    <div class="form-group">
    <label class="control-label" for="inputSuccess">Qualifications <font color="#CC0000">*</font></label>
    
    <select name="Qualifications" id="Qualifications" class="required form-control" tabindex="6" onChange="getQualification(this.value)">
        <option value="">&nbsp; Please Select</option>
        <option value="Diploma" <?php if($sq['usrm_Qualification']=='Diploma'){?>selected="selected"<?php }?>>&nbsp;Diploma</option>
        <option value="Bachelor's Degree" <?php if($sq['usrm_Qualification']=="Bachelor's Degree"){?>selected="selected"<?php }?>>&nbsp;Bachelor's Degree</option>
        <option value="Master's Degree" <?php if($sq['usrm_Qualification']=="Master's Degree"){?>selected="selected"<?php }?>>&nbsp;Master's Degree</option>
        <option value="PHD" <?php if($sq['usrm_Qualification']=='PHD'){?>selected="selected"<?php }?>>&nbsp;PHD</option>
        <option value="Post-Doctoral" <?php if($sq['usrm_Qualification']=='Post-Doctoral'){?>selected="selected"<?php }?>>&nbsp;Post-Doctoral </option>
        <option value="Other" <?php if($sq['usrm_Qualification']=='Other'){?>selected="selected"<?php }?>>&nbsp;Other</option>
      </select>
    </div>
    
    <div class="form-group">
                                            <label for="exampleInputPassword1">Nationality <font color="#CC0000">*</font></label>
                                      <select name="Nationality" id="Nationality" class="required form-control" tabindex="6">
    <option value="">&nbsp; Please Select</option>
    <?php
$sqlUser = "SELECT * FROM ".$prefix."countries order by cidm_country_name asc";
$queryUser = $mysqli->query($sqlUser);
while($r = $queryUser->fetch_array()){?>
    <option value="<?php echo $r['cidm_country_id'];?>"  <?php if($sq['usrm_Nationality']==$r['cidm_country_id']){?>selected="selected"<?php }?>>&nbsp;<?php echo $r['cidm_country_name'];?></option>
    <?php }?>
  </select>
                                        </div>
                                        
                                        
   <?php if($sqUser['usrm_usrtype']=='reviewer'){?>                                     
      <div class="form-group">
 <label for="exampleInputPassword1">Assign Categories <font color="#CC0000">*</font></label><br />
<?php
$sqlCategory = "SELECT * FROM ".$prefix."categories order by rstug_categoryName asc";
$queryCategory = $mysqli->query($sqlCategory);
while($rCategory = $queryCategory->fetch_array()){
?>
<input name="category[]" type="checkbox" value="<?php echo $rCategory['rstug_categoryID'];?>" <?php if($rCategory['rstug_categoryID']==$choper1 || $rCategory['rstug_categoryID']==$choper2 || $rCategory['rstug_categoryID']==$choper3 || $rCategory['rstug_categoryID']==$choper4 || $rCategory['rstug_categoryID']==$choper5 || $rCategory['rstug_categoryID']==$choper6 || $rCategory['rstug_categoryID']==$choper7 || $rCategory['rstug_categoryID']==$choper8 || $rCategory['rstug_categoryID']==$choper9 || $rCategory['rstug_categoryID']==$choper10 || $rCategory['rstug_categoryID']==$choper11 || $rCategory['rstug_categoryID']==$choper12 || $rCategory['rstug_categoryID']==$choper13 || $rCategory['rstug_categoryID']==$choper14 || $rCategory['rstug_categoryID']==$choper15){?>checked="checked"<?php }?>/>&nbsp;<?php echo $rCategory['rstug_categoryName'];?><br />
<?php }?>
</div>                                   
  <?php }?>                                      
                                        
                                         <div class="form-group">
                                           <?php if($sq['usrm_profilepic']){?><img src="files/photos/thumb_<?php echo $sq['usrm_profilepic'];?> "  style="border:1px solid #CCC; padding:2px;"/><?php }?><br /> <b>Upload profile picture</b>                                        
<input name="profilepic" type="file" />
                                        </div>
                                        
                                    
        
        
   
        
        
        
        
        
        
        
        
                                    <input name="doRegister" type="submit" class="btn btn-info btn-flat" value="Update Details"/>&nbsp;&nbsp;&nbsp;<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=Users'"/>
                              
<p>&nbsp;</p>
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
      
                <?php }else{?><p class="error">You dont have permissions to access this page, please contact administrator for details</p><?php }?>  
                 </form>                      