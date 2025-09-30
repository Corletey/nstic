<?php
session_start();
require_once('contrlrcn/c_mlsrcontrol.php'); 
timeout($timeout);
?><!doctype html>
<html class="no-js" lang="en">

<head>
<base href="<?php echo $base_url;?>" />
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $sitename;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <!-- amchart css -->
    <!-- others css -->
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- modernizr css -->
  <script src="js/ajax_populate.js"></script>
    
    
   <script type="text/javascript">
        function refreshParent() {
            if (window.opener != null && !window.opener.closed) {
                window.opener.location.reload();
            }
        }
        //call the refresh page on closing the window
        window.onunload = refreshParent;
    </script>


</head>

<body>
    <!--[if lt IE 8]>
         
        <![endif]-->

    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-containermm">
        <!-- sidebar menu area start -->
 
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-contentmm">
            <!-- header area start -->
       
            <!-- header area end -->
            <!-- page title area start -->
  
            <!-- page title area end -->
            <div class="main-content-innermm">
                   

<?php
$grantID=$_GET['grantID'];
$usrm_id=$_SESSION['usrm_id'];
$sqlUsers2="SELECT * FROM ".$prefix."submissions_proposals where `projectID`='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();

?>


            <h3>Project Information</h3>

<form action="" method="post" name="regForm" id="regForm" autocomplete="off">

<div class="containerm" style="padding:30px;"><!--begin-->
 <p><strong>Important:</strong> Note that the information requested is not the same as in the preliminary concept note proposal stage. You are required to take the feedback from your preliminary concept note proposal into consideration when developing the full proposal.</p>
 
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>
 <div class="row success">

   <div class="col-100">
   <label for="fname">Title (max 50 words) - Give the title of your project <span class="error">*</span></label>
     <br /><strong><?php echo $rUserInv2['projectTitle'];?></strong>
   </div>
 </div>
 <div class="row success">

   <div class="col-100">
   <label for="lname">Short Title or Acronym (20 characters) <span class="error">*</span></label><br />
    <strong><?php echo $rUserInv2['titleAcronym'];?></strong>
   </div>
 </div>

 
   <div class="row success">

   <div class="col-100">
    <label for="lname">Identify the 5 most relevant keywords that represent the scientific basis of your project (max 5 words) <span class="error">*</span></label><br />
    <strong><?php echo $rUserInv2['relevantKeywords'];?></strong>
   </div>
 </div>
 
   <div class="row success">

   <div class="col-100">
    <label for="country"><?php echo $lang_new_researchTypeID;?> <span class="error">*</span></label><br />
      <?php
$researchTypeID=$rUserInv2['researchTypeID'];
$sqlCat = "SELECT * FROM ".$prefix."categories where rstug_categoryID='$researchTypeID' order by rstug_categoryName asc";
$queryCat = $mysqli->query($sqlCat);
$rCat = $queryCat->fetch_array();
?>
<strong><?php echo $rCat['rstug_categoryName'];?></strong>
   </div>
 </div>
 
<?php /*?>   <div class="row success">

   <div class="col-100">
    <label for="lname">Host Institution  <span class="error">*</span></label>
     <input type="text" id="HostInstitution" name="HostInstitution" placeholder=".." class="required"  value="<?php echo $rUserInv2['HostInstitution'];?>">
   </div>
 </div><?php */?>

 
    <div class="row success">

   <div class="col-100">
   <label for="country">Duration of the project- indicate the duration of the project in months <span class="error">*</span></label><br />

      <?php
      $projectDurationID=$rUserInv2['projectDurationID'];
$sqlFeaturedCall = "SELECT * FROM ".$prefix."duration where durationID='$projectDurationID' order by durationID asc";
$queryFeaturedCall = $mysqli->query($sqlFeaturedCall);
$rFeaturedCall = $queryFeaturedCall->fetch_array();
?>
<strong><?php echo $rFeaturedCall['durationdesc'];?></strong>


   </div>
 </div>
 
<div class="row success">

   <div class="col-100">
    <label for="lname">Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal  <span class="error">*</span></label><br />
     <strong><?php echo $rUserInv2['PrincipalInvestigator'];?></strong>
   </div>
 </div>
 
 <div class="row success">

   <div class="col-100">
    <label for="lname">Total funding applied for  <span class="error">*</span></label><br />
