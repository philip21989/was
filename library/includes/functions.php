<?php

include_once('config.php');
include_once(CLASSES.'/user_opt_class.php');
$user_op_obj=new USER_OPERATIONS();
if(isset($_SESSION['username']) && $_SESSION['username']!='' && isset($_SESSION['token']) && $_SESSION['token']!='')
{
    $login_status=$user_op_obj->checklogin_user($_SESSION['username'],$_SESSION['token']);
    if(!empty($login_status) && $login_status['status']=='fail')
    {
        echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/login\">";
        exit;
    }
}else
{
    echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/login\">";
    exit;
}

$user_access_role=$user_op_obj->get_active_user_role($_SESSION['username']);
if($user_access_role=='super_admin')
    $active_super_user = true;
else if($user_access_role=='admin')
    $active_admin_user  = true;
else if($user_access_role == 'resource')
    $active_resource_user = true;   

$priority_array=array('999'=>'High','99'=>'Normal','9'=>'Low');
    
?>