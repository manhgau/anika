<section class="content">
    <div class="row">
        <?php echo form_open('','role="form"');?>
        <!-- left column -->
        <div class="col-md-9">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="input-name"> Tên đối tác <span class="red">*</span></label>
                        <input type="text" id="input-name" name="name" required class="form-control" value="<?php echo set_value('name', html_entity_decode($relationship->name)); ?>">
                        <?php echo form_error('name'); ?>
                    </div>

                    <div class="form-group">
                        <label for="input-description"> Mô tả ngắn </label>
                        <?php echo form_error('description'); ?>
                        <textarea class="form-control" id="input-description" rows="3" name="description"><?php echo set_value('description', html_entity_decode($relationship->description)); ?></textarea>
                    </div>

                    <div class="clear"></div>
                </div><!-- /.box-body -->
                <div class="clear"></div>
                <div class="box-footer" style="clear:both;">
                    <?php echo form_submit('submit','Save','class="btn btn-primary"'); ?>
                </div>
            </div><!-- /.box -->
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body">
                    <ul class="list-unstyled">
                        <li>
                        <label><?=form_checkbox('status','1',($relationship->status == 1) ? TRUE : FALSE,'class="simple"');?> Hiển thị</label>
                        </li>
                        <li><label><input type="checkbox" class="simple" name="is_hot" value="1" <?php if($relationship->is_hot) echo 'checked="checked"'; ?>> Is HOT</label></li>
                    </ul>
       
                    <div class="form-group" style="">
                            <label for="uploadFile">Ảnh</label>
                            <?php echo form_element([
                                'type' => 'fileupload',
                                'name' => 'image',
                                'value' => $relationship->image,
                                'button_label' => 'Chọn ảnh'
                            ]) ?>
                        </div>
                 
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>