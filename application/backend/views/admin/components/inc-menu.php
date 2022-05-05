<ul class="sidebar-menu" style="padding-bottom:150px">
    <li class="active">
        <a href="<?php echo base_url('dashboard'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="treeview <?php echo (in_array($this->router->class, array('news', 'category'))) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-file-text"></i>
            <span><?php echo lang('manage_product') ?></span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('manage_product/index'); ?>"><i class="fa fa-list"></i> Danh sách sản phẩm</a></li>
            <li><a href="<?php echo base_url('manage_product/edit'); ?>"><i class="fa fa-list"></i> Thêm mới </a></li>
            <li><a href="<?php echo base_url('category_product/index'); ?>"><i class="fa fa-list"></i> Danh mục sản phẩm </a></li>
        </ul>
    </li>
    <!--  -->
    <!-- <li><a href="/realnews/index"><i class="fa fa-file-text"></i> Sản phẩm </a></li>-->
    <li><a href="/member"><i class="fa fa-users"></i> <?php echo lang('member') ?> </a></li>
    <?php /*
    <li><a href="/pointload"><i class="fa fa-usd"></i> <?php echo lang('point') ?> </a></li>
    <li><a href="/pointload/refund?status=pending"><i class="fa fa-retweet"></i> <?php echo lang('refund_request') ?> <span class="badge bg-orange" id="refund_pending_number"></span></a></li>
    <li><a href="/member/post?status=pending"><i class="fa fa-plane"></i> <?php echo lang('post_request') ?> <span class="badge bg-orange" id="post_pending_number"></span></a></li>
    */ ?>
    <li class="treeview <?php echo (in_array($this->router->class, array('news', 'category'))) ? 'active' : ''; ?>">
        <a href="#">
            <i class="fa fa-file-text"></i>
            <span><?php echo lang('news') ?></span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('news/index'); ?>"><i class="fa fa-list"></i> Danh sách bài viết</a></li>
            <li><a href="<?php echo base_url('news/edit'); ?>"><i class="fa fa-list"></i> Thêm mới </a></li>
            <li><a href="<?php echo base_url('category'); ?>"><i class="fa fa-list"></i> Chuyên mục bài viết</a></li>
        </ul>
    </li>

    <li class="treeview <?php echo ($this->router->class=='partner') ? 'active' : '';?>">
        <a href="#">
            <i class="fa fa-share-alt"></i>
            <span>Đối tác kinh doanh</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('partner/edit'); ?>"><i class="fa fa-plus"></i> Thêm mới</a></li>
            <li><a href="<?php echo base_url('partner'); ?>"><i class="fa fa-list"></i> Danh sách</a></li>
        </ul>
    </li>

    <li class="treeview <?php echo ($this->router->class=='notification') ? 'active' : '';?>">
        <a href="#">
            <i class="fa fa-cc-discover"></i>
            <span>Tin khuyến mãi</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('notification/edit'); ?>"><i class="fa fa-plus"></i> Thêm mới</a></li>
            <li><a href="<?php echo base_url('notification'); ?>"><i class="fa fa-list"></i> Danh sách thông báo</a></li>
        </ul>
    </li>
    
    
    <?php /*
    
    
    <li class="treeview <?php echo ($this->router->class=='memtor') ? 'active' : '';?>">
        <a href="#">
            <i class="fa fa-user"></i>
            <span> Mentors </span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('memtor/edit'); ?>"><i class="fa fa-plus"></i> Thêm mới </a></li>
            <li><a href="<?php echo base_url('memtor'); ?>"><i class="fa fa-list"></i> Danh sách </a></li>
            <li><a href="/memtor/feedback"><i class="fa fa-list"></i> Feedbacks </a></li>
        </ul>
    </li>
        */

    
   
    /* 
    <li class="<?php echo ($this->router->class=='portfolio') ? 'active' : '';?>">
        <a href="/portfolio">
            <i class="fa fa-share-alt"></i>
            <span>Portfolio</span>
        </a>
    </li>

    <li class="<?php echo ($this->router->class=='accelerator') ? 'active' : '';?>">
        <a href="/accelerator">
            <i class="fa fa-share-alt"></i>
            <span>Accelerator</span>
        </a>
    </li>

    <li class="<?php echo ($this->router->class=='ourteam') ? 'active' : '';?>">
        <a href="/ourteam">
            <i class="fa fa-users"></i>
            <span>Our team</span>
        </a>
    </li>

    <li class="<?php echo ($this->router->class=='newspaper') ? 'active' : '';?>">
        <a href="/newspaper">
            <i class="fa fa-newspaper-o"></i>
            <span>Media Links</span>
        </a>
    </li>

    <li class="<?php echo ($this->router->class=='newsletter') ? 'active' : '';?>">
        <a href="/dashboard/newsletter">
            <i class="fa fa-newspaper-o"></i>
            <span>Newsletter</span>
        </a>
    </li>
    */ ?>
    <?php /*
    <li class="treeview <?php echo ($this->router->class=='event') ? 'active' : '';?>">
        <a href="#">
            <i class="fa fa-clock-o"></i>
            <span> Sự kiện </span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('event/edit'); ?>"><i class="fa fa-plus"></i> Thêm mới </a></li>
            <li><a href="<?php echo base_url('event'); ?>"><i class="fa fa-list"></i> Danh sách </a></li>
        </ul>
    </li>

    <li class="treeview <?php echo ($this->router->class=='gallery') ? 'active' : '';?>">
        <a href="#">
            <i class="fa fa-picture-o"></i>
            <span>Galleries</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('gallery/edit'); ?>"><i class="fa fa-plus"></i> Thêm mới</a></li>
            <li><a href="<?php echo base_url('gallery'); ?>"><i class="fa fa-list"></i> Danh sách </a></li>
        </ul>
    </li>
    */ ?>

    <?php /*
    <li class="treeview <?php echo ($this->router->class=='advertising') ? 'active' : '';?>">
        <a href="#">
            <i class="fa fa-cc-discover"></i>
            <span>Tin khuyến mãi</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('advertising/edit'); ?>"><i class="fa fa-plus"></i> Thêm mới</a></li>
            <li><a href="<?php echo base_url('advertising'); ?>"><i class="fa fa-list"></i> Danh sách </a></li>
            <li><a href="<?php echo base_url('advertising/group'); ?>"><i class="fa fa-list"></i> Nhóm </a></li>
        </ul>
    </li>
    
    <li class="treeview <?php echo ($this->router->class=='video') ? 'active' : '';?>">
        <a href="#">
            <i class="fa fa-video-camera"></i>
            <span>Videos</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('video/edit'); ?>"><i class="fa fa-plus"></i> Thêm mới</a></li>
            <li><a href="<?php echo base_url('video'); ?>"><i class="fa fa-list"></i> Danh sách </a></li>
            <li><a href="<?php echo base_url('video/video_category'); ?>"><i class="fa fa-list"></i> Chuyên mục </a></li>
        </ul>
    </li>
    */ ?>

    <?php if ($userdata['level'] <= 2) : ?>
        <?php /*
    <li class="treeview <?php echo ($this->router->class=='report') ? 'active' : '';?>">
        <a href="#">
            <i class="fa fa-line-chart"></i>
            <span>Báo cáo</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('report/viewerReport'); ?>"><i class="fa fa-list"></i> Thống kê Viewer</a></li>
        </ul>
    </li>
    */ ?>
        <?php /*
    <li class="treeview <?php echo ($this->router->class=='page') ? 'active' : '';?>">
        <a href="#">
            <i class="fa fa-file"></i>
            <span>Thông tin</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('page/edit'); ?>"><i class="fa fa-plus"></i> Thêm mới</a></li>
            <li><a href="<?php echo base_url('page'); ?>"><i class="fa fa-list"></i> Danh sách</a></li>
        </ul>
    </li>

    <li class="<?php echo ($this->router->class=='feedback') ? 'active' : '';?>">
        <a href="/feedback/index">
            <i class="fa fa-commenting-o"></i>
            <span>Customer Contact</span>
        </a>
    </li>

    <li class="<?php echo ($this->router->class=='faq') ? 'active' : '';?>">
        <a href="/faq/index">
            <i class="fa fa-question-circle-o"></i>
            <span>Q&A</span>
        </a>
    </li>
    
    
    <li class="treeview <?php echo ($this->router->class=='salary') ? 'active' : '';?>">
        <a href="#">
            <i class="fa fa-usd"></i>
            <span>Nhuận bút</span>
            <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo base_url('salary/salaryMonth/?min_view=' . min(config_item('pageview_quota'))); ?>"><i class="fa fa-list"></i> Chấm nhuận</a></li>
            <li><a href="<?php echo base_url('salary/reportSalaryByMonth'); ?>"><i class="fa fa-list"></i> Tổng kết nhuận bút</a></li>
            <li><a href="<?php echo base_url('salary/newsTypeConfig'); ?>"><i class="fa fa-list"></i> Phân loại bài viết</a></li>
        </ul>
    </li>
    */ ?>
    <?php endif; ?>

    <?php if ($userdata['level'] == 1) : ?>
        <li class="treeview <?php echo ($this->router->class == 'user') ? 'active' : ''; ?>">
            <a href="#">
                <i class="fa fa-users"></i> <span>Quản trị viên</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="<?php echo base_url('user/edit'); ?>"><i class="fa fa-plus"></i> Thêm mới </a></li>
                <li><a href="<?php echo base_url('user'); ?>"><i class="fa fa-list"></i> Danh sách </a></li>
                <?php /*
            <?php if ((int)$userdata['level'] === 1) :?>
            <li><a href="<?php echo base_url('user/user_permission'); ?>"><i class="fa fa-list"></i> Phân quyền </a></li>
            <?php endif; ?>
            */ ?>
            </ul>
        </li>
        <li class="treeview <?php echo (in_array($this->router->class, array('setting', 'banner'))) ? 'active' : ''; ?>">
            <a href="#">
                <i class="fa fa-cog"></i> <span>Cài đặt</span>
                <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a href="/setting/option"><i class="fa fa-angle-double-right"></i> Cài đặt chung </a></li>
                <li><a href="/banner"><i class="fa fa-angle-double-right"></i> Banner </a></li>
                <li><a href="/setting_department"><i class="fa fa-angle-double-right"></i> Danh sách phòng ban </a></li>
                <li><a href="/setting_bussiness"><i class="fa fa-angle-double-right"></i> Lĩnh vực kinh doanh </a></li>
            </ul>

        </li>
    <?php endif; ?>
</ul>