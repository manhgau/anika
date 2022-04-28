<section class="content">
    <div class="row">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-body">
                    <div class="form-group">
                        <label for="input-name"> Tên đối tác <span class="red">*</span></label>
                        <input type="text" id="input-name" name="name" required class="form-control" value="<?php echo set_value('name', html_entity_decode($partner->name)); ?>">
                        <?php echo form_error('name'); ?>
                    </div>

                    <div class="form-group">
                        <label for="input-description"> Mô tả ngắn </label>
                        <?php echo form_error('description'); ?>
                        <textarea class="form-control" id="input-description" rows="3" name="description"><?php echo set_value('description', html_entity_decode($partner->description)); ?></textarea>
                    </div>
                        <div class="form-group">
                            <label for="input-status"><input type="checkbox" name="status" class="simple" id="input-status" value="1" <?php if ($partner->status == 1) echo 'checked="checked"'; ?> /> Công khai</label> <?php echo my_form_error('status'); ?>

                        </div>
                        <div class="form-group">
                            <label for="input-is-hot"><input type="checkbox" name="is_hot" class="simple" id="input-is-hot" value="1" <?php if ($partner->is_hot == 1) echo 'checked="checked"'; ?> /> Nổi bật </label> <?php echo my_form_error('is_hot'); ?>

                        </div>
                        <div class="form-group" style="">
                            <label for="uploadFile">Ảnh đại diện</label>
                            <?php echo form_element([
                                'type' => 'fileupload',
                                'name' => 'image',
                                'value' => $partner->image,
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