<?= form_hidden('news_code', $code); ?>
<!-- =-=-=-=-=-=-= Main Area =-=-=-=-=-=-= -->
<div class="main-content-area">
    <!-- =-=-=-=-=-=-= Page Breadcrumb =-=-=-=-=-=-= -->
    <section class="page-title">
        <div class="container">
            <h1><?php echo $news['title'] ?></h1>
        </div>
        <!-- end container -->
    </section>

    <!-- =-=-=-=-=-=-= Page Breadcrumb End =-=-=-=-=-=-= -->

    <!-- =-=-=-=-=-=-= Blog & News =-=-=-=-=-=-= -->
    <section id="blog" class="custom-padding white" style="padding:30px 0 50px 0">
        <div class="container">
            <?php if ($news['is_bought'] == false): ?>
                <?php $this->load->view('home/home/inc-news-intro', ['news' => (object)$news]); ?>
            <?php else: ?>
                <!-- Row -->
                <div class="row">
                    <!-- Left Side Content -->
                    <div class="col-sm-12 col-xs-12 col-md-8">
                        <!-- Blog Grid -->
                        <div class="blog-detial">
                            <div class="blog-image"><img alt="blog-image1" class="img-responsive" src="<?php echo getImageUrl($news['thumbnail']) ?>" /></div>
                            <div class="blog-content">
                                <strong><?php echo $news['intro'] ?></strong>
                            </div>
                            <?php echo $news['content'] ?>
                            <div class="clearfix"></div>
                        </div>

                        <!-- Blog Grid -->

                        <div class="clearfix"></div>
                        <!-- Pagination End -->
                    </div>
                    <!-- Left Content End -->

                    <!-- Blog Right Sidebar -->
                    <div class="col-sm-12 col-xs-12 col-md-4">
                        <!-- sidebar -->
                        <div class="side-bar">
                            <ul class="list-group">
                                <li class="list-group-item">Dịch vụ: <strong><?php echo implode(', ', $news['service_type_name']) ?></strong></li>
                                <?php if ($news['price']): ?>
                                <li class="list-group-item">Giá bán: <strong class="text-danger"><?php echo number_format($news['price']) ?></strong></li>
                                <?php endif ?>

                                <?php if ($news['rent_price_hour']): ?>
                                <li class="list-group-item"><?php echo lang('rent_price_hour') ?>: <strong class="text-danger"><?php echo number_format($news['rent_price_hour']) ?></strong></li>
                                <?php endif ?>

                                <?php if ($news['rent_price_day']): ?>
                                <li class="list-group-item"><?php echo lang('rent_price_day') ?>: <strong class="text-danger"><?php echo number_format($news['rent_price_day']) ?></strong></li>
                                <?php endif ?>

                                <?php if ($news['rent_price_month']): ?>
                                <li class="list-group-item"><?php echo lang('rent_price_month') ?>: <strong class="text-danger"><?php echo number_format($news['rent_price_month']) ?></strong></li>
                                <?php endif ?>

                                <li class="list-group-item">Chủ nhà: <strong><?php echo mb_strtoupper($news['owner_name']) ?></strong></li>
                                <li class="list-group-item">Số điện thoại: <strong><?php echo $news['owner_phone'] ?></strong></li>
                                <li class="list-group-item">Địa chỉ: <strong><?php echo $news['address'] ?></strong></li>
                                <li class="list-group-item">Loại nhà: <strong><?php echo $news['type_name'] ?></strong></li>
                                <li class="list-group-item">PN: <strong><?php echo @$news['bed_room'] ?></strong></li>
                                <li class="list-group-item">Hoa hồng: <strong class="text-primary"><?php echo number_format($news['sale_bonus']) ?></strong></li>
                            </ul>
                            
                        </div>
                        <!-- sidebar end -->
                    </div>
                    <!-- Blog Right Sidebar End -->
                </div>

            <?php endif ?>
            <!-- Row End -->
        </div>
        <!-- end container -->
    </section>
    <!-- =-=-=-=-=-=-= Blog & News end =-=-=-=-=-=-= -->
</div>
<!-- =-=-=-=-=-=-= Main Area End =-=-=-=-=-=-= -->