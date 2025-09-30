<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];

if($_POST['doSaveData'] and $_POST['projectID'] and $_POST['progressID'] and $sessionusrm_id){

	//briefoverview, degreeStatedProject, barriers, summarymajorAccomplishments, plansforContinuation
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$progressID=$mysqli->real_escape_string($_POST['progressID']);
	$patentlicense=$mysqli->real_escape_string($_POST['patentlicense']);
	$listofallpatents=$mysqli->real_escape_string($_POST['listofallpatents']);
	$nameofthepatent=$mysqli->real_escape_string($_POST['nameofthepatent']);
	$potentialimportance=$mysqli->real_escape_string($_POST['potentialimportance']);
	$detailed_account_progress=$mysqli->real_escape_string($_POST['detailed_account_progress']);
	$listeachspecificaim=$mysqli->real_escape_string($_POST['listeachspecificaim']);
	$anyaimsdiscontinued=$mysqli->real_escape_string($_POST['anyaimsdiscontinued']);
	$newnovelfindings=$mysqli->real_escape_string($_POST['newnovelfindings']);
	$majorresearchmilestones=$mysqli->real_escape_string($_POST['majorresearchmilestones']);
	$nextQuarterResearchGoals=$mysqli->real_escape_string($_POST['nextQuarterResearchGoals']);

//$sessionusrm_id

$sqlUsers="SELECT * FROM ".$prefix."progress_report_summary_progress where `owner_id`='$sessionusrm_id' and `projectID`='$projectID' and `is_sent`='0' order by id desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

if(!$totalUsers){
$sqlA2="insert into ".$prefix."progress_report_summary_progress (`progressID`,`projectID`,`owner_id`,`patentlicense`,`listofallpatents`,`nameofthepatent`,`potentialimportance`,`detailed_account_progress`,`listeachspecificaim`,`anyaimsdiscontinued`,`newnovelfindings`,`majorresearchmilestones`,`nextQuarterResearchGoals`,`is_sent`) 

values('$progressID','$projectID','$sessionusrm_id','$patentlicense','$listofallpatents','$nameofthepatent','$potentialimportance','$detailed_account_progress','$listeachspecificaim','$anyaimsdiscontinued','$newnovelfindings','$majorresearchmilestones','$nextQuarterResearchGoals','0')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted.</p>';


$wm="select * from ".$prefix."progress_report_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();

if($totalStages and $mysqli->query($sqlA2)){
$sqlASubmissionStages="update ".$prefix."progress_report_stages  set `SummaryofScientificProgress`='1' where `owner_id`='$sessionusrm_id' and status='new'";
$mysqli->query($sqlASubmissionStages);
}


echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=KeyPersonnelEffort'>";

logaction("$session_fullname Submitted Progress Report for project ID: $projectID");
}
}


if($totalUsers){
$sqlA2="update ".$prefix."progress_report_summary_progress  set `patentlicense`='$patentlicense',`listofallpatents`='$listofallpatents',`nameofthepatent`='$nameofthepatent',`potentialimportance`='$potentialimportance',`detailed_account_progress`='$detailed_account_progress',`listeachspecificaim`='$listeachspecificaim',`anyaimsdiscontinued`='$anyaimsdiscontinued',`newnovelfindings`='$newnovelfindings',`majorresearchmilestones`='$majorresearchmilestones',`nextQuarterResearchGoals`='$nextQuarterResearchGoals' where `projectID`='$projectID' and `owner_id`='$sessionusrm_id' and `is_sent`='0'";
$mysqli->query($sqlA2);
$message='<p class="success">Dear '.$session_fullname.', details have been submitted.</p>';


logaction("$session_fullname updated Progress Report for project ID: $projectID");	








$wm="select * from ".$prefix."progress_report_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();

if($totalStages and $mysqli->query($sqlA2)){
$sqlASubmissionStages="update ".$prefix."progress_report_stages  set `SummaryofScientificProgress`='1' where `owner_id`='$sessionusrm_id' and status='new'";
$mysqli->query($sqlASubmissionStages);
}

echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=KeyPersonnelEffort'>";
	
}

}//end post



if(isset($message)){echo $message;}

$sqlUsers2="SELECT * FROM ".$prefix."progress_report_summary_progress where `owner_id`='$sessionusrm_id'  and  `is_sent`='0' order by progressID desc limit 0,1";//conceptID='$conceptID'
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();



$wConceptStages="select * from ".$prefix."progress_report_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
///Get p

$sqlUsersee="SELECT * FROM ".$prefix."progress_report_signature_page where `owner_id`='$sessionusrm_id'  and  `is_sent`='0' order by progressID desc limit 0,1";//conceptID='$conceptID'
$QueryUsersee = $mysqli->query($sqlUsersee);
$rUserInvee=$QueryUsersee->fetch_array();

