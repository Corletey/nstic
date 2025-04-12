<?php
$sessionusrm_id=$_SESSION['usrm_id'];
$categorym=$mysqli->real_escape_string($_GET['categorym']);
if($_POST['doSaveDetails'] and $_POST['qn'] and $_POST['percentScore'] and $_POST['grantID'] and $categorym){

 $grantID=$mysqli->real_escape_string($_POST['grantID']);
$qn=$mysqli->real_escape_string($_POST['qn']);
$qn_number=$mysqli->real_escape_string($_POST['qn_number']);
$string=$mysqli->real_escape_string($_POST['percentScore']);
$percentScore=preg_replace('/[^0-9]/', '', $string);
//check the last question
$sqlstudyLAst="SELECT * FROM ".$prefix."mscores_dynamic_qns where `grantID`='$grantID' order by id desc limit 0,1";// and filename='$attachethicalapproval2'
$QuerystudyLast = $mysqli->query($sqlstudyLAst);
$rFListsLastQn=$QuerystudyLast->fetch_array();
$dynamic_recent_qn_no=$rFListsLastQn['qn_number']+1;

$sqlstudy="SELECT * FROM ".$prefix."mscores_dynamic_qns where `grantID`='$grantID' and `question`='$qn' order by id desc";// and filename='$attachethicalapproval2'
$Querystudy = $mysqli->query($sqlstudy);
$totalstudy = $Querystudy->num_rows;
if(!$totalstudy and $categorym){
$sqlA2="insert into ".$prefix."mscores_dynamic_qns (`grantID`,`categorym`,`postedBy`,`DatePosted`,`question`,`qn_number`,`percentScore`) 

values('$grantID','$categorym','$sessionusrm_id',now(),'$qn','$dynamic_recent_qn_no','$percentScore')";
$mysqli->query($sqlA2);


/*$count_number=1;
echo $sqlstudyLAst="SELECT * FROM ".$prefix."mscores_dynamic_qns where `grantID`='$grantID' order by id asc";// and filename='$attachethicalapproval2'
$QuerystudyLast = $mysqli->query($sqlstudyLAst);
while($rFListsLastQn=$QuerystudyLast->fetch_array()){
	$question_id=$rFListsLastQn['id'];
	$qn_numberupdate=$count_number++;

echo $sqlAUpdate="update ".$prefix."mscores_dynamic_qns set `qn_number`='$qn_numberupdate' where `grantID`='$id' and id='$question_id'";
$mysqli->query($sqlAUpdate);
}*/

echo $message='<div class="success">Dear '.$session_fullname.', details have been submitted, click save to continue</div>';
logaction("$session_fullname Loaded Dynamic Evaluation Criteria");
}

}//end post

if($_POST['doUpdate'] and $category=='EvaluationCriteriaUpdate' and $id and $_POST['qnupdate'] and $_POST['qn_numberupdate'] and $_POST['percentScoreupdate'] and $bkey){
	
$qnupdate=$mysqli->real_escape_string($_POST['qnupdate']);
$qn_numberupdate=$mysqli->real_escape_string($_POST['qn_numberupdate']);
$stringupdate=$mysqli->real_escape_string($_POST['percentScoreupdate']);
	
$sqlAUpdate="update ".$prefix."mscores_dynamic_qns set `question`='$qnupdate',`qn_number`='$qn_numberupdate',`percentScore`='$stringupdate' where `id`='$bkey' and `grantID`='$id'";
$mysqli->query($sqlAUpdate);

echo $message='<div class="success">Dear '.$session_fullname.', details have been updated</div>';	

echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=EvaluationCriteria&id=$id&categorym=$categorym'>";
	
}

