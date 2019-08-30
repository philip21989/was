<?php 
  include_once('library/includes/functions.php');
  $user_op_obj->logout_user($_SESSION['username']);
  session_destroy();
  echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
  exit;
 ?>