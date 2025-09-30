<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$sql = "select * from ".$prefix."musers  where usrm_id='$sessionusrm_id'";
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

$image =$_FILES["profilepic"]["name"];
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
$sqlA1="update ".$prefix."musers set `usrm_NameofInstitution`='$Institution',`usrm_fname`='$fname',`usrm_sname`='$sname',`usrm_Nationality`='$Nationality',`usrm_password`='$md5pass',`usrm_phone`='$phone',`usrm_profilepic`='$newname',`usrm_gender`='$Gender',`usrm_Qualification`='$Qualifications',`usrm_dob`='$dob',`categoryID`='$categoryID' where usrm_id='$sessionusrm_id'";
$mysqli->query($sqlA1);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
}

if($_FILES["profilepic"]["name"] and !$_POST['pwd']){
$sqlA2="update ".$prefix."musers set `usrm_NameofInstitution`='$Institution',`usrm_fname`='$fname',`usrm_sname`='$sname',`usrm_Nationality`='$Nationality',`usrm_phone`='$phone',`usrm_profilepic`='$newname',`usrm_gender`='$Gender',`usrm_Qualification`='$Qualifications',`usrm_dob`='$dob',`categoryID`='$categoryID' where usrm_id='$sessionusrm_id'";
$mysqli->query($sqlA2);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
}


if(!$_FILES["profilepic"]["name"] and $_POST['pwd']){
$sqlA3="update ".$prefix."musers set `usrm_NameofInstitution`='$Institution',`usrm_fname`='$fname',`usrm_sname`='$sname',`usrm_Nationality`='$Nationality',`usrm_password`='$md5pass',`usrm_phone`='$phone',`usrm_gender`='$Gender',`usrm_Qualification`='$Qualifications',`usrm_dob`='$dob',`categoryID`='$categoryID' where usrm_id='$sessionusrm_id'";
$mysqli->query($sqlA3);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
}


if(!$_FILES["profilepic"]["name"] and !$_POST['pwd']){
$sqlA4="update ".$prefix."musers set `usrm_NameofInstitution`='$Institution',`usrm_fname`='$fname',`usrm_sname`='$sname',`usrm_Nationality`='$Nationality',`usrm_phone`='$phone',`usrm_gender`='$Gender',`usrm_Qualification`='$Qualifications',`usrm_dob`='$dob',`categoryID`='$categoryID' where usrm_id='$sessionusrm_id'";
$mysqli->query($sqlA4);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
}



	$sqlA = "INSERT INTO ".$prefix."mlogs (log_details, logname, logemail,logdate) VALUES('$session_fullname has updated his account details', '".$_SESSION['mmfullname']."', '',now())";
$mysqli->query($sqlA);	
$message='<p class="success">Dear '.$session_fullname.', '.$firstName.' account details have been successfully updated. Thank you';


		
}

$sqlUsers="SELECT * FROM ".$prefix."musers  where usrm_id='$sessionusrm_id'";
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
?>

