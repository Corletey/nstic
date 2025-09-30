<?php
if($_POST['doSaveData']=='Save and Next' and $_POST['projectID'] and $_POST['asrmApplctID']){
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 

         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
	
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$ResearchObjective=$mysqli->real_escape_string($_POST['ResearchObjective']);
	$Outputs=$mysqli->real_escape_string($_POST['Outputs']);
	$Outcomes=$mysqli->real_escape_string($_POST['Outcomes']);
	$ImpactCapacityDevelopment=$mysqli->real_escape_string($_POST['ImpactCapacityDevelopment']);
	$ImpactPathwayDiagram=$mysqli->real_escape_string($_POST['ImpactPathwayDiagram']);
	$StakeholderEngagement=$mysqli->real_escape_string($_POST['StakeholderEngagement']);
	$CommunicationWithStakeholders=$mysqli->real_escape_string($_POST['CommunicationWithStakeholders']);
	$ScientificOutput=$mysqli->real_escape_string($_POST['ScientificOutput']);
	

	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	
	$attachment = $session_user_id.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['ImpactPathwayDiagram']['name']));
$target = 'files/'. basename($session_user_id.preg_replace('/\s+/', '_', $_FILES['ImpactPathwayDiagram']['name']));
$research_attachment = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['ImpactPathwayDiagram']['tmp_name']), $target);
$extension = getExtension($attachment);
$extension = strtolower($extension);
	
	$sqlUsers="SELECT * FROM ".$prefix."project_results where `owner_id`='$asrmApplctID' and `is_sent`='0' order by projectID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."project_results (`projectID`,`owner_id`,`ResearchObjective`,`Outputs`,`Outcomes`,`ImpactCapacityDevelopment`,`ImpactPathwayDiagram`,`StakeholderEngagement`,`CommunicationWithStakeholders`,`ScientificOutput`,`ResearchOutputs1`,`ResearchOutputs2`,`ResearchOutputs3`,`ResearchOutputs4`,`ResearchOutputs5`,`ResearchOutputs6`,`ResearchOutputs7`,`ResearchOutputsIndicators1`,`ResearchOutputsIndicators2`,`ResearchOutputsIndicators3`,`ResearchOutputsIndicators4`,`ResearchOutputsIndicators5`,`ResearchOutputsIndicators6`,`ResearchOutputsIndicators7`,`ResearchOutcomes1`,`ResearchOutcomes2`,`ResearchOutcomes3`,`ResearchOutcomes4`,`ResearchOutcomes5`,`ResearchOutcomes6`,`ResearchOutcomes7`,`ResearchOutcomesIndicators1`,`ResearchOutcomesIndicators2`,`ResearchOutcomesIndicators3`,`ResearchOutcomesIndicators4`,`ResearchOutcomesIndicators5`,`ResearchOutcomesIndicators6`,`ResearchOutcomesIndicators7`,`Impact1`,`Impact2`,`Impact3`,`Impact4`,`Impact5`,`Impact6`,`Impact7`,`is_sent`) 

