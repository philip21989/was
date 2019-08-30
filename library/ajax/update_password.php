<?php 
  include_once('../includes/config.php');

  include_once(CLASSES.'/user_opt_class.php');

  $user_op_obj=new USER_OPERATIONS();

  $status=$user_op_obj->update_user_password($_SESSION['username'],$_POST['op'],$_POST['np']);

  if($status['status']=='success')
    echo '1';
  else
    echo $status['msg'];
    
?>
