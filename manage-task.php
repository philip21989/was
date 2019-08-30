<?php 
$this_module_name='Tasks';
$this_sub_module_name='';
include_once('library/includes/functions.php');
if((!isset($active_super_user) || !$active_super_user) && (!isset($active_admin_user) || !$active_admin_user))
{
    echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
    exit;
}
include_once(CLASSES.'/task_rel_class.php');
$task_op_obj=new TASK_OPERATIONS();
   if(!empty($_POST) && $_POST['task_title']!='')
   { 
        $status=$task_op_obj->save_task($_POST,$_FILES);
        if($status['status']=='fail')
        {
        $_SESSION['status_dis']=$status['msg'];
        $_SESSION['status_dis_type']='error';
        echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
        exit;
        }else
        {
        $_SESSION['status_dis']=$status['msg'];
        $_SESSION['status_dis_type']='success';
        echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/view-tasks\">";
        exit;
        }
   }

   if(isset($_REQUEST['task_id']))
   {
     $get_task=$task_op_obj->get_task_details(["task_id"=>$_REQUEST['task_id']]);
    if(empty($get_task))
    {
        echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
        exit;
    }
    $mode='update';
   }else
    $mode ='add';
    $this_page_name=($mode=='add')?'manage-task':'';
    $get_list_of_assigners=$user_op_obj->get_users([],false,[],'1','0');

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title><?php echo ucfirst($mode);?> Task - <?php echo META_TITLE;?></title>
    <meta name="description" content="overview &amp; stats" />
    <style type="text/css">#box_l-error,#box_b-error,#box_h-error {color: #d16e6c;}
    .float-left{float: left;width: 50%;}
      .no_end_class {
          float: left;
          margin: 5px 11px;
      } </style>
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
                <a href="<?php echo SITE_URL; ?>/view-tasks">Manage Task</a>
              </li>
              <li class="active"><?php echo ucfirst($mode);?> Task</li>
            </ul><!-- /.breadcrumb -->

            
          </div>

          <div class="page-content">
            

            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS 
                <h3 class="lighter block green">Update Password</h3>-->

                <div class="hr hr-18 hr-double dotted"></div>

                <div class="widget-box">
                  

                  <div class="widget-body">
                    <div class="widget-main">
                      <div id="fuelux-wizard-container">

                        <div class="step-content pos-rel">
                          <div class="step-pane active" data-step="1">
                            <h3 class="lighter block green">Enter the following information</h3>

                            
                             <h5 class="lighter block red" id="pw_error"></h5>
                            <form class="form-horizontal" id="validation-form" method="post" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $mode;?>" name="mode">
                              <?php if($mode=='update'){?>
                              <input type="hidden" value="<?php echo $get_task[0]->task_id;?>" name="task_id">
                             <?php } ?>
                                                     
                              <div class="form-group">
                                <label for="task_title" class="control-label col-xs-12 col-sm-3 no-padding-right">Title:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="text" value="<?php echo ($mode=='update')?$get_task[0]->task_title:'';?>" class="col-xs-12 col-sm-6" id="task_title" name="task_title">
                                  </div>
                                </div>
                              </div>

                              <div class="space-2"></div>
                              <div class="form-group">
                                <label for="category" class="control-label col-xs-12 col-sm-3 no-padding-right">Category:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="text" value="<?php echo ($mode=='update')?$get_task[0]->category:'';?>" class="col-xs-12 col-sm-6" id="category" name="category">
                                  </div>
                                </div>
                              </div>

                              <div class="space-2"></div>
                              <div class="form-group">
	                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="assigned_to">Assign to:</label>

	                            <div class="col-xs-12 col-sm-9">
	                              <div class="clearfix">
	                                <select class="input-full select2" id="assigned_to" name="assigned_to">
	                                    <option value="">Select User</option>
	                                    <?php if(is_array($get_list_of_assigners) && count($get_list_of_assigners)>0){
	                                        foreach($get_list_of_assigners as $reporter_details) {?>
	                                          <option value="<?php echo $reporter_details['username'];?>" <?php echo ($mode=='update' && $get_task[0]->assigned_to==$reporter_details['username'])?'selected="selected"':'';?> ><?php echo $reporter_details['first_name'].' '.$reporter_details['last_name'].' ('.$reporter_details['username'].')';?></option>
	                                    <?php } }?>
	                                    
	                                </select>
	                              </div>
	                            </div>
	                          </div>
	                         <div class="space-2"></div>
                             <div class="form-group">
	                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="priority">Priority:</label>

	                            <div class="col-xs-12 col-sm-9">
	                              <div class="clearfix">
	                                <select class="input-full select2" id="priority" name="priority">
	                                    <option value="">Select Priority</option>
                                        <?php foreach($priority_array as $p_key=>$p_value) { ?>
                                            <option value="<?php echo $p_key;?>" <?php echo ($mode=='update' && $get_task[0]->priority==$p_key)?'selected="selected"':'';?>><?php echo $p_value;?></option>
                                        <?php } ?>
	                                </select>
	                              </div>
	                            </div>
	                          </div>
	                         <div class="space-2"></div>
                              <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="short_description">Short Description:</label>
                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <textarea name="short_description" id="short_description" class="col-xs-12 col-sm-6" ><?php echo ($mode=='update')?$get_task[0]->short_description:'';?></textarea>
                                  </div>
                                </div>
                              </div>
                              <div class="space-2"></div>

                              <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="description">Description:</label>
                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                     <textarea id="description" name="description" rows="10"><?php echo ($mode=='update')?html_entity_decode($get_task[0]->description,ENT_QUOTES,"UTF-8"):'';?></textarea>
                                     <script src="<?php echo SITE_URL."/ckeditor/ckeditor.js"?>"></script>
                                     <script type="text/javascript" src="<?php echo SITE_URL."/ckfinder/ckfinder.js"?>"></script>
                                     <script>
                                      window.onload = function()

                                      {

                                            var editor = CKEDITOR.replace( 'description');

                                        CKEDITOR.config.allowedContent = true; 
                                          };
                                    </script>
                                 </div>
                                </div>
                              </div>

                              <div class="space-2"></div>

                              <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="start_date">Date</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="input-group float-left">
                                  <input type="text" class="input-sm form-control start_date" name="start_date" value="<?php echo ($mode=='update')?$get_task[0]->start_date:'';?>" />
                                  <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </span>

                                  <input type="text" class="input-sm form-control end_date" name="end_date" value="<?php echo ($mode=='update')?$get_task[0]->end_date:'';?>" />
                                </div>

                                </div>
                              </div>
                                <div class="space-2"></div>

                                <div class="form-group">
                                <label for="attachment" class="control-label col-xs-12 col-sm-3 no-padding-right">Attachment:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="file" id="attachment" name="attachment" />

                                   <?php if($mode=='update' && isset($get_task[0]->attachment_name) && $get_task[0]->attachment_name!=''){?>
                                     <?php echo $get_task[0]->attachment_name;?>
                                      <div class="space-2"></div>
                                      <input type="checkbox" name="remove_this_attachment" value="1"> Remove Attachment
                                   <?php } ?>
                                  </div>
                                </div>
                              </div>

                                                            
                              <div class="space-8"></div>

                                          <div class="clearfix">
                                <div class="col-md-offset-3 col-md-9">
                                  <input type="submit" name="submit_btn" value="Submit" class="btn btn-success">

                                  &nbsp; &nbsp; &nbsp;
                                  <input type="button" name="Back" value="Back" onclick="window.location.href='<?php echo SITE_URL; ?>/view-tasks'" class="btn btn-cancel">
                                </div>
                              </div>
                            </form>
                          </div>
                          
                        </div>
                      </div>

                      
                    </div><!-- /.widget-main -->
                  </div><!-- /.widget-body -->
                </div>

                <!-- PAGE CONTENT ENDS -->
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div>
        <?php include_once(INC.'/footer.php');?>

      <script type="text/javascript">
      jQuery(function($) {

       
        
      
        $('[data-rel=tooltip]').tooltip();
      
        $(".select2").css('width','200px').select2({allowClear:true})
        .on('change', function(){
          $(this).closest('form').validate().element($(this));
        }); 
      
      
        var $validation = false;
        $('#fuelux-wizard-container')
        .ace_wizard({
          //step: 2 //optional argument. wizard will jump to step "2" at first
          //buttons: '.wizard-actions:eq(0)'
        })
        .on('actionclicked.fu.wizard' , function(e, info){
          if(info.step == 1 && $validation) {
            if(!$('#validation-form').valid()) e.preventDefault();
          }
        })
        .on('finished.fu.wizard', function(e) {
          bootbox.dialog({
            message: "Thank you! Your information was successfully saved!", 
            buttons: {
              "success" : {
                "label" : "OK",
                "className" : "btn-sm btn-primary"
              }
            }
          });
        }).on('stepclick.fu.wizard', function(e){
          //e.preventDefault();//this will prevent clicking and selecting steps
        });
      
      
      

        jQuery.validator.addMethod("email", function (value, element) {
          return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value);
        }, "Enter a valid Email address.");
        
        
            
        $('#validation-form').validate({
          errorElement: 'div',
          errorClass: 'help-block',
          focusInvalid: false,
          ignore: "",
          rules: {
            
            task_title: {
              required: true
            },
            short_description: {
              required: true
            },
            assigned_to: {
              required: true
            },
            priority: {
              required: true
            },
            description: {
              required: function(){
               CKEDITOR.instances.description.updateElement();
              },

             minlength:10
            },
            start_date: {
              required: true,
            },
            end_date: {
              required: true,
            }
          },
      
          messages: {
            start_date: {
              required: 'Start Date required'
            },
            end_date: {
              required: 'End Date required'
            },
            assigned_to: {
              required: 'Select Assign to'
            },
            priority: {
              required: 'Select Priority'
            },
            attachment: {
              extension: "DOC|doc|DOCX|docx|PDF|pdf|txt|JPEG|jpeg|JPG|jpg|png|PNG"
            },
          },
      
      
          highlight: function (e) {
            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
          },
      
          success: function (e) {
            $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
            $(e).remove();
          },
      
          errorPlacement: function (error, element) {
            if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
              var controls = element.closest('div[class*="col-"]');
              if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
              else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
            }
            else if(element.is('.select2')) {
              error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
            }
            else if(element.is('.chosen-select')) {
              error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
            }
            else error.insertAfter(element.parent());
          },
      

          invalidHandler: function (form) {
          }
        });
      
        $('#attachment').ace_file_input({
          no_file:'No File ...',
          btn_choose:'Choose',
          btn_change:'Change',
          droppable:true,
          onchange:null,
          thumbnail:true, //| true | large
          whitelist:'DOC|doc|DOCX|docx|PDF|pdf|txt|JPEG|jpeg|JPG|jpg|png|PNG',
          blacklist:'exe|php'
          //onchange:''
          //
        });   
        
        //$('.input-daterange').datepicker({autoclose:true});
        $(".start_date").datepicker({
            autoclose: true,
          todayHighlight: true,
          format: 'mm-dd-yyyy',
          startDate: "<?php echo date('m-d-Y',strtotime('now'));?>", 
        }).on('changeDate', function (selected) {
            var startDate = new Date(selected.date.valueOf());
            $('.end_date').val('');
            $('.end_date').datepicker('setStartDate', startDate);
        }).on('clearDate', function (selected) {
            $('.end_date').datepicker('setStartDate', null);
        });

        $(".end_date").datepicker({
            format: 'mm-dd-yyyy',
            todayHighlight: true,
            autoclose: true,
            startDate: "<?php echo ($mode=='update')?$get_task[0]->start_date:date('m-d-Y',strtotime('now'));?>"
        }).on('changeDate', function (selected) {
            var endDate = new Date(selected.date.valueOf());
            $('.start_date').datepicker('setEndDate', endDate);
        }).on('clearDate', function (selected) {
            $('.start_date').datepicker('setEndDate', null);
        });


        $(document).one('ajaxloadstart.page', function(e) {
          //in ajax mode, remove remaining elements before leaving page
          $('[class*=select2]').remove();
          $('select[name="discount_code[]"]').bootstrapDualListbox('destroy');
          $('select[name="products[]"]').bootstrapDualListbox('destroy');
          $('select[name="category[]"]').bootstrapDualListbox('destroy');
        });

      

      })    </script>
  </body>
</html>