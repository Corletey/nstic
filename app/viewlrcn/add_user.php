  <?php if($session_usertype=='superadmin' || $session_usertype=='admin'){?> 
<form action="./main.php?option=suser" method="post" name="regForm" id="regForm" enctype="multipart/form-data">
<?php echo $message;?>

<div class="box-header"><h3 class="box-title">Add User</h3></div><!-- /.box-header -->
                                
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->  
                            <div class="box box-primary">
                       
                              
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
                                            <label for="exampleInputEmail1">Username <font color="#CC0000">*</font></label>
                                            <input type="text" class="form-control required email" name="usrm_username" id="exampleInputEmail1" value="<?php echo $sq['usrm_username'];?>">
                                            
                                            
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
<!--<option value="reviewer">&nbsp;Reviewer</option>-->
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
                             
                                <div class="box-body">

                                        <!-- text input -->
                                  
                                        <div class="form-group">
                                            <label for="exampleInputPassword1"><?php echo $lang_institution_of_affiliation;?> <font color="#CC0000">*</font></label>
                                           <input type="text" class="form-control required" name="Institution" id="Institution" value="<?php echo $sq['usrm_NameofInstitution'];?>">
                                           
                                           
                                        </div> 
                                     <div class="form-group">
    <label class="control-label" for="inputSuccess"><?php echo $lang_Gender;?> <font color="#CC0000">*</font></label>
    <input name="Gender" type="radio" value="Male" tabindex="14" id="Gender" <?php if($sq['usrm_gender']=='Male'){?>checked="checked"<?php }?>/> <?php echo $lang_male;?>&nbsp;
      <input name="Gender" type="radio" value="Female"  tabindex="15" id="Gender" <?php if($sq['usrm_gender']=='Female'){?>checked="checked"<?php }?>/> <?php echo $lang_female;?>
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
                                        
                                    
        
        
   
        
        
        
        
        
        
        
        
                                    <input name="doRegister" type="submit" class="btn btn-info btn-flat" value="Add User"/>&nbsp;&nbsp;&nbsp;<input name="button" type="button" class="btn btn-info btn-flat" value="Back to List" onClick="window.location.href='./main.php?option=Users'"/>
                              
<p>&nbsp;</p>
                                </div><!-- /.box-body -->
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </div><!-- /.box -->
                        </div><!--/.col (right) -->
                    </div>   <!-- /.row -->
          
                <?php }else{?><p class="error">You dont have permissions to access this page, please contact administrator for details</p><?php }?>  
                 </form>
     
                 