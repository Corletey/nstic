 <?php 
$Now=date("Y-m-d H:i:s");
if($Now>='2018-08-18 23:59:00'){
	?>
    
<p style="color:#F00; font-size:24px; padding-top:50px;">&nbsp;&nbsp;&nbsp;&nbsp;Submissions Closed on 18/08/2018 Midnight. Thank You</p>	

<?php
}else{
?><!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                           <small><?php echo $sitename;?> - Submit CVs</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> <?php echo $lang_home;?></a></li>
                        <li class="active">Register Users</li>
                    </ol>
                </section>

<section class="content">



<?php
$path = $_FILES['attachment_a']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);

if($_POST['doUploadProposal']=='Submit' and ($ext!='pdf'))
{
	$messagepdf="<p class='error'>ERROR: Please upload pdf (only pdf files are allowed)</p>";
}

if($_POST['doUploadProposal']=='Submit' and ($ext=='pdf') and $_FILES['attachment_a'])
{
	
		function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }


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
	

$attachment_a = $usrm_id."_".$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachment_a']['name']));
		
$length = 10;
$refno = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

	//.$time
//Make sure that this appointment is not resubmitted again	and proposalm_upload='$document' 
$queryDistrictsMain="select * from ".$prefix."concepts where conceptm_email='$email' and cpt_sector='$sector' and categorym='proposals'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$totals_R=$R_DMain->num_rows;

if($totals_R){
	$message="<p class='error'>Your Concept was Already submitted, We shall get back to you during the review process. Thank you</p>";
}
if(!$totals_R){
	
$new_file_name = 'files/';
$folderperm=substr(sprintf('%o', fileperms('files/')), -4);		
			////check for file permissions before submitting data
if ($folderperm<='0711') {//0754
$message="<p class='error'>ERROR: Your file was not upload because of permissions on the folder</p>";
}

else{
$attachment_a = $usrm_id."a_".$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachment_a']['name']));
$targetw_a = "files/". basename($usrm_id."a_".preg_replace('/\s+/', '_', $_FILES['attachment_a']['name']));
$studytoolsext_maina = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachment_a']['tmp_name']), $targetw_a);
$extension_txtm_a = getExtension($filed_main_a);
$extension_txtm_a = strtolower($filed_main_a);


$attachment_b = $usrm_id."b_".$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachment_b']['name']));
$targetw_c = "files/". basename($usrm_id."b_".preg_replace('/\s+/', '_', $_FILES['attachment_b']['name']));
$studytoolsext_mains = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachment_b']['tmp_name']), $targetw_c);
$extension_txtm_a = getExtension($filed_main_b);
$extension_txtm_a = strtolower($filed_main_b);


$attachment_c = $usrm_id."c_".$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachment_c']['name']));
$targetw_d = "files/". basename($usrm_id."c_".preg_replace('/\s+/', '_', $_FILES['attachment_c']['name']));
$studytoolsext_maind = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachment_c']['tmp_name']), $targetw_d);
$extension_txtm_c = getExtension($filed_main_c);
$extension_txtm_c = strtolower($filed_main_c);




//}
if($_FILES['attachment_a']['name']){
$querya="insert into ".$prefix."concepts_cvs (`usrm_id`,`cvname`,`cvdate`) 
values('$usrm_id','$attachment_a',now())";
$mysqli->query($querya);
}

if($_FILES['attachment_b']['name']){
$queryb="insert into ".$prefix."concepts_cvs (`usrm_id`,`cvname`,`cvdate`) 
values('$usrm_id','$attachment_b',now())";
$mysqli->query($queryb);
}

if($_FILES['attachment_c']['name']){
$queryc="insert into ".$prefix."concepts_cvs (`usrm_id`,`cvname`,`cvdate`) 
values('$usrm_id','$attachment_c',now())";
$mysqli->query($queryc);
}



///send email
$record_id = $mysqli->insert_id;
if($record_id>=1){
echo '<img src="img/ajax-loader1.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = './main.php?option=SubmitCvc';</script>");

$message="<p style='color:#09F!important;'>Your Cvs have been submitted, please wait...</p>";
}

if($record_id<=0){
$message="<p style='color:#09F!important;'>Your CVs were NOT Submitted please try again later.</p>";	
}


}
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
                        <div class="col-md-6">
                            <!-- general form elements -->  
                            <div class="box box-primary">
                                <div class="box-header" style="border-bottom:1px solid #ccc;">
                                    <h3 class="box-title">Proposal Details - Please attach cvs</h3>
                                
                                </div><!-- /.box-header -->
                                <!-- form start -->
<div class="box-body">
<table width="100%" border="0">

      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>

             <tr>
    <td width="26%">Upload File (CV)<span class="error">*</span></td>
    <td width="74%">
    <input type="file" name="attachment_a" id="attachment_a" class="required"/>  <br />  
     <strong>(Allowed file type:pdf only, Max allowed size 2Mbs) </strong></td>
    </tr>
  
      <tr>
    <td width="26%">Upload File (CV)</td>
    <td width="74%">
    <input type="file" name="attachment_b" id="attachment_b"/>  <br />  
     <strong>(Allowed file type:pdf only, Max allowed size 2Mbs) </strong></td>
    </tr>
    
        <tr>
    <td width="26%">Upload File (CV)</td>
    <td width="74%">
    <input type="file" name="attachment_c" id="attachment_c"/>  <br />  
     <strong>(Allowed file type:pdf only, Max allowed size 2Mbs) </strong></td>
    </tr>

             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
    <td>&nbsp;</td>
    <td><input name="doUploadProposal" type="submit" value="Submit" class="btn btn-info btn-flat"/></td>
    </tr>
</table></div>
 
                           
                            </div><!-- /.box -->

                          </div>

                        <!-- right column -->
                        <div class="col-md-6">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sitename;?> (PPP) in Research and &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Innovation Grants</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                
<div class="progress" style="margin-left:20px;">
<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">50% Complete</div>
</div>

<?php include("viewlrcn/call_text.php");?>
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
 
                 </form>
     
                 </section> 
<?php }?>