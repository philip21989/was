<?php 

$this_module_name='Settings';
$this_sub_module_name='';
$this_page_name='update-profile';

include_once('library/includes/functions.php');

if(!empty($_POST))
{
  $_POST['user_name']=$_SESSION['username'];
  $update_status=$user_op_obj->update_logged_user($_POST);
  if(!empty($update_status))
  {
    $_SESSION['status_dis']=$update_status['msg'];
    $_SESSION['status_dis_type']=$update_status['status'];
  }
}
  
$get_details=  $user_op_obj->get_user_details(array("user_name" => $_SESSION['username']));
if(empty($get_details))
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
    <title>Update Profile - <?php echo META_TITLE;?></title>
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
                <a href="#">Settings</a>
              </li>
              <li class="active">Update Profile</li>
            </ul><!-- /.breadcrumb -->

            
          </div>

          <div class="page-content">
            

            <div class="row">
              <div class="col-xs-12">
               

                <div class="hr hr-18 hr-double dotted"></div>

                <div class="widget-box">
                  

                  <div class="widget-body">
                    <div class="widget-main">
                      <div id="fuelux-wizard-container">

                        <div class="step-content pos-rel">
                          <div class="step-pane active" data-step="1">
                          <h5 class="lighter block red error_msg" id="error_msg">
                            <?php 
                              if(isset($update_status['msg']))
                                echo $update_status['msg'];
                            ?>
                          </h5>
                            <h3 class="lighter block green">Enter the following information</h3>

                           
                            <form class="form-horizontal" action="" id="validation-form" method="post">
                            
                               <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="first_name">First Name:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="text" name="first_name" id="first_name" class="col-xs-12 col-sm-6" value="<?php echo $get_details[0]->first_name;?>" />
                                  </div>
                                </div>
                              </div>

                              <div class="space-2"></div>
                                                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="last_name">Last Name:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="text" name="last_name" id="last_name" class="col-xs-12 col-sm-6"  value="<?php echo $get_details[0]->last_name;?>"/>
                                  </div>
                                </div>
                              </div>

                              <div class="space-2"></div>
                                                            
                              <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="email">Email Address:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="email" name="email" id="email" class="col-xs-12 col-sm-6" value="<?php echo $get_details[0]->email;?>" />
                                  </div>
                                                                    
                                </div>
                              </div>
                       
                              <div class="space-8"></div>

                              <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                  <label>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-success">
                                    <h5 class="lighter block red error_msg" id="error_msg"></h5>
                                  </label>
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
            
            first_name: {
              required: true
            },
            last_name: {
              required: true
            },
            email: {
              required: true,
              email:true
            }
            
          },
      
          messages: {
            
            email: {
              required: "Provide a valid email.",
              email: "Provide a valid email."
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
