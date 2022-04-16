<style type="text/css">
#list-image ul li{border:none!important;margin:0!important;padding:0!important}#display-file table{width:100%;display:block;border:none!important}#display-file td{border:1px solid #ccc;padding:3px 5px;text-align:center}#display-file td input{width:100%;background-color:#f2f2f2;padding:2px}#display-file tr td:first-child{width:100px}#display-file tr td:nth-child(2){width:250px}#display-file tr td:nth-child(3){width:60px}#display-file tr td:nth-child(4){width:100px}#display-file tr td:last-child{width:50px}
</style>
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
                            <label for="input-title">Tên Gallery</label> <?php echo my_form_error('title');?>
                            <?php echo form_input('title',set_value('title',$gallery->title),'class="form-control" id="input-title"'); ?>
                        </div> 
                        <div class="form-group">
                            <label for="input-description">Mô tả</label> <?php echo my_form_error('description');?>

                            <textarea name="description" rows="5" class="form-control" id="input-description"><?php echo $gallery->description;?></textarea>
                        </div>

                        <div class="form-group" id="list-image">
                            <label for="tinymce" style="width:100%;"> Ảnh </label> <?php echo my_form_error('content');?>
                            <button id="upload" type="button" name="bt_image"><span>Tải ảnh từ máy tính</span></button>
                            <p><span id="status"></span></p>
                            <div id="display-file">
                                <ul>
                                <li>
                                    <table>
                                    <tr>
                                        <td><strong>Ảnh</strong></td>
                                        <td><strong>Caption</strong></td>
                                        <td><strong>Vị trí</strong></td>
                                        <td><strong>is Thumbnail</strong></td>
                                        <td><strong>Xóa</strong></td>
                                    </tr>
                                    </table>
                                </li>
                                    <?php if($images) : foreach ($images as $img) : ?>
                                        <li id="banner-<?=$img->id;?>">
                                            <table>
                                            <tr>
                                                <td><img src="<?php echo config_item('media_uri').$img->image_url ;?>" alt="" style="height:auto!important">
                                                    <input type="hidden" name="images[<?=$img->id;?>]" value="<?=$img->image_url;?>">
                                                </td>
                                                <td><input type="text" name="caption[<?=$img->id;?>]" value="<?=$img->caption;?>" placeholder="Caption:" class="form-control"></td>
                                                <td><input type="text" name="position[<?=$img->id;?>]" value="<?=$img->position;?>" placeholder="Position:" size="5" class="form-control"></td>
                                                <td><input type="radio" name="thumbnail" value="<?=$img->image_url;?>" id="img-<?=$img->id;?>" <?php if($img->image_url == $gallery->thumbnail) echo 'checked="checked"';?> ></td>
                                                <td><a class="btn btn-xs btn-danger" href="javascript:;" onclick="remove_image(<?=$img->id;?>)"> Xóa </a></td>
                                            
                                            </tr>
                                            </table>
                                        </li>
                                        <?php endforeach; endif; ?>

                                    <li class="clear hidden"></li>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <hr class="line" style="clear: both;" />
                        <h3 id="seo-box-title" class="box-title" onclick="toggle_seo();">SEO Options</h3>
                        <div class="seo-box">
                            <div class="form-group">
                                <label for="meta-title">Meta title</label> <?php echo my_form_error('meta_title');?>
                                <?php echo form_input('meta_title',set_value('meta_title',$gallery->meta_title),'class="form-control" id="meta-title"'); ?>
                            </div>

                            <div class="form-group">
                                <label for="meta-keyword">Meta Keyword</label> <?php echo my_form_error('meta_keyword');?>
                                <textarea name="meta_keyword" class="form-control" rows="4" id="meta-keyword"><?php echo $gallery->meta_keyword; ?></textarea>
                            </div> 

                            <div class="form-group">
                                <label for="meta-desc">Meta Description</label> <?php echo my_form_error('meta_description');?>
                                <textarea name="meta_description" id="meta-desc" class="form-control" rows="4"><?php echo $gallery->meta_description; ?></textarea>
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
                                <input type="checkbox" name="status" value="1" id="status" <?php if($gallery->status==1) echo 'checked="checked"'; ?>>
                            </p>
                            <p>
                                <label for="is-hot">HOT</label> <?php echo form_error('is_hot');?>
                                <input type="checkbox" name="is_hot" value="1" id="is-hot" <?php if($gallery->is_hot==1) echo 'checked="checked"'; ?>>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>