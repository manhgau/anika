<div class="row">
    <div class="col-xs-12">
        <div class="form-group row">
            <div class="col-sm-6">
                <label>Điểm nổi bật</label>
                <input type="text" class="form-control" name="highlight" value="<?php echo $productDetail->highlight; ?>">
            </div>
            <div class="col-sm-3">
                <label>Thời gian book trước <small class="thin">(Ngày)</small></label>
                <input type="number" name="pre_booking_time" class="form-control" value="<?php echo $productDetail->pre_booking_time; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <label>Bao gồm</label>
                <textarea class="form-control pre-wrap" name="included" rows="4"><?php echo $productDetail->included; ?></textarea>
            </div>
            <div class="col-sm-6">
                <label>Không bao gồm</label>
                <textarea class="form-control pre-wrap" name="excluded" rows="4"><?php echo $productDetail->excluded; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <label>Lưu ý</label>
                <textarea class="form-control pre-wrap" name="note" rows="4"><?php echo $productDetail->note; ?></textarea>
            </div>
            
            <div class="col-sm-6">
                <label>Chính sách</label>
                <textarea class="form-control pre-wrap" name="policy" rows="4"><?php echo $productDetail->policy; ?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <p class="col-xs-12"><label>Tiện ích trên xe</label></p>
            <div class="clearfix">
                <?php $arrFeature = explode(',', $productDetail->feature);?>
                <ul class="list-feature-selector list-unstyled">
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="air_condition" <?php if(in_array('air_condition', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('air_condition'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="wifi" <?php if(in_array('wifi', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('wifi'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="tv" <?php if(in_array('tv', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('tv'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="water" <?php if(in_array('water', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('water'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="tea_coffe" <?php if(in_array('tea_coffe', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('tea_coffe'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="trash_bag" <?php if(in_array('trash_bag', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('trash_bag'); ?></label>
                    </li>
                </ul>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-xs-12">Ngôn ngữ</label>
                <?php $arrLangs = explode(',', $productDetail->language); ?>
            <div class="col-xs-6 col-md-4 col-lg-3">
                <label class="thin"><input type="checkbox" class="simple" name="language[]" value="vi" <?php if(in_array('vi', $arrLangs)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('vi'); ?></label>
            </div>
            <div class="col-xs-6 col-md-4 col-lg-3">
                <label class="thin"><input type="checkbox" class="simple" name="language[]" value="en" <?php if(in_array('en', $arrLangs)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('en'); ?></label>
            </div>
            <div class="col-xs-6 col-md-4 col-lg-3">
                <label class="thin"><input type="checkbox" class="simple" name="language[]" value="cn" <?php if(in_array('cn', $arrLangs)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('cn'); ?></label>
            </div>
            <div class="col-xs-6 col-md-4 col-lg-3">
                <label class="thin"><input type="checkbox" class="simple" name="language[]" value="kr" <?php if(in_array('kr', $arrLangs)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('kr'); ?></label>
            </div>
            <div class="col-xs-6 col-md-4 col-lg-3">
                <label class="thin"><input type="checkbox" class="simple" name="language[]" value="jp" <?php if(in_array('jp', $arrLangs)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('jp'); ?></label>
            </div>
            <div class="col-xs-6 col-md-4 col-lg-3">
                <label class="thin"><input type="checkbox" class="simple" name="language[]" value="fr" <?php if(in_array('fr', $arrLangs)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('fr'); ?></label>
            </div>
            <div class="col-xs-6 col-md-4 col-lg-3">
                <label class="thin"><input type="checkbox" class="simple" name="language[]" value="gr" <?php if(in_array('gr', $arrLangs)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('gr'); ?></label>
            </div>
        </div>

        <div class="form-group" id="list-image">
            <label for="tinymce" style="width:100%;">Ảnh sản phẩm <small>(<?php echo PRODUCT_IMAGE_SIZE; ?>)</small> </label> <?php echo my_form_error('content');?>
            <button id="upload" type="button" name="bt_image"><span>Tải ảnh từ máy tính</span></button>
            <p><span id="status"></span></p>
            <div id="display-file">
                <ul class="clearfix list-unstyled">
                    <?php if($listImages) : 
                        ?>
                        <?php 
                                foreach($listImages as $key => $img) : ?>
                                <li>
                                    <img src="<?php echo get_image($img->url);?>" alt="" height="60" style="height:60px;width:auto;margin:1px 0;border:1px solid #eee">
                                    <input type="hidden" name="listImage[]" value="<?php echo $img->id;?>">
                                    <a class="insert_img_content" href="javascript:;" title="Chèn ảnh vào bài viết" data="<?php echo get_image($img->url);?>">Insert</a>
                                    <a class="remove-item fa fa-times" style="color:#d20;" href="javascript:;" title="Xóa ảnh"></a>
                                </li>
                                <?php endforeach; ?>
                        <?php endif; ?>
                    <li class="clear hidden"></li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>

        <div class="form-group">
            <label>Lịch trình/Giới thiệu nhà xe</label>
            <textarea class="form-control" id="tinymce1" name="content"><?php echo $productDetail->content; ?></textarea>
        </div>
        <hr class="line">
        <div class="form-group">
            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Lưu</button>
        </div>
    </div>
</div>