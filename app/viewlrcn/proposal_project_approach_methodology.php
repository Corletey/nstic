<?php
if($_POST['doSaveData']=='Save and Next' and $_POST['projectID'] and $_POST['asrmApplctID']){

	
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$generalApproach=$mysqli->real_escape_string($_POST['generalApproach']);
	$RelationshipOngoingResearch=$mysqli->real_escape_string($_POST['RelationshipOngoingResearch']);
	$otherDonorsFunding=$mysqli->real_escape_string($_POST['otherDonorsFunding']);
	$StateDonors=$mysqli->real_escape_string($_POST['StateDonors']);
	$HostInstitution=$mysqli->real_escape_string($_POST['HostInstitution']);
	$otherDonorsFunding=$mysqli->real_escape_string($_POST['otherDonorsFunding']);
	//$StateDonors=$mysqli->real_escape_string($_POST['StateDonors']);
	//$StateAmount=$mysqli->real_escape_string($_POST['StateAmount']);
	$furtheringWork=$mysqli->real_escape_string($_POST['furtheringWork']);
	$furtheringWorkHow=$mysqli->real_escape_string($_POST['furtheringWorkHow']);
	$drawSynergiesOngoingProjects=$mysqli->real_escape_string($_POST['drawSynergiesOngoingProjects']);
	$projectone=$mysqli->real_escape_string($_POST['projectone']);
	$potentialSynergyExist=$mysqli->real_escape_string($_POST['potentialSynergyExist']);
	$asrmApplctID=$mysqli->real_escape_string($_POST['asrmApplctID']);
	

	
	$sqlUsers="SELECT * FROM ".$prefix."project_methodology where `owner_id`='$asrmApplctID' and `is_sent`='0' order by projectID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers and $_POST['asrmApplctID']){
$sqlA2="insert into ".$prefix."project_methodology (`projectID`,`owner_id`,`generalApproach`,`RelationshipOngoingResearch`,`otherDonorsFunding`,`StateDonors`,`StateAmount`,`furtheringWork`,`furtheringWorkHow`,`drawSynergiesOngoingProjects`,`projectone`,`projectoneObjectives`,`projectTwo`,`projectTwoObjectives`,`projectThree`,`projectThreeObjectives`,`potentialSynergyExist`,`SynergyProject`,`SynergyTask`,`SynergyDescrption`,`is_sent`) 

values('$projectID','$asrmApplctID','$generalApproach','$RelationshipOngoingResearch','$otherDonorsFunding','$StateDonors','$StateAmount','$furtheringWork','$furtheringWorkHow','$drawSynergiesOngoingProjects','$projectone','$projectoneObjectives','$projectTwo','$projectTwoObjectives','$projectThree','$projectThreeObjectives','$potentialSynergyExist','$SynergyProject','$SynergyTask','$SynergyDescrption','0')";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){//

	
	///Add education Details
for ($i=0; $i < count($_POST['StateDonors']); $i++) {
$StateDonors=$_POST['StateDonors'][$i];
$StateAmount=$_POST['StateAmount'][$i];

$Insert_QR2="insert into ".$prefix."project_methodology_donors (`methodologyID`,`projectID`,`owner_id`,`StateDonors`,`StateAmount`) values ('$record_id','$projectID','$asrmApplctID','$StateDonors','$StateAmount')";
$mysqli->query($Insert_QR2);

}

//////Objectives
for ($i=0; $i < count($_POST['projectName']); $i++) {
$projectName=$_POST['projectName'][$i];
$projectObjectives=$_POST['projectObjectives'][$i];

$Insert_QRRR="insert into ".$prefix."projects_objectives (`methodologyID`,`projectID`,`owner_id`,`projectName`,`projectObjectives`) values ('$record_id','$projectID','$asrmApplctID','$projectName','$projectObjectives')";
$mysqli->query($Insert_QRRR);

}

for ($i=0; $i < count($_POST['SynergyProject']); $i++) {
$SynergyProject=$_POST['SynergyProject'][$i];
$SynergyTask=$_POST['SynergyTask'][$i];
$SynergyDescrption=$_POST['SynergyDescrption'][$i];

$Insert_QRRR2="insert into ".$prefix."potential_for_synergy (`methodologyID`,`projectID`,`owner_id`,`SynergyProject`,`SynergyTask`,`SynergyDescrption`) values ('$record_id','$projectID','$asrmApplctID','$SynergyProject','$SynergyTask','$SynergyDescrption')";
$mysqli->query($Insert_QRRR2);

}
	
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, proceed to continue</p>';
logaction("$session_fullname added created new protocol");

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalBudget'>";

}
if($record_id<=0){
$message='<p class="failed">Dear '.$session_fullname.', details have not been saved. Re-enter and submit again.</p>';	
}

}	/////end totals

