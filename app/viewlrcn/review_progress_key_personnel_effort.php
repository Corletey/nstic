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
$sqlASubmissionStages="insert into ".$prefix."progress_report_review (`projectID`,`progressID`,`owner_id`,`SignaturePage`,`Abstract`,`SummaryofScientificProgress`,`KeyPersonnelEffort`,`Publications`,`PatentsandLicenses`,`status`,`reviewer_id`)  values('$id','$progressID','$owner_id','0','0','0','1','0','0','new','$sessionusrm_id')";
$mysqli->query($sqlASubmissionStages);	
}

if($totalConcepts and $id){


$wm="select * from ".$prefix."progress_report_review where  owner_id='$owner_id' and status='new' and reviewer_id='$sessionusrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."progress_report_review  set `KeyPersonnelEffort`='1' where `owner_id`='$owner_id' and status='new' and reviewer_id='$sessionusrm_id'";
$mysqli->query($sqlASubmissionStages);
}
}
$sqlUsers2="SELECT * FROM ".$prefix."progress_report_keypersonnel_effort where `owner_id`='$owner_id'  and  `progressID`='$progressID' order by id desc limit 0,1";//conceptID='$conceptID'
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();
?>
<div class="tab">
 
  
   <button <?php if($rUConceptStages['SignaturePage']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=reviewProgressReport&id=<?php echo $id;?>'"><?php echo $lang_SignaturePage;?></button>

    <button <?php if($rUConceptStages['Abstract']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewAbstract&id=<?php echo $id;?>'"><?php echo $lang_abstract;?></button>
  
  <button <?php if($rUConceptStages['SummaryofScientificProgress']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewSummaryofScientificProgress&id=<?php echo $id;?>'"><?php echo $lang_SummaryofScientificProgress;?> </button>
  
    <button <?php if($rUConceptStages['KeyPersonnelEffort']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'reviewKeyPersonnelEffort')" id="defaultOpen"><?php echo $lang_KeyPersonnelEffort;?> </button>
    
    <button <?php if($rUConceptStages['Publications']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=reviewPublications&id=<?php echo $id;?>'"><?php echo $lang_Publications;?></button>
    
  


  
 
  
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

<div id="reviewKeyPersonnelEffort" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("report_approve_button.php");?>
   
    
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
            </tr>

        

<?php
$sqlUsers2="SELECT * FROM ".$prefix."progress_report_keypersonnel_effort where `owner_id`='$owner_id'  and  `progressID`='$progressID' order by id desc limit 0,40";//conceptID='$conceptID'
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
            </tr>   <?php }?>
        
        

    </table>   
    
    
    
    
    
    
    
    
    

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