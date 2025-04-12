<?php
if($_POST['doSaveData']=='Save and Next' and $_POST['projectID'] and $_POST['asrmApplctID']){
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

$attachment = $session_user_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['GantChart']['name']));
$target = 'files/'. basename($session_user_id.preg_replace('/\s+/', '_', $_FILES['GantChart']['name']));
$research_attachment = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['GantChart']['tmp_name']), $target);
$extension = getExtension($attachment);
$extension = strtolower($extension);

$attachment2 = $session_user_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['overallCoordination']['name']));
$target2 = 'files/'. basename($session_user_id.preg_replace('/\s+/', '_', $_FILES['overallCoordination']['name']));
$research_attachment2 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['overallCoordination']['tmp_name']), $target2);
$extension = getExtension($attachment2);
$extension = strtolower($extension);
	
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$informationFlow=$mysqli->real_escape_string($_POST['informationFlow']);
	$RiskManagement=$mysqli->real_escape_string($_POST['RiskManagement']);
	$PossibleRisk=$mysqli->real_escape_string($_POST['PossibleRisk']);
	$MitigationMeasure=$mysqli->real_escape_string($_POST['MitigationMeasure']);
	
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$sqlUsers="SELECT * FROM ".$prefix."project_management where `owner_id`='$asrmApplctID' and `is_sent`='0' order by projectID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."project_management (`projectID`,`owner_id`,`overallCoordination`,`GantChart`,`informationFlow`,`RiskManagement`,`PossibleRisk`,`MitigationMeasure`,`is_sent`) 

values('$projectID','$asrmApplctID','$attachment2','$attachment','$informationFlow','$RiskManagement','$PossibleRisk','$MitigationMeasure','0')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
	
	for ($i=0; $i < count($_POST['PossibleRisk']); $i++) {
$PossibleRisk=$_POST['PossibleRisk'][$i];
$MitigationMeasure=$_POST['MitigationMeasure'][$i];

$wm1="select * from ".$prefix."possible_risk where  projectID='$projectID' and PossibleRisk='$PossibleRisk' and MitigationMeasure='$MitigationMeasure'";
$cmdwb1 = $mysqli->query($wm1);
if(!$cmdwb1->num_rows){
$Insert_QR2="insert into ".$prefix."possible_risk (`projectmgtID`,`projectID`,`owner_id`,`PossibleRisk`,`MitigationMeasure`,`is_sent`) values ('$record_id','$projectID','$asrmApplctID','$PossibleRisk','$MitigationMeasure','0')";
$mysqli->query($Insert_QR2);
}

}

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new protocol");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalFollowup'>";


}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update
if($_FILES['GantChart']['name'] and $_FILES['overallCoordination']['name']){	
$sqlA2="update ".$prefix."project_management set  `overallCoordination`='$attachment2',`GantChart`='$attachment',`informationFlow`='$informationFlow',`RiskManagement`='$RiskManagement',`PossibleRisk`='$PossibleRisk',`MitigationMeasure`='$MitigationMeasure' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);
}

if($_FILES['GantChart']['name'] and !$_FILES['overallCoordination']['name']){	
$sqlA2="update ".$prefix."project_management set  `GantChart`='$attachment',`informationFlow`='$informationFlow',`RiskManagement`='$RiskManagement',`PossibleRisk`='$PossibleRisk',`MitigationMeasure`='$MitigationMeasure' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);
}

if(!$_FILES['GantChart']['name'] and $_FILES['overallCoordination']['name']){	
$sqlA2="update ".$prefix."project_management set  `overallCoordination`='$attachment2',`informationFlow`='$informationFlow',`RiskManagement`='$RiskManagement',`PossibleRisk`='$PossibleRisk',`MitigationMeasure`='$MitigationMeasure' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);
}
if(!$_FILES['GantChart']['name'] and !$_FILES['overallCoordination']['name']){	
$sqlA2="update ".$prefix."project_management set  `informationFlow`='$informationFlow',`RiskManagement`='$RiskManagement' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);
}

for ($i=0; $i < count($_POST['PossibleRisk']); $i++) {
$PossibleRisk=$_POST['PossibleRisk'][$i];
$MitigationMeasure=$_POST['MitigationMeasure'][$i];

$sqlUsers2ff="SELECT * FROM ".$prefix."project_management where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryUsers2ff = $mysqli->query($sqlUsers2ff);
$rUserInv2ff=$QueryUsers2ff->fetch_array();
$projectmgtID=$rUserInv2ff['projectmgtID'];

$wm1="select * from ".$prefix."possible_risk where  projectID='$projectID' and PossibleRisk='$PossibleRisk' and MitigationMeasure='$MitigationMeasure'";
$cmdwb1 = $mysqli->query($wm1);
if(!$cmdwb1->num_rows){
$Insert_QR2="insert into ".$prefix."possible_risk (`projectmgtID`,`projectID`,`owner_id`,`PossibleRisk`,`MitigationMeasure`,`is_sent`) values ('$projectmgtID','$projectID','$asrmApplctID','$PossibleRisk','$MitigationMeasure','0')";
$mysqli->query($Insert_QR2);
}

}
echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalFollowup'>";
	
}//end


