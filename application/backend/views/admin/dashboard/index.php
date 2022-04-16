<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <section class="content">
            <style type="text/css">.small-box > .inner{padding:0 10px}</style>

            <div class="row">
                <h2 class="page-header">Bài viết của tôi</h2>
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <p>
                                Tất cả: <strong style="font-size:1.4em"><?php echo $newsReport['myNews']; ?></strong>
                            </p>
                        </div>
                        <a href="<?php echo base_url('news/myNews'); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <p>
                                Đã duyệt: <strong style="font-size:1.4em"><?php echo $newsReport['myNewsApproved']; ?></strong>
                            </p>
                        </div>
                        <a href="<?php echo base_url('news/myNews?status=1'); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <p>
                                Chờ duyệt: <strong style="font-size:1.4em"><?php echo $newsReport['myNewsPending']; ?></strong>
                            </p>
                        </div>
                        <a href="<?php echo base_url('news/myNews?status=2'); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <p>
                                Đang viết: <strong style="font-size:1.4em"><?php echo $newsReport['myNewsWritting']; ?></strong>
                            </p>
                        </div>
                        <a href="<?php echo base_url('news/myNews?status=4'); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-black">
                        <div class="inner">
                            <p>
                                Bị trả lại: <strong style="font-size:1.4em"><?php echo $newsReport['myNewsReturn']; ?></strong>
                            </p>
                        </div>
                        <a href="<?php echo base_url('news/myNews?status=5'); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <p>
                                Thùng rác: <strong style="font-size:1.4em"><?php echo $newsReport['myNewsTrash']; ?></strong>
                            </p>
                        </div>
                        <a href="<?php echo base_url('news/myNews?status=3'); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            </section>
            <!-- /.row -->


            <div class="box">
                <div class="box-body table-responsive">
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title" style="background: #3c8dbc;color: #fff;display: block;width: 100%;"> <i class="fa fa-fire" style="color:#f0a049"></i> Từ khóa hot trong ngày</h3>
                            </div>
                            <div class="box-body" style="height:320px;overflow:hidden;position:relative">
                                <iframe scrolling="no" style="border:none;width:100%;position:absolute;top:0px;left:0" height="350" src="https://www.google.com/trends/hottrends/widget?pn=p28&amp;tn=20&amp;h=350"></iframe>
                            </div>
                        </div>
                    </div>
                    <?php if($userdata['level'] <= 2) : ?>
                        <?php if (isset($host_orders) && $host_orders): ?>
                        <div class="col-md-4">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title" style="background: #3c8dbc;color: #fff;display: block;width: 100%;"><a href="<?php echo base_url('setting/home_feature');?>" style="color:#FFF"><i class="fa fa-file-text-o" style="color:#f0a049"></i> Tin HOT</a></h3>
                                </div>
                                <div class="box-body" style="height:320px;overflow-y:scroll;position:relative">
                                    <ul class="list-news-trending">
                                        <?php foreach($host_orders as $_id) : $val=$hot_news[$_id]; ?>
                                            <li><a href="#"><?php echo $val->title;?></a></li>
                                            <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php if (isset($popular_news) && $popular_news): ?>
                        <div class="col-md-4">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title" style="background: #3c8dbc;color: #fff;display: block;width: 100%;"> <i class="fa fa-file-text-o" style="color:#f0a049"></i> Bài đọc nhiều</h3>
                                </div>
                                <div class="box-body" style="height:320px;overflow-y:scroll;position:relative">
                                    <ul class="list-news-trending">
                                        <?php foreach($popular_news as $key => $val) : ?>
                                            <li><a href="#"><?php echo $val->title;?></a></li>
                                            <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php endif; ?>
                    <div class="clear"></div>
                </div>
                <div class="box-body table-responsive">
                    <?php if($userdata['level'] <= 2) : ?>
                        <?php if (isset($editor_choise) && $editor_choise): ?>
                        <div class="col-md-4">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title" style="background: #3c8dbc;color: #fff;display: block;width: 100%;"> <a href="<?php echo base_url('setting/editor_choise');?>" style="color:#fff"><i class="fa fa-fire" style="color:#f0a049"></i> Nên đọc</a> </h3>
                                </div>
                                <div class="box-body" style="height:320px;overflow-y:scroll;position:relative">
                                    <?php if($editor_choise) :?>
                                        <ul class="list-news-trending">
                                            <?php  foreach($editor_choise as $key => $val) : ?>
                                                <li><a href="#"><?php echo $val->title;?></a></li>
                                                <?php endforeach; ?>
                                        </ul>
                                        <?php else:?>
                                        <div class="alert alert-warning">Chưa có bài viết nào!</div>
                                        <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    <?php if($userdata['level'] <= 2) : ?>
                        <?php if (isset($home_news) && $home_news): ?>
                        <div class="col-md-4">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title" style="background: #3c8dbc;color: #fff;display: block;width: 100%;"> <a href="<?php echo base_url('setting/home_news');?>" style="color:#fff"><i class="fa fa-fire" style="color:#f0a049"></i> Tin nổi bật</a> </h3>
                                </div>
                                <div class="box-body" style="height:320px;overflow-y:scroll;position:relative">
                                    <?php if($home_news) :?>
                                        <ul class="list-news-trending">
                                            <?php  foreach($home_news as $key => $val) : ?>
                                                <li><a href="#"><?php echo $val->title;?></a></li>
                                                <?php endforeach; ?>
                                        </ul>
                                        <?php else:?>
                                        <div class="alert alert-warning">Chưa có bài viết nào!</div>
                                        <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    <?php if($userdata['level'] <= 2) : ?>
                        <?php if (isset($static_lastest_news) && $static_lastest_news): ?>
                        <div class="col-md-4 hidden">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title" style="background: #3c8dbc;color: #fff;display: block;width: 100%;"> <a href="<?php echo base_url('setting/static_lastest_news');?>" style="color:#fff"><i class="fa fa-fire" style="color:#f0a049"></i> Ẩn khỏi box-Tin mới - Trang chủ</a> </h3>
                                </div>
                                <div class="box-body" style="height:320px;overflow-y:scroll;position:relative">
                                    <?php if($static_lastest_news) :?>
                                        <ul class="list-news-trending">
                                            <?php  foreach($static_lastest_news as $key => $val) : ?>
                                                <li><a href="#"><?php echo $val->title;?></a></li>
                                                <?php endforeach; ?>
                                        </ul>
                                        <?php else:?>
                                        <div class="alert alert-warning">Chưa có bài viết nào!</div>
                                        <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    <div class="clear"></div>
                </div>
                <div class="box-body table-responsive hidden">
                    <?php if($userdata['level'] <= 2) : ?>
                        <?php if (isset($static_videos) && $static_videos): ?>
                        <div class="col-md-4">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title" style="background: #3c8dbc;color: #fff;display: block;width: 100%;"> <a href="<?php echo base_url('setting/static_videos');?>" style="color:#fff"><i class="fa fa-fire" style="color:#f0a049"></i> Box Truyền Hình</a> </h3>
                                </div>
                                <div class="box-body" style="height:320px;overflow-y:scroll;position:relative">
                                    <?php if($static_videos) :?>
                                        <ul class="list-news-trending">
                                            <?php  foreach($static_videos as $key => $val) : ?>
                                                <li><a href="#"><?php echo $val->title;?></a></li>
                                                <?php endforeach; ?>
                                        </ul>
                                        <?php else:?>
                                        <div class="alert alert-warning">Chưa có bài viết nào!</div>
                                        <?php endif;?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</section>