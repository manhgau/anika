<section class="content">
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <form action="" method="post">
                    <div class="box-header">
                        <h3 class="box-title">Thông tin địa điểm</h3>
                    </div>
                    <div class="box-body">                        
                        <div class="form-group select-type">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Phân loại</label>
                            <select class="form-control" name="location_type">
                                <option value="is_country" <?php echo ($location->level == 1) ? 'selected="selected"' : '';?>>Quốc gia</option>
                                <option value="is_province" <?php echo ($location->level == 2) ? 'selected="selected"' : '';?>>Tỉnh thành</option>
                                <option value="is_location" <?php echo ($location->level == 3) ? 'selected="selected"' : '';?>>Địa điểm</option>
                            </select>
                        </div>                        
                        <div class="form-group parent-location">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Quốc gia</label>
                            <input type="text" class="form-control" name="parent_id" id="token-input-parent">
                        </div>
                        <div class="form-group group-location">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Vùng miền</label>
                            <input type="text" class="form-control" id="token-group-location" name="group_id">
                        </div>
                        <div class="form-group location">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Tên</label>
                            <input type="text" class="form-control" name="name" value="<?php echo $location->name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Ảnh đại diện <span class="required">*</span></label>
                              <?php echo form_error('thumbnail');?>
                             <p><button id="upload-single" type="button"><span>Tải ảnh từ máy tính</span></button> <small> (320x160) </small> </p>
                              <p><span id="status-single"></span></p>
                             <div id="singleUploaded">
                                 <?php if($location->thumbnail) echo '<img src="'. config_item('media_uri') . $location->thumbnail .'">';?>
                                 <input type="hidden" name="thumbnail" value="<?php echo $location->thumbnail;?>">
                                </div>
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Giới thiệu</label>
                            <textarea class="form-control" id="tinymce1" name="content"><?php echo $location->content; ?></textarea>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-floppy-o"></i> Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>