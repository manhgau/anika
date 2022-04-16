<form method="post">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo (isset($news->id)) ? 'Edit' : 'Add new'?></h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Title <span class="red">*</span></label> <?php echo my_form_error('title');?>
                    <input type="text" class="form-control" name="title" value="<?= $news->title ?>">
                </div>                        
                <div class="form-group">
                    <label for="link">Link <span class="red">*</span></label> <?php echo my_form_error('newsUrl');?>
                    <input type="url" required="required" name="newsUrl" value="<?= $news->newsUrl ?>" class="form-control">
                </div>
                <div class="form-group">
                    <label>Trang hiển thị</label>
                    <?php 
                    $options = $this->newspaper_model->getPageShow();
                    echo form_dropdown('on_page', $options, $news->on_page, 'class="form-control" onchange="reloadNextPos(this)"');
                    ?> 
                </div> 
                <div class="form-group">
                    <label>Vị trí</label>
                    <?= form_input('order', $news->order, 'class="form-control"'); ?> 
                </div> 
                <div class="form-group">
                    <label for="isHot"><?php echo form_checkbox('isHot','1', ($news->isHot==1) ? TRUE : FALSE,'class="simple" id="isHot"')?> Hiển thị</label> 
                </div> 
                <div class="form-group">
                    <label>Logo trang <span class="red">*</span></label> <span class="gray">(256x256)</span>
                    <p>
                        <button id="upload-single" type="button" class="btn btn-sm btn-default" data-name="image"><span><i class="fa fa-upload"></i> tải ảnh</span></button>
                        <span id="status-single"></span>
                    </p>
                    <div id="singleUploaded" style="max-height:200px;overflow:auto">
                        <?php if ($news->image): ?>
                            <img src="<?php echo getImageUrl($news->image);?>" alt="" class="image-preview">
                        <?php endif ?>
                        <input type="hidden" name="image" value="<?php echo ($news->image) ? $news->image : '' ?>">
                    </div>
                </div> 
            </div>
            <div class="box-footer">
                <?php echo form_submit('submit','Lưu','class="btn btn-danger"');?>
            </div>
        </div>
    </div>
</form>