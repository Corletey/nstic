 <?php 
$Now=date("Y-m-d H:i:s");
if($Now>='2018-08-18 23:59:00'){
	?>
    
<p style="color:#F00; font-size:24px; padding-top:50px;">&nbsp;&nbsp;&nbsp;&nbsp;Submissions Closed on 28/02/2017 Midnight. Thank You</p>	

<?php
}else{
?> <!-- Content Header (Page header) -->
 
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
<?php
$path = $_FILES['attachment']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);


if($_POST['doUploadProposal']=='Update' and $_POST['proposalTittle'])
{
	
		function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

	$user_ip = $_SERVER['REMOTE_ADDR'];
	
	$proposalTittle=$mysqli->real_escape_string($_POST['proposalTittle']);
	
	
	$sector=$mysqli->real_escape_string($_POST['sector']);
	$othersector=$mysqli->real_escape_string($_POST['othersector']);

   
$sqlConceptLogs="SELECT * FROM ".$prefix."musers where usrm_id='$usrm_id' and usrm_username='$usrm_username'";
$QueryConcept=$mysqli->query($sqlConceptLogs);
$rFListsmain=$QueryConcept->fetch_array();

	$nameofpi=$rFListsmain['usrm_fname']." ".$rFListsmain['usrm_sname'];
	$email=$rFListsmain['usrm_email'];
	$phone=$rFListsmain['usrm_phone'];
	$NameofInstitution=$rFListsmain['usrm_NameofInstitution'];
	

$document = $usrm_id."_".$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachment']['name']));
		

			////check for file permissions before submitting data
/*if (!is_writable(dirname("files/"))) {
$message2="<p class='error'>ERROR: Your file was not upload because of permissions on the folder</p>";	
}

if (is_writable(dirname("files/"))) {*/
$targetw = "files/". basename($usrm_id."_".preg_replace('/\s+/', '_', $_FILES['attachment']['name']));
$studytoolsext_main = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachment']['tmp_name']), $targetw);
$extension_txtm = getExtension($filed_main);
$extension_txtm = strtolower($filed_main);
//}

if($_FILES['attachment']['name']){
$query="update ".$prefix."concepts set `proposalmTittle`='$proposalTittle',`cpt_sector`='$sector',`proposalm_upload`='$document' where usrm_id='$usrm_id' and conceptm_id='$id'";
$mysqli->query($query);
}
if(!$_FILES['attachment']['name']){
$query="update ".$prefix."concepts set `proposalmTittle`='$proposalTittle',`cpt_sector`='$sector' where usrm_id='$usrm_id' and conceptm_id='$id'";
$mysqli->query($query);
}

//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`) 
values('$nameofpi has updated a proposal titled $proposalTittle under $sector$othersector.','$nameofpi','$email','$user_ip',now())";
$mysqli->query($queryLog);	
///send email

$message="<p style='color:#09F!important;'>Congratulations: Your Proposal was updated Successfully.</p>";

}

$sqlConceptLogs="SELECT * FROM ".$prefix."concepts where usrm_id='$usrm_id' and conceptm_id='$id'";
$QueryConcept=$mysqli->query($sqlConceptLogs);
$rFListsmain=$QueryConcept->fetch_array();
$conceptStatus=$rFListsmain['conceptm_status'];
?>

<?php if($message){?><?php echo $message;?><?php echo $message2;?><?php }?>


<form action="" method="post"  enctype="multipart/form-data" name="regForm" id="regForm" >


                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->  
                            <div class="box box-primary">
                                <div class="box-header" style="border-bottom:1px solid #ccc;">
                                    <h3 class="box-title">Proposal Details</h3>
                                
                                </div><!-- /.box-header -->
                                <!-- form start -->
