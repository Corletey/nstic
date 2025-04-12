<?php
?><div class="tab">
  

  <button <?php if($rProjectStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'reviewProjectTeam')" id="defaultOpen">Researcher Profile </button>
  
 
</div>


<div id="reviewProjectTeam" class="tabcontent">
 
  
  <?php
  $asrmApplctID2=$bt;
$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where piID='$bkey' order by piID desc limit 0,10";
$QueryUsers4 = $mysqli->query($sqlUsers4);
if($QueryUsers4->num_rows){
	$rUserInv2=$QueryUsers4->fetch_array();

?>
<div style="overflow-x:auto;">
  <table width="100%" border="0" id="customers">
  <tr>
    <th>Name</th>
    <th><?php echo $lang_Gender;?></th>
    <th><?php echo $lang_AgeRange;?></th>
    <th><?php echo $lang_Contacts;?></th>
    <th><?php echo $lang_Email;?></th>
    <th><?php echo $lang_Expertise;?></th>
    <!--    <th><?php echo $lang_ResearchExperience;?></th>
    <th><?php echo $$lang_RoleofTeamMember;?></th>
    <th><?php echo $lang_institution_of_affiliation;?></th>-->
  </tr>
  

  <tr>
    <td><?php echo $rUserInv2['Surname'];?> <?php echo $rUserInv2['Othername'];?></td>
    <td><?php echo $rUserInv2['Gender'];?></td>
    <td><?php echo $rUserInv2['AgeRange'];?></td>
    <td><?php echo $rUserInv2['Contacts'];?></td>
    <td><?php echo $rUserInv2['emailaddress'];?></td>
    <td><?php echo $rUserInv2['Expertise'];?></td>
    <?php /*?>    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td><?php echo $rUserInv2['InstitutionofAffiliation'];?></td><?php */?>
  </tr>
  <tr>
    <th><?php echo $lang_ResearchExperience;?></th>
    <th><?php echo $lang_ResearchExperience;?></th>
    <th><?php echo $$lang_RoleofTeamMember;?></th>
    <th colspan="2"><?php echo $lang_institution_of_affiliation;?></th>
    <th><?php echo $lang_Updatedon;?></th>
  
  </tr>
  

  <tr>
    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['ResearchExperienceDetails'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td colspan="2"><?php echo $rUserInv2['InstitutionofAffiliation'];?></td>
    <td><?php echo $rUserInv2['updatedon'];?></td>
    <?php /*?>    <td><?php echo $rUserInv2['ResearchExperience'];?></td>
    <td><?php echo $rUserInv2['RoleofTeamMember'];?></td>
    <td><?php echo $rUserInv2['InstitutionofAffiliation'];?></td><?php */?>
  </tr>
  


  
  
</table>
</div>

<?php }?>


<?php
$QRp6="select * from ".$prefix."education_history where piID='$bkey'";
$QRDp6=$mysqli->query($QRp6);
if($TotalsEduc=$QRDp6->num_rows){
?>
<div style="overflow-x:auto;">
<table width="100%" id="rounded-corner" summary="2007 Major IT Companies' Profit">
    <thead>
    	<tr>
        	<th scope="col"></th>
        
        	<th scope="col"><?php echo $lang_University;?></th>
        	<th scope="col"><?php echo $lang_Qualification;?></th>
            <th scope="col"><?php echo $lang_Year;?></th>
            <th scope="col"><?php echo $lang_Specialisation;?></th>
        </tr>
    </thead>

    <tbody>
    <?php
while($QR_Totalp6=$QRDp6->fetch_array())
{
	
	?>
    	<tr>
        	<td><input type="checkbox" name="" /></td>

       	  <td><?php echo $QR_Totalp6['rstug_educn_university'];?></td>
        	<td><?php echo $QR_Totalp6['rstug_educn_qualification'];?> </td>
        	<td><?php echo $QR_Totalp6['rstug_educn_year'];?> </td>
            <td><?php echo $QR_Totalp6['rstug_educn_specialisation'];?> </td>
       	</tr>
        <?php }?>
    </tbody>
</table></div><?php }?>


<div style="clear:both; height:10px;"></div>
<a href="./main.php?option=ListofResearchers" style="background-color:#06F; color:#fff;padding:5px;">Back</a>








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