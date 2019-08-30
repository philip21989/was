<?php 
  include_once('library/includes/config.php');
  if(!isset($_REQUEST['link']) || $_REQUEST['link']=='' || isset($_SESSION['username']))
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
    <title>Recovery Password Page - <?php echo META_TITLE;?></title>

    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/font-awesome/4.2.0/css/font-awesome.min.css" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo ASSETS;?>/fonts/fonts.googleapis.com.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/ace.min.css" />

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="<?php echo ASSETS;?>/css/ace-part2.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/ace-rtl.min.css" />

    <style type="text/css">
      .help-block{color:#d16e6c;}
    </style>

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="<?php echo ASSETS;?>/css/ace-ie.min.css" />
    <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="<?php echo ASSETS;?>/js/html5shiv.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body class="login-layout">
    <div class="main-container">
      <div class="main-content">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="login-container">
              <div class="center">
                <h1>
                  <span class="green"><?php echo META_TITLE;?></span>
                </h1>
                <h4 class="white" id="id-company-text">Recovery Password</h4>
              </div>

              <div class="space-6"></div>

              <div class="position-relative">
                <div id="login-box" class="login-box visible widget-box no-border">
                  <div class="widget-body">
                    <div class="widget-main">
                      <h4 class="header blue lighter bigger">
                        <i class="ace-icon fa fa-coffee green"></i>
                        Please Enter Your Information
                      </h4>

                      <div class="space-6"></div>

                      <div class="error_msg" id="login_error"></div>

                      <form method="post" id="validation-recovery-form" class="form-horizontal" onsubmit="return false;">
                        <fieldset>
                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="password" class="form-control" placeholder="New Password" id="password" name="password" />
                              <i class="ace-icon fa fa-lock"></i>
                            </span>
                          </label>

                          <label class="block clearfix">
                            <span class="block input-icon input-icon-right">
                              <input type="password" class="form-control" placeholder="Confirm Password" id="password2" name="password2" />
                              <i class="ace-icon fa fa-lock"></i>
                            </span>
                          </label>

                          <div class="space"></div>

                          <div class="clearfix">
                              <input type="hidden" name="link" value="<?php echo $_REQUEST['link'];?>" id='link'></input>
                                                    
                            <input type="submit" name="submit" value="Change" id="recovery-form" class="width-35 pull-right btn btn-sm btn-primary">
                          </div>
                          <div class="space-4"></div>
                        </fieldset>
                      </form>

                    </div><!-- /.widget-main -->

                    
                  </div><!-- /.widget-body -->
                </div><!-- /.login-box -->

                
                <!-- /.signup-box -->
              </div><!-- /.position-relative -->
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="<?php echo ASSETS;?>/js/jquery.2.1.1.min.js"></script>

    <script src="<?php echo ASSETS;?>/js/jquery.validate.min.js"></script>

    <script type="text/javascript">
      window.jQuery || document.write("<script src='<?php echo ASSETS;?>/js/jquery.min.js'>"+"<"+"/script>");
    </script>

    
    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo ASSETS;?>/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="<?php echo ASSETS;?>/js/bootstrap.min.js"></script>

    <script src="<?php echo ASSETS;?>/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.easypiechart.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.sparkline.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.flot.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.flot.pie.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.flot.resize.min.js"></script>

    <script src="<?php echo ASSETS;?>/js/ace-elements.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/ace.min.js"></script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
      jQuery(function($) {
       $(document).on('click', '.toolbar a[data-target]', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.widget-box.visible').removeClass('visible');//hide others
        $(target).addClass('visible');//show target
       });
      });
      
      
      
      //you don't need this, just used for changing background
      jQuery(function($) {
       $('#btn-login-dark').on('click', function(e) {
        $('body').attr('class', 'login-layout');
        $('#id-text2').attr('class', 'white');
        $('#id-company-text').attr('class', 'blue');
        
        e.preventDefault();
       });
       $('#btn-login-light').on('click', function(e) {
        $('body').attr('class', 'login-layout light-login');
        $('#id-text2').attr('class', 'grey');
        $('#id-company-text').attr('class', 'blue');
        
        e.preventDefault();
       });
       $('#btn-login-blur').on('click', function(e) {
        $('body').attr('class', 'login-layout blur-login');
        $('#id-text2').attr('class', 'white');
        $('#id-company-text').attr('class', 'light-blue');
        
        e.preventDefault();
       });


       $('#validation-recovery-form').validate({
          errorElement: 'div',
          errorClass: 'help-block',
          focusInvalid: false,
          ignore: "",
          rules: {
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
             var link=$('#link').val();
             var pwd=$('#password').val();
             $.ajax({
                method:'POST',
                url:'<?php echo AJAX;?>/recovery_password.php',
                data:{link:link, pwd:pwd}
             }).success(function(msg){
              $('#login_error').html(msg);
                if(msg==1)
                {
                  $('#login_error').html("Password successfully updated.");
                  var delay = 2000;
                  setTimeout(function() {
                    $(location).attr('href',"<?php echo SITE_URL.'/login';?>");
                  }, delay);
                }
                else
                  $('#login_error').html(msg);
                
             });
          },
          invalidHandler: function (form) {
          }
        });
       
      });
    </script>
  </body>
</html>
