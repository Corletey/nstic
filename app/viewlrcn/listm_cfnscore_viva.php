<?php if($_SESSION['usrm_usrtype']=='superadmin' || $session_usertype=='admin'){
	//////get all//////////////////////////
$queryContributionLogs="select * from ".$prefix."mscores where scoredmID='$id'";
$rs_ContributionLogs=$mysqli->query($queryContributionLogs);
$rsContributionLogs=$rs_ContributionLogs->fetch_array();
$conceptm_id=$rsContributionLogs['conceptm_id'];
///////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."concepts where conceptm_id='$conceptm_id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();
$conceptm_id=$rsContribution['conceptm_id'];
//////////////////////////////////////////////////////////////////////////////////////
/*$queryContribution2="select * from ".$prefix."concepts where conceptm_id='$conceptm_id'";
$rs_Contribution2=$mysqli->query($queryContribution2);
$rsContribution2=$rs_Contribution2->fetch_array();

$ms_NameOfPI=$rsContribution2['ms_NameOfPI'];
$conceptm_NameofInstitution=$rsContribution2['conceptm_NameofInstitution'];
$proposalmTittle=$rsContribution['proposalmTittle'];
$conceptm_email=$rsContribution['conceptm_email'];
$conceptm_phone=$rsContribution['conceptm_phone'];*/

/*

/////////////////////Get Reviewer Details
$queryReviwer="select * from ".$prefix."musers where usrm_id='$conceptm_assignedto'";
$rs_Reviwer=$mysqli->query($queryReviwer);
$rsReviwer=$rs_Reviwer->fetch_array();
$usrm_fname=$rsReviwer['usrm_fname'];
$usrm_email=$rsReviwer['usrm_email'];
$usrm_phone=$rsReviwer['usrm_phone'];*/
//////////////////////////////////////////////////////////////////////////////

?>
<?php

if($_POST['doEvaluate']=='Submit')
{
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");
$AppPrototypeClearly=$_POST['vivascore'];
//get totals
$sqlScoresMaine = "SELECT * FROM ".$prefix."mscores where scoredmID='$id'";
$queryScoresMaine = $mysqli->query($sqlScoresMaine);
$rsVivae=$queryScoresMaine->fetch_array();

if($rsVivae['EvTotalScore']){$totalVIVA=($rsVivae['EvTotalScore']+$AppPrototypeClearly);


$queryScores="update  ".$prefix."mscores set `AppPrototypeClearly`='$AppPrototypeClearly',`EvTotalScore`='$totalVIVA' where scoredmID='$id'";
$mysqli->query($queryScores);
}

$message="<p class='success'><p>Successfully Evaluated. VIVA Score: <b>".$AppPrototypeClearly."</b> Thank You</p>";


}//end checking permissions
$sqlScoresMain = "SELECT * FROM ".$prefix."mscores where scoredmID='$id'";
$queryScoresMain = $mysqli->query($sqlScoresMain);
$totalScoresMain = $queryScoresMain->num_rows;
$rsViva= $queryScoresMain->fetch_array();
?>
 
 <!-- Content Header (Page header) -->
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

<form action="./main.php?option=psviva&id=<?php echo $id;?>" method="post" name="regForm" id="regForm"  enctype="multipart/form-data">

<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td>



<div class="box box-danger">
                                <div class="box-header">
                                  &nbsp;
                                </div><!-- /.box-header -->
                                <div class="box-body">
                           
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-check"></i><b>VIVA Score</b>
                                        <p>Is the research team able to present and demonstrate the research prototype clearly? (25%)</p>
<input name="vivascore" type="text" class="required number" maxlength="2" id="QnewMethods" autocomplete="off" value="<?php echo $rsViva['AppPrototypeClearly'];?>"/>                                      
                                       
                                
                                       
                                     
                                        
                                  </div>
                                </div><!-- /.box-body -->
                                </div>
                         
                            <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/> 
                             <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/>

                     <table>
                               <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
<?php 
//check success messge
//if($_POST['doEvaluate']=='Submit' and $errmsg){?><input name="doEvaluate" type="submit" class="btn btn-info btn-flat" value="Submit"/><?php //}?>&nbsp;
<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=pcompleteval'"/></td>
  </tr>
</table>



                           
                           
         
</td>
<td style="padding-right:20px;">&nbsp;</td>
<td style="padding-top:30px;" valign="top">
<?php if($message){?><div class="alert alert-warning alert-dismissable"><?php echo $message;?></div><?php }?>

<?php /*?><?php if($errmessage){?><div class="alert alert-warning alert-dismissable"><?php echo $errmessage;?></div><?php }?><?php */?>

<?php if($errmsg){?><div class="alert alert-warning alert-dismissable">
<p><b>Please correct errors below</b>:</p>
<span style="color:#F00;"><?php echo $errmsg;?></span></div><?php }?>

 <b style="font-size:18px;"><?php echo $rsContribution['proposalmTittle'];?></b>
<?php
//Begin Browser Support
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if (preg_match('/MSIE/i', $user_agent)) {
//////////////////////////////////////
//if (preg_match('/MSIE/i', $user_agent)) { $browser = "Internet Explorer";}
//elseif (preg_match('/Firefox/i', $user_agent)){$browser = "Mozilla Firefox";}
//elseif (preg_match('/Chrome/i', $user_agent)){$browser = "Google Chrome";}
//elseif (preg_match('/Safari/i', $user_agent)){$browser = "Safari";}
//elseif (preg_match('/Opera/i', $user_agent)){$browser = "Opera";}
?>
<?php }else{?>
  
  <?php if($rsContribution['proposalm_uploadReup']){?>
  
    <iframe src="https://docs.google.com/viewerng/viewer?url=https://sgcigrants.uncst.go.ug/files/<?php echo $rsContribution['proposalm_uploadReup'];?>&hl=bn&embedded=true" style="width:500px; height:800px;"></iframe>
    
  <?php }?>
<?php 
}//end browser support
?>
</td>
</tr>
</table>

 </form>                           
 </section><?php }else{?><p style="color:#900;">Error!! You are not allowed to access this page</p><?php }?>