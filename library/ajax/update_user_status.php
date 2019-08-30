<?php 
  include_once('../includes/functions.php');
  if(isset($_POST['cid']))
  {
    $status=$user_op_obj->update_user_status($_POST['cid']);
    if($status['status']=='success')
        echo $status['updated_status'];
  }else
    echo "Provide Valid Details!";
?>