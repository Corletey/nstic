<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$_GET['categoryID'];

if($_POST['doSaveData']=='Save and Next'){

$owner_id=$mysqli->real_escape_string($_POST['usrm_id']);
$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$grantID=$mysqli->real_escape_string($_POST['grantID']);
$project_title=$mysqli->real_escape_string($_POST['projecttitle']);


$sqlUsersCall="SELECT * FROM ".$prefix."grantcalls where category='proposals' order by grantID desc limit 0,1";
		$QueryUsersCall = $mysqli->query($sqlUsersCall);
		$rUserInvCall=$QueryUsersCall->fetch_array();
		$shortacronym=$rUserInvCall['shortacronym'];
		if(!$id){$grantcallID=$rUserInvCall['grantID'];
		
		
		}
		if($id){$grantcallID=$id;
		}
		
//What is the project title
$sqlTitles4="SELECT * FROM ".$prefix."dynamic_proposal_titles where `project_title`='$project_title' and `owner_id`='$owner_id' order by dproposalID desc";
$QueryTitles4 = $mysqli->query($sqlTitles4);
$rUserInv4=$QueryTitles4->fetch_array();

$mmCOnecpt=$rUserInv4['dproposalID']+1;
$referenceNo="$shortacronym".date("Y").$rUserCategory['rstugshort1']."0".$mmCOnecpt;


$sqlTitles="SELECT * FROM ".$prefix."dynamic_proposal_titles where  `owner_id`='$owner_id' and `is_sent`='0' order by dproposalID desc";
$QueryTitles = $mysqli->query($sqlTitles);
$rUserInv=$QueryTitles->fetch_array();
if(!$QueryTitles->num_rows and $_POST['projecttitle']){
$sqlA2="insert into ".$prefix."dynamic_proposal_titles (`owner_id`,`grantID`,`project_title`,`referenceNo`,`projectStatus`,`finalSubmission`,`dateUpdated`,`is_sent`,`categoryID`) 

values('$owner_id','$grantID','$project_title','$referenceNo','Pending Final Submission','Pending Final Submission',now(),'0','$categoryID')";
$mysqli->query($sqlA2);	

}
///Update project title
if($QueryTitles->num_rows and $_POST['projecttitle']){
$sqlAmm="update ".$prefix."dynamic_proposal_titles  set `project_title`='$project_title' where `owner_id`='$owner_id' and `is_sent`='0'";
$mysqli->query($sqlAmm);	

}

$sqlTitles2="SELECT * FROM ".$prefix."dynamic_proposal_titles where `owner_id`='$owner_id' and `is_sent`='0' order by dproposalID desc";
$QueryTitles2 = $mysqli->query($sqlTitles2);

$rUserInv22=$QueryTitles2->fetch_array();
$mdproposalID=$rUserInv22['dproposalID'];

for ($i=0; $i < count($_POST['home']); $i++) {
$question_no=$_POST['home'][$i];
 /////////////////////////insert all details////////////
$winningAnswer=$_POST['Answer'.$question_no];
$updateanswerID=$_POST['answerID'.$question_no];
 //grantcall_qn_answers
 
 
$sqlUsers="SELECT * FROM ".$prefix."grantcall_qn_answers_proposal where `questionID`='$question_no' and `usrm_id`='$owner_id' and `is_sent`='0' order by answerID desc";
$QueryUsers = $mysqli->query($sqlUsers);

if(!$QueryUsers->num_rows and $QueryTitles2->num_rows){
	
$sqlA2="insert into ".$prefix."grantcall_qn_answers_proposal (`questionID`,`categoryID`,`answer`,`usrm_id`,`status`,`categorym`,`grantID`,`dateupdated`,`is_sent`,`dproposalID`) 

values('$question_no','$categoryID','$winningAnswer','$owner_id','new','proposal','$grantID',now(),'0','$mdproposalID')";
$mysqli->query($sqlA2);	
$record_id = $mysqli->insert_id;
$record_id2.=$mysqli->insert_id;
}//end submit

if($QueryUsers->num_rows and $updateanswerID and $QueryTitles2->num_rows){
	
$sqlAUpdate="update ".$prefix."grantcall_qn_answers_proposal set `answer`='$winningAnswer' where `grantID`='$grantID' and answerID='$updateanswerID'";
$mysqli->query($sqlAUpdate);	


////////////////////Now UPDATE




}//end submit
}///end loop



 ////////////////Check if any record was added

//Insert into Submission Stages
$wm="select * from ".$prefix."dynamic_proposal_stages where  categoryID='$maincategoryID' and owner_id='$owner_id' and status='new' and grantID='$grantID' order by id desc";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$record_id2;
if(!$totalStages and $record_id2){
$sqlASubmissionStages="insert into ".$prefix."dynamic_proposal_stages (`categoryID`,`owner_id`,`status`,`grantID`,`is_sent`,`dproposalID`)  values('$maincategoryID','$owner_id','new','$grantID','0','$mdproposalID')";
$mysqli->query($sqlASubmissionStages);
}

 
 


}//end post