if(!$record_id){$record_idm=$_POST['projectID'];}
if($record_id){$record_idm=$record_id;}		
//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."project_stages (`owner_id`,`projectID`,`ProjectInformation`,`Background`,`Methodology`,`ProjectResults`,`ResearchTeam`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`)  values('$asrmApplctID','$record_idm','1','0','0','0','0','1','0','0',now(),'new')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `ProjectManagement`='1' where `owner_id`='$asrmApplctID' and status='new'";
$mysqli->query($sqlASubmissionStages);
}

}//end post



if(isset($message)){echo $message;}
$asrmApplctID2=$usrm_id;
$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();

$sqlUsers2="SELECT * FROM ".$prefix."project_management where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();
$projectID=$rUserInv2['projectID'];

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<div class="tab">

  <button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SubmitProposal&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  
  <button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalResearchTeam&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBackground&id=<?php echo $id;?>'"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalMethodology&id=<?php echo $id;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=proposalResults&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectResults;?></button>
  
  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'proposalManagement')" id="defaultOpen"><?php echo $lang_new_ProjectManagement;?></button>
  
   <button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalFollowup&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
   
</div>
<script>
function deleteRow(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable').deleteRow(-1);
	//document.getElementById("myTable").deleteRow(0);
}


function insRow()
{
    console.log( 'hi');
    var x=document.getElementById('POITable');
    var new_row = x.rows[1].cloneNode(true);
    var len = x.rows.length;
    new_row.cells[0].innerHTML = len;
    
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.value = '';
	
    var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = '';

	

	
	new_row.cells[3].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
	
}
</script>
<div id="proposalManagement" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("proposal_submit_now_final_button.php");?>
   
    
  <h3>Project management (max. 400 words)</h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Describe how the overall coordination and monitoring management of the project will be implemented. Provide if possible a project organisational chart. Indicate the decision-making bodies and processes foreseen as part of the project execution (decision boards, coordination meetings). <span class="error">(pdf only)</span> <span class="error">*</span></label>

<?php if(!$rUserInv2['overallCoordination']){?>
<input name="overallCoordination" type="file" class="required" id="overallCoordination" required/>
<?php }?>

<?php if($rUserInv2['overallCoordination']){?>
<input name="overallCoordination" type="file" id="overallCoordination"/>
<br /><a href="./files/<?php echo $rUserInv2['overallCoordination'];?>" target="_blank"><strong>Attachment</strong></a><?php }?>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="fname">If appropriate, set up a Gantt chart or detailed diagram giving the time schedule of the tasks and mark their interrelations; add milestones where important goals will be reached and/or decisions on further approach will have to be made; indicate a critical path marking those events which directly influence the overall time schedule in case of delays. Please make assumptions underlying the critical path and the Grant chart. (4 Assumptions) <span class="error">(pdf only)</span><span class="error">*</span></label>

<?php if(!$rUserInv2['GantChart']){?>
<input name="GantChart" type="file" class="required" id="ImpactPathwayDiagram" required/>
<?php }?>

<?php if($rUserInv2['GantChart']){?>
<input name="GantChart" type="file" id="ImpactPathwayDiagram"/>
<br /><a href="./files/<?php echo $rUserInv2['GantChart'];?>" target="_blank"><strong>Gant Chart</strong></a><?php }?>

    </div>
  </div>


    <div class="row success">

    <div class="col-100">
    <label for="fname">Explain how information flow and communication will be enhanced within the project. Provide details of specific planned meetings and exchanges, and highlight factors likely to provide additional value to these communication processes., <span class="error">*</span></label>
<textarea id="MyTextBox10" name="informationFlow" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['informationFlow'];?></textarea>
    </div>
  </div>
  
 <div class="row success">

    <div class="col-100">
    <label for="fname">Risk management: Indicate where there are risks of not achieving the objectives and fall-back positions, if applicable. <span class="error">*</span></label>
    
    <table width="50%" border="0" id="POITable">
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <th>Possible Risk</th>
            <th>Mitigation Measure
            </th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<input type="text" name="PossibleRisk[]" id="vvv" tabindex="4" class="requiredd" minlength="5" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:360px; background:#ffffff;"/>
            </td>
            <td><input type="text" name="MitigationMeasure[]" id="customss2" tabindex="5" class="requiredd" minlength="3" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:360px; background:#ffffff;"/></td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>
        
        <?php 
$sqlProjectID="SELECT * FROM ".$prefix."possible_risk where `owner_id`='$usrm_id' and `projectID`='$projectID'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td>
              <label><?php echo $rUserProjectID['PossibleRisk'];?></label>
            </td>
            <td>
              <label><?php echo $rUserProjectID['MitigationMeasure'];?></label>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php }?>
    </table>
    


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