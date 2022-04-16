<section class="content">
    <div class="row">
        <form action="" method="post" role="form">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-parent">Chuyên mục cha</label> <?php echo my_form_error('parent_id');?>
                            <select class="form-control" id="input-parent" name="parent_id">
                                <option value="0"> --- Chọn chuyên mục --- </option>
                                <?php 
                                select_box_with_level_category($list_category, 0, $category->parent_id); ?>
                            </select>
                            <?php //echo form_dropdown('parent_id',$list_category,($category->parent_id) ? $category->parent_id : $this->input->post('parent_id'),'class="form-control" id="input-parent"'); ?>
                        </div>
                        <div class="form-group">
                            <label for="input-title">Tên chuyên mục</label> <?php echo my_form_error('title');?>
                            <input type="text" name="title" value="<?= set_value('title', html_entity_decode($category->title)) ?>" class="form-control" id="input-title">
                        </div>
                        <div class="form-group">
                            <label for="input-desc">Mô tả</label>
                            <textarea name="description" id="input-desc" rows="3" class="form-control"><?php echo $category->description;?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="input-status"><input type="checkbox" name="status" class="simple" id="input-status" value="1" <?php if($category->status ==1) echo 'checked="checked"'; ?> /> Công khai</label> <?php echo my_form_error('status');?>
                            
                        </div>
                        <hr class="line" style="clear: both;" />
                        <h3 class="box-title" onclick="toggle_seo();" id="seo-box-title">SEO Options</h3>
                        <div class="seo-box">
                            <div class="form-group">
                                <label for="meta-title">Meta title</label> <?php echo my_form_error('meta_title');?>
                                <?php echo form_input('meta_title',set_value('meta_title',$category->meta_title),'class="form-control" id="meta-title"'); ?>
                            </div>
                            <div class="form-group">
                                <label for="meta-keyword">Meta Keyword</label> <?php echo my_form_error('meta_keyword');?>
                                <textarea name="meta_keyword" class="form-control" rows="4" id="meta-keyword"><?php echo $category->meta_keyword; ?></textarea>
                            </div> 
                            <div class="form-group">
                                <label for="meta-desc">Meta Description</label> <?php echo my_form_error('meta_description');?>
                                <textarea name="meta_description" id="meta-desc" class="form-control" rows="4"><?php echo $category->meta_description; ?></textarea>
                            </div> 
                        </div>                     
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit','Save','class="btn btn-primary"');?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>