<?php
$sqlFeaturedCall = "SELECT * FROM ".$prefix."grantcalls where grantID='$id'";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
$rFeaturedCall = $queryFeaturedCall->fetch_array();
?>
      <div class="box-header">
                                
<h3 class="box-title"><?php echo $rFeaturedCall['title'];?></h3>
  </div><!-- /.box-header -->
                                <div class="box-body">
 <p style="font-size:14px; line-height:18px;"><?php echo $rFeaturedCall['summary'];?>  </p>
 <p style="font-size:14px; line-height:18px;"><a href="../uploads/<?php echo $rFeaturedCall['attachment'];?>" target="_blank" style="text-transform:uppercase; color:#0CF; font-weight:bold;">Read More</a></p>
                                                    

                                </div>








