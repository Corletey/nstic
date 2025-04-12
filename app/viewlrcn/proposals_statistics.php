<?php
$sqlPending="SELECT *  FROM ".$prefix."submissions_proposals where projectStatus='Pending Final Submission' order by projectID desc";
$QueryPending = $mysqli->query($sqlPending);
$Pendings=$QueryPending->num_rows;


$sqlScheduled="SELECT *  FROM ".$prefix."submissions_proposals where projectStatus='Scheduled for Review' order by projectID desc";
$QueryScheduled = $mysqli->query($sqlScheduled);
$Scheduled=$QueryScheduled->num_rows;

$sqlApproved="SELECT *  FROM ".$prefix."submissions_proposals where projectStatus='Approved' order by projectID desc";
$QueryApproved = $mysqli->query($sqlApproved);
$Approved=$QueryApproved->num_rows;

$sqlReviewed="SELECT *  FROM ".$prefix."submissions_proposals where projectStatus='Reviewed' order by projectID desc";
$QueryReviewed = $mysqli->query($sqlReviewed);
$Reviewed=$QueryReviewed->num_rows;

$sqlRejected="SELECT *  FROM ".$prefix."submissions_proposals where projectStatus='Rejected' order by projectID desc";
$QueryRejected = $mysqli->query($sqlRejected);
$Rejected=$QueryRejected->num_rows;
//'Pending Review','','Rejected','Reviewed'
?>
<div class="innergraphs">
<canvas id="myChart4" height="120"></canvas>

<script type="text/javascript">
var ctx = document.getElementById('myChart4').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["Pending Final Submission", "Scheduled for Review", "Reviewed"],
        datasets: [{
            label: "Submitted Concepts",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(54, 162, 235)',
            data: [<?php echo $Pendings;?>, <?php echo $Scheduled;?>, <?php echo $Reviewed;?>],
        }]
    },

    // Configuration options go here
    options: {}
});
</script>
</div>

<div class="innergraphs2">
<canvas id="myChart5" height="120"></canvas>

<script type="text/javascript">
var ctx = document.getElementById('myChart5').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["Approved", "Rejected"],
        datasets: [{
            label: "Submitted Concepts",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(54, 162, 235)',
            data: [<?php echo $Approved;?>, <?php echo $Rejected;?>],
        }]
    },

    // Configuration options go here
    options: {}
});
</script>
</div>

<div style="clear:both;"></div>
