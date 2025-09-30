<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];
if($_POST['doSaveData'] and $_POST['projectID'] and $sessionusrm_id){

	//briefoverview, degreeStatedProject, barriers, summarymajorAccomplishments, plansforContinuation
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$briefoverview=$mysqli->real_escape_string($_POST['briefoverview']);
	$degreeStatedProject=$mysqli->real_escape_string($_POST['degreeStatedProject']);
	$barriers=$mysqli->real_escape_string($_POST['barriers']);
	$summarymajorAccomplishments=$mysqli->real_escape_string($_POST['summarymajorAccomplishments']);
	$plansforContinuation=$mysqli->real_escape_string($_POST['plansforContinuation']);

//$sessionusrm_id

$sqlUsers="SELECT * FROM ".$prefix."progress_report_signature_page where `owner_id`='$sessionusrm_id' and `projectID`='$projectID' and `is_sent`='0' order by progressID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();


if($totalUsers){
$sqlA2="update ".$prefix."progress_report_signature_page  set `briefoverview`='$briefoverview',`degree_stated_project`='$degreeStatedProject',`barriers`='$barriers',`summarymajorAccomplishments`='$summarymajorAccomplishments',`plansforContinuation`='$plansforContinuation' where `projectID`='$projectID' and `owner_id`='$sessionusrm_id' and `is_sent`='0'";
$mysqli->query($sqlA2);
$message='<p class="success">Dear '.$session_fullname.', details have been submitted.</p>';


logaction("$session_fullname updated Progress Report for project ID: $projectID");	








$wm="select * from ".$prefix."progress_report_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();

if($totalStages and $mysqli->query($sqlA2)){
$sqlASubmissionStages="update ".$prefix."progress_report_stages  set `Abstract`='1' where `owner_id`='$sessionusrm_id' and status='new'";
$mysqli->query($sqlASubmissionStages);
}
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=SummaryofScientificProgress'>";
	
}

}//end post



if(isset($message)){echo $message;}

$sqlUsers2="SELECT * FROM ".$prefix."progress_report_signature_page where `owner_id`='$sessionusrm_id'  and  `is_sent`='0' order by progressID desc limit 0,1";//conceptID='$conceptID'
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();



$wConceptStages="select * from ".$prefix."progress_report_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
///Get p

?>
<div class="tab">
 
  
   <button <?php if($rUConceptStages['SignaturePage']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=submitProgressReport&id=<?php echo $id;?>'"><?php echo $lang_SignaturePage;?></button>

    <button <?php if($rUConceptStages['Abstract']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'Abstract')" id="defaultOpen"><?php echo $lang_abstract;?></button>
  
  <button <?php if($rUConceptStages['SummaryofScientificProgress']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SummaryofScientificProgress&id=<?php echo $id;?>'"><?php echo $lang_SummaryofScientificProgress;?> </button>
  
    <button <?php if($rUConceptStages['KeyPersonnelEffort']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=KeyPersonnelEffort&id=<?php echo $id;?>'"><?php echo $lang_KeyPersonnelEffort;?> </button>
    
    <button <?php if($rUConceptStages['Publications']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=Publications&id=<?php echo $id;?>/'"><?php echo $lang_Publications;?></button>
    
   


  
 
  
</div>

<div id="Abstract" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("progressreport_submit_now_final_button.php");?>
   
    
  <h3><?php echo $lang_abstract;?></h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $sessionusrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserInv2['projectID'];?>" >

 <div class="container"><!--begin-->
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>



  
   <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_provideAbstract;?>
<span class="error">*</span></label><br />
<textarea id="MyTextBox14" name="briefoverview" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['briefoverview'];?></textarea>
<p id="countermm">Characters limit: <span  id="countercol">300 words</span></p> 
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
    <br /><?php echo $lang_degreetowhich;?>
<span class="error">*</span></label><br />
<textarea id="MyTextBox13" name="degreeStatedProject" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['degree_stated_project'];?></textarea>
<p id="countermm">Characters limit: <span  id="countercol">250 words</span></p> 
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
    <br /><?php echo $lang_barriers;?> <span class="error">*</span></label><br />
<textarea id="MyTextBoxmm300" name="barriers" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['barriers'];?></textarea>
<p id="countermm">Characters limit: <span  id="countercol">300 words</span></p> 
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
    <br /><?php echo $lang_majoraccomplishments;?> <span class="error">*</span></label><br />
<textarea id="MyTextBoxmm3001" name="summarymajorAccomplishments" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['summarymajorAccomplishments'];?></textarea>
<p id="countermm">Characters limit: <span  id="countercol">300 words</span></p> 
    </div>
  </div>

  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_plansforcontinuation;?>  <span class="error">*</span></label><br />
<textarea id="MyTextBoxmm3002" name="plansforContinuation" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['plansforContinuation'];?></textarea>
<p id="countermm">Characters limit: <span  id="countercol">300 words</span></p> 
    </div>
  </div>
  
  <div class="row" style="padding-top:5px;">
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