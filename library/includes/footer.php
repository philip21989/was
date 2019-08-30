</div>
      </div><!-- /.main-content -->

      <div class="footer">
        <div class="footer-inner">
          <div class="footer-content">
            <span class="bigger-120">
              <span class="green bolder"> &copy; <?php echo date('Y');?></span>
            </span>

            
            
          </div>
        </div>
      </div>

      <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
      </a>
    </div><!-- /.main-container -->
    
        <script src="<?php echo ASSETS;?>/js/jquery.2.1.1.min.js"></script>


        <?php if(isset($_SESSION['status_dis']) && $_SESSION['status_dis']!=''){?>

            <script type="text/javascript">
              jQuery(function($) {
              $.gritter.add({
                  title: '<?php echo $_SESSION['status_dis'];?>',
                  text: '',
                  class_name: '<?php echo (isset($_SESSION['status_dis_type']) && $_SESSION['status_dis_type']=='success')?'gritter-success':'gritter-warning';?>'
                });
               });
            </script>

         <?php unset($_SESSION['status_dis']);unset($_SESSION['status_dis_type']);} ?> 

    

    <script type="text/javascript">
      window.jQuery || document.write("<script src='<?php echo ASSETS;?>/js/jquery.min.js'>"+"<"+"/script>");
    </script>

    
    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo ASSETS;?>/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="<?php echo ASSETS;?>/js/bootstrap.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/fuelux.wizard.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.validate.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/additional-methods.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/bootbox.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.maskedinput.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/select2.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/markdown.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/bootstrap-markdown.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/bootstrap-datepicker.min.js"></script>
    
    <script src="<?php echo ASSETS;?>/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.easypiechart.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.sparkline.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.flot.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.flot.pie.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.flot.resize.min.js"></script>

    <script src="<?php echo ASSETS;?>/js/spin.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.gritter.min.js"></script>

    <script src="<?php echo ASSETS;?>/js/dropzone.min.js"></script>

    <script src="<?php echo ASSETS;?>/js/jquery.colorbox.min.js"></script>

    <script src="<?php echo ASSETS;?>/js/fuelux.spinner.min.js"></script>


    <script src="<?php echo ASSETS;?>/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.dataTables.bootstrap.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/dataTables.tableTools.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/dataTables.colVis.min.js"></script>

    <script src="<?php echo ASSETS;?>/js/bootstrap-tag.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.hotkeys.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/bootstrap-wysiwyg.min.js"></script>

    <script src="<?php echo ASSETS;?>/js/chosen.jquery.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/moment.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/bootstrap-datetimepicker.min.js"></script>
    
    <script src="<?php echo ASSETS;?>/js/jquery.nestable.min.js"></script>

    <script src="<?php echo ASSETS;?>/js/ace-elements.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/ace.min.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.redirect.js"></script>
    <script src="<?php echo ASSETS;?>/js/jquery.knob.min.js"></script>

