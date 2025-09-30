<?php
if($_POST['doSaveData'] and $_POST['Introduction'] and $_POST['asrmApplctID'] and $id){

	
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
	
	$sqlUsersrr="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$asrmApplctID' and `projectStatus`='Pending Final Submission' and grantcallID='$id' order by conceptID desc limit 0,1";
		$QueryUsersrr = $mysqli->query($sqlUsersrr);
		$rUserInvrr=$QueryUsersrr->fetch_array();
	  $conceptm_id=$rUserInvrr['conceptID'];
	
	
	
	
	$sqlUsers="SELECT * FROM ".$prefix."introduction_concept where `owner_id`='$asrmApplctID' and grantcallID='$id' order by id desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."introduction_concept (`Introduction`,`Objectives`,`Expectedoutput`,`Expectedoutcome`,`Impact`,`DescribeProjectAlignment`,`updatedon`,`owner_id`,`projectCategory`,`is_sent`,`conceptID`,`Economicimpact`,`EnvironmentalImpact`,`SocietalImpact`,`grantcallID`) 

values('$Introduction','$Objectives','$Expectedoutput','$Expectedoutcome','$Impact','$DescribeProjectAlignment',now(),'$asrmApplctID','Concept','0','$conceptm_id','$Economicimpact','$EnvironmentalImpact','$SocietalImpact','$id')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to the next Menu</p>';
logaction("$session_fullname added created new protocol");

/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newconceptProjectDetails/$id';</script>");*/

}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update


$sqlA2="update ".$prefix."introduction_concept set  `Introduction`='$Introduction',`Objectives`='$Objectives',`Expectedoutput`='$Expectedoutput',`Expectedoutcome`='$Expectedoutcome',`Impact`='$Impact',`DescribeProjectAlignment`='$DescribeProjectAlignment',`Economicimpact`='$Economicimpact',`EnvironmentalImpact`='$EnvironmentalImpact',`SocietalImpact`='$SocietalImpact',`conceptID`='$conceptm_id' where owner_id='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlA2);

/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newconceptProjectDetails/$id';</script>");*/
	
}//end



	//Insert into Submission Stages
$wm="select * from ".$prefix."concept_stages where  owner_id='$asrmApplctID' and conceptID='$conceptm_id' and status='new' and grantcallID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages){
$sqlASubmissionStages="update ".$prefix."concept_stages  set `Introduction`='1' where `owner_id`='$asrmApplctID' and grantcallID='$id'";
$mysqli->query($sqlASubmissionStages);
}	


}//end post
$sqlUsers2="SELECT * FROM ".$prefix."introduction_concept where `owner_id`='$usrm_id' and grantcallID='$id' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."concept_stages where  owner_id='$sessionusrm_id' and grantcallID='$id'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?><div class="tab">

<?php require_once("dynamic_categories.php");?>

  <?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newSubmitConcept&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
 
<?php if($total_Team){?><button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newconceptIntroduction')" id="defaultOpen"><?php echo $lang_new_Introduction;?></button><?php }?>
    
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>

<?php if($total_Attachments){?><button <?php if($rUConceptStages['conceptAttachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newconceptAttachments&id=<?php echo $id;?>'"><?php echo $lang_new_Attachments;?> </button><?php }?>
  
  
</div>

<div id="newconceptIntroduction" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
   <?php include("concept_submit_now_final_button.php");?>
   <?php 
  $sqlDynamic="SELECT * FROM ".$prefix."concept_dynamic_questions_all_b where grantID='$id' order by id asc";
	$QueryDynamic = $mysqli->query($sqlDynamic);
	$rowsDynamic=$QueryDynamic->fetch_array();
	?>
   
  <h3><?php echo $lang_new_Introduction;?></h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">


 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">
 
 <div class="container"><!--begin-->
 
 <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  
  <?php if($rowsDynamic['qn_introduction_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsDynamic['qn_introduction'];?></label>

      <textarea id="MyTextBoxMM3" name="Introduction" placeholder="Give the title of your project.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Introduction'];?></textarea>
    </div>
  </div><?php }?>
  
  <?php if($rowsDynamic['qn_objectives_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_objectives'];?></label>
      <textarea id="MyTextBox4" name="Objectives" placeholder="Objectives.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Objectives'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">100 words</span></p> 
    </div>
  </div><?php }?>

<?php if($rowsDynamic['qn_expectedoutput_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_expectedoutput'];?></label>
      <textarea id="MyTextBox5" name="Expectedoutput" placeholder="Expected output(s).." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Expectedoutput'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">100 words</span></p> 
    </div>
  </div><?php }?>
  
  <?php if($rowsDynamic['qn_expectedoutcome_status']=='Enable'){?>
   <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_expectedoutcome'];?></label>
      <textarea id="MyTextBox5Exp" name="Expectedoutcome" placeholder="Expected Outcomes(s).." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Expectedoutcome'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">100 words</span></p> 
    </div>
  </div><?php }?>
  
  <?php if($rowsDynamic['qn_scientific_impact_status']=='Enable'){?>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_scientific_impact'];?>
</label>
      <textarea id="MyTextBox7" name="Impact" placeholder="Scientific Impact.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Impact'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">250 words</span></p> 
    </div>
  </div><?php }?>
  
  
 <?php if($rowsDynamic['qn_environmental_impact_status']=='Enable'){?> 
 <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_Economicimpact'];?> 
</label>
      <textarea id="MyTextBoxmm300" name="Economicimpact" placeholder="Economic impact.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['Economicimpact'];?></textarea>
    </div>
  </div><?php }?>  
  
  <?php if($rowsDynamic['qn_environmental_impact_status']=='Enable'){?>
 <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_environmental_impact'];?>
</label>
      <textarea id="MyTextBoxmm3001" name="EnvironmentalImpact" placeholder="Environmental Impact.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['EnvironmentalImpact'];?></textarea>
    </div>
  </div><?php }?> 
  
  
   <?php if($rowsDynamic['qn_societal_impact_status']=='Enable'){?>
   <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_societal_impact'];?>
</label>
      <textarea id="MyTextBoxmm3002" name="SocietalImpact" placeholder="Societal Impact.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['SocietalImpact'];?></textarea>
    </div>
  </div>  
  <?php }?> 
  
  <?php if($rowsDynamic['qn_describe_project_alignment_status']=='Enable'){?>
      <div class="row success"> 	

    <div class="col-100">
    <label for="lname"><?php echo $rowsDynamic['qn_describe_project_alignment'];?>
</label>
      <textarea id="MyTextBox8" name="DescribeProjectAlignment" placeholder="Describe the project alignment of this project to the National Vision/Development Plan.." style="height:150px" class="requiredm" required><?php echo $rUserInv2['DescribeProjectAlignment'];?></textarea>
      <p id="countermm">Characters limit: <span  id="countercol">100 words</span></p> 
    </div>
  </div><?php }?>
  
  

 

  <div class="row success">
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