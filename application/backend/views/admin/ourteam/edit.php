<?php $formElement = $this->ourteam_model->ourteamForm($member) ?>
<section class="content">
    <div class="row">
        <?php echo form_open('','role="form"');?>
        <!-- left column -->
        <div class="col-md-9">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h4 class="box-title">Infomation</h4>
                </div>
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label> Name <span class="red">*</span></label>
                        <?php echo form_element($formElement['name']); ?>
                        <?php echo form_error('name'); ?>
                    </div>
                    <div class="form-group">
                        <label>Chức danh <span class="red">*</span></label>
                        <?php echo form_element($formElement['job_title']); ?>
                        <?php echo form_error('job_title'); ?>
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <?php echo form_element($formElement['description']); ?>
                        <?php echo form_error('description'); ?>
                    </div>

                    <div class="form-group" id="list-image">
                        <label>Logo công ty cũ</label>
                        <?php echo form_element($formElement['logo_worked']) ?>
                        <?php /*
                        <p>
                            <a href="javascript:;" class="btn btn-sm btn-info" id="upload" type="button" name="bt_image"><i class="fa fa-upload"></i> <span>Tải ảnh</span></a> <small>(xx * 17px)</small>
                        </p>
                        <p><span id="status"></span><span id="status-copyright"></span></p>
                        <div class="clearfix">
                            <style type="text/css">#display-file img{width:auto!important;height:20px!important}</style>
                            <div id="display-file">
                                <ul class="list-inline">
                                    <?php if($arrLogo = explode(',', $member->logo_worked) && $member->logo_worked_image) : ?>
                                        <?php foreach ($member->logo_worked_image as $img) : ?>
                                            <li class="list-inline-item">
                                                <img src="<?= getImageUrl($img->url);?>" alt="">
                                                <input type="hidden" name="listImage[]" value="<?=$img->id;?>">
                                            </li>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            */ ?>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header">
                    <h4 class="box-title">Config</h4>
                </div>
                <div class="box-body">
                    <ul class="list-unstyled">
                        <li><label><?= form_element($formElement['status']); ?> Hiển thị</label></li>
                    </ul>
                    <div class="form-group">
                        <label>Nhóm <span class="red">*</span></label>
                        <?php echo form_element($formElement['group']); ?>
                        <?php echo form_error('group'); ?>
                    </div>
                    <div class="form-group">
                        <label>Vị trí</label>
                        <?php echo form_element( $formElement['order'] ) ?>
                        <?php echo form_error('order'); ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_element( $formElement['linkedin'] ) ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_element( $formElement['facebook'] ) ?>
                    </div>
                    <div class="form-group">
                        <label>Ảnh đại diện <span class="red">*</span></label>
                        <?php echo form_element($formElement['image']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box box-danger">
                <div class="box-footer" style="clear:both;">
                    <?php echo form_submit('submit','Save','class="btn btn-danger"'); ?>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>