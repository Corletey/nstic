 <?php /*?><?php if($rUserInv3['categoryID']==$maincategoryID || !$QueryTitles3->num_rows){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname">Project Title <span class="error">*</span></label>
       
      <input name="projecttitle" type="text" value="<?php echo $rUserInv3['project_title'];?>" required/>
      
      
    </div>
  </div><?php }?>
<?php */?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">
 <input type="hidden" name="usrm_id" value="<?php echo $_SESSION['usrm_id'];?>" >
    <?php
$sqldynamicQns="SELECT * FROM ".$prefix."grantcall_questions where `categoryID`='$categoryID' and grantID='$id' order by questionID asc limit 0,100";
$QuerydynamicQns = $mysqli->query($sqldynamicQns);//and grantID='$id' 
while($rdynamicQns=$QuerydynamicQns->fetch_array()){
	$questionID=$rdynamicQns['questionID'];
	$questionIDm=$rdynamicQns['questionID'];
	$categoryIDm=$rdynamicQns['categoryID'];
	
$sqldynamicAnswers="SELECT * FROM ".$prefix."grantcall_qn_answers_concept where `questionID`='$questionID' and usrm_id='$ownerm_id' and grantID='$id' order by answerID asc";
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
    <label for="fname"><?php echo $rdynamicQns['questionName'];?> <span class="error">*</span></label><br />
    
    
     <input type="hidden" name="categoryID" value="<?php echo $rdynamicQns['categoryID'];?>" >
    <input name="grantID" type="hidden" value="<?php echo $rdynamicQns['grantID'];?>"/>    
     <input name="home[]" type="hidden" value="<?php echo $rdynamicQns['questionID'];?>" checked="checked"/>
     <input name="answerID<?php echo $rdynamicQns['questionID'];?>" type="hidden" value="<?php echo $rdynamicAnswers['answerID'];?>"/>
     
     
     
<?php if(!$totalscheckbox and !$totalsRadioButton and !$totalsDropdown and !$totalsbudget and !$totalsattahment and $rdynamicQns['project_title']=='No' ){?>  

<?php echo $rdynamicAnswers['answer'];?><br /><br />
<?php }?>

  <?php if(!$totalscheckbox and !$totalsRadioButton and !$totalsDropdown and !$totalsbudget and !$totalsattahment and $rdynamicQns['project_title']=='Yes' ){?>  
<?php echo $rUserInv3['project_title'];?><br /><br />

<?php }?>   

      
      
      
      
	
            <?php
while($rcheckbox=$Querycheckbox->fetch_array()){?>
  <input name="Answer1<?php echo $rcheckbox['questionID'];?>" type="checkbox" value="<?php echo $rdynamicAnswers['answer'];?>" /> <?php echo $rcheckbox['dynamiccheckboxes'];?> <br />         
            
 <?php }?> 

 
 
 
 
 
   <?php
while($rradiobutton=$Queryradiobutton->fetch_array()){?>
 <input name="Answer2<?php echo $rradiobutton['questionID'];?>" type="radio" value="<?php echo $rdynamicAnswers['answer'];?>" /> <?php echo $rradiobutton['dynamicradiobuttion'];?> <br />         
            
 <?php }?>  
 
 
  <?php
if($totalsDropdown){
?>
<?php 
while($rdropdown=$Querydropdown->fetch_array()){
//grantcall_questions_dropdown

	?>


<?php echo $rdropdown['dropdown_option'];?>
 <?php }?>
 
  <?php }//end totals?>
  
  
  
  
  
  

  
  
  
  
  
  <?php }?>

<?php /*?><?php
$sqlUsersDr="SELECT * FROM ".$prefix."dynamic_budget_answers where `owner_id`='$ownerm_id' order by id desc limit 0,1";
$QueryUsersDr = $mysqli->query($sqlUsersDr);
$rUserInvDr=$QueryUsersDr->fetch_array();
?>
   
    <label for="fname">Project Total Budget <span class="error">*</span></label>
       
      <input name="totalBudget" type="text" value="<?php echo $rUserInvDr['initialtotalBudget'];?>" required/>
 
<?php */?>
  
  </form>