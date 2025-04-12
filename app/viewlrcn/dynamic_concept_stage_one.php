<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$mysqli->real_escape_string($_GET['categoryID']);


if($_POST['doSaveData']=='Save and Next'){
$owner_id=$mysqli->real_escape_string($_POST['usrm_id']);
$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$grantID=$mysqli->real_escape_string($_POST['grantID']);
$project_title=$mysqli->real_escape_string($_POST['projecttitle']);
$initialtotalBudget=$mysqli->real_escape_string($_POST['totalBudget']);

$sqlUsersCall="SELECT * FROM ".$prefix."grantcalls where category='concepts' order by grantID desc limit 0,1";
		$QueryUsersCall = $mysqli->query($sqlUsersCall);
		$rUserInvCall=$QueryUsersCall->fetch_array();
		$shortacronym=$rUserInvCall['shortacronym'];
		if(!$id){$grantcallID=$rUserInvCall['grantID'];
		
		
		}
		if($id){$grantcallID=$id;
		}
		
//What is the project title
$sqlTitles4="SELECT * FROM ".$prefix."dynamic_concept_titles order by dconceptID desc";
$QueryTitles4 = $mysqli->query($sqlTitles4);
$rUserInv4=$QueryTitles4->fetch_array();

$mmCOnecpt=$rUserInv4['dconceptID']+1;
$referenceNo="$shortacronym".date("Y").$rUserCategory['rstugshort1']."0".$mmCOnecpt;


$sqlTitles="SELECT * FROM ".$prefix."dynamic_concept_titles where  `owner_id`='$sessionusrm_id' and `is_sent`='0' order by dconceptID desc";
$QueryTitles = $mysqli->query($sqlTitles);
$rUserInv=$QueryTitles->fetch_array();

if(!$QueryTitles->num_rows){
$sqlA2="insert into ".$prefix."dynamic_concept_titles (`owner_id`,`grantID`,`project_title`,`referenceNo`,`projectStatus`,`finalSubmission`,`dateUpdated`,`is_sent`,`categoryID`) 

values('$sessionusrm_id','$grantID','$project_title','$referenceNo','Pending Final Submission','Pending Final Submission',now(),'0','$categoryID')";
$mysqli->query($sqlA2);	

}


$sqlTitles2="SELECT * FROM ".$prefix."dynamic_concept_titles where `owner_id`='$sessionusrm_id' and `is_sent`='0' order by dconceptID desc";
$QueryTitles2 = $mysqli->query($sqlTitles2);
//sleep(1);
$rUserInv22=$QueryTitles2->fetch_array();
$mdconceptID=$rUserInv22['dconceptID'];

for ($i=0; $i < count($_POST['home']); $i++) {
$question_no=$_POST['home'][$i];
 /////////////////////////insert all details////////////
$updateanswerID=$_POST['answerID'.$question_no];
 
 if($_POST['Answer'.$question_no]){
$winningAnswer=$mysqli->real_escape_string($_POST['Answer'.$question_no]); 
 
$sqlUsers="SELECT * FROM ".$prefix."grantcall_qn_answers_concept where `questionID`='$question_no' and `usrm_id`='$sessionusrm_id' and `is_sent`='0' order by answerID desc";
$QueryUsers = $mysqli->query($sqlUsers);

if(!$QueryUsers->num_rows){// and $QueryTitles2->num_rows
	
$sqlA2="insert into ".$prefix."grantcall_qn_answers_concept (`questionID`,`categoryID`,`answer`,`usrm_id`,`status`,`categorym`,`grantID`,`dateupdated`,`is_sent`,`dconceptID`) 

values('$question_no','$categoryID','$winningAnswer','$sessionusrm_id','new','concept','$grantID',now(),'0','$mdconceptID')";
$mysqli->query($sqlA2);	
$record_id = $mysqli->insert_id;
$record_id2.=$mysqli->insert_id;
}//end submit
 }


if($QueryUsers->num_rows and $updateanswerID and $sessionusrm_id){
$sqlAUpdate="update ".$prefix."grantcall_qn_answers_concept set `answer`='$winningAnswer' where `grantID`='$grantID' and answerID='$updateanswerID' and usrm_id='$sessionusrm_id' and answerID='$updateanswerID'";
$mysqli->query($sqlAUpdate);	


////////////////////Now UPDATE
}//end submit
}///end Genral loop

/////////////////For checkboxes only***************************************
for ($i=0; $i < count($_POST['home1']); $i++) {
$question_no1=$_POST['home1'][$i];
 /////////////////////////insert all details////////////
$updateanswerID1=$_POST['Answerm'][$i];
 
 if($_POST['Answerm'][$i]){
$winningAnswer1=$mysqli->real_escape_string($_POST['Answerm'][$i]); 
 
$sqlUsers1="SELECT * FROM ".$prefix."grantcall_qn_answers_concept where `questionID`='$question_no1' and `usrm_id`='$sessionusrm_id' and answer='$winningAnswer1' and `is_sent`='0' order by answerID desc";
$QueryUsers1 = $mysqli->query($sqlUsers1);

if(!$QueryUsers1->num_rows){// and $QueryTitles2->num_rows
	
$sqlA1="insert into ".$prefix."grantcall_qn_answers_concept (`questionID`,`categoryID`,`answer`,`usrm_id`,`status`,`categorym`,`grantID`,`dateupdated`,`is_sent`,`dconceptID`) 

values('$question_no1','$categoryID','$winningAnswer1','$sessionusrm_id','new','concept','$grantID',now(),'0','$mdconceptID')";
$mysqli->query($sqlA1);	

}//end submit
 }


if($QueryUsers1->num_rows and $updateanswerID1 and $QueryTitles1->num_rows and $owner_id){
//$sqlAUpdate1="update ".$prefix."grantcall_qn_answers_concept set `answer`='$winningAnswer1' where `grantID`='$grantID' and answerID='$updateanswerID1' and usrm_id='$sessionusrm_id'";
//$mysqli->query($sqlAUpdate1);	


////////////////////Now UPDATE
}//end submit
}///end Checkbox loop
///initialtotalBudget
$sqlUsers="SELECT * FROM ".$prefix."dynamic_budget_answers where `owner_id`='$sessionusrm_id' and `is_sent`='0' order by id desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
$totalUsers = $QueryUsers->num_rows;
$rUserInv=$QueryUsers->fetch_array();
	
if(!$totalUsers and $owner_id){
$sqlA2="insert into ".$prefix."dynamic_budget_answers (`Personnel`,`PersonnelTotal`,`ResearchCosts`,`ResearchCostsTotal`,`Equipment`,`EquipmentTotal`,`kickoff`,`kickoffTotal`,`Travel`,`TravelTotal`,`KnowledgeSharing`,`KnowledgeSharingTotal`,`OverheadCosts`,`OverheadCostsTotal`,`OtherGoods`,`OtherGoodsTotal`,`MatchingSupport`,`MatchingSupportTotal`,`TotalBudget`,`TotalSubmitted`,`owner_id`,`projectCategory`,`is_sent`,`conceptID`,`initialtotalBudget`) 

values('$Personnel','$PersonnelTotal','$ResearchCosts','$ResearchCostsTotal','$Equipment','$EquipmentTotal','$kickoff','$kickoffTotal','$Travel','$TravelTotal','$KnowledgeSharing','$KnowledgeSharingTotal','$OverheadCosts','$OverheadCostsTotal','$OtherGoods','$OtherGoodsTotal','$MatchingSupport','$MatchingSupportTotal','$TotalBudget','$TotalSubmitted','$sessionusrm_id','Project','0','$id','$initialtotalBudget')";
$mysqli->query($sqlA2);
}
if($totalUsers and $owner_id){
$sqlA44="update ".$prefix."dynamic_budget_answers set initialtotalBudget='$initialtotalBudget' where `owner_id`='$sessionusrm_id' and `is_sent`='0'";
$mysqli->query($sqlA44);
}

 ////////////////Check if any record was added

//Insert into Submission Stages
$wm="select * from ".$prefix."dynamic_concept_stages where  categoryID='$maincategoryID' and owner_id='$sessionusrm_id' and status='new' and grantID='$id' order by id desc";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$record_id2;
if(!$totalStages and $record_id2){
$sqlASubmissionStages="insert into ".$prefix."dynamic_concept_stages (`categoryID`,`owner_id`,`status`,`grantID`,`is_sent`,`dconceptID`)  values('$maincategoryID','$sessionusrm_id','new','$id','0','$mdconceptID')";
$mysqli->query($sqlASubmissionStages);
//Reload After saving
//Reload After saving
echo '<meta http-equiv="REFRESH" content="0;url='.$base_url.'main.php?option=SubmitConceptDynamic&id='.$id.'&categoryID='.$maincategoryID.'">';
}

 
 


}//end post

