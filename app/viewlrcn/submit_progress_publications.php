<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];
if($_POST['doSaveData'] and $_POST['progressID'] and $_POST['projectID']){

	
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	$progressID=$mysqli->real_escape_string($_POST['progressID']);
     $chapters=$mysqli->real_escape_string($_POST['chapters']);
	
	for ($i=0; $i < count($_POST['NameofMeeting']); $i++) {

$NameofMeeting=$mysqli->real_escape_string($_POST['NameofMeeting'][$i]);
$MonthsDevotedtoProject=$mysqli->real_escape_string($_POST['MonthsDevotedtoProject'][$i]);
$abstract=$mysqli->real_escape_string($_POST['abstract'][$i]);
$Location=$mysqli->real_escape_string($_POST['Location'][$i]);
$Title=$mysqli->real_escape_string($_POST['Title'][$i]);
$MeetingDate=$_POST['MeetingDate'][$i];
		
$sqlUsers="SELECT * FROM ".$prefix."progress_meeting_abstracts where `NameofMeeting`='$NameofMeeting' and `projectID`='$projectID' and `owner_id`='$sessionusrm_id' and `is_sent`='0' order by meetingAbstractID desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
$totalUsers = $QueryUsers->num_rows;
	if(!$totalUsers){
$Insert_QR2="insert into ".$prefix."progress_meeting_abstracts (`progressID`,`projectID`,`owner_id`,`chapters`,`NameofMeeting`,`abstract`,`Location`,`Title`,`MeetingDate`,`is_sent`) values ('$progressID','$projectID','$sessionusrm_id','$chapters','$NameofMeeting','$abstract','$Location','$Title','$MeetingDate','0')";
$mysqli->query($Insert_QR2);
	}
if($totalUsers){
$Insert_QR22="update ".$prefix."progress_meeting_abstracts set chapters='$chapters' where `progressID`='$progressID'";
$mysqli->query($Insert_QR22);	
}
}
///////////////////////////////////Other Presentations
for ($i=0; $i < count($_POST['Organizationofpublication']); $i++) {
$locationofpublication=$mysqli->real_escape_string($_POST['locationofpublication'][$i]);
$Organizationofpublication=$mysqli->real_escape_string($_POST['Organizationofpublication'][$i]);
$titleofpublication=$mysqli->real_escape_string($_POST['titleofpublication'][$i]);
$DateofMeeting=$mysqli->real_escape_string($_POST['DateofMeeting'][$i]);
		
$sqlUsers4="SELECT * FROM ".$prefix."progress_report_otherpresentations where `Organization`='$Organizationofpublication' and `projectID`='$projectID' and `owner_id`='$sessionusrm_id' and `is_sent`='0' order by id desc limit 0,1";
$QueryUsers4 = $mysqli->query($sqlUsers4);
$totalUsers4 = $QueryUsers4->num_rows;
	if(!$totalUsers4){
$Insert_QR24="insert into ".$prefix."progress_report_otherpresentations (`progressID`,`projectID`,`owner_id`,`Organization`,`location`,`title`,`DateofMeeting`,`is_sent`) values ('$progressID','$projectID','$sessionusrm_id','$Organizationofpublication','$locationofpublication','$titleofpublication','$DateofMeeting','0')";
$mysqli->query($Insert_QR24);
	}

}



$wm="select * from ".$prefix."progress_report_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();

if($totalStages){
$sqlASubmissionStages="update ".$prefix."progress_report_stages  set `Publications`='1' where `owner_id`='$sessionusrm_id' and status='new'";
$mysqli->query($sqlASubmissionStages);
}
logaction("$session_fullname Submitted Progress Report for project ID: $projectID");
$message='<p class="success">Dear '.$session_fullname.', details have been submitted.</p>';




}//end post



if(isset($message)){echo $message;}

