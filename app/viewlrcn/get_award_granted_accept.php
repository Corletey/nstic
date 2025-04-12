<?php
require_once('../configlrcn/db_mconfig.php');
$country=$_GET['country'];
if($country=='Yes'){
?>
 
   <div class="row success">

    <div class="col-100">
    <label for="fname"><b>Attach signed Agreement (Sign on each page) in pdf</b> <span class="error">*</span></label>
   <input name="signedagreement" type="file" id="signedagreement" class="required" required/>
    </div>
  </div>
  
  <div class="form-group row">
                          <div class="col-sm-4 offset-sm-3">
                    <input name="doAcceptTerms" type="submit"  class="btn btn-primary" value="Accept Terms and Conditions" onclick="return confirm('Are you sure you want to proceed?');"/>

                          </div>
                        </div>
  
<?php }
if($country=='No'){?>

<div class="row success">

<div class="col-100">
<label for="fname">Reasons for Rejection</label>

<textarea id="rejectGrantComment" name="rejectGrantComment" rows="4" cols="50">
</textarea>
   
</div>
</div>


<div class="form-group row">
                          <div class="col-sm-4 offset-sm-3">
                    <input name="doRejectGrant" type="submit"  class="btn btn-primary" value="Reject Grant Offer" onclick="return confirm('Are you sure you want to proceed?');"/>

                          </div>
                        </div>

<?php }

?>