$wGrantCategories1="select * from ".$prefix."grantcall_categories where  grantID='$id' and categorym='concept' and categoryID='$maincategoryID' order by categoryID asc";
$cmGrantCategories1 = $mysqli->query($wGrantCategories1);
$rUGrantCategories1=$cmGrantCategories1->fetch_array();

if(isset($message)){echo $message;}

$sqlTitles3="SELECT * FROM ".$prefix."dynamic_concept_titles where  `owner_id`='$sessionusrm_id' and `is_sent`='0' order by dconceptID desc";
$QueryTitles3 = $mysqli->query($sqlTitles3);
$rUserInv3=$QueryTitles3->fetch_array();
?>
<div class="tab">

<?php
require_once("dynamic_categories.php");?> 

</div>

<div id="SubmitConceptDynamic" class="tabcontentss">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("dynamic_concept_submit_now_final_button.php");?>
   
  
   
  <h3><b><?php 
  
  $caidp=$rUGrantCategories1['categoryName'];
$wGrantCategoriesMain="select * from ".$prefix."dynamic_categories_main where  category_id='$caidp' order by category_id asc";
$cmGrantCategoriesMain = $mysqli->query($wGrantCategoriesMain);
$rUGrantCategoriesMain=$cmGrantCategoriesMain->fetch_array();

  echo $rUGrantCategoriesMain['category_name'];?></b></h3>
 


 <div class="container"><!--begin-->
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>

  <div class="row success">

    <div class="col-100">
    
  <?php
  //Load Category 1
  //echo $categoryID;
if($categoryID<=0 and $grantID<=0){
	echo '<meta http-equiv="REFRESH" content="0;url='.$base_url.'main.php?option=dashboard">';
} 
  /*if($categoryID==1){
  require_once("dynamic_concept_stage_one_cata.php");
  }*/
  
   if($categoryID==7){//Project Team
  require_once("dynamic_concept_stage_one_catb.php");
  }
 
  if($categoryID==8){//Budget
  require_once("dynamic_concept_stage_one_catc.php");
  }
  if($categoryID==9){///Attachments
  require_once("dynamic_concept_stage_one_catd.php");
  }else if($categoryID!=7 and $categoryID!=8 and $categoryID!=9){
	  require_once("dynamic_concept_stage_one_cata_other.php");
  }
  ?>
      
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
</script>