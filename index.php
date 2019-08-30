<?php 
$this_module_name='Dashboard';
$this_sub_module_name='';
$this_page_name='index';
  include_once('library/includes/functions.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Dashboard - <?php echo META_TITLE;?></title>
    <meta name="description" content="overview &amp; stats" />
    <?php include_once(INC.'/header.php'); ?>   
<div class="breadcrumbs" id="breadcrumbs">
<script type="text/javascript">
try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
</script>
<ul class="breadcrumb">
<li>
<i class="ace-icon fa fa-home home-icon"></i>
<a href="#">Home</a>
</li>
<li class="active">Dashboard</li>
</ul><!-- /.breadcrumb -->
</div>
            <div class="page-content">
            <!-- /.ace-settings-container -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <h1 class="center green">WAS</h1>
                                <div class="col-xs-12 col-sm-6 col-sm-offset-3 center">
                                    <div class="space-6"></div>
                                    <div class="hr hr16 dotted"></div>
                                    <div class="profile-contact-info">
                                    <div class="profile-contact-links align-center">
                                        <a class="btn btn-link" href="javascript:">
                                            <i class="ace-icon fa fa-circle bigger-130"></i>
                                            Active
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                    </div><!-- /.row -->

            </div><!-- /.page-content -->

        <?php include_once(INC.'/footer.php');?>

      
  </body>
</html>
