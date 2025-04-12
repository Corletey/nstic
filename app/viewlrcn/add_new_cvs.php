<!-- Content Header (Page header) -->
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
<?php CheckSubmittedCVS();?>


<?php
if($_POST['doUploadProposal']=='Submit' and $_POST['proposal_id'])
{
	
		function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

$proposal_id=$mysqli->real_escape_string($_POST['proposal_id']);
//////////////////////////////////////Other Attachments//////////////////////////////////////////
for ($i=0; $i < count($_POST['NameofAttachmentStudytoolsmm']); $i++) {
$NameofAttachmentStudytoolsmm=$_POST['NameofAttachmentStudytoolsmm'][$i];//////////////harriet

$studytoolsextfile = $usrm_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['rstug_studytoolsmm']['name'][$i]));
$targetw = "files/". basename($usrm_id.preg_replace('/\s+/', '_', $_FILES['rstug_studytoolsmm']['name'][$i]));
$studytoolsext_main = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['rstug_studytoolsmm']['tmp_name'][$i]), $targetw);


$extension_txtm = getExtension($studytoolsext_main);
$extension_txtm = strtolower($studytoolsext_main);
 
 ////////////////////////study tools
$querym="select * from ".$prefix."concepts_cvs where usrm_id='$usrm_id' and cvname='$studytoolsextfile' and openstatus='open'";
$rowsm = $mysqli->query($querym);
$results=$rowsm->fetch_array();


$TotalsTudy = $rowsm->num_rows;

$conceptm_id=$mysqli->real_escape_string($_POST['conceptm_id']);

 if(!$TotalsTudy and strlen($studytoolsextfile)>=6 and $conceptm_id){
$sqlA4s = "INSERT INTO ".$prefix."concepts_cvs (usrm_id,name, cvname,cvdate, openstatus, conceptm_id, proposal_id) VALUES('$usrm_id','$NameofAttachmentStudytoolsmm','$studytoolsextfile',now(),'open','$conceptm_id','$proposal_id')";
$mysqli->query($sqlA4s);
 }//end totals
}//////end////////////////////////////////
$record_id = $mysqli->insert_id;



if($record_id>=1){
echo '<img src="img/ajax-loader1.gif">';
echo '<div class="spacer"></div>';
echo '<meta http-equiv="refresh" content="5; url='.$base_url.'main.php?option=dashboard" />';
/*echo("<script>location.href = './main.php?option=dashboard';</script>");*/

$message="<p style='color:#09F!important;'>Your Cv(s) have been submitted successfully</p>";
}

if($record_id<=0){
$message="<p style='color:#09F!important;'>Your Cv was NOT Submitted please try again later.</p>";	
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
<p><strong>Attach more Cvs </strong></p>


<tr>


<td colspan="2"><strong>Select Project</strong><br />
<select name="proposal_id"  class="required" style="border:1px solid #7F9DB9;width:350px; height:30px;padding: 2px;">
<option value="">Please select from list</option>
<?php
$sqlFeaturedCall = "SELECT * FROM ".$prefix."grantcalls where EndDate>'$today'";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
while($rFeaturedCall = $queryFeaturedCall->fetch_array()){
?>
<option value="<?php echo $rFeaturedCall['grantID'];?>"><?php echo $rFeaturedCall['title'];?></option>
<?php }?>
</select>

</td>


</tr>


<tr>

<td colspan="2">&nbsp;</td>


</tr>

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
       




         <tr>
    <td>&nbsp;</td>
    <td>
    <?php
$sql = "select * FROM ".$prefix."concepts where categorym='proposals' and openstatus='open' order by conceptm_id desc limit 0,1";
$result = $mysqli->query($sql);
$rFLists2=$result->fetch_array();
?>
    <input name="conceptm_id" type="hidden" value="<?php echo $rFLists2['conceptm_id'];?>"/>
    
    <input name="doUploadProposal" type="submit" value="Submit" class="btn btn-info btn-flat"/></td>
    </tr>
</table></div>
 
                           
                            </div><!-- /.box -->

                          </div>

                        <!-- right column -->
                        <div class="col-md-6">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                       
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
 
                 </form>
     
                 </section> 
