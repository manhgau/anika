<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">WE OFFER Config</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <style type="text/css">
                    .strong{font-weight:700}td .form-control{margin-top:5px;}
                    .offer-img-preview{margin-top:5px;padding:5px;background-color:#e4e4e4;}
                    .offer-img-preview img{display:inline-block;height: 20px;width:auto;margin-right:10px;cursor:pointer;}
                </style>
                <?php echo form_open_multipart() ;?>
                <div class="box-body">
                    <table class="table table-bordered form-group">
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <input type="text" name="offer_title" class="form-control text-center strong" value="<?php echo $offerCfg['offer_title']; ?>" placeholder="Tiêu đề">
                                    <textarea name="offer_desc" rows="2" placeholder="Mô tả" class="form-control text-center"><?php echo $offerCfg['offer_desc']; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" class="form-control text-center strong" name="offer_1_title" value="<?php echo $offerCfg['offer_1_title']; ?>">
                                    <textarea name="offer_1_desc" rows="2"  class="form-control text-center"><?php echo $offerCfg['offer_1_desc']; ?></textarea>
                                </td>
                                <td colspan="2">
                                    <input type="text" name="offer_2_title" value="<?php echo $offerCfg['offer_2_title']; ?>" class="form-control text-center strong">
                                    <textarea name="offer_2_desc" rows="2" class="form-control text-center"><?php echo $offerCfg['offer_2_desc']; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="">
                                    <input type="text" name="offer_1_1_title" value="<?php echo $offerCfg['offer_1_1_title']; ?>" class="form-control strong">
                                    <textarea name="offer_1_1_desc" rows="2" class="form-control"><?php echo $offerCfg['offer_1_1_desc']; ?></textarea>
                                </td>
                                <td colspan="">
                                    <input type="text" name="offer_1_2_title" value="<?php echo $offerCfg['offer_1_2_title']; ?>" class="form-control strong">
                                    <textarea name="offer_1_2_desc" rows="2" class="form-control"><?php echo $offerCfg['offer_1_2_desc']; ?></textarea>
                                </td>
                                <td colspan="">
                                    <input type="text" name="offer_2_1_title" value="<?php echo $offerCfg['offer_2_1_title']; ?>" class="form-control strong">
                                    <textarea name="offer_2_1_desc" rows="2" class="form-control"><?php echo $offerCfg['offer_2_1_desc']; ?></textarea>
                                    
                                    
                                    <div class="upload-conter">
                                        <label>Ảnh</label> <button class="img-single-upload btn btn-xs green" data-name="offer_2_1_img">Upload</button>
                                        <p id="status-offer_2_1_img"></p>
                                        <input type="hidden" name="offer_2_1_img" value="<?php echo str_replace('null', '', $offerCfg['offer_2_1_img']); ?>" class="form-control offer_img">
                                        <div class="offer-img-preview">
                                            <?php 
                                            if ($offerCfg['offer_2_1_img'] && $offerCfg['offer_2_1_img']!='null') 
                                            {
                                                foreach (explode(',', $offerCfg['offer_2_1_img']) as $key => $value) {
                                                    echo '<img src="', get_image(trim($value)), '" />';
                                                }
                                            } 
                                            ?>
                                        </div>
                                    </div>
                                    
                                </td>
                                <td colspan="">
                                    <input type="text" name="offer_2_2_title" value="<?php echo $offerCfg['offer_2_2_title']; ?>" class="form-control strong">
                                    <textarea name="offer_2_2_desc" rows="2" class="form-control"><?php echo $offerCfg['offer_2_2_desc']; ?></textarea>
                                    <div class="upload-conter">
                                        <label>Ảnh</label> <button class="img-single-upload btn btn-xs green" data-name="offer_2_2_img">Upload</button>
                                        <p id="status-offer_2_2_img"></p>
                                        <input type="hidden" name="offer_2_2_img" value="<?php echo str_replace('null', '', $offerCfg['offer_2_2_img']); ?>" class="form-control offer_img">
                                        <div class="offer-img-preview">
                                            <?php 
                                            if ($offerCfg['offer_2_2_img'] && $offerCfg['offer_2_2_img']!='null') 
                                            {
                                                foreach (explode(',', $offerCfg['offer_2_2_img']) as $key => $value) {
                                                    echo '<img src="', get_image(trim($value)), '" />';
                                                }
                                            } 
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="">
                                    <input type="text" name="offer_1_3_title" value="<?php echo $offerCfg['offer_1_3_title']; ?>" class="form-control strong">
                                    <textarea name="offer_1_3_desc" rows="2" class="form-control"><?php echo $offerCfg['offer_1_3_desc']; ?></textarea>
                                </td>
                                <td colspan="">
                                    <input type="text" name="offer_1_4_title" value="<?php echo $offerCfg['offer_1_4_title']; ?>" class="form-control strong">
                                    <textarea name="offer_1_4_desc" rows="2" class="form-control"><?php echo $offerCfg['offer_1_4_desc']; ?></textarea>
                                </td>
                                <td colspan="">
                                    <input type="text" name="offer_2_3_title" value="<?php echo $offerCfg['offer_2_3_title']; ?>" class="form-control strong">
                                    <textarea name="offer_2_3_desc" rows="2" class="form-control"><?php echo $offerCfg['offer_2_3_desc']; ?></textarea>
                                    <div class="upload-conter">
                                        <label>Ảnh</label> <button class="img-single-upload btn btn-xs green" data-name="offer_2_3_img">Upload</button>
                                        <p id="status-offer_2_3_img"></p>
                                        <input type="hidden" name="offer_2_3_img" value="<?php echo str_replace('null', '', $offerCfg['offer_2_3_img']); ?>" class="form-control offer_img">
                                        <div class="offer-img-preview">
                                            <?php 
                                            if ($offerCfg['offer_2_3_img'] && $offerCfg['offer_2_3_img']!='null') 
                                            {
                                                foreach (explode(',', $offerCfg['offer_2_3_img']) as $key => $value) {
                                                    echo '<img src="', get_image(trim($value)), '" />';
                                                }
                                            } 
                                            ?>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="">
                                    <input type="text" name="offer_2_4_title" value="<?php echo $offerCfg['offer_2_4_title']; ?>" class="form-control strong">
                                    <textarea name="offer_2_4_desc" rows="2" class="form-control"><?php echo $offerCfg['offer_2_4_desc']; ?></textarea>
                                    <div class="upload-conter">
                                        <label>Ảnh</label> <button class="img-single-upload btn btn-xs green" data-name="offer_2_4_img">Upload</button>
                                        <p id="status-offer_2_4_img"></p>
                                        <input type="hidden" name="offer_2_4_img" value="<?php echo str_replace('null', '', $offerCfg['offer_2_4_img']); ?>" class="form-control offer_img">
                                        <div class="offer-img-preview">
                                            <?php 
                                            if ($offerCfg['offer_2_4_img'] && $offerCfg['offer_2_4_img']!='null') 
                                            {
                                                foreach (explode(',', $offerCfg['offer_2_4_img']) as $key => $value) {
                                                    echo '<img src="', get_image(trim($value)), '" />';
                                                }
                                            } 
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group" style="padding:20px 0">
                        <button class="btn btn-md btn-success"> <i class="fa fa-floppy-o"></i> Save</button>
                    </div>
                </div>
                <?php echo form_close();?>
            </div><!-- /.box -->
        </div>
    </div>
</section>