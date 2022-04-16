<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo lang('member_infomation') ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="required">Họ tên</label> <?php echo my_form_error('username');?>
                            <input type="text" class="form-control" id="input-username" required value="<?php echo htmlspecialchars($member->username);?>" name="username">
                        </div> 
                        <div class="form-group">
                            <label for="input-intro">Mô tả ngắn</label> <?php echo my_form_error('intro');?>
                            <textarea name="intro" rows="3" class="form-control" id="input-intro"><?php echo $member->intro;?></textarea>
                        </div>

                        <div class="form-group">
                            <?php echo form_element(['label'=>'Địa chỉ', 'name' => 'address', 'value' => $member->address, 'required'=>true]) ?>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-6">
                                <?php 
                                echo form_element([
                                    'type' => 'select',
                                    'name' => 'province_id',
                                    'value' => $member->province_id,
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
                                    'value' => $member->district_id,
                                    'label' => 'Huyện/quận',
                                    'required' => true,
                                    'options' => toArray($this->location_model->districtSelectOption($member->province_id)),
                                ]);
                                ?>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-6">
                                <?php 
                                echo form_element([
                                    'name' => 'owner_name',
                                    'value' => $member->owner_name,
                                    'label' => 'Họ tên chủ nhà',
                                    'required' => true
                                ]);
                                ?>
                            </div>
                            <div class="col-xs-6">
                                <?php 
                                echo form_element([
                                    'name' => 'owner_phone',
                                    'value' => $member->owner_phone,
                                    'label' => 'Số điện thoại chủ nhà',
                                    'required' => true
                                ]);
                                ?>
                                <span class="text-muted hidden phone-check"></span>
                            </div>
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
                            <textarea name="content" class="form-control" id="tinymce" rows="20"><?php echo $member->content; ?></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php 
                            echo form_hidden('id', $member->id);
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
                            <label><input type="checkbox" class="simple" name="is_public" value="1" <?php echo $member->is_public ? 'checked="checked"' : '' ?>> Công khai</label>
                        </div>
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => 'Mã bài viết',
                                'name' => 'code',
                                'required' => true,
                                'value' => $member->code
                            ]) ?>
                            <span class="hidden code-check text-danger"></span>
                        </div>
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => 'Thời gian bán/cho thuê',
                                'name' => 'service_time',
                                'required' => true,
                                'class' => 'form-control vn-datepicker',
                                'value' => date('d/m/Y', strtotime($member->service_time))
                            ]) ?>
                        </div>
                        <?php 
                            $statusFilter = $this->realnews_model->getStatus();
                            $typeFilter = $this->realnews_model->getType();
                            $serviceFilter = $this->realnews_model->getService();
                        ?>
                        <div class="form-group">
                            <label class="required">Số điểm</label>
                            <input type="number" name="point" value="<?php echo set_value('point', $member->point) ?>" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="required">Giá</label>
                            <input type="text" name="price" id="price-mask" value="<?php echo set_value('price', $member->price) ?>" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="required"><?php echo lang('sale_bonus') ?></label>
                            <input type="text" name="sale_bonus" id="sale_bonus-mask" value="<?php echo set_value('sale_bonus', $member->sale_bonus) ?>" required class="form-control">
                        </div>
                        <div class="form-group">
                            <?php 
                                $allService = $this->realnews_model->getService();
                                $options = ['' => 'chọn dịch vụ'] + array_combine(array_keys($allService), array_column($allService, 'name'));
                                echo form_element([
                                    'name' => 'service_type',
                                    'value' => $member->service_type,
                                    'label' => 'Dịch vụ',
                                    'required' => true,
                                    'type' => 'select',
                                    'options' => $options,
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                $allType = $this->realnews_model->getType();
                                $options = ['' => 'chọn nhóm'] + array_combine(array_keys($allType), array_column($allType, 'name'));
                                echo form_element([
                                    'name' => 'type',
                                    'value' => $member->type,
                                    'label' => 'Nhóm',
                                    'required' => true,
                                    'type' => 'select',
                                    'options' => $options,
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                $allStatus = $this->realnews_model->getStatus();
                                $options = ['' => 'chọn tình trạng'] + array_combine(array_keys($allStatus), array_column($allStatus, 'name'));
                                echo form_element([
                                    'name' => 'status',
                                    'value' => $member->status,
                                    'label' => 'Tình trạng',
                                    'required' => true,
                                    'type' => 'select',
                                    'options' => $options,
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail</label> <?php echo form_error('thumbnail');?>
                            <input id="uploadFile" type="file" name="thumbnail" class="img" id="thumbnail" />
                            <div id="imagePreview" style="background-image: url(<?php echo ($member->thumbnail) ? get_image($member->thumbnail) : '';?>);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>