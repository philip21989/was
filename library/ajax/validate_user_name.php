<?php 
  include_once('../includes/functions.php');
  
  $status=$user_op_obj->get_user_details(["user_name" => $_REQUEST['user_name']]);

  if(empty($status))
  {
  	echo 'true';
  }
  else
  	echo 'false';
  
?>
