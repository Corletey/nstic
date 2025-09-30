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
?>
<?php



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

<form action="./main.php?option=spreview&id=<?php echo $id;?>" method="post" name="regForm" id="regForm"  enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td>


<div class="box box-danger">
                                <div class="box-header">
                               
                                    <h3 class="box-title"><?php /*?><?php echo $rsContribution['ms_NameOfPI'];?>'s <?php echo $lang_ReviewSubmission;?><?php */?></h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                               
                                     <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                       <b style="font-size:14px;">Title: <?php echo $rsContribution['proposalmTittle'];?></b>
                                       
                                    </div>
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        Name: <?php echo $rsContribution2['ms_NameOfPI'];?> <br />
                                        Email: <?php echo $rsContribution['conceptm_email'];?> <br />
                                        Phone: <?php echo $rsContribution2['conceptm_phone'];?>
                                        
                                    </div>
                                    <div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
           <?php if($rsContribution['cpt_sector']){?>Sector: <?php echo $rsContribution['cpt_sector'];?><br /><?php }?>
           <?php if($rsContribution['cpt_othersector']){?>Other Sector: <?php echo $rsContribution['cpt_othersector'];?><br /><?php }?>
                                      RefNo: <?php echo $rsContribution['referenceno'];?> 
                                    </div>
                                    
                                    
                                    <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                      <a href="<?php echo 'files/'.$rsContribution['propUpload'];?>" target="_blank" style="font-size:20px;">Download File</a>
                                    </div>
                                    
                                    
                                </div><!-- /.box-body -->
                            </div>
                            <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/> 
                           
                            <table>
                               <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
    <?php if(!$rsContribution['proposalm_uploadReup']){?>
   
    <input name="status" type="radio" value="Approve for Review" class="required"  onChange="getState(this.value)"/> <span style="color:#06F; font-weight:bold;"><?php echo $lang_ApprovedforReview;?></span><br />
    <input name="status" type="radio" value="Reject Submission" class="required"  onChange="getState(this.value)"/> <span style="color:#F00; font-weight:bold;">&nbsp;Reject Submission</span><br /><br />

<div id="statediv"></div>
    
<input name="doSubmit" type="submit" class="btn btn-info btn-flat" value="Submit"/><?php }?> &nbsp;

<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=proposals'"/></td>
  </tr>
</table>

</td>
<td style="padding-right:20px;">&nbsp;</td>
<td valign="top">

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
<p>This PDF file cannot be viewed in Internet Explorer, please use Mozilla, Google Chrome, Opera</p>
<a href="<?php echo 'files/'.$rsContribution['proposalm_upload'];?>" style="color:#09F;">Download File</a>
<?php }else{?>

<?php if(!$rsContribution['propUpload']){?>
  <iframe src="https://docs.google.com/viewerng/viewer?url=https://sgcigrants.uncst.go.ug/files/<?php echo $rsContribution['proposalm_upload'];?>&hl=bn&embedded=true" style="width:500px; height:800px;"></iframe>
  <?php }?>
  
  
  <?php if($rsContribution['propUpload']){?>
  <iframe src="https://docs.google.com/viewerng/viewer?url=https://sgcigrants.uncst.go.ug/files/<?php echo $rsContribution['propUpload'];?>&hl=bn&embedded=true" style="width:500px; height:800px;"></iframe>
  
  <?php }?>

<?php 
}//end browser support
?>
</td>
</tr>
</table>

 </form>                           
                            </section>