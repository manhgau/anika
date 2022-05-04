
<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Nội dung bài viết</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-title">Tiêu đề <span class="red">*</span></label> <?php echo my_form_error('title');?>
                            <input type="text" class="form-control" id="input-title" required value="<?php echo htmlspecialchars($article->title);?>" name="title">
                        </div> 
                        <div class="form-group">
                            <label for="input-description">Mô tả</label> <?php echo my_form_error('description');?>
                            <textarea name="description" rows="3" class="form-control" id="input-description"><?php echo $article->description;?></textarea>
                        </div>

                        <div class="form-group" id="list-image">
                            <label for="tinymce" style="width:100%;"> Nội dung bài viết </label> <?php echo my_form_error('content');?>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p>
                                        <button id="upload" type="button" name="bt_image"><span>Tải ảnh</span></button>
                                     hoặc <button id="upload-copyright" type="button" name="bt_image"><span>Tải ảnh và chèn logo</span></button> <small>(640x***)</small>
                                    </p>
                                    <p><span id="status"></span><span id="status-copyright"></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <style type="text/css">#display-file img{width:60px!important;height:40px!important}</style>
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
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <textarea name="content" class="form-control" id="tinymce" rows="20"><?php echo $article->content; ?></textarea>
                        </div> 

                        <hr class="line" style="clear: both;" />