<strong><?php echo numberformat($rUserInv2['Totalfunding']);?> <?php echo $rUserInv2['currency'];?></strong>
   </div>
 </div>

</div><!--End-->


  </form>



</div>




<div style="overflow-x:auto; padding:30px;">
<h3>Project Team</h3>

  <?php
  

$sqlUsers2="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryUsers2 = $mysqli->query($sqlUsers2);
$totalUsers = $QueryUsers2->num_rows;
$rUserInv2=$QueryUsers2->fetch_array();
$conceptIDm=$rUserInv2['conceptID'];
$projectID=$rUserInv2['projectID'];

$sqlUsers4="SELECT * FROM ".$prefix."principal_investigators where `conceptm_id`='$conceptIDm' order by piID desc limit 0,10";
$QueryUsers4 = $mysqli->query($sqlUsers4);
if($QueryUsers4->num_rows){

?>

  <table width="100%" border="0" id="customers">
  <tr>
    <th>Name</th>
    <th>Gender</th>
    <th><?php echo $lang_AgeRange;?></th>
    <th><?php echo $lang_Contacts;?></th>
    <th><?php echo $lang_Expertise;?></th>

 
  </tr>
  
  <?php 

while($rUserInv2=$QueryUsers4->fetch_array()){
?>
  <tr>
    <td><?php echo $rUserInv2['Surname'];?> <?php echo $rUserInv2['Othername'];?></td>
    <td><?php echo $rUserInv2['Gender'];?></td>
    <td><?php echo $rUserInv2['AgeRange'];?></td>
    <td><?php echo $rUserInv2['Contacts'];?></td>
    <td><?php echo $rUserInv2['Expertise'];?></td>
   

  </tr>
  <?php }?>
</table>


<p>&nbsp;</p><?php }?>
</div>











</div>



<div style="overflow-x:auto; padding:30px;">
<h3>Background</h3>

 <div class="containerm"><!--begin-->

  
 <?php
$sqlQnsubmitted_c2="SELECT * FROM ".$prefix."concept_dynamic_questions_all_g where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted_c2 = $mysqli->query($sqlQnsubmitted_c2);
$rowsSubmitted_c=$Querysubmitted_c2->fetch_array();



$sqlUsers22="SELECT * FROM ".$prefix."project_background where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryUsers22 = $mysqli->query($sqlUsers22);
$rUserInv22=$QueryUsers22->fetch_array();
?> 

