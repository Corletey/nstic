<?php
$sessionusrm_id=$_SESSION['usrm_id'];

$sqlcall = "select * FROM ".$prefix."grantcalls order by grantID desc limit 0,40";//and conceptm_status='new' 
$resultcall = $mysqli->query($sqlcall);
?>
 <h4 class="niceheaders">Dynamic Evaluation Criteria</h4><hr />
 
 

 <?php 
 while($rFListsCall=$resultcall->fetch_array()){
	 $grantID=$rFListsCall['grantID'];
	 $categorym=$rFListsCall['category'];

	 
$sql44 = "select * FROM ".$prefix."mscores_dynamic_qns where grantID='$grantID' order by qn_number asc";//and conceptm_status='new' 
$result44 = $mysqli->query($sql44);
$totalQns = $result44->num_rows;
if($totalQns){$totalQns="<span style='color:#ff851b'>Total Questions: ".$totalQns."</span>";}
if(!$totalQns){$totalQns="<span class='error'>Total Questions: ".$totalQns. ". $lang_Please_add_evaluation_criteria_call</span>";}
	 ?>
 <button class="accordion" style="font-size:14px;"><img src="./img/edit.gif" /> <?php echo $rFListsCall['title'];?> | <?php echo $totalQns;?></button>
  <div class="panel">
  
  <input name="" type="button" onclick="window.location.href='./main.php?option=EvaluationCriteria&id=<?php echo $grantID;?>&categorym=<?php echo $categorym;?>';" value="Click to add/update" style="padding:8px; background:#ff851b; color:#ffffff; border:1px solid #ff851b;"/>

  	
   <table width="100%" border="0" class="success">
  <tr>
    <th width="5%">No</th>
    <th width="78%">Question</th>
    <th width="9%">Max %</th>
   
  </tr>
  <?php 
while($rFLists24=$result44->fetch_array()){
	
?>

  <tr>
    <td style="border-bottom:1px solid #4CAF50; border-right:1px solid #4CAF50;"><?php echo $rFLists24['qn_number'];?>. 
 
    </td>
    <td style="border-bottom:1px solid #4CAF50; border-right:1px solid #4CAF50;"><?php echo $rFLists24['question'];?>
 
    </td>
    <td style="border-bottom:1px solid #4CAF50; border-right:1px solid #4CAF50;" align="center"><?php echo $rFLists24['percentScore'];?>
 
    
    
    </td>
 
  </tr>


  <?php $totalScore=($rFLists24['percentScore']+$totalScore);
  }?>
  
  <tr>
    <th width="5%">&nbsp;</th>
    <th width="78%">&nbsp;</th>
    <th width="9%"><?php echo $totalScore; $totalScore="";?></th>
 
  </tr>
  </table>
  </div>
 
  <?php }?>
   
  
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

