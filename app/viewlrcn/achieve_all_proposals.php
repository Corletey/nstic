  <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> <?php echo $lang_home;?></a></li>
                        <li class="active">Access Achieve</li>
                    </ol>
                </section>

<section class="content">




                    <!-- Main row -->
                    <div class="row success">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">                            


                            <!-- Custom tabs (Charts with tabs)-->
                          <div class="nav-tabs-custom">
                              
                                 <?php
                                  if($session_usertype=='superadmin' || $session_usertype=='admin'){?>
                                    <!-- Tabs within a box -->
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active"><a href="#revenue-chart" data-toggle="tab">+</a></li>
                                    <li class="pull-left header"><i class="fa fa-inbox"></i> NSTIP 2014/2015</li>
                                </ul>
                                <div class="tab-content">
                                
                                <div class="statspage">


<div class="statbox1"><h2>Rejected Concepts<br> <span>[<?php RejectedAchieved();?>]</span> </h2></div>
<div class="statbox2"><h2><a href="./main.php?option=achieve">Reviewed Concepts<br> <span>[<?php ReviewedAchieved();?>]</span> </a></h2></div>
<div class="statbox3"><h2><a href="./main.php?option=achieve">Unassigned Concepts<br> <span>[<?php UnassignedAchieved();?>] </span></a> </h2></div> 
<div class="statbox4"><h2><a href="./main.php?option=achievepropsubmitted">PROPOSALS SUBMITTED<br> <span>[<?php TotalAchieved();?>] </span></a> </h2></div>
</div>

                                
                                 <?php AchieveGenerateCategories();?>
                                 <?php AchievedConferences();?>
                                 </div>
                                 <?php }?>
                          
                                 
                                 
                                
                            </div><!-- /.nav-tabs-custom -->

                            <!-- Chat box --><!-- /.box (chat box) -->                                                        

                            <!-- TO DO List --><!-- /.box -->

                            <!-- quick email widget -->
                        </section><!-- /.Left col -->
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                      
                    </div><!-- /.row (main row) -->

                </section>