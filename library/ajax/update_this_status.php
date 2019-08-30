<?php 
  include_once('../includes/functions.php');
  include_once(CLASSES.'/task_rel_class.php');
  $task_op_obj=new TASK_OPERATIONS();

  if(!isset($_POST['task_id']) || $_POST['task_id']=='')
  {
    echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
    exit;
  }
  $get_task=$task_op_obj->get_task_details(["task_id"=>$_POST['task_id']]);
  if(empty($get_task))
  {
    echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
    exit;
  }
  $status=$task_op_obj->update_task_status($_POST['task_id'],$_POST['status'],$_POST['completed']);
  echo $status['msg'];
