<?php 
  include_once('../includes/config.php');

  include_once(CLASSES.'/user_opt_class.php');

  $user_op_obj=new USER_OPERATIONS();

  $status=$user_op_obj->validate_user($_POST['username'],$_POST['pwd']);

  if($status['status']=='success')
    echo '1';
  else
    echo $status['msg'];
    
?>
