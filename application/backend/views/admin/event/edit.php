<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="box box-primary">
                    <!--<div class="box-header">
                        <h3 class="box-title">Nội dung sự kiện</h3>
                    </div>-->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-title">Tên sự kiện</label> <?php echo my_form_error('title');?>
                            <?php echo form_input('title',set_value('title',$event->title),'class="form-control" id="input-title"'); ?>
                        </div> 
                        <div class="form-group">
                            <label for="input-intro">Mô tả</label> <?php echo my_form_error('intro');?>

                            <textarea name="intro" rows="5" class="form-control" id="input-intro"><?php echo $event->intro;?></textarea>
                        </div>

                        <div class="form-group" id="list-image">
                            <label for="tinymce" style="width:100%;"> Chi tiết sự kiện </label> <?php echo my_form_error('content');?>
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
                            <textarea name="description" class="form-control" id="tinymce" rows="20"><?php echo $event->description; ?></textarea>
                        </div> 

                        <hr class="line" style="clear: both;" />
                        <h3 id="seo-box-title" class="box-title" onclick="toggle_seo();">SEO Options</h3>
                        <div class="seo-box">
                            <div class="form-group">
                                <label for="meta-title">Meta title</label> <?php echo my_form_error('meta_title');?>
                                <?php echo form_input('meta_title',set_value('meta_title',$event->meta_title),'class="form-control" id="meta-title"'); ?>
                            </div>

                            <div class="form-group">
                                <label for="meta-keyword">Meta Keyword</label> <?php echo my_form_error('meta_keyword');?>
                                <textarea name="meta_keyword" class="form-control" rows="4" id="meta-keyword"><?php echo $event->meta_keyword; ?></textarea>
                            </div> 

                            <div class="form-group">
                                <label for="meta-desc">Meta Description</label> <?php echo my_form_error('meta_description');?>
                                <textarea name="meta_description" id="meta-desc" class="form-control" rows="4"><?php echo $event->meta_description; ?></textarea>
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
                                <input type="checkbox" name="status" value="1" id="status" <?php if($event->status==1) echo 'checked="checked"'; ?>>
                            </p>
                            <p>
                                <label for="isHOT">HOT</label> <?php echo form_error('is_hot');?>
                                <input type="checkbox" name="is_hot" value="1" id="isHOT" <?php if($event->is_hot==1) echo 'checked="checked"'; ?>>
                            </p>
                        </div>
                        <hr class="line" />
                        <div class="form-group">
                            <label for="begin-time">Bắt đầu</label> <?php echo form_error('title');?>
                            <?php echo form_input('begin_time',date('d-m-Y H:i',$event->begin_time),'class="form-control form_datetime1" readonly="" id="begin-time"');?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Ảnh đại diện</label>
                            <button id="upload-single" type="button" data-name="image"><span>Tải ảnh</span></button> 
                            <p><span id="status-single"></span></p>
                            <div id="singleUploaded">
                                <img src="<?php echo ($event->thumbnail) ? ( config_item('media_server') . $event->thumbnail) : ''; ?>" alt="" class="image-preview">
                                <input type="hidden" name="image" value="<?php echo $event->thumbnail; ?>">
                            </div>
                        </div>
                        <hr class="line" />
                        <div class="form-group">
                            <label for="location">Địa điểm</label> <?php echo form_error('location');?>
                            <input type="text" name="location" class="form-control" id="location" value="<?=$event->location;?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>