<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Nội dung bài viết</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="text-primary">ID chủ nhà</label> <?php echo my_form_error('title');?>
                            <?php 
                            $prepopulate = [];
                            if ($news->member_id) {
                                $member = $this->member_model->get($news->member_id, true);
                                $prepopulate[] = [
                                    'id' => $member->id,
                                    'name' => $member->fullname
                                ];
                            }
                            echo tokeninput('member_id', '/member/tokenSearch', 1, $prepopulate, 'token-member_id');
                            ?>
                        </div> 
                        <div class="form-group">
                            <label class="required">Tiêu đề</label> <?php echo my_form_error('title');?>
                            <input type="text" class="form-control" id="input-title" required value="<?php echo htmlspecialchars($news->title);?>" name="title">
                        </div> 
                        <div class="form-group">
                            <label class="required">Mô tả ngắn</label> <?php echo my_form_error('intro');?>
                            <textarea name="intro" rows="3" class="form-control" id="input-intro"><?php echo $news->intro;?></textarea>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-6">
                                <?php 
                                echo form_element([
                                    'type' => 'select',
                                    'name' => 'province_id',
                                    'value' => $news->province_id,
                                    'label' => 'Tỉnh/thành',
                                    'required' => true,
                                    'options' => toArray($this->location_model->provinceSelectOption()),
                                ]);
                                ?>
                            </div>
                            <div class="col-xs-6">
                                <?php 
                                echo form_element([
                                    'type' => 'select',
                                    'name' => 'district_id',
                                    'value' => $news->district_id,
                                    'label' => 'Huyện/quận',
                                    'required' => true,
                                    'options' => toArray($this->location_model->districtSelectOption($news->province_id)),
                                ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo form_element(['label'=>'Địa chỉ', 'name' => 'address', 'value' => $news->address, 'required'=>true]) ?>
                            <span class="text-muted hidden address-check"></span>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-6">
                                <?php 
                                echo form_element([
                                    'name' => 'owner_name',
                                    'value' => $news->owner_name,
                                    'label' => 'Họ tên chủ nhà',
                                    'required' => true
                                ]);
                                ?>
                            </div>
                            <div class="col-xs-6">
                                <?php 
                                echo form_element([
                                    'name' => 'owner_phone',
                                    'value' => $news->owner_phone,
                                    'label' => 'Số điện thoại chủ nhà',
                                    'required' => true
                                ]);
                                ?>
                                <span class="text-muted hidden phone-check"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo form_element([
                                'name' => 'fb_page_url', 
                                'value' => $news->fb_page_url, 
                                'type' => 'url',
                                'label' => lang('fb_page_url'),
                            ]) ?>
                        </div>

                        <div class="form-group" id="list-image">
                            <label for="tinymce" style="width:100%;"> Nội dung bài viết </label> <?php echo my_form_error('content');?>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p>
                                        <button id="upload" type="button" name="bt_image"><span>Tải ảnh</span></button>
                                     hoặc <button id="upload-copyright" type="button" name="bt_image"><span>Tải ảnh và chèn logo</span></button> <small>(640x***)</small>
                                    </p>
                                    <p><span id="status"></span><span id="status-copyright"></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <style type="text/css">#display-file img{width:60px!important;height:40px!important}</style>
                                <div id="display-file">
                                        <ul>
                                            <?php if(isset($product_images)) : 
                                                    $_img_order = explode('#',$product_detail->list_image);
                                                ?>
                                                <?php 
                                                    foreach ($_img_order as $_order) :
                                                        foreach($product_images as $key => $img) : if($img->id == $_order) : ?>
                                                        <li>
                                                            <img src="<?=$img->url;?>" alt="" height="40" style="height:40px;width:auto;margin:1px 0;border:1px solid #eee">
                                                            <input type="hidden" name="listImage[]" value="<?=$img->id;?>">
                                                            <a class="insert_img_content" data="<?=$img->url;?>">Insert</a>
                                                        </li>
                                                        <?php endif; endforeach; endforeach; ?>
                                                <?php endif; ?>
                                            <li class="clear hidden"></li>
                                        </ul>
                                    </div>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <textarea name="content" class="form-control" id="tinymce" rows="20"><?php echo $news->content; ?></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php 
                            echo form_hidden('id', $news->id);
                            echo form_submit('publish','Cập nhật','class="btn btn-success"');
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Thông tin</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label><input type="checkbox" class="simple" name="is_public" value="1" <?php echo $news->is_public ? 'checked="checked"' : '' ?>> Công khai</label>
                        </div>
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => 'Mã bài viết',
                                'name' => 'code',
                                'required' => true,
                                'value' => $news->code
                            ]) ?>
                            <span class="hidden code-check text-danger"></span>
                        </div>
                        <?php 
                            $statusFilter = $this->realnews_model->getStatus();
                            $typeFilter = $this->realnews_model->getType();
                            $serviceFilter = $this->realnews_model->getService();
                            $rentTimeFilter = $this->realnews_model->getRentTime();
                        ?>
                        <div class="form-group">
                            <label class="required"><?php echo lang('point_number') ?></label>
                            <input type="number" name="point" value="<?php echo set_value('point', $news->point) ?>" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Giá bán</label>
                            <div class="input-group">
                                <input type="number" name="price" min="0" step="0.01" class="form-control" value="<?php echo set_value('price', $news->price/TYDONG) ?>" placeholder="ví dụ: 1.2">
                                <span class="input-group-addon" id="basic-addon2">Tỷ</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Giá thuê theo giờ</label>
                            <div class="input-group">
                                <input type="number" name="rent_price_hour" min="0" step="0.01" class="form-control" value="<?php echo set_value('rent_price_hour', $news->rent_price_hour/TRIEUDONG) ?>" placeholder="ví dụ: 0.15">
                                <span class="input-group-addon" id="basic-addon2">Triệu</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Giá thuê theo ngày</label>
                            <div class="input-group">
                                <input type="number" name="rent_price_day" min="0" step="0.01" class="form-control" value="<?php echo set_value('rent_price_day', $news->rent_price_day/TRIEUDONG) ?>" placeholder="ví dụ: 0.6">
                                <span class="input-group-addon" id="basic-addon2">Triệu</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Giá thuê theo tháng</label>
                            <div class="input-group">
                                <input type="number" name="rent_price_month" min="0" step="0.01" class="form-control" value="<?php echo set_value('rent_price_month', $news->rent_price_month/TRIEUDONG) ?>" placeholder="ví dụ: 8.5">
                                <span class="input-group-addon" id="basic-addon2">Triệu</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php 
                                $allStatus = $this->realnews_model->getStatus();
                                $options = ['' => '--- chọn ---'] + array_combine(array_keys($allStatus), array_column($allStatus, 'name'));
                                echo form_element([
                                    'name' => 'status',
                                    'value' => $news->status,
                                    'label' => 'Tình trạng',
                                    'required' => true,
                                    'type' => 'select',
                                    'options' => $options,
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => lang('rent_enddate'),
                                'name' => 'rent_enddate',
                                'autocomplete' => 'off',
                                'class' => 'form-control vn-datepicker',
                                'value' => ($news->rent_enddate) ? date('d/m/Y',  strtotime($news->rent_enddate)) : ''
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <label class="required"><?php echo lang('sale_bonus') ?></label>
                            <div class="input-group">
                                <input type="number" name="sale_bonus" min="0" step="0.01" class="form-control" value="<?php echo set_value('sale_bonus', $news->sale_bonus/TRIEUDONG) ?>" placeholder="ví dụ: 1.5">
                                <span class="input-group-addon" id="basic-addon2">Triệu</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php 
                                $allType = $this->realnews_model->getType();
                                $options = ['' => 'chọn nhóm'] + array_combine(array_keys($allType), array_column($allType, 'name'));
                                echo form_element([
                                    'name' => 'type',
                                    'value' => $news->type,
                                    'label' => 'Loại nhà',
                                    'required' => true,
                                    'type' => 'select',
                                    'options' => $options,
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo form_element([
                                    'name' => 'bedroom_number',
                                    'value' => $news->bedroom_number,
                                    'label' => lang('bedroom_number'),
                                    'type' => 'number',
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo form_element([
                                    'name' => 'floor_number',
                                    'value' => $news->floor_number,
                                    'label' => lang('floor_number'),
                                    'type' => 'number',
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo form_element([
                                    'name' => 'acreage',
                                    'value' => $news->acreage,
                                    'label' => lang('acreage'),
                                    'type' => 'number',
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail</label> <?php echo form_error('thumbnail');?>
                            <input id="uploadFile" type="file" name="thumbnail" class="img" id="thumbnail" />
                            <div id="imagePreview" style="background-image: url(<?php echo ($news->thumbnail) ? get_image($news->thumbnail) : '';?>);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>