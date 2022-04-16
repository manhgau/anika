<div class="panel-body">
    <form action="" id="product-setting-form">
    <div class="row">
        <div class="col-xs-9">
            <div class="box box-primary">
                <div class="box-header">
                    <h2 class="box-title">SEO Options</h2>
                </div>
                <div class="box-body">
                    <div class=" form-group">
                        <label>Meta title</label>
                        <input type="text" class="form-control" name="meta_title" value="<?php echo $productDetail->meta_title; ?>">
                    </div>
                    <div class=" form-group">
                        <label>Meta description</label>
                        <textarea name="meta_description" class="form-control"><?php echo $productDetail->meta_description; ?></textarea>
                    </div>
                    <div class=" form-group">
                        <label>Meta keyword</label>
                        <textarea name="meta_keyword" class="form-control"><?php echo $productDetail->meta_keyword; ?></textarea>
                    </div>
                    <hr>
                    <div class=" form-group">
                        <label>Maps</label>
                        <input type="text" name="map_view" class="form-control" value="<?php echo $productDetail->map_view; ?>">
                    </div>
                    <div class=" form-group">
                        <div class="embed-responsive embed-responsive-16by9" id="maps-preview">
                            <?php if($productDetail->map_view): ?>

                            <iframe class="embed-responsive-item" src="<?php echo $productDetail->map_view; ?>"></iframe>
                            <?php else : ?>
                            <iframe class="embed-responsive-item hidden" src=""></iframe>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="box box-primary row">
                <div class="box-header">
                    <h2 class="box-title">Cài đặt chung</h2>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label><input type="checkbox" class="simple" name="is_recommend" value="1" <?php if($product->is_recommend == 1) echo 'checked="checked"';?>> Khuyên dùng</label>
                    </div>
                    <div class="form-group">
                        <label>Trạng thái bán</label>
                        <select name="status" class="form-control">
                            <option value="<?php echo STATUS_PUBLISHED; ?>" <?php if($product->status == STATUS_PUBLISHED) echo 'selected="selected"';?>>Đăng bán</option>
                            <option value="<?php echo STATUS_PENDING; ?>" <?php if($product->status == STATUS_PENDING) echo 'selected="selected"';?>>Chờ duyệt bán</option>
                            <option value="<?php echo STATUS_DRAFF; ?>" <?php if($product->status == STATUS_DRAFF) echo 'selected="selected"';?>>Hủy bán</option>
                        </select>
                    </div>
                    <div class="form-group hidden">
                        <label>Số lượng bán</label>
                        <input type="number" name="amount" class="form-control" value="<?php echo $product->amount; ?>">
                    </div>
                    <div class="form-group hidden">
                        <label>Thời gian bán</label>
                        <input type="text" name="sale_expired" class="form-control is-datepicker" value="<?php echo $product->sale_expired; ?>">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Lưu</button>
        <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Hủy</button>
    </div>
    </form>
</div>