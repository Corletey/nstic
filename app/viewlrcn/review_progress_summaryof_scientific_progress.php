<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];


if(isset($message)){echo $message;}

//////////////////////////////////////////////
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
$sqlASubmissionStages="insert into ".$prefix."progress_report_review (`projectID`,`progressID`,`owner_id`,`SignaturePage`,`Abstract`,`SummaryofScientificProgress`,`KeyPersonnelEffort`,`Publications`,`PatentsandLicenses`,`status`,`reviewer_id`)  values('$id','$progressID','$owner_id','0','0','1','0','0','0','new','$sessionusrm_id')";
$mysqli->query($sqlASubmissionStages);	
}

if($totalConcepts and $id){


$wm="select * from ".$prefix."progress_report_review where  owner_id='$owner_id' and status='new' and reviewer_id='$sessionusrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalConcepts and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."progress_report_review  set `SummaryofScientificProgress`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$sessionusrm_id'";
$mysqli->query($sqlASubmissionStages);
}
}



$sqlUsers4="SELECT * FROM ".$prefix."progress_report_summary_progress where `owner_id`='$owner_id'  and  `progressID`='$progressID' order by progressID desc limit 0,1";//conceptID='$conceptID'
$QueryUsers4 = $mysqli->query($sqlUsers4);
$totalUsers4 = $QueryUser4->num_rows;
$rUserInv4=$QueryUsers4->fetch_array();
?>
<div class="tab">
 
  
   <button <?php if($rUConceptStages['SignaturePage']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewProgressReport&id=<?php echo $id;?>'"><?php echo $lang_SignaturePage;?></button>

    <button <?php if($rUConceptStages['Abstract']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewAbstract&id=<?php echo $id;?>'"><?php echo $lang_abstract;?></button>
  
  <button <?php if($rUConceptStages['SummaryofScientificProgress']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewSummaryofScientificProgress')" id="defaultOpen"><?php echo $lang_SummaryofScientificProgress;?> </button>
  
    <button <?php if($rUConceptStages['KeyPersonnelEffort']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewKeyPersonnelEffort&id=<?php echo $id;?>'"><?php echo $lang_KeyPersonnelEffort;?> </button>
    
    <button <?php if($rUConceptStages['Publications']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewPublications&id=<?php echo $id;?>'"><?php echo $lang_Publications;?></button>
    
  


  
 
  
</div>

<div id="reviewSummaryofScientificProgress" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("report_approve_button.php");?>
   
    
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
<strong><?php echo $rUserInv4['patentlicense'];?></strong>
    </div>
  </div>
  
<div class="row success3">

    <div class="col-100">
    
    
    
    
    
    <div id="getpatentlicensediv">
	<?php if($rUserInv4['patentlicense']=='Yes'){?>
    
    <p><?php echo $lang_Providealistofallpatents;?> <em  style="color:#F00;"><?php echo $lang_confidentialinformation;?></em>.</p>
<strong><?php echo $rUserInv4['listofallpatents'];?></strong><br />



<p><?php echo $lang_Indicatethenameofthepatent;?></p>
<strong><?php echo $rUserInv4['nameofthepatent'];?></strong><br />


<p><?php echo $lang_Describeinvention;?></p>
<strong><?php echo $rUserInv4['potentialimportance'];?></strong>
    
    <?php }?>
    </div>
    
    </div>
    </div>
    
      
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
    <br /><?php echo $lang_Providea_detailed_account;?>
<span class="error">*</span></label><br />
<strong><?php echo $rUserInv4['detailed_account_progress'];?></strong>
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_eachspecificaim;?> <span class="error">*</span></label><br />
<strong><?php echo $rUserInv4['listeachspecificaim'];?></strong>
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
    <br /><?php echo $lang_listofanyaims;?> <span class="error">*</span></label><br />
<strong><?php echo $rUserInv4['anyaimsdiscontinued'];?></strong>
    </div>
  </div>

  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_Newaimsornovelfindings;?>  <span class="error">*</span></label><br />
<strong><?php echo $rUserInv4['newnovelfindings'];?></strong>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_majorresearchmilestones;?>  <span class="error">*</span></label><br />
<strong><?php echo $rUserInv4['majorresearchmilestones'];?></strong>
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_listofnextquarter;?>  <span class="error">*</span></label><br />
<strong><?php echo $rUserInv4['nextQuarterResearchGoals'];?></strong>
    </div>
  </div>
  
  <div class="row" style="padding-top:5px;">
<!--  
  The text should focus on the research support provided by this grant and not include results obtained from funding by other grants or agencies.

Do not exceed 5 pages; number any additional pages as 3a, 3b, 3c, etc.

(Collaborative Grants must submit one combined Progress Report.)

(See Section on individual program reporting requirements in the grants management manual.)
-->
  
  
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