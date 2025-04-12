 <?php
 ///Get Allowed Categories
 ///Project Information
$wGrant_cat1="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='1' order by category_number asc";
$cmGrant_cat1 = $mysqli->query($wGrant_cat1);
$total_Information = $cmGrant_cat1->num_rows;


 ///Project Introduction
$wGrant_cat2="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='5' order by category_number asc";
$cmGrant_cat2 = $mysqli->query($wGrant_cat2);
$total_Introduction = $cmGrant_cat2->num_rows;

 ///Project Details/Background
$wGrant_cat3="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='6' order by category_number asc";
$cmGrant_cat3 = $mysqli->query($wGrant_cat3);
$total_Background = $cmGrant_cat3->num_rows;

 ///Project Team
$wGrant_cat4="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='7' order by category_number asc";
$cmGrant_cat4 = $mysqli->query($wGrant_cat4);
$total_Team = $cmGrant_cat4->num_rows;

 ///Project Budget
$wGrant_cat5="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='8' order by category_number asc";
$cmGrant_cat5 = $mysqli->query($wGrant_cat5);
$total_Budget = $cmGrant_cat5->num_rows;

 ///Project Attachments
$wGrant_cat6="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='9' order by category_number asc";
$cmGrant_cat6 = $mysqli->query($wGrant_cat6);
$total_Attachments = $cmGrant_cat6->num_rows;

 ///Project Citations
$wGrant_cat7="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='10' order by category_number asc";
$cmGrant_cat7 = $mysqli->query($wGrant_cat7);
$total_Citations = $cmGrant_cat7->num_rows;

 ///Approach/Methodology
$wGrant_cat8="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='19' order by category_number asc";
$cmGrant_cat8 = $mysqli->query($wGrant_cat8);
$total_Methodology = $cmGrant_cat8->num_rows;

 ///Follow-up
$wGrant_cat9="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='20' order by category_number asc";
$cmGrant_cat9 = $mysqli->query($wGrant_cat9);
$total_Followup = $cmGrant_cat8->num_rows;

 ///Project Results
$wGrant_cat10="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='21' order by category_number asc";
$cmGrant_cat10 = $mysqli->query($wGrant_cat10);
$total_Results = $cmGrant_cat10->num_rows;

 ///Project Management
$wGrant_cat11="select * from ".$prefix."grantcall_categories where  grantID='$id' and categoryName='23' order by category_number asc";
$cmGrant_cat11 = $mysqli->query($wGrant_cat11);
$total_Management = $cmGrant_cat11->num_rows;

$finalTotalCount=($total_Information+$total_Introduction+$total_Background+$total_Team+$total_Budget+$total_Attachments+$total_Citations+$total_Methodology+$total_Followup+$total_Results+$total_Management);

?>
