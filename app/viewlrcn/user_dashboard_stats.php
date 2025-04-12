<div class="col-mm9 halfgraph1">



<canvas id="myChart" width="200" height="200"></canvas>
<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Drafts', 'Submitted', 'Scheduled', 'Approved', 'Rejected'],
        datasets: [{
            label: 'Submitted Concepts',
            data: [<?php DraftConcepts();?>, <?php PendingReviewConcepts();?>, <?php ScheduledforReviewConcepts();?>, <?php ApprovedConcepts();?>, <?php RejectedConcepts();?>],
            backgroundColor: [
                'rgba(239, 76, 76, 0.9)',
                'rgba(239, 76, 76, 0.6)',
                'rgba(239, 76, 76, 0.4)'
            ],
            borderColor: [
                'rgba(239, 76, 76, 1)',
                'rgba(239, 76, 76, 1)',
                'rgba(239, 76, 76, 1)'
            ],
            borderWidth: 0
        }]
    },
    /*options: {F4516C
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }*/
});
</script>




</div>





<div class="col-mm9 halfgraph2">
<h4>Submitted Proposals</h4> 



<canvas id="myChart4" height="220"></canvas>

<script type="text/javascript">
var ctx = document.getElementById('myChart4').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["Drafts", "Submitted", "Scheduled", "Approved", "Rejected"],
        datasets: [{
            label: "Submitted Proposals",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(54, 162, 235)',
            data: [<?php DraftProposals();?>, <?php PendingReviewProposals();?>, <?php ScheduledforReviewProposals();?>, <?php ApprovedProposals();?>, <?php RejectedProposals();?>],
        }]
    },

    // Configuration options go here
    options: {}
});
</script>	












</div>




<div style="clear:both;"></div>