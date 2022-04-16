<div class="panel-body">
    <form action="" id="product-intro-form">
    <div class="row">
        <div class="col-md-9 col-xs-12">
            <div class="form-group">
                <label>Tên sản phẩm/dịch vụ</label>
                <input type="text" name="title" required="required" class="form-control" value="<?php echo $product->title; ?>">
            </div>
            <div class="form-group">
                <label>Mô tả ngắn</label>
                <textarea id="editor-2" name="description" class="form-control"><?php echo $product->description; ?></textarea>
            </div>
            <div class="form-group row">
                <div class="col-xs-12 col-md-4">
                    <label>Quốc gia</label>
                    <input type="text" class="form-control" name="country_id" id="token-country">
                </div>
                <div class="col-xs-12 col-md-4">
                    <label>Tỉnh thành</label>
                    <input type="text" class="form-control " name="province_id" id="token-province">
                </div>
                <div class="col-xs-12 col-md-4">
                    <label>Điểm tham quan</label>
                    <input type="text" class="form-control" name="location_id" id="token-location">
                </div>
            </div>
            <hr class="line">
            <div class="form-group">
                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Lưu</button>
                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Hủy</button>
            </div>
        </div>
        <div class="col-md-3 col-xs-12">
            <div class="form-group">
                <label>Chuyên mục</label>
                <select name="product_category" class="form-control">
                    <?php adminPage_select_parent_menu($appProductCategories, 0, $product->product_category); ?>
                </select>
            </div>
            <div class="form-group">
                <label for="thumbnail">Ảnh đại diện <span class="required">*</span></label>
                  <?php echo form_error('image');?>
                 <p><button id="upload-single" class="btn btn-sm btn-default" type="button"><i class="fa fa-upload blue"></i> <span>Tải ảnh mới</span></button> <small> (<?php echo THUMBNAIL_SIZE_PRODUCT; ?>) </small> </p>
                  <p><span id="status-single"></span></p>
                 <div id="singleUploaded">
                     <?php if($product->thumbnail) echo '<img src="'. config_item('media_uri') . $product->thumbnail .'">';?>
                     <input type="hidden" name="thumbnail" value="<?php echo $product->thumbnail;?>">
                    </div>
            </div>
            <div class="form-group">
                <label for="cover_image">Ảnh Cover <span class="required">*</span></label>
                  <?php echo form_error('image');?>
                 <p><button class="btn btn-sm btn-default btn-uppload-single" data-name="cover_image" type="button"><i class="fa fa-upload blue"></i> <span>Tải ảnh mới</span></button> <small> (<?php echo COVER_IMAGE_SIZE; ?>) </small> </p>
                  <p><span id="status-cover_image"></span></p>
                 <div id="singleUploaded-cover_image">
                     <?php if($product->cover_image) echo '<img src="'. config_item('media_uri') . $product->cover_image .'">';?>
                     <input type="hidden" name="cover_image" value="<?php echo $product->cover_image;?>">
                    </div>
            </div>
        </div>
    </div>
    </form>
</div>