<form action="" method="post" name="regForm" id="regForm" enctype="multipart/form-data">
<?php echo $message;?>
<div class="box-header"><h3 class="box-title">My Account</h3></div><!-- /.box-header -->
        
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
                                            <label for="exampleInputEmail1">Date of Birth <font color="#CC0000">*</font></label><br>
                                            <select name="date" id="ddate" class="required mmm" tabindex="6">
      <option value="">Date</option>
      <option value="01" <?php if($chop3=='01'){?> selected="selected"<?php }?>>&nbsp;01</option>
      <option value="02" <?php if($chop3=='02'){?> selected="selected"<?php }?>>&nbsp;02</option>
      <option value="03" <?php if($chop3=='03'){?> selected="selected"<?php }?>>&nbsp;03</option>
      <option value="04" <?php if($chop3=='04'){?> selected="selected"<?php }?>>&nbsp;04</option>
      <option value="05" <?php if($chop3=='05'){?> selected="selected"<?php }?>>&nbsp;05</option>
      <option value="06" <?php if($chop3=='06'){?> selected="selected"<?php }?>>&nbsp;06</option>
      <option value="07" <?php if($chop3=='07'){?> selected="selected"<?php }?>>&nbsp;07</option>
      <option value="08" <?php if($chop3=='08'){?> selected="selected"<?php }?>>&nbsp;08</option>
      <option value="09" <?php if($chop3=='09'){?> selected="selected"<?php }?>>&nbsp;09</option>
      <option value="10" <?php if($chop3=='10'){?> selected="selected"<?php }?>>&nbsp;10</option>
      <option value="11" <?php if($chop3=='11'){?> selected="selected"<?php }?>>&nbsp;11</option>
      <option value="12" <?php if($chop3=='12'){?> selected="selected"<?php }?>>&nbsp;12</option>
      <option value="13" <?php if($chop3=='13'){?> selected="selected"<?php }?>>&nbsp;13</option>
      <option value="14" <?php if($chop3=='14'){?> selected="selected"<?php }?>>&nbsp;14</option>
      <option value="15" <?php if($chop3=='15'){?> selected="selected"<?php }?>>&nbsp;15</option>
      <option value="16" <?php if($chop3=='16'){?> selected="selected"<?php }?>>&nbsp;17</option>
      <option value="17" <?php if($chop3=='17'){?> selected="selected"<?php }?>>&nbsp;17</option>
      <option value="18" <?php if($chop3=='18'){?> selected="selected"<?php }?>>&nbsp;18</option>
      <option value="19" <?php if($chop3=='19'){?> selected="selected"<?php }?>>&nbsp;19</option>
      <option value="20" <?php if($chop3=='20'){?> selected="selected"<?php }?>>&nbsp;20</option>
      <option value="21" <?php if($chop3=='21'){?> selected="selected"<?php }?>>&nbsp;21</option>
      <option value="22" <?php if($chop3=='22'){?> selected="selected"<?php }?>>&nbsp;22</option>
      <option value="23" <?php if($chop3=='23'){?> selected="selected"<?php }?>>&nbsp;23</option>
      <option value="24" <?php if($chop3=='24'){?> selected="selected"<?php }?>>&nbsp;24</option>
      <option value="465" <?php if($chop3=='25'){?> selected="selected"<?php }?>>&nbsp;25</option>
      <option value="26" <?php if($chop3=='26'){?> selected="selected"<?php }?>>&nbsp;26</option>
      <option value="27" <?php if($chop3=='27'){?> selected="selected"<?php }?>>&nbsp;27</option>
      <option value="28" <?php if($chop3=='28'){?> selected="selected"<?php }?>>&nbsp;28</option>
      <option value="29" <?php if($chop3=='29'){?> selected="selected"<?php }?>>&nbsp;29</option>
      <option value="30" <?php if($chop3=='30'){?> selected="selected"<?php }?>>&nbsp;30</option>
      <option value="31" <?php if($chop3=='31'){?> selected="selected"<?php }?>>&nbsp;31</option>
    </select>
      <select name="month" id="dmonth" class="required mmm" tabindex="7">
        <option value="">&nbsp;Month</option>
      <option value="01" <?php if($chop2=='01'){?> selected="selected"<?php }?>>&nbsp;January</option>
        <option value="02" <?php if($chop2=='02'){?> selected="selected"<?php }?>>&nbsp;Feabruary</option>
        <option value="03" <?php if($chop2=='03'){?> selected="selected"<?php }?>>&nbsp;March</option>
        <option value="04" <?php if($chop2=='04'){?> selected="selected"<?php }?>>&nbsp;April</option>
        <option value="05" <?php if($chop2=='05'){?> selected="selected"<?php }?>>&nbsp;May</option>
        <option value="06" <?php if($chop2=='06'){?> selected="selected"<?php }?>>&nbsp;June</option>
        <option value="07" <?php if($chop2=='07'){?> selected="selected"<?php }?>>&nbsp;July</option>
        <option value="08" <?php if($chop2=='08'){?> selected="selected"<?php }?>>&nbsp;August</option>
        <option value="09" <?php if($chop2=='09'){?> selected="selected"<?php }?>>&nbsp;September</option>
        <option value="10" <?php if($chop2=='10'){?> selected="selected"<?php }?>>&nbsp;October</option>
        <option value="11" <?php if($chop2=='11'){?> selected="selected"<?php }?>>&nbsp;November</option>
        <option value="12" <?php if($chop2=='12'){?> selected="selected"<?php }?>>&nbsp;December</option>
      </select>
      <select name="yearm" id="dyear" class="required mmm" tabindex="8">
        <option value="">Year</option>
        <?php
define('DOB_YEAR_START', 1920);

$current_year = (date('Y')-17);

for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
        <option value="<?php echo $count;?>"  <?php if($chop1==$count){?> selected="selected"<?php }?>><?php echo $count;?></option>
        <?php }?>
      </select>
                                            
                                            
                                        </div>  
                                                                           
                                        
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password <font color="#CC0000">*</font></label>
                                           <input type="password" class="form-control" name="pwd" minlength="5" id="pwd" value="" autocomplete="off">
                                        </div>
                                  
                                         <div class="form-group">
                                            <label for="exampleInputPassword1">Re-type Password <font color="#CC0000">*</font></label>
                                            
                                          
                                            
                                            
                                            <input type="password" class="form-control" name="pwd2" id="pwd2" minlength="5"   equalto="#pwd" autocomplete="off">
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
<input name="category[]" type="checkbox" value="<?php echo $rCategory['rstug_categoryID'];?>" <?php if($rCategory['rstug_categoryID']==$choper1 || $rCategory['rstug_categoryID']==$choper2 || $rCategory['rstug_categoryID']==$choper3 || $rCategory['rstug_categoryID']==$choper4 || $rCategory['rstug_categoryID']==$choper5 || $rCategory['rstug_categoryID']==$choper6 || $rCategory['rstug_categoryID']==$choper7){?>checked="checked"<?php }?>/>&nbsp;<?php echo $rCategory['rstug_categoryName'];?><br />
<?php }?>
</div>                                   
  <?php }?>                                      
                                        
                                         <div class="form-group">
                                           <?php if($sq['usrm_profilepic']){?><img src="files/photos/thumb_<?php echo $sq['usrm_profilepic'];?> "  style="border:1px solid #CCC; padding:2px;"/><?php }?><br /> <b>Upload profile picture</b>                                        
<input name="profilepic" type="file" />
                                        </div>
                                        
                                    
        
        
   
        
        
        
        
        
        
        
        
                                    <input name="doRegister" type="submit" class="btn btn-info btn-flat" value="Update Details"/>&nbsp;&nbsp;&nbsp;               
<p>&nbsp;</p>
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
      
                 </form>                      