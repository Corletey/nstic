<?php 
include("viewlrcn/user_dashboard2.php");
$sql = "select * FROM ".$prefix."grantcalls where category='concepts' and publish='Yes'  order by grantID desc limit 0,10";
$result = $mysqli->query($sql);
$total_pages = $result->num_rows;
		  ?>
 <div class="table-responsive">
 <h4 class="niceheaders"><?php echo $lang_CallforConcepts;?></h4><hr />
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
                                                        <td class="small-col" colspan="5"><p><?php echo $lang_no_results_displayed;?>...</p></td>
                                                    </tr>
                                                    <?php }else{





														 
								while($rFLists2=$result->fetch_array()){
							  //Check whether something was posted
							  $proposal_id=$rFLists2['grantID'];
							  
$queryDistrictsMain="select * from ".$prefix."submissions_concepts where projectStatus!='Pending Final Submission' and owner_id='$usrrsmyLoggedIdm' and grantcallID='$proposal_id'";
$R_DMain=$mysqli->query($queryDistrictsMain);	
$totals_R=$R_DMain->num_rows;


							  ?>
                                                   <tr class="unread" style="font-size:13px;">
                                                
                                                        <td width="265" class="small-col"><strong><?php echo $rFLists2['title'];?></strong></td>
                                                        <td width="359" class="time"><strong><?php echo $rFLists2['summary'];?></strong></td>
                                                        <td width="216" class="time"><strong><?php echo $rFLists2['EndDate'];?></strong></td>
                                                        <td width="219" class="time">
                                                        <?php if($rFLists2['EndDate']<$today){ echo "<span class='button2'>$lang_CallExpired</span>";}?>

<?php if($rFLists2['EndDate']>=$today and !$totals_R and $rFLists2['dynamic']=='No'){?> <span  class="button1"><a href="./main.php?option=newSubmitConcept&id=<?php echo $rFLists2['grantID'];?>"><?php echo $lang_ApplyNow;?></a></span><br />
														
	<a href="./files/<?php echo $rFLists2['attachment'];?>" target="_blank" style="font-weight:bold;"><?php echo $lang_ViewAttachment;?></a>													
<?php }?>

<?php 

if($rFLists2['EndDate']>=$today and !$totals_R and $rFLists2['dynamic']=='Yes' and $rFLists2['end_review']=='No'){?> <span  class="button1"><a href="./main.php?option=newSubmitConcept&id=<?php echo $rFLists2['grantID'];?>"><?php echo $lang_ApplyNow;?></a></span><br />
														
	<a href="./files/<?php echo $rFLists2['attachment'];?>" target="_blank" style="font-weight:bold;"><?php echo $lang_ViewAttachment;?></a>													
<?php }?>


<?php if($rFLists2['EndDate']>=$today and $rFLists2['dynamic']=='Yes' and $totals_R>=1){ echo "<span class='button2'>$lang_Submitted</span>";}?>
                                                        
<?php if($rFLists2['EndDate']>=$today and $totals_R and $rFLists2['dynamic']!='Yes'){ echo "<span class='button2'>$lang_Submitted</span>";}?>
                                                        </td>

                                                    </tr>
                                                  <?php } //End Loop?>
                                                  
                                                </table>
              </div><!-- /.table-responsive -->
				   
	  <?php

 }
?>
	  