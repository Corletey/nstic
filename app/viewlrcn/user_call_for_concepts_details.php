<?php 
include("viewlrcn/user_dashboard2.php");

$sql = "select * FROM ".$prefix."grantcalls where publish='Yes' and grantID='$id' order by grantID desc limit 0,10";
$result = $mysqli->query($sql);
$total_pages = $result->num_rows;



		  ?>
 <div class="table-responsive">
 <h4 class="niceheaders">Call for Proposals</h4><hr />
                                                <!-- THE MESSAGES -->
                                                <table class="table table-mailbox" width="100%">
                                                    <tr class="unread" style="font-size:13px;">
                                                
                                                        <th width="265" class="small-col"><strong><?php echo $lang_Title;?></strong></th>
                                                        <th width="359" class="time"><strong><?php echo $lang_Call;?></strong></th>
                                                        <th width="216" class="time"><strong><?php echo $lang_EndDate;?></strong></th>
                                                        <th width="219" class="time"><strong><?php echo $lang_Status;?></strong></th>

                                                    </tr>
                                                    <?php if(!$total_pages){?>
                                                      <tr>
                                                        <td class="small-col" colspan="5"><p>No latest calls at the moment, please check back later...</p></td>
                                                    </tr>
                                                    <?php }else{





														 
								while($rFLists2=$result->fetch_array()){
							  //Check whether something was posted
							  $proposal_id=$rFLists2['grantID'];
							  $grantID=$rFLists2['grantID'];
							  $usrrsmyLoggedIdm=$_SESSION['usrm_id'];
							  
$queryDistrictsMain="select * from ".$prefix."submissions_proposals where owner_id='$usrrsmyLoggedIdm' and grantcallID='$proposal_id' and is_sent='1'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$rFListsConcept=$R_DMain->fetch_array();
$totals_R=$R_DMain->num_rows;

////Get concept
$queryDistrictsMain2="select * from ".$prefix."submissions_concepts where owner_id='$usrrsmyLoggedIdm' and invited_for_proposal='invited' and grantcallIDMain='$proposal_id' order by conceptID desc limit 0,1";
$R_DMain2=$mysqli->query($queryDistrictsMain2);	
$rFListsConcept2=$R_DMain2->fetch_array();
$totalFInvited = $R_DMain2->num_rows;

$sqlFListsconcepts4="SELECT * FROM ".$prefix."submissions_concepts where invited_for_proposal='invited' and owner_id='$sessionusrm_id' and grantcallIDMain='$proposal_id'";
$QueryFListconcepts4=$mysqli->query($sqlFListsconcepts4);
$totalFLconcepts4 = $QueryFListconcepts4->num_rows;

							  ?>
                                                   <tr class="unread" style="font-size:13px;">
                                                
                                                        <td width="265" class="small-col"><strong><?php echo $rFLists2['title'];?></strong></td>
                                                        <td width="359" class="time"><strong><?php echo $rFLists2['summary'];?></strong></td>
                                                        <td width="216" class="time"><strong><?php echo $rFLists2['EndDate'];?></strong></td>
                                                        <td width="219" class="time">
           
 
 <?php 
$wGrantCategories1="select * from ".$prefix."grantcall_categories where  grantID='$proposal_id' order by category_number asc limit 0,1";
$cmGrantCategories1 = $mysqli->query($wGrantCategories1);
$rUGrantCategories1=$cmGrantCategories1->fetch_array();
$categoryIDFirst=$rUGrantCategories1['categoryID'];

$queryProposals="select * from ".$prefix."submissions_proposals where owner_id='$usrrsmyLoggedIdm' and grantcallID='$proposal_id'";
$R_DProposals=$mysqli->query($queryProposals);	
$totals_Proposals=$R_DProposals->num_rows;


if($rFLists2['EndDate']>=$today and ($rFLists2['dynamic']=='Yes' || $rFLists2['dynamic']=='No') and !$QueryTitles4->num_rows and $totalFInvited  and $rFLists2['includeconcept']=='Yes'){?> <span  class="button1"><a href="./main.php?option=newSubmitProposal&id=<?php echo $rFLists2['grantID'];?>&categoryID=<?php echo $rUGrantCategories1['categoryID'];?>&conceptID=<?php echo $rFListsConcept2['conceptID'];?>"><?php echo $lang_ApplyNow;?></a></span><br />

<a href="./files/<?php echo $rFLists2['attachment'];?>" target="_blank" style="font-weight:bold;"><?php echo $lang_ViewAttachment;?></a>	
<?php }?>

<?php 
if(($rFLists2['dynamic']=='Yes' || $rFLists2['dynamic']=='No') and !$QueryTitles4->num_rows and $totalFInvited=='0'  and $rFLists2['includeconcept']=='Yes'){?><span class='button4'><?php echo $lang_NotInvitedtoSubmitfullProposal;?></span>	
<?php }?>

<?php if($rFLists2['EndDate']>=$today and ($rFLists2['dynamic']=='Yes' || $rFLists2['dynamic']=='No') and !$QueryTitles4->num_rows and $rFLists2['includeconcept']=='No' and !$totals_Proposals){?> <span  class="button1"><a href="./main.php?option=newSubmitProposal&id=<?php echo $rFLists2['grantID'];?>&categoryID=<?php echo $rUGrantCategories1['categoryID'];?>&conceptID=<?php echo $rFListsConcept2['conceptID'];?>"><?php echo $lang_ApplyNow;?></a></span><br />



<a href="./files/<?php echo $rFLists2['attachment'];?>" target="_blank" style="font-weight:bold;"><?php echo $lang_ViewAttachment;?></a>	
<?php }?>
<?php if($rFLists2['EndDate']>=$today and $rFLists2['dynamic']=='Yes' and $totals_Proposals>=1){ echo "<span class='button3'>$lang_Submitted</span>";}?>
                                                    

<?php if($rFLists2['EndDate']>=$today and $rFLists2['dynamic']=='Yes' and $QueryTitles4->num_rows>=1){ echo "<span class='button2'>Already Submitted</span>";}?>
                                                        
<?php if($rFLists2['EndDate']>=$today and $totals_R and $rFLists2['dynamic']!='Yes'){ echo "<span class='button2'>Already Submitted</span>";}?>

                                                        </td>

                                                    </tr>
                                                  <?php }
								//End Loop?>
                                                  
                                                </table>
              </div><!-- /.table-responsive -->
				   
	  <?php
										
 }
?>
	  