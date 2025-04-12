<?php
$ownerm_id=$_GET['ownerm_id'];
$maincategoryID=$_GET['categoryID'];
?>
    <?php
$sqldynamicQns="SELECT * FROM ".$prefix."grantcall_questions where `categoryID`='$categoryID'  and grantID='$id' order by qn_number asc limit 0,100";
$QuerydynamicQns = $mysqli->query($sqldynamicQns);
while($rdynamicQns=$QuerydynamicQns->fetch_array()){
	$questionID=$rdynamicQns['questionID'];
	$questionIDm=$rdynamicQns['questionID'];
	$categoryIDm=$rdynamicQns['categoryID'];
	
$sqldynamicAnswers="SELECT * FROM ".$prefix."grantcall_qn_answers_concept where `questionID`='$questionID' and usrm_id='$ownerm_id' and grantID='$id' order by answerID asc";
$QuerydynamicAnswers = $mysqli->query($sqldynamicAnswers);
$rdynamicAnswers=$QuerydynamicAnswers->fetch_array();

/////If dropdwons///////////////////////////////////////////////////////////////////
$sqlcheckbox="SELECT * FROM ".$prefix."grantcall_questions_checkboxes where questionID='$questionIDm' and `categoryID`='$categoryIDm' and grantID='$id' order by id asc";
$Querycheckbox = $mysqli->query($sqlcheckbox);
$totalscheckbox=$Querycheckbox->num_rows;

$sqlradiobutton="SELECT * FROM ".$prefix."grantcall_questions_radiobutton where questionID='$questionIDm' and `categoryID`='$categoryIDm' and grantID='$id' order by id asc";
$Queryradiobutton = $mysqli->query($sqlradiobutton);
$totalsRadioButton=$Queryradiobutton->num_rows;

$sqldropdown="SELECT * FROM ".$prefix."grantcall_questions_dropdown where questionID='$questionIDm' and `categoryID`='$categoryIDm' and grantID='$id' order by id asc";
$Querydropdown = $mysqli->query($sqldropdown);
$totalsDropdown=$Querydropdown->num_rows;

$sqlbudget="SELECT * FROM ".$prefix."grantcall_questions_budget where questionID='$questionIDm' and `categoryID`='$categoryIDm' and grantID='$id' order by id asc";
$Querybudget = $mysqli->query($sqlbudget);
$totalsbudget=$Querybudget->num_rows;

$sqlattahment="SELECT * FROM ".$prefix."grantcall_questions_attachments where questionID='$questionIDm' and `categoryID`='$categoryIDm' and grantID='$id' order by id asc";
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
<?php echo $rdynamicAnswers['answer'];?><br /><br />
<?php }?>

      
      
      
      
	
            <?php
while($rcheckbox=$Querycheckbox->fetch_array()){
	$answer=$rcheckbox['id'];
$sqldynamicAnswers2="SELECT * FROM ".$prefix."grantcall_qn_answers_concept where `questionID`='$questionID' and usrm_id='$ownerm_id' and answer='$answer' and grantID='$id' order by answerID asc";
$QuerydynamicAnswers2 = $mysqli->query($sqldynamicAnswers2);
$rdynamicAnswers2=$QuerydynamicAnswers2->fetch_array();	
	
	
	
	?>
  <input name="Answerm[]" type="checkbox" value="<?php echo $rcheckbox['id'];?>"  <?php if($rcheckbox['id']==$rdynamicAnswers2['answer']){?>checked="checked"<?php }?>/> <?php echo $rcheckbox['dynamiccheckboxes'].' '.$rdynamicAnswers2['answer'];?><br />         
            
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
$qn_number=$rdynamicQns['qn_number'];
if($rdynamicQns['project_title']=='catmain'){ echo "<br />";
  /////If Question Rank is 1. Then, display category
$sqlTitles5="SELECT * FROM ".$prefix."dynamic_concept_titles where grantID='$id' and owner_id='$ownerm_id' order by dconceptID desc";
$QueryTitles5 = $mysqli->query($sqlTitles5);
$rUserInv5=$QueryTitles5->fetch_array();
$submissionCatID=$rUserInv5['submissionCatID'];
if($submissionCatID>=1){ ?>
<label for="fname">Project/Research Category<span class="error">*</span></label><br />
      <?php
$sqldynamicCar="SELECT * FROM ".$prefix."categories where rstug_categoryID='$submissionCatID' order by rstug_categoryName asc";
$QuerydynamicCar = $mysqli->query($sqldynamicCar);
$rdynamicCar=$QuerydynamicCar->fetch_array();echo $rdynamicCar['rstug_categoryName'];
}
 }?>
  
  
  
  <?php }?>
  