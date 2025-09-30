<?php
require_once('../configlrcn/db_mconfig.php');
//require_once('../contrlrcn/language.php');
$country=$_GET['country'];
if($country=='Yes'){
?><div class="col-100">
    <label for="fname">Provide Comments </label>

    <textarea id="generalApproach" name="regretcomments" placeholder="" style="height:150px; " class="required" required></textarea>  
    </div>
    <?php }
	if($country=='No'){?>
    
    <?php }?>