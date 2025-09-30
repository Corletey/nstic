<?php if($_SESSION['usrm_usrtype']=='reviewer'){
	//////get all//////////////////////////
	$queryLoggedr="select * from ".$prefix."musers where usrm_username='$usrm_username'";
$rs_Logged=$mysqli->query($queryLoggedr);
$rsLogged=$rs_Logged->fetch_array();
$usrrsLoggedId=$rsLogged['usrm_id'];

$queryContributionLogs="select * from ".$prefix."conceptsasslogs where conceptm_assignedto='$usrrsLoggedId'";
$rs_ContributionLogs=$mysqli->query($queryContributionLogs);
$rsContributionLogs=$rs_ContributionLogs->fetch_array();
$conceptm_assignedto=$rsContributionLogs['conceptm_assignedto'];
///////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."concepts where conceptm_id='$id'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();
$conceptm_id=$rsContribution['conceptm_id'];
//////////////////////////////////////////////////////////////////////////////////////
$queryContribution2="select * from ".$prefix."concepts where conceptm_id='$conceptm_id'";
$rs_Contribution2=$mysqli->query($queryContribution2);
$rsContribution2=$rs_Contribution2->fetch_array();

$ms_NameOfPI=$rsContribution2['ms_NameOfPI'];
$conceptm_NameofInstitution=$rsContribution2['conceptm_NameofInstitution'];
$proposalmTittle=$rsContribution['proposalmTittle'];
$conceptm_email=$rsContribution['conceptm_email'];
$conceptm_phone=$rsContribution['conceptm_phone'];



/////////////////////Get Reviewer Details
$queryReviwer="select * from ".$prefix."musers where usrm_id='$conceptm_assignedto'";
$rs_Reviwer=$mysqli->query($queryReviwer);
$rsReviwer=$rs_Reviwer->fetch_array();
$usrm_fname=$rsReviwer['usrm_fname'];
$usrm_email=$rsReviwer['usrm_email'];
$usrm_phone=$rsReviwer['usrm_phone'];
//////////////////////////////////////////////////////////////////////////////
$sqlScoresMain = "SELECT * FROM ".$prefix."mscores where conceptm_id='$id' and EvaluatedBy='$conceptm_assignedto'";
$queryScoresMain = $mysqli->query($sqlScoresMain);
$totalScoresMain = $queryScoresMain->num_rows;

?>
<?php

if($_POST['doEvaluate']=='Update')
{
require("viewlrcn/class.phpmailer.php");
require("viewlrcn/class.smtp.php");

$QnewMethods=$_POST['QnewMethods'];	
if($QnewMethods>=31){
$errmsg="Error!! <b>Scientific quality and innovation of the joint research proposal</b>: Question has exceeded 30%";
}
////////////////////////////////////////////////////////////////////////
$QhighQuality=$_POST['QhighQuality'];
if($QhighQuality>=16){
$errmsg="Error!! <b>Feasibility  of the joint  research  proposal (Practicality,   feasibility   and   consistency   of   proposed   activities   with   the objectives  of the call,  and feasibility  of the  methodology  provided)</b>: 15%";	
}
////////////////////////////////////////////////////////////////////////
$SatisfactoryPartnership=$_POST['SatisfactoryPartnership'];
if($SatisfactoryPartnership>=16){
$errmsg="Error!! <b>3. Added value  to expect  from  collaboration Technological  capacity  building</b> 15%";	
}
///////////////////////////////////////////////////////////////////////////
//$PrototypeClearly=$_POST['PrototypeClearly'];
//if($PrototypeClearly>=26){
//$errmsg="Error!! <b>Applicability</b>: Question (a) has exceeded 25";	
//}

////////////////////////////////////////////////////////////////
$AddressIssues=$_POST['AddressIssues'];
if($AddressIssues>=6){
$errmsg="Error!! <b>4. Competence, <?php echo $lang_Expertise;?> and experience of principal investigators and relevant  scientists  / research  teams</b>: Question exceeded 5%";	
}

/////////////////////////////////////////////////
$ClearlyConvincingly=$_POST['ClearlyConvincingly'];
if($ClearlyConvincingly>=16){
$errmsg="Error!! <b>5. Clarity of expected results</b>: Question (a) has exceeded 15%";		
}

////////////////////////////////////////////////////////////////////////////////
$GenderIssues=$_POST['GenderIssues'];
if($GenderIssues>=11){
$errmsg="Error!! Question 6 has exceeded 10%";	
}

$Potential=$_POST['Potential'];
if($Potential>=6){
$errmsg="Error!! Question Potential to promote equity and ethics of the joint project (5%)";	
}

$Budget=$_POST['Budget'];
if($Budget>=6){
$errmsg="Error!! Budget has exceeded 5%";	
}


/////////////////////////////////////
$EvTotalScore=($QnewMethods+$QhighQuality+$SatisfactoryPartnership+$AddressIssues+$ClearlyConvincingly+$GenderIssues+$Potential+$Budget);
//////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////
$conceptm_id=$mysqli->real_escape_string($_POST['conceptm_id']);
$ownermID=$mysqli->real_escape_string($_POST['ownermID']);
$overallcomment=$mysqli->real_escape_string($_POST['overallcomment']);
$comment1=$mysqli->real_escape_string($_POST['comment1']);
$comment2=$mysqli->real_escape_string($_POST['comment2']);
$comment3=$mysqli->real_escape_string($_POST['comment3']);
$comment4=$mysqli->real_escape_string($_POST['comment4']);
$comment5=$mysqli->real_escape_string($_POST['comment5']);
$comment6=$mysqli->real_escape_string($_POST['comment6']);
$commentnon=$mysqli->real_escape_string($_POST['commentnon']);
$comment7=$mysqli->real_escape_string($_POST['comment7']);

$Verdict=$mysqli->real_escape_string($_POST['Verdict']);
$categorym=$mysqli->real_escape_string($_POST['categorym']);

$queryScores="update ".$prefix."mscores set   `STQnewMethods`='$QnewMethods',`STQhighQuality`='$QhighQuality',`STQSatisfactoryPartnership`='$SatisfactoryPartnership',`AppAddressIssues`='$AddressIssues',`ImpactClearlyConvincingly`='$ClearlyConvincingly',`ImpactGenderIssues`='$GenderIssues',`EvTotalScore`='$EvTotalScore',`EvoverallComment`='$overallcomment',`EvComment1`='$comment1',`EvComment2`='$comment2',`EvComment3`='$comment3',`EvComment4`='$comment4',`EvComment5`='$comment5',`EvComment6`='$comment6',`Everdict`='$Verdict',`Potential`='$Potential',`Budget`='$Budget',`EvCommentnon`='$commentnon',`EvComment7`='$comment7' where scoredmID='$id' and EvaluatedBy='$conceptm_assignedto'";
$mysqli->query($queryScores);
//////////////////////////////////////////////////////////////////////////////////////////////
$noReviewed=($rsContribution['conceptm_Reviewers']+1);

	///send email notification to admin

$message="<p class='success'><p>Successfully Evaluated. Total Score: <b>".$EvTotalScore."</b> Thank You</p>";


}//end checking permissions

$queryScore="select * from ".$prefix."mscores where scoredmID='$id' and EvaluatedBy='$conceptm_assignedto'";
$rs_Score=$mysqli->query($queryScore);
$rsScore=$rs_Score->fetch_array();
?>
 
 <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
               
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><?php echo $lang_ReviewSubmission;?></li>
                    </ol>
                </section>

<section class="content">

<form action="./main.php?option=previewscore&id=<?php echo $id;?>" method="post" name="regForm" id="regForm"  enctype="multipart/form-data">

<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td>



<div class="box box-danger">
                                <div class="box-header">
                                  &nbsp;
                                </div><!-- /.box-header -->
                                <div class="box-body">
                           
                                    <div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-check"></i>
<div  style="text-align:left!important;"><strong>1. Scientific quality and innovation of the joint research proposal (30%)</strong></div>
                                       
<table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="QnewMethods" type="text" class="required number" maxlength="2" id="QnewMethods" autocomplete="off" value="<?php echo $rsScore['STQnewMethods'];?>"/> </td>
    <td valign="top"><textarea name="comment1" cols="40" rows="" id="comment1"><?php echo $rsScore['EvComment1'];?></textarea> </td>
  </tr>
</table>
 </p>
 <div class="clear"></div>
                                       
<div  style="text-align:left!important;"><strong>2. Feasibility  of the joint  research  proposal (Practicality,   feasibility   and   consistency   of   proposed   activities   with   the objectives  of the call,  and feasibility  of the  methodology  provided) (15%) </strong></div>


<table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="QhighQuality" type="text" class="required number" maxlength="2" id="QhighQuality" autocomplete="off" value="<?php echo $rsScore['STQhighQuality'];?>"/> </td>
    <td valign="top"><textarea name="comment2" cols="40" rows="" id="comment2"><?php echo $rsScore['EvComment2'];?></textarea> </td>
  </tr>
</table>
</p>
 <div class="clear"></div>
                                       
<div  style="text-align:left!important;"><strong>3. Added value  to expect  from  collaboration Technological  capacity  building (15%)</strong></div>
 
 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="SatisfactoryPartnership" type="text" class="required number" maxlength="2" id="SatisfactoryPartnership" autocomplete="off" value="<?php echo $rsScore['STQSatisfactoryPartnership'];?>"/> </td>
    <td valign="top"><textarea name="comment3" cols="40" rows="" id="comment3"><?php echo $rsScore['EvComment3'];?></textarea> </td>
  </tr>
</table>
 
 
 </p>
  <div class="clear"></div> 
                                        
                                    </div>
                                    <div class="alert alert-warning alert-dismissable">
                                        <i class="fa fa-check"></i>
<div  style="text-align:left!important;"><strong>4. Competence, <?php echo $lang_Expertise;?> and experience of principal investigators and relevant  scientists  / research  teams (5%)</strong></div>

 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="AddressIssues" type="text" class="required number" maxlength="2" id="AddressIssues" autocomplete="off" value="<?php echo $rsScore['AppAddressIssues'];?>"/> </td>
    <td valign="top"><textarea name="comment4" cols="40" rows="" id="comment4"><?php echo $rsScore['EvComment4'];?></textarea> </td>
  </tr>
</table>




  <div class="clear"></div>          
           
           
                                    </div>
                                    
                                    
                                    <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
<div  style="text-align:left!important;"><strong>5. Clarity of expected results (15%)</strong></div>
 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="ClearlyConvincingly" type="text" class="required number" maxlength="2" id="ClearlyConvincingly" autocomplete="off" value="<?php echo $rsScore['ImpactClearlyConvincingly'];?>"/> </td>
    <td valign="top"><textarea name="comment5" cols="40" rows="" id="comment5"><?php echo $rsScore['EvComment5'];?></textarea> </td>
  </tr>
</table>



 <div class="clear"></div>
 
 
<div  style="text-align:left!important;"><strong>6. Relevance and impact of  research (Industrial Development, Technological Capacity Building, Marketing of Research Results, Agricultural Production,   Improved Health Outcomes, Economic  Growth  Improved  Livelihoods) (10%)</strong></div>
 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="GenderIssues" type="text" class="required number" maxlength="2" id="GenderIssues" autocomplete="off" value="<?php echo $rsScore['ImpactGenderIssues'];?>"/></td>
    <td valign="top"><textarea name="comment6" cols="40" rows="" id="comment6"><?php echo $rsScore['EvComment6'];?></textarea> </td>
  </tr>
</table>
</p>
 <div class="clear"></div>
</div>



<div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
<div  style="text-align:left!important;"><strong>Potential to promote equity and ethics of the joint project (5%)</strong></div>
 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="Potential" type="text" class="required number" maxlength="2" id="Potential" autocomplete="off" value="<?php echo $rsScore['Potential'];?>"/></td>
    <td valign="top"><textarea name="commentnon" cols="40" rows="" id="commentnon"><?php echo $rsScore['EvCommentnon'];?></textarea> </td>
  </tr>
</table>
  <div class="clear"></div>
 
<div  style="text-align:left!important;"><strong>7. Budget (Consistency  with  the  budget  ratio  or  percentage  provided  by  the  appeal guide, Basis of  estimates - How  well the  proposed  expenses  reflect the actual  cost of the  proposed action?) (5%)</strong></div>
 <table width="60%" border="0" align="left" style="margin-left:20px;">
  <tr>
    <td><strong><?php echo $lang_Score;?></strong></td>
    <td><strong>Comment</strong></td>
  </tr>
  <tr>
    <td valign="top"><input name="Budget" type="text" class="required number" maxlength="2" id="Budget" autocomplete="off" value="<?php echo $rsScore['Budget'];?>"/></td>
    <td valign="top"><textarea name="comment7" cols="40" rows="" id="comment7"><?php echo $rsScore['EvComment7'];?></textarea> </td>
  </tr>
</table>
 
  <div class="clear"></div>
                                    </div>




                                    
                                    
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                     <div class="alert alert-success alert-dismissable">
<i class="fa fa-check"></i>
<p><strong><?php echo $lang_OverallComment;?></strong></p>
<textarea name="overallcomment" cols="40" rows="" id="commentoverall"><?php echo $rsScore['EvoverallComment'];?></textarea>
 <div class="clear"></div>
<p><strong><?php echo $lang_Verdict;?></strong></p>
<input name="Verdict" type="radio" value="Recommended for Consideration" class="required" <?php if($rsScore['Everdict']=='Recommended for Consideration'){?>checked="checked"<?php }?>/>&nbsp;&nbsp;<?php echo $lang_RecommendedforConsideration;?><br />

<input name="Verdict" type="radio" value="Not Recommended for Consideration" class="required" <?php if($rsScore['Everdict']=='Not Recommended for Consideration'){?>checked="checked"<?php }?>/>&nbsp;&nbsp;<?php echo $lang_NotRecommendedforConsideration;?>
 <div class="clear"></div>

 
                                    </div>
                                    
                                    <p>&nbsp;</p> 
                                </div><!-- /.box-body -->                        
                                
                                
                                
                                
                                
                                
                         
                            <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/> 
                             <input name="conceptm_id" type="hidden"  value="<?php echo $rsContribution['conceptm_id'];?>"/>
                             <input name="ownermID" type="hidden"  value="<?php echo $rsContribution['usrm_id'];?>"/>

                     <table>
                               <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
<input name="doEvaluate" type="submit" class="btn btn-info btn-flat" value="Update"/>&nbsp;
<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=rvpcoconcepts'"/></td>
  </tr>
</table>



                           
                           
         
</td>
<td style="padding-right:20px;">&nbsp;</td>
<td style="padding-top:30px;" valign="top">
<?php if($message){?><div class="alert alert-warning alert-dismissable"><?php echo $message;?></div><?php }?>

<?php /*?><?php if($errmessage){?><div class="alert alert-warning alert-dismissable"><?php echo $errmessage;?></div><?php }?><?php */?>

<?php if($errmsg){?><div class="alert alert-warning alert-dismissable">
<p><b>Please correct errors below</b>:</p>
<span style="color:#F00;"><?php echo $errmsg;?></span></div><?php }?>

 </td>
</tr>
</table>

 </form>                           
 </section><?php }else{?><p style="color:#900;">Error!! You are not allowed to access this page</p><?php }?>