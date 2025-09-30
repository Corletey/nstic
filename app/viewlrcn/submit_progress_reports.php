<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];
if($_POST['doSaveData']=='Save and Next' and $_POST['projectID'] and $sessionusrm_id){

for ($i=0; $i < count($_POST['projectQuarter']); $i++) {
$projectQuarter.=$mysqli->real_escape_string($_POST['projectQuarter'][$i]).',';
}
	
	$projectID=$mysqli->real_escape_string($_POST['projectID']);
	//$projectQuarter=$mysqli->real_escape_string($_POST['projectQuarter']);
	$Institution=$mysqli->real_escape_string($_POST['Institution']);
	$InstitutionAddress=$mysqli->real_escape_string($_POST['InstitutionAddress']);
	$InstitutionTelephone=$mysqli->real_escape_string($_POST['InstitutionTelephone']);
	$InstitutionEmail=$mysqli->real_escape_string($_POST['InstitutionEmail']);
	$InstitutionWebsite=$mysqli->real_escape_string($_POST['InstitutionWebsite']);
//$sessionusrm_id

$sqlUsers="SELECT * FROM ".$prefix."progress_report_signature_page where `owner_id`='$sessionusrm_id' and `projectID`='$projectID' and `is_sent`='0' order by progressID desc limit 0,1";
		$QueryUsers = $mysqli->query($sqlUsers);
		$totalUsers = $QueryUsers->num_rows;
		$rUserInv=$QueryUsers->fetch_array();

	
if(!$totalUsers){
$sqlA2="insert into ".$prefix."progress_report_signature_page (`projectID`,`owner_id`,`projectQuarter`,`reportType`,`Institution`,`InstitutionAddress`,`InstitutionTelephone`,`InstitutionEmail`,`InstitutionWebsite`,`is_sent`,`reportStatus`,`submissionDate`) 

values('$projectID','$sessionusrm_id','$projectQuarter','$projectQuarter','$Institution','$InstitutionAddress','$InstitutionTelephone','$InstitutionEmail','$InstitutionWebsite','0','Pending',now())";
$mysqli->query($sqlA2);
$record_id = $mysqli->insert_id;

if($record_id>=1){
$message='<p class="success">Dear '.$session_fullname.', details have been submitted.</p>';
/*echo("<script>location.href = '".$base_url."'main.php?option=Abstract';</script>");*/
logaction("$session_fullname Submitted Progress Report for project ID: $projectID");
}
}

if($totalUsers){
$sqlA2="update ".$prefix."progress_report_signature_page  set `projectQuarter`='$projectQuarter',`reportType`='$projectQuarter',`Institution`='$Institution',`InstitutionAddress`='$InstitutionAddress',`InstitutionTelephone`='$InstitutionTelephone',`InstitutionEmail`='$InstitutionEmail',`InstitutionWebsite`='$InstitutionWebsite',`submissionDate`=now() where `projectID`='$projectID' and `owner_id`='$sessionusrm_id' and `is_sent`='0'";
$mysqli->query($sqlA2);
$message='<p class="success">Dear '.$session_fullname.', details have been submitted.</p>';









logaction("$session_fullname updated Progress Report for project ID: $projectID");	
	
}

///Add education Details
if($record_id){
$record_id=$record_id;	
}
if(!$record_id){
$record_id=$id;	
}
for ($i=0; $i < count($_POST['Objectives']); $i++ and $record_id) {
	
	if($record_id>=1){
$Objectives=$mysqli->real_escape_string($_POST['Objectives'][$i]);
$Inputs=$mysqli->real_escape_string($_POST['Inputs'][$i]);
$Activities=$mysqli->real_escape_string($_POST['Activities'][$i]);
$Outputs=$mysqli->real_escape_string($_POST['Outputs'][$i]);
$Outcomes=$mysqli->real_escape_string($_POST['Outcomes'][$i]);
$Impact=$mysqli->real_escape_string($_POST['Impact'][$i]);
$Assumptions=$mysqli->real_escape_string($_POST['Assumptions'][$i]);

$Insert_QR2="insert into ".$prefix."progress_report (`projectID`,`owner_id`,`progressID`,`Objectives`,`Inputs`,`Activities`,`Outputs`,`Outcomes`,`Impact`,`Assumptions`,`date_added`) values ('$projectID','$sessionusrm_id','$record_id','$Objectives','$Inputs','$Activities','$Outputs','$Outcomes','$Impact','$Assumptions',now())";
$mysqli->query($Insert_QR2);
	}

}


for ($i=0; $i < count($_FILES['attachethicalapproval']['name']); $i++) {
$AttachmentName=$mysqli->real_escape_string($_POST['AttachmentName'][$i]);	
	
	if($record_id>=1){
$attachethicalapproval = preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name'][$i]);
$attachethicalapproval2 = $asrmApplctID.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name'][$i]));
$targetw1 = "./files/". basename($asrmApplctID.preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name'][$i]));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['tmp_name'][$i]), $targetw1);

$sqlA2="insert into ".$prefix."progress_report_attachments (`projectID`,`owner_id`,`progressID`,`AttachmentName`,`Attachment`,`date_updated`) 

values('$projectID','$sessionusrm_id','$record_id','$AttachmentName','$attachethicalapproval2',now())";
$mysqli->query($sqlA2);	
	}
	
}

$wm="select * from ".$prefix."progress_report_stages where  owner_id='$sessionusrm_id' and status='new'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();
if(!$totalStages and $record_id){
$sqlASubmissionStages="insert into ".$prefix."progress_report_stages (`projectID`,`progressID`,`owner_id`,`SignaturePage`,`Abstract`,`SummaryofScientificProgress`,`KeyPersonnelEffort`,`Publications`,`PatentsandLicenses`,`status`)  values('$projectID','$record_id','$sessionusrm_id','1','0','0','0','0','0','new')";
$mysqli->query($sqlASubmissionStages);
/*echo("<script>location.href = '".$base_url."'main.php?option=Abstract';</script>");*/
}
if($totalStages){
$sqlASubmissionStages="update ".$prefix."progress_report_stages  set `SignaturePage`='1' where `owner_id`='$sessionusrm_id' and status='new'";
$mysqli->query($sqlASubmissionStages);
/*echo("<script>location.href = '".$base_url."'main.php?option=Abstract';</script>");*/
}


}//end post



if(isset($message)){echo $message;}

$sqlUsers2="SELECT * FROM ".$prefix."progress_report_signature_page where `owner_id`='$sessionusrm_id'  and  `is_sent`='0' order by progressID desc limit 0,1";//conceptID='$conceptID'
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();
$progressID=$rUserInv2['progressID'];

$shcategoryID12=$rUserInv2['projectQuarter'];
$categoryChunksss = explode(",", $shcategoryID12);

$chops1="$categoryChunksss[0]";
$chops2="$categoryChunksss[1]";
$chops3="$categoryChunksss[2]";
$chops4="$categoryChunksss[3]";
$chops5="$categoryChunksss[4]";
$chops6="$categoryChunksss[5]";
$chops7="$categoryChunksss[6]";
$chops8="$categoryChunksss[7]";

$wConceptStages="select * from ".$prefix."progress_report_stages where  owner_id='$sessionusrm_id' and status='new' order by id desc";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();

?>
<div class="tab">

  <button <?php if($rUConceptStages['SignaturePage']==1){?>class="tablinks"<?php }?> onclick="openCity(event, 'submitProgressReport')" id="defaultOpen"><?php echo $lang_SignaturePage;?></button>
  
 <?php if($totalUsers){?> 
    <button <?php if($rUConceptStages['Abstract']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=Abstract&id=<?php echo $id;?>'"><?php echo $lang_abstract;?></button>
  
  <button <?php if($rUConceptStages['SummaryofScientificProgress']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=SummaryofScientificProgress/<?php echo $id;?>/'"><?php echo $lang_SummaryofScientificProgress;?> </button>
  
    <button <?php if($rUConceptStages['KeyPersonnelEffort']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=KeyPersonnelEffort&id=<?php echo $id;?>'"><?php echo $lang_KeyPersonnelEffort;?> </button>
    
    <button <?php if($rUConceptStages['Publications']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=Publications&id=<?php echo $id;?>'"><?php echo $lang_Publications;?></button>
    
 <?php }?>
 
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
   
   new_row.cells[8].getElementsByTagName('input')[0].removeAttribute('style');
	

	
    x.appendChild( new_row );
}

function deleteRow(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable').deleteRow(-1);
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
   
   new_row.cells[3].getElementsByTagName('input')[0].removeAttribute('style');
	

	
    x.appendChild( new_row );
}

function deleteRow2(row)
{
    var i=row.parentNode.parentNode.rowIndex;
    document.getElementById('POITable2').deleteRow(-1);
	//document.getElementById("myTable").deleteRow(0);
}
</script>
 
  
 
  
</div>

<div id="submitProgressReport" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("progressreport_submit_now_final_button.php");?>
   
    
  <h3><?php echo $lang_new_ProjectInformation;?></h3>

 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="asrmApplctID" value="<?php echo $sessionusrm_id;?>" >

 <div class="container"><!--begin-->
  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>

  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $lang_ProjectTitle;?> <span class="error">*</span></label>
      <select id="country" name="projectID" class="requiredm" required>
      <option value=""><?php echo $lang_please_select;?></option>
       <?php
$sqlFeaturedCall = "SELECT * FROM ".$prefix."submissions_proposals where owner_id='$sessionusrm_id' and awarded='yes' order by projectID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
while($rFeaturedCall = $queryFeaturedCall->fetch_array()){
?>
<option value="<?php echo $rFeaturedCall['projectID'];?>" <?php if($rFeaturedCall['projectID']==$rUserInv2['projectID']){?>selected="selected"<?php }?>><?php echo $rFeaturedCall['projectTitle'];?></option>
<?php }?>
      </select>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_ProjectReport;?>  <span class="error">*</span></label><br />
 <input name="projectQuarter[]" type="checkbox" value="1st" <?php if($chops1=='1st' || $chops2=='1st' || $chops3=='1st' || $chops4=='1st' || $chops5=='1st' || $chops6=='1st' || $chops7=='1st' || $chops8=='1st'){?>checked="checked"<?php }?>/> <?php echo $lang_1stQuarter;?><br />
 <input name="projectQuarter[]" type="checkbox" value="2nd" <?php if($chops1=='2nd' || $chops2=='2nd' || $chops3=='2nd' || $chops4=='2nd' || $chops5=='2nd' || $chops6=='2nd' || $chops7=='2nd' || $chops8=='2nd'){?>checked="checked"<?php }?>/> <?php echo $lang_2ndQuarter;?><br />
 <input name="projectQuarter[]" type="checkbox" value="3rd" <?php if($chops1=='3rd' || $chops2=='3rd' || $chops3=='3rd' || $chops4=='3rd' || $chops5=='3rd' || $chops6=='3rd' || $chops7=='3rd' || $chops8=='3rd'){?>checked="checked"<?php }?>/> <?php echo $lang_3rdQuarter;?><br />
 <input name="projectQuarter[]" type="checkbox" value="4th"<?php if($chops1=='4th' || $chops2=='4th' || $chops3=='4th' || $chops4=='4th' || $chops5=='4th' || $chops6=='4th' || $chops7=='4th' || $chops8=='4th'){?>checked="checked"<?php }?>/> <?php echo $lang_4thQuarter;?><br />
 
 <input name="projectQuarter[]" type="checkbox" value="Mid Year Report" <?php if($chops1=='Mid Year Report' || $chops2=='Mid Year Report' || $chops3=='Mid Year Report' || $chops4=='Mid Year Report' || $chops5=='Mid Year Report' || $chops6=='Mid Year Report' || $chops7=='Mid Year Report' || $chops8=='Mid Year Report'){?>checked="checked"<?php }?>/> <?php echo $lang_MidYearReport;?><br />
 
 <input name="projectQuarter[]" type="checkbox" value="Annual Report" <?php if($chops1=='Annual Report' || $chops2=='Annual Report' || $chops3=='Annual Report' || $chops4=='Annual Report' || $chops5=='Annual Report' || $chops6=='Annual Report' || $chops7=='Annual Report' || $chops8=='Annual Report'){?>checked="checked"<?php }?>/> <?php echo $lang_AnnualReport;?><br />
 <input name="projectQuarter[]" type="checkbox" value="Project Closure Report" <?php if($chops1=='Project Closure Report' || $chops2=='Project Closure Report' || $chops3=='Project Closure Report' || $chops4=='Project Closure Report' || $chops5=='Project Closure Report' || $chops6=='Project Closure Report' || $chops7=='Project Closure Report' || $chops8=='Project Closure Report'){?>checked="checked"<?php }?>/> <?php echo $lang_ProjectClosureReport;?><br />
 
 <input name="projectQuarter[]" type="checkbox" value="Accountability Reports" <?php if($chops1=='Accountability Reports' || $chops2=='Accountability Reports' || $chops3=='Accountability Reports' || $chops4=='Accountability Reports' || $chops5=='Accountability Reports' || $chops6=='Accountability Reports' || $chops7=='Accountability Reports' || $chops8=='Accountability Reports'){?>checked="checked"<?php }?>/> <?php echo $lang_AccountabilityReports;?><br />
 
    </div>
  </div>

  
    <div class="row success">
    <p><?php echo $one_Entry_perRow;?></p>

<table width="100%" border="0" id="POITable" class="customers3">
        <tr>
            <th style="">&nbsp;</th>
            <th><?php echo $lang_Objectives;?></th>
            <th><?php echo $lang_Inputs;?></th>
            <th><?php echo $lang_Activities;?></th>
            <th><?php echo $lang_Outputs;?></th>
            <th><?php echo $lang_Outcomes;?></th>
            <th><?php echo $lang_Impact;?></th>
            <th><?php echo $lang_Assumptions;?></th>

            <th>&nbsp; </th>
             <th>&nbsp; </th>
        </tr>
        <tr>
            <td style="">1</td>
            <td>
<input type="hidden" name="educn_university[]" id="vvv" tabindex="4" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;" required title="Minimum Length 8 characters" placeholder="Minimum Length 8 characters"/>

<textarea name="Objectives[]" cols="" rows="" placeholder="<?php echo $lang_Objectives;?>" class="requireds"></textarea>


            </td>
            <td><input type="hidden" name="educn_university[]" id="vvv" tabindex="4" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;" required title="Minimum Length 8 characters" placeholder="Minimum Length 8 characters"/>
            
            <textarea name="Inputs[]" cols="" rows="" placeholder="<?php echo $lang_Inputs;?>" class="requireds"></textarea>
          
  
  
            <td><textarea name="Activities[]" cols="" rows="" placeholder="<?php echo $lang_Activities;?>" class="requireds"></textarea></td>
  
  
   <td>
<textarea name="Outputs[]" cols="" rows="" placeholder="<?php echo $lang_Outputs;?>" class="requireds"></textarea>
</td>

              <td>
            <textarea name="Outcomes[]" cols="" rows="" placeholder="<?php echo $lang_Outcomes;?>" class="requireds"></textarea>
            </td>
            
            <td>
           <textarea name="Impact[]" cols="" rows="" placeholder="<?php echo $lang_Impact;?>" class="requireds"></textarea>
            </td>
            
            <td>
           <textarea name="Assumptions[]" cols="" rows="" placeholder="<?php echo $lang_Assumptions;?>" class="requireds"></textarea>
            </td>
           
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow()" style="font-size:12px;"/></td>
        </tr>
        
        
         <?php
		 $countm=0;
$sqlUsers23="SELECT * FROM ".$prefix."progress_report where `owner_id`='$sessionusrm_id'  and  `progressID`='$progressID' order by id desc limit 0,40";//conceptID='$conceptID'
$QueryUsers23 = $mysqli->query($sqlUsers23);
while($rUserInv23=$QueryUsers23->fetch_array()){
	$countm++;
?>
 <tr>
            <td><?php echo $countm;?></td>
<td><?php echo $rUserInv23['Objectives'];?></td>

<td><?php echo $rUserInv23['Inputs'];?></td>

<td><?php echo $rUserInv23['Activities'];?></td>
<td><?php echo $rUserInv23['Outputs'];?></td>

<td><?php echo $rUserInv23['Outcomes'];?></td>
<td><?php echo $rUserInv23['Impact'];?></td>

<td><?php echo $rUserInv23['Assumptions'];?></td>


             <td></td>
            <td></td>
        </tr>   <?php }?>  

    </table>
    
  </div>
  

  <div class="row success">
    <p><?php echo $one_Attachment_perRow;?></p>

<table width="100%" border="0" id="POITable2" class="customers3">
        <tr>
            <th style="">&nbsp;</th>
            <th><?php echo $lang_nameof_attachment;?></th>
       <th><?php echo $lang_Attachments;?></th>
          

            <th>&nbsp; </th>
             <th>&nbsp; </th>
        </tr>
        <tr>
            <td style="">1</td>
            <td>
<input type="hidden" name="educn_university[]" id="vvv" tabindex="4" class="requireds" style="border:1px solid #7F9DB9;background:url(./images/fmbg.jpg);padding:5px; width:200px;" required title="Minimum Length 8 characters" placeholder="Minimum Length 8 characters"/>

<textarea name="AttachmentName[]" cols="" rows="" placeholder="<?php echo $lang_nameof_attachment;?>" class="requireds"></textarea>


            </td>
                <td>

<input name="attachethicalapproval[]" type="file" />

            </td>       
        
           
            <td><input type="button" id="delPOIbutton" value="Delete" onClick="deleteRow2(this)" style="display:none; font-size:12px;"/></td>
            <td><input type="button" id="addmorePOIbutton" value="Add Rows" onClick="insRow2()" style="font-size:12px;"/></td>
        </tr>
        
        
                <?php
$count=0;
$sqlUsers24="SELECT * FROM ".$prefix."progress_report_attachments where `owner_id`='$sessionusrm_id'  and  `progressID`='$progressID' order by id desc limit 0,40";//conceptID='$conceptID'
$QueryUsers24 = $mysqli->query($sqlUsers24);
while($rUserInv24=$QueryUsers24->fetch_array()){
	$count++;
?>
 <tr>
            <td><?php echo $count;?></td>
<td><?php echo $rUserInv24['AttachmentName'];?></td>

<td><a href="./files/<?php echo $rUserInv24['Attachment'];?>" target="_blank"><?php echo $rUserInv24['Attachment'];?></a></td>


             <td></td>
            <td></td>
        </tr>   <?php }?>  
    </table>
    
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