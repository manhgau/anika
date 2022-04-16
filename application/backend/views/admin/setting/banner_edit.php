<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Sửa Banner</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open_multipart() ;?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tiêu đề:&nbsp;</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Tiêu đề menu: " value="<?php echo $banner->title;?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Liên kết:&nbsp;</label>
                        <input type="text" class="form-control" id="url" name="out_link" placeholder="Menu URL: " value="<?php echo $banner->out_link;?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Vị trí:&nbsp;</label>
                        <input type="text" class="form-control" id="order" name="order" placeholder="Menu order: " value="<?php echo $banner->order;?>">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Ảnh</label> <?php echo form_error('thumbnail');?>
                        <input id="uploadFile" type="file" name="thumbnail" class="img" />
                        <div id="imagePreview" style="background-image: url(<?php echo get_image($banner->img_url);?>);"></div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="banner_group" value="<?php echo $banner->banner_group;?>">
                        <input type="hidden" id="id" name="id" value="<?php echo $banner->id;?>">
                        <input type="submit" name="submit" value="Lưu">
                    </div>
                </div>
                <?php echo form_close();?>
            </div><!-- /.box -->
        </div>
    </div>
</section>