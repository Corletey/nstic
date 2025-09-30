<!-- dynamic_proposal_call -->

<script language="JavaScript">
  function toggle(source) {
    var checkbox = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkbox.length; i++) {
      if (checkbox[i] != source)
        checkbox[i].checked = source.checked;
    }
  }
</script><?php
          /*Begin add new category*/
          $sessionusrm_id = $_SESSION['usrm_id'];
          $action = $mysqli->real_escape_string($_GET['action']);
          $grantID = $mysqli->real_escape_string($_GET['grantID']);

          $sqlGRant = "SELECT * FROM " . $prefix . "grantcalls order by grantID desc limit 0,1";
          $QueryGRant = $mysqli->query($sqlGRant);
          $totalGRant = $QueryGRant->num_rows;
          $rGRant = $QueryGRant->fetch_array();
          if ($action = "update") {
            //$sqlProjectID2rUpdate="UPDATE ".$prefix."grantcall_categories set `status`='new' where  grantID='$id' and categorym='proposal' order by category_number asc";
            //$QueryProjectID2rUpdate = $mysqli->query($sqlProjectID2rUpdate);
          }



          if ($_POST['doSaveProceed'] and $_SESSION['usrm_id'] and $action = "new" and !$id) {








            ///////////////////End if category is saved


            $sqlUsers = "SELECT * FROM " . $prefix . "grantcalls where `grant_adminID`='$sessionusrm_id' and grantID='$idgrantID' order by grantID desc limit 0,1";
            $QueryUsers = $mysqli->query($sqlUsers);
            $totalUsers = $QueryUsers->num_rows;
            $rUserInv = $QueryUsers->fetch_array();


            if (!$totalUsers) {
              $sqlA2 = "insert into " . $prefix . "grantcalls (`title`,`summary`,`details`,`attachment`,`startDate`,`EndDate`,`category`,`conceptID`,`shortacronym`,`dynamic`,`grant_adminID`,`publish`) 

values('$title','$summary','$details','$attachmentFile2','$startDate','$EndDate','proposals',NULL,'$shortacronym','Yes','$sessionusrm_id','No')";
              $mysqli->query($sqlA2);
              $newGrantID = $mysqli->insert_id;


              ///If category is saved, then add to stages questions_add_stages
              $sqlSaved = "SELECT * FROM " . $prefix . "concept_dynamic_stages where categorym='proposal' and catadmin_id='$sessionusrm_id' and grantcallID='$idgrantID' order by id desc limit 0,1";
              $QuerySaved = $mysqli->query($sqlSaved);
              if (!$QuerySaved->num_rows) {
                $sqlSaved = "insert into " . $prefix . "concept_dynamic_stages (`categorym`,`categories_up`,`catordering_up`,`questions_up`,`call_up`,`ProjectInformation`,`Introduction`,`ProjectDetails`,`Budget`,`Citations`,`dateCreated`,`status`,`grantcallID`,`catadmin_id`) 
values('proposal','1','0','0','0','0','0','0','0','0',now(),'new','$newGrantID','$sessionusrm_id')";
                $mysqli->query($sqlSaved);
              }


              for ($i = 0; $i < count($_POST['category']); $i++) {
                $category = $mysqli->real_escape_string($_POST['category'][$i]);

                $category_number = $mysqli->real_escape_string($_POST['category_number'][$i]);
                $finalCategoryID = $mysqli->real_escape_string($_POST['finalCategoryID'][$i]);



                $sqlUsers = "SELECT * FROM " . $prefix . "grantcall_categories where `categoryName`='$category' and categorym='proposal' and catadmin_id='$sessionusrm_id' and grantID='$idgrantID' order by categoryID desc limit 0,1";
                $QueryUsers = $mysqli->query($sqlUsers);
                if (!$QueryUsers->num_rows and $category) {
                  $sqlA2 = "insert into " . $prefix . "grantcall_categories (`categoryName`,`categorym`,`date_added`,`status`,`grantID`,`category_number`,`catadmin_id`,`catadminstatus`) 

values('$category','proposal',now(),'new','$newGrantID','1','$sessionusrm_id','dynamic')";
                  $mysqli->query($sqlA2);
                  $message = '<p class="success">Dear ' . $session_fullname . ', details have been submitted, please add another category.</p>';
                  //$newGrantID=$mysqli->insert_id;

                }
              } //end foreach

              echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=DynamicCallProposals&id=$newGrantID&action=update'>";
            }
          } //end Post and end $action=="new"
          /////////////////Update from here.


          if ($_POST['doSaveProceed'] and $_SESSION['usrm_id'] and $action = "update" and $id) {


            for ($i = 0; $i < count($_POST['category']); $i++) {
              $category = $mysqli->real_escape_string($_POST['category'][$i]);

              $category_number = $mysqli->real_escape_string($_POST['category_number'][$i]);
              $finalCategoryID = $mysqli->real_escape_string($_POST['finalCategoryID'][$i]);



              $sqlUsers = "SELECT * FROM " . $prefix . "grantcall_categories where `categoryName`='$category' and categorym='proposal' and catadmin_id='$sessionusrm_id' and grantID='$id' order by categoryID desc limit 0,1";
              $QueryUsers = $mysqli->query($sqlUsers);
              if (!$QueryUsers->num_rows and $category) {
                $sqlA2 = "insert into " . $prefix . "grantcall_categories (`categoryName`,`categorym`,`date_added`,`status`,`grantID`,`category_number`,`catadmin_id`,`catadminstatus`) 

values('$category','proposal',now(),'new','$id','$category_number','$sessionusrm_id','dynamic')";
                $mysqli->query($sqlA2);
                $message = '<p class="success">Dear ' . $session_fullname . ', details have been submitted, please add another category.</p>';
              }
            } //end foreach
            echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=DynamicCallProposals&id=$id&action=update'>";

            ///////////////////End if category is saved

          }


          if ($_POST['doNextPage'] == 'Proceed to Next Page' and $id) {

            $sqlCatNos = "SELECT * FROM " . $prefix . "grantcall_categories where grantID='$id'  and categorym='proposal' and catadmin_id='$sessionusrm_id' order by categoryID desc";
            $QueryCatNos = $mysqli->query($sqlCatNos);
            $rowsCount = $QueryCatNos->fetch_array();
            $AnyCategorySaved = $QueryCatNos->num_rows;

            if ($AnyCategorySaved) {
              echo '<img src="./img/ajax-loader1.gif">';
              echo '<div class="spacer"></div>';
              echo "<meta http-equiv='REFRESH' content='0;url=$base_url/main.php?option=DynamicCallProposalsUpdate&id=$id&action=update'>";
            } else {

              $message = '<p class="error2">Dear ' . $session_fullname . ', you have saved any category. Please check list to confirm.</p>';
            }
          }

          //Get the last category
          $sqlLastQn = "SELECT * FROM " . $prefix . "grantcall_categories where grantID='$id' order by categoryID desc limit 0,1";
          $QueryLastQn = $mysqli->query($sqlLastQn);
          $rUserLastQn = $QueryLastQn->fetch_array();

          //check any category
          $sqlCatGrantCategoryUp = "SELECT * FROM " . $prefix . "concept_dynamic_stages where grantcallID='$id' and grantcallID>=1  and categorym='proposal' and catadmin_id='$sessionusrm_id' order by id desc";
          $AnyCategorySavedUP = $mysqli->query($sqlCatGrantCategoryUp);
          $AnyCategoryRows = $AnyCategorySavedUP->fetch_array();
          $AnyCategorySavedG = $AnyCategorySavedUP->num_rows;
          ?><div class="tab">

  <button <?php if ($AnyCategoryRows['categories_up'] == '1') { ?>class="tablinks" <?php } ?> onclick="openCity(event, 'DynamicCallProposals')" id="defaultOpen"><?php echo $lang_new_AddProposalCategories; ?> </button>

  <?php
  if ($AnyCategorySavedG) { ?>
    <button <?php if ($AnyCategoryRows['catordering_up'] == '1') { ?>class="tablinks" <?php } ?> onClick="window.location.href='./main.php?option=DynamicCallProposalsUpdate&id=<?php echo $id; ?>&action=update'"><?php echo $lang_new_UpdateOrdering; ?> </button>

    <button <?php if ($AnyCategoryRows['questions_up'] == '1') { ?>class="tablinks" <?php } ?> onClick="window.location.href='./main.php?option=DynamicCallProposalQns&id=<?php echo $id; ?>&action=update'"><?php echo $lang_new_AddQuestionsCategories; ?> </button>
    <button <?php if ($AnyCategoryRows['call_up'] == '1') { ?>class="tablinks" <?php } ?> onClick="window.location.href='./main.php?option=SubmitCallforProposalNew&id=<?php echo $id; ?>&action=update'"><?php echo $lang_new_FInishSubmitCOncept; ?></button>
  <?php } ?>

