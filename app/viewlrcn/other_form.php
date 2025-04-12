<?php 
$country=$_GET['country'];
if($country=="Reject Submission"){
?>
<p>Please Input reason below:</p>
<textarea name="cmtcomments" cols="" rows="" style="width:420px; height:150px;" class="required"></textarea>
<?php }
if($country=="Approve for Review"){
?>
<p>Please Input reason below:</p>
<textarea name="cmtcomments" cols="" rows="" style="width:420px; height:150px;"></textarea>
<?php }?>