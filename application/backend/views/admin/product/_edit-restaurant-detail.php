<div class="row">
    <div class="col-xs-9">
        <div class="form-group row">
            <div class="col-sm-6 form-group">
                <label>Địa chỉ</label>
                <input class="form-control" name="address" value="<?php echo $productDetail->address;?>">
            </div>
            <div class="col-sm-3 form-group">
                <label>Hotline</label>
                <input class="form-control" name="hotline" value="<?php echo $productDetail->hotline;?>">
            </div>
            <div class="col-sm-3 form-group">
                <label>Email</label>
                <input class="form-control" name="email" value="<?php echo $productDetail->email;?>">
            </div>
            <div class="col-sm-6 form-group">
                <label>Ưu thế địa lý</label>
                <input class="form-control" type="text" name="location_highlight" value="<?php echo $productDetail->location_highlight;?>">
            </div>
            <div class="col-sm-3 form-group">
                <label>Thời gian mở cửa</label>
                <input class="form-control" type="text" name="open_door_time" value="<?php echo $productDetail->open_door_time;?>">
            </div>
            <div class="col-sm-3 form-group">
                <label>Sức chưa tối đa</label>
                <input class="form-control" type="number" name="seat_number" value="<?php echo $productDetail->seat_number;?>">
            </div>
            <div class="col-sm-6 form-group">
                <label>Món độc đáo</label>
                <input class="form-control" type="text" name="highlight" value="<?php echo $productDetail->highlight;?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <label>Menu chung</label>
                <input class="form-control" type="text" name="menu" value="<?php echo $productDetail->menu;?>">
            </div>
            <div class="col-sm-6">
                <label>Thực đơn hôm nay</label>
                <textarea class="form-control pre-wrap" name="included" rows="3"><?php echo $productDetail->included; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <label>Lưu ý</label>
                <textarea class="form-control pre-wrap" name="note" rows="3"><?php echo $productDetail->note; ?></textarea>
            </div>
            
            <div class="col-sm-6">
                <label>Chính sách</label>
                <textarea class="form-control pre-wrap" name="policy" rows="4"><?php echo $productDetail->policy; ?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <p class="col-xs-12"><label>Tính năng/dịch vụ</label></p>
            <div class="clearfix">
                <?php $arrFeatures = explode(',', $productDetail->feature);?>
                <ul class="list-feature-selector list-unstyled">
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="reception" <?php if(in_array('reception', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('reception'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="guard" <?php if(in_array('guard', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('guard'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="parking" <?php if(in_array('parking', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('parking'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="cab" <?php if(in_array('cab', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('cab'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="vip_room" <?php if(in_array('vip_room', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('vip_room'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="vip_area" <?php if(in_array('vip_area', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('vip_area'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="view_room" <?php if(in_array('view_room', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('view_room'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="party_room" <?php if(in_array('party_room', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('party_room'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="has_party" <?php if(in_array('has_party', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('has_party'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="smoking_room" <?php if(in_array('smoking_room', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('smoking_room'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="staff" <?php if(in_array('staff', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('staff'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="pg_wine" <?php if(in_array('pg_wine', $arrFeatures)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('pg_wine'); ?></label>
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
            <label>Giới thiệu nhà hàng</label>
            <textarea class="form-control" id="tinymce1" name="content"><?php echo $productDetail->content; ?></textarea>
        </div>
        <hr class="line">
        <div class="form-group">
            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Lưu</button>
            <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Hủy</button>
        </div>
    </div>
    <div class="col-xs-3">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Cấu hình</h3>
            </div>
            <div class="box-body">
                <label>Thời gian book trước khi sử dụng <small class="thin">(giờ)</small></label>
                <input type="number" name="pre_booking_time" class="form-control" value="<?php echo $productDetail->pre_booking_time; ?>">
            </div>
        </div>
    </div>
</div>