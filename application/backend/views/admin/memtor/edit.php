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
                            <label for="input-group">Nhóm</label> <?php echo my_form_error('group');?>
                            <ul class="list-inline">
                                <?php foreach (config_item('mentor_group') as $gName): ?>
                                <li class="list-inline-item">
                                    <label class="thin"><input type="radio" name="group" value="<?php echo $gName; ?>" <?php if($memtor->group==$gName) echo 'checked="checked"';?>> <?php echo ucfirst($gName); ?></label>
                                </li>    
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="input-name">Tên</label> <?php echo my_form_error('name');?>
                            <?php echo form_input('name',set_value('name',$memtor->name, false),'class="form-control" id="input-name"'); ?>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="input-job_title">Chức danh</label> <?php echo my_form_error('job_title');?>
                            <?php echo form_input('job_title',set_value('job_title',$memtor->job_title, false),'class="form-control" id="input-job_title"');?>
                            </div>
                            <div class="col-xs-6">
                                <label for="input-company">Công ty</label> <?php echo my_form_error('company');?>
                            <?php echo form_input('company',set_value('company', $memtor->company, false),'class="form-control" id="input-company"');?>
                            </div>
                        </div>

                        <div class="form-group" id="list-image">
                            <label for="tinymce" style="width:100%;"> Tiểu sử </label> <?php echo my_form_error('description');?>
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
                            <textarea name="description" class="form-control" id="tinymce" rows="20"><?php echo $memtor->description; ?></textarea>
                        </div> 

                        <hr class="line" style="clear: both;" />
                        <h3 class="box-title" onclick="toggle_seo();" id="seo-box-title">SEO Options</h3>
                        <div class="seo-box">
                            <div class="form-group">
                                <label for="meta-title">Meta title</label> <?php echo my_form_error('meta_title');?>
                                <?php echo form_input('meta_title',set_value('meta_title',$memtor->meta_title, false),'class="form-control" id="meta-title"'); ?>
                            </div>

                            <div class="form-group">
                                <label for="meta-keyword">Meta Keyword</label> <?php echo my_form_error('meta_keyword');?>
                                <textarea name="meta_keyword" class="form-control" rows="4" id="meta-keyword"><?php echo set_value( 'meta_keyword' ,$memtor->meta_keyword, false); ?></textarea>
                            </div> 

                            <div class="form-group">
                                <label for="meta-desc">Meta Description</label> <?php echo my_form_error('meta_description');?>
                                <textarea name="meta_description" id="meta-desc" class="form-control" rows="4"><?php echo set_value( 'meta_description' ,$memtor->meta_description, false); ?></textarea>
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
                                <input type="checkbox" name="status" value="1" id="status" <?php if($memtor->status==1) echo 'checked="checked"'; ?>>
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="position">Thứ tự hiển thị</label> <?php echo form_error('position');?>
                            <input type="number" class="form-control" min="1" name="position" value="<?php echo $memtor->position;?>" id="position">
                        </div>
                        <div class="form-group">
                            <label for="birthday">Ngày sinh</label> <?php echo form_error('birthday');?>
                            <?php echo form_input('birthday',date('d-m-Y H:i',$memtor->birthday),'class="form-control form_datetime1" readonly="" id="birthday"');?>
                        </div>
                        <div class="form-group">
                            <label for="birthday">Giới tính</label> <?php echo form_error('gender');?>
                            <p>
                                <label for="male">Nam</label> <input type="radio" value="1" name="gender" <?php if($memtor->gender==1) echo 'checked="checked"'; ?> id="male"> - <label for="female">Nữ</label> <input type="radio" value="0" name="gender" <?php if($memtor->gender==0) echo 'checked="checked"'; ?> id="female">
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="linkedin_url">LinkedIn</label> <?php echo form_error('linkedin_url');?>
                            <input type="text" name="linkedin_url" id="linkedin_url" value="<?=$memtor->linkedin_url;?>" class="form-control">              
                        </div>
                        <div class="form-group">
                            <label for="facebook">Facebook</label> <?php echo form_error('facebook');?>
                            <input type="text" name="facebook" id="facebook" value="<?=$memtor->facebook;?>" class="form-control">              
                        </div>
                        <div class="form-group">
                            <label for="twitter">Twitter</label> <?php echo form_error('twitter');?>
                            <input type="text" name="twitter" id="twitter" value="<?=$memtor->twitter;?>" class="form-control">              
                        </div>
                        <div class="form-group">
                            <label for="twitter">Website</label> <?php echo form_error('website');?>
                            <input type="text" name="website" id="website" value="<?=$memtor->website;?>" class="form-control">              
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Ảnh đại diện <small>(<?php echo MENTOR_AVATAR; ?>)</small></label>
                            <input id="uploadFile" type="file" name="thumbnail" class="img" id="thumbnail" />
                            <div id="imagePreview" style="background-image:url(<?=get_image($memtor->image);?>);"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Ảnh share MXH <small>(600x315)</small></label><br>
                            <a href="javascript:;" id="upload-single-1" type="button" class="btn btn-sm btn-primary" data-name="og_image"><span><i class="fa fa-upload"></i> Upload ảnh</span></a> 
                            <p><span id="status-single-1"></span></p>
                            <div id="singleUploaded-1" style="max-height:200px;overflow:auto">
                                <img src="<?php echo get_image($memtor->og_image); ?>" alt="" class="image-preview">
                                <input type="hidden" name="og_image" value="<?php echo $memtor->og_image; ?>">
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>