if($category=='EvaluationCriteriaDel' and $id){

$sqlADelete="DELETE  from ".$prefix."mscores_dynamic_qns where `id`='$bkey' and `grantID`='$id'";
$mysqli->query($sqlADelete);

//Auto Number Questions

//check the last question
$count_number=1;
$sqlstudyLAst="SELECT * FROM ".$prefix."mscores_dynamic_qns where `grantID`='$id' order by id asc";// and filename='$attachethicalapproval2'
$QuerystudyLast = $mysqli->query($sqlstudyLAst);
while($rFListsLastQn=$QuerystudyLast->fetch_array()){
	$question_id=$rFListsLastQn['id'];
	$qn_numberupdate=$count_number++;



$sqlAUpdate="update ".$prefix."mscores_dynamic_qns set `qn_number`='$qn_numberupdate' where `grantID`='$id' and id='$question_id'";
$mysqli->query($sqlAUpdate);
}
echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=EvaluationCriteria&id=$id&categorym=$categorym'>";

echo $message='<div class="error">Dear '.$session_fullname.', details have been Removed</div>';	
	
}
///Load Default Criteria
if($mysqli->real_escape_string($_GET['default'])=='true' and $id  and $categorym){

$sqlstudy="SELECT * FROM ".$prefix."default_evaluation order by id desc";// and filename='$attachethicalapproval2'
$Querystudy = $mysqli->query($sqlstudy);
while($rFListsCalldynamic=$Querystudy->fetch_array()){

$question=$rFListsCalldynamic['question'];
$qn_number=$rFListsCalldynamic['qn_number'];
$percentScore=$rFListsCalldynamic['percentScore'];

$sqlTotals = "select * FROM ".$prefix."mscores_dynamic_qns where grantID='$id' and postedBy='$sessionusrm_id' and question='$question' order by qn_number asc";//and conceptm_status='new' 
$resultTotals = $mysqli->query($sqlTotals);
$totalMain = $resultTotals->num_rows;
if(!$totalMain){
$sqlA2ww="insert into ".$prefix."mscores_dynamic_qns (`grantID`,`categorym`,`postedBy`,`DatePosted`,`question`,`qn_number`,`percentScore`) 

values('$id','$categorym','$sessionusrm_id',now(),'$question','$qn_number','$percentScore')";
$mysqli->query($sqlA2ww);
$record_id = $mysqli->insert_id;
}
	
}

if($record_id){
echo $message='<div class="success">Dear '.$session_fullname.', default evaluation has been added</div>';
logaction("$session_fullname loaded deafault evaluation criteria");
 echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=EvaluationCriteria&id=$id&categorym=$categorym'>";
}
if(!$record_id){
echo $message='<div class="error">Dear '.$session_fullname.', evaluation failed to load</div>';
}

}

$sqlcall = "select * FROM ".$prefix."grantcalls where `grantID`='$id' order by grantID asc limit 0,20";//and conceptm_status='new' 
$resultcall = $mysqli->query($sqlcall);
?> 

<div class="button3" style="float:right; padding:5px;"> 
<a href="./main.php?option=EvaluationCriteria&id=<?php echo $id;?>&default=true&categorym=<?php echo $categorym;?>" onclick="return confirm('<?php echo $lang_CustomizeEvaluationCriteria;?>');"><?php echo $lang_CustomizeEvaluationCriteria;?></a>
</div>


<?php /*?><div class="button3" style="float:right; padding:5px;"> 
<a href="'.$base_url.'main.php?option=AdminNewConcepts" onclick="return confirm('Make sure you are done editing Evaluation Criteria. Proceed?');">Proceed to Assign Call</a>
</div><?php */?>


