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
                            <label class="required">Tên sản phẩm</label> <?php echo my_form_error('title');?>
                            <input type="text" class="form-control" id="input-title" required value="<?php echo htmlspecialchars($product->title);?>" name="title">
                        </div> 
                        <div class="form-group">
                            <label class="required">Mô tả ngắn</label> <?php echo my_form_error('intro');?>
                            <textarea name="intro" rows="3" class="form-control" id="input-intro"><?php echo $product->intro;?></textarea>
                        </div>

                        <div class="form-group" id="list-image">
                            <label for="tinymce" style="width:100%;"> Nội dung bài viết </label> <?php echo my_form_error('content');?>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p>
                                        <button id="upload" type="button" name="bt_image"><span>Tải ảnh</span></button>
                                     <!-- hoặc <button id="upload-copyright" type="button" name="bt_image"><span>Tải ảnh và chèn logo</span></button> <small>(640x***)</small> -->
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
                            <textarea name="content" class="form-control" id="tinymce" rows="20"><?php echo $product->content; ?></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php 
                            echo form_hidden('id', $product->id);
                            echo form_submit('publish','Cập nhật','class="btn btn-success"');
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
                       
                        <div class="form-group">
                            <label>Giá bán</label>
                            <div class="input-group">
                                <input type="number" name="price" min="0" step="" class="form-control" value="<?php echo set_value('price', $product->price) ?>" placeholder="ví dụ: 1200000">
                                <span class="input-group-addon" id="basic-addon2">VND</span>
                            </div>
                        </div>
                                    
                        <div class="form-group">
                            <?php 
                                $allStatus = $this->manage_product_model->getStatus();
                                $options = ['' => '--- chọn ---'] + array_combine(array_keys($allStatus), array_column($allStatus, 'name'));
                                echo form_element([
                                    'name' => 'status',
                                    'value' => $product->status,
                                    'label' => 'Tình trạng',
                                    'required' => true,
                                    'type' => 'select',
                                    'options' => $options,
                                ]);
                            ?>
                        </div>
                              
                        <div class="form-group">
                            <?php 
                                $allType = $this->category_product_model->getList();
                                $options = ['' => 'Chọn nhóm'] + array_combine(array_column($allType, 'id'), array_column($allType, 'title'));
                                echo form_element([
                                    'name' => 'category_name',
                                    'value' => $product->category_id,
                                    'label' => 'Danh mục sản phẩm',
                                    'required' => true,
                                    'type' => 'select',
                                    'options' => $options,
                                ]);
                            ?>
                        </div>
                     
                        <div class="form-group">
                        <label for="uploadFile">Ảnh đại diện</label>
                            <?php echo form_element([
                                'type' => 'fileupload',
                                'name' => 'thumbnail',
                                'value' => $product->thumbnail,
                                'button_label' => 'Chọn ảnh'
                            ]) ?>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>