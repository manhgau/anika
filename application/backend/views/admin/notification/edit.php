<section class="content">
    <div class="row">
        <form action="" method="post" role="form">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-title">Tiêu đề thông báo</label> <?php echo my_form_error('title');?>
                            <input type="text" name="title" value="<?= set_value('title', html_entity_decode($notification->title)) ?>" class="form-control" id="input-title">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Chọn loại thông báo</label>
                            <?php echo form_dropdown('type',$notification_type,(isset($notification->type)) ? $notification->type : 'thong_bao_he_thong','class="form-control"'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Chọn nhóm đối tượng</label>
                            <?php echo form_dropdown('sender_type',$notification_sender,(isset($notification->sender_type)) ? $notification->sender_type : 'all','class="form-control"'); ?>
                        </div>
                        <div class="form-group">
                            <label for="input-desc">Nội dung thông báo</label>
                            <textarea name="content" id="input-desc" rows="3" class="form-control"><?php echo $notification->content;?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="input-status">Trạng thái</label> <?php echo my_form_error('status');?>
                            <select name="status" id="input-status" class="form-control" <?php if($userdata['level'] > 1) echo 'readonly="readonly"';?>>
                                <option value="0" <?php if($notification->status==0) echo 'selected="selected"';?>>Khóa</option>
                                <option value="1" <?php if($notification->status==1) echo 'selected="selected"';?>>Công khai</option>
                            </select>

                        </div>

                        <hr class="line" style="clear: both;" />
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit','Save','class="btn btn-primary"');?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>