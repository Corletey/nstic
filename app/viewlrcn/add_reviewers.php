  <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){

if($_POST['doRegister']){
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

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

$filename = "./files/photos/". $newname;
$filename1 = "./files/photos/thumb_". $newname;

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
	$master2=md5($_POST['email']);///md5 email
	$Institution=$mysqli->real_escape_string($_POST['Institution']);
	$usrm_usrtype=$mysqli->real_escape_string($_POST['usrm_usrtype']);
	
	$date=$mysqli->real_escape_string($_POST['date']);
	$month=$mysqli->real_escape_string($_POST['month']);
	$yearm=$mysqli->real_escape_string($_POST['yearm']);
	$dob=($yearm.'-'.$month.'-'.$date);
	
	$ipaddress=$_SERVER['REMOTE_ADDR'];
	$md5pass=md5($mysqli->real_escape_string($_POST['pwd']));
	$NotPassword=$mysqli->real_escape_string($_POST['pwd']);
	
	$hostmain  = $_SERVER['HTTP_HOST'];
    $host_upper = strtoupper($host);
    $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	

	$length=25;
    $refNo = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	
	$sqlUsers="SELECT * FROM ".$prefix."musers where `usrm_email`='$email'";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		
		if($totalUsers){
		
			echo $message='<p class="error">Username <b>'.$username.'</b> already exists';


		}
		
		foreach($_POST['category'] as $categories) {
   $categoryID .= $categories.',';
    }
		if(!$totalUsers){
$sqlA2="insert into ".$prefix."musers (`usrm_username`,`usrm_NameofInstitution`,`usrm_fname`,`usrm_sname`,`usrm_Nationality`,`usrm_password`,`usrm_phone`,`usrm_email`,`usrm_updated`,`usrm_approved`,`usrm_usrtype`,`usrm_profilepic`,`usrm_no`,`usrm_gender`,`usrm_Qualification`,`usrm_dob`,`sentNotify`,`categoryID`) values('$email','$Institution','$fname','$sname','$Nationality','$md5pass','$phone','$email',now(),'1','$usrm_usrtype','$newname','$master2','$Gender','$Qualifications','$dob','0','$categoryID')";
$mysqli->query($sqlA2);
////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
$mail->FromName = "$sitename"; //From Name -- CHANGE --


$mail->addBcc("$emailBcc",'UNCST - $sitename');
$mail->AddAddress($email, $fname); //To Address -- CHANGE --
$mail->AddReplyTo("$emailUsername", "$sitename-User Registration"); //Reply-To Address -- CHANGE --

$mail->WordWrap = 50; // set word wrap to 50 characters
$mail->IsHTML(false); // set email format to HTML
$mail->Subject = "$sitename - User Registration";
$body="Hello $fname,<br>
An account has been created for you on $sitename. Please click the link below to login or copy and paste link in your browser.</p>
After Registration Confirmation, you can proceed to login<br><br>

Username: $email<br>
Password: $NotPassword<br>
Link: https://careersug.com/grants/

<br><br>
<p>$fulladdress
</p>

";
$mail->MsgHTML($body);

if(!$mail->Send()){
	echo "Mailer Error: " . $mail->ErrorInfo;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$sqlA = "INSERT INTO ".$prefix."mlogs (log_details, logname, logemail,logip,logdate) VALUES('A new user called $fname has been added by $session_fullname', '".$_SESSION['mmfullname']."', '$email','',now())";
//$mysqli->query($sqlA);	

$message='<p class="success">Dear, this account has been successfully created, you can check your email for details. Thank you';

		}



}//end post

 
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  ?> 
<form action="" method="post" name="regForm" id="regForm" enctype="multipart/form-data">
<?php echo $message;?>

<div class="box-header"><h3 class="box-title"><?php echo $lang_Reviewers;?> </h3></div><!-- /.box-header -->
                                
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->  
                            <div class="box box-primary">
                       
                              
                                    <div class="box-body">
                                    
                                <div class="form-group">
                                  <label class="control-label" for="inputSuccess"><?php echo $lang_first_name;?> <font color="#CC0000">*</font></label>
                                  <input type="text" class="form-control required" name="fname"  value="<?php echo $sq['usrm_fname'];?>" id="fname"/>
                                  </div>
                                  
                                  <div class="form-group">
                                  <label class="control-label" for="inputSuccess"><?php echo $lang_last_name;?> <font color="#CC0000">*</font></label>
                                  <input type="text" class="form-control required" name="sname"  value="<?php echo $sq['usrm_sname'];?>" id="sname"/>
                                  </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1"><?php echo $lang_email;?> <font color="#CC0000">*</font></label>
                                            <input type="email" class="form-control required email" name="email" id="exampleInputEmail1" value="<?php echo $sq['usrm_email'];?>">
                                            
                                            
                                        </div>
                                     
                                                                           
                                        
                                        <div class="form-group">
                                            <label for="exampleInputPassword1"><?php echo $lang_pasword;?> <font color="#CC0000">*</font></label>
                                           <input type="password" class="form-control" name="pwd" minlength="5" id="pwd" value="" autocomplete="off">
                                        </div>
                                  
                                         <div class="form-group">
                                            <label for="exampleInputPassword1"><?php echo $lang_retype_password;?> <font color="#CC0000">*</font></label>
                                            
                                          
                                            
                                            
                                            <input type="password" class="form-control" name="pwd2" id="pwd2" minlength="5"   equalto="#pwd" autocomplete="off">
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                         <div class="form-group">
                                            <label for="exampleInputPassword1"><?php echo $lang_UserRole;?> <font color="#CC0000">*</font></label>

 <select name="usrm_usrtype" id="usrm_usrtype" class="required form-control" tabindex="6">
    <option value="">&nbsp; <?php echo $lang_please_select;?></option>

<option value="reviewer">&nbsp;<?php echo $lang_Reviewer;?></option>
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
                                            <label for="exampleInputPassword1"><?php echo $lang_institution_of_affiliation;?> <font color="#CC0000">*</font></label>
                                           <input type="text" class="form-control required" name="Institution" id="Institution" value="<?php echo $sq['usrm_NameofInstitution'];?>">
                                           
                                           
                                        </div> 
                                     <div class="form-group">
    <label class="control-label" for="inputSuccess"><?php echo $lang_Gender;?> <font color="#CC0000">*</font></label>
    <input name="Gender" type="radio" value="Male" tabindex="14" id="Gender" <?php if($sq['usrm_gender']=='Male'){?>checked="checked"<?php }?>/> <?php echo $lang_male;?>&nbsp;
      <input name="Gender" type="radio" value="Female"  tabindex="15" id="Gender" <?php if($sq['usrm_gender']=='Female'){?>checked="checked"<?php }?>/> <?php echo $lang_female;?>
    </div>
    
    <div class="form-group">
                                            <label class="control-label" for="inputSuccess"><?php echo $lang_phone_number;?> <font color="#CC0000">*</font></label>
                                            <input type="text" class="form-control required" name="phone"  value="<?php echo $sq['usrm_phone'];?>"/>
    </div>
    
    <div class="form-group">
    <label class="control-label" for="inputSuccess"><?php echo $lang_Qualifications;?> <font color="#CC0000">*</font></label>
    
    <select name="Qualifications" id="Qualifications" class="required form-control" tabindex="6" onChange="getQualification(this.value)">
        <option value="">&nbsp; <?php echo $lang_please_select;?></option>
        <option value="Diploma" <?php if($sq['usrm_Qualification']=='Diploma'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Diploma;?></option>
        <option value="Bachelor's Degree" <?php if($sq['usrm_Qualification']=="Bachelor's Degree"){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Bachelor;?></option>
        <option value="Master's Degree" <?php if($sq['usrm_Qualification']=="Master's Degree"){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Master;?></option>
        <option value="PHD" <?php if($sq['usrm_Qualification']=='PHD'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_PHD;?></option>
        <option value="Post-Doctoral" <?php if($sq['usrm_Qualification']=='Post-Doctoral'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_post_Doctoral;?> </option>
        <option value="Other" <?php if($sq['usrm_Qualification']=='Other'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Other;?></option>
      </select>
    </div>

    <div class="form-group">
                                            <label for="exampleInputPassword1"><?php echo $lang_Nationality;?> <font color="#CC0000">*</font></label>
                                      <select name="Nationality" id="Nationality" class="required form-control" tabindex="6">
    <option value="">&nbsp; <?php echo $lang_please_select;?></option>
    <?php
$sqlUser = "SELECT * FROM ".$prefix."countries order by cidm_country_name asc";
$queryUser = $mysqli->query($sqlUser);
while($r = $queryUser->fetch_array()){?>
    <option value="<?php echo $r['cidm_country_id'];?>"  <?php if($sq['usrm_Nationality']==$r['cidm_country_id']){?>selected="selected"<?php }?>>&nbsp;<?php echo $r['cidm_country_name'];?></option>
    <?php }?>
  </select>
                                        </div>
                                 
                                 
                                 
      <div class="form-group">
 <label for="exampleInputPassword1"><?php echo $lang_AssignCategories;?> <font color="#CC0000">*</font></label><br />
<?php
$sqlCategory = "SELECT * FROM ".$prefix."categories order by rstug_categoryName asc";
$queryCategory = $mysqli->query($sqlCategory);
while($rCategory = $queryCategory->fetch_array()){
?>
<input name="category[]" type="checkbox" value="<?php echo $rCategory['rstug_categoryID'];?>" <?php if($rCategory['rstug_categoryID']==$choper1 || $rCategory['rstug_categoryID']==$choper2 || $rCategory['rstug_categoryID']==$choper3 || $rCategory['rstug_categoryID']==$choper4 || $rCategory['rstug_categoryID']==$choper5 || $rCategory['rstug_categoryID']==$choper6 || $rCategory['rstug_categoryID']==$choper7){?>checked="checked"<?php }?>/>&nbsp;


<?php if($base_lang=='en'){echo $rCategory['rstug_categoryName'];}
if($base_lang=='fr'){echo $rCategory['rstug_categoryName_fr'];}
if($base_lang=='pt'){echo $rCategory['rstug_categoryName_pt'];}
?><br />
<?php }?>
</div>                                   

                                 
                                 
                                        
                                         <div class="form-group">
                                           <?php if($sq['usrm_profilepic']){?><img src="files/photos/thumb_<?php echo $sq['usrm_profilepic'];?> "  style="border:1px solid #CCC; padding:2px;"/><?php }?><br /> <b><?php echo $lang_Uploadprofilepicture;?></b>                                        
<input name="profilepic" type="file" />
                                        </div>
                                        
                                    
        
        
   
        
        
        
        
        
        
        
        
                                    <input name="doRegister" type="submit" class="btn btn-info btn-flat" value="<?php echo $lang_new_Save;?>"/>&nbsp;&nbsp;&nbsp;<input name="button" type="button" class="btn btn-info btn-flat" value="<?php echo $lang_BacktoList;?>" onClick="window.location.href='./main.php?option=Reviewers'"/>
                              
<p>&nbsp;</p>
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
          
                <?php }else{?><p class="error">You dont have permissions to access this page, please contact administrator for details</p><?php }?>  
                 </form>
     
                 