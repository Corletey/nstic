<?php
$conceptm_id=$_GET['conceptID'];
$conceptID=$_GET['conceptID'];
if($_POST['doSaveData'] and $_POST['projectID'] and $_POST['asrmApplctID'] and $id){
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }

$attachment = $session_user_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['GantChart']['name']));
$target = './files/'. basename($session_user_id.preg_replace('/\s+/', '_', $_FILES['GantChart']['name']));
$research_attachment = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['GantChart']['tmp_name']), $target);
$extension = getExtension($attachment);
$extension = strtolower($extension);

$attachment2 = $session_user_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['overallCoordination']['name']));
$target2 = './files/'. basename($session_user_id.preg_replace('/\s+/', '_', $_FILES['overallCoordination']['name']));
$research_attachment2 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['overallCoordination']['tmp_name']), $target2);
$extension = getExtension($attachment2);
$extension = strtolower($extension);
	
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$informationFlow=$mysqli->real_escape_string($_POST['informationFlow']);
	$RiskManagement=$mysqli->real_escape_string($_POST['RiskManagement']);
	//$PossibleRisk=$mysqli->real_escape_string($_POST['PossibleRisk']);echo "Passed2";
	//$MitigationMeasure=$mysqli->real_escape_string($_POST['MitigationMeasure']);
	
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$sqlUsers="SELECT * FROM ".$prefix."project_management where `owner_id`='$asrmApplctID' and `grantID`='$id' order by projectID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."project_management (`projectID`,`owner_id`,`overallCoordination`,`GantChart`,`informationFlow`,`RiskManagement`,`PossibleRisk`,`MitigationMeasure`,`is_sent`,`grantID`) 

values('$projectID','$asrmApplctID','$attachment2','$attachment','$informationFlow','$RiskManagement','$PossibleRisk','$MitigationMeasure','0','$id')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
	
	if($_POST['PossibleRisk']){
	for ($i=0; $i < count($_POST['PossibleRisk']); $i++) {
$PossibleRisk=$_POST['PossibleRisk'][$i];
$MitigationMeasure=$_POST['MitigationMeasure'][$i];

$wm1="select * from ".$prefix."possible_risk where  projectID='$projectID' and PossibleRisk='$PossibleRisk' and MitigationMeasure='$MitigationMeasure' and grantID='$id'";
$cmdwb1 = $mysqli->query($wm1);
if(!$cmdwb1->num_rows){
$Insert_QR2="insert into ".$prefix."possible_risk (`projectmgtID`,`projectID`,`owner_id`,`PossibleRisk`,`MitigationMeasure`,`is_sent`,`grantID`) values ('$record_id','$projectID','$asrmApplctID','$PossibleRisk','$MitigationMeasure','0','$id')";
$mysqli->query($Insert_QR2);
}

}
	}

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to the next Menu</p>';
logaction("$session_fullname added created new protocol");

/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newproposalFollowup&id=$id&categoryID=$categoryID&conceptID=$conceptID';</script>");
*/
}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update
if($_FILES['GantChart']['name'] and $_FILES['overallCoordination']['name']){	
$sqlA2="update ".$prefix."project_management set  `overallCoordination`='$attachment2',`GantChart`='$attachment',`informationFlow`='$informationFlow',`RiskManagement`='$RiskManagement',`PossibleRisk`='$PossibleRisk',`MitigationMeasure`='$MitigationMeasure' where owner_id='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlA2);
}

if($_FILES['GantChart']['name'] and !$_FILES['overallCoordination']['name']){	
$sqlA2="update ".$prefix."project_management set  `GantChart`='$attachment',`informationFlow`='$informationFlow',`RiskManagement`='$RiskManagement',`PossibleRisk`='$PossibleRisk',`MitigationMeasure`='$MitigationMeasure' where owner_id='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlA2);
}

if(!$_FILES['GantChart']['name'] and $_FILES['overallCoordination']['name']){	
$sqlA2="update ".$prefix."project_management set  `overallCoordination`='$attachment2',`informationFlow`='$informationFlow',`RiskManagement`='$RiskManagement',`PossibleRisk`='$PossibleRisk',`MitigationMeasure`='$MitigationMeasure' where owner_id='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlA2);
}
if(!$_FILES['GantChart']['name'] and !$_FILES['overallCoordination']['name']){	
$sqlA2="update ".$prefix."project_management set  `informationFlow`='$informationFlow',`RiskManagement`='$RiskManagement' where owner_id='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlA2);
}

if($_POST['PossibleRisk']){
for ($i=0; $i < count($_POST['PossibleRisk']); $i++) {
$PossibleRisk=$_POST['PossibleRisk'][$i];
$MitigationMeasure=$_POST['MitigationMeasure'][$i];

$sqlUsers2ff="SELECT * FROM ".$prefix."project_management where `owner_id`='$usrm_id' and `grantID`='$id' order by projectID desc limit 0,1";
$QueryUsers2ff = $mysqli->query($sqlUsers2ff);
$rUserInv2ff=$QueryUsers2ff->fetch_array();
$projectmgtID=$rUserInv2ff['projectID'];

$wm1="select * from ".$prefix."possible_risk where  projectID='$projectID' and PossibleRisk='$PossibleRisk' and MitigationMeasure='$MitigationMeasure' and grantID='$id'";
$cmdwb1 = $mysqli->query($wm1);
if(!$cmdwb1->num_rows){
$Insert_QR2="insert into ".$prefix."possible_risk (`projectmgtID`,`projectID`,`owner_id`,`PossibleRisk`,`MitigationMeasure`,`is_sent`,`grantID`) values ('$projectmgtID','$projectID','$asrmApplctID','$PossibleRisk','$MitigationMeasure','0','$id')";
$mysqli->query($Insert_QR2);
}

}
}
/*echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo("<script>location.href = '".$base_url."'main.php?option=newproposalFollowup&id=$id&categoryID=$categoryID&conceptID=$conceptID';</script>");*/
	
}//end


