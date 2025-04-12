<?php
$conceptID=$_GET['conceptID'];

if($_POST['doSaveData']=='Save and Next' and $_POST['projectTitle'] and $_POST['asrmApplctID']){

	
	$projectTitle=$mysqli->real_escape_string($_POST['projectTitle']);
	$titleAcronym=$mysqli->real_escape_string($_POST['titleAcronym']);
	$relevantKeywords=$mysqli->real_escape_string($_POST['relevantKeywords']);
	$researchTypeID=$mysqli->real_escape_string($_POST['researchTypeID']);
	$projectDurationID=$mysqli->real_escape_string($_POST['projectDurationID']);
	$HostInstitution=$mysqli->real_escape_string($_POST['HostInstitution']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	$PrincipalInvestigator=$mysqli->real_escape_string($_POST['PrincipalInvestigator']);
	$Totalfunding=$mysqli->real_escape_string($_POST['Totalfunding']);
	$conceptID=$mysqli->real_escape_string($_POST['conceptID']);
	
		////////////////////Get Category
	$sqlCategory="SELECT * FROM ".$prefix."categories where rstug_categoryID='$researchTypeID' order by rstug_categoryName asc";
	$QueryCategory = $mysqli->query($sqlCategory);
	$rUserCategory=$QueryCategory->fetch_array();
	
	//Get call ID
	$sqlUsersCall="SELECT * FROM ".$prefix."grantcalls where category='proposals' order by grantID desc limit 0,1";
		$QueryUsersCall = $mysqli->query($sqlUsersCall);
		$rUserInvCall=$QueryUsersCall->fetch_array();
		$shortacronym=$rUserInvCall['shortacronym'];
		if(!$id){$grantcallID=$rUserInvCall['grantID'];
		
		}
		if($id){$grantcallID=$id;
		}
	
	$sqlUsers2="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$asrmApplctID' order by projectID desc limit 0,1";
		$QueryUsers2 = $mysqli->query($sqlUsers2);
		$totalUsers2 = $QueryUsers2->num_rows;
		$rUserInv2=$QueryUsers2->fetch_array();


$sqlUsers6="SELECT * FROM ".$prefix."submissions_proposals order by projectID desc limit 0,1";
		$QueryUsers6 = $mysqli->query($sqlUsers6);
		$totalUsers6 = $QueryUsers6->num_rows;
		$rUserInv6=$QueryUsers6->fetch_array();
			
if(!$totalUsers6){$serialBegin='0001';}
if($totalUsers6){
$NewserialBegin=$rUserInv6['conceptID']+1;


if($NewserialBegin>=0 and $NewserialBegin<=9)
{$serialBegin='000'.$NewserialBegin;}

if($NewserialBegin>=10 and $NewserialBegin<=99)
{$serialBegin='00'.$NewserialBegin;}

if($NewserialBegin>=100 and $NewserialBegin<=199)
{$serialBegin='0'.$NewserialBegin;}

if($NewserialBegin>=200 and $NewserialBegin<=9000000000)
{$serialBegin=$NewserialBegin;}

}
		//Assign Reference number
$mmCOnecpt=$totalUsers6['conceptID']+1;
$referenceNo="$shortacronym"."-".$grantcallID."-".date("Y")."-"."$serialBegin";



$sqlUsers="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$asrmApplctID' and `is_sent`='0' order by projectID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();
	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."submissions_proposals (`conceptID`,`projectTitle`,`titleAcronym`,`relevantKeywords`,`researchTypeID`,`projectDurationID`,`updatedon`,`owner_id`,`projectCategory`,`projectStatus`,`is_sent`,`HostInstitution`,`rejectComents`,`finalSubmission`,`PrincipalInvestigator`,`Totalfunding`,`conceptm_Times`,`conceptm_Reviewers`,`category`,`projectYears`,`grantcallID`,`creferences`,`referenceNo`,`dynamic`) 

values('$conceptID','$projectTitle','$titleAcronym','$relevantKeywords','$researchTypeID','$projectDurationID',now(),'$asrmApplctID','Proposal','Pending Final Submission','0','$HostInstitution','','Pending Final Submission','$PrincipalInvestigator','$Totalfunding','','','proposal','','$grantcallID','','$referenceNo','No')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new protocol");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalResearchTeam&id=$id'>";


}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update,`PrincipalInvestigator`,`Totalfunding``conceptID`='$conceptID',
$sqlA2="update ".$prefix."submissions_proposals set  `projectTitle`='$projectTitle',`titleAcronym`='$titleAcronym',`relevantKeywords`='$relevantKeywords',`researchTypeID`='$researchTypeID',`projectDurationID`='$projectDurationID',`HostInstitution`='$HostInstitution',`finalSubmission`='Pending Final Submission',`PrincipalInvestigator`='$PrincipalInvestigator',`Totalfunding`='$Totalfunding',`referenceNo`='$referenceNo' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalResearchTeam&id=$id'>";
	
}//end


