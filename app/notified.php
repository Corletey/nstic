<?php
session_start();
require_once('contrlrcn/c_mlsrcontrol.php'); 
$ds=base64_decode($id);
?>
<?php                                                  
$sqlScoreReview="SELECT * FROM ".$prefix."concepts where conceptm_id='$ds'";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
$rScoreReview = $QueryScoreReview->fetch_array();
	?>
    <div style="width:600px; margin:0 auto; padding-top:30px;">
    <h3>Notification</h3><hr>
 <?php echo $rScoreReview['mailtext'];?>
</div>