<?php if($rowsSubmitted_c['SummaryAudience_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['SummaryAudience'];?><span class="error">*</span></label><br />
<strong><?php echo $rUserInv22['SummaryAudience'];?></strong>
    </div>
  </div><?php }?>


<?php if($rowsSubmitted_c['explanationObjectives_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['explanationObjectives'];?><span class="error">*</span></label><br />
<strong><?php echo $rUserInv2['explanationObjectives'];?></strong>
    </div>
  </div><?php }?>

<?php if($rowsSubmitted_c['researchInnovationIssues_status']){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['researchInnovationIssues'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv22['researchInnovationIssues'];?></strong>
    </div>
  </div><?php }?>
  
<?php if($rowsSubmitted_c['NovelCharacterScientificResearch_status']){?>
 <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['NovelCharacterScientificResearch'];?><span class="error">*</span></label><br />
<strong><?php echo $rUserInv22['NovelCharacterScientificResearch'];?></strong>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['ClearJustificationDemonstration_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ClearJustificationDemonstration'];?> <span class="error">*</span></label><br />
<strong><?php echo $rUserInv22['ClearJustificationDemonstration'];?></strong>
    </div><?php }?>
  </div>
  
  
  <?php if($rowsSubmitted_c['interdisciplinaryTransdisciplinary_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['interdisciplinaryTransdisciplinary'];?> <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv22['interdisciplinaryTransdisciplinary'];?></strong>
    </div>
  </div><?php }?>
  
 
 <?php if($rowsSubmitted_c['addedValue_status']){?> 
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['addedValue'];?> <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv22['addedValue'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['ImportanceResearchInnovation_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ImportanceResearchInnovation'];?> <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv22['ImportanceResearchInnovation'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['PartofInternationalProject_status']){?>
  <div class="row success">

    <div class="col-100">
     <label for="lname"><?php echo $rowsSubmitted_c['PartofInternationalProject'];?> <span class="error">*</span><br />
  
      <input name="PartofInternationalProject" type="radio" value="No"  onChange="getProjectSpecificActivities(this.value)" <?php if($rUserInv22['PartofInternationalProject']=='No'){?>checked="checked"<?php }?>/> <?php echo $lang_No;?><br />
     <input name="PartofInternationalProject" type="radio" value="Yes"  onChange="getProjectSpecificActivities(this.value)" <?php if($rUserInv22['PartofInternationalProject']=='Yes'){?>checked="checked"<?php }?>/> <?php echo $lang_Yes;?>
     </label>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['projectSpecificActivities_status']){?>
  
   <div class="row success">

    <div class="col-100">
    
    <div id="projectSpecificActivities">
<?php if($rUserInv22['projectSpecificActivities']){?>
<label for="fname"><?php echo $rowsSubmitted_c['projectSpecificActivities'];?> <span class="error">*</span></label><br />
<strong><?php echo $rUserInv22['projectSpecificActivities'];?></strong><?php }?>
    </div>
    

    </div>
  </div><?php }?>

</div><!--End-->



</div>





<div style="overflow-x:auto; padding:30px;">
<h3>Approach/Methodology</h3>


<?php
$sqlQnsubmitted_c3="SELECT * FROM ".$prefix."concept_dynamic_questions_all_h where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted_c3 = $mysqli->query($sqlQnsubmitted_c3);
$rowsSubmitted_c3=$Querysubmitted_c3->fetch_array();

$sqlUsers23="SELECT * FROM ".$prefix."project_methodology where `owner_id`='$usrm_id' and `projectID`='$id' order by methodologyID desc limit 0,1";
$QueryUsers23 = $mysqli->query($sqlUsers23);
$rUserInv23=$QueryUsers23->fetch_array();
?>

<?php if($rowsSubmitted_c3['generalApproach_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c3['generalApproach'];?>  <span class="error">*</span></label><br />
<strong><?php echo $rUserInv23['generalApproach'];?></strong>
    </div>
  </div>
   <?php }?>

<?php if($rowsSubmitted_c3['RelationshipOngoingResearch_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c3['RelationshipOngoingResearch'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv23['RelationshipOngoingResearch'];?></strong>
    </div>
  </div>
   <?php }?>

<?php if($rowsSubmitted_c3['otherDonorsFunding_status']){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c3['otherDonorsFunding'];?><span class="error">*</span>
   <br /><strong><?php echo $rUserInv23['otherDonorsFunding'];?></strong>
    </label>

    </div>
  </div>
   <?php }?>
  
  <?php if($rowsSubmitted_c3['otherDonorsFunding_status']){?>
  <div class="row success">

    <div class="col-100">
    <div id="projectOtherDonorsFunding">
    
<?php if($rUserInv23['otherDonorsFunding']=='Yes'){?>
<label for="fname"><?php echo $rowsSubmitted_c3['drawSynergiesOngoingProjects'];?><!--State the Donors and components they are funding – State Amount--><span class="error">*</span><br /></label>

<table width="50%" border="0" id="customers2">
        <tr>
            <th style=" display:none;">&nbsp;</th>
            <th><strong><?php echo $lang_Donor;?></strong>
            </th>
            <th><strong><?php echo $lang_new_Amount;?></strong>
            </th>
  
        </tr>
    
        
        <?php 
$projectID=$rUserProjectID['projectID'];
$sqlProjectID="SELECT * FROM ".$prefix."project_methodology_donors where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td><?php echo $rUserProjectID['StateDonors'];?>
            </td>
            <td><?php echo number_format($rUserProjectID['StateAmount']);?>
            </td>
       
        </tr>
        <?php }?>
    </table>
<?php }?>
    
    
    
    
    </div>
    </div>
    </div>
     <?php }?>
     
     
    
    <?php if($rowsSubmitted_c3['furtheringwork_status']){?>
 <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c3['furtheringwork'];?><br /><strong><?php echo $rUserInv2['furtheringWork'];?></strong>
   <div id="projectfurtheringWork">
   
   <?php 
if($rUserInv23['furtheringWork']=='Yes'){?><br />
<strong><?php echo $rUserInv23['furtheringWorkHow'];?></strong><?php }?>
   
   </div> 

    </div>
  </div>
   <?php }?>
  
   <div class="row success">

    <div class="col-100">
   
   
   <div id="projectdrawSynergies">
   
   <?php 
if($rowsSubmitted_c3['synergymayexistbetween_status']){?>
<label for="fname"><?php echo $rowsSubmitted_c3['synergymayexistbetween'];?><!--Name the Projects and the objectives. (Max 3 Projects)--> <span class="error">*</span><br /></label>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="POITable3">
<tr>
            <td style=" display:none;">&nbsp;</td>
       <th>
              <?php echo $lang_Project;?></th>
            <th><?php echo $lang_Task;?></th>
            <th> <?php echo $lang_Descrption;?></th>

     
        </tr>
        <?php 
$sqlProjectID3="SELECT * FROM ".$prefix."potential_for_synergy where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID3 = $mysqli->query($sqlProjectID3);
while($rUserProjectID3=$QueryProjectID3->fetch_array()){
?>
        <tr>
            <td style=" display:none;">&nbsp;</td>
            <td>
              <label><?php echo $rUserProjectID3['SynergyProject'];?></label></td>
            <td><label><?php echo $rUserProjectID3['SynergyTask'];?></label></td>
            <td><label><?php echo $rUserProjectID3['SynergyDescrption'];?></label></td>
            
    
   
        </tr>
        <?php }?>
    </table>
    
    <?php }?>
   
   </div> 

    
    
    </label>

    </div>
  </div> 
  
  
  
  <?php if($rowsSubmitted_c3['']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c3['synergymayexistbetween'];?><!--Explain where a potential for synergy may exist between different tasks of the project and how this is going to be exploited.--><span class="error">*</span></label>
<table width="100%" border="0" id="customers2">
        <tr>
            <th><strong><?php echo $lang_Project;?></strong></th>
            <th><strong><?php echo $lang_Task;?></strong></th>
            <th> <strong><?php echo $lang_Descrption;?></strong></th>
     
        </tr>
       <?php 
$sqlProjectID3="SELECT * FROM ".$prefix."potential_for_synergy where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID3 = $mysqli->query($sqlProjectID3);
while($rUserProjectID3=$QueryProjectID3->fetch_array()){
?>
        <tr>
   
            <td>
              <label><?php echo $rUserProjectID3['SynergyProject'];?></label></td>
            <td><label><?php echo $rUserProjectID3['SynergyTask'];?></label></td>
            <td><label><?php echo $rUserProjectID3['SynergyDescrption'];?></label></td>
         
        </tr>
        <?php }?>
    </table>

    </div>
  </div>
   <?php }?>
  




</div>


           
  <div style="overflow-x:auto; padding:30px;">
  <?php
$sqlQnsubmitted_d="SELECT * FROM ".$prefix."concept_dynamic_questions_all_e where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted_d = $mysqli->query($sqlQnsubmitted_d);
$rowsSubmitted_d=$Querysubmitted_d->fetch_array();
$totalStages_d = $Querysubmitted_d->num_rows;
$sqlUsers24="SELECT * FROM ".$prefix."concept_budget where `owner_id`='$usrm_id' and grantcallID='$grantID' order by id desc limit 0,1";
$QueryUsers24 = $mysqli->query($sqlUsers24);
$rUserInv24=$QueryUsers24->fetch_array();
$projectID=$rUserProjectID['projectID'];
?>

<h3>Budget</h3>

<table width="100%" border="1" align="left" cellpadding="0" cellspacing="0" class="tablem">
<tr>
    <td width="30" valign="top"><p align="center"><strong>&nbsp;</strong></td>
    <td width="203" valign="top"><p align="center"><strong><?php echo $lang_new_Item;?></strong></td>
    <td width="256" valign="top"><p align="center"><strong><?php echo $lang_new_Description;?></strong></td>
    <td width="328" valign="top"><p align="center"><strong><?php echo $lang_new_Amount;?></strong></td>
     <td valign="top"><p align="center"><strong><?php echo $lang_new_PercentageCeiling;?></strong></td>
    <td valign="top"><p align="center"><strong>MAX. ALLOWABLE AMOUNT</strong></td>
    </tr>
    <?php if($rowsSubmitted_d['qn_Personnel_status']){?>
    
  <tr>
    <td width="30" valign="top">1. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_Personnel'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv24['PersonnelDescription'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv24['Personnel'];?></td>
  
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_PersonnelPercentage_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv24['PersonnelTotal'];?></td>
  </tr>
  <?php }?>
  <?php if($rowsSubmitted_d['qn_ResearchCosts_status']){?>
  <tr>
    <td width="30" valign="top">2. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_ResearchCosts'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv24['ResearchCostsDescription'];?></td>
    <td width="328" valign="top">
   
    <?php echo $rUserInv24['ResearchCosts'];?>
</td>

<td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_ResearchCosts_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv24['ResearchCostsTotal'];?></td>
  </tr>
  <?php }?>
  
  
   <?php if($rowsSubmitted_d['qn_Equipment_Ceiling_status']){?>
  <tr>
    <td width="30" valign="top">3. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_Equipment'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv24['EquipmentDescription'];?></td>
    <td width="328" valign="top">
   <?php echo $rUserInv24['Equipment'];?>
   
    
    </td>
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_Equipment_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv24['EquipmentTotal'];?></td>
  </tr>
  <?php }?>
  
  <?php if($rowsSubmitted_d['qn_Travel_status']){?>
<tr>
    <td width="30" valign="top">4. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_Travel'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv24['TravelDescription'];?></td>
    <td width="328" valign="top">
  <?php echo $rUserInv24['Travel'];?>
 
    </td>
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_Travel_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv24['TravelTotal'];?></td>
  </tr>
  <?php }?>
  
  
   <?php if($rowsSubmitted_d['qn_kickoff_status']){?>
  <tr>
    <td width="30" valign="top">5. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_kickoff'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv24['kickoffDescription'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv24['kickoff'];?></td>
  
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_kickoff_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv24['kickoffTotal'];?></td>
  </tr>
  <?php }?>
  
  <?php if($rowsSubmitted_d['qn_KnowledgeSharing_status']){?>
  <tr>
    <td width="30" valign="top">6. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_KnowledgeSharing'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv24['KnowledgeSharingDescription'];?></td>
    <td width="328" valign="top">
<?php echo $rUserInv24['KnowledgeSharing'];?>
    
    </td>
    
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_KnowledgeSharing_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv24['KnowledgeSharingTotal'];?></td>
  </tr>
  <?php }?>
  
   <?php if($rowsSubmitted_d['qn_OverheadCosts_status']){?>
  <tr>
    <td width="30" valign="top">7. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_OverheadCosts'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv24['OverheadCostsDescription'];?></td>
    <td width="328" valign="top">

    <?php echo $rUserInv24['OverheadCosts'];?>
    
    </td>
   
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_OverheadCosts_Ceiling'];?></td>
    <td width="275" valign="top"><?php echo $rUserInv24['OverheadCostsTotal'];?></td>
  </tr>
  <?php }?>
  
  
   <?php if($rowsSubmitted_d['qn_OtherGoods_status']){?>
  <tr>
    <td width="30" valign="top">8. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_OtherGoods'];?></td>
      <td width="328" valign="top"><?php echo $rUserInv24['OtherGoodsDescription'];?></td>
    <td width="328" valign="top">
<?php echo $rUserInv24['OtherGoods'];?>
    
    </td>
  
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_OtherGoods_Ceiling'];?></td>
    <td width="275" valign="top">    
   <?php echo $rUserInv24['OtherGoodsTotal'];?>
    
    
    </td>
  </tr>
  <?php }?>
  
   <?php if($rowsSubmitted_d['qn_MatchingSupport_status']){?>
  
  <tr>
    <td width="30" valign="top">9. &nbsp;</td>
    <td width="203" valign="top"><?php echo $rowsSubmitted_d['qn_MatchingSupport'];?></td>
    <td width="328" valign="top"><?php echo $rUserInv24['MatchingSupportDescription'];?></td>
    <td width="328" valign="top">
<?php echo $rUserInv24['MatchingSupport'];?>
    
    </td>
    
    
    
    <td width="209" valign="top" class="txtalign" align="center"><?php echo $rowsSubmitted_d['qn_MatchingSupport_Ceiling'];?></td>
    <td width="275" valign="top">    
    <?php echo $rUserInv24['MatchingSupportTotal'];?>
    
    
    </td>


  </tr>
  <?php }?>
  <tr>
    <td width="30" valign="top">&nbsp;</td>
    <td width="203" valign="top"><p align="center"><strong><?php echo $lang_new_TotalBudgetCost;?></strong></td>
    <td width="328" valign="top">&nbsp;</td>
    <td width="275" valign="top"><?php echo numberformat($rUserInv24['TotalSubmitted']);?></td>
    <td width="209" align="center" valign="top"><strong>100</strong></td>
    <td width="275" valign="top"><?php echo $rUserInv24['TotalSubmitted'];?></td>
  </tr>
</table>



</div>            
                
     <div style="overflow-x:auto; padding:30px;">

<h3>Project Results</h3>
<?php
$sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_j where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();

$sqlUsers25="SELECT * FROM ".$prefix."project_results where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryUsers25 = $mysqli->query($sqlUsers25);
$rUserInv25=$QueryUsers25->fetch_array();
?> 

<?php if($rowsSubmitted_c['logicalflow_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><strong><?php echo $rowsSubmitted_c['logicalflow'];?><span class="error">*</span></strong></label>

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="customers">
        <tr>
        
      
           <th width="20%"><strong><em><?php echo $lang_Researchoutputs;?></em></strong></th>
    <th width="17%"><strong><em><?php echo $lang_Indicators;?></em></strong></th>
    <th width="6%">&nbsp;</th>
    <th width="20%"><strong><em><?php echo $lang_Researchoutcomes;?></em></strong></th>
    <th width="16%"><strong><em><?php echo $lang_Indicators;?></em></strong></th>
    <th width="7%">&nbsp;</th>
    <th width="14%"><strong><em><?php echo $lang_Impact;?></em></strong></th>
     
        </tr>
      
        
        <?php 
$sqlProjectID="SELECT * FROM ".$prefix."research_impact_pathway where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
     
           <td width="20%"><?php echo $rUserProjectID['ResearchOutputs1'];?></td>
    <td width="17%"><?php echo $rUserProjectID['ResearchOutputsIndicators1'];?></td>
    <td width="6%">&nbsp;</td>
    <td width="20%"><?php echo $rUserProjectID['ResearchOutcomes1'];?></td>
    <td width="16%"><?php echo $rUserProjectID['ResearchOutcomesIndicators1'];?></td>
    <td width="7%">&nbsp;</td>
    <td width="14%"><?php echo $rUserProjectID['Impact1'];?></td>
      
        </tr>
        <?php }?>
        </table>
    </div>
  </div><?php }?>

<?php if($rowsSubmitted_c['ResearchObjective_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ResearchObjective'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv25['ResearchObjective'];?></strong>
    </div>
  </div><?php }?>


<?php if($rowsSubmitted_c['Outputs_status']){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['Outputs'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv25['Outputs'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['Outcomes_status']){?>
 <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['Outcomes'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv25['Outcomes'];?></strong>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['ImpactCapacityDevelopment_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ImpactCapacityDevelopment'];?><br /><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv25['ImpactCapacityDevelopment'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['ImpactPathwayDiagram_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ImpactPathwayDiagram'];?> <span class="error">(<?php echo $lang_FilePDF;?>)</span><span class="error">*</span></label>

<?php if($rUserInv25['ImpactPathwayDiagram']){?>

<br /><a href="./files/<?php echo $rUserInv25['ImpactPathwayDiagram'];?>" target="_blank"><?php echo $lang_ClicktoViewDetails;?></a><?php }?>

    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['StakeholderEngagement_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['StakeholderEngagement'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv25['StakeholderEngagement'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['CommunicationWithStakeholders_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['CommunicationWithStakeholders'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv25['CommunicationWithStakeholders'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['ScientificOutput_status']){?>
     <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ScientificOutput'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv25['ScientificOutput'];?></strong>
    </div>
  </div><?php }?>
  
 

</div><!--End-->



</div>   







 <div style="overflow-x:auto; padding:30px;">
<h3>Project Management</h3>

<?php
$sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_k where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
$sqlUsers26="SELECT * FROM ".$prefix."project_management where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
$QueryUsers26 = $mysqli->query($sqlUsers26);
$rUserInv26=$QueryUsers26->fetch_array();
?> 

<?php if($rowsSubmitted_c['overallCoordination_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['overallCoordination'];?></span> <span class="error">*</span></label><br />


<?php if($rUserInv26['overallCoordination']){?>
<br /><a href="./files/<?php echo $rUserInv26['overallCoordination'];?>" target="_blank"><strong><?php echo $lang_new_Attachments;?></strong></a><?php }?>
    </div>
  </div><?php }?>

<?php if($rowsSubmitted_c['GantChart_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['GantChart'];?><span class="error"><?php echo $lang_FilePDF;?></span><span class="error">*</span></label><br />


<?php if($rUserInv26['GantChart']){?>
<br /><a href="./files/<?php echo $rUserInv26['GantChart'];?>" target="_blank"><strong><?php echo $lang_ClicktoViewDetails;?></strong></a><?php }?>

    </div>
  </div><?php }?>


<?php if($rowsSubmitted_c['informationFlow_status']){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['informationFlow'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv26['informationFlow'];?></strong>
    </div>
  </div><?php }?>
  
  <?php if($rowsSubmitted_c['Riskmanagement_status']){?>
 <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['Riskmanagement'];?> <span class="error">*</span></label>

<table width="50%" border="0" id="customers">
        <tr>
         
            <th><?php echo $lang_PossibleRisk;?>
            </th>
            <th><?php echo $lang_MitigationMeasure;?>
            </th>
      
        </tr>
          
        <?php 
$sqlProjectID="SELECT * FROM ".$prefix."possible_risk where `owner_id`='$usrm_id' and `projectID`='$id'";
$QueryProjectID = $mysqli->query($sqlProjectID);
while($rUserProjectID=$QueryProjectID->fetch_array()){
?>
        <tr>
         
            <td>
              <label><?php echo $rUserProjectID['PossibleRisk'];?></label>
            </td>
            <td>
              <label><?php echo $rUserProjectID['MitigationMeasure'];?></label>
            </td>
     
        </tr>
        <?php }?>
    </table>

    </div>
  </div>
  <?php }?>
  
  
  
  


</div><!--End-->
 



</div> 


 <div style="overflow-x:auto; padding:30px;">
<h3>Project Followup</h3>

<?php
$sqlQnsubmitted_c="SELECT * FROM ".$prefix."concept_dynamic_questions_all_i where grantID='$grantID' and categorym='proposal' order by id desc";
$Querysubmitted_c = $mysqli->query($sqlQnsubmitted_c);
$rowsSubmitted_c=$Querysubmitted_c->fetch_array();
$sqlUsers27="SELECT * FROM ".$prefix."project_follow_up where `owner_id`='$usrm_id' and `projectID`='$id' and grantID='$grantID' order by projectID desc limit 0,1";
$QueryUsers27 = $mysqli->query($sqlUsers27);
$rUserInv27=$QueryUsers27->fetch_array();
?> 
<div class="containerm"><!--begin-->

  
<label for="fname"><?php echo $lang_new_RequiredFieldsMarked;?> (<span class="error">*</span>)</label>

<?php if($rowsSubmitted_c['resultExploitationPlan_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['resultExploitationPlan'];?>
 <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv27['resultExploitationPlan'];?></strong>
    </div>
  </div><?php }?>


<?php if($rowsSubmitted_c['resultInnovativeResults_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['resultInnovativeResults'];?>
 <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv27['resultInnovativeResults'];?></strong>
    </div><?php }?>
  </div>
  
  <?php if($rowsSubmitted_c['resultIntellectualProperty_status']){?>
  
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['resultIntellectualProperty'];?>
 <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv27['resultIntellectualProperty'];?></strong>
    </div>
  </div><?php }?>


<?php if($rowsSubmitted_c['ethicalConsiderations_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['ethicalConsiderations'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserInv27['ethicalConsiderations'];?></strong>
    </div>
  </div><?php }?>


<?php if($rowsSubmitted_c['DealwithEthicalIssues_status']){?>
    <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['DealwithEthicalIssues'];?> <span class="error">*</span></label>
<br /><strong><?php echo $rUserInv27['DealwithEthicalIssues'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['NeedEthicalClearance_status']){?>
 <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['NeedEthicalClearance'];?><span class="error">*</span> <br /><strong><?php echo $rUserInv27['PartofInternationalProject'];?></label> 
    
    
<div id="projectwhyNoNeedEthicalCliarence"><?php if($rUserInv27['NeedEthicalClearance']=='No'){?>   
<br /><strong><?php echo $rUserInv27['NeedEthicalClearanceWhy'];?></strong><?php }?></div>

    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['GenderYouth_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['GenderYouth'];?>
<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv27['GenderYouth'];?></strong>
    </div>
  </div><?php }?>
  
  
<?php /*?>  <?php if($rowsSubmitted_c['']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['YoungResearchers'];?>
<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv27['YouthTakenccount'];?></strong>
    </div>
  </div><?php }?><?php */?>
  
  
  <?php if($rowsSubmitted_c['YoungResearchers_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['YoungResearchers'];?>
<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv27['YoungResearchers'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['InterestGroups_status']){?>
  
     <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['InterestGroups'];?>
<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv27['InterestGroups'];?></strong>
    </div>
  </div><?php }?>
  
  
  <?php if($rowsSubmitted_c['StateNatureofSupport_status']){?>
  
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['StateNatureofSupport'];?>
<span class="error">*</span></label>
<br /><strong><?php echo $rUserInv27['StateNatureofSupport'];?></strong>
    </div>
  </div><?php }?>
  
  
  
  <?php if($rowsSubmitted_c['AttachLetterofSupport_status']){?>
   <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsSubmitted_c['AttachLetterofSupport'];?> <span class="error">(<?php echo $lang_FilePDF;?>)</span>
<span class="error">*</span></label>
<?php if($rUserInv27['AttachLetterofSupport']){?>
<br /><a href="./files/<?php echo $rUserInv27['AttachLetterofSupport'];?>" target="_blank"><strong><?php echo $lang_new_letterofsupport;?></strong></a><?php }?>

    </div>
  </div>
  <?php }?>



</div><!--End-->
 



</div> 


<div style="overflow-x:auto; padding:30px;">
<h3>Citation</h3>

<div class="containerm"><!--begin-->
 
 <?php 
  $sqlDynamic="SELECT * FROM ".$prefix."concept_dynamic_questions_all_f where grantID='$grantID' and categorym='proposal' order by id asc";
	$QueryDynamic = $mysqli->query($sqlDynamic);
	$rowsDynamic=$QueryDynamic->fetch_array();
  $sqlProjectID="SELECT * FROM ".$prefix."submissions_proposals where `owner_id`='$usrm_id' and `projectID`='$id' order by projectID desc limit 0,1";
  $QueryProjectID = $mysqli->query($sqlProjectID);
  $rUserProjectID=$QueryProjectID->fetch_array();
	?>
<?php if($rowsDynamic['qn_References_status']){?>
  <div class="row success">

    <div class="col-100">
    <label for="fname"><?php echo $rowsDynamic['qn_References'];?><span class="error">*</span></label>
<br /><strong><?php echo $rUserProjectID['creferences'];?></strong>
    </div>
  </div>
<?php }?>

   

</div><!--End-->
 



</div> 


<div style="overflow-x:auto; padding:30px;">

<h3>View Attachments</h3>

<table class="table table-striped table-sm" id="customers">
                  <thead>
                          <tr>
                            <th><?php echo $lang_Attachments;?></th>
                            <th><?php echo $lang_Category;?></th>
                            <th><?php echo $lang_Updatedon;?></th>
                     
                          </tr>
                        </thead>
                        <tbody>
                        <?php
	
						
						
//if no page var is given, set start to 0
$sql = "select * FROM ".$prefix."concept_attachments where grantcallID='$grantID' and owner_id='$usrm_id' order by id desc";//informed concent
$result = $mysqli->query($sql);
while($rInvestigator=$result->fetch_array()){
	?>


<OBJECT data="files/<?php echo $rInvestigator['filename'];?>" TYPE="application/vnd.adobe.pdfxml" TITLE="SamplePdf" 
WIDTH=200 HEIGHT=100>
    <a href="files/<?php echo $rInvestigator['filename'];?>"></a> 
</object>

   <?php }///////////end function ?>                 
                     


</div> 





















             
                </div>
                <!-- row area end -->
       
                <!-- row area start-->
            </div>
        </div>
        <!-- main content area end -->
        <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright 2020 - <?php echo $year;?>. All right reserved. Grants Management System.</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <!-- offset area start -->
      
    <!-- offset area end -->
    <!-- jquery latest version -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
    zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script>
    <!-- others plugins -->
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
    

</body>

</html>
