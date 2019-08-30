<?php 
  include_once('../includes/config.php');

  include_once(CLASSES.'/user_opt_class.php');

  $user_op_obj=new USER_OPERATIONS();

  $status=$user_op_obj->forget_password_user($_POST['username']);

  echo $status['msg'];
    
?>
