<section class="content">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Câu hỏi</label>
                            <?php echo form_input('question',set_value('question',$faq->question),'class="form-control"'); ?>
                            <?php echo my_form_error('question'); ?>
                        </div>
                        <div class="form-group" id="list-image">
                            <label style="width:100%;"> Trả lời </label>
                            <a href="javascript:;" class="btn btn-default btn-sm" id="upload" type="button" name="bt_image"><span>Tải ảnh từ máy tính</span></a>
                            <p><span id="status"></span></p>
                            <div id="display-file">
                                <ul>
                                    <?php if(isset($product_images)) : 
                                        $_img_order = explode('#',$product_detail->list_image);
                                        ?>
                                        <?php 
                                        foreach ($_img_order as $_order) :
                                            foreach($product_images as $key => $img) : if($img->id == $_order) : ?>
                                                <li>
                                                    <img src="<?=$img->url;?>" alt="" height="40" style="height:40px;width:auto;margin:1px 0;border:1px solid #eee">
                                                    <input type="hidden" name="listImage[]" value="<?=$img->id;?>">
                                                    <a class="insert_img_content" data="<?=$img->url;?>">Insert</a>
                                                </li>
                                            <?php endif; endforeach; endforeach; ?>
                                        <?php endif; ?>
                                        <li class="clear hidden"></li>
                                    </ul>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="form-group">
                                <textarea id="tinymce" name="answer"><?php echo $faq->answer; ?></textarea>
                                <p class="error-answer"><?php echo my_form_error('answer'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box box-info">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Trạng thái</label>
                                <?php echo form_dropdown('status', ['public' => 'Công khai', 'hide' => 'Ẩn'], $faq->status, 'class="form-control"'); ?>
                            </div>
                            <div class="form-group">
                                <label>Thứ tự</label>
                                <?php echo form_input('order',set_value('order',$faq->order),'class="form-control"'); ?>
                                <?php echo my_form_error('order'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-info">
                <div class="box-footer">
                    <?php echo form_submit('submit','Save','class="btn btn-primary"'); ?>
                </div>
            </div>
        </form>
</section>