<header class="header">
    <a href="<?php echo base_url('dashboard');?>" class="logo" style="background:#fff">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        <img src="<?php echo getImageUrl( siteOption('logo') );?>" style="max-height: 40px;">
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top bg-danger" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="nav-link"><a href="<?php echo config_item('main_domain'); ?>" title="View Site" target="_blank"><i class="fa fa-globe"></i></a></li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span><i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-green">
                            <img src="<?php echo ($userdata['image']) ? get_image($userdata['image']) : base_url('admin/assets/img/avatar3.png');?>" class="img-circle" alt="User Image" />
                            <p>
                                <?php echo $userdata['name'] . ' - ' . config_item('user_levels')[$userdata['level']]; ?>
                                <!--<small>Member since Nov. 2014</small>-->
                            </p>
                        </li>
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="<?php echo base_url('user/my_posted');?>">Posted</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Histories</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url('user/profile'); ?>" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url('user/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>