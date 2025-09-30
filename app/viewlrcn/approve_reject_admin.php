<?php
$country=$_GET['country'];
if($country=='AcceptWithComments' || $country=='Resubmission'){?>
<label for="lname"><?php echo "Please provide comments";?></label>
<textarea id="MyTextBox10" name="rejectcomments" placeholder="Comments.." class="required" style="height:150px" required></textarea>
<?php }
if($country=='TotalReject'){?>
    <label for="lname"><?php echo " Please provide comments";?></label>
    <textarea id="MyTextBox10" name="rejectcomments" placeholder="Comments.." class="required" style="height:150px" required></textarea>
    <?php }

if($country=='ApproveConcept'){}?>