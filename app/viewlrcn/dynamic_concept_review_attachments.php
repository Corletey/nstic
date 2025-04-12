<?php
///Get project Owner
$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$conceptID'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_concents where  owner_id='$owner_id'  and conceptID='$conceptID' and reviewer_id='$usrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_concents  set `Attachments`='1' where `owner_id`='$owner_id'  and conceptID='$conceptID' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}

$sqlUsers2="SELECT * FROM ".$prefix."introduction_concept where `owner_id`='$owner_id' and `conceptID`='$conceptID' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."review_concents where reviewer_id='$sessionusrm_id' and reviewer_id='$usrm_id'  and conceptID='$conceptID'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?><div class="tab">
<?php require_once("dynamic_categories.php");?>

<?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewProjectInformation&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
 
<?php if($total_Team){?> <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptPrincipalInvestigator&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newReviewconceptIntroduction')" id="defaultOpen"><?php echo $lang_new_Introduction;?></button><?php }?>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptProjectDetails&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newReviewconceptBudget&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptReferences&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
<?php if($total_Attachments){?><button <?php if($rUConceptStages['Attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptAttachments&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_ViewAttachment;?> </button><?php }?>
</div>

<div id="newReviewconceptIntroduction" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?> 
   
  <h3><?php echo $lang_ViewAttachment;?></h3>

 
 <div class="container"><!--begin-->
 
 <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  
  <div class="row success">

  <table class="table table-striped table-sm" id="customers">
                  <thead>
                          <tr>
                            <th><?php echo $lang_new_Attachments;?></th>
                            <th><?php echo $lang_Category;?></th>
                            <th><?php echo $lang_Updatedon;?></th>
                     
                          </tr>
                        </thead>
                        <tbody>
                        <?php
		
//if no page var is given, set start to 0
 $sql = "select * FROM ".$prefix."concept_attachments where `owner_id`='$owner_id' and `conceptID`='$conceptID' order by id desc";//informed concent
$result = $mysqli->query($sql);
while($rInvestigator=$result->fetch_array()){
	?>
                          <tr>
                            <td><a href="<?php echo $base_url;?>files/<?php echo $rInvestigator['filename'];?>" target="_blank"><?php echo $lang_ViewAttachment;?></a></td>
                            <td><?php if($rInvestigator['attachmentCategory']=='concept'){ echo $lang_Concepts;}?>
                            <?php if($rInvestigator['attachmentCategory']=='cv'){ echo $lang_CVSofTeamMembers;}?>
                            <?php if($rInvestigator['attachmentCategory']=='workplan'){ echo $lang_WorkPlan;}?>
                            <?php if($rInvestigator['attachmentCategory']=='budget'){ echo $lang_Budget;}?></td>
                            <td><?php echo $rInvestigator['updated'];?></td>
                          </tr>
   <?php }///////////end function ?>                 
                        </tbody>
                      </table>
  </div>
  
  
</div><!--End-->







</div>


<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script><?php }?>