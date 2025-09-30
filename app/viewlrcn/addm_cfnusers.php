  <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>

                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> <?php echo $lang_home;?></a></li>
                        <li class="active">Register Users</li>
                    </ol>
                </section>

<section class="content">
  <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){?> 
<form action="./main.php?option=suser" method="post" name="regForm" id="regForm" enctype="multipart/form-data">
<?php echo $message;?>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->  
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Login Details</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                              
                                    <div class="box-body">
                                    
                                <div class="form-group">
                                  <label class="control-label" for="inputSuccess">First Name <font color="#CC0000">*</font></label>
                                  <input type="text" class="form-control required" name="fname"  value="<?php echo $sq['usrm_fname'];?>" id="fname"/>
                                  </div>
                                  
                                  <div class="form-group">
                                  <label class="control-label" for="inputSuccess">Last Name <font color="#CC0000">*</font></label>
                                  <input type="text" class="form-control required" name="sname"  value="<?php echo $sq['usrm_sname'];?>" id="sname"/>
                                  </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address <font color="#CC0000">*</font></label>
                                            <input type="email" class="form-control required email" name="email" id="exampleInputEmail1" value="<?php echo $sq['usrm_email'];?>">
                                            
                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Date of Birth <font color="#CC0000">*</font></label><br>
                                            <select name="date" id="ddate" class="required mmm" tabindex="6">
      <option value="">Date</option>
      <option value="01" <?php if($chop3=='01'){?> selected="selected"<?php }?>>&nbsp;01</option>
      <option value="02" <?php if($chop3=='02'){?> selected="selected"<?php }?>>&nbsp;02</option>
      <option value="03" <?php if($chop3=='03'){?> selected="selected"<?php }?>>&nbsp;03</option>
      <option value="04" <?php if($chop3=='04'){?> selected="selected"<?php }?>>&nbsp;04</option>
      <option value="05" <?php if($chop3=='05'){?> selected="selected"<?php }?>>&nbsp;05</option>
      <option value="06" <?php if($chop3=='06'){?> selected="selected"<?php }?>>&nbsp;06</option>
      <option value="07" <?php if($chop3=='07'){?> selected="selected"<?php }?>>&nbsp;07</option>
      <option value="08" <?php if($chop3=='08'){?> selected="selected"<?php }?>>&nbsp;08</option>
      <option value="09" <?php if($chop3=='09'){?> selected="selected"<?php }?>>&nbsp;09</option>
      <option value="10" <?php if($chop3=='10'){?> selected="selected"<?php }?>>&nbsp;10</option>
      <option value="11" <?php if($chop3=='11'){?> selected="selected"<?php }?>>&nbsp;11</option>
      <option value="12" <?php if($chop3=='12'){?> selected="selected"<?php }?>>&nbsp;12</option>
      <option value="13" <?php if($chop3=='13'){?> selected="selected"<?php }?>>&nbsp;13</option>
      <option value="14" <?php if($chop3=='14'){?> selected="selected"<?php }?>>&nbsp;14</option>
      <option value="15" <?php if($chop3=='15'){?> selected="selected"<?php }?>>&nbsp;15</option>
      <option value="16" <?php if($chop3=='16'){?> selected="selected"<?php }?>>&nbsp;17</option>
      <option value="17" <?php if($chop3=='17'){?> selected="selected"<?php }?>>&nbsp;17</option>
      <option value="18" <?php if($chop3=='18'){?> selected="selected"<?php }?>>&nbsp;18</option>
      <option value="19" <?php if($chop3=='19'){?> selected="selected"<?php }?>>&nbsp;19</option>
      <option value="20" <?php if($chop3=='20'){?> selected="selected"<?php }?>>&nbsp;20</option>
      <option value="21" <?php if($chop3=='21'){?> selected="selected"<?php }?>>&nbsp;21</option>
      <option value="22" <?php if($chop3=='22'){?> selected="selected"<?php }?>>&nbsp;22</option>
      <option value="23" <?php if($chop3=='23'){?> selected="selected"<?php }?>>&nbsp;23</option>
      <option value="24" <?php if($chop3=='24'){?> selected="selected"<?php }?>>&nbsp;24</option>
      <option value="465" <?php if($chop3=='25'){?> selected="selected"<?php }?>>&nbsp;25</option>
      <option value="26" <?php if($chop3=='26'){?> selected="selected"<?php }?>>&nbsp;26</option>
      <option value="27" <?php if($chop3=='27'){?> selected="selected"<?php }?>>&nbsp;27</option>
      <option value="28" <?php if($chop3=='28'){?> selected="selected"<?php }?>>&nbsp;28</option>
      <option value="29" <?php if($chop3=='29'){?> selected="selected"<?php }?>>&nbsp;29</option>
      <option value="30" <?php if($chop3=='30'){?> selected="selected"<?php }?>>&nbsp;30</option>
      <option value="31" <?php if($chop3=='31'){?> selected="selected"<?php }?>>&nbsp;31</option>
    </select>
      <select name="month" id="dmonth" class="required mmm" tabindex="7">
        <option value="">&nbsp;Month</option>
      <option value="01" <?php if($chop2=='01'){?> selected="selected"<?php }?>>&nbsp;January</option>
        <option value="02" <?php if($chop3=='02'){?> selected="selected"<?php }?>>&nbsp;Feabruary</option>
        <option value="03" <?php if($chop3=='03'){?> selected="selected"<?php }?>>&nbsp;March</option>
        <option value="04" <?php if($chop3=='04'){?> selected="selected"<?php }?>>&nbsp;April</option>
        <option value="05" <?php if($chop3=='05'){?> selected="selected"<?php }?>>&nbsp;May</option>
        <option value="06" <?php if($chop3=='06'){?> selected="selected"<?php }?>>&nbsp;June</option>
        <option value="07" <?php if($chop3=='07'){?> selected="selected"<?php }?>>&nbsp;July</option>
        <option value="08" <?php if($chop3=='08'){?> selected="selected"<?php }?>>&nbsp;August</option>
        <option value="09" <?php if($chop3=='09'){?> selected="selected"<?php }?>>&nbsp;September</option>
        <option value="10" <?php if($chop3=='10'){?> selected="selected"<?php }?>>&nbsp;October</option>
        <option value="11" <?php if($chop3=='11'){?> selected="selected"<?php }?>>&nbsp;November</option>
        <option value="12" <?php if($chop3=='12'){?> selected="selected"<?php }?>>&nbsp;December</option>
      </select>
      <select name="yearm" id="dyear" class="required mmm" tabindex="8">
        <option value="">Year</option>
        <?php
define('DOB_YEAR_START', 1920);

$current_year = (date('Y')-17);

for ($count = $current_year; $count >= DOB_YEAR_START; $count--)
{
?>
        <option value="<?php echo $count;?>"  <?php if($chop1==$count){?> selected="selected"<?php }?>><?php echo $count;?></option>
        <?php }?>
      </select>
                                            
                                            
                                        </div>  
                                                                           
                                        
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password <font color="#CC0000">*</font></label>
                                           <input type="password" class="form-control" name="pwd" minlength="5" id="pwd" value="" autocomplete="off">
                                        </div>
                                  
                                         <div class="form-group">
                                            <label for="exampleInputPassword1">Re-type Password <font color="#CC0000">*</font></label>
                                            
                                          
                                            
                                            
                                            <input type="password" class="form-control" name="pwd2" id="pwd2" minlength="5"   equalto="#pwd" autocomplete="off">
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                         <div class="form-group">
                                            <label for="exampleInputPassword1">User Role <font color="#CC0000">*</font></label>

 <select name="usrm_usrtype" id="usrm_usrtype" class="required form-control" tabindex="6">
    <option value="">&nbsp; Please Select</option>


<option value="user">&nbsp;User</option>
<option value="admin">&nbsp;Admin</option>
<option value="superadmin">&nbsp;Superadmin</option>
<option value="reviewer">&nbsp;Reviewer</option>
  </select>

                                        </div>
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                    </div><!-- /.box-body -->

                         
                           
                            </div><!-- /.box -->

                            <!-- Form Element sizes -->
                   

                        </div><!--/.col (left) -->
                        <!-- right column -->
                        <div class="col-md-6">
                            <!-- general form elements disabled -->
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo $lang_Contacts;?> and Addresses</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                        <!-- text input -->
                                  
                                        <div class="form-group">
                                            <label for="exampleInputPassword1"><?php echo $lang_institution_of_affiliation;?> <font color="#CC0000">*</font></label>
                                           <input type="text" class="form-control required" name="Institution" id="Institution" value="<?php echo $sq['usrm_NameofInstitution'];?>">
                                           
                                           
                                        </div> 
                                     <div class="form-group">
    <label class="control-label" for="inputSuccess"><?php echo $lang_Gender;?> <font color="#CC0000">*</font></label>
    <input name="Gender" type="radio" value="Male" tabindex="14" id="Gender" <?php if($sq['usrm_gender']=='Male'){?>checked="checked"<?php }?>/> <?php echo $lang_Male;?>&nbsp;
      <input name="Gender" type="radio" value="Female"  tabindex="15" id="Gender" <?php if($sq['usrm_gender']=='Female'){?>checked="checked"<?php }?>/> <?php echo $lang_Female;?>
    </div>
    
    <div class="form-group">
                                            <label class="control-label" for="inputSuccess"><?php echo $lang_phone_number;?> <font color="#CC0000">*</font></label>
                                            <input type="text" class="form-control required" name="phone"  value="<?php echo $sq['usrm_phone'];?>"/>
    </div>
    
    <div class="form-group">
    <label class="control-label" for="inputSuccess"><?php echo $lang_Qualifications;?> <font color="#CC0000">*</font></label>
    
     <select name="Qualifications" id="Qualifications" class="required form-control" tabindex="6" onChange="getQualification(this.value)">
        <option value="">&nbsp; <?php echo $lang_please_select;?></option>
        <option value="Diploma" <?php if($sq['usrm_Qualification']=='Diploma'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Diploma;?></option>
        <option value="Bachelor's Degree" <?php if($sq['usrm_Qualification']=="Bachelor's Degree"){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Bachelor;?></option>
        <option value="Master's Degree" <?php if($sq['usrm_Qualification']=="Master's Degree"){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Master;?></option>
        <option value="PHD" <?php if($sq['usrm_Qualification']=='PHD'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_PHD;?></option>
        <option value="Post-Doctoral" <?php if($sq['usrm_Qualification']=='Post-Doctoral'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_post_Doctoral;?> </option>
        <option value="Other" <?php if($sq['usrm_Qualification']=='Other'){?>selected="selected"<?php }?>>&nbsp;<?php echo $lang_Other;?></option>
      </select>
      </select>
    </div>
    
    <div class="form-group">
                                            <label for="exampleInputPassword1"><?php echo $lang_Nationality;?> <font color="#CC0000">*</font></label>
                                      <select name="Nationality" id="Nationality" class="required form-control" tabindex="6">
    <option value="">&nbsp; <?php echo $lang_please_select;?></option>
    <?php
$sqlUser = "SELECT * FROM ".$prefix."countries order by cidm_country_name asc";
$queryUser = $mysqli->query($sqlUser);
while($r = $queryUser->fetch_array()){?>
    <option value="<?php echo $r['cidm_country_id'];?>"  <?php if($sq['usrm_Nationality']==$r['cidm_country_id']){?>selected="selected"<?php }?>>&nbsp;<?php echo $r['cidm_country_name'];?></option>
    <?php }?>
  </select>
                                        </div>
                                        
                                        
                                         <div class="form-group">
                                           <?php if($sq['usrm_profilepic']){?><img src="files/photos/thumb_<?php echo $sq['usrm_profilepic'];?> "  style="border:1px solid #CCC; padding:2px;"/><?php }?><br /> <b><?php echo $lang_Uploadprofilepicture;?></b>                                        
<input name="profilepic" type="file" />
                                        </div>
                                        
                                    
        
        
   
        
        
        
        
        
        
        
        
                                    <input name="doRegister" type="submit" class="btn btn-info btn-flat" value="Update Details"/>&nbsp;&nbsp;&nbsp;<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=users'"/>
                              
<p>&nbsp;</p>
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
                <?php }else{?><p class="error">You dont have permissions to access this page, please contact administrator for details</p><?php }?>  
                 </form>
     
                 </section> 
                                                  