if(!$record_id){$record_idm=$_POST['projectID'];}
if($record_id){$record_idm=$record_id;}		
//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and grantID='$id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."project_stages (`owner_id`,`projectID`,`ProjectInformation`,`Background`,`Methodology`,`ProjectResults`,`ResearchTeam`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`,`grantID`)  values('$asrmApplctID','$record_idm','1','0','0','0','0','1','0','0',now(),'new','$id')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `ProjectManagement`='1' where `owner_id`='$asrmApplctID' and grantID='$id'";
$mysqli->query($sqlASubmissionStages);
}

}//end post



if(isset($message)){echo $message;}
$asrmApplctID2=$usrm_id;
$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `grantcallID`='$id' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();

$sqlUsers2="SELECT * FROM ".$prefix."project_management where `owner_id`='$usrm_id' and `grantID`='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();
$projectID=$rUserInv2['projectID'];

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."project_stages where  owner_id='$sessionusrm_id' and grantID='$id' order by id desc limit 0,1";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
?>
<?php
require("dynamic_categories.php");

?>
<div class="tab">
<?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newSubmitProposal&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectInformation;?> </button><?php }?>
  

<?php if($total_Team){?><button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newproposalResearchTeam&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button><?php }?>
  
<?php if($total_Background){?><button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalBackground&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Background;?> </button><?php }?>
  
<?php if($total_Methodology){?><button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalMethodology&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button><?php }?>
    
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalBudget&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
    
    
    
<?php if($total_Results){?><button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalResults&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectResults;?></button><?php }?>
     
<?php if($total_Management){?><button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'newproposalManagement')" id="defaultOpen"><?php echo $lang_new_ProjectManagement;?></button><?php }?>
    
<?php if($total_Followup){?><button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalFollowup&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectFollowup;?></button><?php }?>
   
<?php if($total_Attachments){?><button <?php if($rUConceptStages['attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newProposalAttachments&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ResearchAttachments;?></button><?php }?>

   
<?php if($total_Citations){?> <button <?php if($rUConceptStages['citations']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newProposalReferences&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
   
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
<div id="newproposalManagement" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("proposal_submit_now_final_button.php");?>
   
    
  <h3><?php echo $lang_new_ProjectManagement;?></h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

 <?php
$sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_k where grantID='$id' and categorym='proposal' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
?>
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>


<?php if($rowsSubmitted_c['overallCoordination_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['overallCoordination'];?> <span class="error">*</span></label>

<?php if(!$rUserInv2['overallCoordination']){?>
<input name="overallCoordination" type="file" class="required" id="overallCoordination" required/>
<?php }?>

<?php if($rUserInv2['overallCoordination']){?>
<input name="overallCoordination" type="file" id="overallCoordination"/>
<br /><a href="./files/<?php echo $rUserInv2['overallCoordination'];?>" target="_blank"><strong><?php echo $lang_ViewAttachment;?></strong></a><?php }?>
    </div>
  </div>
<?php }?>

<?php if($rowsSubmitted_c['GantChart_status']=='Enable'){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['GantChart'];?><span class="error">*</span></label>

<?php if(!$rUserInv2['GantChart']){?>
<input name="GantChart" type="file" class="required" id="ImpactPathwayDiagram" required/>
<?php }?>

<?php if($rUserInv2['GantChart']){?>
<input name="GantChart" type="file" id="ImpactPathwayDiagram"/>
<br /><a href="./files/<?php echo $rUserInv2['GantChart'];?>" target="_blank"><strong><?php echo $lang_ViewAttachment;?></strong></a><?php }?>

    </div>
  </div>
<?php }?>

   <?php if($rowsSubmitted_c['informationFlow_status']=='Enable'){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['informationFlow'];?> <span class="error">*</span></label>
<textarea id="MyTextBox10" name="informationFlow" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['informationFlow'];?></textarea>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['Riskmanagement_status']=='Enable'){?>
 <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['Riskmanagement'];?> <span class="error">*</span></label>
    
    <table width="50%" border="0" id="POITable">
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <th><?php echo $lang_PossibleRisk;?></th>
            <th><?php echo $lang_MitigationMeasure;?>
            </th>
            <th>&nbsp;</th>
            <th></th>
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
if($_GET['del']=='true'){
$impc=$mysqli->real_escape_string($_GET['impc']);
$sqlDelete="DELETE FROM ".$prefix."possible_risk where `owner_id`='$usrm_id' and `grantID`='$id' and id='$impc'";
$mysqli->query($sqlDelete);	
}
$sqlProjectID="SELECT * FROM ".$prefix."possible_risk where `owner_id`='$usrm_id' and `grantID`='$id'";
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
            <td><a href="./main.php?option=newproposalManagement&id=<?php echo $id;?>&categoryID=&conceptID=&impc=<?php echo $rUserProjectID['id'];?>&del=true"  style="background-color:#F00; color:#fff;padding:5px;" onclick="return confirm('Are you sure you want to Delete?');">Delete</a></td>
        </tr>
        <?php }?>
    </table>
    


    </div>
  </div>
  <?php }?>
  
  
  
  
  <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="<?php echo $lang_new_Save;?>">
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