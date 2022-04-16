<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-title">Tên Tour</label> <?php echo my_form_error('title');?>
                            <input type="text" class="form-control" id="input-title" value="<?php echo htmlspecialchars($product->title);?>" nalme="tite">
                        </div> 
                        <div class="form-group">
                            <label for="editor-2">Điểm nổi bật</label> <?php echo my_form_error('description');?>
                            <textarea name="description" rows="5" class="form-control" id="editor-2"><?php echo $product->description;?></textarea>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="editor-3">Bao gồm</label> <?php echo my_form_error('include');?>
                                <textarea name="include" rows="5" class="form-control" id="editor-3"><?php echo $product->include;?></textarea>
                            </div>
                            <div class="col-xs-6">
                                <label for="editor-4">Loại trừ</label> <?php echo my_form_error('exclude');?>
                                <textarea name="exclude" rows="5" class="form-control" id="editor-4"><?php echo $product->exclude;?></textarea>
                            </div>
                        </div>
                        <div class="form-group" id="list-image">
                            <label for="" style="width:100%;"> Hình ảnh Tour </label> <?php echo my_form_error('content');?>
                            <button id="upload" type="button" name="bt_image"><span>Tải ảnh từ máy tính</span></button>
                            <p><span id="status"></span></p>
                            <div id="display-file">
                                <ul>
                                    <?php if($listImages) : 
                                        ?>
                                        <?php 
                                                foreach($listImages as $key => $img) : ?>
                                                <li>
                                                    <img src="<?php echo get_image($img->url);?>" alt="" height="60" style="height:60px;width:auto;margin:1px 0;border:1px solid #eee">
                                                    <input type="hidden" name="listImage[]" value="<?php echo $img->id;?>">
                                                    <a class="insert_img_content" href="javascript:;" title="Chèn ảnh vào bài viết" data="<?php echo get_image($img->url);?>">Insert</a>
                                                    <a class="remove-item fa fa-times" style="color:#d20;" href="javascript:;" title="Xóa ảnh"></a>
                                                    <span class="remove-item">x</span>
                                                </li>
                                                <?php endforeach; ?>
                                        <?php endif; ?>
                                    <li class="clear hidden"></li>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="form-group">
                            <label for="tinymce" style="width:100%;"> Nội dung chi tiết Tour </label> <?php echo my_form_error('content');?>
                            <textarea name="content" class="form-control" id="tinymce" rows="15"><?php echo $product->content; ?></textarea>
                        </div> 
                        <div class="form-group">
                            <label for="tinymce" style="width:100%;"> Điều khoản sử dụng </label>
                            <textarea name="policy" class="form-control" id="tinymce1" rows="10"><?php echo $product->policy; ?></textarea>
                        </div> 

                        <hr class="line" style="clear: both;" />
                        <h3 class="box-title" onclick="toggle_seo();" id="seo-box-title">SEO Options</h3>
                        <div class="seo-box">
                            <div class="form-group">
                                <label for="meta-title">Meta title</label> <?php echo my_form_error('meta_title');?>
                                <input type="text" name="meta_title" id="meta-title" class="form-control" value="<?php echo htmlspecialchars($product->meta_title);?>">
                            </div>

                            <div class="form-group">
                                <label for="meta-keyword">Meta Keyword</label> <?php echo my_form_error('meta_keyword');?>
                                <textarea name="meta_keyword" class="form-control" rows="4" id="meta-keyword"><?php echo htmlspecialchars($product->meta_keyword); ?></textarea>
                            </div> 

                            <div class="form-group">
                                <label for="meta-desc">Meta Description</label> <?php echo my_form_error('meta_description');?>
                                <textarea name="meta_description" id="meta-desc" class="form-control" rows="4"><?php echo htmlspecialchars($product->meta_description); ?></textarea>
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
                    <div class="box-header" style="border-bottom:1px solid #ccc">
                        <h3 class="box-title">Thông tin</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <input type="checkbox" name="status" value="2" id="bussiness-status">
                            <label for="bussiness-status">Đăng sản phẩm</label>
                        </div>
                        <div class="form-group">
                            <label for="public-time">Hẹn giờ đăng</label>
                            <input type="text" name="public_time" id="public-time" class="form-control form_datetime1" readonly value="<?php echo date( 'd-m-Y H:i', strtotime($product->public_time) );?>">
                        </div>
                        <div class="form-group">
                            <label>Giá</label>
                            <input type="number" name="price" id="" class="form-control" value="<?php echo $product->price; ?>">
                        </div>
                        <div class="form-group">
                            <label>Thời gian tour</label>
                            <input type="text" name="duration" id="" class="form-control" value="<?php echo $product->duration; ?>" placeholder="4N3Đ">
                        </div>
                        <div class="form-group">
                            <label for="public-time">Nhóm sản phẩm</label>
                            <select name="product_category" class="form-control">
                                <option>--- Chọn chuyên mục ---</option>
                                <?php foreach ($product_categories as $key => $val) : ?>
                                    <option value="<?php echo $val->id; ?>" 
                                        <?php if ($product->pruduct_category == $val->id) echo 'selected="selected"';?> 
                                            > <?php echo $val->title; ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <hr class="line">
                        <div class="form-group">
                            <label>Thời gian khởi hành</label>
                            <input type="text" name="start_time" class="form-control form_datetime1" value="<?php echo date('d-m-Y H:i', strtotime($product->start_time)); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Địa điểm</label>
                            <input type="text" name="locations" class="form-control" id="token-locations">
                        </div>
                        <div class="form-group">
                            <label>Ngôn ngữ</label>
                            <select name="language" class="form-control">
                                <option value="vi" <?php if ($product->language == 'vi')echo 'selected="selected"';?>>tiếng Việt</option>
                                <option value="en" <?php if ($product->language == 'en')echo 'selected="selected"';?>>tiếng Anh</option>
                                <option value="de" <?php if ($product->language == 'de')echo 'selected="selected"';?>>tiếng Đức</option>
                                <option value="fr" <?php if ($product->language == 'fr')echo 'selected="selected"';?>>tiếng Pháp</option>
                                <option value="kr" <?php if ($product->language == 'kr')echo 'selected="selected"';?>>tiếng Hàn Quốc</option>
                                <option value="jp" <?php if ($product->language == 'jp')echo 'selected="selected"';?>>tiếng Nhật Bản</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Số lượng</label>
                            <input type="text" name="amount" class="form-control" value="<?php echo $product->amount; ?>">
                        </div>
                        <div class="form-group">
                            <label>Nhà cung cấp</label>
                            <input type="text" name="bussiness_id" class="form-control" id="token-bussiness">
                        </div>
                        <hr class="line">
                        <div class="form-group">
                            <label for="thumbnail">Ảnh đại diện <span class="required">*</span></label>
                              <?php echo form_error('image');?>
                             <p><button id="upload-single" type="button"><span>Tải ảnh từ máy tính</span></button> <small> (1600x900) </small> </p>
                              <p><span id="status-single"></span></p>
                             <div id="singleUploaded">
                                 <?php if($product->thumbnail) echo '<img src="'. config_item('media_uri') . $product->thumbnail .'">';?>
                                 <input type="hidden" name="thumbnail" value="<?php echo $product->thumbnail;?>">
                                </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</section>