<?php 
$this_module_name='Tasks';
$this_sub_module_name='';
$this_page_name='add-comment';
include_once('library/includes/functions.php');
if(!isset($_REQUEST['task_id']) || $_REQUEST['task_id']=='')
{
    echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
    exit;
}
include_once(CLASSES.'/task_rel_class.php');
$task_op_obj=new TASK_OPERATIONS();
     $get_task=$task_op_obj->get_task_details(["task_id"=>$_REQUEST['task_id']]);
    if(empty($get_task))
    {
        echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
        exit;
    }
$comments=$task_op_obj->get_task_comments($_REQUEST['task_id']);
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>View Task Details - <?php echo META_TITLE;?></title>
    <meta name="description" content="overview &amp; stats" />
      <style type="text/css">.pull-right span {margin-left: 30px;}</style>
      <style type="text/css">div.right_row .pull-right {
    float: right;
    text-align: right;
    width: 100%;
}
.attachment-convo a {
    padding: 6px 10px;
    border: 1px solid #6ead4c;
    border-radius: 13px;
}</style>
    <?php include_once(INC.'/header.php'); ?>   
        <div class="breadcrumbs" id="breadcrumbs">
            <script type="text/javascript">
              try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
            </script>

            <ul class="breadcrumb">
              <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="<?php echo SITE_URL; ?>">Home</a>
              </li>

              
              <li>
                <a href="#">Manage Tasks</a>
              </li>
              <li class="active">View Task Details</li>
            </ul><!-- /.breadcrumb -->

            
          </div>

          <div class="page-content">
            

            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->

             
                <div class="row">
                  <div class="col-xs-12">
                    <div class="clearfix">
                        <!--<div class="pull-left"><a href="javascript:" onclick="delete_pages('');" class="DTTT_button btn btn-white btn-primary  btn-bold"><span><i class="fa fa-trash-o bigger-110 red"></i></span></a></div>
                      <div class="pull-right"><a href="javascript:" onclick="export_report();" class="btn btn-white btn-primary  btn-bold"><span><i class="fa fa-file-excel-o bigger-110 green"></i></span></a></div>-->
                    </div>
                    <div class="table-header">
                      View Task Details
                    </div>

                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div>
                    
            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="space-6"></div>

                <div class="row">
                  <div class="col-sm-10 col-sm-offset-1">
                    <div class="widget-box transparent">
                      <div class="widget-header widget-header-large">
                        <h3 class="widget-title grey lighter">
                          <!--<i class="ace-icon fa fa-leaf green"></i>-->
                          <?php echo $get_task[0]->task_title;?>
                        </h3>

                      </div>

                      <div class="widget-body">
                        <div class="widget-main padding-24">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="row">
                              <div class="well well-sm">
												<!-- -
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		&nbsp; -->
												<div class="inline middle blue bigger-110"> Task is <?php echo $get_task[0]->completed_per;?>% completed </div>

												&nbsp; &nbsp; &nbsp;
												<div style="width:200px;" data-percent="<?php echo $get_task[0]->completed_per;?>%" class="inline middle no-margin progress progress-striped active pos-rel">
													<div class="progress-bar progress-bar-success" style="width:<?php echo $get_task[0]->completed_per;?>%"></div>
												</div>
											</div><!-- /.well -->
                                <div class="col-xs-11 label label-lg label-purple arrowed arrowed-right">
                                  <b>Task Details</b>
                                </div>
                              </div>

                              <div>
                                <ul class="list-unstyled spaced">
                                <li>
                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                    Status:

                                    <b class="red"><?php echo ucfirst($get_task[0]->status);?></b>
                                  </li>
                                <li>
                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                    Task Assigned By:

                                    <b class="red">@<?php echo $get_task[0]->created_by;?></b>
                                  </li>
                                  <li>
                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                    Priority:

                                    <b class="red"><?php echo $priority_array[$get_task[0]->priority];?></b>
                                  </li>
                                <li>
                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                    Start Date:

                                    <b class="red"><?php echo $get_task[0]->start_date;?></b>
                                  </li>
                                  <li>
                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                    End Date:

                                    <b class="red"><?php echo $get_task[0]->end_date;?></b>
                                  </li>
                                  <li>
                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                    Category:

                                    <b class="red"><?php echo $get_task[0]->category;?></b>
                                  </li>
                                  <li>
                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                    Short Info:

                                    <b class="red"><?php echo $get_task[0]->short_description;?></b>
                                  </li>
                                <?php if(isset($get_task[0]->attachment_name) && file_exists(DOCUMENTROOT.'/'.$get_task[0]->attachment_path)){?>
                                  <li>
                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                    Attachment:

                                    <b class="red"><a href="<?php echo SITE_URL.'/'.$get_task[0]->attachment_path;?>" target="_blank"><?php echo $get_task[0]->attachment_name;?></a></b>
                                  </li>
                                  <?php } ?> 

                                  

                                  
                                </ul>
                              </div>
                            </div><!-- /.col -->

                            
                          </div><!-- /.row -->

                          

                          <div class="space"></div>
                          
                          <div class="hr hr8 hr-double hr-dotted"></div>
                          <div class="row">
                            <div class="col-sm-12">
                                <h3>Description</h3>
                                <?php echo html_entity_decode($get_task[0]->description,ENT_QUOTES,"UTF-8");?>
                            </div>
                            `							<div class="col-sm-12">
										<div class="widget-box">
											<div class="widget-header">
												<h4 class="widget-title lighter smaller">
													<i class="ace-icon fa fa-comment blue"></i>
													Comments
												</h4>
											</div>
                                        <?php if(is_array($comments) && !empty($comments)){ ?>
											<div class="widget-body">
												<div class="widget-main no-padding">
													<div class="dialogs">
                                                    <?php foreach($comments as $comment_val){?>
														<div class="itemdiv dialogdiv">
															<div class="user">
																<img alt="" src="<?php echo ASSETS;?>/avatars/avatar2.png" />
															</div>

															<div class="body">
																<div class="time">
																	<i class="ace-icon fa fa-clock-o"></i>
																	<span class="green"><?php echo $task_op_obj->convert_date_format('Y-m-d H:i:s',$comment_val->ta_created,'M d h:i A');?></span>
																</div>

																<div class="name">
																	<a href="#"><?php echo $comment_val->ta_comment_by;?></a>
																</div>
																<div class="text"><?php echo html_entity_decode($comment_val->ta_comment,ENT_QUOTES,"UTF-8")?></div>
                                                                <?php if(isset($comment_val->attachment_name) && file_exists(DOCUMENTROOT.'/'.$comment_val->attachment_path)){?>
                                                                <div class="text text-right attachment-convo"><a href="<?php echo SITE_URL.'/'.$comment_val->attachment_path;?>" target="_blank"><i class="ace-icon fa fa-external-link blue"></i> <?php echo $comment_val->attachment_name;?></a></div>
                                                                <?php } ?>
																
															</div>
														</div>
                                                    <?php } ?>  
													</div>

												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
                                        <?php  }else echo 'No Comments added!' ?>    
										</div><!-- /.widget-box -->
									</div><!-- /.col -->
                          </div>

                          

                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- PAGE CONTENT ENDS -->
              </div><!-- /.col -->
        </div>
                     
                    </div>
                  </div>
                </div>

                <!-- PAGE CONTENT ENDS -->
               <div id="modal-wizard" class="modal">
                        <i class="ace-icon fa fa-spinner fa-spin orange bigger-125" id="middle_spinner"></i>
                </div>
                
              </div><!-- /.col -->
            </div><!-- /.row -->

          </div>
        <?php include_once(INC.'/footer.php');?>

        
  </body>
</html>
