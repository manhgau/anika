<section class="content">
    <div class="row">
        <?php echo form_open('','role="form"');?>
        <!-- left column -->
        <div class="col-md-9">
            <!-- general form elements -->
            <div class="box box-primary">
                <!-- form start -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="input-name"> Tên đối tác <span class="red">*</span></label>
                        <input type="text" id="input-name" name="name" required class="form-control" value="<?php echo set_value('name', html_entity_decode($relationship->name)); ?>">
                        <?php echo form_error('name'); ?>
                    </div>

                    <div class="form-group">
                        <label for="input-description"> Mô tả ngắn </label>
                        <?php echo form_error('description'); ?>
                        <textarea class="form-control" id="input-description" rows="3" name="description"><?php echo set_value('description', html_entity_decode($relationship->description)); ?></textarea>
                    </div>

                    <div class="form-group" id="list-image">
                            <label for="tinymce" style="width:100%;"> Nội dung Giới thiệu </label> <?php echo my_form_error('content');?>
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
                        <textarea id="tinymce" name="content"><?php echo $relationship->content; ?></textarea>
                    </div>
                    <div class="clear"></div>
                </div><!-- /.box-body -->
                <div class="clear"></div>
                <div class="box-footer" style="clear:both;">
                    <?php echo form_submit('submit','Save','class="btn btn-primary"'); ?>
                </div>
            </div><!-- /.box -->
        </div>
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body">
                    <ul class="list-unstyled">
                        <li>
                        <label><?=form_checkbox('status','1',($relationship->status == 1) ? TRUE : FALSE,'class="simple"');?> Hiển thị</label>
                        </li>
                        <li><label><input type="checkbox" class="simple" name="is_hot" value="1" <?php if($relationship->is_hot) echo 'checked="checked"'; ?>> Is HOT</label></li>
                    </ul>

                    <div class="form-group">
                        <label>Khu vực đầu tư</label>
                        <input type="text" class="form-control" name="invest_location" value="<?php echo $relationship->invest_location; ?>" placeholder="Southeast Asia">
                    </div>

                    <div class="form-group">
                        <label>Số tiền ký quỹ</label>
                            <?php echo form_input('deposit_text', $relationship->deposit_text, ['class' => 'form-control', 'placeholder' => '$ 1,000 - 10,000']); ?>
                            <?php /*
                                <div class="input-group">
                                <span class="input-group-addon" id="basic-deposit_amount">$</span>
                                    <input type="number" min="1000" name="deposit_amount" value="<?= set_value('deposit_amount', $relationship->deposit_amount) ?>" step="1000" class="form-control" placeholder="number" aria-describedby="basic-deposit_amount">
                                </div>
                            */ ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Logo trắng <small>(<?php echo PARTNER_LOGO_TRANSPARENT; ?>)</small></label><br>
                        <button id="upload-single" type="button" class="btn btn-sm btn-primary" data-name="image"><span><i class="fa fa-upload"></i> Upload ảnh</span></button> 
                        <p><span id="status-single"></span></p>
                        <div id="singleUploaded" style="max-height:200px;overflow:auto;background: #303030">
                            <img src="<?php echo get_image($relationship->image); ?>" alt="" class="image-preview">
                            <input type="hidden" name="image" value="<?php echo $relationship->image; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Logo gốc <small>(<?php echo PARTNER_LOGO; ?>)</small></label><br>
                        <button id="upload-single-1" type="button" class="btn btn-sm btn-primary" data-name="image_trans"><span><i class="fa fa-upload"></i> Upload ảnh</span></button> 
                        <p><span id="status-single-1"></span></p>
                        <div id="singleUploaded-1" style="max-height:200px;overflow:auto">
                            <img src="<?php echo get_image($relationship->image_trans); ?>" alt="" class="image-preview">
                            <input type="hidden" name="image_trans" value="<?php echo $relationship->image_trans; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nhóm</label>
                        <select name="group_index" class="form-control">
                            <?php foreach ($group as $key => $value): ?>
                                <option value="<?php echo $key; ?>" <?php if($key==$relationship->group_index) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label >Vị trí</label>
                        <?php echo form_input('position',set_value('position',$relationship->position),'class="form-control"'); ?>
                        <?php echo form_error('position'); ?>
                    </div>

                    <div class="form-group">
                        <label > Website </label>
                        <?php echo form_input('url',set_value('url',$relationship->url),'class="form-control"'); ?>
                        <?php echo form_error('url'); ?>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email" value="<?php echo $relationship->email; ?>">
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $relationship->phone; ?>">
                    </div>

                    <div class="form-group">
                        <label>Facebook</label>
                        <input type="text" class="form-control" placeholder="Facebook" name="facebook" value="<?php echo $relationship->facebook; ?>">
                        <label>Instagram</label>
                        <input type="text" class="form-control" placeholder="Instagram" name="instagram" value="<?php echo $relationship->instagram; ?>">
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>