if($totalUsers){
	///update
	
$sqlA2="update ".$prefix."project_methodology set  `generalApproach`='$generalApproach',`RelationshipOngoingResearch`='$RelationshipOngoingResearch',`otherDonorsFunding`='$otherDonorsFunding',`StateDonors`='$StateDonors',`StateAmount`='$StateAmount',`furtheringWork`='$furtheringWork',`furtheringWorkHow`='$furtheringWorkHow',`drawSynergiesOngoingProjects`='$drawSynergiesOngoingProjects',`projectone`='$projectone',`projectoneObjectives`='$projectoneObjectives',`projectTwo`='$projectTwo',`projectTwoObjectives`='$projectTwoObjectives',`projectThree`='$projectThree',`projectThreeObjectives`='$projectThreeObjectives',`potentialSynergyExist`='$potentialSynergyExist',`SynergyProject`='$SynergyProject',`SynergyTask`='$SynergyTask',`SynergyDescrption`='$SynergyDescrption' where owner_id='$asrmApplctID' and is_sent='0'";
$mysqli->query($sqlA2);

$sqlUsers24="SELECT * FROM ".$prefix."project_methodology where `owner_id`='$usrm_id' and `is_sent`='0' order by methodologyID desc limit 0,1";
$QueryUsers24 = $mysqli->query($sqlUsers24);
$rUserInv24=$QueryUsers24->fetch_array();
$methodologyID=$rUserInv24['methodologyID'];

///Add education Details
for ($i=0; $i < count($_POST['StateDonors']); $i++) {
$StateDonors=$_POST['StateDonors'][$i];
$StateAmount=$_POST['StateAmount'][$i];

$wm1="select * from ".$prefix."project_methodology_donors where  methodologyID='$methodologyID' and projectID='$projectID' and StateDonors='$StateDonors' and StateAmount='$StateAmount'";
$cmdwb1 = $mysqli->query($wm1);
if(!$cmdwb1->num_rows){
$Insert_QR2="insert into ".$prefix."project_methodology_donors (`methodologyID`,`projectID`,`owner_id`,`StateDonors`,`StateAmount`) values ('$methodologyID','$projectID','$asrmApplctID','$StateDonors','$StateAmount')";
$mysqli->query($Insert_QR2);
}

}
//////Objectives
for ($i=0; $i < count($_POST['projectObjectives']); $i++) {
$projectName=$_POST['projectName'][$i];
$projectObjectives=$_POST['projectObjectives'][$i];

$wm2="select * from ".$prefix."project_methodology_donors where  methodologyID='$methodologyID' and projectID='$projectID' and projectName='$projectName' and projectObjectives='$projectObjectives'";
$cmdwb2 = $mysqli->query($wm2);
if(!$cmdwb2->num_rows){
$Insert_QRRR="insert into ".$prefix."projects_objectives (`methodologyID`,`projectID`,`owner_id`,`projectName`,`projectObjectives`) values ('$methodologyID','$projectID','$asrmApplctID','$projectName','$projectObjectives')";
$mysqli->query($Insert_QRRR);
}

}

for ($i=0; $i < count($_POST['SynergyProject']); $i++) {
$SynergyProject=$_POST['SynergyProject'][$i];
$SynergyTask=$_POST['SynergyTask'][$i];
$SynergyDescrption=$_POST['SynergyDescrption'][$i];

$wm3="select * from ".$prefix."potential_for_synergy where  methodologyID='$methodologyID' and projectID='$projectID' and SynergyProject='$SynergyProject' and SynergyTask='$SynergyTask'";
$cmdwb3 = $mysqli->query($wm3);
if(!$cmdwb3->num_rows){
$Insert_QRRR2="insert into ".$prefix."potential_for_synergy (`methodologyID`,`projectID`,`owner_id`,`SynergyProject`,`SynergyTask`,`SynergyDescrption`) values ('$methodologyID','$projectID','$asrmApplctID','$SynergyProject','$SynergyTask','$SynergyDescrption')";
$mysqli->query($Insert_QRRR2);
}

}

echo '<img src="img/loading_wait.gif">';
echo '<div class="spacer"></div>';
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=proposalBudget'>";
	
}//end


