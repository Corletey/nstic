<?php
function GrantsCall(){
	global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
$sqlFeaturedCall = "SELECT *,DATE_FORMAT(`EndDate`,'%M %d, %Y') AS EndDatem FROM ".$prefix."grantcalls where EndDate>='$today' order by grantID desc limit 0,1";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
$totalFeaturedCall = $queryFeaturedCall->num_rows;
$rFeaturedCall = $queryFeaturedCall->fetch_array();
if($totalFeaturedCall){
	
?>
<h1 style="color:#ffffff;"><?php echo $rFeaturedCall['title'];?></h1>
                    <p style="font-size:14px; line-height:18px;"><?php echo $rFeaturedCall['summary'];?></p>

<p style="font-size:14px; line-height:18px;"><a href="../grants/data/grantcall/<?php echo $rFeaturedCall['grantID'];?>/" target="_blank" style="text-transform:uppercase; color:#0CF; font-weight:bold;">Read More</a></p>

<?php 
}if(!$totalFeaturedCall){?>
<h1 style="color:#ffffff;">We dont have any Latest call at the moment, please check back soon...</h1>
<?php 
}


}?>


<?php
function GrantsCallTimer(){
	global $mysqli,$gr_mgroup_id,$prefix,$usrm_id,$today;
	$sqlFeaturedCall = "SELECT *,DATE_FORMAT(`EndDate`,'%M %d, %Y') AS EndDatem FROM ".$prefix."grantcalls where EndDate>='$today' order by grantID desc limit 0,1";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
$totalFeaturedCall = $queryFeaturedCall->num_rows;
$rFeaturedCall = $queryFeaturedCall->fetch_array();
if($totalFeaturedCall){	
	
	?>
    <p id="demo"></p> 
<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo $rFeaturedCall['EndDatem'];?> 23:59:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = days + " days " + hours + "Hours "
    + minutes + "m " + seconds + "s ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
}, 1000);
</script>

<p style="color:#F00; font-weight:bold;">Submission Deadline: <?php echo $rFeaturedCall['EndDatem'];?> 23:59:00</p>

<?php 
}//end Timer
}?>
        
