<?php
/**
 * User Opertions Class
 */
require_once('database_class.php');
include_once(CLASSES."/mail_function_class.php");
class USER_OPERATIONS extends DATABASE_CLASS
{
    function __construct()
    {

            $this->db_conn=parent::__construct();
    }
    function get_user_details($match_data)
    {
        try {
            $command = new MongoDB\Driver\Command([
                'aggregate' => 'user',
                'pipeline' => [
                    ['$match' => $match_data],
                ],
                'cursor' => new stdClass,
            ]);
            $res=$this->db_conn->executeCommand(DATABASE, $command);
            $res=$res->toArray();
            return $res;
        } catch (MongoDB\Driver\Exception\Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        } 
    }
    function validate_user($user_name,$password)
    {
        try {
            $res=$this->get_user_details( [
                "user_name" => $user_name,
                'status'=>"1",
                'removed'=>'0'
            ]);
            if(!empty($res) && !empty($res[0]))
            {
                if(password_verify($password, $res[0]->password))
			    {
                    $random_token=$this->randomToken();
                    $this->update_record(
                        'user_login_log',
                        ['user_id'=>$res[0]->user_id,'expired'=>'0'],
                        ['$set' =>['logout_time'=>$this->get_date_timestamp(),'expired'=>'1']],
                        TRUE);
                    $login_log_data=[
                        'username'=>$res[0]->user_name,
                        'user_id'=>$res[0]->user_id,
                        'login_time'=>$this->get_date_timestamp(),
                        'logout_time'=>'',
                        'ip_address'=>$_SERVER['REMOTE_ADDR'],
                        'token'=>$random_token,
                        'expired'=>'0'];
                    if($this->insert_record('user_login_log',$login_log_data)=='success')
                    {
                        $return_array=[
                            'status'=>'success',
                            'msg'=>'Successfully Logged In',
                            'token'=>$random_token,
                            "user_first_name"=>$res[0]->first_name,
                            "user_last_name"=>$res[0]->last_name,
                            "username"=>$res[0]->user_name,];
                        $_SESSION['username']=$res[0]->user_name;
                        $_SESSION['token']=$random_token;
                    }
                    else
                        $return_array=[
                            'status'=>'fail',
                            'msg'=>'User Login Failed. Please try again!'];      
                }else
                   $return_array=[
                       'status'=>'fail',
                       'msg'=>'Invalid Username and Password'];
            }else
                $return_array=[
                    'status'=>'fail',
                    'msg'=>'Invalid Username and Password'];
            return $this->returnJson($return_array);   
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }    
    }
    function logout_user($user_name)
    {   
        try{
            $res=$this->get_user_details( [
                "user_name" => $user_name,
                'status'=>"1",
                'removed'=>'0'
            ]);
            if(!empty($res) && !empty($res[0]))
            {
                $this->update_record(
                    'user_login_log',
                    ['user_id'=>$res[0]->user_id,'expired'=>'0'],
                    ['$set' =>['logout_time'=>$this->get_date_timestamp(),'expired'=>'1']],
                    TRUE);
                    $return_array=[
                        'status'=>'success',
                        'msg'=>'Successfully Logged Out'];
                    $_SESSION['status_dis']='Successfully Logged Out';
                    $_SESSION['status_dis_type']='success';    
            }else
            {
                $return_array=[
                    'status'=>'fail',
                    'msg'=>'User Not Recognized!'];
            }
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }
    }
    function get_active_user_role($user_name)
    {
        try {
            $res=$this->get_user_details( [
                "user_name" => $user_name
            ]);
            if(empty($res))
            {
                return 'normal-user';  
            }
            return $res[0]->user_type;
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }
    }
    function update_logged_user($admin_data)
    {
        try {
            $res=$this->get_user_details( [
                "user_name" => $admin_data['user_name']
            ]);
            if(empty($res))
            {
                $return_array=[
                    'status'=>'fail',
                    'msg'=>'User not recognized!'];
                return $this->returnJson($return_array);  
            }
            $admin_user_data=[
                "email"=> $admin_data['email'],
                "first_name"=> $admin_data['first_name'],
                "last_name"=> $admin_data['last_name']
                ];
            $this->update_record(
                'user',
                ['user_name'=>$admin_data['user_name']],
                ['$set' =>$admin_user_data],
                TRUE);
            $return_array=[
                    'status'=>'success',
                    'msg'=>'Details Updated Successfully!'];
            return $this->returnJson($return_array);
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }  
    }
    function update_user_password($user_name,$password,$new_password)
    {
        try {
            $res=$this->get_user_details( [
                "user_name" => $user_name,
                'status'=>"1",
                'removed'=>'0'
            ]);
            if(!empty($res) && !empty($res[0]))
            {
                if(password_verify($password, $res[0]->password))
			    {
                    $new_pwd=password_hash($new_password, PASSWORD_BCRYPT, ["Admin_access_".SALT=> SALT]);
                    $this->update_record(
                        'user',
                        ['user_id'=>$res[0]->user_id],
                        ['$set' =>["password"=>$new_pwd]],
                        FALSE);
                        $return_array=[
                            'status'=>'success',
                            'msg'=>'Password Updated Successfully!'];      
                }else
                   $return_array=[
                       'status'=>'fail',
                       'msg'=>'Invalid Old Password'];
            }else
                $return_array=[
                    'status'=>'fail',
                    'msg'=>'Invalid Username and Password'];
            return $this->returnJson($return_array);   
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }    
    }
    function checklogin_user($user_name,$token)
    {
        try {
            $res=$this->get_user_details( [
                "user_name" => $user_name,
                'status'=>"1",
                'removed'=>'0'
            ]);
            if(!empty($res) && !empty($res[0]))
            {
                $command_login_log = new MongoDB\Driver\Command([
                    'aggregate' => 'user_login_log',
                    'pipeline' => [
                        ['$match' => [
                            "username" => $user_name,
                            'expired'=>"0",
                            'token'=>$token
                        ]],
                    ],
                    'cursor' => new stdClass,
                ]);
                $res_log=$this->db_conn->executeCommand(DATABASE, $command_login_log);
                $res_log=$res_log->toArray();
                if(!empty($res_log) && !empty($res_log[0]) && $res_log[0]->user_id==$res[0]->user_id)
                {
                    $return_array=[
                        'status'=>'success',
                        'msg'=>'User has been verified!'];
                }else
                    $return_array=[
                        'status'=>'fail',
                        'msg'=>'Invalid User or Token!'];
            }else
                $return_array=[
                    'status'=>'fail',
                    'msg'=>'User not recognized!'];
            if($return_array['status']=='fail')
                session_destroy();        
            return $this->returnJson($return_array);        
        } catch (MongoDB\Driver\Exception\Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        } 
    }
    function forget_password_user($user_name)
    {
        try {
            $res=$this->get_user_details( [
                "user_name" => $user_name,
                'status'=>"1",
                'removed'=>'0'
            ]);
            if(!empty($res) && !empty($res[0]))
            {
                $pwd_link=$this->encrypt_password($res[0]->user_id.'|'.$res[0]->user_name);
                $message= '<div>
							<div>
								<p>
									==============================================================
								</p>
								<p >
									<strong>Please click following link to get new password </strong>
							  </p>
								<p>"'.SITE_URL.'/recovery-password/?link='.urlencode($pwd_link).'" </p>
								==============================================================
								

							</div>
						</div>';

			$objMailFucntion=new sendMail($res[0]->email,"Password Recovery E-mail",$message, FROM_EMAIL);

            // if($objMailFucntion->sendMail())
            // {
                $this->update_record(
                    'user',
                    ['user_id'=>$res[0]->user_id],
                    ['$set' =>['recovery_link'=>$pwd_link,'recovery_status'=>'1']],
                    FALSE);
                $return_array=[
                    'status'=>'success',
                    'msg'=>'Recovery link sent successfully!'];
            // }
            // else
            //     $return_array=[
            //         'status'=>'fail',
            //         'msg'=>'Problem with sending recovery link!'];

            }else
                $return_array=[
                    'status'=>'fail',
                    'msg'=>'User not recognized!'];
            return $this->returnJson($return_array);        
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }
    }
    function recover_password_user($link,$new_password)
    {
        try {
            $res=$this->get_user_details( [
                "recovery_link" => $link,
                'recovery_status'=>"1"
            ]);
            if(!empty($res) && !empty($res[0]))
            {
                $dec_link=$this->decrypt_password($link);
                $link_info=explode('|', $dec_link);
                if($link_info[0]==$res[0]->user_id && $link_info[1]==$res[0]->user_name)
                {
                    $new_pwd=password_hash($new_password, PASSWORD_BCRYPT, ["Admin_access_".SALT=> SALT]);
                    $this->update_record(
                        'user',
                        ['user_id'=>$res[0]->user_id],
                        ['$set' =>['recovery_link'=>"",'recovery_status'=>'0',"password"=>$new_pwd]],
                        FALSE);
                        $return_array=[
                            'status'=>'success',
                            'msg'=>'Password Updated Successfully!'];    
                }else
                    $return_array=[
                        'status'=>'fail',
                        'msg'=>'Invalid Recovery Link!'];
            }else
                $return_array=[
                    'status'=>'fail',
                    'msg'=>'User not recognized!'];
            return $this->returnJson($return_array);        
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }
    }
    function generate_unique_user_id()
    {
        try {
            $user_id=$this->randomToken(8);
            $res=$this->get_user_details([
                "user_id" => $user_id
            ]);
            if(!empty($res))
                $this->generate_unique_user_id();
            else
             return $user_id;    
        } catch (Exception $e) {
            return $this->randomToken(8);
        }
    }
    function save_admin_user($admin_data)
    {
        try {
            if($admin_data['mode']=='add')
            {
                $res=$this->get_user_details( [
                    "user_name" => $admin_data['user_name']
                ]);
                if(!empty($res))
                {
                    $return_array=[
                        'status'=>'fail',
                        'msg'=>'User Name already exists!'];
                    return $this->returnJson($return_array);  
                }
                $password=password_hash($admin_data['password'], PASSWORD_BCRYPT, ["Admin_access_".SALT=> SALT]);
                $user_id=$this->generate_unique_user_id();
                if(isset($admin_data['report_to']) && $admin_data['report_to']!='')
                {
                    $res=$this->get_user_details( [
                        "user_name" => $admin_data['report_to'],
                        'status'=>"1",
                        'removed'=>'0'
                    ]);
                    
                    if(empty($res))
                    {
                        $return_array=[
                            'status'=>'fail',
                            'msg'=>'Report to User not exist or deactivated!'];
                        return $this->returnJson($return_array);  
                    }else
                    {
                        $report_to=$res[0]->user_name;
                        $report_to_id=$res[0]->user_id;
                    }
                }else
                {
                    $report_to='';
                    $report_to_id='';
                }
                $admin_user_data=[
                    "user_name"=> $admin_data['user_name'],
                    "password"=> $password,
                    "user_type"=> "admin",
                    "added_by"=>$_SESSION['username'],
                    "status"=> "1",
                    "email"=> $admin_data['email'],
                    "created"=> $this->get_date_timestamp(),
                    "first_name"=> $admin_data['first_name'],
                    "last_name"=> $admin_data['last_name'],
                    "user_id"=> $user_id,
                    "removed"=> "0",
                    "user_role"=>$admin_data['role'],
                    "recovery_link"=>'',
                    "recovery_status"=>'0',
                    "reporting"=>$report_to,
                    "reporting_user_id"=>$report_to_id
                ];
                if($this->insert_record('user',$admin_user_data)=='success')
                {
                    $message= '<div>
                                <div>
                                    <p>
                                        ==============================================================
                                    </p>
                                    <p> Your Account Has been created!
                                    </p>
                                    <p >
                                        <strong>User Name: </strong>'.$admin_data['user_name'].'
                                </p>
                                    ==============================================================
                                </div>
                            </div>';
                    $objMailFucntion=new sendMail($admin_data['email'],"Admin access",$message,FROM_EMAIL);
                    $objMailFucntion->sendMail();
                    $return_array=[
                        'status'=>'success',
                        'msg'=>'Admin User added Successfully!'];
                }else
                    $return_array=[
                        'status'=>'fail',
                        'msg'=>'Admin User Not added!'];
            }else if($admin_data['mode']=='update')
            {
                $res=$this->get_user_details( [
                    "user_name" => $admin_data['edit_user']
                ]);
                if(empty($res))
                {
                    $return_array=[
                        'status'=>'fail',
                        'msg'=>'Admin User not recognized!'];
                    return $this->returnJson($return_array);  
                }
                $admin_user_data=[
                    "email"=> $admin_data['email'],
                    "first_name"=> $admin_data['first_name'],
                    "last_name"=> $admin_data['last_name'],
                    "user_role"=>$admin_data['role']
                    ];
                if(isset($admin_data['update_password']) && $admin_data['update_password']==1)
                {
                    $password=password_hash($admin_data['password'], PASSWORD_BCRYPT, ["Admin_access_".SALT=> SALT]);
                    $admin_user_data['password']=$password;
                }
                $this->update_record(
                    'user',
                    ['user_name'=>$admin_data['edit_user']],
                    ['$set' =>$admin_user_data],
                    TRUE);
                $return_array=[
                        'status'=>'success',
                        'msg'=>$admin_data['edit_user'].' admin user Details Updated Successfully!'];
                return $this->returnJson($return_array);
            }
            
            return $this->returnJson($return_array);            
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }
    }
    function update_user_status($user_name)
    {
        try{
            $res=$this->get_user_details( [
                "user_name" => $user_name
            ]);
            if(empty($res))
            {
                $return_array=[
                    'status'=>'fail',
                    'msg'=>'User not recognized!'];
                return $this->returnJson($return_array);  
            }
            $user_status=($res[0]->status==1)?'0':'1';
            $this->update_record(
                'user',
                ['user_name'=>$user_name],
                ['$set' =>['status'=>$user_status]],
                TRUE);
            $return_array=[
                    'status'=>'success',
                    'msg'=>$user_name.' user status Updated Successfully!',
                    'updated_status'=>$user_status
                ];
            return $this->returnJson($return_array);        
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        } 
    }
    function remove_user($user_name)
    {
        try{
            $res=$this->get_user_details( [
                "user_name" => $user_name
            ]);
            if(empty($res))
            {
                $return_array=[
                    'status'=>'fail',
                    'msg'=>'User not recognized!'];
                return $this->returnJson($return_array);  
            }
            $this->update_record(
                'user',
                ['user_name'=>$user_name],
                ['$set' =>['removed'=>'1']],
                TRUE);
            $return_array=[
                    'status'=>'success',
                    'msg'=>$user_name.' user removed Successfully!'];
            return $this->returnJson($return_array);                    
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        } 
    }
    function get_users($params_array=[],$get_all_details=false,$get_user_types=[],$active_users="all",$live_users="all")
    {
        try{
            if($active_users!='all')
                $params_array["status"]=$active_users;
            if($live_users!='all')    
                $params_array["removed"]=$live_users;
            if(!empty($get_user_types))
                $params_array["user_type"]=['$in'=>$get_user_types];
            $res=$this->get_user_details($params_array);
           if(!empty($res))
           { 
               if(!$get_all_details)
               {
                    foreach($res as $k=>$v)
                    {
                        $return_admins[]=["username"=>$v->user_name,"first_name"=>$v->first_name,"last_name"=>$v->last_name,"email"=>$v->email,"status"=>$v->status];
                    }
                    return $this->returnJson($return_admins);
                }else
                {
                    return $this->returnJson($res);
                }
           }else
                return false;

        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        } 
    }
    function save_resource_user($resource_data)
    {
        try {
            if($resource_data['mode']=='add')
            {
                $res=$this->get_user_details( [
                    "user_name" => $resource_data['user_name']
                ]);
                if(!empty($res))
                {
                    $return_array=[
                        'status'=>'fail',
                        'msg'=>'User Name already exists!'];
                    return $this->returnJson($return_array);  
                }
                if(isset($resource_data['report_to']) && $resource_data['report_to']!='')
                {
                    $res=$this->get_user_details( [
                        "user_name" => $resource_data['report_to'],
                        'status'=>"1",
                        'removed'=>'0'
                    ]);
                    
                    if(empty($res))
                    {
                        $return_array=[
                            'status'=>'fail',
                            'msg'=>'Report to User not exist or deactivated!'];
                        return $this->returnJson($return_array);  
                    }else
                    {
                        $report_to=$res[0]->user_name;
                        $report_to_id=$res[0]->user_id;
                    }
                }else
                {
                    $report_to='';
                    $report_to_id='';
                }
                $password=password_hash($resource_data['password'], PASSWORD_BCRYPT, ["Admin_access_".SALT=> SALT]);
                $user_id=$this->generate_unique_user_id();
                $resource_user_data=[
                    "user_name"=> $resource_data['user_name'],
                    "password"=> $password,
                    "user_type"=> "resource",
                    "status"=> "1",
                    "email"=> $resource_data['email'],
                    "created"=> $this->get_date_timestamp(),
                    "first_name"=> $resource_data['first_name'],
                    "last_name"=> $resource_data['last_name'],
                    "user_id"=> $user_id,
                    "removed"=> "0",
                    "reporting"=>$report_to,
                    "reporting_user_id"=>$report_to_id,
                    "user_role"=>$resource_data['role'],
                    "added_by"=>$_SESSION['username']
                ];
                if($this->insert_record('user',$resource_user_data)=='success')
                {
                    $message= '<div>
                                <div>
                                    <p>
                                        ==============================================================
                                    </p>
                                    <p> Your Account Has been created!
                                    </p>
                                    <p >
                                        <strong>User Name: </strong>'.$resource_data['user_name'].'
                                </p>
                                    ==============================================================
                                </div>
                            </div>';
                    $objMailFucntion=new sendMail($resource_data['email'],"Resource access",$message,FROM_EMAIL);
                    $objMailFucntion->sendMail();
                    $return_array=[
                        'status'=>'success',
                        'msg'=>'Resource User added Successfully!'];
                }else
                    $return_array=[
                        'status'=>'fail',
                        'msg'=>'Resource User Not added!'];
            }else if($resource_data['mode']=='update')
            {
                $res=$this->get_user_details( [
                    "user_name" => $resource_data['edit_user']
                ]);
                if(empty($res))
                {
                    $return_array=[
                        'status'=>'fail',
                        'msg'=>'Resource User not recognized!'];
                    return $this->returnJson($return_array);  
                }
                if(isset($resource_data['report_to']) && $resource_data['report_to']!='')
                {
                    $res=$this->get_user_details( [
                        "user_name" => $resource_data['report_to'],
                        'status'=>"1",
                        'removed'=>'0'
                    ]);
                    
                    if(empty($res))
                    {
                        $return_array=[
                            'status'=>'fail',
                            'msg'=>'Report to Admin User not exist or deactivated!'];
                        return $this->returnJson($return_array);  
                    }else
                    {
                        $report_to=$res[0]->user_name;
                        $report_to_id=$res[0]->user_id;
                    }
                }else
                {
                    $report_to='';
                    $report_to_id='';
                }
                $resource_user_data=[
                    "email"=> $resource_data['email'],
                    "first_name"=> $resource_data['first_name'],
                    "last_name"=> $resource_data['last_name'],
                    "user_role"=>$resource_data['role'],
                    "reporting"=>$report_to,
                    "reporting_user_id"=>$report_to_id
                    ];
                if(isset($resource_data['update_password']) && $resource_data['update_password']==1)
                {
                    $password=password_hash($resource_data['password'], PASSWORD_BCRYPT, ["Admin_access_".SALT=> SALT]);
                    $resource_user_data['password']=$password;
                }
                $this->update_record(
                    'user',
                    ['user_name'=>$resource_data['edit_user']],
                    ['$set' =>$resource_user_data],
                    TRUE);
                $return_array=[
                        'status'=>'success',
                        'msg'=>$resource_data['edit_user'].' resource user Details Updated Successfully!'];    
            }
            return $this->returnJson($return_array);            
        } catch (Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }
    }
    function get_dashboard_users_count()
    {
        try {
            $command = new MongoDB\Driver\Command([
                'aggregate' => 'user',
                'pipeline' => [
                    ['$match' => ['status'=>'1','removed'=>'0','user_type'=>'resource']],
                    ['$group' => [
                        "_id"=> array('user_name'=>'user_name'),
                          'users_array' => array('$addToSet'=>'$user_name'),
                      ]]
                ],
                'cursor' => new stdClass,
            ]);
            $res=$this->db_conn->executeCommand(DATABASE, $command);
            $res=$res->toArray();
            return $res;
        } catch (MongoDB\Driver\Exception\Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }       
    }
}