if(!$record_id){$record_idm=$_POST['projectID'];}
if($record_id){$record_idm=$record_id;}		
//Insert into Submission Stages
$wm="select * from ".$prefix."project_stages where  owner_id='$asrmApplctID' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."project_stages (`owner_id`,`projectID`,`ProjectInformation`,`Background`,`Methodology`,`ProjectResults`,`ResearchTeam`,`ProjectManagement`,`Followup`,`Budget`,`dateCreated`,`status`)  values('$asrmApplctID','$record_idm','1','0','1','0','0','0','0','0',now(),'new')";
$mysqli->query($sqlASubmissionStages);
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."project_stages  set `Methodology`='1' where `owner_id`='$asrmApplctID' and status='new'";
$mysqli->query($sqlASubmissionStages);
}

}//end post



if(isset($message)){echo $message;}
$asrmApplctID2=$usrm_id;
$sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryProjectID = $mysqli->query($sqlProjectID);
$rUserProjectID=$QueryProjectID->fetch_array();

$sqlUsers2="SELECT * FROM ".$prefix."project_methodology where `owner_id`='$usrm_id' and `is_sent`='0' order by methodologyID desc limit 0,1";
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
  
    <button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'proposalMethodology')" id="defaultOpen"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalResults&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectResults;?></button>
  
  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=proposalManagement&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
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
	var inp1 = new_row.cells[2].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.value = '';
    
	new_row.cells[3].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
}
</script>


<script>
function deleteRow2(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable2').deleteRow2(-1);
	//document.getElementById("myTable").deleteRow(0);
}


function insRow2()
{
    console.log( 'hi');
    var x=document.getElementById('POITable2');
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

<script>
function deleteRow3(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable3').deleteRow3(-1);
	//document.getElementById("myTable").deleteRow(0);
}


function insRow3()
{
    console.log( 'hi');
    var x=document.getElementById('POITable3');
    var new_row = x.rows[1].cloneNode(true);
    var len = x.rows.length;
    new_row.cells[0].innerHTML = len;
    
    var inp1 = new_row.cells[1].getElementsByTagName('input')[0];
    inp1.id += len;
    inp1.value = '';
    var inp2 = new_row.cells[2].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = '';
	
	var inp2 = new_row.cells[3].getElementsByTagName('input')[0];
    inp2.id += len;
    inp2.value = '';
	
    new_row.cells[4].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
}
</script>

<div id="proposalMethodology" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("proposal_submit_now_final_button.php");?>
   
    
  <h3>Project Approach/Methodology (max. 1500 words) </h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserProjectID['projectID'];?>" >
 <div class="container"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Explain the general approach and methodology chosen to achieve the project objectives. Highlight the particular advantages of the methodology chosen.  <span class="error">*</span></label>
<textarea id="generalApproach" name="generalApproach" placeholder="" style="height:150px; " class="required" required><?php echo $rUserInv2['generalApproach'];?></textarea>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="fname">Relationship to ongoing Research/Projects (Name of study and reference) -(max 5100 words)<span class="error">*</span></label>
<textarea id="MyTextBox5100" name="RelationshipOngoingResearch" placeholder="" style="height:150px; " class="required" required><?php echo $rUserInv2['RelationshipOngoingResearch'];?></textarea>
    </div>
  </div>


    <div class="row success">

    <div class="col-100">
    <label for="fname">Are there other Donors funding this Project? Yes/No <span class="error">*</span>
    <input name="otherDonorsFunding" type="radio" value="No"  onChange="getOtherDonorsFunding(this.value)" <?php if($rUserInv2['otherDonorsFunding']=='No'){?>checked="checked"<?php }?>/> No &nbsp; <input name="otherDonorsFunding" type="radio" value="Yes"  onChange="getOtherDonorsFunding(this.value)" <?php if($rUserInv2['otherDonorsFunding']=='Yes'){?>checked="checked"<?php }?>/> Yes
    </label>

    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <div id="projectOtherDonorsFunding">
    
<?php if($rUserInv2['otherDonorsFunding']=='Yes'){?>
<label for="fname">State the Donors and components they are funding – State Amount<span class="error">*</span><br /></label>

<table width="50%" border="0" id="POITable">
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <th>Donor
            </th>
            <th>
              Amount
            </th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<input type="text" name="StateDonors[]" id="vvv" tabindex="4" class="requiredd" minlength="5" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:220px; background:#ffffff;"/>
            </td>
            <td><input type="text" name="StateAmount[]" id="customss2" tabindex="5" class="requiredd" minlength="3" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:220px; background:#ffffff;"/></td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>
        
        <?php 
$projectID=$rUserProjectID['projectID'];
$sqlProjectID="SELECT * FROM ".$prefix."project_methodology_donors where `owner_id`='$usrm_id' and `projectID`='$projectID'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td>
              <label><?php echo $rUserProjectID['StateDonors'];?></label>
            </td>
            <td>
              <label><?php echo $rUserProjectID['StateAmount'];?></label>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php }?>
    </table>
<?php }?>
    
    
    
    
    </div>
    </div>
    </div>
    
    
 <div class="row success">

    <div class="col-100">
    <label for="fname">Is this project furthering work in an existing Project?(Y/N), if Yes(indicate how) <input name="furtheringWork" type="radio" value="No"  onChange="getfurtheringWork(this.value)" <?php if($rUserInv2['furtheringWork']=='No'){?>checked="checked"<?php }?>/> No &nbsp; <input name="furtheringWork" type="radio" value="Yes"  onChange="getfurtheringWork(this.value)" <?php if($rUserInv2['furtheringWork']=='Yes'){?>checked="checked"<?php }?>/> Yes<span class="error">*</span></label>
   <div id="projectfurtheringWork">
   
   <?php 
