  <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                  
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> <?php echo $lang_home;?></a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

<section class="content">


                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">                            


                            <!-- Custom tabs (Charts with tabs)-->
                          <div class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active"><a href="#revenue-chart" data-toggle="tab">+</a></li>
                                    <li class="pull-left header"><i class="fa fa-inbox"></i> Submissions by Reviewer</li>
                                </ul>
                                <div class="tab-content">


                                
                                
                                 <?php GenerateReviewrs();?>
                                 <?php
                                  if($session_usertype=='superadmin' || $session_usertype=='admin'){?>
                                 <?php SubmissionsByReviewer();?>
                                 <?php }?>
                                     
                                     
  <?php if(!$_POST['doSearch']){?>                                                            
<table class="table table-mailbox">
  <tr>
    <td style="background:#307ECC; color:#FFF;"><strong><?php echo $lang_Reviewer;?></strong></td>
    <td style="background:#307ECC; color:#FFF;"><strong>Total Assigned</strong></td>
    <td style="background:#307ECC; color:#FFF;"><strong>Total Pending</strong></td>
    <td style="background:#307ECC; color:#FFF;"><strong>Total Scored</strong></td>
  </tr>
  <?php
$sqlmusers="SELECT * FROM ppr_musers,ppr_conceptsasslogs where usrm_usrtype='reviewer' and ppr_musers.usrm_id=ppr_conceptsasslogs.conceptm_assignedto and openstatus='open'";
$Querymusers=$mysqli->query($sqlmusers);
while($rmusers = $Querymusers->fetch_array()){
$reviewerusrm_id=$rmusers['usrm_id'];
$sql = "select * FROM ".$prefix."conceptsasslogs where conceptm_assignedto='$reviewerusrm_id' and openstatus='open' order by conceptm_id asc limit 0,100";
$result = $mysqli->query($sql);
$total_pages = $result->num_rows;
$rFLists2=$result->fetch_array();
///////Those Pending
$sqlPending = "select * FROM ".$prefix."conceptsasslogs where conceptm_assignedto='$reviewerusrm_id' and logm_status='new'  and openstatus='open' order by conceptm_id asc limit 0,100";
$resultPending = $mysqli->query($sqlPending);
$total_pagesPending = $resultPending->num_rows;
////////////////////////////
$sqlDone = "select * FROM ".$prefix."conceptsasslogs where conceptm_assignedto='$reviewerusrm_id' and logm_status='completed'  and openstatus='open' order by conceptm_id asc limit 0,100";
$resultDone = $mysqli->query($sqlDone);
$total_pagesDone = $resultDone->num_rows;
?>
  <tr>
    <td><?php echo $rmusers['usrm_fname'];?> <?php echo $rmusers['usrm_sname'];?></td>
    <td><?php echo $total_pages;?></td>
    <td style="color:#F00; font-weight:bold;"><?php echo $total_pagesPending;?></td>
    <td style="color:#06F; font-weight:bold;"><?php echo $total_pagesDone;?></td>
  </tr>
<?php }?>
</table>                   
  <?php }?>                               
                                </div>
                            </div><!-- /.nav-tabs-custom -->

                            <!-- Chat box --><!-- /.box (chat box) -->                                                        

                            <!-- TO DO List --><!-- /.box -->

                            <!-- quick email widget -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                      
                    </div><!-- /.row (main row) -->

                </section>