values('$projectID','$asrmApplctID','$ResearchObjective','$Outputs','$Outcomes','$ImpactCapacityDevelopment','$attachment','$StakeholderEngagement','$CommunicationWithStakeholders','$ScientificOutput','$ResearchOutputs1','$ResearchOutputs2','$ResearchOutputs3','$ResearchOutputs4','$ResearchOutputs5','$ResearchOutputs6','$ResearchOutputs7'
,'$ResearchOutputsIndicators1','$ResearchOutputsIndicators2','$ResearchOutputsIndicators3','$ResearchOutputsIndicators4','$ResearchOutputsIndicators5','$ResearchOutputsIndicators6','$ResearchOutputsIndicators7','$ResearchOutcomes1','$ResearchOutcomes2','$ResearchOutcomes3','$ResearchOutcomes4','$ResearchOutcomes5','$ResearchOutcomes6','$ResearchOutcomes7','$ResearchOutcomesIndicators1','$ResearchOutcomesIndicators2','$ResearchOutcomesIndicators3','$ResearchOutcomesIndicators4','$ResearchOutcomesIndicators5','$ResearchOutcomesIndicators6','$ResearchOutcomesIndicators7','$Impact1','$Impact2','$Impact3','$Impact4','$Impact5','$Impact6','$Impact7','0')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
	
	for ($i=0; $i < count($_POST['ResearchOutputs1']); $i++) {
$ResearchOutputs1=$_POST['ResearchOutputs1'][$i];
$ResearchOutputsIndicators1=$_POST['ResearchOutputsIndicators1'][$i];
$ResearchOutcomes1=$_POST['ResearchOutcomes1'][$i];
$ResearchOutcomesIndicators1=$_POST['ResearchOutcomesIndicators1'][$i];
$Impact1=$_POST['Impact1'][$i];

$wm3="select * from ".$prefix."research_impact_pathway where  ResearchOutputs1='$ResearchOutputs1' and projectID='$projectID' and ResearchOutputsIndicators1='$ResearchOutputsIndicators1' and ResearchOutcomes1='$ResearchOutcomes1'";
$cmdwb3 = $mysqli->query($wm3);
if(!$cmdwb3->num_rows){
$Insert_QRRR2="insert into ".$prefix."research_impact_pathway (`resultsID`,`projectID`,`owner_id`,`ResearchOutputs1`,`ResearchOutputsIndicators1`,`ResearchOutcomes1`,`ResearchOutcomesIndicators1`,`Impact1`) values ('$record_id','$projectID','$asrmApplctID','$ResearchOutputs1','$ResearchOutputsIndicators1','$ResearchOutcomes1','$ResearchOutcomesIndicators1','$Impact1')";
$mysqli->query($Insert_QRRR2);
}
	}

$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new protocol");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';

echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalManagement'>";

}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update
if(!$_FILES['ImpactPathwayDiagram']['name']){	
$sqlA2="update ".$prefix."project_results set  `ResearchObjective`='$ResearchObjective',`Outputs`='$Outputs',`Outcomes`='$Outcomes',`ImpactCapacityDevelopment`='$ImpactCapacityDevelopment',`StakeholderEngagement`='$StakeholderEngagement',`CommunicationWithStakeholders`='$CommunicationWithStakeholders',`ScientificOutput`='$ScientificOutput',`ResearchOutputs1`='$ResearchOutputs1',`ResearchOutputs2`='$ResearchOutputs2',`ResearchOutputs3`='$ResearchOutputs3',`ResearchOutputs4`='$ResearchOutputs4',`ResearchOutputs5`='$ResearchOutputs5',`ResearchOutputs6`='$ResearchOutputs6',`ResearchOutputs7`='$ResearchOutputs7',`ResearchOutputsIndicators1`='$ResearchOutputsIndicators1',`ResearchOutputsIndicators2`='$ResearchOutputsIndicators2',`ResearchOutputsIndicators3`='$ResearchOutputsIndicators3',`ResearchOutputsIndicators4`='$ResearchOutputsIndicators4',`ResearchOutputsIndicators5`='$ResearchOutputsIndicators5',`ResearchOutputsIndicators6`='$ResearchOutputsIndicators6',`ResearchOutputsIndicators7`='$ResearchOutputsIndicators7',`ResearchOutcomes1`='$ResearchOutcomes1',`ResearchOutcomes2`='$ResearchOutcomes2',`ResearchOutcomes3`='$ResearchOutcomes3',`ResearchOutcomes4`='$ResearchOutcomes4',`ResearchOutcomes5`='$ResearchOutcomes5',`ResearchOutcomes6`='$ResearchOutcomes6',`ResearchOutcomes7`='$ResearchOutcomes7',`ResearchOutcomesIndicators1`='$ResearchOutcomesIndicators1',`ResearchOutcomesIndicators2`='$ResearchOutcomesIndicators2',`ResearchOutcomesIndicators3`='$ResearchOutcomesIndicators3',`ResearchOutcomesIndicators4`='$ResearchOutcomesIndicators4',`ResearchOutcomesIndicators5`='$ResearchOutcomesIndicators5',`ResearchOutcomesIndicators6`='$ResearchOutcomesIndicators6',`ResearchOutcomesIndicators7`='$ResearchOutcomesIndicators7',`Impact1`='$Impact1',`Impact2`='$Impact2',`Impact3`='$Impact3',`Impact4`='$Impact4',`Impact5`='$Impact5',`Impact6`='$Impact6',`Impact7`='$Impact7' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);
}
if($_FILES['ImpactPathwayDiagram']['name']){	
$sqlA2="update ".$prefix."project_results set  `ResearchObjective`='$ResearchObjective',`Outputs`='$Outputs',`Outcomes`='$Outcomes',`ImpactCapacityDevelopment`='$ImpactCapacityDevelopment',`ImpactPathwayDiagram`='$attachment',`StakeholderEngagement`='$StakeholderEngagement',`CommunicationWithStakeholders`='$CommunicationWithStakeholders',`ScientificOutput`='$ScientificOutput',`ResearchOutputs1`='$ResearchOutputs1',`ResearchOutputs2`='$ResearchOutputs2',`ResearchOutputs3`='$ResearchOutputs3',`ResearchOutputs4`='$ResearchOutputs4',`ResearchOutputs5`='$ResearchOutputs5',`ResearchOutputs6`='$ResearchOutputs6',`ResearchOutputs7`='$ResearchOutputs7',`ResearchOutputsIndicators1`='$ResearchOutputsIndicators1',`ResearchOutputsIndicators2`='$ResearchOutputsIndicators2',`ResearchOutputsIndicators3`='$ResearchOutputsIndicators3',`ResearchOutputsIndicators4`='$ResearchOutputsIndicators4',`ResearchOutputsIndicators5`='$ResearchOutputsIndicators5',`ResearchOutputsIndicators6`='$ResearchOutputsIndicators6',`ResearchOutputsIndicators7`='$ResearchOutputsIndicators7',`ResearchOutcomes1`='$ResearchOutcomes1',`ResearchOutcomes2`='$ResearchOutcomes2',`ResearchOutcomes3`='$ResearchOutcomes3',`ResearchOutcomes4`='$ResearchOutcomes4',`ResearchOutcomes5`='$ResearchOutcomes5',`ResearchOutcomes6`='$ResearchOutcomes6',`ResearchOutcomes7`='$ResearchOutcomes7',`ResearchOutcomesIndicators1`='$ResearchOutcomesIndicators1',`ResearchOutcomesIndicators2`='$ResearchOutcomesIndicators2',`ResearchOutcomesIndicators3`='$ResearchOutcomesIndicators3',`ResearchOutcomesIndicators4`='$ResearchOutcomesIndicators4',`ResearchOutcomesIndicators5`='$ResearchOutcomesIndicators5',`ResearchOutcomesIndicators6`='$ResearchOutcomesIndicators6',`ResearchOutcomesIndicators7`='$ResearchOutcomesIndicators7',`Impact1`='$Impact1',`Impact2`='$Impact2',`Impact3`='$Impact3',`Impact4`='$Impact4',`Impact5`='$Impact5',`Impact6`='$Impact6',`Impact7`='$Impact7' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);
}

	for ($i=0; $i < count($_POST['ResearchOutputs1']); $i++) {
$ResearchOutputs1=$_POST['ResearchOutputs1'][$i];
$ResearchOutputsIndicators1=$_POST['ResearchOutputsIndicators1'][$i];
$ResearchOutcomes1=$_POST['ResearchOutcomes1'][$i];
$ResearchOutcomesIndicators1=$_POST['ResearchOutcomesIndicators1'][$i];
$Impact1=$_POST['Impact1'][$i];

$wm3="select * from ".$prefix."research_impact_pathway where  ResearchOutputs1='$ResearchOutputs1' and projectID='$projectID' and ResearchOutputsIndicators1='$ResearchOutputsIndicators1' and ResearchOutcomes1='$ResearchOutcomes1'";
$cmdwb3 = $mysqli->query($wm3);
if(!$cmdwb3->num_rows){
$Insert_QRRR2="insert into ".$prefix."research_impact_pathway (`resultsID`,`projectID`,`owner_id`,`ResearchOutputs1`,`ResearchOutputsIndicators1`,`ResearchOutcomes1`,`ResearchOutcomesIndicators1`,`Impact1`) values ('$record_id','$projectID','$asrmApplctID','$ResearchOutputs1','$ResearchOutputsIndicators1','$ResearchOutcomes1','$ResearchOutcomesIndicators1','$Impact1')";
$mysqli->query($Insert_QRRR2);
}
	}
echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalManagement'>";
	
}//end


if(!$record_id){$record_idm=$_POST['projectID'];}
if($record_id){$record_idm=$record_id;}		
//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."project_stages (`owner_id`,`projectID`,`ProjectInformation`,`Background`,`Methodology`,`ProjectResults`,`ResearchTeam`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`)  values('$asrmApplctID','$record_idm','1','0','0','1','0','0','0','0',now(),'new')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `ProjectResults`='1' where `owner_id`='$asrmApplctID' and status='new'";
$mysqli->query($sqlASubmissionStages);
}

}//end post



if(isset($message)){echo $message;}
$asrmApplctID2=$usrm_id;
$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();

$sqlUsers2="SELECT * FROM ".$prefix."project_results where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
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
   
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'proposalResults')" id="defaultOpen"><?php echo $lang_new_ProjectResults;?></button>
   
  
  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalManagement&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalFollowup&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
  
</div>

<div id="proposalResults" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("proposal_submit_now_final_button.php");?>
 <script>
function deleteRow(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable').deleteRow(i);
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
	
	
	new_row.cells[5].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
}
</script>

    
  <h3>Project Results (max. 1000 words)</h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->
<label for="fname"><strong>Theory of Change</strong></label><br />
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><strong>Please describe in narrative the relationship, logical flow and/or causalities between planned activities, expected results (output), desired changes (outcome) and main objective (contribution to impact). A context analysis that includes the assumptions underlying the Research Impact Pathway should be part of the Theory of Change.</strong><br />
    Research Impact Pathway  <span class="error">*</span></label>





<table width="100%" border="0" cellpadding="0" cellspacing="0" id="POITable">
        <tr>
            <td style=" display:none;">&nbsp;</td>
      
           <td width="20%"><strong><em>Research outputs</em></strong></td>
    <td width="17%"><strong><em>Indicators</em></strong></td>
    <td width="6%">&nbsp;</td>
    <td width="20%"><strong><em>Research outcomes</em></strong></td>
    <td width="16%"><strong><em>Indicators</em></strong></td>
    <td width="7%">&nbsp;</td>
    <td width="14%"><strong><em>Impact</em></strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<input type="text" name="ResearchOutputs1[]" id="vvv" tabindex="4" class="requiredd" minlength="5" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:160px; background:#ffffff;"/>
            </td>
            <td><input type="text" name="ResearchOutputsIndicators1[]" id="customss2" tabindex="5" class="requiredd" minlength="3" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:160px; background:#ffffff;"/></td>
            
            <td>&nbsp;</td>
            
            <td><input type="text" name="ResearchOutcomes1[]" id="customss2" tabindex="5" class="requiredd" minlength="3" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:160px; background:#ffffff;"/></td>
            
            <td><input type="text" name="ResearchOutcomesIndicators1[]" id="customss2" tabindex="5" class="requiredd" minlength="3" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:160px; background:#ffffff;"/></td>
            
            <td>&nbsp;</td>
            
            <td><input type="text" name="Impact1[]" id="customss2" tabindex="5" class="requiredd" minlength="3" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:160px; background:#ffffff;"/></td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>
        
        <?php 
