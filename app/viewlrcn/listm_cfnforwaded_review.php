 <?php
 if($session_usertype=='reviewer'){?><!-- Content Header (Page header) -->
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
///////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."concepts where conceptm_id='$id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();


$nameofpi=$rsContribution['ms_NameOfPI'];

$path = $_FILES['attachment']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);

?>

<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td>


<div class="box box-danger">
                                <div class="box-header">
                                    <i class="fa fa-warning"></i>
                                    <h3 class="box-title"><?php echo $rsContribution['ms_NameOfPI'];?>'s <?php echo $lang_ReviewSubmission;?></h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                               
                                    <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                       <b style="font-size:18px;"><?php echo $rsContribution['proposalmTittle'];?></b>
                                       
                                    </div>
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                        Name: <?php echo $rsContribution['ms_NameOfPI'];?> <br />
                                        Email: <?php echo $rsContribution['conceptm_email'];?> <br />
                                        Phone: <?php echo $rsContribution['conceptm_phone'];?>
                                        
                                    </div>
                                    <div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-warning"></i>
           <?php if($rsContribution['cpt_sector']){?>Sector: <?php echo $rsContribution['cpt_sector'];?><br /><?php }?>
           <?php if($rsContribution['cpt_othersector']){?>Other Sector: <?php echo $rsContribution['cpt_othersector'];?><br /><?php }?>
                                      RefNo: <?php echo $rsContribution['referenceno'];?> 
                                    </div>
                                    
                                    
                                    <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                      <a href="<?php echo 'files/'.$rsContribution['proposalm_uploadv2'];?>" target="_blank">Download File</a>
                                    </div>
                                    
                                    
                                </div><!-- /.box-body -->
                            </div>
  <form action="./main.php?option=freview" method="post" name="regForm" id="regForm"  enctype="multipart/form-data">
   <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/> 
                            
                            <table>
                               <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
    <input name="status" type="radio" value="Approve Submission" class="required"  onChange="getState(this.value)"/> Accept Submission<br />
    <input name="status" type="radio" value="Reject Submission" class="required"  onChange="getState(this.value)"/> Reject Submission<br /><br />
    <div id="statediv"></div>
    
<input name="doSubmit" type="submit" class="btn btn-info btn-flat" value="Proceed"/> &nbsp;<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=dashboard'"/></td>
  </tr>
</table>
 </form>
 
 
</td>
<td style="padding-right:20px;">&nbsp;</td>
<td style="padding-top:30px;" valign="top">

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
<a href="<?php echo 'files/'.$rsContribution['proposalm_uploadv2'];?>" style="color:#09F;">Download File</a>
<?php }else{?>

<iframe src="https://docs.google.com/viewerng/viewer?url=https://sgcigrants.uncst.go.ug/files/<?php echo $rsContribution['proposalm_uploadv2'];?>&hl=bn&embedded=true" style="width:500px; height:800px;"></iframe>

<?php 
}//end browser support
?>
</td>
</tr>
</table>

                          
                            </section>
                            <?php }?>