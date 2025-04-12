<?php
///Get project Owner
///Get score ID
$wmOwner2="select * from ".$prefix."mscores_new where scoredmID='$id'";
$cmdOwner2 = $mysqli->query($wmOwner2);
$rowners2= $cmdOwner2->fetch_array();
$newconceptID=$rowners2['conceptm_id'];

$wmOwner="select * from ".$prefix."submissions_concepts where  conceptID='$newconceptID'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner= $cmdOwner->fetch_array();
if($cmdOwner->num_rows and $newconceptID){
$owner_id=$rowner['owner_id'];


?>

<?php if($_SESSION['usrm_usrtype']=='reviewer'){

if($_POST['doSubmit'])
{

$QnewMethods=$_POST['QnewMethods'];	
if($QnewMethods>=31){
$errmsg="Error!! <b>Scientific quality and innovation of the joint research proposal</b>: Question has exceeded 30%";
}
////////////////////////////////////////////////////////////////////////
$QhighQuality=$_POST['QhighQuality'];
if($QhighQuality>=16){
$errmsg="Error!! <b>Feasibility  of the joint  research  proposal (Practicality,   feasibility   and   consistency   of   proposed   activities   with   the objectives  of the call,  and feasibility  of the  methodology  provided)</b>: 15%";	
}
////////////////////////////////////////////////////////////////////////
$SatisfactoryPartnership=$_POST['SatisfactoryPartnership'];
if($SatisfactoryPartnership>=16){
$errmsg="Error!! <b>3. Added value  to expect  from  collaboration Technological  capacity  building</b> 15%";	
}
///////////////////////////////////////////////////////////////////////////
//$PrototypeClearly=$_POST['PrototypeClearly'];
//if($PrototypeClearly>=26){
//$errmsg="Error!! <b>Applicability</b>: Question (a) has exceeded 25";	
//}

////////////////////////////////////////////////////////////////
$AddressIssues=$_POST['AddressIssues'];
if($AddressIssues>=6){
$errmsg="Error!! <b>4. Competence, <?php echo $lang_Expertise;?> and experience of principal investigators and relevant  scientists  / research  teams</b>: Question exceeded 5%";	
}

/////////////////////////////////////////////////
$ClearlyConvincingly=$_POST['ClearlyConvincingly'];
if($ClearlyConvincingly>=16){
$errmsg="Error!! <b>5. Clarity of expected results</b>: Question (a) has exceeded 15%";		
}

////////////////////////////////////////////////////////////////////////////////
$GenderIssues=$_POST['GenderIssues'];
if($GenderIssues>=11){
$errmsg="Error!! Question 6 has exceeded 10%";	
}

$Potential=$_POST['Potential'];
if($Potential>=10){
$errmsg="Error!! Question Potential to promote equity and ethics of the joint project (5%)";	
}

$Budget=$_POST['Budget'];
if($Budget>=6){
$errmsg="Error!! Budget has exceeded 5%";	
}


/////////////////////////////////////
$EvTotalScore=($QnewMethods+$QhighQuality+$SatisfactoryPartnership+$AddressIssues+$ClearlyConvincingly+$GenderIssues+$Potential+$Budget);
//////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////
$conceptm_id=$mysqli->real_escape_string($_POST['conceptm_id']);
$ownermID=$mysqli->real_escape_string($_POST['owner_id']);
$overallcomment=$mysqli->real_escape_string($_POST['overallcomment']);
$comment1=$mysqli->real_escape_string($_POST['comment1']);
$comment2=$mysqli->real_escape_string($_POST['comment2']);
$comment3=$mysqli->real_escape_string($_POST['comment3']);
$comment4=$mysqli->real_escape_string($_POST['comment4']);
$comment5=$mysqli->real_escape_string($_POST['comment5']);
$comment6=$mysqli->real_escape_string($_POST['comment6']);
$commentnon=$mysqli->real_escape_string($_POST['commentnon']);
$comment7=$mysqli->real_escape_string($_POST['comment7']);

$Verdict=$mysqli->real_escape_string($_POST['Verdict']);
$categorym=$mysqli->real_escape_string($_POST['categorym']);
$conceptm_assignedto=$mysqli->real_escape_string($_POST['conceptm_assignedto']);

if(!$errmsg){
$queryScores="update ".$prefix."mscores_new set   `STQnewMethods`='$QnewMethods',`STQhighQuality`='$QhighQuality',`STQSatisfactoryPartnership`='$SatisfactoryPartnership',`AppAddressIssues`='$AddressIssues',`ImpactClearlyConvincingly`='$ClearlyConvincingly',`ImpactGenderIssues`='$GenderIssues',`EvTotalScore`='$EvTotalScore',`EvoverallComment`='$overallcomment',`EvComment1`='$comment1',`EvComment2`='$comment2',`EvComment3`='$comment3',`EvComment4`='$comment4',`EvComment5`='$comment5',`EvComment6`='$comment6',`Everdict`='$Verdict',`Potential`='$Potential',`Budget`='$Budget',`EvCommentnon`='$commentnon',`EvComment7`='$comment7' where `scoredmID`='$id' and `EvaluatedBy`='$conceptm_assignedto'";
$mysqli->query($queryScores);
//////////////////////////////////////////////////////////////////////////////////////////////
$message="<p class='success'><p>Successfully Evaluated. Total Score: <b>".$EvTotalScore."</b> Thank You</p>";



/*echo '<meta http-equiv="refresh" content="5; url='.$base_url.'main.php?option=dashboard/" />';*/
}


}//end checking permissions

}


$queryScore="select * from ".$prefix."mscores_new where scoredmID='$id' and EvaluatedBy='$usrm_id'";
$rs_Score=$mysqli->query($queryScore);
$rsScore=$rs_Score->fetch_array();
?>



<div class="tab">

   <button class="tablinks"onClick="window.location.href='./main.php?option=reviewProjectInformation&id=<?php echo $newconceptID;?>'"><?php echo $lang_new_ProjectInformation;?></button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptPrincipalInvestigator&id=<?php echo $newconceptID;?>'"><?php echo $lang_new_ProjectTeam;?></button>
  <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptIntroduction&id=<?php echo $newconceptID;?>'"><?php echo $lang_new_Introduction;?></button>
   <button class="tablinks" onClick="window.location.href='./main.php?option=ReviewconceptProjectDetails&id=<?php echo $newconceptID;?>'"><?php echo $lang_new_ProjectDetails;?></button>
  <button class="tablinks"  onClick="window.location.href='./main.php?option=ReviewconceptBudget&id=<?php echo $newconceptID;?>'"><?php echo $lang_new_Budget;?></button>
  <button class="tablinks"  onClick="window.location.href='./main.php?option=ReviewconceptReferences&id=<?php echo $newconceptID;?>'"><?php echo $lang_new_Citations;?></button>
  <button class="tablinks"  onclick="openCity(event, 'conceptScoreReviewersUpdate')" id="defaultOpen">Score Sheet </button>
  
</div>


<div id="conceptScoreReviewersUpdate" class="tabcontent">



  <h3><?php echo $lang_GiveScoretoConcept;?></h3><?php if($message){?><span style="color:#03F; font-size:18px;"><?php  echo $message;?></span> <?php }?>
  <?php if($errmsg){?><span style="color:#F00; font-size:18px;"><?php  echo $errmsg;?></span> <?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="asrmApplctID" value="<?php echo $id;?>">
  <input type="hidden" name="proposalTittle" value="<?php echo $rUserInv4['projectTitle'];?>">
  <input type="hidden" name="owner_id" value="<?php echo $rUserInv4['owner_id'];?>">
  <input type="hidden" name="conceptm_id" value="<?php echo $newconceptID;?>">
 <input type="hidden" name="conceptm_assignedto" value="<?php echo $usrm_id;?>">
 
<div class="container"><!--begin-->

  
  <label for="fname"><strong>Tick check box and Assign Reviewer</strong> (<span class="error">*</span>)</label>
  <div class="row success">

    <div class="col-100">
  
  
                                       
<table width="100%" border="0" id="customers">
  <tr>
    <th width="35%"><strong><?php echo $lang_Score;?></strong></th>
    <th width="49%"><strong><?php echo $lang_ProvideComments;?></strong></th>
  </tr>
  <tr><td colspan="2"><strong>1. Scientific quality and innovation of the joint research proposal (30%)</strong></td></tr>
  <tr>
    <td valign="top"><input name="QnewMethods" type="text" class="required number" maxlength="2" id="QnewMethods" autocomplete="off" value="<?php echo $rsScore['STQnewMethods'];?>"/> </td>
    <td valign="top"><textarea name="comment1" cols="40" rows="" id="comment1"><?php echo $rsScore['EvComment1'];?></textarea> </td>
  </tr>
  
   <tr><td colspan="2"><strong>2. Feasibility  of the joint research proposal (Practicality, feasibility and consistency of proposed activities with the objectives  of the call, and feasibility of the methodology provided) (15%) </strong></td></tr>

<tr>
    <td valign="top"><input name="QhighQuality" type="text" class="required number" maxlength="2" id="QhighQuality" autocomplete="off" value="<?php echo $rsScore['STQhighQuality'];?>"/> </td>
    <td valign="top"><textarea name="comment2" cols="40" rows="" id="comment2"><?php echo $rsScore['EvComment2'];?></textarea> </td>
  </tr>
  
 <tr><td colspan="2"><strong>3. Added value  to expect  from  collaboration Technological  capacity  building (15%)</strong></td></tr>
  
    <tr>
    <td valign="top"><input name="SatisfactoryPartnership" type="text" class="required number" maxlength="2" id="SatisfactoryPartnership" autocomplete="off" value="<?php echo $rsScore['STQSatisfactoryPartnership'];?>"/> </td>
    <td valign="top"><textarea name="comment3" cols="40" rows="" id="comment3"><?php echo $rsScore['EvComment3'];?></textarea> </td>
  </tr>
  
   
  
  
  <tr><td colspan="2"><strong>4. Competence, <?php echo $lang_Expertise;?> and experience of principal investigators and relevant  scientists  / research  teams (5%)</strong></td></tr>
  
  
   <tr>
    <td valign="top"><input name="AddressIssues" type="text" class="required number" maxlength="2" id="AddressIssues" autocomplete="off" value="<?php echo $rsScore['AppAddressIssues'];?>"/> </td>
    <td valign="top"><textarea name="comment4" cols="40" rows="" id="comment4"><?php echo $rsScore['EvComment4'];?></textarea> </td>
  </tr>
  
  
  <tr><td colspan="2"><strong>5. Clarity of expected results (15%)</strong></td></tr>
   <tr>
    <td valign="top"><input name="ClearlyConvincingly" type="text" class="required number" maxlength="2" id="ClearlyConvincingly" autocomplete="off" value="<?php echo $rsScore['ImpactClearlyConvincingly'];?>"/> </td>
    <td valign="top"><textarea name="comment5" cols="40" rows="" id="comment5"><?php echo $rsScore['EvComment5'];?></textarea> </td>
  </tr>
  
  <tr><td colspan="2"><strong>6. Relevance and impact of  research (Industrial Development, Technological Capacity Building, Marketing of Research Results, Agricultural Production,   Improved Health Outcomes, Economic  Growth  Improved  Livelihoods) (10%)</strong></td></tr>
  
   <tr>
    <td valign="top"><input name="GenderIssues" type="text" class="required number" maxlength="2" id="GenderIssues" autocomplete="off" value="<?php echo $rsScore['ImpactGenderIssues'];?>"/></td>
    <td valign="top"><textarea name="comment6" cols="40" rows="" id="comment6"><?php echo $rsScore['EvComment6'];?></textarea> </td>
  </tr>
  
  
   <tr><td colspan="2"><strong>6. Relevance and impact of  research (Industrial Development, Technological Capacity Building, Marketing of Research Results, Agricultural Production,   Improved Health Outcomes, Economic  Growth  Improved  Livelihoods) (10%)</strong><br />
   <strong>Potential to promote equity and ethics of the joint project (5%)</strong></td></tr>
   
    <tr>
    <td valign="top"><input name="Potential" type="text" class="required number" maxlength="2" id="Potential" autocomplete="off" value="<?php echo $rsScore['Potential'];?>"/></td>
    <td valign="top"><textarea name="commentnon" cols="40" rows="" id="commentnon"><?php echo $rsScore['EvCommentnon'];?></textarea> </td>
  </tr>
   
   <tr><td colspan="2"><strong>7. Budget (Consistency  with  the  budget  ratio  or  percentage  provided  by  the  appeal guide, Basis of  estimates - How  well the  proposed  expenses  reflect the actual  cost of the  proposed action?) (5%)</strong></td></tr>
   
     <tr>
    <td valign="top"><input name="Budget" type="text" class="required number" maxlength="2" id="Budget" autocomplete="off" value="<?php echo $rsScore['Budget'];?>"/></td>
    <td valign="top"><textarea name="comment7" cols="40" rows="" id="comment7"><?php echo $rsScore['EvComment7'];?></textarea> </td>
  </tr>
   <tr><td colspan="2"><p><strong><?php echo $lang_OverallComment;?></strong></p>
<textarea name="overallcomment" cols="40" rows="" id="commentoverall"><?php echo $rsScore['EvoverallComment'];?></textarea>
 <div class="clear"></div>
<p><strong><?php echo $lang_Verdict;?></strong></p>
<input name="Verdict" type="radio" value="Recommended for Consideration" class="required" <?php if($rsScore['Everdict']=='Recommended for Consideration'){?>checked="checked"<?php }?>/>&nbsp;&nbsp;<?php echo $lang_RecommendedforConsideration;?><br />

<input name="Verdict" type="radio" value="Not Recommended for Consideration" class="required" <?php if($rsScore['Everdict']=='Not Recommended for Consideration'){?>checked="checked"<?php }?>/>&nbsp;&nbsp;<?php echo $lang_NotRecommendedforConsideration;?>

</td></tr>
  
</table>



  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
    </div>
  </div>
  
 <div class="row success">
    <input type="submit" name="doSubmit" value="<?php echo $lang_new_Save;?>">
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
</script><?php }?>