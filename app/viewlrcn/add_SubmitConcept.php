 <?php
 $sql = "select * FROM ".$prefix."grantcalls where grantID='$id'";
$result = $mysqli->query($sql);
$total_pages = $result->num_rows;
$rFLists2=$result->fetch_array();
 
$Now=date("Y-m-d H:i:s");
if($rFLists2['EndDate']<$today){
	?>
    
<p style="color:#F00; font-size:24px; padding-top:50px;">&nbsp;&nbsp;&nbsp;&nbsp;Submissions Closed on <?php echo $rFLists2['EndDate'];?> Midnight. Thank You</p>	

<?php
}else{
?><!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                           <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> <?php echo $lang_home;?></a></li>
                        <li class="active">Register Users</li>
                    </ol>
                </section>

<section class="content">

<?php CheckSubmittedCVS();?>

<?php
$path = $_FILES['attachment']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);

if($_POST['doUploadProposal']=='Submit' and ($ext!='pdf'))
{
	$messagepdf="<p class='error'>ERROR: Please upload pdf (only pdf files are allowed)</p>";
}

if($_POST['doUploadProposal']=='Submit' and ($ext=='pdf') and $_POST['proposalTittle'])
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
	$proposal_id=$mysqli->real_escape_string($_POST['proposal_id']);
	
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
		
$length = 10;
$refno = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

	//.$time
//Make sure that this appointment is not resubmitted again	and proposalm_upload='$document' 
$queryDistrictsMain="select * from ".$prefix."concepts where conceptm_email='$email' and cpt_sector='$sector' and categorym='proposals' and openstatus='open' and proposal_id='$proposal_id'";
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
$targetw = "files/". basename($usrm_id."_".preg_replace('/\s+/', '_', $_FILES['attachment']['name']));
$studytoolsext_main = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachment']['tmp_name']), $targetw);
$extension_txtm = getExtension($filed_main);
$extension_txtm = strtolower($filed_main);
//}


$query="insert into ".$prefix."concepts (`usrm_id`,`ms_NameOfPI`,`conceptm_NameofInstitution`,`conceptm_email`,`conceptm_phone`,`proposalmTittle`,`cpt_sector`,`cpt_othersector`,`proposalm_upload`,`referenceno`,`conceptm_date`,`conceptm_status`,`conceptm_cmtapprove`,`conceptm_cmtreject`,`conceptm_assignedto`,`conceptm_assignedby`,`proposalm_uploadReup`,`conceptm_Reviewers`,`conceptm_Avg`,`conceptm_Times`,`categorym`,`sentNotify`,`mailtext`,`openstatus`,`proposal_id`) 
values('$usrm_id','$nameofpi','$NameofInstitution','$email','$phone','$proposalTittle','$sector','$othersector','$document','$refno',now(),'new','','','','','','','','','proposals','','','open','$proposal_id')";
$mysqli->query($query);
$record_id = $mysqli->insert_id;
//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`,`proposal_id`) 
values('$nameofpi has submit a proposal titled $proposalTittle under $sector$othersector.','$nameofpi','$email','$user_ip',now(),'$proposal_id')";
$mysqli->query($queryLog);	
///send email



//////////////////////////////////////Other Attachments//////////////////////////////////////////
for ($i=0; $i < count($_POST['NameofAttachmentStudytoolsmm']); $i++) {
$NameofAttachmentStudytoolsmm=$_POST['NameofAttachmentStudytoolsmm'][$i];//////////////harriet

$studytoolsextfile = $usrm_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['rstug_studytoolsmm']['name'][$i]));
$targetw = "files/". basename($usrm_id.preg_replace('/\s+/', '_', $_FILES['rstug_studytoolsmm']['name'][$i]));
$studytoolsext_main = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['rstug_studytoolsmm']['tmp_name'][$i]), $targetw);


$extension_txtm = getExtension($studytoolsext_main);
$extension_txtm = strtolower($studytoolsext_main);
 
 ////////////////////////study tools
$qRstudy="select * from ".$prefix."concepts_cvs where usrm_id='$usrm_id' and sattachment='$studytoolsextfile' and openstatus='open'";
$QueryRstudy = $mysqli->real_escape_string($qRstudy);
$TotalsTudy = $QueryRstudy->num_rows;
 if(!$TotalsTudy and strlen($studytoolsextfile)>=6){
$sqlA4s = "INSERT INTO ".$prefix."concepts_cvs (usrm_id,name, cvname,cvdate, openstatus, conceptm_id, proposal_id) VALUES('$usrm_id','$NameofAttachmentStudytoolsmm','$studytoolsextfile',now(),'open','$record_id', '$proposal_id')";
$mysqli->query($sqlA4s);
 }//end totals
}//////end////////////////////////////////




