 <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
       
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Assign Submission</li>
                    </ol>
                </section>

<section class="content">
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
<form action="./main.php?option=pmassign" method="post" name="regForm" id="regForm"  enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td>


<div class="box box-danger">
                                <div class="box-header">
                                    <i class="fa fa-warning"></i>
                                    <h3 class="box-title"><?php echo $rsContribution2['ms_NameOfPI'];?>'s <?php echo $lang_ReviewSubmission;?></h3>
                                    
                                </div><!-- /.box-header -->
                                <div class="box-body">
                               
                                    <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                       <b style="font-size:18px;"><?php echo $rsContribution['proposalmTittle'];?></b>
                                       
                                    </div>
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                        Name: <?php echo $rsContribution2['ms_NameOfPI'];?> <br />
                                        Email: <?php echo $rsContribution['conceptm_email'];?> <br />
                                        Phone: <?php echo $rsContribution2['conceptm_phone'];?>
                                        
                                    </div>
                                    <div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-warning"></i>
                                      RefNo: <?php echo $rsContribution['referenceno'];?> 
                                    </div>
                                    
                                  
                                    
                                </div><!-- /.box-body -->
          </div>
                            <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/> 
                            
     

</td>
<td style="padding-right:20px;">&nbsp;</td>
<td style="padding-top:30px;" valign="top">
                       <table>
                               <tr>
    <td align="left" valign="top">
  <p><b>Please select Reviewer (s)</b><hr /></p>
  
  <?php
  $sqlReviewer="SELECT * FROM ".$prefix."musers  where usrm_usrtype='reviewer'";
$QueryReviewer=$mysqli->query($sqlReviewer);
while($sqReviewer = $QueryReviewer->fetch_array()){
?>
<div style="width:100%; padding-bottom:8px;"><input name="reviewer[]" type="checkbox" value="<?php echo $sqReviewer['usrm_id'];?>"  class="required"/>&nbsp;<?php echo $sqReviewer['usrm_fname'];?> <?php echo $sqReviewer['usrm_sname'];?></div>

<?php }?>

  
</td>
  </tr>
  
                         <tr>
                                 <td align="left" valign="top">&nbsp;</td>
                         </tr>
                         <tr>
 <td align="left" valign="top">
<input name="doSubmit" type="submit" class="btn btn-info btn-flat" value="Assign to Reviewers"/><br /><br />

<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=proposals'"/>
</td>
  </tr>
</table>
</td>
</tr>
</table>

 </form>                           
                            </section>