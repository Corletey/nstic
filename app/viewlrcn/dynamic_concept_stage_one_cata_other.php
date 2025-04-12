<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$maincategoryID=$_GET['categoryID'];

if($_POST['doSaveDataCatTheree']=='Save'){
	
	$sqlUsersCall="SELECT * FROM ".$prefix."grantcalls where category='concepts' order by grantID desc limit 0,1";
		$QueryUsersCall = $mysqli->query($sqlUsersCall);
		$rUserInvCall=$QueryUsersCall->fetch_array();
		$shortacronym=$rUserInvCall['shortacronym'];
		if(!$id){$grantcallID=$rUserInvCall['grantID'];
		
		
		}
		if($id){$grantcallID=$id;
		}

$owner_id=$mysqli->real_escape_string($_POST['usrm_id']);
$categoryID=$mysqli->real_escape_string($_POST['categoryID']);
$grantID=$mysqli->real_escape_string($_POST['grantID']);
$submissionCatID=$mysqli->real_escape_string($_POST['submissionCatID']);
///Begin Titke
$sqldynamicQnsYes="SELECT * FROM ".$prefix."grantcall_questions where `project_title`='Yes'  and grantID='$id' order by questionID desc limit 0,1";
$QuerydynamicQnsYes = $mysqli->query($sqldynamicQnsYes);
$rdynamicQnsYes=$QuerydynamicQnsYes->fetch_array();
$totalTitle=$QuerydynamicQnsYes->num_rows;

$titlequestionID=$rdynamicQnsYes['questionID'];
//grantcall_qn_answers_concept
$sqldynamicQnsYes2="SELECT * FROM ".$prefix."grantcall_qn_answers_concept where `questionID`='$titlequestionID'  and grantID='$id' and usrm_id='$sessionusrm_id' order by  answerID desc limit 0,1";
$QuerydynamicQnsYes2 = $mysqli->query($sqldynamicQnsYes2);
$rdynamicQnsYes2=$QuerydynamicQnsYes2->fetch_array();
$project_title=$mysqli->real_escape_string($rdynamicQnsYes2['answer']);
///End Title

//What is the project title
$sqlTitles4="SELECT * FROM ".$prefix."dynamic_concept_titles order by dconceptID desc";
$QueryTitles4 = $mysqli->query($sqlTitles4);
$rUserInv4=$QueryTitles4->fetch_array();

$mmCOnecpt=$rUserInv4['dconceptID']+1;
$referenceNo="$shortacronym".date("Y").$rUserCategory['rstugshort1']."0".$mmCOnecpt;


$sqlTitles="SELECT * FROM ".$prefix."dynamic_concept_titles where  `owner_id`='$sessionusrm_id' and `is_sent`='0' and grantID='$grantID' order by dconceptID desc";
$QueryTitles = $mysqli->query($sqlTitles);
$rUserInv=$QueryTitles->fetch_array();

if(!$QueryTitles->num_rows){
$sqlA2="insert into ".$prefix."dynamic_concept_titles (`owner_id`,`grantID`,`project_title`,`referenceNo`,`projectStatus`,`finalSubmission`,`dateUpdated`,`is_sent`,`categoryID`,`submissionCatID`) 

values('$sessionusrm_id','$grantID','$project_title','$referenceNo','Pending Final Submission','Pending Final Submission',now(),'0','$categoryID','$submissionCatID')";
$mysqli->query($sqlA2);	

}


$initialtotalBudget=$mysqli->real_escape_string($_POST['totalBudget']);


		

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


///Update project title
if($project_title and !$id and !$categoryID){
$sqlAmm="update ".$prefix."dynamic_concept_titles  set `project_title`='$project_title' where `owner_id`='$sessionusrm_id' and `is_sent`='0'";
//$mysqli->query($sqlAmm);	

}
if($project_title and $id and $categoryID and $submissionCatID){
$sqlAmm="update ".$prefix."dynamic_concept_titles  set `project_title`='$project_title',`submissionCatID`='$submissionCatID' where `owner_id`='$sessionusrm_id' and `is_sent`='0' and grantID='$id'";
$mysqli->query($sqlAmm);	

}
if($project_title and $id and $categoryID and !$submissionCatID){
$sqlAmm2="update ".$prefix."dynamic_concept_titles  set `project_title`='$project_title' where `owner_id`='$sessionusrm_id' and `is_sent`='0' and grantID='$id'";
$mysqli->query($sqlAmm2);	

}

 }//end loop


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


