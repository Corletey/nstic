 <?php
 ///////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."concepts where conceptm_id='$id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();
$conceptm_id=$rsContribution['conceptm_id'];
//////////////////////////////////////////////////////////////////////////////////////
$queryContribution2="select * from ".$prefix."concepts where conceptm_id='$conceptm_id'";
$rs_Contribution2=$mysqli->query($queryContribution2);
$rsContribution2=$rs_Contribution2->fetch_array();


?><!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
           
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?php echo $lang_ReviewSubmission;?></li>
                    </ol>
                </section>

<section class="content">
<?php

$status=$_POST['status'];
 $path = $_FILES['attachment']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
$nameofpi=$rsContribution['ms_NameOfPI'];
$proposalTittle=$rsContribution['proposalmTittle'];

if($_POST['doSubmit'] and $status=='Approve for Review')
{

if($ext=='pdf')
{	
	
$new_file_name = 'files/';
$folderperm=substr(sprintf('%o', fileperms('files/')), -4);		
				
if ($folderperm<='754') {

///Record this log before sending mail to admin
$message="<p class='error'>Dear $nameofpi, Your proposal was not submitted, there permissions on server, please contact Administrator. Thank you</p>";
///////////////////////////////////////////////////
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`) 
values('$session_fullname wanted to Re-Uploaded Submission titled $proposalTittle with name $document, but files folder has permissions.','$nameofpi','$email','$user_ip',now())";
$mysqli->query($queryLog);	
///send email notification to admin
	
	
} else {

$document = $nameofpi.'p2_'.$mysqli->real_escape_string($_FILES['attachment']['name']);
$target = 'files/'.$nameofpi.'p2_'.basename( $_FILES['attachment']['name']);
$download = move_uploaded_file($_FILES['attachment']['tmp_name'], $target); 


$query="update ".$prefix."concepts set `conceptm_status`='approved',`proptm_cmtreject`='',`proposalm_uploadReup`='$document' where conceptm_id='$id'";
$mysqli->query($query);
//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`) 
values('$session_fullname has submit Re-Uploaded Submission titled $proposalTittle with name $document.','$nameofpi','$email','$user_ip',now())";
$mysqli->query($queryLog) or print(mysql_error());	
///send email
$message="<p class='success'><p>Submission attached for review successfully</p>";

}//end checking permissions
}///end if pdf
if($ext!='pdf')
{	$errormessage="<p class='error'>Please upload a pdf document only</p>";}
?>
                               
                                    <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <?php if($message){?>
                                        <b style="font-size:18px;"><?php echo $message;?></b><br /><br />
                                        <input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=dashboard'"/>
                                        <?php }?>
                                        <?php if($errormessage){?>
                                        <b style="font-size:18px; color:#F00;"><?php echo $errormessage;?></b><br /><br />
                                        <input name="button" type="button" class="btn btn-info btn-flat" value="Click to Go Back" onClick="window.location.href='./main.php?option=review&id=<?php echo $id;?>'"/>
                                        <?php }?>
                                       
                                    </div>
                           
                            <?php }?>
                            
<?php 
//////rejected///////////////////////////////////////////////////////////////////
if($_POST['doSubmit'] and $status=='Reject Submission'){
	$cmtcomments=$_POST['cmtcomments'];									  
$query="update ".$prefix."concepts  set conceptm_status='rejected',`proptm_cmtapprove`='',`proptm_cmtreject`='$cmtcomments' where conceptm_id='$id'";
$mysqli->query($query);
//log this entry
$queryLog="insert into ".$prefix."mlogs (`log_details`,`logname`,`logemail`,`logip`,`logdate`,`proptm_cmtapprove`,`proptm_cmtreject`) 
values('$session_fullname has approved $nameofpi proposal titled $proposalTittle.','$nameofpi','$email','$user_ip',now(),'','$cmtcomments')";
$mysqli->query($queryLog);	
///send email
?>
                               
                           
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                       <b style="font-size:18px;"><?php echo $rsContribution2['ms_NameOfPI'];?>'s Proposal <?php echo $rsContribution['proposalmTittle'];?> has been Rejected.</b>
                                        
                                    </div>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=proposals'"/>
                            <?php }?>   
                                </div><!-- /.box-body -->
                            </div>
                     
                            </section>