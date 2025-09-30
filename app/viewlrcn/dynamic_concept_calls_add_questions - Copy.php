<?php
if($_POST['doSaveData']=='Save' and $_POST['categoryID']){


for ($i=0; $i < count($_POST['Question']); $i++ and $_POST['qn_number']) {

$categoryID=$mysqli->real_escape_string($_POST['categoryID']);

$Question=$mysqli->real_escape_string($_POST['Question'][$i]);
$qn_number=$mysqli->real_escape_string($_POST['qn_number'][$i]);


$sqlUsers="SELECT * FROM ".$prefix."grantcall_questions where `questionName`='$Question' and `status`='new' and categorym='concept' order by questionID desc limit 0,1";
$QueryUsers = $mysqli->query($sqlUsers);
if(!$QueryUsers->num_rows and $Question and $qn_number){
$sqlA2="insert into ".$prefix."grantcall_questions (`categoryID`,`questionName`,`updatedm`,`status`,`categorym`,`qn_number`) 

values('$categoryID','$Question',now(),'new','concept','$qn_number')";
$mysqli->query($sqlA2);	
$questionID = $mysqli->insert_id;
$message='<p class="success">Dear '.$session_fullname.', details have been submitted, please add another question.</p>';	


/////////////////////////Add multiple Dynamic
for ($i=0; $i < count($_POST['dynamicradiobuttion']); $i++ and $questionID and $Question) {

$dynamicradiobuttion=$mysqli->real_escape_string($_POST['dynamicradiobuttion'][$i]);

$sqlRadioButton="SELECT * FROM ".$prefix."grantcall_questions_radiobutton where `questionID`='$questionID' and `dynamicradiobuttion`='$dynamicradiobuttion' order by id desc limit 0,1";
$QueryRadioButton = $mysqli->query($sqlRadioButton);
if(!$QueryUsers->num_rows){
$sqlDynamicRadio = "INSERT INTO ".$prefix."grantcall_questions_radiobutton (`questionID`,`dynamicradiobuttion`,`categoryID`,`grantID`) VALUES ('$questionID','$dynamicradiobuttion','$categoryID','')";
$mysqli->query($sqlDynamicRadio);
}

}


for ($i=0; $i < count($_POST['dynamiccheckboxes']); $i++ and $questionID and $Question) {

$dynamiccheckboxes=$mysqli->real_escape_string($_POST['dynamiccheckboxes'][$i]);

$sqlCheckboxes="SELECT * FROM ".$prefix."grantcall_questions_checkboxes where `questionID`='$questionID' and `dynamiccheckboxes`='$dynamiccheckboxes' order by id desc limit 0,1";
$QueryCheckboxes = $mysqli->query($sqlCheckboxes);
if(!$QueryCheckboxes->num_rows){
$sqlCheckboxes = "INSERT INTO ".$prefix."grantcall_questions_checkboxes (`questionID`,`dynamiccheckboxes`,`categoryID`,`grantID`) VALUES ('$questionID','$dynamiccheckboxes','$categoryID','')";
$mysqli->query($sqlCheckboxes);
}

}

for ($i=0; $i < count($_POST['dropdown_option']); $i++ and $questionID and $Question) {

$dropdown_option=$mysqli->real_escape_string($_POST['dropdown_option'][$i]);

$sqldropdown="SELECT * FROM ".$prefix."grantcall_questions_dropdown where `questionID`='$questionID' and `dropdown_option`='$dropdown_option' order by id desc limit 0,1";
$Querydropdown = $mysqli->query($sqldropdown);
if(!$Querydropdown->num_rows){
$sqldropdown = "INSERT INTO ".$prefix."grantcall_questions_dropdown (`questionID`,`dropdown_option`,`categoryID`,`grantID`) VALUES ('$questionID','$dropdown_option','$categoryID','')";
$mysqli->query($sqldropdown);
}

}

for ($i=0; $i < count($_POST['dynamicaddattachments']); $i++ and $questionID and $Question) {

$dynamicaddattachments=$mysqli->real_escape_string($_POST['dynamicaddattachments'][$i]);

$sqldropdown="SELECT * FROM ".$prefix."grantcall_questions_attachments where `questionID`='$questionID' and `dynamicaddattachments`='$dynamicaddattachments' order by id desc limit 0,1";
$Querydropdown = $mysqli->query($sqldropdown);
if(!$Querydropdown->num_rows){
$sqldropdown = "INSERT INTO ".$prefix."grantcall_questions_attachments (`questionID`,`dynamicaddattachments`,`categoryID`,`grantID`) VALUES ('$questionID','$dynamicaddattachments','$categoryID','')";
$mysqli->query($sqldropdown);
}

}// end addattachments

///Budget
for ($i=0; $i < count($_POST['PersonnelTotal']); $i++ and $questionID and $Question and $_POST['ResearchCosts'] and $_POST['TravelandSubsistence']) {

$PersonnelTotal=$mysqli->real_escape_string($_POST['PersonnelTotal'][$i]);
$ResearchCosts=$mysqli->real_escape_string($_POST['ResearchCosts'][$i]);
$Equipment=$mysqli->real_escape_string($_POST['Equipment'][$i]);
$TravelandSubsistence=$mysqli->real_escape_string($_POST['TravelandSubsistence'][$i]);
$Grantkickoff=$mysqli->real_escape_string($_POST['Grantkickoff'][$i]);
$KnowledgeSharing=$mysqli->real_escape_string($_POST['KnowledgeSharing'][$i]);
$Overheadcosts=$mysqli->real_escape_string($_POST['Overheadcosts'][$i]);
$Othergoods=$mysqli->real_escape_string($_POST['Othergoods'][$i]);
$MatchingSupport=$mysqli->real_escape_string($_POST['MatchingSupport'][$i]);


$sqldropdown="SELECT * FROM ".$prefix."grantcall_questions_budget where `questionID`='$questionID' and `PersonnelTotal`='$PersonnelTotal' and `ResearchCosts`='$ResearchCosts' and `Equipment`='$Equipment' and `TravelandSubsistence`='$TravelandSubsistence' and `Grantkickoff`='$Grantkickoff' and `KnowledgeSharing`='$KnowledgeSharing' and `Overheadcosts`='$Overheadcosts' and `Othergoods`='$Othergoods' and `MatchingSupport`='$MatchingSupport' order by id desc limit 0,1";
$Querydropdown = $mysqli->query($sqldropdown);
if(!$Querydropdown->num_rows){
$sqldropdown = "INSERT INTO ".$prefix."grantcall_questions_budget (`questionID`,`categoryID`,`grantID`,`PersonnelTotal`,`ResearchCosts`,`Equipment`,`TravelandSubsistence`,`Grantkickoff`,`KnowledgeSharing`,`Overheadcosts`,`Othergoods`,`MatchingSupport`) VALUES ('$questionID','$categoryID','','$PersonnelTotal','$ResearchCosts','$Equipment','$TravelandSubsistence','$Grantkickoff','$KnowledgeSharing','$Overheadcosts','$Othergoods','$MatchingSupport')";
$mysqli->query($sqldropdown);
}

}// end addattachments

}

if($QueryUsers->num_rows){
$message='<p class="error2">Dear '.$session_fullname.', details were already submitted, please add another question.</p>';		
}
	
}//end Big Question Addition
}
//Get the last question
$sqlLastQn="SELECT * FROM ".$prefix."grantcall_questions where `status`='new' order by questionID desc limit 0,1";
$QueryLastQn = $mysqli->query($sqlLastQn);
$rUserLastQn=$QueryLastQn->fetch_array();

