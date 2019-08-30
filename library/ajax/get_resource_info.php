<?php 
  include_once('../includes/functions.php');
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
            $get_user_data=$user_op_obj->get_users(['user_name'=>$_POST['cid']],true);
            if(!empty($get_user_data))
            {
        ?>
          <div class="profile-user-info profile-user-info-striped">
                <div class="profile-info-row">
                  <div class="profile-info-name">User Name:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $get_user_data[0]->user_name;?>
                    </div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-name">First Name:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $get_user_data[0]->first_name;?>
                    </div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-name">Last Name:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $get_user_data[0]->last_name;?>
                    </div>
                  </div>
                </div>

                <div class="profile-info-row">
                  <div class="profile-info-name">Email:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $get_user_data[0]->email;?>
                    </div>
                  </div>
                </div>
              <?php if(isset($get_user_data[0]->user_role) && $get_user_data[0]->user_role !=''){?>
                <div class="profile-info-row">
                  <div class="profile-info-name">Role:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $get_user_data[0]->user_role;?>
                    </div>
                  </div>
                </div>
              <?php } ?>
              <?php if(isset($get_user_data[0]->reporting) && $get_user_data[0]->reporting !=''){?>
                <div class="profile-info-row">
                  <div class="profile-info-name">Reporting To:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                    <?php echo $get_user_data[0]->reporting;?>
                    </div>
                  </div>
                </div>
              <?php } ?>              
                <div class="profile-info-row">
                  <div class="profile-info-name">Date Added:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                      <?php echo $get_user_data[0]->created;?>
                    </div>
                  </div>
                </div>


                <div class="profile-info-row">
                  <div class="profile-info-name">Status:</div>
                  <div class="profile-info-value">
                    <div class="editable editable-click">
                      <?php echo ($get_user_data[0]->status==1)?'Active':'Inactive';?>
                    </div>
                  </div>
                </div>

          </div>
        <?php  }} ?>
  </div>

  <div class="modal-footer wizard-actions">
  <?php if(isset($get_user_data[0]->user_name)){
      $edit_url=SITE_URL."/manage-resource-user/".$get_user_data[0]->user_name;
      ?>
    <input type="button" name="Edit" value="Edit" class="btn btn-cancel" onClick="window.location.href='<?php echo $edit_url;?>'">
  <?php } ?>
  <input type="button" name="Close" value="Close" class="btn btn-danger" onclick="$('#modal-wizard').html('');$('#modal-wizard').modal('hide');">

  </div>
  </div>
</div>