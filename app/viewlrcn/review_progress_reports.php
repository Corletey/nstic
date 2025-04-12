<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];



if(isset($message)){echo $message;}

$sqlUsers2="SELECT * FROM ".$prefix."progress_report_signature_page where `progressID`='$id' order by progressID desc limit 0,1";//conceptID='$conceptID'
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();
$progressID=$rUserInv2['progressID'];
$progressID=$rUserInv2['progressID'];

$shcategoryID12=$rUserInv2['projectQuarter'];
$categoryChunksss = explode(",", $shcategoryID12);

$chops1="$categoryChunksss[0]";
$chops2="$categoryChunksss[1]";
$chops3="$categoryChunksss[2]";
$chops4="$categoryChunksss[3]";
$chops5="$categoryChunksss[4]";
$chops6="$categoryChunksss[5]";
$chops7="$categoryChunksss[6]";
$chops8="$categoryChunksss[7]";

$owner_id=$rUserInv2['owner_id'];
$wConceptStages="select * from ".$prefix."progress_report_review where  reviewer_id='$sessionusrm_id' and status='new' order by id desc";
$cmConceptStages = $mysqli->query($wConceptStages);
$totalConcepts = $cmConceptStages->num_rows;
$rUConceptStages=$cmConceptStages->fetch_array();
if(!$totalConcepts and $id){
$sqlASubmissionStages="insert into ".$prefix."progress_report_review (`projectID`,`progressID`,`owner_id`,`SignaturePage`,`Abstract`,`SummaryofScientificProgress`,`KeyPersonnelEffort`,`Publications`,`PatentsandLicenses`,`status`,`reviewer_id`)  values('$id','$progressID','$owner_id','1','0','0','0','0','0','new','$sessionusrm_id')";
$mysqli->query($sqlASubmissionStages);	
}

if($totalConcepts and $id){


$wm="select * from ".$prefix."progress_report_review where  owner_id='$owner_id' and status='new' and reviewer_id='$sessionusrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."progress_report_review  set `SignaturePage`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$sessionusrm_id'";
$mysqli->query($sqlASubmissionStages);
}
}

