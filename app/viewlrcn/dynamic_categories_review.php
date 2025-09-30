 <?php
 ///Get Allowed Categories
 ///Project Information
$wGrant_cat1="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='1' order by category_number asc";
$cmGrant_cat1 = $mysqli->query($wGrant_cat1);
$total_Information = $cmGrant_cat1->num_rows;


 ///Project Introduction
$wGrant_cat2="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='5' order by category_number asc";
$cmGrant_cat2 = $mysqli->query($wGrant_cat2);
$total_Introduction = $cmGrant_cat2->num_rows;

 ///Project Details/Background
$wGrant_cat3="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='6' order by category_number asc";
$cmGrant_cat3 = $mysqli->query($wGrant_cat3);
$total_Background = $cmGrant_cat3->num_rows;

 ///Project Team
$wGrant_cat4="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='7' order by category_number asc";
$cmGrant_cat4 = $mysqli->query($wGrant_cat4);
$total_Team = $cmGrant_cat4->num_rows;

 ///Project Budget
$wGrant_cat5="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='8' order by category_number asc";
$cmGrant_cat5 = $mysqli->query($wGrant_cat5);
$total_Budget = $cmGrant_cat5->num_rows;

 ///Project Attachments
$wGrant_cat6="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='9' order by category_number asc";
$cmGrant_cat6 = $mysqli->query($wGrant_cat6);
$total_Attachments = $cmGrant_cat6->num_rows;

 ///Project Citations
$wGrant_cat7="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='10' order by category_number asc";
$cmGrant_cat7 = $mysqli->query($wGrant_cat7);
$total_Citations = $cmGrant_cat7->num_rows;

 ///Approach/Methodology
$wGrant_cat8="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='19' order by category_number asc";
$cmGrant_cat8 = $mysqli->query($wGrant_cat8);
$total_Methodology = $cmGrant_cat8->num_rows;

 ///Follow-up
$wGrant_cat9="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='20' order by category_number asc";
$cmGrant_cat9 = $mysqli->query($wGrant_cat9);
$total_Followup = $cmGrant_cat8->num_rows;

 ///Project Results
$wGrant_cat10="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='21' order by category_number asc";
$cmGrant_cat10 = $mysqli->query($wGrant_cat10);
$total_Results = $cmGrant_cat10->num_rows;

 ///Project Management
$wGrant_cat11="select * from ".$prefix."grantcall_categories where  grantID='$grantID' and categoryName='23' order by category_number asc";
$cmGrant_cat11 = $mysqli->query($wGrant_cat11);
$total_Management = $cmGrant_cat11->num_rows;

/*$wGrantAllowedCategoryMain="select * from ".$prefix."dynamic_categories_main where category_id='$MosescatagoryID'";
$cmGrantAllowedCategoryMain = $mysqli->query($wGrantAllowedCategoryMain);
$rUGrantAllowedMain=$cmGrantAllowedCategoryMain->fetch_array();*/

?>


<!--onclick="openCity(event, 'newFirstInformation')" id="defaultOpen"-->
  
<?php /*?> 
<button <?php if($rUConceptStages['ProjectInformation']==1){?>class="tablinks"<?php }?> ><?php echo $rUGrantAllowedMain['category_name'];?></button>
<?php if($totalUsers){?> 
    <button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>  onClick="window.location.href='./main.php?option=newproposalResearchTeam&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalBackground&id=<?php echo $id?>&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Background;?> </button>
  
    <button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalMethodology&id=<?php echo $id?>&&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalBudget&id=<?php echo $id?>&&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalResults&id=<?php echo $id?>&&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectResults;?></button>
   
  
  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalManagement&id=<?php echo $id?>&&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newproposalFollowup&id=<?php echo $id?>&&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ProjectFollowup;?></button>
  
   <button <?php if($rUConceptStages['attachments']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newProposalAttachments&id=<?php echo $id?>&&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_ResearchAttachments;?></button>
   
    <button <?php if($rUConceptStages['citations']==1){?>class="tablinks"<?php }?> onClick="window.location.href='./main.php?option=newProposalReferences&id=<?php echo $id?>&&categoryID=<?php echo $categoryID;?>&conceptID=<?php echo $conceptID;?>'"><?php echo $lang_new_Citations;?></button>
  <?php }?>
  
  
  
  
  
   <?php if(!$totalUsers){?> 
    <button <?php if($rUConceptStages['ResearchTeam']==1){?>class="tablinks"<?php }?>><?php echo $lang_new_ProjectTeam;?>  </button>
  
  <button <?php if($rUConceptStages['Background']==1){?>class="tablinks"<?php }?>>Background </button>
  
    <button <?php if($rUConceptStages['Methodology']==1){?>class="tablinks"<?php }?> ><?php echo $lang_new_ApproachMethodology;?> </button>
    
    <button <?php if($rUConceptStages['Budget']==1){?>class="tablinks"<?php }?>><?php echo $lang_new_Budget;?></button>
    
   <button <?php if($rUConceptStages['ProjectResults']==1){?>class="tablinks"<?php }?>><?php echo $lang_new_ProjectResults;?></button>
   
  
  <button <?php if($rUConceptStages['ProjectManagement']==1){?>class="tablinks"<?php }?> ><?php echo $lang_new_ProjectManagement;?></button>
  
  <button <?php if($rUConceptStages['Followup']==1){?>class="tablinks"<?php }?> ><?php echo $lang_new_ProjectFollowup;?></button>
  <button <?php if($rUConceptStages['attachments']==1){?>class="tablinks"<?php }?> ><?php echo $lang_new_ResearchAttachments;?></button>
  <button <?php if($rUConceptStages['citation']==1){?>class="tablinks"<?php }?> >Citation</button>
  
  <?php }?>
  
  <?php */?>