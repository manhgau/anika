<section class="content">
    <div class="row">
        <?php $formElement = $this->portfolio_model->porfolioForm($portfolio) ?>
        <?php echo form_open('','role="form"');?>
        <!-- left column -->
        <div class="col-md-9">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="input-name"> Name <span class="red">*</span></label>
                        <input type="text" id="input-name" name="name" required class="form-control" value="<?php echo set_value('name', html_entity_decode($portfolio->name)); ?>">
                        <?php echo form_error('name'); ?>
                    </div>
                    <div class="form-group">
                        <label for="input-description"> Description </label>
                        <?php echo form_error('description'); ?>
                        <textarea class="form-control" id="input-description" rows="3" name="description"><?php echo set_value('description', html_entity_decode($portfolio->description)); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Url</label>
                        <input type="url" name="url" class="form-control" value="<?php echo set_value('url', $portfolio->url); ?>">
                        <?php echo form_error('url'); ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo $formElement['thinkzone_batch']['label'] ?></label>
                        <?php echo form_element($formElement['thinkzone_batch']) ?>
                    </div>
                    <div class="form-group">
                        <label><?php echo $formElement['bussiness_area']['label'] ?></label>
                        <?php echo form_element($formElement['bussiness_area']) ?>
                    </div>
                    <div class="form-group">
                        <label>Vision & Mission</label>
                        <?php echo form_element($formElement['vision_mission']) ?>
                    </div>
                    <div class="">
                        <label>Thành tích</label>
                        <?php echo form_element($formElement['key_traction']) ?>
                    </div>
                </div><!-- /.box-body -->
                <div class="clear"></div>
                <div class="box-footer" style="clear:both;">
                    <?php echo form_submit('submit','Save','class="btn btn-danger"'); ?>
                </div>
            </div><!-- /.box -->
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body">
                    <ul class="list-unstyled">
                        <li><label><?= form_element($formElement['status']); ?> Hiển thị</label></li>
                        <li><label><input type="checkbox" class="simple" name="isHot" value="1" <?php if($portfolio->isHot) echo 'checked="checked"'; ?>> Is HOT</label></li>
                    </ul>
                    <div class="form-group">
                        <label>Vị trí</label>
                        <?php echo form_element( $formElement['order'] ) ?>
                        <?php echo form_error('order'); ?>
                    </div>
                    <div class="form-group">
                        <label>Logo <small>(<?php echo $this->portfolio_model->logoSize; ?>)</small></label><br>
                        <?php echo form_element($formElement['logo']) ?>
                        
                    </div>
                    <div class="form-group">
                        <label>Năm thành lập</label>
                        <?php echo form_element($formElement['year_foundation']) ?>
                    </div>
                    <div class="form-group">
                        <label>Founder</label>
                        <?php echo form_element($formElement['founder_name']) ?>
                    </div>
                    <div class="form-group">
                        <label>Founder Image</label>
                        <?php echo form_element($formElement['founder_image']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>