?>
<div class="tab">

  <button <?php if($rUConceptStages['SignaturePage']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewProgressReport')" id="defaultOpen"><?php echo $lang_SignaturePage;?></button>
  

    <button <?php if($rUConceptStages['Abstract']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewAbstract&id=<?php echo $id;?>'"><?php echo $lang_abstract;?></button>
  
  <button <?php if($rUConceptStages['SummaryofScientificProgress']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewSummaryofScientificProgress&id=<?php echo $id;?>'"><?php echo $lang_SummaryofScientificProgress;?> </button>
  
    <button <?php if($rUConceptStages['KeyPersonnelEffort']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewKeyPersonnelEffort&id=<?php echo $id;?>'"><?php echo $lang_KeyPersonnelEffort;?> </button>
    
    <button <?php if($rUConceptStages['Publications']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewPublications&id=<?php echo $id;?>'"><?php echo $lang_Publications;?></button>

 
 
  
 
  
</div>

<div id="reviewProgressReport" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("report_approve_button.php");?>
   
    
  <h3>Project Information</h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $sessionusrm_id;?>" >

 <div class="container"><!--begin-->
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>

  <div class="row success">

    <div class="col-100">
    <label for="fname">Project Title <span class="error">*</span></label>

       <?php
$mmprojectID=$rUserInv2['projectID'];
$sqlFeaturedCall = "SELECT * FROM ".$prefix."submissions_proposals where owner_id='$owner_id' and awarded='yes' and projectID='$mmprojectID' order by projectID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
$rFeaturedCall = $queryFeaturedCall->fetch_array();
?>
<strong><?php echo $rFeaturedCall['projectTitle'];?></strong>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
   <label for="lname"><?php echo $lang_ProjectReport;?>  <span class="error">*</span></label><br />
 <input name="projectQuarter[]" type="checkbox" value="1st" <?php if($chops1=='1st' || $chops2=='1st' || $chops3=='1st' || $chops4=='1st' || $chops5=='1st' || $chops6=='1st' || $chops7=='1st' || $chops8=='1st'){?>checked="checked"<?php }?>/> <?php echo $lang_1stQuarter;?><br />
 <input name="projectQuarter[]" type="checkbox" value="2nd" <?php if($chops1=='2nd' || $chops2=='2nd' || $chops3=='2nd' || $chops4=='2nd' || $chops5=='2nd' || $chops6=='2nd' || $chops7=='2nd' || $chops8=='2nd'){?>checked="checked"<?php }?>/> <?php echo $lang_2ndQuarter;?><br />
 <input name="projectQuarter[]" type="checkbox" value="3rd" <?php if($chops1=='3rd' || $chops2=='3rd' || $chops3=='3rd' || $chops4=='3rd' || $chops5=='3rd' || $chops6=='3rd' || $chops7=='3rd' || $chops8=='3rd'){?>checked="checked"<?php }?>/> <?php echo $lang_3rdQuarter;?><br />
 <input name="projectQuarter[]" type="checkbox" value="4th"<?php if($chops1=='4th' || $chops2=='4th' || $chops3=='4th' || $chops4=='4th' || $chops5=='4th' || $chops6=='4th' || $chops7=='4th' || $chops8=='4th'){?>checked="checked"<?php }?>/> <?php echo $lang_4thQuarter;?><br />
 
 <input name="projectQuarter[]" type="checkbox" value="Mid Year Report" <?php if($chops1=='Mid Year Report' || $chops2=='Mid Year Report' || $chops3=='Mid Year Report' || $chops4=='Mid Year Report' || $chops5=='Mid Year Report' || $chops6=='Mid Year Report' || $chops7=='Mid Year Report' || $chops8=='Mid Year Report'){?>checked="checked"<?php }?>/> <?php echo $lang_MidYearReport;?><br />
 
 <input name="projectQuarter[]" type="checkbox" value="Annual Report" <?php if($chops1=='Annual Report' || $chops2=='Annual Report' || $chops3=='Annual Report' || $chops4=='Annual Report' || $chops5=='Annual Report' || $chops6=='Annual Report' || $chops7=='Annual Report' || $chops8=='Annual Report'){?>checked="checked"<?php }?>/> <?php echo $lang_AnnualReport;?><br />
 <input name="projectQuarter[]" type="checkbox" value="Project Closure Report" <?php if($chops1=='Project Closure Report' || $chops2=='Project Closure Report' || $chops3=='Project Closure Report' || $chops4=='Project Closure Report' || $chops5=='Project Closure Report' || $chops6=='Project Closure Report' || $chops7=='Project Closure Report' || $chops8=='Project Closure Report'){?>checked="checked"<?php }?>/> <?php echo $lang_ProjectClosureReport;?><br />
 
 <input name="projectQuarter[]" type="checkbox" value="Accountability Reports" <?php if($chops1=='Accountability Reports' || $chops2=='Accountability Reports' || $chops3=='Accountability Reports' || $chops4=='Accountability Reports' || $chops5=='Accountability Reports' || $chops6=='Accountability Reports' || $chops7=='Accountability Reports' || $chops8=='Accountability Reports'){?>checked="checked"<?php }?>/> <?php echo $lang_AccountabilityReports;?><br />
    </div>
  </div>

  
    <div class="row success">
    <p><?php echo $one_Entry_perRow;?></p>

<table width="100%" border="0" id="POITable" class="customers3">
        <tr>
            <th style="">&nbsp;</th>
            <th><?php echo $lang_Objectives;?></th>
            <th><?php echo $lang_Inputs;?></th>
            <th><?php echo $lang_Activities;?></th>
            <th><?php echo $lang_Outputs;?></th>
            <th><?php echo $lang_Outcomes;?></th>
            <th><?php echo $lang_Impact;?></th>
            <th><?php echo $lang_Assumptions;?></th>
        </tr>
<?php
		 $countm=0;
$sqlUsers23="SELECT * FROM ".$prefix."progress_report where `progressID`='$progressID' order by id desc limit 0,40";//conceptID='$conceptID'
$QueryUsers23 = $mysqli->query($sqlUsers23);
while($rUserInv23=$QueryUsers23->fetch_array()){
	$countm++;
?>
 <tr>
            <td><?php echo $countm;?></td>
<td><?php echo $rUserInv23['Objectives'];?></td>

<td><?php echo $rUserInv23['Inputs'];?></td>

<td><?php echo $rUserInv23['Activities'];?></td>
<td><?php echo $rUserInv23['Outputs'];?></td>

<td><?php echo $rUserInv23['Outcomes'];?></td>
<td><?php echo $rUserInv23['Impact'];?></td>

<td><?php echo $rUserInv23['Assumptions'];?></td>
        </tr>   <?php }?>  

    </table>
    
  </div>
  

  <div class="row success">
    <p><?php echo $one_Attachment_perRow;?></p>

<table width="100%" border="0" id="POITable2" class="customers3">
        <tr>
            <th style="">&nbsp;</th>
            <th><?php echo $lang_nameof_attachment;?></th>
       <th><?php echo $lang_Attachments;?></th>
        </tr>

        
        
                <?php
$count=0;
$sqlUsers24="SELECT * FROM ".$prefix."progress_report_attachments where `progressID`='$progressID' order by id desc limit 0,40";//conceptID='$conceptID'
$QueryUsers24 = $mysqli->query($sqlUsers24);
while($rUserInv24=$QueryUsers24->fetch_array()){
	$count++;
?>
 <tr>
            <td><?php echo $count;?></td>
<td><?php echo $rUserInv24['AttachmentName'];?></td>

<td><a href="./files/<?php echo $rUserInv24['Attachment'];?>" target="_blank"><?php echo $rUserInv24['Attachment'];?></a></td>
        </tr>   <?php }?>  
    </table>
    
  </div>
 
 
   </form>
 
 
 
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
</script>