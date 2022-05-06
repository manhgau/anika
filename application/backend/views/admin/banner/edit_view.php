<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Sửa Banner</h3>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label for="exampleInputEmail1">Chọn nhóm</label>
                                <?php echo form_dropdown('type',$banner_type,(isset($banner->type)) ? $banner->type : 1,'class="form-control"'); ?>
                            </div>
                           
                            <div class="col-xs-4">
                                <label for="position">Vị trí:&nbsp;</label>
                                <input type="text" class="form-control" id="position" name="position" placeholder="banner position: " value="<?php echo $banner->position;?>">

                                
                            </div>
                            <div class="col-xs-4">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label for="input-name">Tiêu đề:&nbsp;</label>
                                <input type="text" class="form-control" name="name" id="input-name" placeholder="Tiêu đề menu: " value="<?php echo $banner->name;?>">
                            </div>
                            <div class="col-xs-4">
                                <label for="url">Liên kết:&nbsp;</label>
                                <input type="text" class="form-control" id="url" name="url" placeholder="Menu URL: " value="<?php echo $banner->url;?>">
                            </div>
                            <div class="col-xs-4">
                                <p style="margin-bottom:0">&nbsp;</p>
                                    <label for="status"><?php echo form_checkbox('status','1',($banner->status==1) ? TRUE : FALSE,'class="simple" id="status"');?>&nbsp;Hiển thị </label>
                                    <br>
                            </div>
                            
                        </div>
                        <div class="form-group row hidden">
                            <div class="col-xs-4">
                                <p></p>
                                
                                <p></p>
                                
                            </div>
                            
                            <div class="col-xs-4 hidden">
                                <label for="position">Ngày hết hạn:&nbsp;</label>
                                <input type="text" class="form-control" name="expired_date" placeholder="Ngày hết hạn">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class=" col-md-4">
                                <label for="exampleInputEmail1">Ảnh</label><br>
                                <button id="upload-single" type="button" class="btn btn-sm btn-primary" data-name="image"><span><i class="fa fa-upload"></i> Upload ảnh</span></button> 
                                <button id="addmore-image" class="btn btn-sm btn-default"> Chèn ảnh vào quảng cáo</button>
                                <p><span id="status-single"></span></p>
                                <div id="singleUploaded" style="max-height:200px;overflow:auto">
                                    
                                    <img src="<?php echo getImageUrl($banner->image);?>" alt="" class="image-preview">
                                    <input type="hidden" name="image" value="<?php echo $banner->image; ?>">
                                </div>
                                
                            </div>
                            <div class=" col-md-8">
                                <label for="input-html">Mã HTML</label>
                                <textarea cols="400" rows="10" class="form-control" name="html" id="input-html"><?php echo $banner->html; ?></textarea>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="id" name="id" value="<?php if(isset($banner->id)) echo $banner->id;?>">
                            <input type="submit" name="submit" value="Lưu" class="btn btn-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>