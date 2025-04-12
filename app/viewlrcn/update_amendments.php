<?php
$conceptID=$_GET['conceptID'];
$sessionusrm_id=$_SESSION['usrm_id'];
if($_POST['doSaveData'] and $_POST['projectID'] and $sessionusrm_id){

$projectID=$mysqli->real_escape_string($_POST['projectID']);
$Details=$mysqli->real_escape_string($_POST['Details']);
$wmConfirm="select * from ".$prefix."amendments where  owner_id='$sessionusrm_id' and projectID='$projectID' order by id desc";
$cmdwbConfirm = $mysqli->query($wmConfirm);
$totalStagesConfirm = $cmdwbConfirm->num_rows;
$rConfirm= $cmdwbConfirm->fetch_array();

if(!$totalStagesConfirm){
$sqlAmendment="insert into ".$prefix."amendments (`projectID`,`owner_id`,`grantID`,`Details`,`date_updated`,`is_sent`,`projectStatus`) 

values('$projectID','$sessionusrm_id','$grantID','$Details',now(),'0','Submitted')";
$mysqli->query($sqlAmendment);
}
if($totalStagesConfirm){
$sqlAmendmentupdate="update ".$prefix."amendments set Details='$Details' where `projectID`='$projectID' and `owner_id`='$sessionusrm_id'";
$mysqli->query($sqlAmendmentupdate);
}

for ($i=0; $i < count($_FILES['attachethicalapproval']['name']); $i++) {
$AttachmentName=$mysqli->real_escape_string($_POST['AttachmentName'][$i]);
$grantID=$mysqli->real_escape_string($_POST['grantID'][$i]);
$projectID=$mysqli->real_escape_string($_POST['projectID']);	
	
	if($_FILES['attachethicalapproval']['name'][$i]){
$attachethicalapproval = preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name'][$i]);
$attachethicalapproval2 = $asrmApplctID.$mysqli->real_escape_string(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name'][$i]));
$targetw1 = "./files/". basename($asrmApplctID.preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['name'][$i]));
$studytoolsext_main1 = move_uploaded_file(preg_replace('/\s+/', '_', $_FILES['attachethicalapproval']['tmp_name'][$i]), $targetw1);

$sqlA2="insert into ".$prefix."amendments_attachments (`projectID`,`owner_id`,`grantID`,`AttachmentName`,`Attachment`,`date_updated`,`is_sent`,`projectStatus`) 

values('$projectID','$sessionusrm_id','$grantID','$AttachmentName','$attachethicalapproval2',now(),'1','Submitted')";
$mysqli->query($sqlA2);	
	}

}

logaction("$session_fullname Submitted Amendments for project ID: $projectID");		


}//end post



if(isset($message)){echo $message;}
$wmConfirm2="select * from ".$prefix."amendments where  owner_id='$sessionusrm_id' and projectID='$id' order by id desc";
$cmdwbConfirm2 = $mysqli->query($wmConfirm2);
$rConfirm2= $cmdwbConfirm2->fetch_array();

?>
<div class="tab">

  <button onclick="openCity(event, 'submitProgressReport')" id="defaultOpen"><?php echo $lang_SubmitAmendments;?></button>

 
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
$sqlFeaturedCall = "SELECT * FROM ".$prefix."submissions_proposals where owner_id='$sessionusrm_id' order by projectID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
while($rFeaturedCall = $queryFeaturedCall->fetch_array()){
?>
<option value="<?php echo $rFeaturedCall['projectID'];?>" <?php if($rFeaturedCall['projectID']==$id){?>selected="selected"<?php }?>><?php echo $rFeaturedCall['projectTitle'];?></option>
<?php }?>
      </select>
    </div>
  </div>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $lang_Details;?> <span class="error">*</span></label>
<textarea name="Details" cols="" rows="" placeholder="<?php echo $lang_Details;?>" class="requireds"><?php echo $rConfirm2['Details'];?></textarea>
    </div>
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
$sqlUsers24="SELECT * FROM ".$prefix."amendments_attachments where `owner_id`='$sessionusrm_id'  and  `projectID`='$id' order by id desc limit 0,40";//conceptID='$conceptID'
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