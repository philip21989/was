<?php 
  include_once('../includes/functions.php');
  include_once(CLASSES.'/task_rel_class.php');
  $task_op_obj=new TASK_OPERATIONS();

  if((!isset($active_super_user) || !$active_super_user) && (!isset($active_admin_user) || !$active_admin_user))
  {
      echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
      exit;
  } 

?>
<div class="modal-backdrop in" style="height: 682px;"></div>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
        <?php if(isset($_POST['cid']) && $_POST['cid']!=''){
            $get_task=$task_op_obj->get_task_details(["task_id"=>$_POST['cid']]);
            if(!empty($get_task))
            {
        ?>
          <div class="profile-user-info profile-user-info-striped">
                <div class="profile-info-row">
                  <div class="profile-info-name">Title:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $get_task[0]->task_title;?>
                    </div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-name">Category:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $get_task[0]->category;?>
                    </div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-name">Short Description:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $get_task[0]->short_description;?>
                    </div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-name">Assigned To:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $get_task[0]->assigned_to;?>
                    </div>
                  </div>
                </div>
                <div class="profile-info-row">
                  <div class="profile-info-name">Priority:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $priority_array[$get_task[0]->priority];?>
                    </div>
                  </div>
                </div>
                <div class="profile-info-row">
                  <div class="profile-info-name">Start Date:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                      <?php echo $get_task[0]->start_date;?>
                    </div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-name">End Date:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                      <?php echo $get_task[0]->end_date;?>
                    </div>
                  </div>
                </div>


                <div class="profile-info-row">
                  <div class="profile-info-name">Status:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                      <?php echo ucfirst($get_task[0]->status);?>
                    </div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-name">Completed:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                      <?php echo $get_task[0]->completed_per;?>%
                    </div>
                  </div>
                </div>

          </div>
        <?php  }} ?>
  </div>

  <div class="modal-footer wizard-actions">
  <?php if(isset($get_task[0]->task_id)){
      $edit_url=SITE_URL."/manage-task/".$get_task[0]->task_id;
      ?>
    <input type="button" name="Edit" value="Edit" class="btn btn-cancel" onClick="window.location.href='<?php echo $edit_url;?>'">
  <?php } ?>
  <input type="button" name="Close" value="Close" class="btn btn-danger" onclick="$('#modal-wizard').html('');$('#modal-wizard').modal('hide');">

  </div>
  </div>
</div>