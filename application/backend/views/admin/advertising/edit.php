<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Sửa tin khuyến mãi</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Chọn nhóm:&nbsp;</label>
                            <select name="group_id" id="" class="form-control">
                                <?php foreach ($adsGroups as $key => $val) : ?>
                                    <option value="<?php echo $val->id; ?>" <?php if ($val->id == $advertising->group_id) echo 'selected="selected"'; ?>><?php echo $val->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="input-name">Tiêu đề:&nbsp;</label>
                            <input type="text" class="form-control" name="title" id="input-name"
                                   value="<?php echo $advertising->title; ?>">
                        </div>
                        <div class="form-group">
                            <label for="url">Đường dẫn:&nbsp;</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Menu URL: "
                                   value="<?php echo $advertising->url; ?>">
                        </div>


                        <div class="form-group">
                            <input type="hidden" id="id" name="id"
                                   value="<?php if (isset($advertising->id)) echo $advertising->id; ?>">
                            <input type="submit" name="submit" value="Lưu" class="btn btn-primary">
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xs-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Chi tiết</h3>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label for="status">Duyệt đăng:&nbsp;</label>
                            <?php echo form_checkbox('status', '1', ($advertising->status == 1) ? TRUE : FALSE, 'class="form-control" id="status"'); ?>
                        </div>
                        <div class="form-group">
                            <label for="is_hot">is HOT:&nbsp;</label>
                            <?php echo form_checkbox('is_hot', '1', ($advertising->is_hot == 1) ? TRUE : FALSE, 'class="form-control" id="is_hot"'); ?>
                        </div>
                        <div class="form-group">
                            <label for="input-sale_info">Mức khuyến mãi:&nbsp;</label>
                            <input type="text" class="form-control" name="sale_info" id="input-sale_info"
                                   value="<?php echo $advertising->sale_info; ?>" placeholder="- 50%">
                        </div>
                        <div class="form-group">
                            <label for="position">Vị trí:&nbsp;</label>
                            <input type="text" class="form-control" id="position" name="position"
                                   placeholder="vị trí hiển thị của tin khuyến mãi"
                                   value="<?php echo $advertising->position; ?>">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Ảnh</label>
                            <button id="upload-single" type="button" data-name="image">
                                <span>Tải ảnh từ máy tính</span></button>
                            <p><span id="status-single"></span></p>
                            <div id="singleUploaded">
                                <img src="<?php echo get_image($advertising->image); ?>" alt="" class="image-preview">
                                <input type="hidden" name="image" value="<?php echo $advertising->image;?>">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</section>