<h3>Project Attachments</h3>

 <table class="table table-striped table-sm" id="customers">
                  <thead>
                          <tr>
                            <th>Attachment</th>
                            <th>Category</th>
                            <th><?php echo $lang_Updatedon;?></th>
                         <th>&nbsp;</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
						
//if no page var is given, set start to 0
 $sql = "select * FROM ".$prefix."concept_attachments where owner_id='$ownerm_id' and catNormal='dynamic'  and conceptID='$id' order by id desc";//informed concent
$result = $mysqli->query($sql);
while($rInvestigator=$result->fetch_array()){
	?>
                          <tr>
                            <td><a href="./files/uploads/<?php echo $rInvestigator['filename'];?>" target="_blank">View File</a></td>
                            <td><?php echo $rInvestigator['attachmentCategory'];?></td>
                            <td><?php echo $rInvestigator['updated'];?></td>
<td><?php /*?><a href="./main.php?option=conceptAttachments&fid=<?php echo $rInvestigator['id'];?>&command=delete" style="color:#F00; font-weight:bold;" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a><?php */?></td>
                          </tr>
   <?php }///////////end function ?>                 
                        </tbody>
                      </table>