$wGrantCategories1="select * from ".$prefix."grantcall_categories where  grantID='$id' and categorym='proposal' and categoryID='$maincategoryID' order by categoryID asc";
$cmGrantCategories1 = $mysqli->query($wGrantCategories1);
$rUGrantCategories1=$cmGrantCategories1->fetch_array();

if(isset($message)){echo $message;}

$sqlTitles3="SELECT * FROM ".$prefix."dynamic_proposal_titles where  `owner_id`='$sessionusrm_id' and `is_sent`='0' order by dproposalID desc";
$QueryTitles3 = $mysqli->query($sqlTitles3);
$rUserInv3=$QueryTitles3->fetch_array();

$sqlConceptRitle="SELECT * FROM ".$prefix."dynamic_concept_titles where  `owner_id`='$sessionusrm_id' and `is_sent`='1' order by dconceptID desc limit 0,1";
$QueryConceptRitle = $mysqli->query($sqlConceptRitle);
$rconceptTitle=$QueryConceptRitle->fetch_array();

?>
<div class="tab">

<?php require_once("dynamic_categories_proposals.php");?>

</div>

<div id="SubmitConceptDynamic" class="tabcontentss">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  
   <?php include("dynamic_proposal_submit_now_final_button.php");?>
   
  
   
  <h3><b><?php echo $rUGrantCategories1['categoryName'];?></b></h3>
 
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
 <input type="hidden" name="usrm_id" value="<?php echo $_SESSION['usrm_id'];?>" >

 <div class="container"><!--begin-->
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>



<?php if($rUserInv3['categoryID']==$maincategoryID || !$QueryTitles3->num_rows){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Project Title <span class="error">*</span></label>
       
      <input name="projecttitle" type="text" value="<?php if($QueryTitles3->num_rows){echo $rUserInv3['project_title'];}else{ echo $rconceptTitle['project_title'];}?>" required/>
      
      
    </div>
  </div><?php }?>







<?php
$sqldynamicQns="SELECT * FROM ".$prefix."grantcall_questions where `categoryID`='$categoryID' order by questionID asc limit 0,100";
$QuerydynamicQns = $mysqli->query($sqldynamicQns);
while($rdynamicQns=$QuerydynamicQns->fetch_array()){
	$questionID=$rdynamicQns['questionID'];
	
$sqldynamicAnswers="SELECT * FROM ".$prefix."grantcall_qn_answers_proposal where `questionID`='$questionID' and usrm_id='$sessionusrm_id' and is_sent='0' order by answerID asc";
$QuerydynamicAnswers = $mysqli->query($sqldynamicAnswers);
$rdynamicAnswers=$QuerydynamicAnswers->fetch_array();	
	
?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rdynamicQns['questionName'];?> <span class="error">*</span></label>
    
    
     <input type="hidden" name="categoryID" value="<?php echo $rdynamicQns['categoryID'];?>" >
    <input name="grantID" type="hidden" value="<?php echo $rdynamicQns['grantID'];?>"/>
    
     <input name="home[]" type="hidden" value="<?php echo $rdynamicQns['questionID'];?>" checked="checked"/>
    
      <input type="text" id="MyTextBox" name="Answer<?php echo $rdynamicQns['questionID'];?>" placeholder="<?php echo $rdynamicQns['questionName'];?>.." class="requiredm" value="<?php echo $rdynamicAnswers['answer'];?>" required>
      
      <input name="answerID<?php echo $rdynamicQns['questionID'];?>" type="hidden" value="<?php echo $rdynamicAnswers['answerID'];?>"/>
      
      
    </div>
  </div>
 <?php }?>
  
 
  

  <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="Save and Next">
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