<!--                        <h3 class="box-title" onclick="toggle_seo();" id="seo-box-title">SEO Options</h3>-->
<!--                        <div class="seo-box">-->
<!--                            <div class="form-group">-->
<!--                                <label for="meta-title">Meta title</label> --><?php //echo my_form_error('meta_title');?>
<!--                                <input type="text" name="meta_title" id="meta-title" class="form-control" value="--><?php //echo $article->meta_title;?><!--">-->
<!--                            </div>-->
<!---->
<!--                            <div class="form-group">-->
<!--                                <label for="meta-keyword">Meta Keyword</label> --><?php //echo my_form_error('meta_keyword');?>
<!--                                <textarea name="meta_keyword" class="form-control" rows="4" id="meta-keyword">--><?php //echo $article->meta_keyword; ?><!--</textarea>-->
<!--                            </div> -->
<!---->
<!--                            <div class="form-group">-->
<!--                                <label for="meta-desc">Meta Description</label> --><?php //echo my_form_error('meta_description');?>
<!--                                <textarea name="meta_description" id="meta-desc" class="form-control" rows="4">--><?php //echo $article->meta_description; ?><!--</textarea>-->
<!--                            </div> -->
<!---->
<!--                            <div class="form-group">-->
<!--                                <label for="meta-slug text-danger">Meta Slug</label> --><?php //echo my_form_error('slugname');?>
<!--                                <p>-->
<!--                                    <small class="text-danger">* Tạo tự động nếu không nhập</small>-->
<!--                                    <small class="text-danger">* Bao gồm tiếng việt không dấu, và dấu "-"</small>-->
<!--                                </p>-->
<!--                                <input type="text" name="slugname" placeholder="vi-du-slugname-bai-viet" value="--><?php //echo $article->slugname; ?><!--" class="form-control">                                -->
<!--                            </div> -->
<!--                        </div>          -->
                    </div>
                    <div class="box-footer">
                        <?php 
                        if($userdata['id'] == $article->create_by && !$article->id)
                        {
                            echo form_submit('sentNews','Gửi bài đi duyệt','class="btn btn-primary"');
                        }

                        if ($article->id)
                        {
                            echo form_submit('saveContentOnly','Cập nhật','class="btn btn-primary"');
                        }
                        
                        if($userdata['level'] <= 2 )
                        {
                            echo ($article->status!=1) ? form_submit('publish','Đăng bài','class="btn btn-success"') : form_submit('un_publish','Ẩn bài viết','class="btn btn-danger"');    
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Thông tin</h3>
                    </div>
                    <div class="box-body">
                        <?php if($userdata['level'] <= 2) : ?>
                            <ul class="list-unstyled">
                                <li>
                                    <label >
                                    <input type="checkbox" name="status" value="1" class="simple" id="status" <?php if($article->status==1) echo 'checked="checked"'; ?>> Xuất bản</label> 
                                    <?php echo form_error('status');?>
                                </li>
                                <li>
                                    <label for="is-hot"><input type="checkbox" name="is_hot" value="1" class="simple" id="is-hot" <?php if($article->is_hot==1) echo 'checked="checked"'; ?>> Nổi bật chuyên mục</label> <?php echo form_error('is_hot');?>
                                </li>
                                <li><label for="is_popular"><input type="checkbox" name="is_popular" value="1" class="simple" id="is_popular" <?php if($article->is_popular==1) echo 'checked="checked"'; ?>> Tin đọc nhiều</label> <?php echo form_error('is_popular');?></li>
                                <li>
                                    <label><input type="checkbox" value="1" class="simple" name="display_author" <?php if($article->display_author) echo 'checked="checked"';?>> Hiện thông tin tác giả</label>
                                </li>
                                <li>
                                    <label><input type="checkbox" value="1" class="simple" name="display_ads_box" <?php if($article->display_ads_box) echo 'checked="checked"';?>> Hiện Box Promotion</label>
                                </li>
                            </ul>
                            <?php else: ?>
                            <input type="hidden" name="status" value="<?php echo $article->status;?>">
                            <input type="hidden" name="is_hot" value="<?php echo $article->is_hot; ?>">
                            <input type="hidden" name="is_popular" value="<?php echo $article->is_popular; ?>">
                            <?php endif; ?>
                        <div class="form-group">
                            <label for="public-time">Hẹn giờ</label> <?php echo form_error('title');?>
                            <?php echo form_input('public_time',date('d-m-Y H:i',strtotime($article->public_time)),'class="form-control form_datetime1" readonly="" id="public-time"');?>
                        </div>
                        <div class="form-group">
                            <label for="category">Chuyên mục <span class="red">*</span></label> <?php echo form_error('title');?>
                            <select name="category[]" class="form-control" multiple="multiple" required style="height:150px">
                                <option value="0"> --- Chọn chuyên mục --- </option>
                                <?php

                                if (isset($categoryNews)) {

                                    select_box_with_level_category_permission($category_for_user, $selectedCatIds);
                                }
                                else
                                    select_box_with_level_category_permission($category_for_user);
                                //    select_box_with_level_category($tree_categories, 0, NULL);

                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail <small style="font-weight:400">(600x400)</small></label> <?php echo form_error('thumbnail');?>
                            <input id="uploadFile" type="file" name="thumbnail" class="img" id="thumbnail" />
                            <div id="imagePreview" style="background-image: url(<?php echo ($article->thumbnail) ? get_image($article->thumbnail) : '';?>);"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Highlight Image <small style="font-weight:400">(1200x410)</small></label><br>
                            <button id="upload-single" type="button" class="btn btn-sm btn-primary" data-name="highlight_image"><span><i class="fa fa-upload"></i> Upload ảnh</span></button> 
                            <p><span id="status-single"></span></p>
                            <style type="text/css">#singleUploaded img{max-width: 100%;height:auto}</style>
                            <div id="singleUploaded" style="max-height:200px;overflow:auto">
                                <img src="<?php echo getImageUrl($article->highlight_image);?>" alt="" class="image-preview">
                                <input type="hidden" name="highlight_image" value="<?php echo $article->highlight_image; ?>">
                            </div>
                            <input type="text" name="highlight_alt" value="<?php echo $article->highlight_alt; ?>" placeholder="ghi chú ảnh" class="form-control">
                            
                        </div>
                        <div class="form-group">
                            <label for="tag">Tags</label> <?php echo form_error('tags_id');?>
                            <textarea rows="1" id="tags" name="tags" style="width:200px;padding:5px;height:auto"></textarea>
                        </div>
                        <div class="form-group hidden">
                            <label for="category">Phân loại bài viết</label>
                            <select name="news_type" class="form-control">
                                <option value="">--- Chọn loại ---</option>
                                <?php foreach($salaryNewsType as $key => $val) : ?>
                                <option value="<?php echo $val->id; ?>" <?php if($newsSalaryRecord && $newsSalaryRecord->type_id == $val->id) echo 'selected="selected"';?> ><?php echo $val->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
<!--                        <div class="form-group hidden">-->
<!--                            <label for="category">Bài viết gốc</label>-->
<!--                            <input type="text" name="source_url" value="--><?php //echo $article->source_url; ?><!--" class="form-control" placeholder="Nhập link bài viết gốc, nếu có.">-->
<!--                        </div>-->
                        <hr class="line">
                        <div class="form-group">
                            <label for="relate-news">Bài liên quan</label>
                            <input type="text" class="form-control" name="relate_news" id="relate-news">
                        </div>
<!--                        <div class="form-group hidden">-->
<!--                            <label for="category">Sự kiện</label> - <a href="--><?php //echo base_url('event/edit');?><!--" class="btn btn-xs btn-default" target="_blank">thêm mới</a>-->
<!--                            <input type="text" class="form-control" name="event" id="news-event">            -->
<!--                        </div>-->
<!--                        <div class="form-group hidden">-->
<!--                            <label for="category">Nhân vật</label> - <a href="--><?php //echo base_url('golfer/edit');?><!--" class="btn btn-xs btn-default" target="_blank">thêm mới</a>-->
<!--                            <input type="text" class="form-control" name="golfer" id="news-golfer">            -->
<!--                        </div>-->
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>