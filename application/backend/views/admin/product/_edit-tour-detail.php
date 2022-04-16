<div class="row">
    <div class="col-xs-12">
        <div class="form-group row">
            <div class="col-sm-3">
                <label>Số ngày Tour</label>
                <input class="form-control" name="duration" value="<?php echo $productDetail->duration;?>">
            </div>
            <div class="col-sm-3">
                <label>Lịch khởi hành</label>
                <input type="text" class="form-control" name="start_time" value="<?php echo ($product->start_time) ? date('Y-m-d', strtotime($product->start_time)) : '';?>">
            </div>
            <div class="col-sm-3">
                <label>Thời gian book trước <small class="thin">(ngày)</small></label>
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
            <p class="col-xs-12"><label>Phương tiện di chuyển</label></p>
            <div class="clearfix">
                <?php $arrTransType = explode(',', $productDetail->transfer_type);?>
                <ul class="list-feature-selector list-unstyled">
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="transfer_type[]" value="car" <?php if(in_array('car', $arrTransType)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('car'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="transfer_type[]" value="train" <?php if(in_array('train', $arrTransType)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('train'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="transfer_type[]" value="bike" <?php if(in_array('bike', $arrTransType)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('bike'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="transfer_type[]" value="motorbike" <?php if(in_array('motorbike', $arrTransType)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('motorbike'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="transfer_type[]" value="fly" <?php if(in_array('fly', $arrTransType)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('fly'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="transfer_type[]" value="ship" <?php if(in_array('ship', $arrTransType)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('ship'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="transfer_type[]" value="walk" <?php if(in_array('walk', $arrTransType)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('walk'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="transfer_type[]" value="cruise" <?php if(in_array('cruise', $arrTransType)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('cruise'); ?></label>
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

        <div class="form-group">
            <label>Lịch trình tour</label>
            <textarea class="form-control" id="tinymce1" name="content"><?php echo $productDetail->content; ?></textarea>
        </div>
        <hr class="line">
        <div class="form-group">
            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Lưu</button>
        </div>
    </div>
</div>