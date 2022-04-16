<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Parent</label>
                            <?php echo form_dropdown('parent_id',$page_no_parent,($page->parent_id) ? $page->parent_id : $this->input->post('parent_id'),'class="form-control"')?>
                            <?php echo my_form_error('parent_id'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Title</label>
                            <?php echo form_input('title',set_value('title',$page->title),'class="form-control"'); ?>
                            <?php echo my_form_error('title'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Order</label>
                            <?php echo form_input('order',set_value('order',$page->order),'class="form-control"'); ?>
                            <?php echo my_form_error('order'); ?>
                        </div>
                        <div class="form-group" id="list-image">
                            <label for="exampleInputEmail1" style="width:100%;"> Nội dung trang </label>
                            <button id="upload" type="button" name="bt_image"><span>Tải ảnh từ máy tính</span></button>
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
                            <textarea id="tinymce" name="content"><?php echo $page->content; ?></textarea>
                            <?php //echo form_textarea('content',set_value('content', $page->content),'class="form-control" id="tinymce"'); ?>
                            <p class="error-content"><?php echo my_form_error('content'); ?></p>
                        </div>
                        <hr class="line" style="clear: both;" />
                        <h3 class="box-title" onclick="toggle_seo();" id="seo-box-title">SEO Options</h3>
                        <div class="seo-box">
                            <div class="form-group">
                                <label for="meta-title">Meta title</label> <?php echo my_form_error('meta_title');?>
                                <?php echo form_input('meta_title',set_value('meta_title',$page->meta_title),'class="form-control" id="meta-title"'); ?>
                            </div>
                            <div class="form-group">
                                <label for="meta-keyword">Meta Keyword</label> <?php echo my_form_error('meta_keyword');?>
                                <textarea name="meta_keyword" class="form-control" rows="4" id="meta-keyword"><?php echo $page->meta_keyword; ?></textarea>
                            </div> 
                            <div class="form-group">
                                <label for="meta-desc">Meta Description</label> <?php echo my_form_error('meta_description');?>
                                <textarea name="meta_description" id="meta-desc" class="form-control" rows="4"><?php echo $page->meta_description; ?></textarea>
                            </div> 
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit','Save','class="btn btn-primary"'); ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>