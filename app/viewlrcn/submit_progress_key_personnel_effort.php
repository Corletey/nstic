<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];
if($_POST['doSaveData'] and $_POST['progressID'] and $_POST['projectID']){

	
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$progressID=$mysqli->real_escape_string($_POST['progressID']);

	
	for ($i=0; $i < count($_POST['PIName']); $i++) {
$PIName=$_POST['PIName'][$i];
$RoleinProject=$_POST['RoleinProject'][$i];
$MonthsDevotedtoProject=$_POST['MonthsDevotedtoProject'][$i];
$Changesinrole=$_POST['Changesinrole'][$i];
$Dateofchange=$_POST['Dateofchange'][$i];
		
$sqlUsers="SELECT * FROM ".$prefix."progress_report_keypersonnel_effort where `projectID`='$projectID',`owner_id`='$sessionusrm_id' and `is_sent`='0' order by projectID desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
$totalUsers = $QueryUsers->num_rows;
	if(!$totalUsers){
$Insert_QR2="insert into ".$prefix."progress_report_keypersonnel_effort (`progressID`,`projectID`,`owner_id`,`PIName`,`RoleinProject`,`MonthsDevotedtoProject`,`Changesinrole`,`Dateofchange`,`is_sent`) values ('$progressID','$projectID','$sessionusrm_id','$PIName','$RoleinProject','$MonthsDevotedtoProject','$Changesinrole','$Dateofchange','0')";
$mysqli->query($Insert_QR2);
	}

}

$wm="select * from ".$prefix."progress_report_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();

if($totalStages){
$sqlASubmissionStages="update ".$prefix."progress_report_stages  set `KeyPersonnelEffort`='1' where `owner_id`='$sessionusrm_id' and status='new'";
$mysqli->query($sqlASubmissionStages);
}
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=Publications'>";

logaction("$session_fullname Submitted Progress Report for project ID: $projectID");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted.</p>';
}//end post



if(isset($message)){echo $message;}

$sqlUsers2="SELECT * FROM ".$prefix."progress_report_keypersonnel_effort where `owner_id`='$sessionusrm_id'  and  `is_sent`='0' order by id desc limit 0,1";//conceptID='$conceptID'
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();



$wConceptStages="select * from ".$prefix."progress_report_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();
///Get p

$sqlUsersee="SELECT * FROM ".$prefix."progress_report_signature_page where `owner_id`='$sessionusrm_id'  and  `is_sent`='0' order by progressID desc limit 0,1";//conceptID='$conceptID'
$QueryUsersee = $mysqli->query($sqlUsersee);
$rUserInvee=$QueryUsersee->fetch_array();

?>
<div class="tab">
 
  
   <button <?php if($rUConceptStages['SignaturePage']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=submitProgressReport&id=<?php echo $id;?>'"><?php echo $lang_SignaturePage;?></button>

    <button <?php if($rUConceptStages['Abstract']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=Abstract&id=<?php echo $id;?>'"><?php echo $lang_abstract;?></button>
  
  <button <?php if($rUConceptStages['SummaryofScientificProgress']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SummaryofScientificProgress&id=<?php echo $id;?>'"><?php echo $lang_SummaryofScientificProgress;?> </button>
  
    <button <?php if($rUConceptStages['KeyPersonnelEffort']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'KeyPersonnelEffort')" id="defaultOpen"><?php echo $lang_KeyPersonnelEffort;?> </button>
    
    <button <?php if($rUConceptStages['Publications']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=Publications&id=<?php echo $id;?>'"><?php echo $lang_Publications;?></button>
    
  


  
 
  
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
	
	var inp3 = new_row.cells[3].getElementsByTagName('input')[0];
    inp3.id += len;
    inp3.value = '';
	
	var inp4 = new_row.cells[4].getElementsByTagName('input')[0];
    inp4.id += len;
    inp4.value = '';
	
	var inp5 = new_row.cells[5].getElementsByTagName('input')[0];
    inp5.id += len;
    inp5.value = '';
	
    new_row.cells[6].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
}
</script>

<div id="KeyPersonnelEffort" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("progressreport_submit_now_final_button.php");?>
   
    
  <h3><?php echo $lang_KeyPersonnelEffort;?></h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $sessionusrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserInvee['projectID'];?>" >
 <input type="hidden" name="progressID" value="<?php echo $rUserInvee['progressID'];?>" >

 <div class="container"><!--begin-->
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>



  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
<?php echo $lang_Listallkeypersonnelnamed;?>
 
<span class="error">*</span></label><br />
<?php /*?><textarea id="MyTextBox14" name="degree_stated_project" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['degree_stated_project'];?></textarea><?php */?>
    </div>
  </div>
  
  
    <div class="row success">

    <div class="col-100">
    
    
 <table width="100%" border="0" id="POITable">
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <th><?php echo $lang_PIName;?></th>
            <th><?php echo $lang_RoleinProject;?></th>
            <th><?php echo $lang_MonthsDevotedtoProject;?></th>
            <th><?php echo $lang_DescribeChangesinrole;?></th>
            <th><?php echo $lang_Dateofchange;?></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<!----><input type="hidden" name="f1" id="vvv" tabindex="4" class="required" minlength="5"/>

<textarea id="PIName" name="PIName[]" placeholder="" style="height:60px;width:190px; margin-bottom:5px;" class="required"></textarea>
</td>

<td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
<textarea id="RoleinProject" name="RoleinProject[]" placeholder="" style="height:60px;width:190px;" class="required"></textarea>
</td>

<td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
<select name="MonthsDevotedtoProject[]" style="height:60px;width:100px;" id="MonthsDevotedtoProject" class="required">
<option value="Q1">Quarter 1</option>
<option value="Q2">Quarter 2</option>
<option value="Q3">Quarter 3</option>
<option value="Q4">Quarter 4</option>
</select>

</td>
<td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
<textarea id="Changesinrole" name="Changesinrole[]" placeholder="" style="height:60px;width:250px;" class="required"></textarea>
</td>
<td><input type="date" name="Dateofchange[]" id="vvv" tabindex="4" class="required" minlength="5"/>
</td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>
        

<?php
$sqlUsers2="SELECT * FROM ".$prefix."progress_report_keypersonnel_effort where `owner_id`='$sessionusrm_id'  and  `is_sent`='0' order by id desc limit 0,40";//conceptID='$conceptID'
$QueryUsers2 = $mysqli->query($sqlUsers2);
while($rUserInv2=$QueryUsers2->fetch_array()){
?>
 <tr>
            <td style=" display:none;">1</td>
            <td><?php echo $rUserInv2['PIName'];?></td>

<td><?php echo $rUserInv2['RoleinProject'];?></td>

<td><?php echo $rUserInv2['MonthsDevotedtoProject'];?></td>
<td><?php echo $rUserInv2['Changesinrole'];?></td>
<td><?php echo $rUserInv2['Dateofchange'];?></td>
  
            <td></td>
            <td></td>
        </tr>   <?php }?>
        
        

    </table>   
    
    
    
    
    
    
    
    
    

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