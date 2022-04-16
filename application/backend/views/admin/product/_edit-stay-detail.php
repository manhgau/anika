<div class="row">
    <div class="col-xs-12">
        <div class="form-group row">
            <div class="col-sm-3">
                <label>Địa chỉ</label>
                <input class="form-control" name="address" value="<?php echo $productDetail->address;?>">
            </div>
            <div class="col-sm-3">
                <label>Hotline</label>
                <input type="text" class="form-control" name="hotline" value="<?php echo $productDetail->hotline;?>">
            </div>
            <div class="col-sm-3">
                <label>Email</label>
                <input type="text" class="form-control" name="email" value="<?php echo $productDetail->email;?>">
            </div>
            <div class="col-sm-3">
                <label>Thời gian book trước <small class="thin">(Giờ)</small></label>
                <input type="number" name="pre_booking_time" class="form-control" value="<?php echo $productDetail->pre_booking_time; ?>">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <label>Ưu thế địa lý</label>
                <input type="text" class="form-control" name="location_highlight" value="<?php echo $productDetail->location_highlight; ?>">
            </div>
            <div class="col-sm-6">
                <label>Điểm nổi bật</label>
                <input type="text" class="form-control" name="highlight" value="<?php echo $productDetail->highlight; ?>">
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
            <p class="col-xs-12"><label>Tiện ích chung</label></p>
            <div class="clearfix">
                <?php $arrFeature = explode(',', $productDetail->feature);?>
                <ul class="list-feature-selector list-unstyled">
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="reception" <?php if(in_array('reception', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('reception'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="secure" <?php if(in_array('secure', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('secure'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="bell_man" <?php if(in_array('bell_man', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('bell_man'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="parking" <?php if(in_array('parking', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('parking'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="bar" <?php if(in_array('bar', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('bar'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="restaurant" <?php if(in_array('restaurant', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('restaurant'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="spa" <?php if(in_array('spa', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('spa'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="gym" <?php if(in_array('gym', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('gym'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="pool" <?php if(in_array('pool', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('pool'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="meeting_room" <?php if(in_array('meeting_room', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('meeting_room'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="photocopy" <?php if(in_array('photocopy', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('photocopy'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="projector" <?php if(in_array('projector', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('projector'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="travel_office" <?php if(in_array('travel_office', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('travel_office'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="transport" <?php if(in_array('transport', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('transport'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="cab" <?php if(in_array('cab', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('cab'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="party" <?php if(in_array('party', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('party'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="smoking_room" <?php if(in_array('smoking_room', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('smoking_room'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="currency_exchange" <?php if(in_array('currency_exchange', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('currency_exchange'); ?></label>
                    </li>
                </ul>
            </div>
        </div>

        <div class="form-group row">
            <p class="col-xs-12"><label>Tiện ích trong phòng</label></p>
            <div class="clearfix">
                <?php $arrFeature = explode(',', $productDetail->room_feature);?>
                <ul class="list-feature-selector list-unstyled">
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="air_condition" <?php if(in_array('air_condition', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('air_condition'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="wifi" <?php if(in_array('wifi', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('wifi'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="minibar" <?php if(in_array('minibar', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('minibar'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="tv" <?php if(in_array('tv', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('tv'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="roaming" <?php if(in_array('roaming', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('roaming'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="water" <?php if(in_array('water', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('water'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="tea_coffe" <?php if(in_array('tea_coffe', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('tea_coffe'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="closet" <?php if(in_array('closet', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('closet'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="hair_dryer" <?php if(in_array('hair_dryer', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('hair_dryer'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="sandal" <?php if(in_array('sandal', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('sandal'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="sampoo" <?php if(in_array('sampoo', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('sampoo'); ?></label>
                    </li>
                    <li class="col-xs-6 col-md-4 col-lg-3">
                        <label class="thin"><input type="checkbox" class="simple" name="feature[]" value="soap" <?php if(in_array('soap', $arrFeature)) echo 'checked="checked"'; ?>> <?php echo $this->lang->line('soap'); ?></label>
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

        <div class="form-group">
            <label>Giới thiệu khách sạn</label>
            <textarea class="form-control" id="tinymce1" name="content"><?php echo $productDetail->content; ?></textarea>
        </div>
        <hr class="line">
        <div class="form-group">
            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Lưu</button>
        </div>
    </div>
</div>