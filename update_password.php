<?php 

$this_module_name='Settings';
$this_sub_module_name='';
$this_page_name='update_password';

  include_once('library/includes/functions.php');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Update Password - <?php echo META_TITLE;?></title>
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
              <li class="active">Update Password</li>
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
                            <form class="form-horizontal" id="validation-form" method="post">
                                                            
                              <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="old_pw">Old Password:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="password" name="opwd" id="opwd" class="col-xs-12 col-sm-4" />
                                  </div>
                                </div>
                              </div>

                              <div class="space-2"></div>

                              <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password">New Password:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="password" name="password" id="password" class="col-xs-12 col-sm-4" />
                                  </div>
                                </div>
                              </div>

                              <div class="space-2"></div>

                              <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="password2">Confirm Password:</label>

                                <div class="col-xs-12 col-sm-9">
                                  <div class="clearfix">
                                    <input type="password" name="password2" id="password2" class="col-xs-12 col-sm-4" />
                                  </div>
                                </div>
                              </div>
                              
                                                            
                              <div class="space-8"></div>

                              <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                  <label>
                                    <input type="submit" name="submit" value="Submit" class="btn btn-success">
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
      
        $('#validation-form').validate({
          errorElement: 'div',
          errorClass: 'help-block',
          focusInvalid: false,
          ignore: "",
          rules: {
            opwd: {
              required: true
            },
            password: {
              required: true,
              minlength: 5
            },
            password2: {
              required: true,
              minlength: 5,
              equalTo: "#password"
            }
          },
      
          messages: {
            opwd:{
              required:"Enter Old Password"
            },
            password: {
              required: "Enter New password.",
              minlength: "Please specify a secure password."
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
      
          submitHandler: function (form) {
            var op=$('#opwd').val();
            var np=$('#password').val();
             $.ajax({
                method:'POST',
                url:'<?php echo AJAX;?>/update_password.php',
                data:{op:op, np:np}
             }).success(function(msg){
                if(msg==1)
                {
                  $('#pw_error').html('Password updated successfully');
                }
                else   
                  $('#pw_error').html(msg);

                $('#opwd').val('');
                $('#password').val('');
                $('#password2').val('');
             });
          },
          invalidHandler: function (form) {
          }
        });
      
        
        
        
        $('#modal-wizard-container').ace_wizard();
        $('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');
        
        
        /**
        $('#date').datepicker({autoclose:true}).on('changeDate', function(ev) {
          $(this).closest('form').validate().element($(this));
        });
        
        $('#mychosen').chosen().on('change', function(ev) {
          $(this).closest('form').validate().element($(this));
        });
        */
        
        
        $(document).one('ajaxloadstart.page', function(e) {
          //in ajax mode, remove remaining elements before leaving page
          $('[class*=select2]').remove();
        });
      })
    </script>
  </body>
</html>
