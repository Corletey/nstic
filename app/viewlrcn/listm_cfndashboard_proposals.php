  <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
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
                              
                                 <?php
                                  if($session_usertype=='superadmin' || $session_usertype=='admin'){?>
                                    <!-- Tabs within a box -->
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active"><a href="#revenue-chart" data-toggle="tab">+</a></li>
                                    <li class="pull-left header"><i class="fa fa-inbox"></i> Latest Proposal Submissions</li>
                                </ul>
                                <div class="tab-content">
                                 
                                 <?php MyConferences();
								 //SubmittedProposals();?>
                                 </div>
                                 <?php }?>
                          
                                  <?php
                                  if($session_usertype=='reviewer'){?>
                                    <!-- Tabs within a box -->
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active"><a href="#revenue-chart" data-toggle="tab">+</a></li>
                                    <li class="pull-left header"><i class="fa fa-inbox"></i> Latest Proposal Submissions</li>
                                </ul>
                                <div class="tab-content">
                                 
                                 <?php //MysReviewer();?>
                                 <?php PendingMyConferencesReviewer();?>
                                 </div>
                                 <?php }?>
                                 
                                 <?php
                                  if($session_usertype=='user'){?>
                                    <!-- Tabs within a box -->
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active"><a href="#revenue-chart" data-toggle="tab">+</a></li>
                                    <li class="pull-left header"><i class="fa fa-inbox"></i> <?php echo $lang_MySubmissions;?></li>
                                </ul>
                                <div class="tab-content">
                                 
                                 <?php //MysReviewer();?>
                                 <?php MySubmittedConcepts();?>
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