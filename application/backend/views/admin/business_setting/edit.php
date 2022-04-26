<section class="content">
    <div class="row">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-title">Tên lĩnh vực</label> <?php echo my_form_error('title'); ?>
                            <input type="text" name="name" value="<?= set_value('title', html_entity_decode($business_setting->name)) ?>" class="form-control" id="input-title">
                        </div>
                       
                        <div class="form-group">
                            <label for="input-status"><input type="checkbox" name="status" class="simple" id="input-status" value="1" <?php if ($business_setting->status == 1) echo 'checked="checked"'; ?> /> Công khai</label> <?php echo my_form_error('status'); ?>

                        </div>
                        <div class="form-group" style="">
                            <label for="uploadFile">Ảnh đại diện</label>
                            <?php echo form_element([
                                'type' => 'fileupload',
                                'name' => 'image',
                                'value' => $business_setting->image,
                                'button_label' => 'Chọn ảnh'
                            ]) ?>
                        </div>
                      
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit', 'Save', 'class="btn btn-primary"'); ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>