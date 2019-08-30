<?php
/**
 * Report Class
 */

require_once('database_class.php');
include_once(CLASSES."/mail_function_class.php");
include_once(CLASSES."/user_opt_class.php");
class TASK_OPERATIONS extends DATABASE_CLASS
{
    function __construct()
    {
            $this->db_conn=parent::__construct();
    }
    function get_task_details($match_data)
    {
        try {
                if(empty($match_data))
                        $match_data['removed']='0';
            $command = new MongoDB\Driver\Command([
                'aggregate' => 'tasks',
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
    function generate_unique_task_id()
    {
        try {
            $task_id=$this->randomToken(8);
            $res=$this->get_task_details([
                "task_id" => $task_id
            ]);
            if(!empty($res))
                $this->generate_unique_task_id();
            else
             return $task_id;    
        } catch (Exception $e) {
            return $this->randomToken(8);
        }
    }
    function save_task($task_info,$files)
    {
        try{
                $user_rel_obj=new USER_OPERATIONS();
                $assigned_to_user=$user_rel_obj->get_user_details( [
                        "user_name" => $task_info['assigned_to']
                    ]);
                if(empty($assigned_to_user))
                {
                        $return_array=[
                                'status'=>'fail',
                                'msg'=>'Failed to retrieve Resource User Details!'];
                        return $this->returnJson($return_array);  
                }
                if($task_info['mode']=='add')
                {
                        $task_id=$this->generate_unique_task_id();
                        $task_details=[
                                        "task_id"=>$task_id,
                                        "task_title"=>$task_info['task_title'],
                                        "category"=>$task_info['category'],
                                        "short_description"=>$task_info['short_description'],
                                        "description"=>htmlentities($task_info['description']),
                                        "assigned_to"=>$task_info['assigned_to'],
                                        "priority"=>$task_info['priority'],
                                        "start_date"=>$task_info['start_date'],
                                        "end_date"=>$task_info['end_date'],
                                        "status"=>"pending",
                                        "completed_per"=>0,
                                        "created_by"=>$_SESSION['username'],
                                        "created"=> $this->get_date_timestamp(),
                                        "removed"=>'0'
                                ];
                        if($this->insert_record('tasks',$task_details)=='success')
                        {
                                $task_details_activity=[
                                        "ta_task_id"=>$task_id,
                                        "ta_task_title"=>$task_info['task_title'],
                                        "ta_action"=>"created",
                                        "ta_assigned_by"=>$_SESSION['username'],
                                        "ta_assigned_to"=> $task_info['assigned_to'],
                                        "ta_priority"=>$task_info['priority'],
                                        "ta_start_date"=>$task_info['start_date'],
                                        "ta_end_date"=>$task_info['end_date'],
                                        "ta_status"=>"pending",
                                        "ta_completed_per"=>0,
                                        "ta_created"=> $this->get_date_timestamp()
                                ];
                                $this->insert_record('tasks_activity',$task_details_activity);
                                $message= '<div>
                                                <p>New task assigned to you!</p>
                                                <p>Below are the details</p>
                                                <p>Task: '.$task_info['task_title'].'</p>
                                                <p>Priority: '.$task_info['priority'].'</p>
                                                <p>link: '.SITE_URL.'/view-task-details/'.$task_id.'
                                        </div>';

                                $objMailFucntion=new sendMail($assigned_to_user[0]->email,"New task Assigned",$message,FROM_EMAIL);
                                $objMailFucntion->sendMail();
                                $return_array=[
                                'status'=>'success',
                                'msg'=>'Task created Successfully!'];
                        }else
                                $return_array=[
                                'status'=>'fail',
                                'msg'=>'Task Not added!'];
                }else if($task_info['mode']=='update')
                {
                        $task_id=$task_info['task_id'];
                        $task_details=$this->get_task_details([
                                "task_id" => $task_info['task_id']
                            ]);
                        if(empty($task_details))
                        {
                                $return_array=[
                                        'status'=>'fail',
                                        'msg'=>'Invalid Task Details!'];
                                return $this->returnJson($return_array);  
                        }
                        $task_update_details=[
                                "task_title"=>$task_info['task_title'],
                                "category"=>$task_info['category'],
                                "short_description"=>$task_info['short_description'],
                                "description"=>htmlentities($task_info['description']),
                                "assigned_to"=>$task_info['assigned_to'],
                                "priority"=>$task_info['priority'],
                                "start_date"=>$task_info['start_date'],
                                "end_date"=>$task_info['end_date']
                              ];
                        if(isset($task_info['remove_this_attachment']) && $task_info['remove_this_attachment']==1)
                        {
                           if($task_details[0]->attachment_path!='')     
                                unlink($task_details[0]->attachment_path);
                           $task_update_details['attachment_name']='';
                           $task_update_details['attachment_path']='';    
                        }      
                    
                    $this->update_record(
                        'tasks',
                        ['task_id'=>$task_info['task_id']],
                        ['$set' =>$task_update_details],
                        TRUE);
                        $task_details_activity=[
                                "ta_task_id"=>$task_id,
                                "ta_task_title"=>$task_info['task_title'],
                                "ta_action"=>"updated",
                                "ta_assigned_to"=> $task_info['assigned_to'],
                                "ta_priority"=>$task_info['priority'],
                                "ta_start_date"=>$task_info['start_date'],
                                "ta_end_date"=>$task_info['end_date'],
                                "ta_created"=> $this->get_date_timestamp()
                            ];
                        $this->insert_record('tasks_activity',$task_details_activity);   
                    $return_array=[
                            'status'=>'success',
                            'msg'=>'Task Details Updated Successfully!'];
                }
                if($files["attachment"]["size"]>0)
		{
			$tmp_name=$files["attachment"]["tmp_name"];
			$file=$files['attachment']['name'];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$uploads_path ='uploads/attachments/attachment_'.$task_id.'.'.$ext;
			$this->local_upload_file($tmp_name,$uploads_path);
                        $this->update_record(
                                'tasks',
                                ['task_id'=>$task_id],
                                ['$set' =>['attachment_name'=>$file,'attachment_path'=>$uploads_path]],
                                TRUE);
                }
                    return $this->returnJson($return_array);
        } catch (Exception $e) {
                return "Exception Occurred :".$e->getMessage();
            }
    }
    function update_task_status($task_id,$status,$completed)
    {
        try {
                $task_details=$this->get_task_details([
                        "task_id" => $task_id
                        ]);
                if(empty($task_details))
                {
                        $return_array=[
                                'status'=>'fail',
                                'msg'=>'Invalid Task Details!'];
                        return $this->returnJson($return_array);  
                }
                $task_details=[
                        "status"=>$status,
                        "completed_per"=>$completed,
                      ];
                $this->update_record(
                'tasks',
                ['task_id'=>$task_id],
                ['$set' =>$task_details],
                TRUE);
                $task_details_activity=[
                        "ta_task_id"=>$task_id,
                        "ta_action"=>'status',
                        "ta_status"=>$status,
                        "ta_completed"=>$completed,
                        "ta_created"=> $this->get_date_timestamp()
                        ];
                $this->insert_record('tasks_activity',$task_details_activity);
                $return_array=[
                        'status'=>'Success',
                        'msg'=>'Status updated successfully!'];
                return $this->returnJson($return_array);  
        } catch (Exception $e) {
                return "Exception Occurred :".$e->getMessage();
        }

    }
    function save_task_comments($comment_info,$files)
    {
            $task_id=$comment_info['task_id'];
            $task_details=$this->get_task_details([
                        "task_id" => $comment_info['task_id']
                        ]);
                if(empty($task_details))
                {
                        $return_array=[
                                'status'=>'fail',
                                'msg'=>'Invalid Task Details!'];
                        return $this->returnJson($return_array);  
                }
                
                $task_details_activity=[
                        "ta_task_id"=>$task_id,
                        "ta_action"=>"comment",
                        "ta_comment"=>htmlentities($comment_info['description']),
                        "ta_comment_by"=>$_SESSION['username'],
                        "ta_created"=> $this->get_date_timestamp()
                        ];
                if($files["attachment"]["size"]>0)
                {
                        $tmp_name=$files["attachment"]["tmp_name"];
                        $file=$files['attachment']['name'];
                        $ext = pathinfo($file, PATHINFO_EXTENSION);
                        $uploads_path ='uploads/attachments/comment_'.$task_id.'_'.$this->randomToken(3).'.'.$ext;
                        $this->local_upload_file($tmp_name,$uploads_path);
                        $task_details_activity['attachment_name']=$file;
                        $task_details_activity['attachment_path']=$uploads_path;
                }        
                $this->insert_record('tasks_activity',$task_details_activity);   
                $return_array=[
                        'status'=>'success',
                        'msg'=>'Comment Added Successfully!'];
        
        return $this->returnJson($return_array);

    }
    function get_task_comments($task_id,$sort_by=-1)
    {
        try {    
                $task_details=$this->get_task_details([
                        "task_id" => $task_id
                        ]);
                if(empty($task_details))
                {
                   return false;  
                }
                $match_data=["ta_action"=>'comment',"ta_task_id"=>$task_id];
                $command = new MongoDB\Driver\Command([
                        'aggregate' => 'tasks_activity',
                        'pipeline' => [
                                ['$match' => $match_data],
                                ['$sort' =>array('_id'=>$sort_by)],
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