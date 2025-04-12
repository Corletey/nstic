<?php
///Get project Owner
$wmOwner = "select * from " . $prefix . "submissions_proposals where  projectID='$id'";
$cmdOwner = $mysqli->query($wmOwner);
$rowner = $cmdOwner->fetch_array();
if ($cmdOwner->num_rows and $id) {
  $owner_id = $rowner['owner_id'];
  $grantcallID = $rowner['grantcallID'];
  $sessionusrm_id = $_SESSION['usrm_id'];
?>

  <?php if ($_SESSION['usrm_usrtype'] == 'reviewer') {

    $queryLoggedr = "select * from " . $prefix . "musers where usrm_username='$usrm_username'";
    $rs_Logged = $mysqli->query($queryLoggedr);
    $rsLogged = $rs_Logged->fetch_array();
    $usrrsLoggedId = $rsLogged['usrm_id'];

    //////get all//////////////////////////
    $queryContributionLogs = "select * from " . $prefix . "conceptsasslogs_new where conceptm_id='$id' and conceptm_assignedto='$usrrsLoggedId'";
    $rs_ContributionLogs = $mysqli->query($queryContributionLogs);
    $rsContributionLogs = $rs_ContributionLogs->fetch_array();
    $totalConceptLogs = $rs_ContributionLogs->num_rows;
    $conceptm_assignedto = $rsContributionLogs['conceptm_assignedto'];


    if ($rsContributionLogs['categorym'] == "concepts") {
      $categorym = "concepts";
    }
    if ($rsContributionLogs['categorym'] == "proposals") {
      $categorym = "proposals";
    }
    ///////////////////////////////////////////////////////////////
    $queryContribution = "select * from " . $prefix . "submissions_proposals where projectID='$id'";
    $rs_Contribution = $mysqli->query($queryContribution);
    $rsContribution = $rs_Contribution->fetch_array();
    $conceptm_id = $rsContribution['dconceptID'];
    $conceptm_Times = $rsContribution['conceptm_Times'];
    $conceptm_Times2 = $rsContribution['conceptm_Times'] + 1;
    //////////////////////////////////////////////////////////////////////////////////////
    $queryContribution2 = "select * from " . $prefix . "submissions_proposals where projectID='$id'";
    $rs_Contribution2 = $mysqli->query($queryContribution2);
    $rsContribution2 = $rs_Contribution2->fetch_array();

    $proposalmTittle = $rsContribution['projectTitle'];





    /////////////////////Get Reviewer Details
    $queryReviwer = "select * from " . $prefix . "musers where usrm_id='$conceptm_assignedto'";
    $rs_Reviwer = $mysqli->query($queryReviwer);
    $rsReviwer = $rs_Reviwer->fetch_array();
    $usrm_fname = $rsReviwer['usrm_fname'];
    $usrm_email = $rsReviwer['usrm_email'];
    $usrm_phone = $rsReviwer['usrm_phone'];
    ///Get owner details
    $conceptm_email = $rsReviwer['usrm_email'];
    $conceptm_phone = $rsReviwer['usrm_phone'];

    //////////////////////////////////////////////////////////////////////////////
    $sqlScoresMain = "SELECT * FROM " . $prefix . "mscores_dynamic where conceptm_id='$id' and EvaluatedBy='$conceptm_assignedto' and categorym='proposals'";
    $queryScoresMain = $mysqli->query($sqlScoresMain);
    $totalScoresMain = $queryScoresMain->num_rows;

  ?>
  <?php
    if ($_POST['doSubmit']) { // and $totalConceptLogs
      require("viewlrcn/class.phpmailer.php");
      require("viewlrcn/class.smtp.php");


      for ($i = 0; $i < count($_POST['finalCategoryID']); $i++) {
        $EvTotalScore = $mysqli->real_escape_string($_POST['EvTotalScore'][$i]);
        $EvTotalScore2 .= $mysqli->real_escape_string($_POST['EvTotalScore'][$i]);
        $category_number = $mysqli->real_escape_string($_POST['question_no'][$i]);
        $finalCategoryID = $mysqli->real_escape_string($_POST['finalCategoryID'][$i]);
        $scomment = $mysqli->real_escape_string($_POST['scomment'][$i]);

        ///////////////////////////////////////////////////////////////////////////////////////
        $conceptm_id = $mysqli->real_escape_string($_POST['conceptm_id']);
        $ownermID = $mysqli->real_escape_string($_POST['owner_id']);
        $overallcomment = $mysqli->real_escape_string($_POST['overallcomment']);


        $Verdict = $mysqli->real_escape_string($_POST['Verdict']);
        $categorym = $mysqli->real_escape_string($_POST['categorym']);

        $sqlScores = "SELECT * FROM " . $prefix . "mscores_dynamic where conceptm_id='$id' and EvaluatedBy='$conceptm_assignedto' and grantID='$grantcallID' and question_id='$finalCategoryID' and categorym='proposals'";
        $queryScores = $mysqli->query($sqlScores);
        $totalScores = $queryScores->num_rows;
        $rScores = $queryScores->fetch_array();

        if (!$totalScores) {
          $queryScores = "insert into " . $prefix . "mscores_dynamic (`conceptm_id`,`EvTotalScore`,`EvaluatedBy`,`DateEvaluated`,`usrm_id`,`scomment`,`EvoverallComment`,`categorym`,`openstatus`,`question_id`,`Verdict`,`grantID`) 
values('$id','$EvTotalScore','$sessionusrm_id',now(),'$ownermID','$scomment','$overallcomment','proposals','open','$finalCategoryID','$Verdict','$grantcallID')";
          $mysqli->query($queryScores);
          $record_id = $mysqli->insert_id;
          //////////////////////////////////////////////////////////////////////////////////////////////




          //if($record_id){}
        }
        if ($totalScores) {
          $queryScores = "update " . $prefix . "mscores_dynamic set `EvTotalScore`='$EvTotalScore',`scomment`='$scomment',`EvoverallComment`='$overallcomment',`Verdict`='$Verdict' where conceptm_id='$id' and EvaluatedBy='$sessionusrm_id' and question_id='$finalCategoryID' and grantID='$grantcallID' and categorym='proposals'";
          $mysqli->query($queryScores);
        }
      } ////end foeeach loop
      $message = "<p class='success'><p>Successfully Saved. Thank You</p>";
    } //end checking permissions

  }


  $sqlUsers4 = "SELECT * FROM " . $prefix . "submissions_proposals where projectID='$id' and grantcallID='$grantcallID' order by projectID desc limit 0,1";
  $QueryUsers4 = $mysqli->query($sqlUsers4);
  $rUserInv4 = $QueryUsers4->fetch_array();

  //////////////////////////Score

  $sqlUsersScore = "SELECT * FROM " . $prefix . "mscores_dynamic where conceptm_id='$id' and EvaluatedBy='$sessionusrm_id'  and grantID='$grantcallID'   and categorym='proposals' order by scoredmID desc limit 0,1";
  $QueryScore = $mysqli->query($sqlUsersScore);
  $rsScore = $QueryScore->fetch_array();
  ?>



  <div id="conceptScoreReviewerss" class="tabcontents">



    <h3><?php echo $lang_GiveScoretoConcept; ?></h3><b><?php if ($message) { ?><?php echo $message; ?><?php } ?>
      <?php if ($errmsg) { ?><?php echo $errmsg; ?><?php } ?></b>
    <form action="" method="post" name="regForm" id="regForm" autocomplete="off">
      <input type="hidden" name="asrmApplctID" value="<?php echo $id; ?>">
      <input type="hidden" name="proposalTittle" value="<?php echo $rowner['project_title']; ?>">
      <input type="hidden" name="owner_id" value="<?php echo $rowner['owner_id']; ?>">
      <input type="hidden" name="conceptm_id" value="<?php echo $dconceptID; ?>">


      <div class="container"><!--begin-->


        <div class="row success">

          <div class="col-100">



            <table width="100%" border="0" id="customers">
              <tr>
                <th width="35%"><strong><?php echo $lang_Score; ?></strong></th>
                <th width="49%"><strong><?php echo $lang_ProvideComments; ?></strong></th>
              </tr>


              <?php
              $qn_no = 0;
              $sqlQuestions = "SELECT * FROM " . $prefix . "mscores_dynamic_qns where grantID='$grantcallID'  and categorym='proposals' order by qn_number asc";
              $QueryQuestions = $mysqli->query($sqlQuestions);
              while ($rQuestions = $QueryQuestions->fetch_array()) {

                $question_id = $rQuestions['id'];

                $sqlScores2 = "SELECT * FROM " . $prefix . "mscores_dynamic where conceptm_id='$id' and EvaluatedBy='$conceptm_assignedto' and question_id='$question_id'  and grantID='$grantcallID'  and categorym='proposals'";
                $queryScores2 = $mysqli->query($sqlScores2);
                $totalScores2 = $queryScores2->num_rows;
                $rScores2 = $queryScores2->fetch_array();
                $qn_no++;
              ?>
                <tr>
                  <td colspan="2"><strong><?php echo $qn_no; ?>. <?php echo $rQuestions['question']; ?> (<?php echo $rQuestions['percentScore']; ?> %)</strong></td>
                </tr>
                <tr>
                  <td valign="top">
                    <input name="finalCategoryID[]" type="hidden" value="<?php echo $rQuestions['id']; ?>" />

                    <script type="text/javascript">
                      function imposeMinMax(el) {
                        if (el.value != "") {
                          if (parseInt(el.value) < parseInt(el.min)) {
                            el.value = el.min;
                          }
                          if (parseInt(el.value) > parseInt(el.max)) {
                            el.value = el.max;
                          }
                        }
                      }
                    </script>


<input name="EvTotalScore[]" type="number" class="requiredm number" id="QnewMethods" autocomplete="off" value="<?php echo $rScores2['EvTotalScore']; ?>" min="1" max="<?php echo $rQuestions['percentScore']; ?>" onkeyup="imposeMinMax(this)" placeholder="Enter score" />

                  </td>

                  <td valign="top"><textarea name="scomment[]" cols="40" rows="" id="comment1" placeholder="Add your comments here"><?php echo $rScores2['scomment']; ?></textarea> </td>

                </tr>

              <?php //end 
              } ?>
              <tr>
                <td colspan="2">
                  <p><strong><?php echo $lang_OverallComment; ?></strong></p>
                  <textarea name="overallcomment" cols="40" rows="" id="commentoverall"><?php echo $rScores2['EvoverallComment']; ?></textarea>
                  <div class="clear"></div>
                  <p><strong><?php echo $lang_Verdict; ?></strong></p>
                  <input name="Verdict" type="radio" value="Recommended for Consideration" class="required" <?php if ($rScores2['Verdict'] == 'Recommended for Consideration') { ?>checked="checked" <?php } ?> />&nbsp;&nbsp;<?php echo $lang_RecommendedforConsideration; ?><br />

                  <input name="Verdict" type="radio" value="Not Recommended for Consideration" class="required" <?php if ($rScores2['Verdict'] == 'Not Recommended for Consideration') { ?>checked="checked" <?php } ?> />&nbsp;&nbsp;<?php echo $lang_NotRecommendedforConsideration; ?>

                </td>
              </tr>

            </table>


          </div>
        </div>

        <div class="row success">
          <input type="submit" name="doSubmit" value="<?php echo $lang_new_Save; ?>">

        </div>

      </div><!--End-->


    </form>


  </div>
  <script>
    function openCity(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();
  </script><?php } ?>