?>
<div class="tab">
 
  
   <button <?php if($rUConceptStages['SignaturePage']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=submitProgressReport&id=<?php echo $id;?>'"><?php echo $lang_SignaturePage;?></button>

    <button <?php if($rUConceptStages['Abstract']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=Abstract&id=<?php echo $id;?>'"><?php echo $lang_abstract;?></button>
  
  <button <?php if($rUConceptStages['SummaryofScientificProgress']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'SummaryofScientificProgress')" id="defaultOpen"><?php echo $lang_SummaryofScientificProgress;?> </button>
  
    <button <?php if($rUConceptStages['KeyPersonnelEffort']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=KeyPersonnelEffort&id=<?php echo $id;?>'"><?php echo $lang_KeyPersonnelEffort;?> </button>
    
    <button <?php if($rUConceptStages['Publications']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=Publications&id=<?php echo $id;?>'"><?php echo $lang_Publications;?></button>
    
  


  
 
  
</div>

<div id="SummaryofScientificProgress" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("progressreport_submit_now_final_button.php");?>
   
    
  <h3><?php echo $lang_SummaryofScientificProgress;?></h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $sessionusrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserInvee['projectID'];?>" >
 <input type="hidden" name="progressID" value="<?php echo $rUserInvee['progressID'];?>" >
 <div class="container"><!--begin-->
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>



  
   <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_resultedinapatent;?>
<span class="error">*</span></label><br />
<input name="patentlicense" type="radio" value="No" onChange="getpatentLicense(this.value)" <?php if($rUserInv2['patentlicense']=='No'){?>checked="checked"<?php }?>/> <?php echo $lang_No;?>&nbsp;
<input name="patentlicense" type="radio" value="Yes" onChange="getpatentLicense(this.value)" <?php if($rUserInv2['patentlicense']=='Yes'){?>checked="checked"<?php }?>/> <?php echo $lang_Yes;?>
    </div>
  </div>
  
<div class="row success3">

    <div class="col-100">
    
    
    
    
    
    <div id="getpatentlicensediv">
	<?php if($rUserInv2['patentlicense']=='Yes'){?>
    
    <p><?php echo $lang_Providealistofallpatents;?> <em  style="color:#F00;"><?php echo $lang_confidentialinformation;?></em>.</p>
<textarea name="listofallpatents" id="MyTextBox14" cols="" rows="5" class="form-control required" style="width:100%; border:1px solid #000; margin-top:20px;"><?php echo $rUserInv2['listofallpatents'];?></textarea><br />



<p><?php echo $lang_Indicatethenameofthepatent;?></p>
<textarea name="nameofthepatent" id="MyTextBox12" cols="" rows="5" class="form-control required" style="width:100%; border:1px solid #000; margin-top:20px;"><?php echo $rUserInv2['nameofthepatent'];?></textarea><br />


<p><?php echo $lang_Describeinvention;?></p>
<textarea name="potentialimportance" id="MyTextBox13" cols="" rows="5" class="form-control required" style="width:100%; border:1px solid #000; margin-top:20px;"><?php echo $rUserInv2['potentialimportance'];?></textarea>
    
    <?php }?>
    </div>
    
    </div>
    </div>
    
      
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
    <br /><?php echo $lang_Providea_detailed_account;?>
 
<span class="error">*</span></label><br />
<textarea id="MyTextBoxmm300" name="detailed_account_progress" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['detailed_account_progress'];?></textarea>
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_eachspecificaim;?><span class="error">*</span></label><br />
<textarea id="MyTextBoxmm3001" name="listeachspecificaim" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['listeachspecificaim'];?></textarea>
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
    <br /><?php echo $lang_listofanyaims;?> <span class="error">*</span></label><br />
<textarea id="MyTextBoxmm3002" name="anyaimsdiscontinued" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['anyaimsdiscontinued'];?></textarea>
    </div>
  </div>

  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_Newaimsornovelfindings;?><span class="error">*</span></label><br />
<textarea id="MyTextBox11" name="newnovelfindings" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['newnovelfindings'];?></textarea>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_majorresearchmilestones;?> <span class="error">*</span></label><br />
<textarea id="MyTextBox14" name="majorresearchmilestones" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['majorresearchmilestones'];?></textarea>
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_listofnextquarter;?> <span class="error">*</span></label><br />
<textarea id="MyTextBox14" name="nextQuarterResearchGoals" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['nextQuarterResearchGoals'];?></textarea>
    </div>
  </div>
  
  <div class="row" style="padding-top:5px;">
<!--  
  The text should focus on the research support provided by this grant and not include results obtained from funding by other grants or agencies.

Do not exceed 5 pages; number any additional pages as 3a, 3b, 3c, etc.

(Collaborative Grants must submit one combined Progress Report.)

(See Section on individual program reporting requirements in the grants management manual.)
-->
  
  
  
    <input type="submit" name="doSaveData" value="<?php echo $lang_SaveandNext;?>">
  </div>

</div><!--End-->
 
 
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