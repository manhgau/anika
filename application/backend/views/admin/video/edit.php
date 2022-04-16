<style type="text/css">
    #list-image ul li{border:none!important;margin:0!important;padding:0!important}#display-file table{width:100%;display:block;border:none!important}#display-file td{border:1px solid #ccc;padding:3px 5px;text-align:center}#display-file td input{width:100%;background-color:#f2f2f2;padding:2px}#display-file tr td:first-child{width:100px}#display-file tr td:nth-child(2){width:250px}#display-file tr td:nth-child(3){width:60px}#display-file tr td:nth-child(4){width:100px}#display-file tr td:last-child{width:50px}
</style>
<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-fileUrl">Video Youtube_ID </label> <?php echo my_form_error('fileUrl');?>
                            <?php echo form_input('fileUrl',set_value('fileUrl',$video->fileUrl),'class="form-control" id="input-fileUrl"'); ?>
                            <div class="video-preview">
                                <?php if($video->fileUrl) echo '<iframe width="300" height="200" src="https://www.youtube.com/embed/'.$video->fileUrl.'?rel=0" frameborder="0" allowfullscreen></iframe>';?>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="input-title">Tên video</label> <?php echo my_form_error('title');?>
                            <?php echo form_input('title',set_value('title',$video->title),'class="form-control" id="input-title"'); ?>
                        </div> 
                        <div class="form-group">
                            <label for="input-description">Mô tả</label> <?php echo my_form_error('description');?>

                            <textarea name="description" rows="5" class="form-control" id="input-description"><?php echo $video->description;?></textarea>
                        </div>

                        <hr class="line" style="clear: both;" />
                        <h3 id="seo-box-title" class="box-title" onclick="toggle_seo();">SEO Options</h3>
                        <div class="seo-box">
                            <div class="form-group">
                                <label for="meta-title">Meta title</label> <?php echo my_form_error('meta_title');?>
                                <?php echo form_input('meta_title',set_value('meta_title',$video->meta_title),'class="form-control" id="meta-title"'); ?>
                            </div>

                            <div class="form-group">
                                <label for="meta-keyword">Meta Keyword</label> <?php echo my_form_error('meta_keyword');?>
                                <textarea name="meta_keyword" class="form-control" rows="4" id="meta-keyword"><?php echo $video->meta_keyword; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta-desc">Meta Description</label> <?php echo my_form_error('meta_description');?>
                                <textarea name="meta_description" id="meta-desc" class="form-control" rows="4"><?php echo $video->meta_description; ?></textarea>
                            </div> 
                        </div>          
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit','Save','class="btn btn-primary"');?>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Thông tin</h3>
                    </div>
                    <hr class="line" />
                    <div class="box-body">
                        <div class="form-group"> 
                            <p>
                                <label for="status">Xuất bản / chờ duyệt</label> <?php echo form_error('status');?>
                                <input type="checkbox" name="status" value="1" id="status" <?php if($video->status==1) echo 'checked="checked"'; ?>>
                            </p>
                            <p>
                                <label for="is-hot">HOT</label> <?php echo form_error('is_hot');?>
                                <input type="checkbox" name="is_hot" value="1" id="is-hot" <?php if($video->is_hot==1) echo 'checked="checked"'; ?>>
                            </p>
                        </div>

                        <div class="form-group">
                            <label for="cat_id">Chuyên mục</label> <?php echo form_error('cat_id');?>
                            <select name="cat_id" id="cat_id" class="form-control">
                                <option value="0">--- Chọn chuyên mục ---</option>
                                <?php foreach($video_categories as $key => $val) : ?>
                                    <option value="<?php echo $val->id;?>" <?php if($val->id == $video->cat_id) echo 'selected="selected"';?>><?php echo $val->title;?></option>
                                    <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="public-time">Hẹn giờ</label> <?php echo form_error('title');?>
                            <?php echo form_input('public_time',date('d-m-Y H:i',$video->public_time),'class="form-control form_datetime1" readonly="" id="public-time"');?>
                        </div>
                    </div>
                    <hr class="line" />
                    <div class="form-group">
                        <p><label for="thumbnail">Ảnh đại diện</label></p>
                        <p><label for="auto-thumbnail" style="font-weight:400;">Tự động từ Youtube</label>  <input type="checkbox" id="auto-thumbnail" checked="checked"></p>
                        <div class="upload-img" >
                            <input id="uploadFile" type="file" name="thumbnail" class="img" id="thumbnail" />
                            <div id="imagePreview" style="background-image:url(<?php echo ($video->thumbnail) ? get_image($video->thumbnail) : getYoutubeThumb($video->fileUrl);?>);"></div>
                        </div>
                    </div>
                    <hr class="line" />
                    <div class="form-group">
                        <label for="tag">Tags</label> <?php echo form_error('tags_id');?>
                        <textarea rows="1" id="tags" name="tags" style="width:200px;padding:5px;height:auto"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>