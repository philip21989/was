<?php 
  include_once('../includes/functions.php');
  include_once(CLASSES.'/task_rel_class.php');
  $task_op_obj=new TASK_OPERATIONS();

  if(!isset($_POST['cid']) || $_POST['cid']=='')
  {
    echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
    exit;
  }
  $get_task=$task_op_obj->get_task_details(["task_id"=>$_POST['cid']]);
  if(empty($get_task))
  {
    echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
    exit;
  }
  $status_array=['pending','in-process','dependency','blocker','completed','closed','terminated'];

?>
    <div class="modal-backdrop in" style="height: 682px;"></div>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <button style="margin-top:-10px;" data-dismiss="modal" class="close" type="button">×</button>
            <div class="profile-user-info profile-user-info-striped">
              <div class="profile-info-row">
                  <div class="profile-info-name">Title:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click"><?php echo $get_task[0]->task_title;?></div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-name">Date:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click"><?php echo $get_task[0]->start_date.' - '.$get_task[0]->end_date;?></div>
                  </div>
                </div>

                
              </div>  
                <div>&nbsp;</div>


                                  <div class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Status:</label>
                                  <div class="col-xs-4 col-sm-8">
                                    <div class="clearfix input-group">
                                    <select name="task_status" id="task_status">
                                        <?php foreach($status_array as $status_val)
                                        {?>
                                          <option value="<?php echo $status_val;?>" <?php echo ($status_val==$get_task[0]->status)?' selected':'';?> ><?php echo ucfirst($status_val);?></option>
                                        <?php }  ?>  
                                          
                                       </select>
                                     </div>
                                  </div>  
                                 </div>   
                                 <div class="space-2"></div>
                    <div class="clearfix"></div>

                                  <div class="space-2"></div>
                                  <div class="form-group">
                                  <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="completed_per">Completed in %:</label>
                                  <div class="col-xs-4 col-sm-8">
                                    <div class="clearfix input-group">
                                        <input type="text" name="completed_per" id="completed_per"  value="<?php echo $get_task[0]->completed_per;?>">
                                     </div>
                                  </div>  
                                 </div>   

                                  <div class="space-2"></div>
                    <div class="clearfix"></div>
                    <div class="space-8"></div>
           </div>
        <div class="modal-footer">
            <input type="button" name="submit_btn" value="Submit" class="btn btn-success" onclick="update_this_status('<?php echo $_POST['cid'];?>')">
            <button data-dismiss="modal" class="btn btn-sm" type="button"><i class="ace-icon fa fa-times"></i> Cancel</button>
        </div>
        </div>
    </div>
