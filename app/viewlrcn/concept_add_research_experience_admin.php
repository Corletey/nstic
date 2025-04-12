<?php if($session_usertype=='user'){?><div class="tab">

 <button class="tablinks"onClick="window.location.href='./main.php?option=SubmitConcept&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=conceptPrincipalInvestigator&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button>
    <button class="tablinks"  onclick="openCity(event, 'conceptIntroduction')" id="defaultOpen"><?php echo $lang_new_Introduction;?></button>
   <button class="tablinks" onClick="window.location.href='./main.php?option=conceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button>
  <button class="tablinks"  onClick="window.location.href='./main.php?option=conceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=conceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button>
</div><?php }?>


<?php if($session_usertype!='user'){?>
<div class="tab">
  
  <button class="tablinks"onClick="window.location.href='./main.php?option=reviewProjectInformation&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  <button class="tablinks" onclick="openCity(event, 'ReviewconceptPrincipalInvestigator')" id="defaultOpen"><?php echo $lang_new_ProjectTeam;?></button>
    <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptIntroduction&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button>
   <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptProjectDetails&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectDetails;?></button>
  <button class="tablinks"  onClick="window.location.href='./main.php?option=ReviewconceptBudget&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptReferences&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button>
</div><?php }?>

<div id="ReviewconceptPrincipalInvestigator" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
 <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?> 
   
  <h3>Project Team - <?php echo $lang_ResearchExperience;?></h3>
  
  <?php
  $asrmApplctID2=$usrm_id;
$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where `conceptm_id`='$id' order by piID desc limit 0,10";
$QueryUsers4 = $mysqli->query($sqlUsers4);
if($QueryUsers4->num_rows){

?>
<div style="overflow-x:auto;">
  <table width="100%" border="0" id="customers">
  <tr>
    <th>Name</th>
    <th>Gender</th>
    <th><?php echo $lang_AgeRange;?></th>
    <th><?php echo $lang_Contacts;?></th>
    <th><?php echo $lang_Expertise;?></th>
    <!--    <th><?php echo $lang_ResearchExperience;?></th>
    <th><?php echo $$lang_RoleofTeamMember;?></th>
    <th><?php echo $lang_institution_of_affiliation;?></th>-->
  </tr>
  
  <?php 

while($rUserInv2=$QueryUsers4->fetch_array()){
?>
  <tr>
    <td><?php echo $rUserInv2['Surname'];?> <?php echo $rUserInv2['Othername'];?></td>
    <td><?php echo $rUserInv2['Gender'];?></td>
    <td><?php echo $rUserInv2['AgeRange'];?></td>
    <td><?php echo $rUserInv2['<?php echo $lang_Contacts;?>'];?></td>
    <td><?php echo $rUserInv2['<?php echo $lang_Expertise;?>'];?></td>
    <?php /*?>    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td><?php echo $rUserInv2['InstitutionofAffiliation'];?></td><?php */?>
  </tr>
  <?php }?>
</table>
</div>

<?php }?>



<?php if($message){echo $message;}?>

<?php
$QRp6="select * from ".$prefix."research_experience where conceptm_id='$id'";
$QRDp6=$mysqli->query($QRp6);
if($TotalsEduc=$QRDp6->num_rows){
?>
<div style="overflow-x:auto;">
<table width="100%" id="rounded-corner" summary="2007 Major IT Companies' Profit">
    <thead>
    	<tr>
        	<th scope="col" class="rounded-company"></th>
        
        	<th scope="col" class="rounded"><?php echo $lang_ResearchExperience;?></th>

        </tr>
    </thead>

    <tbody>
    <?php
while($QR_Totalp6=$QRDp6->fetch_array())
{
	
	?>
    	<tr>
        	<td><input type="checkbox" name="" /></td>

       	  <td><?php echo $QR_Totalp6['details'];?></td>

       	</tr>
        <?php }?>
    </tbody>
</table></div><?php }?>











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