$sqlUsers2="SELECT * FROM ".$prefix."progress_meeting_abstracts where `owner_id`='$sessionusrm_id'  and  `is_sent`='0' order by meetingAbstractID desc limit 0,1";//conceptID='$conceptID'
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
  
  <button <?php if($rUConceptStages['SummaryofScientificProgress']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SummaryofScientificProgress/<?php echo $id;?>/'"><?php echo $lang_SummaryofScientificProgress;?> </button>
  
    <button <?php if($rUConceptStages['KeyPersonnelEffort']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=KeyPersonnelEffort&id=<?php echo $id;?>'"><?php echo $lang_KeyPersonnelEffort;?> </button>
    
    <button <?php if($rUConceptStages['Publications']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'Publications')" id="defaultOpen"><?php echo $lang_Publications;?></button>
    
  


  
 
  
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
	
	var inp3 = new_row.cells[3].getElementsByTagName('input')[0];
    inp3.id += len;
    inp3.value = '';
	
	var inp4 = new_row.cells[4].getElementsByTagName('input')[0];
    inp4.id += len;
    inp4.value = '';
	
	
    new_row.cells[5].getElementsByTagName('input')[0].removeAttribute('style');
    x.appendChild( new_row );
}
</script>

<div id="Publications" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("progressreport_submit_now_final_button.php");?>
   
    
  <h3><?php echo $lang_Publications;?></h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $sessionusrm_id;?>" >
 <input type="hidden" name="projectID" value="<?php echo $rUserInvee['projectID'];?>" >
 <input type="hidden" name="progressID" value="<?php echo $rUserInvee['progressID'];?>" >

 <div class="container"><!--begin-->
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>



  
    <div class="row success">

    <div class="col-100">
    <label for="lname">
<?php echo $lang_chapters;?>
 
<span class="error">*</span></label><br />
<textarea id="MyTextBox14" name="chapters" placeholder="" style="height:150px" class="required" required><?php echo $rUserInv2['chapters'];?></textarea>
    </div>
  </div>
  
 <div class="row success">

    <div class="col-100">
    <label for="lname">
<?php echo $lang_meeting_abstracts;?>
 
<span class="error">*</span></label><br />






<table width="100%" border="0" id="POITable">
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <th><?php echo $lang_NameofMeeting;?></th>
            <th><?php echo $lang_abstract;?></th>
            <th><?php echo $lang_Location;?></th>
            <th><?php echo $lang_Title;?></th>
            <th><?php echo $lang_Date;?></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<!----><input type="hidden" name="f1" id="vvv" tabindex="4" class="required" minlength="5"/>

<textarea id="NameofMeeting" name="NameofMeeting[]" placeholder="" style="height:60px;width:175px; margin-bottom:5px;" class="required"></textarea>
</td>

<td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
<textarea id="abstract" name="abstract[]" placeholder="" style="height:60px;width:175px;" class="required"></textarea>
</td>

<td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
<textarea id="Location" name="Location[]" placeholder="" style="height:60px;width:175px;" class="required"></textarea>

</td>
<td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
<textarea id="Title" name="Title[]" placeholder="" style="height:60px;width:220px;" class="required"></textarea>
</td>
<td><input type="date" name="MeetingDate[]" id="MeetingDate" tabindex="4" class="required" minlength="5"/>
</td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>
        
        
      <?php
$sqlUsers2="SELECT * FROM ".$prefix."progress_meeting_abstracts where `owner_id`='$sessionusrm_id'  and  `is_sent`='0' order by meetingAbstractID desc limit 0,40";//conceptID='$conceptID'
$QueryUsers2 = $mysqli->query($sqlUsers2);
while($rUserInv2=$QueryUsers2->fetch_array()){
?>
 <tr>
            <td style=" display:none;">1</td>
            <td><?php echo $rUserInv2['NameofMeeting'];?></td>

<td><?php echo $rUserInv2['abstract'];?></td>

<td><?php echo $rUserInv2['Location'];?></td>
<td><?php echo $rUserInv2['Title'];?></td>
<td><?php echo $rUserInv2['MeetingDate'];?></td>
  
            <td></td>
            <td></td>
        </tr>   <?php }?>  
        
        

    </table>   







    </div>
  </div>
  
  
  
  <div class="row success">

    <div class="col-100">
    <label for="lname">
<?php echo $lang_other_presentations;?>
 
<span class="error">*</span></label><br />


<table width="100%" border="0" id="POITable2">
        <tr>
            <td style=" display:none;">&nbsp;</td>
             <th><?php echo $lang_NameofMeeting;?></th>
            <th><?php echo $lang_Location;?></th>
            <th><?php echo $lang_Title;?></th>
            <th><?php echo $lang_Date;?></th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <tr>
            <td style=" display:none;">1</td>
            <td>
<!----><input type="hidden" name="f1" id="vvv" tabindex="4" class="required" minlength="5"/>

<textarea id="Organizationofpublication" name="Organizationofpublication[]" placeholder="" style="height:60px;width:190px; margin-bottom:5px;" class="required"></textarea>
</td>

<td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
<textarea id="locationofpublication" name="locationofpublication[]" placeholder="" style="height:60px;width:190px;" class="required"></textarea>
</td>

<td><input type="hidden" name="f2" id="vvv" tabindex="4" class="required" minlength="5"/>
<textarea id="title" name="titleofpublication[]" placeholder="" style="height:60px;width:190px;" class="required"></textarea>

</td>

<td><input type="date" name="DateofMeeting[]" id="DateofMeeting" tabindex="4" class="required" minlength="5"/>
</td>
  
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow2(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow2()" style="font-size:12px;"/></td>
        </tr>


  <?php
$sqlUsers23="SELECT * FROM ".$prefix."progress_report_otherpresentations where `owner_id`='$sessionusrm_id'  and  `is_sent`='0' order by id desc limit 0,40";//conceptID='$conceptID'
$QueryUsers23 = $mysqli->query($sqlUsers23);
while($rUserInv23=$QueryUsers23->fetch_array()){
?>
 <tr>
            <td style=" display:none;">1</td>
            <td><?php echo $rUserInv23['Organization'];?></td>

<td><?php echo $rUserInv23['location'];?></td>

<td><?php echo $rUserInv23['title'];?></td>
<td><?php echo $rUserInv23['DateofMeeting'];?></td>

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