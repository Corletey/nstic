<?php
session_start();
require_once('contrlrcn/c_mlsrcontrol.php'); 
$ds=$mysqli->real_escape_string(base64_decode($_GET['id']));

?>
     <script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>

  <script>
  $(document).ready(function(){
    $.validator.addMethod("username", function(value, element) {
        return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
    }, "Username must contain only letters, numbers, or underscore.");

    $("#regForm").validate();
  });
  </script>
   <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
<?php                                                  
$sqlScoreReview="SELECT * FROM ".$prefix."mscores where scoredmID='$ds'";
$QueryScoreReview=$mysqli->query($sqlScoreReview);
$rScoreReview = $QueryScoreReview->fetch_array();
$mconceptm_id=$rScoreReview['conceptm_id'];

$queryContribution2="select * from ".$prefix."concepts where conceptm_id='$mconceptm_id'";
$rs_Contribution2=$mysqli->query($queryContribution2);
$rsContribution2=$rs_Contribution2->fetch_array();


	?>
    <div style="width:600px; margin:0 auto; padding-top:10px;">
    <h3>Add Viva Score and close window after scoring</h3><hr>

   <p> <?php echo $rsContribution2['proposalmTittle'];?></p>
    
    <p><strong>Viva Score: <?php echo $rScoreReview['EVivaScore'];?></strong></p>

<p><strong>Comment</strong></p>
<?php echo $rScoreReview['EvVivaComments'];?>

</div>
