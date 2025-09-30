<?php
if($_POST['doSaveData']=='Save and Next' and $_POST['Introduction'] and $_POST['asrmApplctID'] and $id){

	
	$Introduction=$mysqli->real_escape_string($_POST['Introduction']);
	$Objectives=$mysqli->real_escape_string($_POST['Objectives']);
	$Expectedoutput=$mysqli->real_escape_string($_POST['Expectedoutput']);
	$Expectedoutcome=$mysqli->real_escape_string($_POST['Expectedoutcome']);
	$Impact=$mysqli->real_escape_string($_POST['Impact']);
	$Economicimpact=$mysqli->real_escape_string($_POST['Economicimpact']);
	$EnvironmentalImpact=$mysqli->real_escape_string($_POST['EnvironmentalImpact']);
	$SocietalImpact=$mysqli->real_escape_string($_POST['SocietalImpact']);
	
	
	$DescribeProjectAlignment=$mysqli->real_escape_string($_POST['DescribeProjectAlignment']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and `is_sent`='0' and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
	
	
	
	$sqlUsers="SELECT * FROM ".$prefix."introduction_concept where `owner_id`='$asrmApplctID' and `is_sent`='0' and grantcallID='$id' order by id desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."introduction_concept (`Introduction`,`Objectives`,`Expectedoutput`,`Expectedoutcome`,`Impact`,`DescribeProjectAlignment`,`updatedon`,`owner_id`,`projectCategory`,`is_sent`,`conceptID`,`Economicimpact`,`EnvironmentalImpact`,`SocietalImpact`,`grantcallID`) 

values('$Introduction','$Objectives','$Expectedoutput','$Expectedoutcome','$Impact','$DescribeProjectAlignment',now(),'$asrmApplctID','Concept','0','$conceptm_id','$Economicimpact','$EnvironmentalImpact','$SocietalImpact','$id')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new protocol");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=conceptProjectDetails'>";	


}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update


$sqlA2="update ".$prefix."introduction_concept set  `Introduction`='$Introduction',`Objectives`='$Objectives',`Expectedoutput`='$Expectedoutput',`Expectedoutcome`='$Expectedoutcome',`Impact`='$Impact',`DescribeProjectAlignment`='$DescribeProjectAlignment',`Economicimpact`='$Economicimpact',`EnvironmentalImpact`='$EnvironmentalImpact',`SocietalImpact`='$SocietalImpact',`conceptID`='$conceptm_id' where owner_id='$asrmApplctID' and is_sent='0' and grantcallID='$id'";
$mysqli->query($sqlA2);

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=conceptProjectDetails&id=$id'>";	
	
}//end



	//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and conceptID='$conceptm_id' and status='new' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `Introduction`='1' where `owner_id`='$asrmApplctID' and `conceptID`='$conceptm_id' and status='new' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}	


}//end post
$sqlUsers2="SELECT * FROM ".$prefix."introduction_concept where `owner_id`='$usrm_id' and `is_sent`='0' and grantcallID='$id' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."concept_stages where  owner_id='$sessionusrm_id' and status='new' and grantcallID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?><div class="tab">

 <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitConcept&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
 
  <button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button>
  
  
    <button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'conceptIntroduction')" id="defaultOpen"><?php echo $lang_new_Introduction;?></button>
    
    
   <button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button>
   
   
  <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=conceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
  
  <button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button>
  <button <?php if($rUConceptStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=conceptAttachments&id=<?php echo $id;?>'">Attachments </button>
</div>

<div id="conceptIntroduction" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <?php include("concept_submit_now_final_button.php");?>
   
  <h3><?php echo $lang_new_Introduction;?></h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">


 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">
 
 <div class="container"><!--begin-->
 
 <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">8. Introduction</label>

      <textarea id="MyTextBoxMM3" name="Introduction" placeholder="Give the title of your project.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Introduction'];?></textarea>
    </div>
  </div>
  <div class="row success">

    <div class="col-100">
    <label for="lname">9. Objectives (Max 100 words)- Explain the aims and objectives of the proposed research within the context of the state-of –the art of the scientific area related to the project.</label>
      <textarea id="MyTextBox4" name="Objectives" placeholder="Objectives.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Objectives'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">100 words</span></p> 
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="lname">10. Expected Output(s), (Max 100 words)</label>
      <textarea id="MyTextBox5" name="Expectedoutput" placeholder="Expected output(s).." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Expectedoutput'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">100 words</span></p> 
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="lname">11. Expected Outcomes(s), (Max 100 words)</label>
      <textarea id="MyTextBox5Exp" name="Expectedoutcome" placeholder="Expected Outcomes(s).." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Expectedoutcome'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">100 words</span></p> 
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">12. Impact (250 Words) <br />
(a) Scientific Impact
</label>
      <textarea id="MyTextBox7" name="Impact" placeholder="Scientific Impact.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Impact'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">250 words</span></p> 
    </div>
  </div>
  
  
  
 <div class="row success">

    <div class="col-100">
    <label for="lname">(b) Economic impact 
</label>
      <textarea id="MyTextBoxmm300" name="Economicimpact" placeholder="Economic impact.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Economicimpact'];?></textarea>
    </div>
  </div>  
  
  
 <div class="row success">

    <div class="col-100">
    <label for="lname">(c) Environmental Impact
</label>
      <textarea id="MyTextBoxmm3001" name="EnvironmentalImpact" placeholder="Environmental Impact.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['EnvironmentalImpact'];?></textarea>
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="lname">(d) Societal impact 
</label>
      <textarea id="MyTextBoxmm3002" name="SocietalImpact" placeholder="Societal Impact.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['SocietalImpact'];?></textarea>
    </div>
  </div>  
      <div class="row success">

    <div class="col-100">
    <label for="lname">13. Describe the project alignment of this project to the National Vision/Development Plan (Max 100 words) (s) 
</label>
      <textarea id="MyTextBox8" name="DescribeProjectAlignment" placeholder="Describe the project alignment of this project to the National Vision/Development Plan.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['DescribeProjectAlignment'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">100 words</span></p> 
    </div>
  </div>
  
  

 

  <div class="row success">
    <input type="submit" name="doSaveData" value="Save and Next">
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