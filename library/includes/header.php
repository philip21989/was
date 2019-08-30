    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" href="<?php echo ASSETS;?>/img/favicon.ico" >
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/font-awesome/4.2.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/select2.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/bootstrap-duallistbox.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/chosen.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/fonts/fonts.googleapis.com.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
    <script src="<?php echo ASSETS;?>/js/ace-extra.min.js"></script>
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/jquery-ui.custom.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/jquery.gritter.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/dropzone.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/colorbox.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/daterangepicker.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/datepicker.min.css" />
    <link rel="stylesheet" href="<?php echo ASSETS;?>/css/pagination.css" />
    <style type="text/css">.display-none {display: none !important;}</style>
  </head>
  <body class="no-skin">
    <div id="navbar" class="navbar navbar-default">
      <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
      </script>

      <div class="navbar-container" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
          <span class="sr-only">Toggle sidebar</span>

          <span class="icon-bar"></span>

          <span class="icon-bar"></span>

          <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
          <a href="<?php echo SITE_URL;?>" class="navbar-brand">
            <small>
            <?php echo META_TITLE;?>
            </small>
          </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
          <ul class="nav ace-nav">
            <li class="light-blue">
              <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <img class="nav-user-photo" src="<?php echo ASSETS;?>/avatars/user.jpg" alt="Jason's Photo" />
                <span class="user-info">
                  <small>Welcome,</small>
                  <?php echo $_SESSION['username'];?>
                </span>

                <i class="ace-icon fa fa-caret-down"></i>
              </a>

              <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                 <li>
                  <a href="<?php echo SITE_URL;?>/update_password">
                    <i class="ace-icon fa fa-pencil-square-o"></i>
                    Update Password
                  </a>
                </li>
                <li class="divider"></li>
                <li>
                  <a href="<?php echo SITE_URL;?>/logout">
                    <i class="ace-icon fa fa-power-off"></i>
                    Logout
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div><!-- /.navbar-container -->
    </div>

    <div class="main-container" id="main-container">
      <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
      </script>

      <div id="sidebar" class="sidebar                  responsive">
        <script type="text/javascript">
          try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
        </script>

        <!-- /.sidebar-shortcuts -->

        <ul class="nav nav-list" id="left-nav">

              <li class="<?php echo (isset($this_module_name) && $this_module_name=='Dashboard')?'active':'';?>">
                  <a href="<?php echo SITE_URL;?>">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text">Dashboard</span>
                  </a>
                  <b class="arrow"></b>
              </li>

              <li class="<?php echo (isset($this_module_name) && $this_module_name=='Settings')?'active open':'';?>">
                  <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-cog"></i>
                    <span class="menu-text">Settings</span>
                    <b class="arrow fa fa-angle-down"></b>
                  </a>
                  <b class="arrow"></b>
                  <ul class="submenu">
                    <li class="<?php echo (isset($this_page_name) && $this_page_name=='update_password')?'active':'';?>">
                      <a href="<?php echo SITE_URL;?>/update_password">Update Password</a>
                      <b class="arrow"></b>
                    </li>

                    <li class="<?php echo (isset($this_page_name) && $this_page_name=='update-profile')?'active':'';?>">
                      <a href="<?php echo SITE_URL;?>/update-profile">Update Profile</a>
                      <b class="arrow"></b>
                    </li>
                  </ul>
              </li>
              <?php if(isset($active_super_user) && $active_super_user){?>
                <li class="<?php echo (isset($this_module_name) && $this_module_name=='Admins')?'active open':'';?>">
                  <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-cog"></i>
                    <span class="menu-text">View Admins</span>
                    <b class="arrow fa fa-angle-down"></b>
                  </a>
                  <b class="arrow"></b>
                  <ul class="submenu">
                    <li class="<?php echo (isset($this_page_name) && $this_page_name=='view-admins')?'active':'';?>">
                      <a href="<?php echo SITE_URL;?>/view-admins">View Admin Users</a>
                      <b class="arrow"></b>
                    </li>

                    <li class="<?php echo (isset($this_page_name) && $this_page_name=='manage-admin-user')?'active':'';?>">
                      <a href="<?php echo SITE_URL;?>/manage-admin-user">Add Admin User</a>
                      <b class="arrow"></b>
                    </li>
                  </ul>
              </li>
              <?php } ?>
              <?php if((isset($active_super_user) && $active_super_user) || (isset($active_admin_user) && $active_admin_user)){?>
                <li class="<?php echo (isset($this_module_name) && $this_module_name=='Resources')?'active open':'';?>">
                  <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-cog"></i>
                    <span class="menu-text">View Resources</span>
                    <b class="arrow fa fa-angle-down"></b>
                  </a>
                  <b class="arrow"></b>
                  <ul class="submenu">
                    <li class="<?php echo (isset($this_page_name) && $this_page_name=='view-resources')?'active':'';?>">
                      <a href="<?php echo SITE_URL;?>/view-resources">View Resource Users</a>
                      <b class="arrow"></b>
                    </li>

                    <li class="<?php echo (isset($this_page_name) && $this_page_name=='manage-resource-user')?'active':'';?>">
                      <a href="<?php echo SITE_URL;?>/manage-resource-user">Add Resource User</a>
                      <b class="arrow"></b>
                    </li>
                  </ul>
              </li>
              <li class="<?php echo (isset($this_module_name) && $this_module_name=='Tasks')?'active open':'';?>">
                  <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-cog"></i>
                    <span class="menu-text">View Tasks</span>
                    <b class="arrow fa fa-angle-down"></b>
                  </a>
                  <b class="arrow"></b>
                  <ul class="submenu">
                    <li class="<?php echo (isset($this_page_name) && $this_page_name=='view-tasks')?'active':'';?>">
                      <a href="<?php echo SITE_URL;?>/view-tasks">View Tasks</a>
                      <b class="arrow"></b>
                    </li>

                    <li class="<?php echo (isset($this_page_name) && $this_page_name=='manage-task')?'active':'';?>">
                      <a href="<?php echo SITE_URL;?>/manage-task">Add task</a>
                      <b class="arrow"></b>
                    </li>
                  </ul>
              </li>
              <?php } ?>
              <li class="<?php echo (isset($this_module_name) && $this_module_name=='Assigned-tasks')?'active open':'';?>">
                  <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-cog"></i>
                    <span class="menu-text">Assigned Tasks</span>
                    <b class="arrow fa fa-angle-down"></b>
                  </a>
                  <b class="arrow"></b>
                  <ul class="submenu">
                    <li class="<?php echo (isset($this_page_name) && $this_page_name=='assigned-tasks')?'active':'';?>">
                      <a href="<?php echo SITE_URL;?>/assigned-tasks">My Tasks</a>
                      <b class="arrow"></b>
                    </li>

                    
                  </ul>
              </li>
        </ul><!-- /.nav-list -->

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
          <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <script type="text/javascript">
          try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        </script>
      </div>

      <div class="main-content">
        <div class="main-content-inner">
          