if($record_id>=1){
echo '<img src="img/ajax-loader1.gif">';
echo '<div class="spacer"></div>';
echo '<meta http-equiv="refresh" content="5; url="'.$base_url.'"main.php?option=dashboard" />';
/*echo("<script>location.href = './main.php?option=dashboard';</script>");*/

$message="<p style='color:#09F!important;'>Your Proposal was Submitted Successfully</p>";
}

if($record_id<=0){
$message="<p style='color:#09F!important;'>Your Proposal was NOT Submitted please try again later.</p>";	
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
    <td width="20%" valign="top">Proposal Title <span class="error">*</span></td>
    <td width="80%" class="sepr">
    <textarea name="proposalTittle" id="ProjectTittle" cols="" rows="2" class="form-control required"  minlength="8" tabindex="3"></textarea>
     </td>
    </tr>
          <?php /*?>   <tr>
               <td> Sector</td>
               <td><select name="sector" style="margin-bottom:5px;" class="form-control required" onChange="getState(this.value)">
               <option value="Biotechnology/Agriculture">&nbsp;Biotechnology/Agriculture</option>
               <option value="Health/Nutrition">&nbsp;Health/Nutrition</option>
               <option value="Information, Communication and Telecommunication (ICT)">&nbsp;Information, Communication and Telecommunication (ICT)</option>
               <option value="Value Addition/Product Development">&nbsp;Value Addition/Product Development</option>
               <option value="Material Sciences/Renewable Energy">&nbsp;Material Sciences/Renewable Energy</option>
              <option value="Other" >&nbsp;Other (Please Specify below)</option>
               
               </select></td>
             </tr><?php */?>
             
             
         <tr>
         <td>&nbsp;</td>
          <td>
          
          <div id="statediv">
          
          
          </div>
          
          
          </td>
             </tr><!-- -->
             <tr>
    <td width="20%" valign="top">Upload File<span class="error">*</span></td>
    <td width="80%">
    <input type="file" name="attachment" id="attachment" class="required"/>  <br />  
     <strong>(Allowed file type:pdf only, Max allowed size 3Mbs) </strong></td>
    </tr>
  
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
    

<p><strong>Attach Cvs (Minimum 2 and Maximum 10)</strong></p>


<tr>
               <td colspan="2">

<table id="POITable" border="0">
 <tr>
<!-- <td></td>
    <td><strong></strong></td>


    <td>&nbsp;</td>
  </tr>

-->

<tr>
<td width="40"><input value="1" name="ItemNo" class="inputmain3" style="border:0px;border-bottom:0px solid #000000; color:#000;  width:30%; background:#F7F8FB; font-size:14px;"/></td>
    <td>
    <input value="" name="NameofAttachmentStudytoolsmm[]" id="NameofAttachmentStudytoolsmm"  class="inputmain3 required" style="border:1px solid #7F9DB9;width:280px; height:30px;padding: 2px;"/>
    
    </td>


    <td><input value="" name="rstug_studytoolsmm[]" type="file"  id="rstug_studytools1" class="required"/></td>
  </tr>

    
</table>     
       
       
<table border="0" cellspacing="0" cellpadding="0">

  <tr>
<td colspan="8" valign="top">

<input type="button" id="addmorePOIbutton" value="ADD ROWS" onclick="insRow()" class="buttonm"/>
<input type="button" id="delPOIbutton" value="DELETE ROWS" onclick="deleteRow(this)" class="buttonm"/>

</td>
</tr>

</table> 
       
</td></tr>



         <tr>
    <td>&nbsp;</td>
    <td>
    <input name="proposal_id" type="hidden" value="<?php echo $id;?>"/>
    
    
    <input name="doUploadProposal" type="submit" value="Submit" class="btn btn-info btn-flat"/></td>
    </tr>
</table>


</div>
 
                           
                            </div><!-- /.box -->

                          </div>

                        <!-- right column -->
                        <div class="col-md-6">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                    <?php include("viewlrcn/call_text.php");?>
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
 
                 </form>
     
                 </section> 
<?php }?>