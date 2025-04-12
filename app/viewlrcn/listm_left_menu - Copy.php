                   <?php
                   if($session_usertype=='superadmin'){?>
                   
                   <li class="active">
                            <a href="./main.php?option=dashboard">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        
                        
                        <?php /*?> <li>
                            <a href="./main.php?option=achieve/" style="color:#06F;">
                         <i class="fa fa-th"></i> <span>NSTIP 2014/15</span> <small class="badge pull-right bg-green"><?php //AchieveConcepts();?></small>
                            </a>
                        </li>
                        <li>
                            <a href="./main.php?option=completeval/2017" style="color:#06F;">
                         <i class="fa fa-th"></i> <span>NSTIP 2018/19</span> <small class="badge pull-right bg-green"><?php AllNewConcepts();?></small>
                            </a>
                        </li>
                    <?php */?>
                        <?php
						//if($id){
						?>
                           
                      <?php /*?> <h5 style="padding-left:15px; color:#000000;"><strong>Concepts</strong></h5> 
                  
                        <li>
                            <a href="./main.php?option=dashboard/">
                         <i class="fa fa-th"></i> <span>New Concepts Submissions</span> <small class="badge pull-right bg-green"><?php NewConcepts();?></small>
                            </a>
                        </li>
                        
                    
                       <li>
                            <a href="./main.php?option=pendingeval/">
                         <i class="fa fa-th"></i> <span>Pending Concepts</span> <small class="badge pull-right bg-maroon"><?php PendingEvaluationTotals();?></small>
                            </a>
                        </li>
                        
                        
                                        <li>
                            <a href="./main.php?option=rejected/">
                         <i class="fa fa-th"></i> <span> Rejected Concepts</span> <small class="badge pull-right bg-red"><?php rejectedconceptsDisp();?></small>
                            </a>
                        </li>      
                        
                        
                        
                                        <li>
                            <a href="./main.php?option=approvedfr/">
                         <i class="fa fa-th"></i> <span> <?php echo $lang_ApprovedforReview;?></span> <small class="badge pull-right bg-aqua"><?php ApprovedforReviewDisp();?></small>
                            </a>
                        </li>   
                          
                          <li>
                            <a href="./main.php?option=forwaded/">
                         <i class="fa fa-th"></i> <span> Forwaded Concepts</span> <small class="badge pull-right bg-green"><?php FowardedconceptsDisp();?></small>
                            </a>
                        </li> 
                        
                         
                        
                        
                            <li>
                            <a href="./main.php?option=completeval/">
                         <i class="fa fa-th"></i> <span>Reviewed Concepts</span> <small class="badge pull-right bg-blue"> <?php CompletedEvaluationTotals();?></small>
                            </a>
                        </li> 
                      
                        
                        <?php */?>
                        
                         
                  <?php /*?>
                        <h5 style="padding-left:15px; color:#000000;"><strong>Proposals</strong></h5>
                        
                         <li>
                            <a href="./main.php?option=RequestsProposals/">
                         <i class="fa fa-th"></i> <span>Requests for full Proposals</span> <small class="badge pull-right bg-green"><?php NotifiedforProposals();?></small>
                            </a>
                        </li><?php */?>
                        
                         <li>
                            <a href="./main.php?option=dashboard/"><!--pdashboard-->
                         <i class="fa fa-th"></i> <span>New Proposal Submissions</span> <small class="badge pull-right bg-green"><?php NewSubmissions();?></small>
                            </a>
                        </li>
                        
                         <li>
                            <a href="./main.php?option=admpendingeval/">
                         <i class="fa fa-th"></i> <span>Pending Proposals</span> <small class="badge pull-right bg-maroon"><?php PendingEvaluationTotalsPropals();?></small>
                            </a>
                        </li>
                       <li>
                            <a href="./main.php?option=admprejected/">
                         <i class="fa fa-th"></i> <span> Rejected Proposals</span> <small class="badge pull-right bg-red"><?php rejectedProposalsDisp();?></small>
                            </a>
                        </li>      
                        
                        <li>
                            <a href="./main.php?option=admpapprovedfr/">
                         <i class="fa fa-th"></i> <span> <?php echo $lang_ApprovedforReview;?></span> <small class="badge pull-right bg-aqua"><?php ApprovedforReviewDispProposal();?></small>
                            </a>
                        </li>   
                        
                        
                            <li>
                            <a href="./main.php?option=propforwaded/">
                         <i class="fa fa-th"></i> <span> Forwaded Proposals</span> <small class="badge pull-right bg-green"><?php FowardedProposalDisp();?></small>
                            </a>
                        </li> 
                           <li>
                            <a href="./main.php?option=adpcompleteval/">
                         <i class="fa fa-th"></i> <span>Reviewed Proposals</span> <small class="badge pull-right bg-blue"> <?php CompletedEvaluationTotalsProposals();?></small>
                            </a>
                        </li>            
                        <?php
				   }//end
						?> 
                       <li>
                            <a href="./main.php?option=ReviewerAssigned/">
                         <i class="fa fa-th"></i> <span>Reviewer Summary</span> <small class="badge pull-right bg-blue"></small>
                            </a>
                        </li>
                        
                       <li>
                            <a href="./main.php?option=report/">
                         <i class="fa fa-th"></i> <span>Reports</span> <small class="badge pull-right bg-blue"></small>
                            </a>
                        </li>
                    
              
                        
                        <li class="treeview">
                            <a href="./main.php?option=admins/">
                                <i class="fa fa-edit"></i> <span>Manage Admins <strong>[<?php TotalAdminsYR();?>]</strong> </span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                    
                        </li>
                          <li class="treeview">
                            <a href="./main.php?option=reviewers/">
                                <i class="fa fa-edit"></i> <span>Manage Reviewers <strong>[<?php TotalReviewersYR();?>]</strong> </span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                    
                        </li>
               <li class="treeview">
                            <a href="./main.php?option=users/">
                                <i class="fa fa-edit"></i> <span>Manage Applicants <strong>[<?php TotalApplicantsYR();?>]</strong> </span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                    
                        </li>
                           <li class="treeview">
                            <a href="./main.php?option=logs/">
                                <i class="fa fa-th"></i> <span>Manage Logs</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                    
                        </li><?php //}//end else?>
                           <li>
                            <a href="signout.php">
                     <i class="fa fa-th"></i> <span>Logout</span>
                            </a>
                        </li>
                   
                        <?php //}?>
 
                         <?php
						 echo $session_usertype;
                   if($session_usertype=='reviewer'){?>
                   <li class="active">
                            <a href="./main.php?option=dashboard/">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        
                       <?php /*?> <li>
                            <a href="./main.php?option=pproposals/">
                     <i class="fa fa-th"></i> <span>Pending Concepts</span> <small class="badge pull-right bg-green"><?php MyForwardedProposals();?></small></a> </li>

                           <li>
                            <a href="./main.php?option=ppcoconcepts/">
                                <i class="fa fa-th"></i> <span>Complete Concepts</span> <b  class="badge pull-right bg-red"><?php MyCompletedProposals();?></b></a></li>
                               <?php */?>
                                
                              <li>
                            <a href="./main.php?option=rvproposals/">
                     <i class="fa fa-th"></i> <span>Pending Proposals</span> <small class="badge pull-right bg-blue"><?php MyPendingForwardedConceptsReviwer();?></small></a> </li>

                           <li>
                            <a href="./main.php?option=rvpcoconcepts/">
                                <i class="fa fa-th"></i> <span>Complete Proposals</span> <b  class="badge pull-right bg-aqua"><?php MyCompletedProposalsReviewer();?></b></a></li>   
                                
                        <li>
                            <a href="./main.php?option=MyAccount/">
                     <i class="fa fa-th"></i> <span>My Account</span>
                            </a>
                        </li>
                         <li>
                            <a href="signout.php">
                     <i class="fa fa-th"></i> <span>Logout</span>
                            </a>
                        </li>
                        <?php }?>	
                         <?php
                   if($session_usertype=='user'){?>
                   <li class="active">
                            <a href="./main.php?option=dashboard/">
                                <i class="fa fa-dashboard"></i> <span>Home</span>
                            </a>
                        </li>
                        
<?php
$usrm_username=$_SESSION['usrm_username'];
$usrm_id=$_SESSION['usrm_id'];
$querysrt="select * from ".$prefix."musers where usrm_id='$usrm_id' and usrm_username='$usrm_username'";
$rs_seee=$mysqli->query($querysrt);
$rsuser=$rs_seee->fetch_array();

///check CVS
$querysrtcvs="select * from ".$prefix."concepts_cvs where usrm_id='$usrm_id'";
$rs_seeecvs=$mysqli->query($querysrtcvs);
$totalUsercvs = $rs_seeecvs->num_rows;
$rsusercvs=$rs_seeecvs->fetch_array();

$querysrtcvsall="select * from ".$prefix."concepts_cvs where usrm_id='$usrm_id'";
$rs_seeecvsall=$mysqli->query($querysrtcvsall);
$totalUsercvsall = $rs_seeecvsall->num_rows;

$Now=date("Y-m-d H:i:s");//2017-02-28 23:59:00
//if($Now>='2018-08-18 23:59:00'){}else{

//if($rsuser['sentNotify']=='Yes' and $_SESSION['usrm_username']){?>
<?php if(!$totalUsercvsall){?>
<li>
                            <a href="./main.php?option=SubmitConcept/">
                     <i class="fa fa-edit"></i> <span>Submit Proposal</span>
                            </a>
                        </li><?php }?>
                        
                        <?php if($totalUsercvsall){?>
                          <li>
                            <a href="./main.php?option=MyProposals/">
                     <i class="fa fa-th"></i> <span>View Proposals</span>
                            </a>
                        </li>
                        <li>
                            <a href="./main.php?option=MyCvs/">
                     <i class="fa fa-th"></i> <span>View My Uploaded Cvs</span>
                            </a>
                        </li>
                        <li>
                            <a href="./main.php?option=AddMyCvs/">
                     <i class="fa fa-th"></i> <span>Add New Cvs</span>
                            </a>
                        </li>
                        <?php }?>
                        
                      <li>
                            <a href="./main.php?option=MyAccount/">
                     <i class="fa fa-th"></i> <span>My Account</span>
                            </a>
                        </li>
                         <li>
                            <a href="signout.php">
                     <i class="fa fa-th"></i> <span>Logout</span>
                            </a>
                        </li>
                        <?php }?>	