if($rUserInv2['furtheringWork']=='Yes'){?><label for="fname"><strong>(indicate how)</strong></label><br />
<textarea id="furtheringWorkHow" name="furtheringWorkHow" placeholder="" style="height:150px; " class="required" required><?php echo $rUserInv2['furtheringWorkHow'];?></textarea><?php }?>
   
   </div> 

    </div>
  </div>
  
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Is this project likely to draw synergies with other ongoing projects? Yes/No <span class="error">*</span>
    <input name="drawSynergiesOngoingProjects" type="radio" value="No"  onChange="getdrawSynergies(this.value)" <?php if($rUserInv2['furtheringWork']=='No'){?>checked="checked"<?php }?>/> No &nbsp; <input name="drawSynergiesOngoingProjects" type="radio" value="Yes"  onChange="getdrawSynergies(this.value)" <?php if($rUserInv2['furtheringWork']=='Yes'){?>checked="checked"<?php }?>/> Yes<span class="error">*</span></label>
   
   
   <div id="projectdrawSynergies">
   
   <?php
if($rUserInv2['furtheringWork']=='Yes'){?>
<label for="fname">Name the Projects and the objectives. (Max 3 Projects) <span class="error">*</span><br /></label>

<table width="100%" border="0" id="POITable2">
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <th>
              Project Name
            </th>
            <th>
              Objectives
            </th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<!----><input type="hidden" name="f1" id="vvv" tabindex="4" class="required" minlength="5"/>

<textarea id="projectName" name="projectName[]" placeholder="" style="height:60px;width:450px;" class="required"></textarea>

            </td>
            <td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
            <textarea id="projectObjectives" name="projectObjectives[]" placeholder="" style="height:60px;width:450px;" class="required"></textarea>
      
      </td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow2(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow2()" style="font-size:12px;"/></td>
        </tr>
        
        <?php 
$sqlProjectID2="SELECT * FROM ".$prefix."projects_objectives where `owner_id`='$usrm_id' and `projectID`='$projectID'";
$QueryProjectID2 = $mysqli->query($sqlProjectID2);
while($rUserProjectID2=$QueryProjectID2->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td>
              <label><?php echo $rUserProjectID2['projectName'];?></label>
            </td>
            <td>
              <label><?php echo $rUserProjectID2['projectObjectives'];?></label>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php }?>
        
    </table>
    
    
	
	
	
	
	<?php }?>
   
   </div> 

    
    
    </label>

    </div>
  </div>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname">Explain where a potential for synergy may exist between different tasks of the project and how this is going to be exploited.<span class="error">*</span></label>


<table width="100%" border="0" id="POITable3">
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <th>
              Project</th>
            <th>Task</th>
            <th> Descrption</th>
            
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<!----><input type="hidden" name="f1" id="vvv" tabindex="4" class="required" minlength="5"/>

<textarea id="SynergyProject" name="SynergyProject[]" placeholder="" style="height:60px;width:300px; margin-bottom:5px;" class="required"></textarea>
</td>

<td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
<textarea id="SynergyTask" name="SynergyTask[]" placeholder="" style="height:60px;width:300px;" class="required"></textarea>
</td>

<td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
<textarea id="SynergyDescrption" name="SynergyDescrption[]" placeholder="" style="height:60px;width:300px;" class="required"></textarea>
</td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow3(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow3()" style="font-size:12px;"/></td>
        </tr>
        
        <?php 
$sqlProjectID3="SELECT * FROM ".$prefix."potential_for_synergy where `owner_id`='$usrm_id' and `projectID`='$projectID'";
$QueryProjectID3 = $mysqli->query($sqlProjectID3);
while($rUserProjectID3=$QueryProjectID3->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td>
              <label><?php echo $rUserProjectID3['SynergyProject'];?></label></td>
            <td><label><?php echo $rUserProjectID3['SynergyTask'];?></label></td>
            <td><label><?php echo $rUserProjectID3['SynergyDescrption'];?></label></td>
            
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