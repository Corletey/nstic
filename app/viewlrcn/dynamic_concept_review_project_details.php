<?php
///Get project Owner
$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$conceptID'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $id){
$owner_id=$rowner['owner_id'];

$wm="select * from ".$prefix."review_concents where  owner_id='$owner_id'  and conceptID='$conceptID' and reviewer_id='$usrm_id'";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$r= $cmdwb->fetch_array();

if($totalStages and $session_usertype!='user'){
$sqlASubmissionStages="update ".$prefix."review_concents  set `ProjectDetails`='1' where `owner_id`='$owner_id'  and conceptID='$conceptID' and reviewer_id='$usrm_id'";
$mysqli->query($sqlASubmissionStages);
}



$sqlUsers2="SELECT * FROM ".$prefix."project_details_concept where `owner_id`='$owner_id' and `conceptID`='$conceptID' order by id desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$rUserInv2=$QueryUsers2->fetch_array();

$sessionusrm_id=$_SESSION['usrm_id'];
$wConceptStages="select * from ".$prefix."review_concents where reviewer_id='$sessionusrm_id' and reviewer_id='$usrm_id'  and conceptID='$conceptID'";
$cmConceptStages = $mysqli->query($wConceptStages);
$rUConceptStages=$cmConceptStages->fetch_array();

$sqlDynamic="SELECT * FROM ".$prefix."concept_dynamic_questions_all_c where grantID='$id' order by id asc";
	$QueryDynamic = $mysqli->query($sqlDynamic);
	$rowsDynamic=$QueryDynamic->fetch_array();
?><div class="tab">

<?php require_once("dynamic_categories.php");?>

<?php if($total_Information){?><button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newreviewProjectInformation&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectInformation;?></button><?php }?>
 