?>
<script type="text/javascript">
function addRow(tableID) {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
            var colCount = table.rows[0].cells.length;
            for(var i=0; i<colCount; i++) {
                var newcell = row.insertCell(i);
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }
        }
		
				function deleteRow(tableID)
{
            try
                 {
                var table = document.getElementById(tableID);
                var rowCount = table.rows.length;
                    for(var i=0; i<rowCount; i++)
                        {
                        var row = table.rows[i];
                        var chkbox = row.cells[0].childNodes[0];
                        if (null != chkbox && true == chkbox.checked)
                            {
                            if (rowCount <= 1)
                                {
                                alert("Cannot delete all the rows.");
                                break;
                                }
                            table.deleteRow(i);
                            rowCount--;
                            i--;
                            }
                        }
                    } catch(e)
                        {
                        alert(e);
                        }
   getValues();
}
</script>

<div class="tab">

    <button class="tablinks" onClick="window.location.href='./main.php?option=DynamicCallConcepts'"><?php echo $lang_new_SubmitConceptCategories;?> </button>

<button  onclick="openCity(event, 'DynamicCallConceptsQns')" id="defaultOpen"><?php echo $lang_new_AddQuestionsCategories;?> </button>
<button class="tablinks" onClick="window.location.href='./main.php?option=SubmitCallforConceptNew'">Submit Call for Concept</button>


</div>

<div id="DynamicCallConceptsQns" class="tabcontent">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>

   
  <h3>Dynamic Concept Calls</h3>
<?php if($message){?><div style="color:#F00; font-size:18px;"><?php echo $message;?></div><?php }?>
 <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">

 
 <div class="container"><!--begin-->
 
 <label for="fname">Please add categories for this new call concept. (<span class="error">*</span>)</label>
  
  <div class="row success">

    <div class="col-100">
    <label for="fname">Category/Theme</label>
      <select name="categoryID" id="MyTextBox3">
      <option value="">Please select from list</option>
    <?php