if(!$record_id){$record_idm=$_POST['projectID'];}
if($record_id){$record_idm=$record_id;}		
//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."project_stages (`owner_id`,`projectID`,`ProjectInformation`,`Background`,`Methodology`,`ProjectResults`,`ResearchTeam`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`)  values('$asrmApplctID','$record_idm','1','0','0','0','0','0','0','0',now(),'new')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `ProjectInformation`='1' where `owner_id`='$asrmApplctID' and status='new'";
$mysqli->query($sqlASubmissionStages);
}

}//end post



if(isset($message)){echo $message;}
$asrmApplctID2=$usrm_id;
$sqlUsers2="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id'  and  `is_sent`='0' order by projectID desc limit 0,1";//conceptID='$conceptID'
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();

///Get concept first
$sqlConcept="SELECT * FROM ".$prefix."submissions_concepts where `owner_id`='$usrm_id' and conceptID='$conceptID'order by conceptID desc limit 0,1";
$QueryConcept = $mysqli->query($sqlConcept);//and grantcallID='$id' 
$rUserConcept=$QueryConcept->fetch_array();
$conceptID=$rUserConcept['conceptID'];

$sqlUsers2mm="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$usrm_id' and conceptID='$conceptID' order by id desc limit 0,1";
$QueryUsers2mm = $mysqli->query($sqlUsers2mm);
$rUserInv2mm=$QueryUsers2mm->fetch_array();

if($totalUsers){
$projectTitle=$rUserInv2['projectTitle'];
$titleAcronym=$rUserInv2['titleAcronym'];
$researchTypeID=$rUserInv2['researchTypeID'];
$Totalfunding=$rUserInv2['Totalfunding'];
$projectDurationID=$rUserInv2['projectDurationID'];
$relevantKeywords=$rUserInv2['relevantKeywords'];
$HostInstitution=$rUserInv2['HostInstitution'];
$conceptID=$rUserConcept['conceptID'];
$mmTotalBudget=$rUserConcept['Totalfunding'];
}
if(!$totalUsers){
$projectTitle=$rUserConcept['projectTitle'];
$titleAcronym=$rUserConcept['titleAcronym'];
$researchTypeID=$rUserConcept['researchTypeID'];
$Totalfunding=$rUserConcept['Totalfunding'];
$projectDurationID=$rUserConcept['projectDurationID'];
$relevantKeywords=$rUserConcept['relevantKeywords'];
$HostInstitution=$rUserInv2['HostInstitution'];
$conceptID=$rUserConcept['conceptID'];
$mmTotalBudget=$rUserInv2mm['TotalSubmitted'];
}

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();

?>
<div class="tab">

  <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'FirstInformation')" id="defaultOpen"><?php echo $lang_new_ProjectInformation;?></button>
  
 <?php if($totalUsers){?> 
    <button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalResearchTeam&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBackground&id=<?php echo $id;?>'">Background </button>
  
    <button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalMethodology&id=<?php echo $id;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalResults&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectResults;?></button>
   
  
  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalManagement&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalFollowup&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
  <?php }?>
  
  
  
  
  <?php if(!$totalUsers){?> 
    <button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?>>Background </button>
  
    <button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> ><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?>><?php echo $lang_new_ProjectResults;?></button>
   
  
  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> ><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> ><?php echo $lang_new_ProjectFollowup;?></button>
  <?php }?>
  
  