<?php if($total_Team){?><button <?php if($rUConceptStages['PrincipalInvestigator']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptPrincipalInvestigator&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_ProjectTeam;?></button><?php }?>
  
<?php if($total_Introduction){?><button <?php if($rUConceptStages['Introduction']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptIntroduction&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Introduction;?></button><?php }?>
    
<?php if($total_Background){?><button <?php if($rUConceptStages['ProjectDetails']==1){?>class="tablinks"<?php }?>  onclick="openCity(event, 'newReviewconceptProjectDetails')" id="defaultOpen"><?php echo $lang_new_ProjectDetails;?></button><?php }?>
   
<?php if($total_Budget){?><button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newReviewconceptBudget&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Budget;?></button><?php }?>
  
<?php if($total_Citations){?><button <?php if($rUConceptStages['cReferences']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptReferences&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_new_Citations;?></button><?php }?>
  
<?php if($total_Attachments){?><button <?php if($rUConceptStages['Attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newReviewconceptAttachments&conceptID=<?php echo $conceptID;?>&id=<?php echo $id;?>'"><?php echo $lang_ViewAttachment;?> </button><?php }?>
</div>


<div id="newReviewconceptProjectDetails" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
<?php if($session_usertype=='superadmin' || $session_usertype=='admin'){include("concept_assign_button_admin.php"); include("concept_assign_button_admin2.php");}?>
 <?php if($session_usertype=='reviewer'){include("concept_score_reviewer.php");}?>    
  <h3><?php echo $lang_new_ProjectDetails;?></h3>



 <div class="container"><!--begin-->
 <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>

  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsDynamic['qn_category_of_beneficiary'];?></label>

      
      
      
      <div style="overflow-x:auto;">

<?php
$sqlUsers3="SELECT * FROM ".$prefix."project_primary_beneficiaries where `owner_id`='$owner_id' and `conceptID`='$conceptID' order by id desc limit 0,10";
$QueryUsers3 = $mysqli->query($sqlUsers3);
$totalUsers3 = $QueryUsers3->num_rows;

if(!$totalUsers3){$required='required';}
if($totalUsers3){$required='';}
?>


<?php if($totalUsers3 = $QueryUsers3->num_rows){
	$count=0;?>
  <table id="customers" border="0">
        <tr>
            <th class="whitebg">&nbsp;No&nbsp;</th>
            <th>Category of beneficiary</th>
            <th>Gender</th>
            <th>Quantities</th>
            <th>Location of beneficiaries</th>
            </tr>      
<?php
if($category=='conceptProjectDetailsDel'){
$mid=$mysqli->real_escape_string($_GET['id']);
$qRDel2="delete from ".$prefix."project_primary_beneficiaries where `owner_id`='$owner_id' and `conceptID`='$conceptID'";
$mysqli->query($qRDel2);
}
 
while($rUserInv3=$QueryUsers3->fetch_array()){$count++;?>
<tr>
<td class="whitebg" style="padding-left:5px;"><?php echo $count;?></td>
<td><?php echo $rUserInv3['Categoryofbeneficiary'];?> <?php if($rUserInv3['OthersCategory']){ echo "<br>".$rUserInv3['OthersCategory'];}?></td>
<td><?php echo $rUserInv3['Gender'];?> <?php if($rUserInv3['OthersGender']){ echo "<br>".$rUserInv3['OthersGender'];}?></td>
<td><?php echo $rUserInv3['Quantities'];?></td>
<td><?php echo $rUserInv3['Locationofbeneficiaries'];?></td>
</tr>
<?php }?></table><?php }//end totals?>


</div>
      
      
      
    </div>
  </div>
  <div class="row success">

    <div class="col-100">
    <label for="lname">15. <?php echo $rowsDynamic['qn_methodology'];?></label><br>
<strong><?php echo nl2br($rUserInv2['Methodology']);?></strong>
    </div>
  </div>


  <div class="row success">

    <div class="col-100">
    <label for="lname">16. <?php echo $rowsDynamic['qn_scientificsolution'];?> </label><br>
    <strong><?php echo nl2br($rUserInv2['solution']);?></strong>
    </div>
  </div>
  
  
  <div class="row success">

    <div class="col-100">
    <label for="lname">17. <?php echo $rowsDynamic['qn_specialinterestgroup'];?> </label><br>
      <strong><?php echo nl2br($rUserInv2['SpecialInterestGroup']);?></strong>
    </div>
  </div>
  
    <div class="row success">

    <div class="col-100">
    <label for="lname">18. <?php echo $rowsDynamic['qn_PartnershipsCollaborations'];?>
</label><br>
<strong><?php echo nl2br($rUserInv2['PartnershipsCollaborations']);?></strong>
    </div>
  </div>
  
      <div class="row success">

    <div class="col-100">
    <label for="lname"><?php echo $lang_new_ExpectedIntellectualProperty;?>
</label><br />
<?php
$shcategoryID4=$rUserInv2['ExpectedIntellectualProperty'];
$categoryChunks = explode("-", $shcategoryID4);
$chop1="$categoryChunks[0]";
$chop2="$categoryChunks[1]";
$chop3="$categoryChunks[2]";
$chop4="$categoryChunks[3]";
$chop5="$categoryChunks[4]";
?>
<strong><?php if($chop1){echo $chop1.'<br>';}?>
<?php if($chop2){echo $chop2.'<br>';}?>
<?php if($chop3){echo $chop3.'<br>';}?>
<?php if($chop4){echo $chop4.'<br>';}?>
<?php if($chop5){echo $chop5.'<br>';}?></strong>


    </div>
  </div>
  
       <div class="row success">

    <div class="col-100">
    <label for="lname">20. Counterpart Funding by Host Institution (Figures)</label>
    <br />
<label for="lname">a) <?php echo $lang_PrimaryFunder;?></label>
 <div style="overflow-x:auto;">

<table width="100%" border="0" id="customers2">
        <tr>
            <th width="48%"><?php echo $lang_new_Name;?></th>
            <th width="52%"><?php echo $lang_new_Amount;?></th>
        </tr>
        <tr>
            <td><strong><?php echo $rUserInv2['PrimaryFunderName'];?></strong></td>
       
              <td><strong><?php echo $rUserInv2['PrimaryFunderAmount'];?></strong>
           </td>
        </tr>
    </table>
</div>

<label for="lname">b) <?php echo $lang_new_SecondaryFunder;?></label>

 <div style="overflow-x:auto;">

<table width="100%" border="0" id="customers2">
        <tr>
            <th width="48%"><?php echo $lang_new_Name;?></th>
            <th width="52%"><?php echo $lang_new_Amount;?></th>
        </tr>
        <tr>
            <td><strong><?php echo $rUserInv2['SecondaryFunderName'];?></strong></td>
       
              <td><strong><?php echo $rUserInv2['SecondaryFunderAmount'];?></strong>
           </td>
        </tr>
    </table>
</div>




<label for="lname">b) <?php echo $lang_new_CounterpartFunding;?></label>
 <div style="overflow-x:auto;">

<table width="100%" border="0" id="customers2">
        <tr>
            <th width="48%"><?php echo $lang_new_Name;?></th>
            <th width="52%"><?php echo $lang_new_Amount;?></th>
        </tr>
        <tr>
            <td><strong><?php echo $rUserInv2['CounterpartFundingName'];?></strong></td>
       
              <td><strong><?php echo $rUserInv2['CounterpartFundingAmount'];?></strong>
           </td>
        </tr>
    </table>
</div>


    </div>
  </div>

 


  
</div><!--End-->






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
</script><?php }?>