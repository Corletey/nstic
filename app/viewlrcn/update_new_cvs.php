<?php /*?> <?php 
$Now=date("Y-m-d H:i:s");
if($Now>='2018-08-18 23:59:00'){
	?>
    
<p style="color:#F00; font-size:24px; padding-top:50px;">&nbsp;&nbsp;&nbsp;&nbsp;Submissions Closed on 18/08/2018 Midnight. Thank You</p>	

<?php
}else{
?><?php */?><!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                           <small><?php echo $sitename;?> - Submit CVs</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Register Users</li>
                    </ol>
                </section>

<section class="content">
<?php CheckSubmittedCVS();?>


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

if($_FILES['attachment_a']['name']){
	
$attachment_a = $usrm_id."a_".$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachment_a']['name']));
$targetw_a = "files/". basename($usrm_id."a_".preg_replace('/\s+/', '_', $_FILES['attachment_a']['name']));
$studytoolsext_maina = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachment_a']['tmp_name']), $targetw_a);
$extension_txtm_a = getExtension($filed_main_a);
$extension_txtm_a = strtolower($filed_main_a);

$querya="update ".$prefix."concepts_cvs set `cvname`='$attachment_a' where `usrm_id`='$usrm_id' and cvID='$id'";
$mysqli->query($querya);

$message="<p style='color:#09F!important;'>Your Cvs have been submitted</p>";

}else{
$message="<p style='color:#09F!important;'>Your CVs were NOT Submitted please try again later.</p>";	
}

}

?>

<?php if($message){?><?php echo $message;?><?php }?>
<?php if($messagepdf){?><?php echo $messagepdf;?><?php }
$sqlConceptLogs="SELECT * FROM ".$prefix."concepts_cvs where usrm_id='$usrm_id' and cvID='$id'";
$QueryConcept=$mysqli->query($sqlConceptLogs);
$rFListsmain=$QueryConcept->fetch_array();

?>

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
    <a href="./files/<?php echo $rFListsmain['cvname'];?>" target="_blank"><?php echo $rFListsmain['cvname'];?></a><br />  
     <strong>(Allowed file type:pdf only) </strong></td>
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
                                

<?php include("viewlrcn/call_text.php");?>
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
 
                 </form>
     
                 </section> 
<?php //}?>