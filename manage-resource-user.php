<?php 

$this_module_name='Resources';
$this_sub_module_name='';


  include_once('library/includes/functions.php');
  if((!isset($active_super_user) || !$active_super_user) && (!isset($active_admin_user) || !$active_admin_user))
  {
      echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
      exit;
  }
 if(!empty($_POST))
 {  
   $status=$user_op_obj->save_resource_user($_POST);
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
      echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/view-resources\">";
      exit;
    }
 }

  if(isset($_REQUEST['username']))
  {
    $get_user_data=$user_op_obj->get_users(['user_name'=>$_REQUEST['username']],true);

  if(empty($get_user_data))
  {
    $_SESSION['status_dis']='Invalid user';
    $_SESSION['status_dis_type']='error';
      echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
      exit;
  }else if($get_user_data[0]->user_type!='resource')
  {
    $_SESSION['status_dis']='User not a Resource';
    $_SESSION['status_dis_type']='error';
      echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
      exit;
  }else if(isset($active_admin_user) && $active_admin_user && $get_user_data[0]->reporting!=$_SESSION['username'])
  {
    $_SESSION['status_dis']='Resource is reporting to another admin';
    $_SESSION['status_dis_type']='error';
      echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0;URL=".SITE_URL."/\">";
      exit;
  }
  $mode='update';
  }else
  $mode ='add';

    $this_page_name=($mode=='add')?'manage-resource-user':'';
    if(isset($active_super_user) && $active_super_user)
        $get_list_of_reporting=$user_op_obj->get_users([],false,['super_admin','admin'],'1','0');

 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title><?php echo ucfirst($mode);?> Resource User - <?php echo META_TITLE;?></title>
    <meta name="description" content="overview &amp; stats" />
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
                <a href="<?php echo SITE_URL; ?>/view-blocks">Manage Resources</a>
              </li>

              <li class="active"><?php echo ucfirst($mode);?> Resource</li>
            </ul><!-- /.breadcrumb -->

            
          </div>

          <div class="page-content">
            

            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                
                <div class="hr hr-18 hr-double dotted"></div>

                <div class="widget-box">
                  

                  <div class="widget-body">
                    <div class="widget-main">
                      <div id="fuelux-wizard-container">

                        <div class="step-content pos-rel">
                          <div class="step-pane active" data-step="1">
                            <h3 class="lighter block green"><?php echo ucfirst($mode);?> <?php echo (isset($_REQUEST['username']))?$get_user_data[0]->first_name:'';?> Resource</h3>

                            

                            <form class="form-horizontal" method="post" id="validation-form" action=""  enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $mode;?>" name="mode">
                            <?php if($mode=='update'){?>
                                  <input type="hidden" value="<?php echo $get_user_data[0]->user_name;?>" name="edit_user">
                             <?php } ?> 
                            <?php if($mode=='add'){?>
                             <div class="form-group">
                                <label for="user_name" class="control-label col-xs-12 col-sm-3 no-padding-right">User Name:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="text" value="<?php echo ($mode=='update')?$get_user_data[0]->user_name:'';?>" class="col-xs-12 col-sm-6" id="user_name" name="user_name">
                                  </div>
                                </div>
                              </div>
                               
                              <div class="space-2"></div>
                            <?php } ?>  
                        <?php if(isset($active_super_user) && $active_super_user){?>
                            <div class="form-group">
	                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="report_to">Select Reporting to:</label>

	                            <div class="col-xs-12 col-sm-9">
	                              <div class="clearfix">
	                                <select class="input-full select2" id="report_to" name="report_to">
	                                    <option value="">Select User</option>
	                                    <?php if(is_array($get_list_of_reporting) && count($get_list_of_reporting)>0){
	                                        foreach($get_list_of_reporting as $reporter_details) {?>
	                                          <option value="<?php echo $reporter_details['username'];?>" <?php echo ($mode=='update' && $get_user_data[0]->reporting==$reporter_details['username'])?'selected="selected"':'';?> ><?php echo $reporter_details['first_name'].' '.$reporter_details['last_name'].' ('.$reporter_details['username'].')';?></option>
	                                    <?php } }?>
	                                    
	                                </select>
	                              </div>
	                            </div>
	                          </div>
	                         <div class="space-2"></div>

                        <?php }else if(isset($active_admin_user) && $active_admin_user){ ?> 
                            <input type="hidden" id="report_to" name="report_to" value="<?php echo $_SESSION['username']?>">
                        <?php } ?>

                            <div class="form-group">
                                <label for="first_name" class="control-label col-xs-12 col-sm-3 no-padding-right">First Name:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="text" value="<?php echo ($mode=='update')?$get_user_data[0]->first_name:'';?>" class="col-xs-12 col-sm-6" id="first_name" name="first_name">
                                  </div>
                                </div>
                              </div>
                               
                              <div class="space-2"></div>

                              <div class="form-group">
                                <label for="last_name" class="control-label col-xs-12 col-sm-3 no-padding-right">Last Name:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="text" value="<?php echo ($mode=='update')?$get_user_data[0]->last_name:'';?>" class="col-xs-12 col-sm-6" id="last_name" name="last_name">
                                  </div>
                                </div>
                              </div>
                               
                              <div class="space-2"></div>

                              <div class="form-group">
                                <label for="email" class="control-label col-xs-12 col-sm-3 no-padding-right">Email:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="text" value="<?php echo ($mode=='update')?$get_user_data[0]->email:'';?>" class="col-xs-12 col-sm-6" id="email" name="email">
                                  </div>
                                </div>
                              </div>
                               
                              <div class="space-2"></div>
                              <?php if($mode=='update'){?>
                                <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right no-padding-top" for="update_password">Update Password:</label>
                                <div class="col-xs-12 col-sm-9">
                                  <div>
                                    <label class="line-height-1 blue">
                                      <input type="radio" class="ace" value="1" id="update_pw_yes" name="update_password" >
                                      <span class="lbl"> Yes</span>
                                    </label>
                                    <label class="line-height-1 blue">
                                      <input type="radio" class="ace" value="0" name="update_password" id="update_pw_no" checked="checked" >
                                      <span class="lbl"> No</span>
                                    </label>
                                  </div>

                                </div>
                              </div>
                              <div class="space-2"></div>
                              <?php } ?>
                              <div class="form-group">
                                <label for="password" class="control-label col-xs-12 col-sm-3 no-padding-right">Password:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="password"  value="" class="col-xs-12 col-sm-6" id="password" name="password">
                                  </div>
                                </div>
                              </div>
                              <div class="space-2"></div>
                              <div class="form-group">
                                <label for="role" class="control-label col-xs-12 col-sm-3 no-padding-right">Role:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="text" value="<?php echo ($mode=='update' && isset($get_user_data[0]->user_role))?$get_user_data[0]->user_role:'';?>" class="col-xs-12 col-sm-6" id="role" name="role">
                                  </div>
                                </div>
                              </div>
                               
                              
                                                              
                           <div class="space-8"></div>

                                          <div class="clearfix">
                                <div class="col-md-offset-3 col-md-9">
                                  <input type="submit" name="submit_btn" value="Submit" class="btn btn-success">

                                  &nbsp; &nbsp; &nbsp;
                                  <input type="button" name="Back" value="Back" onclick="window.location.href='<?php echo SITE_URL; ?>/view-resources'" class="btn btn-cancel">
                                </div>
                              </div>
                            </form>
                          </div>
                          
                        </div>
                      </div>

                      
                    </div><!-- /.widget-main -->
                  </div><!-- /.widget-body -->
                </div>

                
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
          ignore: [],

          rules: {
            user_name: {
              required: true,
              remote: '<?php echo AJAX;?>/validate_user_name.php',
            },
            first_name: {
              required: true
            },
            last_name: {
              required: true
            },
            email: {
              required: true,
              email:true
            },
            password: {
              <?php if($mode=='add'){?>
              required: true,
              <?php }else{?>
              required: function (element) {
                  if($("#update_pw_yes").is(':checked')){
                    return true;
                  }else
                  return false;
              },
            <?php } ?>
              minlength: 5
            }
            
          },
      
          messages: {
            user_name: {
                remote:'User Name Existed'
            }
            
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
      
        
        
        
        $(document).one('ajaxloadstart.page', function(e) {
          //in ajax mode, remove remaining elements before leaving page
          $('[class*=select2]').remove();
        });

      

      })
    </script>
  </body>
</html>