$sqlProjectID44="SELECT * FROM ".$prefix."grantcall_categories where `status`='new'  and categorym='concept' order by categoryID desc";
$QueryProjectID44 = $mysqli->query($sqlProjectID44);
while($rUserProjectID44=$QueryProjectID44->fetch_array()){
?>
<option value="<?php echo $rUserProjectID44['categoryID'];?>"><?php echo $rUserProjectID44['categoryName'];?></option>
 <?php }?>
 </select>
    </div>
  </div>
  
  <div class="row success">

   
    
    
    <table width="38%" align="center" cellpadding="0" cellspacing="0" class="normal-text" border="0">
<tr>
<td  align="center"><!--<input type="button" value="Add New Row" onClick="addRow('dataTableMoze')" >-->&nbsp;
<input type="button" value="Remove Row" onClick="deleteRow('dataTableMoze')" ></td>
</tr>
</table>

<table width="100%" border="0" id="POITable">
<tr>
  <th width="30" valign="top"></th>
  <th width="1013">Add Questions to the Grant new call</th>
  <th width="169">Question Number</th>
</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="normal-text" id="dataTableMoze">



<tr>
<td width="20" valign="top"><input type="checkbox" name="chk[]" checked="checked"/></td>

<td >

<div class="form-group form-group-default">
              <input type="hidden" class="form-control" name="Questionmm[]">  
                
                <textarea name="Question[]" cols="" rows="" id="MyTextBox3" required class="questionbox"></textarea>
              </div>



<div class="form-group form-group-default <?php echo $required;?>">
  <input type="hidden" class="form-control" name="Categoryofbeneficiarymm[]">  
                     
<select id="dropdown" name="dropdown[]" class="form-control <?php echo $required;?>" style="width:400px;" onChange="getqndropdown(this.value)">
<option value="">Select to add dropdown to the Question</option> 
<option value="1"> 1</option> 
<option value="2"> 2</option> 
<option value="3"> 3</option>
<option value="4"> 4</option>
<option value="5"> 5</option>

<option value="6"> 6</option>
<option value="7"> 7</option>
<option value="8"> 8</option>
<option value="9"> 9</option>
<option value="10"> 10</option>
<option value="11"> 11</option>
<option value="12"> 12</option>
<option value="13"> 13</option>
<option value="14"> 14</option>
<option value="15"> 15</option>
<option value="16"> 16</option>
<option value="17"> 17</option>
<option value="18"> 18</option>
<option value="19"> 19</option>
<option value="20"> 20</option>
<option value="21"> 21</option>
<option value="22"> 22</option>
<option value="23"> 23</option>
<option value="24"> 24</option>
      </select>
      
      <div id="getdropdiv">  </div>
     
      
  </div>
  
  
  
  
  
  
  
  
  <div class="form-group form-group-default <?php echo $required;?>">
                
<input type="hidden" class="form-control" name="Gendermm[]">
                
<select id="Gender" name="multipleselect[]" class="form-control <?php echo $required;?>" style="width:400px;"  onChange="getqnmultiple(this.value)">
<option value="">Select  to add Multiple Select Checkboxes  to the Question</option>
<option value="1"> 1</option> 
<option value="2"> 2</option> 
<option value="3"> 3</option>
<option value="4"> 4</option>
<option value="5"> 5</option>

<option value="6"> 6</option>
<option value="7"> 7</option>
<option value="8"> 8</option>
<option value="9"> 9</option>
<option value="10"> 10</option>

      </select>
       <div id="getmultipleselectdiv">  </div>         
                
              </div>
              
              
              
    
 <div class="form-group form-group-default <?php echo $required;?>">   
    <input type="hidden" class="form-control" name="singleselectmm[]">  
    <select id="singleselect" name="singleselect[]" class="form-control <?php echo $required;?>" style="width:400px;" onChange="getqnsingleselect(this.value)">
<option value="">Select  to add radio button  to the Question</option> 
<option value="1"> 1</option> 
<option value="2"> 2</option> 
<option value="3"> 3</option>
<option value="4"> 4</option>
<option value="5"> 5</option>

<option value="6"> 6</option>
<option value="7"> 7</option>
<option value="8"> 8</option>
<option value="9"> 9</option>
<option value="10"> 10</option>
      </select>
  </div>
  
  <div id="getsingleselectdiv">  </div> 


 <div class="form-group form-group-default <?php echo $required;?>">   
    <input type="hidden" class="form-control" name="singleselectmm[]">  
    <select id="singleselect" name="singleattachments[]" class="form-control <?php echo $required;?>" style="width:400px;" onChange="getqnattachments(this.value)">
