<div class="panel-body">
    <form action="" id="product-price-form">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="well">
                <button class="btn btn-sm btn-default" id="add-new-price"><i class="fa fa-plus green"></i> Tạo giá mới</button>
            </div>
            <table class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Tên gói</th>
                        <th>Số người áp dụng</th>
                        <th>Giá</th>
                        <th>Ghi chú</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php if($productPrices) : foreach($productPrices as $key => $price) :  ?>
                        <tr data-id="<?php echo $price->id?>" <?php if($key == 0) echo 'id="price-defined"'; ?>>
                            <td><input type="text" name="name" class="form-control" value="<?php echo $price->name; ?>"></td>
                            <td class="clearfix">
                                <input type="number" min="1" name="person_min" style="width:80px;float: left" class="form-control" value="<?php echo $price->person_min; ?>">
                                <input type="number" min="1" name="person_max" style="width:80px;float: left" class="form-control" value="<?php echo $price->person_max; ?>">
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="thin">Người lớn</label>
                                    <input type="number" min="0" name="price" style="width:150px" class="form-control" value="<?php echo $price->price; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="thin">Trẻ em</label>
                                    <input type="number" name="price_child" style="width:150px" class="form-control" value="<?php echo $price->price_child; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="thin">Em bé</label>
                                    <input type="number" name="price_baby" style="width:150px" class="form-control" value="<?php echo $price->price_baby; ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="thin">Chung</label>
                                    <input type="text" name="note" class="form-control" value="<?php echo $price->note; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="thin">Trẻ em</label>
                                    <input type="text" name="note_child" class="form-control" value="<?php echo $price->note_child; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="thin">Em bé</label>
                                    <input type="text" name="note_baby" class="form-control" value="<?php echo $price->note_baby; ?>">
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-primary btn-save-price"><i class="fa fa-floppy-o"></i> Lưu</button>
                                <button class="btn btn-xs btn-danger btn-remove-price"><i class="fa fa-trash-o"></i> Xóa</button>
                            </td>
                        </tr>
                    <?php endforeach; else:  ?>
                        <tr data-id="" style="display:none" id="price-defined">
                            <td><input type="text" name="name" class="form-control" value=""></td>
                            <td class="clearfix">
                                <input type="number" name="person_min" style="width:80px;float: left" class="form-control" value="">
                                <input type="number" name="person_max" style="width:80px;float: left" class="form-control" value="">
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="thin">Người lớn</label>
                                    <input type="number" name="price" style="width:150px" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label class="thin">Trẻ em</label>
                                    <input type="number" name="price_child" style="width:150px" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label class="thin">Em bé</label>
                                    <input type="number" name="price_baby" style="width:150px" class="form-control" value="">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label class="thin">Chung</label>
                                    <input type="text" name="note" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label class="thin">Trẻ em</label>
                                    <input type="text" name="note_child" class="form-control" value="">
                                </div>
                                <div class="form-group">
                                    <label class="thin">Em bé</label>
                                    <input type="text" name="note_baby" class="form-control" value="">
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-primary btn-save-price"><i class="fa fa-floppy-o"></i> Lưu</button>
                                <button class="btn btn-xs btn-danger btn-remove-price"><i class="fa fa-trash-o"></i> Xóa</button>
                            </td>
                        </tr>
                        <tr> <td colspan="5">Chưa có mức giá nào</td> </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <hr class="line">
            <div class="form-group">
                <input type="hidden" name="product_id" value="<?php echo $product->id; ?>">
                <!-- <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Lưu</button>
                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Hủy</button> -->
            </div>
        </div>
    </div>
    </form>
</div>