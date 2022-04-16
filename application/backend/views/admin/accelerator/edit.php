<section class="content">
    <div class="row">
        <?php $formElement = $this->accelerator_model->acceleratorForm($accelerator) ?>
        <?php echo form_open('','role="form"');?>
        <!-- left column -->
        <div class="col-md-9">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label> Name <span class="red">*</span></label>
                        <?php echo form_element($formElement['name']); ?>
                        <?php echo form_error('name'); ?>
                    </div>
                    <div class="form-group">
                        <label>Loại hình hỗ trợ</label>
                        <?php echo form_element($formElement['type']); ?>
                        <?php echo form_error('type'); ?>
                    </div>
                    <div class="form-group">
                        <label>Giới thiệu ngắn</label>
                        <?php echo form_element($formElement['intro']); ?>
                        <?php echo form_error('intro'); ?>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <?php echo form_element($formElement['description']); ?>
                        <?php echo form_error('description'); ?>
                    </div>
                </div><!-- /.box-body -->
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
                    </ul>
                    <div class="form-group">
                        <label>Vị trí</label>
                        <?php echo form_element( $formElement['order'] ) ?>
                        <?php echo form_error('order'); ?>
                    </div>
                    <div class="form-group">
                        <label>Logo <small>(<?php echo $this->accelerator_model->logoSize; ?>)</small></label><br>
                        <?php echo form_element($formElement['logo']) ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>