<button id="myBtn">Add New Question</button>
 <h4 class="niceheaders"><?php echo $lang_DynamicEvaluationCriteria;?></h4><hr />
 
 

 
 <?php 
 while($rFListsCall=$resultcall->fetch_array()){
	 $grantID=$rFListsCall['grantID'];
	 
$sqlCatNos="SELECT count(*) AS TotalCount FROM ".$prefix."mscores_dynamic_qns where grantID='$grantID' group by qn_number order by TotalCount desc";
$QueryCatNos = $mysqli->query($sqlCatNos);
$rowsCount=$QueryCatNos->fetch_array();

$rowsCount['TotalCount'];
if($rowsCount['TotalCount']>=2){
echo $message='<p class="error2">You have duplicate naming of category numbers, please review.</p>';
}

	 
$sql44 = "select * FROM ".$prefix."mscores_dynamic_qns where grantID='$grantID' order by qn_number asc";//and conceptm_status='new' 
$result44 = $mysqli->query($sql44);
$totalQns = $result44->num_rows;
if($totalQns){$totalQns="<span style='color:#ff851b'>Total Questions: ".$totalQns."</span>";}
if(!$totalQns){$totalQns="<span class='error'>Total Questions: ".$totalQns. ". $lang_Please_add_evaluation_criteria_call</span>";}
	 ?>
<img src="./img/edit.gif" /><strong> <?php echo $rFListsCall['title'];?> | <?php echo $totalQns;?></strong>
   <table width="100%" border="0" class="success">
  <tr>
    <th width="5%">No</th>
    <th width="78%">Question</th>
    <th width="9%">Max %</th>
    <th width="8%">Action</th>
  </tr>
  <?php 
while($rFLists24=$result44->fetch_array()){
	
?>
<form action="" method="post" name="regForm2" id="regForm2" autocomplete="off"  enctype="multipart/form-data">
  <tr>
    <td style="border-bottom:1px solid #4CAF50; border-right:1px solid #4CAF50;"><?php echo $rFLists24['qn_number'];?>. 
    
    <?php if($category=='EvaluationCriteriaUpdate' and $bkey==$rFLists24['id']){?><input name="qn_numberupdate" type="text" value="<?php echo $rFLists24['qn_number'];?>"/><?php }?>
    </td>
    <td style="border-bottom:1px solid #4CAF50; border-right:1px solid #4CAF50;"><?php echo $rFLists24['question'];?>
    <?php if($category=='EvaluationCriteriaUpdate' and $bkey==$rFLists24['id']){?><input name="qnupdate" type="text" value="<?php echo $rFLists24['question'];?>"/><?php }?>
    </td>
    <td style="border-bottom:1px solid #4CAF50; border-right:1px solid #4CAF50;" align="center"><?php echo $rFLists24['percentScore'];?>
    <?php if($category=='EvaluationCriteriaUpdate' and $bkey==$rFLists24['id']){?><input name="percentScoreupdate" type="text" value="<?php echo $rFLists24['percentScore'];?>"/>
	
	<input type="submit" name="doUpdate" value="Update">
	<?php }?>
    
    
    </td>
    <td style="border-bottom:1px solid #4CAF50;"><a href="./main.php?option=EvaluationCriteriaUpdate&id=<?php echo $grantID;?>&bkey=<?php echo $rFLists24['id'];?>&categorym=<?php echo $categorym;?>" style="font-size:11px;">Update</a>
    <div style="width:100%; height:3px;"></div>
    <a href="./main.php?option=EvaluationCriteriaDel&id=<?php echo $grantID;?>&bkey=<?php echo $rFLists24['id'];?>&categorym=<?php echo $categorym;?>" onclick="return confirm('Are you sure you want to DELETE this Evaluation Question?');"  style="font-size:11px; color:#F00;">Remove</a>
    </td>
  </tr>
</form>

  <?php $totalScore=($rFLists24['percentScore']+$totalScore);
  }?>
  
  <tr>
    <th width="5%">&nbsp;</th>
    <th width="78%">&nbsp;</th>
    <th width="9%"><?php echo $totalScore; $totalScore="";?></th>
    <th width="8%">&nbsp;</th>
  </tr>
  </table>

<div class="button3" style="float:right; padding:5px;"> 
<a href="<?php echo $base_url;?>main.php?option=dashboard" onclick="return confirm('Make sure you are done editing Evaluation Criteria. Proceed?');"><?php echo $lang_proceed_tocalls;?></a>
</div>
 
  <?php }?>
   
  
  
  <!-- The Modal -->
<div id="myModal" class="modal" style="width:700px;">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <!--<h3><strong>Add New Question</strong></h3>-->
    </div>
    <div class="modal-body" style="height:450px; overflow:scroll;">
    <!--<h4>Name Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal</h4>-->
     <form action="" method="post" name="regForm" id="regForm" autocomplete="off"  enctype="multipart/form-data">
    
    <label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
<input type="hidden" name="asrmApplctID" value="<?php echo $usrm_id;?>">

 <div class="row success">
 <label class="col-sm-3 form-control-label">Choose Call <span class="error">*</span>:</label>

<select id="callID" name="grantID" class="requireDd" required>
<option value=""> Please Select</option>
<?php 
$sqlcall2 = "select * FROM ".$prefix."grantcalls where `grantID`='$id' order by grantID asc limit 0,20";//and conceptm_status='new' 
$resultcall2 = $mysqli->query($sqlcall2);
while($rFListsCall2=$resultcall2->fetch_array()){
?>
<option value="<?php echo $rFListsCall2['grantID'];?>"> <?php echo $rFListsCall2['title'];?></option>
<?php }?>
      </select>    
    
  </div>

 <div class="row success">
 <label class="col-sm-6 form-control-label">Evaluation Question/Criteria <span class="error">*</span>:</label>
<textarea name="qn" cols="" rows="" class="required" required></textarea>
    
    
  </div>
  
   <div class="row success">
 <label class="col-sm-6 form-control-label">Percentage Max Score eg 30 <span class="error">*</span>:</label>
<input name="percentScore" type="text"  class="required" required/>
    
    
  </div>

<!-- <div class="row success">
 <label class="col-sm-4 form-control-label">Question Number <span class="error">*</span>:</label>
<input name="qn_number" type="text"  class="required" required/>
    
    
  </div>-->

   
 <div class="row success">
    <div class="rightm">
    <input type="submit" name="doSaveDetails" value="Save">
    </div>
    
    
  </div>
  
  
   </form>
   
</div>
                                     
</div>
</div>
      
      <script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("activem");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}
</script> 

                        
<script type="text/javascript">

var countries=new ddajaxtabs("countrytabs", "countrydivcontainer")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

</script>



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

