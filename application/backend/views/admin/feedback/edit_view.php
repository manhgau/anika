<section class="content">
    <div class="row">
        <div class="col-md-10">
            <div class="box box-primary">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-customer_name">Tên khách hàng:&nbsp;</label>
                            <input type="text" class="form-control" name="customer_name" id="input-customer_name" placeholder="Tên khách hàng" value="<?php echo $feedback->customer_name;?>">
                        </div>
                        <div class="form-group">
                            <label for="url">Thông tin khách hàng:&nbsp;</label>
                            <input type="text" class="form-control" id="url" name="customer_info" placeholder="" value="<?php echo $feedback->customer_info;?>">
                        </div>
                        <div class="form-group">
                            <label for="Message">Message:&nbsp;</label>
                            <textarea rows="6" class="form-control" id="Message" name="message"><?php echo $feedback->message;?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Message">Bài viết</label>
                            <input type="text" id="token-news" name="destinationId" class="form-control" value="<?php echo '';?>">
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Avatar <span class="required">*</span></label> 
                            <?php echo form_error('thumbnail');?>
                            <p><button id="upload-single" type="button"><span>Tải ảnh từ máy tính</span></button> <small>300x170</small> </p>
                            <p><span id="status-single"></span></p>
                            <div id="singleUploaded">
                                <?php if($feedback->avatar) echo '<img src="'. config_item('media_uri') . $feedback->avatar .'">';?>
                                <input type="hidden" name="thumbnail" value="<?php echo $feedback->avatar;?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <input type="submit" name="submit" value="Lưu" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>