</div>

<div id="DynamicCallProposals" class="tabcontent ">
  <span onclick="this.parentElement.style.display='none'" class="topright">&times</span>
  <?php if ($message) { ?><div style="color:#F00; font-size:18px;"><?php echo $message; ?></div><?php } ?>

  <h3><?php echo $lang_new_ProposalCallsCategories; ?></h3>

  <!--<button id="myBtn" style="float:right;">Click to Add More Categories</button>
<div style="clear:both;"></div>-->

  <form action="" method="post" name="regForm" id="regForm" autocomplete="off" enctype="multipart/form-data">


    <div class="container success"><!--begin-->

      <label for="fname"><?php echo $lang_new_PleaseChooseCategories; ?> (<span class="error">*</span>)</label>



      <div class="row success">


        <?php
        if ($id and !$_POST['doSaveData'] and $sessionusrm_id) {
          $catID = $_GET['catID'];
          $sqlProjectIDDel = "SELECT * FROM " . $prefix . "grantcall_categories where categoryID='$catID'  and grantID='$id' and grantID>=1 order by categoryID desc";
          $QueryProjectIDDel = $mysqli->query($sqlProjectIDDel);
          $rUserProjectIDDel = $QueryProjectIDDel->fetch_array();

          if ($QueryProjectIDDel->num_rows) {
            $newcatid = $rUserProjectIDDel['categoryID'];
            $newmaincatid = $rUserProjectIDDel['categoryName'];

            $sqlA2Protocol2 = "delete from " . $prefix . "grantcall_categories where categoryID='$newcatid' and catadmin_id='$sessionusrm_id'";
            $mysqli->query($sqlA2Protocol2);
            ///Dont delete main categories

            $sqlProjectIDDelMain = "SELECT * FROM " . $prefix . "dynamic_categories_main where category_id='$newmaincatid' and catadminstatus='dynamic' order by category_id desc limit 0,1";
            $QueryProjectIDDelMain = $mysqli->query($sqlProjectIDDelMain);
            if ($QueryProjectIDDelMain->num_rows) {
              $sqlA2Protocol22 = "delete from " . $prefix . "dynamic_categories_main where category_id='$newmaincatid' and catadmin_id='$sessionusrm_id' and catadminstatus='dynamic'";
              $mysqli->query($sqlA2Protocol22);
            }

            $message = '<p class="error2">Dear ' . $session_fullname . ', category has been removed from your list.</p>';
          }
        }

        $sqlProjectID2 = "SELECT * FROM " . $prefix . "dynamic_categories_main where `published`='Yes' and (catadmin_id='$sessionusrm_id' || catadminstatus='fixed' || catadminstatus='proposal') and category_id!='5' order by category_rank asc";
        $QueryProjectID2 = $mysqli->query($sqlProjectID2);
        if ($QueryProjectID2->num_rows) { ?>
          <table width="100%" border="0">
            <tr>
              <th>&nbsp; <input type="checkbox" onclick="toggle(this);" />Enable</th>
              <th>Category</th>
              <th>Action </th>
            </tr>



            <?php
            while ($rUserProjectID2 = $QueryProjectID2->fetch_array()) {
              $category_id = $rUserProjectID2['category_id'];
              /* category_name*/
              $sqlProjectID3 = "SELECT * FROM " . $prefix . "grantcall_categories where grantID='$id' and grantID>=1 and categorym='proposal' and categoryName='$category_id' and catadmin_id='$sessionusrm_id' order by categoryID desc";
              $QueryProjectID3 = $mysqli->query($sqlProjectID3);
              $rUserProjectID3 = $QueryProjectID3->fetch_array();

            ?>
              <tr>
                <td width="7%" style="border-bottom:2px solid #4CAF50; border-right:2px solid #4CAF50;">
                  <?php if ($category_id == 1) { ?>
                    <input name="category[]" type="checkbox" value="<?php echo $rUserProjectID2['category_id']; ?>" checked="checked" readonly="readonly" />
                  <?php } ?>

                  <?php if ($category_id != 1) { ?>
                    <input name="category[]" type="checkbox" value="<?php echo $rUserProjectID2['category_id']; ?>" <?php if ($rUserProjectID2['category_id'] == $rUserProjectID3['categoryName']) { ?>checked="checked" <?php } ?> />
                  <?php } ?>


                  <?php /*?><input name="finalCategoryID[]" type="hidden" value="<?php echo $rUserProjectID3['categoryID'];?>" /><?php */ ?>

                </td>

                <td width="47%" style="border-bottom:2px solid #4CAF50; border-right:2px solid #4CAF50;"><?php if ($base_lang == 'en') {
                                                                                                            echo $rUserProjectID2['category_name'];
                                                                                                          }
                                                                                                          if ($base_lang == 'fr') {
                                                                                                            echo $rUserProjectID2['category_name_fr'];
                                                                                                          }
                                                                                                          if ($base_lang == 'pt') {
                                                                                                            echo $rUserProjectID2['category_name_pt'];
                                                                                                          } ?></td>


                <td width="18%" align="center" style="border-bottom:2px solid #4CAF50;">


                  <?php if ($QueryProjectID3->num_rows and $rUserProjectID3['categoryName'] != 1) { ?> <a href="./main.php?option=DynamicCallProposals&id=<?php echo $id; ?>&catID=<?php echo $rUserProjectID3['categoryID']; ?>&action=update" style="color:#F00;padding:5px; font-size:12px;" onclick="return confirm('Are you sure you want to remove this Category?');"><?php echo $lang_new_RemoveCategory; ?></a><?php } ?></td>
              </tr>


            <?php } ?>


          <?php } ?>

          </table>

          <?php
          if ($AnyCategorySavedG) { ?><input type="submit" name="doNextPage" value="<?php echo $lang_proceed_to; ?>" style="margin-left:20px; background:#F93;"><?php } ?>
          <input type="submit" name="doSaveProceed" value="<?php echo $lang_SaveCategories; ?>">


      </div>
    </div><!--End-->


  </form>



</div>






</div>


<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h3><strong>Add new theme/category</strong></h3>
    </div>
    <div class="modal-body" style="height:450px; overflow:scroll;">
      <!--<h4>Name Principal Investigator- please mention the PI of the project who will be the applicant to submit the proposal</h4>-->
      <form action="" method="post" name="regForm" id="regForm" autocomplete="off">



        <div class="container"><!--begin-->

          <label for="fname">Please add categories for this new call concept. (<span class="error">*</span>)</label>

          <div class="row success">

            <div class="col-100">
              <table width="100%" border="0">
                <tr>
                  <td width="100%"><label for="fname">Category/Theme <span class="error">*</span></label>
                    <input type="text" id="MyTextBox3mmmm" name="newcategory" placeholder="Category/Theme.." value="<?php echo $rUserInv2['categoryName']; ?>" required onKeyUp="showUser(this.value)">


                    <div id="txtHint"></div>
                  </td>

                </tr>
              </table>


            </div>



          </div>

          <div class="row success">
            <input type="submit" name="doSaveData" value="Save">
          </div>


      </form>
    </div>
  </div>
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
</script>