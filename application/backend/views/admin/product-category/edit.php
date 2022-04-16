<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-title">Chuyên mục cha</label> <?php echo my_form_error('parent_id');?>
                            <select name="parent_id" class="form-control select2-category">
                                <option value="0">--- Chọn chuyên mục ---</option>
                                <?php foreach ($treeCategories as $key => $val) : ?>
                                <option value="<?php echo $val['id'];?>" <?php echo ($val['id'] == $category->parent_id) ? 'selected="selected"' : '' ;?> ><?php echo $val['title']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div> 
                        <div class="form-group">
                            <label for="input-title">Tiêu đề</label> <?php echo my_form_error('title');?>
                            <input type="text" class="form-control" id="input-title" value="<?php echo htmlspecialchars($category->title);?>" name="title">
                        </div> 
                        <div class="form-group">
                            <label for="input-description">Mô tả</label> <?php echo my_form_error('description');?>
                            <textarea name="description" rows="5" class="form-control" id="input-description"><?php echo $category->description;?></textarea>
                        </div>

                        <hr class="line" style="clear: both;" />
                        <h3 class="box-title" onclick="toggle_seo();" id="seo-box-title">SEO Options</h3>
                        <div class="seo-box">
                            <div class="form-group">
                                <label for="meta-title">Meta title</label> <?php echo my_form_error('meta_title');?>
                                <input type="text" name="meta_title" id="meta-title" class="form-control" value="<?php echo htmlspecialchars($category->meta_title);?>">
                            </div>

                            <div class="form-group">
                                <label for="meta-keyword">Meta Keyword</label> <?php echo my_form_error('meta_keyword');?>
                                <textarea name="meta_keyword" class="form-control" rows="4" id="meta-keyword"><?php echo htmlspecialchars($category->meta_keyword); ?></textarea>
                            </div> 

                            <div class="form-group">
                                <label for="meta-desc">Meta Description</label> <?php echo my_form_error('meta_description');?>
                                <textarea name="meta_description" id="meta-desc" class="form-control" rows="4"><?php echo htmlspecialchars($category->meta_description); ?></textarea>
                            </div> 
                        </div>          
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit','Save','class="btn btn-primary"');?>
                    </div>
                </div>
            </div>

            <div class="col-md-3 hidden">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Thông tin</h3>
                    </div>
                    <hr class="line" />
                </div>
            </div>
        </form>
    </div>
</section>