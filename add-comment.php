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
   if(!empty($_POST) && $_POST['task_id']!='')
   { 
        $status=$task_op_obj->save_task_comments($_POST,$_FILES);
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
        $redirect_to=(isset($_REQUEST['from_page']) && $_REQUEST['from_page']!='')?$_REQUEST['from_page']:'view-tasks';
        echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/".$redirect_to."\">";
        exit;
        }
   }

     $get_task=$task_op_obj->get_task_details(["task_id"=>$_REQUEST['task_id']]);
    if(empty($get_task))
    {
        echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
        exit;
    }

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Add Task Comment - <?php echo META_TITLE;?></title>
    <meta name="description" content="overview &amp; stats" />
    <style type="text/css">#box_l-error,#box_b-error,#box_h-error {color: #d16e6c;}
    .float-left{float: left;width: 50%;}
      .no_end_class {
          float: left;
          margin: 5px 11px;
      }
      .margin-9{margin-top: 9px;}
            	#removeItem_1{display: none;}
 </style>

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
                <a href="<?php echo SITE_URL; ?>/view-tasks">Manage Tasks</a>
              </li>
              <li class="active">Add Comment</li>
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
                              <input type="hidden" value="<?php echo $get_task[0]->task_id;?>" name="task_id">

                              <div class="form-group">
                                <label for="task_title" class="control-label col-xs-12 col-sm-3 no-padding-right">Title:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix margin-9">
                                    <?php echo $get_task[0]->task_title;?>
                                  </div>
                                </div>
                              </div>
                               <div class="space-2"></div>

                               <div class="form-group">
                                <label for="Address" class="control-label col-xs-12 col-sm-3 no-padding-right">Date:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix margin-9">
                                    <?php echo  $get_task[0]->start_date.' - '.$get_task[0]->end_date;?>
                                  </div>
                                </div>
                              </div>
                               <div class="space-2"></div>

                               <div class="form-group">
                                <label for="location" class="control-label col-xs-12 col-sm-3 no-padding-right">Priority:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix margin-9">
                                    <?php echo $priority_array[$get_task[0]->priority];?>
                                  </div>
                                </div>
                              </div>
                               <div class="space-2"></div>
                              <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="description">Comment:</label>
                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                     <textarea id="description" name="description" rows="10"></textarea>
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
                                <label for="attachment" class="control-label col-xs-12 col-sm-3 no-padding-right">Attachment:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="file" id="attachment" name="attachment" />
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
            
            description: {
              required: function(){
               CKEDITOR.instances.description.updateElement();
              },

             minlength:10
            }
          },
      
          messages: {

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