</div>

<div id="FirstInformation" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("proposal_submit_now_final_button.php");?>
   
    
  <h3>Project Information</h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserInv2['projectID'];?>" >
  <input type="hidden" name="conceptID" value="<?php echo $conceptID;?>" >
 <div class="container"><!--begin-->
 <p><strong>Important:</strong> You may take the feedback from your preliminary concept note proposal into consideration when developing the full proposal.</p>
  
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Title (max 50 words) - Give the title of your project <span class="error">*</span></label>
      <input type="text" id="MyTextBox50" name="projectTitle" placeholder="Give the title of your project.." class="requiredm" value="<?php echo $projectTitle;?>" required readonly="readonly">
    </div>
  </div>
  <div class="row success">

    <div class="col-100">
    <label for="lname">Short Title or Acronym (20 characters) <span class="error">*</span></label>
      <input type="text" id="MyTextBox20" name="titleAcronym" placeholder="Short Title or Acronym.." class="requiredm" maxlength="10"  value="<?php echo $titleAcronym;?>" required>
    </div>
  </div>

  
    <div class="row success">

    <div class="col-100">
     <label for="lname">Identify the 5 most relevant keywords that represent the scientific basis of your project (max 5 words) <span class="error">*</span></label>
      <input type="text" id="MyTextBox2" name="relevantKeywords" placeholder=".." class="requiredm"  value="<?php echo $relevantKeywords;?>" required>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
     <label for="country">Research and Development foci selection- select the appropriate research, development and innovation focus/foci for your proposal <span class="error">*</span></label>
     
    <select id="country" name="researchTypeID" class="requiredm" required>
    <option value="">Please select from list</option>
       <?php
$sqlCat = "SELECT * FROM ".$prefix."categories order by rstug_categoryName asc";
$queryCat = $mysqli->query($sqlCat);
while($rCat = $queryCat->fetch_array()){
?>
<option value="<?php echo $rCat['rstug_categoryID'];?>" <?php if($rCat['rstug_categoryID']==$researchTypeID){?>selected="selected"<?php }?>><?php echo $rCat['rstug_categoryName'];?></option>
<?php }?>
</select>
    </div>
  </div>
  
<?php /*?>   <div class="row success">

    <div class="col-100">
     <label for="lname">Host Institution  <span class="error">*</span></label>
      <input type="text" id="HostInstitution" name="HostInstitution" placeholder=".." class="required"  value="<?php echo $rUserInv2['HostInstitution'];?>">
    </div>
  </div><?php */?>

  
     <div class="row success">

    <div class="col-100">
    <label for="country">Duration of the project- indicate the duration of the project in months <span class="error">*</span></label>
      <select id="country" name="projectDurationID" class="requiredm" required>
       <?php
$sqlFeaturedCall = "SELECT * FROM ".$prefix."duration order by durationID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
while($rFeaturedCall = $queryFeaturedCall->fetch_array()){
?>
<option value="<?php echo $rFeaturedCall['durationID'];?>" <?php if($rFeaturedCall['durationID']==$projectDurationID){?>selected="selected"<?php }?>><?php echo $rFeaturedCall['duration'];?> <?php echo $rFeaturedCall['durationdesc'];?></option>
<?php }?>
      </select>
    </div>
  </div>
  

  
  <div class="row success">

    <div class="col-100">
     <label for="lname">Total funding applied for  <span class="error">*</span></label>
      <input type="text" id="Totalfunding" name="Totalfunding" placeholder=".." class="requiredm"  value="<?php if(!$totalUsers){echo $rUserInv2mm['TotalSubmitted'];}else{echo $rUserInv2['Totalfunding'];}?>" required >
    </div>
  </div>
  
  <div class="row" style="padding-top:5px;">
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