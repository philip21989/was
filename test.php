<?php 
  include_once('library/includes/config.php');
  include_once(CLASSES.'/user_opt_class.php');
  $user_op_obj=new USER_OPERATIONS();
  $admin_user_data=array (
    'user_name' => 'suresh',
    'password' => '$2y$10$X81dzeBiGXNGmmlmbaLjGu5WOXA9LF5ptosmudxcuvJbrVAQojaGG',
    'user_type' => 'super_admin',
    'added_by' => '',
    'status' => '1',
    'email' => 'suresh3218@gmail.com',
    'created' => '2019-08-22 20:02:41',
    'first_name' => 'Suresh',
    'last_name' => 'Deva',
    'user_id' => 'u8Dihzoh',
    'removed' => '0',
    'user_role' => 'Director',
    'recovery_link' => '',
    'recovery_status' => '0',
  );
  //$user_op_obj->insert_record('user',$admin_user_data);
   
