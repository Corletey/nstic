<?php
	//doSaveFive
	$action=$mysqli->real_escape_string($_GET['action']);
if($_POST['doAddSiteConfiguration']){

$name_granting_council=$mysqli->real_escape_string($_POST['name_granting_council']);
$physical_address=$mysqli->real_escape_string($_POST['physical_address']);
$postal_address=$mysqli->real_escape_string($_POST['postal_address']);
$email=$mysqli->real_escape_string($_POST['email']);	
$telephone=$mysqli->real_escape_string($_POST['telephone']);
$lgID=$mysqli->real_escape_string($_POST['lgID']);
		
$upUpdate="update ".$prefix."configuration  set name_granting_council='$name_granting_council',physical_address='$physical_address', postal_address='$postal_address',email='$email',`telephone`='$telephone' where  id='$lgID'";
$mysqli->query($upUpdate);

 $message="<span class=error2>$lang_updatesite_configuration.</span>"; 
}
if( $message){echo  $message;}
	?>
 
 <h4 class="niceheaders"><?php echo $lang_site_configuration;?> </h4><hr />
 
 <button id="myBtn"><?php echo $lang_updatesite_configuration;?> </button> 

<div style="clear:both;"></div>
<form action="" method="post" name="regForm2" id="regForm2" autocomplete="off"  enctype="multipart/form-data">
 
 <?php 
$sql = "select *,DATE_FORMAT(`dateupdated`,'%d/%m/%Y') AS updatedonm FROM ".$prefix."configuration order by id desc";//and conceptm_status='new' 
$result = $mysqli->query($sql);

		  ?>
 <div class="table-responsive">
                                                <!-- THE MESSAGES -->
                                                <table width="100%" class="table table-mailbox">
                                   
                                                
                                                    <tr class="unread">
                                                      <th width="268" class="small-col"><strong><?php echo $lang_name_granting_council;?></strong></th>
                                                      <th width="206" class="name"><strong><?php echo $lang_physical_address;?></strong></th>
                                                      <th width="100" class="time"><strong><?php echo $lang_postal_address;?></strong></th>
                                                        <th width="100" class="time"><?php echo $lang_TelephoneContact;?></th>
                                                        <th width="100" class="time"><?php echo $lang_email;?></th>
                                                        <th width="100" class="time"><?php echo $lang_Updatedon;?></th>
                                                    </tr>
                                               
                                                    <?php 
while($rFLists2=$result->fetch_array()){
?>
                                                    <tr>
                                                      <td class="small-col"><?php echo $rFLists2['name_granting_council'];?>
                                                      
                                                      </td>
                                                      <td class="name">
													  <?php echo $rFLists2['physical_address'];?>
                                                      
                                                      </td>
                                                      <td class="time"><?php echo $rFLists2['postal_address'];?>
                                                      
                                                      </td>
                                                        <td class="time"><?php echo $rFLists2['telephone'];?></td>
                                                        <td class="time"><?php echo $rFLists2['email'];?></td>
                                                        <td class="time"><?php echo $rFLists2['updatedonm'];?></td>
                                                    </tr>

                                                    <?php }?>
                                                   

                                                </table>
</div><!-- /.table-responsive -->
</form>

   <!-- The Modal -->
<div id="myModal" class="modal" style="margin-top:80px;">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
    
    </div>
    <div class="modal-body" style="height:300px; overflow:scroll;">
    <?php
$wGrantCategories="select * from ".$prefix."configuration order by id asc limit 0,1";
$cmGrantCategories = $mysqli->query($wGrantCategories);
$rows=$cmGrantCategories->fetch_array();
?>

 <form action="" method="post" name="regForm" id="regForm" enctype="multipart/form-data">
 <input name="lgID" type="hidden" value="<?php echo $rows['id'];?>"/>
 
 <div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_name_granting_council;?><span class="error">*</span></label>
<div class="col-sm-7">
<textarea name="name_granting_council" cols="" rows="" class="form-control  required"><?php echo $rows['name_granting_council'];?></textarea>


</div>
</div> 

 <div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_physical_address;?><span class="error">*</span></label>
<div class="col-sm-7">
<textarea name="physical_address" cols="" rows="" class="form-control  required"><?php echo $rows['physical_address'];?></textarea>


</div>
</div>

 <div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_postal_address;?><span class="error">*</span></label>
<div class="col-sm-7">
<textarea name="postal_address" cols="" rows="" class="form-control  required"><?php echo $rows['postal_address'];?></textarea>


</div>
</div>  

<div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_email;?><span class="error">*</span></label>
<div class="col-sm-7">
<textarea name="email" cols="" rows="" class="form-control  required"><?php echo $rows['email'];?></textarea>


</div>
</div>  

<div class="form-group row success" style="padding-top:10px;">
<label class="col-sm-4 form-control-label"><?php echo $lang_TelephoneContact;?><span class="error">*</span></label>
<div class="col-sm-7">
<textarea name="telephone" cols="" rows="" class="form-control  required"><?php echo $rows['telephone'];?></textarea>


</div>
</div> 

      
       <div class="form-group row">
                          <div class="col-sm-4 offset-sm-3">
                    <input name="doAddSiteConfiguration" type="submit"  class="btn btn-primary" value="<?php echo $lang_new_Save;?>"/>

                          </div>
                        </div>
                                          
     </form>                   
    </div>
    </div>
    </div><!--End-->
    
    <script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>