if($QueryUsers->num_rows and $updateanswerID and $sessionusrm_id){
/*echo $sqlAUpdate="update ".$prefix."grantcall_qn_answers_concept set `answer`='$winningAnswer' where `grantID`='$grantID' and answerID='$updateanswerID' and usrm_id='$sessionusrm_id' and answerID='$updateanswerID'";*/


////////////////////Now UPDATE
}//end submit
}///end Checkbox loop

















///initialtotalBudget
 ////////////////Check if any record was added

//Insert into Submission Stages
//Insert into Submission Stages
$wm="select * from ".$prefix."dynamic_concept_stages where  categoryID='$maincategoryID' and owner_id='$sessionusrm_id' and status='new' and grantID='$id' order by id desc";
$cmdwb = $mysqli->query($wm);
$totalStages = $cmdwb->num_rows;
$record_id2;
if(!$totalStages){
$sqlASubmissionStages="insert into ".$prefix."dynamic_concept_stages (`categoryID`,`owner_id`,`status`,`grantID`,`is_sent`,`dconceptID`)  values('$maincategoryID','$sessionusrm_id','new','$id','0','$mdconceptID')";
$mysqli->query($sqlASubmissionStages);
//Reload After saving
//Reload After saving
echo '<meta http-equiv="REFRESH" content="0;url='.$base_url.'main.php?option=SubmitConceptDynamic&id='.$id.'&categoryID='.$maincategoryID.'">';
}

 
 


}//end post
?>
<form action="" method="post" name="regForm" id="regForm" autocomplete="off"  enctype="multipart/form-data">
    <?php
