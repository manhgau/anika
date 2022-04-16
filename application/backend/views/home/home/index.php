<!-- =-=-=-=-=-=-= Main Area =-=-=-=-=-=-= -->
<div class="main-content-area">
    <section class="white question-tabs" id="latest-post">
        <div class="container">
            <div class="row">
                <!-- Content Area Bar -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#tab1"><i class="icofont icon-ribbon"></i><strong class="">Chính chủ</strong></a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#tab2"><i class="icofont icon-global"></i><strong class="">Duyệt bài</strong></a>
                                </li>
                                <li class="">
                                    <a data-toggle="tab" href="#tab3"><i class="icofont icon-layers"></i><strong class=""><?php echo lang('refund_point') ?></strong></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- =-=-=-=-=-=-= Main Area End =-=-=-=-=-=-= -->

<!-- =-=-=-=-=-=-= HOME =-=-=-=-=-=-= -->
<?php $headerBg = @array_shift($this->banner_model->get_banner_by_group(1)); ?>
<?php if ($headerBg): ?>
<div class="full-section search-section" style="background-image: url('<?php echo getImageUrl($headerBg->image) ?>'); background-size: cover;">
<?php else: ?>
<div class="full-section search-section">
<?php endif ?>
    <div class="tab-content">
        <div id="tab1" class="tab-pane active">
            <div class="search-area container">
                <h3 class="search-title">Bạn muốn xem bài viết nào?</h3>
                <p class="search-tag-line">Nhập mã bài viết để xem chi tiết</p>
                    <div class="row">
                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                            <form autocomplete="off" method="get" class="search-form clearfix" id="search-form">
                                <div class="form-group">
                                    <input type="text" placeholder="Nhập mã bài viết" class="search-term form-control" autocomplete="off" value="" required="" name="code">
                                    <input type="submit" value="Xem chi tiết" class="search-btn" />
                                </div>
                            </form>
                            <div class="panel panel-default" id="news-intro" style="margin-top: 20px;border:none">
                                <div class="panel-body">
                                    <ul class="list-group bg-white text-left" style="margin-bottom:0">
                                        <li class="list-group-item"><?php echo lang('point_number') ?>: <strong class="text-danger text-xl"></strong></li>
                                        <li class="list-group-item"><?php echo lang('service_type') ?>: <strong class="text-danger text-xl"></strong></li>
                                        <li class="list-group-item"><?php echo lang('type') ?>: <strong class="text-danger text-xl"></strong></li>
                                        <li class="list-group-item">Địa chỉ: </li>
                                        <li class="list-group-item">Số điện thoại chủ nhà: </li>
                                        <li class="list-group-item">Link bài viết: </li>
                                        <li class="text-center list-group-item"><button class="btn btn-danger">Lấy SĐT</button></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div id="tab2" class="tab-pane">
            <div class="search-area container bg-white">
                <h3 class="search-title" style="color: #333;">Duyệt bài</h3>
                <p class="search-tag-line" style="color: #333;">Hãy để Sari lan tỏa thông tin bất động sản của bạn đến nhiều người trong cộng đồng hơn</p>
                <form autocomplete="off" method="post" class="search-form clearfix" id="post-form" style="text-align: left;">
                    <div class="form-group">
                        <label class="required">Link bài đăng Facebook</label>
                        <input type="url" placeholder="" name="url" class="form-control" required="">
                    </div>
                    <div class="form-group text-left">
                        <label class="required">Tiêu đề</label>
                        <input type="text" placeholder="Tiêu đề" name="title" class="form-control" required="">
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12 col-md-6">
                            <label class="required"><?php echo lang('owner_name') ?></label>
                            <input type="text" placeholder="<?php echo lang('owner_name') ?>" name="owner_name" class="form-control text-uppercase" required="">
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label class="required"><?php echo lang('owner_phone') ?></label>
                            <input type="number" placeholder="<?php echo lang('owner_phone') ?>" name="owner_phone" class="form-control" required="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label class="required"><?php echo lang('province') ?></label>

                            <?php $options = $this->location_model->provinceSelectOption('chọn tỉnh/thành') ?>
                            <?php echo form_dropdown('province_id', $options, '', 'class="form-control" required'); ?>
                        </div>
                        <div class="form-group col-xs-6">
                            <label class="required"><?php echo lang('district') ?></label>
                            <?php $options = ['' => '--- chọn huyện/quận ---'] ?>
                            <?php echo form_dropdown('district_id', $options, '', 'class="form-control" required'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="required"><?php echo lang('address') ?></label>
                        <input type="text" placeholder="<?php echo lang('address') ?>" name="address" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label class="required"><?php echo lang('intro') ?></label>
                        <?php echo form_textarea([
                            'name' => 'intro',
                            'required' => true,
                            'rows' => 3,
                            'placeholder' => 'Giới thiệu ngắn',
                            'class' => 'form-control',
                        ]); ?>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12 col-md-6">
                            <label><?php echo lang('price'); ?></label>
                            <div class="input-group">
                                <input type="number" name="price" min="0" step="0.01" class="form-control" value="" placeholder="ví dụ: 1.2">
                                <span class="input-group-addon" id="basic-addon2">Tỷ</span>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label><?php echo lang('rent_price_hour'); ?></label>
                            <div class="input-group">
                                <input type="number" name="rent_price_hour" min="0" step="0.01" class="form-control" value="" placeholder="ví dụ: 0.15">
                                <span class="input-group-addon" id="basic-addon2">Triệu</span>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label><?php echo lang('rent_price_day'); ?></label>
                            <div class="input-group">
                                <input type="number" name="rent_price_day" min="0" step="0.01" class="form-control" value="" placeholder="ví dụ: 0.6">
                                <span class="input-group-addon" id="basic-addon2">Triệu</span>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <label><?php echo lang('rent_price_month'); ?></label>
                            <div class="input-group">
                                <input type="number" name="rent_price_month" min="0" step="0.01" class="form-control" value="" placeholder="ví dụ: 8.5">
                                <span class="input-group-addon" id="basic-addon2">Triệu</span>
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-6">
                            <?php 
                                $allStatus = $this->realnews_model->getStatus();
                                $options = ['' => '--- chọn ---'] + array_combine(array_keys($allStatus), array_column($allStatus, 'name'));
                                echo form_element([
                                    'name' => 'status',
                                    'value' => '',
                                    'label' => 'Tình trạng',
                                    'required' => true,
                                    'type' => 'select',
                                    'options' => $options,
                                ]);
                            ?>
                        </div>
                        <div class="col-md-6 form-group">
                            <?php 
                                $allType = $this->realnews_model->getType();
                                $options = ['' => 'chọn nhóm'] + array_combine(array_keys($allType), array_column($allType, 'name'));
                                echo form_element([
                                    'name' => 'type',
                                    'value' => '',
                                    'label' => lang('type'),
                                    'required' => true,
                                    'type' => 'select',
                                    'options' => $options,
                                ]);
                            ?>
                        </div>
                        <div class="col-xs-4 form-group">
                            <?php 
                                echo form_element([
                                    'name' => 'acreage',
                                    'label' => lang('acreage'),
                                    'type' => 'number',
                                ]);
                            ?>
                        </div>
                        <div class="col-xs-4 form-group">
                            <?php 
                                echo form_element([
                                    'name' => 'bedroom_number',
                                    'label' => lang('bedroom_number'),
                                    'type' => 'number',
                                ]);
                            ?>
                        </div>
                        <div class="col-xs-4 form-group">
                            <?php 
                                echo form_element([
                                    'name' => 'floor_number',
                                    'label' => lang('floor_number'),
                                    'type' => 'number',
                                ]);
                            ?>
                        </div>
                        <div class="col-xs-6 form-group">
                            <label class="required"><?php echo lang('point') ?></label>
                            <?php $priceOpts = $this->realnews_model->publishPrice() ?>
                            <select name="point" class="form-control" required>
                                <?php foreach ($priceOpts as $key => $price): ?>
                                <option value="<?php echo $price ?>"><?php echo $price, ' ', lang('point'); ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-xs-6 form-group">
                            <label class="required"><?php echo lang('sale_bonus') ?></label>
                            <div class="input-group">
                                <input type="number" name="sale_bonus" min="0" step="0.01" class="form-control" value="" placeholder="ví dụ: 1.5">
                                <span class="input-group-addon" id="basic-addon2">Triệu</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group search-tag-line bg-warning text-danger" style="padding-top:20px;padding-bottom: 20px; text-align: center;">
                        <p>Yêu cầu của bạn sẽ được tính phí <strong id="point-fee"></strong></p>
                        <p>Bài viết của bạn sẽ được xét duyệt và chỉnh sửa trước khi được đăng trên nhóm của chúng tôi</p>
                    </div>
                    <div class="text-center"><button class="btn btn-danger">Duyệt bài <i class="fa fa-plane"></i></button></div>
                </form>
            </div>
        </div>
        <div id="tab3" class="tab-pane">
            <div class="search-area container">
                <h3 class="search-title"><?php echo lang('refund_point') ?></h3>
                <p class="search-tag-line"><?php echo lang('refund_point_desc') ?></p>
                <form autocomplete="off" method="post" class="search-form clearfix" id="refund-form">
                    <div class="form-group">
                        <input type="text" placeholder="Mã bài viết" id="name" name="code" class="form-control" required="">
                    </div>
                    <div class="form-group hidden">
                        <input type="url" placeholder="Link bài viết" id="email" name="url" class="form-control">
                    </div>
                    <div class="form-group">
                        <textarea cols="12" rows="2" placeholder="Lý do..." id="message" name="note" class="form-control" required=""></textarea>
                    </div>
                    <button class="btn btn-danger">Gửi yêu cầu <i class="fa fa-plane"></i></button>
                </form>
            </div>
        </div>
    </div>
    
</div>
<!-- =-=-=-=-=-=-= HOME END =-=-=-=-=-=-= -->
<section id="social-media">
    <div class="block no-padding">
        <div class="row">
            <div class="col-md-12">
                <div class="social-bar">
                    <ul>
                        <?php $pages = json_decode(siteOption('facebook_page'), true); ?>
                        <?php foreach ($pages as $key => $value): ?>
                        <li class="<?php echo 'social' . (++$key) ?>">
                            <a title="Facebook Page" href="<?php echo trim($value['url']); ?>" target="_blank">
                                <img alt="" src="/public/assets/home/images/facebook.png" /> <span><?php echo trim($value['name']) ?></span>
                            </a>
                        </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>