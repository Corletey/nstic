<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];
if(isset($message)){echo $message;}

$sqlUsers2="SELECT * FROM ".$prefix."progress_report_signature_page where `progressID`='$id' order by progressID desc limit 0,1";//conceptID='$conceptID'
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();
$progressID=$rUserInv2['progressID'];

$owner_id=$rUserInv2['owner_id'];
$wConceptStages="select * from ".$prefix."progress_report_review where  reviewer_id='$sessionusrm_id' and status='new' order by id desc";
$cmConceptStages = $mysqli->query($wConceptStages);
$totalConcepts = $cmConceptStages->num_rows;
$rUConceptStages=$cmConceptStages->fetch_array();
if(!$totalConcepts and $id){
$sqlASubmissionStages="insert into ".$prefix."progress_report_review (`projectID`,`progressID`,`owner_id`,`SignaturePage`,`Abstract`,`SummaryofScientificProgress`,`KeyPersonnelEffort`,`Publications`,`PatentsandLicenses`,`status`,`reviewer_id`)  values('$id','$progressID','$owner_id','','1','0','0','0','0','new','$sessionusrm_id')";
$mysqli->query($sqlASubmissionStages);	
}

if($totalConcepts and $id){


$wm="select * from ".$prefix."progress_report_review where  owner_id='$owner_id' and status='new' and reviewer_id='$sessionusrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."progress_report_review  set `Abstract`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$sessionusrm_id'";
$mysqli->query($sqlASubmissionStages);
}
}

?>
<div class="tab">
 
  
   <button <?php if($rUConceptStages['SignaturePage']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewProgressReport&id=<?php echo $id;?>'"><?php echo $lang_SignaturePage;?></button>

    <button <?php if($rUConceptStages['Abstract']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'reviewAbstract')" id="defaultOpen"><?php echo $lang_abstract;?></button>
  
  <button <?php if($rUConceptStages['SummaryofScientificProgress']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewSummaryofScientificProgress&id=<?php echo $id;?>'"><?php echo $lang_SummaryofScientificProgress;?> </button>
  
    <button <?php if($rUConceptStages['KeyPersonnelEffort']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewKeyPersonnelEffort&id=<?php echo $id;?>'"><?php echo $lang_KeyPersonnelEffort;?> </button>
    
    <button <?php if($rUConceptStages['Publications']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewPublications&id=<?php echo $id;?>'"><?php echo $lang_Publications;?></button>
    
   


  
 
  
</div>

<div id="reviewAbstract" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("report_approve_button.php");?>
   
    
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
<strong><?php echo $rUserInv2['briefoverview'];?></strong>

    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
    <br /><?php echo $lang_degreetowhich;?> <?php echo $lang_provideAbstract;?>
<span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['degree_stated_project'];?></strong>
 
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
    <br /><?php echo $lang_barriers;?> <span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['barriers'];?></strong>

    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
    <br /><?php echo $lang_majoraccomplishments;?>; <span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['summarymajorAccomplishments'];?></strong>

    </div>
  </div>

  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_plansforcontinuation;?>  <span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['plansforContinuation'];?></strong>

    </div>
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