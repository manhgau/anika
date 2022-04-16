<?php $this->load->view('admin/components/page_head'); ?>
<body class="skin-blue fixed">    
<?php $this->load->view('admin/components/top-menu'); ?>

<div class="wrapper row-offcanvas row-offcanvas-left">
    <?php $this->load->view('admin/components/left-menu.php');?>
    <!-- Main Column -->
    <aside class="right-side">
        <!-- Page Breadcrums -->
        <section class="content-header">
            <h1>
                <?php echo $meta_title; ?>
                <small><?=config_item('site_name');?></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                <?php if(!empty($breadcrumbs)) : foreach($breadcrumbs as $title => $url ) :?>
                <li <?php if(end($breadcrumbs)) echo 'class="active"'?>><a href="<?php echo $url; ?>"><?php echo $title?></a></li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ol>
        </section>
        <div class="alert alert-warning" style="margin:20px">
            <p><?php echo $msg;?>!</p>
        </div>
    </aside>
</div>
<div style="height:40px;background:#3C8DBC;color:rgb(208,208,208);text-align:center;vertical-align:middle;line-height:40px;font-weight:600">
    &copy; Vu Minh - 0984.228.941 - vuminhndvn@gmail.com
</div>
<div id="dialog" title="Basic dialog"></div>
<?php $this->load->view('admin/components/page_js'); ?>
<?php if(isset($sub_js)) $this->load->view($sub_js);?>
<?php $this->load->view('admin/components/page_end');?>
<?php exit();?>
