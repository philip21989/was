<?php 

$this_module_name='Assigned-tasks';
$this_sub_module_name='';
$this_page_name='assigned-tasks';

  include_once('library/includes/functions.php');
  
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>View Assigned Tasks - <?php echo META_TITLE;?></title>
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
                <a href="javascript:">View Tasks</a>
              </li>
              <li class="active">View Assigned Task List</li>
            </ul><!-- /.breadcrumb -->

            
          </div>

          <div class="page-content">
            

            <div class="row">
              <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->

              
                <div class="row">
                  <div class="col-xs-12">
                    <div class="clearfix">
                       <!-- <div class="pull-left"><a href="javascript:" onclick="delete_pages('');" class="DTTT_button btn btn-white btn-primary  btn-bold"><span><i class="fa fa-trash-o bigger-110 red"></i></span></a></div>
                      <div class="pull-right"><a href="javascript:" onclick="export_report();" class="btn btn-white btn-primary  btn-bold"><span><i class="fa fa-file-excel-o bigger-110 green"></i></span></a></div>-->
                    </div>
                    <div class="table-header">
                      View Assigned Tasks
                    </div>
                
                    <!-- div.table-responsive -->

                    <!-- div.dataTables_borderWrap -->
                    <div id="datatable-data">
                    
                      Loading...
                     
                    </div>
                  </div>
                </div>

                <!-- PAGE CONTENT ENDS -->
               
              </div><!-- /.col -->
            </div><!-- /.row -->

          </div>
          <div id="modal-wizard" class="modal">
                        <i class="ace-icon fa fa-spinner fa-spin orange bigger-125" id="middle_spinner"></i>
                </div>
        <?php include_once(INC.'/footer.php');?>

      <script type="text/javascript">
      jQuery(function($) {
        get_datatable();
        $(".knob").knob();

        $('#search_bt').click(function(){
            get_datatable();
          });


        $('.chosen-select').chosen({allow_single_deselect:true}); 

       

        $('#clear').on( 'click' , function () {
          $('#title').val('');
          $('#assigned_to').val('');
          get_datatable();
        } );

       

      
      })
  function get_datatable()
  {
    $('#datatable-data').html('Loading...');
    var title=$('#title').val();
    var assigned_to=$('#assigned_to').val();
    $.ajax({
      method:'POST',
      url:'<?php echo AJAX;?>/view-assigned-list-tasks.php',
      data:{title:title,assigned_to:assigned_to}
    }).success(function(msg){
      if(msg=='empty')
        $('#datatable-data').html('<h3 class="red align-center">No Tasks available</h3>');
      else
      {
        $('#datatable-data').html(msg);
        var oTable1 = $('#dynamic-table').dataTable({
          "pageLength": 25,
            bAutoWidth: false,
            "aoColumns": [
              { "bSortable": false },
              null,null,null,null,null,
              { "bSortable": false }
            ],
            "aaSorting": [],
            "language": {
          "emptyTable":     "No Tasks Available"
            }
            });
        
          $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
          $('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;
            $(this).closest('table').find('tbody > tr').each(function(){
              var row = this;
              if(th_checked) tableTools_obj.fnSelect(row);
              else tableTools_obj.fnDeselect(row);
            });
          });
          $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
            var row = $(this).closest('tr').get(0);
            if(!this.checked) tableTools_obj.fnSelect(row);
            else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
          });
            $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
            e.stopImmediatePropagation();
            e.stopPropagation();
            e.preventDefault();
          });
          $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
          function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();
            var off2 = $source.offset();
            if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
            return 'left';
          }
      }

   });
    
  }        
  function get_details(cid)
  { 
    $("#modal-wizard").modal();
    $.ajax({
          method:'POST',
          url:'<?php echo AJAX;?>/get_assigned_task_info.php',
          data:{cid:cid}
        }).success(function(msg){
          $('#modal-wizard').html(msg);
          $('#middle_spinner').css('display','none');

        });
  }
  function update_status(cid)
  { 
        $("#modal-wizard").modal();
        $.ajax({
            method:'POST',
            url:'<?php echo AJAX;?>/update_task_status.php',
            data:{cid:cid}
            }).success(function(msg){
            $('#modal-wizard').html(msg);
            $('#middle_spinner').css('display','none');

            });
   }
    function update_this_status(task_id)
    {
        var status=$('#task_status').val();
        var completed=$('#completed_per').val();
        $.ajax({
            method:'POST',
            url:'<?php echo AJAX;?>/update_this_status.php',
            data:{task_id:task_id,status:status,completed:completed}
            }).success(function(msg){
                $.gritter.add({
                  title: msg,
                  text: '',
                  class_name: 'gritter-success'
                });
                get_datatable();
                $('#modal-wizard').modal('toggle'); 
            });
    }    
    </script>
  </body>
</html>