<div class="box-body">
<table width="100%" border="0">

      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
 <!--     <tr>
    <td width="26%" align="left">Name of Institution <span class="error">*</span></td>
    <td width="74%"><input type="text" name="NameofInstitution" id="NameofInstitution"  class="required form-control" minlength="5" tabindex="1"/>
    
     </td>
    </tr>
           <tr>
    <td width="26%">Phone <span class="error">*</span></td>
    <td width="74%" class="sepr"><input type="text" name="phone" id="phone"  class="required number form-control" minlength="8" tabindex="3"/> </td>
    </tr>-->
             <tr>
    <td width="26%" valign="top">Proposal Title <span class="error">*</span></td>
    <td width="74%" class="sepr">
    <textarea name="proposalTittle" id="ProjectTittle" cols="" rows="2" class="form-control"  minlength="8" tabindex="3"><?php echo $rFListsmain['proposalmTittle'];?></textarea>
     </td>
    </tr>
             <?php /*?><tr>
               <td> Sector</td>
               <td><select name="sector" style="margin-bottom:5px;"  onChange="getState(this.value)" class="form-control">
               <option value="Biotechnology/Agriculture" <?php if($rFListsmain['cpt_sector']=='Biotechnology/Agriculture'){?>selected="selected"<?php }?>>&nbsp;Biotechnology/Agriculture</option>
               <option value="Health/Nutrition" <?php if($rFListsmain['cpt_sector']=='Health/Nutrition'){?>selected="selected"<?php }?>>&nbsp;Health/Nutrition</option>
               <option value="Information, Communication and Telecommunication (ICT)" <?php if($rFListsmain['cpt_sector']=='Information, Communication and Telecommunication (ICT)'){?>selected="selected"<?php }?>>&nbsp;Information, Communication and Telecommunication (ICT)</option>
               <option value="Value Addition/Product Development" <?php if($rFListsmain['cpt_sector']=='Value Addition/Product Development'){?>selected="selected"<?php }?>>&nbsp;Value Addition/Product Development</option>
               <option value="Material Sciences/Renewable Energy" <?php if($rFListsmain['cpt_sector']=='Material Sciences/Renewable Energy'){?>selected="selected"<?php }?>>&nbsp;Material Sciences/Renewable Energy</option>
              <option value="Other">&nbsp;Other</option>
               </select>
               
               </td>
             </tr><?php */?>
       <!--   <tr>
          <td colspan="2">
          
          <div id="statediv">
          
          
          </div>
          
          
          </td>
             </tr>-->
             <tr>
    <td width="26%">Upload File<span class="error">*</span></td>
    <td width="74%">
    <input type="file" name="attachment" id="attachment"/>  <br /> 
    <a href="files/<?php echo $rFListsmain['proposalm_upload'];?>" target="_blank"><?php echo $rFListsmain['proposalm_upload'];?></a>
    
    <br /> 
     <strong>(Allowed file type:pdf only) </strong></td>
    </tr>
  
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
    <td>&nbsp;</td>
    <td><?php if($conceptStatus=='new'){?><input name="doUploadProposal" type="submit" value="Update" class="btn btn-info btn-flat"/><?php }?></td>
    </tr>
</table></div>
                           
                            </div><!-- /.box -->

                          </div>

                        <!-- right column -->
                        <div class="col-md-6">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Welcome to UNCST-<?php echo $sitename;?></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
<p>The <strong><?php echo $name_granting_council;?> is a Government of Uganda Agency, established by CAP 209, under the Ministry of Finance Planning and Economic Development. The Council is mandated to facilitate and coordinate the development and implementation of policies and strategies for <strong>integrating Science and Technology</strong> (S&T) into the national development process</p>

<p>The Uganda <strong>NSTIP</strong> is an important step toward the creation of this stronger national science and technology system. It will provide resources for the expansion of high-quality research and training at both graduate and undergraduate levels; it will emphasize the use of research outputs in the private sector and for social progress; and it will also sponsor activities to strengthen science and technology policy-making and implementation. </p>
<p>Submit your Proposal today.</p>
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
 
                 </form>
     
                 </section> 
                 <?php }?>                                 