$sqlProjectID="SELECT * FROM ".$prefix."research_impact_pathway where `owner_id`='$usrm_id' and `projectID`='$projectID'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
      
           <td width="20%"><?php echo $rUserProjectID['ResearchOutputs1'];?></td>
    <td width="17%"><?php echo $rUserProjectID['ResearchOutputsIndicators1'];?></td>
    <td width="6%">&nbsp;</td>
    <td width="20%"><?php echo $rUserProjectID['ResearchOutcomes1'];?></td>
    <td width="16%"><?php echo $rUserProjectID['ResearchOutcomesIndicators1'];?></td>
    <td width="7%">&nbsp;</td>
    <td width="14%"><?php echo $rUserProjectID['Impact1'];?></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php }?>
        </table>
        
        
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="fname">a) Research objective: the main objective of the research project, in relation to the objectives of the call;<span class="error">*</span></label>
<textarea id="MyTextBox14" name="ResearchObjective" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['ResearchObjective'];?></textarea>
    </div>
  </div>


    <div class="row success">

    <div class="col-100">
    <label for="fname">b) Outputs: the most immediate results of the research project. Research outcomes relate to the uptake of these outputs by external stakeholders and the effects thereof;<span class="error">*</span></label>
<textarea id="MyTextBox13" name="Outputs" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['Outputs'];?></textarea>
    </div>
  </div>
  
 <div class="row success">

    <div class="col-100">
    <label for="fname">c) Outcomes: The external use, adoption or influence of a project's outputs by next and final users that results in adopter-level changes needed to achieve the intended impact. Indicate the (economic, social, environmental) changes that are expected at the level of the adopters;<span class="error">*</span></label>
<textarea id="MyTextBoxmm300" name="Outcomes" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['Outcomes'];?></textarea>
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Impact: changes in Scientific, economic, environmental and social conditions that the project is working toward. <br />
  a) Capacity development: Describe the activities incorporated in the project with the purpose of capacity development.<br /><span class="error">*</span></label>
<textarea id="MyTextBoxmm3001" name="ImpactCapacityDevelopment" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['ImpactCapacityDevelopment'];?></textarea>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">b) Impact pathway diagram with indicators at output and outcome level <span class="error">(pdf only)</span><span class="error">*</span></label>

<?php if($rUserInv2['ImpactPathwayDiagram']){?>
<input name="ImpactPathwayDiagram" type="file" id="ImpactPathwayDiagram"/>

<br /><a href="./files/<?php echo $rUserInv2['ImpactPathwayDiagram'];?>" target="_blank">Impact pathway diagram</a><?php }?>

<?php if(!$rUserInv2['ImpactPathwayDiagram']){?>
<input name="ImpactPathwayDiagram" type="file" class="required" id="ImpactPathwayDiagram" required/>
<?php }?>
    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Knowledge sharing and research uptake (Max 250 words)<br />
  Stakeholder engagement: Include an initial mapping of relevant stakeholders and their roles and contributions in the project at all stages.<span class="error">*</span></label>
<textarea id="MyTextBox7" name="StakeholderEngagement" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['StakeholderEngagement'];?></textarea>
    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Communication with stakeholders (including communication strategies, methods and technologies): Describe the proposed activities and their timeline. Include in this section a description of the planned communication activities, specifying target groups, specific objectives, communication issues and products as well as means of communication.<span class="error">*</span></label>
<textarea id="MyTextBoxmm3002" name="CommunicationWithStakeholders" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['CommunicationWithStakeholders'];?></textarea>
    </div>
  </div>
  
     <div class="row success">

    <div class="col-100">
    <label for="fname">Scientific output.<span class="error">*</span></label>
<textarea id="MyTextBox10" name="ScientificOutput" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['ScientificOutput'];?></textarea>
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