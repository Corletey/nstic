 <script type="text/javascript">
 $(document).ready(function(){
    $('.up, .down').click(function(e){
        e.preventDefault();
        
        var row = $(this).parents("tr:first"); 
        //selects all of row's tds except position number 
        
        // var row = $(this).parents("tr:first");
        // selects the entire row
     
        if ($(this).is(".up")) {
            row.insertBefore(row.prev());
        } 
        else {
            row.insertAfter(row.next());
        }
        
        $('tbody tr .td:first-child').each(function(idx, item) {
            $(this).text(idx+1);
        });
    });
});
</script>

    <script language="javascript">  
    //Alter this variable depending on how many words you want to limit the textarea to.  
    var maxwords = 600;  
      
    function check_length(obj, cnt, rem)  
    {  
        var ary = obj.value.split(" ");  
        var len = ary.length;  
        cnt.innerHTML = len;  
        rem.innerHTML = maxwords - len;  
        if (len > maxwords) {  
            alert("Message in '" + obj.name + "' limited to " + maxwords + " words.");  
            ary = ary.slice(0,maxwords-1);  
            obj.value = ary.join(" ");  
            cnt.innerHTML = maxwords;  
            rem.innerHTML = 0;  
            return false;  
        }  
        return true;  
    }  
    </script> 
 
  <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
             
                        <small><?php echo $sitename;?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><b>Poster Contribution</b></li>
                    </ol>
                </section>

<section class="content">

<form action="./main.php?option=submitposter" method="post" name="regForm" id="regForm" >
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <ol class="breadcrumb">
                        <li><a href="./main.php?option=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active"><b>Submit your Poster Contribution</b></li>
                    </ol>
                    <p>Please complete the form below in order to submit your contribution. All fields marked with an asterisk (*) must be filled in.
The next steps will allow you to preview your submission, upload files to the server (if required), and to save your submission.<br />

<b>Once completed, you can return to and update this abstract at any time before the abstract submission deadline.</b></p>
                </section>
<?php
$confsessionNo=($cfn_user_id.$cfn_usrname.'MMM');
$queryusers="select * from ".$prefix."users where cfn_usrname='$cfn_usrname' and cfn_user_id='$cfn_user_id'";
$rs_CMDusers=$mysqli->query($queryusers);
$rsusers=$rs_CMDusers->fetch_array();
///////////////////////////////////////////////////////////////
$queryContribution="select * from ".$prefix."poster where cfn_user_id='$cfn_user_id' and sh_confsessionNo='$confsessionNo'";
$rs_Contribution=$mysqli->query($queryContribution);
$rsContribution=$rs_Contribution->fetch_array();

?>
    <!-- Main content -->
                <section class="content">
                    <table width="100%" border="0">
                      <tr>
                        <td colspan="2" align="left" valign="top" class="conftxt"><strong>Information on this Contribution</strong></td>
                      </tr>
                      <tr>
                        <td align="left" valign="top" class="conftxt">Submitting Author</td>
                        <td align="left" valign="top"><?php echo $rsusers['cfn_firstName'];?> <?php echo $rsusers['cfn_lastName'];?>
                        <input type="hidden" name="author" class="form-control sepm" id="authone" value="<?php echo $rsusers['cfn_firstName'];?> <?php echo $rsusers['cfn_lastName'];?>" /></td>
                      </tr>
                      <tr>
    <td width="17%" height="51" align="left" valign="top" class="conftxt"> Type of Submission</td>
    <td width="83%" align="left" valign="top"><strong>Poster</strong></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" class="conftxt"><strong>Information on Author(s)</strong></td>
    </tr>
  <tr>
    <td width="17%" height="229" align="left" valign="top" class="conftxt">Author(s) <font color="#CC0000">*</font></td>
    <td width="83%" align="left" valign="top">
      
      
      
      
      
      
      <table width="90%" class="tablemrows">
    <thead>
        <tr>
            <th width="2%"></th>
            <th width="18%">First Name </th>
            <th width="18%">Last Name</th>
            <th width="28%">E-mail</th>
            <th width="24%">Organization</th>
            <th colspan = "2">Move</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td height="37" class="td">1</td>
            <td class="td"><input type="text" name="authorFirstName1" class="form-control sepm" id="authone" value="<?php if($rsContribution['sh_authorFirstName1']){ echo $rsContribution['sh_authorFirstName1']; }else{ echo $rsusers['cfn_firstName'];}?>" />
            
            
            
            </td>
            <td class="td"><input type="text" name="authorlastName1" class="form-control sepm" id="authtwo" value="<?php if($rsContribution['sh_authorlastName1']){ echo $rsContribution['sh_authorlastName1']; }else{ echo $rsusers['cfn_lastName'];}?>" /></td>
            <td class="td"><input type="text" name="authorEmail1" class="form-control sepm" id="authtwo" value="<?php if($rsContribution['sh_authorEmail1']){ echo $rsContribution['sh_authorEmail1']; }else{ echo $rsusers['cfn_email'];}?>" /></td>
            <td class="td"><input type="text" name="authororganisation1" class="form-control sepm" id="authtwo" value="<?php if($rsContribution['sh_authororganisation1']){ echo $rsContribution['sh_authororganisation1']; }else{ echo $rsusers['cfn_organisation'];}?>" /></td>
            <td width="5%" class = "up"><a href="#"><img src="img/move_up.gif" border="0"/></a></td>
            <td width="5%" class = "down"><a href="#"><img src="img/move_down.gif" border="0"/></a></td>
        </tr>
         <tr>
            <td class="td">2</td>
            <td class="td"><input type="text" name="authorFirstName2" class="form-control sepm" id="authone" value="<?php echo $rsContribution['sh_authorFirstName2'];?>" /></td>
            <td class="td"><input type="text" name="authorlastName2" class="form-control sepm" id="authtwo" value="<?php echo $rsContribution['sh_authorlastName2'];?>" /></td>
            <td class="td"><input type="text" name="authorEmail2" class="form-control sepm" id="authtwo" value="<?php echo $rsContribution['sh_authorEmail2'];?>" /></td>
            <td class="td"><input type="text" name="authororganisation2" class="form-control sepm" id="authtwo" value="<?php echo $rsContribution['sh_authororganisation2'];?>" /></td>
            <td class = "up"><a href="#"><img src="img/move_up.gif" border="0"/></a></td>
            <td class = "down"><a href="#"><img src="img/move_down.gif" border="0"/></a></td>
        </tr>
      <tr>
            <td class="td">3</td>
            <td class="td"><input type="text" name="authorFirstName3" class="form-control sepm" id="authone" value="<?php echo $rsContribution['sh_authorFirstName3'];?>" /></td>
            <td class="td"><input type="text" name="authorlastName3" class="form-control sepm" id="authtwo" value="<?php echo $rsContribution['sh_authorlastName3'];?>" /></td>
            <td class="td"><input type="text" name="authorEmail3" class="form-control sepm" id="authtwo" value="<?php echo $rsContribution['sh_authorEmail3'];?>" /></td>
            <td class="td"><input type="text" name="authororganisation3" class="form-control sepm" id="authtwo" value="<?php echo $rsContribution['sh_authororganisation3'];?>" /></td>
            <td class = "up"><a href="#"><img src="img/move_up.gif" border="0"/></a></td>
            <td class = "down"><a href="#"><img src="img/move_down.gif" border="0"/></a></td>
        </tr>
     <tr>
            <td class="td">4</td>
            <td class="td"><input type="text" name="authorFirstName4" class="form-control sepm" id="authone" value="<?php echo $rsContribution['sh_authorFirstName4'];?>" /></td>
            <td class="td"><input type="text" name="authorlastName4" class="form-control sepm" id="authtwo" value="<?php echo $rsContribution['sh_authorlastName4'];?>" /></td>
            <td class="td"><input type="text" name="authorEmail4" class="form-control sepm" id="authtwo" value="<?php echo $rsContribution['sh_authorEmail4'];?>" /></td>
            <td class="td"><input type="text" name="authororganisation4" class="form-control sepm" id="authtwo" value="<?php echo $rsContribution['sh_authororganisation4'];?>" /></td>
            <td class = "up"><a href="#"><img src="img/move_up.gif" border="0"/></a></td>
            <td class = "down"><a href="#"><img src="img/move_down.gif" border="0"/></a></td>
        </tr>
    </tbody>
