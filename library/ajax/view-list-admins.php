<?php 
  include_once('../includes/functions.php');
  
	if(!isset($active_super_user) || !$active_super_user)
  {
    echo 'empty';
      exit;
  }
  $parms=array();
  if(!empty($_POST['username']))
		$parms['user_name']=$_POST['username'];
	if(!empty($_POST['email']))
  $parms['email']=$_POST['email'];
  $get_all_admins=$user_op_obj->get_users($parms,false,['admin'],'all','0');

?>
<?php if(is_array($get_all_admins) && count($get_all_admins)>0){ ?>
<table id="dynamic-table" class="table table-striped table-bordered table-hover">
                        <thead>
                          <tr>
                            <th class="center">
                              <label class="pos-rel">
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                              </label>
                            </th>
                            <th>User Name</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th></th>
                          </tr>
                        </thead>

                        <tbody id="pages_table">
                          <?php 
                            foreach ($get_all_admins as $row) {


                            ?>
                            <tr id="content_row_<?php echo $row['id'];?>">
                              <td class="center">
                                <label class="pos-rel">
                                  <input type="checkbox" class="ace" value="<?php echo $row['username'];?>" name="check_row" />
                                  <span class="lbl"></span>
                                </label>
                              </td>

                              <td>
                                <a href="#"><?php echo $row['username'];?></a>
                              </td>
                              <td>
                                <a href="#"><?php echo $row['first_name'];?></a>
                              </td>
                              <td>
                                <a href="#"><?php echo $row['last_name'];?></a>
                              </td>
                              <td>
                                <a href="#"><?php echo $row['email'];?></a>
                              </td>
                              
                              <td>
                                <div class="hidden-sm hidden-xs action-buttons">
                                  <a class="blue" href="javascript:" title="View Details" id="view_page_m" onclick="get_details('<?php echo $row['username'];?>')">
                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                  </a>

                                  <a class="grey" href="<?php echo SITE_URL;?>/manage-admin-user/<?php echo $row['username'];?> " title="Update Admin User">
                                    <i class="ace-icon fa fa-pencil-square-o bigger-130"></i>
                                  </a>

                                  <a class="<?php echo ($row['status']==1)?'green':'red';?>" href="javascript:"  title="<?php echo ($row['status']==1)?'Deactivate':'Activate';?>" onclick="update_user_status('<?php echo $row['username'];?>')" id="status_<?php echo $row['username'];?>">
                                    <i class="ace-icon fa fa-circle bigger-130"></i>
                                  </a>
                                  
                                    <!--<a class="red" href="javascript:" onclick="delete_pages(<?php echo $row['id'];?>);"  title="Remove">
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                  </a>-->
                                </div>

                                <div class="hidden-md hidden-lg">
                                  <div class="inline pos-rel">
                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                      <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                      <li>
                                        <a href="javascript:" onclick="get_details('<?php echo $row['username'];?>')" class="tooltip-info" data-rel="tooltip" data-toggle="modal" title="View details">
                                          <span class="blue">

                                            <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                          </span>
                                        </a>
                                      </li>

                                      <li>
                                        <a href="<?php echo SITE_URL;?>/manage-admin-user/<?php echo $row['username'];?>" class="tooltip-success" data-rel="tooltip" title="Update">
                                          <span class="grey">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                          </span>
                                        </a>
                                      </li>
                                       <li>
                                        <a href="javascript:" class="tooltip-error" data-rel="tooltip" title="<?php echo ($row['status']==1)?'Deactivate':'Activate';?>" onclick="update_user_status('<?php echo $row['username'];?>')" id="status_m_<?php echo $row['username'];?>">
                                          <span class="<?php echo ($row['status']==1)?'green':'red';?>">
                                            <i class="ace-icon fa fa-circle bigger-120"></i>
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