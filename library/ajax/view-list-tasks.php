<?php 
  include_once('../includes/functions.php');
  if((!isset($active_super_user) || !$active_super_user) && (!isset($active_admin_user) || !$active_admin_user))
  {
    echo 'empty';
      exit;
  }
  include_once(CLASSES.'/task_rel_class.php');
  $task_op_obj=new TASK_OPERATIONS();
  $parms=array();
  if(!empty($_POST['title']))
		$parms['task_title']=$_POST['title'];
	if(!empty($_POST['assigned_to']))
  $parms['assigned_to']=$_POST['assigned_to'];

  if(isset($active_admin_user) && $active_admin_user)
    $parms['created_by']=$_SESSION['username'];
  $get_all_tasks=$task_op_obj->get_task_details($parms);
  
?>
<?php if(is_array($get_all_tasks) && count($get_all_tasks)>0){?>
<table id="dynamic-table" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th class="center">
                              <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                              </label>
                            </th>
                            <th>Title</th>
                            <th>Assigned To</th>
                            <th>Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Completed</th>
                            <th></th>
                          </tr>
                        </thead>

                        <tbody id="pages_table">
                          <?php 
                            foreach ($get_all_tasks as $row) {


                            ?>
                            <tr id="content_row_<?php echo $row->task_id;?>">
                              <td class="center">
                                <label class="pos-rel">
                                  <input type="checkbox" class="ace" value="<?php echo $row->task_id;?>" name="check_row" />
                                  <span class="lbl"></span>
                                </label>
                              </td>

                              <td>
                                <a href="#"><?php echo $row->task_title;?></a>
                              </td>
                              <td>
                                <a href="#"><?php echo $row->assigned_to;?></a>
                              </td>
                              <td>
                                <a href="#"><?php echo $row->start_date.' - '.$row->end_date;?></a>
                              </td>
                              <td>
                                <a href="#"><?php echo $priority_array[$row->priority];?></a>
                              </td>
                              <td>
                                <a href="#"><?php echo ucfirst($row->status);?></a>
                              </td>
                              <td>
                                <a href="#">
                                    <?php echo $row->completed_per;?>%
                                </a>
                              </td>
                              
                              <td>
                                <div class="hidden-sm hidden-xs action-buttons">
                                  <a class="blue" href="javascript:" title="View Details" id="view_page_m" onclick="get_details('<?php echo $row->task_id;?>')">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                  </a>

                                  <a class="grey" href="<?php echo SITE_URL;?>/manage-task/<?php echo $row->task_id;?> " title="Update Task">
                                    <i class="ace-icon fa fa-pencil-square-o bigger-130"></i>
                                  </a>

                                  <a class="green" href="<?php echo SITE_URL;?>/add-comment/<?php echo $row->task_id;?>/view-tasks" title="Update Task">
                                    <i class="ace-icon fa fa-comment bigger-130"></i>
                                  </a>
                                  
                                  <a class="pink" href="javascript:" title="Update Status" id="view_page_m" onclick="update_status('<?php echo $row->task_id;?>')">
                                    <i class="ace-icon fa fa-tachometer bigger-130"></i>
                                  </a>
                                  
                                  <a class="orange" href="<?php echo SITE_URL;?>/view-task-details/<?php echo $row->task_id;?>" title="View Task">
                                    <i class="ace-icon fa fa-eye bigger-130"></i>
                                  </a>

   
                                </div>

                                <div class="hidden-md hidden-lg">
                                  <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                      <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                      <li>
                                        <a href="javascript:" onclick="get_details('<?php echo $row->task_id;?>')" class="tooltip-info" data-rel="tooltip" data-toggle="modal" title="View details">
                                          <span class="blue">

                                            <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                          </span>
                                        </a>
                                      </li>

                                      <li>
                                        <a href="<?php echo SITE_URL;?>/manage-task/<?php echo $row->task_id;?>" class="tooltip-success" data-rel="tooltip" title="Update">
                                          <span class="grey">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                          </span>
                                        </a>
                                      </li>

                                      <li>
                                        <a href="<?php echo SITE_URL;?>/add-comment/<?php echo $row->task_id;?>/view-tasks" class="tooltip-success" data-rel="tooltip" title="Update">
                                          <span class="green">
                                            <i class="ace-icon fa fa-comment bigger-120"></i>
                                          </span>
                                        </a>
                                      </li>
                                      <li>
                                        <a href="javascript:" onclick="update_status('<?php echo $row->task_id;?>')" class="tooltip-info" data-rel="tooltip" data-toggle="modal" title="View details">
                                          <span class="pink">

                                            <i class="ace-icon fa  fa-tachometer bigger-120"></i>
                                          </span>
                                        </a>
                                      </li> 
                                      <li>
                                        <a href="<?php echo SITE_URL;?>/view-task-details/<?php echo $row->task_id;?>" class="tooltip-success" data-rel="tooltip" title="view">
                                          <span class="orange">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                          </span>
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </td>
                            </tr>

                          <?php } ?>
                          

                        </tbody>
                      </table>
                      <?php }else echo 'empty'; ?>