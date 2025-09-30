 
  <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
               
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">My Details</li>
                    </ol>
                </section>

<section class="content">
<?php if($session_usertype=='superadmin' || $session_usertype=='user' || $session_usertype=='reviewer' || $session_usertype=='admin'){?>  
<div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">My Account Details</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>Organisation</th>
                                                <th>Profession</th>
                                                <th>User Details</th>
                                                <th>Address</th>
                                                <th>Photo</th>
                                            </tr>
                                        </thead>
<?php
$sql = "select * from ".$prefix."musers  where usrm_id='$usrm_id' and usrm_username='$usrm_username'";
$result = $mysqli->query($sql);
while($sq =$result->fetch_array())
{
$cfn_countryID=$sq['usrm_Nationality'];
$sql2 = "select * from ".$prefix."countries  where cidm_country_id='$cfn_countryID'";
$result2 = $mysqli->query($sql2);
$sq2 =$result2->fetch_array();	
	?>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $sq['cfn_title'];?> <?php echo $sq['cfn_firstName'];?> <?php echo $sq['cfn_lastName'];?><br /><br />
<img src="img/edit.gif" /> <a href="./main.php?option=mydetails">Update my Details</a>
                                                </td>
                                                <td><?php echo $sq['cfn_organisation'];?></td>
                                                <td><?php echo $sq['cfn_profession'];?> <?php if($sq['cfn_department']){?> / <?php echo $sq['cfn_department']; }?></td>
                                                <td>Email: <?php echo $sq['cfn_email'];?><br />
                                                Username: <?php echo $sq['cfn_usrname'];?></td>
                                                <td><p><?php echo $sq['cfn_address1'];?><br />
                                                  Phone: <?php echo $sq['cfn_phone'];?></p>
                                                  <p>Country: <?php echo $sq2['cfn_countryName'];?><br />
                                                    Postal Code: <?php echo $sq['cfn_postalCode'];?><br />
                                                City: <?php echo $sq['cfn_city'];?></p></td>
                                                <td>  <?php if($sq['cfn_profilepic']){?><img src="files/photos/thumb_<?php echo $sq['cfn_profilepic'];?> "  style="border:1px solid #CCC; padding:2px;"/><?php }?> </td>
                                            </tr>
<?php }?>
                                    
                                        </tbody>
             
                                    </table>
</div><!-- /.box-body -->
                            </div>
                            <?php }else{?><p class="error">You dont have permissions to access this page, please contact administrator for details</p><?php }?> 
                            </section>