</table>
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      </td>
  </tr>

  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">Title of Contribution<font color="#CC0000">*</font></td>
    <td align="left" valign="top"><input type="text" name="titleofcontribution" class="required form-control sepm fixedm fixedm" id="confwebsite" value="<?php echo $rsContribution['sh_titleofcontribution'];?>" />
    </td>
  </tr>
   <tr>
    <td align="left" valign="top">Abstract   <font color="#CC0000">*</font></td>
    <td align="left" valign="top">
    
    <textarea class="form-control required" name="abstract" rows="3" style="resize: none; width:90%; height:250px;" onkeypress=" return check_length(this, document.getElementById('count_number_words'), document.getElementById('show_remaining_words'));"><?php echo $rsContribution['sh_abstract'];?></textarea><br />
    <strong>Note: Maximum length of abstract: 600 characters</strong><br />
    
    <br>
<font color="black">Word count:</font><font color="red">
   <span id="count_number_words">0</span>
</font>
<br>
<font color="black">Words remaining: </font><font color="red">
   <span id="show_remaining_words">600</span>
</font> 

    </td>
  </tr>
  <tr>
    <td align="left" valign="top" colspan="2">&nbsp;</td>
  </tr>

    <tr>
      <td align="left" valign="top">Remark / Message to the Program Committee and Chairs</td>
      <td align="left" valign="top"> <textarea class="form-control required" name="committeemessage" rows="3" style="resize: none; width:90%; height:120px;"><?php echo $rsContribution['sh_committeemessage'];?></textarea> </td>
    </tr>
  
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
    <td align="left" valign="top">  <font color="#CC0000">*</font></td>
    <td align="left" valign="top"> <?php
											$queryConf="select * from ".$prefix."conferences where cfn_dateBegin>='$today' and cfn_approveStatus='approved' order by cfn_confName asc";
                                            $rs_CMDConf=$mysqli->query($queryConf);
                                            $totalsConf=$rs_CMDConf->num_rows;?>
                                            <select class="form-control required " name="cfn_confID" style="width:90%;">
                                            <option value="">----Please Select ----</option>
                                          <?php 
                                            while($rsConf=$rs_CMDConf->fetch_array()){
	
	                                        ?>
                                           <option value="<?php echo $rsConf['cfn_confID'];?>" <?php if($rsContribution['cfn_confID']==$rsConf['cfn_confID']){?>selected="selected"<?php }?>>&nbsp;<?php echo $rsConf['cfn_confName'];?></option>
                                           <?php } ?>
                                            </select></td>
  </tr>
  
  
  
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><input name="doSubmit" type="submit" class="btn btn-info btn-flat" value="Proceed"/></td>
  </tr>
</table>   <!-- /.row -->
</section><!-- /.content -->
                 </form>
     </section>
                                                              