<option value="">Select to add Attachments</option> 
<option value="1"> 1</option> 
<option value="2"> 2</option> 
<option value="3"> 3</option>
<option value="4"> 4</option>
      </select>
  </div>
  
  <div id="getattachmentsdiv">  </div> 
  
  
  
   <div class="form-group form-group-default <?php echo $required;?>">   
    <input type="hidden" class="form-control" name="singleselectmm[]">  
    <select id="singlebudget" name="singlebudget[]" class="form-control <?php echo $required;?>" style="width:400px;" onChange="getqnbudget(this.value)">
<option value="">Select to add Budget</option> 
<option value="1"> Yes</option> 
<option value="2"> No</option> 
      </select>
  </div>
  
  <div id="getbudgetdiv">  </div> 
  
  
</td>


<td valign="top"><div class="form-group form-group-default">
              
                
                <textarea name="qn_number[]" cols="" rows="" id="MyTextBox3mm" required style="width:150px;"><?php echo ($rUserLastQn['qn_number']+1);?></textarea>
              </div></td>
              
</tr>







</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

    
    
    
    
    
    
    
    
    
    
    
    
    
  
    
    
    
    
    
     <div class="row success">
    <input type="submit" name="doSaveData" value="Save">
  </div>
  
</div><!--End-->


</form> 
  
    

  </div>
  
  <?php
  $count=0;
$sqlProjectID2r="SELECT * FROM ".$prefix."grantcall_categories where `status`='new' order by category_number asc";
$QueryProjectID2r = $mysqli->query($sqlProjectID2r);
if($QueryProjectID2r->num_rows){?>
  
  <div class="row success">
  
  
  <div id="customers2">
        
        <?php 
while($rUserProjectID2=$QueryProjectID2r->fetch_array()){
	$count++;
	$categoryIDm=$rUserProjectID2['categoryID'];
?>
 <button class="accordion"><?php echo $rUserProjectID2['category_number'];?>. <?php echo $rUserProjectID2['categoryName'];?></button>
  <div class="panel">	
  
  <?php
  ///Begin Questions
$sqlProjectID2="SELECT * FROM ".$prefix."grantcall_questions where  `categoryID`='$categoryIDm' order by qn_number asc";
$QueryProjectID2 = $mysqli->query($sqlProjectID2);
while($rUserProjectID2r=$QueryProjectID2->fetch_array()){
	$questionIDm=$rUserProjectID2r['questionID'];
	
?>	
  
 <p><?php echo $rUserProjectID2r['qn_number'];?>. <?php echo $rUserProjectID2r['questionName'];?></p>
            <?php
$sqlcheckbox="SELECT * FROM ".$prefix."grantcall_questions_checkboxes where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Querycheckbox = $mysqli->query($sqlcheckbox);
while($rcheckbox=$Querycheckbox->fetch_array()){?>
  <input name="" type="checkbox" value="" /> <?php echo $rcheckbox['dynamiccheckboxes'];?> <br />         
            
 <?php }?> 

 
 
 
 
 
   <?php
$sqlradiobutton="SELECT * FROM ".$prefix."grantcall_questions_radiobutton where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Queryradiobutton = $mysqli->query($sqlradiobutton);
while($rradiobutton=$Queryradiobutton->fetch_array()){?>
 <input name="" type="radio" value="" /> <?php echo $rradiobutton['dynamicradiobuttion'];?> <br />         
            
 <?php }?>  
 
 
  <?php
$sqldropdown="SELECT * FROM ".$prefix."grantcall_questions_dropdown where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Querydropdown = $mysqli->query($sqldropdown);
$totalsDropdown=$Querydropdown->num_rows;
if($totalsDropdown){
?>
<select name="" style="width:200px;">
<?php 
while($rdropdown=$Querydropdown->fetch_array()){?>

<option><?php echo $rdropdown['dropdown_option'];?></option>
 <?php }?>
 </select>
  <?php }?>
 
  
   <?php
   $attcount=0;
$sqlrattachments="SELECT * FROM ".$prefix."grantcall_questions_attachments where questionID='$questionIDm' and `categoryID`='$categoryIDm' order by id asc";
$Queryattachments = $mysqli->query($sqlrattachments);
while($rrattachments=$Queryattachments->fetch_array()){
	$attcount++;?>
<?php echo $attcount.". ".$rrattachments['dynamicaddattachments'];?> <br />         
            
 <?php }?> 
  
 <?php }// end Questions loop?>   
  
  
  </div><!--End Pane-->
	



<?php } // End while loop for Categories
?>
 </div>




</div>
<?php }// end totals?>

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