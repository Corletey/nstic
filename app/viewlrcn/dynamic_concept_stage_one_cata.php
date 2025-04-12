 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="usrm_id" value="<?php echo $_SESSION['usrm_id'];?>" >
    <?php
$sqldynamicQns="SELECT * FROM ".$prefix."grantcall_questions where `categoryID`='$categoryID' and grantID='$id' order by questionID asc limit 0,100";
$QuerydynamicQns = $mysqli->query($sqldynamicQns);
while($rdynamicQns=$QuerydynamicQns->fetch_array()){
	$questionID=$rdynamicQns['questionID'];
	$questionIDm=$rdynamicQns['questionID'];
	$categoryIDm=$rdynamicQns['categoryID'];
	
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
$sqlTitles3="SELECT * FROM ".$prefix."dynamic_concept_titles where  `owner_id`='$sessionusrm_id' and `is_sent`='0' order by dconceptID desc";
$QueryTitles3 = $mysqli->query($sqlTitles3);
$rUserInv3=$QueryTitles3->fetch_array();	
	
?>
    <label for="fname"><?php echo $rdynamicQns['questionName'];?> <span class="error">*</span></label><br />
    
    
     <input type="hidden" name="categoryID" value="<?php echo $rdynamicQns['categoryID'];?>" >
    <input name="grantID" type="hidden" value="<?php echo $rdynamicQns['grantID'];?>"/>    
     <input name="home[]" type="hidden" value="<?php echo $rdynamicQns['questionID'];?>" checked="checked"/>
     <input name="answerID<?php echo $rdynamicQns['questionID'];?>" type="hidden" value="<?php echo $rdynamicAnswers['answerID'];?>"/>
     
     
     
<?php if(!$totalscheckbox and !$totalsRadioButton and !$totalsDropdown and !$totalsbudget and !$totalsattahment and $rdynamicQns['project_title']=='No' ){?>  

<textarea name="Answer<?php echo $rdynamicQns['questionID'];?>" placeholder="<?php echo $rdynamicQns['questionName'];?>.." cols="" rows="" required id="MyTextBoxMMMM"><?php echo $rdynamicAnswers['answer'];?></textarea>
<?php }?>

  <?php if(!$totalscheckbox and !$totalsRadioButton and !$totalsDropdown and !$totalsbudget and !$totalsattahment and $rdynamicQns['project_title']=='Yes' ){?>  
<textarea name="projecttitle" cols="" rows="" required id="MyTextBoxMMMM"><?php echo $rUserInv3['project_title'];?></textarea>

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
 <input name="Answer1<?php echo $rradiobutton['questionID'];?>" type="radio" value="<?php echo $rradiobutton['id'];?>" <?php if($rradiobutton['id']==$rdynamicAnswers['answer']){?>checked="checked"<?php }?>/> <?php echo $rradiobutton['dynamicradiobuttion'];?><br />         
            
 <?php }?> 
 
 
  <?php
if($totalsDropdown){
?>
<select name="Answer1<?php echo $rdynamicQns['questionID'];?>" id="dynamic">
<?php 
while($rdropdown=$Querydropdown->fetch_array()){
//grantcall_questions_dropdown

	?>


<option value="<?php echo $rdropdown['id'];?>" <?php if($rdropdown['id']==$rdynamicAnswers['answer']){?>selected="selected"<?php }?>><?php echo $rdropdown['dropdown_option'];?></option>
 <?php }?>
 </select>
  <?php }//end totals?>
  
  
  
  
  
  

  
  
  
  
  
  <?php }?>

<?php /*?><?php
$sqlUsersDr="SELECT * FROM ".$prefix."dynamic_budget_answers where `owner_id`='$sessionusrm_id' and `is_sent`='0' order by id desc limit 0,1";
$QueryUsersDr = $mysqli->query($sqlUsersDr);
$rUserInvDr=$QueryUsersDr->fetch_array();
?>
   
    <label for="fname">Project Total Budget <span class="error">*</span></label>
       
      <input name="totalBudget" type="text" value="<?php echo $rUserInvDr['initialtotalBudget'];?>" required/>
 
<?php */?>
  
   <div class="row" style="padding-top:5px;">
    <input type="submit" name="doSaveData" value="Save and Next">
  </div>
  
  </form>