$sqldynamicQns="SELECT * FROM ".$prefix."grantcall_questions where `categoryID`='$categoryID'  and grantID='$id' order by qn_number asc limit 0,100";
$QuerydynamicQns = $mysqli->query($sqldynamicQns);
while($rdynamicQns=$QuerydynamicQns->fetch_array()){
	$questionID=$rdynamicQns['questionID'];
	$questionIDm=$rdynamicQns['questionID'];
	$categoryIDm=$rdynamicQns['categoryID'];
	$project_title=$rdynamicQns['project_title'];
	$qn_number=$rdynamicQns['qn_number'];
	
$sqldynamicAnswers="SELECT * FROM ".$prefix."grantcall_qn_answers_concept where `questionID`='$questionID' and usrm_id='$sessionusrm_id' and is_sent='0' order by answerID asc";
$QuerydynamicAnswers = $mysqli->query($sqldynamicAnswers);
$rdynamicAnswers=$QuerydynamicAnswers->fetch_array();

/////If dropdwons///////////////////////////////////////////////////////////////////
$sqlcheckbox="SELECT * FROM ".$prefix."grantcall_questions_checkboxes where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Querycheckbox = $mysqli->query($sqlcheckbox);
$totalscheckbox=$Querycheckbox->num_rows;

$sqlradiobutton="SELECT * FROM ".$prefix."grantcall_questions_radiobutton where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Queryradiobutton = $mysqli->query($sqlradiobutton);
$totalsRadioButton=$Queryradiobutton->num_rows;

$sqldropdown="SELECT * FROM ".$prefix."grantcall_questions_dropdown where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Querydropdown = $mysqli->query($sqldropdown);
$totalsDropdown=$Querydropdown->num_rows;

$sqlbudget="SELECT * FROM ".$prefix."grantcall_questions_budget where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Querybudget = $mysqli->query($sqlbudget);
$totalsbudget=$Querybudget->num_rows;

$sqlattahment="SELECT * FROM ".$prefix."grantcall_questions_attachments where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Queryattahment = $mysqli->query($sqlattahment);
$totalsattahment=$Queryattahment->num_rows;
$totalsattahment2.=$Queryattahment->num_rows;
///////////////////////////////////////////////////////////////////////////////////////////	
	
?>
   <?php if($rdynamicQns['project_title']!='catmain'){?> <label for="fname"><?php echo $rdynamicQns['questionName'];?> <span class="error">*</span></label><br /><?php }?>
    
    
     <input type="hidden" name="categoryID" value="<?php echo $rdynamicQns['categoryID'];?>" >
    <input name="grantID" type="hidden" value="<?php echo $rdynamicQns['grantID'];?>"/>    
     <input name="home[]" type="hidden" value="<?php echo $rdynamicQns['questionID'];?>" checked="checked"/>
     <input name="answerID<?php echo $rdynamicQns['questionID'];?>" type="hidden" value="<?php echo $rdynamicAnswers['answerID'];?>"/>
     
     
     
<?php if(!$totalscheckbox and !$totalsRadioButton and !$totalsDropdown and $rdynamicQns['project_title']!='catmain'){?>  

<textarea name="Answer<?php echo $rdynamicQns['questionID'];?>" placeholder="<?php echo $rdynamicQns['questionName'];?>.." cols="" rows="" required id="MyTextBoxMMMM"><?php echo $rdynamicAnswers['answer'];?></textarea>
<?php }?>

      
      
      
      
	
            <?php
while($rcheckbox=$Querycheckbox->fetch_array()){
	$answer=$rcheckbox['id'];
$sqldynamicAnswers2="SELECT * FROM ".$prefix."grantcall_qn_answers_concept where `questionID`='$questionID' and usrm_id='$sessionusrm_id' and answer='$answer' and is_sent='0' order by answerID asc";
$QuerydynamicAnswers2 = $mysqli->query($sqldynamicAnswers2);
$rdynamicAnswers2=$QuerydynamicAnswers2->fetch_array();	
	
	
	
	?>
<input name="home1[]" type="hidden" value="<?php echo $rdynamicQns['questionID'];?>" checked="checked"/>
  <input name="Answerm[]" type="checkbox" value="<?php echo $rcheckbox['id'];?>"  <?php if($rcheckbox['id']==$rdynamicAnswers2['answer']){?>checked="checked"<?php }?>/> <?php echo $rcheckbox['dynamiccheckboxes'];?><br />         
            
 <?php }?> 

 
 
 
 
 
   <?php
while($rradiobutton=$Queryradiobutton->fetch_array()){?>
 <input name="Answer<?php echo $rradiobutton['questionID'];?>" type="radio" value="<?php echo $rradiobutton['id'];?>" <?php if($rradiobutton['id']==$rdynamicAnswers['answer']){?>checked="checked"<?php }?>/> <?php echo $rradiobutton['dynamicradiobuttion'];?><br />         
            
 <?php }?>  
 
 
  <?php
if($totalsDropdown){
?>
<select name="Answer<?php echo $rdynamicQns['questionID'];?>" id="dynamic">
<?php 
while($rdropdown=$Querydropdown->fetch_array()){
//grantcall_questions_dropdown

	?>


<option value="<?php echo $rdropdown['id'];?>" <?php if($rdropdown['id']==$rdynamicAnswers['answer']){?>selected="selected"<?php }?>><?php echo $rdropdown['dropdown_option'];?></option>
 <?php }?>
 </select>
  <?php }//end totals?>
  
  
  
  
  
  

  
  
  
  

  <?php 
 // echo $qn_number;
 if($rdynamicQns['project_title']=='catmain'){ echo "<br /><br />";
  /////If Question Rank is 1. Then, display category
  $sqlTitles5="SELECT * FROM ".$prefix."dynamic_concept_titles where grantID='$id' and owner_id='$sessionusrm_id' order by dconceptID desc limit 0,1";
$QueryTitles5 = $mysqli->query($sqlTitles5);
$rUserInv5=$QueryTitles5->fetch_array();
  ?>
<label for="fname">Project/Research Category<span class="error">*</span></label><br />
  <select name="submissionCatID">
      <?php
$sqldynamicCar="SELECT * FROM ".$prefix."categories  order by rstug_categoryName asc";
$QuerydynamicCar = $mysqli->query($sqldynamicCar);
while($rdynamicCar=$QuerydynamicCar->fetch_array()){?>
  <option value="<?php echo $rdynamicCar['rstug_categoryID'];?>" <?php if($rdynamicCar['rstug_categoryID']==$rUserInv5['submissionCatID']){?>selected="selected"<?php }?>><?php echo $rdynamicCar['rstug_categoryName'];?></option>
  <?php }?>
  
  </select>
  <?php }?>
    <br />  <br />
  <?php
  }?>
  
  
   <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveDataCatTheree" value="Save">
  </div>
  
  </form>