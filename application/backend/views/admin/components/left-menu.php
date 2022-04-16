<aside class="left-side sidebar-offcanvas">                
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo ($userdata['image']) ? get_image($userdata['image']) : base_url('admin/assets/img/avatar3.png'); ?>" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Hello, <?php echo $userdata['name']; ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        
        <?php 
        //$this->load->view('admin/components/inc-menu-'.$userdata['level']);
        $this->load->view('admin/components/inc-menu');
        ?>
    </section>
    <!-- /.sidebar -->
</aside>